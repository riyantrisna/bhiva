<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venue extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('data');
	}

	public function index()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

		$data['venue'] = $this->data->getAllVenue();

		$this->load->view('venue', $data);

	}	

	public function view()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

		$id = $this->uri->segment('3');
		$data['venue_detail'] = $this->data->getVenueDetail($id);
		$data['venue_detail_image'] = $this->data->getVenueDetailImage($id);

		$this->load->view('view_venue', $data);

	}	


	public function check_venue()
    {

        $schedule_date = $this->input->post('schedule_date', TRUE);
        $venue_id = $this->input->post('venue_id', TRUE);

        $status_update =  $this->data->checkVenueSchedule($schedule_date, $venue_id);

        $msg_check = '';

		$date_formated = $this->data->getDatetimeIndo($schedule_date);
        if(empty($status_update)){
            $msg_check.= '<div style="color: green;">'.MultiLang('available_venue').' <b>'.$date_formated .'</b></div>';
        }else{
            $msg_check.= '<div style="color: red;">'.MultiLang('notavailable_venue').' <b>'.$date_formated .'</b></div>';
        }

        $data['msg'] = $msg_check;
        
        echo json_encode($data);
    }
	
}
