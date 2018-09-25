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
                            <hr>
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='fa fa-info-circle'></div>
                                            View Offer Company
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
    $(':input').attr('readonly','readonly');
    $("select").attr("disabled","disabled");
    $(":input").attr("disabled","disabled");
</script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
    </body>
</html>