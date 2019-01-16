<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
		
        <link href='<?php echo base_url(); ?>assets/admin/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>  
        <link href='<?php echo base_url(); ?>assets/front/dist/css/Open_Sans.css' rel='stylesheet' type='text/css'>
        
        <link rel="stylesheet" href="<?php echo site_url(); ?>/assets/front/stylesheets/file_upload_css/style.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/blueimp/blueimp-gallery.min.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-ui.css">
        <noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-noscript.css"></noscript>
        <noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-ui-noscript.css"></noscript>
        
        <?php $this->load->view('admin/include/listing_script'); ?>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script> 
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/vendor/jquery.ui.widget.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.iframe-transport.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/tmpl.min.js"></script>
        <script src="<?php echo site_url(); ?>/assets/admin/javascripts/blueimp/load-image.all.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/canvas-to-blob.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.iframe-transport.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-process.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-image.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-validate.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-ui.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-select.min.js" type="text/javascript"></script>
        
        <title>Edit Listing</title>
<style>
	canvas {display:none;}

    .loader_display {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('<?php echo static_image_path; ?>ajax-loader.gif') 50% 50% no-repeat rgb(249,249,249);
    }

</style>
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container post-prod'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-list-ol'></i>
                                    <span>Listings</span>
                                </h1>
                                <div class='pull-right'>                                  
                                    <?php                                    
                                    $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                    $view_path = base_url() . "admin/classifieds/listings_view/" . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6) . '/' . $page_redirect;
                                    ?>
                                    <a href='<?php echo $view_path; ?>' class="btn-primary btn-lg">
                                        <i class="fa fa-eye"></i>&nbsp;View Ad
                                    </a>
                                </div>
                            </div>
                            <hr class="hr-normal">
                            <?php if(validation_errors() != false) { ?>
                            <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo validation_errors(); ?>								
                            </div>							
                            <?php } ?>
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <div class='title'>                         
                                <?php if(isset($_GET['userid']) && $_GET['userid']!='')  {
                                            $res    =   $this->db->query('select email_id,username from user where user_id='.$_GET['userid'])->row();
                                            if(isset($res)) {
                                                echo 'Email ID: <u>'. $res->email_id.'</u><br>';  
                                                echo 'Username: '. $res->username;
                                            }
                                            else
                                                redirect('admin/classifieds/listings/');
                                        }
                                ?>
                            </div>
<?php 
    if(isset($_REQUEST['request_for']) && $_REQUEST['request_for']=='user' && isset($_REQUEST['userid']))
        $myredirect_path    =   base_url() . 'admin/classifieds/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$product[0]['product_id'].'/?request_for=user&userid='.$_REQUEST['userid'];
    else
        $myredirect_path    =   base_url() . 'admin/classifieds/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/'.$product[0]['product_id'];

    if(!empty($user_store_status) && $user_store_status==3)
        echo '<span style="color:red;">Note: You are trying to edit post for Hold Store, If you approve now but system will deactivate after its specified days (Mention in settings module)</span>';

?>
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
                                                   <select class="form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);" <?php if(isset($user_category_id) && (int)$user_category_id>0) echo 'disabled=disabled'; ?>>
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>" <?php 
                                                            	if($cat['category_id'] == $product[0]['category_id'])  echo 'selected';  
                                                            		elseif(isset($user_category_id) && (int)$user_category_id>0 && $user_category_id==$cat['category_id']) {
                                                                            echo 'selected';
                                                                      }
                                                                       ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                           <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Sub Category<span> *</span></label>
                                                <div class='col-md-5' id="sub_cat_list" style="padding: 0px 12px 14px 6px;">
                                                    <select class="form-control" id="sub_cat" name="sub_cat" <?php if(isset($user_sub_category_id) && (int)$user_sub_category_id>0) echo 'disabled=disabled'; ?>>
														<option value="">Select Sub Category</option>
                                                        <?php foreach ($sub_category as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>" <?php if($cat['sub_category_id'] == $product[0]['sub_category_id']) echo 'selected';
                                                            	elseif(isset($user_sub_category_id) && (int)$user_sub_category_id>0) echo set_select('sub_cat',$cat['sub_category_id'], TRUE);
                                                             ?>><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                                   
													<label id="subcat_id_err" class="error" style="display:none;"><font color="#b94a48">This field is required.</font></label>
                                                </div>
                                            </div>
                                        </div>
                                      
                    <!--===================== DEFAULT FORM ======================-->
                    <?php //if($product_type=='default'){  ?>

				    <?php 
                        $this->load->view('admin/listings/edit_forms/form1_default');
                    ?>
				<?php //}else if($product_type=='vehicle'){ ?>
                    <!--=========================== VEHICLE FORM =============================-->
                    <?php 
                        $this->load->view('admin/listings/edit_forms/form2_vehicle');
                    ?>
            
                <?php //}else if($product_type=='real_estate'){ ?>
                <!--================= REAL ESTATE HOUSES FORM ===================-->
                <?php 
                    $this->load->view('admin/listings/edit_forms/form3_realestate1');
                ?>
                <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
                <?php 
                    $this->load->view('admin/listings/edit_forms/form4_realestate2');
                ?>                
                <!--  ===========================  Car Number    ===========================  - -->
    			<?php 
                    $this->load->view('admin/listings/edit_forms/form5_car_number');
                ?>	
                <!--  ===========================  Mobile Number    ===========================  - -->
                <?php 
                    $this->load->view('admin/listings/edit_forms/form6_mobile_number');
                ?>  
                                                        
                                                            
<?php //} ?>
<div class="loader_display" style="display:none;"></div>
<!-- <div id="" style="text-align:center" class="loader_display" style="display:none;">
    <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
</div> -->
				<form id="fileupload" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
					<h4><i class="fa fa-image"></i>&nbsp;&nbsp;Upload Media</h4>
                    <hr />		
					<span id="error_img" style="color:red"></span>		
					<div class='form-group'>   						
							<?php
                                                        if(isset($product[0]['product_image']) && !empty($product[0]['product_image'])):
                                                         ?>
<div class='form-group img-div005' style="display: inline-block;vertical-align: top;">
                <div class='gallery'>                                                   
                        <ul class='list-unstyled list-inline'>
                        <li>
                                <div class='picture'>
                                    <?php 
                                    if(!empty($product[0]['product_image'])) {
                                        $load_img = base_url() . product . "original/" . $product[0]['product_image'];
                                        $img_url = base_url() . product . "medium/" . $product[0]['product_image'];
                                    }
                                    else {
                                        $load_img = site_url().'/assets/upload/No_Image.png';
                                        $img_url = site_url().'/assets/upload/No_Image.png';
                                    }
                                    ?>
                                    <a data-lightbox='flatty' href='<?php echo $load_img; ?>'>
                                        <img alt="Product Image" src="<?php echo $img_url; ?>" width="150px" height="150px"/>
                                  </a><br>
                                    <div class="star fav" >
                                            <a href="#"><?php $ext = explode(".", $product[0]['product_image']); ?>
    <i class="fa fa-star" id="<?php echo $ext[0]; ?>" name="<?php echo $product[0]['product_image']; ?>" title="Set As Cover Image" data-id="<?php echo $product[0]['product_image']; ?>"></i>
    </a>
                                    </div>
                                  <div class='tags'>
                                        <div class='label label-important'>
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
                                                      <?php  if(sizeof($images) > 0) {  ?>  
							<ul class='list-unstyled list-inline'>
							<?php  foreach($images as $i):  ?>  
							  <li>                                                  
								<div class='picture'>								             <?php 
                                                                        if(!empty($i['product_image'])) {
                                                                            $load_img = base_url() . product . "original/" . $i['product_image'];
                                                                            $img_url = base_url() . product . "medium/" . $i['product_image'];
                                                                        }
                                                                        else {
                                                                            $load_img = site_url().'/assets/upload/No_Image.png';
                                                                            $img_url = site_url().'/assets/upload/No_Image.png';
                                                                        }
                                                                        ?>                   
									<a data-lightbox='flatty' href="<?php echo $load_img; ?>">
									<img alt="Product Image" src="<?php echo $img_url; ?>" width="150px" height="150px">
								  </a>
								  <div class='tags'>
									<div class='label label-important'>
										<div class="star fav" >
											<a href="#"><?php $ext = explode(".", $i['product_image']); ?>
												<i class="fa fa-star-o" id="<?php echo $ext[0]; ?>" name="<?php echo $i['product_image']; ?>" value="<?php echo $i['product_image']; ?>" title="Set As Cover Image" data-id="<?php echo $i['product_image']; ?>"></i>
											</a>
										</div>										<a style="cursor:pointer;" class="delete_btn1" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>','<?php echo $product[0]['product_id']; ?>','<?php echo $i['product_image']; ?>');"><i class="fa fa-trash" title="Delete Image" ></i></a>
									</div>
								  </div>
								</div>                          
							  </li>      
								<?php   endforeach; ?>                        
							</ul> 
                                                      <?php } ?>
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
								</span><span class="restrict_msg">[Maximum 10 Images are allowed]</span>
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
							<input type="radio"  name="video_selection" id="video_form" onclick="javascript:show_hide(2);" <?php if(isset($product[0]['video_name']) && $product[0]['video_name']!='') echo 'checked=checked'; ?>/>&nbsp;&nbsp;Upload Video<span class="restrict_msg">[Maximum 20 seconds video is allowed]</span>
						</div>					
					</div>
					<div class="row form-group" style="margin-top:20px; <?php if(isset($product[0]['youtube_link']) && $product[0]['youtube_link']!='') echo ''; else echo 'display:none;'; ?> " id="youtube_div">						
						<label class="col-md-2 col-sm-3 control-label">Youtube Link</label>
						<div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="my_youtube_link" name="my_youtube_link" value="<?php if(isset($product[0]['youtube_link']) && $product[0]['youtube_link']!='') echo $product[0]['youtube_link']; ?>"/></div>
					</div>
				</form>
				<form id="fileupload1" action="<?php echo base_url() . 'VideoUploads/index/'; ?>" method="POST" enctype="multipart/form-data">
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
									  <source src="<?php echo base_url() . product.'video/'.$product[0]['video_name']; ?>" type="video/webm">
									  <source src="<?php echo base_url() . product. 'video/'.$product[0]['video_name']; ?>" type="video/mp4">
									  <source src="<?php echo base_url() . product. 'video/'.$product[0]['video_name']; ?>" type="video/ogg">
									  <source src="<?php echo base_url() . product. 'video/'.$product[0]['video_name']; ?>" type="application/ogg">
									  
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
            
            <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">  
                            <h4 class="modal-title">Confirmation
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>                   
                        </div>
                        <div class="modal-body">                  
                            <p id="alert_message_action">Are you sure want delete Image(s)?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <a href="#" class="scrollup"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <?php //$this->load->view('admin/include/footer-script'); ?>        
<script>
    var emirate_url     =   "<?php echo base_url() ?>admin/classifieds/show_emirates_postadd";
    var plate_prefix_url = "<?php echo base_url(); ?>admin/classifieds/show_prefix";
</script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/listing_common.js" type="text/javascript"></script>
<script type="text/javascript">
    
    $('.form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          return false;
        }
    });
    
    $("#vehicle_pro_year").datepicker({
        format: "yyyy",
        startView: 1,
        minViewMode: 2,
        endDate: '+1y'
    });

    $(".total_stock").keydown(function (e) {
        restrict(e);
    });
    
    $("#vehicle_pro_year").keydown(function (e) {
        restrict(e);
    });
    
    $('#vehicle_pro_year').keypress(function(e) {
        e.preventDefault();
    });
    
    $("#vehicle_pro_year").change(function (e) {
        
        var vehicle_pro_year = document.getElementById("vehicle_pro_year");
        if(vehicle_pro_year.value.length>0) {
            if(vehicle_pro_year.value.length != 4){
                $('#year_error').show();
                $('#year_error').html('Please enter year in 4 digit');
                return false;
            }
            else {
                $('#year_error').hide();
            }
        }
    });
    
    function restrict(e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||    
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||     
            (e.keyCode >= 35 && e.keyCode <= 40)) {                 
                 return;
        }
        
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }    
    }

        $('.loader_display').hide();
        var base_url = "<?php echo base_url(); ?>admin/";
	
                
		$("#fileupload").on("click", "div.star > a  i ", function(e){
                        
			e.preventDefault();			
			var data_id = $(this).attr('data-id');
                        var id  =     $(this).attr('id');
			var frm	=     $("#cov_img_form1").val();
                        
			if(id!=frm) {                            
                            $("#" + frm).removeClass("fa-star");
                            $("#" + frm).addClass("fa-star-o");                            
			}
			
			$("#"+id).removeClass("fa-star-o");
			$("#"+id).addClass("fa-star");
			
			$("#cov_img_form1").val(id);
			$("#cov_img_form2").val(id);
			$("#cov_img_form3").val(id);
			$("#cov_img_form4").val(id);
                        $("#cov_img_form5").val(id);
                        $("#cov_img_form6").val(id);
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

	/*$("#cov_img_form1").val("");
	$("#cov_img_form2").val("");
	$("#cov_img_form3").val("");
	$("#cov_img_form4").val("");*/
		
	$("#video_form1").val("");
	$("#video_form2").val("");
	$("#video_form3").val("");
	$("#video_form4").val("");
        $("#video_form5").val("");
        $("#video_form6").val("");
				
	$("#form1_images_arr").val("");
	$("#form2_images_arr").val("");
	$("#form3_images_arr").val("");
	$("#form4_images_arr").val("");
        $("#form5_images_arr").val("");
        $("#form6_images_arr").val("");

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
                else if($("#video_form5").val()!='')
                    img_arr	=	$("#video_form5").val();
                else if($("#video_form6").val()!='')
                    img_arr	=	$("#video_form6").val();
		if(img_arr!='') {
			var url = "<?php echo base_url(); ?>admin/classifieds/remove_image_selected";
			$.post(url, {value: img_arr}, function(response) { 
				$("#video_form1").val("");
				$("#video_form2").val("");
				$("#video_form3").val("");
				$("#video_form4").val("");
                                $("#video_form5").val("");
                                $("#video_form6").val("");
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
//				console.log(response.files[0].name);						  
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
                                $("#form5_images_arr").val(img_arr);
                                $("#form6_images_arr").val(img_arr);
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
				img_arr.splice(index, 1);
				var url = "<?php echo base_url(); ?>admin/classifieds/remove_image_uploaded";
				$.post(url, {all_data:$("#form1_images_arr").val(),not_to_delete:img_arr}, function(response)
				{ });
				
				$("#form1_images_arr").val(img_arr);
				$("#form2_images_arr").val(img_arr);
				$("#form3_images_arr").val(img_arr);
				$("#form4_images_arr").val(img_arr);
                                $("#form5_images_arr").val(img_arr);
                                $("#form6_images_arr").val(img_arr);
				
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
                                        $("#cov_img_form5").val('');
                                        $("#cov_img_form6").val('');
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
        var url = window.location.hostname === '<?php echo base_url() . 'admin/VideoUploads/index/'; ?>',
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
            acceptFileTypes: /(\.|\/)(mp4|flv|avi|webm|svi|m4v)$/i,
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
//				console.log(response.files[0].name);
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
                                $("#video_form5").val(img_arr);
                                $("#video_form6").val(img_arr);
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
			$("#error_span").html("Video Uploaded");		
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
				img_arr.splice(index, 1);
				var url = "<?php echo base_url(); ?>admin/classifieds/remove_video_uploaded";
				$.post(url, {value:$("#video_form1").val()}, function(response)
				{ });
				
				$("#video_form1").val(img_arr);
				$("#video_form2").val(img_arr);
				$("#video_form3").val(img_arr);
				$("#video_form4").val(img_arr);
                                $("#video_form5").val(img_arr);
                                $("#video_form6").val(img_arr);
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
	//alert(subval);
	show_sub_cat(val);
	
	<?php  if(isset($user_sub_category_id) && (int)$user_sub_category_id>0) { ?>
           show_sub_cat_fields("<?php echo $user_sub_category_id; ?>"); 
    <?php   } else { ?>    
    	show_sub_cat_fields(subval); 
    <?php } ?>	
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
                $("#sub_cat_form5").val("");
                $("#sub_cat_form6").val("");
		
		if($("#cat_id")!='')
			$("#cat_id_err").hide();				
			
		if($("#show_sub_category")=='')
			$("#subcat_id_err").show();				
		
		var userid  = '';
        <?php
            if(isset($_GET['userid'])) {
                ?>
                    var userid  = "<?php echo $_GET['userid']; ?>";
                <?php 
            }
            elseif($user_id!='') {
                ?>
                var userid  = "<?php echo $user_id; ?>";
                <?php 
            }
        ?>

		var url = "<?php echo base_url() ?>admin/classifieds/show_sub_cat";
		$.post(url, {value: val,sub_cat_id:<?php echo $product[0]['sub_category_id']; ?>,q:q,userid:userid}, function(data)
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

        var form = $("#form1");
        if(form.valid() == true)
            $('.loader_display').show();       	
		
		
    })
	$('#form2_submit').click(function(){
            var vehicle_pro_year = document.getElementById("vehicle_pro_year");
            if(vehicle_pro_year.value.length>0) {                
                if(vehicle_pro_year.value.length == 4){
                    $('#year_error').hide();
                }
                else
                {
                    $('#year_error').show();
                    $('#year_error').html('Please enter year in 4 digit');                
                    return false;
                }
            }
            
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

        var form = $("#form2");
        if(form.valid() == true)
            $('.loader_display').show();        
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

        var form = $("#form3");
        if(form.valid() == true)
            $('.loader_display').show();        
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

        var form = $("#form4");
        if(form.valid() == true)
            $('.loader_display').show();        
    })	
    
    $('#form5_submit').click(function(){
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form5").val(link);
		}
		var cat_id	=	$("#cat_id_form5").val();
		var subcat_id	=	$("#sub_cat_form5").val();
		
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

        var form = $("#form5");
        if(form.valid() == true)
            $('.loader_display').show();        
    })
    
    $('#form6_submit').click(function(){
		if($('#youtube_form').is(':checked')) {				
			var link	=	$("#my_youtube_link").val();
			$("#youtube_form6").val(link);
		}
		var cat_id	=	$("#cat_id_form6").val();
		var subcat_id	=	$("#sub_cat_form6").val();
		
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

        var form = $("#form6");
        if(form.valid() == true)
            $('.loader_display').show();        
    })
})

	function deletemainimg(prod_id,img_name) {
           
            $('#alert_message_action').html('Are you sure you want to delete Cover Image?');            
            var url = "<?php echo base_url() ?>admin/classifieds/removemainimage";
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if(val=='yes') {                    
                    $.post(url, {prod_id:prod_id}, function(data) {
                        window.location = "<?php echo $myredirect_path; ?>";  
                    });
                }
            });
	}
	
	function mydelete(val1,prod_id,img_name) {
        
            $('#alert_message_action').html('Are you sure you want to delete Image?'); 
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if(val=='yes') {
                    var url = "<?php echo base_url() ?>admin/classifieds/removeimage";
                    $.post(url, {value: val1,prod_id:prod_id}, function(data){                        
			window.location = "<?php echo $myredirect_path; ?>";  
                    });
                }
            });            
	}


	function mydeletevideo(prod_id,video)
	{            
            $('#alert_message_action').html('Are you sure you want to delete video?');
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if(val=='yes') {                    
                    var url = "<?php echo base_url() ?>admin/classifieds/removevideo";
                    $.post(url, {prod_id:prod_id,video:video}, function(data) {
                        window.location = "<?php echo $myredirect_path; ?>";  
                    });
                }
            });
	}
       
    $(document).on("keypress", ".price_txt", function (e) {             
        var charCode = (e.which) ? e.which : e.keyCode;
        if ((charCode >= 48 && charCode <= 57) || charCode == 188 || charCode == 190 || charCode == 46 || charCode == 8 || charCode == 37 || charCode == 39 || charCode == 44)
        return true;
        else
        return false;            
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/wysihtml5-0.3.0.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-wysihtml5.js"></script>
		
<script src="<?php echo site_url(); ?>assets/googleMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete"
async defer></script>
    </body>
</html>