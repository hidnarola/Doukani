<?php if ($this->session->flashdata('msg1')): ?>
    <div class='alert  alert-info'>
        <a class='close' data-dismiss='alert' href='#'>&times;</a>
        <?php echo $this->session->flashdata('msg1'); ?>
    </div>
<?php endif; ?>
<div class="user_profile_main">
    <div class="user_profile_mainTop">
        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->user_id; ?>">
        <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $user->user_id; ?>">
        <div class="user_pro_pic">
            <?php
            $profile_picture = '';
            $profile_picture = $this->dbcommon->load_picture($user->profile_picture, $user->facebook_id, $user->twitter_id, $user->username, $user->google_id, 'original', 'seller-page');
            ?>  	
            <img src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" alt="Profile Image">

            <?php if ($get_myfollowers > 0 && $is_logged == 1) { ?>
                <div class="badge_top" data-toggle="tooltip" data-placement="top" data-original-title="You are following">
                    <img src="<?php echo base_url(); ?>assets/front/images/check.png" alt="Check Mark" />
                </div>
            <?php } ?>
        </div>        
        <h3><?php if ($user->nick_name != ''): echo $user->nick_name;
        else: echo $user->username;
        endif; ?></h3>
    </div>
    <div class="right_follow_side">						  
        <ul class="user_followers_main">
            <?php
            $btn_name = 'Follow';
            if ($is_following > 0)
                $btn_name = 'Following';

            if (isset($login_userid)) {
                if ($login_userid != $user->user_id) {
                    if ($btn_name == 'Following') {
                        ?>
                        <li class="user-following">
                            <a href="<?php echo base_url(); ?>seller/unfollow/<?php echo $user->user_id; ?>" class="btn btn-block mybtn " id="following" ><?php echo $btn_name; ?></a>
                        </li>
                    <?php
                    } else {
                        if (isset($current_user) && (sizeof($current_user) == 0) || (isset($current_user) && sizeof($current_user) > 0 && $current_user != '' && $current_user['user_id'] != $user->user_id)) {
                            ?>
                            <li class="user-following">
                                <a href="<?php echo base_url(); ?>seller/addfollow/<?php echo $user->user_id; ?>" class="btn btn-block mybtn "><?php echo $btn_name; ?>
                                </a>
                            </li>
                        <?php
                        }
                    }
                }
            } else {
                ?>
                <li class="user-following"><a href="<?php echo base_url(); ?>login/index" class="btn btn-block mybtn "><?php echo $btn_name; ?></a></li>
<?php } ?>
            <li class="user-Listing">
                <a href="<?php echo base_url().emirate_slug; ?><?php echo $user->user_slug; ?>" style="<?php echo (isset($current_page1)) ? 'background: #a0a0a0;':''; ?>">Listings
                </a>
            </li>            
            <li class="user-followers">
                <a href="<?php echo base_url(); ?><?php echo $user->user_slug . '/followers'; ?>" style="<?php echo (isset($current_page2)) ? 'background: #a0a0a0;':''; ?>"><?php echo $followers; ?> Followers 
                </a>
            </li>
            <?php if (isset($login_userid) || $login_userid != $user->user_id) { ?>            
                    <li class="user-contact"><button class="btn btn-block mybtn" id="contact_number"><i></i><span> Contact</span></button></li> 
                <?php
} ?>
        </ul>
    </div>
</div>  
<div id="send_inquiry" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <form accept-charset="utf-8" name="formReportAds" method="post" id="formReportAds" class="form-horizontal validate-form" action="<?php echo site_url() . 'home/send_msg_seller'; ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Contact to seller</h4>
                </div>
                <?php 
                    if (isset($current_user) && (sizeof($current_user) == 0) || (isset($current_user) && sizeof($current_user) > 0 && $current_user != '' && $current_user['user_id'] != $user->user_id)) {
                ?>
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
                            <input type="text" value="<?php echo $seller_name; ?>" placeholder="" name="seller_name" id="seller_name" class="form-control" readonly>
                            <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $seller_id; ?>" >
                            <input type="hidden" name="request_from" id="request_from" value="<?php echo $request_from; ?>" >
                            <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo current_url(); ?>" >
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <div class="col-xs-3 text-center">
                            <label class="control-label">Email </label>
                        </div>
                        <div class="col-xs-9">
                            <?php echo $seller_emailid; ?>
                            <input type="hidden" value="<?php echo $seller_emailid; ?>" placeholder="" name="seller_email" id="seller_email" class="form-control" readonly>
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
                <?php } elseif(!isset($current_user)) {?>
                <div class="modal-body">
                    <h5>You need to be logged in to contact with Seller.</h5>
                </div>
                <div class="modal-footer">
                    <a href="login/index" class="btn btn-success btn-md">Log In</a>
                </div>
                <?php } ?>
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
                    <a href="<?php echo base_url(); ?>login" class="btn btn-success btn-md">Log In</a>
                </div>
            </div>
        </div>
    </div>
</div>  
<script>
    $('#see_number').click(function () {
        $(this).find('.show_number').text('<?php echo $contact_no; ?>');
    });

    $("#following").mouseenter(function () {
        $('#following').text('Un-follow');
    });

    $("#following").mouseout(function () {
        $('#following').text('Following');
    });

    $(document).on("click", "#contact_number", function (e) {
<?php if ($is_logged == 0) { ?>
            $("#ifLoginModal").modal('show');
<?php } else { ?>
            $("#send_inquiry").modal('show');
<?php } ?>
    });
</script>