<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language extends CI_Controller {

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
		$data['components'] = 'components/language';
		$data['active_menu_parent'] = 'setting';
		$data['active_menu'] = 'language';

		$this->load->view('home', $data);
	}
	
	public function data()
	{   
        $path_language = $this->config->item('path_language');
		$filter = array();
        $filter['keyword'] = $_POST['search']['value'];
        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1=> 'a.`lang_code`',
            2=> 'a.`lang_name`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllLanguage($filter);
        $count = $this->data->getTotalAllLanguage($filter);
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->code;
                $row[] = $value->name;
                $row[] = !empty($value->icon) ? '<center><img src='.$path_language.$value->icon.' style="max-width:80px;" /></center>' : '';
    
                //add html for action
                $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->code.'\')"><i class="fas fa-search"></i></a>
                        <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="'.MultiLang('edit').'" onclick="edit('."'".$value->code."'".')"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="'.MultiLang('delete').'" onclick="deletes('."'".$value->code."','".$value->name."'".')"><i class="fas fa-trash-alt"></i></a>';
            
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
    
    public function add()
    {
        $path_language_upload = $this->config->item('path_language_upload');
        $code = $this->input->post('code', TRUE);
        $language = $this->input->post('language', TRUE);
        $file_icon_value = $this->input->post('file_icon_value');
        $file_icon_value_old = $this->input->post('file_icon_value_old');
        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(empty($code)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('code').' '.MultiLang('required').'</li>';
        }else{
            $check_code = $this->data->getExistCode($code);
            if(!empty($check_code->code)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('code').' <b>'.$code.'</b> '.MultiLang('existed').'</li>';
            }
        }

        if(empty($language)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('language').' '.MultiLang('required').'</li>';
        }

        if(empty($file_icon_value)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('icon').' '.MultiLang('required').'</li>';
        }

        if($validation){
            $result = false;
            $upload['status'] = true;

            if(!empty($file_icon_value)){
                $max_size = '512'; // in KB
                $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
                $upload = $this->data->uploadBase64($file_icon_value, $path_language_upload, $max_size, $type_allow);
            }

            if($upload['status']){
                $data = array(
                    'lang_code' => $code,
                    'lang_name' => $language,
                    'lang_icon' => !empty($upload['file']) ? $upload['file'] : NULL,
                    'insert_user_id' => $user_id,
                    'insert_datetime' => $date
                );
                $result_add = $this->data->addLanguage($data);
            
                if ($result_add) {
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
                    @unlink($path_language_upload.$file_icon_value);
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

    public function edit()
    {
        $path_language_upload = $this->config->item('path_language_upload');
        $code_old = $this->input->post('code_old', TRUE);
        $language = $this->input->post('language', TRUE);
        $file_icon_value = $this->input->post('file_icon_value');
        $file_icon_value_old = $this->input->post('file_icon_value_old');
        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(empty($language)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('language').' '.MultiLang('required').'</li>';
        }

        if(empty($file_icon_value) AND empty($file_icon_value_old)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('icon').' '.MultiLang('required').'</li>';
        }

        if($validation){
            $result = false;
            $upload['status'] = true;

            if(!empty($file_icon_value)){
                $max_size = '512'; // in KB
                $type_allow = 'jpg|JPG|png|PNG|jpeg|JPEG|gif|GIF';
                $upload = $this->data->uploadBase64($file_icon_value, $path_language_upload, $max_size, $type_allow);
            }

            if($upload['status']){
                if(!empty($file_icon_value)){
                    $data = array(
                        'lang_name' => $language,
                        'lang_icon' => (!empty($upload['file'])) ? $upload['file'] : NULL,
                        'update_user_id' => $user_id,
                        'update_datetime' => $date
                    );
                }else{
                    $data = array(
                        'lang_name' => $language,
                        'update_user_id' => $user_id,
                        'update_datetime' => $date
                    );
                }
                $result_update = $this->data->updateLanguage($data, $code_old);
            
                if ($result_update) {
                    $result["status"] = TRUE;
                    $result["message"] = MultiLang('msg_update_success');
                    if(!empty($file_icon_value) AND !empty($file_icon_value_old)){
                        @unlink($path_language_upload.$file_icon_value_old);
                    }
                } else {
                    $result["status"] = FALSE;
                    $result["message"] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    $result["message"].= '<li>'.MultiLang('msg_update_failed').'</li>';
                    $result["message"].= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>';
                    $result["message"].= '</div>';
                    @unlink($path_language_upload.$file_icon_value);
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

    public function detail($id)
    {
        $path_language = $this->config->item('path_language');
        $data = $this->data->getDetailLanguage($id);
        $data->icon_file = $data->icon;
        $data->icon = $path_language.$data->icon;
        $data->inserted = (!empty($data->insert_user) ? $data->insert_user.',' : '').' '.($this->data->getDateIndo($data->insert_datetime));
        $data->updated = (!empty($data->update_user) ? $data->update_user.',' : '').' '.($this->data->getDateIndo($data->update_datetime));
        echo json_encode($data);
    }

    public function delete($id)
    {
        $path_language_upload = $this->config->item('path_language_upload');
        $data = $this->data->getDetailLanguage($id);
        $delete = $this->data->deleteLanguage($id);
        if($delete){
            @unlink($path_language_upload.$data->icon);

            $result["status"] = TRUE;
            $result["message"] = MultiLang('msg_delete_success');
        }else{
            $result["status"] = FALSE;
            $result["message"] = MultiLang('msg_delete_failed');
        }

        echo json_encode($result);
    } 
}
