<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tourpackages extends CI_Controller {

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
		$data['components'] = 'components/tourpackages';
		$data['active_menu_parent'] = 'master_data';
        $data['active_menu'] = 'tourpackages';
        $data['destination'] = $this->data->getDestination();
        $data['destination'] = json_encode($data['destination']);

		$this->load->view('home', $data);
	}
	
	public function data()
	{   
		$filter = array();
        $filter['keyword'] = $_POST['search']['value'];
        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1 => 'b.`tourpackagestext_name`',
            2 => 'a.`tourpackages_status`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllTourpackages($filter);
        $count = $this->data->getTotalAllTourpackages($filter);
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->name;
                $row[] = ($value->status == 1) ? MultiLang('active') : MultiLang('not_active');
    
                //add html for action
                $row[] = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="'.MultiLang('testimony').'" onclick="totestimony(\''.$value->id.'\')"><i class="fas fa-comments"></i></a>
                        <a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->id.'\')"><i class="fas fa-search"></i></a>
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
        $destination = $this->data->getDestination();

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
        $html.=     '<label for="content">'.MultiLang('content').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;*';
        $html.=     '<textarea id="content_<?php echo $value->code;?>" name="content['.$value->code.']" class="form-control textarea"></textarea>';
        $html.=     '<input type="hidden" id="content_name_<?php echo $value->code;?>" name="content_name['.$value->code.']" value="'.$value->name.'" >';
        $html.=     '<br>';
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="destination">'.MultiLang('destination').'</label>';
        $html.=     '<div>';
        $html.=         '<table class="table table-bordered" id="table_destination">
                            <tr>
                                <td style="text-align: center;">
                                    '.MultiLang('name').'
                                </td>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('day').'
                                </td>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('order').'/'.MultiLang('day').'
                                </td>
                                <td style="width: 50px; text-align: center;">
                                    '.MultiLang('is_night').'?
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('action').'
                                </td>
                            </tr>
                            <tr>
                                <td>';
        $html.=                     '<select name="destination[]" class="form-control">';
        $html.=                         '<option value="">';
        $html.=                             '-- '.MultiLang('select').' --';
        $html.=                         '</option>';
        if(!empty($destination)){
            foreach ($destination as $key => $value) {
        $html.=                         '<option value="'.$value->id.'">';
        $html.=                             $value->name;
        $html.=                         '</option>';
            }
        }
        $html.=                     '</select>';
        $html.=                 '</td>
                                <td>
                                    <input type="number" name="day[]" class="form-control" onkeypress="return isNumber(event)">
                                </td>
                                <td>
                                    <input type="number" name="order[]" class="form-control" onkeypress="return isNumber(event)">
                                </td>
                                <td style="text-align: center;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_night[]">
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-success" onclick="add_destination()"><i class="fas fa-plus"></i></button>
                                </td>
                            </tr>
                        </table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_local">'.MultiLang('default_price_local').' (Rp) *</label>';
        $html.=     '<input type="text" id="base_price_local" name="base_price_local" class="form-control curr">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_foreign">'.MultiLang('default_price_foreign').' (Rp) *</label>';
        $html.=     '<input type="text" id="base_price_foreign" name="base_price_foreign" class="form-control curr">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="price_period">'.MultiLang('price_period').'</label>';
        $html.=     '<div>';
        $html.=         '<table class="table table-bordered" id="table_price">
                            <tr>
                                <td style="width: 150px; text-align: center;">
                                    '.MultiLang('start').'
                                </td>
                                <td style="width: 150px; text-align: center;">
                                    '.MultiLang('end').'
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
                                <td>
                                    <input type="text" class="form-control curr" name="price_local[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_foreign[]">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="add_price()"><i class="fas fa-plus"></i></button>
                                </td>
                            </tr>
                        </table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_rating_manual">'.MultiLang('is_rating_manual').'?</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_rating_manual" id="is_rating_manual">
                        <label class="form-check-label" for="is_rating_manual">
                        '.MultiLang('yes').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="rating_manual">'.MultiLang('rating_manual_value').' *</label>';
        $html.=     '<input type="text" id="rating_manual" name="rating_manual" class="form-control" onkeypress="return isNumberText(event)" maxlength="4">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="total_rater_manual">'.MultiLang('total_rater_manual').' *</label>';
        $html.=     '<input type="text" id="total_rater_manual" name="total_rater_manual" class="form-control" onkeypress="return isNumber(event)">';
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
        $html.= '<div class="form-group">
                    <label for="file_image">'.MultiLang('image').' *</label>
                    <br>
                    <div class="row">';
                        for($i=1; $i<=4; $i++){
        $html.=             '<div class="col" style="text-align: center;">
                                <label id="label_images_'.$i.'" for="images_'.$i.'" style="cursor: pointer;">
                                    <img style="width:180px; height:100px; border:1px dashed #C3C3C3;" src="../assets/images/upload-images.png" />
                                </label>
                                
                                <input type="file" name="images_'.$i.'" id="images_'.$i.'" style="display:none;" onchange="readURL(this,\''.$i.'\')" accept="image/*"/>

                                <img style="width:180px; height:100px; border:1px dashed #C3C3C3; margin-bottom: 5px; display:none;" id="show_images_'.$i.'" />
                                <br>
                                <div style="height: 40px;">
                                    <span id="remove_'.$i.'" class="btn btn-warning" onclick="removeImage(\''.$i.'\')" style="cursor: pointer; margin-bottom: 5px; display:none;">
                                        '.MultiLang('delete').'
                                    </span>
                                    <span class="msg_images" id="msg_images_'.$i.'" style="color: red;"></span>
                                </div>

                                <input type="hidden" id="file_image_value_'.$i.'" name="file_image_value[]"/>
                            </div>';
                        }
        $html.='
                    </div>
                </div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function add()
    {

        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');

        $name = $this->input->post('name', TRUE);
        $name_name = $this->input->post('name_name', TRUE);
        $content = $this->input->post('content', TRUE);
        $content_name = $this->input->post('content_name', TRUE);
        $base_price_local = $this->input->post('base_price_local', TRUE);
        $base_price_foreign = $this->input->post('base_price_foreign', TRUE);
        $is_rating_manual = $this->input->post('is_rating_manual', TRUE);
        $rating_manual = $this->input->post('rating_manual', TRUE);
        $total_rater_manual = $this->input->post('total_rater_manual', TRUE);
        $status = $this->input->post('status', TRUE);
        $file_image_value = $this->input->post('file_image_value');
        $start = $this->input->post('start', TRUE);
        $end = $this->input->post('end', TRUE);
        $price_local = $this->input->post('price_local', TRUE);
        $price_foreign = $this->input->post('price_foreign', TRUE);
        $price = array(
            'start' => $start,
            'end' => $end,
            'price_local' => $price_local,
            'price_foreign' => $price_foreign
        );
        $destination = $this->input->post('destination', TRUE);
        $day = $this->input->post('day', TRUE);
        $order = $this->input->post('order', TRUE);
        $is_night = $this->input->post('is_night', TRUE);
        $destination = array(
            'destination' => $destination,
            'day' => $day,
            'order' => $order,
            'is_night' => $is_night
        );

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
        
        if(!empty($content)){
            foreach ($content as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('content').' '.$content_name[$key].' '.MultiLang('required').'</li>';
                }
            }
        }

        if(empty($base_price_local)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('default_price_local').' '.MultiLang('required').'</li>';
        }
        
        if(empty($base_price_foreign)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('default_price_foreign').' '.MultiLang('required').'</li>';
        }

        if(empty($rating_manual)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('rating_manual').' '.MultiLang('required').'</li>';
        }
        
        if(empty($total_rater_manual)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('total_rater_manual').' '.MultiLang('required').'</li>';
        }

        if(!isset($status) AND $status == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('status').' '.MultiLang('required').'</li>';
        }

        if(!empty($file_image_value)){
            $empty = true;
            foreach ($file_image_value as $key => $value) {
                if(empty($value)){
                    $empty = $empty && true;
                }else{
                    $empty = $empty && false;
                }
            }
            if($empty){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('image').' '.MultiLang('required').'</li>';
            }
        }

        if($validation){
            $results = true;
            $upload_status = true;
            $msg_upload = '';
            $images_name = array();

            $max_size = '1024'; // in KB
            $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
            foreach ($file_image_value as $key => $value) {
                $upload = '';
                if(!empty($value)){
                    $upload = $this->data->uploadBase64($value, $path_tourpackages_upload, $max_size, $type_allow);
                    if(!$upload['status']){
                        $upload_status = $upload_status && false;
                        $msg_upload.= '<li>'.MultiLang('image').' '.($key+1).': '.$upload['message'].'</li>';
                    }
                }
                $images_name[$key+1] = (!empty($upload['file'])) ? $upload['file'] : NULL;
            }

            if($upload_status){
                $data = array(
                    'tourpackages_base_price_local' => str_replace('.','',$base_price_local),
                    'tourpackages_base_price_foreign' => str_replace('.','',$base_price_foreign),
                    'tourpackages_is_rating_manual' => isset($is_rating_manual) ? 1 : 0,
                    'tourpackages_rating_manual' => $rating_manual,
                    'tourpackages_total_rater_manual' => $total_rater_manual,
                    'tourpackages_status' => $status,
                    'insert_user_id' => $user_id,
                    'insert_datetime' => $date
                );
                $results = $results && $this->data->addTourpackages($data, $name, $content, $images_name, $price, $destination);
            
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
                    foreach ($file_image_value as $key => $value) {
                        if(!empty($value)){
                            @unlink($path_tourpackages_upload.$value);
                        }
                    }
                    
                }
            }else{
                $result["status"] = FALSE;
                $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                $result["message"].= $msg_upload;
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
        $path_tourpackages = $this->config->item('path_tourpackages');
        $detail = $this->data->getDetailTourpackages($id);
        $detail_text = $this->data->getDetailTourpackagesText($id);
        $detail_images = $this->data->getDetailTourpackagesImages($id);
        $detail_price = $this->data->getDetailTourpackagesPrice($id);
        $detail_destination = $this->data->getDetailTourpackagesDestination($id);
        $lang = $this->data->getLang();
        $destination = $this->data->getDestination();

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
        $html.=     '<label for="content">'.MultiLang('content').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;*';
        $html.=     '<textarea id="content_<?php echo $value->code;?>" name="content['.$value->code.']" class="form-control textarea">'.$v->text.'</textarea>';
        $html.=     '<input type="hidden" id="content_name_<?php echo $value->code;?>" name="content_name['.$value->code.']" value="'.$value->name.'" >';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="destination">'.MultiLang('destination').'</label>';
        $html.=     '<div>';
        $html.=         '<table class="table table-bordered" id="table_destination">
                            <tr>
                                <td style="text-align: center;">
                                    '.MultiLang('name').'
                                </td>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('day').'
                                </td>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('order').'/'.MultiLang('day').'
                                </td>
                                <td style="width: 50px; text-align: center;">
                                    '.MultiLang('is_night').'?
                                </td>
                                <td style="text-align: center;">
                                    '.MultiLang('action').'
                                </td>
                            </tr>';
        if(!empty($detail_destination)){
            foreach ($detail_destination as $key => $value) {

                if($key == 0){
                    $action = '<button type="button" class="btn btn-success" onclick="add_destination()"><i class="fas fa-plus"></i></button>';
                }else{
                    $action = '<button type="button" class="btn btn-danger" onclick="delete_destination(this)"><i class="fas fa-trash-alt"></i></button>';
                }
                $html.='        <tr>
                                    <td>';
                $html.=                 '<select name="destination[]" class="form-control">';
                $html.=                     '<option value="">';
                $html.=                         '-- '.MultiLang('select').' --';
                $html.=                     '</option>';
                if(!empty($destination)){
                    foreach ($destination as $k => $v) {
                $html.=                     '<option value="'.$v->id.'" '.($value->destination_id == $v->id ? "selected" : "").'>';
                $html.=                         $v->name;
                $html.=                     '</option>';
                    }
                }
                $html.=                 '</select>';
                $html.=            '</td>
                                    <td>
                                        <input type="number" name="day[]" class="form-control" onkeypress="return isNumber(event)" value="'.$value->day.'">
                                    </td>
                                    <td>
                                        <input type="number" name="order[]" class="form-control" onkeypress="return isNumber(event)" value="'.$value->order.'">
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="1" name="is_night[]" '.($value->is_night == 1 ? "checked" : "").'>
                                        </div>
                                    </td>
                                    <td style="text-align: center;">
                                        '.$action.'
                                    </td>
                                </tr>';
                
            }
        }else{
            $html.='        <tr>
                                <td>';
            $html.=                 '<select name="destination[]" class="form-control">';
            $html.=                     '<option value="">';
            $html.=                         '-- '.MultiLang('select').' --';
            $html.=                     '</option>';
            if(!empty($destination)){
                foreach ($destination as $key => $value) {
            $html.=                     '<option value="'.$value->id.'">';
            $html.=                         $value->name;
            $html.=                     '</option>';
                }
            }
            $html.=                 '</select>';
            $html.=            '</td>
                                <td>
                                    <input type="number" name="day[]" class="form-control" onkeypress="return isNumber(event)">
                                </td>
                                <td>
                                    <input type="number" name="order[]" class="form-control" onkeypress="return isNumber(event)">
                                </td>
                                <td style="text-align: center;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_night[]">
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-success" onclick="add_destination()"><i class="fas fa-plus"></i></button>
                                </td>
                            </tr>';
        }
        $html.=         '</table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_local">'.MultiLang('default_price_local').' (Rp) *</label>';
        $html.=     '<input type="text" id="base_price_local" name="base_price_local" class="form-control curr" value="'.$detail->base_price_local.'">';
        $html.=     '<input type="hidden" id="id" name="id" value="'.$detail->id.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_foreign">'.MultiLang('default_price_foreign').' (Rp) *</label>';
        $html.=     '<input type="text" id="base_price_foreign" name="base_price_foreign" class="form-control curr" value="'.$detail->base_price_foreign.'">';
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
                    $action = '<button type="button" class="btn btn-success" onclick="add_price()"><i class="fas fa-plus"></i></button>';
                }else{
                    $action = '<button type="button" class="btn btn-danger" onclick="delete_price(this)"><i class="fas fa-trash-alt"></i></button>';
                }
        $html.=             '<tr>
                                <td>
                                    <input type="text" name="start[]" class="form-control calendar" placeholder="yyyy-mm-dd" value="'.$value->start.'">
                                </td>
                                <td>
                                    <input type="text" name="end[]" class="form-control calendar" placeholder="yyyy-mm-dd" value="'.$value->end.'">
                                </td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_local[]" value="'.$value->price_local.'">
                                </td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_foreign[]" value="'.$value->price_foreign.'">
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
                                <td>
                                    <input type="text" class="form-control curr" name="price_local[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control curr" name="price_foreign[]">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success" onclick="add_price()"><i class="fas fa-plus"></i></button>
                                </td>
                            </tr>';
        }
        $html.=         '</table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_rating_manual">'.MultiLang('is_rating_manual').'?</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_rating_manual" id="is_rating_manual" '.($detail->is_rating_manual == 1 ? "checked" : "").'>
                        <label class="form-check-label" for="is_rating_manual">
                        '.MultiLang('yes').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="rating_manual">'.MultiLang('rating_manual_value').' *</label>';
        $html.=     '<input type="text" id="rating_manual" name="rating_manual" class="form-control" onkeypress="return isNumberText(event)" value="'.$detail->rating_manual.'" maxlength="4">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="total_rater_manual">'.MultiLang('total_rater_manual').' *</label>';
        $html.=     '<input type="text" id="total_rater_manual" name="total_rater_manual" class="form-control" onkeypress="return isNumber(event)" value="'.$detail->total_rater_manual.'">';
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
        $html.= '</div>';
        $html.= '<div class="form-group">
                    <label for="file_image">'.MultiLang('image').' *</label>
                    <br>
                    <div class="row">';
                        for($i=1; $i<=4; $i++){
                            foreach ($detail_images as $key => $value) {
                                if($value->order == $i){
                                    if(!empty($value->img)){
                                        $type = pathinfo($path_tourpackages.$value->img, PATHINFO_EXTENSION);
                                        $base_64_images = base64_encode(file_get_contents($path_tourpackages.$value->img));
                                        $base_64_images = 'data:image/' . $type . ';base64,' .$base_64_images;
                                    }else{
                                        $base_64_images = '';
                                    }
        $html.=             '<div class="col" style="text-align: center;">
                                <label id="label_images_'.$i.'" for="images_'.$i.'" style="cursor: pointer;'.(!empty($value->img) ? 'display:none;' : '').'">
                                    <img style="width:180px; height:100px; border:1px dashed #C3C3C3;" src="../assets/images/upload-images.png" />
                                </label>
                                
                                <input type="file" name="images_'.$i.'" id="images_'.$i.'" style="display:none;" onchange="readURL(this,\''.$i.'\')" accept="image/*"/>

                                <img style="width:180px; height:100px; border:1px dashed #C3C3C3; margin-bottom: 5px; '.(!empty($value->img) ? '' : 'display:none;').'" id="show_images_'.$i.'" '.(!empty($value->img) ? 'src="'.$path_tourpackages.$value->img.'"' : '').' />
                                <br>
                                <div style="height: 40px;">
                                    <span id="remove_'.$i.'" class="btn btn-warning" onclick="removeImage(\''.$i.'\')" style="cursor: pointer; margin-bottom: 5px; '.(!empty($value->img) ? '' : 'display:none;').'">
                                        '.MultiLang('delete').'
                                    </span>
                                    <span class="msg_images" id="msg_images_'.$i.'" style="color: red;"></span>
                                </div>

                                <input type="hidden" id="file_image_value_'.$i.'" name="file_image_value[]" value="'.$base_64_images.'"/>
                                <input type="hidden" id="file_image_value_old_'.$i.'" name="file_image_value_old[]" value="'.(!empty($value->img) ? $value->img : '').'"/>
                            </div>';
                                }
                            }
                        }
        $html.='
                    </div>
                </div>';

        $data['html'] = $html;

        echo json_encode($data);
    }

    public function edit()
    {   
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');

        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $name_name = $this->input->post('name_name', TRUE);
        $content = $this->input->post('content', TRUE);
        $content_name = $this->input->post('content_name', TRUE);
        $base_price_local = $this->input->post('base_price_local', TRUE);
        $base_price_foreign = $this->input->post('base_price_foreign', TRUE);
        $is_rating_manual = $this->input->post('is_rating_manual', TRUE);
        $rating_manual = $this->input->post('rating_manual', TRUE);
        $total_rater_manual = $this->input->post('total_rater_manual', TRUE);
        $status = $this->input->post('status', TRUE);
        $file_image_value = $this->input->post('file_image_value');
        $file_image_value_old = $this->input->post('file_image_value_old');
        $start = $this->input->post('start', TRUE);
        $end = $this->input->post('end', TRUE);
        $price_local = $this->input->post('price_local', TRUE);
        $price_foreign = $this->input->post('price_foreign', TRUE);
        $price = array(
            'start' => $start,
            'end' => $end,
            'price_local' => $price_local,
            'price_foreign' => $price_foreign
        );
        $destination = $this->input->post('destination', TRUE);
        $day = $this->input->post('day', TRUE);
        $order = $this->input->post('order', TRUE);
        $is_night = $this->input->post('is_night', TRUE);
        $destination = array(
            'destination' => $destination,
            'day' => $day,
            'order' => $order,
            'is_night' => $is_night
        );

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
        
        if(!empty($content)){
            foreach ($content as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('content').' '.$content_name[$key].' '.MultiLang('required').'</li>';
                }
            }
        }

        if(empty($base_price_local)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('default_price_local').' '.MultiLang('required').'</li>';
        }
        
        if(empty($base_price_foreign)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('default_price_foreign').' '.MultiLang('required').'</li>';
        }

        if(empty($rating_manual)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('rating_manual').' '.MultiLang('required').'</li>';
        }
        
        if(empty($total_rater_manual)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('total_rater_manual').' '.MultiLang('required').'</li>';
        }
        if(!isset($status) AND $status == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('status').' '.MultiLang('required').'</li>';
        }

        if(!empty($file_image_value) AND !empty($file_image_value_old)){
            $empty = true;
            foreach ($file_image_value as $key => $value) {
                if(empty($value)){
                    $empty = $empty && true;
                }else{
                    $empty = $empty && false;
                }
            }
            if($empty){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('image').' '.MultiLang('required').'</li>';
            }
        }

        if($validation){
            $results = true;
            $upload_status = true;
            $msg_upload = '';
            $images_name = array();

            $max_size = '1024'; // in KB
            $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
            foreach ($file_image_value as $key => $value) {
                $upload = '';
                if(!empty($value)){
                    $upload = $this->data->uploadBase64($value, $path_tourpackages_upload, $max_size, $type_allow);
                    if(!$upload['status']){
                        $upload_status = $upload_status && false;
                        $msg_upload.= '<li>'.MultiLang('image').' '.($key+1).': '.$upload['message'].'</li>';
                    }
                }
                $images_name[$key+1] = (!empty($upload['file']) ? $upload['file'] : NULL);
            }

            if($upload_status){
                $data = array(
                    'tourpackages_base_price_local' => str_replace('.','',$base_price_local),
                    'tourpackages_base_price_foreign' => str_replace('.','',$base_price_foreign),
                    'tourpackages_is_rating_manual' => isset($is_rating_manual) ? 1 : 0,
                    'tourpackages_rating_manual' => $rating_manual,
                    'tourpackages_total_rater_manual' => $total_rater_manual,
                    'tourpackages_status' => $status,
                    'update_user_id' => $user_id,
                    'update_datetime' => $date
                );
                $results = $results && $this->data->updateTourpackages($data, $id, $name, $content, $images_name, $price, $destination);
            
                if ($results) {
                    $result["status"] = TRUE;
                    $result["message"] = MultiLang('msg_update_success');
                    if(!empty($file_image_value) AND !empty($file_image_value_old)){
                        foreach ($file_image_value as $key => $value) {
                            @unlink($path_tourpackages_upload.$file_image_value_old[$key]);
                        }
                    }
                } else {
                    $result["status"] = FALSE;
                    $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    $result["message"].= '<li>'.MultiLang('msg_update_failed').'</li>';
                    $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>';
                    $result["message"].= '</div>';
                    foreach ($file_image_value as $key => $value) {
                        if(!empty($value)){
                            @unlink($path_tourpackages_upload.$value);
                        }
                    }
                }

            }else{
                $result["status"] = FALSE;
                $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                $result["message"].= $msg_upload;
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
        $path_tourpackages = $this->config->item('path_tourpackages');
        $detail = $this->data->getDetailTourpackages($id);
        $detail_text = $this->data->getDetailTourpackagesText($id);
        $detail_images = $this->data->getDetailTourpackagesImages($id);
        $detail_price = $this->data->getDetailTourpackagesPrice($id);
        $detail_destination = $this->data->getDetailTourpackagesDestination($id);
        $lang = $this->data->getLang();
        $destination = $this->data->getDestination();

        $html = '<div class="form-group">';
        $html.=     '<label for="name">'.MultiLang('name').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')';
        $html.=     '<div style=" border:1px dashed #3e3e3e; padding: 5px; margin: 5px 0">'.$v->name.'</div>';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="content">'.MultiLang('content').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')';
        $html.=     '<div style=" border:1px dashed #3e3e3e; padding: 5px; margin: 5px 0">'.$v->text.'</div>';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="destination">'.MultiLang('destination').'</label>';
        $html.=     '<div>';
        $html.=         '<table class="table table-bordered" id="table_destination">
                            <tr>
                                <td style="text-align: center;">
                                    '.MultiLang('name').'
                                </td>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('day').'
                                </td>
                                <td style="width: 140px; text-align: center;">
                                    '.MultiLang('order').'/'.MultiLang('day').'
                                </td>
                                <td style="width: 100px; text-align: center;">
                                    '.MultiLang('is_night').'?
                                </td>
                            </tr>';
        if(!empty($detail_destination)){
            foreach ($detail_destination as $key => $value) {
                $html.='        <tr>
                                    <td style="text-align: left;">';
                $html.=                 $value->destination_name;
                $html.=            '</td>
                                    <td style="text-align: center;">
                                        '.$value->day.'
                                    </td>
                                    <td style="text-align: center;">
                                        '.$value->order.'
                                    </td>
                                    <td style="text-align: center;">
                                        '.($value->is_night == 1 ? MultiLang('yes') : MultiLang('no')).'
                                    </td>
                                </tr>';
                
            }
        }else{
            $html.='        <tr>
                                <td colspan="4" style="text-align: center;">
                                    <i>-- '.MultiLang('empty_data').' --</i>
                                </td>
                            </tr>';
        }
        $html.=         '</table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_local">'.MultiLang('default_price_local').'</label>';
        $html.=     '<div>Rp '.number_format($detail->base_price_local, 2, ',', '.').'</div>';
        $html.= '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="base_price_foreign">'.MultiLang('default_price_foreign').'</label>';
        $html.=     '<div>Rp '.number_format($detail->base_price_foreign, 2, ',', '.').'</div>';
        $html.= '</div>';
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
                                <td style="text-align: right;">
                                    '.number_format($value->price_local, 2, ',', '.').'
                                </td>
                                <td style="text-align: right;">
                                    '.number_format($value->price_foreign, 2, ',', '.').'
                                </td>
                            </tr>';
            }
        }else{
        $html.=             '<tr>
                                <td colspan="4" style="text-align: center;">
                                    <i>-- '.MultiLang('empty_data').' --</i>
                                </td>
                            </tr>';
        }
        $html.=         '</table>';
        $html.=     '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_rating_manual">'.MultiLang('is_rating_manual').'?</label>';
        $html.=     '<div>'.($detail->is_rating_manual == 1 ? MultiLang('yes') : MultiLang('no')).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="rating_manual">'.MultiLang('rating_manual_value').'</label>';
        $html.=     '<div>'.$detail->rating_manual.'</div>';
        $html.= '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="total_rater_manual">'.MultiLang('total_rater_manual').'</label>';
        $html.=     '<div>'.$detail->total_rater_manual.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="status">'.MultiLang('status').'</label>';
        $html.=     '<div>'.($detail->status == 1 ? MultiLang('active') : MultiLang('not_active')).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">
                    <label for="file_image">'.MultiLang('image').'</label>
                    <br>
                    <div class="row">';
                        for($i=1; $i<=4; $i++){
                            foreach ($detail_images as $key => $value) {
                                if($value->order == $i){
        $html.=             '<div class="col" style="text-align: center;">
                                <img style="width:180px; height:100px; border:1px dashed #C3C3C3; margin-bottom: 5px;" id="show_images_'.$i.'" src="'.(!empty($value->img) ? $path_tourpackages.$value->img : '../assets/images/upload-images.png').'" />

                            </div>';
                                }
                            }
                        }
        $html.='
                    </div>
                </div>';
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
        $path_tourpackages_upload = $this->config->item('path_tourpackages_upload');
        $detail_images = $this->data->getDetailTourpackagesImages($id);
        $delete = $this->data->deleteTourpackages($id);
        if($delete){
            if(!empty($detail_images)){
                foreach ($detail_images as $key => $value) {
                    @unlink($path_tourpackages_upload.$value->img);
                }
            }
            $result["status"] = TRUE;
            $result["message"] = MultiLang('msg_delete_success');
        }else{
            $result["status"] = FALSE;
            $result["message"] = MultiLang('msg_delete_failed');
        }

        echo json_encode($result);
    } 

    public function setid()
    {
        $session_data = array(
            'tourpackages_id' => $this->input->post('id', TRUE)
        );
        $this->session->set_userdata($session_data);
        if($this->session->userdata('tourpackages_id')){
            $result["status"] = TRUE;
        }else{
            $result["status"] = FALSE;
        }
        echo json_encode($result);
    } 
}
