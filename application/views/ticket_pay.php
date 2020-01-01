<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container mt-5">
			<div class="row text-center">
				<div class="col-md-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<h5>
									<b><?php echo MultiLang('payment'); ?></b>
								</h5>
							</div>
							<hr>
							<div class="form-group">
								<b><?php echo $transaction_ticket->ticket_name;?></b>
							</div>
							<hr>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('visit_date'); ?>
							</div>
							<div class="form-group">
								<?php echo $transaction_ticket->visit_date;?>
							</div>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('price'); ?>
							</div>
							<?php
							if(!empty($local)){
								foreach($local AS $key => $value){
									$visitortype_name = (!empty($value->visitortype_name) ? '('.$value->visitortype_name.')' : '');
							?>
							<div class="form-group">
								<?php echo MultiLang('local_tourists').' '.$visitortype_name; ?> (@ Rp <?php echo number_format($value->price, 0, ',', '.');?> x <?php echo $value->qty;?>)
								<span style="color: #212529; font-weight: bold;">
									Rp <?php echo number_format(($value->price * $value->qty), 0, ',', '.');?>
								</span>
							</div>
							<?php 
								}
							} 
							?>
							<?php
							if(!empty($foreign)){
								foreach($foreign AS $key => $value){
									$visitortype_name = (!empty($value->visitortype_name) ? '('.$value->visitortype_name.')' : '');
							?>
							<div class="form-group">
								<?php echo MultiLang('foreign_tourists').' '.$visitortype_name; ?> (@ Rp <?php echo number_format($value->price, 0, ',', '.');?> x <?php echo $value->qty;?>)
								<span style="color: #212529; font-weight: bold;">
									Rp <?php echo number_format(($value->price * $value->qty), 0, ',', '.');?>
								</span>
							</div>
							<?php 
								}
							} 
							?>
							<hr>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('payment_total'); ?>
							</div>
							<div class="form-group">
								<div class="card-title mt-auto">
									<h5 style="color: #212529; font-weight: bold;">Rp <?php echo number_format( $transaction_ticket->total, 0, ',', '.');?></h5>
								</div>
							</div>
							<hr>
							<?php if(!empty($transaction_ticket->midtrans_transaction_id) AND $transaction_ticket->status=='1' AND $transaction_ticket->payment_type=='gopay'){ ?>
							<div class="form-group" style="color: #212529; font-weight: bold;">
								<?php echo MultiLang('qrcode_gopay'); ?>
								<br>
								<img src="<?php echo $this->config->item('qrcode_gopay_url').$transaction_ticket->midtrans_transaction_id.'/qr-code';?>" width="200" height="200">
							</div>
							<hr>
							<div class="form-group">
								<a href="<?php echo base_url().'user/transaction'; ?>" type="button" class="btn btn-primary" ><?php echo MultiLang('my_order'); ?></a>
							</div>
							<?php }else{ ?>
							<div class="form-group">
								<button type="button" class="btn btn-warning" style="font-weight: bold; padding: 10px 50px;" onclick="pay('<?php echo $transaction_ticket->midtrans_snap_token;?>');"><?php echo MultiLang('pay'); ?></button>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php 
			$this->load->view('footer');
		?>
		<script>
			function pay(token){
				snap.pay(token, {
					onSuccess: function(result){
						window.location.href = "<?php echo base_url(); ?>/user/transaction"
					},
					onPending: function(result){
						window.location.href = "<?php echo base_url(); ?>/user/transaction"
					},
					onError: function(result){
						window.location.href = "<?php echo base_url(); ?>/user/transaction"
						// toastr.error('<?php echo MultiLang('there_is_an_error');?>');
					}
					// ,
					// onClose: function(){
					// 	window.location.href = "<?php echo base_url(); ?>/user/transaction"
					// }
				});
			}
		
		</script>
	</body>
</html>
