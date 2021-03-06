<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

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
		$data['components'] = 'components/service';
		$data['active_menu_parent'] = 'cms';
        $data['active_menu'] = 'service';

		$this->load->view('home', $data);
	}
	
	public function data()
	{   
		$filter = array();
        $filter['keyword'] = $_POST['search']['value'];
        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1 => 'b.`servicetext_name`',
            2 => 'a.`service_type`',
            3 => 'a.`service_order`',
            4 => 'a.`service_status`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllService($filter);
        $count = $this->data->getTotalAllService($filter);
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->name;
                if($value->type == 0){
                    $type = MultiLang('information');
                }elseif($value->type == 1){
                    $type = MultiLang('tour_packages');
                }elseif($value->type == 2){
                    $type = MultiLang('ticket');
                }elseif($value->type == 3){
                    $type = MultiLang('venue');
                }else{
                    $type = '-';
                }
                $row[] = $type;
                $row[] = $value->order;
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
        $html.=     '<label for="type">'.MultiLang('type').' *</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type1" value="0" checked>
                        <label class="form-check-label" for="type1">
                            '.MultiLang('information').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type2" value="1">
                        <label class="form-check-label" for="type2">
                            '.MultiLang('tour_packages').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type3" value="2">
                        <label class="form-check-label" for="type3">
                            '.MultiLang('ticket').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type4" value="3">
                        <label class="form-check-label" for="type4">
                            '.MultiLang('venue').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group" id="content_div">';
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
        $html.=     '<label for="order">'.MultiLang('order').' *</label>';
        $html.=     '<input type="number" id="order" name="order" class="form-control" onkeypress="return isNumber(event)">';
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

        $path_service_upload = $this->config->item('path_service_upload');

        $name = $this->input->post('name', TRUE);
        $name_name = $this->input->post('name_name', TRUE);
        $content = ($this->input->post('type', TRUE) == 0 OR $this->input->post('type', TRUE) == 3) ? $this->input->post('content') : NULL;
        $content_name = ($this->input->post('type', TRUE) == 0 OR $this->input->post('type', TRUE) == 3) ? $this->input->post('content_name', TRUE) : NULL;
        $order = $this->input->post('order', TRUE);
        $type = $this->input->post('type', TRUE);
        $status = $this->input->post('status', TRUE);
        $file_image_value = $this->input->post('file_image_value');

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
        
        if(!empty($content) AND ($type==0 OR $type==3)){
            foreach ($content as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('content').' '.$content_name[$key].' '.MultiLang('required').'</li>';
                }
            }
        }

        if(empty($order)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('order').' '.MultiLang('required').'</li>';
        }
        
        if(isset($type) AND $type == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('type').' '.MultiLang('required').'</li>';
        }else{
            if($type != 0){
                $check = $this->data->checkServiceTypeExist($type);
                if(!empty($check->id)){
                    $validation = $validation && false;
                    if($type == 0){
                        $type_text = MultiLang('information');
                    }elseif($type == 1){
                        $type_text = MultiLang('tour_packages');
                    }elseif($type == 2){
                        $type_text = MultiLang('ticket');
                    }elseif($type == 3){
                        $type_text = MultiLang('venue');
                    }
                    $validation_text.= '<li>'.MultiLang('type').' <b>'.$type_text.'</b> '.MultiLang('existed').'</li>';
                }
            }
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
            $results = true;$content = $this->input->post('content', TRUE);
            $content_name = $this->input->post('content_name', TRUE);
            $upload_status = true;
            $msg_upload = '';
            $images_name = array();

            $max_size = '1024'; // in KB
            $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
            foreach ($file_image_value as $key => $value) {
                $upload = '';
                if(!empty($value)){
                    $upload = $this->data->uploadBase64($value, $path_service_upload, $max_size, $type_allow);
                    if(!$upload['status']){
                        $upload_status = $upload_status && false;
                        $msg_upload.= '<li>'.MultiLang('image').' '.($key+1).': '.$upload['message'].'</li>';
                    }
                }
                $images_name[$key+1] = (!empty($upload['file'])) ? $upload['file'] : NULL;
            }

            if($upload_status){
                $data = array(
                    'service_order' => $order,
                    'service_status' => $status,
                    'service_type' => $type,
                    'insert_user_id' => $user_id,
                    'insert_datetime' => $date
                );
                $results = $results && $this->data->addService($data, $name, $content, $images_name);
            
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
                            @unlink($path_service_upload.$value);
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
        $path_service = $this->config->item('path_service');
        $detail = $this->data->getDetailService($id);
        $detail_text = $this->data->getDetailServiceText($id);
        $detail_images = $this->data->getDetailServiceImages($id);
        $lang = $this->data->getLang();

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
        $html.=     '<label for="type">'.MultiLang('type').' *</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type1" value="0" '.($detail->type == 0 ? "checked" : "").'>
                        <label class="form-check-label" for="type1">
                            '.MultiLang('information').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type2" value="1" '.($detail->type == 1 ? "checked" : "").'>
                        <label class="form-check-label" for="type2">
                            '.MultiLang('tour_packages').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type3" value="2" '.($detail->type == 2 ? "checked" : "").'>
                        <label class="form-check-label" for="type3">
                            '.MultiLang('ticket').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="type" id="type4" value="3" '.($detail->type == 3 ? "checked" : "").'>
                        <label class="form-check-label" for="type4">
                            '.MultiLang('venue').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group" id="content_div">';
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
        $html.=     '<label for="order">'.MultiLang('order').' *</label>';
        $html.=     '<input type="number" id="order" name="order" class="form-control" onkeypress="return isNumber(event)" value="'.$detail->order.'">';
        $html.=     '<input type="hidden" id="id" name="id" value="'.$detail->id.'">';
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
                                        $type = pathinfo($path_service.$value->img, PATHINFO_EXTENSION);
                                        $base_64_images = base64_encode(file_get_contents($path_service.$value->img));
                                        $base_64_images = 'data:image/' . $type . ';base64,' .$base_64_images;
                                    }else{
                                        $base_64_images = '';
                                    }
        $html.=             '<div class="col" style="text-align: center;">
                                <label id="label_images_'.$i.'" for="images_'.$i.'" style="cursor: pointer;'.(!empty($value->img) ? 'display:none;' : '').'">
                                    <img style="width:180px; height:100px; border:1px dashed #C3C3C3;" src="../assets/images/upload-images.png" />
                                </label>
                                
                                <input type="file" name="images_'.$i.'" id="images_'.$i.'" style="display:none;" onchange="readURL(this,\''.$i.'\')" accept="image/*"/>

                                <img style="width:180px; height:100px; border:1px dashed #C3C3C3; margin-bottom: 5px; '.(!empty($value->img) ? '' : 'display:none;').'" id="show_images_'.$i.'" '.(!empty($value->img) ? 'src="'.$path_service.$value->img.'"' : '').' />
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
        $path_service_upload = $this->config->item('path_service_upload');

        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $name_name = $this->input->post('name_name', TRUE);
        $content = ($this->input->post('type', TRUE) == 0 OR $this->input->post('type', TRUE) == 3) ? $this->input->post('content') : NULL;
        $content_name = ($this->input->post('type', TRUE) == 0 OR $this->input->post('type', TRUE) == 3) ? $this->input->post('content_name', TRUE) : NULL;
        $order = $this->input->post('order', TRUE);
        $type = $this->input->post('type', TRUE);
        $status = $this->input->post('status', TRUE);
        $file_image_value = $this->input->post('file_image_value');
        $file_image_value_old = $this->input->post('file_image_value_old');

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
        
        if(!empty($content) AND ($type==0 OR $type==3)){
            foreach ($content as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('content').' '.$content_name[$key].' '.MultiLang('required').'</li>';
                }
            }
        }

        if(empty($order)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('order').' '.MultiLang('required').'</li>';
        }
        
        if(isset($type) AND $type == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('type').' '.MultiLang('required').'</li>';
        }else{
            if($type != 0){
                $check = $this->data->checkServiceTypeExist($type, $id);
                
                if(!empty($check->id)){
                    $validation = $validation && false;
                    if($type == 0){
                        $type_text = MultiLang('information');
                    }elseif($type == 1){
                        $type_text = MultiLang('tour_packages');
                    }elseif($type == 2){
                        $type_text = MultiLang('ticket');
                    }elseif($type == 3){
                        $type_text = MultiLang('venue');
                    }
                    $validation_text.= '<li>'.MultiLang('type').' <b>'.$type_text.'</b> '.MultiLang('existed').'</li>';
                }
            }
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
                    $upload = $this->data->uploadBase64($value, $path_service_upload, $max_size, $type_allow);
                    if(!$upload['status']){
                        $upload_status = $upload_status && false;
                        $msg_upload.= '<li>'.MultiLang('image').' '.($key+1).': '.$upload['message'].'</li>';
                    }
                }
                $images_name[$key+1] = (!empty($upload['file']) ? $upload['file'] : NULL);
            }

            if($upload_status){
                $data = array(
                    'service_order' => $order,
                    'service_status' => $status,
                    'service_type' => $type,
                    'update_user_id' => $user_id,
                    'update_datetime' => $date
                );
                $results = $results && $this->data->updateService($data, $id, $name, $content, $images_name);
            
                if ($results) {
                    $result["status"] = TRUE;
                    $result["message"] = MultiLang('msg_update_success');
                    if(!empty($file_image_value) AND !empty($file_image_value_old)){
                        foreach ($file_image_value as $key => $value) {
                            @unlink($path_service_upload.$file_image_value_old[$key]);
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
                            @unlink($path_service_upload.$value);
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
        $path_service = $this->config->item('path_service');
        $detail = $this->data->getDetailService($id);
        $detail_text = $this->data->getDetailServiceText($id);
        $detail_images = $this->data->getDetailServiceImages($id);
        $lang = $this->data->getLang();

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
        $html.=     '<label for="type">'.MultiLang('type').'</label>';
                if($detail->type == 0){
        $html.=     '<div>'.MultiLang('information').'</div>';
                }elseif($detail->type == 1){
        $html.=     '<div>'.MultiLang('tour_packages').'</div>';
                }elseif($detail->type == 2){
        $html.=     '<div>'.MultiLang('ticket').'</div>';
                }elseif($detail->type == 3){
        $html.=     '<div>'.MultiLang('venue').'</div>';
                }
        $html.= '</div>';
        if($detail->type == 0){
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
        }
        $html.= '<div class="form-group">';
        $html.=     '<label for="order">'.MultiLang('order').'</label>';
        $html.=     '<div>'.$detail->order.'</div>';
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
                                <img style="width:180px; height:100px; border:1px dashed #C3C3C3; margin-bottom: 5px;" id="show_images_'.$i.'" src="'.(!empty($value->img) ? $path_service.$value->img : '../assets/images/upload-images.png').'" />

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
        $path_service_upload = $this->config->item('path_service_upload');
        $detail_images = $this->data->getDetailServiceImages($id);
        $delete = $this->data->deleteService($id);
        if($delete){
            if(!empty($detail_images)){
                foreach ($detail_images as $key => $value) {
                    @unlink($path_service_upload.$value->img);
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
}
