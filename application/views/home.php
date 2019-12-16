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
							<?php
							if(!empty($value->title)){
							?>
							<hgroup>
								<h1><?php echo $value->title;?></h1>
							</hgroup>
							<?php
							}
							if(!empty($value->link)){
							?>
							<a class="btn btn-hero btn-lg" href="<?php echo $value->link; ?>"><?php echo $value->title_link;?></a>
							<?php } ?>
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
			
			<div class="container pt-2">
				<div class="row">
					<div class="col-md-8 col-sm-12 pb-3 pt-5 text-left">
						<p class="text-justify"><?php echo $greeting->text;?></p>
						<?php if(!empty($greeting->img)){ ?>
						<div class="mt-3">
							<?php if(!empty($greeting->link_img)){ ?>
							<a href="<?php echo $greeting->link_img;?>" target="_blank">
								<img class="d-block w-100" src="<?php echo base_url().$greeting->img;?>" alt="Bhiva Location Maps">
							</a>
							<?php }else{ ?>
								<img class="d-block w-100" src="<?php echo base_url().$greeting->img;?>" alt="Bhiva Location Maps">
							<?php } ?>
						</div>
						<?php } ?>
					</div>
					<div class="col-md-1 col-sm-12" style="border-right: 1px solid #C7C7C7;">
						&nbsp;
						<br>
					</div>
					<div class="col-md-3 col-sm-12 pb-3 pt-5 text-left">
						<h5 class="text-center mb-4"><?php echo MultiLang('travel_post'); ?></h5>

						<?php
						if(!empty($travel_post)){
							foreach ($travel_post as $key => $value) {
						?>
						<a class="text-decoration-none" href="<?php echo base_url();?>travelpost/read/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>">
							<div class="mt-3 row">
								<img class="col-sm-12 d-block h100" src="<?php echo base_url().$value->img;?>" alt="">
								<p class="col-sm-12" style="color: #212529;">
									<?php echo $value->name; ?>
									<br>
									<span class="font-italic text-black-50" style="font-size: 14px;"><?php echo $value->creator;?>, <?php echo $value->date;?></span>
								</p>
							</div>
						</a>
						<?php
							}
						}
						?>
						<div style="text-align: right;">
							<a class="text-decoration-none" style="color: #0C74A8;" href="<?php echo base_url();?>travelpost">
								<?php echo MultiLang('more_travel_post'); ?>...
							</a>
						</div>
					</div>
				</div>
			</div>

			<hr class="mt-4 mb-5">

			<div class="col-sm-12 mt-5 mb-4">
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
					$destination = $this->CI->load_destination($val->id, 0, 4);
					if(!empty($destination)){
						foreach ($destination as $key => $value) {
					?>
						<div class="col-lg-3 col-md-6 col-sm-12">
							<a href="<?php echo base_url();?>destination/view/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>" class="d-block mb-4 h-100">
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
				</div>
			</div>
			<?php 
				}
			}
			?>

			<div class="container mb-5">
				<div class="row text-center text-lg-left justify-content-center">
					<a href="<?php echo base_url();?>destination" class="btn btn-primary"><?php echo MultiLang('other_destination'); ?></a>
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

		</div>
		
		<?php 
			$this->load->view('footer');
		?>

	</body>
</html>
