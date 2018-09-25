<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
		<?php $this->load->view('admin/include/footer-script'); ?>
		 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Edit Listing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- <link href="<?php echo base_url(); ?>assets/front/dist/css/bootstrap.css" rel="stylesheet"> -->
    <!--<link href="<?php echo base_url(); ?>assets/front/style.css" rel="stylesheet"> -->
    <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <!-- <link href="<?php echo base_url(); ?>assets/front/responsive.css" rel="stylesheet"> -->
    <!--<link href="dist/css/Open_Sans.css" rel="stylesheet">-->
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
                                            Edit Listing
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
                                                   <select class="form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);">
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $product[0]['category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                           <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Sub Category<span> *</span></label>
                                                <div class='col-md-5' id="sub_cat_list" style="padding: 0px 12px 14px 6px;">
                                                    <select class="form-control" id="sub_cat" name="sub_cat" >
														<option value="">Select Sub Category</option>
                                                        <?php foreach ($sub_category as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>" <?php echo ($cat['sub_category_id'] == $product[0]['sub_category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                                   
													<label id="subcat_id_err" class="error" style="display:none;"><font color="#b94a48">This field is required.</font></label>
                                                </div>
                                            </div>
                                        </div>

                    <!--===================== DEFAULT FORM ======================-->
                    <?php //if($product_type=='default'){						
                
                        ?>

				<form  name="default_form" action='<?php echo base_url() . 'admin/classifieds/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form default_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form1">
				<h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
				<hr />
					<input type="hidden" name="cat_id" value="<?php if(isset($product[0]['category_id'])) echo $product[0]['category_id']; ?>" id="cat_id_form1">
					<input type="hidden" name="sub_cat" value="<?php if(isset($product[0]['sub_category_id'])) echo $product[0]['sub_category_id']; ?>" id="sub_cat_form1">
					<div class='form-group'>
						<input type="hidden" id='mycounter1' value="<?php echo $mycounter; ?>">
						<label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
						<div class='col-md-5 controls'>
							<input placeholder='Product Name' class="form-control" value="<?php if(isset($product[0]['product_name'])) echo $product[0]['product_name']; ?>" name="pro_name" type='text' data-rule-required='true' maxlength="50"/>
						</div>
					</div>
				<div class='form-group'>                        
					<label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
					<div class='col-md-5 controls'>
						<textarea class="form-control" id="inputTextArea1" placeholder="Description" name="pro_desc" rows="3" data-rule-required='true' maxlength="200"><?php if(isset($product[0]['product_description'])) echo $product[0]['product_description']; ?></textarea>
					</div>
				</div>
				<div class='form-group'>                        
					<label class='col-md-2 control-label' for='inputText1'>Price<span> *</span></label>
					<div class='col-md-5 controls'>
						<input class="form-control"  placeholder="Price" value="<?php if(isset($product[0]['product_price'])) echo $product[0]['product_price']; ?>" name="pro_price" type="text"  data-rule-required='true' />
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
							  <?php if($st['country_id'] == $product[0]['country_id']) {?>
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
					 <div class='col-md-5 controls' >
						<select  name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required='true' id="city_form1">
							<option value="">Select</option>
							<?php foreach ($state as $o) { ?>
								<option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
							<?php } ?>
						</select>                     
					</div>
				</div>
				<div class='form-group'>                        
					<label class='col-md-2 control-label' for='inputText1'>Phone No.</label>
					<div class='col-md-5 controls'>
						<input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  data-rule-required='true' value='<?php if(isset($product[0]['phone_no'])) echo $product[0]['phone_no']; ?>' onkeypress="return isNumber1(event)"/>
					</div>
				</div>	
				 <div class="form-group" >
					<label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
					 <div class='col-md-5 controls'>
						<select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control  select2 " data-rule-required='true'>
							<option value="">Select</option>
							<option value="NeedReview" <?php if($product[0]['product_is_inappropriate']=='NeedReview'): echo 'selected=selected'; endif; ?>>NeedReview</option>
							<option value="Approve" <?php if($product[0]['product_is_inappropriate']=='Approve'): echo 'selected=selected'; endif; ?>>Approve</option>
							<option value="Unapprove" <?php if($product[0]['product_is_inappropriate']=='Unapprove'): echo 'selected=selected'; endif; ?>>Unapprove</option>
							<option value="Inappropriate" <?php if($product[0]['product_is_inappropriate']=='Inappropriate'): echo 'selected=selected'; endif; ?>>Inappropriate</option>
						</select>                     
					</div>
				</div><!-- display:none;-->
				<div class="row form-group" style="margin-top:20px;display:none;">
						<div class="col-md-2 col-sm-3">Youtube Link</div>
						<div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form1"/>
						<?php $ext = explode(".", $product[0]['product_image']); ?>
							<input type="text" class="form-control" name="cov_img" id="cov_img_form1" value="<?php echo $ext[0]; ?>"/>
						</div>
				</div>
				<div class="row form-group" style="margin-top:20px; display:none;">
						<div class="col-md-2 col-sm-3">Upload Video</div>
						<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form1" name="video" /></div>
				</div>
				<div class="form-actions form-actions-padding-sm btn-btm-css">
					<div class="row">
						<div class="col-md-10 col-md-offset-2">
							<button class='btn btn-primary' type='submit' id="form1_submit" name="default_submit">
								<i class="fa fa-floppy-o"></i>
								Save
							</button>
							<a href='#' title="Cancel" class="btn" onclick="goBack()">Cancel</a><input type="hidden" name="form1_images_arr" id="form1_images_arr"   class="form-control" /> 
						</div>
					</div>
				</div>
				</form>
				<?php //}else if($product_type=='vehicle'){ ?>
                    <!--=========================== VEHICLE FORM =============================-->

            <form name="vehicle_form" style="display: none;" action='<?php echo base_url() . 'admin/classifieds/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form vehicle_form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form2">				
											<h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
											<hr />
                                            <input type="hidden" name="cat_id" value="<?php if(isset($product[0]['category_id'])) echo $product[0]['category_id']; ?>" id="cat_id_form2">
                                            <input type="hidden" name="sub_cat" value="<?php if(isset($product[0]['sub_category_id'])) echo $product[0]['sub_category_id']; ?>" id="sub_cat_form2">                                            
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control" value="<?php if(isset($product[0]['product_name'])) echo $product[0]['product_name']; ?>" placeholder="Title" name="title" type="text" data-rule-required='true' maxlength="50"/>
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Description<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <textarea class="form-control" id="vehicle_pro_desc" placeholder="Description" name="vehicle_pro_desc" rows="3" data-rule-required='true' maxlength="200"><?php if(isset($product[0]['product_description'])) echo $product[0]['product_description']; ?></textarea>
                                                </div>
                                            </div> 
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Price<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Price" value="<?php if(isset($product[0]['product_price'])) echo $product[0]['product_price']; ?>" name="vehicle_pro_price" id="vehicle_pro_price" type="text"  data-rule-required='true' />
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Car Brand</label>
												<input type="hidden" id="mybrand" value="<?php if(isset($product[0]['product_brand'])) echo $product[0]['product_brand']; ?>">
                                                <div class='col-md-5'>
                                                    <!--<input class="form-control"  placeholder="Brand" name="pro_brand" type="text" value="<?php //echo $product[0]['product_brand']; ?>" /> -->                                                  
                                                    <select name="pro_brand"  class="form-control select2 " onchange="show_model(this.value);" id="pro_brand">    
                                                        <option value="">Select Brand</option>  
                                                        <?php foreach($brand as $col):?>
                                                            <option value="<?php echo $col['brand_id']; ?>"  <?php echo (isset($product[0]['product_brand']) && $product[0]['product_brand']==$col['brand_id']) ? 'selected' : ''; ?>><?php echo $col['name']; ?></option>
                                                        <?php endforeach;   ?>
                                                    </select>                                               
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Car Model</label>
                                                <div class='col-md-5'>
                                                    <select id="pro_model" name="vehicle_pro_model" class="select2 form-control">
														<?php foreach($model as $col):?>
                                                            <option value="<?php echo $col['model_id']; ?>"  <?php echo (isset($product[0]['model']) && $product[0]['model']==$col['model_id']) ? 'selected' : ''; ?> class="myhide"><?php echo $col['name']; ?></option>
                                                        <?php endforeach;   ?>      
													</select>                     
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Type Of Car</label>
                                                <div class='col-md-5'>
                                                    <input class="form-control" value="<?php if(isset($product[0]['type_of_car'])) echo $product[0]['type_of_car']; ?>" placeholder="Type Of Car" name="vehicle_pro_type_of_car" type="text" />
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Year</label>
                                                <div class='col-md-5'>
                                                    <input class="form-control datepicker-years" value="<?php if(isset($product[0]['year'])) echo $product[0]['year']; ?>" placeholder="Select Year" id="vehicle_pro_year" name="vehicle_pro_year" type="text" />
                                                </div>
                                            </div>
                                          <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Mileage</label>
                                                <div class='col-md-5'>                                              
                                                    <!--<input class="form-control" value="<?php //echo $product[0]['millage']; ?>"  placeholder="Mileage" name="vehicle_pro_mileage" id="vehicle_pro_mileage" type="text" />-->
                                                    <select name="vehicle_pro_mileage" id="vehicle_pro_mileage"  class="select2 form-control">
                                                    <option value="">Select Mileage</option>
                                                    <?php foreach($mileage as $col):?>
                                                        <option value="<?php echo $col['mileage_id']; ?>"
                                                        <?php if(isset($product[0]['millage']) && $col['mileage_id']==$product[0]['millage']) echo 'selected=selected'; else echo ''; ?> ><?php echo $col['name']; ?></option>            
                                                    <?php endforeach;   ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Condition</label>
                                                <div class='col-md-5'>
                                                    <input class="form-control" value="<?php if(isset($product[0]['vehicle_condition'])) echo $product[0]['vehicle_condition']; ?>"  placeholder="Condition" name="vehicle_pro_condition" id="vehicle_pro_condition" type="text" maxlength="30" />
                                                </div>
                                            </div>

                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Choose color</label>
                                                <div class='col-md-5'>      <!-- kesha -->                                              
                                                  <!-- <input class='colorpicker-hex form-control' value="<?php //echo $product[0]['color']; ?>" name="vehicle_pro_color" id="vehicle_pro_color" placeholder='Pick a color' style='margin-bottom: 0;' type='text'> -->
                                                 <select name="vehicle_pro_color"  class="form-control" id="ms" >   
                                                        <option value="">Select Color</option>                                  
                                                        <?php foreach($colors as $col):  ?>                                     
                                                        <option style="color:<?php echo $col['font_color']; ?>;background-color:<?php echo $col['background_color']; ?>" value="<?php echo $col['background_color']; ?>"
                                                        <?php if(isset($product[0]['color']) && $product[0]['color']==$col['background_color']) echo 'selected=selected'; else echo ''; ?>><?php echo $col['name']; ?></option>
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
														  <?php if($st['country_id'] == $product[0]['country_id']) {?>
															<option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
															<?php } else { ?>
															<option value="<?php echo $st['country_id'] ?>" ><?php echo $st['country_name'] ?></option>
															<?php } ?>                                        
														 <?php endforeach; ?>                                	
													</select>
												</div>
											</div>
											<div class="form-group" >
											<input type="hidden" id='mycounter2' value="<?php echo $mycounter; ?>">
                                                <label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
                                                 <div class='col-md-5 controls'>
                                                    <select name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required='true' id="city_form2">
                                                        <option value="">Select</option>
                                                        <?php foreach ($state as $o) { ?>
                                                            <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
                                                        <?php } ?>
                                                    </select>                     
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  data-rule-required='true' value='<?php if(isset($product[0]['phone_no'])) echo $product[0]['phone_no']; ?>' onkeypress="return isNumber1(event)"/>
                                                </div>
                                            </div>                                           
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
                                                 <div class='col-md-5 controls'>
                                                    <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control select2" data-rule-required='true'>
                                                        <option value="">Select</option>
                                                        <option value="NeedReview" <?php if($product[0]['product_is_inappropriate']=='NeedReview'): echo 'selected=selected'; endif; ?>>NeedReview</option>
                                                        <option value="Approve" <?php if($product[0]['product_is_inappropriate']=='Approve'): echo 'selected=selected'; endif; ?>>Approve</option>
                                                        <option value="Unapprove" <?php if($product[0]['product_is_inappropriate']=='Unapprove'): echo 'selected=selected'; endif; ?>>Unapprove</option>
                                                        <option value="Inappropriate" <?php if($product[0]['product_is_inappropriate']=='Inappropriate'): echo 'selected=selected'; endif; ?>>Inappropriate</option>
                                                    </select>                     
                                                </div>
                                            </div>	
											<div class="row form-group" style="margin-top:20px;display:none;">
													<div class="col-md-2 col-sm-3">Youtube Link</div>
													<div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form2"/>
													
													<?php $ext = explode(".", $product[0]['product_image']); ?>										
													<input type="text" class="form-control" name="cov_img" id="cov_img_form2" value="<?php echo $ext[0]; ?>"/>
													</div>
											</div>
											<div class="row form-group" style="margin-top:20px;display:none;">
													<div class="col-md-2 col-sm-3">Upload Video</div>
													<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form2" name="video" /></div>
											</div>											
                                            <div class="form-actions form-actions-padding-sm btn-btm-css">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="form2_submit" name="vehicle_submit">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='#' title="Cancel" class="btn" onclick="goBack()">Cancel</a><input type="hidden" name="form2_images_arr" id="form2_images_arr"   class="form-control" /> 
                                                    </div>
                                                </div>
                                            </div>
            </form>
<?php //}else if($product_type=='real_estate'){ ?>
            <!--================= REAL ESTATE HOUSES FORM ===================-->
            <form name="real_estate_houses_form" style="display: none;" action='<?php echo base_url() . 'admin/classifieds/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form real_estate_houses_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form3">
											<h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
											<hr />
                                            <input type="hidden" name="cat_id" value="<?php if(isset($product[0]['category_id']))  echo $product[0]['category_id']; ?>" id="cat_id_form3">
                                            <input type="hidden" name="sub_cat" value="<?php if(isset($product[0]['sub_category_id'])) echo $product[0]['sub_category_id']; ?>" id="sub_cat_form3">
                                            <input type="hidden" id='mycounter3' value="<?php echo $mycounter; ?>">
                                           
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control" placeholder="Ad Title" name="houses_ad_title" value="<?php if(isset($product[0]['product_name'])) echo $product[0]['product_name']; ?>" id="pro_ad_title" type="text" data-rule-required='true' maxlength="50"/>
                                                </div>
                                            </div>
											<div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <textarea class="form-control" placeholder="Description" name="house_pro_desc" rows="3" data-rule-required='true' maxlength="200"><?php if(isset($product[0]['product_description'])) echo $product[0]['product_description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Price<span> *</span></label>   
													<div class="input-group col-md-5 controls price_cont">
                                                        <span class="input-group-addon">Dirham</span>
                                                        <input type="text" value="<?php if(isset($product[0]['product_price'])) echo $product[0]['product_price']; ?>" id="houses_price" name="houses_price" class="form-control" data-rule-required='true'>
                                                        <span class="input-group-addon">.00</span>
                                                      </div>
                                                      <div class="checkbox col-md-2">
                                                        <label>
                                                          <input name="houses_free" <?php echo (isset($product[0]['free_status']) && $product[0]['free_status'] == 1) ? 'checked' : ''; ?> type="checkbox" value="1">
                                                          Free
                                                        </label>
                                                      </div>
													  <span for="houses_price" class="help-block has-error"></span>
                                            </div>
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Furnished</label>
                                                <div class='col-md-5'>
                                                    <select id="furnished" name="furnished" class="select2 form-control">
                                                        <option  value="0">Select</option>
                                                        <option <?php echo (isset($product[0]['furnished']) && $product[0]['furnished'] == 'yes') ? 'selected' : ''; ?>  value="yes">Yes</option>
                                                        <option <?php echo (isset($product[0]['furnished']) && $product[0]['furnished'] == 'no') ? 'selected' : ''; ?> value="no">No</option>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Bedrooms</label>
                                                <div class='col-md-5'>
                                                    <select id="bedrooms" name="bedrooms" class="select2 form-control">
                                                       <option value="0">Select Number</option>
                                                        <?php for($i=1;$i<6;$i++){ ?>
                                                            <option <?php echo (isset($product[0]['Bedrooms']) && $product[0]['Bedrooms'] == $i) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>                     
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Bathrooms</label>
                                                <div class='col-md-5'>
                                                    <select id="bathrooms" name="bathrooms" class="select2 form-control">
                                                        <option value="0">Select Number</option>
                                                        <?php for($i=1;$i<4;$i++){ ?>
                                                            <option <?php echo (isset($product[0]['Bathrooms']) && $product[0]['Bathrooms'] == $i) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Pets</label>
                                                <div class='col-md-5'>
                                                    <select id="pets" name="pets" class="select2 form-control">
                                                        <option  value="0">Select</option>
                                                        <option <?php echo (isset($product[0]['pets']) && $product[0]['pets'] == 'yes') ? 'selected' : ''; ?>  value="yes">Yes</option>
                                                        <option <?php echo (isset($product[0]['pets']) && $product[0]['pets'] == 'no') ? 'selected' : ''; ?> value="no">No</option>
                                                    </select>                 
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Broker Fee</label>
                                                <div class='col-md-5'>
                                                    <select id="broker_fee" name="broker_fee" class="select2 form-control">
                                                        <option  value="0">Select</option>
                                                        <option <?php echo (isset($product[0]['broker_fee']) && $product[0]['broker_fee'] == 'yes') ? 'selected' : ''; ?>  value="yes">Yes</option>
                                                        <option <?php echo (isset($product[0]['broker_fee']) && $product[0]['broker_fee'] == 'no') ? 'selected' : ''; ?> value="no">No</option>
                                                    </select>                      
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Square Meters</label>
                                                <div class='col-md-5'>
                                                    <input class="form-control" placeholder="square_meters" id="pro_square_meters" value="<?php if(isset($product[0]['Area'])) echo $product[0]['Area']; ?>" name="pro_square_meters" type="number" />
                                                </div>
                                            </div>
											<div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>My Ad is in</label>
                                                <div class='col-md-5'>
                                                    <select id="houses_language" name="houses_language" class="select2 form-control">
                                                        <option <?php echo ($product[0]['ad_language'] == 0 || $product[0]['ad_language'] == '') ? 'selected':'' ;?> value="0">Select</option>
                                                        <option <?php echo ($product[0]['ad_language'] == 'english') ? 'selected' : ''; ?> value="english">English</option>
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
														  <?php if($st['country_id'] == $product[0]['country_id']) {?>
															<option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
															<?php } else { ?>
															<option value="<?php echo $st['country_id'] ?>" ><?php echo $st['country_name'] ?></option>
															<?php } ?>                                        
														 <?php endforeach; ?>                                	
													</select>
												</div>
											</div>	
											 <div class='form-group'>                                                
                                                <label class='col-md-2 control-label'>Emirate<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required='true'  id="city_form3">                                                        
                                                        <?php foreach ($state as $o) { ?>
                                                            <option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
                                                        <?php } ?>
                                                    </select>                     
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Ad Address</label>
                                                <div class='col-md-5'>
                                                    <input class="form-control"  placeholder="Address" value="<?php if(isset($product[0]['address'])) echo $product[0]['address']; ?>" name="houses_ad_address" type="text" maxlength="100"/>
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <div class='col-md-offset-2 col-md-5 controls'>
                                                    <input type="text" class="form-control" value="<?php if(isset($product[0]['neighbourhood'])) echo $product[0]['neighbourhood']; ?>" placeholder="Neighbourhood (Optional)" name="houses_pro_neighbourhood" maxlength="50"/>
                                                </div>
                                            </div>
											<div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  data-rule-required='true' value='<?php if(isset($product[0]['phone_no'])) echo $product[0]['phone_no']; ?>' onkeypress="return isNumber1(event)"/>
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
                                                 <div class='col-md-5 controls'>
                                                    <select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control select2" data-rule-required='true'>
                                                        <option value="">Select</option>
                                                        <option value="NeedReview" <?php if($product[0]['product_is_inappropriate']=='NeedReview'): echo 'selected=selected'; endif; ?>>NeedReview</option>
                                                        <option value="Approve" <?php if($product[0]['product_is_inappropriate']=='Approve'): echo 'selected=selected'; endif; ?>>Approve</option>
                                                        <option value="Unapprove" <?php if($product[0]['product_is_inappropriate']=='Unapprove'): echo 'selected=selected'; endif; ?>>Unapprove</option>
                                                        <option value="Inappropriate" <?php if($product[0]['product_is_inappropriate']=='Inappropriate'): echo 'selected=selected'; endif; ?>>Inappropriate</option>
                                                    </select>                   
                                                </div>
                                            </div>
											<div class="row form-group" style="margin-top:20px;display:none;">
												<div class="col-md-2 col-sm-3">Youtube Link</div>
												<div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form3"/>
												<?php $ext = explode(".", $product[0]['product_image']); ?>
												<input type="text" class="form-control" name="cov_img" id="cov_img_form3" value="<?php echo $ext[0]; ?>"/>
												
												</div>
											</div>
											<div class="row form-group" style="margin-top:20px;display:none;">
												<div class="col-md-2 col-sm-3">Upload Video</div>
												<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form3" name="video" /></div>
											</div>
                                            <div class="form-actions form-actions-padding-sm btn-btm-css">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="form3_submit" name="real_estate_houses_submit">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='#' title="Cancel" class="btn" onclick="goBack()">Cancel</a><input type="hidden" name="form3_images_arr" id="form3_images_arr"   class="form-control" /> 
                                                    </div>
                                                </div>
                                            </div>
            </form>
            <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
            <form name="real_estate_shared_form" style="display: none;" action='<?php echo base_url() . 'admin/classifieds/listings_edit/'.$product[0]['product_id'] ?>' class='form form-horizontal validate-form real_estate_shared_form real_estate' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form4">
						<h4><i class="fa fa-info-circle"></i>&nbsp;&nbsp;Item Details</h4>
						<hr />    
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Ad Title<span> *</span></label>
							<div class='col-md-5 controls'>
								<input class="form-control" placeholder="Ad Title" value="<?php if(isset($product[0]['product_name'])) echo $product[0]['product_name']; ?>" name="shared_ad_title" type="text" data-rule-required='true' maxlength="50"/>
							</div>
						</div>   
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Describe what makes your ad unique<span> *</span></label>
							<div class='col-md-5 controls'>
								<textarea class="form-control" placeholder="Description" name="shared_pro_desc" rows="3" data-rule-required='true' maxlength="200"><?php if(isset($product[0]['product_description'])) echo $product[0]['product_description']; ?></textarea>
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Price<span> *</span></label>
								<div class="input-group col-md-5 price_cont">
									<span class="input-group-addon">Dirham</span>
									<input type="text" value="<?php if(isset($product[0]['product_price'])) echo $product[0]['product_price']; ?>" id="shared_price" name="shared_price" class="form-control" data-rule-required='true'>
									<span class="input-group-addon">.00</span>
								  </div>
								  <div class="checkbox col-md-2">
									<label>
									  <input type="checkbox" <?php echo (isset($product[0]['free_status']) && $product[0]['free_status'] == 1) ? 'checked' : ''; ?> name="shared_free" value="1">
									  Free
									</label>
								  </div>
								  <span for="shared_price" class="help-block has-error"></span>
						</div>
						<h4><i class="fa fa-home"></i>&nbsp;&nbsp;Contact Details</h4>
						<hr />	
						<div class="form-group">                    
							<label class='col-md-2 control-label' for='inputText1'>Country <span> *</span></label>
							<div class="col-md-5 controls">
								<select class="select2 form-control" name="location" id="location_con_form4" onchange="show_emirates_form4(this.value);" data-rule-required='true' >	
									<option value="">Select Country</option>
									<?php foreach ($location as $st): ?>
									  <?php if($st['country_id'] == $product[0]['country_id']) {?>
										<option value="<?php echo $st['country_id'] ?>" selected><?php echo $st['country_name'] ?></option>
										<?php } else { ?>
										<option value="<?php echo $st['country_id'] ?>" ><?php echo $st['country_name'] ?></option>
										<?php } ?>                                        
									 <?php endforeach; ?>                                	
								</select>
							</div>
						</div>											
						<div class="form-group" >
							<input type="hidden" name="cat_id" value="<?php if(isset($product[0]['category_id'])) echo $product[0]['category_id']; ?>" id="cat_id_form4">
							<input type="hidden" name="sub_cat" value="<?php if(isset($product[0]['sub_category_id'])) echo $product[0]['sub_category_id']; ?>" id="sub_cat_form4">                                              
							<label class='col-md-2 control-label' for='inputText1'>Emirate<span> *</span></label>
							<div class='col-md-5  controls'>
								<select  name="state" class="select2 form-control" onchange="show_emirates(this.value);" data-rule-required='true' id="city_form4">
									<option value="">Select</option>
									<?php foreach ($state as $o) { ?>
										<option value="<?php echo $o['state_id']; ?>" <?php echo ($product[0]['state_id'] == $o['state_id'])? 'selected':'' ;?>><?php echo $o['state_name']; ?></option>
									<?php } ?>
								</select>    													
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Ad Address</label>
							<div class='col-md-5'>
								<input class="form-control" value="<?php if(isset($product[0]['address'])) echo $product[0]['address']; ?>"  placeholder="Address" name="shared_ad_address" type="text" maxlength="100"/>
							</div>
						</div>
						 <div class='form-group'>                        
							<div class='col-md-offset-2 col-md-5 controls'>
							<input type="hidden" id='mycounter4' value="<?php echo $mycounter; ?>">
								<input type="text" class="form-control" value="<?php if(isset($product[0]['neighbourhood'])) echo $product[0]['neighbourhood']; ?>" placeholder="Neighbourhood (Optional)" name="shared_pro_neighbourhood" maxlength="50"/>
							</div>
						</div>
						
						
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>My Ad is in</label>
							<div class='col-md-5'>
								<select id="shared_language" name="shared_language" class="select2 form-control">
									<option <?php echo ($product[0]['ad_language'] == 0 || $product[0]['ad_language'] == '') ? 'selected':'' ;?> value="0">Select</option>
									<option <?php echo ($product[0]['ad_language'] == 'english') ? 'selected' : ''; ?> value="english">English</option>
								</select>                     
							</div>
						</div>
						<div class='form-group'>                        
							<label class='col-md-2 control-label' for='inputText1'>Phone No.<span> *</span></label>
							<div class='col-md-5 controls'>
								<input class="form-control"  placeholder="Client Phone No." name="pro_phone" type="text"  data-rule-required='true' value='<?php if(isset($product[0]['phone_no'])) echo $product[0]['phone_no']; ?>' onkeypress="return isNumber1(event)"/>
							</div>
						</div>
						<div class="form-group" >
							<label class='col-md-2 control-label' for='inputText1'>Product Is<span> *</span></label>
							 <div class='col-md-5 controls'>
								<select id="product_is_inappropriate" name="product_is_inappropriate" class="form-control select2" data-rule-required='true'>
									<option value="">Select</option>
									<option value="NeedReview" <?php if($product[0]['product_is_inappropriate']=='NeedReview'): echo 'selected=selected'; endif; ?>>NeedReview</option>
									<option value="Approve" <?php if($product[0]['product_is_inappropriate']=='Approve'): echo 'selected=selected'; endif; ?>>Approve</option>
									<option value="Unapprove" <?php if($product[0]['product_is_inappropriate']=='Unapprove'): echo 'selected=selected'; endif; ?>>Unapprove</option>
									<option value="Inappropriate" <?php if($product[0]['product_is_inappropriate']=='Inappropriate'): echo 'selected=selected'; endif; ?>>Inappropriate</option>
								</select>                   
							</div>
						</div>
						<div class="row form-group" style="margin-top:20px;display:none;">
								<div class="col-md-2 col-sm-3">Youtube Link</div>
								<div class="col-md-6 col-sm-8"><input type="text" class="form-control" name="youtube" id="youtube_form4"/>
								<?php $ext = explode(".", $product[0]['product_image']); ?>												
								<input type="text" class="form-control" name="cov_img" id="cov_img_form4" value="<?php echo $ext[0]; ?>"/>
								</div>
						</div>
						<div class="row form-group" style="margin-top:20px;display:none;">
								<div class="col-md-2 col-sm-3">Upload Video</div>
								<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="video_form4" name="video" /></div>
						</div>
						<div class="form-actions form-actions-padding-sm btn-btm-css">
							<div class="row">
								<div class="col-md-10 col-md-offset-2">
									<button class='btn btn-primary' type='submit' id="form4_submit" name="real_estate_shared_submit">
										<i class="fa fa-floppy-o"></i>
										Save
									</button>
									<a href='#' title="Cancel" class="btn" onclick="goBack()">Cancel</a><input type="hidden" name="form4_images_arr" id="form4_images_arr"   class="form-control" /> 
								</div>
							</div>
						</div>
					</form>											
                                            
<?php //} ?>
				<form id="fileupload" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
					<h4><i class="fa fa-image"></i>Upload Media</h4>
                    <hr />		
					<span id="error_img" style="color:red"></span>		
					<div class='form-group'>   						
							<?php if (!empty($product[0]['product_image'])): ?>
							<div class='form-group img-div005' style="display: inline-block;vertical-align: top;">
									<div class='gallery'>                                                   
										<ul class='list-unstyled list-inline'>
										<li>
											<div class='picture'>													
											  <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $product[0]['product_image']; ?>'>
												<img alt="product Image" src="<?php echo base_url() . product . "medium/" . $product[0]['product_image']; ?>" width="150px" height="150px"/>
											  </a>
													<!--<div class="star" >
														<a href="#">1
															<i class="fa fa-star"></i>
														</a>
													</div>--><br>
													<div class="star fav" >
														<a href="#" ><?php $ext = explode(".", $product[0]['product_image']); ?>
                                                            <i class="fa fa-star" id="<?php echo $ext[0]; ?>" name="<?php echo $product[0]['product_image']; ?>" title="Set As Cover Image"></i>
                                                        </a>
													</div>
											  <div class='tags'>
												
												<div class='label label-important'>														
													<!-- <input type="radio" name="<?php   // echo $product[0]['product_image'] ?>" id="cov_img" title="Set Image as Cover Image" onclick="javascript:selet_cover_img('<?php //echo $product[0]['product_image']; ?>');"   class="rd_cls" value="1"> -->													
													<a  class="delete_btn1" style="cursor:pointer;" onclick="javascript:deletemainimg('<?php echo $product[0]['product_id']; ?>','<?php  echo $product[0]['product_image'] ?>');"><i class="fa fa-trash" title="Delete Image"></i></a>
												</div>
											  </div>                              
											</div>                          
										  </li >
										</ul>                       
									</div>								
							</div>
						<?php endif; ?>												
						
					</div>
					<div class="form-group img-div006" >  						 
						  <div class='gallery'>                                                 
							<ul class='list-unstyled list-inline'>
							<?php  foreach($images as $i):  ?>  
							  <li>                                                  
								<div class='picture'>								                                
									<a data-lightbox='flatty' href="<?php echo base_url() . product . "original/" . $i['product_image']; ?>">
									<img alt="product Image" src="<?php echo base_url() . product . "medium/" . $i['product_image']; ?>" width="150px" height="150px">
								  </a>
								  <div class='tags'>
									<div class='label label-important'>
										<div class="star fav" >
											<a href="#"><?php $ext = explode(".", $i['product_image']); ?>
												<i class="fa fa-star-o" id="<?php echo $ext[0]; ?>" name="<?php echo $i['product_image']; ?>" value="<?php echo $i['product_image']; ?>" title="Set As Cover Image"></i>
											</a>
										</div>										
										<!-- <input type="radio" name="<?php //echo $i['product_image']; ?>" id="cov_img" title="Set Image as Cover Image" onclick="javascript:selet_cover_img('<?php //echo $i['product_image']; ?>');" class="rd_cls" value="1"> -->
									
										<a style="cursor:pointer;" class="delete_btn1" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>','<?php echo $product[0]['product_id']; ?>','<?php echo $i['product_image']; ?>');"><i class="fa fa-trash" title="Delete Image"></i></a>
									</div>
								  </div>
								</div>                          
							  </li>      
								<?php   endforeach; ?>                        
							</ul>                       
						  </div>						
					</div>
					<div class="clearfix"></div>
					<div class='form-group'>  
					<div class="fileupload-buttonbar row">
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
					</div>
					<!-- The table listing the files available for upload/download -->
					
					<div class="col-md-8">
					<table role="presentation" class="table table-striped"><tbody class="files" id="table_image"></tbody></table>					
					</div>
					<div class="clearfix"></div>
				</form>
				<form  class='form form-horizontal validate-form'>
					<div class='form-group'>     
						<label class="col-md-2 col-sm-3 control-label">Video</label>                      
						<div class="col-md-6 col-sm-8 mar-t-7">
							<input type="radio" name="video_selection" id="youtube_form" onclick="javascript:show_hide(1);" <?php if(isset($product[0]['youtube_link']) && $product[0]['youtube_link']!='') echo 'checked=checked'; ?>/>
							&nbsp;&nbsp;Youtube Link &nbsp;&nbsp;&nbsp;&nbsp;							
							<input type="radio"  name="video_selection" id="video_form" onclick="javascript:show_hide(2);" <?php if(isset($product[0]['video_name']) && $product[0]['video_name']!='') echo 'checked=checked'; ?>/>&nbsp;&nbsp;Upload Video
						</div>					
					</div>
					<div class="row form-group" style="margin-top:20px; <?php if(isset($product[0]['youtube_link']) && $product[0]['youtube_link']!='') echo ''; else echo 'display:none;'; ?> " id="youtube_div">						
						<label class="col-md-2 col-sm-3 control-label">Youtube Link</label>
						<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="my_youtube_link" name="my_youtube_link" value="<?php if(isset($product[0]['youtube_link']) && $product[0]['youtube_link']!='') echo $product[0]['youtube_link']; ?>"/></div>
					</div>
				</form>
				<form id="fileupload1" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
						<span id="error_span" style="color:red"></span>												
						<div  id="video_div" style="<?php if(isset($product[0]['video_name']) && $product[0]['video_name']!='') echo ''; else echo 'display:none;'; ?>">
						<div class="form-group" style="margin-top:20px;<?php if(isset($product[0]['video_name']) && $product[0]['video_name']!='') echo ''; else echo 'display:none;'; ?>" >
							<!--<div class="col-md-2 col-sm-3">Upload Video</div>
							<div class="col-md-6 col-sm-8">
							<input type="file" class="form-control" id="video" name="video" /></div> -->
							<?php if($product[0]['video_name']!='') { ?>	
								<div class="video-uploaded-div">
									<video width="400" controls>
									  <!-- <source src="<?php //echo base_url() . 'assets/upload/product/original/'.$product[0]['video_name']; ?>" > -->
									  <source src="<?php echo base_url() . 'assets/upload/product/original/'.$product[0]['video_name']; ?>" type="video/webm">
									  <source src="<?php echo base_url() . 'assets/upload/product/original/'.$product[0]['video_name']; ?>" type="video/mp4">
									  <source src="<?php echo base_url() . 'assets/upload/product/original/'.$product[0]['video_name']; ?>" type="video/ogg">
									  <source src="<?php echo base_url() . 'assets/upload/product/original/'.$product[0]['video_name']; ?>" type="application/ogg">
									  
									  Your browser does not support HTML5 video.
									</video> <a style="cursor:pointer;" class="" onclick="javascript:mydeletevideo('<?php echo $product[0]['product_id']; ?>','<?php echo $product[0]['video_name']; ?>');"><i class="fa fa-trash"></i></a>
								</div>	
							<?php } ?>	
						</div>	
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
								<button type="button" class="btn btn-danger delete">
									<i class="glyphicon glyphicon-trash" title="Click Me after select images to delete"></i>
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
            {% if (file.thumbnailUrl) {  %} 
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
<script type="text/javascript">                
var base_url = "<?php echo base_url(); ?>admin/";
</script>
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/javascripts/multiupload.js"></script>-->	
<script type="text/javascript">
	function goBack()
  	{
 	 	window.history.back()
 	}
	//function set_coverimg(a)
	//{
		//$('#fileupload').find('div.star').click(function(e) {		
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
			return false;		
		});
	//}
/*
function set_coverimg(a)
{
	//alert(a);
	var conname		=	"'#"+a+"'";
	alert(conname);	
	$(conname).removeClass("fa-star-o");
	$(conname).addClass("fa-star");
	
	$("#cov_img_form1").val(a);
	$("#cov_img_form2").val(a);
	$("#cov_img_form3").val(a);
	$("#cov_img_form4").val(a);
	
} */
function isNumber1(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		
		if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=45) {
			return false;
		}
		return true;
	}
	
$("#vehicle_pro_year").datepicker({
    format: "yyyy",
    startView: 1,
    minViewMode: 2
});

	/*$("#cov_img_form1").val("");
	$("#cov_img_form2").val("");
	$("#cov_img_form3").val("");
	$("#cov_img_form4").val("");*/
		
	$("#video_form1").val("");
	$("#video_form2").val("");
	$("#video_form3").val("");
	$("#video_form4").val("");
				
	$("#form1_images_arr").val("");
	$("#form2_images_arr").val("");
	$("#form3_images_arr").val("");
	$("#form4_images_arr").val("");

		
	
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
            maxNumberOfFiles: <?php echo $img_cnt; ?>,								
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
				$("#form1_images_arr").val(img_arr);
				$("#form2_images_arr").val(img_arr);
				$("#form3_images_arr").val(img_arr);
				$("#form4_images_arr").val(img_arr);  							
				
				var str = $("#form1_images_arr").val();
				var arr = str.split(',');
				var myval	=	$("#cov_img_form1").val();
				var mydata	=	window.btoa(myval);
				
				var chk_	=	jQuery.inArray(mydata,arr);
				if(chk_==-1)
				{
					$("#cov_img_form1").val('');
					$("#cov_img_form2").val('');
					$("#cov_img_form3").val('');
					$("#cov_img_form4").val('');
				}
				
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
        $('#fileupload1').fileupload({
            dropZone: $('#dropzone'),
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(mp4|flv|avi)$/i,
            maxFileSize: 10000000, // 10 MB
            maxNumberOfFiles: <?php echo $vido_cnt; ?>,								
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

	
	
		

var val     = $('#cat_id').val();
var subval  = $('#sub_cat').val();
show_sub_cat(val);
show_sub_cat_fields(subval);
var val = $('#cat_id').val();
//show_sub_cat(val);
var q=0;
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
    $.post(url, {value: val,sub_cat_id:<?php echo $product[0]['sub_category_id']; ?>,q:q}, function(data)
    {        
        $("#sub_cat_list").html(data);
        //$("#sub_cat").select2();
    });
	 q	=	q+1;
}
/*
$("#cat_id").each(function() {
        var $thisOption = $(this);
        $thisOption.attr("disabled", "disabled");
});
$("#sub_cat").each(function() {
        var $thisOption = $(this);        
        $thisOption.attr("disabled", "disabled");
});
*/

var val = $('#cat_id').val();
//show_sub_cat(val);
//$("#shared_location").select2();
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
<script>

var url 	= 	"<?php echo base_url() ?>admin/classifieds/show_emirates_postadd";
	//for form 1
	//var val1	=	$("#location_con_form1").val();
	//show_emirates_form1(val1);
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
	//show_emirates_form2(val2);
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
	//show_emirates_form3(val3);
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
	//show_emirates_form4(val4);
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
function deletemainimg(prod_id,img_name)
{
    var url = "<?php echo base_url() ?>admin/classifieds/removemainimage";
    var r = confirm("Are you sure you want to delete main image?");
    if (r == true) 
    {
		if(img_name==$('#cov_img_form1').val())
		{
			$('#cov_img_form1').val('');
			$('#cov_img_form2').val('');
			$('#cov_img_form3').val('');
			$('#cov_img_form4').val('');
		}
			
        $.post(url, {prod_id:prod_id}, function(data)
        {
        
            //alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>admin/classifieds/listings_edit/"+prod_id;  
        });
    }     
    return false;
}
function mydelete(val,prod_id,img_name)
{
    var url = "<?php echo base_url() ?>admin/classifieds/removeimage";
    var r = confirm("Are you sure you want to delete image?");
    if (r == true) 
    {
		if(img_name==$('#cov_img_form1').val())
		{
			$('#cov_img_form1').val('');
			$('#cov_img_form2').val('');
			$('#cov_img_form3').val('');
			$('#cov_img_form4').val('');
		}
        $.post(url, {value: val,prod_id:prod_id}, function(data)
        {          
			//alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>admin/classifieds/listings_edit/"+prod_id;  
        });
    }     
    return false;
}


function mydeletevideo(prod_id,video)
{
    var url = "<?php echo base_url() ?>admin/classifieds/removevideo";
    var r = confirm("Are you sure you want to delete video?");
    if (r == true) 
    {	
		$("#video_form1").val("");
		$("#video_form2").val("");
		$("#video_form3").val("");
		$("#video_form4").val("");
		
        $.post(url, {prod_id:prod_id,video:video}, function(data)
        {          
			//alert("Image deleted successfully");
            window.location = "<?php echo base_url(); ?>admin/classifieds/listings_edit/"+prod_id;  
        });
    }     
    return false;
}
</script>        
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / theme file [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
    </body>
</html>