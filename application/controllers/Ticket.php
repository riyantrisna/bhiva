<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../vendor/autoload.php';
require APPPATH . '../vendor/veritrans/veritrans-php/Veritrans.php';
class Ticket extends CI_Controller {

	function __construct()
	{
		parent::__construct();

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

		$data['service_detail'] = $this->data->getServiceDetailTicket();
		$data['service_detail_image'] = $this->data->getServiceDetailImageTicket();

		$data['ticket'] = $this->data->getTicket();

		$this->load->view('ticket', $data);

	}	

	public function search_ticket(){

		$ticket = $this->input->post('ticket', TRUE);
		$visit_date = $this->input->post('visit_date', TRUE);
		
		$ticket_detail = $this->data->getTicketById($ticket);
		$type_visitor = $this->data->getVisitorType();
		$html = '
				<input type="hidden" name="ticket_id" value="'.$ticket.'" />
				<input type="hidden" name="visit_date" value="'.$visit_date.'" />
				<div class="col-md-12 col-sm-12 pt-3">
					<span id="info_max_min_order" style="color: #8f8f8f; font-weight: normal; font-style: italic; ">
						* '.MultiLang('min_order').' '.$ticket_detail->min_order.', '.MultiLang('max_order').' '.$ticket_detail->max_order.'
					</span>
				</div>
				<div class="col-md-6 col-sm-12 pt-3 pb-3">
					<div class="card">
						<div class="card-header">
							<b>'.$ticket_detail->name.'</b> ('.MultiLang('local_tourists').')
						</div>
						<ul class="list-group list-group-flush">
				';
							$local_tourists_begin_sub_total = 0;
							if(!empty($type_visitor) AND $ticket_detail->is_type == 1){
								foreach ($type_visitor as $key => $value) {
									$ticket_detail_price = $this->data->getSearchTicket($ticket_detail->id, $value->id, $visit_date);

									if($key == 0){
										$local_tourists_begin_sub_total = number_format($ticket_detail->min_order*$ticket_detail_price->price_local, 0, ',', '.');
									}
									
									if(!empty($ticket_detail_price)){
		$html.= '			<li class="list-group-item">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										'.($value->name).'
										(@ Rp '.(number_format($ticket_detail_price->price_local, 0, ',', '.')).')
										<br>
										<i class="fas fa-minus-circle" style="color: #8f8f8f; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="visitor_qty(\'#local_tourists'.$value->id.'\', \'min\', \''.$ticket_detail->min_order.'\', \''.$ticket_detail->max_order.'\',\''.number_format($ticket_detail_price->price_local, 0, ',', '').'\', \'#local_tourists_item_total'.$value->id.'\')"></i>

										<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="qty_input border-0 text-center" id="local_tourists'.$value->id.'" name="local_tourists['.$value->id.']" value="'.($key == 0 ? $ticket_detail->min_order : 0).'" onkeypress="return isNumber(event)" readonly/>

										<i class="fas fa-plus-circle" style="color: #42B549; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="visitor_qty(\'#local_tourists'.$value->id.'\', \'add\', \''.$ticket_detail->min_order.'\', \''.$ticket_detail->max_order.'\',\''.number_format($ticket_detail_price->price_local, 0, ',', '').'\', \'#local_tourists_item_total'.$value->id.'\')"></i>
									</div>
									<div class="col-md-6 col-sm-12 text-right">
										Rp <span class="lable_mask_item_local" id="local_tourists_item_total'.$value->id.'">'.($key == 0 ? number_format($ticket_detail->min_order*$ticket_detail_price->price_local, 0, ',', '.') : 0).'</span>
									</div>
								</div>
							</li>
				';
									}
								}
							}else{
							$ticket_detail_price = $this->data->getSearchTicket($ticket_detail->id, '', $visit_date);

							$local_tourists_begin_sub_total = number_format($ticket_detail->min_order*$ticket_detail_price->price_local, 0, ',', '.');

		$html.= '			<li class="list-group-item">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										@ Rp '.(number_format($ticket_detail_price->price_local, 0, ',', '.')).'
										&nbsp;&nbsp;
										<i class="fas fa-minus-circle" style="color: #8f8f8f; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="visitor_qty(\'#local_tourists\', \'min\', \''.$ticket_detail->min_order.'\', \''.$ticket_detail->max_order.'\',\''.number_format($ticket_detail_price->price_local, 0, ',', '').'\', \'#local_tourists_item_total\')"></i>

										<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="qty_input border-0 text-center" id="local_tourists" name="local_tourists[0]" value="'.$ticket_detail->min_order.'" onkeypress="return isNumber(event)" readonly/>

										<i class="fas fa-plus-circle" style="color: #42B549; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="visitor_qty(\'#local_tourists\', \'add\', \''.$ticket_detail->min_order.'\', \''.$ticket_detail->max_order.'\',\''.number_format($ticket_detail_price->price_local, 0, ',', '').'\', \'#local_tourists_item_total\')"></i>
									</div>
									<div class="col-md-6 col-sm-12 text-right">
										Rp <span class="lable_mask_item_local" id="local_tourists_item_total">'.(number_format($ticket_detail->min_order*$ticket_detail_price->price_local, 0, ',', '.')).'</span>
									</div>
								</div>
							</li>
				';
							}
		$html.= '		</ul>
						<div class="card-header text-right">
							<b>'.MultiLang('sub_total').' Rp <span class="lable_mask_subtotal" id="local_tourists_sub_total">'.$local_tourists_begin_sub_total.'</span></b>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-sm-12 pt-3 pb-3">
					<div class="card">
						<div class="card-header">
						<b>'.$ticket_detail->name.'</b> ('.MultiLang('foreign_tourists').')
						</div>
						<ul class="list-group list-group-flush">
				';
							if(!empty($type_visitor) AND $ticket_detail->is_type == 1){
								foreach ($type_visitor as $key => $value) {
									$ticket_detail_price = $this->data->getSearchTicket($ticket_detail->id, $value->id, $visit_date);
									if(!empty($ticket_detail_price)){
		$html.= '			<li class="list-group-item">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										'.$value->name.'
										(@ Rp '.(number_format($ticket_detail_price->price_foreign, 0, ',', '.')).')
										<br>
										<i class="fas fa-minus-circle" style="color: #8f8f8f; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="visitor_qty(\'#foreign_tourists'.$value->id.'\', \'min\', \''.$ticket_detail->min_order.'\', \''.$ticket_detail->max_order.'\',\''.number_format($ticket_detail_price->price_foreign, 0, ',', '').'\', \'#foreign_tourists_item_total'.$value->id.'\')"></i>

										<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="qty_input border-0 text-center" id="foreign_tourists'.$value->id.'" name="foreign_tourists['.$value->id.']" value="0" onkeypress="return isNumber(event)" readonly/>

										<i class="fas fa-plus-circle" style="color: #42B549; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="visitor_qty(\'#foreign_tourists'.$value->id.'\', \'add\', \''.$ticket_detail->min_order.'\', \''.$ticket_detail->max_order.'\',\''.number_format($ticket_detail_price->price_foreign, 0, ',', '').'\', \'#foreign_tourists_item_total'.$value->id.'\')"></i>
									</div>
									<div class="col-md-6 col-sm-12 text-right">
										Rp <span class="lable_mask_item_foreign" id="foreign_tourists_item_total'.$value->id.'">0</span>
									</div>
								</div>
							</li>
				';
									}
								}
							}else{
							$ticket_detail_price = $this->data->getSearchTicket($ticket_detail->id, '', $visit_date);
		$html.= '			<li class="list-group-item">
								<div class="row">
									<div class="col-md-6 col-sm-12">
										@ Rp '.(number_format($ticket_detail_price->price_foreign, 0, ',', '.')).'
										&nbsp;&nbsp;
										<i class="fas fa-minus-circle" style="color: #8f8f8f; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="visitor_qty(\'#foreign_tourists\', \'min\', \''.$ticket_detail->min_order.'\', \''.$ticket_detail->max_order.'\',\''.number_format($ticket_detail_price->price_foreign, 0, ',', '').'\', \'#foreign_tourists_item_total\')"></i>

										<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="qty_input border-0 text-center" id="foreign_tourists" name="foreign_tourists[0]" value="0" onkeypress="return isNumber(event)" readonly/>

										<i class="fas fa-plus-circle" style="color: #42B549; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="visitor_qty(\'#foreign_tourists\', \'add\', \''.$ticket_detail->min_order.'\', \''.$ticket_detail->max_order.'\',\''.number_format($ticket_detail_price->price_foreign, 0, ',', '').'\', \'#foreign_tourists_item_total\')"></i>
									</div>
									<div class="col-md-6 col-sm-12 text-right">
										Rp <span class="lable_mask_item_foreign" id="foreign_tourists_item_total">0</span>
									</div>
								</div>
							</li>
					';
								}
		$html.= '		</ul>
						<div class="card-header text-right">
							<b>'.MultiLang('sub_total').' Rp <span class="lable_mask_subtotal" id="foreign_tourists_sub_total">0</span></b>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 pt-3 pb-3">
					<div class="card">
						<div class="card-header text-right">
							<b>'.MultiLang('total').' Rp <span class="lable_mask_total" id="total_all">'.$local_tourists_begin_sub_total.'</span></b>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 mb-3 text-right">
					<div id="msg_btn_login" style="color: red;"></div>
					<button type="button" class="btn btn-warning col-md-4 col-sm-12 mt-2" style="width: 100%; font-weight: bold; padding: 10px;" onclick="book();">'.MultiLang('continue_to_payment').'</button>
				</div>

		';
		

		$data['html'] = $html;
        
        echo json_encode($data);
	}

	public function create_ticket(){

		if(!$this->session->userdata('user_id')){
			$data['is_session'] = FALSE ;
			echo json_encode($data);
		}else{
			$date = date('Y-m-d H:i:s');
        	$user_id = $this->session->userdata('user_id');
			$user_real_name = $this->session->userdata('user_real_name');

			$detail_user = $this->data->getUserByUserId($user_id);
			
        	$ticket_id = $this->input->post('ticket_id');
        	$visit_date = $this->input->post('visit_date');
        	$local_tourists = $this->input->post('local_tourists');
        	$foreign_tourists = $this->input->post('foreign_tourists');

			$ticket_detail = $this->data->getTicketById($ticket_id);

			$local_tourists_insert = array();
			if(!empty($local_tourists)){
				$i = 0;
				$sub_total_local = 0;
				foreach ($local_tourists as $key => $value) {
					if(!empty($value)){
						$type_id = ($ticket_detail->is_type) == 1 ? $key : NULL;
						$ticket_detail_price = $this->data->getSearchTicket($ticket_id, $type_id , $visit_date);
						$type_name = ($ticket_detail->is_type) == 1 ? $ticket_detail_price->type_visitor_name : NULL;

						$local_tourists_insert[$i]['ticket_id'] = $ticket_id;
						$local_tourists_insert[$i]['ticket_is_type'] = $ticket_detail->is_type;
						$local_tourists_insert[$i]['visitortype_id'] = $type_id;
						$local_tourists_insert[$i]['visitortype_name'] = $type_name;
						$local_tourists_insert[$i]['tourists_type'] = 1; // local
						$local_tourists_insert[$i]['qty'] = $value;
						$local_tourists_insert[$i]['price'] = $ticket_detail_price->price_local;
						$local_tourists_insert[$i]['sub_total'] = $value * $ticket_detail_price->price_local;

						$sub_total_local+= ($value * $ticket_detail_price->price_local);
						$i++;
					}
				}
			}

			$foreign_tourists_insert = array();
			if(!empty($foreign_tourists)){
				$i = 0;
				$sub_total_foreign = 0;
				foreach ($foreign_tourists as $key => $value) {
					if(!empty($value)){
						$type_id = ($ticket_detail->is_type) == 1 ? $key : NULL;
						$ticket_detail_price = $this->data->getSearchTicket($ticket_id, $type_id, $visit_date);
						$type_name = ($ticket_detail->is_type) == 1 ? $ticket_detail_price->type_visitor_name : NULL;

						$foreign_tourists_insert[$i]['ticket_id'] = $ticket_id;
						$foreign_tourists_insert[$i]['ticket_is_type'] = $ticket_detail->is_type;
						$foreign_tourists_insert[$i]['visitortype_id'] = $type_id;
						$foreign_tourists_insert[$i]['visitortype_name'] = $type_name;
						$foreign_tourists_insert[$i]['tourists_type'] = 2; // foreign
						$foreign_tourists_insert[$i]['qty'] = $value;
						$foreign_tourists_insert[$i]['price'] = $ticket_detail_price->price_foreign;
						$foreign_tourists_insert[$i]['sub_total'] = $value * $ticket_detail_price->price_foreign;

						$sub_total_foreign+= ($value * $ticket_detail_price->price_foreign);
						$i++;
					}
				}
			}

			$total = $sub_total_local + $sub_total_foreign;

			$data_insert = array(
				'transaction_code' => '',
				'transaction_date' => $date,
				'transaction_type' => 2, //ticket
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
				'detail_ticket' => array(
					'ticket_id' => $ticket_id,
					'visit_date' => $visit_date
				),
				'detail_ticket_local_tourist' => $local_tourists_insert,
				'detail_ticket_foreign_tourist' => $foreign_tourists_insert
				
			);

			$transaction_ticket = $this->data->createTransactionTicket($data_insert, $data_insert_detail);

			$update_transaction_ticket = FALSE;

			if($transaction_ticket['transaction_id'] > 0){
				//midtrans
				$order_id = $transaction_ticket['transaction_code'];

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
				if(!empty($local_tourists_insert)){
					foreach ($local_tourists_insert as $key => $value) {
						$item_details[] = array(
							'id' => $order_id.$value['visitortype_id'].'local',
							'price' => number_format($value['price'], 0, ',', ''),
							'quantity' => $value['qty'],
							'name' => MultiLang('local_tourists').' '.$value['visitortype_name']
						);
					}
				}

				if(!empty($foreign_tourists_insert)){
					foreach ($foreign_tourists_insert as $key => $value) {
						$item_details[] = array(
							'id' => $order_id.$value['visitortype_id'].'foreign',
							'price' => number_format($value['price'], 0, ',', ''),
							'quantity' => $value['qty'],
							'name' => MultiLang('foreign_tourists').' '.$value['visitortype_name']
						);
					}
				}

				// Optional
				$customer_details = array(
					'first_name'    => $detail_user->real_name,
					'last_name'     => "",
					'email'         => $detail_user->email,
					'phone'         => $detail_user->phone
				);
				// Fill transaction details
				$transaction = array(
					'transaction_details' => $transaction_details,
					'item_details' => $item_details,
					'customer_details' => $customer_details,
					'expiry' => $custom_expiry,
					'credit_card' => $credit_card_option,
					'callbacks' => ['finish' => $this->config->item('base_url').'user/transaction'],
					'gopay' => [
						'enable_callback' => true,						
						'callback_url' => $this->config->item('base_url').'user/transaction'
					],
					'enabled_payments' => $payment_channels

				);

				$snap_token = Veritrans_Snap::getSnapToken($transaction);

				$data_update = array(
					'transaction_midtrans_snap_token' => $snap_token,
					'update_user_id' => $user_id,
					'update_datetime' => $date
				);
				$update_transaction_ticket = $this->data->updateTransaction($data_update, $transaction_ticket['transaction_id']);
			}
			
			if($update_transaction_ticket){
				$data['transaction_code'] = $transaction_ticket['transaction_code'];
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
		//detail transaction ticket
		$data['transaction_ticket'] = $this->data->getTransactionTicket($transaction_code);
		if(!empty($data['transaction_ticket']->visit_date)){
			$data['transaction_ticket']->visit_date = $data['transaction_ticket']->visit_date;
			$data['transaction_ticket']->visit_date_formated = $this->data->getDateIndo($data['transaction_ticket']->visit_date);
		}

		$data['local'] = $this->data->getTransactionTicketDetail($data['transaction_ticket']->id, 1);
		$data['foreign'] = $this->data->getTransactionTicketDetail($data['transaction_ticket']->id, 2);

		if(!$this->session->userdata('user_id')){
			header('Location: '. base_url());
		}elseif($this->session->userdata('user_id') AND empty($data['transaction_ticket'])){
			header('Location: '. base_url().'user/transaction');
		}

		$this->load->view('ticket_pay', $data);

	}
	
}
