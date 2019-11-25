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
			if(!empty($destination_detail_image) AND count($destination_detail_image) > 1){
				foreach ($destination_detail_image as $key => $value) {
			?>
				<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key;?>" <?php echo (($key==0) ? 'class="active"' : ''); ?>></li>
			<?php
				}
			}
			?>
			</ol>
			<div class="carousel-inner">
			<?php
			if(!empty($destination_detail_image)){					
				foreach ($destination_detail_image as $key => $value) {
			?>
				<div class="carousel-item <?php echo (($key==0) ? 'active' : ''); ?> slides">
					<div class="slide" style="background-image: url('<?php echo base_url().$value->img;?>')"></div>
					<div class="hero">
						<hgroup>
							<h1><?php echo $destination->name;?></h1>
						</hgroup>
					</div>
				</div>
			<?php
				}
			}
			?>
			</div>
			<?php
			if(!empty($destination_detail_image) AND count($destination_detail_image) > 1){
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
		<div class="container mt-5">
			<div class="row">
				<div class="col-md-8 col-sm-12">

					<p class="justify-content-center">
						<?php echo $destination->text;?>
					</p>
					
					<b><?php echo MultiLang('share_on'); ?></b>
					<div class="ssk-group">
						<a href="javascript:void(0)" onclick="window.open('https://facebook.com/sharer/sharer.php?u=<?php echo base_url();?>destination/view/<?php echo $destination->id.'/'.(str_replace(' ','-',$destination->name));?>','_blank','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no, scrollbars=yes, resizable=yes, width=800, height=600');" class="ssk ssk-facebook"></a>
						<a href="javascript:void(0)" onclick="window.open('https://twitter.com/share?url=<?php echo base_url();?>destination/view/<?php echo $destination->id.'/'.(str_replace(' ','-',$destination->name));?>','_blank','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no, scrollbars=yes, resizable=yes, width=800, height=600');" class="ssk ssk-twitter"></a>
						<a href="javascript:void(0)" onclick="window.open('https://pinterest.com/pin/create/button/?url=<?php echo base_url();?>destination/view/<?php echo $destination->id.'/'.(str_replace(' ','-',$destination->name));?>&description=<?php echo (str_replace(' ','-',$destination->name));?>','_blank','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no, scrollbars=yes, resizable=yes, width=800, height=600');" class="ssk ssk-pinterest"></a>
					</div>
				</div>
				<div class="col-md-1 col-sm-12">&nbsp;<br><br></div>
				<div class="col-md-3 col-sm-12">
					<div class="">
						<h5><i class="fas fa-layer-group"></i> <?php echo MultiLang('tour_packages_related'); ?></h5>
					</div>
					<?php
						if(!empty($destination_tourpackages)){
							foreach ($destination_tourpackages as $key => $value) {
						?>
						
							<div class="col-md-12 col-sm-12 mt-4">
								<a class="d-block h-100 text-decoration-none" href="<?php echo base_url();?>destination/view/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>">
									<div class=" img-hover-zoom img-hover-zoom--brightness">
										<img class="img-fluid" src="<?php echo base_url().$value->img;?>" alt="">
										<span class="centered-text-img"><?php echo $value->name;?></span>
									</div>
								</a>
							</div>
						
						<?php
							}
						}else{
						?>
							<div class="col-md-12 col-sm-12 mt-4">
								<div style="width: 100%; text-align: center; white-space: nowrap;">
									<i class="text-black-50">-- <?php echo MultiLang('there_are_no_tour_packages'); ?> --</i>
								</div>
							</div>
						<?php
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
				<a href="<?php echo base_url();?>tourpackages" class="btn btn-primary"><?php echo MultiLang('other_packages'); ?></a>
			</div>
		</div>
		
		<?php 
			$this->load->view('footer');
		?>
		<style>
			/* .fade-carousel {
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
			} */
		</style>
	</body>
</html>
