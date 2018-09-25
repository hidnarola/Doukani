<html>
<head>
     <?php $this->load->view('include/head'); ?>
    <script type="text/javascript">
    function initialize() {
      var mapProp = {
        center:new google.maps.LatLng(51.508742,-0.120850),
        zoom:5,
        mapTypeId:google.maps.MapTypeId.ROADMAP
      };
      var map=new google.maps.Map(document.getElementById("googleMap"), mapProp);
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
	
</head>

<body>
<!--container-->
    <div class="container-fluid">
        <?php $this->load->view('include/header'); ?>
        <?php $this->load->view('include/menu'); ?>
        <div class="row page">
            <?php $this->load->view('include/sub-header'); ?>
            <div class="col-sm-12 main postad">
                <div class="row">
                    <?php $this->load->view('include/left-nav'); ?>
                    <div class="col-sm-10 post-ad">
                        <h3>Edit your ad</h3>
                        <div class='box-content'>
                            <div class='row'>
                            <div class='form-group'>  
                                
                                <div class="col-md-2 col-sm-3">Category</div>
                                <div class='col-md-6 col-sm-8 controls' style="padding: 0px 12px 14px 14px;">
                                     <select class="form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);">
                                        <?php foreach ($category1 as $cat): ?>
                                            <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $product[0]['category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <div class='row'>       
                                                <div class='form-group'>  
                                                <!--<label class='col-md-2 control-label text-right' for='inputText1'>Sub Category</label>-->                                                
                                                <div class="col-md-2 col-sm-3">Sub Category</div>
                                                <div class='col-md-6 col-sm-8 controls' id="sub_cat_list" style="padding: 0px 12px 14px 14px;">
                                                     <select class="form-control" id="sub_cat1" name="sub_cat" >
                                                        <?php foreach ($sub_category1 as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>" <?php echo ($cat['sub_category_id'] == $product[0]['sub_category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                            
                                                </div>
                                                </div>
                                            </div>
                                            <!--===================== DEFAULT FORM ======================-->


                                                <?php if($product_type=='default'){ ?>

                                            <form  name="default_form" action='<?php echo base_url() . 'user/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form default_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                                <input type="hidden" name="cat_id" value="<?php echo $product[0]['category_id']; ?>">
                                                <input type="hidden" name="sub_cat" value="<?php echo $product[0]['sub_category_id']; ?>">
                                                <div class='form-group'>
												<input type="hidden" id='mycounter1' value="<?php echo $mycounter; ?>">
                                                    <div class="col-md-2 col-sm-3">Name<span> *</span></div>
                                                    <div class='col-md-6 col-sm-8 controls'>
                                                        <input placeholder='Product Name' class="form-control" value="<?php echo $product[0]['product_name']; ?>" name="pro_name" type='text' data-rule-required='true'/>
                                                    </div>
                                                </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Description<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <textarea class="form-control" id="inputTextArea1" placeholder="Description" name="pro_desc" rows="3" data-rule-required='true'><?php echo $product[0]['product_description']; ?></textarea>
                                                </div>
                                            </div>                                          
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Upload Main Image</div>
                                                <div class='col-md-5'>
                                                    <!-- <div id="dragAndDropFiles" class="uploadArea">
                                                        <h1>Drop Images Here</h1>
                                                    </div> -->
                                                     <!-- <input type="file" id="file" name="vehicle_files[]" multiple="multiple" accept="image/*" /> -->
														<input type="file" name="multiUpload1" id="multiUpload"/>														
														<img id="blah" src="#" alt="" style="display: inline-block;vertical-align: top;"  />
														
                                                    <?php if (!empty($product[0]['product_image'])): ?>
                                                    <div class='form-group' style="display: inline-block;">
                                                        <div class="col-md-2"></div>
                                                        <div class='col-md-5'>
                                                            <div class='gallery'>                                                   
                                                                <ul class='list-unstyled list-inline'>                                                              
                                                                  <li>                                                  
                                                                    <div class='picture'>
                                                                      <div class='tags'>
                                                                        <div class='label label-important'><a  class="delete_btn1" style="cursor:pointer;" onclick="javascript:deletemainimg('<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
                                                                      </div>                              
                                                                      <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $product[0]['product_image']; ?>'>
                                                                        <img alt="product Image" src="<?php echo base_url() . product . "medium/" . $product[0]['product_image']; ?>" />
                                                                      </a>
                                                                    </div>                          
                                                                  </li>                                                                           
                                                                </ul>                       
                                                            </div>                                                              
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
												
                                                </div>                                              
                                                <!-- <div class="progressBar">
                                                    <div class="status"></div>
                                                </div>
                                                <input type="button" name="upload_btn" id="upload_btn" value="Upload" />-->
                                            </div>                                          
                                            <div class='form-group'>  
												<div class="col-md-2 col-sm-3">Upload Sub-Images</div>												
												<div class="col-md-10"><a href="javascript:void(0);" id="attachMore1" class="btn btn-primary">Upload another file</a></div>
												<div class="clearfix"></div>
												<div id="moreImageUpload1" class='col-md-12'></div>
											</div>
											<div class="form-group" >                                                
                                                 <div class='col-md-12'>
                                                  <div class='gallery'>                                                 
                                                    <ul class='list-unstyled list-inline'>
                                                    <?php  foreach($images as $i):  ?>  
                                                      <li>                                                  
                                                        <div class='picture'>
                                                          <div class='tags'>
                                                            <div class='label label-important'>
															<a  style="cursor:pointer;" class="delete_btn2" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>','<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
                                                          </div>                              
                                                            <a data-lightbox='flatty' href="<?php echo base_url() . product . "original/" . $i['product_image']; ?>">
                                                            <img alt="product Image" src="<?php echo base_url() . product . "medium/" . $i['product_image']; ?>" width="150px" height="150px">
                                                          </a>
                                                        </div>                          
                                                      </li>      
                                                        <?php   endforeach; ?>                        
                                                    </ul>                       
                                                  </div>
                                                </div>
                                            </div>
                                                                                   
                                            
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Emirate<span> *</span></div>
                                                 <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="shared_location" name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required="true">
                                                        <option value="">Select</option>
                                                        <?php foreach ($state as $o) { ?>
                                                            <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
                                                        <?php } ?>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Price<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Price" value="<?php echo $product[0]['product_price']; ?>" name="pro_price" type="text" data-rule-required='true' />
                                                </div>
                                            </div>
                                            <!--<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Brand</label>
                                                <div class='col-md-5'>
                                                    <!--<input class="form-control"  placeholder="Brand" name="pro_brand" type="text" value="<?php //echo $product[0]['product_brand']; ?>" />-->
                                                   <!-- <select name="pro_brand"  class="form-control select2 ">    
                                                        <option value="">Select Brand</option>  
                                                        <?php //foreach($brand as $col):?>
                                                            <option value="<?php //echo $col['brand_id']; ?>"
                                                            <?php //if($col['brand_id']==$product[0]['product_brand']) echo 'selected=selected'; else echo ''; ?>><?php //echo $col['name']; ?></option>            
                                                        <?php //endforeach;   ?>
                                                    </select>       
                                                </div>
                                            </div>-->
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submitHandler" name="default_submit">
                                                            <i class='icon-save'></i>
                                                            Repost
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>user/my_listing' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                            <?php } else if($product_type=='vehicle'){ ?>
                    <!--=========================== VEHICLE FORM =============================-->

            <form name="vehicle_form" style="display: none;" action='<?php echo base_url() . 'user/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form vehicle_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                            <input type="hidden" name="cat_id" value="<?php echo $product[0]['category_id']; ?>">
                                            <input type="hidden" name="sub_cat" value="<?php echo $product[0]['sub_category_id']; ?>">
                                            <div class="form-group" >
											<input type="hidden" id='mycounter2' value="<?php echo $mycounter; ?>">
                                                <div class="col-md-2 col-sm-3">Emirate<span> *</span></div>
                                                 <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="shared_location" name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required="true">
                                                        <option value="">Select</option>
                                                        <?php foreach ($state as $o) { ?>
                                                            <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
                                                        <?php } ?>
                                                    </select>                     
                                                </div>
                                            </div>      
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Title<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" value="<?php echo $product[0]['product_name']; ?>" placeholder="Title" name="title" type="text" data-rule-required='true'/>
                                                </div>
                                            </div>
                                            <!--<div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Make</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="pro_make" name="vehicle_pro_make" class="select2 form-control">
                                                        <option <?php //echo ($product[0]['make']==0 || $product[0]['make']=='' ) ? 'selected' : ''; ?> value="0">Select</option>
                                                        <option <?php //echo ($product[0]['make']=='make1') ? 'selected' : ''; ?> value="make1">Make 1</option>
                                                        <option <?php //echo ($product[0]['make']=='make2') ? 'selected' : ''; ?> value="make2">Make 2</option>
                                                        <option <?php //echo ($product[0]['make']=='make3') ? 'selected' : ''; ?> value="make3">Make 3</option>
                                                        <option <?php //echo ($product[0]['make']=='make4') ? 'selected' : ''; ?> value="make4">Make 4</option>
                                                    </select>                     
                                                </div>
                                            </div>-->
											<div class='form-group'>                                                                        
												<div class="col-md-2 col-sm-3">Car Brand</div>
												<input type="hidden" id="mybrand" value="<?php echo $product[0]['product_brand']; ?>">
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <!--<input class="form-control"  placeholder="Brand" name="pro_brand" type="text" value="<?php //echo $product[0]['product_brand']; ?>" /> -->                                                  
                                                    <select name="pro_brand"  class="form-control select2 " onchange="show_model(this.value);" id="pro_brand">    
                                                        <option value="">Select Brand</option>  
                                                        <?php foreach($brand as $col):?>
                                                            <option value="<?php echo $col['brand_id']; ?>"  <?php echo ($product[0]['product_brand']==$col['brand_id']) ? 'selected' : ''; ?>><?php echo $col['name']; ?></option>
                                                        <?php endforeach;   ?>
                                                    </select>                                               
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Car Model</div>
                                                <div class='col-md-6 col-sm-8 controls'>											
                                                    <select id="pro_model" name="vehicle_pro_model" class="select2 form-control">
														<?php foreach($model as $col):?>
                                                            <option value="<?php echo $col['model_id']; ?>"  <?php echo ($product[0]['model']==$col['model_id']) ? 'selected' : ''; ?> class="myhide"><?php echo $col['name']; ?></option>
                                                        <?php endforeach;   ?>      
														  <!-- <option value="<?php //echo $col['brand_id']; ?>"  <?php //echo ($product[0]['model']==$col['model_id']) ? 'selected' : ''; ?>><?php //echo $col['name']; ?></option>-->
                                                        
                                                       <!-- <option <?php //echo ($product[0]['model']==0 || $product[0]['model']=='' ) ? 'selected' : ''; ?> value="0">Select</option>
                                                        <option <?php //echo ($product[0]['model']=='model1') ? 'selected' : ''; ?> value="model1">Model 1</option>
                                                        <option <?php //echo ($product[0]['model']=='model2') ? 'selected' : ''; ?> value="model2">Model 2</option>
                                                        <option <?php //echo ($product[0]['model']=='model3') ? 'selected' : ''; ?> value="model3">Model 3</option>
                                                        <option <?php //echo ($product[0]['model']=='model4') ? 'selected' : ''; ?> value="model4">Model 4</option> -->
                                                    </select>  
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Type Of Car</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" value="<?php echo $product[0]['type_of_car']; ?>" placeholder="Type Of Car" name="vehicle_pro_type_of_car" type="text" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Year</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control datepicker-years" value="<?php echo $product[0]['year']; ?>" placeholder="Select Year" id="vehicle_pro_year" name="vehicle_pro_year" type="text" />
                                                </div>
                                            </div>
                                          <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Mileage</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <!--<input class="form-control" value="<?php echo $product[0]['millage']; ?>"  placeholder="Mileage" name="vehicle_pro_mileage" id="vehicle_pro_mileage" type="text" />-->
                                                    <select name="vehicle_pro_mileage" id="vehicle_pro_mileage"  class="select2 form-control">
                                                    <option value="">Select Mileage</option>
                                                    <?php foreach($mileage as $col):?>
                                                        <option value="<?php echo $col['mileage_id']; ?>"
                                                        <?php if($col['mileage_id']==$product[0]['millage']) echo 'selected=selected'; else echo ''; ?>><?php echo $col['name']; ?></option>            
                                                    <?php endforeach;   ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Condition</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" value="<?php echo $product[0]['vehicle_condition']; ?>"  placeholder="Condition" name="vehicle_pro_condition" id="vehicle_pro_condition" type="text" />
                                                </div>
                                            </div>

                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Choose color</div>
                                                <div class='col-md-6 col-sm-8 controls'><!-- kesha -->
                                                   <!--<input class='colorpicker-hex form-control' value="<?php //echo $product[0]['color']; ?>" name="vehicle_pro_color" id="vehicle_pro_color" placeholder='Pick a color' style='margin-bottom: 0;' type='text'> -->
                                                   <select name="vehicle_pro_color"  class="form-control" id="ms" > 
                                                        <option value="">Select Color</option>                                  
                                                        <?php foreach($colors as $col):  ?>                                     
                                                        <option style="color:<?php echo $col['font_color']; ?>;background-color:<?php echo $col['background_color']; ?>" value="<?php echo $col['background_color']; ?>"
                                                        <?php if($product[0]['color']==$col['background_color']) echo 'selected=selected'; else echo ''; ?>><?php echo $col['name']; ?></option>
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
                                                     <input type="file" name="multiUpload1" id="multiUpload1"/>													  
													 <img id="blah1" src="#" alt="" style="display: inline-block;" />
                                                    <?php if (!empty($product[0]['product_image'])): ?>
                                                    <div class='form-group' style="display: inline-block;vertical-align: top;">
                                                        <div class="col-md-2"></div>
                                                        <div class='col-md-5'>
                                                            <div class='gallery'>                                                   
                                                                <ul class='list-unstyled list-inline'>                                                              
                                                                  <li>                                                  
                                                                    <div class='picture'>
                                                                      <div class='tags'>
                                                                        <div class='label label-important'><a  class="delete_btn1"  onclick="javascript:deletemainimg('<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
                                                                      </div>                              
                                                                      <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $product[0]['product_image']; ?>'>
                                                                        <img alt="product Image" src="<?php echo base_url() . product . "medium/" . $product[0]['product_image']; ?>" />
                                                                      </a>
                                                                    </div>                          
                                                                  </li>                                                                           
                                                                </ul>                       
                                                            </div>                                                              
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
												
                                                </div>                                              
                                                <!-- <div class="progressBar">
                                                    <div class="status"></div>
                                                </div>
                                                <input type="button" name="upload_btn" id="upload_btn" value="Upload" />-->
                                            </div>                                          
                                            <div class='form-group'>  
												<div class="col-md-2 col-sm-3">Upload Sub-Images</div>
												<div class="col-md-10"><a href="javascript:void(0);" id="attachMore2" class="btn btn-primary">Upload another file</a></div>
												<div class="clearfix"></div>
												<div id="moreImageUpload2" class='col-md-12'></div>												
											</div>
											<div class="form-group" >                                                
                                                 <div class='col-md-12'>
                                                  <div class='gallery'>                                                 
                                                    <ul class='list-unstyled list-inline'>
                                                    <?php  foreach($images as $i):  ?>  
                                                      <li>                                                  
                                                        <div class='picture'>
                                                          <div class='tags'>														
                                                            <div class='label label-important'><a  class="delete_btn2" style="cursor:pointer;" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>','<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
                                                          </div>                              
                                                            <a data-lightbox='flatty' href="<?php echo base_url() . product . "original/" . $i['product_image']; ?>">
                                                            <img alt="product Image" src="<?php echo base_url() . product . "medium/" . $i['product_image']; ?>" width="150px" height="150px">
                                                          </a>
                                                        </div>                          
                                                      </li>      
                                                        <?php   endforeach; ?>                        
                                                    </ul>                       
                                                  </div>
                                                </div>
                                            </div>
                                            
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Description<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <textarea class="form-control" id="vehicle_pro_desc" placeholder="Description" name="vehicle_pro_desc" rows="3" data-rule-required='true'><?php echo $product[0]['product_description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Price<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Price" value="<?php echo $product[0]['product_price']; ?>" name="vehicle_pro_price" id="vehicle_pro_price" type="text" data-rule-required='true' />
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submitHandler1" name="vehicle_submit">
                                                            <i class='icon-save'></i>
                                                            Repost
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>user/my_listing' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
            </form>
<?php } else if($product_type=='real_estate'){ ?>
            <!--================= REAL ESTATE HOUSES FORM ===================-->
            <form name="real_estate_houses_form" style="display: none;" action='<?php echo base_url() . 'user/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form real_estate_houses_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                            <input type="hidden" name="cat_id" value="<?php echo $product[0]['category_id']; ?>">
                                            <input type="hidden" name="sub_cat" value="<?php echo $product[0]['sub_category_id']; ?>">
                                            <input type="hidden" id='mycounter3' value="<?php echo $mycounter; ?>">
                                            <div class='form-group'>                        
                                                <div class='col-md-offset-2 col-md-6 col-sm-8 controls'>
                                                    <input type="text" class="form-control" value="<?php echo $product[0]['neighbourhood']; ?>" placeholder="Neighbourhood (Optional)" name="houses_pro_neighbourhood" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Title<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" placeholder="Ad Title" name="houses_ad_title" value="<?php echo $product[0]['product_name']; ?>" id="pro_ad_title" type="text" data-rule-required='true'/>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Address</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control"  placeholder="Address" value="<?php echo $product[0]['address']; ?>" name="houses_ad_address" type="text" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                                                
                                                <div class="col-md-2 col-sm-3">Emirate<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="shared_location" name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required="true">
                                                        <option value="0">Select</option>
                                                        <?php foreach ($state as $o) { ?>
                                                            <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
                                                        <?php } ?>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Furnished</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="furnished" name="furnished" class="select2 form-control">
                                                        <option <?php echo ($product[0]['furnished'] == 0 || $product[0]['furnished'] == '') ? 'selected':'' ;?> value="0">Select</option>
                                                        <option <?php echo ($product[0]['furnished'] == 'yes') ? 'selected' : ''; ?>  value="yes">Yes</option>
                                                        <option <?php echo ($product[0]['furnished'] == 'no') ? 'selected' : ''; ?> value="no">No</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Bedrooms</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="bedrooms" name="bedrooms" class="select2 form-control">
                                                       <option value="0">Select Number</option>
                                                        <?php for($i=1;$i<6;$i++){ ?>
                                                            <option <?php echo ($product[0]['Bedrooms'] == $i) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>                     
                                                </div>
                                            </div>

                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Bathrooms</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="bathrooms" name="bathrooms" class="select2 form-control">
                                                        <option value="0">Select Number</option>
                                                        <?php for($i=1;$i<4;$i++){ ?>
                                                            <option <?php echo ($product[0]['Bathrooms'] == $i) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Pets</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="pets" name="pets" class="select2 form-control">
                                                        <option <?php echo ($product[0]['pets'] == 0 || $product[0]['pets'] == '') ? 'selected':'' ;?> value="0">Select</option>
                                                        <option <?php echo ($product[0]['pets'] == 'yes') ? 'selected' : ''; ?>  value="yes">Yes</option>
                                                        <option <?php echo ($product[0]['pets'] == 'no') ? 'selected' : ''; ?> value="no">No</option>
                                                    </select>                 
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">Broker Fee</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="broker_fee" name="broker_fee" class="select2 form-control">
                                                        <option <?php echo ($product[0]['broker_fee'] == 0 || $product[0]['broker_fee'] == '') ? 'selected':'' ;?> value="0">Select</option>
                                                        <option <?php echo ($product[0]['broker_fee'] == 'yes') ? 'selected' : ''; ?>  value="yes">Yes</option>
                                                        <option <?php echo ($product[0]['broker_fee'] == 'no') ? 'selected' : ''; ?> value="no">No</option>
                                                    </select>                      
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Square Meters</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" placeholder="square_meters" id="pro_square_meters" value="<?php echo $product[0]['Area']; ?>" name="pro_square_meters" type="number" />
                                                </div>
                                            </div>                                            
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Upload Main Image</div>
                                                <div class='col-md-5'>
                                                    <!-- <div id="dragAndDropFiles" class="uploadArea">
                                                        <h1>Drop Images Here</h1>
                                                    </div> -->
                                                     <!-- <input type="file" id="file" name="vehicle_files[]" multiple="multiple" accept="image/*" /> -->
                                                     <input type="file" name="multiUpload1" id="multiUpload2"/>													 
													 <img id="blah2" src="#" alt="" style="display: inline-block;vertical-align: top;" />
													 
                                                    <?php if (!empty($product[0]['product_image'])): ?>
                                                    <div class='form-group' style="display: inline-block;">
                                                        <div class="col-md-2"></div>
                                                        <div class='col-md-5'>
                                                            <div class='gallery'>                                                   
                                                                <ul class='list-unstyled list-inline'>                                                              
                                                                  <li>                                                  
                                                                    <div class='picture'>
                                                                      <div class='tags'>
                                                                        <div class='label label-important'><a  class="delete_btn1"  onclick="javascript:deletemainimg('<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
                                                                      </div>                              
                                                                      <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $product[0]['product_image']; ?>'>
                                                                        <img alt="product Image" src="<?php echo base_url() . product . "medium/" . $product[0]['product_image']; ?>" />
                                                                      </a>
                                                                    </div>                          
                                                                  </li>                                                                           
                                                                </ul>                       
                                                            </div>                                                              
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
												
                                                </div>                                              
                                                <!-- <div class="progressBar">
                                                    <div class="status"></div>
                                                </div>
                                                <input type="button" name="upload_btn" id="upload_btn" value="Upload" />-->
                                            </div>                                          
                                            <div class='form-group'>  
												<div class="col-md-2 col-sm-3">Upload Sub-Images</div>												
												<div class="col-md-10"><a href="javascript:void(0);" id="attachMore3" class="btn btn-primary">Upload another file</a></div>
												<div class="clearfix"></div>
												<div id="moreImageUpload3" class='col-md-12'></div>												
											</div>
											<div class="form-group" >                                                
                                                 <div class='col-md-12'>
                                                  <div class='gallery'>                                                 
                                                    <ul class='list-unstyled list-inline'>
                                                    <?php  foreach($images as $i):  ?>  
                                                      <li>                                                  
                                                        <div class='picture'>
                                                          <div class='tags'>														    
                                                            <div class='label label-important'><a  class="delete_btn2"  style="cursor:pointer;" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>','<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
                                                          </div>                              
                                                            <a data-lightbox='flatty' href="<?php echo base_url() . product . "original/" . $i['product_image']; ?>">
                                                            <img alt="product Image" src="<?php echo base_url() . product . "medium/" . $i['product_image']; ?>" width="150px" height="150px">
                                                          </a>
                                                        </div>                          
                                                      </li>      
                                                        <?php   endforeach; ?>                        
                                                    </ul>                       
                                                  </div>
                                                </div>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <div class="col-md-2 col-sm-3">Describe what makes your ad unique<span> *</span></div>
                                                <div class='col-md-5 controls'>
                                                    <textarea class="form-control" placeholder="Description" name="house_pro_desc" rows="3" data-rule-required='true'><?php echo $product[0]['product_description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group col-md-12'>                       
                                                <div class="col-md-2 col-sm-3">Price<span> *</span></div>
                                                
                                                    <div class="input-group col-md-6 col-sm-8 controls">
                                                        <span class="input-group-addon">Dirham</span>
                                                        <input type="text" value="<?php echo $product[0]['product_price']; ?>" id="houses_price" name="houses_price" class="form-control"  data-rule-required='true'>
                                                        <span class="input-group-addon">.00</span>
                                                      </div>
                                                      <div class="checkbox col-md-1">
                                                        <label>
                                                          <input name="houses_free" <?php echo ($product[0]['free_status'] == 1) ? 'checked' : ''; ?> type="checkbox" value="1">
                                                          Free
                                                        </label>
                                                      </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">My Ad is in</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="houses_language" name="houses_language" class="select2 form-control">
                                                        <option <?php echo ($product[0]['ad_language'] == 0 || $product[0]['ad_language'] == '') ? 'selected':'' ;?> value="0">Select</option>
                                                        <option <?php echo ($product[0]['ad_language'] == 'english') ? 'selected' : ''; ?> value="english">English</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submitHandler2" name="real_estate_houses_submit">
                                                            <i class='icon-save'></i>
                                                            Repost
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>user/my_listing' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
            </form>
            <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
            <form name="real_estate_shared_form" style="display: none;" action='<?php echo base_url() . 'user/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                             <div class='form-group'>                        
                                                <div class='col-md-offset-2 col-sm-6 col-sm-8 controls'>
												<input type="hidden" id='mycounter4' value="<?php echo $mycounter; ?>">
                                                    <input type="text" class="form-control" value="<?php echo $product[0]['neighbourhood']; ?>" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Title<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" placeholder="Ad Title" value="<?php echo $product[0]['product_name']; ?>" name="shared_ad_title" type="text" data-rule-required='true' />
                                                </div>
                                            </div>             
                                            <div class="form-group" >
                                                <input type="hidden" name="cat_id" value="<?php echo $product[0]['category_id']; ?>">
                                                <input type="hidden" name="sub_cat" value="<?php echo $product[0]['sub_category_id']; ?>">                                              
                                                <div class="col-md-2 col-sm-3">Emirate<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls controls'>
                                                    <select id="shared_location" name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required="true">
                                                        <option value="">Select</option>
                                                        <?php foreach ($state as $o) { ?>
                                                            <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
                                                        <?php } ?>
                                                    </select>                     
                                                </div>
                                            </div>                                           
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Ad Address</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <input class="form-control" value="<?php echo $product[0]['address']; ?>"  placeholder="Address" name="shared_ad_address" type="text" />
                                                </div>
                                            </div>
                                            
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Upload Main Image</div>
                                                <div class='col-md-5'>
                                                    <!-- <div id="dragAndDropFiles" class="uploadArea">
                                                        <h1>Drop Images Here</h1>
                                                    </div> -->
                                                     <!-- <input type="file" id="file" name="vehicle_files[]" multiple="multiple" accept="image/*" /> -->
                                                     <input type="file" name="multiUpload1" id="multiUpload3"/>													  
													 <img id="blah3" src="#" alt="" style="display: inline-block;"/>
                                                    <?php if (!empty($product[0]['product_image'])): ?>
                                                    <div class='form-group' style="display: inline-block;vertical-align: top;">
                                                        <div class="col-md-2"></div>
                                                        <div class='col-md-5'>
                                                            <div class='gallery'>                                                   
                                                                <ul class='list-unstyled list-inline'>                                                              
                                                                  <li>                                                  
                                                                    <div class='picture'>
                                                                      <div class='tags'>
                                                                        <div class='label label-important'><a  class="delete_btn1"  onclick="javascript:deletemainimg('<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
                                                                      </div>                              
                                                                      <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $product[0]['product_image']; ?>'>
                                                                        <img alt="product Image" src="<?php echo base_url() . product . "medium/" . $product[0]['product_image']; ?>" />
                                                                      </a>
                                                                    </div>                          
                                                                  </li>                                                                           
                                                                </ul>                       
                                                            </div>                                                              
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
												
                                                </div>                                              
                                                <!-- <div class="progressBar">
                                                    <div class="status"></div>
                                                </div>
                                                <input type="button" name="upload_btn" id="upload_btn" value="Upload" />-->
                                            </div>                                          
                                            <div class='form-group'>  
												<div class="col-md-2 col-sm-3">Upload Sub-Images</div>
												<div class="col-md-10"><a href="javascript:void(0);" id="attachMore4" class="btn btn-primary">Upload another file</a></div>
												<div class="clearfix"></div>
												<div id="moreImageUpload4" class='col-md-12'></div>												
											</div>
											<div class="form-group" >                                                
                                                 <div class='col-md-12'>
                                                  <div class='gallery'>                                                 
                                                    <ul class='list-unstyled list-inline'>
                                                    <?php  foreach($images as $i):  ?>  
                                                      <li>                                                  
                                                        <div class='picture'>
                                                          <div class='tags'>														  
                                                            <div class='label label-important'><a  class="delete_btn2" style="cursor:pointer;" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>','<?php echo $product[0]['product_id']; ?>');"><i class="fa fa-trash"></i></a></div>
                                                          </div>                              
                                                            <a data-lightbox='flatty' href="<?php echo base_url() . product . "original/" . $i['product_image']; ?>">
                                                            <img alt="product Image" src="<?php echo base_url() . product . "medium/" . $i['product_image']; ?>" width="150px" height="150px">
                                                          </a>
                                                        </div>                          
                                                      </li>      
                                                        <?php   endforeach; ?>                        
                                                    </ul>                       
                                                  </div>
                                                </div>
                                            </div>
                                            
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Describe what makes your ad unique<span> *</span></div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <textarea class="form-control" placeholder="Description" name="shared_pro_desc" rows="3" data-rule-required='true'><?php echo $product[0]['product_description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <div class="col-md-2 col-sm-3">Price<span> *</span></div>                                                
                                                    <div class="input-group col-md-6 col-sm-8 controls">
                                                        <span class="input-group-addon">Dirham</span>
                                                        <input type="text" value="<?php echo $product[0]['product_price']; ?>" id="shared_price" name="shared_price" class="form-control"  data-rule-required='true'>
                                                        <span class="input-group-addon">.00</span>
                                                      </div>
                                                      <div class="checkbox col-md-2">
                                                        <label>
                                                          <input type="checkbox" <?php echo ($product[0]['free_status'] == 1) ? 'checked' : ''; ?> name="shared_free" value="1">
                                                          Free
                                                        </label>
                                                      </div>
                                            </div>
                                            <div class="form-group" >
                                                <div class="col-md-2 col-sm-3">My Ad is in</div>
                                                <div class='col-md-6 col-sm-8 controls'>
                                                    <select id="shared_language" name="shared_language" class="select2 form-control">
                                                        <option <?php echo ($product[0]['ad_language'] == 0 || $product[0]['ad_language'] == '') ? 'selected':'' ;?> value="0">Select</option>
                                                        <option <?php echo ($product[0]['ad_language'] == 'english') ? 'selected' : ''; ?> value="english">English</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submitHandler3" name="real_estate_shared_submit">
                                                            <i class='icon-save'></i>
                                                            Repost
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>user/my_listing' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
       
        <!--//footer-->
    </div>
   <script type="text/javascript">

var base_url = "<?php echo base_url(); ?>admin/";

</script>
    <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/javascripts/multiupload.js"></script>-->
<script type="text/javascript">

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
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }           
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
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }        
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
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }
               
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
                   
        }
        if(cnt>0)
        {
            alert("Please select image files to upload.");
            return false;
        }
             
    })
})



function mydelete(val,prod_id)
{
    var url = "<?php echo base_url() ?>users/removeimage";
    var r = confirm("Are you sure you want to delete image?");
    if (r == true) 
    {
        $.post(url, {value: val,prod_id:prod_id}, function(data)
        {           
            //alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>users/listings_edit/"+prod_id;  
        });
    }     
    return false;
}
function deletemainimg(prod_id)
{
    var url = "<?php echo base_url() ?>users/removemainimage";
    var r = confirm("Are you sure you want to delete main image?");
    if (r == true) 
    {
        $.post(url, {prod_id:prod_id}, function(data)
        {
        
            //alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>users/listings_edit/"+prod_id;  
        });
    }     
    return false;
}

var config = {
    support : "image/jpg,image/png,image/bmp,image/jpeg,image/gif",     // Valid file formats
    form: "demoFiler",   // Form ID
    dragArea: "dragAndDropFiles",  // Upload Area ID
    upload_btn: "upload_btn", //upload button
    uploadUrl: "<?php echo base_url(); ?>uploads/index"             // Server side upload url
}

$("#vehicle_pro_year").datepicker({
    format: "yyyy",
    startView: 1,
    minViewMode: 2
});
var val     = $('#cat_id').val();
var subval  = $('#sub_cat1').val();
//show_sub_cat(val);
show_sub_cat_fields(subval);

$("#cat_id").each(function() {
        var $thisOption = $(this);
        $thisOption.attr("disabled", "disabled");
});
$("#sub_cat1").each(function() {
        var $thisOption = $(this);        
        $thisOption.attr("disabled", "disabled");
});



function show_sub_cat_fields(subval) {
    $("input[name='sub_cat1']").val(subval);
    var cat_text = $("#cat_id").find("option:selected").text();
    
    if(cat_text=='Real Estate'){        
        if(subval!=0){
            var sub_cat = $("#sub_cat1 option[value='"+subval+"']").text();
            if(sub_cat=='Houses - Apartments for Rent' || sub_cat=='Houses - Apartments for Sale'){
            
                $(".default_form").hide();
                $(".vehicle_form").hide();
                $(".real_estate").hide();
                $(".real_estate_houses_form").show();
                //$("#real_estate_location").select2();
                $("#form_type").val("real_estate_houses_form");
                
            }else if(sub_cat=='Rooms for Rent - Shared' || sub_cat=='Housing Swap' || sub_cat=='Land' || sub_cat=='Shops for Rent - Sale' || sub_cat=='Office - Commercial Space'){
                $(".default_form").hide();
                $(".vehicle_form").hide();
                $(".real_estate").hide();
                $(".real_estate_shared_form").show();
                //$("#shared_location").select2();
                $("#form_type").val("real_estate_shared_form");
            }
                
        }else{
            $(".default_form").hide();
            $(".vehicle_form").hide();
            $(".real_estate").hide();
        }
    }else if(cat_text=='Vehicles'){
        if(subval!=0){
            var sub_cat = $("#sub_cat1 option[value='"+subval+"']").text();
            if(sub_cat=='Cars'){
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
    var url = "<?php echo base_url() ?>user/show_sub_cat";
    $.post(url, {value: val}, function(data)
    {
                    //alert(data);
        $("#sub_cat_list").html(data);
        $("#sub_cat1").select2();


    });
}
</script>
        
<script>
//$("#location").select2();

var val = $('#location').val();
show_emirates(val);
function show_emirates(val) {
    var url = "<?php echo base_url() ?>user/show_emirates";
    $.post(url, {value: val}, function(data)
    {
//                            alert(data);
        $("#sub_state_list option").remove();
        $("#sub_state_list").append(data);
        //$("#sub_state_list").select2();

    });
}

/*var val1 = $('#mybrand').val();
show_model(val1);*/
function show_model(val1) 
{
	
	var url = "<?php echo base_url() ?>user/show_model";
	$.post(url, {value: val1}, function(data)
	{
		
        //alert(data);
		$("#pro_model option").remove();
		$("#pro_model").append(data);
	});
}


//<a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm(\"Are you really want to delete ?\")">Delete</a>
function loadimage(input,a) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function (e) {
			$('#blah1'+a)
				.attr('src', e.target.result)
				.width(100)
				.height(100);
		};
		reader.readAsDataURL(input.files[0]);
	}
}

function loadimage1(input) 
{
	if (input.files && input.files[0]) {
		var reader = new FileReader();
	
		reader.onload = function (e) {			
			$('#blah')
				.attr('src', e.target.result)
				.width(100)
				.height(100);				
			$('#blah1')
				.attr('src', e.target.result)
				.width(100)
				.height(100);
			$('#blah2')
				.attr('src', e.target.result)
				.width(100)
				.height(100);
			$('#blah3')
				.attr('src', e.target.result)
				.width(100)
				.height(100);
		};
		reader.readAsDataURL(input.files[0]);
	}
}
function del_file(eleId,a) 
{
        var ele = document.getElementById("delete_file" + eleId);
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
 

var upload_number1 = $('#mycounter1').val();
$('#attachMore1').click(function() 
{
	if(upload_number1<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><input type="file" id="upload_file' + upload_number1 + '" name="multiUpload' + upload_number1 + '"  onchange="javascript:loadimage(this,'+upload_number1+')">';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number1 + ',1)" style="cursor:pointer;" onclick="return confirm(Are you really want to delete ?)"><i class="fa fa-trash"></i></a><img id="blah1'+upload_number1+'" src="#" alt="Image" /></div>';	
		
		$('<dl class="col-md-2 file_upload_btn" id="delete_file' + upload_number1 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload1');
		
		upload_number1++;
	}
});

var upload_number2 = $('#mycounter2').val();
$('#attachMore2').click(function() 
{
	if(upload_number2<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><input type="file" id="upload_file' + upload_number2 + '" name="multiUpload' + upload_number2 + '" onchange="javascript:loadimage(this,'+upload_number2+')">';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number2 + ',2)" style="cursor:pointer;" onclick="return confirm(Are you really want to delete ?)"><i class="fa fa-trash"></i></a><img id="blah1'+upload_number2+'" src="#" alt="Image" /></div>';
		$('<dl  class="col-md-2 file_upload_btn" id="delete_file' + upload_number2 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload2');
		upload_number2++;
	}
});
var upload_number3 = $('#mycounter3').val();
$('#attachMore3').click(function() 
{
	if(upload_number3<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><input type="file" id="upload_file' + upload_number3 + '" name="multiUpload' + upload_number3 + '" onchange="javascript:loadimage(this,'+upload_number3+')">';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number3 + ',3)" style="cursor:pointer;"onclick="return confirm(Are you really want to delete ?)"><i class="fa fa-trash"></i></a><img id="blah1'+upload_number3+'" src="#" alt="Image" /></div>';
		$('<dl  class="col-md-2 file_upload_btn" id="delete_file' + upload_number3 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload3');
		upload_number3++;
	}
});
var upload_number4 = $('#mycounter4').val();
$('#attachMore4').click(function() 
{
	if(upload_number4<=9)
	{
		//add more file
		var moreUploadTag = '';            
		moreUploadTag += '<div class="text-center"><input type="file" id="upload_file' + upload_number4 + '" name="multiUpload' + upload_number4 + '" onchange="javascript:loadimage(this,'+upload_number4+')">';
		moreUploadTag += '<a class="delete_btn" href="javascript:del_file(' + upload_number4 + ',4)" style="cursor:pointer;" onclick="return confirm(Are you really want to delete ?)"><i class="fa fa-trash"></i></a><img id="blah1'+upload_number4+'" src="#" alt="Image" /></div>';
		$('<dl class="col-md-2 file_upload_btn" id="delete_file' + upload_number4 + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload4');
		
		upload_number4++;
	}
});


function readURL(input) 
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
	
</script>
    </body>
</html>
