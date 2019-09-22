<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translation extends CI_Controller {

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
		$data['components'] = 'components/translation';
		$data['active_menu_parent'] = 'setting';
        $data['active_menu'] = 'translation';

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
            1=> 'a.`key_code`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllTranslation($filter);
        $count = $this->data->getTotalAllTranslation($filter);

        $translang = $this->data->getTranslationLanguage();
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->code;
                $translation = '';
                if(!empty($translang)){
                    foreach ($translang as $k => $v) {
                        if($v->key_id == $value->id){
                            $translation.= '<div><img src='.$path_language.$v->icon.' style="max-width:18px;" /> &nbsp;&nbsp;'.(!empty($v->text) ? $v->text : '-').'</div>' ;
                        }
                    }
                }
                // $row[] = substr($translation, 0, -4);
                $row[] = $translation;
    
                //add html for action
                $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->id.'\')"><i class="fas fa-search"></i></a>
                        <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="'.MultiLang('edit').'" onclick="edit('."'".$value->id."'".')"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="'.MultiLang('delete').'" onclick="deletes('."'".$value->id."','".$value->code."'".')"><i class="fas fa-trash-alt"></i></a>';
            
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
        $html.=     '<label for="code">'.MultiLang('code').' *</label>';
        $html.=     '<input type="text" id="code" name="code" class="form-control">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="translation">'.MultiLang('translation').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;*';
        $html.=     '<input type="text" id="translation_<?php echo $value->code;?>" name="translation['.$value->code.']" class="form-control">';
        $html.=     '<input type="hidden" id="translation_name_<?php echo $value->code;?>" name="translation_name['.$value->code.']" value="'.$value->name.'" >';
        $html.=     '<br>';
            }
        }
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function add()
    {
        $code = $this->input->post('code', TRUE);
        $language = $this->input->post('language', TRUE);
        $translation = $this->input->post('translation', TRUE);
        $translation_name = $this->input->post('translation_name', TRUE);
        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(empty($code)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('code').' '.MultiLang('required').'</li>';
        }else{
            $check_code = $this->data->getExistCodeTranslation($code);
            if(!empty($check_code->code)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('code').' <b>'.$code.'</b> '.MultiLang('existed').'</li>';
            }
        }

        if(!empty($translation)){
            foreach ($translation as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('translation').' '.$translation_name[$key].' '.MultiLang('required').'</li>';
                }
            }
        }

        if($validation){
            $results = true;

            $data = array(
                'key_code' => $code,
                'insert_user_id' => $user_id,
                'insert_datetime' => $date
            );
            $results = $results && $this->data->addTransalation($data, $translation, $user_id, $date);
        
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

        $detail = $this->data->getDetailTranslation($id);
        $detail_text = $this->data->getDetailTranslationText($id);

        $lang = $this->data->getLang();
        $path_language = $this->config->item('path_language');

        $html = '<div class="form-group">';
        $html.=     '<label for="code">'.MultiLang('code').' *</label>';
        $html.=     '<input type="text" disabled="disabled" id="code" name="code" class="form-control" value="'.$detail->code.'">';
        $html.=     '<input type="hidden" id="id" name="id" class="form-control" value="'.$detail->id.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="translation">'.MultiLang('translation').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang_code){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;*';
        $html.=     '<input type="text" id="translation_<?php echo $value->code;?>" name="translation['.$value->code.']" value="'.$v->text.'" class="form-control">';
        $html.=     '<input type="hidden" id="translation_name_<?php echo $value->code;?>" name="translation_name['.$value->code.']" value="'.$value->name.'" >';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function edit()
    {
        $id = $this->input->post('id', TRUE);
        $language = $this->input->post('language', TRUE);
        $translation = $this->input->post('translation', TRUE);
        $translation_name = $this->input->post('translation_name', TRUE);
        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';

        if(!empty($translation)){
            foreach ($translation as $key => $value) {
                if(empty($value)){
                    $validation = $validation && false;
                    $validation_text.= '<li>'.MultiLang('translation').' '.$translation_name[$key].' '.MultiLang('required').'</li>';
                }
            }
        }

        if($validation){
            $results = true;

            $data = array(
                'update_user_id' => $user_id,
                'update_datetime' => $date
            );
            $results = $results && $this->data->updateTransalation($data, $id, $translation, $user_id, $date);
        
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

        $detail = $this->data->getDetailTranslation($id);
        $detail_text = $this->data->getDetailTranslationText($id);

        $lang = $this->data->getLang();
        $path_language = $this->config->item('path_language');

        $html = '<div class="form-group">';
        $html.=     '<label for="code">'.MultiLang('code').'</label>';
        $html.=     '<div id="code">'.$detail->code.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="translation">'.MultiLang('translation').'</label>';
        $html.=     '<br>';
        if(!empty($lang)){
            foreach ($lang as $key => $value) {
                foreach ($detail_text as $k => $v) {
                    if($value->code == $v->lang_code){
        $html.=     '<img src="'.$path_language.$value->icon.'" style="max-width:18px;" /> ('.$value->name.')&nbsp;';
        $html.=     '<div>'.$v->text.'</div>';
        $html.=     '<br>';
                    }
                }
            }
        }
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="inserted">'.MultiLang('inserted').'</label>';
        $html.=     '<div id="inserted">'.(!empty($detail->insert_user) ? $detail->insert_user.',' : '').' '.($this->data->getDatetimeIndo($detail->insert_datetime)).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="updated">'.MultiLang('updated').'</label>';
        $html.=     '<div id="updated">'.(!empty($detail->update_user) ? $detail->update_user.',' : '').' '.($this->data->getDatetimeIndo($detail->update_datetime)).'</div>';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function delete($id)
    {
        $delete = $this->data->deleteTranslation($id);
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
