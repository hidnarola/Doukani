<?php
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
?>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>

        <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/front/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/front/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
        <link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/front/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />   
        <?php
        $product_latitude = '';
        $product_longitude = '';

        if ($product[0]->latitude != '' && $product[0]->longitude != '') {
            $product_latitude = $product[0]->latitude;
            $product_longitude = $product[0]->longitude;
            $zoom = 14;
        } else {
            $product_latitude = $product[0]->state_latitude;
            $product_longitude = $product[0]->state_longitude;
            $zoom = 14;
        }
        ?>

    <input  data-zoom="<?php echo $zoom; ?>" data-latitude="latitude1" data-longitude="longitude1" data-type="googleMap" data-map_id="map1" data-lat="<?= $product_latitude; ?>" data-lang="<?= $product_longitude; ?>" data-input_id="google_input1" id="google_input1" type="hidden" class="textfield form-control" value="<?= $product[0]->address; ?>" name="address"   placeholder="Enter a location" />
    <input data-type="latitude1" type="hidden" name="latitude" value="<?= $product_latitude; ?>">
    <input data-type="longitude1" type="hidden" name="longitude" value="<?= $product_longitude; ?>">

    <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/image_slider/jssor.slider.mini.js"></script>
    <link rel="image_src" href="<?php echo $share_url; ?>" />

    <script type="text/javascript">
        document.write('<style>.noscript { display: none; }</style>');
    </script>    
    <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
    <style>
        .image-wrapper.current a img[alt="undefined"]{ display:none !important;}
        #video_div > iframe,
        #video_div > video { height: 340px; left: auto; margin: -170px 0 0; position: absolute; top: 50%; width: 100% !important;}
        ul.thumbs video{height: 150px;}

        .modal-backdrop.fade.in {
            /*display:none;*/
        }	
        .modal-dialog.appup {
            /*width:400px !important;*/
        }
        button.close {
            background: transparent none repeat scroll 0 0;
            cursor: pointer;
            padding: 3px !important;
        }
        .modal-dialog {		  
            /*width: 1000px !important;*/		  
        }
        .modal-header{
            background-color:#ed1b33;
            color:white;
        }

    </style>
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
                        <div class="col-sm-9 ContentRight ProducstdetailsOuter">
                            <!--row-->
                            <div class="row subcat-div">
                                <div class="col-sm-12">
                                    <?php $this->load->view('include/breadcrumb'); ?>
                                    <span class="result"><?php echo $product[0]->product_name; ?> details</span>                               
                                </div>
                            </div>
                            <div class="detail-block white">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="prod-title">
                                            <h3 class="prod-name"><?php echo $product[0]->product_name; ?></h3>
                                            <p class="item-by">
                                                <?php
                                                $profile_picture = '';

                                                $profile_picture = $this->dbcommon->load_picture($product[0]->profile_picture, $product[0]->facebook_id, $product[0]->twitter_id, $product[0]->username, $product[0]->google_id);
                                                ?>
                                                <a href="<?php echo base_url() . $product[0]->user_slug; ?>">
                                                    By <img class="img-circle" src="<?php echo $profile_picture; ?>" alt="Profile Image" /> <?php echo $product[0]->username1; ?> 
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
                                                            $cover = base_url() . 'assets/upload/noimage_big.jpg';
                                                            $cover_img1 = document_root . product . 'product_detail/' . $cover_img;
                                                            if (!empty($cover_img1)) {
                                                                $cover = base_url() . product . 'product_detail/' . $cover_img;
                                                            }
                                                            //for original image
                                                            $original = base_url() . 'assets/upload/noimage_big.jpg';
                                                            $original_img = document_root . product . 'original/' . $cover_img;
                                                            if (!empty($original_img)) {
                                                                $original = base_url() . product . 'original/' . $cover_img;
                                                            }
                                                            ?>
                                                            <div data-p="144.50" style="display: none;">
                                                                <a class="fancybox-thumb" rel="fancybox-thumb" href="<?php echo $original; ?>" title="Cover Image">
                                                                    <img data-u="image" src="<?php echo item_details_image_start . $cover . item_details_image_end; ?>" onError="this.src='<?php echo item_details_image_start . base_url(); ?>assets/upload/No_Image.png<?php echo item_details_image_end; ?>'" id="cover_image" alt="<?php echo $product[0]->product_name; ?>"/>                                          
                                                                </a>
                                                                <img data-u="thumb" src="<?php echo thumb_start_small . $coversmall . thumb_end_small; ?>" onError="this.src='<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>'" alt="<?php echo $product[0]->product_name; ?>"/>
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
                                                                <img data-u="thumb" src="<?php echo thumb_start_small . $vimg . thumb_end_small; ?>" onError="this.src='<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>'" alt="Video Image"/>               
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
                                                                <img data-u="thumb" src=""id="video123" alt="Video Image" />                                              
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
                                                                $medimg = base_url() . 'assets/upload/noimage_big.jpg';
                                                                if (!empty($filename)) {
                                                                    $medimg = base_url() . product . 'product_detail/' . $pro;
                                                                }

                                                                $filename = document_root . product . 'original/' . $pro;
                                                                $original = base_url() . 'assets/upload/noimage_big.jpg';
                                                                if (!empty($filename)) {
                                                                    $original = base_url() . product . 'original/' . $pro;
                                                                }
                                                                ?>                        
                                                                <div data-p="144.50" style="display: none;">                                
                                                                    <a class="fancybox-thumb" rel="fancybox-thumb"  href="<?php echo $original; ?>" title="Image #<?php echo $i; ?>">
                                                                        <img data-u="image" src="<?php echo item_details_image_start . $medimg . item_details_image_end; ?>" alt="" onError="this.src='<?php echo item_details_image_start . base_url(); ?>assets/upload/No_Image.png<?php echo item_details_image_end; ?>'"/>
                                                                    </a>
                                                                    <img data-u="thumb" src="<?php echo thumb_start_small . $small_img . thumb_end_small; ?>" onError="this.src='<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>'" alt="Cover Image" />
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
                                                                    <img data-u="image" src="<?php echo item_details_image_start . base_url(); ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>" alt="" onError="this.src='<?php echo item_details_image_start . base_url(); ?>assets/upload/NoImage_itemdetails.png<?php echo item_details_image_end; ?>'" id="" alt="Image" />
                                                                </a>
                                                                <img data-u="thumb" src="<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>" onError="this.src='<?php echo thumb_start_small . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_small; ?>'" alt="Image"  />
                                                            </div>

                                                        <?php }
                                                        ?>
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


                                        <div class="side-data">                 
                                            <div class="prod-data">                        
                                                <div class="action-wrap">
                                                    <div class="price-block">
                                                        <span class="sell_lbl">Selling Price:</span> <span>AED </span><span><?php echo number_format($product[0]->product_price, 2); ?></span>
                                                    </div>   
                                                    <div class="btn-div0001">                                                                   
                                                        <a href="<?php echo site_url() . 'user/listings_edit/' . $product[0]->product_id; ?>"  class="edit_b btn btn-blue blue-btn"><i><img src="<?php echo site_url(); ?>assets/front/images/edit.png" class="item-det-edit" alt="Image"></i>&nbsp; Edit Ad</a>
                                                        <a href="javascript:void(0);"  class="edit_b btn btn-blue blue-btn" id="delet_user_ad" data-id="<?php echo $product[0]->product_id; ?>"><i><img src="<?php echo site_url(); ?>assets/front/images/delete.png"  class="item-det-del" alt="Image"></i> Delete Ad</a>
                                                    </div>
                                                    <button class="btn black-btn " onclick="show_number();"><span class="show_number" > Show Number</span></button>                        
                                                </div>                                     
                                                <div class="extra-info">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr style="color:#9197a3;">
                                                                    <td><span>Posted On:</span></td>
                                                                    <td><?php echo $posted_on; ?></td>
                                                                </tr>
                                                                <?php if (isset($delivery_option_text) && !empty($delivery_option_text)) { ?>
                                                                    <tr>
                                                                        <th>Shipping Option</th>
                                                                        <td><?php echo $delivery_option_text; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <?php if (isset($weight_text) && !empty($weight_text)) { ?>
                                                                    <tr>
                                                                        <th>Weight</th>
                                                                        <td><?php echo $weight_text; ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <tr>
                                                                    <th>Category</th>
                                                                    <td>
                                                                        <?php
                                                                        echo str_replace('\n', " ", $product[0]->catagory_name);
                                                                        if ($product[0]->sub_category_id != '' || $product[0]->sub_category_id != null) {
                                                                            ?>
                                                                            <?php echo ' - ' . str_replace('\n', " ", $product[0]->sub_category_name); ?>
                                                                        <?php } ?>    
                                                                    </td>
                                                                </tr>        
                                                                <?php if (isset($product[0]->vehicle_features)) { ?>
                                                                    <?php if ($product[0]->vehicle_features->bname != '') { ?>
                                                                        <tr>
                                                                            <th>Brand</th>
                                                                            <td><?php echo $product[0]->vehicle_features->bname; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->vehicle_features->mname != '') { ?>
                                                                        <tr>
                                                                            <th>Model</th>
                                                                            <td><?php echo $product[0]->vehicle_features->mname; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->vehicle_features->mileagekm != '') { ?>
                                                                        <tr>
                                                                            <th>Mileage</th>
                                                                            <td><?php echo $product[0]->vehicle_features->mileagekm; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->vehicle_features->colorname != '') { ?>
                                                                        <tr>
                                                                            <th>Color</th>
                                                                            <td><?php echo $product[0]->vehicle_features->colorname; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->vehicle_features->type_of_car != '') { ?>
                                                                        <tr>
                                                                            <th>Type Of Car</th>
                                                                            <td><?php echo $product[0]->vehicle_features->type_of_car; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->vehicle_features->year != '') { ?>
                                                                        <tr>
                                                                            <th>Year</th>
                                                                            <td><?php echo $product[0]->vehicle_features->year; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->vehicle_features->make != '') { ?>
                                                                        <tr>
                                                                            <th>Make</th>
                                                                            <td><?php echo $product[0]->vehicle_features->make; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->vehicle_features->vehicle_condition != '') { ?>
                                                                        <tr>
                                                                            <th>Condition</th>
                                                                            <td><?php echo $product[0]->vehicle_features->vehicle_condition; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                                <?php if (isset($product[0]->realestate_features)) { ?>
                                                                    <?php if ($product[0]->realestate_features->Emirates != '') { ?>
                                                                        <tr>
                                                                            <th>Emirates</th>
                                                                            <td><?php echo $product[0]->realestate_features->Emirates; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->realestate_features->PropertyType != '') { ?>
                                                                        <tr>
                                                                            <th>Property Type</th>
                                                                            <td><?php echo $product[0]->realestate_features->PropertyType; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->realestate_features->Bedrooms != '') { ?>
                                                                        <tr>
                                                                            <th>Bedrooms</th>
                                                                            <td><?php
                                                                                if ((int) $product[0]->realestate_features->Bedrooms == '-1')
                                                                                    echo 'More than 10';
                                                                                else
                                                                                    echo $product[0]->realestate_features->Bedrooms;
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->realestate_features->Bathrooms != '') { ?>
                                                                        <tr>
                                                                            <th>Bathrooms</th>
                                                                            <td><?php
                                                                                if ((int) $product[0]->realestate_features->Bathrooms == '-1')
                                                                                    echo 'More than 10';
                                                                                else
                                                                                    echo $product[0]->realestate_features->Bathrooms;
                                                                                ?>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>                                       
                                                                    <?php if ($product[0]->realestate_features->Area != '') { ?>
                                                                        <tr>
                                                                            <th>Area</th>
                                                                            <td><?php echo $product[0]->realestate_features->Area; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->realestate_features->Amenities != '') { ?>
                                                                        <tr>
                                                                            <th>Amenities</th>
                                                                            <td><?php echo $product[0]->realestate_features->Amenities; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->realestate_features->furnished != '') { ?>
                                                                        <tr>
                                                                            <th>Furnished</th>
                                                                            <td><?php echo ($product[0]->realestate_features->furnished != "0") ? ucfirst($product[0]->realestate_features->furnished) : '-'; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                    <?php if ($product[0]->realestate_features->pets != '') { ?>
                                                                        <tr>
                                                                            <th>Pets</th>
                                                                            <td><?php echo ($product[0]->realestate_features->pets) ? ucfirst($product[0]->realestate_features->pets) : '-'; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                <?php } ?>

                                                                <?php if (isset($product[0]->car_number)) { ?>
                                                                    <?php if ($product[0]->car_number->car_number != '') { ?>
                                                                        <tr style="color:#ed1b33">
                                                                            <th >Car Number</th>
                                                                            <td><b><?php echo $product[0]->car_number->car_number; ?></b></td>
                                                                        </tr>
                                                                    <?php } ?>                                            
                                                                    <?php if ($product[0]->car_number->plate_source_name != '') { ?>
                                                                        <tr>
                                                                            <th>Plate Source</th>
                                                                            <td><?php echo $product[0]->car_number->plate_source_name; ?></td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                    <?php if ($product[0]->car_number->plate_prefix != '') { ?>
                                                                        <tr>
                                                                            <th>Plate Prefix</th>
                                                                            <td><?php echo $product[0]->car_number->plate_prefix; ?></td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                    <?php if ($product[0]->car_number->plate_digit != '') { ?>
                                                                        <tr>
                                                                            <th>Plate Digit</th>
                                                                            <td><?php echo $product[0]->car_number->plate_digit; ?></td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                    <?php if ($product[0]->car_number->car_repeating_number != '') { ?>
                                                                        <tr>
                                                                            <th>Repeating Number</th>
                                                                            <td><?php echo $product[0]->car_number->car_repeating_number; ?></td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                <?php } ?> 

                                                                <?php if (isset($product[0]->mobile_number)) { ?>
                                                                    <?php if ($product[0]->mobile_number->mobile_operator != '') { ?>
                                                                        <tr>
                                                                            <th>Mobile Operator</th>
                                                                            <td><?php echo $product[0]->mobile_number->mobile_operator; ?></td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                    <?php if ($product[0]->mobile_number->car_repeating_number != '') { ?>
                                                                        <tr>
                                                                            <th>Repeating Number</th>
                                                                            <td><?php echo $product[0]->mobile_number->car_repeating_number; ?></td>
                                                                        </tr>
                                                                    <?php } ?>

                                                                    <?php if ($product[0]->mobile_number->mobile_number != '') { ?>
                                                                        <tr style="color:#ed1b33">
                                                                            <th>Mobile Number</th>
                                                                            <td><b><?php echo $product[0]->mobile_number->mobile_number; ?><b></td>
                                                                                        </tr>
                                                                                    <?php } ?>                                           
                                                                                <?php } ?> 
                                                                                <?php if ($product[0]->address != '') { ?>
                                                                                    <tr> 
                                                                                        <th>Address</th>                                                   
                                                                                        <td><?php echo $product[0]->address; ?></td>
                                                                                    </tr>
                                                                                <?php } ?>
                                                                                </tbody>
                                                                                </table>
                                                                                </div>                      
                                                                                </div>

                                                                                </div>
                                                                                </div>

                                                                                <div class="desc-wrap">
                                                                                    <h4 class="sub-title">Description</h4>
                                                                                    <p><?php echo $product[0]->product_description; ?></p>
                                                                                </div>
                                                                                <div class="Products-Location">
                                                                                    <div id="map1" style="width:100%;height:300px; margin:20px 0;"></div>
                                                                                </div>                
                                                                                </div>
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
                                                                                <!--footer-->
                                                                                <?php $this->load->view('include/footer'); ?>

                                                                                <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                                    <div class="modal-dialog modal-sm" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">  
                                                                                                <h4 class="modal-title"><i class="fa fa-check-square-o"></i>Confirmation
                                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                                </h4>                   
                                                                                            </div>
                                                                                            <div class="modal-body">                  
                                                                                                <p>Are you sure want delete this Ad?</p>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                </div>
                                                                                </div>
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
                    $("#replyModal").modal('hide');
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
            $('.show_number').text('<?php echo ($product[0]->phone != '') ? $product[0]->phone : "-"; ?>');
        }
        $(document).on("click", "#delet_user_ad", function (e) {
            var product_id = $(document).find(this).attr('data-id');
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if (val == 'yes') {

                    var url = "<?php echo base_url(); ?>user/removeproduct";
                    $.post(url, {prod_id: product_id}, function (data) {
                        window.location = "<?php echo base_url(); ?>user/my_listing";
                    });

                }
            });
        });
                                                                                </script>
                                                                                <script src="<?php echo site_url(); ?>assets/googleMap.js"></script>
                                                                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete"
                                                                                async defer></script>
                                                                                </body>
                                                                                </html>