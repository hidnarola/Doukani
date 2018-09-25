<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />        
        <link href='<?php echo base_url(); ?>assets/front/dist/css/Open_Sans.css' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="<?php echo static_image_path; ?>favicon.ico" />             

        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/cropper.min.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/main.css">  

        <script src="<?php echo base_url(); ?>assets/front/dist/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap.min.js"></script>        
        <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap-switch.js"></script>    
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/demo.js" type="text/javascript"></script>
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-sm-12'>
                            <div class='page-header'>
                                <h1 class='pull-left'>
                                    <i class='icon-user'></i>
                                    <span>User profile</span>
                                </h1>
                                <div class='pull-right'>
                                    <ul class='breadcrumb'>
                                        <li>                                          
                                            <i class='icon-bar-chart'></i>
                                        </li>
                                        <li class='separator'>
                                            <i class='icon-angle-right'></i>
                                        </li>
                                        <li>User</li>
                                        <li class='separator'>
                                            <i class='icon-angle-right'></i>
                                        </li>
                                        <li class='active'>profile</li>
                                    </ul>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                             <?php if(validation_errors() != false) { ?>
                            <div class='alert alert-info text-center'>
                                <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                <?php echo validation_errors(); ?>                              
                            </div>                          
                            <?php } ?>
                            <div class='row'>
                                <div class='col-sm-3 col-lg-2'>
                                    <div class='box'>
                                        <div class='box-content'>
                                            <?php
                                                if (!empty($user[0]->profile_picture))
                                                    $profile_image = base_url() . profile . "original/" . $user[0]->profile_picture;
                                                else
                                                    $profile_image = base_url() . "assets/upload/avtar.png";
                                                ?>

                                            <div id='preview' style="cursor: pointer; z-index:-100;">
                                                <img class="img-responsive" alt="<?php echo $user[0]->username; ?>" id="exist" src="<?php echo $profile_image; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"/>
                                            </div>
                                            <form enctype="multipart/form-data" id="imageform" name="imageform" >                              
                                                <label title="Upload image file" for="inputImage" class="btn btn-primary btn-upload"><input type="file" accept="image/*" name="file" id="inputImage" class="sr-only" ><span title="" data-toggle="tooltip" class="docs-tooltip"><span class="fa fa-upload"></span></span>
                                                </label>
                                            </form>
                                                
                                        </div>
                                    </div>
                                </div>
                                <div class='col-sm-9 col-lg-10 box'>
                                    <div class='box-content box-double-padding'>
                                        <form action='<?php echo base_url(); ?>admin/users/profile' class='validate-form' method='post' enctype="multipart/form-data">
                                            <fieldset>
                                                <div class='col-sm-4'>
                                                    <div class='lead'>
                                                        <i class='icon-github text-contrast'></i>
                                                        Login info
                                                    </div>
                                                    <small class='text-muted'>
                                                        User's login information to access classified application, 
                                                        They will be able to add, edit, view, and delete all information.
                                                    </small>
                                                </div>
                                                <div class='col-sm-7 col-sm-offset-1'>
                                                    <div class='form-group'>
                                                        <label>Username</label>
                                                        <input class='form-control' name="username" id='username' placeholder='Username' type='text' value="<?php echo $user[0]->username; ?>" data-rule-required='true' >
                                                    </div>
                                                    <div class='form-group'>
                                                        <label>Nickname</label>
                                                        <input class='form-control' name="nick_name" id='nick_name' placeholder='Nickname' type='text' value="<?php echo $user[0]->nick_name; ?>" >
                                                    </div>
                                                    <div class='form-group'>
                                                        <labelE-mail</label>
                                                            <input class='form-control' id='email' placeholder='E-mail' type='text' name="email_id" value="<?php echo $user[0]->email_id; ?>" data-rule-email='true' data-rule-required='true' />
                                                    </div>
                                                    <hr class='hr-normal'>
                                                    <div class='form-group'>
                                                        <label>
                                                            <input data-target='#change-password' data-toggle='collapse' id='changepasswordcheck' type='checkbox' name="pwd_flag" value='0'>
                                                            Change password?
                                                        </label>
                                                    </div>
                                                    <div class='collapse' id='change-password'>
                                                        <div class='form-group'>
                                                            <label>Password</label>
                                                            <input class='form-control' id='password' placeholder='Password' name="password" type='password' id="password"/>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Password confirmation</label>
                                                            <input class='form-control' id='password-confirmation' placeholder='Password confirmation' type='password'>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <hr class='hr-normal'>
                                            <fieldset>
                                                <div class='col-sm-4'>
                                                    <div class='lead'>
                                                        <i class='icon-github text-contrast'></i>
                                                        Personal info
                                                    </div>
                                                    <small class='text-muted'>
                                                        User can update his personal information as well.
                                                    </small>
                                                </div>
                                                <div class='col-sm-7 col-sm-offset-1'>
                                                    <div class='form-group'>
                                                        <label>Address</label>
                                                        <textarea placeholder="Address" class="form-control" name="address" rows="4" cols="80"><?php echo $user[0]->address; ?></textarea>              				
                                                    </div>
                                                    <div class='form-group'>
                                                        <label>Phone</label>
                                                        <input class='form-control' id='phone' placeholder='Phone' type='text' name="phone" value="<?php echo $user[0]->phone; ?>"  onkeypress="return isNumber(event)"  data-rule-required='true'> 
                                                    </div>
                                                    <div class="form-group" >
                                                        <label>Emirate</label>
                                                        <select id="sub_state_list" name="state" class="select2 form-control">
                                                            <option value="0">Select Emirate</option>
                                                            <?php foreach ($state as $o) { ?>
                                                                <option value="<?php echo $o['state_id']; ?>" <?php echo ($user[0]->state == $o['state_id']) ? 'selected' : ''; ?> ><?php echo $o['state_name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>                                                   
                                                    <div class='form-group'>
                                                        <label>Chat Notification</label>
                                                        <input class='' id='chat_notification' type='checkbox' name="chat_notification" value="1"  <?php if($user[0]->chat_notification==1) echo 'checked'; ?> >
                                                    </div>
                                                    <!-- 
                                                    <hr>						   
                                                    <div class='form-group'>
                                                        <label>Cover Picture								
                                                            <input title='Cover Picture' name='cover_picture'type='file'>
                                                            <div class="cover-size-div">Recommend Size: 1920*440</div>
                                                        </label>
                                                    </div>
                                                    <?php //if (!empty($user[0]->cover_picture)): ?>
                                                        <img alt="Cover Picture" src="<?php //echo base_url() . cover . "small/" . $user[0]->cover_picture; ?>"/>
                                                    <?php //endif; ?>
                                                -->
                                                </div>
                                            </fieldset>
                                            <div class='form-actions form-actions-padding' style='margin-bottom: 0;'>
                                                <div class='text-right'>
                                                    <button class='btn btn-primary btn-lg'>Save
                                                        <i class='icon-save'></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <form id="img_upload" name="img_upload" method="post"> 
                <div id="loading" style="text-align:center">
                    <img id="loading-image" src="<?php echo static_image_path; ?>ajax-loader.gif" alt="Loading..." />
                </div>
                <div class="modal-dialog modal-md">
                    <div class="modal-content rounded">                     
                        <div class="modal-header text-center orange-background">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button" id="close_popup">
                                <i class="fa fa-close"></i>
                            </button>
                            <h4 id="myLargeModalLabel" class="modal-title">Crop Your Image</h4>
                            <input type="hidden" name="img_name" id="img_name" >
                            <input type="hidden" value="<?php echo $user[0]->user_id; ?>" name="req_user_id" id="req_user_id">
                            <input type="hidden" id="crop_img_type">
                        </div>                        
                        <img id="image" name="image" src="" width="50%" height="50%" />
                        <div id='preview' align="center">

                        </div>                                                      
                        <input type="submit" id="upload_img" name="upload_img" value="Crop & Save" class="btn btn-primary">
                        <div class="docs-data" style="display:none;">
                            <input type="hidden" id="target_dir" name="target_dir" value="<?php echo document_root . profile; ?>"><br>
                            <input type="hidden" id="user_page" name="user_page" value="user_page"><br>
                            X=<input type="text" id="dataX"  name="dataX" placeholder="x">px<br>
                            Y=<input type="text" id="dataY" name="dataY" placeholder="y">px<br>
                            Width=<input type="text" id="dataWidth" name="dataWidth" placeholder="width">px            
                            Height=<input type="text" id="dataHeight" name="dataHeight" placeholder="height"> px
                            Rotate=<input type="text" id="dataRotate" name="dataRotate" placeholder="rotate">
                            ScaleX=<input type="text" id="dataScaleX" name="dataScaleX" placeholder="scaleX">
                            ScaleY=<input type="text" id="dataScaleY" name="dataScaleY" placeholder="scaleY">                       
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade sure" id="search_alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                    <h4 class="modal-title">Alert
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </h4>                   
                    </div>
                    <div class="modal-body">
                        <p class="response_message"></p>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <?php //$this->load->view('admin/include/footer-script'); ?>
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
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
        <script type="text/javascript">
            URL = window.URL || window.webkitURL;
    var blobURL = '';
    $('#inputImage').on('change', function ()
    { 
        var file = $('#inputImage')[0].files[0];
        blobURL = URL.createObjectURL(file);
        $('#crop_img_type').val(file.type);        
        $('#loading').show();

        var ext = file.name.split('.').pop().toLowerCase();
        console.log(ext);
       
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {            
            $('#inputImage').val('');
            $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
            $(document).find("#search_alert").modal('show');
        }
        else {
            $("#send-message-popup").modal('show');
            $('#send-message-popup').on('shown.bs.modal', function () {
                var image = $(document).find('#send-message-popup #img_upload #image');
                image.cropper({
                    viewMode:1,
                    dragMode: 'move',
                    aspectRatio: 1 / 1,
                    cropBoxMovable: false,
                    cropBoxResizable: false,
                    movable: true,
                    toggleDragModeOnDblclick: false
                });

                image.on('built.cropper', function () {
                    $('#loading').hide();
                    URL.revokeObjectURL(blobURL);
                }).cropper('reset').cropper('replace', blobURL);
            });            
        }
    });
    
    function dataURItoBlob(dataURI) {
        // convert base64 to raw binary data held in a string
        // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
        var byteString = atob(dataURI.split(',')[1]);

        // separate out the mime component
        var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
        console.log()
        // write the bytes of the string to an ArrayBuffer
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        // write the ArrayBuffer to a blob, and you're done
        var bb = new Blob([ab], {type: mimeString});
        return bb;
    }
    
    
    $('#img_upload').on('hidden.bs.modal', manage_crop_image);
    $("#upload_img").click(manage_crop_image);
    
    function manage_crop_image(e) {
        
        e.preventDefault();
        var form_data = new FormData($("#img_upload")[0]);        

        var croppedCanvas = $('#img_upload #image').cropper('getCroppedCanvas', {height: 300, width: 300});
        var im_url = croppedCanvas.toDataURL();
        var image_binary = im_url;
        var binToblob = dataURItoBlob(image_binary);
        var content_type = binToblob.type;
        var image_type = content_type.split('/');
        form_data.append("cropped_image", binToblob, 'crop_image.' + image_type[1]);
        
        croppedCanvas = $('#img_upload #image').cropper('getCroppedCanvas', {height: 100, width: 100});
        im_url = croppedCanvas.toDataURL();
        image_binary = im_url;
        binToblob = dataURItoBlob(image_binary);
        content_type = binToblob.type;
        image_type = content_type.split('/');
        form_data.append("cropped_image_100", binToblob, 'crop_image.' + image_type[1]);
        
        croppedCanvas = $('#img_upload #image').cropper('getCroppedCanvas', {height: 50, width: 50});
        im_url = croppedCanvas.toDataURL();
        image_binary = im_url;
        binToblob = dataURItoBlob(image_binary);
        content_type = binToblob.type;
        image_type = content_type.split('/');
        form_data.append("cropped_image_50", binToblob, 'crop_image.' + image_type[1]);
        
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: "<?php echo base_url(); ?>admin/users/crop_image_upload",
            data: form_data,
            async: false,
            contentType: false,
            processData: false,
            success: function (data) {                             
                window.location.href = "<?php echo base_url() . 'admin/users/profile/'; ?>";
            }
        });
    }
    
        $(document).ready(function() {
            $('#preview').click(function() {
                $('#photoimg').click();
            });
            
//            $('#photoimg').live('change', function()
//            {
//                $("#UserChangePictureForm").submit();//	    
//            });
            $('#changepasswordcheck').bind('click', function() {
                if ($(this).is(':checked')) {
                    $('#password').attr({
                        'data-rule-minlength': "6",
                        'data-rule-password': "true",
                        'data-rule-required': 'true'
                    });
                    $('#password-confirmation').attr('data-rule-equalto', '#password');
                } else {
                    $('#password').removeAttr('data-rule-minlength data-rule-password data-rule-required');
                    $('#password-confirmation').removeAttr('data-rule-equalto');
                }
            });
        });
        function show_emirates(val) {
                var url = "<?php echo base_url() ?>admin/users/show_emirates";
                $.post(url, {value: val}, function(data)
                {    
                    $("#sub_state_list option").remove();
                    $("#sub_state_list").append(data);

                });
            }
		function isNumber(evt) {
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			
			if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode!=45) {
				return false;
			}
			return true;
		}	
        </script>
    </body>
</html>