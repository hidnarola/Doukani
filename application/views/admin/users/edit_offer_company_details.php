<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
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
                                    <i class='icon-tags'></i>
                                    <span>Offer Company</span>
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
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Edit Offer Company
                                        </div>						
                                    </div>
                                    <div class='box-content'>
                                        <?php 
                                            $redirect = $_SERVER['QUERY_STRING'];
                                            if(!empty($_SERVER['QUERY_STRING']))
                                                $redirect = '/?'.$redirect;
                                        ?>
                                        <form action='<?php echo base_url() . 'admin/users/edit_offers_company/' . $company_details[0]->id.$redirect; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="offer_company_edit">                       

                                            <div class='form-group'>
                                                <input class="form-control" name="id" type='hidden' value="<?php echo $company_details[0]->id; ?>">
                                                <label class='col-md-2 control-label' for='inputText1'>Company Name<span>*</span></label>                                                
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Company Name' class="form-control" name="company_name" id="company_name" type='text' value="<?php echo $company_details[0]->company_name; ?>" data-rule-required='true'>
                                                    <span class="company_name_status"></span>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Company Description</label>                   
                                                <div class='col-md-5 controls'>
                                                    <textarea cols="78" rows="5" class="form-control" name="company_description" ><?php echo $company_details[0]->company_description; ?></textarea>
                                                </div>
                                            </div>                                            
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Company Logo</label>
                                                <div class='col-md-5'>
                                                    <input title='Company Logo' id='company_logo' name='company_logo' type='file' class='form-control' onchange="javascript:loadimage(this);">
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'></label>
                                                <div class='col-md-9'>
                                                    <img alt="Image" src="" id="blah1">
                                                </div>
                                            </div>
                                            <?php
                                            if ($company_details[0]->company_logo != '') {
                                                $company_logo = site_url().company_logo . "medium/" . $company_details[0]->company_logo;
                                            ?>
                                            <div class='form-group'>
                                                <div class="col-md-2"></div>
                                                <div class='col-md-5'>
                                                    <img alt="Company Logo" src="<?php echo $company_logo; ?>"  onerror="this.src='<?php echo thumb_start_grid.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" >
                                                </div>
                                            </div>
                                            <?php } ?>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Category<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                     <select class="form-control" id="offer_category_id" name="offer_category_id" <?php if($offer_count>0) echo 'disabled'; ?>>
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $company_details[0]->offer_category_id) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Meta Title</label>                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Meta Title' class="form-control" name="meta_title" type='text' value="<?php echo $company_details[0]->meta_title; ?>" maxlength="255" >
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Meta Description</label>
                                                <div class='col-md-5 controls'>
                                                        <textarea cols="78" rows="5" class="form-control" name="meta_description" id="meta_description" placeholder='Meta Description' ><?php echo $company_details[0]->meta_description; ?></textarea>
                                                </div>                                                
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Active/Hold<span>*</span></label>
                                                <div class='col-md-3 controls'>
                                                    <select name="company_status" id="company_status" data-rule-required='true' class="form-control">    
                                                        <option value="">Select</option>
                                                        <option value="0" <?php if ($company_details[0]->company_status == 0) echo 'selected'; ?>>Active</option>
                                                        <option value="3" <?php if ($company_details[0]->company_status == 3) echo 'selected'; ?>>Hold</option>
                                                    </select>                
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Status<span>*</span></label>
                                                <div class='col-md-3 controls'>
                                                    <select name="company_is_inappropriate" id="company_is_inappropriate" data-rule-required='true' class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="NeedReview" <?php if ($company_details[0]->company_is_inappropriate == 'NeedReview') echo 'selected'; ?>>NeedReview</option>
                                                        <option value="Approve" <?php if ($company_details[0]->company_is_inappropriate == 'Approve') echo 'selected'; ?>>Approve</option>
                                                        <option value="Unapprove" <?php if ($company_details[0]->company_is_inappropriate == 'Unapprove') echo 'selected'; ?>>Unapprove</option>
                                                        <option value="Inappropriate" <?php if ($company_details[0]->company_is_inappropriate == 'Inappropriate') echo 'selected'; ?>>Inappropriate</option>
                                                    </select>
                                                </div>
                                            </div>                                            		   
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit'>
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='<?php echo base_url()."admin/users/index/offerUser".$redirect; ?>' title="Cancel" class="btn">Cancel</a>
                                                    </div>
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
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script>
            
        var flag1 = 0;
        var flag2 = 0;
    
        $(document).on("change", "#company_name", function (e) {
            var company_name = $(this).val();
            if(company_name) {
                $.ajax({
                type: 'post',
                url: '<?php echo site_url().'home/check_company_name' ?>',
                data: {
                    company_name:company_name,user_id:'<?php echo $company_details[0]->user_id; ?>'
                },
                success: function (response) {                  
                    if(response=="OK") {
                       $('.company_name_status').html('');
                       flag1 = 0;
                       return true;
                    }
                   else {
                        flag1 = 1;
                        $('.company_name_status').html('<font color="#b94a48">'+response+'</font>');
                        return false;                               
                    }
                  }
                });
            }
            else {
               $('.company_name_status').html("");
               return false;
            }
        });

           
        
        $("#offer_company_edit").submit(function( event ) {
            if(flag1==1 || flag2==1)
                return false;
        });
    
        $('#blah1').hide();
        
        function loadimage(input) {
            
            var company_logo  = $("#company_logo").val();
            if(company_logo!='') {                    
                var file_data = $("#company_logo").prop("files")[0];
                var type = file_data.type;
                if (file_data) {
                    if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif") {
                        $('#company_logo').val('');
                        $(document).find('.file-input-name').html('');
                        $(".file-input-name").html("");
                        var imgcon = $("#blah1")[0];
                        $(imgcon).attr("src", "");
                        $(imgcon).hide();
                        
                        $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                        $(document).find("#search_alert").modal('show');
                        return false;
                    }
                }
            }
                
            if (input.files && input.files[0]) {
                var reader = new FileReader();                
                reader.onload = function (e) {
                    $('#blah1').attr('src', e.target.result);
                    var imgcon = $("#blah1")[0];
                    var img = imgcon;
                    
                    var pic_real_width, pic_real_height;
                    $("<img/>")
                            .attr("src", $(img).attr("src"))
                            .load(function () {
                                pic_real_width = this.width;
                                pic_real_height = this.height;

                                $(imgcon).attr("src", $(img).attr("src"));
                                $(imgcon).show();                                
                            });
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
    </body>
</html>