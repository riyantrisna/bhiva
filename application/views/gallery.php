<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div>
			<!-- Top content -->
			<div class="container mt-5 mb-3" >
				<div class="col-sm-12 mt-5 mb-3">
					<div style="text-align: center;">
						<h5><?php echo MultiLang('our_photo_gallery'); ?></h5>
						<p class="text-grey-theme mt-1" style="font-size: 16px; color: #8f8f8f !important;"><?php echo MultiLang('text_our_photo_gallery'); ?></p>
					</div>
				</div>
				<div id="carousel-gallery" class="carousel slide carousel-gallery" data-ride="carousel" data-interval="6000">
					<div class="carousel-inner row w-100 mx-auto" role="listbox">
					<?php 
						if(!empty($gallery)){ 
							foreach ($gallery as $key => $value) {
					?>
					
						<div class="carousel-item col-12 col-sm-6 col-md-4 col-lg-3 text-center <?php echo (($key==0) ? 'active' : ''); ?>">
							<a href="javascript:void(0)" class="d-block mb-4 h-100" onclick="load_photo('<?php echo $value->id;?>', '<?php echo $value->title;?>')">
								<img src="<?php echo base_url().$value->img;?>" class="img-fluid img-thumbnail mx-auto" style="height: 180px;" alt="<?php echo $value->title;?>"> 
								<span class="" style="font-size: 16px;"><?php echo $value->title;?></span>
							</a>
						</div>
					
					<?php
							} 
						}
					?>
					</div>
					<a class="carousel-control-prev" href="#carousel-gallery" role="button" data-slide="prev" style="width: 100px !important;">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carousel-gallery" role="button" data-slide="next" style="width: 100px !important;">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>

			<hr class="mt-4 mb-5">

			<div class="container">
				
				<div class="col-sm-12 mb-3">
					<h5 class="font-weight-light text-center text-lg-left mt-4 mb-0"><?php echo MultiLang('photo'); ?> <span id="title_gallery"><?php echo $gallery[0]->title;?></span></h5>
				</div>

				<div id="photo_gallery" class="row text-center text-lg-left">
					<?php
					if(!empty($gallery_photo_first)){
						foreach ($gallery_photo_first as $key => $value) {
					?>
					<div class="col-12 col-sm-6 col-md-4 col-lg-3 text-center">
						<a href="<?php echo base_url().(!empty($value->link) ? $value->link : $value->img);?>" class="d-block mb-4 h-100 text-decoration-none" data-toggle="lightbox" data-gallery="gallery" <?php if(!empty($value->title)){?> data-title="<?php echo $value->title;?>" <?php } ?> data-width="1280">
							<img class="img-fluid img-thumbnail" src="<?php echo base_url().$value->img;?>" alt="<?php echo $value->title;?>" style="height: 180px;">
						<?php if(!empty($value->title)){?> <div class="text-center" style="font-size: 16px; color: #212529;"><?php echo $value->title;?></div><?php } ?>
						</a>
					</div>
					<?php
						}
					}else{
					?>
						<div class="col-12 text-center"><i>-- <?php echo MultiLang('blank_photo_data');?> --</i></div>
					<?php
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

		</div>
		
		<?php 
			$this->load->view('footer');
		?>
		<style>
			/*gallery*/

			.carousel-item > a{
				text-decoration: none;
				color: #212529;
			}
			/*
				code by Iatek LLC 2018 - CC 2.0 License - Attribution required
				code customized by Azmind.com
			*/
			@media (min-width: 768px) and (max-width: 991px) {
				/* Show 4th slide on md if col-md-4*/
				.carousel-inner .active.col-md-4.carousel-item + .carousel-item + .carousel-item + .carousel-item {
					position: absolute;
					top: 0;
					right: -33.3333%;  /*change this with javascript in the future*/
					z-index: -1;
					display: block;
					visibility: visible;
				}
			}
			@media (min-width: 576px) and (max-width: 768px) {
				/* Show 3rd slide on sm if col-sm-6*/
				.carousel-inner .active.col-sm-6.carousel-item + .carousel-item + .carousel-item {
					position: absolute;
					top: 0;
					right: -50%;  /*change this with javascript in the future*/
					z-index: -1;
					display: block;
					visibility: visible;
				}
			}
			@media (min-width: 576px) {
				.carousel-item {
					margin-right: 0;
				}
				/* show 2 items */
				.carousel-inner .active + .carousel-item {
					display: block;
				}
				.carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left),
				.carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item {
					transition: none;
				}
				.carousel-inner .carousel-item-next {
					position: relative;
					transform: translate3d(0, 0, 0);
				}
				/* left or forward direction */
				.active.carousel-item-left + .carousel-item-next.carousel-item-left,
				.carousel-item-next.carousel-item-left + .carousel-item,
				.carousel-item-next.carousel-item-left + .carousel-item + .carousel-item {
					position: relative;
					transform: translate3d(-100%, 0, 0);
					visibility: visible;
				}
				/* farthest right hidden item must be also positioned for animations */
				.carousel-inner .carousel-item-prev.carousel-item-right {
					position: absolute;
					top: 0;
					left: 0;
					z-index: -1;
					display: block;
					visibility: visible;
				}
				/* right or prev direction */
				.active.carousel-item-right + .carousel-item-prev.carousel-item-right,
				.carousel-item-prev.carousel-item-right + .carousel-item,
				.carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item {
					position: relative;
					transform: translate3d(100%, 0, 0);
					visibility: visible;
					display: block;
					visibility: visible;
				}
			}
			/* MD */
			@media (min-width: 768px) {
				/* show 3rd of 3 item slide */
				.carousel-inner .active + .carousel-item + .carousel-item {
					display: block;
				}
				.carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item {
					transition: none;
				}
				.carousel-inner .carousel-item-next {
					position: relative;
					transform: translate3d(0, 0, 0);
				}
				/* left or forward direction */
				.carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item {
					position: relative;
					transform: translate3d(-100%, 0, 0);
					visibility: visible;
				}
				/* right or prev direction */
				.carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item {
					position: relative;
					transform: translate3d(100%, 0, 0);
					visibility: visible;
					display: block;
					visibility: visible;
				}
			}
			/* LG */
			@media (min-width: 991px) {
				/* show 4th item */
				.carousel-inner .active + .carousel-item + .carousel-item + .carousel-item {
					display: block;
				}
				.carousel-inner .carousel-item.active:not(.carousel-item-right):not(.carousel-item-left) + .carousel-item + .carousel-item + .carousel-item {
					transition: none;
				}
				/* Show 5th slide on lg if col-lg-3 */
				.carousel-inner .active.col-lg-3.carousel-item + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
					position: absolute;
					top: 0;
					right: -25%;  /*change this with javascript in the future*/
					z-index: -1;
					display: block;
					visibility: visible;
				}
				/* left or forward direction */
				.carousel-item-next.carousel-item-left + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
					position: relative;
					transform: translate3d(-100%, 0, 0);
					visibility: visible;
				}
				/* right or prev direction //t - previous slide direction last item animation fix */
				.carousel-item-prev.carousel-item-right + .carousel-item + .carousel-item + .carousel-item + .carousel-item {
					position: relative;
					transform: translate3d(100%, 0, 0);
					visibility: visible;
					display: block;
					visibility: visible;
				}
			}
		</style>
		<script>
			$( document ).ready(function() {

				/*
					Carousel
				*/
				$('#carousel-gallery').on('slide.bs.carousel', function (e) {
					/*
						CC 2.0 License Iatek LLC 2018 - Attribution required
					*/
					var $e = $(e.relatedTarget);
					var idx = $e.index();
					var itemsPerSlide = 5;
					var totalItems = $('.carousel-item').length;
				
					if (idx >= totalItems-(itemsPerSlide-1)) {
						var it = itemsPerSlide - (totalItems - idx);
						for (var i=0; i<it; i++) {
							// append slides to end
							if (e.direction=="left") {
								$('.carousel-item').eq(i).appendTo('.carousel-inner');
							}
							else {
								$('.carousel-item').eq(0).appendTo('.carousel-inner');
							}
						}
					}
				});

				$(document).on("click", '[data-toggle="lightbox"]', function(event) {
					event.preventDefault();
					$(this).ekkoLightbox({
						// alwaysShowClose: true,
					});
				});
			});

			async function load_photo(id, title){
				await $('#loaders').modal('show');

				jQuery.ajax({
					url : "<?php echo site_url('gallery/loadphoto/')?>",
					type: "POST",
					data: {id: id},
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							await $("#photo_gallery").html(data.html).fadeOut().fadeIn();
							await $("#title_gallery").html(title).fadeOut().fadeIn();
							await $('#loaders').on('shown.bs.modal', function (e) {
								$('#loaders').modal('hide');
							})
							// if(data.datas == "1"){
								await $('html, body').animate({
									scrollTop: $("#title_gallery").offset().top - 100
								}, 1000);
							// }
						}else{
							await $('#loaders').on('shown.bs.modal', function (e) {
								$('#loaders').modal('hide');
							})
						}

					}
				});

				$('#loaders').on('shown.bs.modal', function (e) {
					$('#loaders').modal('hide');
				})
				
			}
			
		</script>
	</body>
</html>
