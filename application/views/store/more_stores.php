<?php
    if (sizeof($stores) > 0) {
        $flag = 1;
        foreach ($stores as $st) {
            if (!empty($between_banners)) {
                if ($flag == 4) {
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                        <div class="ad-banner1">
                <?php $this->load->view('home/between_banner_view'); ?>
                        </div>
                    </div>
                    <?php
                }
                $flag++;
            }

            $store_cover_img = '';
            $store_start = thumb_start_grid_store_cover . HTTPS . website_url;
            $store_end = thumb_end_grid_store_cover;

            if ($st['store_cover_image'] != '')
                $store_cover_img = $store_start . store_cover . "original/" . $st['store_cover_image'] . $store_end;
            else
                $store_cover_img = $store_start.HTTPS . website_url . 'assets/upload/store_cover_image.png'. $store_end;

            $profile_picture = '';

            $profile_start = thumb_start_grid . HTTPS . website_url;
            $profile_end = thumb_end_grid_userprofile;

            $profile_picture = $this->dbcommon->load_picture($st['profile_picture'], $st['facebook_id'], $st['twitter_id'], $st['username'], $st['google_id']);
            
           
            $store_link = HTTP . $st['store_domain'] . after_subdomain . remove_home;   
           
            ?>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
                <div class="store-block">
                    <div class="store-banner" style="background-image:url(<?php echo $store_cover_img; ?>);"></div>
                    <div class="store-iiner">
                        <div class="store-tbl">
                            <div class="tbl-cell"><a href="<?php echo $store_link; ?>" class="str-btn"><i class="fa fa-eye"></i> Store</a></div>
                            <div class="tbl-cell"><div class="store-avtar"><img src="<?php echo $profile_picture; ?>" alt="Image" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" /></div></div>
                            <?php
                            $btn_name = '<i class="fa fa-plus"></i> Follow';

                            if (isset($login_userid) && $login_userid != '') {
                                $count_array = array('user_id' => $login_userid,
                                    'seller_id' => $st['user_id']);

                                $is_following = $this->dbcommon->get_count('followed_seller', $count_array);
                            } else
                                $is_following = 0;

                            if ($is_following > 0)
                                $btn_name = 'Following';

                            if (isset($login_userid)) {
                                if ($login_userid != $st['user_id']) {
                                    if ($btn_name == 'Following') {
                                        ?>                             
                                        <div class="tbl-cell"><a href="<?php echo base_url(); ?>allstores/unfollow/<?php echo $st['user_id']; ?>" class="str-btn following1" id="following<?php echo $st['user_id']; ?>"><?php echo $btn_name; ?></a></div>
                                        <?php
                                    } else {
                                        if (isset($current_user) && (sizeof($current_user) == 0) || (isset($current_user) && sizeof($current_user) > 0 && $current_user != '' && $current_user['user_id'] != $st['user_id'])) {
                                            ?>
                                            <div class="tbl-cell"><a href="<?php echo base_url(); ?>allstores/addfollow/<?php echo $st['user_id']; ?>" class="str-btn" ><?php echo $btn_name; ?></a></div>
                                            <?php
                                        }
                                    }
                                }
                            } else {
                                ?>
                                <div class="tbl-cell"><a href="<?php echo base_url(); ?>login/index" class="str-btn" ><?php echo $btn_name; ?></a></div>
        <?php } ?>


                        </div>
                        <div class="store-name"><h3><?php echo $st['store_name']; ?></h3></div>
                    </div>
                </div>
            </div>
    <?php }
} ?>