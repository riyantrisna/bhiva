<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tourpackages extends CI_Controller {

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

		$data['service_detail'] = $this->data->getServiceDetailBanner(1); // 1 adalah type untuk paket wisata
		$data['service_detail_image'] = $this->data->getServiceDetailImageBanner(1); // 1 adalah type untuk paket wisata
		$data['combo_time'] = $this->data->getTimeDayNight(); 
		$data['combo_destination'] = $this->data->getDestinationAll(); 

		$data['tourpackages_begin'] = $this->data->getTourpackagesBegin();
		$data['tourpackages_begin_total'] = $this->data->getTotalTourpackagesBegin();

		$this->load->view('tourpackages', $data);

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
		$data['tourpackages_id'] = $id;
		$data['tourpackages_detail'] = $this->data->getTourpackagesDetailByDate($id, date('Y-m-d', strtotime(date('Y-m-d').' + 1 day')));
		$data['tourpackages_detail_image'] = $this->data->getTourpackagesDetailImage($id);
		$data['tourpackages_testimony'] = $this->data->getTourpackagesTestimony($id, 0, 2);
		$data['tourpackages_testimony_total'] = $this->data->getTourpackagesTestimonyTotal($id);
		$data['tourpackages_destination_days'] = $this->data->getTourpackagesDestinationDays($id);

		$this->load->view('tourpackages_view', $data);

	}	

	public function add()
	{
		$data['lang'] = $this->data->getLang();
		$data['lang_set'] = $this->data->getLangDetail();
		$data['path_language'] = $this->config->item('path_language');
		$data['service'] = $this->data->getService();
		$data['contact'] = $this->data->getContact();
		$data['destination_location'] = $this->data->getDestinationLocation();

		$data['tourpackages'] = $this->data->getTourpackages();

		$id = $this->uri->segment('3');
		$date_tour = $this->uri->segment('5');
		$total_local = $this->uri->segment('6');
		$total_foreign = $this->uri->segment('7');
		$data['tourpackages_id'] = $id;

		$data['tourpackages_detail'] = $this->data->getTourpackagesDetailByDate($id, $date_tour);
		$data['tourpackages_detail_image'] = $this->data->getTourpackagesDetailImage($id);
		if(!empty($date_tour)){
			$data['tourpackages_detail']->date_tour = $date_tour;
			$data['tourpackages_detail']->date_tour_formated = $this->data->getDateIndo($date_tour);
		}
		$data['tourpackages_detail']->total_local = $total_local;
		$data['tourpackages_detail']->total_foreign = $total_foreign;

		//profile
		$data['user'] = $this->data->getUserByUserId($this->session->userdata('user_id'));

		if(strtotime($date_tour) < strtotime(date('Y-m-d').' + 1 days ')){
			header('Location: '. base_url().'tourpackages/view/'.$id.'/'.(preg_replace("/\W|_/","-",$data['tourpackages_detail']->name)));
		}

		$this->load->view('tourpackages_add', $data);

	}

	public function getTourpackagesDestination($id, $day)
	{
		$data = $this->data->getTourpackagesDestination($id, $day);

		return $data;
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
											<i class="fas fa-star" style="color:#FFD31C"></i> '. number_format($value->rating, 1, ',', '.') .'
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
			$data['total_data'] = count($tourpackages);
		}else{
			$html.= '<div class="col-12 text-center"><i>-- '.MultiLang('tour_packages_not_found').' --</i></div>';
			$data['total_data'] = 0;
		}

		$data['html'] = $html;
        
        echo json_encode($data);
	}
	
	public function show_price(){

		$filter['id'] = $this->input->post('id', TRUE);
		$filter['date_tour'] = $this->input->post('date_tour', TRUE);
		$tourpackages = $this->data->getDetailTourpackagesPrice($filter);

		$data = array(
			'price_local' => number_format($tourpackages->price_local, 0, ',', '.'),
			'price_foreign' => number_format($tourpackages->price_foreign, 0, ',', '.')
		);
        
        echo json_encode($data);
	}

	public function load_more()
	{
		$id = $this->input->post('id', TRUE);
		$page = $this->input->post('page', TRUE);
		$limit = $this->input->post('limit', TRUE);

		$tourpackages_testimony = $this->data->getTourpackagesTestimony($id, $page, $limit);
		$html = '';
		if(!empty($tourpackages_testimony)){
			foreach ($tourpackages_testimony as $key => $value) {
				
				$html.= ' <div class="col-md-6 col-sm-12 mt-3 h-100 text-center">';
				$html.= ' 	<img class="rounded-circle" style="width: 80px; height: 80px;" src="'.base_url().$value->user_photo.'" alt="'.$value->user_real_name.'">';
				$html.= '	<div style="font-size: 16px; font-weight: bold;">'.$value->user_real_name.'</div>';
				$html.= '	<p class="text-center" style="font-size: 14px; color: #8f8f8f !important;">';
				$html.=  		$value->testimony;
				$html.= '	</p>';
				$html.= '</div>';
			}

			if(count($tourpackages_testimony) >= 2 ){
				$html.= '<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more" onclick="load_more('.$id.','.($page+2).', 2)">'.MultiLang('load_more').'</button>
						</div>';
			}

		}

		$data['html'] = $html;
        
        echo json_encode($data);
	}
	
}
