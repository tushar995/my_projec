<?php      
    $frontend_asset= base_url();
?>
<div class="clearfix"></div>
<div class="mtgn-blnk-top"></div>
<!--login form-->
<section class="logn-frm sec-pad">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 xs-hidden">
				<div class="lgin-graphic-form">
					
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="logn-wre-form">
					<div class="form-ttle">
						<h3 class="frm-ttle-hed mt-0">Welcome<span class="flag"></span></h3>
					</div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="google-button btn-block mt-20"  id="customBtn" type="button">
                                <span class="google-button__icon">
                                    <img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>/google-icn.png" />
                                </span>
                                <span class="google-button__text">
                                    Log in with Google
                                </span>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="google-button fb-btn btn-block mt-20" type="button" onclick="login();">
                                <span class="google-button__icon">
                                    <img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>/	fb-icon.png" />
                                </span>
                                <span class="google-button__text">
                                    Log in with Facebook
                                </span>
                            </button>
                        </div>
                    </div>					
					<div class="text-tnsfrm-upr text-center fnt-wgt-700 mt-20">or</div>
					<form class="lve-wre-form-prt mt-20" id="login" action="<?php echo base_url(); ?>home/userLogin">
						<div class="form-group mb-25">
							<label>Email Id</label>
							<input type="email" name="email" class="form-control" autocomplete="off" placeholder="Email" />
						</div>
						<div class="form-group mb-25">
							<label>Password</label>
							<input type="password" name="password" class="form-control" placeholder="Password" />
						</div>
						
						<button type="button" class="btn-form btn-block btn-primary-form mt-5 login_user">Login</button>
					</form>
					<div class="text-center mt-25">
						<span class="mr-2 para">Need an account?</span>
						<a href="<?php echo base_url(); ?>auth/selectUserType" class="btn-link2">Create one</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<style>
    .pac-container{
        z-index:9999;
    }
</style>