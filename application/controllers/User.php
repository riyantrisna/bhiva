<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public $CI = NULL;

	function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();

		$this->load->model('data');
		$this->user_lang = !empty($this->session->userdata('user_lang')) ? $this->session->userdata('user_lang') : 'id';
	}

	public function profile()
	{

		if(!$this->session->userdata('user_id'))
		{
			//jika memang session sudah terdaftar, maka redirect ke halaman dahsboard
			redirect(base_url());
		}else{

			$data['lang'] = $this->data->getLang();
			$data['lang_set'] = $this->data->getLangDetail();
			$data['path_language'] = $this->config->item('path_language');
			$data['service'] = $this->data->getService();
			$data['contact'] = $this->data->getContact();
			$data['destination_location'] = $this->data->getDestinationLocation();

			//profile
			$data['user'] = $this->data->getUserByUserId($this->session->userdata('user_id'));

			$data['tourpackages'] = $this->data->getTourpackages();
			$data['destination_location_home'] = $this->data->getDestinationLocationHome();
			
			$this->load->view('user', $data);
		}

	}

	public function logout(){
	    $this->session->sess_destroy();
	    redirect(base_url());
	}

	public function edit()
    {   
        $path_user_upload = $this->config->item('path_user_upload');
        $path_user = $this->config->item('path_user');
        $id = $this->session->userdata('user_id');
        $name = $this->input->post('name', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $gender = $this->input->post('gender', TRUE);
        $birthday = $this->input->post('birthday', TRUE);
        $lang = $this->input->post('lang', TRUE);
        $file_photo_value = $this->input->post('file_photo_value');
        $file_photo_value_old = $this->input->post('file_photo_value_old');

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(empty($name)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('name').' '.MultiLang('required').'</li>';
		}
		
		if(empty($phone)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('phone').' '.MultiLang('required').'</li>';
        }

        if(empty($gender)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('gender').' '.MultiLang('required').'</li>';
        }

        if(empty($birthday)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('birthday').' '.MultiLang('required').'</li>';
        }

        if(empty($lang)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('language').' '.MultiLang('required').'</li>';
        }

        if($validation){
            $results = true;
            $upload['status'] = true;

            if(!empty($file_photo_value)){
                $max_size = '512'; // in KB
                $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
                $upload = $this->data->uploadBase64($file_photo_value, $path_user_upload, $max_size, $type_allow);
            }

            if($upload['status']){
                if(!empty($file_photo_value)){
					$data = array(
						'user_real_name' => $name,
						'user_phone' => $phone,
						'user_gender' => $gender,
						'user_birthday' => $birthday,
						'user_lang' => $lang,
						'user_photo' => (!empty($upload['file'])) ? $upload['file'] : NULL,
						'update_user_id' => $user_id,
						'update_datetime' => $date
					);
                }else{
					$data = array(
						'user_real_name' => $name,
						'user_phone' => $phone,
						'user_gender' => $gender,
						'user_birthday' => $birthday,
						'user_lang' => $lang,
						'user_photo' => NULL,
						'update_user_id' => $user_id,
						'update_datetime' => $date
					);
                }
                $results = $results && $this->data->updateUser($data, $id);
            
                if ($results) {
                    $result["status"] = TRUE;
                    $result["message"] = MultiLang('msg_update_success');
                    if(!empty($file_photo_value) AND !empty($file_photo_value_old)){
                        @unlink($path_user_upload.$file_photo_value_old);
                    }elseif(empty($file_photo_value)){
                        @unlink($path_user_upload.$file_photo_value_old);
					}
					
					$session_data = array(
						'user_real_name' => $name,
						'user_lang' => $lang,
						'user_photo' => $path_user.(!empty($upload['file']) ? $upload['file'] : 'default.png'),
					);
					//set session userdata
					$this->session->set_userdata($session_data);

                } else {
                    $result["status"] = FALSE;
                    $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    $result["message"].= '<li>'.MultiLang('msg_update_failed').'</li>';
                    $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>';
                    $result["message"].= '</div>';
                    @unlink($path_user_upload.$file_photo_value);
                }

            }else{
                $result["status"] = FALSE;
                $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                $result["message"].= '<li>'.$upload['message'].'</li>';
                $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>';
                $result["message"].= '</div>';
            }

        }else{
            $result["status"] = FALSE;
            $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            $result["message"].= $validation_text;
            $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>';
            $result["message"].= '</div>';
        }

        echo json_encode($result);
        
    }
	
}
