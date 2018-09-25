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
                                    <i class='fa fa-cogs'></i>
                                    <span>Settings</span>
                                </h1>               
                            </div>
                            <hr class="normal" />

                            <?php if ($this->session->flashdata('msg')): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>

                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Site Settings
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class='box-content'>
                                        <form action='<?php echo base_url() . 'admin/systems/settings/' ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post'>
                                            <div class='form-group'>
                                                <div class='col-md-12 controls'>
                                                    <label class='col-md-9 control-label' for='inputText1'><span>If No. of Ads for Every Month not specified in this page then system will take 15 ads for all type of users</span></label>
                                                </div>    
                                            </div>
                                            <div class='form-group'>
                                                <div class='col-md-9 controls'>
                                                    <label class='col-md-9 control-label' for='inputText1'><span>Allocate No. of Ads for different type of Users</span></label>
                                                </div>    
                                            </div> 

                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Classified User</label>
                                                <div class='col-md-5 controls'>
                                                    <input class=" form-control number_field" name="no_of_post_month_classified_user" type='text' data-rule-required='true' value="<?php echo $settings['no_of_post_month_classified_user'] ?>"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Store User</label>
                                                <div class='col-md-5 controls'>
                                                    <input class=" form-control number_field" name="no_of_post_month_store_user" type='text' data-rule-required='true' value="<?php echo $settings['no_of_post_month_store_user'] ?>"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Offer User</label>
                                                <div class='col-md-5 controls'>
                                                    <input class=" form-control number_field" name="no_of_post_month_offer_user" type='text' data-rule-required='true' value="<?php echo $settings['no_of_post_month_offer_user'] ?>"/>
                                                </div>
                                            </div>

                                            <div class='form-group'>
                                                <div class='col-md-9 controls'>
                                                    <label class='col-md-9 control-label' for='inputText1'><span>No. of days for Ads Availability</span></label>
                                                </div>    
                                            </div> 

                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Classified Ads: </label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Number of days' class="form-control number_field" name="adv_availability_classified_user" type='text' value="<?php echo $settings['adv_availability_classified_user'] ?>" data-rule-required='true'/>
                                                </div>
                                            </div>

                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Store Ads: </label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Number of days' class="form-control number_field" name="adv_availability_store_user" type='text' value="<?php echo $settings['adv_availability_store_user'] ?>" data-rule-required='true'/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Offer Ads: </label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Number of days' class="form-control number_field" name="adv_availability_offer_user" type='text' value="<?php echo $settings['adv_availability_offer_user'] ?>" data-rule-required='true'/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Super Admin / Admin Ads: </label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Number of days' class="form-control number_field" name="adv_availability_admin" type='text' value="<?php echo $settings['adv_availability_admin'] ?>" data-rule-required='true'/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <div class='col-md-9 controls'>
                                                    <label class='col-md-9 control-label' for='inputText1'><span>Other things</span></label>
                                                </div>    
                                            </div>                                            
                                            <div class="form-group">                                            
                                                <label class='col-md-4 control-label' for='inputText1'>Colors: </label>
                                                <div class='col-md-5'> 
                                                    <?php
                                                    if (isset($settings['colors']) && $settings['colors'] != '')
                                                        $color = explode(",", $settings['colors']);
                                                    else
                                                        $color = array();
                                                    ?>          

                                                    <select name="colors[]"  class="" id="ms" multiple="multiple">                  
                                                        <?php foreach ($colors as $col): ?>
                                                            <option value="<?php echo $col['background_color']; ?>"
                                                            <?php
                                                            if (in_array($col['background_color'], $color))
                                                                echo 'selected=selected';
                                                            else
                                                                echo '';
                                                            ?>><?php echo $col['name']; ?></option>         
                                                                <?php endforeach; ?>
                                                    </select>                                               
                                                </div>
                                            </div>
                                            <div class="form-group">                                            
                                                <label class='col-md-4 control-label' for='inputText1'>Brand: </label>
                                                <div class='col-md-5 controls'> 
                                                    <?php $brands = explode(",", $settings['brand']); ?>                     
                                                    <select name="brand[]"  class="form-control" id="ms1" multiple="multiple">                  
                                                        <?php foreach ($brand as $col): ?>
                                                            <option value="<?php echo $col['brand_id']; ?>"
                                                            <?php
                                                            if (in_array($col['brand_id'], $brands))
                                                                echo 'selected=selected';
                                                            else
                                                                echo '';
                                                            ?>><?php echo $col['name']; ?></option>            
                                                                <?php endforeach; ?>
                                                    </select>                                               
                                                </div>
                                            </div>
                                            <div class="form-group">                                            
                                                <label class='col-md-4 control-label' for='inputText1'>Mileage: </label>
                                                <div class='col-md-5 controls'> 
                                                    <?php $mileage1 = explode(",", $settings['mileage']); ?>                       
                                                    <select name="mileage[]"  class="form-control" id="ms" multiple="multiple">                 
                                                        <?php foreach ($mileage as $col): ?>
                                                            <option value="<?php echo $col['mileage_id']; ?>"
                                                            <?php
                                                            if (in_array($col['mileage_id'], $mileage1))
                                                                echo 'selected=selected';
                                                            else
                                                                echo '';
                                                            ?>><?php echo $col['name']; ?></option>            
                                                                <?php endforeach; ?>
                                                    </select>                                               
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Ios Notification Maximum Length: </label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='' class="form-control number_field" name="iphone_notification_max_length" type='text' value="<?php echo $settings['iphone_notification_max_length'] ?>" data-rule-required='true' />Total Characters<b>(message+url)</b>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Android Notification Maximum Length: </label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='' class="form-control number_field" name="android_notification_max_length" type='text' value="<?php echo $settings['android_notification_max_length'] ?>" data-rule-required='true'/>Total Characters<b>(message+url)</b>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>USD Currency Amount: </label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='' class="form-control number_field" name="usd_currency_amount" type='number' value="<?php echo $settings['usd_currency_amount'] ?>" data-rule-required='true'/>
                                                    <b>1 AED = ___ USD</b>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>Commission on purchase from Stores</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='' class="form-control number_field" name="commission_on_purchase_from_store" type='number' value="<?php echo $settings['commission_on_purchase_from_store'] ?>" data-rule-required='true'/>
                                                    <b>In % (percentage)</b>
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-3">
                                                        <button class='btn btn-primary' type='submit' name="submit">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>admin/systems/settings' title="Cancel" class="btn">Cancel</a>
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
                <section>
                    </div>
                    <?php $this->load->view('admin/include/footer-script'); ?>
                    <script>
                        $(function () {
                            $('#ms').change(function () {
                                //console.log($(this).val());
                            }).multipleSelect({
                                width: '100%'
                            });
                            $(".ms-drop ul li").each(function () {
                                $(this).css("background", $(this).find("input").val());
                            });
                        });


                        $(".number_field").keydown(function (e) {
                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                                    (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                                return;
                            }

                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }
                        });

                    </script>