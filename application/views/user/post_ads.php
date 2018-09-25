<html>
<head>
     <?php $this->load->view('include/head'); ?>
    <script type="text/javascript">
/*    function initialize() {
      var mapProp = {
        center:new google.maps.LatLng(51.508742,-0.120850),
        zoom:5,
        mapTypeId:google.maps.MapTypeId.ROADMAP
      };
      var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
    }
    google.maps.event.addDomListener(window, 'load', initialize); */
    </script>
</head>

<body>
<!--container-->
    <div class="container-fluid">
            
        <!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
            
        <!--//ad1 header-->
        <!--menu-->
        <?php $this->load->view('include/menu'); ?>
        <!--//menu-->
        
        <!--body-->
        <div class="row page">
            <!--header-->
           <?php $this->load->view('include/sub-header'); ?>
            <!--//header-->
            <!--main-->
            <div class="col-sm-12 main postad">
        <div class="row">
                    <!--cat-->
                   <?php $this->load->view('include/left-nav'); ?>
                    <!--//cat-->
                    <!--content-->
                    
                     <!--content-->
                     
                    <div class="col-sm-10 post-ad">
						<?php if(isset($msg)):  ?>
						  <div class='alert  <?php echo $msg_class; ?>'>
							<a class='close' data-dismiss='alert' href='#'>&times;</a>
							<center><?php echo $msg; ?></center>
						  </div>
						<?php endif; ?>
                        <h3>Post Your Ad</h3>

                        <div class='box-content'>
                                        <div class='row'>
                                            <div class='form-group'>  
                                                <div class="col-md-2 col-sm-3">Category <span> *</span></div>
                                                <!--<label class='col-md-2 control-label text-right' for='inputText1'>Category</label>-->
                                                <div class='col-md-6 col-sm-8' style="padding: 0px 12px 14px 14px;">
                                                    <select class="select2 form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);">
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
										<div class='row'>       
											<div class='form-group'>  
											<!--<label class='col-md-2 control-label text-right' for='inputText1'>Sub Category</label>-->
											<div class="col-md-2 col-sm-3">Sub Category <span> *</span></div>
											<div class='col-md-6 col-sm-8' id="sub_cat_list" style="padding: 0px 12px 14px 14px;">
												<select class="select2 form-control" id="show_sub_category" name="show_sub_category" >
													<option value="0">--select Sub Category--</option>
													<?php foreach ($sub_category as $cat): ?>
														<option value="<?php echo $cat['sub_category_id']; ?>"><?php echo $cat['sub_category_name'] ?></option>
													<?php endforeach; ?>
												</select>                                            
											</div>
											</div>
										</div>
                                        

                    <!--===================== DEFAULT FORM ======================-->


                                            <form  name="default_form" action='<?php echo base_url() . 'user/post_ads' ?>' class='form form-horizontal validate-form default_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form1">   
                                            <div class='form-group'>                                            
                                                 <input type="hidden" name="cat_id">
                                                <input type="hidden" name="sub_cat">
                                                
                                                <!--<label class='col-md-2 control-label' for='inputText1'>Name</label>-->
                                                <div class="col-md-2 col-sm-3">Name <span> *</span></div>
                                                <div class="col-md-6 col-sm-8 controls">
                                                    <input placeholder='Product Name' class="form-control" name="pro_name" type='text' data-rule-required='true'/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <div class="col-md-2 col-sm-3">Description <span> *</span></div>
                                                <!--<label class='col-md-2 control-label' for='inputText1'>Description</label>-->
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <textarea class="form-control" id="inputTextArea1" placeholder="Description" name="pro_desc" rows="3" data-rule-required='true'></textarea>
                                                </div>
                                            </div>
                                             <div class='form-group'>                                                
												<div class="col-md-2 col-sm-3">Upload Main Image</div>
                                                <div class='col-md-5'>
                                                    <!-- <div id="dragAndDropFiles" class="uploadArea">
                                                        <h1>Drop Images Here</h1>
                                                    </div> -->
                                                     <!-- <input type="file" id="file" name="vehicle_files[]" multiple="multiple" accept="image/*" /> -->
                                                     <input type="file" name="multiUpload1" id="multiUpload" onchange="javascript:loadimage1(this);"/>
													 <img id="blah" src="#" alt="" class="hide_img" />
                                                </div>                                              
                                                <!-- <div class="progressBar">
                                                    <div class="status"></div>
                                                </div>
                                                <input type="button" name="upload_btn" id="upload_btn" value="Upload" />-->
                                            </div>                                          
                                            <div class='form-group'>  												
												<div class="col-md-2 col-sm-3">Upload Sub-Images</div>												
												<a href="javascript:void(0);" id="attachMore1" class="col-md-2 btn btn-primary">Upload another file</a>
												<div class="clearfix"></div>
												<div id="moreImageUpload1" class='col-md-12'></div>												
											</div>	
                                            <div class="row form-group">
                                                <div class="col-md-2 col-sm-3">Emirate <span> *</span></div>
                                                <div class="col-md-6 col-sm-8 controls">
                                                    <select class="form-control" name="city" id="city" data-rule-required='true'>
                                                            <option value="">-- Select Emirate --</option>
                                                             <?php foreach ($state as $st): ?>
                                                            <?php if($st['state_id'] == @$_POST['city']) {?>
                                                              <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city'],TRUE); ?> ><?php echo $st['state_name'] ?></option>
                                                              <?php } else { ?>
                                                              <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city']); ?> ><?php echo $st['state_name'] ?></option>
                                                              <?php } ?>

                                                           <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>     
                                                <div class="col-md-2 col-sm-3">Price <span> *</span></div>                      
                                                <!--<label class='col-md-2 control-label' for='inputText1'>Price</label>-->
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Price" name="pro_price" type="text"  data-rule-required='true' />
                                                </div>
                                            </div>
										<!--
                                            <div class='form-group'>   
                                                <div class="col-md-2 col-sm-3">Brand <span> *</span></div>                          
                                                <!--<label class='col-md-2 control-label' for='inputText1'>Brand</label> -->
                                            <!--    <div class='col-md-6 col-sm-8 controls'>
                                                    <!--<input class="form-control"  placeholder="Brand" name="pro_brand" type="text" />-->
                                                <!--    <select name="pro_brand"  class="form-control select2 ">    
                                                        <option value="">Select Brand</option>  
                                                        <?php //foreach($brand as $col):?>
                                                            <option value="<?php //echo $col['brand_id']; ?>"><?php //echo $col['name']; ?></option>
                                                        <?php //endforeach;   ?>
                                                    </select>
                                                </div>
                                            </div>-->

                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submitHandler" name="default_submit">
                                                            <i class='icon-save'></i>
                                                            Post
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>user/post_ads' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>

                    <!--=========================== VEHICLE FORM =============================-->

            <form name="vehicle_form" style="display: none;" action='<?php echo base_url() . 'user/post_ads' ?>' class='form form-horizontal validate-form vehicle_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form2">
												<input type="hidden" name="cat_id">
                                                <input type="hidden" name="sub_cat">
											<div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Ad Title</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" placeholder="Title" name="title" type="text" data-rule-required='true'/>
                                                </div>
                                            </div>
											
                                            <!--<div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Make</div>
                                                <div class='col-md-6 col-sm-8 controls'>    
													<select id="pro_make" name="vehicle_pro_make" class="select2 form-control">
													<option value="0">Select</option>
                                                        <option value="make1">Make 1</option>
                                                        <option value="make2">Make 2</option>
                                                        <option value="make3">Make 3</option>
                                                        <option value="make4">Make 4</option>
                                                    </select>                     
                                                </div>
                                            </div>-->
											<div class='form-group'>
												<div class='col-md-2 col-sm-3'>Car Brand</div>								
                                                <div class='col-md-5'>
                                                    <!--<input class="form-control"  placeholder="Brand" name="pro_brand" type="text" value="<?php //echo $product[0]['product_brand']; ?>" /> -->
                                                    <select name="pro_brand"  class="form-control select2 " onchange="show_model(this.value);" id="pro_brand">    
                                                        <option value="">Select Brand</option>  
                                                        <?php foreach($brand as $col):?>
                                                            <option value="<?php echo $col['brand_id']; ?>"><?php echo $col['name']; ?></option>
                                                        <?php endforeach;   ?>
                                                    </select>                                               
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Car Model</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="pro_model" name="vehicle_pro_model" class="select2 form-control">
														 <?php foreach($model as $col):?>
                                                            <option value="<?php echo $col['model_id']; ?>"  <?php echo ($product[0]['model']==$col['model_id']) ? 'selected' : ''; ?>><?php echo $col['name']; ?></option>
                                                        <?php endforeach;   ?>    
                                                       <!-- <option value="0">Select</option>
                                                        <option value="model1">Model 1</option>
                                                        <option value="model2">Model 2</option>
                                                        <option value="model3">Model 3</option>
                                                        <option value="model4">Model 4</option>-->
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="row form-group">
												<div class="col-md-2 col-sm-3">Emirate <span> *</span></div>
												<div class="col-md-6 col-sm-8 controls">
													<select class="form-control" name="city" id="city" data-rule-required='true'>
															<option value="">-- Select Emirate --</option>
															 <?php foreach ($state as $st): ?>
															<?php if($st['state_id'] == @$_POST['city']) {?>
															  <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city'],TRUE); ?> ><?php echo $st['state_name'] ?></option>
															  <?php } else { ?>
															  <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city']); ?> ><?php echo $st['state_name'] ?></option>
															  <?php } ?>

														   <?php endforeach; ?>
													</select>
												</div>
											</div>
                                            <div class='form-group'>                        
                                               <div class='col-md-2 col-sm-3'>Type Of Car</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Type Of Car" name="vehicle_pro_type_of_car" type="text" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Year</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control datepicker-years"  placeholder="Select Year" id="vehicle_pro_year" name="vehicle_pro_year" type="text" />
                                                </div>
                                            </div>
                                          <div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Mileage</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <!--<input class="form-control"  placeholder="Mileage" name="vehicle_pro_mileage" id="vehicle_pro_mileage" type="text" />-->
                                                    <select name="vehicle_pro_mileage" id="vehicle_pro_mileage"  class="select2  form-control">
                                                    <option value="">Select Mileage</option>
                                                    <?php foreach($mileage as $col):?>
                                                        <option value="<?php echo $col['mileage_id']; ?>" ><?php echo $col['name']; ?></option>     
                                                    <?php endforeach;   ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Condition</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Condition" name="vehicle_pro_condition" id="vehicle_pro_condition" type="text" />
                                                </div>
                                            </div>

                                            <div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Choose color</div>
                                                <div class='col-md-2 col-sm-2 controls'><!-- kesha -->
                                                   <!--<input class='colorpicker-hex form-control' name="vehicle_pro_color" id="vehicle_pro_color" placeholder='Pick a color' style='margin-bottom: 0;' type='text'> -->
                                                   <select name="vehicle_pro_color"  class="form-control" id="ms" > 
                                                        <option value="">Select Color</option>                                  
                                                        <?php foreach($colors as $col):?>                                       
                                                        <option style="color:<?php echo $col['font_color']; ?>;background-color:<?php echo $col['background_color']; ?>" value="<?php echo $col['background_color']; ?>"
                                                        ><?php echo $col['name']; ?></option>
                                                        <?php endforeach;   ?>
                                                    </select>
                                                </div>
                                            </div>
                                         <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Upload Main Image</div>
                                                <div class='col-md-5'>
                                                    <!-- <div id="dragAndDropFiles" class="uploadArea">
                                                        <h1>Drop Images Here</h1>
                                                    </div> -->
                                                     <!-- <input type="file" id="file" name="vehicle_files[]" multiple="multiple" accept="image/*" /> -->
                                                     <input type="file" name="multiUpload1" id="multiUpload1" onchange="javascript:loadimage2(this);"/>
													 <img id="blah1" src="#" alt="" class="hide_img" />
                                                </div>                                              
                                                <!-- <div class="progressBar">
                                                    <div class="status"></div>
                                                </div>
                                                <input type="button" name="upload_btn" id="upload_btn" value="Upload" />-->
                                            </div>                                          
                                            <div class='form-group'>  
												<div class="col-md-2 col-sm-3">Upload Sub-Images</div>
												<a href="javascript:void(0);" id="attachMore2" class="col-md-2 btn btn-primary">Upload another file</a>
												<div class="clearfix"></div>												
												<div id="moreImageUpload2" class='col-md-12'></div>
											</div>	
                                            <div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Description</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <textarea class="form-control" id="vehicle_pro_desc" placeholder="Description" name="vehicle_pro_desc" rows="3" data-rule-required='true'></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class='col-md-2 col-sm-3'>Price</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Price" name="vehicle_pro_price" id="vehicle_pro_price" type="text"  data-rule-required='true' />
                                                </div>
                                            </div>
											<div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submitHandler1" name="vehicle_submit">
                                                            <i class='icon-save'></i>
                                                            Post
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>user/post_ads' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
            </form>

            <!--================= REAL ESTATE HOUSES FORM ===================-->
            <form name="real_estate_houses_form" style="display: none;" action='<?php echo base_url() . 'user/post_ads' ?>' class='form form-horizontal validate-form real_estate_houses_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form3">
                 <input type="hidden" name="cat_id" >
                                                <input type="hidden" name="sub_cat">
                <div class="row form-group">
                                <div class="col-md-2 col-sm-3">Emirate <span> *</span></div>
                                <div class="col-md-6 col-sm-8 controls">
                                    <select class="form-control" name="city" id="city" data-rule-required='true'>
                                            <option value="">-- Select Emirate --</option>
                                             <?php foreach ($state as $st): ?>
                                            <?php if($st['state_id'] == @$_POST['city']) {?>
                                              <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city'],TRUE); ?> ><?php echo $st['state_name'] ?></option>
                                              <?php } else { ?>
                                              <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city']); ?> ><?php echo $st['state_name'] ?></option>
                                              <?php } ?>

                                           <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                                            <div class='form-group'>                        
                                                <div class='col-md-offset-2 col-md-6 col-sm-8 controls'>
                                                    <input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="houses_pro_neighbourhood" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Address</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Address" name="houses_ad_address" type="text" />
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Furnished</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="furnished" name="furnished" class="select2 form-control">
                                                        <option value="0">Select</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Bedrooms</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="bedrooms" name="bedrooms" class="select2 form-control">
                                                        <option value="0">Select Number</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>                     
                                                </div>
                                            </div>

                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Bathrooms</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="bathrooms" name="bathrooms" class="select2 form-control">
                                                        <option value="0">Select</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Pets</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="pets" name="pets" class="select2 form-control">
                                                        <option value="0">Select</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Broker Fee</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="broker_fee" name="broker_fee" class="select2 form-control">
                                                        <option value="0">Select</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Square Meters</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" placeholder="square_meters" id="pro_square_meters" name="pro_square_meters" type="number" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Title</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" placeholder="ad_title" name="houses_ad_title" id="pro_ad_title" type="text" data-rule-required='true'/>
                                                </div>
                                            </div>
                                           <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Upload Main Image</div>
                                                <div class='col-md-5'>
                                                    <!-- <div id="dragAndDropFiles" class="uploadArea">
                                                        <h1>Drop Images Here</h1>
                                                    </div> -->
                                                     <!-- <input type="file" id="file" name="vehicle_files[]" multiple="multiple" accept="image/*" /> -->
                                                     <input type="file" name="multiUpload1" id="multiUpload2" onchange="javascript:loadimage3(this);"/>
													 <img id="blah2" src="#" alt="" />
                                                </div>                                              
                                                <!-- <div class="progressBar">
                                                    <div class="status"></div>
                                                </div>
                                                <input type="button" name="upload_btn" id="upload_btn" value="Upload" />-->
                                            </div>                                          
                                            <div class='form-group'>  
												<div class="col-md-2 col-sm-3">Upload Sub-Images</div>												
												<a href="javascript:void(0);" id="attachMore3" class="col-md-2 btn btn-primary">Upload another file</a>
												<div class="clearfix"></div>												
												<div id="moreImageUpload3" class='col-md-12'></div>												
											</div>
                                            <div class='form-group'>
                                                <div class="col-md-2 col-sm-3">Describe what makes your ad unique</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <textarea class="form-control" placeholder="Description" name="house_pro_desc" rows="3" data-rule-required='true'></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Price</div>
                                                
                                                    <div class="input-group col-md-6 col-sm-8 controls">
                                                        <span style="color: #333333;" class="input-group-addon">Dirham</span>
                                                        <input type="text" id="houses_price" name="houses_price" class="form-control" data-rule-required='true'>
                                                        <span style="color: #333333;" class="input-group-addon">.00</span>
                                                      </div>
                                                      <div class="checkbox col-md-2">
                                                        <label>
                                                          <input name="houses_free" type="checkbox" value="1">
                                                          Free
                                                        </label>
                                                      </div>
                                                    <span for="houses_price" class="help-block has-error"></span>
                                                
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">My Ad is in</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="houses_language" name="houses_language" class="select2 form-control">
                                                        <option value="0">Select</option>
                                                        <option value="english">English</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submitHandler2" name="real_estate_houses_submit">
                                                            <i class='icon-save'></i>
                                                            Post
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>user/post_ads' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
            </form>
            <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
            <form name="real_estate_shared_form" style="display: none;" action='<?php echo base_url() . 'user/post_ads' ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form4">
                 <input type="hidden" name="cat_id">
                                                <input type="hidden" name="sub_cat">
                <div class="row form-group">
                                <div class="col-md-2 col-sm-3">Emirate <span> *</span></div>
                                <div class="col-md-6 col-sm-8 controls">
                                    <select class="form-control" name="city" id="city" data-rule-required='true'>
                                            <option value="">-- Select Emirate --</option>
                                             <?php foreach ($state as $st): ?>
                                            <?php if($st['state_id'] == @$_POST['city']) {?>
                                              <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city'],TRUE); ?> ><?php echo $st['state_name'] ?></option>
                                              <?php } else { ?>
                                              <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city']); ?> ><?php echo $st['state_name'] ?></option>
                                              <?php } ?>

                                           <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                                            <div class='form-group'>                        
                                                <div class='col-md-offset-2 col-md-5 controls'>
                                                    <input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Address</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Address" name="shared_ad_address" type="text" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Title</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" placeholder="ad_title" name="shared_ad_title" type="text" data-rule-required='true'/>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Upload Main Image</div>
                                                <div class='col-md-5'>
                                                    <!-- <div id="dragAndDropFiles" class="uploadArea">
                                                        <h1>Drop Images Here</h1>
                                                    </div> -->
                                                     <!-- <input type="file" id="file" name="vehicle_files[]" multiple="multiple" accept="image/*" /> -->
                                                     <input type="file" name="multiUpload1" id="multiUpload3" onchange="javascript:loadimage4(this);"/>
													 <img id="blah3" src="#" alt="" />
                                                </div>                                              
                                                <!-- <div class="progressBar">
                                                    <div class="status"></div>
                                                </div>
                                                <input type="button" name="upload_btn" id="upload_btn" value="Upload" />-->
                                            </div>                                          
                                            <div class='form-group'>  
												<div class="col-md-2 col-sm-3">Upload Sub-Images</div>												
												<a href="javascript:void(0);" id="attachMore4" class="col-md-2 btn btn-primary">Upload another file</a>
												<div class="clearfix"></div>												
												<div id="moreImageUpload4" class='col-md-12'></div>	
											</div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Describe what makes your ad unique</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <textarea class="form-control" placeholder="Description" name="shared_pro_desc" rows="3" data-rule-required='true'></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Price</div>
                                                
                                                    <div class="input-group col-md-6 col-sm-8 controls">
                                                        <span style="color: #333333;" class="input-group-addon">Dirham</span>
                                                        <input type="text" id="shared_price" name="shared_price" class="form-control" data-rule-required='true'>
                                                        <span style="color: #333333;" class="input-group-addon">.00</span>
                                                      </div>
                                                      <div class="checkbox col-md-2">
                                                        <label>
                                                          <input type="checkbox" name="shared_free" value="1">
                                                          Free
                                                        </label>
                                                      </div>
                                                    <span for="shared_price" class="help-block has-error"></span>
                                                
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">My Ad is in</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="shared_language" name="shared_language" class="select2 form-control">
                                                        <option value="0">Select</option>
                                                        <option value="english">English</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submitHandler3" name="real_estate_shared_submit">
                                                            <i class='icon-save'></i>
                                                            Post
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>user/post_ads' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>








                 <?php /*    <form action="<?php echo base_url(); ?>user/post_ads" method="post" enctype="multipart/form-data" class='validate-form'>
                            <h4><i class="fa fa-info-circle"></i>Item Details</h4>
                            <hr />
                             <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="row form-group">
                                <div class="col-md-2 col-sm-3">Ad Title <span> *</span></div>
                                <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="pro_name" data-rule-required="true"/></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2 col-sm-3">Category <span> *</span></div>
                                <div class="col-md-6 col-sm-8">
                                    <select class="form-control" id="category" name="cat_id"  onchange="show_sub_category(this.value);">
                                            <option value="0">--Select Category--</option>
                                             <?php foreach ($category as $cat): ?>
                                            <?php if($cat['category_id'] == @$_POST['cat_id']) {?>
                                            <option value="<?php echo $cat['category_id'] ?>" <?php echo set_select('cat', @$_POST['cat'],TRUE)?> ><?php echo $cat['catagory_name'] ?></option>
                                            <?php } else { ?>
                                            <option value="<?php echo $cat['category_id'] ?>" <?php echo set_select('cat', @$_POST['cat'])?> ><?php echo $cat['catagory_name'] ?></option>
                                            <?php }endforeach; ?>
                                    </select>
                                </div>
                            </div>
                             <div class="row form-group">
                                <div class="col-md-2 col-sm-3">Sub Category <span> *</span></div>
                                <div class="col-md-6 col-sm-8">
                                     <select class="form-control" id="sub_category" name="sub_category">
                                            <option value="0">--Select Sub Category--</option>
                                             
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row form-group" >
                                <div class="col-md-2 col-sm-3">Price <span> *</span></div>                                
                                <div class="col-md-6 col-sm-8"><input type="text" class="form-control price-box" name="pro_price" data-rule-required="true"/><span class="aed">AED</span></div>
                            </div>
                            <div class="row form-group" >
                                <div class="col-md-2 col-sm-3">Ad Discription <span> *</span></div>
                                <div class="col-md-6 col-sm-8"><textarea class="form-control"  name="pro_desc" data-rule-required="true"></textarea></div>
                            </div>
                            
                            <h4><i class="fa fa-image"></i>Upload Media</h4>
                            <hr />
                            <p>Images <i>(Ads with Photos sell faster)</i></p>
                            <div class="col-md-12">
                                <div class="col-md-11 images">
                            <input type="hidden" id="image_count" name="image_count" values="6"/>
                            <input type="file" class="custom-file-input" name="pro_image_0">
                            <input type="file" class="custom-file-input" name="pro_image_1">
                            <input type="file" class="custom-file-input" name="pro_image_2">
                            <input type="file" class="custom-file-input" name="pro_image_3">
                            <input type="file" class="custom-file-input" name="pro_image_4">
                            <input type="file" class="custom-file-input" name="pro_image_5"> 
                        </div><div class="col-md-1">
                            <a style="position:relative;" href="#"><i class="fa fa-plus-circle add-img"></i></a>
                        </div>
                        </div>
                            <p>Video</p>
                            <label class="video"><input class="video_radio" value="youtube_link" type="radio" name="v" />Youtube Link</label>
                            <label class="video"><input type="radio" name="v" class="video_radio" value="upload_video" />Upload Video</label>
                            <div class="row form-group" style="margin-top:20px;">
                                <div class="col-md-2 col-sm-3">Youtube Link</div>
                                <div class="col-md-6 col-sm-8"><input name="youtube_link" type="text" class="form-control" /></div>
                            </div>
                            
                            <h4><i class="fa fa-home"></i>Contact Details</h4>
                            <hr />
                            <div class="row form-group">
                                <div class="col-md-2 col-sm-3">Phone Number</div>
                                <div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="phone"/></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2 col-sm-3">Emirate <span> *</span></div>
                                <div class="col-md-6 col-sm-8">
                                    <select class="form-control" name="city" id="city">
                                            <option value="">-- Select Emirate --</option>
                                             <?php foreach ($state as $st): ?>
                                            <?php if($st['state_id'] == @$_POST['city']) {?>
                                              <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city'],TRUE); ?> ><?php echo $st['state_name'] ?></option>
                                              <?php } else { ?>
                                              <option value="<?php echo $st['state_id'] ?>" <?php echo set_select('state', @$_POST['city']); ?> ><?php echo $st['state_name'] ?></option>
                                              <?php } ?>

                                           <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-md-2 col-sm-3">Address</div>
                                <div class="col-md-6 col-sm-8"><textarea class="form-control" name="address"></textarea></div>
                                <div class="col-sm-12"><div id="googleMap" style="width:100%;height:250px; margin:20px 0;"></div></div>
                            </div>
                            
                            <hr />
                            
                            <p class="links no-padding">Share on <i class="fa fa-facebook"></i><i class="fa fa-twitter"></i><i class="fa fa-google-plus"></i></p>
                            <p class="tc">On submit, I will agree to <a href="#">Terms & Conditions</a></p>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    <button class="btn btn-blue" name="postAds" id="postAds">Post Ad</button>
                                </div>
                            </div>
                        </form>
                        */ ?>
                    </div>
                    <!--//content--><!--//content-->
                </div>
            </div>
            <!--//main-->
        </div>
        <!--//body-->
        
        <!--footer-->
            <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>
    <script type="text/javascript">
var hei			=	150;
var wid			=	150;
var min_height	=	400;
var min_width	=	700;
var err_msg		=	"Image Dimension must be grater than 700*400";
    $(function(){
    $('#submitHandler').click(function(){
        var inp = document.getElementById('multiUpload');
        var cnt = 0;
        var cnt1= 0;
        for (var i = 0; i < inp.files.length; ++i) 
        {
          var name = inp.files.item(i).name;
          var size = inp.files.item(i).size;
          var type = inp.files.item(i).type;
                
                if(type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                    cnt++;  
                else
                {
                    if (size > 1024)
                        cnt1++;             
                }       
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }
        /*else if(cnt1>0)
        {
            alert('Please upload an image with size less than 1 MB.');
            return false;
        }*/     
    })
})

$(function(){
    $('#submitHandler1').click(function(){
        var inp = document.getElementById('multiUpload1');
        var cnt = 0;
        var cnt1= 0;
        for (var i = 0; i < inp.files.length; ++i) 
        {
          var name = inp.files.item(i).name;
          var size = inp.files.item(i).size;
          var type = inp.files.item(i).type;
                
                if(type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                    cnt++;  
                else
                {
                    if (size > 1024)
                        cnt1++;             
                }       
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }
        /*else if(cnt1>0)
        {
            alert('Please upload an image with size less than 1 MB.');
            return false;
        }*/     
    })
})
$(function(){
    $('#submitHandler2').click(function(){
        var inp = document.getElementById('multiUpload2');
        var cnt = 0;
        var cnt1= 0;
        for (var i = 0; i < inp.files.length; ++i) 
        {
          var name = inp.files.item(i).name;
          var size = inp.files.item(i).size;
          var type = inp.files.item(i).type;
                
                if(type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                    cnt++;  
                else
                {
                    if (size > 1024)
                        cnt1++;             
                }       
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }
        /*else if(cnt1>0)
        {
            alert('Please upload an image with size less than 1 MB.');
            return false;
        }*/     
    })
})
$(function(){
    $('#submitHandler3').click(function(){
        var inp = document.getElementById('multiUpload3');
        var cnt = 0;
        var cnt1= 0;
        for (var i = 0; i < inp.files.length; ++i) 
        {
          var name = inp.files.item(i).name;
          var size = inp.files.item(i).size;
          var type = inp.files.item(i).type;
                
                if(type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif")
                    cnt++;  
                else
                {
                    if (size > 1024)
                        cnt1++;             
                }       
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }
        /*else if(cnt1>0)
        {
            alert('Please upload an image with size less than 1 MB.');
            return false;
        }*/     
    })
})

    
    
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
    var cat_text = $("#cat_id").find("option:selected").text();
    
    if(cat_text=='Real Estate'){
        if(subval!=0){
            var sub_cat = $("#show_sub_category option[value='"+subval+"']").text();
            if(sub_cat=='Houses - Apartments for Rent' || sub_cat=='Houses - Apartments for Sale'){
                $(".default_form").hide();
                $(".vehicle_form").hide();
                $(".real_estate").hide();
                $(".real_estate_houses_form").show();
                $("#real_estate_location").select2();
                $("#form_type").val("real_estate_houses_form");
                
            }else if(sub_cat=='Rooms for Rent - Shared' || sub_cat=='Housing Swap' || sub_cat=='Land' || sub_cat=='Shops for Rent - Sale' || sub_cat=='Office - Commercial Space'){
                $(".default_form").hide();
                $(".vehicle_form").hide();
                $(".real_estate").hide();
                $(".real_estate_shared_form").show();
                $("#shared_location").select2();
                $("#form_type").val("real_estate_shared_form");
            }
                
        }else{
            $(".default_form").hide();
            $(".vehicle_form").hide();
            $(".real_estate").hide();
        }
    }else if(cat_text=='Vehicles'){
        if(subval!=0){
            var sub_cat = $("#show_sub_category option[value='"+subval+"']").text();
            if(sub_cat=='cars'){
                $(".default_form").hide();
                $(".real_estate").hide();
                $(".vehicle_form").show();
                $("#form_type").val("vehicle_form");
                // initMultiUploader(config);
                $("#vehicle_pro_color").colorpicker();
            }else{
                $(".real_estate").hide();
                $(".vehicle_form").hide();
                $(".default_form").show();
                $("#form_type").val("default_form");

            }
        }
    }else{
        $(".real_estate").hide();
        $(".vehicle_form").hide();
        $(".default_form").show();
        $("#form_type").val("default_form");
    }

   
}
function show_sub_cat(val) {
    /*var cat_text = $("#cat_id option[value='"+val+"']").text();
    
    if(cat_text=='Vehicles'){
        $(".default_fields").hide();
        $(".real_estate").hide();
        $(".vehicle_fields").show();
    }else{
        $(".real_estate").hide();
        $(".vehicle_fields").hide();
        $(".default_fields").show();
    }*/
    $("input[name='cat_id']").val(val);
    $(".real_estate").hide();
    $(".vehicle_form").hide();    
    $(".default_form").show();
    $("#form_type").val("default_form");
    var url = "<?php echo base_url() ?>user/show_sub_category";
    $.post(url, {value: val}, function(data)
    {
                    //alert(data);
        $("#sub_cat_list").html(data);
        // $("#sub_cat").select2();


    });
   
}
    function show_sub_category(val) {
        
      $("input[name='cat_id']").val(val);

      var url = "<?php echo base_url() ?>user/show_sub_category";
      $.post(url, {value: val}, function(data)
      {
          $("#sub_category").html(data);
         
      });
      }
        jQuery(document).ready(function(){

          $(".add-img").click(function(e){
            e.preventDefault();
            var count = $("div.images input").length;
              $("#image_count").val(count);
              $("div.images").append('<input class="custom-file-input" type="file" name="pro_image_'+count+'">');
            });

          $("")
          /*$("#postAds").click(function(){
            alert("<?php echo $current_user->userAdsLeft; ?>");
            return false;
          });*/
        });

function show_model(val1) 
{
	var url = "<?php echo base_url() ?>user/show_model";
	$.post(url, {value: val1}, function(data)
	{                            
		$("#pro_model option").remove();
		$("#pro_model").append(data);

	});
}
var upload_number1 = 2;
$('#attachMore1').click(function() 
{
	if(upload_number1<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i><input type="file" id="upload_file' + upload_number1 + '" name="multiUpload' + upload_number1 + '"  onchange="javascript:loadimage11(this,'+upload_number1+')"></span><div class="clearfix"></div>';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number1 + ',1)" style="cursor:pointer;" onclick=""><i class="fa fa-trash"></i></a><img id="blah1'+upload_number1+'" src="#" alt="Image" style="display:none;"/></div>';	
		
		$('<dl class="col-md-2 file_upload_btn" id="delete_file1' + upload_number1 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload1');
		upload_number1++;
	}
});
var upload_number2 = 2;
$('#attachMore2').click(function() 
{
	if(upload_number2<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i><input type="file" id="upload_file' + upload_number2+ '" name="multiUpload' + upload_number2 + '" onchange="javascript:loadimage22(this,'+upload_number2+')"></span><div class="clearfix"></div>';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number2 + ',2)" style="cursor:pointer;" onclick=""><i class="fa fa-trash"></i></a><img id="blah2'+upload_number2+'" src="#" alt="Image" style="display:none;"/></div>';
		$('<dl  class="col-md-2 file_upload_btn" id="delete_file2' + upload_number2 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload2');
		upload_number2++;
	}
});
var upload_number3 = 2;
$('#attachMore3').click(function() 
{
	if(upload_number3<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i><input type="file" id="upload_file' + upload_number3 + '" name="multiUpload' + upload_number3 + '" onchange="javascript:loadimage33(this,'+upload_number3+')"></span><div class="clearfix"></div>';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number3 + ',3)" style="cursor:pointer;" onclick=""><i class="fa fa-trash"></i></a><img id="blah3'+upload_number3+'" src="#" alt="Image" style="display:none;"/></div>';
		$('<dl  class="col-md-2 file_upload_btn" id="delete_file3' + upload_number3 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload3');
		upload_number3++;
	}
});
var upload_number4 = 2;
$('#attachMore4').click(function() 
{
	if(upload_number4<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><span class="btn btn-warning fileinput-button"><i class="fa fa-plus"></i><input type="file" id="upload_file' + upload_number4 + '" name="multiUpload' + upload_number4 + '" onchange="javascript:loadimage44(this,'+upload_number4+')"></span><div class="clearfix"></div>';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number4 + ',4)" style="cursor:pointer;" onclick=""><i class="fa fa-trash"></i></a><img id="blah4'+upload_number4+'" src="#" alt="Image" style="display:none;"/></div>';
		$('<dl class="col-md-2 file_upload_btn" id="delete_file4' + upload_number4 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload4');
		
		upload_number4++;
	}
});

function del_file(eleId,a) 
{
	
        var ele = document.getElementById("delete_file"+a+ eleId);
		ele.parentNode.removeChild(ele);
		if(a==1)
			upload_number1--;
		else if(a==2)	
			upload_number2--;
		else if(a==3)		
			upload_number3--;
		else if(a==4)			
			upload_number4--;
		alert("Image Removed");
}

function loadimage11(input,a) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {

			$('#blah1'+a)
				.attr('src', e.target.result)
				.width(wid)
				.height(hei);
				
				var imgcon	=	$("#blah1"+a)[0];				
				var img = imgcon;				
				console.log(img);
				var pic_real_width, pic_real_height;
				$("<img/>") 
					.attr("src", $(img).attr("src"))
					.load(function() {
						pic_real_width = this.width;  						
						pic_real_height = this.height;
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							$('#upload_file'+a).val('');
							$(".file-input-name").html("");
							$(imgcon).attr("src", "");
							$(imgcon).hide();
						}
						else
						{
							$(imgcon).attr("src", $(img).attr("src"));
							$(imgcon).show();
						}
						// alert("Width"+pic_real_width);
						// alert("Height"+pic_real_height);
					});	
		};
		reader.readAsDataURL(input.files[0]);
	}
}
function loadimage22(input,a) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {

			$('#blah2'+a)
				.attr('src', e.target.result)
				.width(wid)
				.height(hei);
				
				var imgcon	=	$("#blah2"+a)[0];				
				var img = imgcon;				
				console.log(img);
				var pic_real_width, pic_real_height;
				$("<img/>") 
					.attr("src", $(img).attr("src"))
					.load(function() {
						pic_real_width = this.width;  						
						pic_real_height = this.height;
				
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							$('#upload_file'+a).val('');
							$(".file-input-name").html("");
							$(imgcon).attr("src", "");
							$(imgcon).hide();
						}
						else
						{
							$(imgcon).attr("src", $(img).attr("src"));
							$(imgcon).show();
						}	
						// alert("Width"+pic_real_width);
						// alert("Height"+pic_real_height);
					});	
		};
		reader.readAsDataURL(input.files[0]);
	}
}
function loadimage33(input,a) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {

			$('#blah3'+a)
				.attr('src', e.target.result)
				.width(wid)
				.height(hei);
				
				var imgcon	=	$("#blah3"+a)[0];				
				var img = imgcon;				
				console.log(img);
				var pic_real_width, pic_real_height;
				$("<img/>") 
					.attr("src", $(img).attr("src"))
					.load(function() {
						pic_real_width = this.width;  
						pic_real_height = this.height;
						
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							$('#upload_file'+a).val('');
							$(".file-input-name").html("");
							$(imgcon).attr("src", "");
							$(imgcon).hide();
						}
						else
						{
							$(imgcon).attr("src", $(img).attr("src"));
							$(imgcon).show();
						}						
						// alert("Height"+pic_real_height);
						// alert("Width"+pic_real_width);
					});	
		};
		reader.readAsDataURL(input.files[0]);
	}
}
function loadimage44(input,a) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {

			$('#blah4'+a)
				.attr('src', e.target.result)
				.width(wid)
				.height(hei);
				
				var imgcon	=	$("#blah4"+a)[0];				
				var img = imgcon;				
				console.log(img);
				var pic_real_width, pic_real_height;
				$("<img/>") 
					.attr("src", $(img).attr("src"))
					.load(function() {
						pic_real_width = this.width;  						
						pic_real_height = this.height;
						if(pic_real_width<min_width || pic_real_height<min_height)
						{
							alert(err_msg);
							$('#upload_file'+a).val('');
							$(".file-input-name").html("");
							$(imgcon).attr("src", "");
							$(imgcon).hide();
						}
						else
						{
							$(imgcon).attr("src", $(img).attr("src"));
							$(imgcon).show();
						}		
						// alert("Height"+pic_real_height);
						// alert("Width"+pic_real_width);
					});	
		};
		reader.readAsDataURL(input.files[0]);
	}
}
$('#blah').hide();
$('#blah1').hide();
$('#blah2').hide();
$('#blah3').hide();
	function loadimage1(input) 
	{
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
			$('#blah').show();
			
				$('#form1 #blah')
					.attr('src', e.target.result)
					.width(wid)
					.height(hei);				
					
					var img = $("#blah")[0];
						console.log(img);
						var pic_real_width, pic_real_height;
						$("<img/>") 
						   .attr("src", $(img).attr("src"))
						   .load(function() {
							pic_real_width = this.width;   							
							pic_real_height = this.height; 
							if(pic_real_width<min_width || pic_real_height<min_height)
							{
								alert(err_msg);		
								$('#multiUpload').val('');
								//$(".file-input-name").html("");								
								$('#form1 #blah').attr("src", "");
								$('#form1 #blah').hide();
							}
							// alert("1Width"+pic_real_width);
							// alert("1Height"+pic_real_height);
					 });
				
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	

	function loadimage2(input)
	{
		
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {		
			$('#blah1').show();
				//form 3 
				$('#form2 #blah1')
					.attr('src', e.target.result)
					.width(wid)
					.height(hei);
						var img = $("#blah1")[0];
						console.log(img);
						var pic_real_width, pic_real_height;
						$("<img/>") 
						   .attr("src", $(img).attr("src"))
						   .load(function() {
							pic_real_width = this.width;   							
							pic_real_height = this.height; 
							if(pic_real_width<min_width || pic_real_height<min_height)
							{
								alert(err_msg);		
								$('#multiUpload1').val('');								
								$(".file-input-name").html("");
								$('#form2 #blah1').attr("src", "");
								$('#form2 #blah1').hide();
							}
							// alert("2Height"+pic_real_height);
							// alert("2Width"+pic_real_width);
					 });
				
			};
			reader.readAsDataURL(input.files[0]);
		} 
	}
	function loadimage3(input)
	{
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {		
			$('#blah2').show();
				//form 3 
				$('#form3 #blah2')
					.attr('src', e.target.result)
					.width(wid)
					.height(hei);
						var img = $("#blah2")[0];
						console.log(img);
						var pic_real_width, pic_real_height;
						$("<img/>") 
						   .attr("src", $(img).attr("src"))
						   .load(function() {
							pic_real_width = this.width;   							
							pic_real_height = this.height; 
							if(pic_real_width<min_width || pic_real_height<min_height)
							{
								alert(err_msg);
								$('#multiUpload2').val('');								
								$(".file-input-name").html("");
								$('#form3 #blah2').attr("src", "");
								$('#form3 #blah2').hide();
							}
							// alert("3Height"+pic_real_height);
							// alert("3Width"+pic_real_width);
					 });
				
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	function loadimage4(input)
	{
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {		
			$('#blah3').show();
				//form 3 
				$('#form4 #blah3')
					.attr('src', e.target.result)
					.width(wid)
					.height(hei);
						var img = $("#blah3")[0];
						console.log(img);
						var pic_real_width, pic_real_height;
						$("<img/>") 
						   .attr("src", $(img).attr("src"))
						   .load(function() {
							pic_real_width = this.width;   							
							pic_real_height = this.height; 
							if(pic_real_width<min_width || pic_real_height<min_height)
							{
								alert(err_msg);
								$('#multiUpload3').val('');								
								$(".file-input-name").html("");
								$('#form4 #blah3').attr("src", "");
								$('#form4 #blah3').hide();
							}
							// alert("4Width"+pic_real_width);
							// alert("4Height"+pic_real_height);
					 });			
			};
			reader.readAsDataURL(input.files[0]);
		}
	}
	/*function readURL(input) 
	{
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah1').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah2').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah3').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
		
    }
    
    $("#multiUpload").change(function(){
        readURL(this);
    });
	$("#multiUpload1").change(function(){
        readURL(this);
    });
	$("#multiUpload2").change(function(){
        readURL(this);
    });
	$("#multiUpload3").change(function(){
        readURL(this);
    });
		*/
    </script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / theme file [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
<!--container-->
</body>
</html>
