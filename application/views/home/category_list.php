<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>      
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
        <script src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/masonry.pkgd.js"></script>
        <script src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/imagesloaded.pkgd.js"></script>
        <style>            
            .grid:after {content: '';display: block;clear: both;}
            .grid{margin:0 -15px;}
            .grid-sizer,.grid-item {width: 25%;padding:0 15px 30px;}
            .grid-item {float: left;}
            .grid-item img {display: block;max-width: 100%;}
            .category_sec ul.list-unstyled li:first-child{font-size:16px;}
            .category_sec ul.list-unstyled li:first-child .fa{vertical-align:1px;}
            .category_sec ul.list-unstyled .mybtn.red-btn{margin:10px 0;}
            @media(max-width:1200px){.grid-sizer,.grid-item {width: 33.33333%;}}
            @media(max-width:990px){.grid-sizer,.grid-item {width: 50%;}}
            @media(max-width:767px){.ProducstdetailsOuter{display:block;}}
            @media(max-width:600px){.grid-sizer,.grid-item {width: 100%;}}
        </style>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
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
                                                <a href="#latest_tab" role="tab" data-toggle="tab"  rel="nofollow" >
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
                                                        <a class="prev" id="demo2_prev" rel="nofollow" ><span class="fa fa-chevron-circle-left"></span></a>
                                                        <a class="next" id="demo2_next" rel="nofollow" ><span class="fa fa-chevron-circle-right"></span></a>
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
                                                    if (strpos($feature_banners[0]['site_url'], 'http://') !== false || strpos($feature_banners[0]['site_url'], 'https://') !== false) {
                                                        $feature_banner_url = 'href="' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                    } else {
                                                        $feature_banner_url = 'href="http://' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                    }
                                                    ?>
                                                    <a <?php echo $feature_banner_url; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" rel="nofollow" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner" /></a>
                                                    <?php
                                                } elseif ($feature_banners[0]['ban_txt_img'] == 'text') {
                                                    if (strpos($feature_banners[0]['site_url'], 'http://') !== false || strpos($feature_banners[0]['site_url'], 'https://') !== false) {
                                                        $feature_banner_url1 = 'href="' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                    } else {
                                                        $feature_banner_url1 = 'href="http://' . $feature_banners[0]['site_url'] . '" target="_blank"';
                                                    }
                                                    ?>
                                                    <a <?php echo $feature_banner_url; ?> onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" rel="nofollow">
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
                                <br>
                                <br>
                                <div class='postadBG'>
                                    <div class='box-header'>
                                        <div class='title'>
                                            <h4 style="color:red">Categories</h4>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class='box-content box-padding category_sec '>
                                        <div class="col-sm-12 ProducstdetailsOuter category_sec">
                                            <div class="grid">
                                                <div class="grid-sizer"></div>
                                                <?php foreach ($category as $cat) { ?>
                                                    <div class="grid-item">
                                                        <ul class="list-unstyled" style="margin-bottom:0;"> 
                                                            <li>
                                                                <a style="color: <?php echo $cat['color']; ?>" href="<?php echo base_url() . emirate_slug . $cat['category_slug']; ?>"><b>
                                                                        <i class="fa <?php echo $cat['icon']; ?>"></i>
                                                                        <?php echo str_replace('\n', " ", $cat['catagory_name']); ?></b>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <?php if ($this->session->userdata('gen_user')) { ?>
                                                                    <a  class="btn mybtn red-btn" href="<?php echo base_url() . 'user/post_ads'; ?>" ><i class="fa fa-pencil-square-o"></i> <b>Post Free Ad</b></a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo base_url() . 'user/post_ads'; ?>"  class="btn mybtn red-btn"><i class="fa fa-pencil-square-o"></i> <b>Post Free Ad</b></a>
                                                                <?php } ?>
                                                            </li>
                                                            <?php
                                                            $sel_state = $this->uri->segment(1);
                                                            if (empty($sel_state))
                                                                $this->session->unset_userdata('request_for_statewise');

                                                            if (!empty($sel_state) && in_array(strtolower($sel_state), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
                                                                $this->session->set_userdata('request_for_statewise', $sel_state);
                                                                $sel_state = $this->session->userdata('request_for_statewise');
                                                            } elseif (isset($_REQUEST['state_id_selection']))
                                                                $sel_state = $_REQUEST['state_id_selection'];
                                                            elseif ($this->session->userdata('request_for_statewise') != '')
                                                                $sel_state = $this->session->userdata('request_for_statewise');

                                                            $state_sql = '';
                                                            if (in_array(state_id_selection, array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
                                                                $selected_state_id = $this->dbcommon->state_id($sel_state);
                                                                $state_sql = ' and state_id=' . $selected_state_id;
                                                            }


                                                            $query = $this->db->query('select sub_category_slug,category_id,sub_category_name,sub_category_id	,if(product_count IS NULL  OR product_count="",0,product_count) product_count1,
if(new_count IS NULL  OR new_count="",0,new_count)	new_count1
			
from sub_category 
left join 
	(select count(*) product_count, sub_category_id p_sub_category_id  from product p where p.product_for="classified" and p.product_is_inappropriate="Approve" and p.is_delete=0 and p.product_deactivate Is NULL and  p.category_id=' . $cat['category_id'] . $state_sql . ' group by p.sub_category_id) k
	on 
	sub_category.sub_category_id=p_sub_category_id
left join 
	(select sub_category_id pp_sub_category_id , count(*) new_count from product pp where pp.product_for="classified" and pp.product_is_inappropriate="Approve" and pp.is_delete=0 and pp.product_deactivate Is NULL and  pp.category_id=' . $cat['category_id'] . $state_sql . ' and DATE_FORMAT(pp.admin_modified_at,"%Y-%m-%d")=CURDATE() ) k1
	on 
	sub_category.sub_category_id=pp_sub_category_id        
where sub_category.category_id=' . $cat['category_id'] . ' AND FIND_IN_SET(0, sub_category.sub_category_type) > 0 group by sub_category.sub_category_id order by sub_cat_order asc');
                                                            $sub_category = $query->result_array();

                                                            foreach ($sub_category as $sub_cat) {
                                                                if ($cat['category_id'] == $sub_cat['category_id']) {
                                                                    ?>
                                                                    <li class="li_hr">
                                                                        <a href="<?php echo base_url() . emirate_slug . $sub_cat['sub_category_slug']; ?>">
            <?php echo str_replace('\n', " ", $sub_cat['sub_category_name']); ?>
                                                                            <?php echo '(' . $sub_cat['product_count1'] . ')'; ?>


            <?php if ((int) $sub_cat['new_count1'] > 0) { ?>
                                                                                <span class="btn btn-success" style="height:23px;padding:0px;width:45px;">New</span>
                                                                            <?php } else echo ''; ?>  
                                                                        </a>  
                                                                    </li>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                        </ul>
                                                    </div>
                                                        <?php } ?>
                                            </div>
                                        </div>
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
        </div>    
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/owl.carousel.js"></script>

        <script type="text/javascript">

                                                $(document).ready(function () {

                                                    var $grid = $('.grid').imagesLoaded(function () {
                                                        // init Masonry after all images have loaded
                                                        $grid.masonry({
                                                            itemSelector: '.grid-item',
                                                            percentPosition: true,
                                                            columnWidth: '.grid-sizer'});
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