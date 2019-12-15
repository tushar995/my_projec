<?php      
    $frontend_asset = base_url();
 ?>
<div id="copyright-container">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p>© <?php echo date('Y'); ?> LIVE WIRE. All rights reserved.</p>
            </div>
            <div class="col-md-6">
                <ul class="breadcrumb">
                    <!-- <li><a href="">Home</a></li>  -->          
                    <li><a href="<?php echo base_url(); ?>home/about_us" target="_blank">About Us</a></li>
                    <li><a href="<?php echo base_url(); ?>home/terms" target="_blank">Terms & conditions</a></li>
                    <li><a href="<?php echo base_url(); ?>home/privacy" target="_blank">Privacy policy</a></li>
                    <li><a href="<?php echo base_url(); ?>home/disclaimer" target="_blank">Disclaimer</a></li>
                    <!-- <li><a href="javascript:void(0)">Services</a></li>
                    <li><a href="javascript:void(0)">Download App</a></li> -->
                    <li><a href="#">Contact us</a></li>
                </ul>
            </div>
        </div>
    </div>
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
                        <form class="lve-wre-form-prt mt-20" id="socialForm" method="post" enctype="multipart/form-data"  action="<?php echo base_url(); ?>auth/socialRegistration" >

                            <div class="form-group mb-25 text-center">

                                <div class="log_div log_div1 ">
                                    <img src="<?php echo $frontend_asset.LV_ASSETS_IMG;?>user-acnt-icn.png" id="socialclientImg"> 
                                </div>

                            </div>

                            <div class="form-group mb-25">
                                <label>Full Name</label>
                                <input type="text" class="form-control" name="socialName" id="socialName" placeholder="Name" />
                            </div>

                            <div class="form-group mb-25">
                                <label>Email Address</label>
                                <input type="email" class="form-control" id="socialEmail" name="socialEmail" placeholder="Email" />
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
 
 <?php if(!empty($front_scripts)) { load_js($front_scripts);} //load required page scripts ?>
 <!-- <script src="<?php echo $frontend_asset.LV_ASSETS_JS;?>semantic.min.js"></script> -->
 <script>
    new WOW().init(); 
</script>
 <script type="text/javascript">
    var base_url = '<?php echo base_url(); ?>'
</script> 
 <script src="<?php echo $frontend_asset.LV_TOASTR;?>toastr.min.js"></script>
 <script src="<?php echo $frontend_asset.LV_CUSTOM;?>front_common.js"></script>
 <script>
     $('.tag .ui.dropdown').dropdown({
    allowAdditions: true
});
 </script>

 </body>
</html>