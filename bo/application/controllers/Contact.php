<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

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
		$data['components'] = 'components/contact';
		$data['active_menu_parent'] = 'cms';
        $data['active_menu'] = 'contact';

        $path_contact = $this->config->item('path_contact');
        $detail = $this->data->getDetailContact(1);

        $html = '<div class="form-group">';
        $html.=     '<label for="address">'.MultiLang('address').' *</label>';
        $html.=     '<textarea id="address" name="address" class="form-control textarea">'.$detail->address.'</textarea>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="email">'.MultiLang('email').' *</label>';
        $html.=     '<input type="text" id="email" name="email" class="form-control" value="'.$detail->email.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="phone">'.MultiLang('phone').' *</label>';
        $html.=     '<input type="number" id="phone" name="phone" class="form-control" onkeypress="return isNumber(event)" value="'.$detail->phone.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="wa">'.MultiLang('whatsapp').' *</label>';
        $html.=     '<input type="number" id="wa" name="wa" class="form-control" onkeypress="return isNumber(event)" value="'.$detail->wa.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="fb">'.MultiLang('facebook').' *</label>';
        $html.=     '<input type="text" id="fb" name="fb" class="form-control" value="'.$detail->fb.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="ig">'.MultiLang('instagram').' *</label>';
        $html.=     '<input type="text" id="ig" name="ig" class="form-control" value="'.$detail->ig.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="twitter">'.MultiLang('twitter').' *</label>';
        $html.=     '<input type="text" id="twitter" name="twitter" class="form-control" value="'.$detail->twitter.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="link_maps">'.MultiLang('link_maps').' *</label>';
        $html.=    '<textarea id="link_maps" name="link_maps" class="form-control">'.$detail->link_maps.'</textarea>';
        $html.= '</div>';
        if(!empty($detail->img_maps)){
            $type = pathinfo($path_contact.$detail->img_maps, PATHINFO_EXTENSION);
            $base_64_images = base64_encode(file_get_contents($path_contact.$detail->img_maps));
            $base_64_images = 'data:image/' . $type . ';base64,' .$base_64_images;
        }else{
            $base_64_images = '';
        }
        $html.= '<div class="form-group">
                    <label for="file_image">'.MultiLang('image_maps').' *</label>
                    <br>
                    <div class="row">
                        <div class="col" style="text-align: center; height: 245px;">
                            <label id="label_images" for="images" style="cursor: pointer;'.(!empty($detail->img_maps) ? 'display:none;' : '').'">
                                <img style="width:360px; height:200px; border:1px dashed #C3C3C3;" src="assets/images/upload-images.png" />
                            </label>
                            
                            <input type="file" name="images" id="images" style="display:none;" onchange="readURL(this)" accept="image/*"/>

                            <img style="width:360px; height:200px; border:1px dashed #C3C3C3; margin-bottom: 5px; '.(!empty($detail->img_maps) ? '' : 'display:none;').'" id="show_images" '.(!empty($detail->img_maps) ? 'src="'.$path_contact.$detail->img_maps.'"' : '').' />
                            <br>
                            <div style="height: 40px;">
                                <span id="remove" class="btn btn-warning" onclick="removeImage()" style="cursor: pointer; margin-bottom: 5px; '.(!empty($detail->img_maps) ? '' : 'display:none;').'">
                                    '.MultiLang('delete').'
                                </span>
                                <span class="msg_images" id="msg_images" style="color: red;"></span>
                            </div>

                            <input type="hidden" id="file_image_value" name="file_image_value" value="'.$base_64_images.'"/>
                            <input type="hidden" id="file_image_value_old" name="file_image_value_old" value="'.$detail->img_maps.'"/>
                        </div>
                    </div>';
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
        $path_contact_upload = $this->config->item('path_contact_upload');
        $address = $this->input->post('address', TRUE);
        $email = $this->input->post('email', TRUE);
        $phone = $this->input->post('phone', TRUE);
        $wa = $this->input->post('wa', TRUE);
        $fb = $this->input->post('fb', TRUE);
        $ig = $this->input->post('ig', TRUE);
        $twitter = $this->input->post('twitter', TRUE);
        $link_maps = $this->input->post('link_maps', TRUE);
        $file_image_value = $this->input->post('file_image_value');
        $file_image_value_old = $this->input->post('file_image_value_old');

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(empty($address)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('address').' '.MultiLang('required').'</li>';
        }

        if(empty($email)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('email').' '.MultiLang('required').'</li>';
        }

        if(empty($phone)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('phone').' '.MultiLang('required').'</li>';
        }

        if(empty($wa)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('whatsapp').' '.MultiLang('required').'</li>';
        }

        if(empty($fb)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('facebook').' '.MultiLang('required').'</li>';
        }

        if(empty($ig)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('instagram').' '.MultiLang('required').'</li>';
        }

        if(empty($twitter)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('twitter').' '.MultiLang('required').'</li>';
        }

        if(empty($link_maps)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('link_maps').' '.MultiLang('required').'</li>';
        }

        if(empty($file_image_value)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('image_maps').' '.MultiLang('required').'</li>';
        }

        if($validation){
            $results = true;
            $upload['status'] = true;

            if(!empty($file_image_value)){
                $max_size = '1024'; // in KB
                $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
                $upload = $this->data->uploadBase64($file_image_value, $path_contact_upload, $max_size, $type_allow);
            }

            if($upload['status']){
                if(!empty($file_image_value)){
                    $data = array(
                        'contact_address' => $address,
                        'contact_email' => $email,
                        'contact_phone' => $phone,
                        'contact_wa' => $wa,
                        'contact_fb' => $fb,
                        'contact_ig' => $ig,
                        'contact_twitter' => $twitter,
                        'contact_img_maps' => (!empty($upload['file'])) ? $upload['file'] : NULL,
                        'contact_link_maps' => $link_maps,
                        'update_user_id' => $user_id,
                        'update_datetime' => $date
                    );
                }else{
                    $data = array(
                        'update_user_id' => $user_id,
                        'update_datetime' => $date
                    );
                }
                $results = $results && $this->data->updateContact($data, 1);
            
                if ($results) {
                    $result["status"] = TRUE;
                    $result["message"] = MultiLang('msg_update_success');
                    if(!empty($file_image_value) AND !empty($file_image_value_old)){
                        @unlink($path_contact_upload.$file_image_value_old);
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
                    @unlink($path_contact_upload.$file_image_value);
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
