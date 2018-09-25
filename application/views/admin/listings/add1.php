<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
		<?php $this->load->view('admin/include/footer-script'); ?>
		 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo ($page_title) ? $page_title : 'Doukani';?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link href="<?php echo base_url(); ?>assets/front/dist/css/bootstrap.css" rel="stylesheet">-->
    <!--<link href="<?php echo base_url(); ?>assets/front/style.css" rel="stylesheet"> -->
    <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <!--<link href="<?php echo base_url(); ?>assets/front/responsive.css" rel="stylesheet">-->
    
    <link href='<?php echo base_url(); ?>assets/front/dist/css/Open_Sans.css' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/front/images/favicon.ico" />
    
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url(); ?>assets/front/dist/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    
    <!-- Validate Plugin -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/plugins/validate/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/plugins/validate/additional-methods.js"></script>
    <!-- / theme file [required] -->
    
	
	<script src="<?php echo base_url(); ?>assets/front/javascripts/theme.js" type="text/javascript"></script>
    <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_colorpicker/bootstrap-colorpicker.css'/>

<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/additional-methods.js" type="text/javascript"></script>
<!-- Bootstrap styles -->
<!--<link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/dist/css/bootstrap.css"> -->
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

<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.iframe-transport.js"></script>
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="<?php echo site_url(); ?>/assets/admin/javascripts/blueimp/load-image.all.min.js"></script>

<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!-- <script src="<?php echo base_url(); ?>js/blueimp/jquery.blueimp-gallery.min.js"></script> -->
<!-- <script src="<?php echo site_url(); ?>assets/landing/bootstrap.min.js"></script> -->
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
<style>
	canvas {display:none;}
</style>
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
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
                                            Add Listing <?php if(isset($_GET['userid']) && $_GET['userid']!='')  {
															$res	=	$this->db->query('select email_id from user where user_id='.(int)$_GET['userid'])->row();
																if(isset($res))
															echo 'for <u>'. $res->email_id.'</u>';  
															else
																redirect('admin/classifieds/listings/');
															}
														?>
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <div class="col-md-12">
                                        <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Category<span> *</span></label>
                                                <div class='col-md-5' style="padding: 0px 12px 14px 6px;">
                                                    <select class="select2 form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);">
														<option value="">Select Catagory</option>
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>													
													<label id="cat_id_err" class="error">This field is required.</label>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Sub Category<span> *</span></label>
                                                <div class='col-md-5' id="sub_cat_list" style="padding: 0px 12px 14px 6px;">
                                                    <select class=" form-control" id="sub_cat" name="sub_cat" data-rule-required='true'>
                                                        <?php foreach ($sub_category as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>"><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                    <!--===================== DEFAULT FORM ======================-->					
						<?php  
						if(isset($_GET['userid']) && $_GET['userid']!='')
							$redirect_url	=	base_url() . 'admin/classifieds/listings_add/?userid='.$_GET['userid'];
						else
							$redirect_url	=	base_url() . 'admin/classifieds/listings_add/';
							
						?>
                                            <form  name="default_form" action='<?php echo $redirect_url; ?>' class='form form-horizontal validate-form default_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form1">
											<h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
											<hr />
                                                <input type="hidden" name="cat_id" id="cat_id_form1">
                                                <input type="hidden" name="sub_cat" id="sub_cat_form1">
                                                <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Product Name' class="form-control" name="pro_name" type='text' data-rule-required='true' maxlength="50"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <textarea class="form-control" id="inputTextArea1" placeholder="Description" name="pro_desc" rows="3" data-rule-required='true' maxlength="200"></textarea>
                                                </div>
                                            </div>  
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Price<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Price" name="pro_price" type="text"  data-rule-required='true' />
                                                </div>
                                            </div>											
											<h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
											<hr />
											<div class="form-group">                    
											<label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
											<div class="col-md-5 controls">
												<select class="select2 form-control" name="location" id="location_con_form1" onchange="show_emirates_form1(this.value);" data-rule-required='true'>
													<option value="">Select Country</option>
													<?php foreach ($location as $st): ?>
													  <?php if($st['country_id'] == 4) {?>
														<option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
														<?php } else { ?>
														<option value="<?php echo $st['country_id'] ?>" ><?php echo $st['country_name'] ?></option>
														<?php } ?>                                        
													 <?php endforeach; ?>                                	
												</select>
											</div>
										</div>					
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select  name="state" class="select2 form-control" data-rule-required='true' id="city_form1">
														 <option value="">Select Emirate</option>
                                                        <!-- <?php //foreach ($state as $o) { ?>
                                                        <option value="<?php //echo $o['state_id']; ?>" ><?php //echo $o['state_name']; ?></option>  -->
                                                        <?php //} ?>
                                                    </select>                     
                                                </div>
                                            </div>                                           
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  data-rule-required='true' onkeypress="return isNumber1(event)"/>
                                                </div>
                                            </div>	
											<!--  display:none;-->
											<div class="row form-group" style="margin-top:20px;display:none;" >
													<div class="col-md-2 col-sm-3">Youtube Link</div>
													<div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form1"/><input type="text" class="form-control" name="cov_img" id="cov_img_form1"/></div>
											</div>
											<div class="row form-group" style="margin-top:20px; display:none;" >
													<div class="col-md-2 col-sm-3">Upload Video</div>
													<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form1" name="video" /></div>
											</div>
											<div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
                                                 <div class='col-md-5 controls'>
                                                    <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control  select2"  data-rule-required='true'>
                                                        <option value="">Select</option>
                                                        <option value="NeedReview">NeedReview</option>
                                                        <option value="Approve">Approve</option>
                                                        <option value="Unapprove">Unapprove</option>
                                                        <option value="Inappropriate">Inappropriate</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm btn-btm-css">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="form1_submit" name="default_submit" >
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='#' title="Cancel" class="btn" onclick="goBack()">Cancel</a><input type="hidden" name="form1_images_arr" id="form1_images_arr"   class="form-control"  /> 
                                                    </div>
                                                </div>
                                            </div>
                                            </form>

                    <!--=========================== VEHICLE FORM =============================-->

            <form name="vehicle_form" style="display: none;" action='<?php echo $redirect_url; ?>' class='form form-horizontal validate-form vehicle_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form2">                          
											<h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
											<hr />
											<input type="hidden" name="cat_id" id="cat_id_form2">
                                            <input type="hidden" name="sub_cat" id="sub_cat_form2">
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control" placeholder="Title" name="title" type="text" data-rule-required='true' maxlength="50"/>
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <textarea class="form-control" id="vehicle_pro_desc" placeholder="Description" name="vehicle_pro_desc" rows="3" data-rule-required='true' maxlength="200"></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Price<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Price" name="vehicle_pro_price" id="vehicle_pro_price" type="text"  data-rule-required='true' />
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Car Brand</label>								
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
                                                <label class='col-md-2 control-label' for='inputText1'>Condition</label>
                                                <div class='col-md-5'>
                                                    <input class="form-control"  placeholder="Condition" name="vehicle_pro_condition" id="vehicle_pro_condition" type="text" maxlength="30"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Choose color</label>
                                                <div class='col-md-5'><!-- kesha -->
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
											<h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
											<hr />
											<div class="form-group">                    
												<label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
												<div class="col-md-5 controls">
													<select class="form-control" name="location" id="location_con_form2" onchange="show_emirates_form2(this.value);" data-rule-required='true'>			
														<option value="">Select Country</option>						
														<?php foreach ($location as $st): ?>
														  <?php if($st['country_id'] == 4) {?>
															<option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
															<?php } else { ?>
															<option value="<?php echo $st['country_id'] ?>" ><?php echo $st['country_name'] ?></option>
															<?php } ?>                                        
														 <?php endforeach; ?>                                	
													</select>
												</div>
											</div>		
                                            <div class="form-group">
                                                <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select  name="state" class="select2 form-control" data-rule-required="true" id="city_form2">
														<option value="">Select Emirate</option>
                                                        <?php //foreach ($state as $o) { ?>
                                                        <!-- <option value="<?php //echo $o['state_id']; ?>" ><?php //echo $o['state_name']; ?></option>  -->
                                                        <?php //} ?>
                                                    </select>                
                                                </div>
                                            </div>                                            
											                                                                                        
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  data-rule-required='true' onkeypress="return isNumber1(event)"/>
                                                </div>
                                            </div>	
											<div class="row form-group" style="margin-top:20px;display:none;">
													<div class="col-md-2 col-sm-3">Youtube Link</div>
													<div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form2"/>
													<input type="text" class="form-control" name="cov_img" id="cov_img_form2"/>
													</div>
											</div>
											<div class="row form-group" style="margin-top:20px;display:none;">
													<div class="col-md-2 col-sm-3">Upload Video</div>
													<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form2" name="video" /></div>
											</div>
											<div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
                                                 <div class='col-md-5 controls'>
                                                    <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control  select2"  data-rule-required='true'>
                                                        <option value="">Select</option>
                                                        <option value="NeedReview">NeedReview</option>
                                                        <option value="Approve">Approve</option>
                                                        <option value="Unapprove">Unapprove</option>
                                                        <option value="Inappropriate">Inappropriate</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm btn-btm-css">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="form2_submit" name="vehicle_submit" onclick="javascript:check_submit2();">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='#' title="Cancel" class="btn" onclick="goBack()" >Cancel</a><input type="hidden" name="form2_images_arr" id="form2_images_arr"  class="form-control" />
                                                    </div>
                                                </div>
                                            </div>
            </form>

            <!--================= REAL ESTATE HOUSES FORM ===================-->
            <form name="real_estate_houses_form" style="display: none;" action='<?php echo $redirect_url; ?>' class='form form-horizontal validate-form real_estate_houses_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form3">
											<h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
											<hr />
                                            <input type="hidden" name="cat_id" id="cat_id_form3">
                                            <input type="hidden" name="sub_cat" id="sub_cat_form3">                                                                                                      
                                             <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control" placeholder="Ad Title" name="houses_ad_title" id="pro_ad_title" type="text" data-rule-required='true'/>
                                                </div>
                                            </div>
											<div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <textarea class="form-control" placeholder="Description" name="house_pro_desc" rows="3" data-rule-required='true' maxlength="200"></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1' >Price</label>
                                                
                                                    <div class="input-group col-md-5 controls price_cont">
                                                        <span class="input-group-addon">Dirham</span>
                                                        <input type="text" id="houses_price" name="houses_price" class="form-control">
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
                                                    <input class="form-control" placeholder="square meters" id="pro_square_meters" name="pro_square_meters" type="number" />
                                                </div>
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
											<h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
											<hr />
											<div class="form-group">                    
												<label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
												<div class="col-md-5 controls">
													<select class="select2 form-control" name="location" id="location_con_form3" onchange="show_emirates_form3(this.value);" data-rule-required='true'>		
														<option value="">Select Country</option>	
														<?php foreach ($location as $st): ?>
														  <?php if($st['country_id'] == 4) {?>
															<option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
															<?php } else { ?>
															<option value="<?php echo $st['country_id'] ?>" ><?php echo $st['country_name'] ?></option>
															<?php } ?>                                        
														 <?php endforeach; ?>                                	
													</select>
												</div>
											</div>
											<div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select name="state" class="select2 form-control" data-rule-required='true' id="city_form3">
													<option value="">Select Emirate</option>
                                                    <?php //foreach ($state as $o) { ?>
                                                        <!--<option value="<?php //echo $o['state_id']; ?>" ><?php //echo $o['state_name']; ?></option> -->
                                                    <?php //} ?>
                                                    </select>
                                                </div>
                                            </div>
											  <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Address</label>
                                                <div class='col-md-5'>
                                                    <input class="form-control"  placeholder="Address" name="houses_ad_address" type="text" maxlength="100"/>
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <div class='col-md-offset-2 col-md-5 controls'>
                                                    <input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="houses_pro_neighbourhood" maxlength="50"/>
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  data-rule-required='true' onkeypress="return isNumber1(event)"/>
                                                </div>
                                            </div>	
											<div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
                                                 <div class='col-md-5 controls'>
                                                    <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control  select2"  data-rule-required='true'>
                                                        <option value="">Select</option>
                                                        <option value="NeedReview">NeedReview</option>
                                                        <option value="Approve">Approve</option>
                                                        <option value="Unapprove">Unapprove</option>
                                                        <option value="Inappropriate">Inappropriate</option>
                                                    </select>                     
                                                </div>
                                            </div>
											
											<div class="row form-group" style="margin-top:20px;display:none;">
												<div class="col-md-2 col-sm-3">Youtube Link</div>
												<div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form3"/>
												<input type="text" class="form-control" name="cov_img" id="cov_img_form3"/>
												</div>
											</div>
											<div class="row form-group" style="margin-top:20px;display:none;">
												<div class="col-md-2 col-sm-3">Upload Video</div>
												<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form3" name="video" /></div>
											</div>
                                            <div class="form-actions form-actions-padding-sm btn-btm-css">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="form3_submit" name="real_estate_houses_submit" onclick="javascript:check_submit3();">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='#' title="Cancel" class="btn" onclick="goBack()">Cancel</a><input type="hidden" name="form3_images_arr" id="form3_images_arr"   class="form-control" /> 
                                                    </div>
                                                </div>
                                            </div>
            </form>
            <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
            <form name="real_estate_shared_form" style="display: none;" action='<?php echo $redirect_url; ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form4">
                                            <input type="hidden" name="cat_id" id="cat_id_form4">
                                            <input type="hidden" name="sub_cat" id="sub_cat_form4">                                            
                                            <h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
											<hr />                                         
                                            <div class='form-group controls'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
                                                <div class='col-md-5'>
                                                    <input class="form-control" placeholder="Ad Title" name="shared_ad_title" type="text" data-rule-required='true' maxlength="50"/>
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <textarea class="form-control" placeholder="Description" name="shared_pro_desc" rows="3" data-rule-required='true' maxlength="200"></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Price</label>    
													<div class="input-group col-md-5 controls price_cont">
                                                        <span class="input-group-addon">Dirham</span>
                                                        <input type="text" id="shared_price" name="shared_price" class="form-control">
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
											<h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
											<hr />	
											<div class="form-group">                    
												<label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
												<div class="col-md-5 controls">
													<select class="select2 form-control" name="location" id="location_con_form4" onchange="show_emirates_form4(this.value);" data-rule-required='true' >	
														<option value="">Select Country</option>
														<?php foreach ($location as $st): ?>
														  <?php if($st['country_id'] == 4) {?>
															<option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
															<?php } else { ?>
															<option value="<?php echo $st['country_id'] ?>" ><?php echo $st['country_name'] ?></option>
															<?php } ?>                                        
														 <?php endforeach; ?>                                	
													</select>
												</div>
											</div>	
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select name="state" class="select2 form-control" data-rule-required='true' id="city_form4">
														<option value="">Select Emirate</option>
                                                        <!--<option value="<?php //echo $o['state_id']; ?>" ><?php //echo $o['state_name']; ?></option> -->
                                                    </select>                
                                                </div>
                                            </div>
                                             <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Address</label>
                                                <div class='col-md-5'>
                                                    <input class="form-control"  placeholder="Address" name="shared_ad_address" type="text" maxlength="100"/>
                                                </div>
                                            </div> 
											<div class='form-group'>                        
                                                <div class='col-md-offset-2 col-md-5 controls'>
                                                    <input type="text" class="form-control" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" maxlength="50"/>
                                                </div>
                                            </div>
											<div class="row form-group" style="margin-top:20px;display:none;">
													<div class="col-md-2 col-sm-3">Youtube Link</div>
													<div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form4"/>
													<input type="text" class="form-control" name="cov_img" id="cov_img_form4"/>
													</div>
											</div>
											<div class="row form-group" style="margin-top:20px;display:none;">
													<div class="col-md-2 col-sm-3">Upload Video</div>
													<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form4" name="video" /></div>
											</div>
                                            
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  data-rule-required='true' onkeypress="return isNumber1(event)"/>
                                                </div>
                                            </div>		
											<div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
                                                 <div class='col-md-5 controls'>
                                                    <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control  select2"  data-rule-required='true'>
                                                        <option value="">Select</option>
                                                        <option value="NeedReview">NeedReview</option>
                                                        <option value="Approve">Approve</option>
                                                        <option value="Unapprove">Unapprove</option>
                                                        <option value="Inappropriate">Inappropriate</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm btn-btm-css">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="form4_submit" name="real_estate_shared_submit" onclick="javascript:check_submit4();">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>                                                       
                                                        <a href='#' title="Cancel" class="btn" onclick="goBack()">Cancel</a><input type="hidden" name="form4_images_arr" id="form4_images_arr"   class="form-control" /> 
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
			
			<form id="fileupload" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data" class='form form-horizontal validate-form' >
					<h4><i class="fa fa-image"></i>Upload Media</h4>
                    <hr />		
					<span id="error_img" style="color:red"></span>		
					<div class="fileupload-buttonbar">
						<label class="col-md-2 col-sm-3 control-label text-right">Upload Images</label>
						<div class="col-md-8 col-sm-8">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<div class="upload-div ">
								<span class="btn btn-success fileinput-button">
									<i class="glyphicon glyphicon-plus"></i>
									<span>Add files...</span>
									<input type="file" name="files[]" multiple >
								</span> [Maximum 10 Images are allowed]
							</div>							
							<div class="upload-div" style="display:none;" id="update_div">
								<button type="button" class="btn btn-danger delete" title="Click Me after select images to delete">
									<i class="glyphicon glyphicon-trash"></i>
									<span>Delete</span>
								</button>
							</div>
							<div class="toggel-div01" id="chk_del" style="display:none;">
								<input type="checkbox" class="toggle" title="Check to select all images to delete">
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
					<div class="col-md-8">
					<table role="presentation" class="table table-striped"><tbody class="files" id="table_image"></tbody></table>					
					</div>
					<div class="clearfix"></div>
				</form>
				<form  class='form form-horizontal validate-form'>
				
					<div class='row form-group'>     
						<label class="col-md-2 col-sm-3 control-label">Video</label>                      
						<div class="col-md-6 col-sm-8 mar-t-7">
							<input type="radio" name="video_selection" id="youtube_form" onclick="javascript:show_hide(1);"/>&nbsp;&nbsp;Youtube Link &nbsp;&nbsp;&nbsp;&nbsp;
							
							<input type="radio"  name="video_selection" id="video_form" onclick="javascript:show_hide(2);"/>&nbsp;&nbsp;Upload Video
						</div>					
					</div>
					<div class="row form-group" style="margin-top:20px; display:none;" id="youtube_div">
						<label class="col-md-2 col-sm-3 control-label">Youtube Link</label>
						<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="my_youtube_link" name="my_youtube_link"/></div>
					</div>
				</form>
				<form id="fileupload1" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
						<span id="error_span" style="color:red"></span>						
						<div class="row form-group" style="margin-top:20px; display:none;" >
							<div class="col-md-2 col-sm-3">Upload Video</div>
							<div class="col-md-6 col-sm-8"><input type="file" class="form-control" id="video" name="video" /></div>							
						</div>
						<div  id="video_div" style="display:none;">
						<div class="fileupload-buttonbar row">
							<div class="col-sm-offset-2 col-lg-8 ">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<div class="upload-div ">
								<span class="btn btn-success fileinput-button">
									<i class="glyphicon glyphicon-plus"></i>
									<span>Upload Video</span>
									<input type="file" name="files">
								</span>
							</div>							
							<div class="upload-div" style="display:none;" id="update_div">
								<button type="button" class="btn btn-danger delete" title="Click Me after select images to delete">
									<i class="glyphicon glyphicon-trash"></i>
									<span>Delete</span>
								</button>
							</div>
							<div class="toggel-div01" id="chk_del" style="display:none;">
								<input type="checkbox" class="toggle" title="Check to select all images to delete">
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
					<div class="col-md-8">
					<table role="presentation" class="table table-striped"><tbody class="files" id="table_image1"></tbody></table>
					
					</div>
					</div>					
				</form>
				<form class="col-sm-offset-2 data-div" method="post">
					<input type="hidden" name="app_id" value="" />
					<div class="form-group">
						<div class="col-md-6 col-sm-8">
							<input type="hidden" name="images_arr" class="form-control" />
						</div>	
					</div>	
					<div class="form-group">
						<div class="col-md-6 col-sm-8">
							<input type="hidden" name="page" value="add" class="form-control" />
						</div>	
					 </div>		
				<!--<button class="btn btn-primary" type="submit" id="btnContinue" name="btnContinue" disabled="disabled">Continue</button> -->
				</form>
			
			
			<div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content rounded">
						<div class="modal-header text-center orange-background">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">
								<i class="fa fa-close"></i>
							</button>
							<h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
						</div>
						<div class="modal-body">							
								<center><span id="error_msg" >Image set as cover image successfully</span></center>             					
						</div>
					</div>						
				</div>
			</div>
			
		  
		  
		  
			<script id="template-upload" type="text/x-tmpl">
				{% for (var i=0, file; file=o.files[i]; i++) { %} 
				<tr class="template-upload fade"> 
				<td>
				<span class="preview">
				<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
				<button class="btn btn-warning cancel" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
				<i class="glyphicon glyphicon-ban-circle" title="Cancel"></i>
				</button>
				</td>
				<td style="display:none;">
				<p class="name">{%=file.name%}</p>
				<strong class="error text-danger" style="color:red;"></strong>
				<p class="size">Processing...</p>
				<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
				</span>
				</td>
				<td style="display:none;"></td>
				<td style="display:none;">
				{% if (!i && !o.options.autoUpload) { %}
				<!--<button class="btn btn-primary start" disabled>
				<i class="glyphicon glyphicon-upload"></i>
				<span>Start</span>
				</button> -->
				{% } %}
				{% if (!i) { %}
				<button class="btn btn-warning cancel">
				<i class="glyphicon glyphicon-ban-circle" title="Cancel"></i>
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
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" ></a>
			<div class="star fav" >
				<a href="#" ><i class="fa fa-star-o" id="{%=file.short_name%}" title="Set As Cover Image"></i></a>
			</div>			
            {% } else { %} 
			<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo site_url();  ?>assets/upload/dummyy-img.png"></a>
			{% } %}		
			{% if (file.deleteUrl) { %} 
            <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="glyphicon glyphicon-trash" title="Delete"></i>
            <span style="display:none">Delete</span>
            </button>
			{% if (file.thumbnailUrl) { %} 
            <input type="checkbox" name="delete" value="1" class="toggle" title="Select Me to delete">
			 {% }  %} 
            {% } else { %} 
            <button class="btn btn-warning delete">
            <i class="glyphicon glyphicon-ban-circle" title="Cancel"></i>
            <span style="display:none;">Cancel</span>
            </button>
			<!--<button class="btn btn-warning delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span style="display:none">Cancel</span>
            </button> -->
            {% } %}					
            </span>    
            </td> 
            <td style="display:none">
            <p class="name">   
            {% if (file.url) {  %}      
            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
            {% } else { %} 
            <span>{%=file.name%}</span>
            {% } %} 
            </p>
            {% if (file.error) { %}
            <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
            </td>
            <td style="display:none">
            <span class="size" >{%=o.formatFileSize(file.size)%}</span>
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
        <?php //$this->load->view('admin/include/footer-script'); ?>

    <!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/javascripts/multiupload.js"></script>-->
<script type="text/javascript">

	function goBack()
  	{
 	 	window.history.back()
 	}
   
   
$("#vehicle_pro_year").datepicker({
        format: "yyyy",
        startView: 1,
        minViewMode: 2
    });
	
	$("#fileupload").on("click", "div.star > a  i ", function(e){
			e.preventDefault();			
			var id = $(this).attr('id');						
			var frm	=	$("#cov_img_form1").val();
			if(id!=frm) {
				$("#"+frm).removeClass("fa-star");
				$("#"+frm).addClass("fa-star-o"); 
			}
			//alert("call");
			
			//alert(id);
			$("#"+id).removeClass("fa-star-o");
			$("#"+id).addClass("fa-star");
			
			$("#cov_img_form1").val(id);
			$("#cov_img_form2").val(id);
			$("#cov_img_form3").val(id);
			$("#cov_img_form4").val(id);
			$("#send-message-popup").modal('show');
			//jQuery("#send-message-popup").delay(2000).fadeOut("slow");
			return false;		
		});
		
	
	
var base_url = "<?php echo base_url(); ?>admin/";

	function selet_cover_img(a)
	{		
		$("#cov_img_form1").val("");
		$("#cov_img_form2").val("");
		$("#cov_img_form3").val("");
		$("#cov_img_form4").val("");
		
		$("#cov_img_form1").val(a);
		$("#cov_img_form2").val(a);
		$("#cov_img_form3").val(a);
		$("#cov_img_form4").val(a);
		return false;
	}
	function del_video()
	{
		var img_arr='';
			
		if($("#video_form1").val()!='')
			img_arr	=	$("#video_form1").val();
		else if($("#video_form2").val()!='')
			img_arr	=	$("#video_form2").val();
		else if($("#video_form3").val()!='')
			img_arr	=	$("#video_form3").val();
		else if($("#video_form4").val()!='')
			img_arr	=	$("#video_form4").val();
		if(img_arr!='') {
			var url = "<?php echo base_url() ?>user/remove_image_selected";
			$.post(url, {value: img_arr}, function(response) { 
				$("#video_form1").val("");
				$("#video_form2").val("");
				$("#video_form3").val("");
				$("#video_form4").val("");
			});		
		}
	}
	function show_hide(a)
	{		
		if(a==1) {
			//alert("1");						
			del_video();			
			$("#youtube_div").show();
			$("#video_div").hide();
			$("#error_span").hide();
			$("#table_image1").html("");
		}
		else {
			del_video();
			//alert("2");
			$("#table_image1").html("");			
			$("#youtube_div").hide();
			$("#video_div").show();
			$("#my_youtube_link").val("");
		}	
	}
	
	
	$("#form1_images_arr").val("");
	$("#form2_images_arr").val("");
	$("#form3_images_arr").val("");
	$("#form4_images_arr").val("");
	
	$("#video_form1").val("");
	$("#video_form2").val("");
	$("#video_form3").val("");
	$("#video_form4").val("");
	
	
	/*jslint unparam: true, regexp: true */
	 total_image = 0, current_image = 0;
    /*global window, $ */
    $(function() {     
	'use strict'; 
        // Change this to the location of your server-side upload handler:
        var url = window.location.hostname === '<?php echo base_url() . 'admin/uploads/index/'; ?>',
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
			messages: {
                maxNumberOfFiles: 'Sorry, You can upload 10 Images,Please remove unneccessary files',                
            },
            previewCrop: true,
            success: function(response) {						
				$("#error_img").html("");				
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
			$("#error_img").html("");				
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                //node.appendTo(data.context);
            }); 			

        }).on('fileuploadprocessalways', function(e, data) {
			$("#error_img").html("");				
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
				$("#error_img").html(file.error);		
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
			$("#error_img").html("");				
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function(e, data) {
			$("#error_img").html("");				
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
					$("#error_img").html(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
			$("#error_img").html("");				
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
				$("#error_img").html('File upload failed.');					
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {						
			$("#error_img").html("");
				
            var index = img_arr.indexOf(data.context[0].id);
            if (index > -1) {
				var url = "<?php echo base_url() ?>admin/classifieds/remove_image_uploaded";
				$.post(url, {value: img_arr}, function(response)
				{ });				
				
                img_arr.splice(index, 1);
				//alert(window.atob(img_arr));
				
				
				$("#form1_images_arr").val(img_arr);
				$("#form2_images_arr").val(img_arr);
				$("#form3_images_arr").val(img_arr);
				$("#form4_images_arr").val(img_arr);  							
				
				//var str = img_arr;
				var str = $("#form1_images_arr").val();
				var arr = str.split(',');
				//console.log("tetbox value: "+$("#cov_img_form1").val());
				//console.log("array: "+arr);
				var myval	=	$("#cov_img_form1").val();
				var mydata	=	window.btoa(myval);
				//console.log("mydata:"+mydata);
				//window.btoa(str)
				var chk_	=	jQuery.inArray(mydata,arr);
				if(chk_==-1)
				{
					$("#cov_img_form1").val('');
					$("#cov_img_form2").val('');
					$("#cov_img_form3").val('');
					$("#cov_img_form4").val('');
				}	
				//alert(jQuery.inArray(mydata,arr));
				//forloop to check cover image				
				/*for (var i=0;i<arr.length;i++)
				{
					if(arr[i]!=window.atob($("#cov_img_form1").val()))
					{
						$("#cov_img_form1").val('');
					}
					alert("in loop"+arr[i] + "<br >");
				}
				*/
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
	
	
	//video upload
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
        $('#fileupload1').fileupload({
            dropZone: $('#dropzone'),
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(mp4|flv|avi)$/i,
            //maxFileSize: 100000000, // 5 MB						
            maxFileSize: 10000000, // 10 MB
            maxNumberOfFiles: 1,								
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
			messages: {
                maxNumberOfFiles: 'Sorry, You can upload only 1 video, Please remove unneccessary file',
			},
            previewCrop: true,
            success: function(response) {							
				console.log(response.files[0].name);
				$("#error_span").html("");				
				var table_content	=	$(".table .table-striped").html();
				if(table_content!='') {
					//$("#update_div").show();
					//$("#chk_del").show();
				}
				//alert("here");
				//$(".error text-danger").html()
                img_arr.push(window.btoa(response.files[0].name));
				//console.log(img_arr);
				$("#video_form1").val(img_arr);
				$("#video_form2").val(img_arr);
				$("#video_form3").val(img_arr);
				$("#video_form4").val(img_arr);
                //$("input[name='images_arr']").val(img_arr);              
            },
            error: function() {
				//alert("here");
                console.log("Error");
            }
        }).on('fileuploadadd', function(e, data) {	
			$("#error_span").html("");		
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function(index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                //node.appendTo(data.context);
            }); 			

        }).on('fileuploadprocessalways', function(e, data) {
			$("#error_span").html("");		
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
                        //.append($('#error_span').text(file.error));
                        .append($('<span class="text-danger"/>').text(''));						
				$("#error_span").html("");
				$("#error_span").html(file.error);	
				$("#video_div").show();						
            }
            if (index === data.files.length) {
                data.context.find('button')
                        .text('Upload')
                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function(e, data) {
			$("#error_span").html("");		
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    ); 
        }).on('fileuploaddone', function(e, data) {	
			$("#error_span").html("");		
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
					$("#error_span").html(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
        }).on('fileuploadfail', function(e, data) {
			$("#error_span").html("");		
            $.each(data.files, function(index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
				$("#error_span").html('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).on('fileuploaddestroy', function(e, data) {	
			$("#error_span").html("");				
            var index = img_arr.indexOf(data.context[0].id);
            if (index > -1) {
				var url = "<?php echo base_url() ?>admin/classifieds/remove_image_uploaded";
				$.post(url, {value: img_arr}, function(response)
				{ });				
				
                img_arr.splice(index, 1);
				$("#video_form1").val(img_arr);
				$("#video_form2").val(img_arr);
				$("#video_form3").val(img_arr);
				$("#video_form4").val(img_arr);  							
            }
				data.context.remove();				
				var table_content	=	$("#table_image1").html();							
				if(table_content=='') {
					//$("#update_div").hide();
					//$("#chk_del").hide();
				}
				return false;
        })		
                .prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }); 

	
	
	
	function isNumber1(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		
		if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=45) {
			return false;
		}
		return true;
	}
	

$("#cat_id_err").hide();
$("#subcat_id_err").hide();

$(function(){
    $('#form1_submit').click(function(){		
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form1").val(link);
		} 
				
		var cat_id		=	$("#cat_id_form1").val();
		var subcat_id	=	$("#sub_cat_form1").val();
		
        if(cat_id=='')	
		{	
			$("#cat_id_err").show();				
			$("#cat_id_err").focus();				
			return false;
		}
		else			
			$("#cat_id_err").hide();
		
	
		if(subcat_id=='')
		{		
			$("#subcat_id_err").show();					
			return false;
		}
			$("#subcat_id_err").hide();		
		
		
    })
	$('#form2_submit').click(function(){
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form2").val(link);
		}
		var cat_id		=	$("#cat_id_form2").val();
		var subcat_id	=	$("#sub_cat_form2").val();
		
        if(cat_id=='')				
		{
			$("#cat_id_err").show();
			return false;			
		}
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
		{
			$("#subcat_id_err").show();			
			return false;
		}
		else
			$("#subcat_id_err").hide();
    })
	$('#form3_submit').click(function(){
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form3").val(link);
		}
		var cat_id		=	$("#cat_id_form3").val();
		var subcat_id	=	$("#sub_cat_form3").val();
		
        if(cat_id=='')			
		{		
			$("#cat_id_err").show();			
			return false;
		}
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
		{
			$("#subcat_id_err").show();			
			return false;
		}
		else
			$("#subcat_id_err").hide();
    })
	$('#form4_submit').click(function(){
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form4").val(link);
		}
		var cat_id		=	$("#cat_id_form4").val();
		var subcat_id	=	$("#sub_cat_form4").val();
		
        if(cat_id=='')			
		{		
			$("#cat_id_err").show();			
			return false;
		}
		else
			$("#cat_id_err").hide();
			
		if(subcat_id=='')
		{
			$("#subcat_id_err").show();			
			return false;
		}
		else
			$("#subcat_id_err").hide();
    })	
})

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
var val = $('#cat_id').val();
show_sub_cat(val);
var subval  = $('#sub_cat').val();
//show_sub_cat(val);
show_sub_cat_fields(subval);
function show_sub_cat_fields(subval) {
	
    $("input[name='sub_cat']").val(subval);
	
	if(subval!='')
		$("#subcat_id_err").hide();	
		
    var cat_text = $("#cat_id").find("option:selected").text();
    if(subval!='')
		$("#subcat_id_err").hide();	
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
        //$("#sub_cat").select2();
    });
}
</script>
        
<script>

var url 	= 	"<?php echo base_url() ?>admin/classifieds/show_emirates_postadd";
	//for form 1
	//var val1	=	$("#location_con_form1").val();
	show_emirates_form1(4);
	function show_emirates_form1(val) {
		var sel_city	=	$("#city_form1").val();		
		if(val>0) {	
			$.post(url, {value: val,sel_city:sel_city}, function(data)
			{	
				$("#city_form1").html("");
				$("#city_form1 option").remove();
				$("#city_form1").append(data);
			});
		}
	}
	
	 //for form 2
	//var val2	=	$("#location_con_form2").val();
	show_emirates_form2(4);
	function show_emirates_form2(val) {
		var sel_city	=	$("#city_form2").val();		
		if(val>0) {	
			$.post(url, {value: val,sel_city:sel_city}, function(data)
			{			
				$("#city_form2").html("");
				$("#city_form2 option").remove();
				$("#city_form2").append(data);
			});
		}
	}
	
	//for form 3
	//var val3	=	$("#location_con_form3").val();
	show_emirates_form3(4);
	function show_emirates_form3(val) {
		var sel_city	=	$("#city_form3").val();		
		if(val>0) {	
			$.post(url, {value: val,sel_city:sel_city}, function(data)
			{			
				$("#city_form3").html("");
				$("#city_form3 option").remove();
				$("#city_form3").append(data);
			});
		}
	}
	
	//for form 4
	//var val4	=	$("#location_con_form4").val();
	show_emirates_form4(4);
	function show_emirates_form4(val) {
		var sel_city	=	$("#city_form4").val();		
		if(val>0) {		
			$.post(url, {value: val,sel_city:sel_city}, function(data)
			{			
				$("#city_form4").html("");
				$("#city_form4 option").remove();
				$("#city_form4").append(data);
			});
		}
	}

	function show_model(val1) 
	{
		var url = "<?php echo base_url() ?>admin/classifieds/show_model";
		$.post(url, {value: val1}, function(data)
		{                            
			$("#pro_model option").remove();
			$("#pro_model").append(data);

		});
	}
</script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / theme file [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>

    </body>
</html>