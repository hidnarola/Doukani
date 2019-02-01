<!DOCTYPE html>
<html>
    <head>
        <?php //$this->load->view('admin/include/head'); ?>
        <?php
        if (isset($page_title)) {
            echo '<title>' . $page_title . '</title>';
        } else {
            ?>
            <title>Classified Application</title>
        <?php } ?>

        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/light-theme.css" media="all" id="color-settings-body-color" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/lightbox/lightbox.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/common/bootstrap-wysihtml5.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/datatables/bootstrap-datatable.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/bootstrap/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/dark-theme.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/theme-colors.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_switch/bootstrap-switch.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/custom-chat.css" media="all" rel="stylesheet" type="text/css" />
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css' />
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_colorpicker/bootstrap-colorpicker.css'/>
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/multiple-select.css' />

        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    </head>
    <body class='contrast-fb store'>

        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>
                                            <i class='icon-list-ol'></i>
                                            <span>Listings</span>
                                            <?php $admin_permission = $this->session->userdata('admin_modules_permission'); ?>
                                        </h1>
                                        <div class='pull-right'>                                  
                                            <?php
                                            if ($this->uri->segment(4) == 'classified') {
                                                if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                                                    ?>
                                                    <a href='<?php echo base_url() . "admin/classifieds/listings_add/" . $this->uri->segment(3) . "/" . $this->uri->segment(4) . "/?userid=" . $_REQUEST['userid']; ?>' title="Add Product" class="btn"><i class='icon-plus'></i>&nbsp;Add Product</a>
                                                <?php } else { ?>
                                                    <a href='<?php echo base_url() . "admin/classifieds/listings_add/" . $this->uri->segment(3) . "/" . $this->uri->segment(4) ?>' title="Add Product" class="btn"><i class='icon-plus'></i>&nbsp;Add Product</a>
                                                    <?php
                                                }
                                            }

                                            if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                                                ?>
                                                <a href='<?php echo site_url() . 'admin/classifieds/listings/' . $this->uri->segment(4) . '/?userid=' . $_REQUEST['userid']; ?>'  title="Reset Filter" class="btn">
                                                    <i class="fa fa-refresh"></i>&nbsp;Reset Filters
                                                </a>
                                            <?php } else { ?>
                                                <a href='<?php echo site_url() . 'admin/classifieds/listings/' . $this->uri->segment(4); ?>'  title="Reset Filter" class="btn">
                                                    <i class="fa fa-refresh"></i>&nbsp;Reset Filters
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class='title'>
                                        <?php
                                        if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                                            $res = $this->db->query('select email_id,username from user where user_id=' . (int) $_REQUEST['userid'])->row();
                                            if (isset($res)) {
                                                echo 'Email ID: <u>' . $res->email_id . '</u><br>';
                                                echo 'Username: ' . $res->username;
                                            } else
                                                redirect('admin/classifieds/listings/classified');
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'>
                                        <h5><span class="f_label" >F</span> - Featured Ads Running in Front End</h5>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>
                            </div>                            
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" id="spam_text" value="<?php echo $spam; ?>"/>
                            <form id="form1" name="form1" action="<?php echo site_url() . 'admin/classifieds/listings/' . $this->uri->segment(4); ?>" method="get" accept-charset="UTF-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <div class="title">Show By Location</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content ">
                                                <?php if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) { ?>
                                                    <input type="hidden" id="userid" name="userid" value="<?php echo $_REQUEST['userid']; ?>">
                                                <?php } ?>
                                                <div class="form-group">
                                                    <select  class="select2 form-control" onchange="show_list();" id="filter_opt" name="filter">

                                                        <?php
                                                        //($this->session->userdata('listing_filter') != '' && $this->session->userdata('listing_filter') == 0)
                                                        ?>
                                                        <option value="0" <?php if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == 0) echo 'selected=selected'; ?>>All</option>
                                                        <option value="emirates" <?php if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "emirates") echo 'selected=selected'; ?>>Emirates</option>
                                                        <option value="category" <?php if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category") echo 'selected=selected'; ?>>Category</option>
                                                    </select>
                                                </div>
                                                <div class="form-group" >
                                                    <select id="location" class="select2 form-control" onchange="show_emirates(this.value);" <?php
                                                    if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "emirates")
                                                        echo '';
                                                    else
                                                        echo 'style="display:none;"';
                                                    ?>  name="con">
                                                        <option value="0">All Countries</option>
                                                        <?php
                                                        foreach ($location as $o) {
                                                            if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "emirates" && isset($_REQUEST['con']) && (int) $_REQUEST['con'] == (int) $o['country_id']) {
                                                                ?>                                             
                                                                <option value="<?php echo $o['country_id']; ?>" selected><?php echo $o['country_name']; ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo $o['country_id']; ?>"><?php echo $o['country_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select id="state_name" <?php
                                                    if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "emirates")
                                                        echo '';
                                                    else
                                                        echo 'style="display:none;"';
                                                    ?>  class="form-control" onchange="show_list();" name="st">
                                                        <option value="0">All Emirates</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select id="category" class="select2 form-control" onchange="show_sub_cat(this.value);"     onload="show_sub_cat(this.value);" name="cat" <?php
                                                    if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category")
                                                        echo '';
                                                    else
                                                        echo 'style="display:none;"';
                                                    ?> >
                                                        <option value="0">All Category</option>
                                                        <?php foreach ($category as $cat): if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category" && isset($_REQUEST['cat']) && (int) $_REQUEST['cat'] == (int) $cat['category_id']) { ?> 
                                                                <option value="<?php echo $cat['category_id']; ?>" selected><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                            <?php } elseif (isset($user_category_id) && (int) $user_category_id > 0 && $user_category_id == $cat['category_id']) { ?> 
                                                                <option value="<?php echo $cat['category_id']; ?>" selected><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                            <?php } ?><?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="subcategory_list">
                                                    <select id="subcategory" name="sub_cat" class="form-control" onchange="show_list();" <?php
                                                    if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category")
                                                        echo '';
                                                    else
                                                        echo 'style="display:none;"';
                                                    ?> >
                                                        <option value="0">All Sub Category</option>
                                                        <?php
                                                        if (isset($sub_cat) && sizeof($sub_cat) > 0) {
                                                            foreach ($sub_cat as $sub) {
                                                                ?>
                                                                <option value="<?php echo $sub['sub_category_id']; ?>" ><?php echo $sub['sub_category_name']; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class='' id="date_range">
                                                    <input  id="date_range_val" class='form-control daterange input-group' data-format='yyyy-MM-dd' placeholder='Product Posted Date' type='text' value="<?php if (isset($_REQUEST['dt'])) echo $_REQUEST['dt']; ?>" name="dt">
                                                    <!--<span class='input-group-addon' id='daterange2' name="daterange2">
                                                       <i class='icon-calendar '></i>
                                                       </span> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <div class="title">Show By Status</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content ">
                                                <div class="form-group">
                                                    <select id="status" class="select2 form-control" name="status">
                                                        <option value="0">All</option>
                                                        <!--<option value="available"> Available</option>
                                                           <option value="sold" >Sold</option>
                                                           <option value="out_of_stock">Out Of Stock </option>
                                                           <option value="discontinued">Discontinued</option> -->
                                                        <option value="NeedReview" <?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'NeedReview') echo 'selected'; ?> >NeedReview</option>
                                                        <option value="Approve"  <?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'Approve') echo 'selected'; ?>>Approve</option>
                                                        <option value="Unapprove"  <?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'Unapprove') echo 'selected'; ?>>Unapprove</option>
                                                        <option value="Inappropriate" <?php if (isset($_REQUEST['status']) && $_REQUEST['status'] == 'Inappropriate') echo 'selected'; ?>>Inappropriate</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select id="other_status" class="select2 form-control" name="other_status">
                                                        <option value="0">All</option>
                                                        <option value="available" <?php if (isset($_REQUEST['other_status']) && $_REQUEST['other_status'] == 'available') echo 'selected'; ?>>Available</option>
                                                        <option value="sold" <?php if (isset($_REQUEST['other_status']) && $_REQUEST['other_status'] == 'sold') echo 'selected'; ?>>Sold (Not Deactivated)</option>
                                                        <option value="deactivate"  <?php if (isset($_REQUEST['other_status']) && $_REQUEST['other_status'] == 'deactivate') echo 'selected'; ?>>Deactivated (Not Sold)</option>
                                                        <option value="sold_deactivate" <?php if (isset($_REQUEST['other_status']) && $_REQUEST['other_status'] == 'sold_deactivate') echo 'selected'; ?>   >Sold & Deactivated</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <div class="title">Search Text</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content ">
                                                <div class="form-group">
                                                    <input type="text" name="search_text" id="search_text" class="form-control" placeholder="Product Name" value="<?php echo @$_GET['search_text']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header">
                                                <div class="form-group">
                                                    <button type="submit" name="submit_filter" id="" class="btn btn-primary">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <hr class="hr-normal">
                            <div class='row'>
                                <div class='col-sm-12' id="filter_list">
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Listings</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <table class='table table-striped superCategoryList' style='margin-bottom:0;'>
                                                        <thead>
                                                            <tr>
                                                                <?php if ($admin_permission != 'only_listing') { ?>
                                                                    <th  width="3%"><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                <?php } ?>
                                                                <th width="10%" style="word-wrap: break-word; white-space: pre-line;">Name</th>
                                                                <th width="5%">Image</th>
                                                                <th width="10%">Category</th>
                                                                <th width="5%">Price</th>
                                                                <th width="10%">Status</th>
                                                                <th width="10%">Product Is</th>
                                                                <th width="15%">Contact Details</th>
                                                                <th width="35%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($product) && sizeof($product) > 0):
                                                                foreach ($product as $pro) {
                                                                    ?>
                                                                    <tr>
                                                                        <?php if ($admin_permission != 'only_listing') { ?>
                                                                            <td><input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $pro['product_id']; ?>" /></td>
                                                                        <?php } ?>
                                                                        <!--top: -18px;-->
                                                                        <td   width="20%" style="word-wrap: break-word; white-space: pre-line;">
                                                                            <?php if (!empty($pro['my_status']) && $pro['my_status'] == 'f_ad') { ?>
                                                                                <span class="f_label" style="">F</span>
                                                                                <?php
                                                                            }
                                                                            echo $pro['product_name'];
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if (!empty($pro['product_image'])) {
                                                                                $load_image = base_url() . product . "original/" . $pro['product_image'];
                                                                                $image_url = base_url() . product . "small/" . $pro['product_image'];
                                                                            } else {
                                                                                $load_image = site_url() . '/assets/upload/No_Image.png';
                                                                                $image_url = site_url() . '/assets/upload/No_Image.png';
                                                                            }
                                                                            ?>
                                                                            <a data-lightbox='flatty' href='<?php echo $load_image; ?>'>
                                                                                <img alt="Product Image" style="height: 40px; width: 64px;" src="<?php echo $image_url; ?>" onerror="this.src='<?php echo site_url(); ?>/assets/upload/No_Image.png'"/>
                                                                            </a>                                                
                                                                        </td>
                                                                        <td><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></td>
                                                                        <td><?php echo number_format($pro['product_price']); ?></td>
                                                                        <td><?php
                                                                            if ((int) $pro['product_is_sold'] == 1 && (int) $pro['product_deactivate'] != 1)
                                                                                echo 'Sold';
                                                                            elseif ((int) $pro['product_is_sold'] != 1 && (int) $pro['product_deactivate'] == 1)
                                                                                echo 'Deactivated';
                                                                            elseif (((int) $pro['product_is_sold'] == 0 || (int) $pro['product_is_sold'] == null) && ((int) $pro['product_deactivate'] == '' || (int) $pro['product_deactivate'] == null))
                                                                                echo 'Available';
                                                                            elseif ((int) $pro['product_is_sold'] == 1 && (int) $pro['product_deactivate'] == 1)
                                                                                echo 'Sold & Deactivated';
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $pro['product_is_inappropriate']; ?></td>
                                                                        <td>
                                                                            <?php
                                                                            $contact = '';
                                                                            if ($pro['user_name'] != '')
                                                                                echo $contact = '<label>Name: </label>' . $pro['user_name'];

                                                                            echo '<br>';
                                                                            if ($pro['user_contact_number'] != '')
                                                                                echo $contact = '<label>Contact: </label>' . $pro['user_contact_number'] . '';

                                                                            if ($pro['email_id'] != '') {
                                                                                if ($admin_permission != 'only_listing')
                                                                                    echo $contact = '<br><a class="btn btn-xs send_message has-tooltip" data-placement="top" title="Email" data-id="' . $pro['user_id'] . '"><i class="fa fa-envelope"></i></a>&nbsp;' . $pro['email_id'];
                                                                                else
                                                                                    echo $contact = '<label>Email ID: </label>' . $pro['email_id'];
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <div class="btn-group action_drop_down">
                                                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                    <span class="caret"></span>
                                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                                </button>
                                                                                <ul class="dropdown-menu" role="menu">
                                                                                    <?php
                                                                                    if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                                                                                        $page_redirect = (isset($_GET['page'])) ? '&page=' . $_GET['page'] : '';
                                                                                        $view_path = base_url() . "admin/classifieds/listings_view/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . '/?request_for=user&userid=' . $_REQUEST['userid'] . $page_redirect;
                                                                                    } else {
                                                                                        $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                                                        $view_path = base_url() . "admin/classifieds/listings_view/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . $page_redirect;
                                                                                    }
                                                                                    ?>
                                                                                    <li>
                                                                                        <a href='<?php echo $view_path; ?>'>
                                                                                            <i class="fa fa-info-circle"></i> View Ad
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="divider"></li> 
                                                                                    <?php
                                                                                    if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                                                                                        $page_redirect = (isset($_GET['page'])) ? '&page=' . $_GET['page'] : '';
                                                                                        $edit_path = base_url() . "admin/classifieds/listings_edit/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . '/?request_for=user&userid=' . $_REQUEST['userid'] . $page_redirect;
                                                                                    } else {
                                                                                        $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                                                        $edit_path = base_url() . "admin/classifieds/listings_edit/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . $page_redirect;
                                                                                    }
                                                                                    if (($admin_permission == 'only_listing' && $pro['product_posted_by'] == $admin_user->user_id && $pro['product_is_inappropriate'] == 'Unapprove') || empty($admin_permission)) {
                                                                                        ?>
                                                                                        <li>
                                                                                            <a href='<?php echo $edit_path; ?>'>
                                                                                                <i class='icon-edit'></i> Edit Ad
                                                                                            </a>   
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <?php
                                                                                    }

                                                                                    if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                                                                                        $page_redirect = (isset($_GET['page'])) ? '&page=' . $_GET['page'] : '';
                                                                                        $delete_path = base_url() . "admin/classifieds/listings_delete/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . '/?request_for=user&userid=' . $_REQUEST['userid'] . $page_redirect;
                                                                                    } else {
                                                                                        $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                                                        $delete_path = base_url() . "admin/classifieds/listings_delete/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . $page_redirect;
                                                                                    }
                                                                                    ?>
                                                                                    <?php
                                                                                    if ($admin_permission == 'only_listing') {
                                                                                        
                                                                                    } else {
                                                                                        ?>
                                                                                        <li>
                                                                                            <a id="delete_ad" data-path="<?php echo $delete_path; ?>">
                                                                                                <i class='icon-trash'></i> Delete Ad
                                                                                            </a> 
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <?php
                                                                                    }

                                                                                    if (isset($pro['user_role']) && !isset($_REQUEST['userid']) && $pro['user_role'] != 'superadmin' && $admin_permission != 'only_listing') {
                                                                                        $product_type__ = $this->uri->segment(4);

                                                                                        if ($pro['user_role'] == 'admin')
                                                                                            $user_link_ = site_url() . 'admin/systems/accounts_view/' . $pro['user_id'];
                                                                                        else
                                                                                            $user_link_ = site_url() . 'admin/users/view/' . $pro['user_id'];

                                                                                        $push_notification = $this->permission->has_permission('push_notification');
                                                                                        if ($push_notification == 1) {
                                                                                            if ($pro['device_type'] == NULL)
                                                                                                echo '';
                                                                                            elseif ($pro['device_type'] == 1) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a class='send_notification' data-id="<?php echo $pro['user_id']; ?>" data-for="ios" data-length = '<?php echo $iphone_notification_max_length->val; ?>'>
                                                                                                        <i class="fa fa-apple"></i> Send Notification
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            } elseif ($pro['device_type'] == 0) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a class='send_notification' data-id="<?php echo $pro['user_id']; ?>" data-for="android" data-length = '<?php echo $android_notification_max_length->val; ?>'>
                                                                                                        <i class="fa fa-android"></i> Send Notification
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                        }

                                                                                        $user_mgt = $this->permission->has_permission('user_mgt');
                                                                                        $system_mgt = $this->permission->has_permission('system_mgt');
                                                                                        if (($pro['user_role'] == 'admin' && $system_mgt == 1) || $user_mgt == 1) {
                                                                                            ?>        
                                                                                            <li>
                                                                                                <a href="<?php echo $user_link_; ?>" target="_blank">
                                                                                                    <i class="fa fa-eye"></i> View Seller Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php if ($pro['user_role'] == 'storeUser' && $user_mgt == 1) { ?>
                                                                                                <li>
                                                                                                    <a href='<?php echo base_url() . "admin/users/view_store/" . $pro['store_id'] . '/' . $search; ?>' target="_blank">
                                                                                                        <i class="fa fa-building-o"></i> View Store Details
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                        }

                                                                                        $classified = $this->permission->has_permission('classified');
                                                                                        if ($classified == 1) {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a href="<?php echo site_url() . 'admin/classifieds/listings/' . $product_type__ . '/?userid=' . $pro['user_id']; ?>" target="_blank">
                                                                                                    <i class="fa fa-list"></i> Seller's New Classified List
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <a href="<?php echo site_url() . 'admin/classifieds/repost_ads/' . $product_type__ . '/?userid=' . $pro['user_id']; ?>" target="_blank">
                                                                                                    <i class="fa fa-list-ol"></i> Seller's Repost Classified List
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }
                                                                                        $store_mgt = $this->permission->has_permission('store_mgt');
                                                                                        if ($pro['user_role'] == 'storeUser' && $store_mgt == 1) {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a href="<?php echo base_url() . 'admin/classifieds/listings/' . $product_type__ . '/?userid=' . $pro['user_id']; ?>" target="_blank">
                                                                                                    <i class='fa fa-bars'></i> Seller's New Store Product List
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <a href="<?php echo base_url() . 'admin/classifieds/repost_ads/' . $product_type__ . '/?userid=' . $pro['user_id']; ?>" target="_blank">
                                                                                                    <i class='fa fa-list'></i> Seller's Repost Store Product List
                                                                                                </a>
                                                                                            </li>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </ul>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            else:
                                                                ?>
                                                                <tr>
                                                                    <td colspan="8">No Results Found</td>
                                                                </tr>
                                                            <?php
                                                            endif;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                    if (sizeof($product) > 0) {
                                                        if ($admin_permission == 'only_listing') {
                                                            
                                                        } else {
                                                            ?>
                                                            <form method="post" action="" id="userForm" class="form form-horizontal col-md-12">
                                                                <div class='form-group'>
                                                                    <div class='col-md-3'>
                                                                        <select style="margin-left: 5px;" class='form-control' id="status_val" name="status" onchange="setfeatured(this);">
                                                                            <option value="0">Select Action</option>
                                                                            <optgroup label="Set Status">
                                                                                <option value="available"> Available</option>
                                                                                <option value="sold" >Sold</option>                                                                                     </optgroup>                    
                                                                            <optgroup label="Product is">
                                                                                <option value="Approve" <?php if (isset($_POST['status']) == 'Approve') echo 'selected'; ?>>Approve</option>
                                                                                <option value="Unapprove" <?php if (isset($_POST['status']) == 'Unapprove') echo 'selected'; ?>>Unapprove</option>
                                                                                <option value="Inappropriate" <?php if (isset($_POST['status']) == 'Inappropriate') echo 'selected'; ?>>Inappropriate</option>
                                                                            </optgroup>
                                                                            <?php if ($this->uri->segment(4) == 'classified') { ?>
                                                                                <optgroup label="Update Product as">
                                                                                    <option value="featured">Featured Ads</option>
                                                                                </optgroup>
                                                                            <?php } ?>

                                                                            <option value="delete">Delete</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class='col-md-3'>
                                                                        <input type="hidden" id="checked_val" name="checked_val"/>
                                                                        <input type="hidden" id="page" name="page" value="<?php echo (isset($_GET['page'])) ? $_GET['page'] : ''; ?>"/>

                                                                        <?php
                                                                        $redirect_after_delete = '';
                                                                        if ((isset($search)) && !empty($search))
                                                                            $redirect_after_delete .= $search;
                                                                        ?>
                                                                        <input type="hidden" id="redirect_me" name="redirect_me" value="<?php echo $redirect_after_delete; ?>" />      

                                                                        <input type="button" class="btn" value="Apply to selected" onclick="update_status();">
                                                                    </div>

                                                                </div>
                                                            </form>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>
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
            </section>
        </div>
        <div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Set Featured Ads</h4>
                    </div>
                    <div class="modal-body">
                        <div class="FeaturedAds-popup">
                            <form action='<?php echo base_url(); ?>admin/classifieds/insert_featured' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form">
                                <div class='box-content control'>
                                    <div class="container">
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <p><strong>From Date</strong></p>
                                                <div class='input-group date' id='datetimepicker6'>
                                                    <input type='text' class="form-control" placeholder="From Date" name="from_date" data-rule-required='true' />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <p><strong>To Date</strong></p>
                                                <div class='input-group date' id='datetimepicker7'>
                                                    <input type='text' class="form-control" placeholder="To Date" name="to_date" data-rule-required='true' />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="margin-bottom-10"></div>
                                    <a class='btn btn-primary' href="#" onclick="javascript:insert_featured();">
                                        <i class="fa fa-paper-plane"></i>Apply                             
                                    </a><input type="hidden" id="checked_values" name="checked_values"/>
                                    <button data-dismiss="modal" class="btn btn-default rounded" type="button" id="cancel">Cancel</button>
                                </div>
                            </form>
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
                            <div class='box-content control'>
                                <div class='form-group '>
                                    <font color="red" ><span id="error_msg" ></span></font>
                                </div>
                                <div class="margin-bottom-10"></div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade center" id="confirm_alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
                    </div>
                    <div class="modal-body">
                        <div class="FeaturedAds-popup">
                            <form action='<?php echo base_url(); ?>admin/classifieds/insert_featured' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form">
                                <div class='box-content control'>
                                    <div class='form-group '>                                            
                                        <font color="red" ><span id="error_msg1" ></span></font>
                                    </div>
                                    <div class="margin-bottom-10"></div>
                                    <a class='btn btn-primary' href="#" id="update">
                                        <i class="fa fa-paper-plane"></i> &nbsp;&nbsp;Update                                      
                                    </a> <input type="hidden" id="checked_values" name="checked_values"/>
                                    <button data-dismiss="modal" class="btn btn-default rounded" type="button" id="cancel1">Cancel</button>
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
                        <p id="alert_message_action">Are you sure want delete Ad(s)?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script type="text/javascript">

            $('input[name="dt"]').daterangepicker({
                format: "YYYY-MM-DD"
            });

            $(document).on("click", "#delete_ad", function (e) {
                var path = $(document).find(this).attr('data-path');
                $(".sure .modal-sm .modal-header").css({"background": "#ec1c32"});
                $('#alert_message_action').html('Are you sure want delete Ad(s)?');
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        jQuery('#userForm').attr('action', path).submit();
                    }
                });
            });

            $('.table-responsive').on('shown.bs.dropdown', function (e) {
                var t = $(this),
                        m = $(e.target).find('.dropdown-menu'),
                        tb = t.offset().top + t.height(),
                        mb = m.offset().top + m.outerHeight(true),
                        d = 20; // Space for shadow + scrollbar.
                if (t[0].scrollWidth > t.innerWidth()) {
                    if (mb + d > tb) {
                        t.css('padding-bottom', ((mb + d) - tb));
                    }
                } else {
//            t.css('overflow', 'visible');
                    t.css('overflow', 'scroll');
                }
            }).on('hidden.bs.dropdown', function () {
                $(this).css({'padding-bottom': '', 'overflow': ''});
            });

        </script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/moment-with-locales.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap-datetimepicker.js"></script>      
        <?php
        $this->load->view('admin/listings/listing_script');
        $this->load->view('admin/listings/send_mail');
        ?>
    </body>
</html>
