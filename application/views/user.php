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
								<li class="list-group-item" style="background-color: #0C74A8; color: #ffffff; border-radius: 0 !important;">
									<i class="fas fa-user mr-2"></i><?php echo MultiLang('profile'); ?>
								</li>
							</a>
							<a href="<?php echo base_url().'user/transaction'; ?>" style="text-decoration: none;">
								<li class="list-group-item" style="color: #212529; border-radius: 0 !important;">
									<i class="fas fa-receipt  mr-2"></i><?php echo MultiLang('my_order'); ?>
								</li>
							</a>
							<a href="<?php echo base_url().'user/changepassword'; ?>" style="text-decoration: none;">
								<li class="list-group-item" style="color: #212529; border-radius: 0 !important;">
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
				<?php
				if(!empty($user->photo_ori)){
					$type = pathinfo($user->photo, PATHINFO_EXTENSION);
					$base_64_images = base64_encode(file_get_contents($user->photo));
					$base_64_images = 'data:image/' . $type . ';base64,' .$base_64_images;
				}else{
					$base_64_images = '';
				}
				?>
				<div class="col-md-9 col-sm-12">
					<form id="form_profile">
						<div class="card">
							<div class="card-header">
								<button type="button" class="btn btn-primary float-right" id="btnSave" onclick="save()"><?php echo MultiLang('save'); ?></button>
							</div>
							<div class="card-body row">
								<div id="box_msg_user" class="w-100">

								</div>
								<div class="col-md-6 col-sm-12 mt-1">
									<div class="form-group">
										<label for="name"><?php echo MultiLang('name'); ?> *</label>
										<input type="text" id="name" name="name" class="form-control" value="<?php echo $user->real_name;?>">
									</div>
									<div class="form-group">
										<label for="email"><?php echo MultiLang('email'); ?></label>
										<input type="email" id="email" name="email" class="form-control" readonly value="<?php echo $user->email;?>">
									</div>
									<div class="form-group">
										<label for="phone"><?php echo MultiLang('phone'); ?> *</label>
										<input type="number" id="phone" name="phone" class="form-control" onkeypress="return isNumber(event)" value="<?php echo $user->phone;?>" style="width: 180px !important;">
									</div>
									<div class="form-group">
										<label for="gender"><?php echo MultiLang('gender');?> *</label>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="gender" id="gender1" value="male" <?php echo $user->gender == "male" ? "checked" : "";?>>
											<label class="form-check-label" for="gender1">
												<?php echo MultiLang('male'); ?>
											</label>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="radio" name="gender" id="gender2" value="female" <?php echo $user->gender == "female" ? "checked" : "";?>>
											<label class="form-check-label" for="gender2">
												<?php echo MultiLang('female');?>
											</label>
										</div>
									</div>
									<div class="form-group">
										<label for="birthday"><?php echo MultiLang('birthday'); ?> *</label>
										<input type="text" id="birthday" name="birthday" class="form-control dates_birthday" placeholder="yyyy-mm-dd" value="<?php echo $user->birthday;?>" style="width: 120px !important;">
									</div>
									<div class="form-group">
										<label for="lang"><?php echo MultiLang('language'); ?> *</label>
										<select id="lang" name="lang" class="form-control">
											<option value="">
												-- <?php echo MultiLang('select'); ?> --
											</option>
									<?php
									if(!empty($lang)){
										foreach ($lang as $key => $value) {
									?>
											<option value="<?php echo $value->code;?>" <?php echo $user->lang == $value->code ? "selected" : "";?>>
												<?php echo $value->name; ?>
											</option>
									<?php
										}
									}
									?>
										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-12" style="text-align: center;">
									<label for="file_image"><?php echo MultiLang('image'); ?> *</label>
									<br>
									<div class="row">
									<div class="col" style="text-align: center;">
										<label id="label_images" for="images" style="cursor: pointer; <?php echo !empty($user->photo_ori) ? 'display:none;' : '';?>">
											<img style="width:150px; height:150px; border:1px dashed #C3C3C3;" src="<?php echo base_url();?>/assets/images/upload-image.png" />
										</label>
										
										<input type="file" name="images" id="images" style="display:none;" onchange="readURL(this)" accept="image/*"/>

										<img style="width:150px; height:150px; border:1px dashed #C3C3C3; margin-bottom: 5px; <?php echo !empty($user->photo_ori) ? '' : 'display:none;';?>" id="show_images" <?php echo !empty($user->photo_ori) ? 'src="'.base_url().$user->photo.'"' : '';?> />
										<br>
										<div style="height: 40px;">
											<span id="remove" class="btn btn-warning" onclick="removeImage()" style="cursor: pointer; margin-bottom: 5px; <?php echo !empty($user->photo_ori) ? '' : 'display:none;';?>">
												<?php echo MultiLang('delete');?>
											</span>
											<span class="msg_images" id="msg_images" style="color: red;"></span>
										</div>

										<input type="hidden" id="file_photo_value" name="file_photo_value" value="<?php echo $base_64_images;?>"/>
										<input type="hidden" id="file_photo_value_old" name="file_photo_value_old" value="<?php echo $user->photo_ori;?>"/>
									</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<button type="button" class="btn btn-primary float-right" id="btnSave" onclick="save()"><?php echo MultiLang('save'); ?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<script>
			function readURL(input) {

				var fileTypes = ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'];

				$('.msg_images').html('');
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					
					if(input.files[0].size <= 512000){

						var extension = input.files[0].name.split('.').pop().toLowerCase(),
						isSuccess = fileTypes.indexOf(extension) > -1;

						if(isSuccess){
							reader.onload = function (e) {
								$('#label_images').hide();
								$('#show_images').attr('src', e.target.result).fadeOut().fadeIn();
								$('#file_photo_value').val(e.target.result);
								$('#remove').show();
							};
							reader.readAsDataURL(input.files[0]);
						}else{
							$('#msg_images').html('<?php echo MultiLang('allowed_file_is'); ?> jpg, JPG, jpeg, JPEG, png, PNG, gif, GIF');
						}
					}else{
						$('#msg_images').html('<?php echo MultiLang('max_file_is'); ?> 1024KB');
					}
				}
			}

			function removeImage()
			{
				$('#label_images').show();
				$('#show_images').removeAttr('src').hide();
				$('#file_photo_value').val('');
				$('#remove').hide();
				$('.msg_images').html('');
			}

			function save()
			{
				$('#btnSave').text('<?php echo MultiLang('process'); ?>...'); //change button text
				$('#btnSave').attr('disabled',true); //set button disable 
				var url;
				url = "<?php echo site_url('user/edit')?>";

				$.ajax({
					url : url,
					type: "POST",
					data: $('#form_profile').serialize(),
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							if(data.status)
							{
								await toastr.success(data.message);
								$('html').animate({ scrollTop: 0 }, 'slow');
							}
							else
							{
								await $('#box_msg_user').html(data.message).fadeOut().fadeIn();
								$('html').animate({ scrollTop: 0 }, 'slow');
							}
						}else{
							toastr.error(xhr.statusText);
						}

						$('#btnSave').text('<?php echo MultiLang('save'); ?>');
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
