<?php $user_details = get_user_session_data(); ?>
<div class="clearfix"></div>
<section class="job-lst-page">
	<div class="banner-job-lst2">
		<div class="job-lst-bne-txt">
			<div class="container">
				<div class="row">
					<div class="dsply-inlne-blck mt-10">
						<h2 class="main-hed banr-txt-inr text-center  mt-0">Access denied!</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<section class="hire-prfle profile-sec">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-sm-12 xol-xs-12">
					<div class="prfle-hre-block sec-pad">
						<div class="prfle-othr-info">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="hire-prfle-back">
										<div class="hre-prfle-img-name text-center">
										</div>
										<div class="expnse-cmplte-job">
										   <div class="hire-prfle-featur brdr-0 text-center mb-20">
												<h2 class="title mt-0 mb-0">You don't have access to this content. Please try switching your user mode.</h2>
											</div>
											<div class="tab-frm TabFrm ">
												<h2 class="title  text-center mt-10 fnt-wgt-700">Select / Switch User Type</h2>
												<ul class="nav nav-pills mrginAuto mt-20">
													<li class="tab-nav-list <?php echo $user_details['userMode']=='hirer' ? 'active' : '' ;  ?>">
														<a href="javascript:void(0);" <?php echo $user_details['userMode']=='hirer' ? '' : 'id="changMode"' ;  ?>   ><span><img class="noact" src="<?php echo base_url(); ?>frontend_asset/images/icn-img-hire-gray.png"><img class="act" src="<?php echo base_url(); ?>frontend_asset/images/icn-img-whte-hire.png"></span>Hirer</a>
													</li>
													<li class="tab-nav-list <?php echo $user_details['userMode']=='worker' ? 'active' : '' ;  ?>">
														<a href="javascript:void(0);" <?php echo $user_details['userMode']=='worker' ? '' : 'id="changMode"' ;  ?> ><span><img class="noact" src="<?php echo base_url(); ?>frontend_asset/images/icn-img-work.png"><img class="act" src="<?php echo base_url(); ?>frontend_asset/images/icn-img-whte-work.png"></span>Worker</a>
													</li>                                        
												</ul>
											</div>
										</div>
									</div>									
								</div>								
							</div>							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>