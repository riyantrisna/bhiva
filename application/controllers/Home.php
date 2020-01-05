<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../vendor/veritrans/veritrans-php/Veritrans.php';
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


			$send_schedule = date('Y-m-d');
			$data['NAMA_USER'] = $name;
			$data['USER_EMAIL'] = $email;
			$data['PASSWORD'] = $password;
			$status_email = $this->data->addEmailSend('registration_user', $email, NULL, $send_schedule, $data);

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

				$data = array(
					'user_last_login' => date('Y-m-d H:i:s')
				);
				$this->data->updateUser($data, $data_user->id);

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

	public function notification(){

		//Set Your server key
		Veritrans_Config::$serverKey = $this->config->item('server_key');
		// Uncomment for production environment
		if($this->config->item('is_production')){
			Veritrans_Config::$isProduction = true;
		}

		$notif = new Veritrans_Notification();

		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		if ($transaction == 'capture') {
			// For credit card transaction, we need to check whether transaction is challenge by FDS or not
			if ($type == 'credit_card'){
				if($fraud == 'challenge'){
					// TODO set payment status in merchant's database to 'Challenge by FDS'
					// TODO merchant should decide whether this transaction is authorized or not in MAP
					$status = 4;	// echo "Transaction order_id: " . $order_id ." is challenged by FDS";
				}else {
					// TODO set payment status in merchant's database to 'Success'
					$status = 2;	// echo "Transaction order_id: " . $order_id ." successfully captured using " . $type;
				}
			}
		}
		else if ($transaction == 'settlement'){
			// TODO set payment status in merchant's database to 'Settlement'
			$status = 2;	// echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
		}else if ($transaction == 'success'){
			// TODO set payment status in merchant's database to 'Success'
			$status = 2;	// echo "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
		} 
		else if($transaction == 'pending'){
			// TODO set payment status in merchant's database to 'Pending'
			$status = 1;	// echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
		} 
		else if ($transaction == 'deny') {
			// TODO set payment status in merchant's database to 'Denied'
			$status = 1;	// echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
		}
		else if ($transaction == 'expire') {
			// TODO set payment status in merchant's database to 'expire'
			$status = 3;	// echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
		}
		else if ($transaction == 'cancel') {
			// TODO set payment status in merchant's database to 'Denied'
			$status = 3;	// echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
		}else{
			$status = 1;
		}

		$data_update = array(
			'transaction_midtrans_transaction_id' => $notif->transaction_id,
			'transaction_midtrans_response' => json_encode((array) $notif),
			'transaction_payment_type' => $notif->payment_type,
			'transaction_status' => $status,
			'update_user_id' => NULL,
			'update_datetime' => date('Y-m-d H:i:s')
		);
		$update_transaction = $this->data->updateTransactionByCode($data_update, $notif->order_id);

		if(!empty($notif->order_id) AND $status==2){

			$detail_transaction = $this->data->getDetailTransactionByCode($notif->order_id);

			$send_schedule = date('Y-m-d');
			$data['NAMA_USER'] = $detail_transaction->contact_name;
			$data['TRANSACTION_ID'] = $detail_transaction->code;
			$data['TOTAL_PAYMENT'] = $detail_transaction->total;
			$data['LINK'] = $this->config->item('base_url').'user/transaction';
			$status_email = $this->data->addEmailSend('payment_successful', $detail_transaction->contact_email, NULL, $send_schedule, $data);

			$email_admin_ticket = $this->data->getSetting('admin_email_ticket');
			$email_admin_tourpackages = $this->data->getSetting('admin_email_tourpackages');

			if(!empty($email_admin_ticket) AND empty($email_admin_tourpackages)){
				$to_admin = $email_admin_ticket;
				$status_email = $this->data->addEmailSend('payment_successful', $to_admin, NULL, $send_schedule, $data);
			}else if(empty($email_admin_ticket) AND !empty($email_admin_tourpackages)){
				$to_admin = $email_admin_tourpackages;
				$status_email = $this->data->addEmailSend('payment_successful', $to_admin, NULL, $send_schedule, $data);
			}else if(!empty($email_admin_ticket) AND !empty($email_admin_tourpackages)){
				$to_admin = $email_admin_ticket.','.$email_admin_tourpackages;
				$status_email = $this->data->addEmailSend('payment_successful', $to_admin, NULL, $send_schedule, $data);
			}

			
			if($detail_transaction->type == '1'){
				$detail_transaction_tourpackages = $this->data->getDetailTransactionTourpackagesByUserId($detail_transaction->id, $detail_transaction->user_id);
				$detail_transaction_testimony = $this->data->getDetailTransactionTestimonyById($detail_transaction->id);

				$send_schedule = date('Y-m-d', strtotime($detail_transaction_tourpackages->date_tour.' + '.$detail_transaction_tourpackages->total_day.' days'));
				
				$data['LINK'] = $this->config->item('base_url').'user/testimony/'.$detail_transaction_testimony->token;
				$status_email = $this->data->addEmailSend('testimony_tourpackages', $detail_transaction->contact_email, NULL, $send_schedule, $data);
			}

		}

		if($update_transaction){
			echo 'ok';
		}else{
			echo 'faild';
		}
	}

	public function forgetpassword()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();


		
		$data['tourpackages'] = $this->data->getTourpackages();
		$data['destination_location_home'] = $this->data->getDestinationLocationHome();
		
		$this->load->view('forgetpassword', $data);

	}

	public function reset_password(){
		$email = $this->input->post('email', TRUE);

		$check_email = $this->data->getExistEmail($email);

		if(!empty($check_email)){
			$new_pass = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

			$data_update = array(
				'user_password' => md5($new_pass)
			);
			$result = $this->data->updateUserByEmail($data_update, $email);

			if($result){
				// kirim email
				$send_schedule = date('Y-m-d');
				$data['NAMA_USER'] = $check_email->real_name;
				$data['USER_EMAIL'] = $email;
				$data['PASSWORD'] = $new_pass;
				$status_email = $this->data->addEmailSend('forget_password', $email, NULL, $send_schedule, $data);

				$data['status'] = TRUE;
				$data['message'] = MultiLang('msg_reset_password_success');
			}else{
				$data['status'] = FALSE;
				$data['message'] = MultiLang('msg_reset_password_failed');
			}
		}else{
			$data['status'] = FALSE;
			$data['message'] = MultiLang('email_not_registered');
		}
		
		echo json_encode($data);
	}

	public function send_subscribe(){
		$email = $this->input->post('email', TRUE);

		$check_email = $this->data->getExistEmailSubscribe($email);

		if(empty($check_email)){

			$data_update = array(
				'subemail_date' => date('Y-m-d'),
				'subemail_email' => $email,

			);
			$result = $this->data->addEmailSubscribe($data_update, $email);

			if($result){
				// kirim email
				$data['status'] = TRUE;
				$data['message'] = MultiLang('subscription_email_saved_successfully');
			}else{
				$data['status'] = FALSE;
				$data['message'] = MultiLang('subscription_email_failed_to_save');
			}
		}else{
			$data['status'] = FALSE;
			$data['message'] = MultiLang('email').' '.MultiLang('existed');
		}
		
		echo json_encode($data);
	}

	public function addEmailSend($key_template, $to, $cc, $send_schedule, $data){
				
		$template_email = $this->data->getTemplateEmail($key_template);

		if(!empty($template_email)){
			$subject = $template_email->subject;
			$content = $template_email->content;
			
			if(!empty($data)){
				foreach ($data as $key_post => $val_post) {
					$subject = str_replace('[' . strtoupper($key_post) . ']', $val_post, $subject);
				}

				$data['title'] = $subject;
				foreach ($data as $key_post => $val_post) {
					$content = str_replace('[' . strtoupper($key_post) . ']', $val_post, $content);
				}
			}

			$data = array(
				'emaillog_to' => $to,
				'emaillog_cc' => $cc,
				'emaillog_subject' => $subject,
				'emaillog_from' => $template_email->from_name,
				'emaillog_content' => $content,
				'emaillog_send_schedule' => $send_schedule,
				'emaillog_status' => 0,
				'insert_user_id' => $this->session->userdata('user_id'),
				'insert_datetime' => date('Y-m-d H:i:s')
			);
			$results = $this->data->addEmailSend($data);
		}else{
			$results = FALSE;
		}

		return $results;
	}
	
}
