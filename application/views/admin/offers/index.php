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
                                            <i class='icon-tags'></i>
                                            <?php
                                            $to_text = '';
                                            $tod = '';
                                            if ($this->uri->segment(4) == 'today') {
                                                $to_text = 'Today';
                                                $tod = 'today';
                                            }
                                            ?>
                                            <span><?php echo $to_text; ?> Offers</span>
                                            <?php $admin_permission = $this->session->userdata('admin_modules_permission'); ?>
                                        </h1>
                                        <div class='pull-right'>
                                            <a href='<?php echo base_url(); ?>admin/offers/add' title="Add Offer" class="btn">
                                                <i class='icon-plus'></i>
                                                Add Offers
                                            </a>
                                            <?php if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) { ?>
                                                <a href='<?php echo site_url() . 'admin/offers/index/' . $tod . '/?userid=' . $_REQUEST['userid']; ?>' class="btn">
                                                    <i class="fa fa-refresh"></i>
                                                    Reset Filters
                                                </a>
                                            <?php } else { ?>
                                                <a href='<?php echo site_url() . 'admin/offers/index/' . $tod; ?>' class="btn">
                                                    <i class="fa fa-refresh"></i>
                                                    Reset Filters
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
                                    <h5><span class="f_label" >F</span> - Featured Offer</h5>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?> 
                            <?php if ($this->session->flashdata('msg1') != ''): ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg1'); ?>
                                </div>
                            <?php endif; ?>
                            <form id="form1" name="form1" action="<?php echo site_url() . 'admin/offers/index/' . $today_request; ?>" method="get" accept-charset="UTF-8">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <div class="title">Show By Category</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content ">

                                                <?php if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) { ?>
                                                    <input type="hidden" id="userid" name="userid" value="<?php echo $_REQUEST['userid']; ?>">
                                                <?php } else { ?>
                                                    <div class="form-group">
                                                        <select id="cat" class="select2 form-control" name="cat">
                                                            <option value="all" <?php if (isset($_GET['cat']) && $_GET['cat'] == "all") echo 'selected=selected'; ?>>All</option>
                                                            <?php
                                                            foreach ($category as $o) {
                                                                if (isset($_GET['cat']) && $_GET['cat'] == $o['category_id']) {
                                                                    ?>
                                                                    <option value="<?php echo $o['category_id']; ?>" selected><?php echo str_replace('\n', " ", $o['catagory_name']); ?></option>
                                                                <?php } else { ?>
                                                                    <option value="<?php echo $o['category_id']; ?>"><?php echo str_replace('\n', " ", $o['catagory_name']); ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                <?php } ?>
                                                <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">

                                                <div class='' id="date_range">
                                                    <input  id="date_range_val" class='form-control daterange input-group' data-format='yyyy-MM-dd' placeholder='Offer Posted Date' type='text' value="<?php if (isset($_GET['dt']) && !empty($_GET['dt'])) echo $_GET['dt']; ?>" name="dt">
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
                                                        <option value="all">All</option>
                                                        <option value="approve" <?php if (isset($_GET['status']) && $_GET['status'] == 'approve') echo 'selected=selected'; ?>>Approve</option>
                                                        <option value="unapprove" <?php if (isset($_GET['status']) && $_GET['status'] == 'unapprove') echo 'selected=selected'; ?>>Unapprove</option>
                                                        <option value="WaitingForApproval" <?php if (isset($_GET['status']) && $_GET['status'] == 'WaitingForApproval') echo 'selected=selected'; ?>>Waiting for Approval</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header">
                                                <button type="submit" name="submit" id="submit" class="btn btn-primary">
                                                    <i class="fa fa-search"></i> Search
                                                </button>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </form>                            
                            <hr class="hr-normal">
                            <div class='row'>
                                <div class='col-sm-12' id="filter_offer_list">
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Offer List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <form id="form1" name="form1" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                            <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                            <input type="submit" name="submit" id="submit">
                                        </form>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'><!-- data-table-->
                                                    <form name="offer_list" id="offer_list" method="post">
                                                        <table class=' table  table-striped superCategoryList' style='margin-bottom:0;'>
                                                            <thead style="text-align: center;">
                                                                <tr>
                                                                    <?php if ($admin_permission != 'only_listing') { ?>
                                                                        <th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                    <?php } ?>
                                                                    <th>Title</th>
                                                                    <th>Offer Is</th>
                                                                    <th>Start Date</th>
                                                                    <th>End Date</th>
                                                                    <th>Contact Details</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($offers) && sizeof($offers) > 0):
                                                                    foreach ($offers as $o) {
                                                                        ?>
                                                                        <tr>
                                                                            <?php if ($admin_permission != 'only_listing') { ?>
                                                                                <td><input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $o['offer_id']; ?>" /></td>
                                                                            <?php } ?>
                                                                            <td>
                                                                                <?php if (!empty($o['offer_f_status']) && $o['offer_f_status'] == 'f_ad') { ?>
                                                                                    <span class="f_label" style="">F</span> <?php } ?>
                                                                                <?php echo $o['offer_title']; ?>
                                                                            </td>
                                                                            <td><?php echo ucfirst($o['offer_is_approve']); ?></td>

                                                                            <td><?php echo $o['offer_start_date']; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if (isset($o['offer_end_date']) && $o['offer_end_date'] == '0000-00-00')
                                                                                    echo 'No End Date';
                                                                                else
                                                                                    echo $o['offer_end_date'];
                                                                                ?>
                                                                            </td>
                                                                            <?php
                                                                            if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'today')
                                                                                $today = '/today';
                                                                            else
                                                                                $today = '';
                                                                            ?>
                                                                            <td>
                                                                                <?php
                                                                                $contact = '';
                                                                                if ($o['company_name'] != '')
                                                                                    echo $contact = '<label>Company Name: </label>' . $o['company_name'] . '<br>';
                                                                                if ($o['user_name'] != '')
                                                                                    echo $contact = '<label>Name: </label>' . $o['user_name'] . '<br>';
                                                                                if ($o['user_contact_number'] != '')
                                                                                    echo $contact = '<label>Contact: </label>' . $o['user_contact_number'] . '<br>';
                                                                                if ($o['email_id'] != '') {
                                                                                    if ($admin_permission != 'only_listing')
                                                                                        echo $contact = '<a class="btn btn-xs send_message has-tooltip" data-placement="top" title="Email" data-id="' . $o['user_id'] . '"><i class="fa fa-envelope"></i></a>&nbsp;' . $o['email_id'];
                                                                                    else
                                                                                        echo $contact = '<label>Email ID: </label>' . $o['email_id'];
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
                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/offers/view/" . $o['offer_id'] . '/' . $today . $search; ?>'>
                                                                                                <i class="fa fa-info-circle"></i> View Offer
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <?php if (($admin_permission == 'only_listing' && $o['offer_posted_by'] == $admin_user->user_id && $o['offer_is_approve'] == 'unapprove') || empty($admin_permission)) { ?>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/offers/edit/" . $o['offer_id'] . '/' . $today . $search; ?>'>
                                                                                                    <i class='icon-edit'></i> Edit Offer
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }
                                                                                        if ($admin_permission == 'only_listing') {
                                                                                            
                                                                                        } else {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a id="delete_offer" data-path ='<?php echo base_url() . "admin/offers/delete/" . $o['offer_id'] . '/' . $today . $search; ?>' >
                                                                                                    <i class='icon-trash'></i> Delete Offer
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }
                                                                                        if (isset($o['user_role']) && !isset($_REQUEST['userid']) && $o['user_role'] != 'superadmin' && $admin_permission != 'only_listing') {
                                                                                            $product_type__ = $this->uri->segment(4);

                                                                                            if ($o['user_role'] == 'admin')
                                                                                                $user_link_ = site_url() . 'admin/systems/accounts_view/' . $o['user_id'];
                                                                                            else
                                                                                                $user_link_ = site_url() . 'admin/users/view/' . $o['user_id'];

                                                                                            if ($o['device_type'] == NULL)
                                                                                                echo '';
                                                                                            elseif ($o['device_type'] == 1) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a class='send_notification' data-id="<?php echo $o['user_id']; ?>" data-for="ios" data-length = '<?php echo $iphone_notification_max_length->val; ?>'>
                                                                                                        <i class="fa fa-apple"></i> Send Notification
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            } elseif ($o['device_type'] == 0) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a class='send_notification' data-id="<?php echo $o['user_id']; ?>" data-for="android" data-length = '<?php echo $android_notification_max_length->val; ?>'>
                                                                                                        <i class="fa fa-android"></i> Send Notification
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                            <li>
                                                                                                <a href="<?php echo $user_link_; ?>" target="_blank">
                                                                                                    <i class="fa fa-eye"></i> View Seller Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/view_offers_company/" . $o['company_user_id']; ?>' target="_blank">
                                                                                                    <i class='fa fa-building'></i> View Offer Company Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <a href="<?php echo site_url() . 'admin/offers/index/' . $tod . '?userid=' . $o['user_id']; ?>" target="_blank">
                                                                                                    <i class="fa fa-list"></i> Offer List
                                                                                                </a>
                                                                                            </li>
                                                                                            <?php
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
                                                    <?php
                                                    if ($admin_permission == 'only_listing') {
                                                        
                                                    } else {
                                                        ?>
                                                        <form method="post" action="" id="userForm" class="form form-horizontal col-md-12">
                                                            <div class='form-group'>
                                                                <div class='col-md-4'>
                                                                    <select style="margin-left: 5px;" class='form-control' id="status_val" name="status" onchange="setfeatured(this);">
                                                                        <option>Select Action</option>
                                                                        <optgroup label="Offer is">
                                                                            <option value="approve" >Approve</option>
                                                                            <option value="unapprove" >Unapprove</option>
                                                                        </optgroup>
                                                                        <optgroup label="Update Offer as">
                                                                            <option value="featured_offer">Featured Offer</option>
                                                                        </optgroup>
                                                                        <option value="delete">Delete</option>
                                                                    </select>  
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <?php
                                                                    $redirect_after_delete = '';
                                                                    if ((isset($search)) && !empty($search))
                                                                        $redirect_after_delete .= $search;
                                                                    ?>
                                                                    <input type="hidden" id="redirect_me" name="redirect_me" value="<?php echo $redirect_after_delete; ?>" />
                                                                    <input type="hidden" id="checked_val" name="checked_val"/>
                                                                    <input type="hidden" id="today" name="today" 
                                                                           value="<?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'today') echo 'today'; ?>" />
                                                                    <input type="button" class="btn" value="Apply to selected" onclick="update_status();">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <?php } ?>
                                                    <br><br><br><br>
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
            <div class="modal fade center" id="set_featured_unfeatured" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content rounded">
                        <div class="modal-header text-center orange-background">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                            <h4 id="myLargeModalLabel" class="modal-title">Set Featured Offer </h4>
                        </div>
                        <div class="modal-body">
                            <div class="FeaturedAds-popup">
                                <form action='<?php echo base_url(); ?>admin/users/insert_featured_offer' class='form form-horizontal' accept-charset="UTF-8" method='post' id="insert_featured_offer">
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
                                        <a class='btn btn-primary' href="#" onclick="javascript:insert_featured_offer();">
                                            <i class="fa fa-paper-plane"></i>Apply                                      
                                        </a> <input type="hidden" id="checked_values" name="checked_values"/>
                                        <input type="hidden" id="today" name="today" value="<?php echo '/' . $this->uri->segment(4); ?>"/>
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
                            <p id="alert_message_action">Are you sure want to delete Offer(s)?</p>
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
        <script type="text/javascript">
            $('input[name="dt"]').daterangepicker({
                format: "YYYY-MM-DD"
            });
        </script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/moment-with-locales.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap-datetimepicker.js"></script>
        <script>

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

            $(document).find('#per_page1').on('change', function () {
                var per_page = $(this).val();
                $('#per_page').val(per_page);
                $(document).find('#submit').click();
            });

            $(document).on("click", "#delete_offer", function (e) {
                var data_path = $(document).find(this).attr('data-path');
                $('#alert_message_action').html('Are you sure want to delete Offer(s)?');
                $(".sure .modal-sm .modal-header").css({"background": "#ec1c32"});
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        jQuery('#offer_list').attr('action', data_path).submit();
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
                    var action = 'update_status';
                    if (selectedValue == 'delete') {
                        action = 'delete';
                        $('#alert_message_action').html('Are you sure want to delete Offer(s)?');
                        $(".sure .modal-sm .modal-header").css({"background": "#ec1c32"});
                        $("#deleteConfirm").modal('show');
                        $(document).on("click", ".yes_i_want_delete", function (e) {
                            var val = $(this).val();
                            if (val == 'yes') {
                                jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/offers/" + action).submit();
                            }
                        });
                    } else if (selectedValue == 'active' || selectedValue == 'inactive' || selectedValue == 'approve' || selectedValue == 'unapprove') {
                        $('#alert_message_action').html('Are you sure you want to Update Status for Offer(s)?');
                        $(".sure .modal-sm .modal-header").css({"background": "#337ab7"});
                        $("#deleteConfirm").modal('show');
                        $(document).on("click", ".yes_i_want_delete", function (e) {
                            var val = $(this).val();
                            if (val == 'yes') {
                                jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/offers/" + action).submit();
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

            function setfeatured()
            {
                var historySelectList = $('select#status_val');
                var selectedValue = $('option:selected', historySelectList).val();


                if (selectedValue == 'featured_offer') {
                    var checkedValues = $('input:checkbox:checked').map(function () {
                        return this.value;
                    }).get();

                    $('#checked_values').val(checkedValues);

                    console.log("===" + $('#checked_values').val());
                    if ($('#checked_values').val() == '' || $('#checked_values').val() == undefined)
                    {
                        $("#alert").modal('show');
                        $("#error_msg").html("Select any record for Featured Offer");
                        //alert("Select any record for Freatured Ad");
                        $("#status_val").each(function () {
                            this.selectedIndex = 0
                        });
                        return false;
                    } else
                        $("#set_featured_unfeatured").modal('show');
                }
            }

            function reset_filter() {
<?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'today') { ?>
                    window.location = "<?php echo site_url() . 'offers/today'; ?>";
<?php } else { ?>
                    window.location = "<?php echo site_url() . 'offers'; ?>";
<?php } ?>
            }

            function insert_featured_offer()
            {
                jQuery('#insert_featured_offer').attr('action', "<?php echo base_url(); ?>admin/offers/insert_featured_offer").submit();
                return false;
            }

        </script>
        <?php $this->load->view('admin/listings/send_mail'); ?>
    </body>
</html>