<!DOCTYPE html>
<html  data-language="english" itemscope itemtype="https://schema.org/WebSite" lang="en">
    <head>
        <title><?php echo ($page_title) ? $page_title : 'Doukani'; ?></title>

        <?php
        //IOS Mobile
        if (!isset($_COOKIE['ios-appid-cookie'])) {
            setcookie('ios-appid-cookie', ios_app_id);
            $_COOKIE['ios-appid-cookie'] = ios_app_id;
            echo '<meta content="app-id=' . ios_app_id . '" name="apple-itunes-app">';
        }

        //Android Mobile
//        if (!isset($_COOKIE['android-appid-cookie'])) {
//            setcookie('android-appid-cookie', android_app_id);
//            $_COOKIE['android-appid-cookie'] = android_app_id;
//            echo '<meta name="google-play-app" content="app-id=' . android_app_id . '">';
//        } 
        ?>

        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />        
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <meta name="google-site-verification" content="oJpJlJv_8K4wnLKT6MW7dvtVn9TPGtYZL6sHZmHun_0" />
        <link href='<?php echo base_url(); ?>assets/admin/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
        <link href="<?php echo base_url(); ?>assets/front/all.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<!--        <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
        <link href="<?php echo base_url(); ?>assets/front/dist/css/bootstrap.css" rel="stylesheet">
        -->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/dist/js/all.js"></script>
<!--        <script src="<?php echo base_url(); ?>assets/front/dist/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap.min.js"></script>-->
<!--        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />-->
<!--        <link href="<?php echo base_url(); ?>assets/front/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/responsive.css" rel="stylesheet">        -->
        <!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/stylesheets/jquery.smartbanner.css" type="text/css" media="screen">-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/jquery.smartbanner.js"></script>

        <meta property="og:type" content="website" />        
        <meta name="title" content="<?= ($page_title) ? $page_title : 'Doukani' ?>">
        <meta name="Description" content="<?= (!empty($seo['description'])) ? $seo['description'] : '' ?>">
        <meta name="keyword" content="<?= (!empty($seo['keyword'])) ? $seo['keyword'] : '' ?>">

        <meta property="og:title" content="<?= ($page_title) ? $page_title : 'Doukani'; ?>"/>
        <meta property="og:url" content="<?= current_url() ?>"/>
        <meta property="og:site_name" content="Doukani"/>
        <meta property="og:description" content="<?= (!empty($seo['description'])) ? $seo['description'] : '' ?>"/>
        <meta name="twitter:card" content="summary">
        <meta name="twitter:url" content="<?= current_url() ?>" >
        <meta name="twitter:title" content="<?= ($page_title) ? $page_title : 'Doukani'; ?>">
        <meta name="twitter:description" content="<?= (!empty($seo['description'])) ? $seo['description'] : '' ?>">
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <?php $this->load->view('include/googleAnalytics'); ?>

    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">

            <?php $this->load->view('include/header'); ?>			
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <div class='col-sm-2'></div>
                        <div class='col-sm-10'>
                            <?php if ($this->session->flashdata('sub_msg1')): ?>
                                <div class='alert alert-info'>
                                    <a class='close' data-dismiss='alert' href='javascript:void(0);'>&times;</a>
                                    <?php echo $this->session->flashdata('sub_msg1'); ?>
                                </div>
                            <?php endif; ?>
                        </div>                        
                        <!--//header-->
                        <!--main-->
                        <div class=" main">
                            <div class="mainContent">
                                <!--cat-->
                                <?php $this->load->view('include/left-nav'); ?>
                                <!--//cat-->
                                <!--content-->
                                <div class="col-sm-10 ContentRight">
                                    <h4 class="web_title"><?php echo home_title; ?></h4>
                                    <div class="latest">
                                        <div class="col-sm-8 latest-ad">
                                            <?php
                                            $active1 = '';
                                            $active2 = '';

                                            if (sizeof($f_products) > 0)
                                                $active1 = 'active';

                                            if (sizeof($latest_product) > 0 && sizeof($f_products) == 0)
                                                $active2 = 'active';
                                            elseif (sizeof($f_products) == 0)
                                                $active2 = 'active';
                                            ?>
                                            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="<?php echo $active1; ?>">
                                                    <a href="<?php
                                                    if ($active1 == 'active')
                                                        echo '#featured_tab';
                                                    else
                                                        echo 'javascript:void(0);';
                                                    ?>"  role="tab" data-toggle="tab" style="<?php if ($active1 == '') echo 'color:gray;pointer-events:none;'; ?>"  rel="nofollow" >
                                                        <h3 class="tab_label">Featured Ads</h3>
                                                    </a>
                                                </li>
                                                <li role="presentation" class="<?php echo $active2; ?>">
                                                    <a href="<?php
                                                    if (sizeof($latest_product) > 0)
                                                        echo '#latest_tab';
                                                    else
                                                        echo 'javascript:void(0);';
                                                    ?>" role="tab" data-toggle="tab"  rel="nofollow" >
                                                        <h3>Latest Posted Items</h3>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane <?php echo $active1; ?>" id="featured_tab">
                                                    <div id="owl-demo1" class="owl-carousel">
                                                        <?php foreach ($f_products as $pro) { ?>
                                                            <div class="item ">
                                                                <div class="col-sm-12">
                                                                    <div class="item-sell featured-sell">
                                                                        <div class="item-img-outer">
                                                                            <div class="ribbon_main">
                                                                                <div class="red_ribbon"></div>
                                                                                <div class="item-img">
                                                                                    <?php if ($pro['product_is_sold'] == 1) { ?>
                                                                                        <div class="sold"><span>SOLD</span></div>
                                                                                        <?php
                                                                                    }
                                                                                    if ($pro['product_image'] != '') {
                                                                                        ?>                                    
                                                                                        <a href="<?php echo base_url() . $pro['product_slug']; ?>"  rel="nofollow" ><img src="<?php echo thumb_start_grid_featured_latest . base_url() . product . "medium/" . $pro['product_image'] . thumb_end_grid_featured_latest; ?>" alt="<?php echo $pro['product_name']; ?>" class="img-responsive  lastet_adss" onerror="this.src='<?php echo thumb_start_grid_featured_latest . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_featured_latest; ?>'" /></a>
                                                                                    <?php } else { ?>
                                                                                        <a href="<?php echo base_url() . $pro['product_slug']; ?>"  rel="nofollow" ><img src="<?php echo thumb_start_grid_featured_latest . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_featured_latest; ?>"  alt="<?php echo $pro['product_name']; ?>" class="img-responsive " onerror="this.src='<?php echo thumb_start_grid_featured_latest . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_featured_latest; ?>'" /></a>
                                                                                    <?php } ?>

                                                                                </div>
                                                                                <div class="function-icon">
                                                                                    <?php
                                                                                    if ($loggedin_user != $pro['product_posted_by']) {
                                                                                        if ($pro['product_is_sold'] != 1) {
                                                                                            if ($is_logged != 0) {
                                                                                                $favi = (int) $pro['my_favorite'];
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
                                                                                                $like = (int) $pro['my_like'];
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
                                                                        </div>
                                                                        <div class="item-disc">
                                                                            <a style="text-decoration: none;" href="<?php echo base_url() . '/' . $pro['product_slug']; ?>">
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
                                                                            <div class="by-user">
                                                                                <?php
                                                                                $profile_picture = '';

                                                                                $profile_picture = $this->dbcommon->load_picture($pro['profile_picture'], $pro['facebook_id'], $pro['twitter_id'], $pro['username'], $pro['google_id']);
                                                                                ?>
                                                                                <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" alt="Profile Image" />
                                                                                <a href="<?php echo base_url() . emirate_slug . $pro['user_slug']; ?>"><?php echo $pro['username1']; ?></a>                                            					 
                                                                            </div>
                                                                            <div class="price">
                                                                                <span>AED <?php echo number_format($pro['product_price']); ?></span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="count-img">
                                                                            <i class="fa fa-image"></i><span><?php echo $pro['MyTotal']; ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="customNavigation">
                                                        <a class="prev" id="demo1_prev"  rel="nofollow" ></a>
                                                        <a class="next" id="demo1_next"  rel="nofollow" ></a>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane <?php echo $active2; ?>" id="latest_tab">
                                                    <?php if (sizeof($latest_product) > 0) { ?>
                                                        <div id="owl-demo2" class="owl-carousel">
                                                            <?php $this->load->view('home/latest_products_grid_view'); ?>
                                                        </div>
                                                        <div class="customNavigation">
                                                            <a class="prev" id="demo2_prev" rel="nofollow" ><span class="fa fa-chevron-circle-left"></span></a>
                                                            <a class="next" id="demo2_next" rel="nofollow" ><span class="fa fa-chevron-circle-right"></span></a>
                                                        </div>
                                                    <?php } else { ?>                                     
                                                        <p>&nbsp;No results found.</p>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="ad-banner-square home_sidebar_banner">
                                                <?php
                                                if (!empty($feature_banners)) {
                                                    $feature_banner_url = '';
                                                    if (!empty($feature_banners[0]['site_url'])) {
                                                        if (strpos($feature_banners[0]['site_url'], 'http://') !== false || strpos($feature_banners[0]['site_url'], 'https://') !== false) {
                                                            $feature_banner_url = 'href="' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                        } else {
                                                            $feature_banner_url = 'href="http://' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                        }
                                                    }
                                                    if ($feature_banners[0]['ban_txt_img'] == 'image') {
                                                        ?>
                                                        <a <?php echo $feature_banner_url; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" rel="nofollow" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner"  /></a>
                                                        <?php
                                                    } elseif ($feature_banners[0]['ban_txt_img'] == 'text') {
                                                        ?>
                                                        <a <?php echo $feature_banner_url; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" rel="nofollow">
                                                            <div class="">
                                                                <?php
                                                                echo $feature_banners[0]['text_val'];
                                                                ?>
                                                            </div>
                                                        </a>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($between_banners1)) { ?>
                                        <div class="LeftFullWidthAdd ad-banner1">                              
                                            <?php
                                            $this->load->view('home/between_banner_update');
                                            $between_banners1_url = '';
                                            if (!empty($between_banners1[0]['site_url'])) {
                                                if (strpos($between_banners1[0]['site_url'], 'http://') !== false || strpos($between_banners1[0]['site_url'], 'https://') !== false) {
                                                    $between_banners1_url = 'href="' . $between_banners1[0]['site_url'] . '" target="_blank"';
                                                } else {
                                                    $between_banners1_url = 'href="http://' . $between_banners1[0]['site_url'] . '" target="_blank"';
                                                }
                                            }
                                            if ($between_banners1[0]['ban_txt_img'] == 'image') {
                                                ?>
                                                <a <?php echo $between_banners1_url; ?> onclick="javascript:update_count('<?php echo $between_banners1[0]['ban_id']; ?>')" rel="nofollow"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $between_banners1[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner"  /></a>
                                            <?php } elseif ($between_banners1[0]['ban_txt_img'] == 'text') {
                                                ?>
                                                <a <?php echo $between_banners1_url; ?> onclick="javascript:update_count('<?php echo $between_banners1[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" rel="nofollow">
                                                    <div class="">
                                                        <?php
                                                        echo $between_banners1[0]['text_val'];
                                                        ?>
                                                    </div>
                                                </a>
                                            <?php } ?>                                            
                                        </div>
                                    <?php } ?>
                                    <!--//ad block-->
                                    <!--//row-->
                                    <!--Most Viewed product items-->
                                    <div class="row most-viewed" id="product_loads">
                                        <div id="most-viewed">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 MostViewsHedding">
                                                <h3>Most Viewed Ads</h3>
                                            </div>
                                            <?php $this->load->view('home/product_grid_view'); ?>
                                        </div>
                                        <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                        <?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_homedata();" id="load_product" value="0">Load More</button><br><br><br/>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <!--End Most Viewed product items-->
                                </div>
                                <!--//content-->
                            </div>
                        </div>
                    </div>
                    <!--//main-->
                </div>
            </div>
            <!--//body-->
            <!--footer-->
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/plugins/validate/jquery.validate.min.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/plugins/validate/additional-methods.js"></script>
            <div id="web_desc" class="web_desc">
                <h6>Doukani is a one stop platform that brings all the buyers and sellers together. Your search for free advertising sites ends here. From luxury cars to super bikes to real estate, you can find it all here. And the best part is that we are among the most trusted free ad posting sites in UAE.</h6>

                <h6>If you are looking for a website where you can post free classified ads, Doukani is your true friend. You just need to create an account with us, and post your add for free.</h6>

                <h6>We are serving people residing in Dubai, Abu Dhabi, Al Ain, Fujairah, Ras Al-Khaimah, Sharjah and Umm Al-Quwainn.</h6>

                <h6>If you are looking to put up a feature ad (paid service), Doukani is the most trusted name online. You can also buy or sell mobile phones and tablets of all the leading brands on Doukani, one of the most genuine and reliable classifieds UAE has to offer.</h6>
            </div>

            <?php $this->load->view('include/footer'); ?>
            <!--//footer-->
        </div>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/owl.carousel.js"></script>
        <script type="text/javascript">
                                                $(document).ready(function () {
                                                    var w = $('.header-banner').width();

                                                    var carousel = $("#owl-demo");
                                                    carousel.owlCarousel({
                                                        navigation: true,
                                                        navigationText: [
                                                            "<i class='icon-chevron-left icon-white'><</i>",
                                                            "<i class='icon-chevron-right icon-white'>></i>"
                                                        ],
                                                    });


                                                    //featured ads
                                                    var owl = $("#owl-demo1");
                                                    owl.owlCarousel({
                                                        autoPlay: 2000,
                                                        items: 3,
                                                        navigation: true,
                                                        itemsDesktop: [1000, 2],
                                                        itemsDesktopSmall: [900, 2],
                                                        itemsTablet: [600, 1],
                                                        itemsMobile: false,
                                                        stopOnHover: true
                                                    });

                                                    $("#demo1_next").click(function () {
                                                        owl.trigger('owl.next');
                                                    })
                                                    $("#demo1_prev").click(function () {
                                                        owl.trigger('owl.prev');
                                                    })

                                                    //latest ads
                                                    var owl1 = $("#owl-demo2");
                                                    owl1.owlCarousel({
                                                        autoPlay: 2000,
                                                        items: 3,
                                                        navigation: true,
                                                        itemsDesktop: [1000, 2],
                                                        itemsDesktopSmall: [900, 2],
                                                        itemsTablet: [600, 1],
                                                        itemsMobile: false,
                                                        stopOnHover: true
                                                    });

                                                    $("#demo2_next").click(function () {
                                                        owl1.trigger('owl.next');
                                                    })
                                                    $("#demo2_prev").click(function () {
                                                        owl1.trigger('owl.prev');
                                                    })
                                                });

                                                $('#myTabs a').click(function (e) {
                                                    e.preventDefault()
                                                    $(this).tab('show')
                                                })

                                                function update_count(a) {
                                                    var url = "<?php echo base_url(); ?>home/update_click_count";
                                                    $.post(url, {ban_id: a}, function (response)
                                                    {
                                                    }, "json");
                                                }

                                                function load_more_homedata() {

                                                    $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                                                    $('#load_product').prop('disabled', true);
                                                    var load_more_status = $('#load_more_status').val();

                                                    var url = "<?php echo base_url(); ?>home/show_more_product";
                                                    var start = $("#load_product").val();
                                                    start++;

                                                    $("#load_product").val(start);
                                                    var val = start;
                                                    if (load_more_status == 'false') {

                                                        var req_numItems = $(document).find('.home_items').length;

                                                        $.post(url, {value: val, req_numItems: req_numItems, state_id_selection: state_id_selection}, function (response)
                                                        {
                                                            $('#load_more_status').val(response.val);
                                                            $("#load_more").before(response.html);

                                                            var after_numItems = $(document).find('.home_items').length;
                                                            if (!response.show_button) {
                                                                $("#load_product").hide();
                                                                $(window).unbind('scroll', bindScroll);
                                                            } else
                                                                $(window).bind('scroll', bindScroll);

                                                            $('#load_product').prop('disabled', false);
                                                            $("#load_product").html('Load More');

                                                        }, "json");
                                                    }
                                                }

                                                // var tw = $('.featured_Ads').width();
                                                // alert(tw);
                                                $(function () {
                                                    $.smartbanner({
                                                        appStoreLanguage: 'us',
                                                        title: 'Doukani',
                                                        author: 'Doukani',
                                                        button: 'VIEW',
                                                        store: {
                                                            ios: 'On the App Store',
                                                            android: 'In Google Play'
                                                        },
                                                        price: {
                                                            ios: 'FREE',
                                                            android: 'FREE'
                                                        }
                                                    });
                                                });

        </script>
    </body>
</html>