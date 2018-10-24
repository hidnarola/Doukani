<?php
$flag = 1;
if (!empty($product_data)) {
    foreach ($product_data as $pro) {
        if (!empty($between_banners)) {
            if ($flag == 5) {
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ad-banner1Outer">
                    <div class="ad-banner1">
                        <?php $this->load->view('home/between_banner_view'); ?>
                    </div>
                </div>
                <?php
            }
            $flag++;
        }
        ?> 
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 <?php if (isset($favorite_ads) && $favorite_ads == 'yes') { ?> prod_<?php
            echo $pro['product_id'];
        } if ((isset($home_page) && $home_page == 'yes') || (isset($latest_page) && $latest_page == 'yes'))
            echo 'home_items';
        ?>">
            <div class="item-sell <?php
            if ((isset($featured_data) && $featured_data == 'yes') || (isset($pro['featured_ad']) && $pro['featured_ad'] > 0)) {
                echo 'featured-sell';
            }
            ?> <?php
            if (isset($my_listing) && $my_listing == 'yes' && $pro['product_is_sold'] != 1) {
                echo 'edit-div';
            } echo 'item-sell' . $pro['product_id'];
            ?> " >
                <div class="item-img-outer">
                    <?php
                    if (isset($pro['product_for']) && $pro['product_for'] == 'store' && isset($pro['store_domain']) && !empty($pro['store_domain']))
                        $product_path = HTTP . $pro['store_domain'] . after_subdomain . '/' . $pro['product_slug'];
                    elseif ((isset($my_listing) && $my_listing == 'yes') || (isset($my_deactivateads) && $my_deactivateads = 'yes'))
                        $product_path = base_url() . 'user/item_details/' . $pro['product_id'];
                    else
                        $product_path = base_url() . $pro['product_slug'];
                    ?>
                    <?php
                    if ((isset($featured_data) && $featured_data == 'yes') || (isset($pro['featured_ad']) && $pro['featured_ad'] > 0)) {
                        if (isset($latest_page) && $latest_page == 'yes') {
                            
                        } else {
                            ?>
                            <div class="ribbon_main">
                                <div class="red_ribbon"></div> <?php
                            }
                        }
                        ?>
                        <div class="item-img">
                            <?php if ($pro['product_is_sold'] == 1) { ?>
                                <div class="sold"><span>SOLD</span></div>
                            <?php } ?>
                            <?php if (!empty($pro['product_image'])) { ?>
                                <a href="<?php echo $product_path; ?>"><img src="<?php echo thumb_start_grid . base_url() . product . "medium/" . $pro['product_image'] . thumb_end_grid; ?>" class="img-responsive" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" alt="<?php echo $pro['product_name']; ?>" /></a>
                            <?php } else { ?>                                           
                                <a href="<?php echo $product_path; ?>"><img src="<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>" class="img-responsive" alt="<?php echo $pro['product_name']; ?>" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" /></a>
                            <?php } ?>
                        </div>
                        <?php
                        if ((isset($featured_data) && $featured_data == 'yes') || (isset($pro['featured_ad']) && $pro['featured_ad'] > 0)) {
                            if (isset($latest_page) && $latest_page == 'yes') {
                                
                            } else {
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="function-icon">
                        <?php
                        if ($loggedin_user != $pro['product_posted_by']) {
                            if ($pro['product_is_sold'] != 1) {
                                if ($is_logged != 0) {
                                    $favi = (int) $pro['my_favorite'];
                                    if (@$pro['product_total_favorite'] != 0 && $favi == 1) {
                                        ?>
                                        <div class="star fav" ><a href="javascript:void(0);" id="<?php echo $pro['product_id']; ?>">
                                                <i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
                                            </a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="star" ><a href="javascript:void(0);">
                                                <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="star" ><a href="<?php echo base_url() . 'login/index'; ?>">
                                            <i class="fa fa-star-o"></i>
                                        </a>
                                    </div>
                                    <?php
                                }
                                if (!isset($favorite_ads)) {
                                    if ($is_logged != 0) {
                                        $like = (int) $pro['my_like'];
                                        if (@$pro['product_total_likes'] != 0 && $like == 1) {
                                            ?>
                                            <div class="newthumb thu"><a href="javascript:void(0);" id="<?php echo $pro['product_id']; ?>">
                                                    <i class="fa fa-thumbs-up" id="<?php echo $pro['product_id']; ?>"></i>
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <div class="newthumb" ><a href="javascript:void(0);">
                                                    <i class="fa fa-thumbs-o-up" id="<?php echo $pro['product_id']; ?>"></i>
                                                </a>
                                            </div>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="newthumb" ><a href="<?php echo base_url() . 'login/index'; ?>">
                                                <i class="fa fa-thumbs-o-up"></i>
                                            </a>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>                                                          
                    </div>
                </div>
                <div class="item-disc">
                    <a style="text-decoration: none;" href="<?php echo $product_path; ?>">
                        <?php $len = strlen($pro['product_name']); ?>	
                        <h4 <?php
                        if ($len > 21) {
                            echo 'title="' . htmlentities($pro['product_name']) . '"';
                        }
                        ?> >
                                <?php echo $pro['product_name']; ?>
                        </h4>
                    </a>
                    <?php
                    $str = str_replace('\n', " ", $pro['catagory_name']);
                    $len = strlen($str);
                    ?>
                    <small <?php
                    if ($len > 28) {
                        echo 'title="' . htmlentities($str) . '"';
                    }
                    ?>>
                            <?php echo $str; ?>
                    </small>

                    <?php if (isset($my_listing) && $my_listing == 'yes') { ?>
                        <?php if ($pro['product_is_sold'] != 1) { ?>
                            <div class="edit_option"><i class="fa fa-pencil-square-o"></i>
                                <div class="tip">
                                    <i class="fa fa-caret-right"></i>
                                    <ul class="options_list">  
                                        <?php if (!isset($_REQUEST['val']) || $_REQUEST['val'] == 'Approve' || $_REQUEST['val'] == 'NeedReview'): ?>
                                            <li id="edit<?php echo $pro['product_id']; ?>"><a href="<?php echo site_url() . 'user/listings_edit/' . $pro['product_id']; ?>"><i><img src="<?php echo site_url(); ?>assets/front/images/edit.png" alt="Image" ></i>Edit</a></li>
                                        <?php endif; ?>

                                        <?php
                                        if (!isset($_REQUEST['val']) || $_REQUEST['val'] == 'Approve') {
                                            if (!isset($current_user['last_login_as']) || (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'generalUser')) {
                                                ?>
                                                <li id="mynew1<?php echo $pro['product_id']; ?>" class="mark_sold">
                                                    <a href="<?php echo site_url() ?>user/mark_sold/<?php echo $pro['product_id']; ?>" ><i><img src="<?php echo site_url(); ?>assets/front/images/sold.png" alt="Image" ></i>Mark Sold</a>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>												
                                        <li id="mynew1<?php echo $pro['product_id']; ?>"><a href="javascript:void(0);" class="<?php echo $pro['product_id']; ?>" id="delet_user_ad" ><i><img src="<?php echo site_url(); ?>assets/front/images/delete.png" alt="Image" ></i>Delete</a></li>


                                        <?php if ((!isset($_REQUEST['val']) || $_REQUEST['val'] == 'Approve') && isset($pro['product_for']) && $pro['product_for'] == 'classified' && empty($pro['featured_ad'])) { ?>
                                            <li><a href="javascript:void(0);" id="boost" class="<?php echo $pro['product_id']; ?>" ><i><img src="<?php echo site_url(); ?>assets/front/images/boost.png" alt="Image" ></i>Promote My Item</a>
                                                <!-- Boost<font color="white">(Coming Soon)</font> --></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div> 
                        <?php } ?>
                    <?php } ?>

                    <?php if (isset($my_deactivateads) && $my_deactivateads == 'yes') { ?>
                        <div class="edit_option"><i class="fa fa-pencil-square-o"></i>
                            <div class="tip">
                                <i class="fa fa-caret-right"></i>
                                <ul class="options_list">  
                                    <li id="edit<?php echo $pro['product_id']; ?>"><a href="<?php echo site_url() . 'user/listings_edit/' . $pro['product_id']; ?>"><i><img src="<?php echo site_url(); ?>assets/front/images/edit.png" alt="Image" ></i>Edit</a></li>
                                    <li ><a href="<?php echo site_url() ?>user/repost_ads/<?php echo $pro['product_id']; ?>" ><i><img src="<?php echo site_url(); ?>assets/front/images/repost.png" alt="Image" ></i>Repost</a></li>
                                    <li id="mynew1<?php echo $pro['product_id']; ?>"><a href="javascript:void(0);"  class="<?php echo $pro['product_id']; ?>" id="delet_user_ad" ><i><img src="<?php echo site_url(); ?>assets/front/images/delete.png" alt="Image"></i>Delete</a></li>
                                </ul>
                            </div>
                        </div>   
                    <?php } ?>    
                </div>
                <div class="cat_grid">
                    <?php
                    if ((isset($seller_listing_page) && $seller_listing_page == 'yes') || (isset($my_listing) && $my_listing == 'yes') || (isset($my_deactivateads) && $my_deactivateads == 'yes')) {
                        
                    } else {
                        ?>
                        <div class="by-user">
                            <?php
                            $profile_picture = '';
                            $profile_picture = $this->dbcommon->load_picture($pro['profile_picture'], $pro['facebook_id'], $pro['twitter_id'], $pro['username'], $pro['google_id']);
                            ?>
                            <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" alt="Profile Image"/>
                            <?php
                            if (isset($pro['product_for']) && $pro['product_for'] == 'store' && isset($pro['store_domain']) && !empty($pro['store_domain']))
                                $user_profile_pg = HTTP . $pro['store_domain'] . after_subdomain . remove_home;
                            else
                                $user_profile_pg = base_url() . emirate_slug . $pro['user_slug'];
                            ?>
                            <a href="<?php echo $user_profile_pg; ?>" title="<?php echo $pro['username1']; ?>"><?php echo $pro['username1']; ?></a>                                            
                        </div> 
                    <?php } ?>
                    <div class=" price">

                        <span title=" <?php echo ($pro['product_price'] != '' && (int) $pro['product_price'] != 0) ? 'AED ' . number_format($pro['product_price']) : ''; ?>"><?php echo ($pro['product_price'] != '' && (int) $pro['product_price'] != 0) ? 'AED ' . number_format($pro['product_price']) : ''; ?></span>
                    </div>
                </div>
                <div class="count-img">
                    <i class="fa fa-image"></i><span><?php echo $pro['MyTotal']; ?></span>
                </div>

            </div>
        </div>

        <?php
    }
} else {
    ?>
    <div class="catlist col-sm-10">
        <div class="TagsList">
            <div class="subcats">
                <div class="col-sm-12 no-padding-xs">
                    <div class="col-sm-12">
                        &nbsp;No results found
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
?>