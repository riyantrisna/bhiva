<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Travelpost extends CI_Controller {

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

		$data['travelpost_list'] = $this->data->getTravelPostList(0,12);
		if(!empty($data['travelpost_list'])){
			foreach ($data['travelpost_list'] as $key => $value) {
				$data['travelpost_list'][$key]->date = $this->data->getDatetimeIndo($value->date);
			}
		}

		$data['total_travelpost_list'] = $this->data->getTotalTravelPostList();

		$this->load->view('travelpost_list', $data);

	}	

	public function load_more()
	{
		$page = $this->input->post('page', TRUE);
		$limit = $this->input->post('limit', TRUE);
		$travelpost_list = $this->data->getTravelPostList($page, $limit);
		if(!empty($travelpost_list)){
			foreach ($travelpost_list as $key => $value) {
				$travelpost_list[$key]->date = $this->data->getDatetimeIndo($value->date);
			}
		}
		
		$html = '';
		if(!empty($travelpost_list)){
			foreach ($travelpost_list as $key => $value) {
				
				$html.= ' <div class="col-md-3 col-sm-12 mt-3">';
				$html.= ' 	<a class="text-decoration-none" href="'.base_url().'travelpost/read/'.$value->id.'/'.(str_replace(' ','-',$value->name)).'">';
				$html.= 		'<div class="row">';
				$html.= 			'<img class="col-sm-12 d-block h100" src="'.base_url().$value->img.'" alt="">';
				$html.= 				'<p class="col-sm-12" style="color: #212529;">';
				$html.=  					$value->name;
				$html.= 					'<br>';
				$html.= 					'<span class="font-italic text-black-50" style="font-size: 14px;">'.$value->creator.', '.$value->date.'</span>';
				$html.= 				'</p>';
				$html.= 		'</div>';
				$html.= 	'</a>';
				$html.= '</div>';
			}

			if(count($travelpost_list) >= 12 ){
				$html.= '<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more" onclick="load_more('.($page+12).', 12)">'.MultiLang('load_more').'</button>
						</div>';
			}

		}

		$data['html'] = $html;
        
        echo json_encode($data);
	}

	public function read()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

		$id = $this->uri->segment('3');
		$data['travelpost'] = $this->data->getTravelPostDetail($id);
		if(!empty($data['travelpost'])){
			$data['travelpost']->date = $this->data->getDatetimeIndo($data['travelpost']->date);
		}
		$data['travelpost_image'] = $this->data->getTravelPostDetailImage($id);
		$data['travelpost_latest'] = $this->data->getTravelPostLatest($id);
		if(!empty($data['travelpost_latest'])){
			foreach ($data['travelpost_latest'] as $key => $value) {
				$data['travelpost_latest'][$key]->date = $this->data->getDatetimeIndo($value->date);
			}
		}

		$this->load->view('travelpost_read', $data);

	}	
	
}
