<?php
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
?>
<html>
    <head>
       
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="Doukani" />
        <meta property="og:title" content="<?php echo $product->product_name; ?>" />
        <meta property="og:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:image" content="<?php echo $share_url; ?>" />
        <meta property="og:description" content="<?php echo $product->product_description; ?>" /> 

        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="Doukani">
        <meta name="twitter:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta name="twitter:title" content="<?php echo $product->product_name; ?>">
        <meta name="twitter:description" content="<?php echo $product->product_description; ?>">
        <meta name="twitter:image:src" content="<?php echo $share_url; ?>"> 


        <?php $this->load->view('include/head'); ?>
         <?php $this->load->view('include/google_tab_manager_head'); ?>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/gallery_assets/css/basic.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/gallery_assets/css/galleriffic-2.css" type="text/css" />
        <link rel="image_src" href="<?php echo $share_url; ?>" />
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/gallery_assets/js/jquery.galleriffic.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/gallery_assets/js/jquery.opacityrollover.js"></script>
        <!-- We only want the thumbnails to display when javascript is disabled -->
        <script type="text/javascript">
            document.write('<style>.noscript { display: none; }</style>');
        </script>
        <?php
        $url = base_url() . 'assets/upload/No_Image.png';
        $filename = document_root . product . 'original/' . $product->product_image;

        if (file_exists($filename)) {
            $url = base_url() . 'assets/upload/product/original/' . $product->product_image;
        }
        $state_name = $product->state_name;
        if ($product->state_name == '')
            $state_name = 'Dubai';
        ?>
        <script>
            var lat = '', lng = '';
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': '<?php echo $state_name; ?>'}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = results[0].geometry.location.lat();
                    lng = results[0].geometry.location.lng();
                }
            });
            function initialize() {
                var myLatlng = new google.maps.LatLng(lat, lng);
                var mapOptions = {
                    zoom: 7,
                    center: myLatlng
                };

                var map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

                var marker = new google.maps.Marker({
                    position: myLatlng,
                    map: map
                });
                google.maps.event.addListener(marker);

            }

            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        <script type="text/javascript" src="https://w.sharethis.com/button/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false});

        </script>
    </head>

    <body itemscope itemtype="https://schema.org/WebPage">
        <?php $this->load->view('include/google_tab_manager_body'); ?>
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
                <div class="col-sm-12 main category-grid">
                    <div class="row">
                        <!--cat-->
                        <?php $this->load->view('include/left-nav'); ?>
                        <!--//cat-->
                        <!--content-->
                        <div class="col-sm-10">
                            <!--row-->
                            <div class="row subcat-div no-padding">
                                <div class="col-sm-12">
                                    <?php $this->load->view('include/breadcrumb'); ?>
                                    <span class="result"><?php echo $product->product_name; ?> details</span>
                                </div>

                            </div>
                            <?php if (isset($msg) && !empty($msg)): ?>
                                <div class="col-sm-12"  style="margin-top: 10px;">
                                    <div class='alert <?php echo $msg_class; ?> text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <!--///row-->
                            <!--row detail-->
                            <div class="row">
                                <div class="col-sm-8 item-detail">
                                    <div class="col-sm-7">
                                        <h3 itemprop="name"><?php echo $product->product_name; ?></h3>
                                        <img itemprop="image" src="<?php echo base_url() . 'assets/upload/product/original/' . $product->product_image; ?>" style="display:none;" />
                                    </div>
                                    <div class="col-sm-5 text-right">
                                        <p class="item-by">
                                            <a href="<?php echo base_url() . 'seller/listings/' . $product->product_posted_by; ?>" style="text-decoration: none;">
                                                <?php
                                                $profile_picture = '';
                                                if ($product->profile_picture != '') {
                                                    $profile_picture = base_url() . profile . "original/" . $product->profile_picture;
                                                } elseif ($product->facebook_id != '') {
                                                    $profile_picture = 'https://graph.facebook.com/' . $product->facebook_id . '/picture?type=large';
                                                } elseif ($product->twitter_id != '') {
                                                    $profile_picture = 'https://twitter.com/' . $product->username . '/profile_image?size=original';
                                                } elseif ($product->google_id != '') {
                                                    $data = file_get_contents('https://picasaweb.google.com/data/entry/api/user/' . $product->google_id . '?alt=json');
                                                    $d = json_decode($data);
                                                    $profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
                                                }
                                                ?>
                                                By <img width="30" height="30" class="img-circle" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"> <?php echo $product->username1; ?>

                                            </a>
                                        </p>                                    
                                    </div>
                                </div>
                            </div>
                            <!--//row detail-->
                            <!--row-->
                            <div class="row">
                                <div class="col-sm-8 images">
                                    <div class="col-md-12">

                                        <div id="gallery" class="">
                                            <div id="controls" class="controls"></div>
                                            <div class="slideshow-container">
                                                <div id="loading" class="loader"></div>
                                                <div id="slideshow" class="slideshow"></div>
                                            </div>
                                            <!-- <div id="caption" class="caption-container"></div> -->
                                        </div>
                                        <div id="thumbs" class="navigation row">
                                            <ul class="thumbs noscript">
<?php
if (!empty($product_images)) {
    $i = 1;
    foreach ($product_images as $pro) {
        $url = base_url() . 'assets/upload/No_Image.png';
        $filename = document_root . product . 'original/' . $pro;

        if (file_exists($filename)) {
            $url = base_url() . 'assets/upload/product/original/' . $pro;
        }
        ?>
                                                        <li>
                                                            <a class="thumb" href="<?php echo $url; ?>" title="Image #<?php echo $i; ?>">
                                                                <img  src="<?php echo base_url() ?>assets/upload/product/medium/<?php echo $pro; ?>" alt="Image #<?php echo $i; ?>" onError="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'" height="120px" width="120px"/>
                                                            </a>
                                                            <div class="caption">

                                                                <div class="image-title">Image #<?php echo $i; ?></div>

                                                            </div>
                                                        </li>
        <?php $i++;
    } ?>
<?php } else { ?>
                                                    <li>
                                                        <a class="thumb" href="<?php echo base_url() ?>assets/upload/No_Image.png" >
                                                            <img width="120" height="120" src="<?php echo base_url() ?>assets/upload/No_Image.png"/>
                                                        </a>
                                                    </li>
<?php } ?>

                                            </ul>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 detail-btns">
<?php if ($product_is_sold == 0) { ?>
                                            <div class="col-sm-6">
                                                <button class="btn mybtn btn-block"><span class="fa fa-phone"></span><span class="show_number"> Show Number</span></button>
                                            </div>
                                        <?php } ?>
                                        <div class="col-sm-6">
                                            <button class="btn btn-blue btn-block" data-toggle="modal" data-target="#replyModal"><span class="fa fa-envelope"></span> Reply to Add</button>
                                        </div>
                                        <div id="replyModal" class="modal fade" role="dialog">
                                            <div class="modal-dialog ">
                                                <div class="modal-content">
                                                    <form name="formReplyAds" method="post" id="formReplyAds" class="form-horizontal" role="form">
                                                        <input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">
                                                        <input type="hidden" value="<?php echo $product->product_code; ?>" name="productCode" id="productCode">
                                                        <input type="hidden" value="<?php echo $product->product_name; ?>" name="productName" id="productName">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Reply to Ad
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div id="formErrorMsg" class="alert alert-info">Fields marked with
                                                                * are required.
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-xs-3 text-center">
                                                                    <label class="control-label">Name *</label>
                                                                </div>
                                                                <div class="col-xs-9">
                                                                    <input type="text" value="" placeholder="" name="sender_name" id="sender_name" class="form-control"> <input type="hidden" value="" name="sender_id" id="sender_id">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-xs-3 text-center">
                                                                    <label class="control-label">Email *</label>
                                                                </div>
                                                                <div class="col-xs-9">
                                                                    <input type="text" value="" placeholder="" name="sender_email" id="sender_email" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-xs-3 text-center">
                                                                    <label class="control-label">Subject *</label>
                                                                </div>
                                                                <div class="col-xs-9">
                                                                    <input type="text" value="" placeholder="" name="subject" id="subject" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-xs-3 text-center">
                                                                    <label class="control-label">Message *</label>
                                                                </div>
                                                                <div class="col-xs-9">
                                                                    <textarea placeholder="" name="message" id="message" class="form-control"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="col-sm-4 col-sm-offset-8">
                                                                <div class="col-sm-6">
                                                                    <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <button type="submit" name="reply_submit" class="btn btn-success btn-md">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 details">
                                    <h4 class="no-margin">Selling Price :</h4>
                                    <h3>AED <?php echo number_format($product->product_price); ?></h3>
                                    <div class="table-responsive">
                                        <table class="table tbl-details">
                                            <tr style="color:#9197a3;">
                                                <td>Posted On</td>
                                                <td><?php echo $posted_on; ?></td>
                                            </tr>
                                            <!--<tr>
                                                <td>Product Code</td>
                                                <td><?php //echo $product->product_code;  ?></td>
                                            </tr> -->



                                        <!--<tr>
                                            <td>Status</td>
                                            <td><?php //echo ucfirst($product->product_status);  ?></td>
                                        </tr> -->
                                            <tr>
                                                <td>Category789</td>
                                                <td><?php
                                        echo str_replace('\n', " ", $product->catagory_name);
                                        print_r($product);
                                        ?></td>
                                            </tr>


<?php if ($product->sub_category_id != '' || $product->sub_category_id != null) { ?>
                                                <tr>
                                                    <td>Sub-Category</td>
                                                    <td><?php echo str_replace('\n', " ", $product->sub_category_name); ?></td>
                                                </tr>
<?php } ?>


                                            <?php if (isset($product->vehicle_features)) { ?>
    <?php if ($product->vehicle_features->bname != '') { ?>
                                                    <tr>
                                                        <td>Brand</td>
                                                        <td><?php echo $product->vehicle_features->bname; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->vehicle_features->mname != '') { ?>
                                                    <tr>
                                                        <td>Model</td>
                                                        <td><?php echo $product->vehicle_features->mname; ?></td>
                                                    </tr>
    <?php } ?>
    <?php if ($product->vehicle_features->mileagekm != '') { ?>
                                                    <tr>
                                                        <td>Mileage</td>
                                                        <td><?php echo $product->vehicle_features->mileagekm; ?></td>
                                                    </tr>
    <?php } ?>
    <?php if ($product->vehicle_features->colorname != '') { ?>
                                                    <tr>
                                                        <td>Color</td>
                                                        <td><?php echo $product->vehicle_features->colorname; ?></td>
                                                    </tr>
    <?php } ?>
    <?php if ($product->vehicle_features->type_of_car != '') { ?>
                                                    <tr>
                                                        <td>Type Of Car</td>
                                                        <td><?php echo $product->vehicle_features->type_of_car; ?></td>
                                                    </tr>
    <?php } ?>
    <?php if ($product->vehicle_features->year != '') { ?>
                                                    <tr>
                                                        <td>Year</td>
                                                        <td><?php echo $product->vehicle_features->year; ?></td>
                                                    </tr>
    <?php } ?>
    <?php if ($product->vehicle_features->make != '') { ?>
                                                    <tr>
                                                        <td>Make</td>
                                                        <td><?php echo $product->vehicle_features->make; ?></td>
                                                    </tr>
    <?php } ?>
    <?php if ($product->vehicle_features->vehicle_condition != '') { ?>
                                                    <tr>
                                                        <td>Condition</td>
                                                        <td><?php echo $product->vehicle_features->vehicle_condition; ?></td>
                                                    </tr>
    <?php } ?>

                                            <?php } ?>

                                            <?php if (isset($product->realestate_features)) { ?>
                                                <?php if ($product->realestate_features->Emirates != '') { ?>
                                                    <tr>
                                                        <td>Emirates</td>
                                                        <td><?php echo $product->realestate_features->Emirates; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->realestate_features->PropertyType != '') { ?>
                                                    <tr>
                                                        <td>Property Type</td>
                                                        <td><?php echo $product->realestate_features->PropertyType; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->realestate_features->Bathrooms != '') { ?>
                                                    <tr>
                                                        <td>Bathrooms</td>
                                                        <td><?php echo $product->realestate_features->Bathrooms; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->realestate_features->Bedrooms != '') { ?>
                                                    <tr>
                                                        <td>Bedrooms</td>
                                                        <td><?php echo $product->realestate_features->Bedrooms; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->realestate_features->Area != '') { ?>
                                                    <tr>
                                                        <td>Area</td>
                                                        <td><?php echo $product->realestate_features->Area; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->realestate_features->Amenities != '') { ?>
                                                    <tr>
                                                        <td>Amenities</td>
                                                        <td><?php echo $product->realestate_features->Amenities; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->realestate_features->furnished != '') { ?>
                                                    <tr>
                                                        <td>Furnished</td>
                                                        <td><?php echo $product->realestate_features->furnished; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->realestate_features->pets != '') { ?>
                                                    <tr>
                                                        <td>Pets</td>
                                                        <td><?php echo $product->realestate_features->pets; ?></td>
                                                    </tr>
    <?php } ?>

                                            <?php } ?>

                                            <?php
                                            echo '<br>';
                                            print_r($product);
                                            if (isset($product->car_number)) {
                                                ?>
                                                <?php if ($product->car_number->car_number != '') { ?>
                                                    <tr>
                                                        <td>Car Number</td>
                                                        <td><?php echo $product->car_number->car_number; ?></td>
                                                    </tr>
    <?php } ?>
                                                <?php if ($product->car_number->plate_source_name != '') { ?>
                                                    <tr>
                                                        <td>Plate Source</td>
                                                        <td><?php echo $product->car_number->plate_source_name; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->car_number->plate_prefix != '') { ?>
                                                    <tr>
                                                        <td>Plate Prefix</td>
                                                        <td><?php echo $product->car_number->plate_prefix; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->car_number->plate_digit != '') { ?>
                                                    <tr>
                                                        <td>Plate Digit</td>
                                                        <td><?php echo $product->car_number->plate_digit; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->car_number->car_repeating_number != '') { ?>
                                                    <tr>
                                                        <td>Repeating Number</td>
                                                        <td><?php echo $product->car_number->car_repeating_number; ?></td>
                                                    </tr>
    <?php } ?>
                                            <?php } ?>
                                            <?php if (isset($product->mobile_number)) { ?>
                                                <?php if ($product->mobile_number->mobile_operator != '') { ?>
                                                    <tr>
                                                        <td>Mobile Operator</td>
                                                        <td><?php echo $product->mobile_number->mobile_operator; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->mobile_number->car_repeating_number != '') { ?>
                                                    <tr>
                                                        <td>Repeating Number</td>
                                                        <td><?php echo $product->mobile_number->car_repeating_number; ?></td>
                                                    </tr>
    <?php } ?>

                                                <?php if ($product->mobile_number->mobile_number != '') { ?>
                                                    <tr>
                                                        <td>Mobile Number</td>
                                                        <td><?php echo $product->mobile_number->mobile_number; ?></td>
                                                    </tr>
    <?php } ?>
                                            <?php } ?> 
                                        </table>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="col-sm-8 ">
                                        <div class="col-sm-12 description">
                                            <h4>Description</h4>
                                            <p><?php echo $product->product_description; ?></p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 detail-ad ad-banner-square">
<?php if (!empty($feature_banners)) { ?>

                                            <a href="<?php echo $feature_banners[0]['site_url']; ?>"  target="_blank"  onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name'] ?>" width="100%" class="img-responsive center-block" /></a>
                                        <?php } else {
                                            ?>
                                            <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/ad1.jpg" class="img-responsive center-block" /></a>
                                        <?php } ?>

                                    </div>
                                    <div class="col-sm-12">
                                        <div id="googleMap" style="width:100%;height:250px; margin:20px 0;"></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <span class='st_facebook_large' id="facebook_btn" displayText='Facebook'></span>
                                        <span class='st_twitter_large' displayText='Tweet'></span>
                                        <span class='st_googleplus_large' displayText='Google +'></span>
                                                                              <!-- <p class="links no-padding">Share on <i class="fa fa-facebook"></i><i class="fa fa-twitter"></i><i class="fa fa-google-plus"></i></p>	 -->
                                    </div>
                                    <div class="col-sm-6 text-right view-report">
                                        <span class="fa fa-eye blue"></span><?php echo $product->product_total_views; ?> Views
                                        <span class="fa fa-flag pink"></span><a data-toggle="modal" data-target="#<?php echo ($is_logged == 1) ? 'reportModal' : 'ifLoginModal' ?>" href="#">Report this Item</a>

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
                                                    <h5>You need to be logged in to report this item.</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?php echo base_url(); ?>login?id=<?php echo $product->product_id; ?>" class="btn btn-blue">Log In</a>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div id="reportModal" class="modal fade" role="dialog">
                                        <div class="modal-dialog ">
                                            <div class="modal-content">
                                                <form accept-charset="utf-8" name="formReportAds" method="post" id="formReportAds" class="form-horizontal" role="form">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">What's wrong with this ad?
                                                        </h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div style="display: none" id="formErrorMsgReport" class="alert alert-info"></div>
                                                        <input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">
                                                        <input type="hidden" value="<?php echo $product->product_code; ?>" name="productCode" id="productCode">
                                                        <input type="hidden" value="<?php echo $product->product_name; ?>" name="productName" id="productName">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <label>
                                                                    <input type="radio" name="report" value="spam" checked="">
                                                                    Spam</label>
                                                                (This is a Spam Ad.)
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <label><input type="radio" name="report" value="fraud"> Fraud</label>
                                                                (You suspect this to be a scam, illegal or fradulent. )
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <label><input type="radio" name="report" value="violation">
                                                                    Policy Violation</label>
                                                                (Ad violates our terms &amp; conditions or other policies.)
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <label><input type="radio" name="report" value="duplicate">
                                                                    Duplicate</label> (It's identical to another Ad.)
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <label><input type="radio" name="report" value="inappropriate">
                                                                    Wrong Category</label> (It doesn't belong in this category.)
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <label><input type="radio" name="report" value="other"> Other</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <label class="control-label">Comments</label>
                                                                <textarea placeholder="" class="form-control" name="comments" id="comments"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="col-xs-8">&nbsp;</div>
                                                        <div class="col-xs-2">
                                                            <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
                                                        </div>
                                                        <div class="col-xs-2">
                                                            <button type="submit" name="report_submit" class="btn btn-success btn-md">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <hr />
                                    </div>
<?php if (!empty($related_product)) { ?>
                                        <div class="col-sm-12 most-viewed">
                                            <h3>Related Items</h3>
                                            <!--item1-->
    <?php if ($related_product) {
        foreach ($related_product as $pro) {
            ?>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="item-sell">
                                                            <div class="item-img">
            <?php if ($pro['product_is_sold'] == 1) { ?>
                                                                    <div class="sold"><span>SOLD</span></div>
                                                                <?php } ?>
                                                                <a href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'" /></a>
                                                            </div>
                                                            <div class="item-disc">
                                                                <a style="text-decoration: none;" href="<?php echo base_url(); ?>home/item_details/<?php echo $pro['product_id']; ?>"><h4><?php echo $pro['product_name']; ?></h4></a>
                                                                <small><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></small>
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
                $data = file_get_contents('https://picasaweb.google.com/data/entry/api/user/' . $pro['google_id'] . '?alt=json');
                $d = json_decode($data);
                $profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
            }
            ?>
                                                                <div class="by-user col-sm-12">
                                                                    <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
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
        <?php }// foreach($related_product as $pro)
    } //if($related_product) 
    ?>
                                            <!--//item1-->

                                        </div>
                                    <?php } ?>
                                </div>


                            </div>
                            <!--//row-->
                        </div>
                        <!--//content-->
                    </div>
                </div>
                <!--//main-->




            </div>


            <!--//body-->

            <!--footer-->
            <?php $this->load->view('include/footer'); ?>

            <!--//footer-->


            <!--container-->
            <script type="text/javascript">
                function update_count(a)
                {
                    var url = "<?php echo base_url() ?>home/update_click_count";
                    $.post(url, {ban_id: a}, function (response)
                    { }, "json");
                }
                jQuery(document).ready(function ($) {


                    // We only want these styles applied when javascript is enabled
                    $('div.navigation').css({'float': 'left'});
                    $('button.mybtn').click(function () {
                        $(this).find('.show_number').text('<?php echo $product->phone; ?>');
                    });
                    $('div.content').css('display', 'block');

                    // Initially set opacity on thumbs and add
                    // additional styling for hover effect on thumbs
                    var onMouseOutOpacity = 0.67;
                    $('#thumbs ul.thumbs li').opacityrollover({
                        mouseOutOpacity: onMouseOutOpacity,
                        mouseOverOpacity: 1.0,
                        fadeSpeed: 'fast',
                        exemptionSelector: '.selected'
                    });


                    // Initialize Advanced Galleriffic Gallery
                    var gallery = $('#thumbs').galleriffic({
                        delay: 1000,
                        numThumbs: 3,
                        preloadAhead: 3,
                        enableTopPager: false,
                        enableBottomPager: true,
                        maxPagesToShow: 3,
                        imageContainerSel: '#slideshow',
                        controlsContainerSel: '#controls',
                        captionContainerSel: '#caption',
                        loadingContainerSel: '#loading',
                        renderSSControls: true,
                        renderNavControls: true,
                        //playLinkText:              'Play Slideshow',
                        //pauseLinkText:             'Pause Slideshow',
                        prevLinkText: '&lsaquo; Previous Photo',
                        nextLinkText: 'Next Photo &rsaquo;',
                        nextPageLinkText: 'Next &rsaquo;',
                        prevPageLinkText: '&lsaquo; Prev',
                        enableHistory: false,
                        autoStart: false,
                        syncTransitions: true,
                        defaultTransitionDuration: 900,
                        enableKeyboardNavigation: false,
                        onSlideChange: function (prevIndex, nextIndex) {
                            // 'this' refers to the gallery, which is an extension of $('#thumbs')
                            this.find('ul.thumbs').children()
                                    .eq(prevIndex).fadeTo('fast', onMouseOutOpacity);
                        },
                        onSlideChangeIn: function (nextIndex) {
                            this.find('ul.thumbs').children()
                                    .eq(nextIndex).fadeTo('fast', 1.0);
                        },
                        onPageTransitionOut: function (callback) {
                            this.fadeTo('fast', 0.0, callback);
                        },
                        onPageTransitionIn: function () {
                            this.fadeTo('fast', 1.0);
                        }
                    });

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
                            form.submit();
                        }
                    });

                    $("#formReplyAds").validate({
                        rules: {
                            sender_name: "required",
                            subject: "required",
                            message: "required",
                            sender_email: {
                                required: true,
                                email: true
                            }
                        },
                        messages: {
                            sender_name: "Please Enter Name",
                            subject: "Please provide a subject",
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
            </script>
            <script type="text/javascript">
                $('div.star a i').click(function () {

                    var url = "<?php echo base_url() ?>home/add_to_favorites";
                    var fav = 0;
                    var id = $(this).attr('id');
//                    console.log(id);
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
//                        console.log(response);
                        if (response != 'Success' && response != 'failure')
                        {
                            $('#err_div').show();
                            $("#error_msg").text(response);
                        } else
                            $('#err_div').hide();
                    });
                });
            </script>
    </body>
</html>
