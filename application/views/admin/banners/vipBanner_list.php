<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <style>
            .scrollable-area .table-striped tr td:nth-child(2) {
                width:10%;
            }
        </style>
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
                                            <span>Vip Banner</span>
                                        </h1>
                                        <div class='pull-right'>
                                            <?php
                                            if ($this->uri->segment(5) != '')
                                                $banner_for = $this->uri->segment(5);
                                            else
                                                $banner_for = '';
                                            ?>
                                            <a class="btn" href="<?php echo base_url() . 'admin/custom_banner/addvip/10/' . $banner_for; ?>">
                                                <i class="icon-plus"></i> Add VIP Banner
                                            </a> 
                                            &nbsp;&nbsp;&nbsp;
                                            <a class="btn" href="<?php echo base_url() . 'admin/custom_banner/vipBanner/10/' . $banner_for; ?>">
                                                <i class="fa fa-refresh"></i> Reset Filters
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>
                            </div>
                            <!--        flash message -->
                            <?php if (isset($flash_message)) { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a class="close" data-dismiss="alert" href="#">×</a>
                                    <i class="icon-smile"></i>
                                    <?php
                                    echo $flash_message;
                                    ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>
                            <form id="form1" name="form1" action="<?php echo site_url() . 'admin/custom_banner/vipBanner/10/' . $banner_for; ?>" method="get" accept-charset="UTF-8">
                                <div class='row'>
                                    <div class='col-sm-3'>
                                        <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                            <div class='box-header orange-background'>
                                                <div class='title'>Select Banner Type</div>
                                                <div class='actions'>
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>                                        
                                            <?php $this->load->view('admin/banners/bannertype_div'); ?>
                                        </div>
                                    </div>
                                    <div class='col-sm-3'>
                                        <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                        <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                            <div class='box-header orange-background'>
                                                <div class='title'>Select Display Page</div>
                                                <div class='actions'>
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php $this->load->view('admin/banners/displaypage_div'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header">
                                                <button type="submit" name="submit_filter" id="submit" class="btn btn-primary">
                                                    <i class="fa fa-search"></i> Search
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr class="hr-normal">
                            <div id="filter_list">
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                            <div class='box-header orange-background'>
                                                <div class='title'>Vip Banner List</div>
                                                <div class='actions'>
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class='box-content box-no-padding'>
                                                <div class='responsive-table'>
                                                    <div class='scrollable-area table-responsive'>
                                                        <form method="post" action="" id="userForm" class="form form-horizontal">  
                                                            <table class='table table-striped superCategoryList' style='margin-bottom:0;'>
                                                                <thead>
                                                                    <tr>
                                                                        <th width="5%"><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                        <th width="5%">Banner Id</th>
                                                                        <th width="5%">Site Url</th>
                                                                        <th width="5%">Banner Type</th>
                                                                        <th width="10%">Display Page</th>
                                                                        <th width="5%">Pause Banner</th>
                                                                        <th width="5%">Impressions Count</th>
                                                                        <th width="5%">Clicks Count</th>
                                                                        <th width="5%">Start Date</th>
                                                                        <th width="5%">End Date</th>
                                                                        <th width="5%">Binding Option</th>
                                                                        <th width="25%">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if (isset($superCategories) && sizeof($superCategories) > 0) {
                                                                        foreach ($superCategories as $superCategory) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $superCategory['ban_id']; ?>" />
                                                                                </td>
                                                                                <td><?php echo $superCategory['ban_id']; ?></td>
                                                                                <td>
                                                                                    <?php if (!empty($superCategory['site_url'])) { ?>
                                                                                        <a href="<?php echo $superCategory['site_url']; ?>"><i class="icon-globe"></i></a>
                                                                                    <?php } ?>
                                                                                </td>
                                                                                <td><?php echo $superCategory['ban_type_name']; ?></td>
                                                                                <td><?php
                                                                                    $display_page = '';
                                                                                    if (isset($superCategory['display_page'])) {
                                                                                        if (in_array($superCategory['ban_type_name'], array("header", "sidebar", "between"))) {
                                                                                            if ($superCategory['display_page'] == 'all_page')
                                                                                                $display_page = 'Classified All Pages';
                                                                                            elseif ($superCategory['display_page'] == 'home_page')
                                                                                                $display_page = 'Classified Home Page';
                                                                                            elseif ($superCategory['display_page'] == 'content_page')
                                                                                                $display_page = 'Classified Content Page';

                                                                                            elseif ($superCategory['display_page'] == 'bw_home_page_ban1')
                                                                                                $display_page = 'Classified Home Page Banner 1';
                                                                                            elseif ($superCategory['display_page'] == 'bw_home_page_ban2')
                                                                                                $display_page = 'Classified Home Page Banner 2';
                                                                                            elseif ($superCategory['display_page'] == 'latest_ads_page')
                                                                                                $display_page = 'Classified Latest Ads Page';

                                                                                            elseif ($superCategory['display_page'] == 'store_all_page')
                                                                                                $display_page = 'Store All Pages';
                                                                                            elseif ($superCategory['display_page'] == 'specific_store_page')
                                                                                                $display_page = 'Specific Store Pages';
                                                                                            elseif ($superCategory['display_page'] == 'store_content_page')
                                                                                                $display_page = 'Store Item Details Page';
                                                                                            elseif ($superCategory['display_page'] == 'store_page_content')
                                                                                                $display_page = 'Store Landing Page';

                                                                                            elseif ($superCategory['display_page'] == 'off_all_page')
                                                                                                $display_page = 'Offer All Pages';
                                                                                            elseif ($superCategory['display_page'] == 'off_home_page')
                                                                                                $display_page = 'Offer Home Page';
                                                                                            elseif ($superCategory['display_page'] == 'off_cat_cont')
                                                                                                $display_page = 'Category Wise Offers Page';
                                                                                            elseif ($superCategory['display_page'] == 'off_comp_cont')
                                                                                                $display_page = 'Company Wise Offers Page';
                                                                                            elseif ($superCategory['display_page'] == 'off_cat_side')
                                                                                                $display_page = 'Categories Block on Offer\'s Home Page';
                                                                                            elseif ($superCategory['display_page'] == 'off_comp_side')
                                                                                                $display_page = 'Companies  Block on Offer\'s Home Page';
                                                                                        }
                                                                                        elseif (in_array($superCategory['ban_type_name'], array("intro", "feature", "footer", "between_app"))) {

                                                                                            if ($superCategory['display_page'] == 'all_page')
                                                                                                $display_page = 'All Page';
                                                                                            elseif ($superCategory['display_page'] == 'content_page')
                                                                                                $display_page = 'Content Page';
                                                                                            elseif ($superCategory['display_page'] == 'home_page')
                                                                                                $display_page = 'Home Page';

                                                                                            elseif ($superCategory['display_page'] == 'after_splash_screen')
                                                                                                $display_page = 'After splash screen';
                                                                                            elseif ($superCategory['display_page'] == 'before_latest_ads')
                                                                                                $display_page = 'Before latest ads';
                                                                                            elseif ($superCategory['display_page'] == 'before_featured_items')
                                                                                                $display_page = 'Before featured items';
                                                                                        }
                                                                                    }
                                                                                    echo $display_page;
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $superCategory['pause_banner']; ?></td>
                                                                                <td><?php echo $superCategory['impression_count']; ?></td>
                                                                                <td><?php echo $superCategory['click_count']; ?></td>
                                                                                <td><?php echo $superCategory['expiry_start_date']; ?></td>
                                                                                <td>
                                                                                    <?php
                                                                                    if (isset($superCategory['expiry_end_date']) && $superCategory['expiry_end_date'] == '0000-00-00')
                                                                                        echo 'No End Date';
                                                                                    else
                                                                                        echo $superCategory['expiry_end_date'];
                                                                                    ?>
                                                                                </td>
                                                                                <td><?php echo $superCategory['bidding_option']; ?></td>
                                                                                <td>
                                                                                    <div class="btn-group action_drop_down">
                                                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                            <span class="caret"></span>
                                                                                            <span class="sr-only">Toggle Dropdown</span>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu" role="menu">
                                                                                            <li>
                                                                                                <a href="<?php echo base_url(); ?>admin/custom_banner/editvip/10/<?php echo $banner_for . '/' . $superCategory['ban_id']; ?>"><i class="icon-edit"></i> Edit Banner</a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <?php
                                                                                                $redirect_after_delete = base_url() . 'admin/custom_banner/deletevip/10/' . $banner_for . '/' . $superCategory['ban_id'] . '/';
                                                                                                if ((isset($search)) && !empty($search) && isset($_REQUEST['page']))
                                                                                                    $redirect_after_delete .= $search . '&page=' . $_REQUEST['page'];
                                                                                                elseif ((isset($search)) && !empty($search))
                                                                                                    $redirect_after_delete .= $search;
                                                                                                elseif (isset($_REQUEST['page']))
                                                                                                    $redirect_after_delete .= '?page=' . $_REQUEST['page'];
                                                                                                ?>
                                                                                                <a data-path="<?php echo $redirect_after_delete; ?>" id="delete_banner" ><i class="icon-trash"></i> Delete Banner</a>
                                                                                            </li>
                                                                                        </ul> 
                                                                                    </div> 



                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    else {
                                                                        ?>
                                                                        <tr>
                                                                            <td colspan="11">No Results Found</td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </form>
                                                        <div class="col-sm-12 text-right pag_bottom">
                                                            <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>	
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <br>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="col-sm-4">
                                                            <label>Per page : </label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="per_page1" id="per_page1" class="form-control" >                                              
                                                                <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '10') ? 'selected' : ''; ?>>10</option>    
                                                                <option value="25" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '25') ? 'selected' : ''; ?>>25</option>
                                                                <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '50') ? 'selected' : ''; ?>>50</option>
                                                                <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '100') ? 'selected' : ''; ?>>100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <?php if (!empty($superCategories)) { ?>
                                                            <form method="post" action="" id="userForm1" class="form form-horizontal col-md-12">
                                                                <div class='form-group'>
                                                                    <div class='col-md-4'>
                                                                        <select style="margin-left: 5px;" class='form-control' id="status_val" name="status">
                                                                            <option>Select Action</option>
                                                                            <option value="delete">Delete</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class='col-md-3'>
                                                                        <input type="hidden" name="type" id="type" value="10">
                                                                        <?php
                                                                        $redirect_after_delete = '';
                                                                        if ((isset($search)) && !empty($search) && isset($_REQUEST['page']))
                                                                            $redirect_after_delete .= $search . '&page=' . $_REQUEST['page'];
                                                                        elseif ((isset($search)) && !empty($search))
                                                                            $redirect_after_delete .= $search;
                                                                        elseif (isset($_REQUEST['page']))
                                                                            $redirect_after_delete .= '?page=' . $_REQUEST['page'];
                                                                        ?>
                                                                        <input type="hidden" id="redirect_me" name="redirect_me" value="<?php echo $redirect_after_delete; ?>" /> 

                                                                        <input type="hidden" name="banner_for" id="banner_for" value="<?php echo $banner_for; ?>">
                                                                        <input type="hidden" id="checked_val" name="checked_val"/> <input type="button" class="btn" value="Apply to selected" onclick="update_status();">
                                                                    </div>                                                           
                                                                </div>
                                                            </form>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>


        <div class="modal fade center" id="alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
                    </div>
                    <div class="modal-body">
                        <div class="FeaturedAds-popup">
                            <form action='' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form">
                                <div class='box-content control'>
                                    <div class='form-group '>
                                        <font color="red" ><span id="error_msg" ></span></font>
                                    </div>
                                    <div class="margin-bottom-10"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h4 class="modal-title">Confirmation
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </h4>                   
                    </div>
                    <div class="modal-body">                  
                        <p id="alert_message_action">Are you sure want to delete Banner(s)?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('admin/include/footer-script'); ?>
    <script>
        $(document).find('#per_page1').on('change', function () {
            var per_page = $(this).val();
            console.log(per_page);
            $('#per_page').val(per_page);
            $(document).find('#submit').click();
        });
        $(document).on("click", "#delete_banner", function (e) {
            var data_path = $(document).find(this).attr('data-path');
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if (val == 'yes') {
                    jQuery('#userForm').attr('action', data_path).submit();
                }
            });
        });

        function all_select() {
            var checked = jQuery('#all').attr('checked');
            if (checked)
                jQuery(":input[type=checkbox]", ".superCategoryList").attr('checked', true);
            else
                jQuery(":input[type=checkbox]", ".superCategoryList").attr('checked', false);
        }

        function update_status() {

            var historySelectList = $('select#status_val');
            var selectedValue = $('option:selected', historySelectList).val();
            var checkedValues = $('input:checkbox:checked').map(function () {
                return this.value;
            }).get();

            $('#checked_val').val(checkedValues);

            if ($('#checked_val').val() != '') {
                if (selectedValue == 'delete') {
                    $("#deleteConfirm").modal('show');
                    $(document).on("click", ".yes_i_want_delete", function (e) {
                        var val = $(this).val();
                        if (val == 'yes') {
                            jQuery('#userForm1').attr('action', "<?php echo base_url(); ?>admin/Custom_banner/deletevip").submit();
                        }
                    });
                } else {
                    $("#alert").modal('show');
                    $("#error_msg").html("Select action");
                }
            } else {
                $("#alert").modal('show');
                $("#error_msg").html("Select any record to perform action");
            }
        }
    </script>
