<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container">
			<div class="row mt-5">
				<div class="col-md-3 col-sm-12 mb-5">
					<div class="card">
						<div class="card-header text-center">
							<img src="<?php echo $this->session->userdata('user_photo'); ?>" class="rounded-circle mb-1" style="width: 70px; height: 70px;" />
							<br>
							<b><?php echo $user->real_name; ?></b>
						</div>
						<ul class="list-group list-group-flush">
							<a href="<?php echo base_url().'user/profile'; ?>" style="text-decoration: none;">
								<li class="list-group-item" style="color: #212529; border-radius: 0 !important;">
									<i class="fas fa-user mr-2"></i><?php echo MultiLang('profile'); ?>
								</li>
							</a>
							<a href="<?php echo base_url().'user/transaction'; ?>" style="text-decoration: none;">
								<li class="list-group-item" style="color: #212529; border-radius: 0 !important;">
									<i class="fas fa-receipt  mr-2"></i><?php echo MultiLang('my_order'); ?>
								</li>
							</a>
							<a href="<?php echo base_url().'user/changepassword'; ?>" style="text-decoration: none;">
								<li class="list-group-item" style="background-color: #0C74A8; color: #ffffff; border-radius: 0 !important;">
									<i class="fas fa-lock mr-2"></i><?php echo MultiLang('change_password'); ?>
								</li>
							</a>
							<a href="<?php echo base_url().'user/logout'; ?>" style="text-decoration: none;">
								<li class="list-group-item" style="color: #212529;">
									<i class="fas fa-sign-out-alt mr-2"></i><?php echo MultiLang('logout'); ?>
								</li>
							</a>
						</ul>
					</div>
				</div>
				<div class="col-md-9 col-sm-12">
					<form id="form_changepassword">
						<div class="card">
							<div class="card-header">
								<button type="button" class="btn btn-primary float-right" id="btnSave" onclick="save()"><?php echo MultiLang('change_password'); ?></button>
							</div>
							<div class="card-body row">
								<div id="box_msg_changepassword" class="w-100">

								</div>
								<div class="col-md-6 col-sm-12 mt-1">
									<div class="form-group">
										<label for="old_password"><?php echo MultiLang('old_password'); ?> *</label>
										<input type="password" id="old_password" name="old_password" class="form-control">
									</div>
									<div class="form-group">
										<label for="new_password"><?php echo MultiLang('new_password'); ?> *</label>
										<input type="password" id="new_password" name="new_password" class="form-control">
									</div>
									<div class="form-group">
										<label for="retype_new_password"><?php echo MultiLang('retype_new_password'); ?> *</label>
										<input type="password" id="retype_new_password" name="retype_new_password" class="form-control">
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="button" class="btn btn-primary float-right" id="btnSave" onclick="save()"><?php echo MultiLang('change_password'); ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			
			function save()
			{
				$('#btnSave').text('<?php echo MultiLang('process'); ?>...'); //change button text
				$('#btnSave').attr('disabled',true); //set button disable 
				var url;
				url = "<?php echo site_url('user/processchangepassword')?>";

				$.ajax({
					url : url,
					type: "POST",
					data: $('#form_changepassword').serialize(),
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							if(data.status)
							{
								await toastr.success(data.message);
								$('html').animate({ scrollTop: 0 }, 'slow');
								$('#form_changepassword')[0].reset();
							}
							else
							{
								await $('#box_msg_changepassword').html(data.message).fadeOut().fadeIn();
								$('html').animate({ scrollTop: 0 }, 'slow');
							}
						}else{
							toastr.error(xhr.statusText);
						}

						$('#btnSave').text('<?php echo MultiLang('change_password'); ?>');
						$('#btnSave').attr('disabled',false);

					}
				});
			}
		</script>
		<?php 
			$this->load->view('footer');
		?>

	</body>
</html>
