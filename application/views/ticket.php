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
			if(!empty($service_detail_image) AND count($service_detail_image) > 1){
				foreach ($service_detail_image as $key => $value) {
			?>
				<li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $key;?>" <?php echo (($key==0) ? 'class="active"' : ''); ?>></li>
			<?php
				}
			}
			?>
			</ol>
			<div class="carousel-inner">
			<?php
			if(!empty($service_detail_image)){					
				foreach ($service_detail_image as $key => $value) {
			?>
				<div class="carousel-item <?php echo (($key==0) ? 'active' : ''); ?> slides">
					<div class="slide" style="background-image: url('<?php echo base_url().$value->img;?>')"></div>
					<div class="hero">
						<hgroup>
							<h1><?php echo $service_detail->name;?></h1>
						</hgroup>
					</div>
				</div>
			<?php
				}
			}
			?>
			</div>
			<?php
			if(!empty($service_detail_image) AND count($service_detail_image) > 1){
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
		<div class="container">
			<form id="form_ticket">
			<div class="row mt-5 mb-5 border rounded d-flex justify-content-center">
				<div class="col-sm-10 p-4 row">
					<div class="form-group col-md-12 col-sm-12 mb-2">
						<h5><i class="fas fa-ticket-alt"></i>&nbsp;&nbsp;<?php echo MultiLang('text_form_ticket'); ?></h5>
						<hr>
					</div>
					<div class="form-group col-md-6 col-sm-12">
						<label for="ticket"><?php echo MultiLang('ticket');?></label>
						<select id="ticket" name="ticket" class="form-control">
							<option value="">
								-- <?php echo MultiLang('choose_ticket'); ?> --
							</option>
							<?php
							if($ticket){
								foreach ($ticket as $key => $value) {
							?>
							<option value="<?php echo $value->id?>">
								<?php echo $value->name; ?>
							</option>
							<?php
								}
							}
							?>
						</select>
					</div>
					<div class="form-group col-md-3 col-sm-12">
						<label for="visit_date"><?php echo MultiLang('visit_date');?></label>
						<input type="text" id="visit_date" name="visit_date" class="form-control dates" value="<?php echo date('Y-m-d');?>">
					</div>
					<div class="form-group col-md-3 col-sm-12">
						<label>&nbsp;</label>
						<button type="button" id="btnSearch" class="btn btn-warning" style="width: 100%; font-weight: bold;" onclick="search_ticket();"><?php echo MultiLang('search'); ?></button>
					</div>
				</div>
			</div>
			</form>
			<div id="div_ticket_result" class="row mt-4 mb-5 border rounded" style="display: none;">
				
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
			var today = new Date();
			today.setDate(today.getDate());

			$(".dates").datepicker({
				format: 'yyyy-mm-dd',
				autoclose: true,
				startDate: today
			});

			async function search_ticket(){
				await $('#loaders').modal('show');

				jQuery.ajax({
					url : "<?php echo site_url('ticket/search_ticket/')?>",
					type: "POST",
					data: $('#form_ticket').serialize(),
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							$('#div_ticket_result').fadeOut().fadeIn().html(data.html);
							await $('#loaders').on('shown.bs.modal', function (e) {
								$('#loaders').modal('hide');
							});

							await $('html, body').animate({
								scrollTop: $("#div_ticket_result").offset().top - 200
							}, 1000);
						}else{
							$('#div_ticket_result').hide();
							await $('#loaders').on('shown.bs.modal', function (e) {
								$('#loaders').modal('hide');
							});
						}

						await $('#loaders').on('shown.bs.modal', function (e) {
							$('#loaders').modal('hide');
						});
					}
				});
			}

			function visitor_qty(elm, type, min, max){
				$('#info_max_min_order').css({'color':'#8f8f8f'});
				var sum = 0;
				$('.qty_input').each(function(){
					sum += parseInt(this.value);
				});
				
				var old_val = $(elm).val();

				if(type == 'add' ){
					if(sum < max){
						$(elm).val(parseInt(old_val) + parseInt(1));
						sum += parseInt(1);
					}else{
						$('#info_max_min_order').css({'color':'red'}).fadeOut().fadeIn();
					}
				}else{
					if(sum > min && old_val > 0){
						$(elm).val(parseInt(old_val) - parseInt(1));
						sum -= parseInt(1);
					}else if(old_val == 0){

					}else{
						$('#info_max_min_order').css({'color':'red'}).fadeOut().fadeIn();
					}
				}

				if(sum == max){
					$('.fa-plus-circle').css({'color':'#8f8f8f'});
					$('.fa-minus-circle').css({'color':'#42B549'});
				}else if(sum == min){
					$('.fa-plus-circle').css({'color':'#42B549'});
					$('.fa-minus-circle').css({'color':'#8f8f8f'});
				}else{
					$('.fa-plus-circle').css({'color':'#42B549'});
					$('.fa-minus-circle').css({'color':'#42B549'});
				}
				
			}
		</script>
	</body>
</html>
