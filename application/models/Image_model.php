<?php
/**
* Handles image upload, resize, crop and rotate
*
* @package       CodeIgniter
* @subpackage    Models
* @version       3.2.0
* @date          30-04-2019
* @author        Mindiii
* 
*/

//use Aws\Common\Exception\MultipartUploadException;
//use Aws\S3\MultipartUploader;
//use Aws\S3\S3Client;
//use Aws\S3\ObjectUploader;
class Image_model extends CI_Model{
    
    /**
     * Constructor
     *
     * @since     2.0.0
     * @access	  public
     * 
     */
    public function __construct(){
        parent::__construct();
        $this->load->helper('string');
    }
    
    /**
     * Predefined image sizes (can be changed according to project requirement)
     * 
     * @param      string $folder Directory name
     * @return     array  $img_sizes Image size array
     * @since      2.0.0
     * @edited     2.0.0
     * 
     */
    function image_sizes($folder){
        
        $img_sizes = array();
        
        switch($folder){
            case 'profile' :
                $img_sizes['thumbnail'] = array('width'=>300, 'height'=>300, 'folder'=>'/thumb');
                $img_sizes['medium'] = array('width'=>600, 'height'=>600, 'folder'=>'/medium');
                $img_sizes['large'] = array('width'=>1024,'height'=>768,'folder'=>'/large');
            break;
        }
            
        return $img_sizes;
    }
    
    /**
     * 
     * Make upload directory
     * 
     * @param      string $folder Directory name
     * @param      string $mode Directory name
     * @param      string $defaultFolder Parent directory name
     * @return     void
     * @since      2.0.0
     * @edited     2.0.0
     * 
     */
    function make_dirs($folder='', $mode=DIR_WRITE_MODE, $defaultFolder='uploads/'){

        if(!@is_dir(FCPATH . $defaultFolder)){
            mkdir(FCPATH . $defaultFolder, $mode);
        }
        
        if(!empty($folder)){

            if(!@is_dir(FCPATH . $defaultFolder . '/' . $folder)){
                mkdir(FCPATH . $defaultFolder . '/' . $folder, $mode,true);
            }
        } 
    }
    
    /**
     * Upload image and create resized copies
     * 
     * @param      string $image Name of image to upload
     * @param      string $folder Upload destination directory name
     * @param      int $height Kept for future use
     * @param      int $width Kept for future use
     * @return     string $thumb_img Uploaded thumb image name
     * @since      2.0.0
     * @edited     3.2.0
     * 
     */
    function upload_image($image, $folder, $height=768, $width=1024){
        
        $this->make_dirs($folder);
        
       	$realpath = 'uploads/'; // Parent directory
        $allowed_types = "jpg|png|jpeg"; 	
        $img_name = random_string('alnum', 16);  //generate random string for image name
        
        $img_sizes_arr = $this->image_sizes($folder);  //predefined sizes in model
        
        // //We will set min height and width according to thumbnail size
        // $min_width = $img_sizes_arr['thumbnail']['width'];
        // $min_height = $img_sizes_arr['thumbnail']['height'];

        //We will set min height and width according to thumbnail size
        if($folder != 'video_thumb'){
            $min_width = $img_sizes_arr['thumbnail']['width'];
            $min_height = $img_sizes_arr['thumbnail']['height'];
        }else{
            $min_width = $min_height = 10;  //keep min height width in case of video thumb thumb to smaller value
        }
                
        $config = array(
                'upload_path'       => $realpath.$folder,
                'allowed_types'     => $allowed_types,
                'max_size'          => "10240",   // File size limitation, initially w'll set to 10mb (Can be changed)
                'max_height'        => "4000", // max height in px
                'max_width'         => "4000", // max width in px
                'min_width'         => $min_width, // min width in px
                'min_height'        => $min_height, // min height in px
                'file_name'         => $img_name,
                'overwrite'	        => FALSE,
                'remove_spaces'	    => TRUE,
            );
		
        $this->load->library('upload'); //upload library
        $this->upload->initialize($config);
 
        if(!$this->upload->do_upload($image)){
            $error = array('error' => $this->upload->display_errors());
            return $error; //error in upload
        }
        
        //image uploaded successfully - We will now resize and crop this image
        
        $image_data = $this->upload->data(); //get uploaded image data
        $this->load->library('image_lib'); //Load image manipulation library
        $thumb_img = '';

        //upload to AWS S3 bucket?
        if($this->config->item('bucket_upload')===TRUE){

            //unlink param here is FALSE, because for orignial image it will be later used to create resizes. So we will unlink from application uploads folder after resize/crop process is completed 
            $s3_result = $this->aws_bucket_upload($source_img_path, $upload_path, $image_name, FALSE);

            if($s3_result!==TRUE){
                $error = array('error' => 'Problem uploading image. Please try again');
                return $error; //error in upload
            }
        }

        foreach($img_sizes_arr as $k=>$v){
            
            // create resize sub-folder
            $sub_folder = $folder.$v['folder'];
            $this->make_dirs($sub_folder);

            $real_path = realpath(FCPATH .$realpath .$folder);

            $resize['image_library']      = 'gd2';
            $resize['source_image']       = $image_data['full_path'];
            $resize['new_image'] 	      = $real_path.$v['folder'].'/'.$image_data['file_name'];
            $resize['maintain_ratio']     = TRUE; //maintain original image ratio
            $resize['width'] 	      = $v['width'];
            $resize['height'] 	      = $v['height'];
            $resize['quality'] 	      = '85%';
            // We need to know whether to use width or height edge as the hard-value. 
            // After the original image has been resized, either the original image width’s edge or 
            // the height’s edge will be the same as the container
            $dim = (intval($image_data["image_width"]) / intval($image_data["image_height"])) - ($v['width'] / $v['height']);
            $resize['master_dim'] = ($dim > 0)? "height" : "width";

            $this->image_lib->initialize($resize);
            $is_resize = $this->image_lib->resize();   //create resized copies
            
            //image resizing maintaining it's aspect ratio is done. Now we will start cropping the resized image
            $source_img = $real_path.$v['folder'].'/'.$image_data['file_name'];
            
            if($is_resize && file_exists($source_img)){
                
                $source_image_arr = getimagesize($source_img);
                $source_image_width = $source_image_arr[0];
                $source_image_height = $source_image_arr[1];
                
                $source_ratio = $source_image_width / $source_image_height;
                $new_ratio = $v['width'] / $v['height'];
                
                if($source_ratio != $new_ratio){
                    
                    //image cropping config
                    $crop_config['image_library'] = 'gd2';
                    $crop_config['source_image'] = $source_img;
                    $crop_config['new_image'] = $source_img;
                    $crop_config['quality'] = "100%";
                    $crop_config['maintain_ratio'] = FALSE;
                    $crop_config['width'] = $v['width'];
                    $crop_config['height'] = $v['height'];
                    
                    if($new_ratio > $source_ratio || (($new_ratio == 1) && ($source_ratio < 1))){
                        //Source image height is greater than crop image height
                        //So we need to move on vertical(Y) axis while keeping horizantal(X) axis static(0)
                        $crop_config['y_axis'] = round(($source_image_height - $crop_config['height'])/2);
                        $crop_config['x_axis'] = 0;
                    }else{
                        //Source image width is greater than crop image width
                        //So we need to move on horizontal(X) axis while keeping vertical(Y) axis static(0)
                        $crop_config['x_axis'] = round(($source_image_width - $crop_config['width'])/2);
                        $crop_config['y_axis'] = 0;
                    }
                    
                    $this->image_lib->initialize($crop_config); 
                    $this->image_lib->crop();
                    $this->image_lib->clear();
                }

                
            }

            //upload to AWS S3 bucket?
            if($this->config->item('bucket_upload')===TRUE){
                $dest_upload_path = $realpath.$folder.$v['folder'].'/'.$image_data['file_name'];

                //unlink here will be TRUE as after upload to bucket we will unlink it immediately
                $s3_result = $this->aws_bucket_upload($source_img, $dest_upload_path, $image_data['file_name']);
            }
        }

        if(empty($thumb_img))
            $thumb_img = $image_data['file_name'];
        
        //unlink the original image if S3 uploading is enabled
        if($this->config->item('bucket_upload')===TRUE){
            //after resizing process we will now unlink original image from application uploads folder
            unlink($source_img_path);
        }

        return $thumb_img;
    } 
    
    /**
     * Delete(unlink) image from folder/server
     * 
     * @param      string $path Physical path of image directory
     * @param      string $file Image name
     * @return     boolean
     * @since      2.0.0
     * @edited     2.0.0
     * 
     */
    function delete_image($path, $file){
        
        $main   = $path.$file;
        $thumb  = $path.'thumb/'.$file;
        $medium = $path.'medium/'.$file;
        $large = $path.'large/'.$file;

        if(file_exists(FCPATH.$main)):
            unlink( FCPATH.$main);
        endif;
        if(file_exists(FCPATH.$thumb)):
            unlink( FCPATH.$thumb);
        endif;
        if(file_exists(FCPATH.$medium)):
            unlink( FCPATH.$medium);
        endif;
        if(file_exists(FCPATH.$large)):
            unlink( FCPATH.$large);
        endif;
        return TRUE;
    }

    /**
     * Upload multipart data to AWS S3 bucket
     * 
     * @param      string $source_img_path Source path of image
     * @param      string $upload_path Destination path for image
     * @param      string $image_name Image name
     * @param      boolean $unlink Whether to unlink image after upload
     * @return     boolean
     * @since      3.1.0
     * @edited     3.1.0
     * 
     */
    function aws_bucket_upload($source_img_path, $upload_path, $image_name, $unlink=TRUE){

        $s3Client = S3Client::factory(
        array(
            'credentials' => array(
                'key' => AWS_BUCKET_KEY,
                'secret' => AWS_BUCKET_SECRET
            ),
            'version' => 'latest',
            'region'  => AWS_BUCKET_REGION
        )
        );
        
        $bucket = AWS_BUCKET_NAME;

        // path: uploads/profile/thumb/abc.jpg
        // If Folder is not there at bucket, SDK will create it and then upload
        $key = $upload_path.$image_name; 
        
        // Using stream instead of file path
        $source = fopen($source_img_path, 'rb');
        
        $uploader = new ObjectUploader(
            $s3Client,
            $bucket,
            $key,
            $source
        );
        
        do {
            try {
                $result = $uploader->upload();
                if ($result["@metadata"]["statusCode"] == '200') {
                    //print('<p>File successfully uploaded to ' . $result["ObjectURL"] . '.</p>');

                    //File uploaded successfully, unlink file from application uploads folder
                    if($unlink === TRUE){
                        unlink($source_img_path);
                    }
                    return TRUE;
                }
                
            } catch (MultipartUploadException $e) {
                rewind($source);
                $uploader = new MultipartUploader($s3Client, $source, [
                    'state' => $e->getState(),
                ]);
            }
        } while (!isset($result));

        //Abort a multipart upload if failed
        try {
            $result = $uploader->upload();
        } catch (MultipartUploadException $e) {
            // State contains the "Bucket", "Key", and "UploadId"
            $params = $e->getState()->getId();
            $result = $s3Client->abortMultipartUpload($params);
            return FALSE;
        }
    }

    /**
     * Upload, resize and compress image to make it usable for other third
     * party APIs
     * @param      string $image Image file name
     * @param      string $folder Upload destination directory
     * @return     string Uploaded image name
     * @since      3.1.0
     * @edited     3.1.0
     * 
     */
    function upload_n_compress($image, $folder){

        $this->make_dirs($folder);
        
       	$realpath = 'uploads/';
        $allowed_types = "jpg|png|jpeg"; 	
        $img_name = random_string('alnum', 16);  //generate random string for image name
        
        //We will set min height and width according to thumbnail size
        $min_width = 300;
        $min_height = 300;
                
        $config = array(
            'upload_path'       => $realpath.$folder,
            'allowed_types'     => $allowed_types,
            'max_size'          => "10240",   // File size limitation, initially w'll set to 10mb (Can be changed)
            'max_height'        => "9000", // max height in px
            'max_width'         => "9000", // max width in px
            'min_width'         => $min_width, // min width in px
            'min_height'        => $min_height, // min height in px
            'file_name'         => $img_name,
            'overwrite'	        => TRUE,
            'remove_spaces'	    => TRUE,
        );
		
        $this->load->library('upload'); //upload library
        $this->upload->initialize($config);
 
        if(!$this->upload->do_upload($image)){
            $error = array('error' => 'Problem uploading image please try again');
            return $error; //error in upload
        }
        
        //image uploaded successfully-We will now resize and compress this image
        
        $image_data = $this->upload->data(); //get uploaded image data
        $this->load->library('image_lib'); //Load image manipulation library

        // create compress, resize and put it in same directory
        $resize['image_library']      = 'gd2';
        $resize['source_image']       = $image_data['full_path'];
        $resize['new_image'] 	      = $image_data['full_path'];
        $resize['maintain_ratio']     = TRUE; //maintain original image ratio
        $resize['width'] 	          = '300';
        $resize['height'] 	          = '300';
        $resize['quality'] 	          = '85%';  //reduce image quality to reduce its size

        $this->image_lib->initialize($resize);
        $is_resize = $this->image_lib->resize();
        $this->image_lib->clear();  //clear memory
        return $image_data['file_name'];
    }

    /**
     * Rotate image by checking exif orentation
     * 
     * @param      string $original_img_path Path of original image
     * @param      array $rotate_config Data ot image to be oriented
     * @return     boolean
     * @since      3.2.0
     * @edited     3.2.0
     * 
     */
    function rotate_image($original_img_path, $rotate_config=array()){
        
        // Check EXIF
        // Seems PHP still having a bug with its EXIF capability and it throws
        // Illegal IFD size error
        // Prepending @ to exif_read_data() will suppress this error
        $exif = @exif_read_data($img_path);

        if($exif && isset($exif['Orientation'])){
            
            $ort = $exif['Orientation'];

            if ($ort == 6 || $ort == 5)
                $rotate_config['rotation_angle'] = '270';
            if ($ort == 3 || $ort == 4)
                $rotate_config['rotation_angle'] = '180';
            if ($ort == 8 || $ort == 7)
                $rotate_config['rotation_angle'] = '90';
                
            $this->image_lib->initialize($rotate_config); 

            if ( ! $this->image_lib->rotate()){
                // Error Message here
                $error = array('error' => $this->image_lib->display_errors());
                return $error;
            }
            
            $this->image_lib->clear();
        }
        
        return TRUE;
    }

}// End of class Image_model
