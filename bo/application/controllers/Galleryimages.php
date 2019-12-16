<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galleryimages extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("data");
		if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
        }
        
        if(empty($this->session->userdata('gallery_id'))){
            redirect(base_url().'gallery');
        }
	}

	public function index()
	{
		$data['components'] = 'components/galleryimages';
		$data['active_menu_parent'] = 'cms';
        $data['active_menu'] = 'gallery';
        $data['id'] = $this->session->userdata('gallery_id');
        $title = $this->data->getDetailGalleryTitle($this->session->userdata('gallery_id'));
        $data['title'] = $title->title;

		$this->load->view('home', $data);
	}
	
	public function data($id)
	{   
		$filter = array();
        $filter['id'] = $id;
        $filter['keyword'] = $_POST['search']['value'];
        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1 => 'b.`gallerytext_title`',
            2 => 'a.`gallery_order`',
            3 => 'a.`gallery_status`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllGalleryImages($filter);
        $count = $this->data->getTotalAllGalleryImages($filter);
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->title;
                $row[] = $value->order;
                $row[] = ($value->status == 1) ? MultiLang('active') : MultiLang('not_active');
    
                //add html for action
                $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->id.'\')"><i class="fas fa-search"></i></a>
                        <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="'.MultiLang('edit').'" onclick="edit('."'".$value->id."'".')"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="'.MultiLang('delete').'" onclick="deletes('."'".$value->id."','".$value->title."'".')"><i class="fas fa-trash-alt"></i></a>';
            
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
        $html.=     '<label for="title">'.MultiLang('title').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;';
        $html.=     '<input id="title_<?php echo $value->code;?>" name="title['.$value->code.']" class="form-control">';
        $html.=     '<input type="hidden" id="title_name_<?php echo $value->code;?>" name="title_name['.$value->code.']" value="'.$value->name.'" >';
        $html.=     '<br>';
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="link">'.MultiLang('link').'</label>';
        $html.=     '<input type="text" id="link" name="link" class="form-control">';
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
                    <div class="row">
                        <div class="col" style="text-align: center; height: 245px;">
                            <label id="label_images" for="images" style="cursor: pointer;">
                                <img style="width:360px; height:200px; border:1px dashed #C3C3C3;" src="../assets/images/upload-images.png" />
                            </label>
                            
                            <input type="file" name="images" id="images" style="display:none;" onchange="readURL(this)" accept="image/*"/>

                            <img style="width:360px; height:200px; border:1px dashed #C3C3C3; margin-bottom: 5px; display:none;" id="show_images" />
                            <br>
                            <div style="height: 40px;">
                                <span id="remove" class="btn btn-warning" onclick="removeImage()" style="cursor: pointer; margin-bottom: 5px; display:none;">
                                    '.MultiLang('delete').'
                                </span>
                                <span class="msg_images" id="msg_images" style="color: red;"></span>
                            </div>

                            <input type="hidden" id="file_image_value" name="file_image_value"/>
                        </div>
                    </div>';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function add()
    {
        $path_gallery_upload = $this->config->item('path_gallery_upload');

        $title = $this->input->post('title', TRUE);
        $title_name = $this->input->post('title_name', TRUE);
        $link = $this->input->post('link', TRUE);
        $order = $this->input->post('order', TRUE);
        $status = $this->input->post('status', TRUE);
        $file_image_value = $this->input->post('file_image_value');

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        // if(!empty($title)){
        //     foreach ($title as $key => $value) {
        //         if(empty($value)){
        //             $validation = $validation && false;
        //             $validation_text.= '<li>'.MultiLang('title').' '.$title_name[$key].' '.MultiLang('required').'</li>';
        //         }
        //     }
        // }

        if(empty($order)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('order').' '.MultiLang('required').'</li>';
        }

        if(!isset($status) AND $status == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('status').' '.MultiLang('required').'</li>';
        }

        if(empty($file_image_value)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('image').' '.MultiLang('required').'</li>';
        }

        if($validation){
            $results = true;
            $upload['status'] = true;

            if(!empty($file_image_value)){
                $max_size = '1024'; // in KB
                $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
                $upload = $this->data->uploadBase64($file_image_value, $path_gallery_upload, $max_size, $type_allow);
            }

            if($upload['status']){
                $data = array(
                    'gallery_parent_id' => $this->session->userdata('gallery_id'),
                    'gallery_type' => 2,
                    'gallery_img' => (!empty($upload['file'])) ? $upload['file'] : NULL,
                    'gallery_link' => (!empty($link)) ? $link : NULL,
                    'gallery_order' => $order,
                    'gallery_status' => $status,
                    'insert_user_id' => $user_id,
                    'insert_datetime' => $date
                );
                $results = $results && $this->data->addGalleryImages($data, $title);
            
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
                    @unlink($path_gallery_upload.$file_image_value);
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

        $path_language = $this->config->item('path_language');
        $path_gallery = $this->config->item('path_gallery');
        $detail = $this->data->getDetailGalleryImages($id);
        $detail_text = $this->data->getDetailGalleryImagesText($id);
        $lang = $this->data->getLang();

        $html = '<div class="form-group">';
        $html.=     '<label for="title">'.MultiLang('title').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')';
        $html.=     '<input type="text" id="title_<?php echo $value->code;?>" name="title['.$value->code.']" class="form-control" value="'.$v->title.'">';
        $html.=     '<input type="hidden" id="title_name_<?php echo $value->code;?>" name="title_name['.$value->code.']" value="'.$value->name.'" >';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="link">'.MultiLang('link').'</label>';
        $html.=     '<input type="text" id="link" name="link" class="form-control" value="'.$detail->link.'">';
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
        if(!empty($detail->img)){
            $type = pathinfo($path_gallery.$detail->img, PATHINFO_EXTENSION);
            $base_64_images = base64_encode(file_get_contents($path_gallery.$detail->img));
            $base_64_images = 'data:image/' . $type . ';base64,' .$base_64_images;
        }else{
            $base_64_images = '';
        }
        $html.= '<div class="form-group">
                    <label for="file_image">'.MultiLang('image').' *</label>
                    <br>
                    <div class="row">
                        <div class="col" style="text-align: center; height: 245px;">
                            <label id="label_images" for="images" style="cursor: pointer;'.(!empty($detail->img) ? 'display:none;' : '').'">
                                <img style="width:360px; height:200px; border:1px dashed #C3C3C3;" src="../assets/images/upload-images.png" />
                            </label>
                            
                            <input type="file" name="images" id="images" style="display:none;" onchange="readURL(this)" accept="image/*"/>

                            <img style="width:360px; height:200px; border:1px dashed #C3C3C3; margin-bottom: 5px; '.(!empty($detail->img) ? '' : 'display:none;').'" id="show_images" '.(!empty($detail->img) ? 'src="'.$path_gallery.$detail->img.'"' : '').' />
                            <br>
                            <div style="height: 40px;">
                                <span id="remove" class="btn btn-warning" onclick="removeImage()" style="cursor: pointer; margin-bottom: 5px; '.(!empty($detail->img) ? '' : 'display:none;').'">
                                    '.MultiLang('delete').'
                                </span>
                                <span class="msg_images" id="msg_images" style="color: red;"></span>
                            </div>

                            <input type="hidden" id="file_image_value" name="file_image_value" value="'.$base_64_images.'"/>
                            <input type="hidden" id="file_image_value_old" name="file_image_value_old" value="'.$detail->img.'"/>
                        </div>
                    </div>';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function edit()
    {   
        $path_gallery_upload = $this->config->item('path_gallery_upload');

        $id = $this->input->post('id', TRUE);
        $title = $this->input->post('title', TRUE);
        $title_name = $this->input->post('title_name', TRUE);
        $link = $this->input->post('link', TRUE);
        $order = $this->input->post('order', TRUE);
        $status = $this->input->post('status', TRUE);
        $file_image_value = $this->input->post('file_image_value');
        $file_image_value_old = $this->input->post('file_image_value_old');

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        // if(!empty($title)){
        //     foreach ($title as $key => $value) {
        //         if(empty($value)){
        //             $validation = $validation && false;
        //             $validation_text.= '<li>'.MultiLang('title').' '.$title_name[$key].' '.MultiLang('required').'</li>';
        //         }
        //     }
        // }

        if(empty($order)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('order').' '.MultiLang('required').'</li>';
        }

        if(!isset($status) AND $status == ''){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('status').' '.MultiLang('required').'</li>';
        }

        if(empty($file_image_value)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('image').' '.MultiLang('required').'</li>';
        }

        if($validation){
            $results = true;
            $upload['status'] = true;

            if(!empty($file_image_value)){
                $max_size = '1024'; // in KB
                $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
                $upload = $this->data->uploadBase64($file_image_value, $path_gallery_upload, $max_size, $type_allow);
            }

            if($upload['status']){
                if(!empty($file_image_value)){
                    $data = array(
                        'gallery_img' => (!empty($upload['file'])) ? $upload['file'] : NULL,
                        'gallery_link' => (!empty($link)) ? $link : NULL,
                        'gallery_order' => $order,
                        'gallery_status' => $status,
                        'update_user_id' => $user_id,
                        'update_datetime' => $date
                    );
                }else{
                    $data = array(
                        'gallery_order' => $order,
                        'gallery_status' => $status,
                        'update_user_id' => $user_id,
                        'update_datetime' => $date
                    );
                }
                $results = $results && $this->data->updateGalleryImages($data, $id, $title);
            
                if ($results) {
                    $result["status"] = TRUE;
                    $result["message"] = MultiLang('msg_update_success');
                    if(!empty($file_image_value) AND !empty($file_image_value_old)){
                        @unlink($path_gallery_upload.$file_image_value_old);
                    }
                } else {
                    $result["status"] = FALSE;
                    $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    $result["message"].= '<li>'.MultiLang('msg_update_failed').'</li>';
                    $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>';
                    $result["message"].= '</div>';
                    @unlink($path_gallery_upload.$file_image_value);
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

        $path_language = $this->config->item('path_language');
        $path_gallery = $this->config->item('path_gallery');
        $detail = $this->data->getDetailGalleryImages($id);
        $detail_text = $this->data->getDetailGalleryImagesText($id);
        $lang = $this->data->getLang();

        $html = '<div class="form-group">';
        $html.=     '<label for="title">'.MultiLang('title').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;';
        $html.=     '<div style=" border:1px dashed #3e3e3e; padding: 5px; margin: 5px 0;">'.$v->title.'</div>';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="link">'.MultiLang('link').'</label>';
        $html.=     '<div id="link">'.$detail->link.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="order">'.MultiLang('order').'</label>';
        $html.=     '<div id="order">'.$detail->order.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="status">'.MultiLang('status').'</label>';
        $html.=     '<div id="status">'.($detail->status == 1 ? MultiLang('active') : MultiLang('not_active')).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="order">'.MultiLang('image').'</label>';
        $html.=     '<center><img src="'.(empty($detail->img) ? $path_gallery.'no-image-available.jpg' : $path_gallery.$detail->img).'" style="width:360px; height:200px; border:1px dashed #C3C3C3;" /></center>';
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
        $path_gallery_upload = $this->config->item('path_gallery_upload');
        $detail = $this->data->getDetailGalleryImages($id);
        $delete = $this->data->deleteGalleryImages($id);
        if($delete){
            @unlink($path_gallery_upload.$detail->img);
            $result["status"] = TRUE;
            $result["message"] = MultiLang('msg_delete_success');
        }else{
            $result["status"] = FALSE;
            $result["message"] = MultiLang('msg_delete_failed');
        }

        echo json_encode($result);
    }
}
