<!DOCTYPE html>
<html lang="en">
    <head>  
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
        <?php
        $protocol = 'http'; //strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'https' : 'https'; 

        $store_start = thumb_start_grid_store_cover . HTTPS . website_url;
        $store_end = thumb_end_grid_store_cover;
        //$store_cover_img = $store_start .$share_url.$store_end;
        if ($share_url != '')
            $store_cover_img = HTTPS . website_url . $share_url;
        else
            $store_cover_img = HTTPS . website_url . 'assets/upload/store_cover_image.png';
        ?>
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="Doukani" />
        <meta property="og:title" content="<?php echo $title_; ?>'s Store" />
        <meta property="og:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:image" content="<?php echo $store_cover_img; ?>" />
        <meta property="og:description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $description_); ?>" />
        <meta name="keyword" content="<?php echo $keyword_; ?>" />

        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="Doukani">
        <meta name="twitter:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta name="twitter:title" content="<?php echo $title_; ?>'s Store">
        <meta name="twitter:description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $description_); ?>">

        <meta name="twitter:image:src" content="<?php echo $store_cover_img; ?>">
        <link rel="image_src" href="<?php echo $share_url; ?>" />      

        <script type="text/javascript">
            document.write('<style>.noscript { display: none; }</style>');
        </script>
        <script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
        <style>
            .modal-header{background-color:#ed1b33;color:white;}            
            .horizontalList{margin-left: auto;margin-right: auto;width: 80%; }
        </style>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">            
            <?php
                $this->load->view('include/header');
                $this->load->view('include/menu');

            if ($store[0]->category_id > 0) {
                ?>
                <div class="page">
                    <div class="store-page">
                        <div class="container">
                            <div class="row">
                                <?php $this->load->view('include/sub-header'); ?>
                                <div class="mainContent">
                                    <input type="hidden" name="search" id="search">
                                    <input type="hidden" name="product_view" id="product_view" value="grid">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $store_user[0]->user_id; ?>">                         
                                    <?php $this->load->view('store/store_common'); ?>
                                    <div class="store-products-wrapper">
                                        <div class="store-products-head">      
                                            <h2><?php echo $store[0]->store_name . '\'s Store'; ?>
                                                <span class="since_line">(Since <?php echo $store_user_regidate; ?>)</span></h2>

                                            <div class="col-sm-12 text-right views">
                                                <a href="javascript:void(0);" class="product_view list" data-id="list"><span class="fa  fa-th-list"></span></a>
                                                <a href="javascript:void(0);" class="product_view grid view-active" data-id="grid"><span class="fa fa-th"></span></a>
                                                <ul>
                                                    <li id="all" class="active"><a href="javascript:void(0);" class="type" data-id="all">All</a></li>
                                                    <li id="new"><a href="javascript:void(0);" class="type" data-id="new">New</a></li>
                                                    <li id="popular"><a href="javascript:void(0);" class="type" data-id="popular">Popular</a></li>
                                                </ul>
                                            </div>
                                        </div>     
                                        <div class="catlist">
                                            <div class="store-products-list-wrapper" id="reset_data">
                                                <?php $this->load->view('store/product_store_grid_view'); ?>
                                                <!--item1-->
                                                <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                                <?php if (@$hide == "false") { ?>
                                                    <div class="col-sm-12 text-center" id="load_more">
                                                        <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br><br>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
                <?php $this->load->view('store/store_common_div'); ?>
            <?php } else { ?>
                <iframe src="<?php echo $store[0]->website_url; ?>" id="website_load" style="border:none;"></iframe>
            <?php } $this->load->view('include/footer'); ?>
        </div>
        <div id="loading" style="text-align:center" class="loader_display">
            <img id="loading-image1" src="<?php echo HTTPS . website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
        </div>
        <script>
<?php
$mypath_ = $store_url;
?>
            $('#loader_display').show();
            function load_more_data() {

                $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_product').prop('disabled', true);

                var load_more_status = $('#load_more_status').val();
                var url = "<?php echo $mypath_; ?>home/load_more_storelisting/";
                var start = $("#load_product").val();
                start++;
                $("#load_product").val(start);
                var user_id = $("#user_id").val();
                var product_view = $('#product_view').val();
                var type = $('#search').val();
                var val = $("#val").val();
                var val1 = start;

                if (load_more_status == 'false') {
                    $.post(url, {value: val1, user_id: user_id, product_view: product_view, type: type, val: val, user_status:<?php echo $user_status; ?>, state_id_selection: state_id_selection}, function (response)
                    {
                        $('#load_more_status').val(response.val);

                        $("#load_more").before(response.html);
                        if (response.val == "true")
                            $("#load_product").hide();

                        $('#load_product').prop('disabled', false);
                        $("#load_product").html('Load More');
//                        $(window).bind('scroll', bindScroll);

                    }, "json");
                }
            }

            $(document).on("click", ".product_view", function (e) {
                $('.loader_display').show();
                e.preventDefault();
                var search = $(this).attr('data-id');
                var val1 = 1;
                $('#product_view').val(search);
                var product_view = $('#product_view').val();
                var type = $('#search').val();
                var user_id = $("#user_id").val();

                if (search == 'grid') {
                    $('.' + search).addClass('view-active');
                    $('.list').removeClass('view-active');
                }
                else if (search == 'list') {
                    $('.' + search).addClass('view-active');
                    $('.grid').removeClass('view-active');
                }

                var url = "<?php echo $mypath_; ?>home/get_store_products";
                $.post(url, {value: val1, product_view: product_view, type: type, user_id: user_id, user_status:<?php echo $user_status; ?>, state_id_selection: state_id_selection}, function (response) {
                    $('#reset_data').html('');
                    $('#reset_data').html(response.html);

                    $('.loader_display').hide();
                }, "json");

            });

            $(document).on("click", ".type", function (e) {
                $('.loader_display').show();
                e.preventDefault();

                var val1 = 1;
                var url = "<?php echo $mypath_; ?>home/get_store_products";
                var user_id = $("#user_id").val();
                var search = $(this).attr('data-id');

                $('#search').val(search);

                var product_view = $('#product_view').val();
                var type = $('#search').val();

                if (search == 'all') {
                    $("#" + search).addClass("active");
                    $("#new").removeClass("active");
                    $("#popular").removeClass("active");
                }
                else if (search == 'new') {
                    $("#" + search).addClass("active");
                    $("#all").removeClass("active");
                    $("#popular").removeClass("active");
                }
                else if (search == 'popular') {
                    $("#" + search).addClass("active");
                    $("#all").removeClass("active");
                    $("#new").removeClass("active");
                }

                $.post(url, {value: val1, product_view: product_view, type: type, user_id: user_id, user_status:<?php echo $user_status; ?>, state_id_selection: state_id_selection}, function (response) {
                    $('#reset_data').html('');
                    $('#reset_data').html(response.html);

                    $('.loader_display').hide();
                }, "json");
            });

<?php
$store_address = '';
$state_name_s = '';
if (isset($store_user[0]->address) && !empty($store_user[0]->address))
    $store_address = $store_user[0]->address . ',';
if (isset($store_user[0]->state) && !empty($store_user[0]->state)) {
    $state_name_s = $this->dbcart->state_name($store_user[0]->state);
    $store_address .= $state_name_s[0]->state_name . ',';
}
if (!empty($store_address))
    $store_address .= 'United Arab Emirates';
else
    $store_address = 'United Arab Emirates';
if (!empty($store_address)) {
    ?>
    var address = '<?php echo $store_address; ?>';
    $('#store_on_google').attr('href', 'https://maps.google.com/maps/place/' + address);

<?php } ?>
    
    jQuery(document).ready(function (e) {
        
        var header_section = parseInt($('#HeadertopSection').height());
        var header_second = parseInt($('.HeaderSecound').height());
        var bottom = parseInt($('#bottom').height());
        var sum = parseInt(header_section) + parseInt(header_second) + parseInt(bottom);
        var window_height = parseInt($( window ).height());
        var window_width = parseInt($( window ).width());
        var get_height = parseInt(window_height) - parseInt(sum);
//        console.log(header_section + "==" + header_second +"====" + sum +"====" + window_height + "===" + get_height);
        $('#website_load').height(get_height);
        $('#website_load').width('100%');
        var resizeId;
        $(window).resize(function () {
            clearTimeout(resizeId);
            resizeId = setTimeout(doneResizing, 200);

            var header_section = parseInt($('#HeadertopSection').height());
            var header_second = parseInt($('.HeaderSecound').height());
            var bottom = parseInt($('#bottom').height());
            var sum = parseInt(header_section) + parseInt(header_second) + parseInt(bottom);
            var window_height = parseInt($( window ).height());
            var window_width = parseInt($( window ).width());
            var get_height = parseInt(window_height) - parseInt(sum);
            $('#website_load').height(get_height);
            $('#website_load').width('100%');
//            console.log(header_section + "==" + header_second +"====" + sum +"====" + window_height + "===" + get_height);
        });
        
        $('#loader_display').hide();
    });
    
    $(document).find('#Layer_5').css("margin-top", "-20px");
        </script>
    </body>
</html>
