<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tourpackages extends CI_Controller {

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

		$data['combo_time'] = $this->data->getTimeDayNight(); 
		$data['combo_destination'] = $this->data->getDestinationAll(); 

		$data['tourpackages_begin'] = $this->data->getTourpackagesBegin();

		$this->load->view('tourpackages', $data);

	}	
	
}
