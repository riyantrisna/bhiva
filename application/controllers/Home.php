<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public $CI = NULL;

	function __construct()
	{
		parent::__construct();
		$this->CI = & get_instance();

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

		$data['slider'] = $this->data->getSlider();
		$data['greeting'] = $this->data->getGreeting();
		$data['travel_post'] = $this->data->getTravelPost();
		if(!empty($data['travel_post'])){
			foreach ($data['travel_post'] as $key => $value) {
				$data['travel_post'][$key]->date = $this->data->getDatetimeIndo($value->date);
			}
		}
		$data['ticket'] = $this->data->getTicket();
		$data['tourpackages'] = $this->data->getTourpackages();
		$data['destination_location_home'] = $this->data->getDestinationLocationHome();

		$this->load->view('home', $data);

	}

	public function load_destination($id, $page, $limit)
	{
		$data = $this->data->getDestinationPagingById($id, $page, $limit);

		return $data;
	}	

	public function changelanguage($lang)
	{
		$session_data = array(
			'user_lang' =>  $lang
		);
		//set session userdata
		$this->session->set_userdata($session_data);
		redirect(base_url());

	}	
	
}
