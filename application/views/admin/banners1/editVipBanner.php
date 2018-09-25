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
                                            <div class="btn-group">
                                                <a class="btn " style="margin-right: 5px;" href="<?php echo base_url() . "admin/custom_banner/vipBanner/10"; ?>"><i class="icon-list"></i> VIP Banner List</a>
                                                <a class="btn " href="<?php echo base_url() . "admin/custom_banner/addvip/10"; ?>"><i class="icon-plus"></i> Add VIP Banner</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>
                                                <div class='icon-edit'></div>
                                                Edit VIP Banner
                                            </div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content'>
                                            <form enctype="multipart/form-data" action="" method="post" name="category" class="validate-form  form-horizontal" style="margin-bottom: 0;"  accept-charset="UTF-8">
												
												<div class='form-group'>
                                                    <label class='col-md-2 control-label'>Banner Show For</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" class="mobile-radio" name="ban_parent_status_0" id="mobile" value="mobile"  <?php echo ($bannerInfo[0]->ban_show_status == "both" || $bannerInfo[0]->ban_show_status == "ios" || $bannerInfo[0]->ban_show_status == "android" ) ? "checked" : ""; ?>/>Mobile 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" class="web" name="ban_show_status_0" id="web" value="web" <?php echo ($bannerInfo[0]->ban_show_status == "web") ? "checked" : ""; ?> />Web
                                                        </label>
                                                        <div class="mobile" style="display:none;">
                                                            <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_show_status" id="ios" value="ios"  <?php echo ($bannerInfo[0]->ban_show_status == "ios") ? "checked" : ""; ?>/>IOS 
                                                            </label>
                                                            <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_show_status" id="andriod" value="andriod" <?php echo ($bannerInfo[0]->ban_show_status == "andriod") ? "checked" : ""; ?> />Andriod
                                                            </label>
                                                            <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_show_status" id="both" value="both" <?php echo ($bannerInfo[0]->ban_show_status == "both") ? "checked" : ""; ?> />Both
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>												
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Banner Type</label>
                                                    <div class='col-md-5'>
														<?php if($bannerInfo[0]->ban_type_name == 'header') 
																$dip_pg1	= 'header';
															elseif($bannerInfo[0]->ban_type_name == 'sidebar')		
																$dip_pg1	= 'sidebar';
															elseif($bannerInfo[0]->ban_type_name == 'between')
																$dip_pg1	= 'between';
															else
																$dip_pg1	= '';
														?>
														<input type="hidden" name="ban_name" value ="<?php echo $dip_pg1; ?>"> 
                                                        <select name="ban_name1" id="ban_type" class="form-control" disabled>
															<option value="header" <?php echo ($bannerInfo[0]->ban_type_name == 'header') ? " selected" : ""; ?>>Header Banner</option>
															<option value="sidebar" <?php echo ($bannerInfo[0]->ban_type_name == 'sidebar') ? " selected" : ""; ?>>Sidebar Banner</option>
                                                            <option value="between" <?php echo ($bannerInfo[0]->ban_type_name == 'between') ? " selected" : ""; ?>>Between Items (Footer for MobileApp)</option>
                                                            <!-- <option value="intro" <?php //echo ($bannerInfo[0]->ban_type_name == 'intro') ? " selected" : ""; ?>>Intro Banner</option>
                                                            <option value="footer" <?php //echo ($bannerInfo[0]->ban_type_name == 'footer') ? " selected" : ""; ?>>Footer Banner</option>
                                                            <option value="offer" <?php //echo ($bannerInfo[0]->ban_type_name == 'offer') ? " selected" : ""; ?>>Offer Banner</option>
                                                            <option value="feature" <?php //echo ($bannerInfo[0]->ban_type_name == 'feature') ? " selected" : ""; ?>>Feature Banner</option>
                                                            <option value="between items" <?php //echo ($bannerInfo[0]->ban_type_name == 'between items') ? " selected" : ""; ?>>Web Banner</option>
                                                            <option value="sponsor" <?php //echo ($bannerInfo[0]->ban_type_name == 'sponsor') ? " selected" : ""; ?>>Web Banner</option>  -->
                                                        </select>
                                                    </div>
                                                </div>
												<div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Page</label>
                                                    <div class='col-md-5'>
														<?php if($bannerInfo[0]->display_page == 'all_page') 
																$dip_pg	= 'all_page';
															elseif($bannerInfo[0]->display_page == 'home_page')		
																$dip_pg	= 'home_page';
															elseif($bannerInfo[0]->display_page == 'content_page')
																$dip_pg	= 'content_page';
															else
																$dip_pg	= '';
														?>
														<input type="hidden" name="display_page_0" value ="<?php echo $dip_pg; ?>"> 
                                                        <select name="display_pag" id="display_page" class='form-control' onchange="hide_show_cat(this.value);" disabled>
                                                            <option value="all_page" <?php echo ($bannerInfo[0]->display_page == 'all_page') ? " selected" : ""; ?>>All Page</option>
                                                            <option value="home_page" <?php echo ($bannerInfo[0]->display_page == 'home_page') ? " selected" : ""; ?>>Home Page</option>
															<option value="content_page" <?php echo ($bannerInfo[0]->display_page == 'content_page') ? " selected" : ""; ?>>Content Page</option>
														</select>
                                                    </div>
                                                </div>
												<?php  $catind=(int)$bannerInfo[0]->cat_id;  ?>
												
                                                <div id="cat_section" style="<?php if($catind!=0) echo ''; else echo 'display:none;'; ?>">
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputSelect'>Select Super Category</label>
                                                        <div class='col-md-5'>
                                                            <select name="super_category" id="superCategory_0_0"  onchange="showSubcategory(this, '0', '0')" class="form-control">
                                                                <option>Select Super Category</option>
                                                                <?php
                                                                foreach ($superCategories as $scategory) {    ?>
                                                                    <option value="<?php echo $scategory['category_id']; ?>" <?php echo ($catind == $scategory['category_id']) ? 'selected' : ''; ?> style="padding-top:15px;"><?php echo str_replace('\n', " ", $scategory['catagory_name']); ?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputSelect'>Select Sub Category</label>
                                                        <div class='col-md-5'>
                                                            <select name="sub_category" id="sub_category_0_0" class="form-control">   
                                                                <option value="0" >ALL</option>
                                                                <?php
                                                                foreach ($sub_cat as $row) {
                                                                    if (($bannerInfo[0]->sup_cat_id == $row['sub_category_id']) ? 'selected' : '')
                                                                        echo " <option value='" . $row['sub_category_id'] . "' selected >" . str_replace('\n', " ", $row['sub_category_name']) . "</option>";
                                                                    else
                                                                        echo " <option value='" . $row['sub_category_id'] . "' >" . str_replace('\n', " ", $row['sub_category_name']) . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class='hr-normal'>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Select Banner</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_txt_img" id="text_banner" value="text"  <?php echo ($bannerInfo[0]->ban_txt_img == "text") ? "checked" : ""; ?>/>
                                                            Text Banner
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_txt_img" id="img_banner" value="image"  <?php echo ($bannerInfo[0]->ban_txt_img == "image") ? "checked" : ""; ?>/>
                                                            Image Banner
                                                        </label>
                                                    </div>
                                                </div>

                                                <?php
                                                if ($bannerInfo[0]->ban_txt_img == "text") {
                                                    ?>
                                                    <div class='form-group' id="text_1">
                                                        <label class='col-md-2 control-label' for='inputTextArea1'>Enter Text</label>
                                                        <div class='col-md-5'>
                                                            <textarea rows="5"   class="form-control" style="direction:ltr; text-align:left; "><?php echo $bannerInfo[0]->text_val; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <?php
                                                } else if ($bannerInfo[0]->ban_txt_img == "image") {
                                                    ?>

                                                    <div class='form-group' id="img_2">
                                                        <label class='col-md-2 control-label' for=''>Big Banner Image(For Website)</label>
                                                        <div class='col-md-9'>
															<?php $this->load->view('admin/banners/include_big_div');  
															
                                                            if ($bannerInfo[0]->big_img_file_name != "") {
                                                                echo "<img class='img-responsive' src='" . base_url() . banner . "medium/" . $bannerInfo[0]->big_img_file_name . "' width='200'/><br>";
                                                            }
                                                            ?>
                                                            <!-- <input name="" type="file" class='form-control'/> -->
															<div class='col-md-5'>
																<input name="uploadedlargefile" id="uploadedlargefile" type="file" class='form-control' onchange="javascript:loadimage(this);"/>
															</div><br><br><br><br>
															<img alt="Banner Image" src="" width="150px" height="150px" id="blah1">
                                                        </div>
                                                    </div>
                                                    <div class='form-group' id="img_3">
                                                        <label class='col-md-2 control-label' for=''>Small Banner Image(For MobileApp)</label>
                                                        <div class='col-md-9'>
															<?php $this->load->view('admin/banners/include_small_div');  ?> 
                                                            <?php
                                                            if ($bannerInfo[0]->img_file_name != "") {
                                                                echo "<img class='img-responsive' src='" . base_url() . banner . "medium/" . $bannerInfo[0]->img_file_name . "' width='200'/><br>";
                                                            }
                                                            ?>
                                                            <!-- <input name="" type="file" class="form-control"/> -->
															<div class='col-md-5'>
																<input name="uploadedfile" id="uploadedfile" type="file" class="form-control" onchange="javascript:loadimage_small(this);"/>
															</div>
																<br><br><br><br>
																<img alt="Banner Image" src="" width="150px" height="150px" id="blah2">
														</div>
                                                     </div>
                                                    <div class='form-group' id="site_url_hide">
                                                        <label class='col-md-2 control-label' for='inputText'>Site URL</label>
                                                        <div class='col-md-5'>
                                                            <input name="site_url" class='form-control'  type='text' value="<?php echo $bannerInfo[0]->site_url; ?>">
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>                                                
                                                <div class='form-group' >
                                                    <label class='col-md-2 control-label' for='inputText'>Phone Number</label>
                                                    <div class='col-md-5'>
                                                        <input name="phone_no" class='form-control' id='inputText' placeholder='Phone Number' type='text' value="<?php echo $bannerInfo[0]->phone_no; ?>" onkeypress="return isNumber(event)">
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Advertiser</label>
                                                    <div class='col-md-5 controls'>
                                                        <input name="adv" class='form-control' id='inputText' placeholder='Advertiser' type='text' value="<?php echo $bannerInfo[0]->advertiser; ?>" data-rule-required='true'>
                                                        <?php /* <select name="adv" class="form-control">
                                                            <?php
                                                            foreach ($advertiser as $adv) {
                                                                if ($adv['user_id'] == ($bannerInfo[0]->adv_id)) {
                                                                    echo "<option value=" . $adv['user_id'] . " selected>" . $adv['username'] . "</option>";
                                                                } else {
                                                                    echo "<option value=" . $adv['user_id'] . ">" . $adv['username'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select> */ ?>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Status</label>
                                                    <div class='col-md-5'>
                                                        <select name="status" class="form-control">
                                                            <option value="0"<?php echo ($bannerInfo[0]->status == 0) ? " selected" : ""; ?>>Inactive</option>
                                                            <option value="1"<?php echo ($bannerInfo[0]->status == 1) ? " selected" : ""; ?>>Active</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Pause Banner</label>
                                                    <div class='col-md-5'>
                                                        <select name="pause_banner" class="form-control" >
                                                            <option value="yes"<?php echo ($bannerInfo[0]->pause_banner == 'yes') ? " selected" : ""; ?>>Yes</option>
                                                            <option value="no"<?php echo ($bannerInfo[0]->pause_banner == 'no') ? " selected" : ""; ?>>No</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Start Date</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="st_dt" id="st_now" value="st_now"  />
                                                            Start Immediately 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="st_dt" id="st_cust" value="st_cust" checked />
                                                            Custom Start Date
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group' id='start_dt' >
                                                    <label class='col-md-2 control-label' for='inputText'></label>
                                                    <div class='col-md-5'>
                                                        <div class='datetimepicker input-group' id='datepicker'>
                                                            <input class='form-control' data-format='yyyy-MM-dd' name="ex_st_dt" placeholder='Select Start Date' type='text' value="<?php echo $bannerInfo[0]->expiry_start_date; ?>">
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
                                                            <input type="radio" name="end_dt" id="end_never" value="end_never"  />
                                                            No End Date 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="end_dt" id="end_cust" value="end_cust"  checked/>
                                                            Custom End Date 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group' id='end_dt'>
                                                    <label class='col-md-2 control-label' for='inputText'></label>
                                                    <div class='col-md-5'>
                                                        <div class='datetimepicker input-group' id='datepicker'>
                                                            <input class='form-control' data-format='yyyy-MM-dd' name="ex_end_dt" placeholder='Select End Date' type='text' value="<?php echo $bannerInfo[0]->expiry_end_date; ?>">
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
                                                            <option value="0">All</option>
                                                            <?php foreach ($state as $o) { ?>
                                                                <option value="<?php echo $o['state_id']; ?>" <?php echo ($bannerInfo[0]->state == $o['state_id']) ? 'selected' : ''; ?> ><?php echo $o['state_name']; ?></option>
                                                            <?php } ?>
                                                        </select>	                  
                                                    </div>
                                                </div>
                                                <hr class="hr-normal">
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'>Impression/Days</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" name="impression_day" size="10" class="form-control" value="<?php echo $bannerInfo[0]->impression_day; ?>" data-rule-required='true'/>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'>Clicks/Days</label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="text" name="clicks_day" size="10" class="form-control" value="<?php echo$bannerInfo[0]->clicks_day; ?>" data-rule-required='true'/>
                                                    </div>
                                                </div> 
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Bidding Options</label>
                                                    <div class='col-md-10'>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="rd_cpm_cpc" id="rd_cpm" value="cpm"  <?php echo($bannerInfo[0]->cpm > 0) ? 'checked' : '' ?>/>
                                                            CPM(Cost Per Measurement) 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="rd_cpm_cpc" id="rd_cpc" value="cpc"  <?php echo($bannerInfo[0]->cpc > 0) ? 'checked' : '' ?>/>
                                                            CPC(Cost Per Click)
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'>Target Value</label>
                                                    <div class='col-md-5'>
                                                        <?php
                                                        if ($bannerInfo[0]->cpm != 0)
                                                            echo '<input type="text" class="form-control" name="cpc_cpm" size="10" value="' . $bannerInfo[0]->cpm . '"/>';
                                                        else
                                                            echo '<input type="text" class="form-control" name="cpc_cpm" size="10" value="' . $bannerInfo[0]->cpc . '"/>';
                                                        ?>
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
<script>
	var cat_value = '<?php echo $bannerInfo[0]->ban_type_name; ?>';
	var url = "<?php echo base_url(); ?>admin/custom_banner/getSubCategory";		
</script>       
<script src="<?php echo base_url(); ?>assets/admin/javascripts/banner.js" type="text/javascript"></script>