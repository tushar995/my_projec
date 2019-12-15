<section class="logn-frm slct-user-typ-sec lve-wre-form-prt">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12">
				<div class="lst-job mt-30 ">
			        <div class="clearfix">
			            <div class="" id="1a">
							<div class="logn-wre-form shdw-bg pd-20 mb-30">
								<div class="form-ttle">
									<h3 class="frm-ttle-hed mt-0">Your Profile</h3>
									<!-- <p class="para">Set ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p> -->
								</div>
								<form class="lve-wre-form-prt mt-20" >
									<div class="form-group mb-25 text-center">
                                        <div class="log_div log_div1 ">
                                          	<img src="<?php echo $user->profileImage; ?>" id="pImg">
                                        </div>
                                	</div>

									<div class="form-group mb-25">
										<h3 class="form-control"><?php echo $user->first_name; ?></h3><span>First name</span>
									</div>

									<div class="form-group mb-25">
										<h3 class="form-control"><?php echo $user->last_name; ?></h3><span>Last name</span>
									</div>

									<div class="form-group mb-25">
										<h3 class="form-control"><?php echo $user->email; ?></h3>
									</div><span>Email</span>
									
									<div class="form-group mb-25">
										<h3 class="form-control"><?php 

											if(!empty($user->contact_detail)){
												echo $user->contact_detail ;
											}else{
												echo "Na";
											}
										 ?></h3><span>Address</span>
									</div>

									<div class="form-group mb-25">
										<h3 class="form-control">
											<?php 

												if(!empty($user->country)){
													echo $user->gender ;
												}else{
													echo "Na";
												}
											?></h3><span>Country</span>
									</div>

									<div class="form-group mb-25">
										<h3 class="form-control"><?php 
											if(!empty($user->gender)){
												echo $user->gender == 1 ? 'Male' : 'Female';
											}else{
												echo "Na";
											}
										?></h3><span>Gender</span>
									</div>
								</form>
							</div>
			            </div>
					</div>
				</div>			
			</div>
		</div>
	</div>
</section>
<style>
    .pac-container{ z-index:9999; }
</style>
