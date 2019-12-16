<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public $CI = NULL;

	function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();

		$this->load->model('data');
		$this->user_lang = !empty($this->session->userdata('user_lang')) ? $this->session->userdata('user_lang') : 'id';
	}

	public function index()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['slider'] = $this->data->getSlider();
		$data['greeting'] = $this->data->getGreeting();
		$data['travel_post'] = $this->data->getTravelPost();
		if(!empty($data['travel_post'])){
			foreach ($data['travel_post'] as $key => $value) {
				$data['travel_post'][$key]->date = $this->data->getDatetimeIndo($value->date);
			}
		}
		$data['ticket'] = $this->data->getTicket();
		$data['tourpackages'] = $this->data->getTourpackages();
		$data['destination_location_home'] = $this->data->getDestinationLocationHome();
		
		$this->load->view('home', $data);

	}

	public function load_destination($id, $page, $limit)
	{
		$data = $this->data->getDestinationPagingById($id, $page, $limit);

		return $data;
	}	

	public function changelanguage($lang)
	{
		$session_data = array(
			'user_lang' =>  $lang
		);
		//set session userdata
		$this->session->set_userdata($session_data);
		redirect(base_url());

	}
	
	public function register()
	{
		$name = $this->input->post('name', TRUE);
		$email = $this->input->post('email', TRUE);
		$phone = $this->input->post('phone', TRUE);
		$gender = $this->input->post('gender', TRUE);
		$birthday = $this->input->post('birthday', TRUE);
		$password = $this->input->post('password', TRUE);
		$repassword = $this->input->post('repassword', TRUE);

		$validation = true;
		$validation_text = '';
		
		if(empty($name)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('name').' '.MultiLang('required').'</li>';
		}
		if(empty($email)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('email').' '.MultiLang('required').'</li>';
		}else{
            $check_email = $this->data->getExistEmail($email);
            if(!empty($check_email->email)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('email').' <b>'.$email.'</b> '.MultiLang('existed').'</li>';
            }
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
		if(empty($password)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('password').' '.MultiLang('required').'</li>';
		}
		if(empty($repassword)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('retype_password').' '.MultiLang('required').'</li>';
		}
		if(!empty($password) AND !empty($repassword) AND $password !== $repassword){
			$validation = $validation && false;
			$validation_text.= '<li>'.MultiLang('password_and_retype_password_not_match').'</li>';
		}

		if($validation){
			$data = array(
				'user_real_name' => $name,
				'user_email' => $email,
				'user_phone' => $phone,
				'user_gender' => $gender,
				'user_birthday' => $birthday,
				'user_is_admin' => 0,
				'user_lang' => $this->user_lang,
				'user_status' => 1,
				'user_password' => MD5($password),
				'insert_user_id' => NULL,
				'insert_datetime' => date('Y-m-d H:i:s')
			);
			$results = $this->data->addUser($data);

			// send email
		
			if ($results) {
				$result["status"] = TRUE;
				$result["message"] = MultiLang('registration_successful');
			} else {
				$result["status"] = FALSE;
				$result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
				$result["message"].= '<li>'.MultiLang('registration_failed').'</li>';
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

	public function login()
	{
		$path_user = $this->config->item('path_user');
		$email = $this->input->post('email', TRUE);
		$password = $this->input->post('password', TRUE);

		$validation = true;
		$validation_text = '';
		
		if(empty($email)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('email_must_fielld').'</li>';
		}elseif(empty($password)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('password_must_fielld').'</li>';
		}elseif(empty($email) AND empty($password)){
			$validation = $validation && false;	
			$validation_text.= '<li>'.MultiLang('username_password_must_fielld').'</li>';		
		}

		if($validation){

			$result = array();
			$validation_text = '';

			$data_user = $this->data->getUserByUsernameLogin($email);
			$password = MD5($password);

			if(!empty($data_user) AND $password === $data_user->password){

				$session_data = array(
					'user_id' => $data_user->id,
					'user_email' => $data_user->email,
					'user_real_name' => $data_user->real_name,
					'user_lang' => $data_user->lang,
					'user_photo' => $path_user.(!empty($data_user->photo) ? $data_user->photo : 'default.png'),
				);
				//set session userdata
				$this->session->set_userdata($session_data);

				$result["status"] = TRUE;
			}else{
				$result["status"] = FALSE;
				$result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
				$result["message"].= '<li>'.MultiLang('username_or_password_wrong').'</li>';
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
