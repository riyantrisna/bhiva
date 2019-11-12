<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12 p-5">
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

				<div class="col-lg-6 col-md-6 col-sm-12 p-5">
					<img src="assets/images/logo-home-text.png" height="60"/>
					<ul class="list-group mt-3">
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
			<!-- <div class="row">
				<div id="box_msg_register"></div>
				<form id="form_register" autocomplete="nope">
					<div class="col-md-6 form-line">
			  			<div class="form-group">
			  				<label for="exampleInputUsername"><?php echo MultiLang('name'); ?></label>
					    	<input type="text" class="form-control" id="" placeholder="<?php echo MultiLang('name'); ?>">
				  		</div>
				  		<div class="form-group">
					    	<label for="exampleInputEmail"><?php echo MultiLang('email'); ?></label>
					    	<input type="email" class="form-control" id="exampleInputEmail" placeholder="<?php echo MultiLang('email'); ?>">
					  	</div>
			  		</div>
			  		<div class="col-md-6">
			  			<div class="form-group">
			  				<label for ="description"><?php echo MultiLang('message'); ?></label>
			  			 	<textarea  class="form-control" id="description" placeholder="<?php echo MultiLang('message'); ?>"></textarea>
			  			</div>
			  			<div>
			  				<button type="button" class="btn btn-default submit"><i class="fa fa-paper-plane" aria-hidden="true"></i><?php echo MultiLang('send_message'); ?></button>
			  			</div>
					</div>
				</form>
			</div> -->
					
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
