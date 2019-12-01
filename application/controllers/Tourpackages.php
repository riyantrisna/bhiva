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

		$data['service_detail'] = $this->data->getServiceDetailBanner(1); // 1 adalah type untuk paket wisata
		$data['service_detail_image'] = $this->data->getServiceDetailImageBanner(1); // 1 adalah type untuk paket wisata
		$data['combo_time'] = $this->data->getTimeDayNight(); 
		$data['combo_destination'] = $this->data->getDestinationAll(); 

		$data['tourpackages_begin'] = $this->data->getTourpackagesBegin();
		$data['tourpackages_begin_total'] = $this->data->getTotalTourpackagesBegin();

		$this->load->view('tourpackages', $data);

	}	

	public function filter_tourpackages(){

		$filter['orderby'] = $this->input->post('orderby', TRUE);
		$filter['destination'] = $this->input->post('destination', TRUE);
		$filter['price_min'] = str_replace('.','', $this->input->post('price_min', TRUE));
		$filter['price_max'] = str_replace('.','', $this->input->post('price_max', TRUE));
		$filter['time'] = $this->input->post('time', TRUE);
		$filter['rating'] = $this->input->post('rating', TRUE);
		$page = $this->input->post('page', TRUE);
		$limit = $this->input->post('limit', TRUE);
		$tourpackages_total = $this->data->getTotalTourpackagesFilter($filter);		
		$tourpackages = $this->data->getTourpackagesFilter($filter, $page, $limit);		
		
		$html = '';
		if(!empty($tourpackages)){
			foreach ($tourpackages as $key => $value) {
				
				$html.= '<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
							<a href="#" class="" style="text-decoration: none;">
								<div class="card h-100">
									<div class="img-hover-zoom img-hover-zoom--brightness card-img-top" style="border-radius: 0;">
										<img class="img-fluid" src="'.base_url().$value->img.'" alt="'.$value->name.'">
									</div>
									<div class="card-body">
										<span class="card-title centered-text-img-packages">'.$value->name.'</span>
										<p class="card-text" style="color: #212529;">
											('.$value->total_day.' '.MultiLang('day').' '.$value->total_night.' '.MultiLang('night').')
										</p>
										
									</div>
									<div class="card-footer">
										<span class="card-title mt-auto" style="color: #212529; font-weight: bold;">
											Rp'. number_format($value->price_local, 0, ',', '.').'
										</span>
										<span class="float-right" style="color: #212529; font-weight: bold;">
											<i class="fas fa-star"></i> '. number_format($value->rating, 1, ',', '.') .'
										</span>
									</div>
								</div>
							</a>
						</div>';
				
			}

			if(count($tourpackages) >= 15 AND $page < $tourpackages_total){
				$html.= '<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more" onclick="load_more('.($page+15).', 15)">'.MultiLang('load_more').'</button>
						</div>';
			}
			$data['datas'] = '1';
		}else{
			$html.= '<div class="col-12 text-center"><i>-- '.MultiLang('tour_packages_not_found').' --</i></div>';
			$data['datas'] = '0';
		}

		$data['html'] = $html;
        
        echo json_encode($data);
	}
	
}
