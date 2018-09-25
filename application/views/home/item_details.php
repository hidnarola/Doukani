<!DOCTYPE html>
<html lang="en">
    <head>        
        <?php
        $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
        ?>
        <?php $this->load->view('include/head'); ?>
        <style>
            .image-wrapper.current a img[alt="undefined"]{ display:none !important;}
            #video_div > iframe,
            #video_div > video { height: 340px; left: auto; margin: -170px 0 0; position: absolute; top: 50%; width: 100% !important;}
            ul.thumbs video{height: 150px;}
        </style>
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="Doukani" />
        <meta property="og:title" content="<?= (!empty($seo['title'])) ? $seo['title'] : (isset($page_title)) ? $page_title : ''; ?>" />
        <meta property="og:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:image" content="<?php echo $share_url; ?>" />
        <?php
        $old = array('<br>', '"');
        $new = array(' ', ' ');
        $new_desc = str_replace($old, $new, $description_);
        ?>

        <meta property="og:description" content="<?= (!empty($seo['description'])) ? preg_replace('#<[^>]+>#', ' ', str_replace($old, $new, $seo['description'])) : '' ?>" />
        <meta name="description" content="<?= (!empty($seo['description'])) ? preg_replace('#<[^>]+>#', ' ', str_replace($old, $new, $seo['description'])) : '' ?>" />
        <meta name="keyword" content="<?php echo $keyword_; ?>" />

        <meta content="article" property="og:type" />
        <meta content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" property="og:url">

        <meta content="summary" name="twitter:card" />
        <meta content="doukaniapp" name="twitter:site" />
        <meta content="<?php echo $product->product_name; ?>" name="twitter:title" />
        <meta name="twitter:text:description" content="<?= (!empty($seo['description'])) ? preg_replace('#<[^>]+>#', ' ', str_replace($old, $new, $seo['description'])) : '' ?>" />
        <meta content="<?php echo $share_url; ?>" name="twitter:image" />

        <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/front/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/front/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/front/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />   
        <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/image_slider/jssor.slider.mini.js"></script>
        <script type="text/javascript">
            document.write('<style>.noscript { display: none; }</style>');
        </script>    
        <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <?php
        $product_latitude = '';
        $product_longitude = '';

        if ($product->latitude != '' && $product->longitude != '') {
            $product_latitude = $product->latitude;
            $product_longitude = $product->longitude;
            $zoom = 14;
        } else {
            $product_latitude = $product->state_latitude;
            $product_longitude = $product->state_longitude;
            $zoom = 14;
        }
        ?>

        <input  data-zoom="<?php echo $zoom; ?>" data-latitude="latitude1" data-longitude="longitude1" data-type="googleMap" data-map_id="map1" data-lat="<?= $product_latitude; ?>" data-lang="<?= $product_longitude; ?>" data-input_id="google_input1" id="google_input1" type="hidden" class="textfield form-control" value="<?= $product->address; ?>" name="address"   />
        <input data-type="latitude1" type="hidden" name="latitude" value="<?= $product_latitude; ?>" />
        <input data-type="longitude1" type="hidden" name="longitude" value="<?= $product_longitude; ?>"/>
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
            //echo $youtube_url;
            $you = strchr($youtube_url, "https://www.youtube.com");
        }
        ?>

        <!--container-->
        <div class="container-fluid">
            <!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
            <!--//ad1 header-->
            <!--menu-->
            <?php $this->load->view('include/menu'); ?>
            <!--//menu-->
            <!--body-->
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main category-grid">
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat--><!--content-->
                            <div class="col-sm-9 ContentRight ProducstdetailsOuter" itemscope itemtype="https://schema.org/Product">
                                <?php if ($this->session->userdata('send_msg') != '') { ?>
                                    <div class='alert  alert-info alert-dismissable'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $this->session->userdata('send_msg'); ?>
                                    </div>
                                <?php } ?>

                                <?php $this->session->unset_userdata('send_msg'); ?>
                                <!--row-->
                                <div class="row subcat-div">
                                    <div class="col-sm-12">
                                        <?php $this->load->view('include/breadcrumb'); ?>
                                        <span class="result" itemprop="name"><?php echo $product->product_name; ?> details</span>
                                    </div>
                                </div>
                                <div class="detail-block white">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="prod-title">
                                                <h3 class="prod-name"><?php echo $product->product_name; ?></h3>
                                                <p class="item-by">
                                                    <?php
                                                    $profile_picture = '';

                                                    $profile_picture = $this->dbcommon->load_picture($product->profile_picture, $product->facebook_id, $product->twitter_id, $product->username, $product->google_id);
                                                    ?>
                                                    <a href="<?php echo base_url() . emirate_slug . $product->user_slug; ?>">
                                                        By <img class="img-circle" src="<?php echo $profile_picture; ?>" alt="Profile Image"  /> <?php echo $product->username1; ?> 
                                                    </a>
                                                </p>
                                            </div>

                                            <div class="images">
                                                <div class="slider-thumbs">
                                                    <div id="slider1_container" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 800px; height: 456px; overflow: hidden; visibility: hidden;">
                                                        <!-- Loading Screen -->
                                                        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                                                            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                                                            <div style="position:absolute;display:block;top:0px;left:0px;width:100%;height:100%;"></div>
                                                        </div>
                                                        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 800px; height: 356px; overflow: hidden;">
                                                            <?php
                                                            $image_status = 0;
                                                            if ($cover_img != '') {
                                                                $image_status = 1;
                                                                //for thumbnail 
                                                                $coversmall = base_url() . 'assets/upload/No_Image.png';
                                                                $covermed_img = document_root . product . 'small/' . $cover_img;
                                                                if (!empty($covermed_img)) {
                                                                    $coversmall = base_url() . product . 'small/' . $cover_img;
                                                                }
                                                                //for screen image
                                                                $cover = base_url() . 'assets/upload/NoImage_itemdetails.png';
                                                                $cover_img1 = document_root . product . 'product_detail/' . $cover_img;
                                                                if (!empty($cover_img1)) {
                                                                    $cover = base_url() . product . 'product_detail/' . $cover_img;
                                                                }
                                                                //for original image
                                                                $original = base_url() . 'assets/upload/NoImage_itemdetails.png';
                                                                $original_img = document_root . product . 'original/' . $cover_img;
                                                                if (!empty($original_img)) {
                                                                    $original = base_url() . product . 'original/' . $cover_img;
                                                                }
                                                                ?>
                                                                <div data-p="144.50" style="display: none;">
                                                                    <a data-name="2" class="fancybox-thumb" rel="Image" href="<?php echo $original; ?>" title="Cover Image">
                                                                        <img data-name="1" data-u="image" src="<?php echo item_details_image_start . $cover . item_details_image_end; ?>" onError="this.src='<?php echo item_details_image_start . base_url(); ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>'" id="cover_image" alt="<?php echo $product->product_name; ?>" />                                          
                                                                    </a>
                                                                    <img data-name="3" data-u="thumb" src="<?php echo thumb_start_small . $coversmall . thumb_end_small; ?>" onError="this.src='<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>'" alt="<?php echo $product->product_name; ?>"  />
                                                                </div>
                                                            <?php } ?>      
                                                            <?php
                                                            if ($product_video != '') {
                                                                $image_status = 1;
                                                                $vimg = base_url() . 'assets/upload/No_Image.png';
                                                                $video_img = document_root . product . 'video_image/' . $product_videoimg;
                                                                if (!empty($video_img)) {
                                                                    $vimg = base_url() . product . 'video_image/' . $product_videoimg;
                                                                }
                                                                ?>
                                                                <div data-p="144.50" style="display: none;">
                                                                    <img data-u="thumb" src="<?php echo thumb_start_small . $vimg . thumb_end_small; ?>" onError="this.src='<?php echo thumb_start_small . base_url(); ?>assets/upload/NoImage_itemdetails.png<?php echo thumb_end_small; ?>'" alt="<?php echo $product->product_name; ?>" />               
                                                                    <video width="400" controls>
                                                                        <source src="<?php echo base_url() . product . 'video/' . $product_video; ?>" type="video/mp4" />
                                                                        <source src="<?php echo base_url() . product . 'video/' . $product_video; ?>" type="video/webm" />
                                                                        <source src="<?php echo base_url() . product . 'video/' . $product_video; ?>" type="video/ogg" />
                                                                        <source src="<?php echo base_url() . product . 'video/' . $product_video; ?>" type="application/ogg" />
                                                                        Your browser does not support HTML5 video.
                                                                    </video>
                                                                </div>
                                                            <?php } ?>
                                                            <?php
                                                            if ($youtube_link != '' && $you != '') {
                                                                $image_status = 1;
                                                                ?>
                                                                <div data-p="144.50" style="display: none;">                                
                                                                    <img data-u="thumb" src=""id="video123" alt="Image" />                                              
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
                                                                    $small_img = base_url() . 'assets/upload/No_Image.png';
                                                                    if (!empty($filename1)) {
                                                                        $small_img = base_url() . product . 'small/' . $pro;
                                                                    }

                                                                    $filename = document_root . product . 'product_detail/' . $pro;
                                                                    $medimg = base_url() . 'assets/upload/NoImage_itemdetails.png';
                                                                    if (!empty($filename)) {
                                                                        $medimg = base_url() . product . 'product_detail/' . $pro;
                                                                    }

                                                                    $filename = document_root . product . 'original/' . $pro;
                                                                    $original = base_url() . 'assets/upload/NoImage_itemdetails.png';
                                                                    if (!empty($filename)) {
                                                                        $original = base_url() . product . 'original/' . $pro;
                                                                    }
                                                                    ?>                        
                                                                    <div data-p="144.50" style="display: none;">                                
                                                                        <a class="fancybox-thumb" rel="Image"  href="<?php echo $original; ?>" title="Image #<?php echo $i; ?>">
                                                                            <img data-u="image" src="<?php echo item_details_image_start . $medimg . item_details_image_end; ?>" alt="" onError="this.src='<?php echo item_details_image_start . base_url(); ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>'" id="cover_image" alt="<?php echo $product->product_name; ?>" />
                                                                        </a>
                                                                        <img data-u="thumb" src="<?php echo thumb_start_small . $small_img . thumb_end_small; ?>" onError="this.src='<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>'" alt="<?php echo $product->product_name; ?>"  />
                                                                    </div>
                                                                    <?php
                                                                    $j++;
                                                                    $i++;
                                                                }
                                                            }
                                                            if ($image_status == 0) {
                                                                ?>

                                                                <div data-p="144.50" style="display: none;">                                
                                                                    <a class="fancybox-thumb" rel="Image"  href="<?php echo base_url() . 'assets/upload/NoImage_itemdetails.png'; ?>" title="No Image">
                                                                        <img data-u="image" src="<?php echo item_details_image_start . base_url(); ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>" alt="" onError="this.src='<?php echo item_details_image_start . base_url(); ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>'" id="" alt="<?php echo $product->product_name; ?>" />
                                                                    </a>
                                                                    <img data-u="thumb" src="<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>" onError="this.src='<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>'" alt="<?php echo $product->product_name; ?>"  />
                                                                </div>

                                                            <?php } ?>
                                                        </div>
                                                        <!-- Thumbnail Navigator -->
                                                        <div data-u="thumbnavigator" class="jssort01" style="position:absolute;left:0px;bottom:0px;width:800px;height:100px;" data-autocenter="1">
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
                                                        <span data-u="arrowleft" class="jssora05l" style="top:158px;left:8px;width:40px;height:40px;"></span>
                                                        <span data-u="arrowright" class="jssora05r" style="top:158px;right:8px;width:40px;height:40px;"></span>        
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="side-data" >
                                                <div class="prod-data">
                                                    <div class="action-wrap" >
                                                        <?php if ($product->product_price != '' && (int) $product->product_price != 0) { ?>
                                                            <div class="price-block" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                                                                <span class="sell_lbl">Selling Price:</span> 
                                                                <span itemprop="priceCurrency" content="AED">AED </span>
                                                                <span itemprop="price" content="<?php echo $product->product_price; ?>"><?php echo number_format($product->product_price); ?></span>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($product_is_sold == 0 && $product->product_is_inappropriate == 'Approve' && $product->product_deactivate == NULL) { ?>
                                                            <button class="btn black-btn " onclick="show_number();"><span class="show_number" > Show Number</span></button>
                                                            <?php
                                                        } else {
                                                            if ($product_is_sold == 1) {
                                                                echo "<p class='sold_message'><i class='fa fa-check-circle' aria-hidden='true'></i> Item Sold</p>";
                                                            } else {
                                                                echo "<p class='expired_message'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> AD Expired</p>";
                                                            }
                                                        }
                                                        ?>
                                                        <?php
                                                        if (isset($user_agree) && $user_agree == 0) {
                                                            if ($is_logged != 0 && $user_status == 'yes') {
                                                                
                                                            } else {
                                                                if ($product->product_is_inappropriate == 'Approve' && $product->product_deactivate == NULL) {
                                                                    ?>
                                                                    <button class="btn red-btn <?php if ($is_logged != 0 && $user_status == 'yes') echo 'disabled'; ?> " data-toggle="modal" id="reply_btn">Reply to Ad</button>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                    <br>
                                                    <div class="extra-info" itemprop="additionalProperty" class="row" itemscope itemtype="https://schema.org/PropertyValue">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <tbody>
                                                                    <tr style="color:#9197a3;">
                                                                        <td><span>Posted On:</span></td>
                                                                        <td><?php echo $posted_on; ?></td>

                                                                    </tr>
                                                                    <tr>
                                                                        <th class="param-label" itemprop="name">Category</th>
                                                                        <td class="param-values" itemprop="value">
                                                                            <?php
                                                                            echo str_replace('\n', " ", $product->catagory_name);
                                                                            if ($product->sub_category_id != '' || $product->sub_category_id != null) {
                                                                                ?>
                                                                                <?php echo ' - ' . str_replace('\n', " ", $product->sub_category_name); ?>
                                                                            <?php } ?>    
                                                                        </td>
                                                                    </tr>        
                                                                    <?php if (isset($product->vehicle_features)) { ?>
                                                                        <?php if ($product->vehicle_features->bname != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Brand</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->bname; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->vehicle_features->mname != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Model</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->mname; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->vehicle_features->mileagekm != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Mileage</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->mileagekm; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->vehicle_features->colorname != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Color</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->colorname; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->vehicle_features->type_of_car != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Type Of Car</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->type_of_car; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->vehicle_features->year != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Year</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->year; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->vehicle_features->make != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Make</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->make; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->vehicle_features->vehicle_condition != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Condition</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->vehicle_condition; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                    <?php if (isset($product->realestate_features)) { ?>
                                                                        <?php if ($product->realestate_features->Emirates != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Emirates</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->realestate_features->Emirates; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->realestate_features->PropertyType != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Property Type</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->realestate_features->PropertyType; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->realestate_features->Bedrooms != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Bedrooms</th>
                                                                                <td class="param-values" itemprop="value"><?php
                                                                                    if ((int) $product->realestate_features->Bedrooms == '-1')
                                                                                        echo 'More than 10';
                                                                                    else
                                                                                        echo $product->realestate_features->Bedrooms;
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->realestate_features->Bathrooms != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Bathrooms</th>
                                                                                <td class="param-values" itemprop="value"><?php
                                                                                    if ((int) $product->realestate_features->Bathrooms == '-1')
                                                                                        echo 'More than 10';
                                                                                    else
                                                                                        echo $product->realestate_features->Bathrooms;
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>                                       
                                                                        <?php if ($product->realestate_features->Area != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Area</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->realestate_features->Area; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->realestate_features->Amenities != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Amenities</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->realestate_features->Amenities; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->realestate_features->furnished != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Furnished</th>
                                                                                <td class="param-values" itemprop="value"><?php echo ($product->realestate_features->furnished != "0") ? ucfirst($product->realestate_features->furnished) : '-'; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                        <?php if ($product->realestate_features->pets != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Pets</th>
                                                                                <td class="param-values" itemprop="value"><?php echo ($product->realestate_features->pets != "0") ? ucfirst($product->realestate_features->pets) : '-'; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?>

                                                                    <?php if (isset($product->car_number)) { ?>
                                                                        <?php if ($product->car_number->car_number != '') { ?>
                                                                            <tr style="color:#ed1b33;">
                                                                                <th class="param-label" itemprop="name"><b>Car Number</b></th>
                                                                                <td class="param-values" itemprop="value"><b><?php echo $product->car_number->car_number; ?></b></td>
                                                                            </tr>
                                                                        <?php } ?>                                            
                                                                        <?php if ($product->car_number->plate_source_name != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Plate Source</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->car_number->plate_source_name; ?></td>
                                                                            </tr>
                                                                        <?php } ?>

                                                                        <?php if ($product->car_number->plate_prefix != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Plate Prefix</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->car_number->plate_prefix; ?></td>
                                                                            </tr>
                                                                        <?php } ?>

                                                                        <?php if ($product->car_number->plate_digit != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Plate Digit</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->car_number->plate_digit; ?></td>
                                                                            </tr>
                                                                        <?php } ?>

                                                                        <?php if ($product->car_number->car_repeating_number != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Repeating Number</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->car_number->car_repeating_number; ?></td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    <?php } ?> 

                                                                    <?php if (isset($product->mobile_number)) { ?>
                                                                        <?php if ($product->mobile_number->mobile_operator != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Mobile Operator</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->mobile_number->mobile_operator; ?></td>
                                                                            </tr>
                                                                        <?php } ?>

                                                                        <?php if ($product->mobile_number->car_repeating_number != '') { ?>
                                                                            <tr>
                                                                                <th class="param-label" itemprop="name">Repeating Number</th>
                                                                                <td class="param-values" itemprop="value"><?php echo $product->mobile_number->car_repeating_number; ?></td>
                                                                            </tr>
                                                                        <?php } ?>

                                                                        <?php if ($product->mobile_number->mobile_number != '') { ?>
                                                                            <tr style="color:#ed1b33;">
                                                                                <th class="param-label" itemprop="name"><b>Mobile Number</b></th>
                                                                                <td class="param-values" itemprop="value"><b><?php echo $product->mobile_number->mobile_number; ?><b></td>
                                                                                            </tr>
                                                                                        <?php } ?>                                           
                                                                                    <?php } ?> 
                                                                                    <?php if ($product->address != '') { ?>
                                                                                        <tr> 
                                                                                            <th  class="param-label" itemprop="name">Address</th>                                                   
                                                                                            <td class="param-values" itemprop="value"><?php echo $product->address; ?></td>
                                                                                        </tr>
                                                                                    <?php } ?>
                                                                                    </tbody>
                                                                                    </table>
                                                                                    </div>
                                                                                    <div class="detail-ad ad-banner-square pull-right m-none">
                                                                                        <?php
                                                                                        if (!empty($feature_banners)) {
                                                                                            $feature_banners_url_1 = '';
                                                                                            if (!empty($feature_banners[0]['site_url'])) {
                                                                                                if (strpos($feature_banners[0]['site_url'], 'http://') !== false || strpos($feature_banners[0]['site_url'], 'https://') !== false) {
                                                                                                    $feature_banners_url_1 = 'href="' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                                                                } else {
                                                                                                    $feature_banners_url_1 = 'href="http://' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                                                                }
//                                                                                                $feature_banners_url_1 = 'href="//' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                                                            }
                                                                                            if ($feature_banners[0]['ban_txt_img'] == 'image') {
                                                                                                ?>
                                                                                                <a <?php echo $feature_banners_url_1; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" rel="nofollow"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner"  /></a>
                                                                                                <?php
                                                                                            } elseif ($feature_banners[0]['ban_txt_img'] == 'text') {
                                                                                                ?>
                                                                                                <a <?php echo $feature_banners_url_1; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" rel="nofollow">
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
                                                                                    </div>

                                                                                    <div class="desc-wrap">
                                                                                        <h4 class="sub-title">Description</h4>
                                                                                        <p itemprop="description"><?php echo $product->product_description; ?></p>
                                                                                    </div>
                                                                                    <div class="detail-ad ad-banner-square pull-right m-block">
                                                                                        <?php
                                                                                        if (!empty($feature_banners)) {
                                                                                            $feature_banners_url1 = '';
                                                                                            if (!empty($feature_banners[0]['site_url'])) {
                                                                                                $feature_banners_url1 = 'href="' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                                                            }
                                                                                            if ($feature_banners[0]['ban_txt_img'] == 'image') {
                                                                                                ?>
                                                                                                <a <?php echo $feature_banners_url1; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" rel="nofollow" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner"  /></a>
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
                                                                                                    <a data-toggle="modal" data-target="#<?php echo ($is_logged == 1) ? 'reportModal' : 'ifLoginModal' ?>" href="#"  rel="nofollow" >Report this Item.</a>
                                                                                                <?php } else { ?>
                                                                                                    <a  href="javascript:void(0);" class="disabled"  rel="nofollow" >Report this Item.</a>
                                                                                                <?php } ?>
                                                                                            </p>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                    <div id="ifLoginModal" class="modal fade" role="dialog">
                                                                                        <div class="modal-dialog">
                                                                                            <!-- Modal content-->
                                                                                            <div class="modal-content">
                                                                                                <div class="modal-header">
                                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                    <h4 class="modal-title">To Report</h4>
                                                                                                </div>
                                                                                                <div class="modal-body">
                                                                                                    <h5>You need to be logged in to reply/report this item.</h5>
                                                                                                </div>
                                                                                                <div class="modal-footer">
                                                                                                    <a href="<?php echo base_url(); ?>login" class="btn btn-success btn-md"  rel="nofollow" >Log In</a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="Products-Location">
                                                                                        <div id="map1" style="width:100%;height:300px; margin:20px 0;"></div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 share_frd"> 
                                                                                            <span class="social_label ">Share with friends </span>
                                                                                            <span class='st_facebook_large' id="facebook_btn" ></span>
                                                                                            <span class='st_twitter_large disabled'></span>
                                                                                            <span class='st_googleplus_large disabled'></span>
                                                                                        </div>
                                                                                        <div class="col-md-6 text-right view-report"> <span class="fa fa-eye blue"></span><?php echo $updated_views_count; ?> Views <span class="fa fa-flag pink"></span>                        
                                                                                            <a data-toggle="modal" data-target="#<?php echo ($is_logged == 1) ? 'reportModal' : 'ifLoginModal' ?>" href="javascript:void(0);"  rel="nofollow" >Report this Item</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    </div>
                                                                                    </div>


                                                                                    </div>
                                                                                    <div class="row most-viewed">
                                                                                        <div class="catlist">
                                                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 MostViewsHedding">
                                                                                                <h3>Related Items</h3>
                                                                                            </div>
                                                                                            <?php
                                                                                            $flag = 1;
                                                                                            if (!empty($related_product)) {
                                                                                                foreach ($related_product as $pro) {
                                                                                                    ?>
                                                                                                    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12" >
                                                                                                        <div class="item-sell <?php if (isset($pro['featured_ad']) && $pro['featured_ad'] > 0) echo 'featured-sell'; ?>">
                                                                                                            <div class="item-img-outer">
                                                                                                                <?php if (isset($pro['featured_ad']) && $pro['featured_ad'] > 0) { ?>
                                                                                                                    <div class="ribbon_main">
                                                                                                                        <div class="red_ribbon"></div> <?php } ?>
                                                                                                                    <div class="item-img">
                                                                                                                        <?php if ($pro['product_is_sold'] == 1) { ?>
                                                                                                                            <div class="sold"><span>SOLD</span></div>
                                                                                                                            <?php
                                                                                                                        }
                                                                                                                        if (isset($pro['product_image']) && $pro['product_image'] != '') {
                                                                                                                            ?>
                                                                                                                            <a href="<?php echo base_url() . $pro['product_slug']; ?>">
                                                                                                                                <img src="<?php echo thumb_start_grid . base_url() . product . "medium/" . $pro['product_image'] . thumb_end_grid; ?>" class="img-responsive" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" alt="<?php echo $product->product_name; ?>"  />
                                                                                                                            </a>
                                                                                                                        <?php } else { ?>
                                                                                                                            <a href="<?php echo base_url() . $pro['product_slug']; ?>"><img src="<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>" class="img-responsive" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" alt="<?php echo $product->product_name; ?>"  /></a>
                                                                                                                        <?php } ?>
                                                                                                                    </div>
                                                                                                                    <?php
                                                                                                                    if (isset($pro['featured_ad']) && $pro['featured_ad'] > 0) {
                                                                                                                        echo '</div>';
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                    <div class = "function-icon">
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
                                                                                                                <div class="item-disc">
                                                                                                                    <a style="text-decoration: none;" href="<?php echo base_url() . $pro['product_slug']; ?>">
                                                                                                                        <?php $len = strlen($pro['product_name']); ?>	
                                                                                                                        <h4 <?php
                                                                                                                        if ($len > 21) {
                                                                                                                            echo 'title="' . htmlentities($pro['product_name']) . '"';
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

                                                                                                                        <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" alt="Profile Image"  />
                                                                                                                        <a href="<?php echo base_url() . emirate_slug . $pro['user_slug']; ?>" title="<?php echo $pro['username1']; ?>"><?php echo $pro['username1']; ?></a>                                            
                                                                                                                    </div>

                                                                                                                    <div class=" price">                                                                                                          <span title=" <?php echo ($pro['product_price'] != '' && (int) $pro['product_price'] != 0) ? 'AED ' . number_format($pro['product_price']) : ''; ?>"><?php echo ($pro['product_price'] != '' && (int) $pro['product_price'] != 0) ? 'AED ' . number_format($pro['product_price']) : ''; ?></span>
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
                                                                                                <?php }
                                                                                                ?>
                                                                                                <!--item1-->
                                                                                                <?php if (@$hide == "false") { ?>
                                                                                                    <div class="col-sm-12 text-center" id="load_more">
                                                                                                        <button class="btn btn-blue" onclick="load_more_category();" id="load_product" value="0">Load More</button><br><br><br>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-sm-4 detail-ad ad-banner-square pull-right responsive-view">
                                                                                            <?php
                                                                                            if (!empty($feature_banners)) {
                                                                                                $feature_banners_url2 = '';
                                                                                                if (!empty($feature_banners[0]['site_url'])) {
                                                                                                    if (strpos($feature_banners[0]['site_url'], 'http://') !== false || strpos($feature_banners[0]['site_url'], 'https://') !== false) {
                                                                                                        $feature_banners_url2 = 'href="' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                                                                    } else {
                                                                                                        $feature_banners_url2 = 'href="http://' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                                                                    }
//                                                                                                    $feature_banners_url2 = 'href="//' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                                                                }
                                                                                                if ($feature_banners[0]['ban_txt_img'] == 'image') {
                                                                                                    ?>
                                                                                                    <a <?php echo $feature_banners_url2; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" rel="nofollow" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner"  /></a>
                                                                                                    <?php
                                                                                                } elseif ($feature_banners[0]['ban_txt_img'] == 'text') {
                                                                                                    ?>
                                                                                                    <a <?php echo $feature_banners_url2; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" rel="nofollow">
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
                                                                                    </div>
                                                                                    <!--//content-->
                                                                                    </div>
                                                                                    </div>
                                                                                    <!--//main-->
                                                                                    </div>
                                                                                    <!--//body-->
                                                                                    <div id="reportModal" class="modal fade" role="dialog">
                                                                                        <div class="modal-dialog ">
                                                                                            <div class="modal-content">
                                                                                                <form accept-charset="utf-8" name="formReportAds" method="post" id="formReportAds" class="form-horizontal validate-form" action="<?php echo base_url() . 'home/send_report'; ?>">
                                                                                                    <div class="modal-header">
                                                                                                        <h4 class="modal-title">What's wrong with this ad?
                                                                                                        </h4>
                                                                                                    </div>
                                                                                                    <div class="modal-body">
                                                                                                        <div style="display: none" id="formErrorMsgReport" class="alert alert-info"></div>
                                                                                                        <input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">
                                                                                                        <input type="hidden" value="<?php echo $product->product_code; ?>" name="productCode" id="productCode">
                                                                                                        <input type="hidden" value="<?php echo $product->product_name; ?>" name="productName" id="productName">
                                                                                                        <input type="hidden" value="<?php echo $product->product_posted_by; ?>" name="seller_id" id="seller_id">
                                                                                                        <input type="hidden" value="<?php echo $product->product_slug; ?>" name="product_slug" id="product_slug">
                                                                                                        <input type="hidden" value="item_details" name="request_from" id="request_from">
                                                                                                        <input type="hidden" value="<?php echo current_url(); ?>" name="redirect_url" id="redirect_url">

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
                                                                                                            <button type="submit" name="report_submit"  id="report_submit" class="btn btn-success btn-md">Submit</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div id="replyModal" class="modal fade" role="dialog">
                                                                                        <div class="modal-dialog ">
                                                                                            <div class="modal-content">
                                                                                                <form name="formReplyAds" method="post" id="formReplyAds" class="form-horizontal"  action="<?php echo site_url() . 'home/send_reply'; ?>">
                                                                                                    <input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">
                                                                                                    <input type="hidden" value="<?php echo $product->product_code; ?>" name="productCode" id="productCode">
                                                                                                    <input type="hidden" value="<?php echo $product->product_name; ?>" name="productName" id="productName">
                                                                                                    <input type="hidden" value="<?php echo $product->product_posted_by; ?>" name="seller_id" id="seller_id">
                                                                                                    <input type="hidden" value="<?php echo $product->product_slug; ?>" name="product_slug" id="product_slug">
                                                                                                    <input type="hidden" value="product_details_page" name="request_from" id="request_from">
                                                                                                    <div class="modal-header">
                                                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                        <h4 class="modal-title">Reply to Ad</h4>
                                                                                                    </div>
                                                                                                    <?php if ($is_logged != 0) { ?>
                                                                                                        <div class="modal-body">                 
                                                                                                            <div class="form-group" style="display:none;">
                                                                                                                <div class="col-xs-3">
                                                                                                                    <label class="control-label">Name *</label>
                                                                                                                </div>
                                                                                                                <div class="col-xs-9">
                                                                                                                    <input type="text" value="<?php echo $nick_name; ?>" placeholder="" name="sender_name" id="sender_name" class="form-control" readonly> 
                                                                                                                    <input type="hidden" value="<?php echo $user_id; ?>" name="sender_id" id="sender_id">
                                                                                                                    <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo current_url(); ?>" >
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="form-group" style="display:none;">
                                                                                                                <div class="col-xs-3 text-center">
                                                                                                                    <label class="control-label">Email *</label>
                                                                                                                </div>
                                                                                                                <div class="col-xs-9">
                                                                                                                    <input type="text" value="<?php echo $owner_email; ?>" placeholder="" name="sender_email" id="sender_email" class="form-control" readonly>
                                                                                                                </div>
                                                                                                            </div>                    
                                                                                                            <div class="form-group">
                                                                                                                <div class="col-xs-3 text-center reply-msg-lbl">
                                                                                                                    <label class="control-label ">Message *</label>
                                                                                                                </div>
                                                                                                                <div class="col-xs-9">
                                                                                                                    <textarea placeholder="" name ="message" id="message" class="form-control xyz" maxlength="50"></textarea>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <div class="col-sm-4 col-sm-offset-8">

                                                                                                                <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                                                                                                                <button type="submit" name="reply_submit" id="reply_submit" class="btn btn-success btn-md">Submit</button>

                                                                                                            </div>
                                                                                                        </div>
                                                                                                    <?php } else { ?>
                                                                                                        <div class="modal-body">
                                                                                                            <h5>You need to be logged in to reply for this item.</h5>
                                                                                                        </div>
                                                                                                        <div class="modal-footer">
                                                                                                            <a href="login/index" class="btn btn-success btn-md">Log In</a>
                                                                                                        </div>
                                                                                                    <?php } ?>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!--footer-->
                                                                                    </div>
                                                                                    <?php $this->load->view('include/footer'); ?>


                                                                                    <!--//footer-->
                                                                                    <!--container-->
                                                                                    <script src="<?php echo site_url(); ?>assets/front/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
                                                                                    <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
                                                                                    <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
                                                                                    <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
                                                                                    <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
                                                                                    <script type="text/javascript">
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
                                                                                                        //$SlideHeight:550,			
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
                                                                                                            $Cols: 10,
                                                                                                            $SpacingX: 8,
                                                                                                            $SpacingY: 8,
                                                                                                            $Align: 360
                                                                                                        }
                                                                                                    };

                                                                                                    var jssor_1_slider = new $JssorSlider$("slider1_container", jssor_1_options);

                                                                                                    //responsive code begin
                                                                                                    //you can remove responsive code if you don't want the slider scales while window resizing
                                                                                                    function ScaleSlider() {

                                                                                                        var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                                                                                                        if (refSize) {
                                                                                                            refSize = Math.min(refSize, 800);
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

                                                                                                    $(".image-wrapper").hide();
                                                                                                    $("#video_div").show();
                                                                                                    // We only want these styles applied when javascript is enabled
                                                                                                    $('div.navigation').css({'float': 'left'});

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
                                                                                                            message: "required"
                                                                                                        },
                                                                                                        messages: {
                                                                                                            sender_name: "Please enter name",
                                                                                                            message: "Please enter message"
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
                                                                                                $('#video123').attr("src", '<?php echo thumb_start_small; ?>' + thumb + '<?php echo thumb_end_small; ?>');
                                                                                                var thumb = Youtube.thumb("https://www.youtube.com/watch?v=" + link, 'big');
                                                                                                $("#youtube_link").attr("href", thumb);

                                                                                                function show_number() {
                                                                                                    $('.show_number').text('<?php echo ($product->phone != '') ? $product->phone : "-"; ?>');
                                                                                                }

                                                                                                $(document).on("click", "#reply_btn", function (e) {
                                                                                                    $("#<?php echo ($is_logged == 1) ? 'replyModal' : 'ifLoginModal' ?>").modal('show');
                                                                                                });
//                                                                                                $(document).on("click", ".fancybox-thumb", function (e) {
//                                                                                                    var alt = $(this).children("img").attr("alt");
//                                                                                                    $('.fancybox-image a').attr("alt", alt);
//                                                                                                    console.log('alt', alt);
//                                                                                                });
                                                                                    </script>
                                                                                    <script src="<?php echo site_url(); ?>assets/googleMap.js"></script>
                                                                                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete"
                                                                                    async defer></script>

                                                                                    </body>
                                                                                    </html>