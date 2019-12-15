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
				<!-- <div class="lgin-graphic-form2">
					<img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>/new-img-1.png" />
				</div> -->
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="logn-wre-form">
					<div class="form-ttle">
						<h3 class="frm-ttle-hed mt-0">Let's get started</h3>
						<p class="para mt-20">Sign up for your account</p>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="google-button btn-block mt-20" id="customBtn" type="button">
                                <span class="google-button__icon">
                                    <img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>/google-icn.png" />
                                </span>
                                <span class="google-button__text">
                                    Sign up with Google
                                </span>
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="google-button fb-btn btn-block mt-20" type="button" onclick="login();">
                                <span class="google-button__icon">
                                    <img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>/fb-icon.png" />
                                </span>
                                <span class="google-button__text">
                                    Sign up with Facebook
                                </span>
                            </button>
                        </div>
                    </div>
                    <div class="text-tnsfrm-upr text-center fnt-wgt-700 mt-20">or</div>
                    <div class="mt-20">
                        <div class="tab-pane" id="2a">
                            <form id="userSignup" class="lve-wre-form-prt mt-20" action="<?php echo base_url(); ?>home/userRegistration">
                                <div class="form-group mb-25 text-center">
                                    <div class="log_div log_div1 ">
                                        <img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>/user-acnt-icn.png" id="pImg">
                                        <div class="text-center upload_pic_in_album"> 
                                            <input accept="image/*" class="inputfile hideDiv" id="file-1" name="profileImage" onchange="document.getElementById('pImg').src = window.URL.createObjectURL(this.files[0])" style="display: none;" type="file">
                                            <label for="file-1" class="upload_pic"><span class="fa fa-camera"></span></label>
                                        </div>
                                        <div id="profileImage-err"> </div>
                                    </div>
                                </div>
                                <div class="form-group mb-25">
                                    <label>First name</label>
                                    <input type="text" class="form-control" name="First_name" placeholder="First name" />
                                </div>

                                <div class="form-group mb-25">
                                    <label>Last name</label>
                                    <input type="text" class="form-control" name="Last_name" placeholder="Last name" />
                                </div>
                                <div class="form-group mb-25">
                                    <label>Email Id</label>
                                    <input type="email" class="form-control" name="email" placeholder="Email" />
                                </div>

                                <div class="form-group mb-25">
                                    <label>Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                                </div>

                                <div class="form-group mb-25">
                                    <label>Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" />
                                </div>

                                <div class="form-group mb-25">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address1" id="address1" placeholder="Address" />
                                </div>

                                <div class="form-group mb-25">
                                    <label>Country</label>
                                    <input type="text" class="form-control" name="countryt" id="countryt" placeholder="Address" />
                                </div>

                                <div class="form-group mb-25">
                                    <label>Gender</label><br>
                                    <input  type="radio" name="gender1" value="1" checked="checked" > Male<br>
                                    <input  type="radio" name="gender1" value="0"> Female<br>
                                </div>
                                

                                <button type="button" class="btn-form btn-block btn-primary-form mt-5 clr-grn signup">Sign Up</button>
                            </form>
                            <div class="text-center mt-25">
                                <span class="mr-2 para">Already have an account?</span>
                                <a href="<?php echo base_url(); ?>home/login" class="btn-link2">Login</a>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>