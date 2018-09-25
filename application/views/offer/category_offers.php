<!DOCTYPE html>
<html lang="en">
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
            <div class=" page">
                <div class="container">
                    <div class="row">
                    <?php $this->load->view('include/sub-header'); ?>
                    <div class="offer-wrap">
                        <div class="row">
                            <div class="col-md-3 col-sm-4">
                                <div class="menu_cat">
                                    <div class="menuCategories"></div>
                                </div>
                                <div class="gray-box side offer_page_cat">
                                    <h3 class="wrap-title">Category</h3>
                                    <input type="hidden" name="offer_cat_id" id="offer_cat_id" value="<?php echo (isset($_GET['cat_id']))? $_GET['cat_id'] : ''; ?>">
                                    <input type="hidden" name="search_text" id="search_text" value="<?php echo (isset($_GET['s']))? $_GET['s'] : ''; ?>">
                                    <input type="hidden" name="search" id="search">
                                    <input type="hidden" name="offer_view" id="offer_view" value="grid">
                                    
                                    <div class="cate-listing">
                                        <div class="cate-list">
                                            <ul class="list-ul boxes">
                                                <li> <!-- -active -->
                                                    <a href="<?php echo site_url().'offers'; ?>">
                                                        <div class="cate-block">
                                                            <div class="cate-icn"><i class="fa fa-refresh"></i></div>
                                                            <h4 class="cate-name"><span>Reset</span></h4>
                                                        </div>
                                                    </a>
                                                </li>
                                                <?php 
                                                    if(isset($_REQUEST['cat_id']))
                                                        $cat_id = $_REQUEST['cat_id'];
                                                    
                                                    foreach ($category as $cat) { ?>
                                                    <li class="li_<?php echo $cat['category_id']; ?> category_li  <?php echo (isset($cat_id) && $cat_id==$cat['category_id'])? 'active' : ''; ?>"> <!-- active  -->
                                                        <a href="javascript:void(0);" data-id="<?php echo $cat['category_id']; ?>" class="off_category">
                                                            <div class="cate-block">
                                                                <div class="cate-icn" style="color: <?php echo $cat['color']; ?>"><i class="fa <?php echo $cat['icon']; ?>"></i></div>
                                                                <h4 class="cate-name"><span><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></span></h4>
                                                            </div>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-8">
                                <div class="gray-box">
                                    <div class="offer-top">
                                        <ol class="breadcrumb no-margin" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo site_url().'alloffers'; ?>" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">Home</span></a></li>
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"  class="active"><a href="javascript:void(0);" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">Offers List</span></a></li>
                                        </ol>
                                        <div class="view-block">
                                            <a href="javascript:void(0);" class="active offer_view grid" data-id="grid"><i class="fa fa-th" aria-hidden="true"></i></a>
                                            <a href="javascript:void(0);" class="offer_view list" data-id="list"><i class="fa fa-th-list" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <div id="loading" style="text-align:center" class="loader_display">
                                        <img src="<?php echo HTTPS . website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
                                    </div>
                                    <div class="offer-listing">
                                        <div class="offer-listing-div">
                                            <div class="row">
                                                <?php $this->load->view('offer/offer_grid_view'); ?>
                                            </div>
                                        </div>
                                        <?php if (@$hide == "false") { ?>
                                        <div class="text-center" id="load_more">
                                            <button class="btn btn-blue" onclick="load_more_data();" id="load_offers" value="0">Load More</button>
                                        </div>
                                        <br><br>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
                <!--//main-->
            </div>
            <!--//body-->
    <!--footer-->
    <?php $this->load->view('include/footer'); ?>
    <script type="text/javascript">

        $(".off_category").click(function () {
            var window_width = parseInt($( window ).width());    
            if(window_width<=1024) {        
                $('html, body').animate({
                    scrollTop: $(".gray-box .offer-top").offset().top
               }, 2000);
            }
           
           $(".loader_display").show();
           $('#load_offers').val(0);
           var offer_view = $('#offer_view').val();
           var search_text = $('#search_text').val();
           var off_cat_id = $(this).attr('data-id');            
           $('#offer_cat_id').val(off_cat_id);
           $('.category_li').removeClass('active');
           $('.li_'+off_cat_id).addClass('active');
          
            var url = "<?php echo base_url(); ?>alloffers/offer_grid_list_view";
            $.post(url, {value:0,category_id: off_cat_id,view:offer_view,s:search_text}, function (response)
            {
                $('.offer-listing-div .row').html('');
                $('.offer-listing-div .row').html(response.html);
                $(".loader_display").hide();
                
                if (response.val == "true")
                    $("#load_offers").hide();
                else
                    $("#load_offers").show();
                
            }, "json");
        });
        
        
        $(document).on("click", ".offer_view", function (e) {
           
           $('#load_offers').val(0);
           $('.loader_display').show();
           
           e.preventDefault();
            var search = $(this).attr('data-id');
            var val1 = 1;
            $('#offer_view').val(search);
            var offer_view = $('#offer_view').val();
            var type = $('#search').val();
            var offer_cat_id = $('#offer_cat_id').val();

            if (search == 'grid') {
                $('.' + search).addClass('active');
                $('.list').removeClass('active');
            }
            else if (search == 'list') {
                $('.' + search).addClass('active');
                $('.grid').removeClass('active');
            }
            $("#load_offers").val(0);
            var search_text = $('#search_text').val();
            var url = "<?php echo site_url(); ?>alloffers/offer_grid_list_view";
            $.post(url, {value:0,view:search,category_id:offer_cat_id,s:search_text}, function (response) {
                $('.offer-listing-div .row').html('');
                $('.offer-listing-div .row').html(response.html);                
                if (response.val == "true")
                    $("#load_offers").hide();
                else
                    $("#load_offers").show();
                
                $('.loader_display').hide();
            }, "json");
        });
        
        function load_more_data() {
            
            var offer_view = $('#offer_view').val();
            var offer_cat_id = $('#offer_cat_id').val();
            
            $("#load_offers").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
            $('#load_offers').prop('disabled', true);
            
            var url = "<?php echo base_url(); ?>alloffers/offer_grid_list_view";
            var start = $("#load_offers").val();
            start++;    
            $("#load_offers").val(start);
            var val = start;
            var search_text = $('#search_text').val();
            $.post(url, {value: val,view:offer_view,category_id:offer_cat_id,s:search_text}, function (response){
                $('.offer-listing-div .row').append(response.html);
                if (response.val == "true")
                    $("#load_offers").hide();
                else
                    $("#load_offers").show();
                
                $('#load_offers').prop('disabled', false);
                $("#load_offers").html('Load More');
            }, "json");
        }
    </script>
</body>
</html>
