<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container mt-5">
			<div class="row text-center">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<h5>
									<b><?php echo MultiLang('testimony'); ?></b>
								</h5>
							</div>
							<hr>
							<div class="form-group">
								<b><?php echo $transaction_tourpackages->tourpackages_name;?></b>
								(<?php echo $transaction_tourpackages->total_day;?> <?php echo MultiLang('day'); ?> <?php echo $transaction_tourpackages->total_night;?> <?php echo MultiLang('night'); ?>)
							</div>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('travel_date'); ?>
							</div>
							<div class="form-group">
								<?php echo $transaction_tourpackages->date_tour_formated;?>
							</div>
							<hr>
							<div class="form-group">
								<div class="form-group d-flex justify-content-center">
									<div class="star-rating">
										<span style="font-size: 30px;" class="far fa-star nilai" data-rating="1"></span>
										<span style="font-size: 30px;" class="far fa-star nilai" data-rating="2"></span>
										<span style="font-size: 30px;" class="far fa-star nilai" data-rating="3"></span>
										<span style="font-size: 30px;" class="far fa-star nilai" data-rating="4"></span>
										<span style="font-size: 30px;" class="far fa-star nilai" data-rating="5"></span>
										<input type="hidden" id="rating" class="rating-value" value="4">
									</div>
								</div>
								<div class="form-group d-flex justify-content-center">
									<textarea id="testimony" name="testimony" rows="5" class="form-control col-md-6 col-sm-12"></textarea>
								</div>
								<div class="form-group d-flex justify-content-center">
									<div id="msg_testimony" style="color: red;" class="msg_input"></div>
								</div>
								<div class="form-group">
									<button type="button" id="btnSend" class="btn btn-warning" style="font-weight: bold; padding: 10px 50px;" onclick="send_testimony();"><?php echo MultiLang('send'); ?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php 
			$this->load->view('footer');
		?>
		<style>
			.star-rating {
				line-height:32px;
				font-size:1.25em;
			}

			.star-rating .fa-star{color: yellow;}
		</style>
		<script>
			var $star_rating = $('.star-rating .nilai');

			var SetRatingStar = function() {
				return $star_rating.each(function() {
					if (parseInt($star_rating.siblings('input.rating-value').val()) >= parseInt($(this).data('rating'))) {
						return $(this).removeClass('far fa-star').addClass('fas fa-star');
					} else {
						return $(this).removeClass('fas fa-star').addClass('far fa-star');
					}
				});
			};

			$star_rating.on('click', function() {
				$star_rating.siblings('input.rating-value').val($(this).data('rating'));
				return SetRatingStar();
			});

			
			$(document).ready(function() {
				SetRatingStar();
			});

			function send_testimony()
			{	
				validation = true;

				if($('#testimony').val()==''){
					$('#msg_testimony').fadeOut().fadeIn().html('<?php echo MultiLang('testimony'); ?> <?php echo MultiLang('required');?>');
					validation = validation && false;
					$('html, body').animate({
						scrollTop: $("#testimony").offset().top - 110
					}, 1000);
				}

				if(validation){
					$('#btnSend').text('<?php echo MultiLang('process'); ?>...'); //change button text
					$('#btnSend').attr('disabled',true); //set button disable 

					jQuery.ajax({
						url : "<?php echo site_url('user/add_testimony/')?>",
						type: "POST",
						data: {rating: $('#rating').val(), testimony: $('#testimony').val(), token: '<?php echo $token;?>', user_id: '<?php echo $user_id;?>'},
						dataType: "json",
						success: async function(data, textStatus, xhr)
						{
							if(xhr.status == '200'){
								if(data.status){
									await toastr.success(data.message, '', {"positionClass": "toast-top-center"});
									setInterval(function(){ 
										window.location.href = "<?php echo base_url(); ?>";
									}, 3000);
								}else{
									await toastr.error(data.message, '', {"positionClass": "toast-top-center"});
									$('#btnSend').attr('disabled',false);
								}
								
							}else{
								toastr.error(xhr.statusText, '', {"positionClass": "toast-top-center"});
								$('#btnSend').attr('disabled',false);
							}

							$('#btnSend').text('<?php echo MultiLang('send'); ?>');
							// $('#btnSend').attr('disabled',false);
						}
					});
				}
				
			}
		
		</script>
	</body>
</html>
