<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container">
			<?php 
			if(!empty($venue)){ 
				$i=1;
				foreach ($venue as $key => $value) {
			?>
				
					<?php
					if($i%2 == 0){
					?>
					<div class="row mt-5" style="flex-direction: row-reverse !important;">
						<div class="col-md-4 col-sm-12">
							<div class="position-relative rounded-circle overflow-hidden mx-auto custom-circle-image">
								<img class="w-100 h-100" src="<?php echo base_url().$value->img;?>" alt="<?php echo $value->name ;?>">
							</div>
						</div>
						<div class="col-md-8 col-sm-12">
							<div style="font-size: 25px; font-weight: bold;"><?php echo $value->name ;?></div>
							<?php echo substr($value->text, 0, 250) ;?>
							<div>
								<a class="btn btn-warning" href="<?php echo base_url();?>venue/view/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>"><?php echo MultiLang('see_more') ;?></a>
							</div>
						</div>
					</div>
					<?php
					}else{
					?>
					<div class="row mt-5">
						<div class="col-md-4 col-sm-12">
							<div class="position-relative rounded-circle overflow-hidden mx-auto custom-circle-image">
								<img class="w-100 h-100" src="<?php echo base_url().$value->img;?>" alt="<?php echo $value->name ;?>">
							</div>
						</div>
						<div class="col-md-8 col-sm-12">
							<div style="font-size: 25px; font-weight: bold;"><?php echo $value->name ;?></div>
							<?php echo substr($value->text, 0, 250) ;?>
							<div>
								<a class="btn btn-warning" href="<?php echo base_url();?>venue/view/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>"><?php echo MultiLang('see_more') ;?></a>
							</div>
						</div>
					</div>
					<?php
					} 
				$i++;
				}
			}
			?>
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
		<style>
		.card-wrapper {
		margin: 5% 0;
		}

		/* You can adjust the image size by increasing/decreasing the width, height */
		.custom-circle-image {
		width: 250px; /* note i used vw not px for better responsive */
		height: 250px;
		}

		.custom-circle-image img {
		object-fit: cover;
		}

		.card-title {
		letter-spacing: 1.1px;
		}

		.card-text {
		font-family: MerriweatherRegular;
		font-size: 22px;
		line-height: initial;
		}
		</style>
		<?php 
			$this->load->view('footer');
		?>

	</body>
</html>
