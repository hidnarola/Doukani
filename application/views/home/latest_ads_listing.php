<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
    </head>
    <?php
    if (@$subcat_id == "")
        $subcat_id = 0;
    ?>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
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
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <!--content-->
                            <div class="col-sm-12 ContentRight latest_pg">
                                <div class="latest">
                                    <?php $this->load->view('common/lastest_ad_featuredpart'); ?>
                                    <!--row-->
                                </div>
                                <div class="col-sm-6 latest_pg_lbl">
                                    <h3 class="border-title latest">Latest Ads</h3>
                                </div>                                
                                <?php $this->load->view('home/latest_common');?>
                                <div class="TagsList">
                                    <!--Product-->
                                    <!--//-->
                                    <div class="row <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') echo'horizontalList';
                                else echo 'most-viewed'; ?>">
                                        <div class="catlist">
                                            <?php
                                            if (isset($_GET['view']) && $_GET['view'] == 'list')
                                                $this->load->view('home/product_listing_view');
                                            else
                                                $this->load->view('home/product_grid_view');
                                            ?>
                                            <!--item1-->
                                            <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                            <?php if (@$hide == "false") { ?>
                                                <div class="col-sm-12 text-center" id="load_more">
                                                    <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br><br>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!--//-->
                                    <!-- end product --> 
                                </div>

                            </div>
                            <!--//main-->            
                        </div>
                        <!--//body-->
                    </div>
                </div>
                <!--footer-->
                <?php $this->load->view('include/footer'); ?>
                <!--//footer-->
            </div>
        </div>
        <!--container-->
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/owl.carousel.js"></script>
        <script type="text/javascript">
                                                        function load_more_data() {

                                                            $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                                                            $('#load_product').prop('disabled', true);
                                                            var load_more_status = $('#load_more_status').val();

                                                            var url = "<?php echo base_url(); ?>home/latest_more_ads/";
                                                            var start = $("#load_product").val();
                                                            start++;

                                                            $("#load_product").val(start);
                                                            var val = start;
<?php
if (isset($_GET['view']) && $_GET['view'] == 'list')
    $view = 'list';
else
    $view = '';
?>
                                                            var view = '<?php echo $view; ?>';
                                                            var req_numItems = $(document).find('.home_items').length;

var view='';
            <?php if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                view = 'list';
            <?php } ?>
                
                                                            $.post(url, {value: val, view: view, req_numItems: req_numItems, state_id_selection: state_id_selection,view:view}, function (response)
                                                            {
                                                                $('#load_more_status').val(response.val);
                                                                $("#load_more").before(response.html);

                                                                var after_numItems = $(document).find('.home_items').length;

                                                                if (!response.show_button)
                                                                    $("#load_product").hide();

                                                                $('#load_product').prop('disabled', false);
                                                                $("#load_product").html('Load More');

                                                            }, "json");
                                                        }

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

                                                        $('#myTabs a').click(function (e) {
                                                            e.preventDefault()
                                                            $(this).tab('show')
                                                        });

        </script>
    </body>
</html>