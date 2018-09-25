<?php
if (!empty($favproduct)) {
    foreach ($favproduct as $pro) {
        // echo "<pre>"; print_r($most_viewed_product); die;
        ?>
        <div class="col-md-3 col-sm-4">
            <div class="item-sell">
                <div class="item-img">
                    <?php if ($pro['product_is_sold'] == 1) { ?>
                        <div class="sold"><span>SOLD</span></div>
                    <?php } ?>
                    <?php if (!empty($pro['product_image'])): ?>
                        <a href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'" alt="Product Image" /></a>
                    <?php endif; ?>

                </div>
                <div class="item-disc">
                    <a style="text-decoration: none;" href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>">
                        <?php $len = strlen($pro['product_name']); ?>	
                        <h4 <?php if ($len > 21) {
                    echo 'title="' . $pro['product_name'] . '"';
                } ?> >
                            <?php
                            $len = strlen($pro['product_name']);
                            if ($len > 21)
                                echo substr($pro['product_name'], 0, 21) . '...';
                            else
                                echo $pro['product_name'];
                            ?>
                        </h4></a>
                    <?php
                    $str = str_replace('\n', " ", $pro['catagory_name']);
                    $len = strlen($str);
                    ?>
                    <small <?php if ($len > 28) {
                    echo 'title="' . $str . '"';
                } ?>>
                        <?php
                        if ($len > 28)
                            echo substr($str, 0, 28) . '...';
                        else
                            echo $str;
                        ?>
                    </small>
                </div>
                <div class="row">
                    <div class="by-user col-sm-12">
        <?php
        $profile_picture = '';
        $profile_picture = $this->dbcommon->load_picture($pro['profile_picture'], $pro['facebook_id'], $pro['twitter_id'], $pro['username'], $pro['google_id']);
        ?>
                        <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" alt="Profile Image" />
                        <a href="<?php echo base_url() . 'seller/listings/' . $pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a>                                            
                    </div>
                    <div class="col-sm-12 price">
                        <span>AED <?php echo number_format($pro['product_price']); ?></span>
                    </div>
                </div>
                <div class="count-img">
                    <i class="fa fa-image"></i><span><?php echo $pro['cntimg'] + $pro['main']; ?></span>
                </div>
                <?php if ($pro['product_is_sold'] != 1) { ?>	
            <?php if (@$pro['product_total_favorite'] != 0) { ?>
                        <div class="star fav" ><a href="#">
                                <i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
                            </a></div>
                    <?php } else { ?>
                        <div class="star" ><a href="#">
                                <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
                            </a></div>
            <?php } ?>
        <?php } ?>

            </div>
        </div>

    <?php
    }
} else {
    echo "<h5>&nbsp;No product found.</h5>";
}
?>
						