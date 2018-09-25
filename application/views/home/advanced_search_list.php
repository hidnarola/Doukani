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
                            <div class="col-sm-9 ContentRight ">
                                <h3>Search Result</h3>
                                <div class="content-top-option">                                                                                        <?php $this->load->view('home/advanced_search_common'); ?>
                                </div>                                
                                <!--row-->
                                <input type="hidden" value="<?php print_r($_REQUEST); ?>">
                                <input type="hidden" name="cat_id" id="cat_id11" value="<?php echo $_REQUEST['cat_id']; ?>">
                                <input type="hidden" name="sub_cat" id="sub_cat11" value="<?php echo $_REQUEST['sub_cat']; ?>">
                                <input type="hidden" name="location1" id="location1" value="<?php echo $_REQUEST['location']; ?>">
                                <input type="hidden" name="city" id="city" value="<?php echo $_REQUEST['city']; ?>">
                                <input type="hidden" name="from_price" id="from_price" value="<?php echo $_REQUEST['from_price']; ?>">
                                <input type="hidden" name="to_price" id="to_price" value="<?php echo $_REQUEST['to_price']; ?>">
                                <?php
                                if (isset($_REQUEST['default'])) {
                                    
                                } elseif (isset($_REQUEST['vehicle_submit'])) {
                                    ?>
                                    <input type="hidden" name="pro_brand" id="pro_brand" value="<?php echo $_REQUEST['pro_brand']; ?>">	
                                    <input type="hidden" name="vehicle_pro_model" id="vehicle_pro_model" value="<?php echo $_REQUEST['vehicle_pro_model']; ?>">	
                                    <input type="hidden" name="vehicle_pro_year" id="vehicle_pro_year" value="<?php echo $_REQUEST['vehicle_pro_year']; ?>">	
                                    <input type="hidden" name="vehicle_pro_mileage" id="vehicle_pro_mileage" value="<?php echo $_REQUEST['vehicle_pro_mileage']; ?>">	
                                    <input type="hidden" name="vehicle_pro_color" id="vehicle_pro_color" value="<?php echo $_REQUEST['vehicle_pro_color']; ?>">                                    
                                    <input type="hidden" name="vehicle_pro_type_of_car" id="vehicle_pro_type_of_car" value="<?php echo $_REQUEST['vehicle_pro_type_of_car']; ?>">											
                                    <?php
                                } elseif (isset($_REQUEST['real_estate_submit'])) {
                                    ?>
                                    <input type="hidden" name="furnished" id="furnished" value="<?php echo $_REQUEST['furnished']; ?>">
                                    <input type="hidden" name="bedrooms" id="bedrooms" value="<?php echo $_REQUEST['bedrooms']; ?>">
                                    <input type="hidden" name="bathrooms" id="bathrooms" value="<?php echo $_REQUEST['bathrooms']; ?>">
                                    <input type="hidden" name="pets" id="pets" value="<?php echo $_REQUEST['pets']; ?>">
                                    <input type="hidden" name="broker_fee" id="broker_fee" value="<?php echo $_REQUEST['broker_fee']; ?>">
                                    <?php if (isset($_REQUEST['houses_free'])): ?>
                                        <input type="hidden" name="houses_free" id="houses_free" value="<?php echo $_REQUEST['houses_free']; ?>">
                                    <?php endif; ?>
                                    <?php
                                }
                                elseif (isset($_REQUEST['shared_submit'])) {
                                    if (isset($_REQUEST['shared_free'])):
                                        ?>
                                        <input type="hidden" name="shared_free" id="shared_free" value="<?php echo $_REQUEST['shared_free']; ?>">
                                    <?php
                                    endif;
                                }
                                elseif (isset($_REQUEST['car_number_submit'])) {
                                    ?>
                                    <input type="hidden" name="plate_source" id="plate_source" value="<?php echo $_REQUEST['plate_source']; ?>">
                                    <input type="hidden" name="plate_prefix" id="plate_prefix" value="<?php echo $_REQUEST['plate_prefix']; ?>">
                                    <input type="hidden" name="plate_digit" id="plate_digit" value="<?php echo $_REQUEST['plate_digit']; ?>">
                                    <input type="hidden" name="repeating_numbers_car" id="repeating_numbers_car" value="<?php echo $_REQUEST['repeating_numbers_car']; ?>">                                                                        
                                    <?php
                                }
                                elseif (isset($_REQUEST['mobile_number_submit'])) {
                                    ?>
                                    <input type="hidden" name="mobile_operators" id="mobile_operators" value="<?php echo $_REQUEST['mobile_operators']; ?>">
                                    <input type="hidden" name="repeating_numbers_mobile" id="repeating_numbers_mobile" value="<?php echo $_REQUEST['repeating_numbers_mobile']; ?>">                                    
                                    <?php
                                }
                                ?>
                                <!--//row-->
                                <!--Most Viewed product items-->							
                                <div class="row <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') echo'horizontalList';
                                else echo 'most-viewed'; ?>">
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
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button>
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
        function load_more_data() {
            
            $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
            $('#load_product').prop('disabled',true);
            var load_more_status = $('#load_more_status').val();
            
            var url = "<?php echo base_url() ?>home/load_more_advanced_search";
            var start = $("#load_product").val();
            start++;
            
            $("#load_product").val(start);            
            var val = start;
            var cat_id = $("#cat_id11").val();
            var sub_cat = $("#sub_cat11").val();
            var location1 = $("#location1").val();
            var city = $("#city").val();
            var from_price = $("#from_price").val();
            var to_price = $("#to_price").val();

            var pro_brand = $("#pro_brand").val();
            var vehicle_pro_model = $("#vehicle_pro_model").val();
            var vehicle_pro_year = $("#vehicle_pro_year").val();
            var vehicle_pro_mileage = $("#vehicle_pro_mileage").val();
            var vehicle_pro_color = $("#vehicle_pro_color").val();
            
            var furnished = $("#furnished").val();
            var bedrooms = $("#bedrooms").val();
            var bathrooms = $("#bathrooms").val();
            var pets = $("#pets").val();
            var broker_fee = $("#broker_fee").val();
            var houses_free = $("#houses_free").val();
            var shared_free = $("#shared_free").val();

            var plate_source = $("#plate_source").val();
            var plate_prefix = $("#plate_prefix").val();
            var plate_digit  = $("#plate_digit").val();
            var repeating_numbers_car = $("#repeating_numbers_car").val();

            var mobile_operators = $("#mobile_operators").val();
            var repeating_numbers_mobile = $("#repeating_numbers_mobile").val();

            var view='';
            <?php if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                view = 'list';
            <?php } ?>
                
            if(load_more_status=='false') {
            $.post(url, {value: val, cat_id: cat_id, sub_cat: sub_cat, location1: location1, city: city, from_price: from_price, to_price: to_price, pro_brand: pro_brand, vehicle_pro_model: vehicle_pro_model, vehicle_pro_year: vehicle_pro_year, vehicle_pro_mileage: vehicle_pro_mileage, vehicle_pro_color: vehicle_pro_color, furnished: furnished, bedrooms: bedrooms, bathrooms: bathrooms, pets: pets, broker_fee: broker_fee, houses_free: houses_free, shared_free: shared_free,plate_source:plate_source,plate_prefix:plate_prefix,plate_digit:plate_digit,repeating_numbers_car:repeating_numbers_car,mobile_operators:mobile_operators,repeating_numbers_mobile:repeating_numbers_mobile,state_id_selection:state_id_selection,view:view}, function (response)
            {
                $('#load_more_status').val(response.val);
                $("#load_more").before(response.html);

                if (response.val == "true")
                    $("#load_product").hide();
                
                $('#load_product').prop('disabled',false);
                $("#load_product").html('Load More');
            }, "json");
            }
        }
    </script>
    <!--container-->
</body>
</html>