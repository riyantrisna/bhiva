<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container mt-5">
			<div class="row">
				<div class="col-md-7 col-sm-12">
					<div id="carouselExampleIndicators" class="carousel fade-carousel slide mb-4" data-ride="carousel">
						<!-- Overlay -->
						<div class="overlay"></div>
						<ol class="carousel-indicators">
						<?php
						if(!empty($tourpackages_detail_image) AND count($tourpackages_detail_image) > 1){
							foreach ($tourpackages_detail_image as $key => $value) {
						?>
							<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key;?>" <?php echo (($key==0) ? 'class="active"' : ''); ?>></li>
						<?php
							}
						}
						?>
						</ol>
						<div class="carousel-inner">
						<?php
						if(!empty($tourpackages_detail_image)){					
							foreach ($tourpackages_detail_image as $key => $value) {
						?>
							<div class="carousel-item <?php echo (($key==0) ? 'active' : ''); ?> slides">
								<div class="slide" style="background-image: url('<?php echo base_url().$value->img;?>')"></div>
							</div>
						<?php
							}
						}
						?>
						</div>
						<?php
						if(!empty($tourpackages_detail_image) AND count($tourpackages_detail_image) > 1){
						?>
						<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="z-index: 3 !important;">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"style="z-index: 3 !important;">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						</a>
						<?php
						}
						?>
					</div>
					<div class="form-group" style="color: #212529; font-weight: bold;">
						<?php echo MultiLang('destination'); ?>
					</div>
					<div id="destination_div">
						<div class="row flex-row flex-sm-nowrap pb-3 col-12" style="margin-left: 0; padding-left: 0;">
							<?php
							if(!empty($tourpackages_destination_days)){
								for($i = 1; $i <= $tourpackages_destination_days->day; $i++){
							?>
							<div class="col-md-6 col-sm-12 text-center justify-content-center h-100 border rounded m-2 pt-2 pb-2 <?php echo $i==1 ? 'ml-sm-0 ml-md-0' : ''; ?>">
								<b><?php echo MultiLang('day').' '.$i; ?></b>
							<?php
									$tourpackages_destination = $this->CI->getTourpackagesDestination($tourpackages_id, $i);
									if(!empty($tourpackages_destination)){					
										foreach ($tourpackages_destination as $key => $value) {
							?>
								<a href="<?php echo base_url();?>destination/view/<?php echo $value->destination_id.'/'.(preg_replace("/\W|_/","-",$value->destination_name));?>" target="_blank" class="" style="text-decoration: none;">
									<div class="col-12 mt-2 mb-2">
										<div class="img-hover-zoom img-hover-zoom--brightness card-img-top" style="border-radius: 0;">
											<img class="img-fluid" src="<?php echo base_url().$value->img;?>" alt="<?php echo $value->destination_name;?>">
											<span class="centered-text-img"><?php echo $value->destination_name;?></span>
										</div>
									</div>
								</a>
							<?php
										}
									}
							?>
							</div>
							<?php
								}
							}
							?>
						</div>
					</div>
					<hr>
					<div class="form-group" style="color: #212529; font-weight: bold;">
						<?php echo MultiLang('desc'); ?>
					</div>
					<p>
						<?php echo $tourpackages_detail->text;?>
					</p>
				</div>
				<div class="col-md-5 col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<h5>
									<b><?php echo $tourpackages_detail->name;?></b>
									(<?php echo $tourpackages_detail->total_day;?> <?php echo MultiLang('day'); ?> <?php echo $tourpackages_detail->total_night;?> <?php echo MultiLang('night'); ?>)
								</h5>
							</div>
							<div class="form-group">
								<b><?php  echo number_format($tourpackages_detail->rating, 1, ',', '.'); ?></b>&nbsp;
								<?php  if($tourpackages_detail->rating < 1.5){ ?>
								<i class="fas fa-star" style="color:#FFD31C"></i>
								<i class="far fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i> 
								<?php }elseif($tourpackages_detail->rating >= 1.5 AND $tourpackages_detail->rating < 2.5){ ?> 
								<i class="fas fa-star" style="color:#FFD31C"></i>
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i>
								<?php }elseif($tourpackages_detail->rating >= 2.5 AND $tourpackages_detail->rating < 3.5){ ?> 
								<i class="fas fa-star" style="color:#FFD31C"></i>
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i>
								<?php }elseif($tourpackages_detail->rating >= 3.5 AND $tourpackages_detail->rating < 4.5){ ?>
								<i class="fas fa-star" style="color:#FFD31C"></i>
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="far fa-star" style="color:#FFD31C"></i> 
								<?php }elseif($tourpackages_detail->rating >= 4.5 AND $tourpackages_detail->rating <= 5){ ?>
								<i class="fas fa-star" style="color:#FFD31C"></i>
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<i class="fas fa-star" style="color:#FFD31C"></i> 
								<?php } ?>
							</div>
							<hr>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('travel_date'); ?>
							</div>
							<div class="form-group">
								<input type="text" id="date_tour" name="date_tour" class="form-control dates" placeholder="yyyy-mm-dd" autocomplete="nope" style="width: 120px !important;" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d').' + 1 day'));?>">
								<input type="hidden" id="div_id" value="<?php echo $tourpackages_detail->id;?>">
							</div>
							<hr>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('price'); ?>
							</div>
							<div class="form-group">
								<?php echo MultiLang('local_tourists'); ?>
								<div class="card-title mt-auto" style="color: #212529; font-weight: bold;">
									Rp <span id="price_local"><?php echo number_format($tourpackages_detail->price_local, 0, ',', '.');?></span>
								</div>
							</div>
							<div class="form-group">
								<?php echo MultiLang('foreign_tourists'); ?>
								<div class="card-title mt-auto" style="color: #212529; font-weight: bold;">
									Rp <span id="price_foreign"><?php echo number_format($tourpackages_detail->price_foreign, 0, ',', '.');?></span>
								</div>
							</div>
							<hr>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('quantity'); ?>
							</div>
							<div class="form-group">
								<span style="color: #8f8f8f; font-weight: normal; font-style: italic; ">
									* <?php echo MultiLang('min_order').' '.$tourpackages_detail->min_order; ?>,  <?php echo MultiLang('max_order').' '.$tourpackages_detail->max_order; ?>
								</span>
							</div>
							<div class="form-group">
								<?php echo MultiLang('local_tourists'); ?> 
								<div>
									<i class="fas fa-minus-circle" style="color: #42B549; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="tourists_qty('min', '<?php echo $tourpackages_detail->min_order; ?>', '<?php echo $tourpackages_detail->max_order; ?>', '#local_tourists', '#foreign_tourists')"></i>
									<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="border-0 text-center" id="local_tourists" name="local_tourists" value="<?php echo $tourpackages_detail->min_order; ?>" onkeypress="return isNumber(event)" readonly/>
									<i class="fas fa-plus-circle" style="color: #42B549; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="tourists_qty('add', '<?php echo $tourpackages_detail->min_order; ?>', '<?php echo $tourpackages_detail->max_order; ?>', '#local_tourists', '#foreign_tourists')"></i>
								</div>
							</div>
							<div class="form-group">
								<?php echo MultiLang('foreign_tourists'); ?>
								<div>
									<i class="fas fa-minus-circle" style="color: #42B549; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="tourists_qty('min', '<?php echo $tourpackages_detail->min_order; ?>', '<?php echo $tourpackages_detail->max_order; ?>', '#foreign_tourists', '#local_tourists')"></i>
									<input type="text" style="width: 50px !important; border-bottom: 1px solid #E0E0E0 !important; outline: none; " class="border-0 text-center" id="foreign_tourists" name="foreign_tourists" value="<?php echo ((($tourpackages_detail->min_order*2) <= $tourpackages_detail->max_order) ? $tourpackages_detail->min_order : ($tourpackages_detail->max_order-$tourpackages_detail->min_order)); ?>" onkeypress="return isNumber(event)" readonly/>
									<i class="fas fa-plus-circle" style="color: #42B549; font-size: 24px; vertical-align: middle; cursor: pointer;" onclick="tourists_qty('add', '<?php echo $tourpackages_detail->min_order; ?>', '<?php echo $tourpackages_detail->max_order; ?>', '#foreign_tourists', '#local_tourists')"></i>
								</div>
							</div>
							<hr>
							<div class="form-group">
								<div id="msg_btn_login" style="color: red; margin: 5px;"></div>
								<button type="button" class="btn btn-warning" style="width: 100%; font-weight: bold; padding: 10px;" onclick="book();"><?php echo MultiLang('book_tour_package'); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
					
		<hr class="mt-4 mb-5">
		
		<div class="container mt-5 mb-5">
			<div class="col-sm-12 mt-5 mb-3">
				<div style="text-align: center;">
					<h5><?php echo MultiLang('testimony'); ?></h5>
					<p class="text-grey-theme mt-1" style="font-size: 16px; color: #8f8f8f !important;"><?php echo MultiLang('text_testimony_tourpackage'); ?></p>
				</div>
			</div>
			<div class="row" id="testimony_div">
				
				<?php
				if(!empty($tourpackages_testimony)){
					foreach ($tourpackages_testimony as $key => $value) {
				?>
				<div class="col-md-6 col-sm-12 mt-3 h-100 text-center">
					<img class="rounded-circle" style="width: 80px; height: 80px;" src="<?php echo base_url().$value->user_photo;?>" alt="<?php echo $value->user_real_name; ?>">
					<div style="font-size: 16px; font-weight: bold;"><?php echo $value->user_real_name; ?></div>
					<p class="text-center" style="font-size: 14px; color: #8f8f8f !important;">
						<?php echo $value->testimony; ?>
					</p>
				</div>
				<?php
					}
					if($tourpackages_testimony_total > 4){
				?>
				<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
					<button type="button" class="btn btn-primary btn-load-more" onclick="load_more(<?php echo $tourpackages_detail->id; ?>, 2, 2)"><?php echo MultiLang('load_more'); ?></button>
				</div>
				<?php
					}
				}else{
				?>
				<div class="col-12 text-center"><i>-- <?php echo MultiLang('there_are_no_testimonials_yet');?> --</i></div>
				<?php
				}
				?>
				
			</div>
		</div>
		
		<?php 
			$this->load->view('footer');
		?>
		<style>
			.fade-carousel {
				position: relative;
				height: 60vh;
			}
			.fade-carousel .carousel-inner .carousel-item {
				height: 60vh;
			}
			.fade-carousel .slides .slide {
				height: 60vh;
				background-size: cover;
				background-position: center center;
				background-repeat: no-repeat;
			}
			.datepicker { 
				z-index: 9999 !important;
			}
		</style>
		<script>
			$(document).ready(function() {
				$("#destination_div").overlayScrollbars({ 
					"scrollbars": {
						"visibility": "auto"
					},
					overflowBehavior : {
						"y": "scroll"
					}
				});

				var tomorrow = new Date();
				tomorrow.setDate(tomorrow.getDate() + 1);

				$(".dates").datepicker({
					format: 'yyyy-mm-dd',
					autoclose: true,
					startDate: tomorrow
				}).on('changeDate', function (ev) {
					date_tour = $('#date_tour').val();
					id = $('#div_id').val();

					if(date_tour != '' && id != ''){
						jQuery.ajax({
							url : "<?php echo site_url('tourpackages/show_price/')?>",
							type: "POST",
							data: {id: id, date_tour: date_tour},
							dataType: "json",
							success: async function(data, textStatus, xhr)
							{
								if(xhr.status == '200'){
									console.log(data);
									$('#price_local').fadeOut().fadeIn().html(data.price_local);
									$('#price_foreign').fadeOut().fadeIn().html(data.price_foreign);
								}
							}
						});
					}
				});
			});
			
			function tourists_qty(type, min, max, elm, elm2){
				if(type=='add'){
					val_old = parseInt($(elm).val());
					val_old2 = parseInt($(elm2).val());
					total_val_old = val_old + val_old2;
					if(total_val_old < max){
						$(elm).val(val_old+parseInt(1));
					}
				}else{
					val_old = parseInt($(elm).val());
					val_old2 = parseInt($(elm2).val());
					total_val_old = val_old + val_old2;
					if(total_val_old > min && val_old > 0){
						$(elm).val(val_old-parseInt(1));
					}
				}
			}

			async function load_more(id, page, limit){
				await $('#loaders').modal('show');
				await $('.btn-load-more').html('<?php echo MultiLang('loading'); ?>...');

				jQuery.ajax({
					url : "<?php echo site_url('tourpackages/load_more/')?>",
					type: "POST",
					data: {id: id, page: page, 'limit': limit},
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							$('#btn-load-more-div, .btn-load-more').hide();
							$('#testimony_div').append(data.html);
						}else{
							$('#btn-load-more-div, .btn-load-more').hide();
						}


					}
				});
				await $('#loaders').on('shown.bs.modal', function (e) {
					$('#loaders').modal('hide');
				})
				
				$('#btn-load-more-div, .btn-load-more').hide();
				
			}

			function book(){

				date = $('#date_tour').val();
				local_tourists = $('#local_tourists').val();
				foreign_tourists = $('#foreign_tourists').val();

				$.post("<?php echo site_url('user/get_session_login');?>", function(data) {
					if(data == '1'){
						window.location.href = "<?php echo base_url(); ?>tourpackages/add/<?php echo $tourpackages_id.'/'.(preg_replace("/\W|_/","-",$tourpackages_detail->name));?>/"+date+"/"+local_tourists+"/"+foreign_tourists;
					}else{
						$('#msg_btn_login').fadeOut().fadeIn().html('<?php echo MultiLang('please_login'); ?>');
					}
				});
				
			}

		
		</script>
	</body>
</html>
