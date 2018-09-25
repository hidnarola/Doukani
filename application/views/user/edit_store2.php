<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>

        <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />
        <link href='<?php echo base_url(); ?>assets/front/dist/css/Open_Sans.css' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/front/images/favicon.ico" />

        <link href="<?php echo base_url(); ?>assets/front/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/responsive.css" rel="stylesheet">

        <link href='https://fonts.googleapis.com/css?family=Mrs+Sheppards&subset=latin,latin-ext' rel='stylesheet' type='text/css'>  
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/cropper.min.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/main.css">
        
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/switch_css/bootstrap-switch.css' rel='stylesheet' type='text/css' />
        <link href='<?php echo base_url(); ?>assets/front/stylesheets/switch_css/highlight.css' rel='stylesheet' type='text/css' />
<!--        <link href='<?php echo base_url(); ?>assets/front/stylesheets/switch_css/main.css' rel='stylesheet' type='text/css' />-->

        <script src="<?php echo base_url(); ?>assets/front/javascripts/swich_js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/swich_js/bootstrap-switch.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/swich_js/highlight.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/swich_js/main.js"></script>


        <style>
            .croppicModalObj {
                margin: 0px auto !important;
            }
            .bdate {
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
                color: #555;
                display: block;
                font-size: 14px;
                height: 34px;
                line-height: 1.42857;
                padding: 6px 12px;
                transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
                width: 100%;
            }       
            .modal-backdrop.fade.in {
                /*display:none; */
            }
            .modal-dialog {       
                width: 300px !important;
            }            
            .modal-header{
                background-color:#ed1b33;
                color:white;
            }
            #update_cost {margin-left:15px; width:92%; text-align:center !important;}
            .action
            {
                width: 400px;
                height: 30px;
                margin: 10px 0;
            }
            .cropped>img
            {
                margin-right: 10px;
            }
            .imageBox
            {
                position: relative;
                height: 400px;
                width: 400px;
                border:1px solid #aaa;
                background: #fff;
                overflow: hidden;
                background-repeat: no-repeat;
                cursor:move;
            }

            .imageBox .thumbBox
            {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 200px;
                height: 200px;
                margin-top: -100px;
                margin-left: -100px;
                box-sizing: border-box;
                border: 1px solid rgb(102, 102, 102);
                box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
                background: none repeat scroll 0% 0% transparent;
            }

            .imageBox .spinner
            {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0;
                text-align: center;
                line-height: 400px;
                background: rgba(0,0,0,0.7);
            }
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
                        <div class="col-sm-12 main dashboard">              
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>                     
                            <div class="col-sm-9 ContentRight">
                                <?php if (validation_errors() != false) { ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo validation_errors(); ?>
                                    </div>
                                <?php } ?>
                                <?php if (isset($msg) && !empty($msg)): ?>
                                    <div class='alert <?php echo $msg_class; ?> text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('flash_message') != ''): ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $this->session->flashdata('flash_message'); ?>
                                    </div>
                                <?php endif; ?>
                                <div class='alert alert-info text-center image-upload-alert' style="display:none;">
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    Your cover image will be visible in store once it's approved by Admin.
                                </div>
                                <?php $this->load->view('user/user_menu'); ?>
                                <!--//row-->
                                <div class="row profile coverimg">
                                    <?php
                                    $store_cover_image = '';
                                    if ($store[0]->store_cover_image != '')
                                        $store_cover_image = thumb_start_edit_store_cover.base_url() . store_cover . "medium/" . $store[0]->store_cover_image.thumb_end_edit_store_cover;
                                    else
                                        $store_cover_image = thumb_start_edit_store_cover.base_url() . 'assets/upload/store_cover_image.png'.thumb_end_edit_store_cover;
                                    ?>
                                    
                                    <div class="col-sm-12 text-center">   
                                        <form enctype="multipart/form-data" id="imageform" name="imageform" action="<?php echo site_url(); ?>user/store_cover_upload" style="z-index:0;">
                                            <label title="Upload image file" for="inputImage" class="btn btn-primary btn-upload">
                                                <input type="file" accept="image/*" name="file" id="inputImage" class="sr-only" onclick="clean();">
                                                <span title="" data-toggle="tooltip" class="docs-tooltip"><span class="fa fa-upload"></span>
                                            </label>
                                        </form> 
                                        <img src="<?php echo $store_cover_image; ?>" class="" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" id="upload_image" height="200px" width="1000px" alt="Stor eCover Image"/>
                                        <div class="cover-size-div">Recommend Size: 1920*440</div>
                                    </div>                                      
                                    <div class="col-sm-6 col-lg-4 store_status_toggle">
                                        <?php                                        
                                        if (!empty($store[0]->store_status) && $store[0]->store_status == '3')
                                            $checked = '';
                                        else
                                            $checked = 'checked';
                                        
                                        ?>
                                        <h2 class="h4">Store Status</h2>
                                        <p>
                                            <input id="switch-state" name="mystore_status" type="checkbox" on-label="Yes" off-label="no" <?php echo $checked; ?>>
                                        </p>                               
                                    </div>
                                    <div class="clearfix"></div> 
                                    <?php if($store[0]->category_id > 0 ) { ?>
                                    <div class="col-sm-6 col-lg-4 store_status_toggle updateshipping-cost">
                                           <a class="btn btn-blue red-btn" id="shipping_cost_btn">Update Shipping Cost</a>
                                    </div>
                                    <?php } ?>
                                    <div class="m-clear"></div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 left-pannerl-div-001"> 
                                        <form name="profile_form" id="profile_form" method="post" class="form form-horizontal " enctype="multipart/form-data"  action="<?php echo base_url(); ?>user/store">
                                            <div class="userupdateform">
                                                <div class="col-sm-6">
                                                    <h3><?php echo $store[0]->store_name; ?></h3>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Category</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <select class="form-control" id="category_id" name="category_id" disabled>
                                                                    <option value="0" <?php echo ($store[0]->category_id==0) ? 'selected' : ''; ?>>Store Website</option>  
                                                                <?php foreach ($category1 as $cat): ?>
                                                                    <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $store[0]->category_id) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>                                                
                                                    </div>
                                                    <?php if($store[0]->category_id > 0 ) { ?>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Sub Category</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input type="hidden" name="store_id" value="<?php echo $store[0]->store_id; ?>">
                                                            <select class="form-control" id="sub_category_id" name="sub_category_id" disabled>
                                                                <option value="">ALL</option>
                                                                <?php foreach ($sub_categories1 as $sub_cat): ?>
                                                                    <option value="<?php echo $sub_cat['sub_category_id']; ?>" <?php echo ($sub_cat['sub_category_id'] == $store[0]->sub_category_id) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $sub_cat['sub_category_name']); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>  
                                                    </div>
                                                    <?php } ?>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Store Name <span style="color:red;">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input placeholder='Store Name' class="form-control" name="store_name" id="store_name" type='text' value="<?php echo $store[0]->store_name; ?>" data-rule-required='true' maxlength="50" >
                                                             <span class="store_name_status"></span>

                                                            <input class="form-control" name="old_store_name"  id="old_store_name" type='hidden' value="<?php echo $store[0]->store_name; ?>" >
                                                        </div>
                                                    </div>
                                                    <?php if($store[0]->category_id > 0 ) { ?>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Store Description </label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <textarea cols="78" rows="5" class="form-control" name="store_description" id="store_description" ><?php echo $store[0]->store_description; ?></textarea>
                                                            <textarea class="form-control" name="old_store_description" id="old_store_description" style="display:none;" ><?php echo $store[0]->store_description; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Meta Title</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <input placeholder='Meta Title' class="form-control" name="meta_title" id="meta_title" type='text' value="<?php echo $store[0]->meta_title; ?>" maxlength="255">

                                                            <input class="form-control" name="old_meta_title" id="old_meta_title" type='hidden' value="<?php echo $store[0]->meta_title; ?>" >
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <label>Meta Description</label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <textarea cols="78" rows="5" class="form-control" 
                                                            name="meta_description" id="meta_description" ><?php echo $store[0]->meta_description; ?></textarea>
                                                            <textarea class="form-control" name="old_meta_description" id="old_meta_description" style="display:none;"><?php echo $store[0]->meta_description; ?></textarea>
                                                        </div>                                                
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <button name="submit" class="btn btn-blue red-btn edit-store-update" >Update</button>
                                                        </div>  
                                                    </div>
                                                </div>                                
                                            </div>
                                        </form>
                                    </div>                           
                                </div>
                            </div>
                        </div>
                        <!--//content-->
                    </div>
                </div>
                <div class="modal fade center" id="replyModal" tabindex="-1" role="dialog"  aria-hidden="true">      
                    <form id="cost_form" name="cost_form" method="post" action="<?php echo site_url().'user/update_shipping_cost'; ?>">
                    <div class="modal-dialog appup modal-md">
                        <div class="modal-content rounded">                     
                            <div class="modal-header">
                                <h4 class="modal-title"><i class="fa fa-money" aria-hidden="true"></i> Shipping Cost
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </h4>
                            </div>
                            <div class="modal-body">                    
                                <form>
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <label>Shipping Cost <span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="shipping_cost" id="shipping_cost" 
                                            value="<?php if(isset($__store[0]->shipping_cost) && sizeof($__store[0]->shipping_cost) > 0) echo $__store[0]->shipping_cost; ?>"  class="form-control" data-rule-required='true'><br>
                                    </div>
                                    </div>
                                    <button type="submit" name="update_cost" id="update_cost" class="form-control btn btn-blue red-btn" >Update</button>
                                </form>
                            </div>  
                        </div>
                    </div>
                </form>
            </div>
            <?php $this->load->view('include/footer'); ?>  
                

            </div>
<div id="loading" style="text-align:center" class="loader_display">
    <img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
</div>

<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
<link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/crop/jquery.form.js"></script>
<script src="<?php echo site_url(); ?>assets/front/javascripts/crop/cropper.min.js"></script>   
<script src="<?php echo site_url(); ?>assets/front/javascripts/crop/main.js"></script>
<script>
    
    var flag1 = 0;
    $(document).on("change", "#store_name", function (e) {
        var store_name = $(this).val();
        if(store_name) {
            $.ajax({
            type: 'post',
            url: '<?php echo site_url().'home/check_store_name' ?>',
            data: {
                store_name:store_name,user_id:'<?php echo $store[0]->store_owner; ?>'
            },
            success: function (response) {                  
                if(response=="OK") {
                   $('.store_name_status').html('');
                   flag1 = 0;
                   return true;
                }
               else {
                    flag1 = 1;
                    $('.store_name_status').html('<font color="#b94a48">'+response+'</font>');
                    return false;                               
                }
              }
            });
        }
        else {
           $( '.store_name_status' ).html("");
           return false;
        }
    });
        
    $(document).on("click", "#shipping_cost_btn", function (e) {
        $("#replyModal").modal('show');
    });

    $( "#profile_form" ).submit(function( event ) {
        
        if(flag1==1)
            return false;
        
        var form = $("#profile_form");
        if(form.valid() == true)
            $('.loader_display').show();     

        var store_name          = $('#store_name').val().trim();
        var store_description   = $('#store_description').text().trim();
        var meta_title          = $('#meta_title').val().trim();
        var meta_description    = $('#meta_description').text().trim();

        var old_store_name        = $('#old_store_name').val().trim();
        var old_store_description = $('#old_store_description').text().trim();
        var old_meta_title        = $('#old_meta_title').val().trim();
        var old_meta_description  = $('#old_meta_description').text().trim();
                
        if(store_name==old_store_name && store_description==old_store_description && meta_title==old_meta_title && meta_description==old_meta_description) {
            $('.loader_display').hide();
//            alert('You have not done any changes for update');
            $(document).find('.response_message').html('You have not done any changes for update.');
            $(document).find("#search_alert").modal('show');
            return false;
        }
        else 
            $("#profile_form").submit();        

    });

    var options = {
        onText: 'Active',
        offText: 'Hold'
    };

    $("[name='mystore_status']").bootstrapSwitch(options);

    $('input[name="mystore_status"]').on('switchChange.bootstrapSwitch', function (event, state) {
        $('.loader_display').show();
        if (state == true)
            var store_status = 0;
        else
            var store_status = 3;

        var url = "<?php echo base_url(); ?>user/update_store_status";
        $.post(url, {user_id:<?php echo $current_user[0]->user_id; ?>, store_id:<?php echo $store[0]->store_id; ?>, store_status: store_status}, function (response)
        {
            $('.loader_display').hide();
           
        });
    });

    function clean() {
        $('#inputImage').val('');
        $('#img_name').val('');
        $('#image').attr("src", "");
    }

    $('#inputImage').on('change', function (e)
    {
        //e.preventDefault();                   
        var img = $('#inputImage').val();

        $('.loader_display').show();

        strFine = img.substring(img.lastIndexOf('\\'));

        var ext = strFine.split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            $('#inputImage').val('');            
            $(document).find('.response_message').html('Invalid File');
            $(document).find("#search_alert").modal('show');
        }
        else {

            $("#imageform").ajaxForm({
                success: function (responseText) {
                    $('#upload_image').attr("src", "<?php echo site_url() . store_cover; ?>medium/" + responseText);
                    $('.image-upload-alert').show();                    
                    $('.loader_display').hide();
                }
            }).submit();
        }
    });

    var val = $("#location").val();

    $(document).on("keypress keyup focusin blur cut paste", "#store_domain", function (e) {
        //$("#store_domain").keypress(function() {            
        $('#full_domain').html('');
        $('#full_domain').html($('#store_domain').val() + '.doukani.com');
    });

    $(document).on("keypress", "#shipping_cost", function (e) {                
        var charCode = (e.which) ? e.which : e.keyCode;
        if ((charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 46)
            return true;
        else
            return false;
    });
    
    $("#cost_form").validate({
        rules: {
            report: "required"            
        },
        messages: {
            report: "Please enter Shipping Cost"
        },
        submitHandler: function (form) {
            $("#replyModal").modal('hide');
            form.submit();
        }
    });
            </script>
    </body>
</html>