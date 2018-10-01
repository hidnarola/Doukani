<?php if(isset($store_main_page) && $store_main_page == 'yes') { ?>
<div class="store-top-section">
    <div class="store-individual-slider">               
        <?php
        $store_cover_image = '';

        if ($store[0]->store_cover_image != '')
            $store_cover_image = HTTPS . website_url . store_cover . "medium/" . $store[0]->store_cover_image;
        else
            $store_cover_image = HTTPS . website_url . 'assets/upload/store_cover_image.png';

//        if (isset($request_from) && $request_from == 'store_page') {
//            $store_cv_img = thumb_start_grid_store_cover_big . $store_cover_image . thumb_end_grid_store_cover_big;
//            $default_store_image = thumb_start_grid_store_cover_big . HTTP . website_url . 'assets/upload/store_cover_image.png' . thumb_end_grid_store_cover_big;
//        } else {
//            $store_cv_img = thumb_start_store_cover . $store_cover_image . thumb_end_store_cover;
//            $default_store_image = thumb_start_store_cover . HTTP . website_url . 'assets/upload/store_cover_image.png' . thumb_end_store_cover;
//        }
        
        if (isset($request_from) && $request_from == 'store_page') {
            $store_cv_img = $store_cover_image;
            $default_store_image = HTTPS . website_url . 'assets/upload/store_cover_image.png';
        } else {
            $store_cv_img = $store_cover_image;
            $default_store_image = HTTPS . website_url . 'assets/upload/store_cover_image.png';
        }
        
        ?>
        <img src="<?php echo $store_cv_img; ?>" alt="Cover Image" onerror="this.src='<?php echo $default_store_image; ?>'"/>
    </div>
    <div class="store-individual-user">
        <div class="store-individual-user-left">
            <div class="store-individual-user-pic">
                <?php
                $store_userprofile_picture = '';

                $store_userprofile_picture = $this->dbcommon->load_picture($store_user[0]->profile_picture, $store_user[0]->facebook_id, $store_user[0]->twitter_id, $store_user[0]->username, $store_user[0]->google_id, 'original', 'store-common');
                ?>
                <span><a href="<?php echo HTTP . $store[0]->store_domain . after_subdomain . remove_home; ?>"><img src="<?php echo $store_userprofile_picture; ?>" alt="Profile Image" onerror="this.src='<?php echo HTTP . website_url; ?>assets/upload/avtar.png'" /></a></span>
                <?php if (isset($get_myfollowers) && $get_myfollowers > 0 && $is_logged == 1) { ?>
                <div class="badge_top"  data-toggle="tooltip" data-placement="top" data-original-title="You are following">
                    <img src="<?php echo HTTPS . website_url; ?>assets/front/images/check.png" alt="Image" />
                </div>
                <?php } ?>
            </div>
            <div class="store-individual-user-social">
                <div class="store-individual-user-social-toggle"><i class="fa fa-navicon"></i><p>Links</p></div>
                <ul>
                    <li> <span>Posts</span> <i class="big"> <?php
                        if (!empty($count_no_of_post))
                            echo '[ <i class="small">' . $count_no_of_post . ' </i>]';
                        else
                            echo '[ <i class="small">0</i> ]';
                        ?> </i></li>
                <li> <a href="<?php echo HTTP . $store[0]->store_domain . after_subdomain .'/followers'; ?>" style="text-decoration:none;"> <span style="color:#3c393a;">Followers</span><i class="big"> <?php
                        if (!empty($store_user[0]->followers_count) && (int) $store_user[0]->followers_count > 0)
                            echo '[ <i class="small">' . $store_user[0]->followers_count . ' </i>]';
                        else
                            echo '[ <i class="small">0</i> ]';
                        ?></i></a></li>

                    <?php if (isset($store[0]->store_is_inappropriate) && $store[0]->store_is_inappropriate == 'Approve' && isset($request_from) && $request_from == 'store_page') { ?>
                        <li class="share_frd">
                            <span class="social_label ">Share with friends </span>
                            <span class='st_facebook_large '></span>
                            <span class='st_twitter_large disabled'></span>
                            <span class='st_googleplus_large disabled' ></span>  
                        </li>
                        <li class="map-link">
                            <span>
                                <a href="javascript:void(0);" id="store_on_google" target="_blank"><i class="fa fa-map-marker" aria-hidden="true"></i></a>
                            </span>
                        </li>
                    <?php } ?>

                </ul>

            </div>            
        </div>
        <div class="store-individual-user-right">
            <div class="store-individual-user-right-toggle">
                <p>More Link</p>
                <i class="fa fa-navicon"></i> 
            </div>
            <ul>
                <?php if (isset($request_from) && $request_from == 'store_page') { ?>
                    <?php if (!empty($store_user[0]->instagram_social_link) || !empty($store_user[0]->facebook_social_link) || !empty($store_user[0]->twitter_social_link)) { ?>
                        <li class="col-sm-13 visit_my_store store-about">
                            <a>Social Links</a>
                            <?php if (!empty($store_user[0]->instagram_social_link)) { ?><a href="<?php echo $store_user[0]->instagram_social_link; ?>"><span class='instagram_icon'></span></a><?php } ?> 

                            <?php if (!empty($store_user[0]->facebook_social_link)) { ?><a href="<?php echo $store_user[0]->facebook_social_link; ?>"><span class='facebook_icon' ></span></a><?php } ?>

                            <?php if (!empty($store_user[0]->twitter_social_link)) { ?><a href="<?php echo $store_user[0]->twitter_social_link; ?>"><span class='twitter_icon'></span></a><?php } ?>
                        </li>
                        <?php
                    }
                }
                ?>

                <li class="store-about">
                    <a href="javascript:void(0);" id="about_us">About Us</a>
                </li>
                <?php
                $btn_name = '<i class="fa fa-plus"></i> Follow';
                if ($is_following > 0)
                    $btn_name = 'Following';
                
                if (isset($login_username)) {
                    if ($login_username != $store_user[0]->username) {
                        if ($btn_name == 'Following') {
                            ?>
                            <li class="store-follow-btn"><a href="<?php echo HTTP . website_url; ?>seller/unfollow/<?php echo $store_user[0]->user_id . '/store'; ?>"  id="following"><?php echo $btn_name; ?></a></li>
                            <?php
                        } else {
                            if (isset($currentusr) && (sizeof($currentusr) == 0) || (isset($currentusr) && sizeof($currentusr) > 0 && $currentusr != '' && $currentusr['user_id'] != $store_user[0]->user_id)) {
                                ?>
                                <li class="store-follow-btn"><a href="<?php echo HTTP . website_url; ?>seller/addfollow/<?php echo $store_user[0]->user_id . '/store'; ?>" ><?php echo $btn_name; ?></a></li>
                                <?php
                            }
                        }
                    }
                } else {
                    ?>
                    <li class="store-follow-btn"><a href="<?php echo HTTPS . website_url . 'login/index'; ?>" ><?php echo $btn_name; ?></a></li>
                <?php } ?>
                <li class="store-user-more-link">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-circle"></i> <i class="fa fa-circle"></i> <i class="fa fa-circle"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if ($store_user[0]->user_id != $loggedin_user) { ?>
                            <li> <a href="javascript:void(0);" id="send_message">Send Message</a></li>
                        <?php } ?>
                        <?php if ($store_user[0]->user_id == $loggedin_user) { ?>
                            <li> <a href="<?php echo HTTP . website_url . 'user/store/'; ?>">Edit Store</a></li>
                        <?php } ?>                                          
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php } ?>
<div class="col-sm-12">
    <?php if ($this->session->userdata('send_msg') != '') { ?>
        <div class='alert  alert-info alert-dismissable'>
            <a class='close' data-dismiss='alert' href='#'>&times;</a>
            <?php echo $this->session->userdata('send_msg'); ?>
        </div>
    <?php } ?>
</div>
<?php $this->session->unset_userdata('send_msg'); ?>
