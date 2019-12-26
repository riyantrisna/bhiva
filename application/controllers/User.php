<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../vendor/autoload.php';
use \Firebase\JWT\JWT;
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
	
	public function changepassword()
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
			
			$this->load->view('changepassword', $data);
		}

	}

	public function processchangepassword(){
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
			$data_user = $this->data->getUserByUsername($this->session->userdata('user_email'));
			if(empty($data_user) OR (!empty($data_user) AND $data_user->password !== MD5($old_password))){
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
			$result_update_user = $this->data->updateUser($data_update, $this->session->userdata('user_id'));

			if($result_update_user){
				$data['status'] = true;
				$data['message'] = MultiLang('success_change_password');
			}else{
				$data['status'] = false;
				$data['message'] = MultiLang('failed_change_password');
			}

		}else{
			$data['status'] = $validation;
			$data['message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
			$data['message'].= $validation_text;
			$data['message'].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>';
			$data['message'].= '</div>';
		}

		echo json_encode($data);
	}

	public function get_session_login(){
		if($this->session->userdata('user_id')){
			echo 1;
		}else{
			echo 0;
		}
	}

	public function transaction()
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

			$filter = array();

			$data['transaction'] = $this->data->getAllTransactionByUserId($filter, $this->session->userdata('user_id'), 0, 10);
			$data['transaction_total'] = $this->data->getTotalAllTransactionByUserId($filter, $this->session->userdata('user_id'));

			$data['tourpackages'] = $this->data->getTourpackages();
			$data['destination_location_home'] = $this->data->getDestinationLocationHome();
			
			$this->load->view('transaction', $data);
		}

	}

	public function filter_transaction(){

		$filter['type'] = $this->input->post('type', TRUE);
		$page = $this->input->post('page', TRUE);
		$limit = $this->input->post('limit', TRUE);
		$transaction_total = $this->data->getTotalAllTransactionByUserId($filter, $this->session->userdata('user_id'));		
		$transaction = $this->data->getAllTransactionByUserId($filter, $this->session->userdata('user_id'), $page, $limit);		
		
		$html = '';
		if(!empty($transaction)){
			foreach ($transaction as $key => $value) {
				
				$html.= '<div class="card mb-4">
							<div class="card-header">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										'.MultiLang('transaction_id').' - <b>'.$value->code.'</b>
									</div>
									<div class="col-md-6 col-sm-12 text-md-right text-sm-left">
										<b>Rp '.(number_format($value->total, 0, ',', '.')).'</b>
									</div>
								</div>
							</div>
							<div class="card-body">';
								
								if($value->type=='1'){
									$type = '<i class="fas fa-layer-group nav-icon"></i>&nbsp;&nbsp;'.MultiLang('tourpackages');
								}elseif($value->type=='2'){
									$type = '<i class="fas fa-ticket-alt nav-icon"></i>&nbsp;&nbsp;'.MultiLang('ticket');
								}elseif($value->type=='3'){
									$type = '<i class="fas fa-place-of-worship nav-icon"></i>&nbsp;&nbsp;'.MultiLang('venue');
								}else{
									$type = '';
								}
								
				$html.= '		<div class="form-group">
									<b>'.$type.'</b>
								</div>
								<div class="form-group">
									'.$value->name.'
								</div>
								
							</div>
							<div class="card-footer">';

								if($value->status=='1'){
									$status = MultiLang('waiting_for_payment');
									$status_color_class = 'badge badge-pill badge-warning';
								}elseif($value->status=='2'){
									$status = MultiLang('payment_successful');
									$status_color_class = 'badge badge-pill badge-success';
								}elseif($value->status=='3'){
									$status = MultiLang('expired_order');
									$status_color_class = 'badge badge-pill badge-danger';
								}elseif($value->status=='4'){
									$status = MultiLang('on_hold');
									$status_color_class = 'badge badge-pill badge-warning';
								}else{
									$status = '';
									$status_color_class = '';
								}
								
				$html.= '		<div class="row">
									<div class="col-md-6 col-sm-12 mb-1">
										<span class="'.$status_color_class.'" style="font-size: 14px;">
											'.$status.'
										</span>
									</div>';
										
				$html.='			<div class="col-md-6 col-sm-12 text-md-right text-sm-left">';
								if($value->status=='1'){
				$html.= '				<button class="btn btn-sm btn-success" href="javascript:void(0)" title="'.MultiLang('complete_payment').'" id="btn_pay" onclick="pay_transaction(\''.$value->id.'\')">
											<i class="fas fa-money-bill-wave"></i> '.MultiLang('complete_payment').'
										</button>';
								}
				$html.='				<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail_transaction(\''.$value->id.'\')">
											<i class="fas fa-search"></i> '.MultiLang('detail').'
										</a>
									</div>
								</div>
							</div>
						</div>';
				
			}

			if(count($transaction) >= 10 AND $page < $transaction_total){
				$html.= '<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more" onclick="load_more('.($page+10).', 10)">'.MultiLang('load_more').'</button>
						</div>';
			}
			// $data['total_data'] = count($transaction);
		}else{
			$html.= '<div class="col-12 text-center"><i>-- '.MultiLang('empty_transaction').' --</i></div>';
			// $data['total_data'] = 0;
		}

		$data['html'] = $html;
        
        echo json_encode($data);
	}

	public function detail_transaction($id){

		$type = $this->data->getDetailTransactionTypeById($id);
		if($type == 1){
			$detail = $this->data->getDetailTransactionTourpackagesByUserId($id, $this->session->userdata('user_id'));
			$detail_tourist = $this->data->getDetailTransactionTouristById($id);
		
			if($detail->status=='1'){
				$status = MultiLang('waiting_for_payment');
				$status_color_class = 'badge badge-pill badge-warning';
			}elseif($detail->status=='2'){
				$status = MultiLang('payment_successful');
				$status_color_class = 'badge badge-pill badge-success';
			}elseif($detail->status=='3'){
				$status = MultiLang('expired_order');
				$status_color_class = 'badge badge-pill badge-danger';
			}elseif($detail->status=='4'){
				$status = MultiLang('on_hold');
				$status_color_class = 'badge badge-pill badge-warning';
			}else{
				$status = '';
				$status_color_class = '';
			}

			$html = '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="status">'.MultiLang('payment_status').'</label>';
			$html.=     '<div id="status">
							<span class="'.$status_color_class.'" style="font-size: 14px;">
								'.$status.'
							</span>
						</div>';
			$html.= '</div><hr>';
			if(!empty($detail->midtrans_transaction_id) AND $detail->status=='1' AND $detail->payment_type=='gopay'){
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="qrcode_gopay">'.MultiLang('qrcode_gopay').'</label>';
			$html.=     '<div id="qrcode_gopay">
							<img src="'.$this->config->item('qrcode_gopay_url').$detail->midtrans_transaction_id.'/qr-code" width="200" height="200">
						</div>';
			$html.= '</div><hr>';
			}
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="code">'.MultiLang('code').'</label>';
			$html.=     '<div id="code">'.$detail->code.'</div>';
			$html.= '</div><hr>';
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="transaction_date">'.MultiLang('transaction_date').'</label>';
			$html.=     '<div id="transaction_date">'.(!empty($detail->date) ? $this->data->getDatetimeIndo($detail->date) : '').'</div>';
			$html.= '</div><hr>';

			if($detail->type=='1'){
				$type = '<i class="fas fa-layer-group nav-icon"></i>&nbsp;&nbsp;'.MultiLang('tourpackages');
			}elseif($detail->type=='2'){
				$type = '<i class="fas fa-ticket-alt nav-icon"></i>&nbsp;&nbsp;'.MultiLang('ticket');
			}elseif($detail->type=='3'){
				$type = '<i class="fas fa-place-of-worship nav-icon"></i>&nbsp;&nbsp;'.MultiLang('venue');
			}else{
				$type = '';
			}

			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="type">'.MultiLang('type').'</label>';
			$html.=     '<div id="type">'.$type.'</div>';
			$html.= '</div><hr>';
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="tourpackages">'.MultiLang('tourpackages').'</label>';
			$html.=     '<div id="tourpackages">'.$detail->tourpackages_name.'</div>';
			$html.= '</div><hr>';
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="travel_date">'.MultiLang('travel_date').'</label>';
			$html.=     '<div id="travel_date">'.(!empty($detail->date_tour) ? $this->data->getDateIndo($detail->date_tour) : '').'</div>';
			$html.= '</div><hr>';
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="price">'.MultiLang('price').'</label>';
			$html.=		'<div id="price">';
			if(!empty($detail->qty_local_tourists)){
			$html.=     MultiLang('local_tourists').' (@ Rp '.(number_format($detail->price_local_tourists, 0, ',', '.')).' x '.$detail->qty_local_tourists.')
						<div class="mt-auto" style="color: #212529;">
							Rp '.(number_format(($detail->price_local_tourists * $detail->qty_local_tourists), 0, ',', '.')).'
						</div>';
			}
			if(!empty($detail->qty_foreign_tourists)){
			$html.=     MultiLang('foreign_tourists').' (@ Rp '.(number_format($detail->price_foreign_tourists, 0, ',', '.')).' x '.$detail->qty_foreign_tourists.')
						<div class="mt-auto" style="color: #212529;">
							Rp '.(number_format(($detail->price_foreign_tourists * $detail->qty_foreign_tourists), 0, ',', '.')).'
						</div>';
			}
			$html.= '	</div>';
			$html.= '</div><hr>';

			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="total">'.MultiLang('total').'</label>';
			$html.=     '<div id="total">Rp '.(number_format($detail->total, 0, ',', '.')).'</div>';
			$html.= '</div><hr>';
			
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="contact_information">'.MultiLang('contact_information').'</label>';
			$html.=     '<div id="contact_information">
							<table>
								<tr>
									<td><b>'.MultiLang('name').'</b></td>
									<td> &nbsp;&nbsp;: '.$detail->contact_name.'</td>
								</tr>
								<tr>
									<td><b>'.MultiLang('email').'</b></td>
									<td> &nbsp;&nbsp;: '.$detail->contact_email.'</td>
								</tr>
								<tr>
									<td><b>'.MultiLang('phone').'</b></td>
									<td> &nbsp;&nbsp;: '.$detail->contact_phone.'</td>
								</tr>
							</table>
						</div>';
			$html.= '</div><hr>';
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="tourist_details">'.MultiLang('tourist_details').'</label>';
			$html.=     '<div id="tourist_details"> ';
			$html.=     	'<div class="table-responsive-sm">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="text-center">'.MultiLang('number').'</th>
										<th class="text-center">'.MultiLang('name').'</th>
										<th class="text-center">'.MultiLang('id_card_number').'</th>
										<th class="text-center">'.MultiLang('type').'</th>
									</tr>
								</thead>
								<tbody>';
							if(!empty($detail_tourist)){
								$no = 1;
								foreach ($detail_tourist as $key => $value) {
									if($value->type == 1){
										$type = MultiLang('local_tourists');
									}elseif($value->type == 2){
										$type = MultiLang('foreign_tourists');
									}
			$html.=				'<tr>
									<td class="text-center">'.$no.'</td>
									<td>'.$value->name.'</td>
									<td>'.$value->id_number.'</td>
									<td>'.$type.'</td>
								</tr>';
								$no++;
								}
							}
			$html.=				'</tbody>
							</table>
							</div>';
			$html.=     '</div>';
			$html.= '</div>';

			$data['html'] = $html;

		}elseif($type == 2){
			$data['html'] = '';
		}
        
        echo json_encode($data);
	}
	
	public function detail_data_transaction($id){

		$detail = $this->data->getDetailDataTransactionByUserId($id, $this->session->userdata('user_id'));
		
		$data['transaction_code'] = $detail->code;

		if($detail->type == 1){
			$data['redirect_page'] = 'tourpackages/pay/';
		}elseif($detail->type == 2){
			$data['redirect_page'] = 'ticket/pay/';
		}elseif($detail->type == 3){
			$data['redirect_page'] = 'venue/pay/';
		}else{
			$data['redirect_page'] = '';
		}

		if(!empty($detail) AND !empty($detail->midtrans_transaction_id)){
			$midtrans = $this->get_midtrans_transaction($detail->code);
			
			if(!empty($midtrans)){
				$respons_midtrans = json_decode($midtrans);
				$status = $this->get_midtrans_transaction_status($respons_midtrans);

				if($detail->status != $status){

					if($status=='1'){
						$status_text = MultiLang('waiting_for_payment');
						$status_color_class = 'badge badge-pill badge-warning';
					}elseif($status=='2'){
						$status_text = MultiLang('payment_successful');
						$status_color_class = 'badge badge-pill badge-success';
					}elseif($status=='3'){
						$status_text = MultiLang('expired_order');
						$status_color_class = 'badge badge-pill badge-danger';
					}elseif($status=='4'){
						$status_text = MultiLang('on_hold');
						$status_color_class = 'badge badge-pill badge-warning';
					}
					
					$is_change_text = '<span class="'.$status_color_class.'" style="font-size: 14px;">
								'.$status_text.'
							</span>';

					$data_update = array(
						'transaction_midtrans_transaction_id' => $respons_midtrans->transaction_id,
						'transaction_midtrans_response' => $midtrans,
						'transaction_payment_type' => $respons_midtrans->payment_type,
						'transaction_status' => $status,
						'update_user_id' => $this->session->userdata('user_id'),
						'update_datetime' => date('Y-m-d H:i:s')
					);
					$update_transaction_tourpackages = $this->data->updateTransaction($data_update, $id);

					$data['is_change'] = TRUE;
					$data['is_change_text'] = $is_change_text.' '.MultiLang('for_your_order_with_transaction_id').' '.$detail->code;
				}else{
					$data['is_change'] = FALSE;
					$data['is_change_text'] = '';
				}
			}else{
				$data['is_change'] = FALSE;
				$data['is_change_text'] = '';
			}
		}else{
			$data['is_change'] = FALSE;
			$data['is_change_text'] = '';
		}
		
		echo json_encode($data);
	}
	
	public function get_midtrans_transaction($code){
		$api_midtrans = $this->config->item('api_midtrans');
		$server_key = $this->config->item('server_key');
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $api_midtrans.'v2/'.$code.'/status',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
			  "Content-Type: application/json",
			  "Accept: application/json",
			  "Authorization: Basic ".base64_encode($server_key.":")
			),
		));
	
		$response = curl_exec($curl);
		$err = curl_error($curl);
	
		curl_close($curl);

		if ($err) {
			$data = '';
		}else{
			$data = $response;
		}
	
		return $data;
	}

	public function get_midtrans_transaction_status($notif){

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

		return $status;
	}

	public function testimony()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

		$token = $this->uri->segment('3');
		if(!empty($token)){
			$decode = JWT::decode($token,$this->config->item('secret_key'),array('HS256'));

			$data['token'] = $token;
			$data['user_id'] = $decode->user_id;
			
			//detail transaction tourpackages
			$data['transaction_tourpackages'] = $this->data->getTransactionTourpackagesByToken($token, $decode->user_id);
			if(!empty($data['transaction_tourpackages']->date_tour)){
				$data['transaction_tourpackages']->date_tour = $data['transaction_tourpackages']->date_tour;
				$data['transaction_tourpackages']->date_tour_formated = $this->data->getDateIndo($data['transaction_tourpackages']->date_tour);
			}

			if(empty($data['transaction_tourpackages']) OR (!empty($data['transaction_tourpackages']) AND $data['transaction_tourpackages']->is_process==1)){
				header('Location: '. base_url());
			}

			$this->load->view('testimony', $data);
		}else{
			header('Location: '. base_url());
		}

	}

	public function add_testimony(){
		$rating = $this->input->post('rating', TRUE);
		$testimony = $this->input->post('testimony', TRUE);
		$token = $this->input->post('token', TRUE);
		$user_id = $this->input->post('user_id', TRUE);

		$data_update = array(
			'tourpackagestesti_date' => date('Y-m-d H:i:s'),
			'tourpackagestesti_testimony' => $testimony,
			'tourpackagestesti_rating' => $rating,
			'tourpackagestesti_is_process' => 1
		);
		$result = $this->data->updateTestimony($data_update, $token, $user_id);

		if($result){
			$data['status'] = TRUE;
			$data['message'] = MultiLang('msg_testimony_success');
		}else{
			$data['status'] = FALSE;
			$data['message'] = MultiLang('msg_testimony_failed');
		}
		
		echo json_encode($data);
	}
	
}
