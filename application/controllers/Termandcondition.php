<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Termandcondition extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('data');
	}

	public function index()
	{

		$data['termandcondition'] = $this->data->Termandcondition();

		$this->load->view('termandcondition', $data);

	}	
	
}
