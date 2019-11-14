<!DOCTYPE html>
<html>
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
		<div class="container">
			<div class="row mt-5 mb-5 d-flex justify-content-center">
				<img src="<?php echo base_url();?>assets/images/logo-home-text.png" height="60"/>
			</div>
			<div class="row p-2" style="text-align: justify;">
				<?php echo $privacypolicy->text; ?>
			</div>
		</div>
	</body>
</html>
