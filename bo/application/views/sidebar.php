<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Admin BHIVA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                
                <li class="nav-item has-treeview">
                    <a href="<?php echo base_url();?>" class="nav-link <?php echo ($active_menu == 'dashboard' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            <?php echo MultiLang('dashboard'); ?>
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview <?php echo ($active_menu_parent == 'cms' ? 'menu-open' : ''); ?>">
                    <a href="<?php echo base_url();?>" class="nav-link <?php echo ($active_menu_parent == 'cms' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-file-image"></i>
                        <p>
                            <?php echo MultiLang('cms'); ?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>slider" class="nav-link <?php echo ($active_menu == 'slider' ? 'active' : ''); ?>">
                                <i class="fas fa-image nav-icon ml-4"></i>
                                <p><?php echo MultiLang('slider'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>service" class="nav-link <?php echo ($active_menu == 'service' ? 'active' : ''); ?>">
                                <i class="fas fa-hands nav-icon ml-4"></i>
                                <p><?php echo MultiLang('service'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>gallery" class="nav-link <?php echo ($active_menu == 'gallery' ? 'active' : ''); ?>">
                                <i class="fas fa-images nav-icon ml-4"></i>
                                <p><?php echo MultiLang('gallery'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>whoweare" class="nav-link <?php echo ($active_menu == 'whoweare' ? 'active' : ''); ?>">
                                <i class="fas fa-users nav-icon ml-4"></i>
                                <p><?php echo MultiLang('who_we_are'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>contact" class="nav-link <?php echo ($active_menu == 'contact' ? 'active' : ''); ?>">
                                <i class="fas fa-id-card nav-icon ml-4"></i>
                                <p><?php echo MultiLang('contact'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>privacypolicy" class="nav-link <?php echo ($active_menu == 'privacypolicy' ? 'active' : ''); ?>">
                                <i class="fas fa-user-shield nav-icon ml-4"></i>
                                <p><?php echo MultiLang('privacy_policy'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>termcondition" class="nav-link <?php echo ($active_menu == 'termcondition' ? 'active' : ''); ?>">
                                <i class="fas fa-file-signature nav-icon ml-4"></i>
                                <p><?php echo MultiLang('term_and_condition'); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo ($active_menu_parent == 'master_data' ? 'menu-open' : ''); ?>">
                    <a href="<?php echo base_url();?>" class="nav-link <?php echo ($active_menu_parent == 'master_data' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-hdd"></i>
                        <p>
                            <?php echo MultiLang('master_data'); ?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>destination" class="nav-link <?php echo ($active_menu == 'destination' ? 'active' : ''); ?>">
                                <i class="fas fa-map-marked-alt nav-icon ml-4"></i>
                                <p><?php echo MultiLang('destination'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>tourpackages" class="nav-link <?php echo ($active_menu == 'tourpackages' ? 'active' : ''); ?>">
                                <i class="fas fa-layer-group nav-icon ml-4"></i>
                                <p><?php echo MultiLang('tourpackages'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>ticket" class="nav-link <?php echo ($active_menu == 'ticket' ? 'active' : ''); ?>">
                                <i class="fas fa-ticket-alt nav-icon ml-4"></i>
                                <p><?php echo MultiLang('ticket'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>venue" class="nav-link <?php echo ($active_menu == 'venue' ? 'active' : ''); ?>">
                                <i class="fas fa-place-of-worship nav-icon ml-4"></i>
                                <p><?php echo MultiLang('venue'); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo ($active_menu_parent == 'setting' ? 'menu-open' : ''); ?>">
                    <a href="<?php echo base_url();?>" class="nav-link <?php echo ($active_menu_parent == 'setting' ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            <?php echo MultiLang('setting'); ?>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>visitortype" class="nav-link <?php echo ($active_menu == 'visitortype' ? 'active' : ''); ?>">
                                <i class="fas fa-walking nav-icon ml-4"></i>
                                <p><?php echo MultiLang('visitor_type'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>language" class="nav-link <?php echo ($active_menu == 'language' ? 'active' : ''); ?>">
                                <i class="fas fa-comment-dots nav-icon ml-4"></i>
                                <p><?php echo MultiLang('language'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>translation" class="nav-link <?php echo ($active_menu == 'translation' ? 'active' : ''); ?> set_url_log">
                                <i class="fas fa-language nav-icon ml-4"></i>
                                <p><?php echo MultiLang('translation'); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url();?>user" class="nav-link <?php echo ($active_menu == 'user' ? 'active' : ''); ?>">
                                <i class="fas fa-user nav-icon ml-4"></i>
                                <p><?php echo MultiLang('user'); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<!-- <script src="assets/plugins/sparklines/sparkline.js"></script> -->
<!-- JQVMap -->
<script src="assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="assets/plugins/jqvmap/maps/jquery.vmap.world.js"></script>
<!-- jQuery Knob Chart -->
<script src="assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="assets/plugins/moment/moment.min.js"></script>
// <script src="assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="assets/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<!-- Toastr -->
<script src="assets/plugins/toastr/toastr.min.js"></script>
<!-- DataTables -->
<script src="assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- Datepicker -->
<script src="assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- Datetimepicker -->
// <script src="assets/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.js"></script>
<!-- InputMask -->
<script src="assets/dist/js/jquery.mask.min.js"></script>
<script>
$(document).ready(function() {
    setInterval(() => {
        $.post("<?php echo site_url('login/get_session_login');?>", function(data) {
            if(data == '0'){
                window.location.href = "<?php echo base_url(); ?>";
            }
        });
    }, (1000 * 60));
});
</script>