<!--Payment info modal start-->
<?php
$user_details = get_user_session_data();//get data of login users
$user_id = $user_details['userId'];
$receiver_pay_text = 'You will receive';
if($user_id == $posted_by) {
    $receiver_pay_text = 'Worker will receive';
}
?>
<div class="modal fade" id="show_payment_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content mdl-subs">
            <div class="modal-header mdl-hdr">
                <h5 class="modal-title prmte clr-green" id="exampleModalLabel">Payment Info</h5>
                <button type="button" class="close mdl-clse" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pop_sngle_prjct mdl-body"> 
                <div class="regfrm">
                    <div class="pymnt-info">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
                                <div class="sub-dte-job mt-10">  
                                <div class="paymnt-lst mt-10 pl-0">    
                                    <div class="dsply-inlne-blck brdr-btm pay-info-block">
                                        <h2 class="dsply-inlne-blck-lft title mt-0 mb-0">Total Work Hours :</h2>
                                        <p class="para dsply-inlne-blck-rgt mb-0" id="total_hours">
                                        </p>
                                    </div>
                                <div class="clearfix"></div>
                                <div class="dsply-inlne-blck brdr-btm mt-10 pay-info-block">
                                    <h2 class="dsply-inlne-blck-lft title mt-0 mb-0">Hourly Rate : </h2>
                                    <p class="para dsply-inlne-blck-rgt mb-0" id="hourly_rate">
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                                <div class="dsply-inlne-blck brdr-btm mt-10 pay-info-block">
                                    <h2 class="dsply-inlne-blck-lft title mt-0 mb-0">Platform Commission(<span id="platform_commission_percent"></span>) :</h2>
                                    <p class="para dsply-inlne-blck-rgt mb-0" id="platform_commission"></p>
                                </div>
                                <div class="clearfix"></div>
                                <div class="dsply-inlne-blck brdr-btm mt-10 pay-info-block">
                                    <h2 class="dsply-inlne-blck-lft title mt-0 mb-0"><?php echo $receiver_pay_text; ?> :</h2>
                                    <p class="para dsply-inlne-blck-rgt mb-0" id="receiver_amount"><?php  ?></p>
                                </div>
                                <div class="clearfix"></div>
                                <div class="dsply-inlne-blck mt-10 pay-info-block">
                                    <h2 class="dsply-inlne-blck-lft title mt-0 mb-0 ttl-hed">Total Amount</h2>
                                    <p class="dsply-inlne-blck-rgt title mb-0 ttl-prce" id="total_amount"></p>
                                </div>
                                </div>
                                <!-- <div class="text-center">
                                    <p class="pendng-btn clr-green  green-dshed-brdr mt-10"> 
                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                        Payment Released 
                                    </p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mdl-ftr">
                <div class="form-group text-right pay-btn">
                    <a href="javascript:void(0)" class="lve-wre-btn clr-proprty pop-btn mt-10" data-dismiss="modal" >OK</a>
                </div>
            </div>
            </div>   
        </div>
    </div>
</div>
<!--Payment info modal end-->