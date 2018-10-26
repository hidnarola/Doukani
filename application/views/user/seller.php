<html>
    <head>
        <?php $this->load->view('include/head'); ?>
    </head>

    <body>
        <!--container-->
        <div class="container-fluid">

            <!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
            <!--//ad1 header-->
            <!--menu-->
            <?php $this->load->view('include/menu'); ?>
            <!--//menu-->

            <!--body-->
            <div class="row page">
                <!--header-->
                <?php $this->load->view('include/sub-header'); ?>
                <!--//header-->
                <!--main-->
                <div class="col-sm-12 main">
                    <div class="row">
                        <!--cat-->
                        <?php $this->load->view('include/left-nav'); ?>
                        <!--//cat-->
                        <!--content-->
                        <div class="col-sm-10">
                            <?php $this->load->view('home/seller_profile'); ?>
                            <div class="col-md-offset-8 col-sm-4 text-right views">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->user_id; ?>">
                                <a href="#" class="view-active"><span class="fa  fa-th"></span></a>
                                <a href="<?php echo base_url(); ?>seller/listings/<?php echo $user->user_id; ?>?view=list"><span class="fa  fa-th-list"></span></a>
                            </div>
                            <div class="row most-viewed">
                                <div class="col-sm-12" id="most-viewed">                                
                                    <!--item1-->
                                    <?php
                                    if (!empty($products)) {
                                        foreach ($products as $pro) {
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
                                                        <a style="text-decoration: none;" href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>"><?php $len = strlen($pro['product_name']); ?>	
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
                                                        <small <?php if ($len > 32) {
                                                            echo 'title="' . $str . '"';
                                                        } ?>>
                                                            <?php
                                                            if ($len > 32)
                                                                echo substr($str, 0, 32) . '...';
                                                            else
                                                                echo $str;
                                                            ?>
                                                        </small>	
                                                    </div>
                                                    <div class="row" style="min-height: 60px;">
                                                        <div class="by-user col-sm-12">
                                                            <?php
                                                            $profile_picture = '';
                                                            if ($user->profile_picture != '') {
                                                                $profile_picture = base_url() . profile . "original/" . $user->profile_picture;
                                                            } elseif ($user->facebook_id != '') {
                                                                $profile_picture = 'https://graph.facebook.com/' . $user->facebook_id . '/picture?type=large';
                                                            } elseif ($user->twitter_id != '') {
                                                                $profile_picture = 'https://twitter.com/' . $user->username . '/profile_image?size=original';
                                                            } elseif ($user->google_id != '') {
                                                                $data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/' . $user->google_id . '?alt=json');
                                                                $d = json_decode($data);
                                                                $profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
                                                            }
                                                            ?>
                                                            <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"/>
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
<?php if (@$hide == "false") { ?>
                                        <div class="col-sm-12 text-center" id="load_more">
                                            <button class="btn btn-blue" onclick="more_seller_products();" id="load_product" value="0">Load More</button><br><br><br>
                                        </div>
<?php } ?>		
                                </div>
                                <!--<div class="col-sm-12 text-center">
                                    <button class="btn btn-blue" onclick="load_more_product();" id="load_product" value="0">Load More</button>
                                </div>-->
                            </div>
                            <!--End Most Viewed product items-->

                        </div>
                    </div>
                    <!--//content-->
                </div>
            </div>
            <!--//main-->




        </div>
        <!--//body-->
        <div id="loading" style="text-align:center">
            <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
        </div>
        <!--footer-->
<?php $this->load->view('include/footer'); ?>
        <!--//footer-->
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

        function more_seller_products() {
            $body = $("body");
            $body.addClass("loading");
            var url = "<?php echo base_url() ?>seller/more_seller_products";
            var start = $("#load_product").val();
            start++;
            $("#load_product").val(start);
            var user_id = $("#user_id").val();
            var val = start;
            $('#loading').show();
            $.post(url, {value: val, user_id: user_id, view: ""}, function (response)
            {

                $("#load_more").before(response.html);
                if (response.val == "true") {
                    $("#load_product").hide();
                }
                $('#loading').hide();
            }, "json");
        }

    </script>
    <!--container-->
</body>
</html>