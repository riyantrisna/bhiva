<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-sm-12 mt-5">
					<?php if(!empty($contact->img_maps)){ ?>
						<?php if(!empty($contact->link_maps)){ ?>
						<a href="<?php echo $contact->link_maps;?>" target="_blank">
							<img class="d-block w-100" src="<?php echo base_url().$contact->img_maps;?>" alt="">
						</a>
						<?php }else{ ?>
							<img class="d-block w-100" src="<?php echo base_url().$contact->img_maps;?>" alt="">
						<?php } ?>
					<?php } ?>
				</div>

				<div class="col-md-6 col-sm-12 mt-5">
					<img src="assets/images/logo-home-text.png" height="60"/>
					<ul class="list-group">
						<li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer" style="font-size: 14px;">
							<h5>PT BHUMI VISATANDA</h5>
							<?php echo $contact->address; ?>
						</li>
						<?php if(!empty($contact->email)){ ?>
						<li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
							<a href="javascript:void(0)"><i class="fas fa-envelope mr-2"></i> <?php echo $contact->email;?></a>
						</li>
						<?php } ?>
						<?php if(!empty($contact->phone)){ ?>
						<li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
							<a href="javascript:void(0)"><i class="fas fa-phone mr-2"></i> <?php echo $contact->phone;?></a>
						</li>
						<?php } ?>
						<?php if(!empty($contact->wa)){ ?>
						<li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
							<a href="javascript:void(0)"><i class="fab fa-whatsapp  mr-3"></i><?php echo $contact->wa;?></a>
						</li>
						<?php } ?>
						<?php if(!empty($contact->fb)){ ?>
						<li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
							<a href="<?php echo $contact->fb;?>" target="_blank"><i class="fab fa-facebook-f mr-3"></i> Facebook</a>
						</li>
						<?php } ?>
						<?php if(!empty($contact->twitter)){ ?>
						<li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
							<a href="<?php echo $contact->twitter;?>" target="_blank"><i class="fab fa-twitter mr-2"></i> Twitter</a>
						</li>
						<?php } ?>
						<?php if(!empty($contact->ig)){ ?>
						<li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
							<a href="<?php echo $contact->ig;?>" target="_blank"><i class="fab fa-instagram mr-3"></i>Instagram</a>
						</li>
						<?php } ?>
					</ul>
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

	</body>
</html>
