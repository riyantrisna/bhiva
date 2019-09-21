<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('data');
	}

	public function index()
	{
		if($this->session->userdata('user_id'))
		{
			//jika memang session sudah terdaftar, maka redirect ke halaman dahsboard
			redirect(base_url().'home');
		}else{
			$path_user = $this->config->item('path_user');
			$is_login = $this->input->post('login');
			if(isset($is_login)){
				$data = array();
				$validation = true;
				$validation_text = '';
				$username = $this->input->post("username", TRUE);
				$password = $this->input->post('password', TRUE);
				
				if(empty($username) AND !empty($password)){
					$validation_text.= '<div>'.MultiLang('username_must_fielld').'</div>';		
					$validation = $validation && false;		
				}elseif(!empty($username) AND empty($password)){
					$validation_text.= '<div>'.MultiLang('password_must_fielld').'</div>';		
					$validation = $validation && false;		
				}elseif(empty($username) AND empty($password)){
					$validation_text.= '<div>'.MultiLang('username_password_must_fielld').'</div>';		
					$validation = $validation && false;		
				}

				$data['msg'] = $validation_text;

				if($validation){

					$data = array();
					$validation_text = '';

					$data_user = $this->data->getUserByUsername($username);
					$password = MD5($password);

					if(!empty($data_user) AND $password == $data_user->password){

						$session_data = array(
							'user_id' => $data_user->id,
							'user_email' => $data_user->email,
							'user_real_name' => $data_user->real_name,
							'user_lang' => $data_user->lang,
							'user_type' => $data_user->type,
							'user_photo' => $path_user.(!empty($data_user->photo) ? $data_user->photo : 'default.png'),
						);
						//set session userdata
						$this->session->set_userdata($session_data);

						redirect(base_url().'home');
					}else{
						$data['msg'] = '<div>'.MultiLang('username_or_password_wrong').'</div>';
						$this->load->view('login', $data);
					}
					

				}else{
					$this->load->view('login', $data);
				}
			}else{
				$this->load->view('login');
			}
			
		}
	}

	public function get_session_login(){
		if($this->session->userdata('user_id')){
			echo 1;
		}else{
			echo 0;
		}
	}
	
	public function logout(){
	    $this->session->sess_destroy();
	    redirect(base_url());
	}

	public function changepassword(){
	    $data = array();
		$validation = true;
		$validation_text = '';

		$old_password = $this->input->post("old_password", TRUE);
		$new_password = $this->input->post('new_password', TRUE);
		$retype_new_password = $this->input->post('retype_new_password', TRUE);

		if(empty($old_password)){
			$validation = $validation && false;
			$validation_text.= '<li>'.MultiLang('old_password_must_fielld').'</li>';
		}

		if(!empty($old_password)){
			$data_user = $this->data->getUserByUsername($this->session->userdata('user_name'));
			if(empty($data_user) OR(!empty($data_user) AND $data_user->password !== MD5($old_password))){
				$validation = $validation && false;
				$validation_text.= '<li>'.MultiLang('old_password_wrong').'</li>';
			}
		}

		if(empty($new_password)){
			$validation = $validation && false;
			$validation_text.= '<li>'.MultiLang('new_password_must_fielld').'</li>';
		}

		if(empty($retype_new_password)){
			$validation = $validation && false;
			$validation_text.= '<li>'.MultiLang('retype_new_password_must_fielld').'</li>';
		}

		if(!empty($new_password) AND !empty($retype_new_password) AND $new_password !== $retype_new_password){
			$validation = $validation && false;
			$validation_text.= '<li>'.MultiLang('new_password_and_retype_new_password_not_match').'</li>';
		}

		if($validation){
			$data_update = array(
				'user_password' => MD5($new_password),
				'update_user_id' => $this->session->userdata('user_id'),
				'update_datetime' => date('Y-m-d H:i:s')

			);
			$result_update_user = $this->data->updateDataUser($data_update, $this->session->userdata('user_id'));

			if($result_update_user){
				$data['status'] = true;
				$data['msg'] = MultiLang('success_change_password');
			}else{
				$data['status'] = false;
				$data['msg'] = MultiLang('failed_change_password');
			}

		}else{
			$data['status'] = $validation;
			$data['msg'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
			$data['msg'].= $validation_text;
			$data['msg'].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>';
			$data['msg'].= '</div>';
		}

		echo json_encode($data);
	}
	
}
