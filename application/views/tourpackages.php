<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div id="carouselExampleIndicators" class="carousel fade-carousel slide" data-ride="carousel">
			<!-- Overlay -->
			<div class="overlay"></div>
			<ol class="carousel-indicators">
			<?php
			if(!empty($service_detail_image) AND count($service_detail_image) > 1){
				foreach ($service_detail_image as $key => $value) {
			?>
				<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key;?>" <?php echo (($key==0) ? 'class="active"' : ''); ?>></li>
			<?php
				}
			}
			?>
			</ol>
			<div class="carousel-inner">
			<?php
			if(!empty($service_detail_image)){					
				foreach ($service_detail_image as $key => $value) {
			?>
				<div class="carousel-item <?php echo (($key==0) ? 'active' : ''); ?> slides">
					<div class="slide" style="background-image: url('<?php echo base_url().$value->img;?>')"></div>
					<div class="hero">
						<hgroup>
							<h1><?php echo $service_detail->name;?></h1>
						</hgroup>
					</div>
				</div>
			<?php
				}
			}
			?>
			</div>
			<?php
			if(!empty($service_detail_image) AND count($service_detail_image) > 1){
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
		<div class="container">
			<div class="row mt-5">
				<div class="col-md-3 col-sm-12">
					<form id="filter_packages" autocomplete="nope">
						<div class="card">
							<div class="card-header">
								<i class="fas fa-filter" style="font-size: 14px;"></i> <?php echo MultiLang('filter'); ?>
							</div>
							<div class="card-body">
								<div class="card-title"><?php echo MultiLang('destination'); ?></div>
								<div class="form-group" id="destination_filter_div" style="height: 250px;">
									<?php
									if(!empty($combo_destination)){
										foreach ($combo_destination as $key => $value) {
									?>
									<div class="form-check">
										<input onclick="filter(0,15);" class="form-check-input" type="checkbox" value="<?php echo $value->id;?>" name="destination[<?php echo $value->id;?>]" id="destination<?php echo $value->id;?>">
										<label class="form-check-label" for="destination<?php echo $value->id;?>">
											<?php echo $value->name;?>
										</label>
									</div>
									<?php
										}
									}
									?>
								</div>
								<hr>
								<div class="card-title"><?php echo MultiLang('price'); ?> (Rp)</div>
								<div class="form-group">
									<input onblur="filter(0,15);" type="text" class="form-control curr text-right" id="price_min" name="price_min" placeholder="<?php echo MultiLang('minimum'); ?>"/>
								</div>
								<div class="form-group">
									<input onblur="filter(0,15);" type="text" class="form-control curr text-right" id="price_max" name="price_max" placeholder="<?php echo MultiLang('maximum'); ?>"/>
								</div>
								<hr>
								<div class="card-title"><?php echo MultiLang('time'); ?></div>
								<div class="form-group">
									<select onchange="filter(0,15);" id="time" name="time" class="form-control">
										<option value="">
											-- <?php echo MultiLang('all'); ?> --
										</option>
									<?php
										if(!empty($combo_time->day) AND !empty($combo_time->night)){
											$night = 0;
											for($day = 1; $day <= $combo_time->day; $day++){
									?>
										<option value="<?php echo $day.','.$night;?>">
											<?php echo $day;?> <?php echo MultiLang('day'); ?>, <?php echo $night;?> <?php echo MultiLang('night'); ?>
										</option>	
										<option value="<?php echo $day.','.($night+1);?>">
											<?php echo $day;?> <?php echo MultiLang('day'); ?>, <?php echo $night+1;?> <?php echo MultiLang('night'); ?>
										</option>								
									<?php
												$night++;
											}
										}
									?>
									</select>
								</div>
								<hr>
								<div class="card-title"><?php echo MultiLang('rating'); ?></div>
								<div class="form-group">
									<div class="form-check">
										<input onclick="filter(0,15);" class="form-check-input" type="checkbox" value="5" name="rating[5]" id="rating5">
										<label class="form-check-label" for="rating5">
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
										</label>
									</div>
									<div class="form-check">
										<input onclick="filter(0,15);" class="form-check-input" type="checkbox" value="4" name="rating[4]" id="rating4">
										<label class="form-check-label" for="rating4">
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
										</label>
									</div>
									<div class="form-check">
										<input onclick="filter(0,15);" class="form-check-input" type="checkbox" value="3" name="rating[3]" id="rating3">
										<label class="form-check-label" for="rating3">
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
										</label>
									</div>
									<div class="form-check">
										<input onclick="filter(0,15);" class="form-check-input" type="checkbox" value="2" name="rating[2]" id="rating2">
										<label class="form-check-label" for="rating2">
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
										</label>
									</div>
									<div class="form-check">
										<input onclick="filter(0,15);" class="form-check-input" type="checkbox" value="1" name="rating[1]" id="rating1">
										<label class="form-check-label" for="rating1">
											<i class="fas fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
											<i class="far fa-star" style="color:#FFD31C"></i> 
										</label>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="col-md-9 col-sm-12">
					<form id="filter_packages_sort" autocomplete="nope">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-8 col-sm-12 pt-2">
										<span><?php echo MultiLang('show'); ?> <span id="total_data" style="font-weight: bold;">0</span> <?php echo MultiLang('data'); ?></span>
									</div>
									<div class="col-md-4 col-sm-12">
										<select onchange="filter(0,15);" id="orderby" name="orderby" class="form-control">
											<option value="latest">
												<?php echo MultiLang('latest'); ?>
											</option>
											<option value="most_popular">
												<?php echo MultiLang('most_popular'); ?>
											</option>
											<option value="lowest_price">
												<?php echo MultiLang('lowest_price'); ?>
											</option>
											<option value="highest_price">
												<?php echo MultiLang('highest_price'); ?>
											</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="row mt-4" id="packages_div">
						<?php
						if(!empty($tourpackages_begin)){
							foreach ($tourpackages_begin as $key => $value) {
						?>
							<div class="col-lg-4 col-md-6 col-sm-12 mb-4 div-cover-item">
								<a href="<?php echo base_url();?>tourpackages/view/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>" class="" style="text-decoration: none;">
									<div class="card h-100">
										<div class="img-hover-zoom img-hover-zoom--brightness card-img-top" style="border-radius: 0;">
											<img class="img-fluid" src="<?php echo base_url().$value->img;?>" alt="<?php echo $value->name;?>">
										</div>
										<div class="card-body">
											<span class="card-title centered-text-img-packages"><?php echo $value->name;?></span>
											<p class="card-text" style="color: #212529;">
												(<?php echo $value->total_day;?> <?php echo MultiLang('day'); ?> <?php echo $value->total_night;?> <?php echo MultiLang('night'); ?>)
											</p>
											
										</div>
										<div class="card-footer">
											<span class="card-title mt-auto" style="color: #212529; font-weight: bold;">
												Rp <?php echo number_format($value->price_local, 0, ',', '.');?>
											</span>
											<span class="float-right" style="color: #212529; font-weight: bold;">
												<i class="fas fa-star" style="color:#FFD31C"></i> <?php echo number_format($value->rating, 1, ',', '.');?>
											</span>
										</div>
									</div>
								</a>
							</div>
						<?php
							}
						if($tourpackages_begin_total > 15){
						?>
						<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more" onclick="load_more(15, 15)"><?php echo MultiLang('load_more'); ?></button>
						</div>
						<?php
							}
						}else{
						?>
						<div class="col-12 text-center"><i>-- <?php echo MultiLang('tour_packages_not_found');?> --</i></div>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php 
			$this->load->view('footer');
		?>
		<script>
			$(document).ready(function() {
				$(".curr").mask('00.000.000.000.000.000.000', {reverse: true});

				$("#destination_filter_div").overlayScrollbars({ 
					"scrollbars": {
						"visibility": "auto"
					}
				});

				count_data();
			});

			function count_data(){
				var numItems = $('.div-cover-item').length;
				$('#total_data').html(numItems);
			}

			async function filter(page, limit){
				await $('#loaders').modal('show');

				var filter_packages_sort = $("#filter_packages_sort").serialize();
				var filter_packages = $("#filter_packages").serialize();
				data = filter_packages_sort+'&'+filter_packages+'&page='+page+'&limit='+limit;

				await jQuery.ajax({
					url : "<?php echo site_url('tourpackages/filter_tourpackages/')?>",
					type: "POST",
					data: data,
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							await $("#packages_div").html(data.html).fadeOut().fadeIn();

							await $('#total_data').html(data.total_data);

							await $('#loaders').on('shown.bs.modal', function (e) {
								$('#loaders').modal('hide');
							});

							await $('html, body').animate({
								scrollTop: $("#packages_div").offset().top - 200
							}, 1000);
						}else{
							await $('#loaders').on('shown.bs.modal', function (e) {
								$('#loaders').modal('hide');
							})

							await $('#total_data').html(0);
						}

					}
				});

				$('#loaders').on('shown.bs.modal', function (e) {
					$('#loaders').modal('hide');
				})
				
			}

			async function load_more(page, limit){
				await $('#loaders').modal('show');
				await $('.btn-load-more').html('<?php echo MultiLang('loading'); ?>...');

				var filter_packages_sort = $("#filter_packages_sort").serialize();
				var filter_packages = $("#filter_packages").serialize();
				data = filter_packages_sort+'&'+filter_packages+'&page='+page+'&limit='+limit;

				await jQuery.ajax({
					url : "<?php echo site_url('tourpackages/filter_tourpackages/')?>",
					type: "POST",
					data: data,
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							$('#btn-load-more-div, .btn-load-more').hide();
							$('#packages_div').append(data.html);
							await $('#total_data').html(data.total_data);
						}else{
							$('#btn-load-more-div, .btn-load-more').hide();
							await $('#total_data').html(0);
						}

					}
				});

				await $('#loaders').on('shown.bs.modal', function (e) {
					$('#loaders').modal('hide');
				})

				$('#btn-load-more-div, .btn-load-more').hide();
				
			}

		</script>
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
		</style>
	</body>
</html>
