<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>	 
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body>        
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
        <div class="container-fluid">                	
            <?php $this->load->view('include/header'); ?>        
            <?php $this->load->view('include/menu'); ?>        
            <div class="page">
                <div class="container"> 
                    <div class="row">
                    <?php $this->load->view('include/sub-header'); ?>
                    <div class="offer-wrap">
                        <div class="menu_cat">
                            <div class="menuCategories"></div>
                        </div>
                        <div class="gray-box offer_page_cat">                            
                            <div class="cate-listing">
                                <div class="cate-list">
                                    <input type="hidden" name="offer_cat_id" id="offer_cat_id">
                                    <ul class="list-ul boxes wide" itemscope itemtype="https://schema.org/BreadcrumbList">                              
                                        <?php 
                                            $link_pos = 1;
                                            foreach ($offer_category as $cat) { ?>
                                            <li class="li_<?php echo $cat['category_id']; ?> category_li" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" > <!-- -active -->
                                                
                                                <a href="javascript:void(0);" data-id="<?php echo $cat['category_id']; ?>" class="off_category" itemprop="item">                                                    
                                                    <div class="cate-block">
                                                        <div class="cate-icn" style="color: <?php echo $cat['color']; ?>"><i class="fa <?php echo $cat['icon']; ?>"></i></div>                                                                                                       <h4 class="cate-name" ><span itemprop="name"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></span>
                                                        <meta itemprop="position" content="<?php echo $link_pos; ?>" />
                                                        </h4>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php $link_pos++; } ?>
                                            <li> <!-- -active -->
                                                <a href="<?php echo site_url().'companies'; ?>">
                                                    <div class="cate-block">
                                                        <div class="cate-icn"><i class="fa fa-refresh"></i></div>
                                                        <h4 class="cate-name"><span>Reset</span></h4>
                                                    </div>
                                                </a>
                                            </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="gray-box">
                            <h3 class="wrap-title">Companies</h3>
                            <div class="comp-listing">
                                <div class="comp-list">
                                    <div id="loading_image" style="text-align:center;display:none;">
                                        <img src="<?php echo HTTPS . website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
                                    </div>
                                    <ul class="comp-ul wide company-list-ul-li">
                                        <?php $this->load->view('offer/companies_logo_list'); ?>
                                        <?php if (@$hide == "false") { ?>
                                        <li class="comp-block more" id="load_more">
                                            <a onclick="load_more_data();" id="load_company" value="0" href="javascript:void(0);">
                                                <div class="comp-block more">
                                                    <div class="comp-img"><span>View<br>More</span></div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    </ul>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <!--//main-->
            </div>
            <!--//body-->
        </div>
    
    <!--footer-->
    <?php $this->load->view('include/footer'); ?>
    <script type="text/javascript">
        
        $(".off_category").click(function () {
            
            var window_width = parseInt($( window ).width());    
            if(window_width<=1024) {        
                $('html, body').animate({
                    scrollTop: $(".gray-box .wrap-title").offset().top
               }, 2000);
            }
            
           $(document).find("#loading_image").show();
           $(document).find('.company-list-ul-li').html('');
           
           var off_cat_id = $(document).find(this).attr('data-id');            
           $(document).find('#offer_cat_id').val(off_cat_id);
           $(document).find('.category_li').removeClass('active');
           $(document).find('.li_'+off_cat_id).addClass('active');
           $(document).find("#load_company").val(0);
            var url = "<?php echo base_url(); ?>alloffers/load_companies";
            $.post(url, {category_id: off_cat_id}, function (response)
            {
                $('.company-list-ul-li').html(response.html);
                $('.company-list-ul-li').append('<li class="comp-block more" id="load_more"><a onclick="load_more_data();" id="load_company" value="0" href="javascript:void(0);"><div class="comp-block more"><div class="comp-img"><span>View<br>More</span></div></div></a></li>');
                if (response.val == "true")
                    $(document).find("#load_more").hide();
                else
                    $(document).find("#load_more").show();
                
                $(document).find("#loading_image").hide();
            }, "json");
        });
                
        function load_more_data() {
            $(document).find("#load_more").hide();
            var url = "<?php echo base_url(); ?>alloffers/load_companies"; 
            var off_cat_id = $(document).find('#offer_cat_id').val();
            
            var start = $(document).find("#load_company").val();
            start++;
            $(document).find("#load_company").val(start);
            var val = start;            
            $.post(url, {value: val,category_id: off_cat_id}, function (response){
                $(document).find('#load_more').before(response.html);
                if (response.val == "true")
                    $(document).find("#load_more").hide();
                else
                    $(document).find("#load_more").show();
            }, "json");
        }
    </script>
</body>
</html>