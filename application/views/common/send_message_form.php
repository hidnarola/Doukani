<div id="send_inquiry" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content"> 
            <?php
            if (isset($store_url) && $store_url != '')
                $mypath_ = $store_url;
            else
                $mypath_ = base_url();
            ?>        
            <form accept-charset="utf-8" name="formReportAds1" method="post" id="formReportAds1" class="form-horizontal validate-form" action="<?php echo $mypath_ . 'home/send_msg_seller'; ?>">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-close"></i></button>                  
                    <h4 class="modal-title">Contact to seller</h4>
                </div>
                <div class="modal-body">
                    <div style="display: none" id="formErrorMsgReport" class="alert alert-info"></div>
                    <div class="row">
                        <div class="col-xs-12">
                            <a class="ShowNumber btn mybtn btn-block" id="see_number">
                                <span class="fa fa-phone"></span><span class="show_number" id="show_number"> Show Number</span>
                            </a>					   
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <label>&nbsp;OR</label>                     
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <label>Send Mail</label>
                        </div>
                        <div class="col-xs-12">
                            <textarea placeholder="" name ="message" id="message" class="form-control xyz"  data-rule-required='true'></textarea>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <div class="col-xs-3 text-center">
                            <label class="control-label">Name</label>
                        </div>
                        <div class="col-xs-9">
                            <input type="hidden" value="<?php echo $seller_name; ?>" name="seller_name" id="seller_name" class="form-control" >
                            <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $seller_id; ?>" >
                            <input type="hidden" name="request_from" id="request_from" value="<?php echo $request_from; ?>" >
                            <?php
                            if (isset($store_url) && $store_url != '')
                                $mypath = $store_url . '/';
                            else
                                $mypath = base_url();

                            if (strpos($mypath, after_subdomain) !== false) {

                                $data = current_url();
                                $last_data = substr($data, strpos($data, "/") - 1);
                                $redirect_url = 'http' . $last_data;
                            } else
                                $redirect_url = $_SERVER['REQUEST_URI'];
                            ?>
                            <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo $redirect_url; ?>" >
                            <?php
                            if (isset($product_slug) && !empty($product_slug)) {
                                ?>
                                <input type="hidden" name="product_slug" id="product_slug" value="<?php echo $product_slug; ?>" >   
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <div class="col-xs-3 text-center">
                            <label class="control-label">Email </label>
                        </div>
                        <div class="col-xs-9">
                            <?php echo $seller_emailid; ?>
                            <input type="hidden" value="<?php echo $seller_emailid; ?>" name="seller_email" id="seller_email" class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-6 col-xs-12">&nbsp;</div>
                    <div class="col-sm-6 col-xs-12 popup-ftr-btn">
                        <button type="button" class="btn btn-black" data-dismiss="modal">Close</button>               
                        <button type="submit" name="send_mail" class="btn btn-success btn-md">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="ifLoginModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">To Contact</h4>
            </div>
            <div class="modal-body">
                <h5>You need to be logged in to contact.</h5>
            </div>
            <div class="modal-footer">
                <div class="col-sm-6 col-xs-12">&nbsp;</div>
                <div class="col-sm-6 col-xs-12 popup-ftr-btn">
                    <a href="<?php echo HTTPS . website_url; ?>login/index" class="btn btn-success btn-md">Log In</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("#following").mouseenter(function () {
        $('#following').text('Un-follow');
    });

    $("#following").mouseout(function () {
        $('#following').text('Following');
    });

    $('#see_number').click(function () {
        $(this).find('.show_number').text('<?php echo $contact_no; ?>');
    });

    $(document).on("click", "#send_message", function (e) {
<?php if ($is_logged == 0) { ?>
            $("#ifLoginModal").modal('show');
<?php } else { ?>
            $("#send_inquiry").modal('show');
<?php } ?>
    });

</script>