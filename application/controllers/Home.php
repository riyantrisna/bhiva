<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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

		$data['slider'] = $this->data->getSlider();
		$data['greeting'] = $this->data->getGreeting();
		$data['ticket'] = $this->data->getTicket();
		$data['tourpackages'] = $this->data->getTourpackages();
		$data['destination_location_home'] = $this->data->getDestinationLocationHome();
		$data['destination'] = $this->data->getDestination();

		$this->load->view('home', $data);

	}	
	
}
