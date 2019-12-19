<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container mt-5">
			<div class="row">
				<div class="col-md-7 col-sm-12">
					<div class="card mb-5">
						<div class="card-body">
							<div class="form-group">
								<h5 style="color: #212529; font-weight: bold;"><?php echo MultiLang('contact_information'); ?></h5>
							</div>
							<div class="form-group">
							   <label for="desc"><?php echo MultiLang('contact_name'); ?></label>
							   <input type="text" id="contact_name" name="contact_name" class="form-control" value="<?php echo $user->real_name; ?>">
							   <span style="color: #8f8f8f; font-weight: normal; font-style: italic; font-size: 14px;">
									<?php echo MultiLang('contact_name_info'); ?>
								</span>
							</div>
							<div class="form-group">
							   <label for="desc"><?php echo MultiLang('contact_email'); ?></label>
							   <input type="email" id="contact_email" name="contact_email" class="form-control" value="<?php echo $user->email; ?>">
							</div>
							<div class="form-group">
							   <label for="desc"><?php echo MultiLang('contact_phone'); ?></label>
							   <input type="number" id="contact_phone" name="contact_phone" class="form-control" value="<?php echo $user->phone; ?>" onkeypress="return isNumber(event)">

							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<h5 style="color: #212529; font-weight: bold;"><?php echo MultiLang('tourist_details'); ?></h5>
							</div>
							<?php
							if(!empty($tourpackages_detail->total_local)){
								for($i = 1; $i <= $tourpackages_detail->total_local; $i++){
							?>
							<div class="form-group">
								<b><?php echo MultiLang('local_tourists'); ?> <?php echo $i;?></b>
							</div>
							<div class="form-group">
								<label for="desc"><?php echo MultiLang('name'); ?></label>
								<input type="text" id="local_tourists_name" name="local_tourists_name[]" class="form-control" value="">
								<span style="color: #8f8f8f; font-weight: normal; font-style: italic; font-size: 14px;">
									<?php echo MultiLang('contact_name_info'); ?>
								</span>
							</div>
							<div class="form-group">
								<label for="desc"><?php echo MultiLang('id_card_number'); ?></label>
								<input type="text" id="local_tourists_identity" name="local_tourists_identity[]" class="form-control" value="">
								<span style="color: #8f8f8f; font-weight: normal; font-style: italic; font-size: 14px;">
									<?php echo MultiLang('identity_info'); ?>
								</span>
							</div>
							<hr>
							<?php
								}
							}
							?>

							<?php
							if(!empty($tourpackages_detail->total_foreign)){
								for($i = 1; $i <= $tourpackages_detail->total_foreign; $i++){
							?>
							<div class="form-group">
								<b><?php echo MultiLang('foreign_tourists'); ?> <?php echo $i;?></b>
							</div>
							<div class="form-group">
								<label for="desc"><?php echo MultiLang('name'); ?></label>
								<input type="text" id="foreign_tourists_name" name="foreign_tourists_name[]" class="form-control" value="">
								<span style="color: #8f8f8f; font-weight: normal; font-style: italic; font-size: 14px;">
									<?php echo MultiLang('contact_name_info'); ?>
								</span>
							</div>
							<div class="form-group">
								<label for="desc"><?php echo MultiLang('id_card_number'); ?></label>
								<input type="text" id="foreign_tourists_identity" name="foreign_tourists_identity[]" class="form-control" value="">
								<span style="color: #8f8f8f; font-weight: normal; font-style: italic; font-size: 14px;">
									<?php echo MultiLang('identity_info'); ?>
								</span>
							</div>
							<hr>
							<?php
								}
							}
							?>

							<div class="form-group">
								<div id="msg_btn_login" style="color: red; margin: 5px;"></div>
								<button type="button" class="btn btn-warning" style="width: 100%; font-weight: bold; padding: 10px;" onclick="book();"><?php echo MultiLang('continue_to_payment'); ?></button>
							</div>
						</div>
					</div>
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
							<hr>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('travel_date'); ?>
							</div>
							<div class="form-group">
								<?php echo $tourpackages_detail->date_tour_formated;?>
								<input type="hidden" id="div_id" value="<?php echo $tourpackages_detail->id;?>">
							</div>
							<hr>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('price'); ?>
							</div>
							<div class="form-group">
								<?php echo MultiLang('local_tourists'); ?> (@ Rp <?php echo number_format($tourpackages_detail->price_local, 0, ',', '.');?> x <?php echo $tourpackages_detail->total_local;?>)
								<div class="card-title mt-auto" style="color: #212529; font-weight: bold;">
									Rp <?php echo number_format(($tourpackages_detail->price_local * $tourpackages_detail->total_local), 0, ',', '.');?>
								</div>
							</div>
							<div class="form-group">
								<?php echo MultiLang('foreign_tourists'); ?> (@ Rp <?php echo number_format($tourpackages_detail->price_foreign, 0, ',', '.');?> x <?php echo $tourpackages_detail->total_foreign;?>)
								<div class="card-title mt-auto" style="color: #212529; font-weight: bold;">
									Rp <?php echo number_format(($tourpackages_detail->price_foreign * $tourpackages_detail->total_foreign), 0, ',', '.');?>
								</div>
							</div>
							<hr>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('payment_total'); ?>
							</div>
							<div class="form-group">
								<div class="card-title mt-auto" style="color: #212529; font-weight: bold;">
									Rp <?php echo number_format((($tourpackages_detail->price_local * $tourpackages_detail->total_local)+$tourpackages_detail->price_foreign * $tourpackages_detail->total_foreign), 0, ',', '.');?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<?php 
			$this->load->view('footer');
		?>
		<style>
			.fade-carousel {
				position: relative;
				height: 35vh;
			}
			.fade-carousel .carousel-inner .carousel-item {
				height: 35vh;
			}
			.fade-carousel .slides .slide {
				height: 35vh;
				background-size: cover;
				background-position: center center;
				background-repeat: no-repeat;
			}
			.datepicker { 
				z-index: 9999 !important;
			}
		</style>
		<script>
			// $(document).ready(function() {
			// });

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
