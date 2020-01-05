<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("data");
		if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
		}
	}

	public function index()
	{
		$data['components'] = 'components/transaction';
		$data['active_menu_parent'] = 'transaction';
        $data['active_menu'] = 'transaction';

		$this->load->view('home', $data);
	}
	
	public function data()
	{   
        $filter = array();
        $filter['number'] = $this->input->post('number');
        $filter['type'] = $this->input->post('type');
        $filter['status'] = $this->input->post('status');

        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1 => 'a.`transaction_code`',
            2 => 'a.`transaction_date`',
            3 => 'a.`transaction_type`',
            4 => 'a.`transaction_status`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllTransaction($filter);
        $count = $this->data->getTotalAllTransaction($filter);

        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->code;
                $row[] = (!empty($value->date) ? $this->data->getDatetimeIndo($value->date) : '');

                if($value->type=='1'){
                    $type = '<i class="fas fa-layer-group nav-icon"></i>&nbsp;&nbsp;'.MultiLang('tourpackages');
                }elseif($value->type=='2'){
                    $type = '<i class="fas fa-ticket-alt nav-icon"></i>&nbsp;&nbsp;'.MultiLang('ticket');
                }elseif($value->type=='3'){
                    $type = '<i class="fas fa-place-of-worship nav-icon"></i>&nbsp;&nbsp;'.MultiLang('venue');
                }else{
                    $type = '';
                }
                $row[] = $type;

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

                if($value->status=='2'){
                    if($value->status=='2' AND $value->status_ticket == '1'){
                        $status_ticket = MultiLang('waiting_release_ticket');
                        $status_ticket_color_class = 'badge badge-pill badge-warning';
                    }elseif($value->status=='2' AND $value->status_ticket == '2'){
                        $status_ticket = MultiLang('ticket_has_been_released');
                        $status_ticket_color_class = 'badge badge-pill badge-success';
                    }else{
                        $status_ticket = '';
                        $status_ticket_color_class = '';
                    }
    
                    $status_ticket =    '<br><span class="'.$status_ticket_color_class.'" style="font-size: 14px;">
                                                '.$status_ticket.'
                                        </span>';
                }else{
                    $status_ticket = '';
                }

                $row[] = '<span class="'.$status_color_class.'" style="font-size: 14px;">
                            '.$status.'
                          </span>'.$status_ticket;
    
                if($value->type=='2' AND $value->status=='2'){
                    $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->id.'\')"><i class="fas fa-search"></i></a>
                            <a class="btn btn-sm btn-warning" href="javascript:void(0)" title="'.MultiLang('send_ticket').'" onclick="send_ticket('."'".$value->id."'".')"><i class="fas fa-ticket-alt nav-icon"></i></a>';
                }else{
                    $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->id.'\')"><i class="fas fa-search"></i></a>';
                }
            
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $count->total,
            "recordsFiltered" => $count->total,
            "data" => $data,
        );
				
        echo json_encode($output);
    }

    public function detail($id){

        $type = $this->data->getDetailTransactionTypeById($id);
		if($type == 1){
			$detail = $this->data->getDetailTransactionTourpackagesByUserId($id);
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
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="transaction_date">'.MultiLang('user').'</label>';
			$html.=     '<div id="transaction_date">'.$detail->user_real_name.'</div>';
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
			$html.=     MultiLang('local_tourists').' (@ Rp '.(number_format($detail->price_local_tourists, 0, ',', '.')).' x '.$detail->qty_local_tourists.') = Rp '.(number_format(($detail->price_local_tourists * $detail->qty_local_tourists), 0, ',', '.')).'<br>';
			}
			if(!empty($detail->qty_foreign_tourists)){
			$html.=     MultiLang('foreign_tourists').' (@ Rp '.(number_format($detail->price_foreign_tourists, 0, ',', '.')).' x '.$detail->qty_foreign_tourists.') = Rp '.(number_format(($detail->price_foreign_tourists * $detail->qty_foreign_tourists), 0, ',', '.')).'<br>';
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
			$path_ticket_rilis = $this->config->item('path_ticket_rilis');
			$detail = $this->data->getDetailTransactionTicketByUserId($id);
			$local = $this->data->getTransactionTicketDetail($id, 1);
			$foreign = $this->data->getTransactionTicketDetail($id, 2);
		
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
			if($detail->status=='2'){
				if($detail->status=='2' AND $detail->status_ticket == '1'){
					$status = MultiLang('waiting_release_ticket');
					$status_color_class = 'badge badge-pill badge-warning';
					$download = '';
				}elseif($detail->status=='2' AND $detail->status_ticket == '2'){
					$status = MultiLang('ticket_has_been_released');
					$status_color_class = 'badge badge-pill badge-success';
					$download = !empty($detail->file) ? '<a class="btn btn-warning" href="'.$path_ticket_rilis.$detail->file.'" target="_blank"><i class="fas fa-file-download"></i> '.MultiLang('download_ticket').'</a>' : '';
				}else{
					$status = '';
					$status_color_class = '';
					$download = '';
				}

				$html.= '<div class="form-group">';
				$html.=     '<label style="font-weight: bold;" for="status">'.MultiLang('ticket_status').'</label>';
				$html.=     '<div id="status">
								<span class="'.$status_color_class.'" style="font-size: 14px;">
									'.$status.'
								</span>
								'.$download.'
							</div>';
				$html.= '</div><hr>';
			}

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
            $html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="transaction_date">'.MultiLang('user').'</label>';
			$html.=     '<div id="transaction_date">'.$detail->user_real_name.'</div>';
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
			$html.=     '<label style="font-weight: bold;" for="tourpackages">'.MultiLang('ticket').'</label>';
			$html.=     '<div id="tourpackages">'.$detail->ticket_name.'</div>';
			$html.= '</div><hr>';
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="visit_date">'.MultiLang('visit_date').'</label>';
			$html.=     '<div id="visit_date">'.(!empty($detail->visit_date) ? $this->data->getDateIndo($detail->visit_date) : '').'</div>';
			$html.= '</div><hr>';
			$html.= '<div class="form-group">';
			$html.=     '<label style="font-weight: bold;" for="price">'.MultiLang('price').'</label>';
			$html.=		'<div id="price">';
					if(!empty($local)){
						foreach($local AS $key => $value){
                            $visitortype_name = (!empty($value->visitortype_name) ? '('.$value->visitortype_name.')' : '');
					
			$html.=	'		'.MultiLang('local_tourists').' '.$visitortype_name.' (@ Rp '.number_format($value->price, 0, ',', '.').' x '. $value->qty.') = Rp  '.number_format(($value->price * $value->qty), 0, ',', '.').'<br>';
					
						}
					} 
					
					
					if(!empty($foreign)){
						foreach($foreign AS $key => $value){
                            $visitortype_name = (!empty($value->visitortype_name) ? '('.$value->visitortype_name.')' : '');
					
			$html.=	'		'.MultiLang('foreign_tourists').' '.$visitortype_name.' (@ Rp '.number_format($value->price, 0, ',', '.').' x '. $value->qty.') = Rp  '.number_format(($value->price * $value->qty), 0, ',', '.').'<br>';
					
						}
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
			$html.= '</div>';

			$data['html'] = $html;
		}
        
        echo json_encode($data);
    }

    public function send_ticket($id){
        $path_ticket_rilis = $this->config->item('path_ticket_rilis');
        $detail = $this->data->getDetailTransactionTicketByUserId($id);
        $detail_ticket_number = $this->data->getDetailTransactionTicketNumber($id);

        $html = '<div class="form-group">';
        $html.=     '<label for="transaction_id">'.MultiLang('transaction_id').'</label>';
        $html.=     '<input type="hidden" id="transaction_id" name="transaction_id" value="'.$detail->id.'">';
        $html.=     '<input type="hidden" id="ticket_id" name="ticket_id" value="'.$detail->ticket_id.'">';
        $html.=     '<input type="hidden" id="ticket_code" name="ticket_code" value="'.$detail->code.'">';
        $html.=     '<div id="transaction_id">';
        $html.=     $detail->code;
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="ticket_name">'.MultiLang('ticket').'</label>';      
        $html.=     '<div id="ticket_name">';
        $html.=     $detail->ticket_name;
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="ticket_file">'.MultiLang('ticket_file').'</label>';      
        $html.=     '<div id="ticket_file">';
        $html.=         '<label id="ticket_file_lable" for="file_ticket" style="width: 200px !important;" class="file-upload btn btn-primary btn-block rounded-pill shadow"><i class="fa fa-upload mr-2"></i>'.MultiLang('choose_file').'
                            <input id="file_ticket" name="file_ticket" type="file" onchange="upload_file_ticket()">
                        </label>';
        $html.=         '<div id="result_ticket_file">';
        if(!empty($detail->file)){
        $html.=             '<a href="'.$path_ticket_rilis. $detail->file.'" target="_blank">'.$detail->file.'</a>';
        }
        $html.=         '</div>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="ticket_status_lable">'.MultiLang('ticket_status').'</label>';      
        $html.=     '<div id="ticket_status_lable">';
        $html.=     '<select name="ticket_status" id="ticket_status" onchange="status_ticket()" class="form-control" style="width: 250px !important;">
                        <option value="">
                            -- '. MultiLang('select') .' --
                        </option>
                        <option value="1" '.($detail->status_ticket==1 ? 'selected' : '').'>
                            '. MultiLang('waiting_release_ticket') .'
                        </option>
                        <option value="2" '.($detail->status_ticket==2 ? 'selected' : '').'>
                            '. MultiLang('ticket_has_been_released') .'
                        </option>
                    </select>';
        $html.=         '<div id="result_ticket_status">';
        $html.=         '</div>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<hr>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="number_ticket_list">'.MultiLang('number_ticket_list').'</label>';      
        $html.=     '<div id="number_ticket_list">';
        $html.=         '<div class="d-flex">';
        $html.=             '<input type="text" class="form-control col-md-9 col-sm-12" id="input_ticket_number" name="input_ticket_number">';
        $html.=             '&nbsp;&nbsp;<button type="button" class="btn btn-success col-md-3 col-sm-12" onclick="add_ticket_number()">'.MultiLang('add').'</button>';
        $html.=         '</div>';
        $html.=         '<div id="result_ticket_number" class="col-md-12 col-sm-12 mb-4">';
        $html.=         '</div>';
        if(!empty($detail_ticket_number)){
            $no = 1;
        $html.=         '<table class="table table-bordered"  id="table_number_ticket">';
            foreach($detail_ticket_number AS $key => $value){
        $html.=             '<tr>';
        $html.=                 '<td>';
        $html.=                     $value->ticket_number;
        $html.=                 '</td>';
        $html.=                 '<td class="text-center">';
        $html.=                     '<button type="button" class="btn btn-danger" onclick="delete_ticket_number(this, \''.$value->ticket_number.'\')"><i class="fas fa-trash-alt"></i></button>';
        $html.=                 '</td>';
        $html.=             '</tr>';
            $no++;
            }
        $html.=         '</table>';
        }else{
        $html.=         '<table class="table table-bordered"  id="table_number_ticket">';
        $html.=         '<tr id="tr_no_data"><td class="text-center"><i>-- '.MultiLang('empty_data').' --</i></td></tr>';
        $html.=         '</table>';
        }
        $html.=     '</div>';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function upload_file_ticket()
    {
        $path_ticket_rilis = $this->config->item('path_ticket_rilis');
        $path_ticket_rilis_upload = $this->config->item('path_ticket_rilis_upload');

        $ticket_code = $this->input->post('ticket_code', TRUE);
        $transaction_id = $this->input->post('transaction_id', TRUE);

        $file_ticket = $_FILES['file_ticket'];
        $target_file = $path_ticket_rilis_upload . basename($file_ticket["name"]);
        $file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $file_ticket_upload = $path_ticket_rilis_upload . 'ticket_'.$ticket_code. '.' . $file_type;
        
        $status_upload = TRUE;
        $msg_upload = '';
        $file_download = '';
        if($file_ticket['size'] > $this->config->item('max_upload_file')){
            $status_upload = FALSE && $status_upload ;
            $msg_upload.=  '<div style="color: red;">'.MultiLang('max_file_is').' '.MultiLang('max_upload_file_lable').'</div>';
        }
        if($status_upload){
            if (move_uploaded_file($file_ticket["tmp_name"], $file_ticket_upload)) {
                $msg_upload.= '<div style="color: green;">'.MultiLang('success_upload').'</div>';
                $file_download = '<a href="'.$path_ticket_rilis.'ticket_'.$ticket_code. '.' . $file_type.'" target="_blank">ticket_'.$ticket_code. '.' . $file_type.'</a>';

                $data_update = array(
                    'transactionticket_file' => 'ticket_'.$ticket_code. '.' . $file_type
                );
                $status_update =  $this->data->updateTransactionTicket($data_update, $transaction_id);

                if(!$status_update){
                    $status_upload = FALSE && $status_upload ;
                    $msg_upload.= '<div style="color: red;">'.MultiLang('failed_upload').'</div>';
                }

            } else {
                $status_upload = FALSE && $status_upload ;
                $msg_upload.= '<div style="color: red;">'.MultiLang('failed_upload').'</div>';
            }
        }

        $data['status_upload'] = $status_upload;
        $data['msg'] = $msg_upload;
        $data['file_download'] = $file_download;
        
        echo json_encode($data);
    }

    public function update_status_ticket()
    {

        $status = $this->input->post('status', TRUE);
        $transaction_id = $this->input->post('transaction_id', TRUE);

        $data_update = array(
            'transactionticket_status' => $status
        );
        $status_update =  $this->data->updateTransactionTicket($data_update, $transaction_id);

        $msg_update = '';

        if($status_update){
            $msg_update.= '<div style="color: green;">'.MultiLang('msg_update_success').'</div>';
        }else{
            $msg_update.= '<div style="color: red;">'.MultiLang('msg_update_failed').'</div>';
        }

        $data['msg'] = $msg_update;
        
        echo json_encode($data);
    }

    public function add_number_ticket()
    {

        $number = $this->input->post('number', TRUE);
        $transaction_id = $this->input->post('transaction_id', TRUE);
        $ticket_id = $this->input->post('ticket_id', TRUE);

        $status_add = TRUE;
        if(!empty($number)){

            $check_number = $this->data->checkTransactionTicketNumber($number);

            if(empty($check_number)){
                $data_insert = array(
                    'transactionticketnum_transaction_id' => $transaction_id,
                    'transactionticketnum_ticket_id' => $ticket_id,
                    'transactionticketnum_ticket_number' => $number,
                    'insert_user_id' => $this->session->userdata('user_id'),
                    'insert_datetime' => date('Y-m-d H:i:s')
                );
                $status_add = $status_add && $this->data->addTransactionTicketNumber($data_insert, $transaction_id);

                if($status_add){
                    $msg_add = '<div style="color: green;">'.MultiLang('msg_add_success').'</div>';
                }else{
                    $msg_add = '<div style="color: red;">'.MultiLang('msg_add_failed').'</div>';
                }
            }else{
                $status_add = FALSE;
                $msg_add = '<div style="color: red;">'.MultiLang('number_ticket').' '.MultiLang('existed').'</div>';
            }
        }else{
            $status_add = FALSE;
            $msg_add = '<div style="color: red;">'.MultiLang('number_ticket').' '.MultiLang('required').'</div>';
        }  

        $data['status_add'] = $status_add;
        $data['msg'] = $msg_add;
        
        echo json_encode($data);
    }

    public function delete_number_ticket()
    {

        $id = $this->input->post('transaction_id', TRUE);
        $number = $this->input->post('number', TRUE);

        $status_delete = TRUE;
        if(!empty($number)){
            $status_delete = $status_delete && $this->data->deleteTransactionTicketNumber($number);

            if($status_delete){
                $msg_add = '<div style="color: green;">'.MultiLang('msg_delete_success').'</div>';
            }else{
                $msg_add = '<div style="color: red;">'.MultiLang('msg_delete__failed').'</div>';
            }
        }else{
            $status_delete = FALSE;
            $msg_add = '<div style="color: red;">'.MultiLang('number_ticket').' '.MultiLang('required').'</div>';
        }  

        $detail_ticket_number = $this->data->getDetailTransactionTicketNumber($id);

        if(empty($detail_ticket_number)){
            $data['tr_content'] = '<tr id="tr_no_data"><td class="text-center"><i>-- '.MultiLang('empty_data').' --</i></td></tr>';
        }else{
            $data['tr_content'] = '';
        }

        $data['status_delete'] = $status_delete;
        $data['msg'] = $msg_add;
        
        echo json_encode($data);
    }

    public function send_mail(){

        $ticket_code = $this->input->post('ticket_code', TRUE);
        $status_email = FALSE;

        if(!empty($ticket_code)){
            $detail_transaction = $this->data->getDetailTransactionByCode($ticket_code);

            $send_schedule = date('Y-m-d');
            $data['NAMA_USER'] = $detail_transaction->contact_name;
            $data['TRANSACTION_ID'] = $detail_transaction->code;
            $data['LINK'] = $this->config->item('base_url_image').'user/transaction';
            $status_email = $this->data->addEmailSend('release_ticket', $detail_transaction->contact_email, NULL, $send_schedule, $data);
        }

        if($status_email){
            $data['status'] = TRUE;
            $data['message'] = MultiLang('msg_send_email_success');
        }else{
            $data['status'] = FALSE;
            $data['message'] = MultiLang('msg_send_email_failed');
        }
        echo json_encode($data);
    }


    // public function edit()
    // {
    //     $id = $this->input->post('id', TRUE);
    //     $language = $this->input->post('language', TRUE);
    //     $transaction = $this->input->post('transaction', TRUE);
    //     $transaction_name = $this->input->post('transaction_name', TRUE);
    //     $date = date('Y-m-d H:i:s');
    //     $user_id = $this->session->userdata('user_id');
        
    //     $validation = true;
    //     $validation_text = '';

    //     if(!empty($transaction)){
    //         foreach ($transaction as $key => $value) {
    //             if(empty($value)){
    //                 $validation = $validation && false;
    //                 $validation_text.= '<li>'.MultiLang('name').' '.$transaction_name[$key].' '.MultiLang('required').'</li>';
    //             }
    //         }
    //     }

    //     if($validation){
    //         $results = true;

    //         $data = array(
    //             'update_user_id' => $user_id,
    //             'update_datetime' => $date
    //         );
    //         $results = $results && $this->data->updateTransaction($data, $id, $transaction, $user_id, $date);
        
    //         if ($results) {
    //             $result["status"] = TRUE;
    //             $result["message"] = MultiLang('msg_update_success');
    //         } else {
    //             $result["status"] = FALSE;
    //             $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    //             $result["message"].= '<li>'.MultiLang('msg_update_failed').'</li>';
    //             $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                     <span aria-hidden="true">&times;</span>
    //                 </button>';
    //             $result["message"].= '</div>';
    //         }

    //     }else{
    //         $result["status"] = FALSE;
    //         $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    //         $result["message"].= $validation_text;
    //         $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                         <span aria-hidden="true">&times;</span>
    //                     </button>';
    //         $result["message"].= '</div>';
    //     }

    //     echo json_encode($result);
        
    // }
}
