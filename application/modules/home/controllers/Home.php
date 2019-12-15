<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Common_Front_Controller {
    public $data = "";
    function __construct() {
        parent::__construct();
        $this->load->model('Home_model');
    }
      
    function index(){
        $data['title'] = 'Signup';
        $data['front_scripts'] = array('frontend_asset/custom/js/facebook.js','frontend_asset/custom/js/google.js');
        $this->load->front_render('signup',$data);  
    }

    function login(){
        $data['title'] = 'Login';
        $data['front_scripts'] = array('frontend_asset/custom/js/facebook.js','frontend_asset/custom/js/google.js');
        $this->load->front_render('login',$data);
    }



    function socialRegistration(){  
        
        $this->form_validation->set_rules('socialFirstName', 'First Name', 'trim|required');
        $this->form_validation->set_rules('socialLastName', 'Last Name','trim|required');
        $this->form_validation->set_rules('socialEmail', 'Email','trim|required|valid_email');
        
        if($this->form_validation->run() == FALSE) {
            $res['status'] = 0;
            $res['msg'] = validation_errors();
            echo json_encode($res);die();
        }

        $data['profile_photo'] = !empty($this->input->post('clientprofileImage')) ? $this->input->post('clientprofileImage') : '';
        if(!empty($this->input->post('clientprofileImage'))){
            $data['is_profile_url'] = 1;
        }

        $data['first_name'] = $this->input->post('socialFirstName');
        $data['last_name'] = $this->input->post('socialLastName');
        $data['email'] = $this->input->post('socialEmail');
        $data['contact_detail'] = $this->input->post('address');
        $data['country'] = $this->input->post('country');
        $data['gender'] = $this->input->post('gender');
        $data['profile_photo'] = !empty($this->input->post('clientprofileImage')) ? $this->input->post('clientprofileImage') : '';
        if(!empty($this->input->post('clientprofileImage'))){
            $data['is_profile_url'] = 1;
        }

        $data['social_id'] = $this->input->post('clientSocialId');
        $data['social_type'] = $this->input->post('clientSocialType');

        $data['crd'] = datetime();
        $data['upd'] = datetime();

        $result = $this->Home_model->socialRegistration($data);

        if(is_array($result)){

            if($result['regType'] == 'REG'){
                $res = array('status' =>1,'msg' => 'Account created successfully','url' => base_url('home/profile'));
            }else if($result['regType'] == 'AE'){
                $res= array('status' =>0,'msg' => 'Email is already registered');
            }

            echo json_encode($res);
        } 
        
    }

    function socialLogin(){

        $data = array();
        $email = $this->input->post('email');
        $socialId = $this->input->post('socialId');
        $data['social_id'] = $this->input->post('socialId');
        $where = array('social_id'=>$socialId);
        $check = $this->common_model->is_data_exists(USERS,$where);

        if($check){

            $result = $this->Home_model->socialRegistration($data);

            if($result['regType'] == 'SL'){

                $response = array('status' =>1,'msg' => 'Logged in successfully','url' => base_url('home/profile'));
                echo json_encode($response);
            }else{
                $response= array('status' =>0,'msg' => 'You are temporary inactive by admin');
                echo json_encode($response);
            }
        }else{
            $where1 = array('email'=>$email);
            $check1 = $this->common_model->is_data_exists(USERS,$where1);
            if($check1){
                $res= array('status' =>0,'msg' => 'Email is already registered');
            }else{
                $res['status'] = 2;
            }
            echo json_encode($res);
        } 
    }


     function userLogin(){
        
        $this->form_validation->set_rules('email','Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        //check validations
        if($this->form_validation->run() == FALSE) {
            $response = array('status' => 0,'msg' => strip_tags(validation_errors()));//failed
            echo json_encode($response); die;
        }
        $data['email'] = $this->input->post('email');
        $data['password'] = $this->input->post('password');
        $remember = $this->input->post('remember');

        $result = $this->Home_model->userLogin(USERS,$data,$remember);
         if(!$result){
            $response = array('status'=>0,'msg'=>'Invalid Username or Password' ,'url'=>base_url('user'));
            echo json_encode($response);die;
        }

        if($result){//CHECK USERS EMAIL VERIFIED OR NOT .
            $response = array('status' =>1,'msg' => 'Logged in successfully','url' => base_url('home/profile'));
                echo json_encode($response);

        }else{//IF EMAIL IS NOT VERIFIED .
            $response = array('status'=>0,'msg'=>'Something went wrong.');
            echo json_encode($response);
        }

    }


    function userRegistration(){


        $this->form_validation->set_rules('First_name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('Last_name', 'Name', 'trim|required|alpha_numeric_spaces');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|matches[password]');

        if($this->form_validation->run() == FALSE){
            $res['status'] = 0;
            $res['msg'] = validation_errors();
            echo json_encode($res);die();
        }
        $email = $this->input->post('email');
        $where =array('email'=>$email);
        $check = $this->common_model->is_data_exists(USERS,$where);
        if($check){
            if($check->social_id){
                $res = array('status' =>FAIL, 'msg' =>'This email is already associated with social account so it cannot be used for signup. Please try using social signup option.');
                echo json_encode($res); die; 
                return false;
            }
            $res = array('status' =>FAIL, 'msg' =>'Email already exists');
            echo json_encode($res); die; 
            return false;
        }else{
            

            if(!empty($_FILES['profileImage']['name'])) {
                $folder = 'profile'; //Set folder for upload  profile image   
                $result = $this->Image_model->upload_image('profileImage', $folder);
                if (is_array($result) && array_key_exists('error', $result)){
                    $response = array('status' => FAIL,'msg' => strip_tags($result['error']));
                    echo json_encode($response); exit;
                }else{
                  $data['profile_photo'] =$result;
                }   
            }

            $data['first_name'] = $this->input->post('First_name');
            $data['last_name'] = $this->input->post('Last_name');
            $data['email'] = $this->input->post('email');
            $data['password'] = password_hash($this->input->post('password') , PASSWORD_DEFAULT);
            $data['contact_detail'] = $this->input->post('address1');
            $data['country'] = $this->input->post('countryt');
            $data['gender'] = $this->input->post('gender1');
            
            $data['crd'] = datetime();
            $data['upd'] = datetime();
            $result = $this->Home_model->userRegister($data);
            
            if($result){
                $res = array('status' =>1,'msg' => 'Account created successfully','url' => base_url('home/login'));
            }else{
                $res = array('status' =>0,'msg' => 'Account is not created successfully');
            }
            echo json_encode($res);
        }
    }


    function profile(){

        $data['title'] = 'profile';
        $user_details = get_user_session_data();
        $userId = $user_details['userId'];
        $data['user'] = $this->Home_model->get_user_data($userId);
        //pr($data['user']);
        $this->load->front_render('user_profile',$data);
    }


}//END OF CLASS