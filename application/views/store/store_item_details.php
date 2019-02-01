<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <?php
        $protocol = 'http';
        ?>
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="Doukani" />
        <meta property="og:title" content="<?php echo $product->product_name; ?>" />
        <meta property="og:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:image" content="<?php echo $share_url; ?>" />
        <meta property="og:description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $description_); ?>" />
        <meta name="keyword" content="<?php echo $keyword_; ?>" />

        <meta content="summary" name="twitter:card">
        <meta content="doukaniapp" name="twitter:site">
        <meta name="twitter:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta name="twitter:title" content="<?php echo $product->product_name; ?>">
        <meta name="twitter:description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $description_); ?>">
        <meta content="<?php echo $share_url; ?>" name="twitter:image">
        <?php
        $product_latitude = '';
        $product_longitude = '';

        if ($product->latitude != '' && $product->longitude != '') {
            $product_latitude = $product->latitude;
            $product_longitude = $product->longitude;
        } else {
            $product_latitude = $product->state_latitude;
            $product_longitude = $product->state_longitude;
        }
        ?>

    <input  data-zoom="12" data-latitude="latitude1" data-longitude="longitude1" data-type="googleMap" data-map_id="map1" data-lat="<?= $product_latitude; ?>" data-lang="<?= $product_longitude; ?>" data-input_id="google_input1" id="google_input1" type="hidden" class="textfield form-control" value="<?= $product->address; ?>" name="address"   />
    <input data-type="latitude1" type="hidden" name="latitude" value="<?= $product_latitude; ?>">
    <input data-type="longitude1" type="hidden" name="longitude" value="<?= $product_longitude; ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo HTTPS . website_url; ?>assets/front/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo HTTPS . website_url; ?>assets/front/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
    <link rel="stylesheet" type="text/css" href="<?php echo HTTPS . website_url; ?>assets/front/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/image_slider/jssor.slider.mini.js"></script>
    <link rel="image_src" href="<?php echo $share_url; ?>" />

    <style>
        .modal-header{
            background-color:#ed1b33;
            color:white;
        }

        .jssort01-99-66 .p {
            position: absolute;
            top: 0;
            left: 0;
            width: 70px;
            height: 70px;
            /*padding-top:25px;*/
        }

        .jssort01-99-66 .t {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;            
            border: none;
        }

        .jssort01-99-66 .w {
            position: absolute;
            top: 0px;
            left: 0px;
            width: 100%;
            height: 100%;
        }

        .jssort01-99-66 .c {
            position: absolute;
            top: 0px;
            left: 0px;            
            width: 70px;
            height: 70px;
            /*border: #000 2px solid;*/
            /*box-sizing: content-box;*/
            background: url('<?php echo HTTPS . website_url . 'assets/front/images/t01.png'; ?>') -800px -800px no-repeat;
            _background: none;
        }

        .jssort01-99-66 .pav .c {
            top: 0px;
            _top: 0px;
            left: 0px;
            _left: 0px;            
            width: 70px;
            height: 70px;
            /*            border: #000 0px solid;
                        _border: #fff 2px solid;*/
            background-position: 50% 50%;
        }

        .jssort01-99-66 .p:hover .c {
            top: 0px;
            left: 0px;
            width: 70px;
            height: 70px;
            /*border: #fff 1px solid;*/
            background-position: 50% 50%;
        }

        .jssort01-99-66 .p.pdn .c {
            background-position: 50% 50%;
            width: 70px;
            height: 70px;
            border: #000 2px solid;
        }

        * html .jssort01-99-66 .c, * html .jssort01-99-66 .pdn .c, * html .jssort01-99-66 .pav .c {
            /* ie quirks mode adjust */
            width /**/: 70px;
            height /**/: 70px;

        }
        #slider1_container .jssort01-99-66 .jssort01-99-66{border-right:solid 1px #efeded;border-left:solid 1px #efeded;}
        #slider1_container .jssort01-99-66 div[data-u="slides"]{height:400px !important;top:40px !important;}
        #slider1_container .jssora05l{top:0 !important;}
        #slider1_container .jssora05r{bottom:0 !important;top:initial !important;}
        #slider1_container .jssora05r, #slider1_container .jssora05l{background:#f1f1f1;color:#999;text-align:center;}
        #slider1_container .jssora05r:hover, #slider1_container .jssora05l:hover{background:#e5e5e5;}
        #slider1_container .jssora05r .fa, #slider1_container .jssora05l .fa{line-height:40px;font-size:30px;}
        #slider1_container .fancybox-thumb > img {height: auto !important;max-height: 390px;max-width: 100%;}

        .image-wrapper.current a img[alt="undefined"]{ display:none !important;}
        #video_div > iframe,
        #video_div > video { height: 340px; left: auto; margin: -170px 0 0; position: absolute; top: 50%; width: 100% !important;}
        ul.thumbs video{height: 150px;}        
    </style>
    <script type="text/javascript">
        document.write('<style>.noscript { display: none; }</style>');
    </script>
    <script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</head>
<body>
    <?php $this->load->view('include/google_tab_manager_body'); ?>
    <script src="https://www.youtube.com/iframe_api"></script>
    <?php
    $name = '';
    if (isset($youtube_link) && $youtube_link != '') {

        function getYouTubeId($url) {
            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
            if (isset($my_array_of_vars['v'])) {
                return $my_array_of_vars['v'];
            }
        }

        $youtube_url = (string) getYouTubeId($youtube_link);
        if (isset($youtube_url) && $youtube_url != '') {
            $name = $youtube_url;
            $youtube_url = 'https://www.youtube.com/embed/' . $youtube_url;
        } else {
            $youtube_url = $youtube_link;
            $name = substr($youtube_url, strrpos($youtube_url, '/') + 1);
        }
        $you = strchr($youtube_url, "https://www.youtube.com");
    }
    ?>
    <!--container-->
    <div class="container-fluid">
        <!--ad1 header-->
        <?php $this->load->view('include/header'); ?>
        <?php $this->load->view('include/menu'); ?>        
        <div class="page">
            <div class="store-details">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>

                        <?php $this->load->view('store/store_common'); ?>

                        <div class="col-sm-12" itemscope itemtype="https://schema.org/Product">
                            <div class="detail-wrap">
                                <div class="prod-breadcrumb">
                                    <?php $this->load->view('include/breadcrumb'); ?>
                                </div>
                                <h3 class="prod-name" itemprop="name"><?php echo $product->product_name; ?></h3>

                                <?php if (isset($msg) && !empty($msg)): ?>                                        
                                    <div class="whiteBG-DIV">
                                        <div class="col-sm-12"  style="margin-top: 10px;">
                                            <div class='alert <?php echo $msg_class; ?> text-center'>
                                                <a class='close' data-dismiss='alert' href='javascript:void(0);'>&times;</a>
                                                <?php echo $msg; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>                                
                                <div class="row">
                                    <div class="col-md-7" >
                                        <div class="img-slider">
                                            <div class="slide-wrap">                                                
                                                <div class="slider-thumbs">
                                                    <div id="slider1_container" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 1000px; height: 480px; overflow: hidden; visibility: hidden; ">
                                                        <!-- Loading Screen -->
                                                        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                                                            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                                                            <div style="position:absolute;display:block;top:0px;left:0px;width:100%;height:100%;"></div>
                                                        </div>
                                                        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 160px; width: 800px; height: 480px; overflow: hidden;">
                                                            <?php
                                                            $image_status = 0;
                                                            if ($cover_img != '') {
                                                                $image_status = 1;
                                                                //for thumbnail	
                                                                $coversmall = HTTPS . website_url . 'assets/upload/No_Image.png';
                                                                $covermed_img = document_root . product . 'small/' . $cover_img;
                                                                if (!empty($covermed_img)) {
                                                                    $coversmall = HTTPS . website_url . product . 'small/' . $cover_img;
                                                                }
                                                                //for screen image
                                                                $cover = HTTPS . website_url . 'assets/upload/NoImage_itemdetails.png';
                                                                $cover_img1 = document_root . product . 'product_detail/' . $cover_img;
                                                                if (!empty($cover_img1)) {
                                                                    $cover = HTTPS . website_url . product . 'product_detail/' . $cover_img;
                                                                }
                                                                //for original image
                                                                $original = HTTPS . website_url . 'assets/upload/NoImage_itemdetails.png';
                                                                $original_img = document_root . product . 'original/' . $cover_img;
                                                                if (!empty($original_img)) {
                                                                    $original = HTTPS . website_url . product . 'original/' . $cover_img;
                                                                }
                                                                ?>
                                                                <div data-p="144.50" style="display: none;">
                                                                    <a class="fancybox-thumb" rel="Image" href="<?php echo $original; ?>" title="Cover Image">
                                                                        <img data-u="image" src="<?php echo item_details_image_start . $cover . item_details_image_end; ?>" onError="this.src='<?php echo item_details_image_start . HTTPS . website_url; ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>'"  alt="<?php echo $product->product_name; ?>"  itemprop="image"  />											 
                                                                    </a>
                                                                    <img data-u="thumb" src="<?php echo thumb_start_small_store . $coversmall . thumb_end_small_store; ?>"  onError="this.src='<?php echo thumb_start_small_store . HTTPS . website_url; ?>assets/upload/No_Image.png<?php echo thumb_end_small_store; ?>'" alt="<?php echo $product->product_name; ?>" />
                                                                </div>
                                                            <?php } ?>		
                                                            <?php
                                                            if ($product_video != '') {
                                                                $image_status = 1;

                                                                $vimg = HTTPS . website_url . 'assets/upload/No_Image.png';
                                                                $video_img = document_root . product . 'video_image/' . $product_videoimg;
                                                                if (!empty($video_img)) {
                                                                    $vimg = HTTPS . website_url . product . 'video_image/' . $product_videoimg;
                                                                }
                                                                ?>
                                                                <div data-p="144.50" style="display: none;">
                                                                    <img data-u="thumb" src="<?php echo $vimg; ?>" alt="Image" />				
                                                                    <video width="400" controls>
                                                                        <source src="<?php echo HTTPS . website_url . product . 'video/' . $product_video; ?>" type="video/mp4" />
                                                                        <source src="<?php echo HTTPS . website_url . product . 'video/' . $product_video; ?>" type="video/webm" />
                                                                        <source src="<?php echo HTTPS . website_url . product . 'video/' . $product_video; ?>" type="video/ogg" />
                                                                        <source src="<?php echo HTTPS . website_url . product . 'video/' . $product_video; ?>" type="application/ogg" />
                                                                        Your browser does not support HTML5 video.
                                                                    </video>
                                                                </div>
                                                            <?php } ?>
                                                            <?php
                                                            if ($youtube_link != '' && $you != '') {
                                                                $image_status = 1;
                                                                ?>
                                                                <div data-p="144.50" style="display: none;">
                                                                    <img data-u="thumb" src="" id="video123" alt="Image" />
                                                                    <iframe width="600" height="400" src="<?php echo $youtube_url; ?>" frameborder="0" allowfullscreen id="youtube" ></iframe>
                                                                </div>
                                                                <?php
                                                            }
                                                            if (!empty($product_images)) {
                                                                $image_status = 1;
                                                                $i = 1;
                                                                if (($youtube_link != '' && $you != '') || $product_video != '')
                                                                    $j = 2;
                                                                else
                                                                    $j = 1;
                                                                foreach ($product_images as $pro) {

                                                                    $filename1 = document_root . product . 'small/' . $pro;
                                                                    $small_img = HTTPS . website_url . 'assets/upload/No_Image.png';
                                                                    if (!empty($filename1)) {
                                                                        $small_img = HTTPS . website_url . product . 'small/' . $pro;
                                                                    }

                                                                    $filename = document_root . product . 'product_detail/' . $pro;
                                                                    $medimg = HTTPS . website_url . 'assets/upload/NoImage_itemdetails.png';
                                                                    if (!empty($filename)) {
                                                                        $medimg = HTTPS . website_url . product . 'product_detail/' . $pro;
                                                                    }

                                                                    $filename = document_root . product . 'original/' . $pro;
                                                                    $original = HTTPS . website_url . 'assets/upload/NoImage_itemdetails.png';
                                                                    if (!empty($filename)) {
                                                                        $original = HTTPS . website_url . product . 'original/' . $pro;
                                                                    }
                                                                    ?>
                                                                    <div data-p="144.50" style="display: none;">
                                                                        <a class="fancybox-thumb" rel="Image"  href="<?php echo $original; ?>" title="Image #<?php echo $i; ?>" >
                                                                            <img data-u="image" src="<?php echo item_details_image_start . $medimg . item_details_image_end; ?>" onError="this.src='<?php echo item_details_image_start . HTTPS . website_url; ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>'" alt="<?php echo $product->product_name; ?>" />
                                                                        </a>
                                                                        <img data-u="thumb" src="<?php echo thumb_start_small_store . $small_img . thumb_end_small_store; ?>"  onError="this.src='<?php echo thumb_start_small_store . HTTPS . website_url; ?>assets/upload/No_Image.png<?php echo thumb_end_small_store; ?>'" alt="<?php echo $product->product_name; ?>" />
                                                                    </div>
                                                                    <?php
                                                                    $j++;
                                                                    $i++;
                                                                }
                                                            }
                                                            if ($image_status == 0) {
                                                                ?>

                                                                <div data-p="144.50" style="display: none;">
                                                                    <a class="fancybox-thumb" rel="Image"  href="<?php echo HTTPS . website_url; ?>assets/upload/NoImage_itemdetails.png" title="No Image" >
                                                                        <img data-u="image" src="<?php echo item_details_image_start . 'assets/upload/NoImage_itemdetails.png' . item_details_image_end; ?>" alt="<?php echo $product->product_name; ?>" onError="this.src='<?php echo item_details_image_start . HTTPS . website_url; ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>'" />
                                                                    </a>
                                                                    <img data-u="thumb" src="<?php echo thumb_start_small_store . 'assets/upload/No_Image.png' . thumb_end_small_store; ?>"  onError="this.src='<?php echo thumb_start_small_store . HTTPS . website_url; ?>assets/upload/No_Image.png<?php echo thumb_end_small_store; ?>'" alt="<?php echo $product->product_name; ?>" />
                                                                </div>
                                                            <?php } ?>                                                            
                                                        </div>
                                                        <!-- Thumbnail Navigator -->
                                                        <div data-u="thumbnavigator" class="jssort01-99-66" style="position:absolute;left:0px;top:0;width:140px;height:480px;" data-autocenter="2">
                                                            <!-- Thumbnail Item Skin Begin -->
                                                            <div data-u="slides" style="cursor: default;">
                                                                <div data-u="prototype" class="p">
                                                                    <div class="w">
                                                                        <div data-u="thumbnailtemplate" class="t"></div>
                                                                    </div>
                                                                    <div class="c"></div>
                                                                </div>
                                                            </div>
                                                            <!-- Thumbnail Item Skin End -->
                                                        </div>
                                                        <!-- Arrow Navigator -->
                                                        <span data-u="arrowleft" class="jssora05l" style="top:0;left:0px;width:140px;height:40px;" data-autocenter="2"><i class="fa fa-angle-up" aria-hidden="true"></i></span>
                                                        <span data-u="arrowright" class="jssora05r" style="left:0;bottom:0;width:140px;height:40px;" data-autocenter="2"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="stock-wrap">
                                                <?php
                                                if (isset($user_data) && $user_data->user_role == 'storeUser') {
                                                    $store_d = $this->dbcommon->getstore_id($user_data->user_id);
                                                    $left_stock = $product->total_stock - $product->stock_availability;
                                                    ?>
                                                    <div class="sold-stock">
                                                        <span class="total"><?php echo ($left_stock > 0) ? $left_stock : 0; ?></span> Sold
                                                    </div>
                                                    <div class="avai-stock">
                                                        <span class="total"><?php echo ($product->stock_availability > 0) ? $product->stock_availability : 0; ?></span> In Stock
                                                    </div>                                                    
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="mo-block">
                                            <?php $this->load->view('common/product_details_datadisplay'); ?>
                                        </div>
                                        <?php if (isset($product->product_description) && !empty($product->product_description)) { ?>
                                            <div class="desc-wrap">
                                                <h4 class="sub-title">Description</h4>
                                                <p itemprop="description"><?php echo $product->product_description; ?></p>
                                            </div>
                                        <?php } ?>
                                        <div class="detail-ad ad-banner-square prod_det pull-right mo-block">
                                            <?php
                                            if (!empty($feature_banners)) {
                                                $feature_banners_url1 = '';
                                                if (!empty($feature_banners[0]['site_url'])) {
                                                    if (strpos($feature_banners[0]['site_url'], 'http://') !== false || strpos($feature_banners[0]['site_url'], 'https://') !== false) {
                                                        $feature_banners_url1 = 'href="' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                    } else {
                                                        $feature_banners_url1 = 'href="http://' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                    }
//                                                    $feature_banners_url1 = 'href="//' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                }
                                                if ($feature_banners[0]['ban_txt_img'] == 'image') {
                                                    ?>
                                                    <a <?php echo $feature_banners_url1; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')"  rel="nofollow" ><img src="<?php echo HTTPS . website_url; ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block"  alt="Banner"/></a>
                                                    <?php
                                                } elseif ($feature_banners[0]['ban_txt_img'] == 'text') {
                                                    ?>
                                                    <a <?php echo $feature_banners_url1; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" rel="nofollow">
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
                                        <div class=" warning_part warning_part">
                                            <h3><i class="glyphicon glyphicon-ban-circle"></i> Scam Warning:</h3>
                                            <p>
                                                Never wire money or financial info to a seller on the internet. For your security, all transactions should be done in person. 
                                            </p>
                                            <?php if (isset($user_agree) && $user_agree == 0) { ?>
                                                <p>
                                                    Please 
                                                    <?php if (isset($user_agree) && $user_agree == 0) { ?>
                                                        <a data-toggle="modal" data-target="#<?php echo ($is_logged == 1) ? 'reportModal' : 'ifLoginModal' ?>" href="javascript:void(0);" rel="nofollow">Report this Item.</a>
                                                    <?php } else { ?>
                                                        <a  href="javascript:void(0);" class="disabled" rel="nofollow">Report this Item.</a>
                                                    <?php } ?>
                                                </p>
                                            <?php } ?>
                                        </div>
                                        <div class="clearfix"></div>

                                        <div class="Products-Location">
                                            <div id="map1" style="width:100%;height:250px; margin:20px 0;"></div>
                                        </div>
                                        <div class="col-sm-6 share_frd store_prd_share_frd">
                                            <?php if (isset($user_agree) && $user_agree == 0) { ?>
                                                <span class="social_label ">Share with friends </span>
                                                <span class='st_facebook_large ' id="facebook_btn" ></span>
                                                <span class='st_twitter_large disabled'></span>
                                                <span class='st_googleplus_large disabled'></span>
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-6 text-right view-report"> <span class="fa fa-eye blue"></span><?php echo $updated_views_count; ?> Views <span class="fa fa-flag pink"></span>                        
                                            <a data-toggle="modal" data-target="#<?php echo ($is_logged == 1) ? 'reportModal' : 'ifLoginModal' ?>" href="javascript:void(0);" rel="nofollow">Report this Item</a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-md-5 mo-none">
                                        <?php $this->load->view('common/product_details_datadisplay'); ?>
                                    </div>                                    
                                </div>
                                <div class="">
                                    <div class="store-products-list-wrapper">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 MostViewsHedding ss2">
                                            <h3>Related Items</h3>
                                        </div>
                                        <?php
                                        $flag = 1;
                                        if (!empty($related_product)) {
                                            foreach ($related_product as $pro) {
                                                ?>
                                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                    <div class="item-sell">
                                                        <div class="item-img-outer">
                                                            <div class="item-img">
                                                                <?php if ((int) $pro['stock_availability'] <= 0) { ?>
                                                                    <div class="sold"><span>Out of stock</span></div>
                                                                    <?php
                                                                }
                                                                if (isset($pro['product_image']) && $pro['product_image'] != '') {
                                                                    ?>
                                                                    <a href="<?php echo $store_url . $pro['product_slug']; ?>"><img src="<?php echo thumb_start_grid . HTTPS . website_url . product . "medium/" . $pro['product_image'] . thumb_end_grid; ?>" class="img-responsive" onerror="this.src='<?php echo thumb_start_grid . HTTPS . website_url; ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" alt="<?php echo $product->product_name; ?>" /></a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo $store_url . $pro['product_slug']; ?>"><img src="<?php echo thumb_start_grid . HTTPS . website_url; ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>" class="img-responsive" alt="<?php echo $product->product_name; ?>"  /></a>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="function-icon">
                                                                <?php
                                                                if ($loggedin_user != $pro['product_posted_by']) {
                                                                    if ((int) $pro['stock_availability'] > 0) {
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
                                                                            <div class="star" ><a href="<?php echo HTTPS . website_url . 'login/index'; ?>">
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
                                                                            <div class="newthumb" ><a href="<?php echo HTTPS . website_url . 'login/index'; ?>">
                                                                                    <i class="fa fa-thumbs-o-up"></i>
                                                                                </a>
                                                                            </div>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                               
                                                                if ((int) $pro['stock_availability'] != 0) {
                                                                if (isset($pro['product_for']) && $pro['product_for'] == 'store'){
                                                                            ?>
                                                                                <div class="addtocart" >
                                                                                        <button data-toggle="tooltip" title="Add To Cart" class="add_to_cart_cus" type="button" id="add_to_cart_button" quantity="1" proid="<?php echo $pro['product_id']; ?>">
                                                                                            <i class="fa fa-shopping-cart <?php echo $pro['product_id']; ?>"></i>
                                                                                        </button>
                                                                                    </div>

                                                                            <?php
                                                                      }
                                                                }
                                                                ?>                                                          
                                                            </div>
                                                        </div>
                                                        <div class="item-disc">
                                                            <a style="text-decoration: none;" href="<?php echo $store_url . $pro['product_slug']; ?>">
                                                                <?php $len = strlen($pro['product_name']); ?>	
                                                                <h4 <?php
                                                                if ($len > 21) {
                                                                    echo 'title="' . $pro['product_name'] . '"';
                                                                }
                                                                ?>>
                                                                        <?php echo $pro['product_name']; ?>
                                                                </h4>
                                                            </a>
                                                            <?php
                                                            $str = str_replace('\n', " ", $pro['catagory_name']);
                                                            $len = strlen($str);
                                                            ?>
                                                            <small <?php
                                                            if ($len > 28) {
                                                                echo 'title="' . $str . '"';
                                                            }
                                                            ?>>
                                                                    <?php echo $str; ?>
                                                            </small>	
                                                        </div>
                                                        <div class="cat_grid"> 
                                                            <div class=" price">
                                                                <span title=" <?php echo ($pro['product_price'] != '' && (int) $pro['product_price'] != 0) ? 'AED ' . number_format($pro['product_price']) : ''; ?>"><?php echo ($pro['product_price'] != '' && (int) $pro['product_price'] != 0) ? 'AED ' . number_format($pro['product_price']) : ''; ?></span>

                                                            </div>

                                                        </div>
                                                        <div class="count-img">
                                                            <i class="fa fa-image"></i><span><?php echo $pro['MyTotal']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--//item1-->
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="catlist col-sm-10">
                                                <div class="TagsList">
                                                    <div class="subcats">
                                                        <div class="col-sm-12 no-padding-xs">
                                                            <div class="col-sm-12">
                                                                &nbsp;No results found
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <!--item1-->
                                        <?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_category();" id="load_product" value="0">Load More</button><br><br><br>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>                                
                            </div>
                        </div>


                    </div>
                    <!--//content-->
                </div>
            </div>
        </div>
        <!--//main-->
    </div>
    <!--//body-->
    <div id="reportModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <?php
                if (isset($store_url) && $store_url != '')
                    $mypath_ = $store_url;
                else
                    $mypath_ = base_url();
                ?>
                <form accept-charset="utf-8" name="formReportAds" method="post" id="formReportAds" class="form-horizontal validate-form" action="<?php echo $mypath_ . 'home/send_report'; ?>">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">What's wrong with this ad?
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div style="display: none" id="formErrorMsgReport" class="alert alert-info"></div>
                        <input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">
                        <input type="hidden" value="<?php echo $product->product_code; ?>" name="productCode" id="productCode">
                        <input type="hidden" value="<?php echo $product->product_name; ?>" name="productName" id="productName">
                        <input type="hidden" value="store_page" name="request_from" id="request_from">
                        <?php
                        if (isset($store_url) && $store_url != '')
                            $mypath = $store_url . '/';
                        else
                            $mypath = base_url();

                        if (strpos($mypath, after_subdomain) !== false) {
                            $data = current_url();
                            $last_data = substr($data, strpos($data, "/") - 1);
                            $redirect_url = 'http' . $last_data;
                        } else
                            $redirect_url = $_SERVER['REQUEST_URI'];
                        ?>
                        <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo $redirect_url; ?>" >
                        <div class="row">
                            <div class="col-xs-12">
                                <label>
                                    <input type="radio" name="report" value="spam" checked="">
                                    &nbsp;Spam</label>
                                (This is a Spam Ad.)
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label><input type="radio" name="report" value="fraud">&nbsp; Fraud</label>
                                (You suspect this to be a scam, illegal or fradulent. )
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label><input type="radio" name="report" value="violation">&nbsp;
                                    Policy Violation</label>
                                (Ad violates our terms &amp; conditions or other policies.)
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label><input type="radio" name="report" value="duplicate">&nbsp;
                                    Duplicate</label> (It's identical to another Ad.)
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label><input type="radio" name="report" value="inappropriate">&nbsp;
                                    Wrong Category</label> (It doesn't belong in this category.)
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <label><input type="radio" name="report" value="other">&nbsp; Other</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label class="control-label">&nbsp;Comments</label>
                                <textarea placeholder="" class="form-control" name="comments" id="comments" data-rule-required='true'></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-6 col-xs-12">&nbsp;</div>
                        <div class="col-sm-6 col-xs-12 popup-ftr-btn">
                            <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>               
                            <button type="submit" name="report_submit" class="btn btn-success btn-md">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
    <div id="replyModal" class="modal fade" role="dialog">
        <div class="modal-dialog ">
            <div class="modal-content">
                <?php
                if (isset($store_url) && $store_url != '')
                    $mypath_ = $store_url;
                else
                    $mypath_ = base_url();
                ?>
                <form name="formReplyAds" method="post" id="formReplyAds" class="form-horizontal" action="<?php echo $mypath_ . 'home/send_reply'; ?>">
                    <input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">
                    <input type="hidden" value="<?php echo $product->product_code; ?>" name="productCode" id="productCode">
                    <input type="hidden" value="<?php echo $product->product_name; ?>" name="productName" id="productName">
                    <input type="hidden" value="<?php echo $product->product_posted_by; ?>" name="seller_id" id="seller_id">
                    <input type="hidden" value="<?php echo $product->product_slug; ?>" name="product_slug" id="product_slug">
                    <input type="hidden" value="store_page" name="request_from" id="request_from">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reply to Ad</h4>
                    </div>
                    <?php if ($is_logged != 0) { ?>
                        <div class="modal-body">                                
                            <div class="form-group" style="display:none;">
                                <div class="col-xs-3 text-center">
                                    <label class="control-label">Name *</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" value="<?php echo $nick_name; ?>" placeholder="" name="sender_name" id="sender_name" class="form-control" readonly> <input type="hidden" value="<?php echo $user_id; ?>" name="sender_id" id="sender_id">
                                </div>
                            </div>
                            <div class="form-group" style="display:none;">
                                <div class="col-xs-3 text-center">
                                    <label class="control-label">Email *</label>
                                </div>
                                <div class="col-xs-9">
                                    <input type="text" value="<?php echo $owner_email; ?>" placeholder="" name="sender_email" id="sender_email" class="form-control" readonly>
                                    <?php
                                    if (strpos($mypath, after_subdomain) !== false) {

                                        $data = current_url();
                                        $last_data = substr($data, strpos($data, "/") - 1);
                                        $redirect_url = 'http' . $last_data;
                                    } else
                                        $redirect_url = $_SERVER['REQUEST_URI'];
                                    ?>
                                    <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo $redirect_url; ?>" >
                                </div>
                            </div>                                
                            <div class="form-group">
                                <div class="col-xs-3 text-center reply-msg-lbl">
                                    <label class="control-label">Message *</label>
                                </div>
                                <div class="col-xs-9">
                                    <textarea placeholder="" name ="message" id="message" class="form-control xyz" maxlength="50"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-sm-4 col-sm-offset-8">

                                <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>

                                <button type="submit" name="reply_submit" class="btn btn-success btn-md">Submit</button>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="modal-body">
                            <h5>You need to be logged in to reply for this item.</h5>
                        </div>
                        <div class="modal-footer">
                            <a href="<?php echo HTTPS . website_url . 'login/index'; ?>" class="btn btn-success btn-md">Log In</a>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content rounded">
                <div class="modal-header text-center orange-background">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
                </div>
                <div class="modal-body">
                </div>
                <div class='alert alert-info alert-dismissable'>
                    <center><span id="error_msg" ></span></center>
                </div>
            </div>
        </div>
    </div>
    <?php
    if ($product->stock_availability > 0) {
        ?>

        <div class="modal fade center" id="quantity_popup" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header orange-background">
                        <h4 class="modal-title buy_now_label" id="myModalLabel" name="buy_now_label" style="display:none;">
                            Buy Now
                        </h4>
                        <h4 class="modal-title add_to_cart_label" id="myModalLabel" name="add_to_cart_label" style="display:none;">
                            Add To Cart
                        </h4>
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                            <i class="fa fa-close"></i>
                        </button>                  
                    </div>
                    <form id="cart_form" name="cart_form" method="post">
                        <div class="modal-body">
                            <div class="">
                                <div class="col-sm-6">
                                    <?php
                                    if (empty($cover_img)) {
                                        $cover_img = HTTPS . website_url . 'assets/upload/No_Image.png';
                                        ?>
                                        <img src="<?php echo $cover_img; ?>" alt="<?php echo $product->product_name; ?>" >
                                    <?php } else { ?>
                                        <img src="<?php echo HTTP . website_url . product; ?>medium/<?php echo $cover_img; ?>" alt="<?php echo $product->product_name; ?>">
                                    <?php } ?>
                                </div>
                                <div class="col-sm-6">
                                    <div class="quantity-popup-input">
                                        <?php if (isset($delivery_option_text) && !empty($delivery_option_text)) { ?>
                                            <div>
                                                <label>Delivery Option : </label>  <?php echo $delivery_option_text; ?>
                                            </div>
                                        <?php } ?>
                                        <br>
                                        <span class="span_error" id="span_error" style="color:red;"></span>
                                        <label>Quantity</label>
                                        <select class="form-control qunatity_dropdown" id="quantity" name="quantity">
                                            <?php
                                            $i = 1;
                                            while ($i <= $product->stock_availability) {
                                                ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?> </option>
                                                <?php
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="quantity-popup-button">
                                        <input type="hidden" value="<?php echo $product->product_id; ?>" name="cart_product_id" id="cart_product_id">
                                        <input type="hidden" value="<?php echo current_url(); ?>" name="redirect_url" id="redirect_url">

                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success btn-md add_cart_btn" id="buy_now_button" name="buy_now_button" style="display:none;">Buy Now</button>
                                        <button type="button" class="btn btn-success btn-md add_cart_btn" id="add_to_cart_button" name="add_to_cart_button" style="display:none;">Add To Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>               
                </div>
            </div>
        </div>
        <?php
    }
    $this->load->view('store/store_common_div');
    $this->load->view('include/footer');
    ?>

    <!--//footer-->
    <!--container-->
    <script src="<?php echo HTTPS . website_url; ?>assets/front/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
    <script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
    <script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>        
    <script type="text/javascript">
                                                $(document).on("click", "#reply_btn", function (e) {
                                                    $("#<?php echo ($is_logged == 1) ? 'replyModal' : 'ifLoginModal' ?>").modal('show');
                                                });
                                                jQuery(document).ready(function ($) {

                                                    $(".fancybox-thumb").fancybox({
                                                        beforeShow: function () {
                                                            var imgAlt = $(this.element).find("img").attr("alt");
                                                            if (imgAlt) {
                                                                $(".fancybox-image").attr("alt", imgAlt);
                                                            }
                                                        },
                                                        padding: 0,
                                                        helpers: {
                                                            title: {
                                                                type: 'outside'
                                                            },
                                                            thumbs: {
                                                                width: 50,
                                                                height: 50
                                                            }
                                                        }

                                                    });
                                                    var jssor_1_SlideshowTransitions = [
                                                        {$Duration: 1200, x: 0.3, $During: {$Left: [0.3, 0.7]}, $Easing: {$Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: 0.3, $SlideOut: false, $Easing: {$Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: -0.3, $During: {$Left: [0.3, 0.7]}, $Easing: {$Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: 0.3, $SlideOut: true, $Easing: {$Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, y: 0.3, $During: {$Top: [0.3, 0.7]}, $Easing: {$Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, y: -0.3, $SlideOut: true, $Easing: {$Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, y: -0.3, $During: {$Top: [0.3, 0.7]}, $Easing: {$Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, y: 0.3, $SlideOut: true, $Easing: {$Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: 0.3, $Cols: 2, $During: {$Left: [0.3, 0.7]}, $ChessMode: {$Column: 3}, $Easing: {$Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: 0.3, $Cols: 2, $SlideOut: true, $ChessMode: {$Column: 3}, $Easing: {$Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, y: 0.3, $Rows: 2, $During: {$Top: [0.3, 0.7]}, $ChessMode: {$Row: 12}, $Easing: {$Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, y: 0.3, $Rows: 2, $SlideOut: true, $ChessMode: {$Row: 12}, $Easing: {$Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, y: 0.3, $Cols: 2, $During: {$Top: [0.3, 0.7]}, $ChessMode: {$Column: 12}, $Easing: {$Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, y: -0.3, $Cols: 2, $SlideOut: true, $ChessMode: {$Column: 12}, $Easing: {$Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: 0.3, $Rows: 2, $During: {$Left: [0.3, 0.7]}, $ChessMode: {$Row: 3}, $Easing: {$Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: -0.3, $Rows: 2, $SlideOut: true, $ChessMode: {$Row: 3}, $Easing: {$Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: {$Left: [0.3, 0.7], $Top: [0.3, 0.7]}, $ChessMode: {$Column: 3, $Row: 12}, $Easing: {$Left: $Jease$.$InCubic, $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, x: 0.3, y: 0.3, $Cols: 2, $Rows: 2, $During: {$Left: [0.3, 0.7], $Top: [0.3, 0.7]}, $SlideOut: true, $ChessMode: {$Column: 3, $Row: 12}, $Easing: {$Left: $Jease$.$InCubic, $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, $Delay: 20, $Clip: 3, $Assembly: 260, $Easing: {$Clip: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, $Delay: 20, $Clip: 3, $SlideOut: true, $Assembly: 260, $Easing: {$Clip: $Jease$.$OutCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, $Delay: 20, $Clip: 12, $Assembly: 260, $Easing: {$Clip: $Jease$.$InCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2},
                                                        {$Duration: 1200, $Delay: 20, $Clip: 12, $SlideOut: true, $Assembly: 260, $Easing: {$Clip: $Jease$.$OutCubic, $Opacity: $Jease$.$Linear}, $Opacity: 2}
                                                    ];

                                                    var jssor_1_options = {
                                                        $AutoPlay: false,
                                                        $SlideshowOptions: {
                                                            $Class: $JssorSlideshowRunner$,
                                                            $Transitions: jssor_1_SlideshowTransitions,
                                                            $TransitionsOrder: 1
                                                        },
                                                        $ArrowNavigatorOptions: {
                                                            $Class: $JssorArrowNavigator$
                                                        },
                                                        $ThumbnailNavigatorOptions: {
                                                            $Class: $JssorThumbnailNavigator$,
                                                            $Rows: 1,
                                                            $Cols: 6,
                                                            $SpacingX: 5,
                                                            $SpacingY: 5,
                                                            $Orientation: 2,
                                                            $Align: 156
                                                        }
                                                    };


                                                    var jssor_1_slider = new $JssorSlider$("slider1_container", jssor_1_options);

                                                    //responsive code begin
                                                    //you can remove responsive code if you don't want the slider scales while window resizing
                                                    function ScaleSlider() {

                                                        var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                                                        if (refSize) {
                                                            refSize = Math.min(refSize, 1000);
                                                            jssor_1_slider.$ScaleWidth(refSize);
                                                        } else {
                                                            window.setTimeout(ScaleSlider, 30);
                                                        }
                                                    }
                                                    ScaleSlider();
                                                    $(window).bind("load", ScaleSlider);
                                                    $(window).bind("resize", ScaleSlider);
                                                    $(window).bind("orientationchange", ScaleSlider);

                                                    //responsive code end


                                                    var w = $('.catlist .col-lg-3 .item-sell .item-img').width();
                                                    $('.catlist .col-lg-3 .item-sell .item-img a').css('width', w);
                                                    var h = $('.catlist .col-lg-3 .item-sell .item-img').height();
                                                    $('.catlist .col-lg-3 .item-sell .item-img a').css('height', h);

                                                    $(window).resize(function () {
                                                        var w = $('.catlist .col-lg-3 .item-sell .item-img').width();
                                                        $('.catlist .col-lg-3 .item-sell .item-img a').css('width', w);
                                                        var h = $('.catlist .col-lg-3 .item-sell .item-img').height();
                                                        $('.catlist .col-lg-3 .item-sell .item-img a').css('height', h);
                                                    });

                                                    //$('#video').trigger('click');
                                                    //jQuery('#video_div').click();
                                                    $(".image-wrapper").hide();
                                                    $("#video_div").show();
                                                    // We only want these styles applied when javascript is enabled
                                                    $('div.navigation').css({'float': 'left'});
                                                    $('button.mybtn').click(function () {
                                                        $(this).find('.show_number').text('<?php echo $product->phone; ?>');
                                                    });
                                                    $('div.content').css('display', 'block');

                                                    $("#formReportAds").validate({
                                                        rules: {
                                                            report: "required",
                                                            comments: "required"
                                                        },
                                                        messages: {
                                                            report: "Please select one of the options",
                                                            comments: "Please enter comments",
                                                        },
                                                        submitHandler: function (form) {
                                                            $("#reportModal").modal('hide');
                                                            form.submit();
                                                        }
                                                    });

                                                    $("#formReplyAds").validate({
                                                        rules: {
                                                            sender_name: "required",
                                                            //subject: "required",
                                                            message: "required",
                                                            sender_email: {
                                                                required: true,
                                                                email: true
                                                            }
                                                        },
                                                        messages: {
                                                            sender_name: "Please enter name",
                                                            //subject: "Please provide a subject",
                                                            message: "Please enter a message",
                                                            sender_email: {
                                                                required: "Please enter an email address",
                                                                email: "Please enter a valid email address"
                                                            }
                                                        },
                                                        submitHandler: function (form) {
                                                            form.submit();
                                                        }
                                                    });
                                                });


                                                var Youtube = (function () {
                                                    'use strict';
                                                    var video, results;

                                                    var getThumb = function (url, size) {
                                                        if (url === null) {
                                                            return '';
                                                        }
                                                        size = (size === null) ? 'big' : size;
                                                        results = url.match('[\\?&]v=([^&#]*)');
                                                        video = (results === null) ? url : results[1];

                                                        if (size === 'small') {
                                                            return 'https://img.youtube.com/vi/' + video + '/2.jpg';
                                                        }
                                                        return 'https://img.youtube.com/vi/' + video + '/0.jpg';
                                                    };
                                                    return {
                                                        thumb: getThumb
                                                    };
                                                }());
<?php if (isset($youtube_link) && $youtube_link != '') { ?>
                                                    var link = "<?php echo (string) getYouTubeId($youtube_link); ?>";
<?php } else { ?>
                                                    var link = "";
<?php } ?>

                                                var thumb = Youtube.thumb("https://www.youtube.com/watch?v=" + link, 'small');
                                                $('#video123').attr("src", thumb);
                                                var thumb = Youtube.thumb("https://www.youtube.com/watch?v=" + link, 'big');
                                                $("#youtube_link").attr("href", thumb);


                                                function show_number() {
                                                    $('.show_number').text('<?php echo $product->phone; ?>');
                                                }

                                                $('.buy_link').click(function () {

                                                    $("#quantity_popup").modal('show');
                                                    var link_id = $(this).attr('id');

                                                    $('#quantity').prop('selectedIndex', 0);

                                                    if (link_id == 'buy_now') {
                                                        var path = '<?php echo HTTPS . website_url; ?>cart/buy_now';
                                                        $('#cart_form').attr('action', path);

                                                        $('.add_to_cart_label').hide();
                                                        $('#add_to_cart_button').hide();
                                                        $('.buy_now_label').show();
                                                        $('#buy_now_button').show();
                                                    } else {

                                                        var path = '<?php echo $store_url; ?>cart/add_to_cart';
                                                        $('#cart_form').attr('action', path);

                                                        $('.buy_now_label').hide();
                                                        $('#buy_now_button').hide();
                                                        $('.add_to_cart_label').show();
                                                        $('#add_to_cart_button').show();
                                                    }
                                                });

                                                // Buy now button
                                                $('#buy_now_button').click(function () {
                                                    window.location = "<?php echo $store_url . 'cart'; ?>";
                                                });

                                                //add to cart button
                                                $('#add_to_cart_button').click(function () {
                                                    check_product_quantity();
                                                });


                                                function check_product_quantity() {

                                                    var product_id = $('#cart_product_id').val();
                                                    var quantity = $('#quantity').val();

                                                    var url = "<?php echo $store_url; ?>home/check_product_and_quantity";

                                                    $.post(url, {quantity: quantity, product_id: product_id}, function (response)
                                                    {
                                                        if (response == 'success') {
                                                            $('#span_error').hide();

                                                            var url = "<?php echo $store_url; ?>cart/add_to_cart";
                                                            var quantity = $('#quantity').val();
                                                            var cart_product_id = $('#cart_product_id').val();

                                                            $.post(url, {quantity: quantity, cart_product_id: cart_product_id}, function (response)
                                                            {
                                                                //                                    $('#cart_count').text(response);
                                                                $('.total-no').text(response);
                                                                $('.cart-li').show();
                                                            });

                                                            $("#quantity_popup").modal('hide');
                                                        } else {
                                                            if (response == 'Out of stock' || response == 'Not Available') {
                                                                $('#span_error').show();
                                                                $('#span_error').text('* ' + response);
                                                                return 0;
                                                            } else
                                                            {
                                                                $('#span_error').show();
                                                                $('#span_error').text('* ' + response + ' Available in Stock');

                                                                //reset dropdown
                                                                var availability = parseInt(response);
                                                                var i = 1;
                                                                var concat_str = '';

                                                                while (i <= availability) {
                                                                    concat_str = concat_str + '<option value="' + i + '">' + i + '</option>';
                                                                    i++;
                                                                }

                                                                $("#quantity").html(concat_str);
                                                                return 0;
                                                            }

                                                        }
                                                    });
                                                }

                                                //                                                $(document).on("click", "#reply_btn", function (e) {
                                                //                                                    $("#replyModal").modal('show');
                                                //                                                });
    </script>
    <script src="<?php echo HTTPS . website_url; ?>assets/googleMap.js"></script>
    <?php if (!isset($exclude_map)) { ?>
        <script src="<?php echo HTTPS; ?>maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete"
        async defer></script>
    <?php } ?>
</body>
</html>
<script type="text/javascript">
      $('[data-toggle="tooltip"]').tooltip();
            //add to cart button
                                                $('.add_to_cart_cus').click(function () {
                                                   var proid= $(this).attr('proid');
                                                   var qat=  $(this).attr('quantity');
                                                   console.log(proid);
                                                   console.log(qat);
                                                    check_product_quantity(proid,qat);
                                                    $("i."+proid).removeClass('fa-shopping-cart');
                                                    $("i."+proid).addClass('fa-check');
                                                });


                                                function check_product_quantity(proid,qat) {

                                                    var product_id = $('#cart_product_id').val();
                                                    var quantity = $('#quantity').val();

                                                    var url = "<?php echo $store_url; ?>home/check_product_and_quantity";

                                                    $.post(url, {quantity: qat, product_id: proid}, function (response)
                                                    {
                                                        if (response == 'success') {
                                                            $('#span_error').hide();

                                                            var url = "<?php echo $store_url; ?>cart/add_to_cart";
                                                            var quantity = $('#quantity').val();
                                                            var cart_product_id = $('#cart_product_id').val();

                                                            $.post(url, {quantity: qat, cart_product_id: proid}, function (response)
                                                            {
                                                                //                                    $('#cart_count').text(response);
                                                                $('.total-no').text(response);
                                                                $('.cart-li').show();
                                                            });
                                                          //  $("#quantity_popup").modal('hide');
                                                        } else {
                                                            if (response == 'Out of stock' || response == 'Not Available') {
                                                             //   $('#span_error').show();
                                                               // $('#span_error').text('* ' + response);
                                                                return 0;
                                                            } else
                                                            {
                                                             //   $('#span_error').show();
                                                             //   $('#span_error').text('* ' + response + ' Available in Stock');

                                                                //reset dropdown
                                                                var availability = parseInt(response);
                                                                var i = 1;
                                                                var concat_str = '';

                                                                while (i <= availability) {
                                                                    concat_str = concat_str + '<option value="' + i + '">' + i + '</option>';
                                                                    i++;
                                                                }

                                                                $("#quantity").html(concat_str);
                                                                return 0;
                                                            }

                                                        }
                                                    });
                                                }
            </script>