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
                                            <i class='icon-key'></i>
                                            <span>Admin Accounts</span>
                                        </h1>

                                        <div class="pull-right">
                                            <a href='<?php echo base_url(); ?>admin/systems/accounts_add' title="Add Admin Account" class="btn">
                                                <i class='icon-plus'></i>
                                                Add Admin Account
                                                <?php
                                                $redirect = $_SERVER['QUERY_STRING'];
                                                if (!empty($_SERVER['QUERY_STRING']))
                                                    $redirect = '/?' . $redirect;
                                                ?>
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
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <?php $this->permission->has_permission('dashboard'); ?>                            
                            <div class='row'>
                                <div class='col-sm-12' id="filter_user_list">
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>
                                                Admin User List 
                                            </div>
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
                                                <div class='scrollable-area table-responsive'>
                                                    <form name="block_status" id="block_status" method="post">
                                                        <table  class=' table  table-striped superCategoryList' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                    <th>Email</th>
                                                                    <th>Block/Unblock</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody >

                                                                <?php
                                                                if (isset($users) && sizeof($users) > 0):
                                                                    foreach ($users as $u) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <input type="hidden" name="redirectUrl" value="<?php echo base_url() . "admin/systems/accounts" . $redirect; ?>" />
                                                                                <input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $u['user_id']; ?>" /></td>
                                                                            <td><?php echo $u['email_id']; ?></td>
                                                                            <td><?php if ($u['is_delete'] == 4) { ?>
                                                                                    <a onclick="unblock(<?php echo $u['user_id']; ?>);" class='btn btn-success btn-xs' href="#"><i class='icon-unlock'></i> UnBlock</a>
                                                                                <?php } else { ?>
                                                                                    <?php if ($u['is_delete'] == 0) { ?>
                                                                                        <a onclick="block(<?php echo $u['user_id']; ?>);" class='btn btn-warning btn-xs' href="#"><i class='icon-lock'></i> Block</a>
                                                                                    <?php } ?>
                                                                                <?php } ?>
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
                                                                                            <a href='<?php echo base_url() . "admin/systems/accounts_view/" . $u['user_id'] . $redirect; ?>'>
                                                                                                <i class="fa fa-info-circle"></i> View User Details
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/systems/accounts_edit/" . $u['user_id'] . $redirect; ?>'>
                                                                                                <i class='icon-edit'></i> Edit User Details
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <?php if ($u['is_delete'] == 1) { ?>
                                                                                                <a data-path='<?php echo base_url() . "admin/systems/accounts_reactivate/" . $u['user_id'] . $redirect; ?>' id="reactivate_admin">
                                                                                                    <i class=' icon-plus '></i> Reactivate User
                                                                                                </a>
                                                                                                <?php
                                                                                            } else {
                                                                                                $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                                                                ?>
                                                                                                <a data-path='<?php echo base_url() . "admin/systems/accounts_delete/" . $u['user_id'] . '/' . $page_redirect; ?>' id="delete_admin">
                                                                                                    <i class='icon-trash'></i> Delete User
                                                                                                </a>
                                                                                            <?php } ?>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                else:
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="4">No Results Found</td>
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
                                                    <?php if (!empty($users)) { ?>
                                                        <input type="hidden" name="redirectUrl" value="<?php echo base_url() . "admin/systems/accounts" ?>" />

                                                        <form method="post" action="" id="userForm" class="form form-horizontal col-md-12">
                                                            <div class='form-group'>
                                                                <div class='col-md-4'>
                                                                    <select style="margin-left: 5px;" class='form-control' id="status_val" name="status">
                                                                        <option>Select Action</option>
                                                                        <option value="delete">Delete</option>
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <input type="hidden" id="checked_val" name="checked_val"/> 
                                                                    <?php
                                                                    $redirect_after_delete = '';
                                                                    if (isset($_REQUEST['page']))
                                                                        $redirect_after_delete .= '?page=' . $_REQUEST['page'];
                                                                    ?>
                                                                    <input type="hidden" id="redirect_me" name="redirect_me" value="<?php echo $redirect_after_delete; ?>" />      

                                                                    <input type="button" class="btn" value="Apply to selected" onclick="update_status();">
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
    <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">  
                    <h4 class="modal-title">Confirmation
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </h4>                   
                </div>
                <div class="modal-body">                  
                    <p id="alert_message_action">Are you sure want to delete Admin User Account(s)?</p>
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
        $(document).find('#per_page1').on('change', function () {
            var per_page = $(this).val();
//            console.log(per_page);
            $('#per_page').val(per_page);
            $(document).find('#submit').click();
        });

        $(document).on("click", "#delete_admin", function (e) {
            var data_path = $(document).find(this).attr('data-path');
//            console.log(data_path);
            $('#alert_message_action').html('Are you sure want to delete Admin User Account(s)?');

            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if (val == 'yes') {
                    jQuery('#block_status').attr('action', data_path).submit();
                }
            });
        });

        $(document).on("click", "#reactivate_admin", function (e) {
            var data_path = $(document).find(this).attr('data-path');
            $('#alert_message_action').html('Are you sure want to Reactivate Admin User Account(s)?');
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if (val == 'yes') {
                    jQuery('#block_status').attr('action', data_path).submit();
                }
            });
        });

        function block(Id) {
            $('#alert_message_action').html('Are you sure you want to block this Admin User Account?');
            $("#deleteConfirm").modal('show');

            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if (val == 'yes') {
                    var path = "<?php echo base_url(); ?>" + "admin/systems/block/" + Id + "<?php echo $redirect; ?>";
                    jQuery('#block_status').attr('action', path).submit();
                }
            });
        }
        function unblock(Id) {
            $('#alert_message_action').html('Are you sure you want to un-block this Admin User Account?');
            $("#deleteConfirm").modal('show');

            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if (val == 'yes') {
                    var path = "<?php echo base_url(); ?>" + "admin/systems/unblock/" + Id + "<?php echo $redirect; ?>";
                    jQuery('#block_status').attr('action', path).submit();
                }
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
                if (selectedValue == 'delete') {
                    $('#alert_message_action').html('Are you sure want to delete Admin User(s) Account?');

                    $("#deleteConfirm").modal('show');
                    $(document).on("click", ".yes_i_want_delete", function (e) {
                        var val = $(this).val();
                        if (val == 'yes') {
                            jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/systems/accounts_delete").submit();
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
</body>
</html>
