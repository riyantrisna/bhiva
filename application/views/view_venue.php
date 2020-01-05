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
			if(!empty($venue_detail_image) AND count($venue_detail_image) > 1){
				foreach ($venue_detail_image as $key => $value) {
			?>
				<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key;?>" <?php echo (($key==0) ? 'class="active"' : ''); ?>></li>
			<?php
				}
			}
			?>
			</ol>
			<div class="carousel-inner">
			<?php
			if(!empty($venue_detail_image)){					
				foreach ($venue_detail_image as $key => $value) {
			?>
				<div class="carousel-item <?php echo (($key==0) ? 'active' : ''); ?> slides">
					<div class="slide" style="background-image: url('<?php echo base_url().$value->img;?>')"></div>
					<div class="hero">
						<hgroup>
							<h1><?php echo $venue_detail->name;?></h1>
						</hgroup>
					</div>
				</div>
			<?php
				}
			}
			?>
			</div>
			<?php
			if(!empty($venue_detail_image) AND count($venue_detail_image) > 1){
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
			<p class="justify-content-center">
				<?php echo $venue_detail->text;?>
			</p>

			<div class="row mb-5 mt-5">
				<div class="form-group col-md-3 col-sm-12">
					<label for="schedule_date" style="font-weight: bold;"><?php echo MultiLang('check_schedule');?></label>
					<input type="text" id="schedule_date" name="schedule_date" class="form-control dates" value="<?php echo date('Y-m-d');?>">
				</div>
				<div class="form-group col-md-3 col-sm-12">
					<label>&nbsp;</label>
					<button type="button" id="btnSearch" class="btn btn-warning" style="width: 100%; font-weight: bold;" onclick="check_venue();"><?php echo MultiLang('search'); ?></button>
				</div>
				<div id="result_schedule" class="form-group col-sm-12">

				</div>
			</div>
		</div>
					
		<hr class="mt-4 mb-5">

		<div class="col-sm-12 mt-5 mb-3">
			<div style="text-align: center;">
				<h5><?php echo MultiLang('text_most_popular_package_title'); ?></h5>
				<p class="text-grey-theme mt-1" style="font-size: 16px; color: #8f8f8f !important;"><?php echo MultiLang('text_most_popular_package'); ?></p>
			</div>
		</div>

		<div class="container mb-5">
			<div class="row">
				<?php
				if(!empty($tourpackages)){
					foreach ($tourpackages as $key => $value) {
				?>
					<div class="col-lg-3 col-md-6 col-sm-12 mb-4">
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
				}
				?>
				<div style="text-align: center; width:100%;">
					<a href="<?php echo base_url();?>tourpackages" class="btn btn-primary"><?php echo MultiLang('other_packages'); ?></a>
				</div>
			</div>
		</div>
		
		<?php 
			$this->load->view('footer');
		?>
		<style>
			.fade-carousel {
				position: relative;
				height: 80vh;
			}
			.fade-carousel .carousel-inner .carousel-item {
				height: 80vh;
			}
			.fade-carousel .slides .slide {
				height: 80vh;
				background-size: cover;
				background-position: center center;
				background-repeat: no-repeat;
			}
		</style>
		<script>
			var today = new Date();
			today.setDate(today.getDate());

			$(".dates").datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true,
				startDate: today
			});

			function check_venue(){
				var schedule_date =  $('#schedule_date').val();
				var venue_id =  <?php echo $venue_detail->id;?>;
				$.ajax({
					url : '<?php echo base_url(); ?>venue/check_venue',
					type: "POST",
					data: {'schedule_date': schedule_date, 'venue_id': venue_id},
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							$('#result_schedule').fadeOut().fadeIn().html(data.msg);
						}else{
							toastr.error(xhr.statusText);
						}

					}
				});
			}
		</script>
	</body>
</html>
