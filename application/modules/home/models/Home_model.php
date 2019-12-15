<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {


    // Create sesion for checking user login or not
    function session_create($lastId){
        $sql = $this->db->select('*')->where(array('userId'=>$lastId))->get(USERS);
        if($sql->num_rows()){
            $user= $sql->row();
            $session_data = array(
                'name' => $user->first_name,
                'email' => $user->email,
                'status' => $user->status,
                'userId' => $user->userId,
               'profileImage' => $user->profile_photo
            );
            $_SESSION[USER_SESS_KEY] = $session_data;
            return true;
        }
        return false; 
    }//ENdFunction

    function socialRegistration($data){
        $check = $this->db->select('*')->where(array('social_id'=>$data['social_id']))->get(USERS);
        if($check->num_rows() == 1) { 
            $res = $check->row();
            $status_check = $res->status ;
            if($status_check == 1){//if active
                $userId = $res->userId;
                $this->session_create($userId);
                return array('regType'=>'SL','data'=>$res); //Client registration 
            }else {
                return array('regType'=>'NA'); //not active
            }
        }else{
            if($check->num_rows() == 0){
                $test = array('email'=>$data['email']);
                $checkEmail = $this->common_model->is_data_exists(USERS,$test);// Check unique email for user.
                if(!$checkEmail){
                    $this->db->insert(USERS,$data);
                    $userId = $this->db->insert_id();
                    $data = $this->common_model->getRow(USERS,array('userId'=>$userId));
                    $this->session_create($userId);
                    $this->sendVerificationEmail($userId);
                    return array('regType'=>'REG','data'=>$data); //User registration    
                }else{
                    return array('regType'=>'AE'); //already exist
                }
            }
        }
    } 


    function userLogin($table, $data){//User authentication login 
        $email = $data['email'];
        $password = $data['password'];
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where(array('email' =>$email));
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            $user = $query->row();
            if(password_verify($data['password'], $user->password)) { 
                $this->session_create($user->userId); 
                return true;
            }
        }else{
           return false;
        } 

    }//END OF User LOGIN FUNCTION


    //User registration
    function userRegister($data){
        $response = $this->db->insert(USERS,$data);
        $userId = $this->db->insert_id();
        if($userId){
            $data = $this->common_model->getRow(USERS,array('userId'=>$userId));
            return true;
        }else{
            return false;
        }
    }//End user registration

    function get_user_data($userId){
        $defaultImg = base_url().DEFAULT_USER;
        $user_image = base_url().IMG_PATH;
        

        $this->db->select('userId,first_name,last_name,social_id,social_type,contact_detail,country,gender,email,profile_photo,is_profile_url,
        (case 
            when(profile_photo = "" OR profile_photo IS NULL) 
                THEN "'.$defaultImg.'"

            when(is_profile_url = 1) 
                THEN profile_photo

            ELSE
                concat("'.$user_image.'",profile_photo) 
            END ) as profileImage');
        $this->db->from(USERS);
        $this->db->where('userId',$userId);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $row = $query->row();
            return $row;
        }
        return false;
    }

    
}