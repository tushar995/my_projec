<?php      
    $frontend_asset= base_url();
    $user_details = get_user_session_data();
 ?>

<div id="footer-wrapper">
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 centered">
                    <div class="footer-logo">
                        <a href="<?php echo base_url(); ?>
                        </a>
                    </div>
                   
                    <ul class="contact-info-list">
                        
                    </ul>
                    
                </div>
            </div>
        </div>
    </footer>
</div>


<!-- modal -->
<div id="googlemodal" class="modal google-mode fade" role="dialog">
    <div class="modal-dialog"  >
        <!-- Modal content-->
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Complete Your Profile</h4>
            </div><?php $frontend_asset= base_url(); ?>
            <div class="modal-body">
                <div id="exTab1" class="tab-frm mt-20 mb-20"> 
                    <div class="tab-content clearfix">
                        <form class="lve-wre-form-prt mt-20" id="socialForm" method="post" enctype="multipart/form-data"  action="<?php echo base_url(); ?>home/socialRegistration" >

                            <div class="form-group mb-25 text-center">

                                <div class="log_div log_div1 ">
                                    <img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>user-acnt-icn.png" id="socialclientImg"> 
                                </div>

                            </div>

                            <div class="form-group mb-25">
                                <label>First name</label>
                                <input type="text" class="form-control" name="socialFirstName" id="socialFirstName" placeholder="First name" />
                            </div>

                            <div class="form-group mb-25">
                                <label>Last name</label>
                                <input type="text" class="form-control" name="socialLastName" id="socialLastName" placeholder="Last name" />
                            </div>

                            <div class="form-group mb-25">
                                <label>Email Address</label>
                                <input type="email" class="form-control" id="socialEmail" name="socialEmail" placeholder="Email" />
                            </div>

                            <div class="form-group mb-25">
                                <label>Address</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Address" />
                            </div>

                            <div class="form-group mb-25">
                                <label>Country</label>
                                <input type="text" class="form-control" name="country" id="country" placeholder="Address" />
                            </div>

                            <div class="form-group mb-25">
                                <label>Gender</label><br>
                                <input  type="radio" name="gender" value="1" > Male<br>
                                <input  type="radio" name="gender" value="0"> Female<br>
                            </div>

                            

                            <input type="hidden" name="clientSocialType" id="clientSocialType">
                            <input type="hidden" name="clientSocialId" id="clientSocialId">
                            <input type="hidden" name="clientprofileImage" id="clientprofileImage">

                            <button type="button" class="btn-form btn-block  btn-primary-form mt-5 socialReg" >Proceed</button>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    .usr-slct .error{
        display: block;
        text-align: center;
    }
</style>

 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>bootstrap.min.js"></script>
 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>bootstrap-select.min.js"></script>
 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>jquery.nivo.slider.pack.js"></script>
 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>owl.carousel.min.js"></script>
 <!-- <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>owl.carousel.js"></script> -->
 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>moment.min.js"></script>
 <!-- <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>owl.navigation.js"></script> -->
 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>bootstrap-datetimepicker.js"></script>
 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>form-wizard.js"></script>
 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>custom.js"></script>
 <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script> 
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
 <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>wow.js"></script>
 <script>
    new WOW().init(); 
</script>
 <?php 
 if(!empty($front_scripts)) { load_js($front_scripts);} //load required page scripts 
 ?>
 
<div id="tl_front_loader" class="tl_loader" style="display: none;"></div> <!-- Loader -->
<script src="<?php echo $frontend_asset.LV_TOASTR;?>toastr.min.js"></script>
<script src="<?php echo $frontend_asset.LV_CUSTOM;?>front_common.js"></script>
 
</script>
</body>
</html>