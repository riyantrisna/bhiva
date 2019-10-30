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
		
		$data['slider'] = $this->data->getSlider();
		$data['tourpackages'] = $this->data->getTourpackages();
		$data['service'] = $this->data->getService();
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['ticket'] = $this->data->getTicket();

		$this->load->view('home', $data);

	}	
	
}
