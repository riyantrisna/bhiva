<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../vendor/autoload.php';
require APPPATH . '../vendor/veritrans/veritrans-php/Veritrans.php';
use \Firebase\JWT\JWT;

class Tourpackages extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();

		$this->load->model('data');
	}

	public function index()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

		$data['service_detail'] = $this->data->getServiceDetailBanner(1); // 1 adalah type untuk paket wisata
		$data['service_detail_image'] = $this->data->getServiceDetailImageBanner(1); // 1 adalah type untuk paket wisata
		$data['combo_time'] = $this->data->getTimeDayNight(); 
		$data['combo_destination'] = $this->data->getDestinationAll(); 

		$data['tourpackages_begin'] = $this->data->getTourpackagesBegin();
		$data['tourpackages_begin_total'] = $this->data->getTotalTourpackagesBegin();

		$this->load->view('tourpackages', $data);

	}	

	public function view()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

		$id = $this->uri->segment('3');
		$data['tourpackages_id'] = $id;
		$data['tourpackages_detail'] = $this->data->getTourpackagesDetailByDate($id, date('Y-m-d', strtotime(date('Y-m-d').' + 1 day')));
		$data['tourpackages_detail_image'] = $this->data->getTourpackagesDetailImage($id);
		$data['tourpackages_testimony'] = $this->data->getTourpackagesTestimony($id, 0, 2);
		$data['tourpackages_testimony_total'] = $this->data->getTourpackagesTestimonyTotal($id);
		$data['tourpackages_destination_days'] = $this->data->getTourpackagesDestinationDays($id);

		$this->load->view('tourpackages_view', $data);

	}	

	public function add()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

	
		$id = $this->uri->segment('3');
		$date_tour = $this->uri->segment('5');
		$total_local = $this->uri->segment('6');
		$total_foreign = $this->uri->segment('7');
		$data['tourpackages_id'] = $id;

		$data['tourpackages_detail'] = $this->data->getTourpackagesDetailByDate($id, $date_tour);
		$data['tourpackages_detail_image'] = $this->data->getTourpackagesDetailImage($id);
		if(!empty($date_tour)){
			$data['tourpackages_detail']->date_tour = $date_tour;
			$data['tourpackages_detail']->date_tour_formated = $this->data->getDateIndo($date_tour);
		}
		$data['tourpackages_detail']->total_local = $total_local;
		$data['tourpackages_detail']->total_foreign = $total_foreign;

		//profile
		$data['user'] = $this->data->getUserByUserId($this->session->userdata('user_id'));

		$total_max_order = $data['tourpackages_detail']->max_order;
		$total_order = $total_local + $total_foreign;

		if(strtotime($date_tour) < strtotime(date('Y-m-d').' + 1 days ') OR ($total_order > $total_max_order) OR !$this->session->userdata('user_id')){
			header('Location: '. base_url().'tourpackages/view/'.$id.'/'.(preg_replace("/\W|_/","-",$data['tourpackages_detail']->name)));
		}

		$this->load->view('tourpackages_add', $data);

	}

	public function getTourpackagesDestination($id, $day)
	{
		$data = $this->data->getTourpackagesDestination($id, $day);

		return $data;
	}	

	public function filter_tourpackages(){

		$filter['orderby'] = $this->input->post('orderby', TRUE);
		$filter['destination'] = $this->input->post('destination', TRUE);
		$filter['price_min'] = str_replace('.','', $this->input->post('price_min', TRUE));
		$filter['price_max'] = str_replace('.','', $this->input->post('price_max', TRUE));
		$filter['time'] = $this->input->post('time', TRUE);
		$filter['rating'] = $this->input->post('rating', TRUE);
		$page = $this->input->post('page', TRUE);
		$limit = $this->input->post('limit', TRUE);
		$tourpackages_total = $this->data->getTotalTourpackagesFilter($filter);		
		$tourpackages = $this->data->getTourpackagesFilter($filter, $page, $limit);		
		
		$html = '';
		if(!empty($tourpackages)){
			foreach ($tourpackages as $key => $value) {
				
				$html.= '<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
							<a href="'.base_url().'tourpackages/view/'.$value->id.'/'.(preg_replace("/\W|_/","-",$value->name)).'" class="" style="text-decoration: none;">
								<div class="card h-100">
									<div class="img-hover-zoom img-hover-zoom--brightness card-img-top" style="border-radius: 0;">
										<img class="img-fluid" src="'.base_url().$value->img.'" alt="'.$value->name.'">
									</div>
									<div class="card-body">
										<span class="card-title centered-text-img-packages">'.$value->name.'</span>
										<p class="card-text" style="color: #212529;">
											('.$value->total_day.' '.MultiLang('day').' '.$value->total_night.' '.MultiLang('night').')
										</p>
										
									</div>
									<div class="card-footer">
										<span class="card-title mt-auto" style="color: #212529; font-weight: bold;">
											Rp'. number_format($value->price_local, 0, ',', '.').'
										</span>
										<span class="float-right" style="color: #212529; font-weight: bold;">
											<i class="fas fa-star" style="color:#FFD31C"></i> '. number_format($value->rating, 1, ',', '.') .'
										</span>
									</div>
								</div>
							</a>
						</div>';
				
			}

			if(count($tourpackages) >= 15 AND $page < $tourpackages_total){
				$html.= '<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more" onclick="load_more('.($page+15).', 15)">'.MultiLang('load_more').'</button>
						</div>';
			}
			$data['total_data'] = count($tourpackages);
		}else{
			$html.= '<div class="col-12 text-center"><i>-- '.MultiLang('tour_packages_not_found').' --</i></div>';
			$data['total_data'] = 0;
		}

		$data['html'] = $html;
        
        echo json_encode($data);
	}
	
	public function show_price(){

		$filter['id'] = $this->input->post('id', TRUE);
		$filter['date_tour'] = $this->input->post('date_tour', TRUE);
		$tourpackages = $this->data->getDetailTourpackagesPrice($filter);

		$data = array(
			'price_local' => number_format($tourpackages->price_local, 0, ',', '.'),
			'price_foreign' => number_format($tourpackages->price_foreign, 0, ',', '.')
		);
        
        echo json_encode($data);
	}

	public function load_more()
	{
		$id = $this->input->post('id', TRUE);
		$page = $this->input->post('page', TRUE);
		$limit = $this->input->post('limit', TRUE);

		$tourpackages_testimony = $this->data->getTourpackagesTestimony($id, $page, $limit);
		$html = '';
		if(!empty($tourpackages_testimony)){
			foreach ($tourpackages_testimony as $key => $value) {
				
				$html.= ' <div class="col-md-6 col-sm-12 mt-3 h-100 text-center">';
				$html.= ' 	<img class="rounded-circle" style="width: 80px; height: 80px;" src="'.base_url().$value->user_photo.'" alt="'.$value->user_real_name.'">';
				$html.= '	<div style="font-size: 16px; font-weight: bold;">'.$value->user_real_name.'</div>';
				$html.= '	<p class="text-center" style="font-size: 14px; color: #8f8f8f !important;">';
				$html.=  		$value->testimony;
				$html.= '	</p>';
				$html.= '</div>';
			}

			if(count($tourpackages_testimony) >= 2 ){
				$html.= '<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more" onclick="load_more('.$id.','.($page+2).', 2)">'.MultiLang('load_more').'</button>
						</div>';
			}

		}

		$data['html'] = $html;
        
        echo json_encode($data);
	}

	public function create_tourpackages(){

		if(!$this->session->userdata('user_id')){
			$data['is_session'] = FALSE ;
			echo json_encode($data);
		}else{
			$secret_key = $this->config->item('secret_key');

			$dates = new DateTime();
			$payload['user_id'] = $this->session->userdata('user_id');
			$payload['user_real_name'] = $this->session->userdata('user_real_name');
			$payload['iat'] = $dates->getTimestamp(); //waktu di buat
			$token_testimony = JWT::encode($payload, $secret_key);

			//$number = $this->data->generateCode('PW');
			$date = date('Y-m-d H:i:s');
        	$user_id = $this->session->userdata('user_id');
        	$user_real_name = $this->session->userdata('user_real_name');

			$tourpackages_id = $this->input->post('id', TRUE);
			$date_tour = $this->input->post('date_tour', TRUE);
			$total_local = $this->input->post('total_local', TRUE);
			$total_foreign = $this->input->post('total_foreign', TRUE);
			$contact_name = $this->input->post('contact_name', TRUE);
			$contact_email = $this->input->post('contact_email', TRUE);
			$contact_phone = $this->input->post('contact_phone', TRUE);
			$local_tourists_name = $this->input->post('local_tourists_name', TRUE);
			$local_tourists_identity = $this->input->post('local_tourists_identity', TRUE);
			$foreign_tourists_name = $this->input->post('foreign_tourists_name', TRUE);
			$foreign_tourists_identity = $this->input->post('foreign_tourists_identity', TRUE);

			$tourpackages_detail = $this->data->getTourpackagesDetailByDate($tourpackages_id, $date_tour);

			$total = number_format((($tourpackages_detail->price_local * $total_local)+($tourpackages_detail->price_foreign * $total_foreign)), 0, ',', '');

			$local_tourists = array();
			if(!empty($local_tourists_name) AND !empty($local_tourists_identity)){
				foreach ($local_tourists_name as $key => $value) {
					$local_tourists[$key]['name'] = $value;
					$local_tourists[$key]['id_number'] = $local_tourists_identity[$key];
					$local_tourists[$key]['type'] = 1;
				}
			}
			
			$foreign_tourists = array();
			if(!empty($foreign_tourists_name) AND !empty($foreign_tourists_identity)){
				foreach ($foreign_tourists_name as $key => $value) {
					$foreign_tourists[$key]['name'] = $value;
					$foreign_tourists[$key]['id_number'] = $foreign_tourists_identity[$key];
					$foreign_tourists[$key]['type'] = 2;
				}
			}

			$data_insert = array(
				'transaction_code' => '',
				'transaction_date' => $date,
				'transaction_type' => 1, //paket wisata
				'transaction_user_id' => $user_id,
				'transaction_user_real_name' => $user_real_name,
				'transaction_total' => $total,
				'transaction_midtrans_snap_token' => NULL,
				'transaction_midtrans_transaction_id' => NULL,
				'transaction_midtrans_response' => NULL,
				'transaction_payment_type' => NULL,
				'transaction_status' => 1,
				'insert_user_id' => $user_id,
				'insert_datetime' => $date

			);

			$data_insert_detail = array(
				'detail_tourpackages' => array(
					'contact_name' => $contact_name,
					'contact_email' => $contact_email,
					'contact_phone' => $contact_phone,
					'tourpackages_id' => $tourpackages_id,
					'total_day' => $tourpackages_detail->total_day,
					'total_night' => $tourpackages_detail->total_night,
					'date_tour' => $date_tour,
					'total_local' => $total_local,
					'total_foreign' => $total_foreign,
					'price_local_tourists' => $tourpackages_detail->price_local,
					'price_foreign_tourists' => $tourpackages_detail->price_foreign,
					'total_local_tourists' => number_format(($tourpackages_detail->price_local * $total_local), 0, ',', ''),
					'total_foreign_tourists' => number_format(($tourpackages_detail->price_foreign * $total_foreign), 0, ',', '')
				),
				'detail_tourpackages_local_tourist' => $local_tourists,
				'detail_tourpackages_foreign_tourist' => $foreign_tourists,
				'detail_tourpackages_testimony' => array(
					'tourpackages_id' => $tourpackages_id,
					'user_id' => $user_id,
					'user_real_name' => $user_real_name,
					'date' => $date,
					'testimony' => NULL,
					'rating' => 0,
					'token' => $token_testimony,
					'is_process' => 0,
					'is_publish' => 0,
					'insert_user_id' => $user_id,
					'insert_datetime' => $date
				)
			);

			$transaction_tourpackages = $this->data->createTransactionTourpackages($data_insert, $data_insert_detail);

			$update_transaction_tourpackages = FALSE;

			if($transaction_tourpackages['transaction_id'] > 0){
				//midtrans
				$order_id = $transaction_tourpackages['transaction_code'];

				$payment_channels = !empty($this->config->item('payment_channels')) ? $this->config->item('payment_channels') : ["credit_card"];

				// Send this options if you use 3Ds in credit card request
				$credit_card_option = [
					'secure' => true, 
					'channel' => 'migs'
				];
		
				//Set Your server key
				Veritrans_Config::$serverKey = $this->config->item('server_key');
				// Uncomment for production environment
				if($this->config->item('is_production')){
					Veritrans_Config::$isProduction = true;
				}
				// Enable sanitization
				Veritrans_Config::$isSanitized = true;
				// Enable 3D-Secure
				Veritrans_Config::$is3ds = true;

				$custom_expiry = [ 
					'start_time' => date("Y-m-d H:i:s O", time()),
					'unit' => 'hour',
					'duration' => empty($this->config->item('payment_duration')) ? $this->config->item('payment_duration') : 1
				];

				$transaction_details = array(
					'order_id' => $order_id,
					'gross_amount' => $total, // no decimal allowed
				);

				// Mandatory for Mandiri bill payment and BCA KlikPay
				// Optional for other payment methods
				if(!empty($total_local)){
					$item1_details = array(
						'id' => $order_id.'local',
						'price' => number_format($tourpackages_detail->price_local, 0, ',', ''),
						'quantity' => $total_local,
						'name' => MultiLang('local_tourists')
					);
				}

				if(!empty($total_foreign)){
					// Optional
					$item2_details = array(
						'id' => $order_id.'foreign',
						'price' => number_format($tourpackages_detail->price_foreign, 0, ',', ''),
						'quantity' => $total_foreign,
						'name' => MultiLang('foreign_tourists')
					);
				}

				if(!empty($total_local) AND !empty($total_foreign)){
					$item_details = array ($item1_details, $item2_details);
				}elseif(!empty($total_local) AND empty($total_foreign)){
					$item_details = array ($item1_details);
				}elseif(empty($total_local) AND !empty($total_foreign)){
					$item_details = array ($item2_details);
				}

				// Optional
				$customer_details = array(
					'first_name'    => $contact_name,
					'last_name'     => "",
					'email'         => $contact_email,
					'phone'         => $contact_phone
				);
				// Fill transaction details
				$transaction = array(
					'transaction_details' => $transaction_details,
					'item_details' => $item_details,
					'customer_details' => $customer_details,
					'expiry' => $custom_expiry,
					'credit_card' => $credit_card_option,
					// 'callbacks' => ['finish' => $this->config->item('host').'api/midtransstatus?order_id='.$order_id],
					// 'gopay' => [
					// 	'enable_callback' => true,						
					// 	'callback_url' => $this->config->item('host').'api/midtransstatus?order_id='.$order_id
					// ],
					'enabled_payments' => $payment_channels

				);

				$snap_token = Veritrans_Snap::getSnapToken($transaction);

				$data_update = array(
					'transaction_midtrans_snap_token' => $snap_token,
					'update_user_id' => $user_id,
					'update_datetime' => $date
				);
				$update_transaction_tourpackages = $this->data->updateTransaction($data_update, $transaction_tourpackages['transaction_id']);
			}
			
			if($update_transaction_tourpackages){
				$data['transaction_code'] = $transaction_tourpackages['transaction_code'];
				$data['transaction_status'] = TRUE;
				$data['is_session'] = TRUE;
			}else{
				$data['transaction_status'] = FALSE;
				$data['is_session'] = TRUE;
			}

			echo json_encode($data);

		}
	}

	public function pay()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

		$transaction_code = $this->uri->segment('3');
		//detail transaction tourpackages
		$data['transaction_tourpackages'] = $this->data->getTransactionTourpackages($transaction_code);
		if(!empty($data['transaction_tourpackages']->date_tour)){
			$data['transaction_tourpackages']->date_tour = $data['transaction_tourpackages']->date_tour;
			$data['transaction_tourpackages']->date_tour_formated = $this->data->getDateIndo($data['transaction_tourpackages']->date_tour);
		}

		if(empty($data['transaction_tourpackages'])){
			header('Location: '. base_url());
		}

		if(!$this->session->userdata('user_id') AND !empty($data['transaction_tourpackages'])){
			header('Location: '. base_url().'tourpackages/view/'.$data['transaction_tourpackages']->tourpackages_id.'/'.(preg_replace("/\W|_/","-",$data['transaction_tourpackages']->tourpackages_name)));
		}

		$this->load->view('tourpackages_pay', $data);

	}
	
}
