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
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>
                                            <i class='icon-list-ol'></i>
                                            <span>Spam Listings</span>
                                            <?php $admin_permission = $this->session->userdata('admin_modules_permission'); ?>
                                        </h1>
                                        <div class='pull-right'>                                            
                                            <a href='<?php echo site_url() . 'admin/classifieds/listings_spam/' . $this->uri->segment(4); ?>' title="Reset Filter" class="btn">
                                                <i class="fa fa-refresh"></i>&nbsp;
                                                Reset Filters
                                            </a>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
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
                            <input type="hidden" id="spam_text" value="<?php echo $spam; ?>"/>
                            <form id="form1" name="form1" action="<?php echo site_url() . 'admin/classifieds/listings_spam/' . $this->uri->segment(4); ?>" method="get" accept-charset="UTF-8">
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
                                                <div class="form-group">
                                                    <select  class="select2 form-control" onchange="show_list();" id="filter_opt" name="filter">
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
                                                    <select id="category" class="select2 form-control" onchange="show_sub_cat(this.value);" <?php
                                                    if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category")
                                                        echo '';
                                                    else
                                                        echo 'style="display:none;"';
                                                    ?> name="cat">
                                                        <option value="0">All Category</option>
                                                        <?php
                                                        foreach ($category as $cat):
                                                            if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category" && isset($_REQUEST['cat']) && (int) $_REQUEST['cat'] == (int) $cat['category_id']) {
                                                                ?>													
                                                                <option value="<?php echo $cat['category_id']; ?>" selected><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option> 
                                                            <?php } else { ?>
                                                                <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                            <?php } ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" id="subcategory_list">												
                                                    <select id="subcategory" name="sub_cat" class="form-control" onchange="show_list();" <?php
                                                    if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category")
                                                        echo '';
                                                    else
                                                        echo 'style="display:none;"';
                                                    ?>  >
                                                        <option value="0">All Sub Category</option>
                                                    </select>
                                                </div>                                           
                                                <div id="date_range">
                                                    <input  id="date_range_val" class='form-control daterange input-group' data-format='yyyy-MM-dd' placeholder='Product Posted Date' type='text' value="<?php if (isset($_REQUEST['dt'])) echo $_REQUEST['dt']; ?>" name="dt">
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
                                                <div class='scrollable-area table-responsive'><!--data-table-->
                                                    <table class='table  table-striped superCategoryList' style='margin-bottom:0;'>
                                                        <thead>
                                                            <tr>
                                                                <?php if ($admin_permission != 'only_listing') { ?>
                                                                    <th width="3%"><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                <?php } ?>
                                                                <th width="10%">Name</th>
                                                                <th width="5%">Image</th>
                                                                <th width="10%">Category</th>
                                                                <th width="5%">Price</th>
                                                                <!-- <th>Status</th> -->
                                                                <th width="10%">Product Is</th>
                                                                <th width="20%">Contact Details</th>
                                                                <th width="40%">Action</th>
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
                                                                        <td><?php echo $pro['product_name']; ?></td>
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
                                                                                <img alt="Category Image" style="height: 40px; width: 64px;" src="<?php echo $image_url; ?>" onerror="this.src='<?php echo site_url(); ?>assets/upload/No_Image.png'"/>
                                                                            </a>

                                                                        </td>
                                                                        <td><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></td>
                                                                        <td><?php echo number_format($pro['product_price'],2); ?></td>
                                                                        <!-- <td><?php //echo $pro['product_status'];                             ?></td> -->
                                                                        <td><?php echo $pro['product_is_inappropriate']; ?> </td>
                                                                        <td>
                                                                            <?php
                                                                            $contact = '';
                                                                            if ($pro['user_name'] != '')
                                                                                echo $contact = '<label>Name: </label>' . $pro['user_name'] . '';
                                                                            if ($pro['user_contact_number'] != '')
                                                                                echo $contact = '<br><label>Contact: </label>' . $pro['user_contact_number'] . '<br>';
                                                                            if ($pro['email_id'] != '') {
                                                                                if ($admin_permission != 'only_listing')
                                                                                    echo $contact = '<a class="btn btn-xs send_message has-tooltip" data-placement="top" title="Email" data-id="' . $pro['user_id'] . '"><i class="fa fa-envelope"></i></a>&nbsp;' . $pro['email_id'];
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
                                                                                    $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                                                    $view_path = base_url() . "admin/classifieds/listings_view/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . $page_redirect;
                                                                                    ?>
                                                                                    <li>
                                                                                        <a href='<?php echo $view_path; ?>'>
                                                                                            <i class="fa fa-info-circle"></i> View Ad
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="divider"></li>
                                                                                    <?php
                                                                                    $edit_path = base_url() . "admin/classifieds/listings_edit/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . $page_redirect;

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

                                                                                    $delete_path = base_url() . "admin/classifieds/listings_delete/" . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $pro['product_id'] . $page_redirect;
                                                                                    ?>
                                                                                    <?php
                                                                                    if ($admin_permission == 'only_listing') {
                                                                                        
                                                                                    } else {
                                                                                        ?>
                                                                                        <li>
                                                                                            <a data-path='<?php echo $delete_path; ?>' id="delete_ad">
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
                                                                                                <a class="" href="<?php echo $user_link_; ?>" target="_blank">
                                                                                                    <i class="fa fa-eye"></i> View Seller Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php if ($pro['user_role'] == 'storeUser' && $user_mgt == 1) { ?>
                                                                                                <li>
                                                                                                    <a class='' href='<?php echo base_url() . "admin/users/view_store/" . $pro['store_id'] . '/' . $search; ?>' target="_blank">
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
                                                                                                <a class="" href="<?php echo site_url() . 'admin/classifieds/repost_ads/' . $product_type__ . '/?userid=' . $pro['user_id']; ?>" target="_blank">
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
                                                                                                    <i class='fa fa-list-alt'></i> Seller's Repost Store Product List
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
                                                            <?php endif;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                    if (sizeof($product) > 0) {
                                                        $admin_permission = $this->session->userdata('admin_modules_permission');
                                                        if ($admin_permission == 'only_listing') {
                                                            
                                                        } else {
                                                            ?>
                                                            <form method="post" action="" id="userForm" class="form form-horizontal col-md-12">
                                                                <div class='form-group'>
                                                                    <div class='col-md-3'>
                                                                        <select style="margin-left: 5px;" class='form-control' id="status_val" name="status">
                                                                            <option value="0">Select Action</option>
                                                                            <optgroup label="Set Status">
                                                                                <option value="available"> Available</option>
                                                                                <option value="sold" >Sold</option>
                                                                            </optgroup>
                                                                            <optgroup label="Product is">
                                                                                <option value="Approve" >Approve</option>
                                                                                <option value="Unapprove" >Unapprove</option>
                                                                                <option value="Inappropriate" >Inappropriate</option>
                                                                            </optgroup>
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
        <div class="modal fade center" id="alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
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
        <script>
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

            $("select#status_val").val('0');
            $(function () {
                $('#date_range_val').daterangepicker({
                    format: "YYYY-MM-DD"
                }, function (start, end) {
                    $("#daterange2").parent().find("input").first().val(start.format("YYYY-MM-DD") + " to " + end.format("YYYY-MM-DD"));
                });
            });

            $("#daterange2").daterangepicker({
                format: "MM/DD/YYYY"
            }, function (start, end) {
                $("#daterange2").parent().find("input").first().val(start.format("YYYY-MM-DD") + " to " + end.format("YYYY-MM-DD"));
                show_list();
            });
            $("#daterange7").daterangepicker({
                format: "MM/DD/YYYY"
            }, function (start, end) {
                $("#daterange7").parent().find("input").first().val(start.format("YYYY-MM-DD") + " to " + end.format("YYYY-MM-DD"));
            });

            function show_list() {
                var filter_opt = $('#filter_opt').val();
                var spam_val = $('#spam_text').val();
                var subcat = "";
                var state_val = "";
                if (filter_opt == 'emirates') {
                    $('#s2id_location').show();
                    $('#state_name').show();
                    $('#s2id_category').hide();
                    $('#subcategory').hide();
                    var val = $('#location').val();
                    var state_val = $('#state_name').val();

                } else if (filter_opt == 'category') {
                    $('#s2id_location').hide();
                    $('#state_name').hide();
                    $('#s2id_category').show();
                    $('#subcategory').show();
                    var val = $('#category').val();
                    var subcat = $('#subcategory').val();

                } else {

                    $('#s2id_location').hide();
                    $('#state_name').hide();
                    $('#s2id_category').hide();
                    $('#subcategory').hide();
                    var val = "";
                }
            }

<?php if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category") { ?>
                show_sub_cat("<?php echo $this->session->userdata('spam_category'); ?>");
<?php } ?>
            function show_sub_cat(val) {
                var sel_sub = 0;
                var url = "<?php echo base_url() ?>admin/classifieds/filter_sub_cat";
<?php if (isset($_REQUEST['filter']) && $_REQUEST['filter'] == "category" && isset($_REQUEST['sub_cat']) && $_REQUEST['sub_cat'] != '0') { ?>
                    sel_sub = "<?php echo $_REQUEST['sub_cat']; ?>";
<?php } ?>
                $.post(url, {value: val, sel_sub: sel_sub}, function (data)
                {
                    $("#subcategory_list").html(data);
                    show_list();
                });
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

                $('#checked_val').val(checkedValues);
                if ($('#checked_val').val() != '') {
                    var valu = $('#checked_values').val();
                    var action = '';

                    if (selectedValue == 'delete') {
                        action = 'listings_delete';
                        $('#alert_message_action').html('Are you sure want delete Ad(s)?');
                        $(".sure .modal-sm .modal-header").css({"background": "#ec1c32"});
                        $("#deleteConfirm").modal('show');
                        $(document).on("click", ".yes_i_want_delete", function (e) {
                            var val = $(this).val();
                            if (val == 'yes') {
                                jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/classifieds/" + action + "/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>").submit();
                            }
                        });
                    } else if (selectedValue == 'available' || selectedValue == 'sold' || selectedValue == 'Approve' || selectedValue == 'Unapprove' || selectedValue == 'Inappropriate') {
                        action = 'update_status';
//                        $('#alert_message_action').html('Are you sure you want to Update Status for Ad?');
//                        $(".sure .modal-sm .modal-header").css({"background":"#337ab7"});
//                        $("#deleteConfirm").modal('show');
//                        $(document).on("click", ".yes_i_want_delete", function (e) {
//                            var val = $(this).val();
//                            if(val=='yes') {
                        jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/classifieds/" + action + "/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>").submit();
//                            }
//                        });                    
                    } else {
                        $("#alert").modal('show');
                        $("#error_msg").html("Select action");
                        return false;
                    }
                } else {
                    $("#alert").modal('show');
                    $("#error_msg").html("Select any record to perform action");
                    return false;
                }

            }

<?php if ($this->session->userdata('spam_filter') != '' && $this->session->userdata('spam_filter') == "emirates") { ?>
                show_emirates("<?php echo $this->session->userdata('spam_country'); ?>");
<?php } ?>

            function show_emirates(val) {
                var sel_city = 0;
                var url = "<?php echo base_url() ?>admin/classifieds/show_emirates";
<?php if ($this->session->userdata('spam_filter') != '' && $this->session->userdata('spam_filter') == "emirates" && $this->session->userdata('spam_state') != 0) { ?>
                    sel_city = "<?php echo $this->session->userdata('spam_state'); ?>";
<?php } ?>

                $.post(url, {value: val, sel_city: sel_city}, function (data)
                {
                    $("#state_name option").remove();
                    $("#state_name").append(data);
                    show_list();
                });
            }
        </script>
        <?php $this->load->view('admin/listings/send_mail'); ?>
    </body>
</html>