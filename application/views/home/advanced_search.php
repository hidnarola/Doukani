<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
         <?php $this->load->view('include/google_tab_manager_head'); ?>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-select.min.js" type="text/javascript"></script>
        <style>
        .post-prod .single-select span {font-style: normal;font-size: 14px;padding: 0 0 0 14px;}
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
                        <?php $this->load->view('include/sub-header'); ?>
                        <div class="col-sm-12 main ">        
                            <?php $this->load->view('include/left-nav'); ?>
                            <div class="col-sm-9 ContentRight ">
                                <div class="advance_search_main col-sm-12 post-prod" >
                                    <h2>Advanced Search</h2>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Category</label>
                                                        <select class="select2 form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);">
                                                            <option value="">--All Category--</option>
                                                            <?php foreach ($category as $cat): ?>
                                                                <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Sub-Category</label>
                                                        <div class='' id="sub_cat_list">
                                                            <select class="form-control" id="show_sub_category" name="show_sub_category" >
                                                                <option value="0">--Sub Category--</option>
                                                                <?php if(isset($sub_category) && sizeof($sub_category) > 0) {
                                                                    foreach ($sub_category as $cat): ?>
                                                                        <option value="<?php echo $cat['sub_category_id']; ?>"><?php echo $cat['sub_category_name']; ?></option>
                                                                <?php endforeach; } ?>
                                                            </select>  
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-sm-12'>
                                                    <!-- DEFAULT FORM -->
                                                    <form  name="default_form" action='<?php echo base_url() .emirate_slug. 'advanced_search' ?>' class='default_form' accept-charset="UTF-8" method='get' enctype="multipart/form-data" id="form1">   
                                                        <div class="row">											
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <input type="hidden" name="cat_id">
                                                                    <input type="hidden" name="sub_cat">
                                                                    <?php if(isset($_REQUEST['view']) && in_array($_REQUEST['view'],array('grid','list','map'))) { ?>
                <input type="hidden" name="view" id="view" value="<?php echo $_REQUEST['view']; ?>">
            <?php } ?>
                                                                    <select class="select2 form-control country_adv" name="location" id="location1">
                                                                        
                                                                        <?php foreach ($location as $loc) { ?>
                                                                            <option value="<?php echo $loc['country_id']; ?>"><?php echo $loc['country_name'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Emirate</label>
                                                                    <select class="form-control city_adv" name="city" id="city" data-rule-required='true'>
                                                                        <option value="">-- Select Emirate --</option>
                                                                        
                                                                        
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price From (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price From---" onkeypress="return isNumber(event)" name="from_price">
                                                                        </div>
                                                                    </div>	
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price To (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price To---" onkeypress="return isNumber(event)" name="to_price">
                                                                        </div>
                                                                    </div>													
                                                                </div>
                                                            </div>
                                                        </div>														
                                                        <div class="col-sm-3 col-sm-offset-9 btn-005">												
                                                            <button type="submit" class="btn btn-block mybtn adv_sear" name="default" id="default" value="Search">Search <i class="search_btn fa fa-search"></i></button>
                                                        </div>
                                                    </form>

                                                    <!--  VEHICLE FORM -->

                                                    <form name="vehicle_form" style="display: none;" action='<?php echo base_url() .emirate_slug. 'advanced_search' ?>' class='vehicle_form' accept-charset="UTF-8" method='get' enctype="multipart/form-data" id="form2">
                                                        <div class="row">												
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <input type="hidden" name="cat_id">
                                                                    <input type="hidden" name="sub_cat">
                                                                    <?php if(isset($_REQUEST['view']) && in_array($_REQUEST['view'],array('grid','list','map'))) { ?>
                <input type="hidden" name="view" id="view" value="<?php echo $_REQUEST['view']; ?>">
            <?php } ?>
                                                                    <select class="select2 form-control country_adv" name="location" id="location2">                                                                       
                                                                        <?php foreach ($location as $loc) { ?>
                                                                            <option value="<?php echo $loc['country_id']; ?>"><?php echo $loc['country_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Emirate</label>
                                                                    <select class="form-control city_adv" name="city" id="city5" >
                                                                        <option value="">-- Select Emirate --</option>

                                                                    </select>                                                
                                                                </div>
                                                            </div>
                                                        </div>	
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Brand</label>
                                                                    <select name="pro_brand"  class="form-control select2" onchange="show_model(this.value);" id="pro_brand">    
                                                                        <option value="">Select Brand</option>  
                                                                        <?php foreach ($brand as $col): ?>
                                                                            <option value="<?php echo $col['brand_id']; ?>"><?php echo $col['name']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>                                                
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Model</label>
                                                                    <select id="pro_model" name="vehicle_pro_model" class="select2 form-control">
                                                                        <option value="">-- All Models --</option>
                                                                        <?php 
                                                                        if(isset($model) && sizeof($model) > 0) {
                                                                            foreach ($model as $col): ?>
                                                                            <option value="<?php echo $col['model_id']; ?>"  <?php echo ($product[0]['model'] == $col['model_id']) ? 'selected' : ''; ?>><?php echo $col['name']; ?></option>
                                                                        <?php endforeach; } ?>    
                                                                    </select>                                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">	
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Car Type</label>
                                                                    <select id="vehicle_pro_type_of_car" name="vehicle_pro_type_of_car" class="select2 form-control ">
                                                                        <option value="">Select Car Type</option>
                                                                        <option value="Small cars">Small cars</option>
                                                                        <option value="Medium cars">Medium cars</option>
                                                                        <option value="Family cars">Family cars</option>
                                                                        <option value="Estate cars">Estate cars</option>
                                                                        <option value="Multi-purpose vehicles (MPV)">Multi-purpose vehicles (MPV)</option>    
                                                                        <option value="4x4 and Sport Utility Vehicles (SUV)">4x4 and Sport Utility Vehicles (SUV)</option>    
                                                                        <option value="Coupes, roadsters and cabriolets">Coupes, roadsters and cabriolets</option>    
                                                                        <option value="Wheelchair Accessible (WAVs)">Wheelchair Accessible (WAVs)</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Year</label>
                                                                    <input class="form-control datepicker-years"  placeholder="Select Year" id="vehicle_pro_year" name="vehicle_pro_year" type="text" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Mileage</label>
                                                                    <select name="vehicle_pro_mileage" id="vehicle_pro_mileage"  class="select2  form-control">
                                                                        <option value="">Select Mileage</option>
                                                                        <?php foreach ($mileage as $col): ?>
                                                                            <option value="<?php echo $col['mileage_id']; ?>" ><?php echo $col['name']; ?></option>     
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group single-select">
                                                                    <label>Color</label>
                                                                    <select name="vehicle_pro_color"  class="form-control selectpicker" id="ms" style="display:none;"> 
                                                                        <option value="">Select Color</option>                                  
                                                                        <?php foreach ($colors as $col): ?>                                       
                                                                            <option style="color:<?php echo $col['font_color']; ?>;background-color:<?php echo $col['background_color']; ?>" value="<?php echo $col['id']; ?>"
                                                                                    ><?php echo $col['name']; ?></option>
                                                                                <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price From (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price From---" onkeypress="return isNumber(event)" name="from_price">
                                                                        </div>
                                                                    </div>	
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price To (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price To---" onkeypress="return isNumber(event)" name="to_price">
                                                                        </div>
                                                                    </div>													
                                                                </div>
                                                            </div>											
                                                        </div>
                                                        <div class="col-sm-3 col-sm-offset-9 btn-005">
                                                            <button type="submit" class="btn btn-block mybtn adv_sear" name="vehicle_submit" id="vehicle_submit" value="Search">Search <i class="search_btn fa fa-search"></i></button>
                                                        </div>

                                                    </form>

                                                    <!-- REAL ESTATE HOUSES FORM -->
                                                    <form name="real_estate_houses_form" style="display: none;" action='<?php echo base_url().emirate_slug . 'advanced_search' ?>' class='real_estate_houses_form real_estate' accept-charset="UTF-8" method='get' enctype="multipart/form-data" id="form3">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <input type="hidden" name="cat_id">
                                                                    <input type="hidden" name="sub_cat">
                                                                    <?php if(isset($_REQUEST['view']) && in_array($_REQUEST['view'],array('grid','list','map'))) { ?>
                <input type="hidden" name="view" id="view" value="<?php echo $_REQUEST['view']; ?>">
            <?php } ?>
                                                                    <select class="select2 form-control country_adv" name="location" id="location3">
                                                                        <?php foreach ($location as $loc) { ?>
                                                                            <option value="<?php echo $loc['country_id']; ?>"><?php echo $loc['country_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Emirate</label>
                                                                    <select class="form-control city_adv" name="city" id="city2" data-rule-required='true'>
                                                                        <option value="">--Select Emirate--</option>
                                                                    </select>                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">												
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Furnished</label>
                                                                    <select id="furnished" name="furnished" class="select2 form-control">
                                                                        <option value="0">Select</option>
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no">No</option>
                                                                    </select>                    												
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Bedrooms</label>
                                                                    <select id="bedrooms" name="bedrooms" class="select2 form-control">
                                                                        <option value="0">Select Number</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="-1">More than 10</option>
                                                                    </select>                     
                                                                </div>	                                                
                                                            </div>
                                                        </div>
                                                        <div class="row">												
                                                            <div class="col-sm-6">	
                                                                <div class="form-group">
                                                                    <label>Bathrooms</label>                                                
                                                                    <select id="bathrooms" name="bathrooms" class="select2 form-control">
                                                                        <option value="0">Select</option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                        <option value="6">6</option>
                                                                        <option value="7">7</option>
                                                                        <option value="8">8</option>
                                                                        <option value="9">9</option>
                                                                        <option value="10">10</option>
                                                                        <option value="-1">More than 10</option>
                                                                    </select>                                                                     
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">	
                                                                <div class="form-group">
                                                                    <label>Pets</label>    
                                                                    <select id="pets" name="pets" class="select2 form-control">
                                                                        <option value="0">Select</option>
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no">No</option>
                                                                    </select>                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">												
                                                            <div class="col-sm-6">		
                                                                <div class="form-group">
                                                                    <label>Broker Fee</label>                                                    
                                                                    <select id="broker_fee" name="broker_fee" class="select2 form-control">
                                                                        <option value="0">Select</option>
                                                                        <option value="yes">Yes</option>
                                                                        <option value="no">No</option>
                                                                    </select>                     
                                                                </div>
                                                            </div>   
                                                            <div class="col-sm-6">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price From (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price From---" onkeypress="return isNumber(event)" name="from_price" id="houses_from_price">
                                                                        </div>
                                                                    </div>	
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price To (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price To---" onkeypress="return isNumber(event)" name="to_price" id="houses_to_price">
                                                                        </div>
                                                                    </div>													
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <input name="houses_free" type="checkbox" value="free" id="houses_free">
                                                                <label>Free</label>&nbsp;&nbsp;
                                                            </div>												
                                                        </div>                                            
                                                        <div class="col-sm-3 col-sm-offset-9 btn-005">												
                                                            <button type="submit" class="btn btn-block mybtn adv_sear" name="real_estate_submit" id="real_estate_submit" value="Search">Search <i class="search_btn fa fa-search"></i></button>
                                                        </div>
                                                    </form>
                                                    <!-- REAL ESTATE SHARED ROOMS FORM -->
                                                    <form name="real_estate_shared_form" style="display: none;" action='<?php echo base_url() .emirate_slug. 'advanced_search' ?>' class='real_estate_shared_form real_estate' accept-charset="UTF-8" method='get' enctype="multipart/form-data" id="form4">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <input type="hidden" name="cat_id">
                                                                    <input type="hidden" name="sub_cat">
                                                                    <?php if(isset($_REQUEST['view']) && in_array($_REQUEST['view'],array('grid','list','map'))) { ?>
                <input type="hidden" name="view" id="view" value="<?php echo $_REQUEST['view']; ?>">
            <?php } ?>
                                                                    <select class="select2 form-control country_adv" name="location" id="location4">
                                                                        <?php foreach ($location as $loc) { ?>
                                                                            <option value="<?php echo $loc['country_id']; ?>"><?php echo $loc['country_name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Emirate</label>
                                                                    <select class="form-control city_adv" name="city" id="city3" data-rule-required='true'>
                                                                        <option value="">-- Select Emirate --</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price From (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price From---" onkeypress="return isNumber(event)" name="from_price" id="shared_from_price">
                                                                        </div>
                                                                    </div>	
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price To (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price To---" onkeypress="return isNumber(event)" name="to_price" id="shared_to_price">
                                                                        </div>
                                                                    </div>													
                                                                </div>
                                                            </div>		
                                                            <div class="col-sm-6">		
                                                                <div class="checkbox-css">
                                                                    <div class="form-group">
                                                                        <input name="shared_free" type="checkbox" value="free" id="shared_free">
                                                                        <label>Free</label>&nbsp;&nbsp;
                                                                    </div>
                                                                </div>	
                                                            </div>	
                                                        </div>											
                                                        <div class="col-sm-3 col-sm-offset-9 btn-005">												
                                                            <button type="submit" class="btn btn-block mybtn adv_sear" name="shared_submit" id="shared_submit" value="Search">Search <i class="search_btn fa fa-search"></i></button>
                                                        </div>
                                                    </form>
                                                    <!--  Car Number -->
                                                    <form  name="car_number_form" action='<?php echo base_url() .emirate_slug . 'advanced_search' ?>' class='car_number_form' accept-charset="UTF-8" method='get' enctype="multipart/form-data" id="form5">   
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <input type="hidden" name="cat_id">
                                                                    <input type="hidden" name="sub_cat">
                                                                    <?php if(isset($_REQUEST['view']) && in_array($_REQUEST['view'],array('grid','list','map'))) { ?>
                <input type="hidden" name="view" id="view" value="<?php echo $_REQUEST['view']; ?>">
            <?php } ?>
                                                                    <select class="select2 form-control country_adv" name="location" id="location5">                                                                        
                                                                        <?php foreach ($location as $loc) { ?>
                                                                            <option value="<?php echo $loc['country_id']; ?>"><?php echo $loc['country_name'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Emirate</label>
                                                                    <select class="form-control city_adv" name="city" id="city4" data-rule-required='true'>
                                                                        <option value="">-- Select Emirate --</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">											
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Plate Source</label>
                                                                    <select class="select2 form-control" name="plate_source" id="plate_source" onchange="show_prefix(this.value);" >
                                                                        <option value="">Select Plate Source</option>
                                                                        <?php foreach ($plate_source as $pl): ?>
                                                                            <option value="<?php echo $pl['id'] ?>" ><?php echo $pl['plate_source_name']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>														
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Plate Prefix</label>
                                                                    <select class="select2 form-control" name="plate_prefix" id="plate_prefix"  >
                                                                        <option value="">Select Plate Prefix</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">											
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Plate Digit</label>
                                                                    <select class="select2 form-control" name="plate_digit" id="plate_digit" >
                                                                        <option value="">Select Plate Digit</option>
                                                                        <?php foreach ($plate_digit as $pl): ?>
                                                                            <option value="<?php echo $pl['id'] ?>"><?php echo $pl['digit_text']; ?></option>
                                                                        <?php endforeach; ?>
                                                                        <option value="-1">More than 5 Digit plates</option>
                                                                    </select>													
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Repeating Number</label>
                                                                    <select class="select2 form-control" name="repeating_numbers_car" id="repeating_numbers_car"  >
                                                                        <option value="">Select # of repeating number</option>
                                                                        <?php foreach ($repeating_numbers_car as $pl): ?>
                                                                            <option value="<?php echo $pl['id'] ?>"><?php echo $pl['rep_number']; ?></option>
                                                                        <?php endforeach; ?>
                                                                        <option value="-1">More than 5 </option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price From (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price From---" onkeypress="return isNumber(event)" name="from_price">
                                                                        </div>
                                                                    </div>	
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price To (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price To---" onkeypress="return isNumber(event)" name="to_price">
                                                                        </div>
                                                                    </div>													
                                                                </div>
                                                            </div>
                                                        </div>														
                                                        <div class="col-sm-3 col-sm-offset-9 btn-005">												
                                                            <button type="submit" class="btn btn-block mybtn adv_sear" name="car_number_submit" id="car_number_submit" value="Search">Search <i class="search_btn fa fa-search"></i></button>
                                                        </div>
                                                    </form>
                                                    <!--   Mobile Number -->
                                                    <form  name="mobile_number_form" action='<?php echo base_url() . emirate_slug.'advanced_search' ?>' class='mobile_number_form' accept-charset="UTF-8" method='get' enctype="multipart/form-data" id="form6">   
                                                        <div class="row">											
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <input type="hidden" name="cat_id">
                                                                    <input type="hidden" name="sub_cat">
                                                                    <?php if(isset($_REQUEST['view']) && in_array($_REQUEST['view'],array('grid','list','map'))) { ?>
                <input type="hidden" name="view" id="view" value="<?php echo $_REQUEST['view']; ?>">
            <?php } ?>
                                                                    <select class="select2 form-control country_adv" name="location" id="location6">
                                                                        <?php foreach ($location as $loc) { ?>
                                                                            <option value="<?php echo $loc['country_id']; ?>"><?php echo $loc['country_name'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Emirate</label>
                                                                    <select class="form-control city_adv" name="city" id="city6" >
                                                                        <option value="">-- Select Emirate --</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">											
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Mobile Operator</label>
                                                                    <select class="select2 form-control" name="mobile_operators" id="mobile_operators"  >
                                                                        <option value="">Select Mobile Operator</option>
                                                                        <?php foreach ($mobile_operators as $pl): ?>
                                                                            <option value="<?php echo $pl['id'] ?>" ><?php echo $pl['operator_name']; ?></option>                
                                                                        <?php endforeach; ?>            

                                                                    </select>														
                                                                </div>
                                                            </div> 
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Repeating Number</label>
                                                                    <select class="select2 form-control" name="repeating_numbers_mobile" id="repeating_numbers_mobile"  > 
                                                                        <option value="">Select # of repeating number</option>
                                                                        <?php foreach ($repeating_numbers_mobile as $pl): ?>
                                                                            <option value="<?php echo $pl['id'] ?>"><?php echo $pl['rep_number']; ?></option>
                                                                        <?php endforeach; ?>
                                                                        <option value="-1">More than 8</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price From (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price From---" onkeypress="return isNumber(event)" name="from_price">
                                                                        </div>
                                                                    </div>	
                                                                    <div class="col-sm-6">
                                                                        <div class="form-group">
                                                                            <label>Price To (AED)</label>
                                                                            <input type="text" class="form-control" placeholder="---Price To---" onkeypress="return isNumber(event)" name="to_price">
                                                                        </div>
                                                                    </div>													
                                                                </div>
                                                            </div>
                                                        </div>														
                                                        <div class="col-sm-3 col-sm-offset-9 btn-005">												
                                                            <button type="submit" class="btn btn-block mybtn adv_sear" name="mobile_number_submit" id="mobile_number_submit" value="Search">Search <i class="search_btn fa fa-search"></i></button>
                                                        </div>
                                                    </form>    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                    
                        </div>
                    </div>            
                </div>
            </div>
        </div>
        <?php $this->load->view('include/footer'); ?>    
    <script type="text/javascript">
        $("#subcat_id_err").hide();
        $("#houses_free").on("click", function () {
            if ($(this).is(':checked'))
            {
                $("#houses_from_price").val("");
                $("#houses_to_price").val("");
            }
        });

        $("#shared_free").on("click", function () {
            if ($(this).is(':checked'))
            {
                $("#shared_from_price").val("");
                $("#shared_to_price").val("");
            }
        });

        var plate_prefix_url = "<?php echo base_url(); ?>home/show_prefix";

        function show_prefix(val) {
            var sel_prefix = $("#plate_prefix").val();
            $.post(plate_prefix_url, {value: val, sel_prefix: sel_prefix}, function (data)
            {
                $("#plate_prefix").html("");
                $("#plate_prefix option").remove();
                $("#plate_prefix").append(data);
            });
        }

        var val;
        
        var val=$(".country_adv").val();
        show_emirates(4);
        function show_emirates(val) {
            var sel_city= $("#sel_city").val();
            var url 	= "<?php echo base_url(); ?>home/show_emirates";
            $.post(url, {value: val,sel_city:sel_city}, function(data)
            {
                    $(".city_adv").html(data);
                    $(".city_adv option").remove();
                    $(".city_adv").append(data);
            });
        }
                

        $("#vehicle_pro_year").datepicker({
            format: "yyyy",
            startView: 1,
            minViewMode: 2
        });
        var val = $('#cat_id').val();
        show_sub_cat(val);

        var sub_val = $('#sub_cat_list').find('#show_sub_category').val();
        $("input[name='sub_cat']").val(sub_val);

        function show_sub_cat_fields(subval) {

            $("input[name='sub_cat']").val(subval);

            if (subval != '')
                $('#subcat_id_err').hide();

            var cat_text = $('#cat_id').find('option:selected').text();

            if (cat_text == 'Real Estate') {
                if (subval != 0) {

                    var sub_cat = $("#show_sub_category option[value='" + subval + "']").text();

                    if (sub_cat == 'Houses - Apartments for Rent' || sub_cat == 'Houses - Apartments for Sale') {

                        $('.default_form').hide();
                        $('.vehicle_form').hide();
                        $('.real_estate').hide();
                        $('.car_number_form').hide();
                        $('.mobile_number_form').hide();
                        $('.real_estate_houses_form').show();
                        $('#real_estate_location').select2();
                        $('#form_type').val('real_estate_houses_form');

                    } else if (sub_cat == 'Rooms for Rent - Shared' || sub_cat == 'Housing Swap' || sub_cat == 'Land' || sub_cat == 'Shops for Rent - Sale' || sub_cat == 'Office - Commercial Space') {

                        $('.default_form').hide();
                        $('.vehicle_form').hide();
                        $('.real_estate').hide();
                        $('.car_number_form').hide();
                        $('.mobile_number_form').hide();
                        $('.real_estate_shared_form').show();
                        $('#form_type').val('real_estate_shared_form');
                    }
                } else {
                    $(".default_form").hide();
                    $(".vehicle_form").hide();
                    $(".real_estate").hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                }
            } else if (cat_text == 'Vehicles') {

                if (subval != 0) {

                    var sub_cat = $("#show_sub_category option[value='" + subval + "']").text();
                    if (sub_cat == 'Cars') {
                        $(".default_form").hide();
                        $(".real_estate").hide();
                        $('.car_number_form').hide();
                        $('.mobile_number_form').hide();
                        $('.real_estate_shared_form').hide();
                        $(".vehicle_form").show();
                        $("#form_type").val("vehicle_form");
                        $("#vehicle_pro_color").colorpicker();
                    }
                    else if (sub_cat == 'Car Number') {
                        $(".real_estate").hide();
                        $(".vehicle_form").hide();
                        $(".default_form").hide();
                        $('.car_number_form').show();
                        $('.mobile_number_form').hide();
                        $("#form_type").val("car_number_form");
                    }
                    else {
                        $(".real_estate").hide();
                        $(".vehicle_form").hide();
                        $('.car_number_form').hide();
                        $('.mobile_number_form').hide();
                        $(".default_form").show();
                        $("#form_type").val("default_form");
                    }
                }
                else {
                    $(".real_estate").hide();
                    $(".vehicle_form").hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $(".default_form").show();
                    $("#form_type").val("default_form");
                }
            }
            else if (cat_text == 'Classifieds') {

                if (subval != 0) {

                    var sub_cat = $("#show_sub_category option[value='" + subval + "']").text();

                    if (sub_cat == 'Mobile Numbers') {

                        $(".real_estate").hide();
                        $(".vehicle_form").hide();
                        $(".default_form").hide();
                        $('.car_number_form').hide();
                        $('.mobile_number_form').show();
                        $("#form_type").val("mobile_number_form");
                    }
                    else {
                        $(".real_estate").hide();
                        $(".vehicle_form").hide();
                        $('.car_number_form').hide();
                        $('.mobile_number_form').hide();
                        $(".default_form").show();
                        $("#form_type").val("default_form");
                    }
                }
                else {

                    $(".real_estate").hide();
                    $(".vehicle_form").hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $(".default_form").show();
                    $("#form_type").val("default_form");
                }
            }
            else {

                $(".real_estate").hide();
                $(".vehicle_form").hide();
                $('.car_number_form').hide();
                $('.mobile_number_form').hide();
                $(".default_form").show();
                $("#form_type").val("default_form");
            }
        }

        function show_sub_cat(val) {
            $("input[name='cat_id']").val(val);
            $(".real_estate").hide();
            $(".vehicle_form").hide();
            $('.car_number_form').hide();
            $('.mobile_number_form').hide();
            $(".default_form").show();
            var url = "<?php echo base_url() ?>home/show_sub_category";

            $.post(url, {value: val}, function (data)
            {
                $("#sub_cat_list").html(data);
            });
        }

        function show_model(val1)
        {
            var url = "<?php echo base_url() ?>home/show_model";
            $.post(url, {value: val1}, function (data)
            {
                $("#pro_model option").remove();
                $("#pro_model").append(data);

            });
        }

        function isNumber(evt)
        {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>    
</body>
</html>
