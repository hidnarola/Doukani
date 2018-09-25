<div class='row'>
    <div class='col-sm-12 col-md-12 box'>
        <div class='box-header blue-background col-md-11'>
            <div class='title'>
                <i class='icon-group'></i>
                Users
            </div>
            <div class='actions'>
                <a class="btn box-collapse btn-mini btn-link" href="javascript:void(0);"><i></i>
                </a>
            </div>
        </div>

        <?php
        $classified_users = 0;
        $store_users = 0;
        $offer_users = 0;
        $super_admin_users = 0;
        $admin_users = 0;
        $delete_users = 0;
        $total_users = 0;
        $not_user_type_selected = 0;
        $hold_store_users = 0;
        $block_users = 0;
        $not_filled_store_details = 0;
        $not_agree_withtd = 0;
        $classified_block_users = 0;
        $store_block_users = 0;
        $offer_block_users = 0;
        $classified_not_agree_users = 0;
        $store_not_agree_users = 0;
        $offer_not_agree_users = 0;
        $total_iphone_users = 0;
        $total_android_users = 0;
        $total_website_users = 0;
        
        $classified_website_users = 0;
        $store_website_users = 0;
        $offer_website_users = 0;
        $website_users_no_type = 0;
        
        $classified_iphone_users = 0;
        $store_iphone_users = 0;
        $offer_iphone_users = 0;
        $iphone_users_no_type = 0;
        
        $classified_android_users = 0;
        $store_android_users = 0;
        $offer_android_users = 0;
        $android_users_no_type = 0;

        foreach ($users as $u) {
            $total_users = $u['total_users'];
            $super_admin_users = $u['super_admin_users'];
            $admin_users = $u['admin_users'];
            $classified_users = $u['classified_users'];
            $store_users = $u['store_users'];
            $offer_users = $u['offer_users'];
            $not_user_type_selected = $u['not_user_type_selected'];
            $delete_users = $u['delete_users'];
            $hold_store_users = $u['hold_store_users'];
            $block_users = $u['block_users'];
            $not_filled_store_details = $u['not_filled_store_details'];
            $not_agree_withtd = $u['not_agree_withtd'];

            $classified_block_users = $u['classified_block_users'];
            $store_block_users = $u['store_block_users'];
            $offer_block_users = $u['offer_block_users'];

            $classified_not_agree_users = $u['classified_not_agree_users'];
            $store_not_agree_users = $u['store_not_agree_users'];
            $offer_not_agree_users = $u['offer_not_agree_users'];
            $total_iphone_users = $u['total_iphone_users'];
            $total_android_users = $u['total_android_users'];
            $total_website_users = $u['total_website_users'];
            
            $delete_iphone_users = $u['delete_iphone_users'];
            $delete_android_users = $u['delete_android_users'];
            $delete_website_users = $u['delete_website_users'];
            
            $classified_website_users = $u['classified_website_users'];
            $store_website_users = $u['store_website_users'];
            $offer_website_users = $u['offer_website_users'];
            $website_users_no_type = $u['website_users_no_type'];

            $classified_iphone_users = $u['classified_iphone_users'];
            $store_iphone_users = $u['store_iphone_users'];
            $offer_iphone_users = $u['offer_iphone_users'];
            $iphone_users_no_type = $u['iphone_users_no_type'];

            $classified_android_users = $u['classified_android_users'];
            $store_android_users = $u['store_android_users'];
            $offer_android_users = $u['offer_android_users'];
            $android_users_no_type = $u['android_users_no_type'];
        }
        ?>
        <div class="col-md-11 box-content admin-dashboard-box">
            <?php
                    $users_total_text = 'Super Admin : ' . $super_admin_users .
                            '<hr class="hr_listing"><a id="" href="javascript:void(0);">Admin : ' . $admin_users . '<hr class="hr_listing">'
                            . 'Classified Users : ' . $classified_users . '<hr class="hr_listing">'
                            . 'Store Users : ' . $store_users . '<hr class="hr_listing">'
                            . 'Offer Users : ' . $offer_users . '<hr class="hr_listing">'
                            . 'No User Type : ' . $not_user_type_selected . '<hr class="hr_listing">'
                            . 'Deleted Users : ' . $delete_users . '<hr class="hr_listing">'
                            . 'Not Filled Store Details : ' . $not_filled_store_details . '<hr class="hr_listing">';
                    ?>
            
            <div class="col-sm-3">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' >
                    <a href="javascript:void(0);" title='Total Users' data-toggle="popover" data-placement="bottom" data-html="true" data-content='<?php echo $users_total_text; ?>'>
                    <h3 class='title text-success'>
                        <?php echo $total_users; ?>
                    </h3>
                    <small>Total</small>
                    <div class='text-success icon-group align-right'></div>                    
                    </a>
                </div>                
            </div>
            <div class="col-sm-3">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Active Super Admin'>
                    <h3 class='title text-info'><?php echo $super_admin_users; ?></h3>
                    <small>Super Admin</small>
                    <div class='text-info icon-user align-right'></div>
                </div>
            </div>
            <div class="col-sm-3">
                <a href="<?php echo site_url() . 'admin/systems/accounts'; ?>">
                    <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Active Admin'>
                        <h3 class='title text-info'><?php echo $admin_users; ?></h3>
                        <small>Admin</small>
                        <div class='text-info icon-user align-right'></div>
                    </div>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="<?php echo site_url() . 'admin/users/index/generalUser'; ?>">
                    <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Active Classified Users'>
                        <h3 class='title text-info'><?php echo $classified_users; ?></h3>
                        <small>Classified Users</small>
                        <div class='text-info icon-user align-right'></div>
                    </div>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="<?php echo site_url() . 'admin/users/index/storeUser'; ?>">
                    <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Active as Store Users'>
                        <h3 class='title text-info'><?php echo $store_users; ?></h3>
                        <small>Store Users</small>
                        <div class='text-info icon-user align-right'></div>
                    </div>
                </a>
            </div> 
            <div class="col-sm-3">
                <a href="<?php echo site_url() . 'admin/users/index/offerUser'; ?>">
                    <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Active as Offer Users'>
                        <h3 class='title text-info'><?php echo $offer_users; ?></h3>
                        <small>Offer Users</small>
                        <div class='text-info icon-user align-right'></div>
                    </div>
                </a>    
            </div>
            <div class="col-sm-3">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='User Type Not Selected'>
                    <h3 class='title text-info'><?php echo $not_user_type_selected; ?></h3>
                    <small>User Type Not Selected</small>
                    <div class='text-info icon-user align-right'></div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Deleted User (including all type of Users)'>
                    <h3 class='title text-info'><?php echo $delete_users; ?></h3>
                    <small>Deleted Users</small>
                    <div class='text-info icon-user align-right'></div>
                </div>
            </div>
            <div class="col-sm-3">
                <a href="<?php echo site_url();?>admin/users/index/storeUser?store_is_inappropriate=Approve&store_status=3&filter=all&con=0&st=0&dt=&submit=">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Approved Hold Store'>
                    <h3 class='title text-info'><?php echo $hold_store_users; ?></h3>
                    <small>Hold Store Users</small>
                    <div class='text-info icon-user align-right'></div>
                </div>
                </a>
            </div>
            <div class="col-sm-3"> 
                <?php
$block_user_display = '<a id="classified_block_user" href="' . site_url() . 'admin/users/index/generalUser?filter=blo&con=0&dt=&per_page=10">Classified : ' . $classified_block_users .
        '</a><hr class="hr_listing"><a id="store_block_user" href="' . site_url() . 'admin/users/index/storeUser?filter=blo&con=0&dt=&per_page=10">Store : ' . $store_block_users .
        '</a><hr class="hr_listing"><a id="offer_block_user" href="' . site_url() . 'admin/users/index/offerUser?filter=blo&con=0&dt=&per_page=10">Offer : ' . $offer_block_users . '</a>';
?>
                <a href="javascript:void(0);" title="Blocked Users" data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $block_user_display; ?>' >
                <div class='box-content box-statistic admin-dashboard-box has-tooltip'>

                    <h3 class='title text-info'><?php echo $block_users; ?></h3>
                    <small>Block Users</small>
                    <div class='text-info icon-user align-right'></div>
                </div>
                </a>
            </div>
            <div class="col-sm-3">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Store User not filled create store form'>
                    <h3 class='title text-info'><?php echo $not_filled_store_details; ?></h3>
                    <small>Not Filled Store Details</small>
                    <div class='text-info icon-user align-right'></div>
                </div>
            </div>
            <div class="col-sm-3">
<?php
$not_agree_text = '<a href="' . site_url() . 'admin/users/index/generalUser?filter=not_agree&con=0&st=&dt=&submit=">Classified : ' . $classified_not_agree_users .
        '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/users/index/storeUser?filter=not_agree&con=0&st=&dt=&submit=">Store : ' . $store_not_agree_users .
        '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/users/index/offerUser?filter=not_agree&con=0&st=&dt=&submit=">Offer : ' . $offer_not_agree_users . '</a>';
?>
                <a href="javascript:void(0);" title='Not Agree With T & C' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $not_agree_text; ?>' >
                <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                    <h3 class='title text-info'>
                        <?php echo $not_agree_withtd; ?>
                    </h3>
                    <small>Not Agree with Terms & Conditions</small>
                    <div class='text-info icon-user align-right'></div>
                </div>
                </a>
            </div>            
            <div class="col-sm-3">
                <?php
$website_text = '<a href="' . site_url() . 'admin/users/index/generalUser?per_page=10&filter=all&con=0&st=&dt=&device_type=null&submit=">Classified : ' . $classified_website_users .
        '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/users/index/storeUser?per_page=10&filter=all&con=0&st=&dt=&device_type=null&submit=">Store : ' . $store_website_users .
        '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/users/index/offerUser?per_page=10&filter=all&con=0&st=&dt=&device_type=null&submit=">Offer : ' . $offer_website_users . '</a><hr class="hr_listing">Deleted : '.$delete_website_users;
?>
                <a href="javascript:void(0);" title='Web Users' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $website_text; ?>' >
                <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                    <h3 class='title text-info'>
                        <?php echo $total_website_users; ?>
                    </h3>
                    <small>Website Users</small>
                    <div class='text-info icon-desktop align-right'></div>
                </div>
                </a>
            </div>
            <div class="col-sm-3">  
                <?php
$iphone_text = '<a href="' . site_url() . 'admin/users/index/generalUser?per_page=10&filter=all&con=0&st=0&dt=&device_type=1&submit=">Classified : ' . $classified_iphone_users .
        '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/users/index/storeUser?per_page=10&filter=all&con=0&st=0&dt=&device_type=1&submit=">Store : ' . $store_iphone_users .
        '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/users/index/offerUser?per_page=10&filter=all&con=0&st=0&dt=&device_type=1&submit=">Offer : ' .  $offer_iphone_users . '</a><hr class="hr_listing">Deleted : '.$delete_iphone_users;
?>
                <a href="javascript:void(0);" title='Iphone Users' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $iphone_text; ?>' >
                <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                    <h3 class='title text-info'>
                        <?php echo $total_iphone_users; ?>
                    </h3>
                    <small>Iphone Users</small>
                    <div class='text-info icon-apple align-right'></div>
                </div>  
                </a>
            </div>
            <div class="col-sm-3"> 
                <?php
$android_text = '<a href="' . site_url() . 'admin/users/index/generalUser?per_page=10&filter=all&con=0&st=0&dt=&device_type=0&submit=">Classified : ' . $classified_android_users .
        '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/users/index/storeUser?per_page=10&filter=all&con=0&st=0&dt=&device_type=0&submit=">Store : ' . $store_android_users .
        '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/users/index/offerUser?per_page=10&filter=all&con=0&st=0&dt=&device_type=0&submit=">Offer : ' . $offer_android_users . '</a><hr class="hr_listing">Deleted : '.$delete_android_users;
?>
                <a href="javascript:void(0);" title='Android Users' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $android_text; ?>' >
                <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                    <h3 class='title text-info'>
                        <?php echo $total_android_users; ?>
                    </h3>
                    <small>Android Users</small>
                    <div class='text-info icon-android align-right'></div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
