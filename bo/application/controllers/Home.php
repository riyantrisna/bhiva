<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();

		if(empty($this->session->userdata('user_id')))
		{
			redirect(base_url());
		}
	}

	public function index()
	{
		$data['components'] = 'components/dashboard';
		$data['active_menu_parent'] = '';
		$data['active_menu'] = 'dashboard';
		$this->load->view('home', $data);
	}
}
