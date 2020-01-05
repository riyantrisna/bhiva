<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Destination extends CI_Controller {

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
		
		$data['tourpackages'] = $this->data->getTourpackages();

		$data['all_destination_location'] = $this->data->getAllDestinationLocation();

		$this->load->view('destination_list', $data);

	}	

	public function load_destination($id, $page, $limit)
	{
		$data = $this->data->getDestinationPagingById($id, $page, $limit);

		return $data;
	}	

	public function load_totaldestination($id)
	{
		$data = $this->data->getTotalDestinationById($id);

		return $data;
	}	

	public function load_more()
	{
		$id = $this->input->post('id', TRUE);
		$page = $this->input->post('page', TRUE);
		$limit = $this->input->post('limit', TRUE);
		$destination = $this->data->getDestinationPagingById($id, $page, $limit);
		$destination_location = $this->data->getDestinationLocationById($id);
		
		$html = '';
		if(!empty($destination)){
			foreach ($destination as $key => $value) {
				$html.= '<div class="col-lg-3 col-md-6 col-sm-12">';
				$html.= '	<a href="'.base_url().'destination/view/'.$value->id.'/'.(preg_replace("/\W|_/","-",$value->name)).'" class="d-block mb-4 h-100">';
				$html.= '		<div class=" img-hover-zoom img-hover-zoom--brightness">';
				$html.= '			<img class="img-fluid" src="'.base_url().$value->img.'" alt="">';
				$html.= '			<span class="centered-text-img">'.$value->name.'</span>';
				$html.= '		</div>';
				$html.= '	</a>';
				$html.= '</div>';
			}

			if(count($destination) >= 4 ){
				$html.= '<div id="btn-load-more-div-'.$id.'" class="col-sm-12 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more-'.$id.'" onclick="load_more('.$id.', '.($page+4).', 4)">'.MultiLang('load_more').' '.$destination_location->name.'</button>
						</div>';
			}

		}

		$data['html'] = $html;
        
        echo json_encode($data);
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
		$data['destination'] = $this->data->getDestinationDetail($id);
		$data['destination_detail_image'] = $this->data->getDestinationDetailImage($id);
		$data['destination_detail_tourpackages'] = $this->data->getDestinationTourpackages($id);

		$this->load->view('destination_view', $data);

	}	
	
}
