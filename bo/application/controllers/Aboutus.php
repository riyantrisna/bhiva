<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends CI_Controller {

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
		$data['components'] = 'components/aboutus';
		$data['active_menu_parent'] = 'cms';
        $data['active_menu'] = 'aboutus';

        $path_language = $this->config->item('path_language');
        $path_aboutus = $this->config->item('path_aboutus');
        $detail = $this->data->getDetailAboutus(1);
        $detail_text = $this->data->getDetailAboutusText(1);
        $lang = $this->data->getLang();

        if(!empty($detail->img)){
            $type = pathinfo($path_aboutus.$detail->img, PATHINFO_EXTENSION);
            $base_64_images = base64_encode(file_get_contents($path_aboutus.$detail->img));
            $base_64_images = 'data:image/' . $type . ';base64,' .$base_64_images;
        }else{
            $base_64_images = '';
        }
        $html = '<div class="form-group">
                    <label for="file_image">'.MultiLang('image').' *</label>
                    <br>
                    <div class="row">
                        <div class="col" style="text-align: center; height: 245px;">
                            <label id="label_images" for="images" style="cursor: pointer;'.(!empty($detail->img) ? 'display:none;' : '').'">
                                <img style="width:360px; height:200px; border:1px dashed #C3C3C3;" src="../assets/images/upload-images.png" />
                            </label>
                            
                            <input type="file" name="images" id="images" style="display:none;" onchange="readURL(this)" accept="image/*"/>

                            <img style="width:360px; height:200px; border:1px dashed #C3C3C3; margin-bottom: 5px; '.(!empty($detail->img) ? '' : 'display:none;').'" id="show_images" '.(!empty($detail->img) ? 'src="'.$path_aboutus.$detail->img.'"' : '').' />
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
        $html.=     '<label for="inserted">'.MultiLang('inserted').'</label>';
        $html.=     '<div>'.(!empty($detail->insert_user) ? $detail->insert_user.',' : '').' '.($this->data->getDatetimeIndo($detail->insert_datetime)).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="updated">'.MultiLang('updated').'</label>';
        $html.=     '<div>'.(!empty($detail->update_user) ? $detail->update_user.',' : '').' '.($this->data->getDatetimeIndo($detail->update_datetime)).'</div>';
        $html.= '</div>';
        $data['html'] = $html;

		$this->load->view('home', $data);
	}

    public function edit()
    {   
        $path_aboutus_upload = $this->config->item('path_aboutus_upload');
        $content = $this->input->post('content');
        $content_name = $this->input->post('content_name', TRUE);
        $file_image_value = $this->input->post('file_image_value');
        $file_image_value_old = $this->input->post('file_image_value_old');

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(!empty($content)){
            foreach ($content as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('content').' '.$content_name[$key].' '.MultiLang('required').'</li>';
                }
            }
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
                $upload = $this->data->uploadBase64($file_image_value, $path_aboutus_upload, $max_size, $type_allow);
            }

            if($upload['status']){
                if(!empty($file_image_value)){
                    $data = array(
                        'aboutus_img' => (!empty($upload['file'])) ? $upload['file'] : NULL,
                        'update_user_id' => $user_id,
                        'update_datetime' => $date
                    );
                }else{
                    $data = array(
                        'update_user_id' => $user_id,
                        'update_datetime' => $date
                    );
                }
                $results = $results && $this->data->updateAboutus($data, 1, $content);
            
                if ($results) {
                    $result["status"] = TRUE;
                    $result["message"] = MultiLang('msg_update_success');
                    if(!empty($file_image_value) AND !empty($file_image_value_old)){
                        @unlink($path_aboutus_upload.$file_image_value_old);
                        $result['new_file'] = $upload['file'];
                    }
                } else {
                    $result["status"] = FALSE;
                    $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    $result["message"].= '<li>'.MultiLang('msg_update_failed').'</li>';
                    $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>';
                    $result["message"].= '</div>';
                    @unlink($path_aboutus_upload.$file_image_value);
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

}
