<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/wysihtml5-0.3.0.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-wysihtml5.js"></script>
        <link href='<?php echo base_url(); ?>assets/admin/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
        <link rel="stylesheet" href="<?php echo site_url(); ?>/assets/front/stylesheets/file_upload_css/style.css">        
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/blueimp/blueimp-gallery.min.css">        
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-ui.css">
        <noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-noscript.css"></noscript>
        <noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-ui-noscript.css"></noscript>

        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/vendor/jquery.ui.widget.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/tmpl.min.js"></script>        
        <script src="<?php echo site_url(); ?>/assets/admin/javascripts/blueimp/load-image.all.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/canvas-to-blob.min.js"></script>       
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.iframe-transport.js"></script>       
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload.js"></script>        
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-process.js"></script>        
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-image.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-validate.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-ui.js"></script>        
	<link href="<?php echo base_url(); ?>assets/front/stylesheets/bootstrap-wysihtml5.css" media="all" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-select.min.js" type="text/javascript"></script>
        <style>
            canvas {display:none;}
            .modal-header{
                background-color:#ed1b33;
                color:white;
            }
        </style>	
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container--> 
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>
                        <div class="col-sm-12 main post__prod">

                            <?php $this->load->view('include/left-nav'); ?>
                            <div class="col-sm-9 post-prod ContentRight">
                                <?php if (validation_errors() != false) { ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo validation_errors(); ?>								
                                    </div>							
                                <?php } ?>
                                <?php if (isset($msg)): ?>
                                    <div class='alert  <?php echo $msg_class; ?>'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <center><?php echo $msg; ?></center>
                                    </div>
                                <?php endif; ?>
                                <h3>Edit your ad</h3>
                                <div class='box-content postadBG' >
                                    <div class='row' style="display:none;">
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
                                    <div class='row' style="display:none;">       
                                        <div class='form-group'>  
                                            <!--<label class='col-md-2 control-label text-right' for='inputText1'>Sub Category</label>-->                                                
                                            <div class="col-md-2 col-sm-3">Sub Category</div>
                                            <div class='col-md-6 col-sm-8 controls' id="sub_cat_list" style="padding: 0px 12px 14px 14px;">
                                                <select class="form-control" id="sub_cat1" name="sub_cat" >
                                                    <?php foreach ($sub_category1 as $cat): ?>
                                                        <option value="<?php echo $cat['sub_category_id']; ?>" <?php echo ($cat['sub_category_id'] == $product[0]['sub_category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                    <?php endforeach; ?>
                                                </select>                                    
                                                <label id="subcat_id_err" class="error" style="display:none;"><font color="#b94a48">This field is required.</font></label>	
                                            </div>
                                        </div>
                                    </div>
                                    <!--===================== DEFAULT FORM ======================-->


                                    <?php if ($product_type == 'default') { 
                                            $this->load->view('user/edit_forms/form1_default');
                                            
                                     } else if ($product_type == 'vehicle') { ?>
                                        <!--=========================== VEHICLE FORM =============================-->
                                     <?php
                                            $this->load->view('user/edit_forms/form2_vehicle');
                                        
                                     } elseif ($product_type == 'real_estate') { ?>
                                        <!--================= REAL ESTATE HOUSES FORM ===================-->
                                        <?php   
                                            $this->load->view('user/edit_forms/form3_realestate_1');
                                         ?>
                                        <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
                                        <?php   
                                            $this->load->view('user/edit_forms/form4_realestate_2');
                                         

                                     } elseif ($product_type == 'car_number') { ?>
                                        <!--  ===========================  Car Number    ===========================  - -->
                                    <?php
                                            $this->load->view('user/edit_forms/form5_car_number');

                                     } elseif ($product_type == 'mobile_number') { ?>				
                                        <!--  ===========================  Mobile Number    ===========================  - -->
                                    <?php    
                                            $this->load->view('user/edit_forms/form6_mobile_number');
                                     } ?>

                                    <form id="fileupload" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
                                        <h4><i class="fa fa-image"></i>Upload Media</h4>
                                        <hr />		
                                        <span id="error_img" style="color:red"></span>		
                                        <div class="form-group ">   			
                                            <?php
                                            if (isset($product[0]['product_image']) && !empty($product[0]['product_image'])):
                                            ?>
                                                <div class='form-group img-div005' style="display: inline-block;vertical-align: top;">

                                                    <div class='gallery'>                                                   
                                                        <ul class='list-unstyled list-inline'>
                                                            <li>
                                                                <div class='picture'>	

                                                                    <img alt="Product Image" src="<?php echo base_url() . product . "medium/" . $product[0]['product_image']; ?>" width="150px" height="150px"/>

                                                                    <div class='tags'>												
                                                                        <div class='label label-important'>
                                                                            <div class="star fav post_ad_star_fill" >
                                                                                <a href="#" ><?php $ext = explode(".", $product[0]['product_image']); ?>
                                                                                    <i class="fa fa-star" id="<?php echo $ext[0]; ?>" name="<?php echo $product[0]['product_image']; ?>" title="Set As Cover Image"></i>
                                                                                </a>
                                                                            </div>																						
                                                                            <a  class="delete_btn1" style="cursor:pointer;" onclick="javascript:deletemainimg('<?php echo $product[0]['product_id']; ?>', '<?php echo $product[0]['product_image'] ?>');"><i class="fa fa-trash" title="Delete Image"></i></a>
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
                                                    <?php foreach ($images as $i): ?>  
                                                        <li>                                                  
                                                            <div class='picture'>
                                                                <img alt="Product Image" src="<?php echo base_url() . product . "medium/" . $i['product_image']; ?>" width="150px" height="150px" alt="Image">								  
                                                                <div class='tags'>
                                                                    <div class='label label-important'>
                                                                        <div class="star fav">
                                                                            <a href="#"><?php $ext = explode(".", $i['product_image']); ?>
                                                                                <i class="fa fa-star-o" id="<?php echo $ext[0]; ?>" name="<?php echo $i['product_image']; ?>" value="<?php echo $i['product_image']; ?>" title="Set As Cover Image"></i>
                                                                            </a>
                                                                        </div>
                                                                        <!-- <input type="radio" name="<?php //echo $i['product_image'];       ?>" id="cov_img" title="Set Image as Cover Image" onclick="javascript:selet_cover_img('<?php //echo $i['product_image'];       ?>');" class="rd_cls" value="1"> -->
                                                                        <a style="cursor:pointer;" class="delete_btn1" onclick="javascript:mydelete('<?php echo $i['product_image_id']; ?>', '<?php echo $product[0]['product_id']; ?>', '<?php echo $i['product_image']; ?>');"><i class="fa fa-trash" title="Delete Image"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>                          
                                                        </li>      
                                                    <?php endforeach; ?>                        
                                                </ul>
                                                <?php } ?>
                                            </div>						
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class='form-group'>  
                                            <div class="fileupload-buttonbar row">
                                                <div class="col-md-2 col-sm-3">Upload Images</div>						
                                                <div class="col-md-8 col-sm-8">
                                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                                    <div class="upload-div ">
                                                        <span class="btn btn-success fileinput-button">
                                                            <i class="glyphicon glyphicon-plus"></i>
                                                            <span>Add files...</span>
                                                            <input type="file" name="files[]" multiple >
                                                        </span> <span class="restrict_msg">[Maximum 10 Images are allowed]</span>
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
                                            <div class="col-md-2 col-sm-3">Video</div>
                                            <div class="col-md-9 col-sm-8 mar-t-7 video-form-radio">
                                                <div class="col-md-4">
                                                <input type="radio" name="video_selection" id="youtube_form" onclick="javascript:show_hide(1);" <?php if (isset($product[0]['youtube_link']) && $product[0]['youtube_link'] != '') echo 'checked=checked'; ?>/>&nbsp;&nbsp;Youtube Link &nbsp;&nbsp;&nbsp;&nbsp;						</div>
                                                <div class="col-md-8">	
                                                    <input type="radio"  name="video_selection" id="video_form" onclick="javascript:show_hide(2);" <?php if (isset($product[0]['video_name']) && $product[0]['video_name'] != '') echo 'checked=checked'; ?>/>&nbsp;&nbsp;Upload Video<span class="restrict_msg">[Maximum 20 seconds video is allowed]</span>
                                                </div>
                                            </div>					
                                        </div>
                                        <div class="row form-group" style="margin-top:20px; <?php
                                        if (isset($product[0]['youtube_link']) && $product[0]['youtube_link'] != '')
                                            echo '';
                                        else
                                            echo 'display:none;';
                                        ?> " id="youtube_div">												
                                            <div class="col-md-2 col-sm-3">Youtube Link</div>
                                            <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="my_youtube_link" name="my_youtube_link" value="<?php if (isset($product[0]['youtube_link']) && $product[0]['youtube_link'] != '') echo $product[0]['youtube_link']; ?>"/></div>
                                        </div>
                                    </form>
                                    <form id="fileupload1" action="<?php echo base_url() . 'VideoUploads/index/'; ?>" method="POST" enctype="multipart/form-data">
                                        <span id="error_span" style="color:red"></span>												
                                        <div  id="video_div" style="<?php
                                        if (isset($product[0]['video_name']) && $product[0]['video_name'] != '')
                                            echo '';
                                        else
                                            echo 'display:none;';
                                        ?>">
                                            <div class="form-group" style="margin-top:20px;<?php
                                            if (isset($product[0]['video_name']) && $product[0]['video_name'] != '')
                                                echo '';
                                            else
                                                echo 'display:none;';
                                            ?>" >
                                                <!--<div class="col-md-2 col-sm-3">Upload Video</div>
                                                <div class="col-md-6 col-sm-8">
                                                <input type="file" class="form-control" id="video" name="video" /></div> -->
                                                <?php if ($product[0]['video_name'] != '') { ?>	
                                                    <div class="video-uploaded-div">
                                                        <video width="400" controls>									  
                                                            <source src="<?php echo base_url() . product. 'video/' . $product[0]['video_name']; ?>" type="video/webm">
                                                            <source src="<?php echo base_url() . product. 'video/' . $product[0]['video_name']; ?>" type="video/mp4">
                                                            <source src="<?php echo base_url() . product. 'video/' . $product[0]['video_name']; ?>" type="video/ogg">
                                                            <source src="<?php echo base_url() . product. 'video/' . $product[0]['video_name']; ?>" type="application/ogg">									  
                                                            Your browser does not support HTML5 video.
                                                        </video> <a style="cursor:pointer;" class="" onclick="javascript:mydeletevideo('<?php echo $product[0]['product_id']; ?>', '<?php echo $product[0]['video_name']; ?>');"><i class="fa fa-trash"></i></a>
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
                                            </div>	                                         </div>		
                                        <!--<button class="btn btn-primary" type="submit" id="btnContinue" name="btnContinue" disabled="disabled">Continue</button> -->
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
<div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header text-center orange-background">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    <i class="fa fa-close"></i>
                </button>
                <h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class='alert alert-info alert-dismissable'>						
                <center><span id="error_msg" >Image set as cover image successfully</span></center>
            </div>
        </div>
    </div>
</div>	  
<div id="loading" style="text-align:center" class="loader_display">
    <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
</div>
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %} 
    <tr class="template-upload fade"> 
    <td>
    <span class="preview">
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" alt="Product Image" ></a>     <button class="btn btn-warning cancel" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <i class="glyphicon glyphicon-ban-circle"></i>
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
    var url= '<?php echo base_url() . product . "medium/"; ?>';
    %}     <tr class="template-download fade" id="{%=btoa(file.name)%}">
    <td>
    <span class="preview"> 
    {% if (file.thumbnailUrl) { %} 
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" alt="Product Image" ></a>
    <div class="star fav post_ad_star upload_star" >
    <a href="#" ><i class="fa fa-star-o" id="{%=file.short_name%}" title="Set As Cover Image"></i></a>
    </div>			
    {% } else { %} 
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo site_url(); ?>assets/upload/dummyy-img.png" alt="Product Image"></a>
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
    <i class="glyphicon glyphicon-ban-circle"></i>
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

<div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">  
                <h4 class="modal-title">Confirmation
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </h4>                   
            </div>
            <div class="modal-body">                  
                <p>Are you sure you want to remove Image?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!--footer-->
<?php $this->load->view('include/footer'); ?>
</div>    
<script>
    
    $('.form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          return false;
        }
    });
  
    
    $(".total_stock").keydown(function (e) {    
        var set = 0;
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
    
    $(".total_stock").keydown(function (e) {
    
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||    
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||     
            (e.keyCode >= 35 && e.keyCode <= 40)) {                 
                 return;
        }
        
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
            var emirate_url = "<?php echo base_url(); ?>user/show_emirates_postadd";
            var plate_prefix_url = "<?php echo base_url(); ?>home/show_prefix";
            function show_sub_cat_fields (subval)  {

                    $("input[name='sub_cat']").val(subval);
                    if (subval != '')
                    $('#subcat_id_err').hide();
                    var cat_text = $('#cat_id').find('option:selected').text();


                if (cat_text == 'Real Estate'){
                    if (subval != 0) {

                    var sub_cat = $("#sub_cat1 option[value='" + subval + "']").text();
                    if (sub_cat == 'Houses - Apartments for Rent' || sub_cat == 'Houses - Apartments for Sale'){

                        $('.default_form').hide();
                        $('.vehicle_form').hide();
                        $('.real_estate').hide();
                        $('.car_number_form').hide();
                        $('.mobile_number_form').hide();
                        $('.real_estate_houses_form').show();
                        
                        $('#form_type').val('real_estate_houses_form'); 
                    } 

                    else if (sub_cat == 'Rooms for Rent - Shared' || sub_cat == 'Housing Swap' || sub_cat == 'Land' || sub_cat == 'Shops for Rent - Sale' || sub_cat == 'Office  -  Commercial Space'){

                    $('.default_form').hide(); 
                    $('.vehicle_form').hide();
                    $('.real_estate').hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $('.real_estate_shared_form').show();
                    $('#form_type').val('real_estate_shared_form');
                }
            } 
            else{
                    $(".default_form").hide();
                    $(".vehi cle_form").hide();
                    $(".real_ estate").hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').hide();
            }
            }
            else if (cat_text == 'Vehicles'){
                
            if (subval != 0){

            var sub_cat = $("#sub_cat1 option[value='" + subval + "']").text();
//                    console.log("helloo " + cat_text + "======" + sub_cat);
            if (sub_cat == 'Cars'){
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
            else{
                $(".real_estate").hide();
                $(".vehicle_form").hide();
                $('.car_number_form').hide();
                $('.mobile_ number_form').hide();
                $(".default_form").show();
                $("#form _type").val("default_form"); }
            }
            
        }
            else if (cat_text == 'Classifieds') {

            if (subval != 0) {

            var sub_cat = $("#sub_cat1 option[value='" + subval + "']").text();
                    if (sub_cat == 'Mobile Numbers') {

            $(".real_estate").hide();
                    $(".vehicle_form").hide();
                    $(".default_form").hide();
                    $('.car_number_form').hide();
                    $('.mobile_number_form').show();
                    $("#form_type").val("mobile_number_form");
            }
            }
            }
            else{
            $(".real_estate").hide();
                    $(".vehicle_form").hide();
                    $ ('.car_number_form').hide();
                    $('.mobile_number_form').hide();
                    $(".default_form").show();
                    $("#form_type").val("default_form");
            }
            }

    $("#vehicle_pro_year").datepicker({
        format: "yyyy",
        startView: 1,
        minViewMode: 2,
        endDate: '+1y'
    });
            function goBack()
            {
            window.history.back()
            }

    function show_emirates_form1(val) {
    var sel_city = $("#city_form1").val();
            $.post(emirate_url, {value: val, sel_city:sel_city}, function(data)
            {
            $("#city_form1").html("");
                    $("#city_form1 option").remove();
                    $("#city_form1").append(data);
            });
    }

    function show_emirates_form2(val)  {
    var sel_city = $("#city_form2").val();
            $.post(emirate_url, {value: val, sel_city:sel_city}, function(data)
            {
            $("#city_form2").html("");
                    $("#city_form2 option").remove();
                    $("#city_form2").append(data);
            });
    }

    function show_emirates_form3(val) {
    var sel_city = $("#city_form3").val();
            $.post(emirate_url, {value: val, sel_city:sel_city}, function(data)
            {
            $("#city_form3").html("");
                    $("#city_form3 option").remove();
                    $("#city_form3").append(data);
            });
    }

    function show_emirates_form4(val) {
    var sel_city = $("#city_form4").val(); $.post(emirate_url, {value: val, sel_city:sel_city}, function(data)
    {
    $("#city_form4").html("");
            $("#city_form4 option").remove();
            $("#city_form4").append(data);
    });
    }         function show_emirates_form5(val) {
    var sel_city = $("#city_form5").val();
            $.post(emirate_url, {value: val, sel_city:sel_city}, function(data)
            {
            $("#city_form5").html("");
                    $("#city_form5 option").remove();
                    $("#city_form5").append(data);
            });
    }
    function show_emirates_form6(val) {
    var sel_city = $("#city_form6").val();
            $.post(emirate_url, {value: val, sel_city:sel_city}, function(data)
            {
            $("#city_form6").html("");
                    $("#city_form6 option").remove();
                    $("#city_form6").append(data);
            });
    }   function show_prefix(val) {
    var sel_prefix = $("#plate_prefix").val();
            $.post(plate_prefix_url, {value: val, sel_prefix:sel_prefix}, function(data)
            {
            $("#plate_prefix").html("");
                    $("#plate_prefix option").remove();
                    $("#plate_prefix").append(data);
            });
    }           $("#video_form1").val("");
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
            
            $("#fileupload").on("click", "div.star > a  i ", function(e){
                e.preventDefault();
                var id = $(this).attr('id');
                var frm = $("#cov_img_form1").val();
                if (id != frm) {
                    $("#" + frm).removeClass("fa-star");
                    $("#" + frm).addClass("fa-star-o ");
                }
                
                $("#" + id).removeClass("fa-star-o");
                $("#" + id).addClass("fa-star");
                $("#cov_img_form1").val(id);
                $("#cov_img_form2").val(id);
                $("#cov_img_form3").val(id);
                $("#cov_img_form4").val(id);
                $("#cov_img_form5").val(id);
                $("#cov_img_form6").val(id);
                $("#send-message-popup").modal('show');
                return false;
            });
            function isNumber1(evt) {
            evt = (evt) ? evt : window.event;
                    var charCode = (evt.which) ? evt.which : evt.keyCode;
                    if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
            return false;
            }
            return true;
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
                            .text('Abort').on('click', function() {
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
//                            console.log(response.files[0].name); var table_content = $(".table .table-striped").html();
                            if (table_content != '') {
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
            node.prepend(file.preview);
            }
            if (file.error) {

            node.append('<br>').append($('<span class="text-danger"/>').text(''));
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
                    if (index > - 1) {                                                                 img_arr.splice(index, 1);
                    var url = "<?php echo base_url(); ?>user/remove_image_uploaded";
                    $.post(url, {all_data:$("#form1_images_arr").val(), not_to_delete:img_arr}, function(response)
                    { });
                    $("#form1_images_arr").val(img_arr); $("#form2_images_arr").val(img_arr);
                    $("#form3_images_arr").val(img_arr);
                    $("#form4_images_arr").val(img_arr);
                    $("#form5_images_arr").val(img_arr);
                    $("#form6_images_arr").val(img_arr);
                    var str = $("#form1_images_arr").val();
                    var arr = str.split(',');
                    var myval = $("#cov_img_form1").val();
                    var mydata = window.btoa(myval);
                    var chk_ = jQuery.inArray(mydata, arr);
                    if (chk_ == - 1)
            {
            $("#cov_img_form1").val('');
                    $("#cov_img_form2").val('');
                    $("#cov_img_form3").val('');
                    $("#cov_img_form4").val('');
                    $("#cov_img_form5").val('');
                    $("#cov_img_form6").val('');
            }
            }                                                                                                                                                 data.context.remove();
                    var table_content = $("#table_image").html();
                    if (table_content == '') {
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
//                    console.log(response.files[0].name);
                            $("#error_span").html("");
                            var table_content = $(".table .table-striped").html();
                            if (table_content != '') {
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
                    if (index > - 1) {
            var url = "<?php echo base_url(); ?>user/remove_video_uploaded";
                    $.post(url, {value:$("#video_form1").val()}, function(response)
                    { });
                    img_arr.splice(index, 1);
                    $("#video_form1").val(img_arr);
                    $("#video_form2").val(img_arr);
                    $("#video_form3").val(img_arr);
                    $("#video_form4").val(img_arr);
                    $("#video_form5").val(img_arr);
                    $("#video_form6").val(img_arr);
            }
            data.context.remove();
                    var table_content = $("#table_image1").html();
                    if (table_content == '') {
            //$("#update_div").hide();
            //$("#chk_del").hide();
            }
            return false;
            })
                    .prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
            });
            
            function mydelete(val1, prod_id) {
                
                $('#alert_message_action').html('Are you sure you want to delete Image?');                
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if(val=='yes') {
                        var url = "<?php echo base_url(); ?>user/removeimage";
                        $.post(url, {value: val1, prod_id:prod_id}, function(data) {                    
                            window.location = "<?php echo base_url(); ?>user/listings_edit/" + prod_id;
                        });
                    }
                });
            }
             function deletemainimg(prod_id) {
             
                $('#alert_message_action').html('Are you sure you want to delete Cover Image?');                
                    $("#deleteConfirm").modal('show');
                    $(document).on("click", ".yes_i_want_delete", function (e) {
                        var val = $(this).val();
                        if(val=='yes') {
                            var url = "<?php echo base_url(); ?>user/removemainimage";
                            $.post(url, {prod_id:prod_id}, function(data) {                
                                window.location = "<?php echo base_url(); ?>user/listings_edit/" + prod_id;
                            });
                        }
                });
            }
            
            function mydeletevideo(prod_id, video) {
                
                $('#alert_message_action').html('Are you sure you want to delete Video?');            
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if(val=='yes') {
                        var url = "<?php echo base_url(); ?>user/removevideo";
                        $.post(url, {prod_id:prod_id, video:video}, function(data) {
                            window.location = "<?php echo base_url(); ?>user/listings_edit/" + prod_id;
                        });
                    }
                });
            }
            

    var config = {
    support : "image/jpg,image/png,image/bmp,image/jpeg,image/gif", // Valid file formats
            form: "demoFiler", // Form ID
            dragArea: "dragAndDropFiles", // Upload Area ID
            upload_btn: "upload_btn", //upload button
            uploadUrl: "<?php echo base_url(); ?>uploads/index"             // Server side upload url
    }



    function show_model(val1) {
    var url = "<?php echo base_url(); ?>home/show_model";
            $.post(url, {value: val1}, function(data)
            {
            $("#pro_model option").remove();
                    $("#pro_model").append(data);
            });
    }

    $(function(){
        

    $('#form1_submit').click(function(){        

        if ($('#youtube_form').is(':checked')) {
            var link = $("#my_youtube_link").val();
            $("#youtube_form1").val(link);
        }

        var cat_id = $("#cat_id_form1").val();
        var subcat_id = $("#sub_cat_form1").val();
        
        if (cat_id == '')
        {
            $("#cat_id_err").show();
            return false;
        }
        else
            $("#cat_id_err").hide();

        if (subcat_id == '')
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
        if ($('#youtube_form').is(':checked')) {
        var link = $("#my_youtube_link").val();
                $("#youtube_form2").val(link);
        }
        var cat_id = $("#cat_id_form2").val();
                var subcat_id = $("#sub_cat_form2").val();
                if (cat_id == '')
        {
        $("#cat_id_err").show();
                return false;
        }
        else
                $("#cat_id_err").hide();
                if (subcat_id == '')
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
        if ($('#youtube_form').is(':checked')) {
        var link = $("#my_youtube_link").val();
                $("#youtube_form3").val(link);
        }
        var cat_id = $("#cat_id_form3").val();
                var subcat_id = $("#sub_cat_form3").val();
                if (cat_id == '')
        {
        $("#cat_id_err").show();
                return false;
        }
        else
                $("#cat_id_err").hide();
                if (subcat_id == '')
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
        if ($('#youtube_form').is(':checked')) {
        var link = $("#my_youtube_link").val();
                $("#youtube_form4").val(link);
        }
        var cat_id = $("#cat_id_form4").val();
                var subcat_id = $("#sub_cat_form4").val();
                if (cat_id == '')
        {
        $("#cat_id_err").show();
                return false;
        }
        else
                $("#cat_id_err").hide();
                if (subcat_id == '')
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
        if ($('#youtube_form').is(':checked')) {
        var link = $("#my_youtube_link").val();
                $("#youtube_form5").val(link);
        }
        var cat_id = $("#cat_id_form5").val();
                var subcat_id = $("#sub_cat_form5").val();
                if (cat_id == '')
        {
        $("#cat_id_err").show();
                return false;
        }
        else
                $("#cat_id_err").hide();
                if (subcat_id == '')
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

        if ($('#youtube_form').is(':checked')) {
        var link = $("#my_youtube_link").val();
                $("#youtube_form6").val(link);
        }
        var cat_id = $("#cat_id_form6").val();
                var subcat_id = $("#sub_cat_form6").val();
                if (cat_id == '')
        {
        $("#cat_id_err").show();
                return false;
        }
        else
                $("#cat_id_err").hide();
                if (subcat_id == '')
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

    var val = '<?php echo $category_id; ?>';
    var subval = '<?php echo $sub_category_id; ?>';
//            console.log(subval + "=====i m here");
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
                    var url = "<?php echo base_url(); ?>user/show_sub_cat";
                    $.post(url, {value: val}, function(data)
                    {
                    //alert(data);
                    $("#sub_cat_list").html(data);
                            // $("#sub_cat1").select2();
                    });
            }

    function del_video() {
    var img_arr = '';
            if ($("#video_form1").val() != '')
            img_arr = $("#video_form1").val();
            else if ($("#video_form2").val() != '')
            img_arr = $("#video_form2").val();
            else if ($("#video_form3").val() != '')
            img_arr = $("#video_form3").val();
            else if ($("#video_form4").val() != '')
            img_arr = $("#video_form4").val();
            else if ($("#video_form5").val() != '')
            img_arr = $("#video_form5").val();
            else if ($("#video_form6").val() != '')
            img_arr = $("#video_form6").val();
            if (img_arr != '') {
    var url = "<?php echo base_url(); ?>user/remove_image_selected";
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


    function show_hide(a) {
    if (a == 1) {
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
    
    $(document).on("keypress", ".price_txt", function (e) {             
        var charCode = (e.which) ? e.which : e.keyCode;
        if ((charCode >= 48 && charCode <= 57) || charCode == 188 || charCode == 190 || charCode == 46 || charCode == 8 || charCode == 37 || charCode == 39 || charCode == 44)
        return true;
        else
        return false;            
    });

$(document).find('.wysihtml5').wysihtml5();
</script>
<!--<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>-->
<script src="<?php echo HTTPS . website_url; ?>assets/googleMap.js"></script>
<?php if (!isset($exclude_map)) { ?>
    <script src="<?php echo HTTPS; ?>maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete"
    async defer></script>
<?php } ?>
</body>
</html>