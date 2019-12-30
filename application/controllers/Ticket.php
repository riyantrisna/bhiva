<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
				<input type="hidden" name="is_type" value="'.$ticket_detail->is_type.'" />
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

										<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="qty_input border-0 text-center" id="local_tourists'.$value->id.'" name="local_tourists[]" value="'.($key == 0 ? $ticket_detail->min_order : 0).'" onkeypress="return isNumber(event)" readonly/>

										<input type="hidden" name="local_type_visitor[]" value="'.$value->id.'" />

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

										<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="qty_input border-0 text-center" id="local_tourists" name="local_tourists[]" value="'.$ticket_detail->min_order.'" onkeypress="return isNumber(event)" readonly/>

										<input type="hidden" name="local_type_visitor[]" value="" />

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

										<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="qty_input border-0 text-center" id="foreign_tourists'.$value->id.'" name="foreign_tourists[]" value="0" onkeypress="return isNumber(event)" readonly/>

										<input type="hidden" name="foreign_type_visitor[]" value="'.$value->id.'" />

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

										<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="qty_input border-0 text-center" id="foreign_tourists" name="foreign_tourists[]" value="0" onkeypress="return isNumber(event)" readonly/>

										<input type="hidden" name="foreign_type_visitor[]" value="" />

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
				<div class="col-md-12 col-sm-12 pt-3 pb-3 text-right">
					<div id="msg_btn_login" style="color: red;"></div>
					<button type="button" class="btn btn-warning col-md-4 col-sm-12 " style="width: 100%; font-weight: bold; padding: 10px;" onclick="book();">'.MultiLang('continue_to_payment').'</button>
				</div>

		';
		

		$data['html'] = $html;
        
        echo json_encode($data);
	}
	
}
