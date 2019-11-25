<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div>
			
			<div class="whoweare mb-5" style="background-image: url('<?php echo base_url().$whoweare->img;?>')">
				<div class="col-lg-5 col-md-5 col-sm-12 whoweare-text rounded">
					<?php echo $whoweare->text;?>
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

		</div>
		
		<?php 
			$this->load->view('footer');
		?>

	</body>
</html>
