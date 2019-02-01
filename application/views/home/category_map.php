<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>         
        <style> .subcat-div { padding: 10px 15px; } </style>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries"></script>	
        <script src="<?php echo site_url(); ?>assets/front/javascripts/oms.min.js"></script>
        <!--<script src="<?php echo site_url(); ?>assets/front/javascripts/oms.js"></script>-->
        <script src="<?php echo site_url(); ?>assets/front/javascripts/markerclusterer.js"></script>    
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
        <script type="text/javascript">

            window.onload = function () {
                if (marker) {
                    marker.setMap(null);
                }
                var gm = google.maps;
                var is_touch_device = 'ontouchstart' in document.documentElement;

                var map = new gm.Map(document.getElementById('map_canvas'), {
                    mapTypeId: gm.MapTypeId.ROADMAP,
                    draggable: !is_touch_device,
                    center: new gm.LatLng(25.2048493, 55.270782800000006),
                    zoom: 8,
                    scrollwheel: true
                });

                var iw = new gm.InfoWindow();
                var oms = new OverlappingMarkerSpiderfier(map,
                        {markersWontMove: true, markersWontHide: true, keepSpiderfied: true});

                var usualColor = 'eebb22';
                var spiderfiedColor = 'ffee22';
                var iconWithColor = function (color) {
                    return '<?php site_url() . "assets/front/images/marker.png"; ?>';
//                    return 'http://chart.googleapis.com/chart?chst=d_map_xpin_letter&chld=pin|+|' +
//                            color + '|000000|ffff00';
                }
                var shadow = new gm.MarkerImage(
                        'https://www.google.com/intl/en_ALL/mapfiles/shadow50.png',
                        new gm.Size(37, 34), // size   - for sprite clipping
                        new gm.Point(0, 0), // origin - ditto
                        new gm.Point(10, 34)  // anchor - where to meet map location
                        );

                oms.addListener('click', function (marker) {
                    iw.setContent(marker.desc);
                    iw.open(map, marker);

                });
                oms.addListener('spiderfy', function (markers) {
                    for (var i = 0; i < markers.length; i++) {
                        markers[i].setIcon('<?php site_url() . "assets/front/images/marker.png"; ?>');
                        markers[i].setShadow(null);
                    }
                    iw.close();
                });
                oms.addListener('unspiderfy', function (markers) {

                    for (var i = 0; i < markers.length; i++) {
                        markers[i].setIcon('<?php site_url() . "assets/front/images/marker.png"; ?>');
                        markers[i].setShadow(shadow);
                    }
                });

                var bounds = new gm.LatLngBounds();
                var marker = '';
                var googleMarkers = [];
                for (var i = 0; i < window.mapData.length; i++) {
                    var datum = window.mapData[i];
//                    console.log(datum);
                    var loc = new gm.LatLng(datum.lat, datum.lon);
                    bounds.extend(loc);
                    marker = new gm.Marker({
                        position: loc,
                        title: datum.h,
                        map: map,
                        shadow: shadow
                    });
                    marker.desc = datum.d;
                    googleMarkers.push(marker);
                    oms.addMarker(marker);
                }
//                var mcOptions = {gridSize: 50, maxZoom: 13, imagePath: ''};
//                var markerCluster = new MarkerClusterer(map, googleMarkers, mcOptions);
//                var markerCluster = new MarkerClusterer(map, googleMarkers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
                map.fitBounds(bounds);
                window.map = map;
                window.oms = oms;
            }
            var data = [];
            var lat = '', lng = '';
            var baseLat = '';
            var baseLon = '';
<?php
foreach ($products as $key => $val) {
    ?>
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'address': "<?php echo ($val['address'] != '') ? $val["address"] : $val['state_name']; ?>"}, function (results, status) {

                    var imgerr = "onerror=this.src='<?php echo thumb_start_grid_map . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid_map; ?>'";
    <?php
    $profile_picture = '';
    $profile_picture = $this->dbcommon->load_picture($val['profile_picture'], $val['facebook_id'], $val['twitter_id'], $val['username'], $val['google_id']);

    if ($val['product_price'] != '' && (int) $val['product_price'] != 0)
        $product_price = 'AED ' . number_format($val['product_price']);
    else
        $product_price = '';
    ?>
                    var imgproerr = "onerror=this.src='<?php echo thumb_start_grid_map . base_url(); ?>assets/upload/avtar.png<?php echo thumb_end_grid_map; ?>'";

                    var ans = '<div class="col-sm-12 list-item map_list"><div class="col-sm-4 img-holder"><?php if ($val['product_is_sold'] == 1) { ?><div class="sold"><span>SOLD</span></div><?php } ?><?php if (isset($val['featured_ad']) && $val['featured_ad'] > 0) { ?><div class="ribbon_main"><div class="red_ribbon"></div> <?php } ?><div class="img-holderInner"> <img src="<?php echo thumb_start_grid_map . base_url() . product . "medium/" . $val['product_image'] . thumb_end_grid_map; ?>" alt="<?php echo addslashes($val['product_name']); ?>" class="img-responsive"  ' + imgerr + ' /></div></a><?php
    if (isset($val['product_for']) && $val['product_for'] == 'store' && isset($val['store_domain']) && !empty($val['store_domain']))
        $product_path = HTTP . $val['store_domain'] . after_subdomain . '/' . $val['product_slug'];
    elseif ((isset($my_listing) && $my_listing == 'yes') || (isset($my_deactivateads) && $my_deactivateads = 'yes'))
        $product_path = base_url() . 'user/item_details/' . $val['product_id'];
    else
        $product_path = base_url() . $val['product_slug'];

    if (isset($val['featured_ad']) && $val['featured_ad'] > 0) {
        echo '</div>';
    }
    ?><div class="count-img"><i class="fa fa-image"></i><span><?php echo $val['MyTotal']; ?></span></div></div><div class="col-sm-8 info-holder"><div class="col-sm-7"><a style="text-decoration: none;" href="<?php echo $product_path; ?>"><h3><?php echo addslashes($val['product_name']); ?></h3></a><small><?php echo str_replace('\n', " ", $val['catagory_name']); ?></small></div><div class="col-sm-5"><div class="list-icons01"><?php
    if ($loggedin_user != $val['product_posted_by']) {
        if ($val['product_is_sold'] != 1) {
            if (!isset($like_ads)) {
                if ($is_logged != 0) {
                    $favi = (int) $val['my_favorite'];
                    if ($val['product_total_favorite'] != 0 && $favi == 1) {
                        ?> <div class="star fav" ><a href="javascript:void(0);" id="<?php echo $val['product_id']; ?>"><i class="fa fa-star" id="<?php echo $val['product_id']; ?>"></i></a></div><?php } else { ?><div class="star" ><a href="javascript:void(0);"><i class="fa fa-star-o" id="<?php echo $val['product_id']; ?>"></i></a></div><?php
                    }
                } else {
                    ?><div class="star" ><a href="<?php echo base_url() . 'login/index'; ?>"><i class="fa fa-star-o"></i></a></div><?php
                }
            }
            if (!isset($favorite_ads)) {
                if ($is_logged != 0) {
                    $like = (int) $val['my_like'];
                    if ($val['product_total_likes'] != 0 && $like == 1) {
                        ?><div class="newthumb thu"><a href="javascript:void(0);" id="<?php echo $val['product_id']; ?>"><i class="fa fa-thumbs-up" id="<?php echo $val['product_id']; ?>"></i></a></div><?php } else { ?><div class="newthumb" ><a href="javascript:void(0);"><i class="fa fa-thumbs-o-up" id="<?php echo $val['product_id']; ?>"></i></a></div><?php
                    }
                } else {
                    ?><div class="newthumb" ><a href="<?php echo base_url() . 'login/index'; ?>"><i class="fa fa-thumbs-o-up"></i></a></div><?php
                }
            }
            if (isset($val['product_for']) && $val['product_for'] == 'store' && isset($val['store_domain']) && !empty($val['store_domain'])) {
                ?><div class="addtocart listview map_loc"><button data-toggle="tooltip" title="Add To Cart" class="add_to_cart_cus" type="button" id="add_to_cart_button" quantity="1" proid="<?php echo $val['product_id']; ?>"><i class="fa fa-shopping-cart <?php echo $val['product_id']; ?>"></i></button></div><?php
            }
        }
    }


    if (isset($val['product_for']) && $val['product_for'] == 'store' && isset($val['store_domain']) && !empty($val['store_domain']))
        $user_profile_pg = HTTP . $val['store_domain'] . after_subdomain . remove_home;
    else
        $user_profile_pg = base_url() . emirate_slug . $val['user_slug'] . '?view=map';
    ?></div><div class="price"><h4><?php echo $product_price; ?></h4></div> </div><div class="by-user col-sm-6 padding5"><img src="<?php echo $profile_picture; ?>" alt="Profile Image" class="img-responsive img-circle" ' + imgproerr + ' /><a href="<?php echo $user_profile_pg; ?>"><?php echo $val['username1']; ?></a></div><div class="Viewouterbutton"><a href="<?php echo $product_path; ?>" class="btn mybtn">View</a></div></div></div>';

                    var html = '';
    <?php
    $product_latitude = '';
    $product_longitude = '';

    if ($val['latitude'] != '' && $val['longitude'] != '') {
        $product_latitude = $val['latitude'];
        $product_longitude = $val['longitude'];
    } else {
        $product_latitude = $val['state_latitude'];
        $product_longitude = $val['state_longitude'];
    }
    if (!empty($product_latitude) && !empty($product_longitude)) {
        ?>
                        data.push({
                            lon: <?= $product_longitude; ?>,
                            lat: <?= $product_latitude; ?>,
                            h: "<?php //echo $val['product_name'];              ?>",
                            d: ans
                        });
    <?php } ?>
                });
<?php } ?>

            window.mapData = data;

        </script>

    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>        
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>            
                        <div class="col-sm-12 main category-grid">
                            <?php $this->load->view('include/left-nav'); ?>                    
                            <div class="col-sm-9 ContentRight <?php echo (isset($latest_page) && $latest_page == 'yes') ? 'latest_pg' : ''; ?>">
                                <?php if (isset($latest_page) && $latest_page == 'yes') { ?>
                                    <div class="latest">
                                        <?php $this->load->view('common/lastest_ad_featuredpart'); ?>
                                        <!--row-->
                                    </div>
                                <?php } ?>
                                <?php
                                if ((isset($my_listing) && $my_listing == 'yes') || (isset($my_deactivateads) && $my_deactivateads == 'yes') || (isset($favorite_ads) && $favorite_ads == 'yes') || (isset($like_ads) && $like_ads == 'yes')) {
                                    $this->load->view('user/user_menu');
                                }
                                ?>
                                <div class="row subcat-div">
                                    <?php if (isset($seller_listing_page) && $seller_listing_page == 'yes') { ?>
                                        <?php $this->load->view('home/seller_profile'); ?>
                                        <br>
                                        <?php $this->load->view('home/seller_common'); ?>
                                    <?php } elseif (isset($slug) && $slug == 'featured_ads') { ?>
                                        <h3>Featured Ads</h3>
                                        <div class="content-top-option">
                                            <?php $this->load->view('home/featured_ads_common'); ?>
                                        </div>                                        
                                    <?php } elseif (isset($slug) && $slug == 'search') {
                                        ?>
                                        <h3>Search Result</h3>
                                        <div class="content-top-option">  
                                            <?php $this->load->view('home/search_common'); ?>
                                        </div>
                                    <?php } elseif (isset($latest_page) && $latest_page == 'yes') {
                                        ?>
                                        <div class="col-sm-6 latest_pg_lbl">
                                            <h3 class="border-title latest">Latest Ads</h3>
                                        </div>
                                        <?php
                                        $this->load->view('home/latest_common');
                                    } elseif (isset($advanced_page) && $advanced_page = 'yes') {
                                        ?>
                                        <h3>Search Result</h3>
                                        <div class="content-top-option">                                                                                        <?php $this->load->view('home/advanced_search_common'); ?>
                                        </div>
                                        <?php
                                    } elseif (isset($my_listing) && $my_listing == 'yes') {
                                        $this->load->view('user/listings_common');
                                    } elseif (isset($my_deactivateads) && $my_deactivateads == 'yes') {
                                        $this->load->view('user/listings_common');
                                    } elseif (isset($favorite_ads) && $favorite_ads == 'yes') {
                                        $this->load->view('user/listings_common');
                                        echo '<h4> My Favorites</h4>';
                                    } elseif (isset($like_ads) && $like_ads == 'yes') {
                                        $this->load->view('user/listings_common');
                                        echo '<h4> My Likes</h4>';
                                    } else {
                                        ?>
                                        <div class="content-top-option">
                                            <?php $this->load->view('home/category_common'); ?>
                                        </div>
                                        <?php $this->load->view('home/category_description'); ?>
                                    <?php } ?>

                                    <?php if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) { ?>

                                        <?php
                                    } else {
                                        if (isset($subcat) && sizeof($subcat) > 0) {
                                            ?>
                                            <div class="TagsList">
                                                <div class="subcats cat_desc_div">
                                                    <div class="col-sm-12 no-padding-xs">
                                                        <?php
                                                        $cat_inc = 0;
                                                        $count_cats = count($subcat);
                                                        foreach ($subcat as $sub) {
                                                            if ($cat_inc < 9) {
                                                                ?>
                                                                <div class="col-sm-6 col-md-6 col-lg-4">
                                                                    <a href="<?php echo base_url() . emirate_slug . $sub['sub_category_slug'] . '/?view=map' . $order_option; ?>" rel="nofollow"><?php echo $sub['name']; ?> <span class="count">(<?php echo $sub['total']; ?>)</span></a>
                                                                </div>
                                                                <?php
                                                            } else {
                                                                if ($cat_inc == 10) {
                                                                    ?>
                                                                    <div class="col-sm-12 text-center" id="load_more1">
                                                                        <button class="btn btn-blue cat_more_page" onclick="load_more_subcategories();" id="load_more_subcategories" value="0">Show More</button><br><br>
                                                                        <br/>
                                                                    </div>
                                                                    <div class="col-sm-12 text-center" id="load_less">
                                                                        <button class="btn btn-blue cat_more_page" onclick="load_less_subcategories();" id="load_less_subcategories" value="0">Show Less</button><br><br>
                                                                        <br/>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            $cat_inc++;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>                                    
                                </div>	
                                <div class="row">
                                    <div class="col-sm-12 catlist">
                                        <?php if (isset($subcat_name) || isset($category_name)) { ?>
                                            <h3><?php echo str_replace('\n', " ", @$subcat_name ? @$subcat_name : @$category_name); ?></h3>                                        
                                            <?php
                                        }
                                        if (!empty($products)) {
                                            ?>
                                            <div class="col-sm-12">
                                                <div id="google-maps" class="map" style="width:100%;height:600px; margin:20px 0;display:none;"></div>								
                                                <div id="map_canvas" class="map" style="width:100%;height:600px; margin:20px 0;"></div>
                                            </div>
                                        <?php } ?>

                                        <div class="col-sm-12">
                                            <div class="table-responsive">
                                                <table id="table-map" class="dataTable table-responsive table-map table table-striped" >
                                                    <tbody>
                                                        <?php
                                                        $flag = 1;
                                                        if (!empty($products)) {
                                                            foreach ($products as $pro) {
                                                                if ($flag == 1) {
                                                                    ?>
                                                                    <tr>
                                                                        <td style="padding-left:20px"><h3>Title</h3></td>
                                                                        <td><h3>Price</h3></td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                                if (@$subcat_id == "")
                                                                    $subcat_id = 0;

                                                                if (isset($pro['product_for']) && $pro['product_for'] == 'store' && isset($pro['store_domain']) && !empty($pro['store_domain']))
                                                                    $product_path = HTTP . $pro['store_domain'] . after_subdomain . '/' . $pro['product_slug'];
                                                                elseif ((isset($my_listing) && $my_listing == 'yes') || (isset($my_deactivateads) && $my_deactivateads = 'yes'))
                                                                    $product_path = base_url() . 'user/item_details/' . $pro['product_id'];
                                                                else
                                                                    $product_path = base_url() . $pro['product_slug'];
                                                                ?>
                                                                <tr>
                                                                    <td style="padding-left:20px"><a href="<?php echo $product_path; ?>"><?php echo $flag . ". " . $pro['product_name']; ?></a></td>

                                                                    <td> <?php
                                                                        if (isset($pro['product_price']) && !empty($pro['product_price'])) {
                                                                            echo 'AED ' . number_format($pro['product_price']);
                                                                        }
                                                                        ?></td>                                                                    
                                                                </tr>
                                                                <?php
                                                                $flag++;
                                                            }
                                                        } else {
                                                            ?>
                                                            <tr>
                                                                <td>No results found</td>

                                                            </tr>
                                                        <?php }
                                                        ?>                                        	
                                                    </tbody>	
                                                </table>
                                                <nav class="col-sm-12 text-right">
                                                    <?php echo @$links; ?>
                                                </nav>
                                            </div>
                                        </div>                              
                                    </div>
                                </div>                        
                            </div>                    
                        </div>
                    </div>            
                </div>
            </div>
        </div>        
        <?php $this->load->view('include/footer'); ?>     
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/owl.carousel.js"></script>
        <script>
<?php if (isset($latest_page) && $latest_page == 'yes') { ?>
                                                                                $(document).ready(function () {
                                                                                    //featured ads
                                                                                    var owl2 = $("#owl-demo2");
                                                                                    owl2.owlCarousel({
                                                                                        autoPlay: 2000,
                                                                                        items: 4,
                                                                                        itemsDesktop: [1000, 2],
                                                                                        itemsDesktopSmall: [900, 2],
                                                                                        itemsTablet: [600, 1],
                                                                                        itemsMobile: false,
                                                                                        stopOnHover: true
                                                                                    });

                                                                                    $("#demo2_next").click(function () {
                                                                                        owl2.trigger('owl.next');
                                                                                    })
                                                                                    $("#demo2_prev").click(function () {
                                                                                        owl2.trigger('owl.prev');
                                                                                    })


                                                                                    var owl1 = $("#owl-demo1");
                                                                                    owl1.owlCarousel({
                                                                                        autoPlay: 2000,
                                                                                        items: 4,
                                                                                        itemsDesktop: [1000, 2],
                                                                                        itemsDesktopSmall: [900, 2],
                                                                                        itemsTablet: [600, 1],
                                                                                        itemsMobile: false,
                                                                                        stopOnHover: true
                                                                                    });

                                                                                    $("#demo1_next").click(function () {
                                                                                        owl1.trigger('owl.next');
                                                                                    })
                                                                                    $("#demo1_prev").click(function () {
                                                                                        owl1.trigger('owl.prev');
                                                                                    });
                                                                                });
<?php } ?>
        </script>
        <script type="text/javascript">
            $(document).on("hover", "div.addtocart .add_to_cart_cus", function (e) { 
                $('[data-toggle="tooltip"]').tooltip();
            });
            $(document).on("click", "div.addtocart .add_to_cart_cus", function (e) { 
                                var proid= $(this).attr('proid');
                                var qat=  $(this).attr('quantity');
                                check_product_quantity(proid,qat);
                                $("i."+proid).removeClass('fa-shopping-cart');
                                $("i."+proid).addClass('fa-check');
                });
                function check_product_quantity(proid, qat) {

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
    </body>
</html>
