<?php
$flag = 1;
if (!empty($listing)) {
    foreach ($listing as $pro) {
        if (!empty($between_banners)) {
            if ($flag == 6) {
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
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="item-sell">
                <div class="item-img-outer">
                    <div class="item-img">
                        <?php if ((int) $pro['stock_availability'] <= 0) { ?>
                            <div class="sold"><span>Out of stock</span></div>
                        <?php }
                        if (isset($pro['product_image']) && $pro['product_image'] != '') {
                            ?>											
                            <a href="<?php echo $store_url . $pro['product_slug']; ?>"><img src="<?php echo thumb_start_grid . HTTP . website_url . product . "medium/" . $pro['product_image'] . thumb_end_grid; ?>" class="img-responsive" onerror="this.src='<?php echo thumb_start_grid . HTTP . website_url; ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" alt="<?php echo $pro['product_name']; ?>" /></a>
                        <?php } else { ?>
                            <a href="<?php echo $store_url . $pro['product_slug']; ?>"><img src="<?php echo thumb_start_grid . HTTP . website_url; ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>" class="img-responsive" alt="<?php echo $pro['product_name']; ?>" /></a>
                        <?php } ?>
                    </div>
                    <div class="function-icon">
                        <?php
                        if ($loggedin_user != $pro['product_posted_by']) {
                            if ((int) $pro['stock_availability'] > 0) {
                                if ($is_logged != 0) {                                    
                                    $favi = (int)$pro['my_favorite'];
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
                                    <?php }
                                } else {
                                    ?>
                                    <div class="star" ><a href="<?php echo HTTP . website_url . 'login/index'; ?>">
                                            <i class="fa fa-star-o"></i>
                                        </a>
                                    </div>
                <?php
                }

                if ($is_logged != 0) {
                    $like = (int)$pro['my_like'];
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
                    <?php }
                } else {
                    ?>
                                    <div class="newthumb" ><a href="<?php echo HTTP . website_url . 'login/index'; ?>">
                                            <i class="fa fa-thumbs-o-up"></i>
                                        </a>
                                    </div>
                            <?php }
                        }
                    } ?>                                                          
                    </div>
                </div>
                <div class="item-disc">
                    <a style="text-decoration: none;" href="<?php echo $store_url . $pro['product_slug']; ?>">
        <?php $len = strlen($pro['product_name']); ?>	
                        <h4 <?php if ($len > 21) {
            echo 'title="' . $pro['product_name'] . '"';
        } ?> >
        <?php echo $pro['product_name']; ?>
                        </h4>
                    </a>
        <?php
        $str = str_replace('\n', " ", $pro['catagory_name']);
        $len = strlen($str);
        ?>
                    <small <?php if ($len > 28) {
            echo 'title="' . $str . '"';
        } ?>>
        <?php echo $str; ?>
                    </small>	
                </div>
                <div class="cat_grid">        
                    <div class=" price">
                        <span title="<?php echo ($pro['product_price'] != '' && (int)$pro['product_price'] != 0) ? 'AED '.number_format($pro['product_price'],2) : ''; ?>"><?php echo ($pro['product_price'] != '' && (int)$pro['product_price'] != 0) ? 'AED '.number_format($pro['product_price'],2) : ''; ?></span>
                    </div>
                </div>
                <div class="count-img">
                    <i class="fa fa-image"></i><span><?php echo $pro['MyTotal']; ?></span>
                </div>
            </div>
        </div>
    <?php }
} ?>