<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div>
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
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
					<div class="carousel-item <?php echo (($key==0) ? 'active' : ''); ?>">
						<img class="d-block w-100" src="<?php echo base_url().$value->img;?>" alt="<?php echo $value->title;?>">
						<div class="carousel-caption">
							<div class="d-flex align-items-center justify-content-center">
								<span style="font-weight: bold; font-size: 8vw;"><?php echo $value->title;?></span>
							</div>
							<div class="align-items-center justify-content-center">
								<span style="font-size: 2vw;">
									<a class="btn btn-warning" href="<?php echo $value->link; ?>"><?php echo $value->title_link;?></a>
								</span>
							</div>
						</div>
					</div>
				<?php
					}
				}
				?>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>

			<div style="margin-top: 5rem !important; margin-bottom: 2rem !important;">
				<div style="text-align: center;">
					<h3><?php echo MultiLang('text_from_ticket_title'); ?></h3>
					<p class="text-grey-theme" style="color: #8f8f8f !important; font-size: 16px; margin-top: 1rem !important;"><?php echo MultiLang('text_form_ticket'); ?></p>
				</div>
				<form style="margin: 2rem 7rem 2rem 7rem !important;">
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="ticket"><?php echo MultiLang('ticket'); ?></label>
							<select class="form-control" id="ticket">
								<option>-- Pilih --</option>
								<option>Candi Borobudur</option>
								<option>Candi Prambanan</option>
								<option>Candi Ratu Boko</option>
								<option>Tiket Terusan Borobudur & Prambanan</option>
								<option>Tiket Terusan Ratu Boko & Prambanan</option>
							</select>
						</div>
						<div class="form-group col-md-2">
							<label for="visit"><?php echo MultiLang('date'); ?></label>
							<input class="form-control calendar" id="visit"/>
						</div>
						<div class="form-group col-md-1">
							<label for="adult"><?php echo MultiLang('adult'); ?></label>
							<select class="form-control" id="adult">
								<?php
								for ($i=0; $i < 6; $i++) { 
								?>
									<option><?php echo $i;?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-1">
							<label for="child"><?php echo MultiLang('child'); ?></label>
							<select class="form-control" id="child">
								<?php
								for ($i=0; $i < 6; $i++) { 
								?>
									<option><?php echo $i;?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-1">
							<label for="student"><?php echo MultiLang('student'); ?></label>
							<select class="form-control" id="student">
								<?php
								for ($i=0; $i < 6; $i++) { 
								?>
									<option><?php echo $i;?></option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label for="tourist_type"><?php echo MultiLang('tourist_type'); ?></label>
							<select class="form-control" id="tourist_type">
								<option>-- Pilih --</option>
								<option>Local Tourist</option>
								<option>Foreign Tourist</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<button type="button" class="btn btn-primary float-right"><?php echo MultiLang('search'); ?></button>
						</div>
						
					</div>
				</form>
			</div>

			<hr class="mt-2 mb-5">

			<div style="margin-top: 5rem !important; margin-bottom: 3rem !important;">
				<div style="text-align: center;">
					<h3><?php echo MultiLang('text_most_popular_package_title'); ?></h3>
					<p class="text-grey-theme" style="font-size: 16px; color: #8f8f8f !important; margin-top: 1rem !important;"><?php echo MultiLang('text_most_popular_package'); ?></p>
				</div>
			</div>

			<div class="container" style="margin-bottom: 5rem !important;">
				<div class="row text-center text-lg-left justify-content-center">
					<?php
					if(!empty($tourpackages)){
						foreach ($tourpackages as $key => $value) {
					?>
						<div class="col-lg-3 col-md-4 col-6">
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
