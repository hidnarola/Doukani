<?php
if (isset($company_list) && sizeof($company_list) > 0) {
    foreach ($company_list as $com) {
        ?>
        <li>
            <?php if (isset($com['f_status']) && (int) $com['f_status'] > 0) { ?>
                <div class="ribbon_main">
                    <div class="red_ribbon"></div>
                <?php } ?>
                <a href="<?php echo site_url() . $com['user_slug']; ?>">
                    <div class="comp-block">
                        <?php
                        if (isset($com['company_logo']) && !empty($com['company_logo']))
                            $img_path = company_image_start . site_url() . offer_company . 'medium/' . $com['company_logo'] . company_image_end;
                        else
                            $img_path = company_image_start . site_url() . 'assets/upload/No_Image.png' . company_image_end;
                        ?>
                        <div class="comp-img"><img src="<?php echo $img_path; ?>" alt="<?php echo $com['company_name']; ?>" onerror="this.src='<?php echo company_image_start.base_url(); ?>assets/upload/No_Image.png<?php echo company_image_end; ?>'"></div>
                        <h4 class="com-name"><span><?php echo $com['company_name']; ?></span></h4>
                    </div>
                </a>
                <?php if (isset($com['f_status']) && (int) $com['f_status'] > 0) { ?>
                </div>
            <?php } ?>
        </li>
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
