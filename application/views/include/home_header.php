<div id="HeadertopSection">	
    <div class="header-banner">	
        <?php if ($this->session->userdata('gen_user')) { ?>
            <a href="<?php echo base_url(); ?>user/post_ads" class="postaddButton">
                <img src="<?php echo base_url(); ?>assets/upload/banner/postfree.jpg"  class="img-responsive center-block" target="_blank"/>
            </a>
        <?php } else { ?>
            <a href="<?php echo base_url(); ?>user/post_ads" class="postaddButton">
                <img src="<?php echo base_url(); ?>assets/upload/banner/postfree.jpg"  class="img-responsive center-block" target="_blank"/>
            </a>
        <?php } ?>
        <?php
        $this->load->model('dbcommon', '', TRUE);
        $intro_banners = $this->dbcommon->getBanners_forhome('header', "'home_page','all_page'");
        if (isset($intro_banners[0]['ban_id']) && $intro_banners[0]['ban_id'] != '') {
            $mycnt = $intro_banners[0]['impression_count'] + 1;
            $array1 = array('ban_id' => $intro_banners[0]['ban_id']);
            $data1 = array('impression_count' => $mycnt);
            $this->dbcommon->update('custom_banner', $array1, $data1);
        }
        if (!empty($intro_banners)) {
            ?>
            <a href="<?php echo $intro_banners[0]['site_url']; ?>" target="_blank"  onclick="javascript:update_count('<?php echo $intro_banners[0]['ban_id']; ?>')" class="mybanner" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $intro_banners[0]['big_img_file_name'] ?>" class="img-responsive center-block" /></a>
        <?php } else {
            ?>
            <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/ad1.png" class="img-responsive" /></a>
            <?php } ?>
    </div>
</div>	
<script type="text/javascript">
    function update_count(a)
    {
        var url = "<?php echo base_url() ?>home/update_click_count";
        $.post(url, {ban_id: a}, function (response)
        {
        }, "json");
    }
    
    $(document).on("click", "div.newthumb a i", function (e) {
<?php if ($is_logged != 0) { ?>
            e.preventDefault();
            var url = "<?php echo base_url(); ?>user/add_to_like";
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
            window.location = "<?php echo base_url(); ?>";
<?php } ?>
    });

    $(document).on("click", "div.star a i", function (e) {
<?php if ($is_logged != 0) { ?>
            e.preventDefault();
            var url = "<?php echo base_url(); ?>user/add_to_favorites";
            var fav = 0;
            var id = $(this).attr('id');
            var myid = $('div.star a i').attr('id');

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
                if (response.trim() == 'Success' || response.trim() == 'failure')
                    $('#err_div').hide();
                else
                {
                    $('#' + id).closest('div').removeClass('fav');
                    $('#' + id).addClass("fa-star-o");
                    $('#' + id).removeClass("fa-star");
                    $("#send-message-popup").modal('show');
                    $('#err_div').show();
                    $("#error_msg").text(response);
                }
            });
<?php } else { ?>
            window.location = "<?php echo base_url(); ?>";
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