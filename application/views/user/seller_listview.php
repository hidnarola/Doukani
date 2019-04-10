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

                            <?php if ($this->session->flashdata('msg1')): ?>
                                <div class='alert  alert-info'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <center><?php echo $this->session->flashdata('msg1'); ?></center>
                                </div>
                            <?php endif; ?>
                            <div class="bg_up">
                                <div class="user_profile_main">
                                    <div class="clearfix">
                                        <div class="user_pro_pic">
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
                                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->user_id; ?>">
                                            <img src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'">
                                            <?php if ($get_myfollowers > 0) { ?>
                                                <div class="badge_top">
                                                    <img src="<?php echo base_url(); ?>assets/front/images/check.png" alt="" />
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="right_follow_side">
                                            <h3><?php if ($user->nick_name != ''): echo $user->nick_name;
                                            else: echo $user->username;
                                            endif; ?></h3>
                                            <div class="bottom_bar">
                                                <?php
                                                $btn_name = 'Follow';
                                                if ($is_following > 0 && $is_logged == 1)
                                                    $btn_name = 'Following';
                                                if (isset($login_username)) {
                                                    if ($login_username != $user->username) {
                                                        ?>									
                                                        <a href="<?php echo base_url(); ?>seller/addfollow/<?php echo $user->user_id; ?>/list" class="btn btn-block mybtn follow_btn"><?php echo $btn_name; ?></a>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <a href="<?php echo base_url(); ?>seller/addfollow/<?php echo $user->user_id; ?>/list" class="btn btn-block mybtn follow_btn"><?php echo $btn_name; ?></a> 
                                                <?php } ?>
                                                <ul class="user_followers_main">
                                                    <li><a href="<?php echo base_url(); ?>seller/listings/<?php echo $user->user_id; ?>"><img src="<?php echo base_url(); ?>assets/front/images/img_1.png"> Listings</a></li>
                                                    <li><a href="<?php echo base_url(); ?>seller/followers/<?php echo $user->user_id; ?>"><img src="<?php echo base_url(); ?>assets/front/images/follow_icon.png"> Followers <?php echo sizeof($followers); ?></a></li>
                                                    <!--<li><a href="#" id="contact" ><img src="<?php echo base_url(); ?>assets/front/images/message_icon.png"> Contact</a></li>-->
                                                    <li><button class="btn mybtn btn-block"><span class="fa fa-phone"></span><span class="show_number">Contact</span></button></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-offset-8 col-sm-4 text-right views">
<?php $view = '';
if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') $view = 'view-active';
else $view = ''; ?>
                                <a href="<?php echo base_url(); ?>seller/listings/<?php echo $user->user_id; ?>" <?php echo $view; ?>><span class="fa  fa-th"></span></a>
                                <a href="#" class="<?php echo $view; ?>"><span class="fa  fa-th-list"></span></a>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 catlist">
                                    <?php
                                    $flag = 1;
                                    if (!empty($products)) {
                                        foreach ($products as $pro) {
                                            if ($flag == 3) {
                                                ?>

                                                <div class="col-sm-12">
                                                    <div class="ad-banner1">
            <?php if (!empty($between_banners)) { ?>

                                                            <a href="<?php echo $between_banners[0]['site_url']; ?>"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $between_banners[0]['big_img_file_name'] ?>" width="100%" class="img-responsive center-block" /></a>
                                                        <?php } else {
                                                            ?>
                                                            <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/ad2.jpg" class="img-responsive center-block" /></a>
            <?php } ?>


                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            $flag++;
                                            ?>
                                            <!--item1-->
                                            <div class="col-sm-12 list-item">
                                                <div class="col-sm-3 img-holder">
                                                    <?php if ($pro['product_is_sold'] == 1) { ?>
                                                        <div class="sold"><span>SOLD</span></div>
                                                    <?php } ?>
                                                    <?php // if (!empty($pro['product_image'])): ?>
                                                    <img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'"/>
        <?php //endif;  ?>
                                                    <div class="count-img">
                                                        <i class="fa fa-image"></i><span><?php echo $pro['cntimg'] + $pro['main']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9 info-holder">
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
                                                    <div class="col-sm-6">
                                                        <a style="text-decoration: none;" href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>"><h3><?php echo $pro['product_name']; ?></h3></a>
                                                        <small><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></small>
                                                    </div>
                                                    <div class="col-sm-6 price padding-r50">
                                                        <h4>AED <?php echo number_format($pro['product_price'],2); ?></h4>
                                                    </div>

                                                        <?php if ($pro['category_id'] == 7 || $pro['category_id'] == 8) { ?>
                                                        <div class="infobar col-sm-12">
                                                            <?php if ($pro['category_id'] == 7) { ?>
                                                                <?php if (@$pro['year'] != "") { ?>
                                                                    <div class="col-sm-4 col-md-3">Year : <?php echo @$pro['year']; ?></div>
                                                                <?php } if (@$pro['colorname']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Color : <?php echo @$pro['colorname']; ?></div>
                                                                <?php } if (@$pro['mileagekm']) { ?>
                                                                    <div class="col-sm-4 col-md-3">KM : <?php echo @$pro['mileagekm']; ?></div>
                                                                <?php }if (@$pro['model']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Model : <?php echo @$pro['model']; ?></div>
                                                                <?php } if (@$pro['type_of_car']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Type : <?php echo @$pro['type_of_car']; ?></div>
                                                                <?php }if (@$pro['make']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Make : <?php echo @$pro['make']; ?></div>
                                                                <?php } ?>
                                                            <?php } else if ($pro['category_id'] == 8) { ?>
                                                                <?php if (@$pro['Country'] != "") { ?>
                                                                    <div class="col-sm-4 col-md-3">Country : <?php echo @$pro['Country']; ?></div>
                                                                <?php } if (@$pro['Emirates']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Emirates : <?php echo @$pro['Emirates']; ?></div>
                                                                <?php } if (@$pro['PropertyType']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Property Type : <?php echo @$pro['PropertyType']; ?></div>
                                                                <?php }if (@$pro['Bathrooms']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Bathrooms : <?php echo @$pro['Bathrooms']; ?></div>
                                                                <?php } if (@$pro['Bedrooms']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Bedrooms : <?php echo @$pro['Bedrooms']; ?></div>
                                                                <?php }if (@$pro['Area']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Area : <?php echo @$pro['Area']; ?></div>
                                                                <?php }if (@$pro['Amenities']) { ?>
                                                                    <div class="col-sm-4 col-md-3">Amenities : <?php echo @$pro['Amenities']; ?></div>
                                                            <?php } ?>
            <?php } ?>
                                                        </div>
                                                            <?php } ?>
                                                    <div class="col-sm-12">
                                                        <div class="by-user col-sm-6 padding5">
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
        <?php //echo base_url() . profile . "original/" . $pro['profile_picture'];  ?>
                                                            <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
                                                            <a href="<?php echo base_url() . 'seller/listings/' . $pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a>                                           
                                                        </div>
                                                        <div class="col-sm-6 padding5 text-right">
                                                            <a href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>" class="btn mybtn">View</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--//item-->
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
                            </div>
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
    <script>
        $('div.navigation').css({'float': 'left'});
        $('button.mybtn').click(function () {
            $(this).find('.show_number').text('<?php echo $user->phone; ?>');
        });
        $('div.content').css('display', 'block');
    </script>
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

            $.post(url, {value: fav, product_id: id}, function (response) {
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
            $.post(url, {value: val, user_id: user_id, view: "list"}, function (response)
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