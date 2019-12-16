<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div>
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-12 mt-5">
						<?php echo $aboutus->text;?>
					</div>
					<div class="col-md-6 col-sm-12 mt-5">
						<img class="d-block w-100" src="<?php echo base_url().$aboutus->img;?>" alt="">
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
						<div class="col-lg-3 col-md-6 col-sm-12 b-4">
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
