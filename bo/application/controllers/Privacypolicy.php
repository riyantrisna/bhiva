<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacypolicy extends CI_Controller {

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
		$data['components'] = 'components/privacypolicy';
		$data['active_menu_parent'] = 'cms';
        $data['active_menu'] = 'privacypolicy';

        $path_language = $this->config->item('path_language');
        $detail = $this->data->getDetailPrivacypolicy(1);
        $detail_text = $this->data->getDetailPrivacypolicyText(1);
        $lang = $this->data->getLang();

        
        $html = '<div class="form-group">';
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
        $path_privacypolicy_upload = $this->config->item('path_privacypolicy_upload');
        $content = $this->input->post('content', TRUE);
        $content_name = $this->input->post('content_name', TRUE);

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

        if($validation){
            $data = array(
                'update_user_id' => $user_id,
                'update_datetime' => $date
            );
            $results = $this->data->updatePrivacypolicy($data, 1, $content);
        
            if ($results) {
                $result["status"] = TRUE;
                $result["message"] = MultiLang('msg_update_success');
                if(!empty($file_image_value) AND !empty($file_image_value_old)){
                    @unlink($path_privacypolicy_upload.$file_image_value_old);
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
                @unlink($path_privacypolicy_upload.$file_image_value);
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
