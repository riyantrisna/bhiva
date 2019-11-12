<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

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
		$data['gallery'] = $this->data->getGallery();
		$data['gallery_photo_first'] = $this->data->getGalleryPhoto(1);

		$this->load->view('gallery', $data);

	}	

	public function loadphoto(){

		$parent_id = $this->input->post('id', TRUE);
		$gallery_photo = $this->data->getGalleryPhoto($parent_id);		
		
		$photos = '';
		if(!empty($gallery_photo)){
			foreach ($gallery_photo as $key => $value) {
				
			$photos.= '	<div class="col-lg-3 col-md-4 col-6">
							<a href="'.base_url().$value->img.'" class="d-block mb-4 h-100" data-toggle="lightbox" data-gallery="gallery">
								<img class="img-fluid img-thumbnail" src="'.base_url().$value->img.'" alt="'.$value->title.'" style="height: 180px;">
							</a>
						</div>';
			}
			$data['datas'] = '1';
		}else{
			$photos.= '<div class="col-12 text-center"><i>-- '.MultiLang('blank_photo_data').' --</i></div>';
			$data['datas'] = '0';
		}

		$data['html'] = $photos;
        
        echo json_encode($data);
	}
	
}
