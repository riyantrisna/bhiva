<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venueschedule extends CI_Controller {

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
		$data['components'] = 'components/venueschedule';
		$data['active_menu_parent'] = 'venueschedule';
        $data['active_menu'] = 'venueschedule';

        $data['list_venue'] = $this->data->getListVenue();

		$this->load->view('home', $data);
	}
	
	public function data()
	{   
		$filter = array();
        
        $filter['schedule_date'] = $this->input->post('schedule_date');
        $filter['venue_id'] = $this->input->post('venue_id');

        $filter['length'] = $this->input->post('length');
        $filter['start'] = $this->input->post('start');

        $columns = array( 
            1 => 'b.venuetext_name',
            2 => 'a.transactionvenue_date_start',
            3 => 'a.transactionvenue_date_end`'
        );

        $filter['order'] = $columns[$this->input->post('order')[0]['column']];
        $filter['dir'] = $this->input->post('order')[0]['dir'];

		$list = $this->data->getAllVenueschedule($filter);
        $count = $this->data->getTotalAllVenueschedule($filter);
        
        $data = array();
        $no = $_POST['start'];

        if(!empty($list)){
            foreach ($list as $key => $value) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $value->venue_name;
                $row[] = $this->data->getDatetimeIndo($value->date_start);
                $row[] = $this->data->getDatetimeIndo($value->date_end);
    
                //add html for action
                $row[] = '<a class="btn btn-sm btn-info" href="javascript:void(0)" title="'.MultiLang('detail').'" onclick="detail(\''.$value->id.'\')"><i class="fas fa-search"></i></a>
                        <a class="btn btn-sm btn-primary" href="javascript:void(0)" title="'.MultiLang('edit').'" onclick="edit('."'".$value->id."'".')"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="'.MultiLang('delete').'" onclick="deletes('."'".$value->id."','".$value->venue_name."'".')"><i class="fas fa-trash-alt"></i></a>';
            
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
        $list_venue = $this->data->getListVenue();

        $html = '<div class="form-group">';
        $html.=     '<label for="venue_id">'.MultiLang('venue').' *</label>';
        $html.=     '<select name="venue_id" id="venue_id" class="form-control">
                        <option value="">
                            -- '.MultiLang('all').' --
                        </option>';
                        if(!empty($list_venue)){
                            foreach ($list_venue as $key => $value) {
        $html.=         '<option value="'.$value->id.'">
                            '.$value->name.'
                        </option>';
                            }
                        }
        $html.=     '</select>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="date_start">'.MultiLang('start_date').' *</label>';
        $html.=     '<input type="text" id="date_start" name="date_start" class="form-control dates_start" >';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="date_end">'.MultiLang('end_date').' *</label>';
        $html.=     '<input type="text" id="date_end" name="date_end" class="form-control dates_end" >';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function add()
    {
        $venue_id = $this->input->post('venue_id', TRUE);
        $date_start = $this->input->post('date_start', TRUE);
        $date_end = $this->input->post('date_end', TRUE);

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(empty($venue_id)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('venue').' '.MultiLang('required').'</li>';
        }

        if(empty($date_start)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('start_date').' '.MultiLang('required').'</li>';
        }
        
        if(empty($date_end)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('end_date').' '.MultiLang('required').'</li>';
        }

        if(!empty($date_start) AND !empty($date_end) AND strtotime($date_start) > strtotime($date_end)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('end_date').' '.MultiLang('must_be_bigger_than').' '.MultiLang('start_date').'</li>';
        }

        if(!empty($date_start) AND !empty($date_end) AND !empty($venue_id)){
            $check_venue_schedule = $this->data->checkVenueSchedule($date_start, $date_end, $venue_id);
            if(!empty($check_venue_schedule)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('notavailable_venue').' '.$this->data->getDatetimeIndo($date_start).' - '.$this->data->getDatetimeIndo($date_end).'</li>';
            }
        }

        if($validation){
            $results = true;

            $data = array(
                'transactionvenue_venue_id' => $venue_id,
                'transactionvenue_date_start' => $date_start,
                'transactionvenue_date_end' => $date_end,
                'insert_user_id' => $user_id,
                'insert_datetime' => $date
            );
            $results = $results && $this->data->addVenueschedule($data);
        
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

        $detail = $this->data->getDetailVenueschedule($id);
        $list_venue = $this->data->getListVenue();

        $html = '<div class="form-group">';
        $html.=     '<label for="venue_id">'.MultiLang('name').' *</label>';
        $html.=     '<select name="venue_id" id="venue_id" class="form-control">
                        <option value="">
                            -- '.MultiLang('all').' --
                        </option>';
                        if(!empty($list_venue)){
                            foreach ($list_venue as $key => $value) {
        $html.=         '<option value="'.$value->id.'" '.($value->id == $detail->venue_id ? 'selected' : '').'>
                            '.$value->name.'
                        </option>';
                            }
                        }
        $html.=     '</select>';
        $html.=     '<input type="hidden" id="id" name="id" value="'.$detail->id.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="date_start">'.MultiLang('start_date').' *</label>';
        $html.=     '<input type="text" id="date_start" name="date_start" class="form-control dates_start" value="'.$detail->date_start.'">';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="date_end">'.MultiLang('end_date').' *</label>';
        $html.=     '<input type="text" id="date_end" name="date_end" class="form-control dates_end" value="'.$detail->date_end.'">';
        $html.= '</div>';

        $data['html'] = $html;
        
        echo json_encode($data);
    }

    public function edit()
    {   
        $id = $this->input->post('id', TRUE);
        $venue_id = $this->input->post('venue_id', TRUE);
        $date_start = $this->input->post('date_start', TRUE);
        $date_end = $this->input->post('date_end', TRUE);

        $date = date('Y-m-d H:i:s');
        $user_id = $this->session->userdata('user_id');
        
        $validation = true;
        $validation_text = '';
        
        if(empty($venue_id)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('venue').' '.MultiLang('required').'</li>';
        }

        if(empty($date_start)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('start_date').' '.MultiLang('required').'</li>';
        }
        
        if(empty($date_end)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('end_date').' '.MultiLang('required').'</li>';
        }

        if(!empty($date_start) AND !empty($date_end) AND strtotime($date_start) > strtotime($date_end)){
            $validation = $validation && false;
            $validation_text.= '<li>'.MultiLang('end_date').' '.MultiLang('must_be_bigger_than').' '.MultiLang('start_date').'</li>';
        }

        if(!empty($date_start) AND !empty($date_end) AND !empty($venue_id)){
            $check_venue_schedule = $this->data->checkVenueSchedule($date_start, $date_end, $venue_id, $id);
            if(!empty($check_venue_schedule)){
                $validation = $validation && false;
                $validation_text.= '<li>'.MultiLang('notavailable_venue').' '.$this->data->getDatetimeIndo($date_start).' - '.$this->data->getDatetimeIndo($date_end).'</li>';
            }
        }

        if($validation){
            $results = true;

            $data = array(
                'transactionvenue_venue_id' => $venue_id,
                'transactionvenue_date_start' => $date_start,
                'transactionvenue_date_end' => $date_end,
                'update_user_id' => $user_id,
                'update_datetime' => $date
            );
            $results = $results && $this->data->updateVenueschedule($data, $id);
            
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

        $detail = $this->data->getDetailVenueschedule($id);

        $html = '<div class="form-group">';
        $html.=     '<label for="venue">'.MultiLang('venue').'</label>';
        $html.=     '<div id="venue">'.$detail->venue_name.'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="date_start">'.MultiLang('start_date').'</label>';
        $html.=     '<div id="date_start">'.$this->data->getDatetimeIndo($detail->date_start).'</div>';
        $html.= '</div>';
        $html.= '<div class="form-group">';
        $html.=     '<label for="date_end">'.MultiLang('end_date').'</label>';
        $html.=     '<div id="date_end">'.$this->data->getDatetimeIndo($detail->date_end).'</div>';
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
        $delete = $this->data->deleteVenueschedule($id);
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
