<?php if (sizeof($offers_list) > 0) {
    $flag = 1;
    foreach ($offers_list as $list) {
        if (!empty($between_banners)) {
            if ($flag == 5) {
                ?>
                <div class=" <?php if(isset($offer_home) && $offer_home=='yes') echo 'item'; 
                        elseif(isset($offer_detail) && $offer_detail=='yes') echo 'side-offer';
                            else echo  'col-lg-12 col-md-12 col-sm-12 col-xs-12'; ?>">
                    <div class="offer-block wide banner">
                      <div class="img"><?php $this->load->view('home/between_banner_view'); ?></div>
                    </div>
                </div>
                <?php
            }
            $flag++;
        }
        ?>
        <div class=" <?php if(isset($offer_home) && $offer_home=='yes') echo 'item'; 
        elseif(isset($offer_detail) && $offer_detail=='yes') echo 'side-offer';
            else echo  'col-lg-3 col-md-4 col-sm-6 col-xs-6'; ?>">
            <div class="offer-block">
                <?php if(isset($list['f_status']) && (int)$list['f_status'] > 0) { ?>
                <div class="ribbon_main">
                    <div class="red_ribbon"></div>
                <?php } ?>
                    <div class="offer-img">
                        <?php
                            $img_get = get_offer_image_first($list['offer_id']);
                            $offer_first_image = $list['offer_image'];
                            if(!empty($img_get)){
                                $offer_first_image = $img_get['file_path'];
                            }
                        ?>
                        <a href="<?php echo site_url().$list['user_slug'].'/'.$list['offer_slug']; ?>">
                            <?php
                            if (isset($list) && !empty($list)) { ?>
                                <img src="<?php echo thumb_start_grid_offer . base_url() . offers . "medium/" . $offer_first_image . thumb_end_grid_offer; ?>" onerror="this.src='<?php echo thumb_start_grid_offer.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_offer; ?>'" alt="<?php echo $list['offer_title']; ?>">
                            <?php } else { ?>
                                <img src="<?php echo thumb_start_grid_offer.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_offer; ?>" onerror="this.src='<?php echo thumb_start_grid_offer.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_offer; ?>'" alt="<?php echo $list['offer_title']; ?>">
        <?php } ?>
                                <?php if(isset($list['out_of_date_status']) && $list['out_of_date_status']=="1") { ?>
                                    <div class="out"><span>Out of Date</span></div>
                                <?php } ?>
                        </a>
                    </div>
                    <div class="offer-detail">
                        <h3 class="offer-title" title="<?php echo $list['offer_title']; ?>">
                            <a href="<?php echo site_url().$list['user_slug'].'/'.$list['offer_slug']; ?>">
                                <?php echo $list['offer_title']; ?>
                            </a>
                        </h3>
                        <!--<p class="offer-text"><?php //echo $list['offer_description']; ?></p>-->
                        <hr class="sep" />
                        <p class="added">Added <?php $date = date_create($list['offer_start_date']);
        echo date_format($date, 'd-m-Y'); ?></p>
                    </div>
                    <?php if(isset($list['f_status']) && (int)$list['f_status'] > 0) { ?>
                    </div>
                    <?php } ?>
            </div>
        </div>
    <?php }
} else { ?>
<div class=" <?php if(isset($offer_home) && $offer_home=='yes') echo 'item'; 
        elseif(isset($offer_detail) && $offer_detail=='yes') echo 'side-offer';
            else echo  'col-md-12'; ?>">
    <div class="catlist col-sm-10">
        <div class="TagsList">
            <div class="subcats">
                <div class="col-sm-12 no-padding-xs">
                    <div class="col-sm-12">
                        &nbsp;No results found
                    </div>
                </div>
            </div>
            <br><br><br>
        </div>
    </div>
    </div>
<?php } ?>
