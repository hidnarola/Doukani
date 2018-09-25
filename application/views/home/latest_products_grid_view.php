<?php foreach ($latest_product as $pro) { ?>
    <div class="item">
        <div class="col-sm-12">
            <div class="item-sell">
                <div class="item-img-outer">                    
                        <div class="item-img">
                            <?php if ($pro['mytag'] == "SOLD") { ?>
                                <div class="sold"><span>SOLD</span></div>
                                <?php
                            }
                            if ($pro['product_image'] != '') {
                                ?>							
                                <a href="<?php echo base_url() . $pro['product_slug']; ?>"><img src="<?php echo thumb_start_grid_featured_latest . base_url() . product . "medium/" . $pro['product_image'] . thumb_end_grid_featured_latest; ?>"  class="img-responsive  lastet_adss" onerror="this.src='<?php echo thumb_start_grid_featured_latest . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_featured_latest; ?>'"  alt="<?php echo $pro['product_name']; ?>"  /></a>
                            <?php } else { ?>
                                <a href="<?php echo base_url() . $pro['product_slug']; ?>"><img src="<?php echo thumb_start_grid_featured_latest . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_featured_latest; ?>"  class="img-responsive " onerror="this.src='<?php echo thumb_start_grid_featured_latest . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_featured_latest; ?>'" alt="<?php echo $pro['product_name']; ?>" /></a>
                            <?php } ?>
                        </div>
                        <div class="function-icon">
                            <?php
                            if ($loggedin_user != $pro['product_posted_by']) {
                                if ($pro['product_is_sold'] != 1) {
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
                    </div>
                    <div class="item-disc">
                        <a style="text-decoration: none;" href="<?php echo base_url() . $pro['product_slug']; ?>">
                            <?php $len = strlen($pro['product_name']); ?>	
                            <h4 <?php
                            if ($len > 17) {
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
                        if ($len > 25) {
                            echo 'title="' . htmlentities($str) . '"';
                        }
                        ?>>
    <?php echo $str; ?>
                        </small>
                    </div>
                    <div class="cat_grid">
                        <?php
                        $profile_picture = '';

                        $profile_picture = $this->dbcommon->load_picture($pro['profile_picture'], $pro['facebook_id'], $pro['twitter_id'], $pro['username'], $pro['google_id']);
                        ?> 
                        <div class="by-user">
                            <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" alt="Profile Image"  />
                            <a href="<?php echo base_url() . emirate_slug .$pro['user_slug']; ?>" title="<?php echo $pro['username1']; ?>"><?php echo $pro['username1']; ?></a>
                        </div>
                        <div class="price">
                            <span title=" <?php echo ($pro['product_price'] != '' && (int)$pro['product_price'] != 0) ? 'AED'.number_format($pro['product_price']) : ''; ?>" ><?php echo ($pro['product_price'] != '' && (int)$pro['product_price'] != 0) ? 'AED '.number_format($pro['product_price']) : ''; ?></span>
                        </div>
                    </div>
                    <div class="count-img">
                        <i class="fa fa-image"></i><span><?php echo $pro['MyTotal']; ?></span>
                    </div>                                                
                </div>
            </div>
        </div>
<?php } ?>