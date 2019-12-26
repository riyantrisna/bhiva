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
								<li class="list-group-item" style="background-color: #0C74A8; color: #ffffff; border-radius: 0 !important;">
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
				<div class="col-md-9 col-sm-12">
					<form id="form_changepassword">
						<div class="card">
							<div class="card-header">
								<div class="row">
									<div class="col-md-8 col-sm-12 pt-2">
										<b><?php echo MultiLang('my_order'); ?></b>
									</div>
									<div class="col-md-4 col-sm-12">
										<select onchange="filter(0,10);" id="type" name="type" class="form-control">
											<option value="">
												-- <?php echo MultiLang('all'); ?> --
											</option>
											<option value="1">
												<?php echo MultiLang('tourpackages'); ?>
											</option>
											<option value="2">
												<?php echo MultiLang('ticket'); ?>
											</option>
										</select>
									</div>
								</div>
							</div>
							<div class="card-body" id="transaction_div">
								
								<?php
								if(!empty($transaction)){
									foreach ($transaction as $key => $value) {
								?>
								<div class="card mb-4">
									<div class="card-header">
										<div class="row">
											<div class="col-md-6 col-sm-12">
												<?php echo MultiLang('transaction_id'); ?> - <b><?php echo $value->code;?></b>
											</div>
											<div class="col-md-6 col-sm-12 text-md-right text-sm-left">
												<b>Rp <?php echo number_format($value->total, 0, ',', '.');?></b>
											</div>
										</div>
									</div>
									<div class="card-body">
										<?php
										if($value->type=='1'){
											$type = '<i class="fas fa-layer-group nav-icon"></i>&nbsp;&nbsp;'.(MultiLang('tourpackages'));
										}elseif($value->type=='2'){
											$type = '<i class="fas fa-ticket-alt nav-icon"></i>&nbsp;&nbsp;'.(MultiLang('ticket'));
										}elseif($value->type=='3'){
											$type = '<i class="fas fa-place-of-worship nav-icon"></i>&nbsp;&nbsp;'.(MultiLang('venue'));
										}else{
											$type = '';
										}
										?>
										<div class="form-group">
											<b> <?php echo $type;?></b>
										</div>
										<div class="form-group">
											<?php echo $value->name;?>
										</div>
										
									</div>
									<div class="card-footer">
										<?php 
										if($value->status=='1'){
											$status = MultiLang('waiting_for_payment');
											$status_color_class = 'badge badge-pill badge-warning';
										}elseif($value->status=='2'){
											$status = MultiLang('payment_successful');
											$status_color_class = 'badge badge-pill badge-success';
										}elseif($value->status=='3'){
											$status = MultiLang('expired_order');
											$status_color_class = 'badge badge-pill badge-danger';
										}elseif($value->status=='4'){
											$status = MultiLang('on_hold');
											$status_color_class = 'badge badge-pill badge-warning';
										}else{
											$status = '';
											$status_color_class = '';
										}										
										?>
										
										<div class="row">
											<div class="col-md-6 col-sm-12 mb-1">
												<span class="<?php echo $status_color_class;?>" style="font-size: 14px;">
													<?php echo $status;?>
												</span>
											</div>
											<div class="col-md-6 col-sm-12 text-md-right text-sm-left">
												<?php if($value->status=='1'){ ?>
												<button class="btn btn-sm btn-success" href="javascript:void(0)" title="<?php echo MultiLang('complete_payment')?>" id="btn_pay" onclick="pay_transaction('<?php echo $value->id; ?>')">
													<i class="fas fa-money-bill-wave"></i> <?php echo MultiLang('complete_payment')?>
												</button>
												<?php } ?>
												<a class="btn btn-sm btn-info" href="javascript:void(0)" title="<?php echo MultiLang('detail')?>" onclick="detail_transaction('<?php echo $value->id; ?>')">
													<i class="fas fa-search"></i> <?php echo MultiLang('detail')?>
												</a>
											</div>
										</div>
									</div>
								</div>
								<?php
									}
								if($transaction_total > 10){
								?>
								<div id="btn-load-more-div" class="col-sm-12 mt-3 text-center justify-content-center">
									<button type="button" class="btn btn-primary btn-load-more" onclick="load_more(10, 10)"><?php echo MultiLang('load_more'); ?></button>
								</div>
								<?php
									}
								}else{
								?>
								<div class="col-12 text-center"><i>-- <?php echo MultiLang('empty_transaction');?> --</i></div>
								<?php
								}
								?>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="title_detail"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="body_detail">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo MultiLang('close'); ?></button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="title_info"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" id="body_info">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="btnOk" onclick="window.location.href = '<?php echo base_url().'user/transaction'; ?>'"><?php echo MultiLang('ok'); ?></button>
					</div>
				</div>
			</div>
		</div>
		
		<?php 
			$this->load->view('footer');
		?>
		<script>
			

			// $(document).ready(function() {
				
			// });

			async function filter(page, limit){
				await $('#loaders').modal('show');

				var type = $("#type").val();
				data = 'type='+type+'&page='+page+'&limit='+limit;

				await jQuery.ajax({
					url : "<?php echo site_url('user/filter_transaction/')?>",
					type: "POST",
					data: data,
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							await $("#transaction_div").html(data.html).fadeOut().fadeIn();

							await $('#loaders').on('shown.bs.modal', function (e) {
								$('#loaders').modal('hide');
							});

							await $('html, body').animate({
								scrollTop: $("#transaction_div").offset().top - 200
							}, 1000);
						}else{
							await $('#loaders').on('shown.bs.modal', function (e) {
								$('#loaders').modal('hide');
							})
						}

					}
				});

				$('#loaders').on('shown.bs.modal', function (e) {
					$('#loaders').modal('hide');
				})
				
			}

			async function load_more(page, limit){
				await $('#loaders').modal('show');
				await $('.btn-load-more').html('<?php echo MultiLang('loading'); ?>...');

				var type = $("#type").val();
				data = 'type='+type+'&page='+page+'&limit='+limit;

				await jQuery.ajax({
					url : "<?php echo site_url('user/filter_transaction/')?>",
					type: "POST",
					data: data,
					dataType: "json",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							$('#btn-load-more-div, .btn-load-more').hide();
							$('#transaction_div').append(data.html);
						}else{
							$('#btn-load-more-div, .btn-load-more').hide();
						}

					}
				});

				await $('#loaders').on('shown.bs.modal', function (e) {
					$('#loaders').modal('hide');
				})

				$('#btn-load-more-div, .btn-load-more').hide();
				
			}


			function detail_transaction(id)
			{
				$('#title_detail').text('<?php echo MultiLang('detail'); ?> <?php echo MultiLang('my_order'); ?>'); // Set Title to Bootstrap modal title

				$.ajax({
					url : "<?php echo site_url('user/detail_transaction/')?>" + id,
					type: "GET",
					dataType: "JSON",
					success: function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							$('#body_detail').html(data.html);
						}else{
							toastr.error(xhr.statusText);
						}

						$('#modal_detail').modal('show'); // show bootstrap modal

					}
				});
			}

			async function pay_transaction(id){
				await $('#btn_pay').html('<?php echo MultiLang('checking_status'); ?>...');
				$('#btn_pay').attr('disabled',true); //set button disable 

				$.ajax({
					url : "<?php echo site_url('user/detail_data_transaction/')?>" + id,
					type: "GET",
					dataType: "JSON",
					success: async function(data, textStatus, xhr)
					{
						if(xhr.status == '200'){
							if(data.is_change){
								await $('#body_info').html(data.is_change_text);
								await $('#modal_info').modal('show'); // show bootstrap modal
							}else{
								if(data.redirect_page != ''){
									window.location.href = "<?php echo base_url(); ?>"+data.redirect_page+data.transaction_code;
								}else{
									$('#body_info').modal('toggle');
              						toastr.error('<?php echo MultiLang('there_is_an_error');?>');
								}
							}
						}else{
							toastr.error(xhr.statusText);
						}

						await $('#btn_pay').html('<?php echo MultiLang('complete_payment'); ?>');
						$('#btn_pay').attr('disabled',false);

					}
				});
			}
		</script>
	</body>
</html>
