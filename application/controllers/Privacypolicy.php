<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Privacypolicy extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('data');
	}

	public function index()
	{

		$data['privacypolicy'] = $this->data->Privacypolicy();

		$this->load->view('privacypolicy', $data);

	}	
	
}
