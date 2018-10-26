<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb store'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='page-header'>
                                        <h1 class='pull-left'>
                                            <i class='fa fa-file-image-o'></i>
                                            <span>VIP Banner</span>
                                        </h1>
                                        <div class='pull-right'>
                                            <?php
                                            if ($this->uri->segment(5) != '')
                                                $banner_for = $this->uri->segment(5);
                                            else
                                                $banner_for = '';
                                            ?>
                                            <a class="btn" href="<?php echo base_url() . "admin/custom_banner/vipBanner/10/" . $banner_for; ?>"><i class="icon-list"></i> VIP Banner List</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-normal">
                            <div class='row'>
                                <div class='col-sm-12'>									
                                    <div class='box'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>
                                                <div class='icon-plus'></div>
                                                Add VIP Banner
                                            </div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content'>
                                            <form enctype="multipart/form-data" action="" method="post" name="category" class="validate-form form-horizontal" style="margin-bottom: 0;"  accept-charset="UTF-8">
                                                <div class='form-group' style="display:none;">
                                                    <label class='col-md-2 control-label' for='inputSelect'>Banner For</label>
                                                    <div class='col-md-5'>
                                                        <select name="ban_for" id="ban_for" class='form-control'>
                                                            <option value="web" <?php if ($this->uri->segment(5) != '' && $this->uri->segment(5) == 'web') echo 'selected'; ?> >Web</option>
                                                            <option value="mobile" <?php if ($this->uri->segment(5) != '' && $this->uri->segment(5) == 'mobile') echo 'selected'; ?>>Mobile</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group' id="mobile" style="display:none;">
                                                    <label class='col-md-2 control-label'>Banner For Mobile</label>
                                                    <div class='col-md-10'>
                                                        <div class="mobile">
                                                            <label class='radio radio-inline'>
                                                                <input type="radio" name="ban_show_status_0" id="ios" value="ios"  />IOS 
                                                            </label>
                                                            <label class='radio radio-inline'>
                                                                <input type="radio" name="ban_show_status_0" id="android" value="android"  />Android
                                                            </label>
                                                            <label class='radio radio-inline'>
                                                                <input type="radio" name="ban_show_status_0" id="both" value="both" />Both
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Banner Type<span>*</span></label>
                                                    <div class='col-md-5'>
                                                        <select name="ban_name_0" id="ban_type" class='form-control' data-rule-required='true'>
                                                            <option value="">Select</option>
                                                            <option value="header">Header Banner</option>
                                                            <option value="sidebar">Sidebar Banner</option>
                                                            <option value="between">Between Banner</option>
                                                            <option value="intro">Intro Banner</option>
                                                            <option value="feature">Feature Banner</option>
                                                            <option value="footer">Footer Banner</option>
                                                            <option value="between_app">Between Banner</option>
                                                            <!-- <option value="offer">Offer Banner</option>
                                                            <option value="feature">Feature Banner</option>
                                                            <option value="between items">Between Items</option>
                                                            <option value="sponsor">Sponsor</option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Page<span>*</span></label>
                                                    <div class='col-md-5'>
                                                        <select name="display_page_0" id="display_page" class='form-control' onchange="hide_show_cat(this.value);" data-rule-required='true'>
                                                            <option value="">Select</option>
                                                            <?php if ($banner_for == 'web') { ?>
                                                                <optgroup label="Classified">
                                                                    <option value="all_page">All Pages</option>
                                                                    <option value="home_page">Home Page</option>
                                                                    <option value="content_page">Content Page</option>
                                                                    <option value="bw_home_page_ban1">Home Page Banner 1</option>
                                                                    <option value="bw_home_page_ban2">Home Page Banner 2</option>
                                                                    <option value="latest_ads_page">Classified Latest Ads Page</option>
                                                                </optgroup>
                                                                <optgroup label="Store">
                                                                    <option value="store_all_page">All Pages</option>
                                                                    <option value="specific_store_page">Specific Store Page</option>
                                                                    <option value="store_content_page">Store Item Details Page</option>
                                                                    <option value="store_page_content">Store Landing Page</option>
                                                                </optgroup>
                                                                <optgroup label="Offer">
                                                                    <option value="off_all_page">All Pages</option>
                                                                    <option value="off_home_page">Home Page</option>
                                                                    <option value="off_catent_page">Offer Details Page</option>
                                                                    <option value="off_cat_cont">Category Wise Offers Page</option>
                                                                    <option value="off_comp_cont">Company Wise Offers Page</option>
                                                                    <option value="off_cat_side">Categories Block on Offer's Home Page</option>
                                                                    <option value="off_comp_side">Companies  Block on Offer's Home Page</option>
                                                                </optgroup>
                                                            <?php } elseif ($banner_for == 'mobile') { ?>
                                                                <option value="all_page">All Pages</option>
                                                                <option value="home_page">Home Page</option>
                                                                <option value="content_page">Content Page</option>
                                                                <option value="after_splash_screen">After splash screen</option>
                                                                <option value="before_latest_ads">Before latest ads</option>
                                                                <option value="before_featured_items">Before featured items</option>                                                            
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="cat_section" style="display:none;">
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputSelect'>Select Super Category</label>
                                                        <div class='col-md-5'>
                                                            <select name="superCategory_0[]" id="superCategory_0_0"  onchange="showSubcategory(this, '0', '0')" class="form-control cat_section_">
                                                                <option value="0">Select Super Category</option>
                                                                <?php
                                                                foreach ($superCategories as $scategory) {
                                                                    ?>
                                                                    <option value="<?php echo $scategory['category_id']; ?>" style="padding-top:15px;"><?php echo str_replace('\n', " ", $scategory['catagory_name']); ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputSelect'>Select Sub Category</label>
                                                        <div class='col-md-5'>
                                                            <select name="subcategory_0[]" id="sub_category_0_0" class="form-control sub_cat_section_">                           
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='form-group' id="addNewCategoryLink_0">
                                                        <label class='col-md-2 control-label' for='inputSelect'></label>
                                                        <div class='col-md-5'>
                                                            <div class="btn-group">
                                                                <a class="btn hidden-xs" style="margin-right: 5px;" href="javaScript:void(0);" onclick="addNewCategory(0)">Click to Add More Category</a>
                                                                <a class="btn hidden-xs" href="javaScript:void(0);" onclick="removeLastCategory(0)" >Remove Last Category</a>
                                                            </div>
                                                            <input type="hidden" id="cat_total_0" name="cat_total_0" value="0" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="company_section" style="display:none;">
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Offer Company</label>
                                                        <div class='col-md-5'>
                                                            <select name="offer_user_company_id_0[]" id="offer_user_company_id_0_0" class="form-control select2">
                                                                <option value="0">All</option>
                                                                <?php foreach ($company as $o) { ?>
                                                                    <option value="<?php echo $o['id']; ?>"><?php echo $o['company_name']; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='form-group' id="addNewCompanyLink_0">
                                                        <label class='col-md-2 control-label' for='inputSelect'></label>
                                                        <div class='col-md-5'>
                                                            <div class="btn-group">
                                                                <a class="btn hidden-xs" style="margin-right: 5px;" href="javaScript:void(0);" onclick="addNewCompany(0)">Click to Add More Company</a> 
                                                                <a class="btn hidden-xs" href="javaScript:void(0);" onclick="removeLastCompany(0)" >Remove Last Company</a>
                                                            </div>
                                                            <input type="hidden" id="company_total_0" name="company_total_0" value="0" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="store_section" style="display:none;">
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Store</label>
                                                        <div class='col-md-5'>
                                                            <select class="select2 form-control" name="store_id_0[]" id="store_id_0_0">
                                                                <option value="0">All</option>
                                                                <?php foreach ($stores as $s) { ?>
                                                                    <option value="<?php echo $s['store_id']; ?>"><?php echo $s['store_domain'] . '.doukani.com'; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='form-group' id="addNewStoreLink_0">
                                                        <label class='col-md-2 control-label' for='inputSelect'></label>
                                                        <div class='col-md-5'>
                                                            <div class="btn-group">
                                                                <a class="btn hidden-xs" style="margin-right: 5px;" href="javaScript:void(0);" onclick="addNewStore(0)">Click to Add More Store</a> 
                                                                <a class="btn hidden-xs" href="javaScript:void(0);" onclick="removeLastStore(0)" >Remove Last Store</a>
                                                            </div>
                                                            <input type="hidden" id="store_total_0" name="store_total_0" value="0" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class='hr-normal'>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Select Banner</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_txt_img_0" id="text_banner" value="text" checked />
                                                            Text Banner
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_txt_img_0" id="img_banner" value="image"  />
                                                            Image Banner
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group' id="text_val">
                                                    <label class='col-md-2 control-label' for='inputTextArea1'>Enter Text</label>
                                                    <div class='col-md-5'>
                                                        <textarea class='form-control' id='' placeholder='Textarea' rows="5"  name="text_ad" style="direction:ltr; text-align:left; "></textarea>
                                                    </div>
                                                </div>												
                                                <div class='form-group' id="big_img" style="display:none;">
                                                    <label class='col-md-2 control-label' for=''>Big Banner Image(For Website)</label>
                                                    <div class='col-md-9'>
                                                        <?php $this->load->view('admin/banners/include_big_div'); ?>
                                                    </div>
                                                    <label class='col-md-2 control-label' for=''></label>	
                                                    <div class='col-md-3'>
                                                        <input name="uploadedlargefile" id="uploadedlargefile" type="file" class='form-control' onchange="javascript:loadimage(this);"/>
                                                    </div><br><br><br><br>

                                                </div>
                                                <div class='form-group'>
                                                    <div class='col-md-9'>
                                                        <img alt="Banner Image" src="" id="blah1">
                                                    </div>
                                                </div>

                                                <div class='form-group' id="small_img" style="display:none;">
                                                    <label class='col-md-2 control-label' for=''>Small Banner Image(For MobileApp)</label>
                                                    <div class='col-md-9'>                                                        
                                                        <?php $this->load->view('admin/banners/include_small_div'); ?> 
                                                    </div>
                                                    <label class='col-md-2 control-label' for=''></label>	
                                                    <div class='col-md-3'>
                                                        <input name="uploadedfile_0" type="file" class='form-control' id="uploadedfile" onchange="javascript:loadimage_small(this);"/>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <div class='col-md-9'>
                                                        <img alt="" src="" id="blah2">
                                                    </div>
                                                </div>

                                                <div class='form-group' id="site_url">
                                                    <label class='col-md-2 control-label' for='inputText'>Site URL</label>
                                                    <div class='col-md-5'>
                                                        <input name="site_url_0" class='form-control' id='inputText' placeholder='Site URL' type='text'>
                                                    </div>
                                                </div>
                                                <div class='form-group' >
                                                    <label class='col-md-2 control-label' for='inputText'>Phone Number</label>
                                                    <div class='col-md-5'>
                                                        <input name="phone_no_0" class='form-control' id='inputText' placeholder='Phone Number' type='text' onkeypress="return isNumber(event)">
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Advertiser<span>*</span></label>
                                                    <div class='col-md-5 controls'>                                                        
                                                        <input name="adv_0" class='form-control' id='inputText' placeholder='Advertiser' type='text' data-rule-required='true'>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Status</label>
                                                    <div class='col-md-5'>
                                                        <select name="status_0" class="form-control">
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Pause Banner</label>
                                                    <div class='col-md-5'>
                                                        <select name="pause_banner_0" class="form-control" >
                                                            <option value="no">No</option>
                                                            <option value="yes">Yes</option>                                                         
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr class="hr-normal">
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Start Date</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="st_dt_0" id="st_now" value="st_now"  checked/>
                                                            Start Immediately 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="st_dt_0" id="st_cust" value="st_cust"  />
                                                            Custom Start Date
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group ' id="start_dt">
                                                    <label class='col-md-2 control-label' for='inputText'></label>
                                                    <div class='col-md-5'>
                                                        <div class='datetimepicker input-group' id='datepicker'>
                                                            <input class='form-control' data-format='yyyy-MM-dd' name="start_date" id="start_date" placeholder='Select Start Date' type='text' value="<?php echo isset($_POST['date']) ? $_POST['date'] : date("Y-m-d"); ?>">
                                                            <span class='input-group-addon'>
                                                                <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>                                             
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>End Date</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="end_dt_0" id="end_never" value="end_never"  checked/>
                                                            No End Date 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="end_dt_0" id="end_cust" value="end_cust"  />
                                                            Custom End Date 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'></label>
                                                    <div class='col-md-5' id='end_dt'>
                                                        <div class='datetimepicker input-group' id='datepicker'>
                                                            <input class='form-control' data-format='yyyy-MM-dd' name="end_date" id="end_date"  placeholder='Select End Date' type='text'>
                                                            <span class='input-group-addon'>
                                                                <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                            </span>
                                                        </div>
                                                        <font color="#b94a48" style="font-size: 14px; font-weight:lighter !important; "><span id="lbl_dbo"></span></font>
                                                    </div>
                                                </div>													
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'>Impressions<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="number" name="impression_day_0" id="impression_day" size="10" class="form-control" data-rule-required='true'/>
                                                    </div>
                                                    <div class='col-md-6 controls'>
                                                        <label class='control-label' for='inputText'>
                                                            <br><span>Note:CPM and CPC : Impressions<br>
                                                                and Duration: Impressions/Days</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'>Clicks<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="number" name="clicks_day_0" id="clicks_day" size="10" class="form-control" data-rule-required='true'/>
                                                    </div>
                                                    <div class='col-md-6 controls'>
                                                        <label class='control-label' for='inputText'>
                                                            <br><span>Note:CPM and CPC : Clicks<br>
                                                                and Duration: Clicks/Days</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Bidding Options</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="duration" id="cpm" value="cpm"  checked/>
                                                            CPM(Cost Per Measurement) 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="duration" id="cpc" value="cpc"  />
                                                            CPC(Cost Per Click)
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="duration" id="duration" value="duration"  />
                                                            Duration
                                                        </label>
                                                    </div>
                                                </div> 
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'>Target Value</label>
                                                    <div class='col-md-5'>
                                                        <input type="text" name="cpc_cpm_0" size="10" class="form-control"/>
                                                    </div>
                                                </div>												
                                                <div class='form-actions form-actions-padding-sm' id="finalRow">
                                                    <div class='row'>
                                                        <div class='col-md-10 col-md-offset-2'>
                                                            <button class='btn btn-primary' type='submit' name="cat_save" id="submit" value="Save">
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                            <a  href='<?php echo base_url(); ?>admin/custom_banner/vipBanner/10/<?php echo $banner_for;
                                                        ?>' title="Cancel" class="btn ">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>                                                
                                                <input type="hidden" id="total" name="total" value="0" />
                                                <input type="hidden" id="company_total" name="company_total" value="0" />
                                                <input type="hidden" id="store_total" name="store_total" value="0" />
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>				
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <!--=============================-->

        <script>
            function showCategory() {
                var display_page = $("#display_page").val();
                $.post(cat_url, {display_page: display_page}, function (data)
                {
                    $(".cat_section_ option").remove();
                    $(".cat_section_").append('<option value="0">Select Super Category</option>');
                    $(".cat_section_").append(data);
                });
            }
            function showSubcategory(obj, ind, secInd) {
                var sup_cat_id = $(obj).val();
                var display_page = $("#display_page").val();

                $.post(url, {sup_cat_id: sup_cat_id, display_page: display_page}, function (data)
                {
                    $("#sub_category_" + ind + "_" + secInd + ' option').remove();
                    $("#sub_category_" + ind + "_" + secInd).append('<option id="0" value="0">ALL</option>');
                    $("#sub_category_" + ind + "_" + secInd).append(data);
                });
            }
            function addNewCategory(ind)
            {
                var url = "<?php echo base_url(); ?>admin/custom_banner/addMoreCategory";
                var curt_id = $("#cat_total_" + ind).val();
                var main_id = $("#total").val();
                var display_page = $("#display_page").val();
                var total = parseInt(curt_id) + 1;

                $.post(url, {main_id: main_id, curt_id: curt_id, display_page: display_page}, function (data)
                {
                    $("#addNewCategoryLink_" + ind).before(data);
                    $("#cat_total_" + ind).val(total);
                    $("#total").val(total);
                });
            }
            function removeLastCategory(ind) {

                var curt_id = $("#cat_total_" + ind).val();
                if (curt_id == 0) {
                    $(document).find('.response_message').html('You are not allow to remove category');
                    $(document).find("#search_alert").modal('show');
                } else {
                    $('#superCategory_0_' + curt_id).closest('div').parent().remove();
                    $('#sub_category_0_' + curt_id).closest('div').parent().remove();
                    $("#cat_total_" + ind).val(curt_id - 1);
                    var tot = $("#total").val();
                    var totmin = parseInt(tot) - 1;
                    $("#total").val(totmin);
                }
            }
            $('#imp_cnt_div').show();
            var cat_value = '';

            $('#start_dt').hide();
            $('#end_dt').hide();

            function addNewCompany(ind)
            {
                var url = "<?php echo base_url(); ?>admin/custom_banner/addMoreCompany";
                var curt_id = $("#company_total_" + ind).val();
                var main_id = $("#company_total").val();
                var total = parseInt(curt_id) + 1;

                $.post(url, {main_id: main_id, curt_id: curt_id}, function (data)
                {
                    $("#addNewCompanyLink_" + ind).before(data);
                    $("#company_total_" + ind).val(total);
                    $("#company_total").val(total);
                });
            }
            function removeLastCompany(ind) {

                var curt_id = $("#company_total_" + ind).val();
                if (curt_id == 0) {
                    $(document).find('.response_message').html('You are not allow to remove Company');
                    $(document).find("#search_alert").modal('show');
                } else {
                    $('#offer_user_company_id' + curt_id).closest('div').parent().remove();
                    $("#company_total_" + ind).val(curt_id - 1);
                    var tot = $("#company_total").val();
                    var totmin = parseInt(tot) - 1;
                    $("#company_total").val(totmin);
                }
            }

            function addNewStore(ind)
            {
                var url = "<?php echo base_url(); ?>admin/custom_banner/addMoreStore";
                var curt_id = $("#store_total_" + ind).val();
                var main_id = $("#store_total").val();
                var total = parseInt(curt_id) + 1;

                $.post(url, {main_id: main_id, curt_id: curt_id}, function (data)
                {
                    $("#addNewStoreLink_" + ind).before(data);
                    $("#store_total_" + ind).val(total);
                    $("#store_total").val(total);
                });
            }
            function removeLastStore(ind) {

                var curt_id = $("#company_total_" + ind).val();
                if (curt_id == 0) {
                    $(document).find('.response_message').html('You are not allow to remove Company');
                    $(document).find("#search_alert").modal('show');
                } else {
                    $('#store_id' + curt_id).closest('div').parent().remove();
                    $("#store_total_" + ind).val(curt_id - 1);
                    var tot = $("#store_total").val();
                    var totmin = parseInt(tot) - 1;
                    $("#store_total").val(totmin);
                }
            }
        </script>        
        <!--set restriction in below file for banner upload -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/banner.js" type="text/javascript"></script>       
        <script>
            var url = "<?php echo base_url(); ?>admin/custom_banner/getSubCategory";
            var cat_url = "<?php echo base_url(); ?>admin/custom_banner/getCategory";

<?php if ($banner_for != '') { ?>
                get_banner_type('<?php echo $banner_for; ?>');
<?php } ?>

            $(function () {
                $('#submit').click(function () {
                    var end_select = document.getElementById("end_cust");
                    if (end_select.checked) {

                        var st_now = document.getElementById("st_now");
                        var st_cust = document.getElementById("st_cust");
                        if (st_now.checked) {
                            var start = '<?php echo date('Y-m-d'); ?>';
//                            console.log("start immediately");
                        } else {
                            if (st_cust.checked) {
                                var start = $("#start_date").val();
//                                console.log("custom_date");
                            }
                        }

                        var end = $("#end_date").val();
                        if (end < start) {
//                            console.log("if part");
                            $("#lbl_dbo").show();
                            $("#lbl_dbo").text("Last Date Must be greater than Start Date");
                            return false;
                        } else {
                            $("#lbl_dbo").hide();
                        }
                    }
                });
            });

        </script>       

