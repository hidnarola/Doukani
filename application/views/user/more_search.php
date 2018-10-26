<!--item1-->
<?php
if (!empty($product_data)) {
    foreach ($product_data as $pro) {
        // echo "<pre>"; print_r($most_viewed_product); die;
        ?>
        <div class="col-md-3 col-sm-4">
            <div class="item-sell">
                <div class="item-img">
                    <?php if ($pro['product_is_sold'] == 1) { ?>
                        <div class="sold"><span>SOLD</span></div>
                    <?php } ?>
                    <?php if (!empty($pro['product_image'])): ?>
                        <a href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'"/></a>
                    <?php endif; ?>

                </div>
                <div class="item-disc">
                    <a style="text-decoration: none;text-align:left;" href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>">
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
                <div class="row" style="min-height: 60px;">
                    <?php
                    $profile_picture = '';
                    if ($pro['profile_picture'] != '') {
                        $profile_picture = base_url() . profile . "original/" . $pro['profile_picture'];
                    } elseif ($pro['facebook_id'] != '') {
                        $profile_picture = 'https://graph.facebook.com/' . $pro['facebook_id'] . '/picture?type=large';
                    } elseif ($pro['twitter_id'] != '') {
                        $profile_picture = 'https://twitter.com/' . $pro['username'] . '/profile_image?size=original';
                    } elseif ($pro['google_id'] != '') {
                        $data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/' . $pro['google_id'] . '?alt=json');
                        $d = json_decode($data);
                        $profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
                    }
                    ?>
                    <div class="by-user col-sm-12">
                        <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" align="left"/>
                        <a href="<?php echo base_url() . 'seller/listings/' . $pro['product_posted_by']; ?>" ><p style="text-align:left;margin-top:6px;"><?php echo $pro['username1']; ?></p></a>
                    </div>
                    <div class="col-sm-12 price">
                        <span>AED <?php echo number_format($pro['product_price']); ?></span>
                    </div>
                </div>
                <div class="count-img">
                    <i class="fa fa-image"></i><span><?php echo $pro['cntimg'] + $pro['main']; ?></span>
                </div>
        <?php if ($pro['product_is_sold'] != 1) { ?>
                    <?php if ($is_logged != 0) { ?>
                        <?php if (@$pro['product_total_favorite'] != 0) { ?>
                            <div class="star fav" ><a href="#">
                                    <i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
                                </a></div>
                        <?php } else { ?>
                            <div class="star" ><a href="#">
                                    <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
                                </a></div>
                <?php }
            } else {
                ?>

                        <div class="star" ><a href="<?php echo base_url() . 'login/index'; ?>">
                                <i class="fa fa-star-o"></i>
                            </a></div>
            <?php } ?>
        <?php } ?>

            </div>
        </div>

    <?php
    }
} else {
    echo "<h5>No product found in this category</h5>";
}
?>

<!--//body-->
</div>
<script type="text/javascript">
    $('div.star a i').click(function () {

        var url = "<?php echo base_url() ?>home/add_to_favorites";
        var fav = 0;
        var id = $(this).attr('id');
//            console.log(id);
        if ($(this).hasClass('fa-star-o')) {
            $(this).closest('div').addClass('fav');
            $(this).removeClass("fa-star-o");
            $(this).addClass("fa-star");
            fav = 1;
        } else if ($(this).hasClass('fa-star')) {
            $(this).closest('div').removeClass('fav');
            $(this).addClass("fa-star-o");
            $(this).removeClass("fa-star");
            fav = -1;
        }

        $.post(url, {value: fav, product_id: id}, function (response)
        {
//                console.log(response);
            if (response != 'Success' && response != 'failure')
            {
                $('#err_div').show();
                $("#error_msg").text(response);
            } else
                $('#err_div').hide();
        });


    });


</script>
<!--container-->
</body>
</html>
