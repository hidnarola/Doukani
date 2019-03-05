<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <style>
            .catlist{margin-top:15px;}
        </style>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
        <div class="container-fluid">
            <!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>            
                        <div class="col-sm-12 main category-grid">
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <!--content-->
                            <div class="col-sm-9 ContentRight">
                                <!--Most Viewed product items-->
                                <h3>Search Result</h3>
                                <?php $this->load->view('home/search_common'); ?>
                                <div class="row <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') echo'horizontalList'; else echo 'most-viewed'; ?>">
                                    <div class="catlist">
                                        <?php
                                        if (isset($_REQUEST['search'])) {
                                            ?>
                                            <input type="hidden" name="getdata" id="getdata" value="<?php print_r($_REQUEST); ?>">									
                                            <input type="hidden" name="cat1" id="cat1" value="<?php echo $_REQUEST['cat']; ?>">	
                                            <input type="hidden" name="sub_cat1" id="sub_cat1" value="<?php echo $_REQUEST['sub_cat']; ?>">
                                            <input type="hidden" name="location1" id="location1" value="<?php
                                            if (isset($_REQUEST['location']))
                                                echo $_REQUEST['location'];
                                            else
                                                echo '';
                                            ?>">
                                            <input type="hidden" name="city2" id="city2" value="<?php echo (isset($_REQUEST['city'])) ?  $_REQUEST['city'] : ''; ?>">
                                            <input type="hidden" name="min_amount1" id="min_amount1" value="<?php echo $_REQUEST['min_amount']; ?>">
                                            <input type="hidden" name="max_amount1" id="max_amount1" value="<?php echo $_REQUEST['max_amount']; ?>"> 
                                        <?php } elseif ($this->uri->segment(3) != '') {
                                            ?>
                                            <input type="hidden" name="city2" id="city2" value="<?php echo $this->uri->segment(3); ?>">	
                                        <?php } elseif (isset($_REQUEST['selection']) && $_REQUEST['selection'] != '') {
                                            ?>
                                            <input type="hidden" name="cityname" id="cityname" value="<?php echo $_REQUEST['selection']; ?>">	
                                            <?php
                                        }
                                        if (isset($_REQUEST['s'])) {
                                            ?>
                                            <input type="hidden" name="search_value1" id="search_value1" value="<?php echo strip_tags($_REQUEST['s']); ?>">
                                        <?php } ?>	
                                        
                                        <?php 
                                            if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list'){
                                                $this->load->view('home/product_listing_view');
                                            }else                                        
                                                $this->load->view('home/product_grid_view'); 
                                        ?>

                                        <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                        <?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center " id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br><br>
                                            </div>
                                        <?php } ?>	
                                    </div>
                                </div>
                                <!--End Most Viewed product items-->
                            </div>
                            <!--//content-->
                        </div>
                    </div>
                    <!--//main-->
                </div>
            </div>
        </div>

        <!--//body-->
        <!--footer-->
        <?php $this->load->view('include/footer'); ?>
        <!--//footer-->

        <script type="text/javascript">
            function load_more_data()
            {
                $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_product').prop('disabled', true);

                var load_more_status = $('#load_more_status').val();
                var url = "<?php echo base_url(); ?>home/more_search";
                var start = $("#load_product").val();
                start++;
                $("#load_product").val(start);
                var val = start;
                var cat1 = $("#cat1").val();
                var sub_cat1 = $("#sub_cat1").val();
                var location = $("#location1").val();
                var city1 = $("#city2").val();
                var cityname = $("#cityname").val();
                var min_amount1 = $("#min_amount1").val();
                var max_amount1 = $("#max_amount1").val();
                var search_value1 = $("#search_value1").val();
                
                 var view='';
                <?php if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                    view = 'list';
                <?php } ?>
                
                if (load_more_status == 'false') {
                    $.post(url, {value: val, cat1: cat1, sub_cat1: sub_cat1, city1: city1, min_amount1: min_amount1, max_amount1: max_amount1, search_value1: search_value1, location: location, cityname: cityname, state_id_selection: state_id_selection,view:view}, function (response)
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
        <!--container-->
    </body>
</html>