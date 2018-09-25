<!DOCTYPE html>
<html lang="en-US">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
        <div class="container-fluid">
            <!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
            <!--//ad1 header-->
            <!--menu-->
            <?php $this->load->view('include/menu'); ?>
            <!--//menu-->        
            <!--body-->
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
                            <div class="col-sm-9 ContentRight">
                                <h3>Featured Ads</h3>
                                <?php $this->load->view('home/featured_ads_common'); ?>
                                <!--Most Viewed product items-->
                                <div class="row <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') echo'horizontalList';
                                else echo 'most-viewed'; ?> Featured_Ads">
                                    <div class="catlist">
                                        <?php 
                                        if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                                            $this->load->view('home/product_listing_view');
                                        else
                                            $this->load->view('home/product_grid_view'); 
                                        ?>
                                        <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                        <?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br><br>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!--End Most Viewed product items-->                        
                            </div>
                            <!--//content-->                
                        </div>
                        <!--//main-->
                    </div>
                </div>
            </div>
            <!--//body-->
            <!--footer-->
            <?php $this->load->view('include/footer'); ?>
            <script type="text/javascript">
            function load_more_data() {

                $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_product').prop('disabled', true);
                var load_more_status = $('#load_more_status').val();
                var url = "<?php echo base_url(); ?>home/get_morefeatured_ads";
                var start = $("#load_product").val();
                start++;
                $("#load_product").val(start);
                var val = start;
                
                var view='';
                <?php if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                    view = 'list';
                <?php } ?>
                
                if(load_more_status=='false') {
                    $.post(url, {value: val,state_id_selection:state_id_selection,view:view}, function (response)
                    {
                        $('#load_more_status').val(response.val);

                        $("#load_more").before(response.html);
                        if (response.val == "true")
                            $("#load_product").hide();
                        
                        $('#load_product').prop('disabled', false);
                        $("#load_product").html('Load More');
                    }, "json");
                }
            }
        </script>
            <!--//footer-->
        </div>        
        <!--container-->        
    </body>
</html>