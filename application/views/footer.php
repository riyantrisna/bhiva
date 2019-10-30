<!-- Footer -->
<form style="margin-top: 2rem !important;">
    <div class="form-row align-middle justify-content-center col-md-12"
        style="background-color: #0090D6; padding-top:1rem;">
        <div class="col-md-6 row justify-content-left text-center form-group" style="padding-top: 7px;">
            <span style="color: #ffffff;"><?php echo MultiLang('text_subscribe'); ?></span>
        </div>
        <div class="col-md-6 row">
            <div class="justify-content-center text-center col-md-10 form-group">
                <input class="form-control" id="subscribe" placeholder="<?php echo MultiLang('enter_your_email'); ?>" />
            </div>
            <div class="justify-content-center text-center col-md-2 form-group">
                <button type="button" class="btn btn-warning"><?php echo MultiLang('subscribe'); ?></button>
            </div>
        </div>
    </div>
</form>

<footer>
    <div class="container pt-5 border-bottom">
        <div class="row">
            <div class="col-md-3 col-sm-12 mb-3 text-center">
                <img src="assets/images/logo-home-text.png" height="60"/>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="col-md-3 col-sm-6 col-6 p-0 float-left mb-3">
                    <h5 class="mb-4 font-weight-bold text-uppercase text-grey-theme"><?php echo MultiLang('service'); ?></h5>
                    <ul class="list-group">
                        <?php
                        if(!empty($service)){
                            foreach ($service as $key => $value) {
                        ?>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="#"><?php echo $value->name?></a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-6 mb-3 p-0 float-left">
                    <h5 class="mb-4 font-weight-bold text-uppercase text-grey-theme"><?php echo MultiLang('company'); ?></h5>
                    <ul class="list-group">
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href=""><?php echo MultiLang('who_we_are');?></a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href=""><?php echo MultiLang('contact'); ?></a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href=""><?php echo MultiLang('gallery'); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-6 mb-3 p-0 float-left">
                    <h5 class="mb-4 font-weight-bold text-uppercase text-grey-theme"><?php echo MultiLang('follow_us_on'); ?></h5>
                    <ul class="list-group">
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href=""><i class="fab fa-facebook-f mr-3"></i> Facebook</a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href=""><i class="fab fa-twitter mr-2"></i> Twitter</a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href=""><i class="fab fa-instagram mr-3"></i>Instagram</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6 col-6 p-0 mb-3 float-left">
                    <h5 class="mb-4 font-weight-bold text-uppercase text-grey-theme"><?php echo MultiLang('support');?></h5>
                    <ul class="list-group">
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href=""><?php echo MultiLang('privacy_policy');?></a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href=""><?php echo MultiLang('term_and_condition');?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ./Footer -->

<!-- jQuery -->
<script src="assets/dist/js/jquery-3.3.1.slim.min.js"></script>
<!-- popper -->
<script src="assets/dist/js/popper.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/dist/js/bootstrap.min.js"></script>
<!-- Datepicker -->
<script src="assets/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Main -->
<script src="assets/dist/js/main.js"></script>

<script>
$(document).ready(function() {
	$(".dates").datepicker({
		format: 'yyyy-mm-dd'
	});
});
</script>