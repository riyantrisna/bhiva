<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {

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
		$data['components'] = 'components/ticket';
		$data['active_menu_parent'] = 'master_data';
        $data['active_menu'] = 'ticket';
        $data['visitortype'] = $this->data->getPersontype();
        $data['visitortype'] = json_encode($data['visitortype']);

		$this->load->view('home', $data);
	}
	
	public function data()
	{   
		$filter = array();
        $filter['keyword'] = $_POST['search']['value'];
        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1 => 'b.`tickettext_name`',
            2 => 'a.`ticket_is_type_visitor`',
            3 => 'a.`ticket_status`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllTicket($filter);
        $count = $this->data->getTotalAllTicket($filter);
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->name;
                $row[] = ($value->is_type_visitor == 1) ? MultiLang('yes') : MultiLang('no');
                $row[] = ($value->status == 1) ? MultiLang('active') : MultiLang('not_active');
    
                //add html for action
                $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->id.'\')"><i class="fas fa-search"></i></a>
                        <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="'.MultiLang('edit').'" onclick="edit('."'".$value->id."'".')"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="'.MultiLang('delete').'" onclick="deletes('."'".$value->id."','".$value->name."'".')"><i class="fas fa-trash-alt"></i></a>';
            
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
    
    public function add_view(){

        $lang = $this->data->getLang();
        $path_language = $this->config->item('path_language');
        $visitortype = $this->data->getPersontype();

        $html = '<div class="form-group">';
        $html.=     '<label for="name">'.MultiLang('name').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;*';
        $html.=     '<input type="text" id="name_<?php echo $value->code;?>" name="name['.$value->code.']" class="form-control">';
        $html.=     '<input type="hidden" id="name_name_<?php echo $value->code;?>" name="name_name['.$value->code.']" value="'.$value->name.'" >';
        $html.=     '<br>';
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_type_visitor">'.MultiLang('is_type_visitor').'?</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_type_visitor" id="is_type_visitor">
                        <label class="form-check-label" for="is_type_visitor">
                        '.MultiLang('yes').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_local">'.MultiLang('default_price_local').'</label>';
        $html.=     '<br>';
        $html.=     '<div id="div_base_price_local1">';
        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
        $html.=     $value->name.' (Rp) *';
        $html.=     '<input type="text" id="base_price_local_'.$value->id.'" name="base_price_local['.$value->id.']" class="form-control curr">';
        $html.=     '<input type="hidden" id="base_price_local_name_'.$value->id.'" name="base_price_local_name['.$value->id.']" value="'.$value->name.'" >';
        $html.=     '<br>';
            }
        }
        $html.=     '</div>';
        $html.=     '<div id="div_base_price_local2">';
        $html.=         '<input type="text" id="base_price_local2" name="base_price_local2" class="form-control curr">';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_foreign">'.MultiLang('default_price_foreign').'</label>';
        $html.=     '<br>';
        $html.=     '<div id="div_base_price_foreign1">';
        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
        $html.=     $value->name.' (Rp) *';
        $html.=     '<input type="text" id="base_price_foreign_'.$value->id.'" name="base_price_foreign['.$value->id.']" class="form-control curr">';
        $html.=     '<input type="hidden" id="base_price_foreign_name_'.$value->id.'" name="base_price_foreign_name['.$value->id.']" value="'.$value->name.'" >';
        $html.=     '<br>';
            }
        }
        $html.= '   </div>';
        $html.=     '<div id="div_base_price_foreign2">';
        $html.=         '<input type="text" id="base_price_foreign2" name="base_price_foreign2" class="form-control curr">';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="price_period">'.MultiLang('price_period').'</label>';
        $html.=     '<div>';
        $html.=         '<table class="table table-bordered" id="table_price">
                            <tr>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('start').'
                                </td>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('end').'
                                </td>
                                <td class="visitor_type_col" style="width: 130px; text-align: center;">
                                    '.MultiLang('visitor_type').'
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('local_tourist_price').'<br>(Rp)
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('foreign_tourist_price').'<br>(Rp)
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('action').'
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="start[]" class="form-control calendar" placeholder="yyyy-mm-dd">
                                </td>
                                <td>
                                    <input type="text" name="end[]" class="form-control calendar" placeholder="yyyy-mm-dd">
                                </td>
                                <td class="visitor_type_col">';
        $html.=                     '<select name="visitortype[]" class="form-control visitor_type_input">';
        $html.=                         '<option value="">';
        $html.=                             '-- '.MultiLang('select').' --';
        $html.=                         '</option>';
        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
        $html.=                         '<option value="'.$value->id.'">';
        $html.=                             $value->name;
        $html.=                         '</option>';
            }
        }
        $html.=                     '</select>';
        $html.=                 '</td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_local[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_foreign[]">
                                </td>
                                <td>
                                    <button id="button_add_price" type="button" class="btn btn-success" onclick="add_price()"><i class="fas fa-plus"></i></button>
                                </td>
                            </tr>
                        </table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="min_order">'.MultiLang('min_order').' *</label>';
        $html.=     '<input type="text" id="min_order" name="min_order" class="form-control" onkeypress="return isNumber(event)">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="max_order">'.MultiLang('max_order').' *</label>';
        $html.=     '<input type="text" id="max_order" name="max_order" class="form-control" onkeypress="return isNumber(event)">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="status">'.MultiLang('status').' *</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="1" checked>
                        <label class="form-check-label" for="status1">
                            '.MultiLang('active').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="0">
                        <label class="form-check-label" for="status2">
                            '.MultiLang('not_active').'
                        </label>
                    </div>';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function add()
    {
        $name = $this->input->post('name', TRUE);
        $name_name = $this->input->post('name_name', TRUE);
        $is_type_visitor = $this->input->post('is_type_visitor', TRUE);
        $base_price_local = $this->input->post('base_price_local', TRUE);
        $base_price_local_name = $this->input->post('base_price_local_name', TRUE);
        $base_price_foreign = $this->input->post('base_price_foreign', TRUE);
        $base_price_foreign_name = $this->input->post('base_price_foreign_name', TRUE);
        $base_price_local2 = $this->input->post('base_price_local2', TRUE);
        $base_price_foreign2 = $this->input->post('base_price_foreign2', TRUE);
        $status = $this->input->post('status', TRUE);
        $start = $this->input->post('start', TRUE);
        $end = $this->input->post('end', TRUE);
        $visitortype = $this->input->post('visitortype', TRUE);
        $price_local = $this->input->post('price_local', TRUE);
        $price_foreign = $this->input->post('price_foreign', TRUE);
        $price = array(
            'start' => $start,
            'end' => $end,
            'visitortype' => $visitortype,
            'price_local' => $price_local,
            'price_foreign' => $price_foreign
        );
        $min_order = $this->input->post('min_order', TRUE);
        $max_order = $this->input->post('max_order', TRUE);

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(!empty($name)){
            foreach ($name as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('name').' '.$name_name[$key].' '.MultiLang('required').'</li>';
                }
            }
        }
        
        if(isset($is_type_visitor)){
            if(!empty($base_price_local)){
                foreach ($base_price_local as $key => $value) {
                    if(empty($value)){
                        $validation = $validation && false;
                        $validation_text.= '<li>'.MultiLang('default_price_local').' '.$base_price_local_name[$key].' '.MultiLang('required').'</li>';
                    }
                }
            }
            
            if(!empty($base_price_foreign)){
                foreach ($base_price_foreign as $key => $value) {
                    if(empty($value)){
                        $validation = $validation && false;
                        $validation_text.= '<li>'.MultiLang('default_price_foreign').' '.$base_price_foreign_name[$key].' '.MultiLang('required').'</li>';
                    }
                }
            }
        }else{
            if(empty($base_price_local2)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('default_price_local').' '.MultiLang('required').'</li>';
            }
            
            if(empty($base_price_foreign2)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('default_price_foreign').' '.MultiLang('required').'</li>';
            }
        }

        if(empty($min_order)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('min_order').' '.MultiLang('required').'</li>';
        }

        if(empty($max_order)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('max_order').' '.MultiLang('required').'</li>';
        }

        if(!isset($status) AND $status == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('status').' '.MultiLang('required').'</li>';
        }

        if($validation){
            $results = true;
            
            $data = array(
                'ticket_is_type_visitor' => isset($is_type_visitor) ? 1 : 0,
                'ticket_min_order' => $min_order,
                'ticket_max_order' => $max_order,
                'ticket_status' => $status,
                'insert_user_id' => $user_id,
                'insert_datetime' => $date
            );
            $results = $results && $this->data->addTicket($data, $name, $base_price_local, $base_price_foreign, $price, $is_type_visitor, $base_price_local2, $base_price_foreign2);
        
            if ($results) {
                $result["status"] = TRUE;
                $result["message"] = MultiLang('msg_add_success');
            } else {
                $result["status"] = FALSE;
                $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                $result["message"].= '<li>'.MultiLang('msg_add_failed').'</li>';
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

    public function edit_view($id){

        $path_language = $this->config->item('path_language');
        $detail = $this->data->getDetailTicket($id);
        $detail_text = $this->data->getDetailTicketText($id);
        $detail_pricedefault = $this->data->getDetailTicketPricedefault($id);
        $detail_price = $this->data->getDetailTicketPrice($id);
        $lang = $this->data->getLang();
        $visitortype = $this->data->getPersontype();

        $html = '<div class="form-group">';
        $html.=     '<label for="name">'.MultiLang('name').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;*';
        $html.=     '<input type="text" id="name_<?php echo $value->code;?>" name="name['.$value->code.']" class="form-control" value="'.$v->name.'">';
        $html.=     '<input type="hidden" id="name_name_<?php echo $value->code;?>" name="name_name['.$value->code.']" value="'.$value->name.'" >';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_type_visitor">'.MultiLang('is_type_visitor').'?</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_type_visitor" id="is_type_visitor" '.($detail->is_type_visitor == 1 ? "checked" : "").'>
                        <label class="form-check-label" for="is_type_visitor">
                        '.MultiLang('yes').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_local">'.MultiLang('default_price_local').'</label>';
        $html.=     '<br>';
        $html.=     '<div id="div_base_price_local1">';
        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
                if(!empty($detail_pricedefault) AND count($detail_pricedefault)>1){
                    foreach ($detail_pricedefault as $k => $v) {
                        if($value->id == $v->visitortype_id){
        $html.=     $value->name.' (Rp) *';
        $html.=     '<input type="text" id="base_price_local_'.$value->id.'" name="base_price_local['.$value->id.']" class="form-control curr" value="'.number_format($v->price_local, 0).'">';
        $html.=     '<input type="hidden" id="base_price_local_name_'.$value->id.'" name="base_price_local_name['.$value->id.']" value="'.$value->name.'" >';
        $html.=     '<br>';
                        }
                    }
                }else{
        $html.=     $value->name.' (Rp) *';
        $html.=     '<input type="text" id="base_price_local_'.$value->id.'" name="base_price_local['.$value->id.']" class="form-control curr">';
        $html.=     '<input type="hidden" id="base_price_local_name_'.$value->id.'" name="base_price_local_name['.$value->id.']" value="'.$value->name.'" >';
        $html.=     '<br>';
                }
            }
        }
        $html.=     '</div>';
        $html.=     '<div id="div_base_price_local2">';
        $html.=         '<input type="text" id="base_price_local2" name="base_price_local2" class="form-control curr" value="'.number_format($detail_pricedefault[0]->price_local, 0).'">';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_foreign">'.MultiLang('default_price_foreign').'</label>';
        $html.=     '<br>';
        $html.=     '<div id="div_base_price_foreign1">';
        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
                if(!empty($detail_pricedefault) AND count($detail_pricedefault)>1){
                    foreach ($detail_pricedefault as $k => $v) {
                        if($value->id == $v->visitortype_id){
        $html.=     $value->name.' (Rp) *';
        $html.=     '<input type="text" id="base_price_foreign_'.$value->id.'" name="base_price_foreign['.$value->id.']" class="form-control curr" value="'.number_format($v->price_foreign, 0).'">';
        $html.=     '<input type="hidden" id="base_price_foreign_name_'.$value->id.'" name="base_price_foreign_name['.$value->id.']" value="'.$value->name.'" >';
        $html.=     '<br>';
                        }
                    }
                }else{
        $html.=     $value->name.' (Rp) *';
        $html.=     '<input type="text" id="base_price_foreign_'.$value->id.'" name="base_price_foreign['.$value->id.']" class="form-control curr">';
        $html.=     '<input type="hidden" id="base_price_foreign_name_'.$value->id.'" name="base_price_foreign_name['.$value->id.']" value="'.$value->name.'" >';
        $html.=     '<br>';
                }
            }
        }
        $html.=     '</div>';
        $html.=     '<div id="div_base_price_foreign2">';
        $html.=         '<input type="text" id="base_price_foreign2" name="base_price_foreign2" class="form-control curr" value="'.number_format($detail_pricedefault[0]->price_foreign, 0).'">';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="price_period">'.MultiLang('price_period').'</label>';
        $html.=     '<div>';
        $html.=         '<table class="table table-bordered" id="table_price">
                            <tr>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('start').'
                                </td>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('end').'
                                </td>
                                <td  class="visitor_type_col" style="width: 130px; text-align: center;">
                                    '.MultiLang('visitor_type').'
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('local_tourist_price').'<br>(Rp)
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('foreign_tourist_price').'<br>(Rp)
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('action').'
                                </td>
                            </tr>';
        if(!empty($detail_price)){
            foreach ($detail_price as $key => $value) {
                if($key == 0){
                    $action = '<button type="button" id="button_add_price" class="btn btn-success" onclick="add_price()"><i class="fas fa-plus"></i></button>';
                }else{
                    $action = '<button type="button" id="button_add_price" class="btn btn-danger" onclick="delete_price(this)"><i class="fas fa-trash-alt"></i></button>';
                }
        $html.=             '<tr>
                                <td>
                                    <input type="text" name="start[]" class="form-control calendar" placeholder="yyyy-mm-dd" value="'.$value->start.'">
                                </td>
                                <td>
                                    <input type="text" name="end[]" class="form-control calendar" placeholder="yyyy-mm-dd" value="'.$value->end.'">
                                </td>
                                <td class="visitor_type_col">';
        $html.=                     '<select name="visitortype[]" class="form-control visitor_type_input">';
        $html.=                         '<option value="">';
        $html.=                             '-- '.MultiLang('select').' --';
        $html.=                         '</option>';
        if(!empty($visitortype)){
            foreach ($visitortype as $k => $v) {
        $html.=                         '<option value="'.$v->id.'" '.($value->visitortype_id == $v->id ? "selected" : "").'>';
        $html.=                             $v->name;
        $html.=                         '</option>';
            }
        }
        $html.=                     '</select>';
        $html.=                 '</td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_local[]" value="'.number_format($value->price_local, 0).'">
                                </td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_foreign[]" value="'.number_format($value->price_foreign, 0).'">
                                </td>
                                <td>
                                    '.$action.'
                                </td>
                            </tr>';
            }
        }else{
        $html.=             '<tr>
                                <td>
                                    <input type="text" name="start[]" class="form-control calendar" placeholder="yyyy-mm-dd">
                                </td>
                                <td>
                                    <input type="text" name="end[]" class="form-control calendar" placeholder="yyyy-mm-dd">
                                </td>
                                <td class="visitor_type_col">';
        $html.=                     '<select name="visitortype[]" class="form-control visitor_type_input">';
        $html.=                         '<option value="">';
        $html.=                             '-- '.MultiLang('select').' --';
        $html.=                         '</option>';
        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
        $html.=                         '<option value="'.$value->id.'">';
        $html.=                             $value->name;
        $html.=                         '</option>';
            }
        }
        $html.=                     '</select>';
        $html.=                 '</td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_local[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_foreign[]">
                                </td>
                                <td>
                                    <button type="button" id="button_add_price" class="btn btn-success" onclick="add_price()"><i class="fas fa-plus"></i></button>
                                </td>
                            </tr>';
        }
        $html.=         '</table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="min_order">'.MultiLang('min_order').' *</label>';
        $html.=     '<input type="text" id="min_order" name="min_order" class="form-control" onkeypress="return isNumber(event)" value="'.$detail->min_order.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="max_order">'.MultiLang('max_order').' *</label>';
        $html.=     '<input type="text" id="max_order" name="max_order" class="form-control" onkeypress="return isNumber(event)" value="'.$detail->max_order.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="status">'.MultiLang('status').' *</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status1" value="1" '.($detail->status == 1 ? "checked" : "").'>
                        <label class="form-check-label" for="status1">
                            '.MultiLang('active').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="status2" value="0" '.($detail->status == 0 ? "checked" : "").'>
                        <label class="form-check-label" for="status2">
                            '.MultiLang('not_active').'
                        </label>
                    </div>';
        $html.=     '<input type="hidden" id="id" name="id" value="'.$detail->id.'">';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function edit()
    {   
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $name_name = $this->input->post('name_name', TRUE);
        $base_price_local = $this->input->post('base_price_local', TRUE);
        $base_price_local_name = $this->input->post('base_price_local_name', TRUE);
        $base_price_foreign = $this->input->post('base_price_foreign', TRUE);
        $base_price_foreign_name = $this->input->post('base_price_foreign_name', TRUE);
        $base_price_local2 = $this->input->post('base_price_local2', TRUE);
        $base_price_foreign2 = $this->input->post('base_price_foreign2', TRUE);
        $is_type_visitor = $this->input->post('is_type_visitor', TRUE);
        $status = $this->input->post('status', TRUE);
        $start = $this->input->post('start', TRUE);
        $end = $this->input->post('end', TRUE);
        $visitortype = $this->input->post('visitortype', TRUE);
        $price_local = $this->input->post('price_local', TRUE);
        $price_foreign = $this->input->post('price_foreign', TRUE);
        $price = array(
            'start' => $start,
            'end' => $end,
            'visitortype' => $visitortype,
            'price_local' => $price_local,
            'price_foreign' => $price_foreign
        );
        $min_order = $this->input->post('min_order', TRUE);
        $max_order = $this->input->post('max_order', TRUE);

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(!empty($name)){
            foreach ($name as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('name').' '.$name_name[$key].' '.MultiLang('required').'</li>';
                }
            }
        }

        if(isset($is_type_visitor)){
            if(!empty($base_price_local)){
                foreach ($base_price_local as $key => $value) {
                    if(empty($value)){
                        $validation = $validation && false;
                        $validation_text.= '<li>'.MultiLang('default_price_local').' '.$base_price_local_name[$key].' '.MultiLang('required').'</li>';
                    }
                }
            }
            
            if(!empty($base_price_foreign)){
                foreach ($base_price_foreign as $key => $value) {
                    if(empty($value)){
                        $validation = $validation && false;
                        $validation_text.= '<li>'.MultiLang('default_price_foreign').' '.$base_price_foreign_name[$key].' '.MultiLang('required').'</li>';
                    }
                }
            }
        }else{
            if(empty($base_price_local2)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('default_price_local').' '.MultiLang('required').'</li>';
            }
            
            if(empty($base_price_foreign2)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('default_price_foreign').' '.MultiLang('required').'</li>';
            }
        }

        if(empty($min_order)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('min_order').' '.MultiLang('required').'</li>';
        }

        if(empty($max_order)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('max_order').' '.MultiLang('required').'</li>';
        }

        if(!isset($status) AND $status == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('status').' '.MultiLang('required').'</li>';
        }

        if($validation){
            $results = true;

            $data = array(
                'ticket_is_type_visitor' => isset($is_type_visitor) ? 1 : 0,
                'ticket_min_order' => $min_order,
                'ticket_max_order' => $max_order,
                'ticket_status' => $status,
                'update_user_id' => $user_id,
                'update_datetime' => $date
            );
            $results = $results && $this->data->updateTicket($data, $id, $name, $base_price_local, $base_price_foreign, $price, $is_type_visitor, $base_price_local2, $base_price_foreign2);
        
            if ($results) {
                $result["status"] = TRUE;
                $result["message"] = MultiLang('msg_update_success');
            } else {
                $result["status"] = FALSE;
                $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                $result["message"].= '<li>'.MultiLang('msg_update_failed').'</li>';
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

    public function detail($id){

        $path_language = $this->config->item('path_language');
        $detail = $this->data->getDetailTicket($id);
        $detail_text = $this->data->getDetailTicketText($id);
        $detail_pricedefault = $this->data->getDetailTicketPricedefault($id);
        $detail_price = $this->data->getDetailTicketPrice($id);
        $lang = $this->data->getLang();
        $visitortype = $this->data->getPersontype();

        $html = '<div class="form-group">';
        $html.=     '<label for="title">'.MultiLang('name').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;';
        $html.=     '<div style=" border:1px dashed #3e3e3e; padding: 5px; margin: 5px 0;">'.$v->name.'</div>';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_type_visitor">'.MultiLang('is_type_visitor').'?</label>';
        $html.=     '<div id="is_type_visitor">'.($detail->is_type_visitor == 1 ? MultiLang('yes') : MultiLang('no')).'</div>';
        $html.= '</div>';
        if($detail->is_type_visitor == 1){
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_local">'.MultiLang('default_price_local').'</label>';
        $html.=     '<br>';
        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
                foreach ($detail_pricedefault as $k => $v) {
                    if($value->id == $v->visitortype_id){
        $html.=     $value->name.' (Rp)';
        $html.=     '<div style=" border:1px dashed #3e3e3e; padding: 5px; margin: 5px 0;">'.number_format($v->price_local, 0, ',', '.').'</div>';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        }else{
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_local">'.MultiLang('default_price_local').' (Rp)</label>';
        $html.=     '<br>';
        $html.=     '<div style=" border:1px dashed #3e3e3e; padding: 5px; margin: 5px 0;">'.number_format($detail_pricedefault[0]->price_local, 0, ',', '.').'</div>';
        $html.= '</div>';
        }
        if($detail->is_type_visitor == 1){
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_foreign">'.MultiLang('default_price_foreign').'</label>';
        $html.=     '<br>';
        if(!empty($visitortype)){
            foreach ($visitortype as $key => $value) {
                foreach ($detail_pricedefault as $k => $v) {
                    if($value->id == $v->visitortype_id){
        $html.=     $value->name.' (Rp)';
        $html.=     '<div style=" border:1px dashed #3e3e3e; padding: 5px; margin: 5px 0;">'.number_format($v->price_foreign, 0, ',', '.').'</div>';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        }else{
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_local">'.MultiLang('default_price_local').' (Rp)</label>';
        $html.=     '<br>';
        $html.=     '<div style=" border:1px dashed #3e3e3e; padding: 5px; margin: 5px 0;">'.number_format($detail_pricedefault[0]->price_foreign, 0, ',', '.').'</div>';
        $html.= '</div>';
        }
        $html.= '<div class="form-group">';
        $html.=     '<label for="price_period">'.MultiLang('price_period').'</label>';
        $html.=     '<div>';
        $html.=         '<table class="table table-bordered" id="table_price">
                            <tr>
                                <td style="width: 170px; text-align: center;">
                                    '.MultiLang('start').'
                                </td>
                                <td style="width: 170px; text-align: center;">
                                    '.MultiLang('end').'
                                </td>
                                <td style="width: 130px; text-align: center; '.($detail->is_type_visitor == 1 ? '' : 'display: none;').'">
                                    '.MultiLang('visitor_type').'
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('local_tourist_price').'<br>(Rp)
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('foreign_tourist_price').'<br>(Rp)
                                </td>
                            </tr>';
        if(!empty($detail_price)){
            foreach ($detail_price as $key => $value) {
                if($key == 0){
                    $action = '<button type="button" class="btn btn-success" onclick="add_price()"><i class="fas fa-plus"></i></button>';
                }else{
                    $action = '<button type="button" class="btn btn-danger" onclick="delete_price(this)"><i class="fas fa-trash-alt"></i></button>';
                }
        $html.=             '<tr>
                                <td style="text-align: center;">
                                    '.$this->data->getDateIndo($value->start).'
                                </td>
                                <td style="text-align: center;">
                                    '.$this->data->getDateIndo($value->end).'
                                </td>
                                <td style="text-align: center; '.($detail->is_type_visitor == 1 ? '' : 'display: none;').'">
                                    '.($value->visitortype_name).'
                                </td>
                                <td style="text-align: right;">
                                    '.number_format($value->price_local, 0, ',', '.').'
                                </td>
                                <td style="text-align: right;">
                                    '.number_format($value->price_foreign, 0, ',', '.').'
                                </td>
                            </tr>';
            }
        }else{
        $html.=             '<tr>
                                <td colspan="'.($detail->is_type_visitor == 1 ? '4' : '5').'" style="text-align: center;">
                                    <i>-- '.MultiLang('empty_data').' --</i>
                                </td>
                            </tr>';
        }
        $html.=         '</table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="min_order">'.MultiLang('min_order').'</label>';
        $html.=     '<div>'.$detail->min_order.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="max_order">'.MultiLang('max_order').'</label>';
        $html.=     '<div>'.$detail->max_order.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="status">'.MultiLang('status').'</label>';
        $html.=     '<div id="status">'.($detail->status == 1 ? MultiLang('active') : MultiLang('not_active')).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="inserted">'.MultiLang('inserted').'</label>';
        $html.=     '<div>'.(!empty($detail->insert_user) ? $detail->insert_user.',' : '').' '.($this->data->getDatetimeIndo($detail->insert_datetime)).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="updated">'.MultiLang('updated').'</label>';
        $html.=     '<div>'.(!empty($detail->update_user) ? $detail->update_user.',' : '').' '.($this->data->getDatetimeIndo($detail->update_datetime)).'</div>';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function delete($id)
    {
        $delete = $this->data->deleteTicket($id);
        if($delete){
            $result["status"] = TRUE;
            $result["message"] = MultiLang('msg_delete_success');
        }else{
            $result["status"] = FALSE;
            $result["message"] = MultiLang('msg_delete_failed');
        }

        echo json_encode($result);
    } 
}
