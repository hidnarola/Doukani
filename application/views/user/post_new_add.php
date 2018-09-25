<link href="<?php echo base_url(); ?>assets/front/stylesheets/bootstrap-tour/bootstrap-tour.css" rel="stylesheet">    
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/bootstrap-tour/bootstrap-tour-standalone.css" rel="stylesheet">        
<?php $this->load->view('include/head'); ?>
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
        <!-- The basic File Upload plugin -->
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload.js"></script>        
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-process.js"></script>        
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-image.js"></script>        
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-validate.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-ui.js"></script>        
	<link href="<?php echo base_url(); ?>assets/front/stylesheets/bootstrap-wysihtml5.css" media="all" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-tour/bootstrap-tour.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-tour/bootstrap-tour-standalone.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-select.min.js" type="text/javascript"></script>
<style>
    .custome span.glyphicon {width:14px; height:14px; float:right; display:block !important; position:relative !important; right:0 !important;}
    /*.yellow .glyphicon { background:yellow; }*/
    .black { background:black;}
    .red { background:red; }
    .glyphicon-ok::before{ display:none;}
    .custome.bootstrap-select.btn-group .dropdown-menu li { display:inline-block; position:relative; vertical-align:top; width:100%; right:0;}
    .custome .dropdown-menu > li > a { display:inline-block; vertical-align:top; width:100%; height:auto;}
    .custome.bootstrap-select.btn-group .dropdown-menu li a span.text { float:left;}
    select.selectpicker {display: visible !important;}
</style>


<!--<script src="<?php echo base_url(); ?>js/blueimp/main.js"></script>-->
<div class="container-fluid">	
    <?php $this->load->view('include/header'); ?>
    <?php $this->load->view('include/menu'); ?>    

    <div class="page">
        <div class="container">
            <div class="row">
                <!--header-->
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
                        <h3>Post Your Ad</h3>
                        <div class='box-content postadBG tour-step-backdrop' id="form_sections">  <!-- registration_main--> 
                            <div>
                                <div class='row'>
                                    <div class='form-group' <?php if (isset($user_category_id) && (int) $user_category_id > 0) echo 'style="display:none;"'; ?>>  
                                        <div class="col-md-2 col-sm-3">Category <span> *</span></div>					
                                        <div class='col-md-6 col-sm-8' style="padding: 0px 12px 14px 14px;">
                                            <select class="select2 form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);" onload="show_sub_cat_load(this.value);">
                                                <option value="">Select Category</option>
                                                <?php foreach ($category as $cat): ?>
                                                    <option value="<?php echo $cat['category_id']; ?>" <?php
                                                    if (isset($user_category_id) && (int) $user_category_id > 0 && $user_category_id == $cat['category_id'])
                                                        echo 'selected=selected';
                                                    elseif (isset($_REQUEST['cat_id']) && (int) $_REQUEST['cat_id'] > 0 && $_REQUEST['cat_id'] == $cat['category_id'])
                                                        echo 'selected=selected';
                                                    ?> ><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                            </select>
                                            <label id="cat_id_err" class="error">This field is required.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>       
                                    <div class='form-group' <?php if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) echo 'style="display:none;"'; ?>> 
                                        <!--<label class='col-md-2 control-label text-right' for='inputText1'>Sub Category</label>-->
                                        <div class="col-md-2 col-sm-3">Sub Category <span> *</span></div>
                                        <div class='col-md-6 col-sm-8' id="sub_cat_list" style="padding: 0px 12px 14px 14px;">
                                            <select class="select2 form-control" id="show_sub_category" name="show_sub_category" >
                                                <option value="">Select Sub Category</option>							
                                                <?php foreach ($sub_category as $cat): ?>
                                                    <option value="<?php echo $cat['sub_category_id']; ?>"  <?php
                                                    if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0)
                                                        echo set_select('sub_cat', $cat['sub_category_id'], TRUE);
                                                    elseif (isset($_REQUEST['sub_cat']))
                                                        echo set_select('sub_cat', $cat['sub_category_id'], TRUE);
                                                    ?>><?php echo $cat['sub_category_name']; ?></option>
                                                        <?php endforeach; ?>

                                            </select>                                            					
                                        </div>			
                                        <label id="subcat_id_err" class="error">This field is required.</label>
                                    </div>
                                </div>
                                <!--===================== DEFAULT FORM ======================-->		

                                <?php $this->load->view('user/add_forms/form1_default'); ?>
                                <!--=========================== VEHICLE FORM =============================-->

                                <?php $this->load->view('user/add_forms/form2_vehicle'); ?>

                                <!--================= REAL ESTATE HOUSES FORM ===================-->

                                <?php $this->load->view('user/add_forms/form3_realeaste_1'); ?>

                                <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->

                                <?php $this->load->view('user/add_forms/form4_realestate_2'); ?>

                                <!--  ===========================  Car Number    ===========================  - -->
                                <?php $this->load->view('user/add_forms/form5_car_number'); ?>

                                <!--  ===========================  Mobile Number    ===========================  - -->
                                <?php $this->load->view('user/add_forms/form6_mobile_number'); ?>         

                                <form id="fileupload" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
                                    <h4><i class="fa fa-image"></i>Upload Media</h4>
                                    <hr />		
                                    <span id="error_img"></span>		
                                    <div class="fileupload-buttonbar row">
                                        <div class="col-md-2 col-sm-3">Upload Images</div>     
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
                                    <!-- The table listing the files available for upload/download -->
                                    <div class="col-md-8">
                                        <table role="presentation" class="table table-striped"><tbody class="files" id="table_image"></tbody></table>					
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                                <form  class='form form-horizontal validate-form'>
                                    <div class='form-group'>     
                                        <div class="col-md-2 col-sm-3">Video</div>                      
                                        <div class="col-md-9 col-sm-8 video-form-radio">
                                            <div class="col-md-4">
                                                <input type="radio" name="video_selection" id="youtube_form" onclick="javascript:show_hide(1);"/>&nbsp;&nbsp;Youtube Link &nbsp;&nbsp;&nbsp;&nbsp;                                                                                           </div>
                                            <div class="col-md-8">
                                                <input type="radio"  name="video_selection" id="video_form" onclick="javascript:show_hide(2);"/>&nbsp;&nbsp;Upload Video <span class="restrict_msg">[Maximum 20 seconds video is allowed]</span>
                                            </div>
                                        </div>					
                                    </div>
                                    <div class="row form-group" style="margin-top:20px; display:none;" id="youtube_div">
                                        <div class="col-md-2 col-sm-3">Youtube Link</div>
                                        <div class="col-md-6 col-sm-8"><input type="text" class="form-control" id="my_youtube_link" name="my_youtube_link"/></div>
                                    </div>
                                </form>
                                <form id="fileupload1" action="<?php echo base_url() . 'VideoUploads/index/'; ?>" method="POST" enctype="multipart/form-data">
                                    <span id="error_span"></span>						
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
                            </div>
                        </div>
                    </div>	
                </div>
            </div>	
        </div>
    </div>
</div>
</div>			
<div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-hidden="true">
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
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" alt="Product Image"></a>
    <button class="btn btn-warning cancel" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
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

<script id="template-download" type="text/x-tmpl">	.
            
    {% for (var i=0, file; file=o.files[i]; i++) {  
    var url= '<?php echo base_url() . product . "medium/"; ?>';
    %}
    <tr class="template-download fade" id="{%=btoa(file.name)%}">
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
    {% }  %}      {% } else { %} 
                                                                <button class="btn btn-warning delete">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span style="display:none;">Cancel</span>
    </button>
    <!--<button class="btn btn-warning delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span style="display:none">Cancel</span>     </button> -->
    {% } %}					     </span>     
    </td> 
    <td style="display:none">
    <p class="name">        {% if (file.url) {  %}      
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %} 
    <span>{%=file.name%}</span>
    {% } %} 
    </p>
                                                                        {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>     <td style="display:none">     <span class="size" >{%=o.formatFileSize(file.size)%}</span>
    </td>             
    </tr> 
    {% } %}    
</script>                                                                                                      <?php $this->load->view('include/footer'); ?>
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
        var emirate_url = "<?php echo base_url(); ?>user/show_emirates_postadd";
        var plate_prefix_url = "<?php echo base_url(); ?>home/show_prefix";
        function show_sub_cat_fields(subval) {

                $("input[name='sub_cat']").val(subval); if (subval != '')
        $('#subcat_id_err').hide();
        var cat_text = $('#cat_id').find('option:selected').text();
                if (cat_text == 'Real Estate'){
                if (subval != 0){

                var sub_cat = $("#show_sub_category option[value='" + subval + "']").text();
        if (sub_cat == 'Houses - Apartments for Rent' || sub_cat == 'Houses - Apartments for Sale'){

        $('.default_form').hide(); $('.vehicle_form').hide();
        $('.real_estate').hide();
                $('.car_number_form').hide(); $('.mobile_number_form').hide();
        $('.real_estate_houses_form').show();                
                $('#form_type').val('real_estate_houses_form');
                } else if (sub_cat == 'Rooms for Rent - Shared' || sub_cat == 'Housing Swap' || sub_cat == 'Land' || sub_cat == 'Shops for Rent - Sale' || sub_cat == 'Office - Commercial Space'){

                $('.default_form').hide();
                $('.vehicle_form').hide();
        $('.real_estate').hide();
        $('.car_number_form').hide();
        $('.mobile_number_form').hide(); $('.real_estate_shared_form').show();
                $('#form_type').val('real_estate_shared_form'); }                                                         } else{                                                         $(".default_form").hide();
                $(".vehicle_form").hide(); $(".real_estate").hide();
                $('.car_number_form').hide();
        $('.mobile_number_form').hide();
}
        } else if (cat_text == 'Vehicles'){

                if (subval != 0){

                var sub_cat = $("#show_sub_category option[value='" + subval + "']").text();
        if (sub_cat == 'Cars'){
                $(".default_form").hide();
                $(".real_estate").hide();
        $('.car_number_form').hide();
        $('.mobile_number_form').hide(); $('.real_estate_shared_form').hide();
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
        if (subval != 0){

                var sub_cat = $("#show_sub_category option[value='" + subval + "']").text();
                if (sub_cat == 'Mobile Numbers') {

                $(".real_estate").hide();
                $(".vehicle_form").hide();
                $(".default_form").hide();
        $('.car_number_form').hide();
        $('.mobile_number_form').show();
        $("#form_type").val("mobile_number_form");
}
                else{
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
else{

$(".real_estate").hide();
        $(".vehicle_form").hide();
        $('.car_number_form').hide();
        $('.mobile_number_form').hide();
                $(".default_form").show();
                $("#form_type").val("default_form");
}
        }

    $("#vehicle_pro_year").datepicker({
        format: "yyyy",
        startView: 1,
        minViewMode: 2,
        endDate: '+0d'
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

                function show_emirates_form2(val) {
varsel_city = $("#city_form2").val();
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
        var sel_city = $("#city_form4").val();
        $.post(emirate_url, {value: val, sel_city:sel_city}, function(data)
                {
                $("#city_form4").html("");
        $("#city_form4 option").remove();
$("#city_form4").append(data);
});
}

function show_emirates_form5(val) {
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
}

        function show_prefix(val) {
var sel_prefix = $("#plate_prefix").val();
$.post(plate_prefix_url, {value: val, sel_prefix:sel_prefix}, function(data)
{
        $("#plate_prefix").html("");
        $("#plate_prefix option").remove();
        $("#plate_prefix").append(data);
});
}

        $("#fileupload").on("click", "div.star > a  i ", function(e){
e.preventDefault();
var id = $(this).attr('id');
var frm = $("#cov_img_form1").val();
if (id != frm) {
        $("#" + frm).removeClass("fa-star");
        $("#" + frm).addClass("fa-star-o");
}
        //alert("call");

        //alert(id);
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
else if ($("#video_form2").val() != '')                                                         img_arr = $("#video_form2").val();
else if ($("#video_form3").val() != '')
img_arr = $("#video_form3").val();
else if ($("#video_form4").val() != '')
img_arr = $("#video_form4").val();
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

function show_hide(a){
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
//                console.log(response.files[0].name);
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
                   if (index > - 1) {
           img_arr.splice(index, 1);
                   var url = "<?php echo base_url(); ?>user/remove_image_uploaded";
                   $.post(url, {all_data:$("#form1_images_arr").val(), not_to_delete:img_arr}, function(response)
               { });
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
                   if (chk_ == - 1)
           {
           $("#cov_img_form1").val('');
                   $("#cov_img_form2").val('');
                   $("#cov_img_form3").val('');
                   $("#cov_img_form4").val('');
                   $("#cov_img_form5").val('');
                   $("#cov_img_form5").val('');
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
//                   console.log(response.files[0].name);
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
           var error = '';
                   $.each(data.result.files, function(index, file) {
                       if(typeof file.error !== 'undefined' && file.error != ''){
                       error += "<br>"+file.error;
                   }
//                   if (file.url) {
//                   var link = $('<a>')
//                           .attr('target', '_blank')
//                           .prop('href', file.url);
//                           $(data.context.children()[index])
//                           .wrap(link);
//                   } else if (file.error) {
//                   var error = $('<span class="text-danger"/>').text(file.error);
//                           $("#error_span").html(file.error);
//                           $(data.context.children()[index])
//                           .append('<br>')
//                           .append(error);
//                   }
                   });
                   
                  if(error == ''){
                      error = 'Video Uploaded!';
                  }
                  $("#error_span").html(error);
                   
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
           img_arr.splice(index, 1);
                   var url = "<?php echo base_url(); ?>user/remove_video_uploaded";
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


        // function isNumber(evt) {
        $(document).on("keypress", ".price_txt", function (e) {             
            var charCode = (e.which) ? e.which : e.keyCode;
            if ((charCode >= 48 && charCode <= 57) || charCode == 188 || charCode == 190 || charCode == 46 || charCode == 8 || charCode == 37 || charCode == 39 || charCode == 44)
            return true;
            else
            return false;            
        });

        $("#cat_id_err").hide();
        $("#subcat_id_err").hide();

    $(function(){
        $('#form1_submit').click(function(){
            
            if ($('#youtube_form').is(':checked')) {
                var link = $("#my_youtube_link").val();
                $("#youtube_form1").val(link);
            }

                var cat_id = $("#cat_id_form1").val();
                var subcat_id = $("#sub_cat_form1").val();
                if (cat_id == '' || cat_id == '0') {
                $("#cat_id_err").show();
                return false;
            }
            else
                    $("#cat_id_err").hide();
                    if (subcat_id == '' || subcat_id == '0'){
                    $("#subcat_id_err").show();
                            return false;
                    }
            else
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
                    if (cat_id == '' || cat_id == '0') {
            $("#cat_id_err").show();
                    return false;
            }
            else
                    $("#cat_id_err").hide();
                    if (subcat_id == '' || subcat_id == '0'){
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
                    if (cat_id == '' || cat_id == '0'){
            $("#cat_id_err").show();
                    return false;
            }
            else
                    $("#cat_id_err").hide();
                    if (subcat_id == '' || subcat_id == '0'){
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
                    if (cat_id == '' || cat_id == '0'){
            $("#cat_id_err").show();
                    return false;
            }
            else
                    $("#cat_id_err").hide();
                    if (subcat_id == '' || subcat_id == '0'){

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
                    if (cat_id == '' || cat_id == '0'){
            $("#cat_id_err").show();
                    return false;
            }
            else
                    $("#cat_id_err").hide();
                    if (subcat_id == '' || subcat_id == '0'){

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
                    if (cat_id == '' || cat_id == '0'){
            $("#cat_id_err").show();
                    return false;
            }
            else
                    $("#cat_id_err").hide();
                    if (subcat_id == '' || subcat_id == '0'){

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

        var val = $('#cat_id').val();        
        show_sub_cat(val);
        var sub_val = $('#sub_cat_list').find('#show_sub_category').val();
        $("input[name='sub_cat']").val(sub_val);
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
                var url = "<?php echo base_url(); ?>user/show_sub_category";
                $.post(url, {value: val}, function(data) {
                //alert(data);
                $("#sub_cat_list").html(data);
                        // $("#sub_cat").select2();
                });
        }

//on change event
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
        if ($("#cat_id") != '')
        $("#cat_id_err").hide();
        if ($("#show_sub_category") == '')
        $("#subcat_id_err").show();
        var url = "<?php echo base_url(); ?>user/show_sub_category";
        $.post(url, {value: val}, function(data) {
        //alert(data);			
        if ($("#sub_cat_list").html(data)) {

<?php if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) { ?>
                        show_sub_cat_fields("<?php echo $user_sub_category_id; ?>");
<?php } else { ?>
                        show_sub_cat_fields(subval);
<?php } ?>
        }

        // $("#sub_cat").select2();
        });
}
var val = $('#cat_id').val();
        var subval = $('#sub_cat').val();
        show_sub_cat(val);
        //show_sub_cat_fields(subval);

                function show_model(val1){
<?php if (isset($_REQUEST['vehicle_pro_model'])) { ?>
                                var sel_model = "<?php echo $_REQUEST['vehicle_pro_model']; ?>";
<?php } else { ?>
                                var sel_model = 0;
<?php } ?>
                var url = "<?php echo base_url(); ?>user/show_model";
                        $.post(url, {value: val1, sel_model:sel_model}, function(data)
                        {
                        $("#pro_model").html("");
                                $("#pro_model option").remove();
                                $("#pro_model").append(data);
                        });
                }
                
        

    $(document).find('.wysihtml5').wysihtml5();
            $(document).ready(function () {
            // Instance the tour
                var tour = new Tour({
                  name: "tour1",
                  container: "body",
                  keyboard: true,
                  backdrop: false,
                  basePath: "",
                });
            // Add your steps. Not too many, you don't really want to get your users sleepy
            tour.addSteps([
              {
                element: "#form_sections",
                title: "Add New Post",
                content: "Share,Sell your Old/New things",
                placement: 'top',
                backdrop: true,
              }
            ]);
            tour.init();
            tour.start();
        });
</script>
<script src="<?php echo HTTPS . website_url; ?>assets/googleMap.js"></script>
<?php if (!isset($exclude_map)) { ?>
    <script src="<?php echo HTTPS; ?>maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete"
    async defer></script>
<?php } ?>