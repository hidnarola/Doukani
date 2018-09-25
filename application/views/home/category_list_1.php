<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>      
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>			
            <?php $this->load->view('include/menu'); ?>
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
                            <!--//cat-->
                            <!--content-->
                            <div class="col-sm-10 ContentRight">
                                <div class="latest">
                                    <div class="col-sm-8 latest-ad">
                                        <?php
                                        $active2 = '';
                                        if (sizeof($latest_product) > 0)
                                            $active2 = 'active';
                                        ?>
                                        <ul id="myTabs" class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="<?php echo $active2; ?>">
                                                <a href="#latest_tab" aria-controls="proflatest_tabile" role="tab" data-toggle="tab">
                                                    <h3>Latest Posted Items</h3>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="latest_tab">
                                                <?php if (sizeof($latest_product) > 0) { ?>
                                                    <div id="owl-demo2" class="owl-carousel">
                                                        <?php $this->load->view('home/latest_products_grid_view'); ?>
                                                    </div>
                                                    <div class="customNavigation">
                                                        <a class="prev" id="demo2_prev"><span class="fa fa-chevron-circle-left"></span></a>
                                                        <a class="next" id="demo2_next"><span class="fa fa-chevron-circle-right"></span></a>
                                                    </div>
                                                <?php } else { ?>                                     
                                                    <p>&nbsp;&nbsp;No results found.</p>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="ad-banner-square home_sidebar_banner">
                                            <?php
                                            if (!empty($feature_banners)) {
                                                if ($feature_banners[0]['ban_txt_img'] == 'image') {
                                                    ?>
                                                    <a href="<?php echo '//' . $feature_banners[0]['site_url']; ?>" target="_blank" onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner" /></a>
                                                    <?php
                                                } elseif ($feature_banners[0]['ban_txt_img'] == 'text') {
                                                    ?>
                                                    <a href="<?php echo '//' . $feature_banners[0]['site_url']; ?>" target="_blank"  onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block">
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
                                <div class='postadBG'>
                                    <div class='box-header'>
                                        <div class='title'>
                                            <i class='icon-keyboard'></i>
                                            <h4 style="color:red">Categories</h4>
                                        </div>
                                    </div>
                                    <div class='box-content box-padding category_sec '>
                                        <?php
                                        $this->load->model('dbcommon', '', TRUE);
                                        $arr = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
                                        ?>

                                        <table>

                                            <?php
                                            $i = 0;
                                            $cnt = sizeof($category);
                                            foreach ($category as $cat) {
                                                if ($i == 0) {
                                                    echo '<tr>';
                                                    $j=0;
                                                }
                                                if ($i % 4 === 0 && $i!=0) {
                                                    echo '</tr><tr>';
                                                    $j=0;
                                                }
                                                echo "<td>";
                                                ?>
                                                <div class="categories-list-post list-unstyled">
                                                    <h4>
                                                        <a style="color: <?php echo $cat['color']; ?>" href="<?php echo base_url() . $cat['category_slug']; ?>"><b>
                                                                <i class="fa <?php echo $cat['icon']; ?>"></i>
                                                <?php echo str_replace('\n', " ", $cat['catagory_name']); ?></b>
                                                        </a>
                                                    </h4>
                                                    <h3>
                <?php if ($this->session->userdata('gen_user')) { ?>
                    <a  class="btn mybtn red-btn" href="<?php echo base_url() . 'user/post_ads'; ?>" ><i class="fa fa-pencil-square-o"></i> <b>Post Free Ad</b></a>
<?php } else { ?>
                    <a href="<?php echo base_url() . 'user/post_ads'; ?>"  class="btn mybtn red-btn"><i class="fa fa-pencil-square-o"></i> <b>Post Free Ad</b></a>
                <?php } ?>
            </h3>
            <ul>
                        <?php foreach ($sub_category as $sub_cat) {
                            if ($cat['category_id']==$sub_cat['category_id']) { ?>
                        <li class="li_hr">
                            <a href="<?php echo base_url() . $sub_cat['sub_category_slug']; ?>">
                            <?php echo str_replace('\n', " ", $sub_cat['sub_category_name']); ?>
                            <?php echo '(' . $this->dbcommon->count_product_cat($sub_cat['sub_category_id']) . ')'; ?>
                            </a>
                        <?php if ($this->dbcommon->get_today_product($sub_cat['sub_category_id']) > 0) { ?>
                                <span class="btn-success" style="height:20px;padding:0px;">New</span>
                <?php } else echo ''; ?>
                        </li>
        <?php }
    } ?>
            </ul>
                                                    
                                                </div>
                                                <?php
                                                echo "</td>";
                                                $i++; $j++;
                                                if ($cnt == $i) {
                                                    $l = 4-$j;
                                                    for($k=0;$k<$l;$k++){
                                                        echo '<td></td>';
                                                    }
                                                    echo '</tr>';
                                                }
                                            }
                                            ?>

                                        </table>
                                        <?php
                                        $i = 1;

                                        foreach ($category as $cat) {
                                            if ($i % 3 === 0) {
                                                ?>
                                                <div class="categories-list-post list-unstyled">
                                                    <h4>
                                                        <a style="color: <?php echo $cat['color']; ?>" href="<?php echo base_url() . $cat['category_slug']; ?>"><b>
                                                                <i class="fa <?php echo $cat['icon']; ?>"></i>
        <?php echo str_replace('\n', " ", $cat['catagory_name']); ?></b>
                                                        </a>
                                                    </h4>





                                                </div>
    <?php } $i++; ?>
<?php } ?>         
                                        <!--//content-->
                                    </div>
                                </div>

                            </div>
                            <!--//main-->
                        </div>
                    </div>
                </div>
                <!--footer-->
<?php $this->load->view('include/footer'); ?>
                <!--//footer-->
            </div>		
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/owl.carousel.js"></script>		
            <script type="text/javascript">
                                                            $(document).ready(function () {

                                                                var carousel = $("#owl-demo");
                                                                carousel.owlCarousel({
                                                                    navigation: true,
                                                                    navigationText: [
                                                                        "<i class='icon-chevron-left icon-white'><</i>",
                                                                        "<i class='icon-chevron-right icon-white'>></i>"
                                                                    ],
                                                                });


                                                                //latest ads
                                                                var owl1 = $("#owl-demo2");
                                                                owl1.owlCarousel({
                                                                    autoPlay: 2000,
                                                                    items: 3,
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

                                                                var nw11 = $('.owl-wrapper .owl-item .item-img').width();
                                                                $('.owl-wrapper .owl-item .item-img a').css('width', nw11);
                                                                var nh11 = $('.owl-wrapper .owl-item .item-img').height();
                                                                $('.owl-wrapper .owl-item .item-img a').css('height', nh11);

                                                                $(window).resize(function () {
                                                                    var nw12 = $('.owl-wrapper .owl-item .item-img').width();
                                                                    $('.owl-wrapper .owl-item .item-img a').css('width', nw12);
                                                                    var nh12 = $('.owl-wrapper .owl-item .item-img').height();
                                                                    $('.owl-wrapper .owl-item .item-img a').css('height', nh12);
                                                                });
                                                            });

                                                            function send_postpage(a) {
                                                                window.location = "<?php echo base_url() . 'user/post_ads'; ?>/" + a;
                                                            }

                                                            $('#myTabs a').click(function (e) {
                                                                e.preventDefault()
                                                                $(this).tab('show')
                                                            })

                                                            $(".menu-wrapper").hide();
                                                            $("#btn-show").hide();
                                                            $(".featured_link").hide();
                                                            $("#cating").hide();

            </script>
            <!--container-->
    </body>
</html>