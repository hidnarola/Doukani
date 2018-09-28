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
        <style>            
            /*            ul.dropdown-menu {position: relative;}
                        ul.dropdown-menu li {border-bottom: 1px #ccc solid;}*/
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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>

                                            <?php
                                            $user_role_ = $this->uri->segment(4);
                                            $user_role_text = '';
                                            if ($user_role_ == 'generalUser') {
                                                echo "<i class='icon-user'></i>";
                                                $user_role_text = 'Classified ';
                                            } elseif ($user_role_ == 'offerUser') {
                                                echo "<i class='icon-tags'></i>";
                                                $user_role_text = 'Offer ';
                                            } elseif ($user_role_ == 'storeUser') {
                                                echo "<i class='icon-building'></i>";
                                                $user_role_text = 'Store ';
                                            }
                                            ?>
                                            <span><?php echo $user_role_text; ?>Users</span>
                                            <?php
                                            $redirect = $_SERVER['QUERY_STRING'];
                                            if (!empty($_SERVER['QUERY_STRING']))
                                                $redirect = '/?' . $redirect;
                                            ?>
                                        </h1>
                                        <div class='pull-right'>                        
                                            <a class="btn" href="<?php echo base_url() . "admin/users/add_user/" . $this->uri->segment(4); ?>">
                                                <i class="icon-plus"></i> Add User
                                            </a>
                                            <a class="btn" href="<?php echo base_url() . "admin/users/index/" . $this->uri->segment(4); ?>">
                                                <i class="fa fa-refresh"></i> Reset Filters
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5><span class="f_label" >F</span> - Featured Store / Company User</h5>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'>
                                        <h3><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h3>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('flash_message') != ''): ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('flash_message'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <form id="form1" name="form1" action="<?php echo site_url() . 'admin/users/index/' . $user_role; ?>" method="get" accept-charset="UTF-8">
                                    <?php if ($this->uri->segment(4) == 'storeUser') { ?>
                                        <div class="col-sm-2">
                                            <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                                <div class="box-header orange-background">
                                                    <div class="title">Status</div>
                                                    <div class="actions">
                                                        <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                        </a>
                                                    </div>
                                                </div>                                        
                                                <div class="box-content ">
                                                    <div class="form-group">
                                                        <select id="store_is_inappropriate" class="select2 form-control" name="store_is_inappropriate">
                                                            <option value="">All</option>
                                                            <option value="NeedReview" <?php if (isset($_REQUEST['store_is_inappropriate']) && $_REQUEST['store_is_inappropriate'] == 'NeedReview') echo 'selected'; ?> >NeedReview</option>
                                                            <option value="Approve"  <?php if (isset($_REQUEST['store_is_inappropriate']) && $_REQUEST['store_is_inappropriate'] == 'Approve') echo 'selected'; ?>>Approve</option>
                                                            <option value="Unapprove"  <?php if (isset($_REQUEST['store_is_inappropriate']) && $_REQUEST['store_is_inappropriate'] == 'Unapprove') echo 'selected'; ?>>Unapprove</option>
                                                            <option value="Inappropriate" <?php if (isset($_REQUEST['store_is_inappropriate']) && $_REQUEST['store_is_inappropriate'] == 'Inappropriate') echo 'selected'; ?>>Inappropriate</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select id="store_status" class="select2 form-control" name="store_status">
                                                            <option value="">All</option>
                                                            <option value="0"  <?php if (isset($_REQUEST['store_status']) && $_REQUEST['store_status'] == '0') echo 'selected'; ?>>Active</option>
                                                            <option value="3"  <?php if (isset($_REQUEST['store_status']) && $_REQUEST['store_status'] == '3') echo 'selected'; ?>>Hold</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if ($this->uri->segment(4) == 'offerUser') { ?>
                                        <div class="col-sm-2">
                                            <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                                <div class="box-header orange-background">
                                                    <div class="title">Status</div>
                                                    <div class="actions">
                                                        <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                        </a>
                                                    </div>
                                                </div>                                        
                                                <div class="box-content ">
                                                    <div class="form-group">
                                                        <select id="company_is_inappropriate" class="select2 form-control" name="company_is_inappropriate">
                                                            <option value="">All</option>
                                                            <option value="NeedReview" <?php if (isset($_REQUEST['company_is_inappropriate']) && $_REQUEST['company_is_inappropriate'] == 'NeedReview') echo 'selected'; ?> >NeedReview</option>
                                                            <option value="Approve"  <?php if (isset($_REQUEST['company_is_inappropriate']) && $_REQUEST['company_is_inappropriate'] == 'Approve') echo 'selected'; ?>>Approve</option>
                                                            <option value="Unapprove"  <?php if (isset($_REQUEST['company_is_inappropriate']) && $_REQUEST['company_is_inappropriate'] == 'Unapprove') echo 'selected'; ?>>Unapprove</option>
                                                            <option value="Inappropriate" <?php if (isset($_REQUEST['company_is_inappropriate']) && $_REQUEST['company_is_inappropriate'] == 'Inappropriate') echo 'selected'; ?>>Inappropriate</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <select id="company_status" class="select2 form-control" name="company_status">
                                                            <option value="">All</option>
                                                            <option value="0"  <?php if (isset($_REQUEST['company_status']) && $_REQUEST['company_status'] == '0') echo 'selected'; ?>>Active</option>
                                                            <option value="3"  <?php if (isset($_REQUEST['company_status']) && $_REQUEST['company_status'] == '3') echo 'selected'; ?>>Hold</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <div class="col-sm-3">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <div class="title">Filter User By</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content ">
                                                <div class="form-group">
                                                    <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                                    <select id="filter_list" name="filter" class="select2 form-control" onchange="show_user();">
                                                        <option value="all" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'all') echo 'selected=selected'; ?>>All</option>
                                                        <option value="reg" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'reg') echo 'selected=selected'; ?>>Registered</option>
                                                        <option value="blo" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'blo') echo 'selected=selected'; ?>>Blocked</option>
                                                        <option value="not_blo" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'not_blo') echo 'selected=selected'; ?>>Not Blocked</option>
                                                        <option value="cou" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'cou') echo 'selected=selected'; ?>>By Emirates</option>
                                                        <option value="dt" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'dt') echo 'selected=selected'; ?>>By Date</option>
                                                        <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser") { ?>
                                                            <option value="wt" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'wt') echo 'selected=selected'; ?>>Waiting for new store details approval</option>
                                                        <?php } ?>
                                                        <option value="not_agree" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'not_agree') echo 'selected=selected'; ?>>Not Agree with Terms & Conditions</option>
                                                    </select>
                                                </div>
                                                <div class="form-group id_100">
                                                    <select id="country_name" name="con"  <?php
                                                    if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'cou')
                                                        echo '';
                                                    else
                                                        echo "style='display: none;'";
                                                    ?>  class="select2 form-control" onchange="show_emirates(this.value);">
                                                        <option value="0">All Countries</option>
                                                        <?php foreach ($location as $o) { ?>
                                                            <option value="<?php echo $o['country_id']; ?>"
                                                            <?php if (isset($_GET['con']) && $_GET['con'] != 0 && $_GET['con'] == $o['country_id']) echo 'selected=selected'; ?>
                                                                    > 
                                                                        <?php echo $o['country_name']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <select id="state_name"  name="st" <?php
                                                    if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'cou')
                                                        echo '';
                                                    else
                                                        echo "style='display: none;'";
                                                    ?>  class="form-control" onchange="show_user();">
                                                        <option value="0">All Emirates</option>
                                                    </select>
                                                </div>
                                                <div class=''  id="date_range" <?php
                                                if (isset($_GET['filter']) && $_GET['filter'] == 'dt')
                                                    echo '';
                                                else
                                                    echo "style='display: none;'";
                                                ?>>
                                                         <?php
                                                         if (isset($_GET['dt']))
                                                             $date = str_replace("+", "to", $_GET['dt']);
                                                         else
                                                             $date = '';
                                                         ?>
                                                    <input  id="date_range_val" class='form-control daterange input-group' data-format='yyyy-MM-dd' placeholder='Select daterange' type='text' onblur="show_user();" value="<?php echo $date; ?>" name="dt" >                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <div class="title">User From</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content ">
                                                <div class="form-group">
                                                    <select id="device_type" name="device_type" class="select2 form-control">
                                                        <option value="" selected=selected>All</option>
                                                        <option value="null" <?php if (isset($_GET['device_type']) && $_GET['device_type'] != '' && $_GET['device_type'] == 'null') echo 'selected=selected'; ?>>Website</option>
                                                        <option value="1" <?php if (isset($_GET['device_type']) && $_GET['device_type'] != '' && $_GET['device_type'] == '1') echo 'selected=selected'; ?>>Iphone</option>
                                                        <option value="0" <?php if (isset($_GET['device_type']) && $_GET['device_type'] != '' && $_GET['device_type'] == '0') echo 'selected=selected'; ?>>Android</option>
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
                                                    <?php if ($this->uri->segment(4) == 'generalUser') { ?>
                                                        <input type="text" name="search_text" id="search_text" class="form-control" placeholder="Search Text" value="<?php echo @$_GET['search_text']; ?>">
                                                        <small class="text-green">You can search Email / Username / Nickname</small>
                                                    <?php } if ($this->uri->segment(4) == 'storeUser') { ?>
                                                        <input type="text" name="search_text" id="search_text" class="form-control" placeholder="Search Text" value="<?php echo @$_GET['search_text']; ?>">
                                                        <small class="text-green">You can search Email / Username / Nickname / Store Name / Store Domain</small>
                                                    <?php } if ($this->uri->segment(4) == 'offerUser') { ?>
                                                        <input type="text" name="search_text" id="search_text" class="form-control" placeholder="Search Text" value="<?php echo @$_GET['search_text']; ?>">
                                                        <small class="text-green">You can search Email / Username / Nickname / Company Name</small>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header">
                                                <div class="form-group">
                                                    <button type="submit" name="submit" id="submit" class="btn  btn-primary">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <hr class="hr-normal">
                            <div class='row'>
                                <div class='col-sm-12' id="filter_user_list">
                                    <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser") { ?>
                                        <span style="color:#f34541 !important;">Red row - waiting for store new details verification
                                        </span>
                                    <?php } ?>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>
                                                <?php
                                                if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'generalUser')
                                                    echo 'Classified User List';
                                                elseif ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'offerUser')
                                                    echo 'Offer User List';
                                                elseif ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser")
                                                    echo 'Virtual Store User List';
                                                ?> 
                                            </div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>                                        
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <form name="block_status" id="block_status" method="post">
                                                        <!-- data-table -->
                                                        <table  class='table  table-striped superCategoryList' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th width="3%"><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                    <th  width="10%" >Email</th>
                                                                    <?php
                                                                    if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser") {
                                                                        echo '<th width="5%">Store Name</th>';
                                                                        echo '<th width="5%">Store Domain</th>';
                                                                    }
                                                                    ?>
                                                                    <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "offerUser") { ?>
                                                                        <th width="5%">Company Name</th>
                                                                    <?php } ?>
                                                                    <th width="10%">Status</th>
                                                                    <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser") { ?>
                                                                        <th width="5%">Active/Hold</th>
                                                                    <?php } ?>
                                                                    <th width="5%">Phone</th>
                                                                    <th width="5%">Block/Unblock</th>
                                                                    <th width="5%">Registered Date</th>         
                                                                    <th width="5%">Remaining Ads</th>
                                                                    <th width="10%">Last Login</th>
                                                                    <th width="30%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($users) && sizeof($users) > 0):
                                                                    $ii = 1;
                                                                    foreach ($users as $u) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="hidden" name="redirectUrl" value="<?php echo base_url() . "admin/users/index/" . $users[0]['user_role'] . $redirect; ?>" />
                                                                                <input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $u['user_id']; ?>" />
                                                                            </td>
                                                                            <?php
                                                                            $col_back = '';
                                                                            if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser" && $u['new_data_status'] == 1)
                                                                                $col_back = 'style="background-color:#ffc0bf !important;"';
                                                                            ?>
                                                                            <td <?php echo $col_back; ?> >
                                                                                <?php if (!empty($u['store_f_status']) && $u['store_f_status'] == 'f_ad') { ?>
                                                                                    <span class="f_label" style="">F</span>   
                                                                                <?php } elseif (!empty($u['offer_f_status']) && $u['offer_f_status'] == 'f_ad') {
                                                                                    ?>
                                                                                    <span class="f_label" style="">F</span>
                                                                                <?php }
                                                                                ?>
                                                                                <?php echo $u['email_id']; ?>
                                                                            </td>
                                                                            <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser") { ?>
                                                                                <td <?php echo $col_back; ?>><?php echo $u['store_name']; ?></td>
                                                                                <td <?php echo $col_back; ?>><?php echo $u['store_domain']; ?></td>
                                                                                <td <?php echo $col_back; ?>><?php echo $u['store_is_inappropriate']; ?></td>
                                                                            <?php } ?>

                                                                            <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "offerUser") { ?>
                                                                                <td <?php echo $col_back; ?>><?php echo $u['company_name']; ?></td>
                                                                            <?php } ?>

                                                                            <td <?php echo $col_back; ?>><?php
                                                                                if ($this->uri->segment(4) != '' && in_array($this->uri->segment(4), array("generalUser", "offerUser"))) {
                                                                                    if ($u['is_delete'] == 0)
                                                                                        echo 'Active';
                                                                                    elseif ($u['is_delete'] == 2)
                                                                                        echo 'Not Agree with T&C';
                                                                                    elseif ($u['is_delete'] == 3) {
                                                                                        if ($u['user_role'] == 'storeUser')
                                                                                            echo 'Store Hold';
                                                                                        elseif ($u['user_role'] == 'offerUser')
                                                                                            echo 'Company Hold';
                                                                                    }
                                                                                    elseif ($u['is_delete'] == 4)
                                                                                        echo 'User Blocked';
                                                                                    elseif ($u['is_delete'] == 5)
                                                                                        echo 'Need to fill Store Form';
                                                                                }
                                                                                else {
                                                                                    if ($u['store_status'] == 0)
                                                                                        echo 'Active Store';
                                                                                    elseif ($u['store_status'] == 2)
                                                                                        echo 'Block Store';
                                                                                    elseif ($u['store_status'] == 3)
                                                                                        echo 'Hold Store';
                                                                                    elseif ($u['store_status'] == 6)
                                                                                        echo 'Store Not Approved By Admin';
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td  <?php echo $col_back; ?> style="width:70px;"><?php echo $u['phone']; ?></td>
                                                                            <td <?php echo $col_back; ?>>
                                                                                <?php if ($u['is_delete'] == 4) { ?>
                                                                                    <a onclick="unblock(<?php echo $u['user_id']; ?>);" class='btn btn-success btn-xs' href="javascript:void(0);"><i class='icon-unlock'></i> UnBlock</a>
                                                                                <?php } else { ?>
                                                                                    <a onclick="block(<?php echo $u['user_id']; ?>);" class='btn btn-warning btn-xs' href="javascript:void(0);"><i class='icon-lock'></i> Block</a>    
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td <?php echo $col_back; ?>><?php echo date('Y-m-d', strtotime($u['user_register_date'])); ?></td>    
                                                                            <td <?php echo $col_back; ?>><?php echo $u['userAdsLeft']; ?></td>
                                                                            <td <?php echo $col_back; ?>><?php echo (!empty($u['last_logged_in'])) ? date('Y-m-d H:i:s', strtotime($u['last_logged_in'])) : ''; ?></td>
                                                                            <td>  
                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <?php
                                                                                        $push_notification = $this->permission->has_permission('push_notification');
                                                                                        if ($push_notification == 1) {
                                                                                            if ($u['device_type'] == NULL)
                                                                                                echo '';
                                                                                            elseif ($u['device_type'] == 1) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a class='send_notification' data-id="<?php echo $u['user_id']; ?>" data-for="ios" data-length = '<?php echo $iphone_notification_max_length->val; ?>'>
                                                                                                        <i class="fa fa-apple"></i> Send Notification
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            } elseif ($u['device_type'] == 0) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a class='send_notification' title='' data-id="<?php echo $u['user_id']; ?>" data-for="android" data-length = '<?php echo $android_notification_max_length->val; ?>'>
                                                                                                        <i class="fa fa-android"></i> Send Notification
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        if ($u['email_id'] != '') {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a class='send_message' title='Email' data-id="<?php echo $u['user_id']; ?>">
                                                                                                    <i class="fa fa-envelope"></i> Send Email
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }
                                                                                        if ($u['is_delete'] == 4) {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a class='' href="<?php echo site_url() . 'admin/users/block_list/' . $u['user_id']; ?>" target="_blank">
                                                                                                    <i class="fa fa-list"></i> Block Product List
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        } else {
                                                                                            $classified = $this->permission->has_permission('classified');

                                                                                            if ($classified == 1) {

                                                                                                if ($u['userAdsLeft'] > 0 && in_array($u['is_delete'], array(0, 3)) && in_array($u['user_role'], array('generalUser', 'storeUser'))) {
                                                                                                    if ($u['user_role'] == 'generalUser') {
                                                                                                        ?>
                                                                                                        <li>
                                                                                                            <a class='' href="<?php echo site_url() . 'admin/classifieds/listings_add/listings/classified/?userid=' . $u['user_id']; ?>" title="Add Classified Product"><i class='icon-plus'></i> Ad Post</a>
                                                                                                        </li>
                                                                                                        <li class="divider"></li>
                                                                                                        <?php
                                                                                                    }
                                                                                                    if ($u['user_role'] == 'storeUser') {
                                                                                                        ?>
                                                                                                        <li>
                                                                                                            <a class='' href="<?php echo site_url() . 'admin/classifieds/listings_add/listings/store/?userid=' . $u['user_id']; ?>" title="Add Store Product"><i class='icon-plus'></i> Ad Post</a>
                                                                                                        </li>
                                                                                                        <li class="divider"></li>
                                                                                                        <?php
                                                                                                    }
                                                                                                }
                                                                                                if (in_array($u['user_role'], array('generalUser'))) {
                                                                                                    ?>
                                                                                                    <li>
                                                                                                        <a class='' href='<?php echo base_url() . "admin/classifieds/listings/classified/?userid=" . $u['user_id']; ?>' target="_blank">
                                                                                                            <i class='fa fa-list'></i> New Classified Product List
                                                                                                        </a>
                                                                                                    </li>
                                                                                                    <li class="divider"></li>
                                                                                                    <li>
                                                                                                        <a class='' href='<?php echo base_url() . "admin/classifieds/repost_ads/classified/?userid=" . $u['user_id']; ?>' target="_blank">
                                                                                                            <i class='fa fa-list-ol'></i> Repost Classified Product List
                                                                                                        </a>
                                                                                                    </li>                                                                                                    
                                                                                                    <li class="divider"></li>
                                                                                                    <?php
                                                                                                }
                                                                                                if ($u['user_role'] == 'storeUser') {
                                                                                                    ?>
                                                                                                    <li>
                                                                                                        <a class='' href='<?php echo base_url() . "admin/classifieds/listings/store/?userid=" . $u['user_id']; ?>' target="_blank">
                                                                                                            <i class='fa fa-list'></i> New Classified Product List
                                                                                                        </a>
                                                                                                    </li>
                                                                                                    <li class="divider"></li>
                                                                                                    <li>
                                                                                                        <a class='' href='<?php echo base_url() . "admin/classifieds/repost_ads/store/?userid=" . $u['user_id']; ?>' target="_blank">
                                                                                                            <i class='fa fa-list-ol'></i> Repost Classified Product List
                                                                                                        </a>
                                                                                                    </li>   
                                                                                                    <li class="divider"></li>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            $store_mgt = $this->permission->has_permission('store_mgt');

                                                                                            if ($u['user_role'] == 'storeUser' && $store_mgt == 1) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a href='<?php echo base_url() . "admin/classifieds/listings/store/?userid=" . $u['user_id']; ?>' target="_blank">
                                                                                                        <i class='fa fa-bars'></i> New Store Product List
                                                                                                    </a> 
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <li>
                                                                                                    <a href='<?php echo base_url() . "admin/classifieds/repost_ads/store/?userid=" . $u['user_id']; ?>' target="_blank">
                                                                                                        <i class='fa fa-list-alt'></i> Repost Store Product List
                                                                                                    </a>    
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <li>
                                                                                                    <a href='<?php echo base_url() . "admin/users/e_wallet/?userid=" . $u['user_id']; ?>' target="_blank">
                                                                                                        <i class='fa fa-money'></i> E-wallet
                                                                                                    </a>    
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                            $offer_mgt = $this->permission->has_permission('offer_mgt');
                                                                                            if ($u['user_role'] == 'offerUser' && $offer_mgt == 1) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a href="<?php echo site_url() . 'admin/offers/index/?userid=' . $u['user_id']; ?>" target="_blank">
                                                                                                        <i class="fa fa-list"></i> Offers List
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                        <li>
                                                                                            <a href = '<?php echo base_url() . "admin/users/view/" . $u['user_id'] . '/' . $search; ?>'>
                                                                                                <i class = "fa fa-info-circle"></i> View User Details
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a href = '<?php echo base_url() . "admin/users/edit/" . $u['user_id'] . $search; ?>'>
                                                                                                <i class = 'icon-edit'></i>
                                                                                                Edit User Details
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <?php
                                                                                        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser" && $u['store_id'] != '') {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/view_store/" . $u['store_id'] . '/' . $search; ?>'>
                                                                                                    <i class="fa fa-building-o"></i> View Store Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/edit_store/" . $u['store_id'] . $search; ?>'>
                                                                                                    <i class='icon-edit'></i>&nbsp;Edit Store Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }

                                                                                        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "offerUser") {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/view_offers_company/" . $u['company_user_id'] . $search; ?>'>
                                                                                                    <i class='fa fa-building'></i> View Offer Company Details
                                                                                                </a>  
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/edit_offers_company/" . $u['company_user_id'] . $search; ?>'>
                                                                                                    <i class='icon-edit'></i>&nbsp;Edit Offer Company Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }

                                                                                        $redirect_after_delete = base_url() . "admin/users/delete/" . $u['user_id'] . '/';
                                                                                        if ((isset($search)) && !empty($search))
                                                                                            $redirect_after_delete .= $search;
                                                                                        ?>
                                                                                        <li>              
                                                                                            <a id="delete_user" data-path ='<?php echo $redirect_after_delete; ?>' >
                                                                                                <i class='icon-trash'></i> Delete User
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>                                                                               
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $ii++;
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
                                                    <form method="post" action="" id="userForm" class="form form-horizontal col-md-12">                                                    
                                                        <div class='form-group'>
                                                            <div class='col-md-4'>
                                                                <select style="margin-left: 5px;" class='form-control' id="status_val" name="status" onchange="setfeatured(this);">
                                                                    <option>Select Action</option>
                                                                    <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser" && !empty($users)) { ?>
                                                                        <optgroup label="Update Store as">
                                                                            <option value="featured">Featured Store</option>
                                                                        </optgroup>
                                                                        <?php
                                                                    }
                                                                    if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "offerUser" && !empty($users)) {
                                                                        ?>
                                                                        <optgroup label="Update User Company as">
                                                                            <option value="featured_user_company">Featured User Company</option>
                                                                        </optgroup>
                                                                    <?php } ?>
                                                                    <option value="delete">Delete</option>
                                                                </select>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <input type="hidden" id="checked_val" name="checked_val"/>   
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
        <div class="modal fade center" id="set_featured_unfeatured" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Set Featured Stores</h4>
                    </div>
                    <div class="modal-body">
                        <div class="FeaturedAds-popup">
                            <form action='<?php echo base_url(); ?>admin/users/insert_featured' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form">
                                <div class='box-content control'>
                                    <div class="container">
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <p><strong>From Date</strong></p>
                                                <div class='input-group date' id='datetimepicker8'>
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
                                                <div class='input-group date' id='datetimepicker9'>
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
                                    </a> <input type="hidden" id="checked_values" name="checked_values"/>
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
        <div class="modal fade center" id="set_featured_unfeatured_company" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Set Featured Offer Users</h4>
                    </div>
                    <div class="modal-body">
                        <div class="FeaturedAds-popup">
                            <form action='<?php echo base_url(); ?>admin/users/insert_featured_company' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form_company">
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
                                    <a class='btn btn-primary' href="#" onclick="javascript:insert_featured_company();">
                                        <i class="fa fa-paper-plane"></i>Apply                                      
                                    </a> <input type="hidden" id="checked_values_featured" name="checked_values_featured"/>
                                    <button data-dismiss="modal" class="btn btn-default rounded" type="button" id="cancel">Cancel</button>
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
                        <p id="alert_message_action">Are you sure want delete User(s)?</p>
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

            $(document).find('#per_page1').on('change', function () {
                var per_page = $(this).val();
                console.log(per_page);
                $('#per_page').val(per_page);
                $(document).find('#submit').click();
            });

            $(document).on("click", "#delete_user", function (e) {
                var data_path = $(document).find(this).attr('data-path');
                $('#alert_message_action').html('Are you sure want delete User(s)?');
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        jQuery('#userForm').attr('action', data_path).submit();
                    }
                });
            });

            $('input[name="dt"]').daterangepicker({
                format: "YYYY-MM-DD"
            });
        </script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/moment-with-locales.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap-datetimepicker.js"></script>

        <script type="text/javascript">
            $(document).find(function () {
                $(document).find('#datetimepicker6').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss'
                });
                $(document).find('#datetimepicker7').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss',
                    useCurrent: false
                });
                $(document).find("#datetimepicker6").on("dp.change", function (e) {
                    $(document).find('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                });
                $(document).find("#datetimepicker7").on("dp.change", function (e) {
                    $(document).find('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                });

                $(document).find('#datetimepicker8').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss'
                });
                $(document).find('#datetimepicker9').datetimepicker({
                    format: 'DD-MM-YYYY HH:mm:ss',
                    useCurrent: false
                });
                $(document).find("#datetimepicker8").on("dp.change", function (e) {
                    $(document).find('#datetimepicker9').data("DateTimePicker").minDate(e.date);
                });
                $(document).find("#datetimepicker9").on("dp.change", function (e) {
                    $(document).find('#datetimepicker8').data("DateTimePicker").maxDate(e.date);
                });

            });
//
//            $(function () {
//                $('#date_range_val').daterangepicker({
//                    format: "YYYY-MM-DD"
//                }, function (start, end) {
//                    $("#daterange2").parent().find("input").first().val(start.format("YYYY-MM-DD") + " to " + end.format("YYYY-MM-DD"));
//                });
//            });

            $("#form_mail").validate({
                ignore: 'input[type=hidden]',
                rules: {
                    subject: "required",
                    message: "required"
                },
                messages: {
                    subject: "Please enter Subject",
                    message: "Please enter Message"
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });

            $("#daterange2").daterangepicker({
                format: "MM/DD/YYYY"
            }, function (start, end) {
                $("#daterange2").parent().find("input").first().val(start.format("YYYY-MM-DD") + " to " + end.format("YYYY-MM-DD"));
                show_user();
            });

            function block(Id) {
                $('#alert_message_action').html('Are you sure you want to block this user?');

                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        var path = "<?php echo base_url(); ?>" + "admin/users/block/" + Id + "<?php echo $redirect; ?>";
                        jQuery('#block_status').attr('action', path).submit();
                    }
                });
            }
            function unblock(Id) {

                $('#alert_message_action').html('Are you sure you want to un-block this user?');
                $("#deleteConfirm").modal('show');

                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        var path = "<?php echo base_url(); ?>" + "admin/users/unblock/" + Id + "<?php echo $redirect; ?>";
                        jQuery('#block_status').attr('action', path).submit();
                    }
                });
            }

<?php if (isset($_GET['con']) && $_GET['con'] != '') { ?>
                show_emirates("<?php echo $_GET['con']; ?>");
<?php } ?>

            function show_emirates(val) {
<?php if (isset($_GET['st'])) { ?>
                    var sel_city = '<?php echo $_GET['st']; ?>';
<?php } else { ?>
                    var sel_city = '';
<?php } ?>

                var url = "<?php echo base_url() ?>admin/classifieds/show_emirates";
                $.post(url, {value: val, sel_city: sel_city}, function (data)
                {
                    $("#state_name option").remove();
                    $("#state_name").append(data);
                });
            }


            function show_user() {

                var filter_val = $('#filter_list').val();
                var state_val = "";
                if (filter_val == "cou") {
                    $('#s2id_country_name').show();
                    $('#country_name').show();
                    $('#state_name').show();
                    $('#date_range').hide();
                    $('#date_range_val').val('');
                    var val = $('#country_name').val();
                    state_val = $('#state_name').val();
                } else if (filter_val == "dt") {
                    show_emirates(0);
                    var val = $('#date_range_val').val();
                    $('#date_range').show();
                    $('#state_name').hide();
                    $('#s2id_country_name').hide();
                    $('#country_name').hide();
                    $('#country_name').val(0);
                    $('#state_name').val('');
                } else {
                    show_emirates(0);
                    state_val = $('#state_name').val();
                    var val = $('#filter_list').val();
                    $('#date_range').hide();
                    $('#s2id_country_name').hide();
                    $('#country_name').hide();
                    $('#state_name').hide();
                    $("div.id_100 select").val("All Countries");
                    $('#country_name').val(0);
                    $('#state_name').val('');
                    $('#date_range_val').val('');
                }
            }

            function reset_filter() {
                location.reload();
            }

            $('select#status_val').change(setfeatured);

            function setfeatured()
            {
                var historySelectList = $('select#status_val');
                var selectedValue = $('option:selected', historySelectList).val();

                if (selectedValue == 'featured') {
                    var checkedValues = $('input:checkbox:checked').map(function () {
                        return this.value;
                    }).get();
                    console.log(checkedValues);
                    $('#checked_values').val(checkedValues);
                    if ($('#checked_values').val() == '')
                    {
                        $("#alert").modal('show');
                        $("#error_msg").html("Select any record for Featured Store");
                        //alert("Select any record for Freatured Ad");
                        $("#status_val").each(function () {
                            this.selectedIndex = 0
                        });
                        return false;
                    } else
                        $("#set_featured_unfeatured").modal('show');
                } else if (selectedValue == 'featured_user_company') {
                    var checkedValues = $('input:checkbox:checked').map(function () {
                        return this.value;
                    }).get();
                    $('#checked_values_featured').val(checkedValues);
                    if ($('#checked_values_featured').val() == '')
                    {
                        $("#alert").modal('show');
                        $("#error_msg").html("Select any record for Featured User Company");
                        //alert("Select any record for Freatured Ad");
                        $("#status_val").each(function () {
                            this.selectedIndex = 0
                        });
                        return false;
                    } else
                        $("#set_featured_unfeatured_company").modal('show');
                }
            }
            function insert_featured()
            {
                jQuery('#featured_form').attr('action', "<?php echo base_url(); ?>admin/users/insert_featured").submit();
                return false;
            }

            function insert_featured_company()
            {
                jQuery('#featured_form_company').attr('action', "<?php echo base_url(); ?>admin/users/insert_featured_company").submit();
                return false;
            }

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

//                console.log('selectedValue' + selectedValue + 'checkedValues'+ checkedValues);

                $('#checked_val').val(checkedValues);

                if ($('#checked_val').val() != '') {
                    if (selectedValue == 'delete') {
                        $("#deleteConfirm").modal('show');
                        $(document).on("click", ".yes_i_want_delete", function (e) {
                            var val = $(this).val();
                            if (val == 'yes') {
                                jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/users/delete").submit();
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
            $('#featured_form').validate();
            $('#featured_form_company').validate();
        </script>
        <?php $this->load->view('admin/listings/send_mail'); ?>
    </body>
</html>