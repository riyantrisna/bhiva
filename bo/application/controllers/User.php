<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
		$data['components'] = 'components/user';
		$data['active_menu_parent'] = 'setting';
        $data['active_menu'] = 'user';

		$this->load->view('home', $data);
	}
	
	public function data()
	{   
		$filter = array();
        $filter['keyword'] = $_POST['search']['value'];
        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1 => 'a.`user_real_name`',
            2 => 'a.`user_email`',
            3 => 'a.`user_phone`',
            4 => 'a.`user_is_admin`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllUser($filter);
        $count = $this->data->getTotalAllUser($filter);
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->real_name;
                $row[] = $value->email;
                $row[] = $value->phone;
                $row[] = ($value->is_admin == 1) ? MultiLang('yes') : MultiLang('no');
    
                //add html for action
                $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->id.'\')"><i class="fas fa-search"></i></a>
                        <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="'.MultiLang('edit').'" onclick="edit('."'".$value->id."'".')"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="'.MultiLang('delete').'" onclick="deletes('."'".$value->id."','".$value->real_name."'".')"><i class="fas fa-trash-alt"></i></a>';
            
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

        $html = '<div class="form-group">';
        $html.=     '<label for="name">'.MultiLang('name').' *</label>';
        $html.=     '<input type="text" id="name" name="name" class="form-control">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="email">'.MultiLang('email').' *</label>';
        $html.=     '<input type="email" id="email" name="email" class="form-control">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="phone">'.MultiLang('phone').'</label>';
        $html.=     '<input type="number" id="phone" name="phone" class="form-control" onkeypress="return isNumber(event)">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="gender">'.MultiLang('gender').' *</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender1" value="male" checked>
                        <label class="form-check-label" for="gender1">
                            '.MultiLang('male').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender2" value="female">
                        <label class="form-check-label" for="gender2">
                            '.MultiLang('female').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="birthday">'.MultiLang('birthday').' *</label>';
        $html.=     '<input type="text" id="birthday" name="birthday" class="form-control" placeholder="yyyy-mm-dd">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="address">'.MultiLang('address').'</label>';
        $html.=     '<textarea id="address" name="address" class="form-control"></textarea>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_admin">'.MultiLang('is_admin').'?</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_admin" id="is_admin">
                        <label class="form-check-label" for="is_admin">
                        '.MultiLang('yes').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="lang">'.MultiLang('language').' *</label>';
        $html.=     '<select id="lang" name="lang" class="form-control">';
        $html.=         '<option value="">';
        $html.=             '-- '.MultiLang('select').' --';
        $html.=         '</option>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
        $html.=         '<option value="'.$value->code.'">';
        $html.=             $value->name;
        $html.=         '</option>';
            }
        }
        $html.=     '</select>';
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
                    <div class="row">
                        <div class="col" style="text-align: center;">
                            <label id="label_images" for="images" style="cursor: pointer;">
                                <img style="width:150px; height:150px; border:1px dashed #C3C3C3;" src="../assets/images/upload-image.png" />
                            </label>
                            
                            <input type="file" name="images" id="images" style="display:none;" onchange="readURL(this)" accept="image/*"/>

                            <img style="width:150px; height:150px; border:1px dashed #C3C3C3; margin-bottom: 5px; display:none;" id="show_images" />
                            <br>
                            <div style="height: 40px;">
                                <span id="remove" class="btn btn-warning" onclick="removeImage()" style="cursor: pointer; margin-bottom: 5px; display:none;">
                                    '.MultiLang('delete').'
                                </span>
                                <span class="msg_images" id="msg_images" style="color: red;"></span>
                            </div>

                            <input type="hidden" id="file_photo_value" name="file_photo_value"/>
                        </div>
                    </div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="desc">'.MultiLang('note').'</label>';
        $html.=     '<textarea id="desc" name="desc" class="form-control"></textarea>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="password">'.MultiLang('password').' *</label>';
        $html.=     '<input type="password" id="password" name="password" class="form-control">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="retype_password">'.MultiLang('retype_password').' *</label>';
        $html.=     '<input type="password" id="retype_password" name="retype_password" class="form-control">';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function add()
    {
        $path_user_upload = $this->config->item('path_user_upload');
        $name = $this->input->post('name', TRUE);
        $email = $this->input->post('email', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $gender = $this->input->post('gender', TRUE);
        $birthday = $this->input->post('birthday', TRUE);
        $address = $this->input->post('address', TRUE);
        $is_admin = $this->input->post('is_admin', TRUE);
        $lang = $this->input->post('lang', TRUE);
        $status = $this->input->post('status', TRUE);
        $file_photo_value = $this->input->post('file_photo_value');
        $desc = $this->input->post('desc', TRUE);
        $password = $this->input->post('password', TRUE);
        $retype_password = $this->input->post('retype_password', TRUE);

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
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

        if(!isset($status) AND $status == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('status').' '.MultiLang('required').'</li>';
        }

        if(empty($password)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('password').' '.MultiLang('required').'</li>';
        }

        if(empty($retype_password)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('retype_password').' '.MultiLang('required').'</li>';
        }

        if(!empty($password) AND !empty($retype_password) AND $password !== $retype_password){
			$validation = $validation && false;
			$validation_text.= '<li>'.MultiLang('password_and_retype_password_not_match').'</li>';
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
                $data = array(
                    'user_real_name' => $name,
                    'user_email' => $email,
                    'user_phone' => $phone,
                    'user_gender' => $gender,
                    'user_birthday' => $birthday,
                    'user_address' => $address,
                    'user_is_admin' => isset($is_admin) ? 1 : 0,
                    'user_lang' => $lang,
                    'user_status' => $status,
                    'user_photo' => (!empty($upload['file'])) ? $upload['file'] : NULL,
                    'user_desc' => $desc,
                    'user_password' => MD5($password),
                    'insert_user_id' => $user_id,
                    'insert_datetime' => $date
                );
                $results = $results && $this->data->addUser($data);
            
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

    public function edit_view($id){

        $path_user = $this->config->item('path_user');
        $detail = $this->data->getDetailUser($id);
        $lang = $this->data->getLang();

        $html = '<div class="form-group">';
        $html.=     '<label for="name">'.MultiLang('name').' *</label>';
        $html.=     '<input type="text" id="name" name="name" class="form-control" value="'.$detail->real_name.'">';
        $html.=     '<input type="hidden" id="id" name="id" value="'.$detail->id.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="email">'.MultiLang('email').' *</label>';
        $html.=     '<input disabled="disabled" type="email" id="email" name="email" class="form-control" value="'.$detail->email.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="phone">'.MultiLang('phone').'</label>';
        $html.=     '<input type="number" id="phone" name="phone" class="form-control" onkeypress="return isNumber(event)" value="'.$detail->phone.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="gender">'.MultiLang('gender').' *</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender1" value="male" '.($detail->gender == "male" ? "checked" : "").'>
                        <label class="form-check-label" for="gender1">
                            '.MultiLang('male').'
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="gender2" value="female" '.($detail->gender == "female" ? "checked" : "").'>
                        <label class="form-check-label" for="gender2">
                            '.MultiLang('female').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="birthday">'.MultiLang('birthday').' *</label>';
        $html.=     '<input type="text" id="birthday" name="birthday" class="form-control" placeholder="yyyy-mm-dd" value='.$detail->birthday.'>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="address">'.MultiLang('address').'</label>';
        $html.=     '<textarea id="address" name="address" class="form-control">'.$detail->address.'</textarea>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_admin">'.MultiLang('is_admin').'?</label>';
        $html.=     '<div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_admin" id="is_admin" '.($detail->is_admin == 1 ? "checked" : "").'>
                        <label class="form-check-label" for="is_admin">
                        '.MultiLang('yes').'
                        </label>
                    </div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="lang">'.MultiLang('language').' *</label>';
        $html.=     '<select id="lang" name="lang" class="form-control">';
        $html.=         '<option value="">';
        $html.=             '-- '.MultiLang('select').' --';
        $html.=         '</option>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
        $html.=         '<option value="'.$value->code.'" '.($detail->lang == $value->code ? "selected" : "").'>';
        $html.=             $value->name;
        $html.=         '</option>';
            }
        }
        $html.=     '</select>';
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
        if(!empty($detail->photo)){
            $type = pathinfo($path_user.$detail->photo, PATHINFO_EXTENSION);
            $base_64_images = base64_encode(file_get_contents($path_user.$detail->photo));
            $base_64_images = 'data:image/' . $type . ';base64,' .$base_64_images;
        }else{
            $base_64_images = '';
        }
        $html.= '<div class="form-group">
                    <label for="file_image">'.MultiLang('image').' *</label>
                    <br>
                    <div class="row">
                        <div class="col" style="text-align: center;">
                            <label id="label_images" for="images" style="cursor: pointer;'.(!empty($detail->photo) ? 'display:none;' : '').'">
                                <img style="width:150px; height:150px; border:1px dashed #C3C3C3;" src="../assets/images/upload-image.png" />
                            </label>
                            
                            <input type="file" name="images" id="images" style="display:none;" onchange="readURL(this)" accept="image/*"/>

                            <img style="width:150px; height:150px; border:1px dashed #C3C3C3; margin-bottom: 5px; '.(!empty($detail->photo) ? '' : 'display:none;').'" id="show_images" '.(!empty($detail->photo) ? 'src="'.$path_user.$detail->photo.'"' : '').' />
                            <br>
                            <div style="height: 40px;">
                                <span id="remove" class="btn btn-warning" onclick="removeImage()" style="cursor: pointer; margin-bottom: 5px; '.(!empty($detail->photo) ? '' : 'display:none;').'">
                                    '.MultiLang('delete').'
                                </span>
                                <span class="msg_images" id="msg_images" style="color: red;"></span>
                            </div>

                            <input type="hidden" id="file_photo_value" name="file_photo_value" value="'.$base_64_images.'"/>
                            <input type="hidden" id="file_photo_value_old" name="file_photo_value_old" value="'.$detail->photo.'"/>
                        </div>
                    </div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="desc">'.MultiLang('note').'</label>';
        $html.=     '<textarea id="desc" name="desc" class="form-control">'.$detail->desc.'</textarea>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="password">'.MultiLang('password').'</label>';
        $html.=     '<input type="password" id="password" name="password" class="form-control">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="retype_password">'.MultiLang('retype_password').'</label>';
        $html.=     '<input type="password" id="retype_password" name="retype_password" class="form-control">';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function edit()
    {   
        $path_user_upload = $this->config->item('path_user_upload');
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $gender = $this->input->post('gender', TRUE);
        $birthday = $this->input->post('birthday', TRUE);
        $address = $this->input->post('address', TRUE);
        $is_admin = $this->input->post('is_admin', TRUE);
        $lang = $this->input->post('lang', TRUE);
        $status = $this->input->post('status', TRUE);
        $file_photo_value = $this->input->post('file_photo_value');
        $file_photo_value_old = $this->input->post('file_photo_value_old');
        $desc = $this->input->post('desc', TRUE);
        $password = $this->input->post('password', TRUE);
        $retype_password = $this->input->post('retype_password', TRUE);

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(empty($name)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('name').' '.MultiLang('required').'</li>';
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

        if(!isset($status) AND $status == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('status').' '.MultiLang('required').'</li>';
        }

        if(!empty($password) AND empty($retype_password)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('retype_password').' '.MultiLang('required').'</li>';
        }

        if(empty($password) AND !empty($retype_password)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('password').' '.MultiLang('required').'</li>';
        }

        if(!empty($password) AND !empty($retype_password) AND $password !== $retype_password){
			$validation = $validation && false;
			$validation_text.= '<li>'.MultiLang('password_and_retype_password_not_match').'</li>';
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
                    if(!empty($password) AND !empty($retype_password)){
                        $data = array(
                            'user_real_name' => $name,
                            'user_phone' => $phone,
                            'user_gender' => $gender,
                            'user_birthday' => $birthday,
                            'user_address' => $address,
                            'user_is_admin' => isset($is_admin) ? 1 : 0,
                            'user_lang' => $lang,
                            'user_status' => $status,
                            'user_photo' => (!empty($upload['file'])) ? $upload['file'] : NULL,
                            'user_desc' => $desc,
                            'user_password' => MD5($password),
                            'update_user_id' => $user_id,
                            'update_datetime' => $date
                        );
                    }else{
                        $data = array(
                            'user_real_name' => $name,
                            'user_phone' => $phone,
                            'user_gender' => $gender,
                            'user_birthday' => $birthday,
                            'user_address' => $address,
                            'user_is_admin' => isset($is_admin) ? 1 : 0,
                            'user_lang' => $lang,
                            'user_status' => $status,
                            'user_photo' => (!empty($upload['file'])) ? $upload['file'] : NULL,
                            'user_desc' => $desc,
                            'update_user_id' => $user_id,
                            'update_datetime' => $date
                        );
                    }
                }else{
                    if(!empty($password) AND !empty($retype_password)){
                        $data = array(
                            'user_real_name' => $name,
                            'user_phone' => $phone,
                            'user_gender' => $gender,
                            'user_birthday' => $birthday,
                            'user_address' => $address,
                            'user_is_admin' => isset($is_admin) ? 1 : 0,
                            'user_lang' => $lang,
                            'user_status' => $status,
                            'user_photo' => NULL,
                            'user_desc' => $desc,
                            'user_password' => MD5($password),
                            'update_user_id' => $user_id,
                            'update_datetime' => $date
                        );
                    }else{
                        $data = array(
                            'user_real_name' => $name,
                            'user_phone' => $phone,
                            'user_gender' => $gender,
                            'user_birthday' => $birthday,
                            'user_address' => $address,
                            'user_is_admin' => isset($is_admin) ? 1 : 0,
                            'user_lang' => $lang,
                            'user_status' => $status,
                            'user_photo' => NULL,
                            'user_desc' => $desc,
                            'update_user_id' => $user_id,
                            'update_datetime' => $date
                        );
                    }
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

    public function detail($id){

        $path_user = $this->config->item('path_user');
        $detail = $this->data->getDetailUser($id);
        $lang = $this->data->getLang();

        $html = '<div class="form-group" style="text-align: center;">';
        $html.= '   <img src="'.(empty($detail->photo) ? $path_user.'default.png' : $path_user.$detail->photo).'" class="img-circle" style="width: 100px; height: 100px;" />';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="name">'.MultiLang('name').'</label>';
        $html.=     '<div id="name">'.$detail->real_name.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="email">'.MultiLang('email').'</label>';
        $html.=     '<div id="email">'.$detail->email.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="phone">'.MultiLang('phone').'</label>';
        $html.=     '<div id="phone">'.$detail->phone.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="gender">'.MultiLang('gender').'</label>';
        $html.=     '<div id="gender">'.($detail->gender == "male" ? MultiLang('male') : MultiLang('female')).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="birthday">'.MultiLang('birthday').'</label>';
        $html.=     '<div id="birthday">'.($this->data->getDateIndo($detail->birthday)).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="address">'.MultiLang('address').'</label>';
        $html.=     '<div id="address">'.$detail->address.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_admin">'.MultiLang('is_admin').'?</label>';
        $html.=     '<div id="is_admin">'.($detail->is_admin == 1 ? MultiLang('yes') : MultiLang('no')).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="lang">'.MultiLang('language').'</label>';
        $html.=      '<div id="lang">'.$detail->lang_name.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="status">'.MultiLang('status').'</label>';
        $html.=     '<div id="status">'.($detail->status == 1 ? MultiLang('active') : MultiLang('not_active')).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="desc">'.MultiLang('note').'</label>';
        $html.=     '<div id="desc">'.$detail->desc.'</div>';
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
        $path_user_upload = $this->config->item('path_user_upload');
        $detail = $this->data->getDetailUser($id);
        $delete = $this->data->deleteUser($id);
        if($delete){
            @unlink($path_user_upload.$detail->photo);
            $result["status"] = TRUE;
            $result["message"] = MultiLang('msg_delete_success');
        }else{
            $result["status"] = FALSE;
            $result["message"] = MultiLang('msg_delete_failed');
        }

        echo json_encode($result);
    } 
}
