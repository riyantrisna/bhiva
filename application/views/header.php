<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>BHIVA</title>
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/logo.ico" />
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- bootstrap -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/fontawesome-free/css/all.min.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="<?php echo base_url();?>assets/google-font.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/main.css">
	<!-- Date picker -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-datepicker/bootstrap-datepicker.min.css">
	<!-- lightbox -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/ekko-lightbox.css">
	<!-- Social Share Kit CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/dist/css/social-share-kit.css" type="text/css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Toastr -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/toastr/toastr.min.css">
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables-bs4/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>
<body>
<?php
//set session userdata
if(!$this->session->userdata('user_lang')){
	$session_data = array(
		'user_lang' =>  'id'
	);
	$this->session->set_userdata($session_data);
}
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-md sticky-top border-grey-theme-bottom" style="background-color: #ffffff;">
	<a href="<?php echo base_url();?>" class="" style="">
		<img src="<?php echo base_url();?>assets/images/logo-home.png" height="58"/>
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
							if($value->type == 1){
					?>
					<a class="dropdown-item font-navbar" href="<?php echo base_url();?>tourpackages"><?php echo $value->name?></a>
					<?php
							}elseif($value->type == 2){
					?>
					<a class="dropdown-item font-navbar" href="<?php echo base_url();?>templeticket"><?php echo $value->name?></a>
					<?php
							}elseif($value->type == 3){
					?>
					<a class="dropdown-item font-navbar" href="<?php echo base_url();?>venue"><?php echo $value->name?></a>
					<?php
							}else{
					?>
					<a class="dropdown-item font-navbar" href="<?php echo base_url();?>service/view/<?php echo $value->id.'/'.(preg_replace("/\W|_/","-",$value->name));?>"><?php echo $value->name?></a>
					<?php
							}
							echo (($key+1) < count($service)) ? '<div class="dropdown-divider"></div>' : '';
						}
					}
					?>
				</div>
			</li>
			<li class="nav-item ml-1">
				<a href="<?php echo base_url();?>gallery" class="nav-link font-navbar"><?php echo MultiLang('gallery'); ?></a>
			</li>
			<li class="nav-item ml-1">
				<a href="<?php echo base_url();?>aboutus" class="nav-link font-navbar"><?php echo MultiLang('about_us'); ?></a>
			</li>
			<li class="nav-item ml-1 mr-3">
				<a href="<?php echo base_url();?>contact" class="nav-link font-navbar"><?php echo MultiLang('contact'); ?></a>
			</li>
			
			
			<li class="nav-item ml-5">&nbsp;</li>
			<li class="nav-item ml-1 dropdown">
				<a href="#" class="nav-link font-navbar dropdown-toggle" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img src="<?php echo $path_language.$lang_set->icon;?>" class="rounded-circle mb-1" style="width: 24px; height: 24px;" /> <?php echo $lang_set->code?>
				</a>
				<div class="dropdown-menu dropdown-menu-right mb-2" aria-labelledby="navbarDropdown">
					<?php
					if(!empty($lang)){					
						foreach ($lang as $key => $value) {
					?>
					<a class="dropdown-item font-navbar" href="<?php echo base_url();?>home/changelanguage/<?php echo $value->code;?>"><img src="<?php echo $path_language.$value->icon;?>" style="max-width:18px !important;" /> <span class="text-capitalize"><?php echo $value->name?></span> (<?php echo $value->code?>)</a>
					<?php echo (($key+1) < count($lang)) ? '<div class="dropdown-divider"></div>' : ''; ?>
					<?php
						}
					}
					?>
				</div>
			</li>
			<?php
			if($this->session->userdata('user_id')){
				$user_real_name = explode(' ', $this->session->userdata('user_real_name'));
			?>
			<li class="nav-item ml-1 dropdown">
				<a class="nav-link font-navbar dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<img src="<?php echo $this->session->userdata('user_photo'); ?>" class="rounded-circle mb-1" style="width: 25px; height: 25px;" />&nbsp;<span style="text-transform: capitalize;"><?php echo $user_real_name[0]; ?></span>
				</a>
				<div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
					<a href="<?php echo base_url().'user/profile'; ?>" class="dropdown-item">
						<i class="fas fa-user mr-2"></i> <span style="text-transform: capitalize;"><?php echo MultiLang('profile'); ?></span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="<?php echo base_url().'user/transaction'; ?>" class="dropdown-item">
						<i class="fas fa-receipt  mr-2"></i> <span style="text-transform: capitalize;"><?php echo MultiLang('my_order'); ?></span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="<?php echo base_url().'user/changepassword'; ?>" class="dropdown-item">
						<i class="fas fa-lock mr-2"></i><span style="text-transform: capitalize;"><?php echo MultiLang('change_password'); ?></span>
					</a>
					<div class="dropdown-divider"></div>
					<a href="<?php echo base_url().'user/logout'; ?>" class="dropdown-item">
						<i class="fas fa-sign-out-alt mr-2"></i><span style="text-transform: capitalize;"><?php echo MultiLang('logout'); ?></span>
					</a>
				</div>
			</li>
			<?php
			}else{
			?>
			<li class="nav-item ml-1">
				<a href="#" class="nav-link" style="color:#0C74A8"; data-toggle="modal" data-target="#modal_form_login"><?php echo MultiLang('login'); ?></a>
			</li>
			<li class="nav-item ml-1">
				<a href="#" class="nav-link" style="color:#328C0E"; data-toggle="modal" data-target="#modal_form_register"><?php echo MultiLang('register'); ?></a>
			</li>
			<?php
			}
			?>
			
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
						<input type="email" name="email" class="form-control" id="emaillogin">
					</div>
					<div class="form-group">
						<label for="passwordlogin" class="text-capitalize"><?php echo MultiLang('password'); ?></label>
						<input type="password" name="password" class="form-control" id="passwordlogin">
					</div>
				</form>
			</div>
			<div class="modal-footer font-footer">
				<button type="button" class="btn btn-primary mr-auto" id="btnLogin" onclick="login()"><?php echo MultiLang('login'); ?></button>
				<a href="<?php echo base_url().'home/forgetpassword'; ?>" style="color: #212529 !important;"><?php echo MultiLang('forget_password'); ?>?</a>
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
						<label for="nameregister" class="text-capitalize"><?php echo MultiLang('name'); ?> *</label>
						<input type="name" name="name" class="form-control" id="nameregister">
					</div>
					<div class="form-group">
						<label for="emailregister" class="text-capitalize"><?php echo MultiLang('email'); ?> *</label>
						<input type="email" name="email" class="form-control" id="emailregister">
					</div>
					<div class="form-group">
					<label for="phone"><?php echo MultiLang('phone'); ?> *</label>
					<input type="number" id="phone" name="phone" class="form-control" onkeypress="return isNumber(event)">
					</div>
					<div class="form-group">
					<label for="gender"><?php echo MultiLang('gender'); ?> *</label>
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
					<label for="birthday"><?php echo MultiLang('birthday'); ?> *</label>
					<input type="text" id="birthday" name="birthday" class="form-control dates_register" placeholder="yyyy-mm-dd">
					</div>
					<div class="form-group">
						<label for="passwordregister" class="text-capitalize"><?php echo MultiLang('password'); ?> *</label>
						<input type="password" name="password" class="form-control" id="passwordregister">
					</div>
					<div class="form-group">
						<label for="retype_passwordregister" class="text-capitalize"><?php echo MultiLang('retype_password'); ?> *</label>
						<input type="password" name="repassword" class="form-control" id="retype_passwordregister">
					</div>
				</form>
			</div>
			<div class="modal-footer font-footer">
				<button type="button" class="btn btn-primary" id="btnRegister" onclick="register()"><?php echo MultiLang('register'); ?></button>
			</div>
		</div>
	</div>
</div>
<script>
function register()
{
    $('#btnRegister').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnRegister').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('home/register')?>";

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_register').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status)
                { 
                    $('#modal_form_register').modal('toggle');
                    $("#box_msg_register").html('').hide();
					$('#form_register')[0].reset();
                    await toastr.success(data.message, '', {"positionClass": "toast-top-left"});
                }
                else
                {
                    await $('#box_msg_register').html(data.message).fadeOut().fadeIn();
                    $('#modal_form_register').animate({ scrollTop: 0 }, 'slow');
                }
            }else{
                $('#modal_form_register').modal('toggle');
                toastr.error(xhr.statusText, '', {"positionClass": "toast-top-left"});
            }

            $('#btnRegister').text('<?php echo MultiLang('register'); ?>');
            $('#btnRegister').attr('disabled',false);

        }
    });
}

function login()
{
    $('#btnLogin').text('<?php echo MultiLang('process'); ?>...'); //change button text
    $('#btnLogin').attr('disabled',true); //set button disable 
    var url;

    url = "<?php echo site_url('home/login')?>";

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_login').serialize(),
        dataType: "json",
        success: async function(data, textStatus, xhr)
        {
            if(xhr.status == '200'){
                if(data.status){
					window.location.href = "<?php echo base_url();?>";
				}else{ 
                    await $('#box_msg_login').html(data.message).fadeOut().fadeIn();
                    $('#modal_form_login').animate({ scrollTop: 0 }, 'slow');
                }
            }else{
				await $('#box_msg_login').html(xhr.statusText).fadeOut().fadeIn();
            }

            $('#btnLogin').text('<?php echo MultiLang('login'); ?>');
            $('#btnLogin').attr('disabled',false);

        }
    });
}
</script>