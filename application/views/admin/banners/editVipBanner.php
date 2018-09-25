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
                                            <?php 
                                            $redirect = $_SERVER['QUERY_STRING'];
                                            if(!empty($_SERVER['QUERY_STRING']))
                                                $redirect = '/?'.$redirect;
                                            ?>
                                        </h1>
                                        <div class='pull-right'>
                                            <?php
                                            if ($this->uri->segment(5) != '')
                                                $banner_for = $this->uri->segment(5);
                                            else
                                                $banner_for = '';
                                            ?>
                                            <div class="btn-group">
                                                <a class="btn " style="margin-right: 5px;" href="<?php echo base_url() . "admin/custom_banner/vipBanner/10/" . $banner_for; ?>"><i class="icon-list"></i> VIP Banner List</a>
                                                <a class="btn " href="<?php echo base_url() . "admin/custom_banner/addvip/10/" . $banner_for; ?>"><i class="icon-plus"></i> Add VIP Banner</a>
                                            </div>
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
                                                <div class='icon-edit'></div>
                                                Edit VIP Banner
                                            </div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content'>
                                            <form enctype="multipart/form-data" action="<?php site_url().'custom_banner/editcustom/10/web/'.$redirect; ?>" method="post" name="category" class="validate-form  form-horizontal" style="margin-bottom: 0;"  accept-charset="UTF-8">
                                                <div class='form-group' style="display:none;">
                                                    <label class='col-md-2 control-label' for='inputSelect'>Banner For</label>
                                                    <div class='col-md-5'>
                                                        <select name="ban_name_0" id="ban_for" class='form-control' disabled>
                                                            <option value="web" <?php if ($bannerInfo[0]->ban_show_status == 'web') echo 'selected'; ?>>Web</option>
                                                            <?php $arr_mob = array('ios', 'android', 'both'); ?>
                                                            <option value="mobile" <?php if (in_array($bannerInfo[0]->ban_show_status, $arr_mob)) echo 'selected'; ?> >Mobile</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php if (in_array($bannerInfo[0]->ban_show_status, $arr_mob)) { ?>
                                                    <div class='form-group' id="mobile">
                                                        <label class='col-md-2 control-label'>Banner For Mobile</label>
                                                        <div class='col-md-10'>                                                        
                                                            <div class="mobile">
                                                                <label class='radio radio-inline'>
                                                                    <input type="radio" name="ban_show_status_0" id="ios" value="ios"   
                                                                    <?php if ($bannerInfo[0]->ban_show_status == 'ios') echo 'checked=checked'; ?>
                                                                           />IOS 
                                                                </label>
                                                                <label class='radio radio-inline'>
                                                                    <input type="radio" name="ban_show_status_0" id="android" value="android"  
                                                                    <?php if ($bannerInfo[0]->ban_show_status == 'android') echo 'checked=checked'; ?>	
                                                                           />Android
                                                                </label>
                                                                <label class='radio radio-inline'>
                                                                    <input type="radio" name="ban_show_status_0" id="both" value="both" 
                                                                    <?php if ($bannerInfo[0]->ban_show_status == 'both') echo 'checked=checked'; ?>	
                                                                           />Both
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Banner Type</label>
                                                    <div class='col-md-5'>
                                                        <?php
                                                        if ($bannerInfo[0]->ban_type_name == 'header')
                                                            $dip_pg1 = 'header';
                                                        elseif ($bannerInfo[0]->ban_type_name == 'sidebar')
                                                            $dip_pg1 = 'sidebar';
                                                        elseif ($bannerInfo[0]->ban_type_name == 'between')
                                                            $dip_pg1 = 'between';
                                                        elseif ($bannerInfo[0]->ban_type_name == 'intro')
                                                            $dip_pg1 = 'intro';
                                                        elseif ($bannerInfo[0]->ban_type_name == 'feature')
                                                            $dip_pg1 = 'feature';
                                                        elseif ($bannerInfo[0]->ban_type_name == 'footer')
                                                            $dip_pg1 = 'footer';
                                                        elseif ($bannerInfo[0]->ban_type_name == 'between_app')
                                                            $dip_pg1 = 'between_app';
                                                        else
                                                            $dip_pg1 = '';
                                                        ?>
                                                        <input type="hidden" name="ban_name" value ="<?php echo $dip_pg1; ?>"> 
                                                        <select name="ban_name1" id="ban_type" class="form-control" disabled>
                                                            <option value="header" <?php echo ($bannerInfo[0]->ban_type_name == 'header') ? " selected" : ""; ?>>Header Banner</option>
                                                            <option value="sidebar" <?php echo ($bannerInfo[0]->ban_type_name == 'sidebar') ? " selected" : ""; ?>>Sidebar Banner</option>

                                                            <option value="between" <?php echo ($bannerInfo[0]->ban_type_name == 'between') ? " selected" : ""; ?>>Between Banner</option>

                                                            <option value="intro" <?php echo ($bannerInfo[0]->ban_type_name == 'intro') ? " selected" : ""; ?>>Intro Banner</option>

                                                            <option value="feature" <?php echo ($bannerInfo[0]->ban_type_name == 'feature') ? " selected" : ""; ?>>Feature Banner</option>

                                                            <option value="footer" <?php echo ($bannerInfo[0]->ban_type_name == 'footer') ? " selected" : ""; ?>>Footer Banner</option>

                                                            <option value="between_app" <?php echo ($bannerInfo[0]->ban_type_name == 'between_app') ? " selected" : ""; ?>>Between Banner</option>

<!--<option value="footer" <?php //echo ($bannerInfo[0]->ban_type_name == 'footer') ? " selected" : "";   ?>>Footer Banner</option>
<option value="offer" <?php //echo ($bannerInfo[0]->ban_type_name == 'offer') ? " selected" : "";   ?>>Offer Banner</option>
<option value="feature" <?php //echo ($bannerInfo[0]->ban_type_name == 'feature') ? " selected" : "";   ?>>Feature Banner</option>
<option value="between items" <?php //echo ($bannerInfo[0]->ban_type_name == 'between items') ? " selected" : "";   ?>>Web Banner</option>
<option value="sponsor" <?php //echo ($bannerInfo[0]->ban_type_name == 'sponsor') ? " selected" : "";   ?>>Web Banner</option>  -->
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Page</label>
                                                    <div class='col-md-5'>
                                                        <?php
                                                        if ($bannerInfo[0]->display_page == 'all_page')
                                                            $dip_pg = 'all_page';
                                                        elseif ($bannerInfo[0]->display_page == 'home_page')
                                                            $dip_pg = 'home_page';
                                                        elseif ($bannerInfo[0]->display_page == 'content_page')
                                                            $dip_pg = 'content_page';
                                                        
                                                        elseif ($bannerInfo[0]->display_page == 'bw_home_page_ban1')
                                                            $dip_pg = 'bw_home_page_ban1';
                                                        elseif ($bannerInfo[0]->display_page == 'bw_home_page_ban2')
                                                            $dip_pg = 'bw_home_page_ban2';
                                                        
                                                        elseif ($bannerInfo[0]->display_page == 'latest_ads_page')
                                                            $dip_pg = 'latest_ads_page';
                                                        
                                                        elseif ($bannerInfo[0]->display_page == 'store_all_page')
                                                            $dip_pg = 'store_all_page';
                                                        elseif ($bannerInfo[0]->display_page == 'specific_store_page')
                                                            $dip_pg = 'specific_store_page';
                                                        elseif ($bannerInfo[0]->display_page == 'store_content_page')
                                                            $dip_pg = 'store_content_page';
                                                        elseif ($bannerInfo[0]->display_page == 'store_page_content')
                                                            $dip_pg = 'store_page_content';

                                                        elseif ($bannerInfo[0]->display_page == 'off_all_page')
                                                            $dip_pg = 'off_all_page';
                                                        elseif ($bannerInfo[0]->display_page == 'off_home_page')
                                                            $dip_pg = 'off_home_page';
                                                        elseif ($bannerInfo[0]->display_page == 'off_cat_cont')
                                                            $dip_pg = 'off_cat_cont';
                                                        elseif ($bannerInfo[0]->display_page == 'off_comp_cont')
                                                            $dip_pg = 'off_comp_cont';
                                                        elseif ($bannerInfo[0]->display_page == 'off_cat_side')
                                                            $dip_pg = 'off_cat_side';
                                                        elseif ($bannerInfo[0]->display_page == 'off_comp_side')
                                                            $dip_pg = 'off_comp_side';

                                                        elseif ($bannerInfo[0]->display_page == 'after_splash_screen')
                                                            $dip_pg = 'after_splash_screen';
                                                        elseif ($bannerInfo[0]->display_page == 'before_latest_ads')
                                                            $dip_pg = 'before_latest_ads';
                                                        elseif ($bannerInfo[0]->display_page == 'before_featured_items')
                                                            $dip_pg = 'before_featured_items';
                                                        else
                                                            $dip_pg = '';
                                                        ?>
                                                        <input type="hidden" name="display_page_0" value ="<?php echo $dip_pg; ?>"> 
                                                        <select name="display_pag" id="display_page" class='form-control' onchange="hide_show_cat(this.value);" disabled >
                                                            <?php if($banner_for=='web') { ?>
                                                            <option value="">Select</option>
                                                            <option value="all_page" <?php echo ($bannerInfo[0]->display_page == 'all_page') ? " selected" : ""; ?>>All Classified Pages</option>
                                                            <option value="home_page" <?php echo ($bannerInfo[0]->display_page == 'home_page') ? " selected" : ""; ?>>Classified Home Page</option>
                                                            <option value="content_page" <?php echo ($bannerInfo[0]->display_page == 'content_page') ? " selected" : ""; ?>>Classified Content Page</option>
                                                            
                                                            <option value="bw_home_page_ban1" <?php echo ($bannerInfo[0]->display_page == 'bw_home_page_ban1') ? " selected" : ""; ?>>Classified Home Page Between Banner 1</option>
                                                            <option value="bw_home_page_ban2" <?php echo ($bannerInfo[0]->display_page == 'bw_home_page_ban2') ? " selected" : ""; ?>>Classified Home Page Between Banner 2</option>
                                                            <option value="latest_ads_page" <?php echo ($bannerInfo[0]->display_page == 'latest_ads_page') ? " selected" : ""; ?>>Classified Latest Ads Page</option>
                                                            
                                                            
                                                            <option value="store_all_page" <?php echo ($bannerInfo[0]->display_page == 'store_all_page') ? " selected" : ""; ?>>All Store Pages</option>
                                                            <option value="specific_store_page" <?php echo ($bannerInfo[0]->display_page == 'specific_store_page') ? " selected" : ""; ?>>Specific Store Page</option>
                                                            <option value="store_content_page" <?php echo ($bannerInfo[0]->display_page == 'store_content_page') ? " selected" : ""; ?>>Store Item Details Page</option>
                                                            <option value="store_page_content" <?php echo ($bannerInfo[0]->display_page == 'store_page_content') ? " selected" : ""; ?>>Store Landing Page</option>

                                                            <option value="off_all_page" <?php echo ($bannerInfo[0]->display_page == 'off_all_page') ? " selected" : ""; ?>>All Offer Pages</option>
                                                            <option value="off_home_page" <?php echo ($bannerInfo[0]->display_page == 'off_home_page') ? " selected" : ""; ?>>Offer Home Page</option>
                                                            <option value="off_catent_page" <?php echo ($bannerInfo[0]->display_page == 'off_catent_page') ? " selected" : ""; ?>>Offer Details Page</option>
                                                            
                                                            <option value="off_cat_cont" <?php echo ($bannerInfo[0]->display_page == 'off_cat_cont') ? " selected" : ""; ?>>Category Wise Offers Page</option>
                                                            <option value="off_comp_cont" <?php echo ($bannerInfo[0]->display_page == 'off_comp_cont') ? " selected" : ""; ?>>Company Wise Offers Page</option>
                                                            <option value="off_cat_side" <?php echo ($bannerInfo[0]->display_page == 'off_cat_side') ? " selected" : ""; ?>>Categories Block on Offer's Home Page</option>
                                                            <option value="off_comp_side" <?php echo ($bannerInfo[0]->display_page == 'off_comp_side') ? " selected" : ""; ?>>Companies  Block on Offer's Home Page</option>
                                                            <?php } elseif($banner_for=='mobile') { ?>
                                                            <option value="all_page" <?php echo ($bannerInfo[0]->display_page == 'all_page') ? " selected" : ""; ?>>All Pages</option>
                                                            <option value="home_page" <?php echo ($bannerInfo[0]->display_page == 'home_page') ? " selected" : ""; ?>>Home Page</option>
                                                            <option value="content_page" <?php echo ($bannerInfo[0]->display_page == 'content_page') ? " selected" : ""; ?>>Content Page</option>
                                                            <option value="after_splash_screen" <?php echo ($bannerInfo[0]->display_page == 'after_splash_screen') ? " selected" : ""; ?> >After splash screen</option>
                                                            <option value="before_latest_ads" <?php echo ($bannerInfo[0]->display_page == 'before_latest_ads') ? " selected" : ""; ?>>Before latest ads</option>
                                                            <option value="before_featured_items" <?php echo ($bannerInfo[0]->display_page == 'before_featured_items') ? " selected" : ""; ?>>Before featured items</option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php
                                                $catind = (int) $bannerInfo[0]->cat_id;
                                                $merger_cat_subcat = array();
                                                $catt_arr = array();
                                                if (in_array($bannerInfo[0]->display_page, array('content_page', 'off_cat_cont'))) {
                                                    if (isset($bannerInfo[0]->cat_id) && $bannerInfo[0]->cat_id != '') {
                                                        $catt_arr = explode(",", $bannerInfo[0]->cat_id);
                                                        $subcatt_arr = explode(",", $bannerInfo[0]->sub_cat_id);

                                                        $merger_cat_subcat = array_combine($catt_arr, $subcatt_arr);
                                                        ?>
                                                        <div id="cat_section" >
                                                            <?php
                                                            $ii = 0;
                                                            foreach ($merger_cat_subcat as $key => $cat) {
                                                                ?>
                                                                <div class='form-group'>
                                                                    <label class='col-md-2 control-label' for='inputSelect'>Select Super Category</label>
                                                                    <div class='col-md-5'>
                                                                        <select name="superCategory_0[]" id="superCategory_0_<?php echo $ii; ?>"  onchange="showSubcategory(this, '<?php echo $ii; ?>', '<?php echo $ii; ?>')" class="form-control cat_section_">
                                                                            <option value="0">Select Super Category</option>
                                                                            <?php foreach ($superCategories as $scategory) { ?>
                                                                                <option value="<?php echo $scategory['category_id']; ?>" <?php echo ($key == $scategory['category_id']) ? 'selected' : ''; ?> style="padding-top:15px;"><?php echo str_replace('\n', " ", $scategory['catagory_name']); ?></option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class='form-group'>
                                                                    <label class='col-md-2 control-label' for='inputSelect'>Select Sub Category</label>
                                                                    <div class='col-md-5'>															
                                                                        <select name="subcategory_0[]" id="sub_category_0_<?php echo $ii; ?>" class="form-control sub_cat_section_">   
                                                                            <option value="0" >ALL</option>
                                                                            <?php
                                                                            $sub_cat = $this->dbcommon->getsub_category($key);
                                                                            foreach ($sub_cat as $row) {
                                                                                if (($cat == $row['sub_category_id']) ? 'selected' : '')
                                                                                    echo " <option value='" . $row['sub_category_id'] . "' selected >" . $row['sub_category_name'] . "</option>";
                                                                                else
                                                                                    echo " <option value='" . $row['sub_category_id'] . "' >" . $row['sub_category_name'] . "</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                $ii++;
                                                            }
                                                            ?>                              
                                                        </div>
                                                    <?php }
                                                    ?>
                                                    <div class='form-group' id="addNewCategoryLink_0">
                                                        <label class='col-md-2 control-label' for='inputSelect'></label>
                                                        <div class='col-md-5'>
                                                            <div class="btn-group">
                                                                <a class="btn hidden-xs" style="margin-right: 5px;" href="javaScript:void(0);" onclick="addNewCategory(0)">Click to Add More Category</a> 
                                                                <a class="btn hidden-xs" href="javaScript:void(0);" onclick="removeLastCategory(0)" id="remove_link">Remove Last Category</a>
                                                            </div>
                                                            <?php
                                                            if (count($catt_arr) == 0)
                                                                $count = -1;
                                                            else
                                                                $count = count($catt_arr) - 1;
                                                            ?>
                                                            <input type="hidden" id="cat_total_0" name="cat_total_0" value="<?php echo $count; ?>" />
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <?php
                                                if (in_array($bannerInfo[0]->display_page, array('specific_store_page','store_content_page'))) {
                                                    if (isset($bannerInfo[0]->store_id) && $bannerInfo[0]->store_id != '') {
                                                        $store_arr = explode(",", $bannerInfo[0]->store_id);
                                                        $ii = 0;
                                                        ?>
                                                        <div id="store_section">
                                                            <?php  foreach ($store_arr as $key => $st) { ?> 
                                                            <div class='form-group'>
                                                                <label class='col-md-2 control-label' for='inputText1'>Store</label>
                                                                <div class='col-md-5'>
                                                                    <select class="select2 form-control"  name="store_id_0[]" id="store_id_0_<?php echo $ii; ?>">
                                                                        <option value="0">All</option>
                                                                        <?php foreach ($stores as $s) { ?>
                                                                        
                                                                            <option value="<?php echo $s['store_id']; ?>" <?php echo ($st == $s['store_id']) ? 'selected' : ''; ?>  ><?php echo $s['store_domain'] . '.doukani.com'; ?></option>
        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        <?php 
                                                            $ii++;
                                                            } 
                                                        ?>
                                                        </div>  
                                                    <?php } ?>  
                                                    <div class='form-group' id="addNewStoreLink_0">
                                                        <label class='col-md-2 control-label' for='inputSelect'></label>
                                                        <div class='col-md-5'>
                                                            <div class="btn-group">
                                                                <a class="btn hidden-xs" style="margin-right: 5px;" href="javaScript:void(0);" onclick="addNewStore(0)">Click to Add More Store</a> 
                                                                <a class="btn hidden-xs" href="javaScript:void(0);" onclick="removeLastStore(0)" id="remove_link_store">Remove Last Store</a>
                                                            </div>
                                                            <?php
                                                            if (isset($store_arr) && count($store_arr) == 0)
                                                                $count = -1;
                                                            else
                                                                $count = count($store_arr) - 1;
                                                            ?>
                                                            <input type="hidden" id="store_total_0" name="store_total_0" value="<?php echo $count; ?>" />
                                                        </div>
                                                    </div>
                                                <?php } 
                                                if (in_array($bannerInfo[0]->display_page, array('off_comp_cont'))) {
                                                    if (isset($bannerInfo[0]->user_company_id) && $bannerInfo[0]->user_company_id != '') {
                                                        $company_arr = explode(",", $bannerInfo[0]->user_company_id);
                                                        $ii = 0;
                                                        if(sizeof($company_arr)>0) {
                                                        ?>
                                                        <div id="company_section">
                                                            <?php  foreach ($company_arr as $key => $st) { ?> 
                                                            <div class='form-group'>
                                                                <label class='col-md-2 control-label' for='inputText1'>Store</label>
                                                                <div class='col-md-5'>
                                                                    <select class="select2 form-control"  name="company_id_0[]" id="company_id_0_<?php echo $ii; ?>">
                                                                        <option value="0">All</option>
                                                                        <?php foreach ($company as $s) { ?>
                                                                        
                                                                            <option value="<?php echo $s['id']; ?>" <?php echo ($st == $s['id']) ? 'selected' : ''; ?>  ><?php echo $s['company_name']; ?></option>
        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        <?php 
                                                            $ii++;
                                                            } 
                                                        ?>
                                                        </div>  
                                                <?php } } ?>
                                                    <div class='form-group' id="addNewCompanyLink_0">
                                                        <label class='col-md-2 control-label' for='inputSelect'></label>
                                                        <div class='col-md-5'>
                                                            <div class="btn-group">
                                                                <a class="btn hidden-xs" style="margin-right: 5px;" href="javaScript:void(0);" onclick="addNewCompany(0)">Click to Add More Company</a> 
                                                                <a class="btn hidden-xs" href="javaScript:void(0);" onclick="removeLastCompany(0)" id="remove_link_company">Remove Last Company</a>
                                                            </div>
                                                            <?php
                                                            $count = 0;
                                                            if(isset($company_arr) && sizeof($company_arr)>0) {
                                                                if (isset($company_arr) && count($company_arr) == 0)
                                                                    $count = -1;
                                                                else
                                                                    $count = count($company_arr) - 1;
                                                            }
                                                            ?>
                                                            <input type="hidden" id="company_total_0" name="company_total_0" value="<?php echo $count; ?>" />
                                                        </div>
                                                    </div>
                                                <?php }  ?>
                                                
                                                <hr class='hr-normal'>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label'>Select Banner</label>
                                                    <div class='col-md-10'>    
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_txt_img_0" id="text_banner" value="text" <?php echo ($bannerInfo[0]->ban_txt_img == "text") ? "checked" : ""; ?> />
                                                            Text Banner
                                                        </label>                                                    
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="ban_txt_img_0" id="img_banner" value="image"  <?php echo ($bannerInfo[0]->ban_txt_img == "image") ? "checked" : ""; ?>/>
                                                            Image Banner
                                                        </label>
                                                    </div>
                                                </div>	
<?php //if($bannerInfo[0]->ban_txt_img == "text") {   ?>					
                                                <div class='form-group' id="text_val">
                                                    <label class='col-md-2 control-label' for='inputTextArea1'>Enter Text</label>
                                                    <div class='col-md-5'>
                                                        <textarea class='form-control' id='' placeholder='Textarea' rows="5"  name="text_ad" style="direction:ltr; text-align:left; "><?php echo $bannerInfo[0]->text_val; ?></textarea>
                                                    </div>
                                                </div>
<?php //}   ?>		
                                                <div id="big_img">											
<?php if ($dip_pg1 != '' && ($dip_pg1 == 'header' || $dip_pg1 == 'between' || $dip_pg1 == 'sidebar')) { ?>
                                                        <div class='form-group'>
                                                            <label class='col-md-2 control-label' for=''></label>
                                                            <div class='col-md-9'>
                                                                <label class='col-md-5 control-label' for=''>Big Banner Image(For Website)</label>
                                                            </div>
                                                        </div>												
    <?php
    if ($bannerInfo[0]->ban_txt_img == "image") {
        ?>
                                                            <div class='form-group' style="<?php if ($bannerInfo[0]->ban_txt_img == "image" || $bannerInfo[0]->img_file_name != "")
                                                                echo '';
                                                            else
                                                                echo 'display:none;'
            ?>" >
                                                                <label class='col-md-2 control-label' for=''></label>
                                                                <div class='col-md-9'>																
        <?php
        if ($bannerInfo[0]->big_img_file_name != "") { ?>
                                                                    <img class='img-responsive' src='<?php echo  base_url() . banner . "original/" . $bannerInfo[0]->big_img_file_name; ?>' onerror="this.src='<?php echo thumb_start_grid.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" /><br>
       <?php }
        ?>
                                                                </div>
                                                            </div>
    <?php } ?>
                                                        <div class='form-group' id="img_2" >
                                                            <label class='col-md-2 control-label' for=''></label>
                                                            <div class='col-md-9'>
                                        <?php $this->load->view('admin/banners/include_big_div'); ?>
                                                                <div class='col-md-5'>
                                                                    <input name="uploadedlargefile" id="uploadedlargefile" type="file" class='form-control' onchange="javascript:loadimage(this);"/>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label class='col-md-2 control-label' for='inputText'></label>
                                                            <div class='col-md-9'>
                                                                <img alt="Banner Image" src="" id="blah1">	
                                                            </div>
                                                        </div>
<?php } ?>
                                                </div>
                                                <div id="small_img"> 
                                                         <?php if ($dip_pg1 != '' && ($dip_pg1 == 'intro' || $dip_pg1 == 'feature' || $dip_pg1 == 'footer' || $dip_pg1 == 'between_app')) { ?>
                                                        <div class='form-group'>
                                                            <label class='col-md-2 control-label' for=''></label>
                                                            <div class='col-md-9'>
                                                                <label class='col-md-5 control-label' for=''>Small Banner Image(For MobileApp)</label>
                                                            </div>
                                                        </div>												
                                                                <?php if ($bannerInfo[0]->ban_txt_img == "image") { ?>
                                                            <div class='form-group'  style="<?php if ($bannerInfo[0]->ban_txt_img == "image" || $bannerInfo[0]->img_file_name != "")
                                                                echo '';
                                                            else
                                                                echo 'display:none;'
                                                                ?>" >
                                                                <label class='col-md-2 control-label' for=''></label>
                                                                <div class='col-md-9'>

                                                                    <?php
                                                                    if ($bannerInfo[0]->img_file_name != "") { ?>
                                                                    <img class='img-responsive' src='<?php echo base_url() . banner . "original/" . $bannerInfo[0]->img_file_name; ?>' onerror="this.src='<?php echo thumb_start_grid.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'" /><br>
                                                                    <?php }
                                                                    ?>                                                            
                                                                </div>
                                                            </div>													
                                                        <?php } ?>  
                                                        <div class='form-group' id="img_3">
                                                            <label class='col-md-2 control-label' for=''></label>
                                                            <div class='col-md-9'>
    <?php $this->load->view('admin/banners/include_small_div'); ?> 
                                                                <div class='col-md-5'>
                                                                    <input name="uploadedfile" id="uploadedfile" type="file" class="form-control" onchange="javascript:loadimage_small(this);"/>
                                                                </div><br><br><br><br>
                                                                
                                                            </div>
                                                        </div>	 
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText'></label>
                                                        <div class='col-md-9'>
                                                            <img alt="Banner Image" src="" id="blah2">	
                                                        </div>
                                                    </div>
<?php } ?>
                                                </div>
                                                <div class='form-group' id="site_url_hide">
                                                    <label class='col-md-2 control-label' for='inputText'>Site URL</label>
                                                    <div class='col-md-5'>
                                                        <input name="site_url" class='form-control'  type='text' value="<?php echo $bannerInfo[0]->site_url; ?>">
                                                    </div>
                                                </div>	
                                                <div class='form-group' >
                                                    <label class='col-md-2 control-label' for='inputText'>Phone Number</label>
                                                    <div class='col-md-5'>
                                                        <input name="phone_no" class='form-control' id='inputText' placeholder='Phone Number' type='text' value="<?php echo $bannerInfo[0]->phone_no; ?>" onkeypress="return isNumber(event)">
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputSelect'>Advertiser<span>*</span></label>
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

                                                <div class='form-group' >
                                                    <label class='col-md-2 control-label' for='inputText'>Start Date</label>
                                                    <div class='col-md-5'>
                                                        <div class='datetimepicker input-group' id='datepicker'>
                                                            <input class='form-control' data-format='yyyy-MM-dd' name="start_date" id="start_date" placeholder='Select Start Date' type='text' value="<?php echo $bannerInfo[0]->expiry_start_date; ?>" >
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
                                                            <input type="radio" name="end_dt_0" id="end_never" value="end_never"  <?php if (isset($bannerInfo[0]->is_endate) && $bannerInfo[0]->is_endate == 1) echo 'checked'; ?> />
                                                            No End Date
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="end_dt_0" id="end_cust" value="end_cust"  <?php if (isset($bannerInfo[0]->is_endate) && $bannerInfo[0]->is_endate == 0) echo 'checked'; ?>/>
                                                            Custom End Date
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class='form-group' id="end_dt">
                                                    <label class='col-md-2 control-label' for='inputText'></label>
                                                    <div class='col-md-5'>
                                                        <div class='datetimepicker input-group' id='datepicker'>
                                                            <input class='form-control' data-format='yyyy-MM-dd' name="end_date" id="end_date" placeholder='Select End Date' type='text' value="<?php echo (isset($bannerInfo[0]->expiry_end_date) && $bannerInfo[0]->expiry_end_date!='0000-00-00') ? $bannerInfo[0]->expiry_end_date : ''; ?>">
                                                            <span class='input-group-addon'>
                                                                <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                            </span>
                                                        </div>
                                                        <font color="#b94a48" style="font-size: 14px; font-weight:lighter !important; "><span id="lbl_dbo"></span></font>
                                                    </div>
                                                </div>                                               
                                                <hr class="hr-normal">
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'>Impressions<span>*</span></label>
                                                    <div class='col-md-5 controls'>
                                                        <input type="number" name="impression_day" id="impression_day" size="10" class="form-control" value="<?php echo $bannerInfo[0]->impression_day; ?>" data-rule-required='true' />
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
                                                        <input type="number" name="clicks_day" id="clicks_day" size="10" class="form-control" value="<?php echo $bannerInfo[0]->clicks_day; ?>" data-rule-required='true'  />
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
                                                            <input type="radio" name="duration" id="cpm" value="cpm"  <?php echo(isset($bannerInfo[0]->bidding_option) && $bannerInfo[0]->bidding_option == 'cpm') ? 'checked' : '' ?>/>
                                                            CPM(Cost Per Measurement) 
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="duration" id="cpc" value="cpc" <?php echo(isset($bannerInfo[0]->bidding_option) && $bannerInfo[0]->bidding_option == 'cpc') ? 'checked' : '' ?> />
                                                            CPC(Cost Per Click)
                                                        </label>
                                                        <label class='radio radio-inline'>
                                                            <input type="radio" name="duration" id="duration" value="duration"  <?php echo(isset($bannerInfo[0]->bidding_option) && $bannerInfo[0]->bidding_option == 'duration') ? 'checked' : '' ?>/>
                                                            Duration
                                                        </label>
                                                    </div>
                                                </div>             
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText'>Target Value</label>
                                                    <div class='col-md-5'>
<?php
$target_val = 0;
if ($bannerInfo[0]->bidding_option == 'cpm')
    $target_val = $bannerInfo[0]->cpm;
elseif ($bannerInfo[0]->bidding_option == 'cpc')
    $target_val = $bannerInfo[0]->cpc;
else
    $target_val = $bannerInfo[0]->duration;
?>
                                                        <input type="text" name="cpc_cpm_0" size="10" class="form-control" value="<?php echo $target_val; ?>" />
                                                    </div>
                                                </div>												
                                                <div class='form-actions form-actions-padding-sm' id="finalRow">
                                                    <div class='row'>
                                                        <div class='col-md-10 col-md-offset-2'>
                                                            <button class='btn btn-primary' type='submit' name="cat_save" id="submit" value="Save">
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                            <a  href='<?php echo base_url(); ?>admin/custom_banner/vipBanner/10/<?php echo $banner_for.$redirect; ?>' title="Cancel" class="btn ">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="total" name="total" value="<?php echo count($catt_arr) - 1; ?>" />
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
                    $("#sub_category_0" + "_" + secInd + ' option').remove();
                    $("#sub_category_0" + "_" + secInd).append('<option id="0" value="0">ALL</option>');
                    $("#sub_category_0" + "_" + secInd).append(data);
                });
            }

            function addNewCategory(ind)
            {

                var url = "<?php echo base_url(); ?>admin/custom_banner/addMoreCategory";
                var curt_id = $("#cat_total_" + ind).val();
                var display_page = $("#display_page").val();
                if (curt_id < 0)
                    curt_id = 0;
                var main_id = $("#total").val();
                if (main_id < 0)
                    main_id = 0;
                var total = parseInt(curt_id) + 1;

                $.post(url, {main_id: main_id, curt_id: curt_id, edit: 'edit', display_page: display_page}, function (data)
                {
                    $("#addNewCategoryLink_" + ind).before(data);
                    $("#cat_total_" + ind).val(total);
                    $("#total").val(total);
                });
            }

            var tot_cat = $("#total").val();
            if (tot_cat < '-1')
                $('#remove_link').hide();

            function removeLastCategory(ind) {

                var curt_id = $("#cat_total_" + ind).val();

                if (curt_id < '0')
                    curt_id = '0';
                var tot_cat = $("#total").val();

                if (tot_cat < '-1') {
                    $('#remove_link').hide();
                }
                else
                {
                    $('#superCategory_0_' + curt_id).closest('div').parent().remove();
                    $('#sub_category_0_' + curt_id).closest('div').parent().remove();
                    if (curt_id < '0')
                        $("#cat_total_" + ind).val(curt_id - 1);
                    else
                        $("#cat_total_" + ind).val(0);
                    var tot = $("#total").val();
                    var totmin = parseInt(tot) - 1;
                    $("#total").val(totmin);
                }
            }
            var cat_value = '<?php echo $bannerInfo[0]->ban_type_name; ?>';
            var url = "<?php echo base_url(); ?>admin/custom_banner/getSubCategory";
            var cat_url = "<?php echo base_url(); ?>admin/custom_banner/getCategory";

<?php if ($bannerInfo[0]->ban_txt_img == "text") { ?>

                $('#text_val').show();
                $('#big_img').hide();
                $('#small_img').hide();
<?php } else { ?>

                var ban_for = $('#ban_for').val();

                $('#text_val').hide();
                if (ban_for == 'web') {
                    $('#big_img').show();
                    $('#small_img').hide();
                }
                else if (ban_for == 'mobile') {
                    $('#big_img').hide();
                    $('#small_img').show();
                }
                else {
                    $('#big_img').show();
                    $('#small_img').hide();
                }
<?php } ?>
                
                function addNewStore(ind)
            {

                var url = "<?php echo base_url(); ?>admin/custom_banner/addMoreStore";
                var curt_id = $("#store_total_" + ind).val();
                if (curt_id < 0)
                    curt_id = 0;
                var main_id = $("#store_total").val();
                if (main_id < 0)
                    main_id = 0;
                var total = parseInt(curt_id) + 1;

                $.post(url, {main_id: main_id, curt_id: curt_id, edit: 'edit'}, function (data)
                {
                    $("#addNewStoreLink_" + ind).before(data);
                    $("#store_total_" + ind).val(total);
                    $("#store_total").val(total);
                });
            }

            var tot_cat = $("#store_total").val();
            if (tot_cat < '-1')
                $('#remove_link_store').hide();

            function removeLastStore(ind) {

                var curt_id = $("#store_total_" + ind).val();

                if (curt_id < '0')
                    curt_id = '0';
                var tot_cat = $("#store_total").val();

                if (tot_cat < '-1') {
                    $('#remove_link').hide();
                }
                else
                {
                    $('#store_id_0_' + curt_id).closest('div').parent().remove();
                    if (curt_id < '0')
                        $("#store_total_" + ind).val(curt_id - 1);
                    else
                        $("#store_total_" + ind).val(0);
                    var tot = $("#store_total").val();
                    var totmin = parseInt(tot) - 1;
                    $("#store_total").val(totmin);
                }
            }
            
            
            
            function addNewCompany(ind)
            {
                var url = "<?php echo base_url(); ?>admin/custom_banner/addMoreCompany";
                var curt_id = $("#company_total_" + ind).val();
                if (curt_id < 0)
                    curt_id = 0;
                var main_id = $("#company_total").val();
                if (main_id < 0)
                    main_id = 0;
                var total = parseInt(curt_id) + 1;

                $.post(url, {main_id: main_id, curt_id: curt_id, edit: 'edit'}, function (data)
                {
                    $("#addNewCompanyLink_" + ind).before(data);
                    $("#company_total_" + ind).val(total);
                    $("#company_total").val(total);
                });
            }

            var tot_cat = $("#company_total").val();
            if (tot_cat < '-1')
                $('#remove_link_company').hide();

            function removeLastCompany(ind) {

                var curt_id = $("#company_total_" + ind).val();

                if (curt_id < '0')
                    curt_id = '0';
                var tot_cat = $("#company_total").val();

                if (tot_cat < '-1') {
                    $('#remove_link').hide();
                }
                else
                {
                    $('#company_id_0_' + curt_id).closest('div').parent().remove();
                    if (curt_id < '0')
                        $("#company_total_" + ind).val(curt_id - 1);
                    else
                        $("#company_total_" + ind).val(0);
                    var tot = $("#company_total").val();
                    var totmin = parseInt(tot) - 1;
                    $("#company_total").val(totmin);
                }
            }
        </script>       
        <!--set restriction in below file for banner upload -->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/banner.js" type="text/javascript"></script>
        <script>

<?php if (isset($bannerInfo[0]->is_endate) && $bannerInfo[0]->is_endate == 0) { ?>
                $('#end_dt').show();
<?php } else { ?>
                $('#end_dt').hide();
<?php } ?>

            $('#end_cust').click(function () {
                $('#end_dt').show();
            });
            $('#end_never').click(function () {
                $('#end_dt').hide();
            });
            
            $(function () {
                $('#submit').click(function () {
                var end_select = document.getElementById("end_cust");
                    if (end_select.checked){
                        
                        var start = $("#start_date").val();
                        var end = $("#end_date").val();                
                        
                        if (end < start) {
                            $("#lbl_dbo").show();
                            $("#lbl_dbo").text("Last Date Must be greater than Start Date");
                            return false;
                        }
                        else {                    
                            $("#lbl_dbo").hide();
                        }
                    }
                });
            });
            
        $('#blah1').hide();
</script>