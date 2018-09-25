<?php
if (isset($offers_list) && sizeof($offers_list) > 0) {
    $flag = 1;
    foreach ($offers_list as $list) {
        if (!empty($between_banners)) {
            if ($flag == 3) {
                ?>
                <div class="offer-block wide banner">
                    <div class="img">
                <?php $this->load->view('home/between_banner_view'); ?>  
                    </div>
                </div>
                <?php
            }
            $flag++;
        }
        ?>
        <div class="offer-block wide">
            <div class="offer-img">
                
                <?php if((int)$list['f_status'] > 0) { ?>
                <div class="ribbon_main">
                    <div class="red_ribbon"></div>
                    <?php } ?>
                    <a  href="<?php echo site_url().$list['user_slug'].'/'.$list['offer_slug']; ?>"> 
                        <?php if (isset($list['offer_image']) && !empty($list['offer_image'])) { ?>
                            <img src="<?php echo thumb_start_grid . base_url() . offers . "medium/" . $list['offer_image'] . thumb_end_grid; ?>" onerror="this.src='<?php echo thumb_start_grid.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" alt="<?php echo $list['offer_title']; ?>">
                        <?php } else { ?>
                            <img src="<?php echo thumb_start_grid.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>" onerror="this.src='<?php echo thumb_start_grid.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" alt="<?php echo $list['offer_title']; ?>">
        <?php } ?>
                            <?php if($list['out_of_date_status']=="1") { ?>
                                <div class="out"><span>Out of Date</span></div>
                            <?php } ?>
                    </a>
                <?php if((int)$list['f_status'] > 0) { ?>
                </div>
                <?php } ?>
            </div>
            <div class="offer-detail">
                <h3 class="offer-title"><a  href="<?php echo site_url().$list['user_slug'].'/'.$list['offer_slug']; ?>" title="<?php echo $list['offer_title']; ?>"><?php echo $list['offer_title']; ?></a></h3>
                <p class="offer-text"><?php echo $list['offer_description']; ?></p>
                <div class="offer-by">
        <?php if (isset($request_company_name) && $request_company_name == 'yes') { ?><a href="<?php echo site_url() . $list['user_slug']; ?>"><?php echo $list['company_name']; ?></a> <?php } ?>
                </div>
                <hr class="sep" />
                <p class="added">Added <?php $date = date_create($list['offer_start_date']);
        echo date_format($date, 'd-m-Y'); ?></p>
                
                <?php if(isset($list['offer_end_date']) && $list['offer_end_date']!='0000-00-00') { ?>
                    <p class="date_expires">Expires <?php $date = date_create($list['offer_end_date']);
               echo date_format($date, 'd-m-Y'); ?></p><br><br>
               <?php } ?>
               
                <div class="Viewouterbutton">
                    <a href="<?php echo site_url().$list['user_slug'].'/'.$list['offer_slug']; ?>" class="btn mybtn">View</a>
                </div>
            </div>
        </div>
    <?php }
} else { ?>
    <div class="catlist">
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
<!--<div class="offer-block wide banner">
    <div class="img"><img src="img/Webinar-landing-Banner(970 X 250).jpg" alt="" /></div>
</div>-->