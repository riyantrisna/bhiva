<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="col-sm-12 mt-5 mb-4">
			<div style="text-align: center;">
				<h5><?php echo MultiLang('destination'); ?></h5>
				<p class="text-grey-theme mt-1" style="font-size: 16px; color: #8f8f8f !important;"><?php echo MultiLang('text_home_destination'); ?></p>
			</div>
		</div>
		
		<?php 
		if(!empty($all_destination_location)){ 				
			foreach ($all_destination_location as $k => $val) {
		?>
		<div class="col-sm-12 mt-5 mb-3" id="<?php echo (preg_replace("/\W|_/","-",$val->name));?>">
			<div style="text-align: center;">
				<h5><?php echo $val->name; ?></h5>
			</div>
		</div>
		<div class="container mb-3">
			<div class="row" id="destination_div_<?php echo $val->id;?>">
				<?php
				$destination = $this->CI->load_destination($val->id, 0, 4);
				$total_destination = $this->CI->load_totaldestination($val->id);
				if(!empty($destination)){
					foreach ($destination as $key => $value) {
				?>
					<div class="col-lg-3 col-md-6 col-sm-12">
						<a href="<?php echo base_url();?>destination/view/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>" class="d-block mb-4 h-100">
							<div class=" img-hover-zoom img-hover-zoom--brightness">
								<img class="img-fluid" src="<?php echo base_url().$value->img;?>" alt="">
								<span class="centered-text-img"><?php echo $value->name;?></span>
							</div>
						</a>
					</div>
				<?php
					}

					if($total_destination > 4){
				?>
						<div class="col-sm-12 text-center justify-content-center">
							<button type="button" class="btn btn-primary btn-load-more-<?php echo $val->id;?>" onclick="load_more(<?php echo $val->id;?>, 4, 4)"><?php echo MultiLang('load_more'); ?> <?php echo $val->name; ?></button>
						</div>
				<?php
					}
				}
				?>
				
			</div>
		</div>
		<?php 
			}
		}
		?>

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

		<script>
			$(document).ready(function () {
				$('html, body').animate({
					scrollTop: $("<?php echo isset($_GET['section']) ? '#'.$_GET['section'] : 'body' ; ?>").offset().top - 100
				}, 'slow');
			});

			async function load_more(id, page, limit){
				await $('#loaders').modal('show');
				await $('.btn-load-more-'+id).html('<?php echo MultiLang('loading'); ?>...');

				jQuery.ajax({
					url : "<?php echo site_url('destination/load_more/')?>",
					type: "POST",
					data: {id: id, page: page, 'limit': limit},
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							$('.btn-load-more-'+id).hide();
							$('#destination_div_'+id).append(data.html);
						}else{
							$('.btn-load-more-'+id).hide();
						}

					}
				});
				await $('#loaders').on('shown.bs.modal', function (e) {
					$('#loaders').modal('hide');
				})
				
				$('.btn-load-more-'+id).hide();
				
			}
		</script>
	</body>
</html>
