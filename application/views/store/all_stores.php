<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
        <style>
            .modal-header{
                background-color:#ed1b33;
                color:white;
            }
        </style> 
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="store-pages">
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>
                        <div class="mainContent all-store-page">
                            <?php if ($this->session->flashdata('msg1')): ?>
                                <div class='alert  alert-info'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <center><?php echo $this->session->flashdata('msg1'); ?></center>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <?php if (sizeof($featured_stores) > 0) { ?>
                                    <div class="offer-banner">
                                        <h1 class="wrap-title">FEATURED STORES</h1>
                                        <div id="owl-demo1" class="owl-carousel">
                                            <?php
                                            foreach ($featured_stores as $fea) {
                                                $store_cover_image = '';

                                                $store_start = thumb_start_grid_store_cover . HTTPS . website_url;
                                                $store_end = thumb_end_grid_store_cover;
                                                //$store_cover_image = $store_start . store_cover . "small/" .$fea['store_cover_image'].$store_end;
                                                if ($fea['store_cover_image'] != '')
                                                    $store_cover_image = $store_start . store_cover . "original/" . $fea['store_cover_image'] . $store_end;
                                                else
                                                    $store_cover_image = $store_start . HTTPS . website_url . 'assets/upload/store_cover_image.png' . $store_end;

                                                $profile_picture = '';

                                                $profile_picture = $this->dbcommon->load_picture($fea['profile_picture'], $fea['facebook_id'], $fea['twitter_id'], $fea['username'], $fea['google_id'], 'original', 'all-store-user');

                                                $store_link = HTTP . $fea['store_domain'] . after_subdomain . remove_home;
                                                ?>
                                                <div class="item ">
                                                    <div class="store-block">
                                                        <div class="store-banner" style="background-image:url(<?php echo $store_cover_image; ?>);"></div>
                                                        <div class="store-iiner">
                                                            <div class="store-tbl">
                                                                <div class="tbl-cell"><a href="<?php echo $store_link; ?>" class="str-btn"><i class="fa fa-eye"></i> Store</a></div>
                                                                <div class="tbl-cell">
                                                                    <a  href="<?php echo $store_link; ?>" rel="nofollow">
                                                                        <div class="store-avtar">
                                                                            <img src="<?php echo $profile_picture; ?>" alt="Image" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                                <?php
                                                                $btn_name = '<i class="fa fa-plus"></i> Follow';
                                                                if (isset($login_userid) && $login_userid != '') {
                                                                    $count_array = array('user_id' => $login_userid,
                                                                        'seller_id' => $fea['user_id']);

                                                                    $is_following = $this->dbcommon->get_count('followed_seller', $count_array);
                                                                } else
                                                                    $is_following = 0;

                                                                if ($is_following > 0)
                                                                    $btn_name = 'Following';

                                                                if (isset($login_userid)) {
                                                                    if ($login_userid != $fea['user_id']) {
                                                                        if ($btn_name == 'Following') {
                                                                            ?>
                                                                            <div class="tbl-cell"><a href="<?php echo base_url(); ?>allstores/unfollow/<?php echo $fea['user_id']; ?>" class="str-btn following1" id="following<?php echo $fea['user_id']; ?>"><?php echo $btn_name; ?></a></div>
                                                                            <?php
                                                                        } else {
                                                                            if (isset($current_user) && (sizeof($current_user) == 0) || (isset($current_user) && sizeof($current_user) > 0 && $current_user != '' && $current_user['user_id'] != $fea['user_id'])) {
                                                                                ?>
                                                                                <div class="tbl-cell"><a href="<?php echo base_url(); ?>allstores/addfollow/<?php echo $fea['user_id']; ?>" class="str-btn"><?php echo $btn_name; ?></a></div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    }
                                                                    else { ?>
                                                                        <div class="tbl-cell"><a href="javascript:void(0);" class="str-btn">-</a></div>
                                                                    <?php }
                                                                } else {
                                                                    ?>
                                                                    <div class="tbl-cell"><a href="<?php echo base_url(); ?>login/index" class="str-btn"> <?php echo $btn_name; ?></a></div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="store-name"><a  href="<?php echo $store_link; ?>" rel="nofollow"><h3><?php echo $fea['store_name']; ?></h3></a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="customNavigation">
                                            <a class="prev" id="demo1_prev"></a>
                                            <a class="next" id="demo1_next"></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="offer-wrap">
                                <div class="gray-box">
                                    <div class="cate-listing">
                                        <div class="menu_cat">                                            
                                            <div class="menuCategories"></div>
                                        </div>
                                        <div class="cate-list all_stores_cat_list">
                                            <ul class="list-ul boxes wide">
                                                <li class="-1"> 
                                                    <a href="javascript:void(0);" class="category_chk chk_all" data-id="-1">
                                                        <div class="cate-block">
                                                            <div class="cate-icn" style="color: #05a846;"><i class="fa fa-repeat"></i></div>
                                                            <h4 class="cate-name"><span>All</span></h4>
                                                        </div>
                                                    </a> 
                                                </li>
                                                <li class="0">
                                                    <a href="javascript:void(0);" class="category_chk chk_others" data-id="0">
                                                        <div class="cate-block">
                                                            <div class="cate-icn" style="color: #0066ff;"><i class="fa fa-globe"></i></div>
                                                            <h4 class="cate-name"><span>Store Websites</span></h4>
                                                        </div>
                                                    </a> 
                                                </li>
                                                <?php foreach ($category as $cat): ?>
                                                    <li class="<?php echo $cat['category_id']; ?>"> 
                                                        <a href="javascript:void(0);" class="category_chk chk_others" data-id="<?php echo $cat['category_id']; ?>">
                                                            <div class="cate-block">
                                                                <div class="cate-icn" style="color: <?php echo $cat['color']; ?>;"><i class="fa <?php echo $cat['icon']; ?>"></i></div>
                                                                <h4 class="cate-name"><span><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></span></h4>
                                                            </div>
                                                        </a> 
                                                    </li>         
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="categories" id="categories"> 
                            <input type="hidden" name="filter_sel" id="filter_sel">
                            <div class="store-list">
                                <div class="gray-box">
                                    <div class="store-category-head">
                                        <h1 class="wrap-title">Store Listing</h1>
                                        <div class="search-by-div">
                                            <label>Search By:</label>
                                            <select id="filter" name="filter" class="selectpicker">
                                                <option value="">Default</option>
                                                <option value="1">New</option>
                                                <option value="2">Popular</option>
                                            </select>
                                        </div>            
                                    </div>

                                    <div class="row" id="reset_data">
                                        <?php $this->load->view('store/store_grid_view'); ?>
                                        <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                        <?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_store" value="0">Load More</button><br><br><br>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
            <div id="loading" style="text-align:center" class="loader_display">
                <img id="loading-image1" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
            </div>
<?php $this->load->view('include/footer'); ?>            
        </div>


        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/owl.carousel.js"></script>    
        <script>

            var owl = $("#owl-demo1");
            owl.owlCarousel({
                autoPlay: 2000,
                items: 4,
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

            jQuery(document).on('mouseenter', ".following1", function (event) {
                $(this).text('Un-follow  ');
            });

            jQuery(document).on('mouseout', ".following1", function (event) {
                $(this).text('Following');
            });

            jQuery(document).on('mouseenter', ".following", function (event) {
                $(this).text('Un-follow ');
            });

            jQuery(document).on('mouseout', ".following", function (event) {
                $(this).text('Following');
            });

            $(document).ready(function () {

                $('.store-individual-user-social-toggle').click(function () {
                    $('.store-individual-user-social ul').slideToggle();
                });
                $('.store-individual-user-right-toggle').click(function () {
                    $('.store-individual-user-right > ul').slideToggle();
                });

                $('.chk_all').prop('checked', true);
                $('.chk_others').prop('checked', false);

                $('.category_chk').on('click', function (e) {
                    console.log("Click Event");
                    $('#categories').val($(this).attr('data-id'));
                    var window_width = parseInt($( window ).width());    
                    if(window_width<=1024) {        
                        $('html, body').animate({
                            scrollTop: $(".store-list").offset().top
                       }, 2000);
                    }
                    get_data("single");
                });

                $('#filter').on('change', function (e) {
                    console.log("Change Event");
                    get_data("filter");
                });

                function get_data(selection) {
                    
                    var cat_id = $('#categories').val();
                    
                    if(selection=="single") {
                        $('li').removeClass('active');
                        $('li.'+cat_id).addClass('active');
                    }
                    
                    $('.loader_display').show();
                    
                    var filters = '';
                    var filter_val = '';

                    filter_val = $('#filter').val();
                    $('#filter_sel').val(filter_val);
                    filters = $('#filter_sel').val();

                    $("#load_store").prop('value', '0');

                    var start = $("#load_store").val();
                    start++;
                    $("#load_store").val(start);
                    //                  console.log($("#load_store").val());
                    var val1 = start;
                    var url = "<?php echo base_url(); ?>allstores/get_stores";

                    $.post(url, {cat_id: cat_id, value: val1, filters: filters}, function (response)
                    {
                        $('#reset_data').html('');
                        $('#reset_data').html(response.html);
                        if (response.val == "true") {
                            $("#load_store").hide();
                        }
                        $('.loader_display').hide();
                    }, "json");
                }
            });

            function load_more_data() {

                $("#load_store").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_store').prop('disabled', true);

                var load_more_status = $('#load_more_status').val();
                var cat_id = $('#categories').val();
                var url = "<?php echo base_url(); ?>allstores/load_more_stores/";
                var start = $("#load_store").val();
                start++;

                $("#load_store").val(start);
                var val1 = start;

                if (load_more_status == 'false') {
                    $.post(url, {value: val1, cat_id: cat_id}, function (response)
                    {
                        $('#load_more_status').val(response.val);

                        $("#load_more").before(response.html);
                        if (response.val == "true") {
                            $("#load_store").hide();
                        }
                        $('#load_store').prop('disabled', false);
                        $("#load_store").html('Load More');

                    }, "json");
                }
            }

            function load_more_jquerylisting() {
                
                $("#load_storesearch").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_storesearch').prop('disabled', true);
                
                var load_more_status1 = $('#load_more_status1').val();
                var cat_id = $('#categories').val();
                var url = "<?php echo base_url(); ?>allstores/load_more_stores/";
                var start = $("#load_storesearch").val();
                start++;

                $("#load_storesearch").val(start);
                var val1 = start;

                filter_val = $('#filter').val();
                $('#filter_sel').val(filter_val);
                filters = $('#filter_sel').val();

                if (load_more_status1 == 'false') {
                    $.post(url, {value: val1, cat_id: cat_id, filters: filters, state_id_selection: state_id_selection}, function (response)
                    {
                        $('#load_more_status1').val(response.val);
                        $("#load_moresearch").before(response.html);
                        if (response.val == "true") {
                            $("#load_storesearch").hide();
                        }
                        $('#load_storesearch').prop('disabled', false);
                        $("#load_storesearch").html('Load More');
                    }, "json");
                }
            }
        </script>
    </body>
</html>