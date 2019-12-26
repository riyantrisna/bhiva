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
									<b><?php echo MultiLang('forget_password'); ?></b>
								</h5>
							</div>
							<hr>
							<div class="form-group">
								<div class="form-group d-flex justify-content-center">
									<div id="msg_email" style="color: red;" class="msg_email"></div>
								</div>
								<div class="form-group d-flex justify-content-center">
									<input placeholder="Email" type="email" name="email" class="form-control col-md-6 col-sm-12" id="email">
								</div>
								<div class="form-group">
									<button type="button" id="btnSend" class="btn btn-warning" style="font-weight: bold; padding: 10px 50px;" onclick="reset_password();"><?php echo MultiLang('reset_password'); ?></button>
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

			function reset_password()
			{	
				$('.msg_email').hide();
				validation = true;

				if($('#email').val()==''){
					// $('#msg_email').fadeOut().fadeIn().html('<?php echo MultiLang('email'); ?> <?php echo MultiLang('required');?>');
					toastr.error('<?php echo MultiLang('email'); ?> <?php echo MultiLang('required');?>', '', {"positionClass": "toast-top-center"});
					validation = validation && false;
					$('html, body').animate({
						scrollTop: $("body").offset().top
					}, 1000);
				}else{
					email_valid = validateEmail($('#email').val());
					if(!email_valid){
						// $('#msg_email').fadeOut().fadeIn().html('<?php echo MultiLang('email'); ?> <?php echo MultiLang('not_valid');?>');
						toastr.error('<?php echo MultiLang('email'); ?> <?php echo MultiLang('not_valid');?>', '', {"positionClass": "toast-top-center"});
						validation = validation && false;
						$('html, body').animate({
							scrollTop: $("body").offset().top
						}, 1000);
					}
				}

				if(validation){
					$('#btnSend').text('<?php echo MultiLang('process'); ?>...'); //change button text
					$('#btnSend').attr('disabled',true); //set button disable 

					jQuery.ajax({
						url : "<?php echo site_url('home/reset_password/')?>",
						type: "POST",
						data: {email: $('#email').val()},
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

							$('#btnSend').text('<?php echo MultiLang('reset_password'); ?>');
							// $('#btnSend').attr('disabled',false);
						}
					});
				}
				
			}
		
		</script>
	</body>
</html>
