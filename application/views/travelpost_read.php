<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container mt-5">
			<div class="row">
				<div class="col-md-8 col-sm-12">
					<h4><?php echo $travelpost->name;?></h4>
					<span class="font-italic text-black-50" style="font-size: 14px;"><?php echo $travelpost->creator;?>, <?php echo $travelpost->date;?></span>
					<div id="carouselExampleIndicators" class="carousel fade-carousel slide" data-ride="carousel">
						<!-- Overlay -->
						<div class="overlay"></div>
						<ol class="carousel-indicators">
						<?php
						if(!empty($travelpost_image) AND count($travelpost_image) > 1){
							foreach ($travelpost_image as $key => $value) {
						?>
							<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key;?>" <?php echo (($key==0) ? 'class="active"' : ''); ?>></li>
						<?php
							}
						}
						?>
						</ol>
						<div class="carousel-inner">
						<?php
						if(!empty($travelpost_image)){					
							foreach ($travelpost_image as $key => $value) {
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
						if(!empty($travelpost_image) AND count($travelpost_image) > 1){
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
					<p class="justify-content-center">
						<?php echo $travelpost->text;?>
					</p>
					
					<b><?php echo MultiLang('share_on'); ?></b>
					<div class="ssk-group">
						<a href="javascript:void(0)" onclick="window.open('https://facebook.com/sharer/sharer.php?u=<?php echo base_url();?>travelpost/read/<?php echo $travelpost->id.'/'.(str_replace(' ','-',$travelpost->name));?>','_blank','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no, scrollbars=yes, resizable=yes, width=800, height=600');" class="ssk ssk-facebook"></a>
						<a href="javascript:void(0)" onclick="window.open('https://twitter.com/share?url=<?php echo base_url();?>travelpost/read/<?php echo $travelpost->id.'/'.(str_replace(' ','-',$travelpost->name));?>','_blank','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no, scrollbars=yes, resizable=yes, width=800, height=600');" class="ssk ssk-twitter"></a>
						<a href="javascript:void(0)" onclick="window.open('https://pinterest.com/pin/create/button/?url=<?php echo base_url();?>travelpost/read/<?php echo $travelpost->id.'/'.(str_replace(' ','-',$travelpost->name));?>&description=<?php echo (str_replace(' ','-',$travelpost->name));?>','_blank','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no, scrollbars=yes, resizable=yes, width=800, height=600');" class="ssk ssk-pinterest"></a>
					</div>
				</div>
				<div class="col-md-1 col-sm-12">&nbsp;<br><br></div>
				<div class="col-md-3 col-sm-12">
					<div class="">
						<h5><i class="fas fa-newspaper"></i> <?php echo MultiLang('latest_posts'); ?></h5>
					</div>
					<?php
						if(!empty($travelpost_latest)){
							foreach ($travelpost_latest as $key => $value) {
						?>
						<a class="text-decoration-none" href="<?php echo base_url();?>travelpost/read/<?php echo $value->id.'/'.(str_replace(' ','-',$value->name));?>">
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
		</style>

		<script>
			$(".calendar").datepicker({
				format: 'yyyy-mm-dd'
			});
		</script>
	</body>
</html>
