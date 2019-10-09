<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tourpackagestestimony extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("data");
		if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
        }
        
        if(empty($this->session->userdata('tourpackages_id'))){
            redirect(base_url().'gallery');
        }
	}

	public function index()
	{
		$data['components'] = 'components/tourpackagestestimony';
		$data['active_menu_parent'] = 'master_data';
        $data['active_menu'] = 'tourpackages';
        $data['id'] = $this->session->userdata('tourpackages_id');
        $name = $this->data->getDetailTourpackagesTitle($this->session->userdata('tourpackages_id'));
        $data['name'] = $name->name;

		$this->load->view('home', $data);
	}
	
	public function data($id)
	{   
        $path_user = $this->config->item('path_user');
		$filter = array();
        $filter['id'] = $id;
        $filter['keyword'] = $_POST['search']['value'];
        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1 => 'a.`tourpackagestesti_user_real_name`',
            2 => 'a.`tourpackagestesti_testimony`',
            3 => 'a.`tourpackagestesti_rating`',
            4 => 'a.`tourpackagestesti_is_process`',
            5 => 'a.`tourpackagestesti_is_publish`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllTourpackagesTestimony($filter);
        $count = $this->data->getTotalAllTourpackagesTestimony($filter);
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = '<img src="'.(empty($value->photo) ? $path_user.'default.png' : $path_user.$value->photo).'" class="img-circle" style="width: 30px; height: 30px;" /> '. $value->user_real_name;
                $row[] = $this->data->getDatetimeIndo($value->date);
                $row[] = $value->rating;
                $row[] = ($value->is_process == 1) ? MultiLang('yes') : MultiLang('no');
                $row[] = ($value->is_publish == 1) ? MultiLang('yes') : MultiLang('no');
    
                //add html for action
                $action = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->token.'\')"><i class="fas fa-search"></i></a>';
                if($value->is_process == 1){
                    if(($value->is_publish == 1)){
                        $action.= '&nbsp;<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="'.MultiLang('unpublish').'" onclick="edit('."'".$value->token."','unpublished','".$value->user_real_name."'".')"><i class="fas fa-ban"></i></a>';
                    }else{
                        $action.= '&nbsp;<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="'.MultiLang('publish').'" onclick="edit('."'".$value->token."','published','".$value->user_real_name."'".')"><i class="fas fa-cloud"></i></a>';
                    }
                }
                $action.= '&nbsp;<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="'.MultiLang('delete').'" onclick="deletes('."'".$value->token."','".$value->user_real_name."'".')"><i class="fas fa-trash-alt"></i></a>';
                
                $row[] = $action;
            
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

    public function detail($id){

        $path_user = $this->config->item('path_user');
        $detail = $this->data->getDetailTourpackagesTestimony($id);

        $html = '';
        $html.= '<div class="form-group">';
        $html.=     '<label for="tourpackages">'.MultiLang('tourpackages').'</label>';
        $html.=     '<div id="tourpackages">'.$detail->tourpackages_name.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="user">'.MultiLang('user').'</label>';
        $html.=     '<div id="user"><img src="'.(empty($detail->photo) ? $path_user.'default.png' : $path_user.$detail->photo).'" class="img-circle" style="width: 30px; height: 30px;" /> '.$detail->user_real_name.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="date">'.MultiLang('date').'</label>';
        $html.=     '<div id="date">'.$this->data->getDatetimeIndo($detail->date).'</div>';
        $html.= '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="testimony">'.MultiLang('testimony').'</label>';
        $html.=     '<div id="testimony">'.$detail->testimony.'</div>';
        $html.= '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="rating">'.MultiLang('rating').'</label>';
        $html.=     '<div id="rating">'.$detail->rating.'</div>';
        $html.= '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_process">'.MultiLang('is_process').'</label>';
        $html.=     '<div id="is_process">'.($detail->is_process == 1 ? MultiLang('yes') : MultiLang('no')).'</div>';
        $html.= '</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="is_publish">'.MultiLang('is_publish').'</label>';
        $html.=     '<div id="is_publish">'.($detail->is_publish == 1 ? MultiLang('yes') : MultiLang('no')).'</div>';
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

    public function edit()
    {
        $id = $this->input->post('id', TRUE);
        $type = $this->input->post('type', TRUE);
        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        $data = array(
            'tourpackagestesti_is_publish' => (($type == 'published') ? 1: 0),
            'update_user_id' => $user_id,
            'update_datetime' => $date
        );
        $results = $this->data->updateTourpackagesTestimony($data, $id);

        if ($results) {
            $result["status"] = TRUE;
            $result["message"] = MultiLang('msg_update_success');
        }else{
            $result["status"] = FALSE;
            $result["message"] = MultiLang('msg_update_failed');
        }

        echo json_encode($result);
    }

    public function delete($id)
    {
        
        $delete = $this->data->deleteTourpackagesTestimony($id);
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
