<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div>
			<div id="carouselExampleIndicators" class="carousel fade-carousel slide" data-ride="carousel">
				<!-- Overlay -->
  				<div class="overlay"></div>
				<ol class="carousel-indicators">
				<?php
				if(!empty($slider)){
					foreach ($slider as $key => $value) {
				?>
					<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key;?>" <?php echo (($key==0) ? 'class="active"' : ''); ?>></li>
				<?php
					}
				}
				?>
				</ol>
				<div class="carousel-inner">
				<?php
				if(!empty($slider)){					
					foreach ($slider as $key => $value) {
				?>
					<div class="carousel-item <?php echo (($key==0) ? 'active' : ''); ?> slides">
						<div class="slide" style="background-image: url('<?php echo base_url().$value->img;?>')"></div>
						<div class="hero">
							<hgroup>
								<h1><?php echo $value->title;?></h1>
							</hgroup>
							<a class="btn btn-hero btn-lg" href="<?php echo $value->link; ?>"><?php echo $value->title_link;?></a>
						</div>
					</div>
				<?php
					}
				}
				?>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev" style="z-index: 3 !important;">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"style="z-index: 3 !important;">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
			
			<div class="container pt-5">
				<div class="row">
					<div class="col-md-6 col-sm-12 mb-3 text-left">
						<h5 class="text-center mb-4"><?php echo MultiLang('bhiva'); ?></h5>
						<?php echo $greeting->text;?>
						<?php if(!empty($greeting->img)){ ?>
						<div class="mt-3">
							<?php if(!empty($greeting->link_img)){ ?>
							<a href="<?php echo $greeting->link_img;?>" target="_blank">
								<img class="d-block w-100" src="<?php echo base_url().$greeting->img;?>" alt="">
							</a>
							<?php }else{ ?>
								<img class="d-block w-100" src="<?php echo base_url().$greeting->img;?>" alt="">
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<div class="col-md-6 col-sm-12 mb-3 text-left" style="border-left: 1px solid #8f8f8f">
						<h5 class="text-center mb-4"><?php echo MultiLang('travel_post'); ?></h5>
						<div class="mt-3" style="display: flex;" >
							<img class="d-block w-50 h-50" src="<?php echo base_url().'files/images/contact/no-image-available.jpg';?>" alt="">
							<p class="ml-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
						<div class="mt-3" style="display: flex;" >
							<img class="d-block w-50 h-50" src="<?php echo base_url().'files/images/contact/no-image-available.jpg';?>" alt="">
							<p class="ml-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
						<div class="mt-3" style="display: flex;" >
							<img class="d-block w-50 h-50" src="<?php echo base_url().'files/images/contact/no-image-available.jpg';?>" alt="">
							<p class="ml-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
						</div>
					</div>
				</div>
			</div>

			<hr class="mt-4 mb-5">

			<div class="col-sm-12 mt-5 mb-5">
				<div style="text-align: center;">
					<h5><?php echo MultiLang('destination'); ?></h5>
					<p class="text-grey-theme mt-1" style="font-size: 16px; color: #8f8f8f !important;"><?php echo MultiLang('text_home_destination'); ?></p>
				</div>
			</div>
			
			<?php 
			if(!empty($destination_location_home)){ 
				foreach ($destination_location_home as $k => $val) {
			?>
			<div class="col-sm-12 mt-3 mb-3">
				<div style="text-align: center;">
					<h5><?php echo $val->name; ?></h5>
				</div>
			</div>
			<div class="container mb-3">
				<div class="row text-center text-lg-left justify-content-center">
					<?php
					if(!empty($destination)){
						foreach ($destination as $key => $value) {
							if($value->desloc_id == $val->id){
					?>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<a href="#" class="d-block mb-4 h-100">
								<div class=" img-hover-zoom img-hover-zoom--brightness">
									<img class="img-fluid" src="<?php echo base_url().$value->img;?>" alt="">
									<span class="centered-text-img"><?php echo $value->name;?></span>
								</div>
							</a>
						</div>
					<?php
							}
						}
					}
					?>
				</div>
			</div>
			<?php 
				}
			}
			?>

			<div class="container mb-5">
				<div class="row text-center text-lg-left justify-content-center">
					<button type="button" class="btn btn-primary"><?php echo MultiLang('other_destination'); ?></button>
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
				<div class="row text-center text-lg-left justify-content-center">
					<?php
					if(!empty($tourpackages)){
						foreach ($tourpackages as $key => $value) {
					?>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<a href="#" class="d-block mb-4 h-100">
								<div class=" img-hover-zoom img-hover-zoom--brightness">
									<img class="img-fluid" src="<?php echo base_url().$value->img;?>" alt="">
									<span class="centered-text-img"><?php echo $value->name;?></span>
								</div>
							</a>
						</div>
					<?php
						}
					}
					?>
					<button type="button" class="btn btn-primary"><?php echo MultiLang('other_packages'); ?></button>
				</div>
			</div>

		</div>
		
		<?php 
			$this->load->view('footer');
		?>

		<script>
			$(".calendar").datepicker({
				format: 'yyyy-mm-dd'
			});
		</script>
	</body>
</html>
