<div id="HeadertopSection">	
    <div class="header-banner">
            <a href="<?php echo HTTPS . website_url; ?>user/post_ads" class="postaddButton">
                <img src="<?php echo HTTPS . website_url; ?>assets/upload/banner/postfree.jpg"  class="img-responsive center-block" target="_blank"/>
            </a>
        <?php 
        
        $header_slug = $this->uri->segment(1);
        $get_char_h = strstr($header_slug, '_', true);

        $this->load->model('dbcommon', '', TRUE);

        if ($this->uri->segment(1) == 'home' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index'))
            $intro_banners = $this->dbcommon->getBanner('header', "'home_page','all_page'", null, null);
        else {
            $hcat_id = NULL;
            $hsubcat_id = NULL;

            if (isset($slug_for) && $slug_for == 'category') {

                $where_h = " category_slug = '" . $header_slug . "' ";
                $category_h = $this->dbcommon->filter('category', $where_h);

                $hcat_id = (int) $category_h[0]['category_id'];
            } elseif ( isset($slug_for) &&  $slug_for == 'sub_category') {

                $where_h = " sub_category_slug = '" . $header_slug . "' ";
                $subcategory_h = $this->dbcommon->filter('sub_category', $where_h);
                // echo $this->db->last_query();
                $hsubcat_id = (int) $subcategory_h[0]['sub_category_id'];
                $hcat_id = (int) $subcategory_h[0]['category_id'];
            } elseif (isset($slug_for) &&  $slug_for == 'product') {
                $product_s = $this->dbcommon->get_product_slugwise($header_slug);
                if (sizeof($product_s) > 0) {
                    $hcat_id = $product_s->category_id;
                    $hsubcat_id = $product_s->sub_category_id;
                }
            }           
            $intro_banners = $this->dbcommon->getBanner_forCategory('header', "'content_page','all_page'", $hcat_id, $hsubcat_id);
        }

        //echo $this->db->last_query();					
        if (!empty($intro_banners)) {
            if (isset($intro_banners[0]['ban_id']) && $intro_banners[0]['ban_id'] != '') {
                $mycnt = $intro_banners[0]['impression_count'] + 1;
                $array1 = array('ban_id' => $intro_banners[0]['ban_id']);
                $data1 = array('impression_count' => $mycnt);
                $this->dbcommon->update('custom_banner', $array1, $data1);
            }
            if ($intro_banners[0]['ban_txt_img'] == 'image') {
                ?>

                <a href="<?php echo $intro_banners[0]['site_url']; ?>" target="_blank"  onclick="javascript:update_count('<?php echo $intro_banners[0]['ban_id']; ?>')" class="mybanner"><img src="<?php echo HTTPS . website_url; ?>assets/upload/banner/original/<?php echo $intro_banners[0]['big_img_file_name']; ?>" width="100%" class="img-responsive center-block" target="_blank"/></a>

            <?php } elseif ($intro_banners[0]['ban_txt_img'] == 'text') {
                ?>
                <a href="<?php echo $intro_banners[0]['site_url']; ?>" target="_blank"  onclick="javascript:update_count('<?php echo $intro_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" id="headerbanner" style="text-decoration:none;">
                    <div class="">
                        <?php
                        echo $intro_banners[0]['text_val'];
                        ?>
                    </div>
                </a>											
                <?php
            }
        }
        ?>
    </div>
</div> 
<script type="text/javascript">

    $(document).ready(function () {


        <?php if ($intro_banners[0]['ban_txt_img'] == 'text') { ?>
                var but_height = $('.postaddButton').height();
                $('#headerbanner').css('height', but_height);
        <?php } ?>
        var resizeId;
        $(window).resize(function () {
            clearTimeout(resizeId);
            resizeId = setTimeout(doneResizing, 200);
           
            // var h = $('.catlist .col-lg-3 .item-sell .item-img img').height();
            // $('.catlist .col-lg-3 .item-sell .item-img').css('height', h);

            // var w1 = $('.header-banner').width();

            var h = $('#most-viewed .col-lg-3 .item-sell .item-img img').height();            
            $('#most-viewed .col-lg-3 .item-sell .item-img').height(h);

            var btnw = $('.postaddButton').width();
            $('.btn.btn-app').css('width', btnw);

        });

        function doneResizing(){
            var nw = $('.owl-wrapper .owl-item .item-img').width();
            var nh = $('.owl-wrapper .owl-item .item-img').height();

            console.log('nw = ', nw);
            console.log('nh = ', nh);

            $('.owl-wrapper .owl-item .item-img a').css('width',nw);
            $('.owl-wrapper .owl-item .item-img a').css('height',nh);
        }

              
        var btnw = $('.postaddButton').width();
        $('.btn.btn-app').css('width', btnw);

    });

    function update_count(a)
    {
        var url = "<?php echo HTTPS . website_url; ?>home/update_click_count";
        $.post(url, {ban_id: a}, function (response)
        {
        }, "json");
    }
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-70149834-1', 'auto');
    ga('send', 'pageview');

    $(document).on("click", "div.newthumb a i", function (e) {
        <?php if (isset($is_logged) && $is_logged != 0) { 
             if(isset($store_url) && $store_url!='')
                $mypath_ = $store_url.'/';
            else
                $mypath_ = base_url();
            
        ?>
            e.preventDefault();
            var url = "<?php echo $mypath_; ?>user/add_to_like";
            var thu = 0;
            var id = $(this).attr('id');

            if ($(this).hasClass('fa-thumbs-o-up')) {                
                $(this).closest('div').addClass('thu');
                $(this).removeClass("fa-thumbs-o-up");
                $(this).addClass("fa-thumbs-up");
                thu = 1;
            } else if ($(this).hasClass('fa-thumbs-up')) {                
                $(this).closest('div').removeClass('thu');
                $(this).addClass("fa-thumbs-o-up");
                $(this).removeClass("fa-thumbs-up");
                thu = -1;
            }

            $.post(url, {value: thu, product_id: id}, function (response) {
                if (response.trim() == 'Success' || response.trim() == 'failure')
                    $('#err_div').hide();
                else
                {
                    $('#' + id).closest('div').removeClass('thu');
                    $('#' + id).addClass("fa-thumbs-o-up");
                    $('#' + id).removeClass("fa-thumbs-up");
                    $("#send-message-popup").modal('show');
                    $('#err_div').show();
                    $("#error_msg").text(response);
                }
            });
        <?php } else { ?>
                    window.location = "<?php echo site_url(); ?>";
        <?php } ?>
    });
    <?php 
        $session_id =  session_id();
    ?>
    $(document).on("click", "div.star a i", function (e) {
        <?php if ($is_logged != 0) { 

            if(isset($store_url) && $store_url!='')
                $mypath_ = $store_url;
            else
                $mypath_ = base_url();
        ?>
            e.preventDefault();
            var url = "<?php echo $mypath_; ?>user/add_to_favorites";
            var fav = 0;
            var id  = $(this).attr('id');

            if ($(this).hasClass('fa-star-o')) {

                $(this).closest('div').addClass('fav');
                $(this).removeClass("fa-star-o");
                $(this).addClass("fa-star");
                fav = 1;
            } else if ($(this).hasClass('fa-star')) {

                <?php if(isset($favorite_ads) && $favorite_ads=='yes') { ?> 
                    $('.prod_' + id).hide();
                <?php } ?>
                $(this).closest('div').removeClass('fav');
                $(this).addClass("fa-star-o");
                $(this).removeClass("fa-star");
                fav = -1;
            }
            var getthis = this;
            $.post(url, {value: fav, product_id: id}, function (response) {                
                if (response.trim() == 'Success' || response.trim() == 'failure')
                    $('#err_div').hide();
                else
                {
                    console.log(getthis);
                    $('i').find('#' + id).closest('div').removeClass('fav');
                    $('i').find('#' + id).addClass("fa-star-o");
                    $('i').find('#' + id).removeClass("fa-star");
                    $("#send-message-popup").modal('show');
                    $('#err_div').show();
                    $("#error_msg").text(response);
                }
            });
        <?php } else { ?>                
                    window.location = "<?php echo site_url(); ?>";
        <?php } ?>
    });
</script>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/56cfe12c1b785aae04c37470/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })(); 
</script>
<!--End of Tawk.to Script-->