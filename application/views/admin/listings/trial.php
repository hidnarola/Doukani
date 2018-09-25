<!DOCTYPE html>
<html>
    <head>
<?php $this->load->view('admin/include/head'); ?>
<?php $this->load->view('admin/include/footer-script'); ?>	

<!-- Bootstrap styles -->
<link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/dist/css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="<?php echo site_url(); ?>/assets/front/stylesheets/file_upload_css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/blueimp/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-ui.css">
<noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-ui-noscript.css"></noscript>
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo site_url(); ?>/assets/admin/javascripts/blueimp/load-image.all.min.js"></script>

<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!-- <script src="<?php echo base_url(); ?>js/blueimp/jquery.blueimp-gallery.min.js"></script> -->
<script src="<?php echo site_url(); ?>assets/landing/bootstrap.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-image.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-validate.js"></script>
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / theme file [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>	
    </head>
    <body class='contrast-fb'>
        <?php //$this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php //$this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-building'></i>
                                    <span>Listings</span>
                                </h1>               
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Add Listing
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <div class="col-md-12">
                                        <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Category</label>
                                                <div class='col-md-5' style="padding: 0px 12px 14px 6px;">
                                                    <select class="select2 form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);">
													<option value="">Select Catagory</option>
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Sub Category</label>
                                                <div class='col-md-5' id="sub_cat_list" style="padding: 0px 12px 14px 6px;">
                                                    <select class="select2 form-control" id="sub_cat" name="sub_cat" data-rule-required='true'>
                                                        <?php foreach ($sub_category as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>"><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                    <!--===================== DEFAULT FORM ======================-->


				<form  name="default_form" action='<?php echo base_url() . 'admin/classifieds/listings_add/' ?>' class='form form-horizontal validate-form default_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form1">
					<input type="hidden" name="cat_id" id="cat_id_form1">
					<input type="hidden" name="sub_cat" id="sub_cat_form1">
					<div class='form-group'>
					<label class='col-md-2 control-label' for='inputText1'>Name<span> *</span></label>
					<div class='col-md-5 controls'>
						<input placeholder='Product Name' class="form-control" name="pro_name" type='text' data-rule-required='true'/>
					</div>
				</div>
				<div class='form-group'>                        
					<label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
					<div class='col-md-5 controls'>
						<textarea class="form-control" id="inputTextArea1" placeholder="Description" name="pro_desc" rows="3" data-rule-required='true'></textarea>
					</div>
				</div>
				
				<div class="form-group" >
					<label class='col-md-2 control-label' for='inputText1'>Emirate</label>
					<div class='col-md-5 controls'>
						<select id="sub_state_list" name="state" class="select2 form-control" data-rule-required='true'>
							 <option value="">Select</option>
							<?php foreach ($state as $o) { ?>
							<option value="<?php echo $o['state_id']; ?>" ><?php echo $o['state_name']; ?></option> 
							<?php } ?>
						</select>                     
					</div>
				</div>
				<div class='form-group'>                        
					<label class='col-md-2 control-label' for='inputText1'>Price<span> *</span></label>
					<div class='col-md-5 controls'>
						<input class="form-control"  placeholder="Price" name="pro_price" type="text"  data-rule-required='true' />
					</div>
				</div>
				<div class="form-actions form-actions-padding-sm">
					<div class="row">
						<div class="col-md-10 col-md-offset-2">
							<button class='btn btn-primary' type='submit' id="form1_submit" name="default_submit">
								<i class="fa fa-floppy-o"></i>
								Save
							</button>
							<a href='<?php echo base_url(); ?>admin/classifieds/listings' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form1_images_arr" id="form1_images_arr"   class="form-control" />
						</div>
					</div>
				</div>
				</form>

                    <!--=========================== VEHICLE FORM =============================-->

            <form name="vehicle_form" style="display: none;" action='<?php echo base_url() . 'admin/classifieds/listings_add/' ?>' class='form form-horizontal validate-form vehicle_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form2">
						<input type="hidden" name="cat_id" id="cat_id_form2">
						<input type="hidden" name="sub_cat" id="sub_cat_form2">					
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
							<div class='col-md-5 controls'>
								<select id="sub_state_list1" name="state" class="select2 form-control" data-rule-required="true">
									<option value="">Select</option>
									<?php foreach ($state as $o) { ?>
									<option value="<?php echo $o['state_id']; ?>" ><?php echo $o['state_name']; ?></option> 
									<?php } ?>
								</select>                
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
							<div class='col-md-5 controls'>
								<input class="form-control" placeholder="Title" name="title" type="text" data-rule-required='true'/>
							</div>
						</div>                                          
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Car Brand</label>								
							<div class='col-md-5'>							
								<select name="pro_brand"  class="form-control select2 " onchange="show_model(this.value);" id="pro_brand">    
									<option value="">Select Brand</option>  
									<?php foreach($brand as $col):?>
										<option value="<?php echo $col['brand_id']; ?>"><?php echo $col['name']; ?></option>
									<?php endforeach;   ?>
								</select>                                               
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Car Model</label>
							<div class='col-md-5'>
								<select id="pro_model" name="vehicle_pro_model" class="select2 form-control">
								<?php foreach($model as $col):?>
										<option value="<?php echo $col['model_id']; ?>"  <?php echo ($product[0]['model']==$col['model_id']) ? 'selected' : ''; ?>><?php echo $col['name']; ?></option>
									<?php endforeach;   ?>      									
								</select>                     
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Type Of Car</label>
							<div class='col-md-5'>
								<input class="form-control"  placeholder="Type Of Car" name="vehicle_pro_type_of_car" type="text" />
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Year</label>
							<div class='col-md-5'>
								<input class="form-control datepicker-years"  placeholder="Select Year" id="vehicle_pro_year" name="vehicle_pro_year" type="text" />
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Mileage</label>
							<div class='col-md-5'>							
								<select name="vehicle_pro_mileage" id="vehicle_pro_mileage"  class="select2  form-control">
								<option value="">Select Mileage</option>
								<?php foreach($mileage as $col):?>
									<option value="<?php echo $col['mileage_id']; ?>" ><?php echo $col['name']; ?></option>     
								<?php endforeach;   ?>
								</select>
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Condition</label>
							<div class='col-md-5'>
								<input class="form-control"  placeholder="Condition" name="vehicle_pro_condition" id="vehicle_pro_condition" type="text" />
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Choose color</label>
							<div class='col-md-2'>
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
							<label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
							<div class='col-md-5 controls'>
								<textarea class="form-control" id="vehicle_pro_desc" placeholder="Description" name="vehicle_pro_desc" rows="3" data-rule-required='true'></textarea>
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Price<span> *</span></label>
							<div class='col-md-5 controls'>
								<input class="form-control"  placeholder="Price" name="vehicle_pro_price" id="vehicle_pro_price" type="text"  data-rule-required='true' />
							</div>
						</div>
						<div class="form-actions form-actions-padding-sm">
							<div class="row">
								<div class="col-md-10 col-md-offset-2">
									<button class='btn btn-primary' type='submit' id="form2_submit" name="vehicle_submit">
										<i class="fa fa-floppy-o"></i>
										Save
									</button>
									<a href='<?php echo base_url(); ?>admin/classifieds/listings' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form2_images_arr" id="form2_images_arr"  class="form-control" />
								</div>
							</div>
						</div>
            </form>

            <!--================= REAL ESTATE HOUSES FORM ===================-->
            <form name="real_estate_houses_form" style="display: none;" action='<?php echo base_url() . 'admin/classifieds/listings_add/' ?>' class='form form-horizontal validate-form real_estate_houses_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form3">
						<input type="hidden" name="cat_id" id="cat_id_form3">
						<input type="hidden" name="sub_cat" id="sub_cat_form3">			            
						<div class='form-group'>                        
							<div class='col-md-offset-2 col-md-5 controls'>
								<input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="houses_pro_neighbourhood" />
							</div>
						</div>                                          
						 <div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
							<div class='col-md-5 controls'>
								<input class="form-control" placeholder="Ad Title" name="houses_ad_title" id="pro_ad_title" type="text" data-rule-required='true'/>
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Ad Address</label>
							<div class='col-md-5'>
								<input class="form-control"  placeholder="Address" name="houses_ad_address" type="text"/>
							</div>
						</div>
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>Emirate</label>
							<div class='col-md-5 controls'>
								<select id="sub_state_list2" name="state" class="select2 form-control" data-rule-required='true'>
								<option value="">Select</option>
								<?php foreach ($state as $o) { ?>
									<option value="<?php echo $o['state_id']; ?>" ><?php echo $o['state_name']; ?></option> 
								<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>Furnished</label>
							<div class='col-md-5'>
								<select id="furnished" name="furnished" class="select2 form-control">
									<option value="0">Select</option>
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>                     
							</div>
						</div>
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>Bedrooms</label>
							<div class='col-md-5'>
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
							<label class='col-md-2 control-label' for='inputText1'>Bathrooms</label>
							<div class='col-md-5'>
								<select id="bathrooms" name="bathrooms" class="select2 form-control">
									<option value="0">Select</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
								</select>                     
							</div>
						</div>
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>Pets</label>
							<div class='col-md-5'>
								<select id="pets" name="pets" class="select2 form-control">
									<option value="0">Select</option>
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>                     
							</div>
						</div>
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>Broker Fee</label>
							<div class='col-md-5'>
								<select id="broker_fee" name="broker_fee" class="select2 form-control">
									<option value="0">Select</option>
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>                     
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Square Meters</label>
							<div class='col-md-5'>
								<input class="form-control" placeholder="square_meters" id="pro_square_meters" name="pro_square_meters" type="number" />
							</div>
						</div>                                           							
						<div class='form-group'>
							<label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique</label>
							<div class='col-md-5 controls'>
								<textarea class="form-control" placeholder="Description" name="house_pro_desc" rows="3" data-rule-required='true'></textarea>
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1' >Price<span> *</span></label>
							
								<div class="input-group col-md-5 controls">
									<span class="input-group-addon">Dirham</span>
									<input type="text" id="houses_price" name="houses_price" class="form-control"  data-rule-required='true'>
									<span class="input-group-addon">.00</span>
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
							<label class='col-md-2 control-label' for='inputText1'>My Ad is in</label>
							<div class='col-md-5'>
								<select id="houses_language" name="houses_language" class="select2 form-control">
									<option value="0">Select</option>
									<option value="english">English</option>
								</select>                     
							</div>
						</div>
						<div class="form-actions form-actions-padding-sm">
							<div class="row">
								<div class="col-md-10 col-md-offset-2">
									<button class='btn btn-primary' type='submit' id="form3_submit" name="real_estate_houses_submit">
										<i class="fa fa-floppy-o"></i>
										Save
									</button>
									<a href='<?php echo base_url(); ?>admin/classifieds/listings' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form3_images_arr" id="form3_images_arr"   class="form-control" /> 
								</div>
							</div>
						</div>
            </form>
            <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
            <form name="real_estate_shared_form" style="display: none;" action='<?php echo base_url() . 'admin/classifieds/listings_add/' ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form4">
                    <input type="hidden" name="cat_id" id="cat_id_form4">
					<input type="hidden" name="sub_cat" id="sub_cat_form4">		                                          
						<div class='form-group'>                        
							<div class='col-md-offset-2 col-md-5 controls'>
								<input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" />
							</div>
						</div>                                          
						<div class='form-group controls'>                        
							<label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
							<div class='col-md-5'>
								<input class="form-control" placeholder="Ad Title" name="shared_ad_title" type="text" data-rule-required='true'/>
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Ad Address</label>
							<div class='col-md-5'>
								<input class="form-control"  placeholder="Address" name="shared_ad_address" type="text" />
							</div>
						</div>
						
						 <div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Upload Main Image</label>
							<div class='col-md-5'>							
								 <input type="file" name="multiUpload1" id="multiUpload" onchange="javascript:loadimage4(this);"/><br>
								 <img id="blah3" src="#" alt="" style="display: inline-block;" />
							</div>                
						</div>                                          
						<div class='form-group'>  
							<label class='col-md-2 control-label' for='inputText1'>Upload Sub-Images</label>	
							<div class="col-md-10"><a href="javascript:void(0);" id="attachMore4" class="btn btn-primary">Upload another file</a></div>
							<div class="clearfix"></div>
							<div id="moreImageUpload4" class='col-md-12'></div>
						</div>	
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>Emirate</label>
							<div class='col-md-5 controls'>
								<select id="sub_state_list3" name="state" class="select2 form-control" data-rule-required='true'>
									<option value="">Select</option>
									<option value="<?php echo $o['state_id']; ?>" ><?php echo $o['state_name']; ?></option> 
								</select>                
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique</label>
							<div class='col-md-5 controls'>
								<textarea class="form-control" placeholder="Description" name="shared_pro_desc" rows="3" data-rule-required='true'></textarea>
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Price</label>                                                
								<div class="input-group col-md-5 controls">
									<span class="input-group-addon">Dirham</span>
									<input type="text" id="shared_price" name="shared_price" class="form-control" data-rule-required='true'>
									<span class="input-group-addon">.00</span>
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
							<label class='col-md-2 control-label' for='inputText1'>My Ad is in</label>
							<div class='col-md-5'>
								<select id="shared_language" name="shared_language" class="select2 form-control">
									<option value="0">Select</option>
									<option value="english">English</option>
								</select>                     
							</div>
						</div>
						<div class="form-actions form-actions-padding-sm">
							<div class="row">
								<div class="col-md-10 col-md-offset-2">
									<button class='btn btn-primary' type='submit' id="form4_submit" name="real_estate_shared_submit">
										<i class="fa fa-floppy-o"></i>
										Save
									</button>                                                       
									<a href='<?php echo base_url(); ?>admin/classifieds/listings' title="Cancel" class="btn">Cancel</a><input type="hidden" name="form4_images_arr" id="form4_images_arr"   class="form-control" /> 
								</div>
							</div>
						</div>
					</form>
					
					<form id="fileupload" action="<?php echo base_url() . 'admin/uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
					<!-- Redirect browsers with JavaScript disabled to the origin page -->
					<!--<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>-->
					<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
					<div class="fileupload-buttonbar row">
						<div class="col-sm-offset-2 col-lg-8 ">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<div class="upload-div ">
								<span class="btn btn-success fileinput-button">
									<i class="glyphicon glyphicon-plus"></i>
									<span>Add files...</span>
									<input type="file" name="files[]" multiple >
								</span>
							</div>							
							<div class="upload-div" style="display:none;" id="update_div">
								<button type="button" class="btn btn-danger delete">
									<i class="glyphicon glyphicon-trash"></i>
									<span>Delete</span>
								</button>
							</div>
							<div class="toggel-div01" id="chk_del" style="display:none;">
								<input type="checkbox" class="toggle">
							</div>	
							<!-- The global file processing state -->
							<span class="fileupload-process"></span>
						</div>
						<!-- The global progress state -->
						<div class="col-lg-5 fileupload-progress fade">
							<!-- The global progress bar -->
							<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
								<div class="progress-bar progress-bar-success" style="width:0%;"></div>
							</div>
							<!-- The extended global progress state -->
							<div class="progress-extended">&nbsp;</div>
						</div>
					</div>
					<!-- The table listing the files available for upload/download -->
					<table role="presentation" class="table table-striped"><tbody class="files" id="table_image"></tbody></table>
				</form>
				<!-- The template to display files available for upload -->
			<script id="template-upload" type="text/x-tmpl">
				{% for (var i=0, file; file=o.files[i]; i++) {%}
				<tr class="template-upload fade">
				<td>
				<span class="preview"></span>
				</td>
				<td>
				<p class="name">{%=file.name%}</p>
				<strong class="error text-danger" style="color:red;"></strong>
				</td>
				<td>
				<p class="size">Processing...</p>
				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
				</td>
				<td>
				{% if (!i && !o.options.autoUpload) { %}
				<!--<button class="btn btn-primary start" disabled>
				<i class="glyphicon glyphicon-upload"></i>
				<span>Start</span>
				</button> -->
				{% } %}
				{% if (!i) { %}
				<button class="btn btn-warning cancel">
				<i class="glyphicon glyphicon-ban-circle"></i>
				<span>Cancel</span>
				</button>
				{% } %}
				</td>
				</tr>
				{% } %}
			</script>
			
			<script id="template-download" type="text/x-tmpl">

            {% for (var i=0, file; file=o.files[i]; i++) { 
				var url= '<?php echo base_url() . product . "medium/" ; ?>';
			%}
            <tr class="template-download fade" id="{%=btoa(file.name)%}">
            <td>
            <span class="preview">
            {% if (file.thumbnailUrl) { %} 
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
            {% } %}
            </span>  
            </td> 
            <td>
            <p class="name">
            {% if (file.url) { %}   
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            {% } else { %} 
            <span>{%=file.name%}</span>
            {% } %} 
            </p>
            {% if (file.error) { %}
            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
            </td>
            <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
            </td> 
            <td>
            {% if (file.deleteUrl) { %}
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="glyphicon glyphicon-trash"></i>
            <span>Delete</span>
            </button>
            <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
            <button class="btn btn-warning cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancel456</span>
            </button>
            {% } %}
			
            </td>
            </tr>
            {% } %}
        </script>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</section>
</div>
        
<script>
$("#vehicle_pro_year").datepicker({
    format: "yyyy",
    startView: 1,
    minViewMode: 2
});

	$("#form1_images_arr").val("");
	$("#form2_images_arr").val("");
	$("#form3_images_arr").val("");
	$("#form4_images_arr").val("");
	
$(function() {     
	'use strict'; 
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo base_url() . 'uploads/index/'; ?>',
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function() {
            var $this = $(this),
                    data = $this.data();
            $this
                    .off('click')
                    .text('Abort')
                    .on('click', function() {
                $this.remove();
                data.abort();
            });
            data.submit().always(function() {
                $this.remove();
            });
        });
		
		
        var img_arr = []; 
        $('#fileupload').fileupload({
            dropZone: $('#dropzone'),
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(jpe?g|jpg|png|gif)$/i,
            maxFileSize: 100000000, // 5 MB						
            maxNumberOfFiles: 10,			
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,
            success: function(response) {							
				console.log(response.files[0].name);						  
				var table_content	=	$(".table .table-striped").html();
				if(table_content!='') {
					$("#update_div").show();
					$("#chk_del").show();
				}
				
                img_arr.push(window.btoa(response.files[0].name));
				//console.log(img_arr);
				$("#form1_images_arr").val(img_arr);
				$("#form2_images_arr").val(img_arr);
				$("#form3_images_arr").val(img_arr);
				$("#form4_images_arr").val(img_arr);
                //$("input[name='images_arr']").val(img_arr);              
            },
            error: function() {
                console.log("Error");
            }
        }).on('fileuploadadd', function(e, data) {

            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });

        }).on('fileuploadprocessalways', function(e, data) {

            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

            if (file.preview) {
                node
				<!--.prepend('<br>')-->
                        .prepend(file.preview);
            }
            if (file.error) {

                node
                        .append('<br>')
                        //.append($('<span class="text-danger"/>').text(file.error));
                        .append($('<span class="text-danger"/>').text(''));
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {


            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
			//console.log(data);
			//return false;
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {						
            var index = img_arr.indexOf(data.context[0].id);
            if (index > -1) {
				var url = "<?php echo base_url() ?>user/remove_image_uploaded";
				$.post(url, {value: img_arr}, function(response)
				{ });				
				
                img_arr.splice(index, 1);
				$("#form1_images_arr").val(img_arr);
				$("#form2_images_arr").val(img_arr);
				$("#form3_images_arr").val(img_arr);
				$("#form4_images_arr").val(img_arr);  							
            }
				data.context.remove();				
				var table_content	=	$("#table_image").html();							
				if(table_content=='') {
					$("#update_div").hide();
					$("#chk_del").hide();
				}
				return false;
        })
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }); 

	function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
	
	
	if((charCode >= 48 && charCode <= 57) || charCode == 188 || charCode == 190 || charCode == 46 || charCode == 8 || charCode == 37  || charCode == 39 || charCode == 44)
		return true;
	else
		return false;
    /*if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true; */
}
	
$("#cat_id_err").hide();
$("#subcat_id_err").hide();

 $(function(){
    $('#form1_submit').click(function(){
		var cat_id		=	$("#cat_id_form1").val();
		var subcat_id	=	$("#sub_cat_form1").val();
		
        if(cat_id=='')	
			$("#cat_id_err").show();				
		else	
			$("#cat_id_err").hide();
	
		if(subcat_id=='')
			$("#subcat_id_err").show();					
		else
			$("#subcat_id_err").hide();		
    })
	
	$('#form2_submit').click(function(){
		var cat_id		=	$("#cat_id_form2").val();
		var subcat_id	=	$("#sub_cat_form2").val();
		
        if(cat_id=='')				
			$("#cat_id_err").show();			
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
			$("#subcat_id_err").show();			
		else
			$("#subcat_id_err").hide();
    })
	
	
	$('#form3_submit').click(function(){
		var cat_id		=	$("#cat_id_form3").val();
		var subcat_id	=	$("#sub_cat_form3").val();
		
        if(cat_id=='')				
			$("#cat_id_err").show();			
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
			$("#subcat_id_err").show();			
		else
			$("#subcat_id_err").hide();
    })
	$('#form4_submit').click(function(){
		var cat_id		=	$("#cat_id_form4").val();
		var subcat_id	=	$("#sub_cat_form4").val();
		
        if(cat_id=='')				
			$("#cat_id_err").show();			
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
			$("#subcat_id_err").show();			
		else
			$("#subcat_id_err").hide();
    })
	
})


	
	
	
	
var val = $('#cat_id').val();
show_sub_cat(val);

function show_sub_cat(val) {
 
    $("input[name='cat_id']").val(val);
    $(".real_estate").hide();
    $(".vehicle_form").hide();    
    $(".default_form").show();
    $("#form_type").val("default_form");
	
	$("#sub_cat_form1").val("");
	$("#sub_cat_form2").val("");
	$("#sub_cat_form3").val("");
	$("#sub_cat_form4").val("");
	
	if($("#cat_id")!='')
		$("#cat_id_err").hide();				
		
	if($("#show_sub_category")=='')
		$("#subcat_id_err").show();	
	
    var url = "<?php echo base_url() ?>admin/classifieds/show_sub_cat";
    $.post(url, {value: val}, function(data)
    {
        //alert(data);
        $("#sub_cat_list").html(data);
        $("#sub_cat").select2();
    });
}

function show_sub_cat_fields(subval) {
    $("input[name='sub_cat']").val(subval);
    var cat_text = $("#cat_id").find("option:selected").text();
    
    if(cat_text=='Real Estate'){
        if(subval!=0){
            var sub_cat = $("#sub_cat option[value='"+subval+"']").text();
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
            var sub_cat = $("#sub_cat option[value='"+subval+"']").text();
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
</script>


    </body>
</html>