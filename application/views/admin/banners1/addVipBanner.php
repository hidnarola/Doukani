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
                                            <i class='icon-edit'></i>
                                            <span>VIP Banner</span>
                                        </h1>
                                        <div class='pull-right'>
                                            <a class="btn" href="<?php echo base_url() . "admin/custom_banner/vipBanner/10"; ?>"><i class="icon-list"></i> VIP Banner List</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
									<div id="loading" style="text-align:center">
										<img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
									</div>
                                    <div class='box'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>
                                                <div class='icon-edit'></div>
                                                Add VIP Banner
                                            </div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content'>
                                            <form enctype="multipart/form-data" action="" method="post" name="category" class="validate-form form-horizontal" style="margin-bottom: 0;"  accept-charset="UTF-8">

												<div class='form-group'>
                                                    <label class='col-md-2 control-label'>Banner Show For</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" class="mobile-radio" name="ban_parent_status_0" id="mobile" value="mobile"  />Mobile 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" class="web" name="ban_show_status_0" id="web" value="web"  />Web
                                                        </label>
                                                        <div class="mobile" style="display:none;">
                                                            <label class='radio radio-inline'>
                                                                <input type="radio" name="ban_show_status_0" id="ios" value="ios"  />IOS 
                                                            </label>
                                                            <label class='radio radio-inline'>
                                                                <input type="radio" name="ban_show_status_0" id="andriod" value="andriod"  />Andriod
                                                            </label>
                                                            <label class='radio radio-inline'>
                                                                <input type="radio" name="ban_show_status_0" id="both" value="both" checked="checked"  />Both
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Banner Type</label>
                                                    <div class='col-md-5'>
                                                        <select name="ban_name_0" id="ban_type" class='form-control'>
															<option value="header">Header Banner</option>
															<option value="sidebar">Sidebar Banner</option>
                                                            <option value="between">Between Items(Footer for MobileApp)</option>
                                                            <!-- <option value="intro">Intro Banner</option>
                                                            <option value="footer">Footer Banner</option>
                                                            <option value="offer">Offer Banner</option>
                                                            <option value="feature">Feature Banner</option>
                                                            <option value="between items">Between Items</option>
                                                            <option value="sponsor">Sponsor</option> -->
                                                        </select>
                                                    </div>
                                                </div>
												<div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Page</label>
                                                    <div class='col-md-5'>
                                                        <select name="display_page_0" id="display_page" class='form-control' onchange="hide_show_cat(this.value);">
                                                            <option value="all_page">All Page</option>
                                                            <option value="home_page">Home Page</option>
															<option value="content_page">Content Page</option>
														</select>
                                                    </div>
                                                </div>
                                                <div id="cat_section" style="display:none;">
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputSelect'>Select Super Category</label>
                                                        <div class='col-md-5'>
                                                            <select name="superCategory_0[]" id="superCategory_0_0"  onchange="showSubcategory(this, '0', '0')" class="form-control">
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
                                                            <select name="category_0[]" id="sub_category_0_0" class="form-control">                           
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='form-group' id="addNewCategoryLink_0">
                                                        <label class='col-md-2 control-label' for='inputSelect'></label>
                                                        <div class='col-md-5'>
                                                            <div class="btn-group">
                                                                <a class="btn  hidden-xs" style="margin-right: 5px;" href="javaScript:void(0);" onclick="addNewCategory(0)">Click to Add More Category</a> 
                                                                <a class="btn  hidden-xs" href="javaScript:void(0);" onclick="removeLastCategory(0)" >Remove Last Category</a>
                                                            </div>
                                                            <input type="hidden" id="cat_total_0" name="cat_total_0" value="0" />
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
                                                        <textarea class='form-control' id='' placeholder='Enter Text' rows="5"  name="text_ad" style="direction:ltr; text-align:left; "></textarea>
                                                    </div>
                                                </div>
                                                <div class='form-group' id="big_img">
                                                    <label class='col-md-2 control-label' for=''>Big Banner Image(For Website)</label>
                                                    <div class='col-md-9'>                                                        
														<?php $this->load->view('admin/banners/include_big_div'); ?>
                                                    </div>
													<label class='col-md-2 control-label' for=''></label>	
													<div class='col-md-3'>
														<input name="uploadedlargefile" id="uploadedlargefile" type="file" class='form-control' onchange="javascript:loadimage(this);"/>
													</div><br><br><br><br>
														<img alt="Banner Image" src="" width="150px" height="150px" id="blah1">
                                                </div>
                                                <div class='form-group' id="small_img">
                                                    <label class='col-md-2 control-label' for=''>Small Banner Image(For MobileApp)</label>
													<div class='col-md-9'>                                                        
														<?php $this->load->view('admin/banners/include_small_div');  ?> 
													</div>
													<label class='col-md-2 control-label' for=''></label>	
													<div class='col-md-3'>
														<input name="uploadedfile_0" type="file" class='form-control' id="uploadedfile" onchange="javascript:loadimage_small(this);"/>
														<br><br>
														<img alt="" src="" width="150px" height="150px" id="blah2">
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
                                                    <label class='col-md-2 control-label' for='inputSelect'>Advertiser</label>
                                                    <div class='col-md-5 controls'>
                                                        <?php /* <select name="adv_0" class="form-control">
                                                            <?php
                                                            foreach ($advertiser as $adv) {
                                                                echo "<option value=" . $adv['user_id'] . ">" . $adv['username'] . "</option>";
                                                            }
                                                            ?>
                                                        </select> */ ?>
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
                                                <div class='form-group' id='start_dt' >
                                                    <label class='col-md-2 control-label' for='inputText'></label>
                                                    <div class='col-md-5'>
                                                        <div class='datetimepicker input-group' id='datepicker'>
                                                            <input class='form-control' data-format='yyyy-MM-dd' name="ex_st_dt_0" placeholder='Select Start Date' type='text' value="<?php echo isset($_POST['date']) ? $_POST['date'] : date("Y-m-d"); ?>">
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
                                                <div class='form-group' id='end_dt'>
                                                    <label class='col-md-2 control-label' for='inputText'></label>
                                                    <div class='col-md-5'>
                                                        <div class='datetimepicker input-group' id='datepicker'>
                                                            <input class='form-control' data-format='yyyy-MM-dd' name="ex_end_dt_0" placeholder='Select End Date' type='text' >
                                                            <span class='input-group-addon'>
                                                                <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Emirate</label>
                                                    <div class='col-md-5'>
                                                        <select id="sub_state_list" name="state" class=" form-control">
                                                            <option value="">-- Select Emirate --</option>
																<?php foreach ($state as $st): ?>
																<option value="<?php echo $st['state_id'] ?>" ><?php echo $st['state_name'] ?></option>
																<?php endforeach; ?>
                                                        </select>	                  
                                                    </div>
                                                </div>
                                                <hr class="hr-normal">
                                                <div class='form-group'  >
                                                    <label class='col-md-2 control-label' for='inputText'>Impression/Days</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" name="impression_day_0" size="10" class="form-control" data-rule-required='true'/>
                                                    </div>
                                                </div>
                                                <div class='form-group'  >
                                                    <label class='col-md-2 control-label' for='inputText'>Clicks/Days</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" name="clicks_day_0" size="10" class="form-control" data-rule-required='true'/>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Bidding Options</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="rd_cpm_cpc" id="rd_cpm" value="cpm"  checked/>
                                                            CPM(Cost Per Measurement) 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="rd_cpm_cpc" id="rd_cpc" value="cpc"  />
                                                            CPC(Cost Per Click)
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
                                                            <button class='btn btn-primary' type='submit' name="cat_save" value="Save">
                                                                 <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
															<a  href='<?php echo base_url(); ?>admin/custom_banner/vipBanner/10' title="Cancel" class="btn ">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="total" name="total" value="0" />
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
	function addNewCategory(ind)
	{
		var url = "<?php echo base_url() ?>admin/custom_banner/addMoreCategory";
		var curt_id = $("#cat_total_" + ind).val();
		var main_id = $("#total").val();
		var total = parseInt(curt_id) + 1;
		$.post(url, {main_id: main_id, curt_id: curt_id}, function(data)
		{
			$("#addNewCategoryLink_" + ind).before(data);
			$("#cat_total_" + ind).val(total);
			$("#total").val(total);					
		});
	}

	function removeLastCategory(ind) {

		var curt_id = $("#cat_total_" + ind).val();
		if (curt_id == 0) {
			alert("You are not allow to remove category");
		} else {
			$('#superCategory_0_' + curt_id).closest('div').parent().remove();
			$('#sub_category_0_' + curt_id).closest('div').parent().remove();
			$("#cat_total_" + ind).val(curt_id - 1);
				var tot	=	$("#total").val();					
				var totmin	=	parseInt(tot)-1;
				$("#total").val(totmin);					
		}
	}
</script>        
<script>
	var cat_value = '';
	var url = "<?php echo base_url(); ?>admin/custom_banner/getSubCategory";		
</script>       
<script src="<?php echo base_url(); ?>assets/admin/javascripts/banner.js" type="text/javascript"></script>       