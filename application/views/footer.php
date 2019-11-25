<!-- Footer -->
<form style="margin-top: 2rem !important;">
    <div class="form-row align-middle justify-content-center col-md-12"
        style="background-color: #0C74A8; padding-top:1rem; margin-left:0;">
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
            <div class="col-md-3 col-sm-12 mb-3 text-left">
                <img src="<?php echo base_url();?>assets/images/logo-home-text.png" height="60"/>
                <ul class="list-group mt-3">
                    <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer" style="font-size: 14px;">
                        <?php echo $contact->address; ?>
                    </li>
                    <?php if(!empty($contact->email)){ ?>
                    <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                        <a href="javascript:void(0)"><i class="fas fa-envelope mr-2"></i> <?php echo $contact->email;?></a>
                    </li>
                    <?php } ?>
                    <?php if(!empty($contact->phone)){ ?>
                    <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                        <a href="javascript:void(0)"><i class="fas fa-phone mr-2"></i> <?php echo $contact->phone;?></a>
                    </li>
                    <?php } ?>
                    <?php if(!empty($contact->wa)){ ?>
                    <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                        <a href="javascript:void(0)"><i class="fab fa-whatsapp  mr-3"></i><?php echo $contact->wa;?></a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="col-md-3 col-sm-6 col-6 p-0 float-left mb-3">
                    <div class="mb-4 text-uppercase font-footer font-weight-bold"><?php echo MultiLang('service'); ?></div>
                    <ul class="list-group">
                        <?php
                        if(!empty($service)){
                            foreach ($service as $key => $value) {
                                if($value->type == 1){
                        ?>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>tourpackages"><?php echo $value->name?></a>
                        </li>
                        <?php
                                }elseif($value->type == 2){
                        ?>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>templeticket"><?php echo $value->name?></a>
                        </li>
                        <?php
                                }elseif($value->type == 3){
                        ?>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>venue"><?php echo $value->name?></a>
                        </li>
                        <?php
                                }else{
                        ?>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>service/view/<?php echo $value->id.'/'.(str_replace(' ','-',$value->name));?>"><?php echo $value->name?></a>
                        </li>
                        <?php
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-6 p-0 float-left mb-3">
                    <div class="mb-4 text-uppercase font-footer font-weight-bold"><?php echo MultiLang('destination'); ?></div>
                    <ul class="list-group">
                        <?php
                        if(!empty($destination_location)){
                            foreach ($destination_location as $key => $value) {
                        ?>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>destination?section=<?php echo (preg_replace("/\W|_/","-",$value->name));?>"><?php echo $value->name?></a>
                        </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-6 mb-3 p-0 float-left">
                    <div class="mb-4 text-uppercase font-footer font-weight-bold"><?php echo MultiLang('company'); ?></div>
                    <ul class="list-group">
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>gallery"><?php echo MultiLang('gallery'); ?></a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>whoweare"><?php echo MultiLang('who_we_are');?></a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>contact"><?php echo MultiLang('contact'); ?></a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>travelpost"><?php echo MultiLang('travel_post'); ?></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6 col-6 mb-3 p-0 float-left">
                    <div class="mb-4 text-uppercase font-footer font-weight-bold"><?php echo MultiLang('follow_us_on'); ?></div>
                    <ul class="list-group">
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo $contact->fb;?>" target="_blank"><i class="fab fa-facebook-f mr-3"></i> Facebook</a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo $contact->twitter;?>" target="_blank"><i class="fab fa-twitter mr-2"></i> Twitter</a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo $contact->ig;?>" target="_blank"><i class="fab fa-instagram mr-3"></i>Instagram</a>
                        </li>
                    </ul>
                </div>

                <div class="col-md-3 col-sm-6 col-6 p-0 mb-3 float-left">
                    <div class="mb-4 text-uppercase font-footer font-weight-bold"><?php echo MultiLang('support');?></div>
                    <ul class="list-group">
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>privacypolicy" target="_blank"><?php echo MultiLang('privacy_policy');?></a>
                        </li>
                        <li class="list-group-item bg-transparent border-0 p-0 mb-2 font-footer">
                            <a href="<?php echo base_url();?>termandcondition" target="_blank"><?php echo MultiLang('term_and_condition');?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<footer class="py-4 bg-dark text-white-50" style="flex-shrink: none;">
    <div class="container text-center">
      <small>Copyright &copy; 2019 BHIVA</small>
    </div>
</footer>
<!-- ./Footer -->

<div id="loaders" class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-sm" style="display: table; position: relative; margin: 0 auto; top: calc(50% - 24px);">
        <div class="modal-content" style="width: 48px; background-color: transparent; border: none;">
            <span class="fa fa-spinner fa-spin fa-3x" style="color: #ffffff;"></span>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?php echo base_url();?>assets/dist/js/jquery/jquery.js"></script>
<!-- popper -->
<script src="<?php echo base_url();?>assets/dist/js/popper.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>assets/dist/js/bootstrap.min.js"></script>
<!-- Datepicker -->
<script src="<?php echo base_url();?>assets/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Main -->
<script src="<?php echo base_url();?>assets/dist/js/main.js"></script>
<!-- lightbox -->
<script src="<?php echo base_url();?>assets/dist/js/ekko-lightbox.min.js"></script>
<!-- Social Share Kit JS -->
<script src="<?php echo base_url();?>assets/dist/js/social-share-kit.js"></script>
<!-- InputMask -->
<script src="assets/dist/js/jquery.mask.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script>
$(document).ready(function() {
	$(".dates").datepicker({
		format: 'yyyy-mm-dd'
	});
});

</script>