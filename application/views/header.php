<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>BHIVA</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="assets/fontawesome-free/css/all.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="assets/google-font.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="assets/dist/css/main.css">
	<!-- Date picker -->
	<link rel="stylesheet" href="assets/bootstrap-datepicker/bootstrap-datepicker.min.css">
	<!-- lightbox -->
	<link rel="stylesheet" href="assets/dist/css/ekko-lightbox.css">
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-md sticky-top border-grey-theme-bottom" style="background-color: #ffffff;">
	<a href="<?php echo base_url();?>" class="" style="">
		<img src="assets/images/logo-home.png" height="58"/>
	</a>
	<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarMenu">
		<i class="fas fa-bars" style="color: #35405a !important;"></i>
	</button>
	<div class="collapse navbar-collapse" id="navbarMenu">
		<ul class="navbar-nav ml-auto text-uppercase">
			<li class="nav-item ml-1">
				<a href="<?php echo base_url();?>" class="nav-link font-navbar"><?php echo MultiLang('home'); ?></a>
			</li>
			<li class="nav-item ml-1 dropdown">
				<a href="#" class="nav-link dropdown-toggle font-navbar" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo MultiLang('service'); ?></a>

				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<?php
					if(!empty($service)){
						foreach ($service as $key => $value) {
					?>
					<a class="dropdown-item font-navbar" href="#"><?php echo $value->name?></a>
					<?php
						}
					}
					?>
				</div>
			</li>
			<li class="nav-item ml-1">
				<a href="<?php echo base_url();?>gallery" class="nav-link font-navbar"><?php echo MultiLang('gallery'); ?></a>
			</li>
			<li class="nav-item ml-1">
				<a href="<?php echo base_url();?>whoweare" class="nav-link font-navbar"><?php echo MultiLang('who_we_are'); ?></a>
			</li>
			<li class="nav-item ml-1 mr-3">
				<a href="<?php echo base_url();?>contact" class="nav-link font-navbar"><?php echo MultiLang('contact'); ?></a>
			</li>
			
			
			<li class="nav-item ml-5">&nbsp;</li>
			
			<li class="nav-item ml-1">
				<a href="#" class="nav-link" style="color:#0C74A8"; data-toggle="modal" data-target="#modal_form_login"><?php echo MultiLang('login'); ?></a>
			</li>
			<li class="nav-item ml-1">
				<a href="#" class="nav-link" style="color:#328C0E"; data-toggle="modal" data-target="#modal_form_register"><?php echo MultiLang('register'); ?></a>
			</li>
			<li class="nav-item ml-1 dropdown">
				<a href="#" class="nav-link font-navbar dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="<?php echo $path_language.$lang_set->icon;?>" style="max-width:18px !important;" /> <?php echo $lang_set->code?>
				</a>
				<div class="dropdown-menu dropdown-menu-right mb-2" aria-labelledby="navbarDropdown">
					<?php
					if(!empty($lang)){					
						foreach ($lang as $key => $value) {
					?>
					<a class="dropdown-item font-navbar" href="#"><img src="<?php echo $path_language.$value->icon;?>" style="max-width:18px !important;" /> <span class="text-capitalize"><?php echo $value->name?></span> (<?php echo $value->code?>)</a>
					<?php
						}
					}
					?>
				</div>
			</li>
		</ul>
	</div>
</nav>
<!-- /.navbar -->

<!-- Modal Form Login-->
<div class="modal fade" id="modal_form_login" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_form_login"><?php echo MultiLang('login'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="box_msg_login"></div>
				<form id="form_login" autocomplete="nope">
					<div class="form-group">
						<label for="emaillogin" class="text-capitalize"><?php echo MultiLang('email'); ?></label>
						<input type="email" class="form-control" id="emaillogin">
					</div>
					<div class="form-group">
						<label for="passwordlogin" class="text-capitalize"><?php echo MultiLang('password'); ?></label>
						<input type="password" class="form-control" id="passwordlogin">
					</div>
				</form>
			</div>
			<div class="modal-footer font-footer">
				<button type="button" class="btn btn-primary mr-auto" id="btnSave" onclick="login()"><?php echo MultiLang('login'); ?></button>
				<a href="" style="color: #212529 !important;"><?php echo MultiLang('forget_password'); ?>?</a>
			</div>
		</div>
	</div>
</div>

<!-- Modal Form Register-->
<div class="modal fade" id="modal_form_register" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="title_form_register"><?php echo MultiLang('register'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="box_msg_register"></div>
				<form id="form_register" autocomplete="nope">
					<div class="form-group">
						<label for="nameregister" class="text-capitalize"><?php echo MultiLang('name'); ?></label>
						<input type="name" class="form-control" id="nameregister">
					</div>
					<div class="form-group">
						<label for="emailregister" class="text-capitalize"><?php echo MultiLang('email'); ?></label>
						<input type="email" class="form-control" id="emailregister">
					</div>
					<div class="form-group">
					<label for="phone"><?php echo MultiLang('phone'); ?></label>
					<input type="number" id="phone" name="phone" class="form-control" onkeypress="return isNumber(event)">
					</div>
					<div class="form-group">
					<label for="gender"><?php echo MultiLang('gender'); ?></label>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="gender" id="gender1" value="male" checked>
						<label class="form-check-label" for="gender1">
							<?php echo MultiLang('male'); ?>
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="radio" name="gender" id="gender2" value="female">
						<label class="form-check-label" for="gender2">
							<?php echo MultiLang('female'); ?>
						</label>
					</div>
					</div>
					<div class="form-group">
					<label for="birthday"><?php echo MultiLang('birthday'); ?></label>
					<input type="text" id="birthday" name="birthday" class="form-control dates" placeholder="yyyy-mm-dd">
					</div>
					<div class="form-group">
						<label for="passwordregister" class="text-capitalize"><?php echo MultiLang('password'); ?></label>
						<input type="password" class="form-control" id="passwordregister">
					</div>
					<div class="form-group">
						<label for="retype_passwordregister" class="text-capitalize"><?php echo MultiLang('retype_password'); ?></label>
						<input type="retype_password" class="form-control" id="retype_passwordregister">
					</div>
				</form>
			</div>
			<div class="modal-footer font-footer">
				<button type="button" class="btn btn-primary" id="btnSave" onclick="register()"><?php echo MultiLang('register'); ?></button>
			</div>
		</div>
	</div>
</div>
