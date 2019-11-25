<!DOCTYPE html>
<html>
		<?php 
			$this->load->view('header');
		?>
		<div class="container">
			<div class="row mt-5">
				<div class="col-md-3 col-sm-12">
					<form id="filter_packages" autocomplete="nope">
						<div class="card">
							<div class="card-header">
								<i class="fas fa-filter" style="font-size: 14px;"></i> <?php echo MultiLang('filter'); ?>
							</div>
							<div class="card-body">
								<div class="card-title"><?php echo MultiLang('destination'); ?></div>
								<div class="form-group" id="destination_filter_div" style="height: 250px;">
									<?php
									if(!empty($combo_destination)){
										foreach ($combo_destination as $key => $value) {
									?>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="<?php echo $value->id;?>" name="destination<?php echo $value->id;?>" id="destination<?php echo $value->id;?>">
										<label class="form-check-label" for="destination<?php echo $value->id;?>">
											<?php echo $value->name;?>
										</label>
									</div>
									<?php
										}
									}
									?>
								</div>
								<hr>
								<div class="card-title"><?php echo MultiLang('price'); ?> (Rp)</div>
								<div class="form-group">
									<input type="text" class="form-control curr text-right" id="price_min" name="price_min" placeholder="<?php echo MultiLang('minimum'); ?>"/>
								</div>
								<div class="form-group">
									<input type="text" class="form-control curr text-right" id="price_max" name="price_max" placeholder="<?php echo MultiLang('maximum'); ?>"/>
								</div>
								<hr>
								<div class="card-title"><?php echo MultiLang('time'); ?></div>
								<div class="form-group">
									<select id="lang" name="lang" class="form-control">
										<option value="">
											-- <?php echo MultiLang('all'); ?> --
										</option>
									<?php
										if(!empty($combo_time->day) AND !empty($combo_time->night)){
											$night = 0;
											for($day = 1; $day <= $combo_time->day; $day++){
									?>
										<option value="<?php echo $day.','.$night;?>">
											<?php echo $day;?> <?php echo MultiLang('day'); ?>, <?php echo $night;?> <?php echo MultiLang('night'); ?>
										</option>	
										<option value="<?php echo $day.','.($night+1);?>">
											<?php echo $day;?> <?php echo MultiLang('day'); ?>, <?php echo $night+1;?> <?php echo MultiLang('night'); ?>
										</option>								
									<?php
												$night++;
											}
										}
									?>
									</select>
								</div>
								<hr>
								<div class="card-title"><?php echo MultiLang('rating'); ?></div>
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="5" name="rating5" id="rating5">
										<label class="form-check-label" for="rating5">
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="4" name="rating4" id="rating4">
										<label class="form-check-label" for="rating4">
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="far fa-star"></i> 
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="3" name="rating3" id="rating3">
										<label class="form-check-label" for="rating3">
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="far fa-star"></i> 
											<i class="far fa-star"></i> 
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="2" name="rating2" id="rating2">
										<label class="form-check-label" for="rating2">
											<i class="fas fa-star"></i> 
											<i class="fas fa-star"></i> 
											<i class="far fa-star"></i> 
											<i class="far fa-star"></i> 
											<i class="far fa-star"></i> 
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="checkbox" value="1" name="rating1" id="rating1">
										<label class="form-check-label" for="rating1">
											<i class="fas fa-star"></i> 
											<i class="far fa-star"></i> 
											<i class="far fa-star"></i> 
											<i class="far fa-star"></i> 
											<i class="far fa-star"></i> 
										</label>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="col-md-9 col-sm-12">
					<form id="filter_packages_sort" autocomplete="nope">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-8 col-sm-12 pt-2">
										<span><?php echo MultiLang('show'); ?> <span id="total_data" style="font-weight: bold;">10</span> <?php echo MultiLang('data'); ?></span>
									</div>
									<div class="col-md-4 col-sm-12">
										<select id="orderby" name="orderby" class="form-control">
											<option value="">
												-- <?php echo MultiLang('sort'); ?> --
											</option>
											<option value="latest">
												<?php echo MultiLang('latest'); ?>
											</option>
											<option value="most_popular">
												<?php echo MultiLang('most_popular'); ?>
											</option>
											<option value="lowest_price">
												<?php echo MultiLang('lowest_price'); ?>
											</option>
											<option value="highest_price">
												<?php echo MultiLang('highest_price'); ?>
											</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="row mt-4" id="packages_div">
						<?php
						if(!empty($tourpackages_begin)){
							foreach ($tourpackages_begin as $key => $value) {
						?>
							<div class="col-lg-4 col-md-6 col-sm-12">
								<a href="#" class="d-block mb-4 h-100">
									<div class="img-hover-zoom img-hover-zoom--brightness">
										<img class="img-fluid" src="<?php echo base_url().$value->img;?>" alt="">
										<span class="centered-text-img"><?php echo $value->name;?><br>(<?php echo $value->total_day;?> <?php echo MultiLang('day'); ?> <?php echo $value->total_night;?> <?php echo MultiLang('night'); ?>)<br>Rp <?php echo number_format($value->price_local, 2, ',', '.');?></span>
									</div>
								</a>
							</div>
						<?php
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php 
			$this->load->view('footer');
		?>
		<script>
			$(document).ready(function() {
				$(".curr").mask('00.000.000.000.000.000.000,00', {reverse: true});

				$("#destination_filter_div").overlayScrollbars({ 
					"scrollbars": {
						"visibility": "auto"
					}
				});
			});


		</script>
	</body>
</html>
