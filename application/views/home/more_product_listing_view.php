<?php
$flag = 1;
if (!empty($product_data)) {
    foreach ($product_data as $pro) {
//        if(isset($req_numItems) && $req_numItems < $display_limit){
        if (!empty($between_banners)) {
            if ($flag == 5) {
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
        ?>  
        <!--item1-->
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
            <div class="list-item <?php if ((isset($home_page) && $home_page == 'yes') || (isset($latest_page) && $latest_page == 'yes')) echo 'home_items'; ?>">
                <div class="col-sm-3 img-holder">
                    <?php if ($pro['product_is_sold'] == 1) { ?>
                        <div class="sold"><span>SOLD</span></div>
                    <?php } ?>
                    <?php if (isset($pro['featured_ad']) && $pro['featured_ad'] > 0) { ?>
                        <div class="ribbon_main">
                            <div class="red_ribbon"></div> <?php } ?>
                        <div class="img-holderInner">                    
                            <?php if (!empty($pro['product_image'])) { ?>
                                <img src="<?php echo thumb_start_grid . base_url() . product . "medium/" . $pro['product_image'] . thumb_end_grid; ?>" class="img-responsive" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" alt="<?php echo $pro['product_name']; ?>"/>
                            <?php } else { ?>
                                <img src="<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>" class="img-responsive" alt="<?php echo $pro['product_name']; ?>" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" />
                            <?php } ?>
                        </div>
                        <?php if (isset($pro['featured_ad']) && $pro['featured_ad'] > 0) { ?>
                        </div>
                    <?php } ?>
                    <div class="count-img">
                        <i class="fa fa-image"></i><span><?php echo $pro['MyTotal']; ?></span>
                    </div>
                </div>
                <div class="col-sm-9 info-holder">
                    <div class="row">
                        <div class="col-sm-8">
                            <a style="text-decoration: none;" href="<?php echo base_url() . $pro['product_slug']; ?>"><h3><?php echo $pro['product_name']; ?></h3></a>
                            <small><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></small>
                        </div>
                        <div class="col-sm-4 ">
                            <div class="list-icons01">
                                <?php
                                if ($loggedin_user != $pro['product_posted_by']) {
                                    if ($pro['product_is_sold'] != 1) {
                                        if ($is_logged != 0) {
                                            $favi = $this->dbcommon->myfavorite($pro['product_id'], session_userid);
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

                                        if ($is_logged != 0) {
                                            $like = $this->dbcommon->mylike($pro['product_id'], session_userid);
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
                                ?>                                                          
                            </div>
                            <?php if ($pro['product_price'] != '' && (int) $pro['product_price'] != 0) { ?>
                                <div class="price">
                                    <h4><?php echo ($pro['product_price'] != '' && (int) $pro['product_price'] != 0) ? 'AED ' . number_format($pro['product_price']) : '';
                    ;
                                ?></h4>
                                </div>
        <?php } ?>
                        </div>

                    </div>
                    <div class="infobar col-sm-12">
                        <?php if ($pro['category_id'] == 7 || $pro['category_id'] == 8) { ?>

                            <?php if ($pro['category_id'] == 7) { ?>
                                <?php if (@$pro['year'] != "") { ?>
                                    <div class="col-sm-4 col-md-3"><span>Year :</span><p><?php echo @$pro['year']; ?></p></div>
                                <?php } if (@$pro['colorname']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Color : </span><p><?php echo @$pro['colorname']; ?></p></div>
                                <?php } if (@$pro['mileagekm']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>KM : </span><p><?php echo @$pro['mileagekm']; ?></p></div>
                                <?php } if (@$pro['bname']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Brand : </span><p><?php echo @$pro['bname']; ?></p></div>
                                <?php }if (@$pro['mname']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Model :</span><p> <?php echo @$pro['mname']; ?></p></div>
                                <?php } if (@$pro['type_of_car']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Type : </span><p><?php echo @$pro['type_of_car']; ?></p></div>
                                <?php }if (@$pro['make']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Make : </span><p><?php echo @$pro['make']; ?></p></div>
                                <?php }if (@$pro['car_number'] && @$pro['sub_category_id'] == '144') { ?>
                                    <div class="col-sm-4 col-md-3"><span>Car Number : </span><p><?php echo @$pro['car_number']; ?></p></div>
                                <?php }if (@$pro['plate_source_name'] && @$pro['sub_category_id'] == '144') { ?>
                                    <div class="col-sm-4 col-md-3"><span>Plate Source : </span><p><?php echo @$pro['plate_source_name']; ?></p></div>
                                <?php }if (@$pro['plate_prefix'] && @$pro['sub_category_id'] == '144') { ?>
                                    <div class="col-sm-4 col-md-3"><span>Plate Prefix : </span><p><?php echo @$pro['plate_prefix']; ?></p></div>
                                <?php }if (@$pro['plate_digit'] && @$pro['sub_category_id'] == '144') { ?>
                                    <div class="col-sm-4 col-md-3"><span>Plate Digit : </span><p><?php echo @$pro['plate_digit']; ?></p></div>                                                    
                                <?php }if (@$pro['car_repeating_number'] && @$pro['sub_category_id'] == '144') { ?>
                                    <div class="col-sm-4 col-md-3"><span>Repeating Number : </span><p><?php echo @$pro['car_repeating_number']; ?></p></div>
                                <?php } ?>

                            <?php } else if ($pro['category_id'] == 8) { ?>
                                <?php if (@$pro['Country'] != "") { ?>
                                    <div class="col-sm-4 col-md-3"><span>Country : </span><p><?php echo @$pro['Country']; ?></p></div>
                                <?php } if (@$pro['Emirates']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Emirates : </span><p><?php echo @$pro['Emirates']; ?></p></div>
                                <?php } if (@$pro['PropertyType']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Property Type : </span><p><?php echo @$pro['PropertyType']; ?></p></div>
                                        <?php } if (@$pro['Bedrooms']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Bedrooms : </span><p><?php
                                            if (@$pro['Bedrooms'] == '-1')
                                                echo 'More than 10';
                                            else
                                                echo @$pro['Bedrooms'];
                                            ?></p></div>
                                        <?php }if (@$pro['Bathrooms']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Bathrooms : </span><p><?php
                                            if ($pro['Bathrooms'] == '-1')
                                                echo 'More than 10';
                                            else
                                                echo @$pro['Bathrooms'];
                                            ?></p></div>                                                    
                                <?php } if (@$pro['Area']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Area : </span><p><?php echo @$pro['Area']; ?></p></div>
                                <?php } if (@$pro['Amenities']) { ?>
                                    <div class="col-sm-4 col-md-3"><span>Amenities : </span><p><?php echo @$pro['Amenities']; ?></p></div>
                                <?php } ?>
                            <?php } ?>
                            <?php
                        }
                        // print_r($pro);
                        ?>

                        <?php if (@$pro['mobile_operator']) { ?>
                            <div class="col-sm-4 col-md-3"><span>Mobile Operator : </span><p><?php echo @$pro['mobile_operator']; ?></p></div>                                                    
                        <?php } if (@$pro['car_repeating_number'] && @$pro['sub_category_id'] == '145') { ?>
                            <div class="col-sm-4 col-md-3"><span>Repeating Number : </span><p><?php echo @$pro['car_repeating_number']; ?></p></div>      
                        <?php } if (@$pro['mobile_number']) { ?>
                            <div class="col-sm-4 col-md-3"><span>Mobile Number : </span><p><?php echo @$pro['mobile_number']; ?></p></div>
                        <?php } if (isset($pro['address']) && !empty(trim($pro['address']))) { ?>  
                            <div class="col-sm-4 col-md-3"><span>Address : </span><p><?php echo @$pro['address']; ?></p></div>
        <?php } ?>

                    </div>
                    <?php
                    $profile_picture = '';
                    $profile_picture = $this->dbcommon->load_picture($pro['profile_picture'], $pro['facebook_id'], $pro['twitter_id'], $pro['username'], $pro['google_id']);
                    ?>                                                            
                    <?php
                    if ((isset($seller_listing_page) && $seller_listing_page == 'yes') || (isset($my_listing) && $my_listing == 'yes') || (isset($my_deactivateads) && $my_deactivateads == 'yes')) {
                        
                    } else {
                        ?>
                        <div class="by-user">                                            
            <?php //echo base_url() . profile . "original/" . $pro['profile_picture'];        ?>
                            <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" alt="Profile Image"/>
                            <a href="<?php echo base_url() . emirate_slug . $pro['user_slug']; ?>"><?php echo $pro['username1']; ?></a>                                           
                        </div>
        <?php } ?>
                    <div class="Viewouterbutton">
                        <a href="<?php echo base_url() . $pro['product_slug']; ?>" class="btn mybtn">View</a>
                    </div>
                </div>
            </div>
        </div>
        <!--//item-->
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

<script>
    var w = $(document).find('.horizontalList .img-holder').width();
    $(document).find('.horizontalList .img-holder .img-holderInner').css('width', w);
    var h = $(document).find('.horizontalList .img-holder').height();
    $(document).find('.horizontalList .img-holder .img-holderInner').css('height', h);

    $(window).resize(function () {
        var w = $(document).find('.horizontalList .img-holder').width();
        $(document).find('.horizontalList .img-holder .img-holderInner').css('width', w);
        var h = $(document).find('.horizontalList .img-holder').height();
        $(document).find('.horizontalList .img-holder .img-holderInner').css('height', h);
    });
</script>