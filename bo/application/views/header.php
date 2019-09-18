<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- Notifications Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<?php echo $this->session->userdata('user_real_name'); ?> &nbsp;<img src="<?php echo $this->session->userdata('user_photo'); ?>" class="img-circle" style="width: 30px; height: 30px;" />
			</a>
			<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
				<a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_change_password">
					<i class="fas fa-lock mr-2"></i> <?php echo MultiLang('change_password'); ?>
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?php echo base_url().'login/logout'; ?>" class="dropdown-item">
					<i class="fas fa-sign-out-alt mr-2"></i> <?php echo MultiLang('logout'); ?>
				</a>
			</div>
		</li>
		
	</ul>
</nav>
<!-- /.navbar -->

<!-- Modal Change Password -->
<div class="modal fade" id="modal_change_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle"><?php echo MultiLang('change_password'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="box_msg_change_password"></div>
				<form id="form_change_password">
					<div class="form-group">
						<label for="old_password"><?php echo MultiLang('old_password'); ?></label>
						<input type="password" id="old_password" name="old_password" class="form-control">
					</div>
					<div class="form-group">
						<label for="new_password"><?php echo MultiLang('new_password'); ?></label>
						<input type="password" id="new_password" name="new_password" class="form-control">
					</div>
					<div class="form-group">
						<label for="retype_new_password"><?php echo MultiLang('retype_new_password'); ?></label>
						<input type="password" id="retype_new_password" name="retype_new_password" class="form-control">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo MultiLang('close'); ?></button>
				<button type="button" class="btn btn-primary" onclick="submitChangePassword()"><?php echo MultiLang('save'); ?></button>
			</div>
		</div>
	</div>
</div>
<script>

function submitChangePassword(){
	$("#box_msg_change_password").html('').hide();
	$.ajax({
		url: "<?php echo base_url()?>login/changepassword",
		type: 'post',
		dataType: 'json',
		data: $("#form_change_password").serialize(),
		success: async function (data, textStatus, xhr) {
			if(xhr.status == '200'){
				if(data.status){
					await $('#modal_change_password').modal('toggle');
					await $("#form_change_password").closest('form').find("input[type=password]").val("");
					await toastr.success(data.msg);
				}else{
					$("#box_msg_change_password").fadeOut().html(data.msg).fadeIn();
				}
			}else{
				toastr.error(xhr.statusText);
			}
		}
	});
}

</script>