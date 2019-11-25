<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container mt-5 mb-5">
			<div class="col-sm-12 mt-5 mb-3">
				<div style="text-align: center;">
					<h5><?php echo MultiLang('travel_post'); ?></h5>
					<p class="text-grey-theme mt-1" style="font-size: 16px; color: #8f8f8f !important;"><?php echo MultiLang('text_travel_post'); ?></p>
				</div>
			</div>
			<div class="row" id="travel_post_div">
				
				<?php
				if(!empty($travelpost_list)){
					foreach ($travelpost_list as $key => $value) {
				?>
				<div class="col-md-3 col-sm-12 mt-3">
					<a class="text-decoration-none" href="<?php echo base_url();?>travelpost/read/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>">
						<div class="row">
							<img class="col-sm-12 d-block h100" src="<?php echo base_url().$value->img;?>" alt="">
							<p class="col-sm-12" style="color: #212529;">
								<?php echo $value->name; ?>
								<br>
								<span class="font-italic text-black-50" style="font-size: 14px;"><?php echo $value->creator;?>, <?php echo $value->date;?></span>
							</p>
						</div>
					</a>
				</div>
				<?php
					}
					if($total_travelpost_list > 12){
				?>
				<div class="col-sm-12 mt-3 text-center justify-content-center">
					<button type="button" class="btn btn-primary btn-load-more" onclick="load_more(12, 12)"><?php echo MultiLang('load_more'); ?></button>
				</div>
				<?php
					}
				}
				?>
				
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

			async function load_more(page, limit){
				await $('#loaders').modal('show');
				await $('.btn-load-more').html('<?php echo MultiLang('loading'); ?>...');

				jQuery.ajax({
					url : "<?php echo site_url('travelpost/load_more/')?>",
					type: "POST",
					data: {page: page, 'limit': limit},
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							$('.btn-load-more').hide();
							$('#travel_post_div').append(data.html);
						}else{
							$('.btn-load-more').hide();
						}

					}
				});

				await $('#loaders').on('shown.bs.modal', function (e) {
					$('#loaders').modal('hide');
				})

				$('.btn-load-more').hide();
				
			}
		</script>
	</body>
</html>
