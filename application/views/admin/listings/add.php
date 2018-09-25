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
                            </div>
                            <hr class="hr-normal">
                            <?php if (validation_errors() != false) { ?>
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
                                <?php
                                if (isset($_GET['userid']) && $_GET['userid'] != '') {
                                    $res = $this->db->query('select email_id,username from user where user_id=' . $_GET['userid'])->row();
                                    if (isset($res)) {
                                        echo 'Email ID: <u>' . $res->email_id . '</u><br>';
                                        echo 'Username: ' . $res->username;
                                    } else
                                        redirect('admin/classifieds/listings/');
                                }
                                ?>
                            </div>
                            <?php
                            if (isset($_GET['userid']) && $_GET['userid'] != '')
                                $redirect_url = base_url() . 'admin/classifieds/listings_add/?userid=' . $_GET['userid'];
                            else
                                $redirect_url = base_url() . 'admin/classifieds/listings_add/';

                            if(!empty($user_store_status) && $user_store_status==3)
                                    echo '<span style="color:red;">Note: You are trying to add new post for Hold Store, If you approve now but system will deactivate after its specified days (Mention in settings module)</span>';

                            ?>
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-plus'></div>
                                            Add Listing
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <div class="col-md-12">
                                            <?php if (isset($user_category_id) && (int) $user_category_id > 0) { ?>
                                            <div class='row' >
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Ad Type<span> *</span></label>
                                                <div class='col-md-5'>
                                                    <label class="radio radio-inline" style="margin-top:0px;margin-bottom:15px;">
                                                        <input type="radio" value="0" id="ad_type" name="ad_type" class="ad_type">
                                                        Classified Ad
                                                    </label>
                                                    <label class="radio radio-inline" style="margin-top:0px;margin-bottom:15px;">
                                                        <input type="radio" value="1" id="ad_type" name="ad_type" checked class="ad_type" >
                                                        Store Ad
                                                    </label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Category<span> *</span></label>
                                                <div class='col-md-5' style="padding: 0px 12px 14px 6px;">
                                                    <select class="select2 form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);" onload="show_sub_cat_load(this.value);" <?php
                                                    if (isset($user_category_id) && (int) $user_category_id > 0)
                                                        echo 'disabled=disabled';
                                                    ?>>
                                                        <option value="">Select Catagory</option>
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>" <?php
                                                            if (isset($_REQUEST['cat_id']))
                                                                echo set_select('cat_id', $cat['category_id'], TRUE);
                                                            elseif (isset($user_category_id) && (int) $user_category_id > 0 && $user_category_id == $cat['category_id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>
                                                                    ><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                                <?php endforeach; ?>                                                            
                                                    </select>                                                   
                                                    <label id="cat_id_err" class="error">This field is required.</label>
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Sub Category<span> *</span></label>
                                                <div class='col-md-5' id="sub_cat_list" style="padding: 0px 12px 14px 6px;">
                                                    <select class=" form-control" id="sub_cat" name="sub_cat" data-rule-required='true' <?php if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) echo 'disabled=disabled'; ?> >
                                                        <?php foreach ($sub_category as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>" <?php
                                                            if (isset($_REQUEST['sub_cat']))
                                                                echo set_select('sub_cat', $cat['sub_category_id'], TRUE);
                                                            elseif (isset($user_sub_category_id) && (int) $user_sub_category_id > 0)
                                                                echo set_select('sub_cat', $cat['sub_category_id'], TRUE);
                                                            ?> ><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                                <?php endforeach; ?>
                                                    </select>
                                                    <label id="subcat_id_err" class="error">This field is required.</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!--===================== DEFAULT FORM ======================-->
                                        <?php
                                        $this->load->view('admin/listings/add_forms/form1_default');
                                        ?>
                                        <!--=========================== VEHICLE FORM =============================-->
                                        <?php
                                        $this->load->view('admin/listings/add_forms/form2_vehicle');
                                        ?>
                                        <!--================= REAL ESTATE HOUSES FORM ===================-->
                                        <?php
                                        $this->load->view('admin/listings/add_forms/form3_realestate1');
                                        ?>
                                        <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
                                        <?php
                                        $this->load->view('admin/listings/add_forms/form4_realestate2');
                                        ?>
                                        <!--  ===========================  Car Number    ===========================  - -->
                                        <?php
                                        $this->load->view('admin/listings/add_forms/form5_car_number');
                                        ?>                                        
                                        <!--  ===========================  Mobile Number    ===========================  - -->
                                        <?php
                                        $this->load->view('admin/listings/add_forms/form6_mobile_number');
                                        ?> 
    <div class="loader_display" style="display:none;"></div>
                                        <form id="fileupload" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data" class='form form-horizontal validate-form' >
                                            <h4><i class="fa fa-image"></i>&nbsp;&nbsp;Upload Media</h4>
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

                                                    <input type="radio"  name="video_selection" id="video_form" onclick="javascript:show_hide(2);"/>&nbsp;&nbsp;Upload Video<span class="restrict_msg">[Maximum 20 seconds video is allowed]</span>
                                                </div>                  
                                            </div>
                                            <div class="row form-group" style="margin-top:20px; display:none;" id="youtube_div">
                                                <label class="col-md-2 col-sm-3 control-label">Youtube Link</label>
                                                <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="my_youtube_link" name="my_youtube_link"/></div>
                                            </div>
                                        </form>
                                        <form id="fileupload1" action="<?php echo base_url() . 'VideoUploads/index/'; ?>" method="POST" enctype="multipart/form-data">
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
                                            var url= '<?php echo base_url() . product . "medium/"; ?>';
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
                                            <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="<?php echo site_url(); ?>assets/upload/dummyy-img.png"></a>
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
        <a href="#" class="scrollup"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
        <script>
            var emirate_url = "<?php echo base_url(); ?>admin/classifieds/show_emirates_postadd";
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
    
            $(".ad_type").click(function() {

                var click_val = $(this).val();
                $('#form1_ad_type').val(click_val);
                $('#form2_ad_type').val(click_val);
                $('#form3_ad_type').val(click_val);
                $('#form4_ad_type').val(click_val);
                $('#form5_ad_type').val(click_val);
                $('#form6_ad_type').val(click_val);

                if($(this).val() == "0") {
                    
                    <?php  if (isset($user_category_id) && (int) $user_category_id > 0) { ?>
                        $('#cat_id').removeAttr("disabled");
                    <?php  }  
                            if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) { ?>
                                $('#sub_cat').removeAttr("disabled");
                    <?php  }  ?>
                 
                    $('.total_stock_div').hide();
                }
                else {                                            
                        
                    $("#cat_id").val('<?php echo $user_category_id; ?>');
                    $("#sub_cat").val('<?php echo $user_sub_category_id; ?>');

                    <?php  if (isset($user_category_id) && (int) $user_category_id > 0) { ?>                                
                                $('#cat_id').attr("disabled",'');
                    <?php  }  
                            if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) { ?>
                                $('#sub_cat').attr("disabled",'');
                    <?php  }  ?>

                    $('.total_stock_div').show();
                }

                show_sub_cat_load('<?php echo $user_category_id; ?>');
                show_sub_cat_fields('<?php echo $user_sub_category_id; ?>');

            });

            $('.loader_display').hide();

            $("#fileupload").on("click", "div.star > a  i ", function (e) {
                e.preventDefault();
                var id = $(this).attr('id');
                var frm = $("#cov_img_form1").val();
                if (id != frm) {
                    $("#" + frm).removeClass("fa-star");
                    $("#" + frm).addClass("fa-star-o");
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
                //jQuery("#send-message-popup").delay(2000).fadeOut("slow");
                return false;
            });
            var base_url = "<?php echo base_url(); ?>admin/";
            function selet_cover_img(a) {
                $("#cov_img_form1").val("");
                $("#cov_img_form2").val("");
                $("#cov_img_form3").val("");
                $("#cov_img_form4").val("");
                $("#cov_img_form5").val("");
                $("#cov_img_form6").val("");
                $("#cov_img_form1").val(a);
                $("#cov_img_form2").val(a);
                $("#cov_img_form3").val(a);
                $("#cov_img_form4").val(a);
                $("#cov_img_form5").val(a);
                $("#cov_img_form6").val(a);
                return false;
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
                    var url = "<?php echo base_url(); ?>admin/classifieds/remove_image_selected";
                    $.post(url, {value: img_arr}, function (response) {
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
                if (a == 1) {             //alert("1");                       
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
            $("#form5_images_arr").val("");
            $("#form6_images_arr").val("");
            $("#video_form1").val("");
            $("#video_form2").val("");
            $("#video_form3").val("");
            $("#video_form4").val("");
            $("#video_form5").val("");
            $("#video_form6").val("");
            /*jslint unparam: true, regexp: true */
            total_image = 0, current_image = 0;                             /*global window, $ */
            $(function () {
                'use strict';
                // Change this to the location of your server-side upload handler:
                var url = window.location.hostname === '<?php echo base_url() . 'admin/uploads/index/'; ?>',
                        uploadButton = $('<button/>')
                        .addClass('btn btn-primary')
                        .prop('disabled', true)
                        .text('Processing...')
                        .on('click', function () {
                            var $this = $(this),
                                    data = $this.data();
                            $this
                                    .off('click')
                                    .text('Abort')
                                    .on('click', function () {
                                        $this.remove();
                                        data.abort();
                                    });
                            data.submit().always(function () {
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
                    disableImageResize: /Android(?!.*Chrome)|Opera/.test(window.navigator.userAgent), previewMaxWidth: 100,
                    previewMaxHeight: 100,
                    messages: {
                        maxNumberOfFiles: 'Sorry, You can upload 10 Images,Please remove unneccessary files',
                    },
                    previewCrop: true,
                    success: function (response) {
                        $("#error_img").html("");
                        console.log(response.files[0].name);
                        var table_content = $(".table .table-striped").html();
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
                    error: function () {
                        console.log("Error");
                    }
                }).on('fileuploadadd', function (e, data) {
                    $("#error_img").html("");
                    data.context = $('<div/>').appendTo('#files');
                    $.each(data.files, function (index, file) {
                        var node = $('<p/>')
                                .append($('<span/>').text(file.name));
                        if (!index) {
                            node
                                    .append('<br>')
                                    .append(uploadButton.clone(true).data(data));
                        }
                        //node.appendTo(data.context);
                    });
                }).on('fileuploadprocessalways', function (e, data) {
                    $("#error_img").html("");
                    var index = data.index,
                            file = data.files[index],
                            node = $(data.context.children()[index]);
                    if (file.preview) {
                        node.prepend(file.preview);
                    }
                    if (file.error) {

                        node.append('<br>')
                                //.append($('<span class="text-danger"/>').text(file.error));
                                .append($('<span class="text-danger"/>').text(''));
                        $("#error_img").html(file.error);
                    }
                    if (index === data.files.length) {
                        data.context.find('button')
                                .text('Upload')
                                .prop('disabled', !!data.files.error);
                    }
                }).on('fileuploadprogressall', function (e, data) {
                    $("#error_img").html("");
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                            );
                }).on('fileuploaddone', function (e, data) {
                    $("#error_img").html("");
                    $.each(data.result.files, function (index, file) {
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
                }).on('fileuploadfail', function (e, data) {
                    $("#error_img").html("");
                    $.each(data.files, function (index) {
                        var error = $('<span class="text-danger"/>').text('File upload failed.');
                        $("#error_img").html('File upload failed.');
                        $(data.context.children()[index])
                                .append('<br>')
                                .append(error);
                    });
                }).on('fileuploaddestroy', function (e, data) {
                    $("#error_img").html("");
                    var index = img_arr.indexOf(data.context[0].id);
                    if (index > -1) {
                        img_arr.splice(index, 1);
                        var url = "<?php echo base_url(); ?>admin/classifieds/remove_image_uploaded";
                        $.post(url, {all_data: $("#form1_images_arr").val(), not_to_delete: img_arr}, function (response)
                        {
                        });
                        //alert(window.atob(img_arr));
                        $("#form1_images_arr").val(img_arr);
                        $("#form2_images_arr").val(img_arr);
                        $("#form3_images_arr").val(img_arr);
                        $("#form4_images_arr").val(img_arr);
                        $("#form5_images_arr").val(img_arr);
                        $("#form6_images_arr").val(img_arr);
                        //var str = img_arr;
                        var str = $("#form1_images_arr").val();
                        var arr = str.split(',');
                        //console.log("tetbox value: "+$("#cov_img_form1").val());
                        //console.log("array: "+arr);
                        var myval = $("#cov_img_form1").val();
                        var mydata = window.btoa(myval);
                        //console.log("mydata:"+mydata);
                        //window.btoa(str)
                        var chk_ = jQuery.inArray(mydata, arr);
                        if (chk_ == -1)
                        {
                            $("#cov_img_form1").val('');
                            $("#cov_img_form2").val('');
                            $("#cov_img_form3").val('');
                            $("#cov_img_form4").val('');
                            $("#cov_img_form5").val('');
                            $("#cov_img_form6").val('');
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
            $(function () {
                'use strict';
                // Change this to the location of your server-side upload handler:
                var url = window.location.hostname === '<?php echo base_url() . 'admin/VideoUploads/index/'; ?>',
                        uploadButton = $('<button/>')
                        .addClass('btn btn-primary')
                        .prop('disabled', true)
                        .text('Processing...')
                        .on('click', function () {
                            var $this = $(this),
                                    data = $this.data();
                            $this
                                    .off('click')
                                    .text('Abort')
                                    .on('click', function () {
                                        $this.remove();
                                        data.abort();
                                    });
                            data.submit().always(function () {
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
                    success: function (response) {
                        console.log(response.files[0].name);
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
                    error: function () {
                        //alert("here");
                        console.log("Error");
                    }
                }).on('fileuploadadd', function (e, data) {
                    $("#error_span").html("");
                    data.context = $('<div/>').appendTo('#files');
                    $.each(data.files, function (index, file) {
                        var node = $('<p/>')
                                .append($('<span/>').text(file.name));
                        if (!index) {
                            node
                                    .append('<br>')
                                    .append(uploadButton.clone(true).data(data));
                        }
                        //node.appendTo(data.context);
                    });

                }).on('fileuploadprocessalways', function (e, data) {
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
                }).on('fileuploadprogressall', function (e, data) {
                    $("#error_span").html("");
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                            );
                }).on('fileuploaddone', function (e, data) {
                    $("#error_span").html("Video Uploaded");
                    $.each(data.result.files, function (index, file) {
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
                }).on('fileuploadfail', function (e, data) {
                    $("#error_span").html("");
                    $.each(data.files, function (index) {
                        var error = $('<span class="text-danger"/>').text('File upload failed.');
                        $("#error_span").html('File upload failed.');
                        $(data.context.children()[index])
                                .append('<br>')
                                .append(error);
                    });
                }).on('fileuploaddestroy', function (e, data) {
                    $("#error_span").html("");
                    var index = img_arr.indexOf(data.context[0].id);
                    if (index > -1) {

                        var url = "<?php echo base_url(); ?>admin/classifieds/remove_video_uploaded";
                        $.post(url, {value: $("#video_form1").val()}, function (response)
                        {
                        });
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


            function isNumber1(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
                    return false;
                }
                return true;
            }

            $("#cat_id_err").hide();
            $("#subcat_id_err").hide();

            $(function () {
                $('#form1_submit').click(function () {
                    if ($('#youtube_form').is(':checked')) {
                        var link = $("#my_youtube_link").val();
                        $("#youtube_form1").val(link);
                    }

                    var cat_id = $("#cat_id_form1").val();
                    var subcat_id = $("#sub_cat_form1").val();

                    if (cat_id == '' || cat_id == '0') {
                        $("#cat_id_err").show();
                        $("#cat_id_err").focus();
                        return false;
                    }
                    else
                        $("#cat_id_err").hide();


                    if (subcat_id == '' || subcat_id == '0') {
                        $("#subcat_id_err").show();
                        return false;
                    }
                    $("#subcat_id_err").hide();

                    var form = $("#form1");
                    if(form.valid() == true)
                        $('.loader_display').show();
                })
                $('#form2_submit').click(function () {
                    
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

                    if (cat_id == '' || cat_id == '0') {
                        $("#cat_id_err").show();
                        return false;
                    }
                    else
                        $("#cat_id_err").hide();

                    if (subcat_id == '' || subcat_id == '0') {
                        $("#subcat_id_err").show();
                        return false;
                    }
                    else
                        $("#subcat_id_err").hide();

                    var form = $("#form2");
                    if(form.valid() == true)
                        $('.loader_display').show();
                })
                $('#form3_submit').click(function () {
                    if ($('#youtube_form').is(':checked')) {
                        var link = $("#my_youtube_link").val();
                        $("#youtube_form3").val(link);
                    }
                    var cat_id = $("#cat_id_form3").val();
                    var subcat_id = $("#sub_cat_form3").val();

                    if (cat_id == '' || cat_id == '0') {
                        $("#cat_id_err").show();
                        return false;
                    }
                    else
                        $("#cat_id_err").hide();

                    if (subcat_id == '' || subcat_id == '0') {
                        $("#subcat_id_err").show();
                        return false;
                    }
                    else
                        $("#subcat_id_err").hide();

                    var form = $("#form3");
                    if(form.valid() == true)
                        $('.loader_display').show();
                })
                $('#form4_submit').click(function () {
                    if ($('#youtube_form').is(':checked')) {
                        var link = $("#my_youtube_link").val();
                        $("#youtube_form4").val(link);
                    }
                    var cat_id = $("#cat_id_form4").val();
                    var subcat_id = $("#sub_cat_form4").val();

                    if (cat_id == '' || cat_id == '0') {
                        $("#cat_id_err").show();
                        return false;
                    }
                    else
                        $("#cat_id_err").hide();

                    if (subcat_id == '' || subcat_id == '0') {
                        $("#subcat_id_err").show();
                        return false;
                    }
                    else
                        $("#subcat_id_err").hide();

                    var form = $("#form4");
                    if(form.valid() == true)
                        $('.loader_display').show();
                })

                $('#form5_submit').click(function () {
                    if ($('#youtube_form').is(':checked')) {
                        var link = $("#my_youtube_link").val();
                        $("#youtube_form5").val(link);
                    }

                    var cat_id = $("#cat_id_form5").val();
                    var subcat_id = $("#sub_cat_form5").val();

                    if (cat_id == '' || cat_id == '0') {
                        $("#cat_id_err").show();
                        $("#cat_id_err").focus();
                        return false;
                    }
                    else
                        $("#cat_id_err").hide();


                    if (subcat_id == '' || subcat_id == '0') {
                        $("#subcat_id_err").show();
                        return false;
                    }
                    $("#subcat_id_err").hide();

                    var form = $("#form5");
                    if(form.valid() == true)
                        $('.loader_display').show();
                })

                $('#form6_submit').click(function () {
                    if ($('#youtube_form').is(':checked')) {
                        var link = $("#my_youtube_link").val();
                        $("#youtube_form6").val(link);
                    }

                    var cat_id = $("#cat_id_form6").val();
                    var subcat_id = $("#sub_cat_form6").val();

                    if (cat_id == '' || cat_id == '0') {
                        $("#cat_id_err").show();
                        $("#cat_id_err").focus();
                        return false;
                    }
                    else
                        $("#cat_id_err").hide();


                    if (subcat_id == '' || subcat_id == '0') {
                        $("#subcat_id_err").show();
                        return false;
                    }
                    $("#subcat_id_err").hide();

                    var form = $("#form6");
                    if(form.valid() == true)
                        $('.loader_display').show();
                })
            })

            var config = {
                support: "image/jpg,image/png,image/bmp,image/jpeg,image/gif", // Valid file formats
                form: "demoFiler", // Form ID
                dragArea: "dragAndDropFiles", // Upload Area ID
                upload_btn: "upload_btn", //upload button
                uploadUrl: "<?php echo base_url(); ?>uploads/index"             // Server side upload url
            }

            $("#vehicle_pro_year").datepicker({
                format: "yyyy",
                startView: 1,
                minViewMode: 2,
                endDate: '+0d'
            });
            var val = $('#cat_id').val();
            //show_sub_cat(val);
            var subval = $('#sub_cat').val();
            //alert(subval);
            show_sub_cat(val);




            //onload event
            function show_sub_cat_load(val) {

                $("input[name='cat_id']").val(val);
                $(".real_estate").hide();
                $(".vehicle_form").hide();
                $(".default_form").show();
                $("#form_type").val("default_form");

                if ($("#cat_id") != '')
                    $("#cat_id_err").hide();

                if ($("#show_sub_category") == '')
                    $("#subcat_id_err").show();

                var userid = '';
                var ad_type = '';

                <?php
                if (isset($_GET['userid'])) {
                    ?>
                            var userid = "<?php echo $_GET['userid']; ?>";
                            var ad_type = $('#form1_ad_type').val();
                    <?php
                }
                ?>

                var url = "<?php echo base_url(); ?>admin/classifieds/show_sub_cat";
                $.post(url, {value: val, userid: userid,ad_type:ad_type}, function (data) {
                    //alert(data);
                    $("#sub_cat_list").html(data);
                    
                     <?php if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) { ?>                             
                            if(ad_type=="1")
                                show_sub_cat_fields("<?php echo $user_sub_category_id; ?>");
                            else 
                                show_sub_cat_fields(0);                                                        
                    <?php } else { ?>
                                var subval = $('#sub_cat').val();
                                show_sub_cat_fields(subval);
                    <?php } ?>

                });
            }

            //onchange event
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

                if ($("#cat_id") != '')
                    $("#cat_id_err").hide();

                if ($("#show_sub_category") == '')
                    $("#subcat_id_err").show();

                var userid = '';
                var ad_type = '';

                <?php
                    if(isset($_GET['userid'])) {
                        ?>
                            var userid  = "<?php echo $_GET['userid']; ?>";
                            var ad_type = $('#form1_ad_type').val();
                        <?php
                    }
                ?>
                var url = "<?php echo base_url() ?>admin/classifieds/show_sub_cat";
                $.post(url, {value: val, userid: userid,ad_type:ad_type}, function (data)
                {
                    if ($("#sub_cat_list").html(data)) {
                        <?php if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) { ?>                            
                               show_sub_cat_fields("<?php echo $user_sub_category_id; ?>");
                        <?php } else { ?>                            
                               var subval = $('#sub_cat').val();
                               show_sub_cat_fields(subval);
                        <?php } ?>
                    }
                })
                        .done(function (data) {

                        })
                        ;
            }



            function show_model(val1)
            {
                <?php if (isset($_REQUEST['vehicle_pro_model'])) { ?>
                                    var sel_model = "<?php echo $_REQUEST['vehicle_pro_model']; ?>";
                <?php } else { ?>
                                    var sel_model = 0;
                <?php } ?>

                var url = "<?php echo base_url() ?>admin/classifieds/show_model";
                $.post(url, {value: val1}, function (data)
                {
                    $("#pro_model option").remove();
                    $("#pro_model").append(data);

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
<script src="https://doukani.com/assets/googleMap.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete" async defer></script>


    </body>
</html>