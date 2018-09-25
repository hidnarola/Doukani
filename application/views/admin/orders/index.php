<html lang="en">
    <head>
        <?php $this->load->view('admin/include/head'); ?>        
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='row'>
                                <div class="col-sm-12">
                                    <div class="orange-background">
                                        <div class="page-header">
                                            <h1 class='pull-left'>
                                                <i class='icon-list-ol'></i>
                                                <span>Transactions</span>
                                            </h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form id="form1" name="form1" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                <input type="submit" name="submit" id="submit">
                            </form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>
                            </div>
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>

                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Transactions List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class='box-content box-no-padding'>
                                            <div class="table_add_display responsive-table">
                                                <div class="table-responsive foo scrollable-area">
                                                    <form method="post" action="" id="userForm" class="form form-horizontal">
                                                        <table class="display responsive no-wrap my-trading-account-table table automation-table marketing-materials-table" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>                                                                                                                 <th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                    <th>Id</th>
                                                                    <th>Done On</th>
                                                                    <th>Username / Nickname</th>
                                                                    <th>Email Id</th>
                                                                    <th>Contact Number</th>
                                                                    <th>User Type</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                if(isset($transaction_list) && sizeof($transaction_list)>0) :
                                                                    foreach ($transaction_list as $list) { ?>
                                                                    <tr class="transaction-tr<?php echo $list['id']; ?>">                                                                        <td><input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $list['id']; ?>" /></td> 
                                                                        <td><?php echo $list['id']; ?></td>
                                                                        <td>
                                                                            <?php
                                                                            $date = date_create($list['created_date']);
                                                                            echo date_format($date, "d-m-Y H:i:s");
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if (isset($list['nick_name']) && !empty($list['nick_name']))
                                                                                echo $list['nick_name'];
                                                                            elseif (isset($list['username']) && !empty($list['username']))
                                                                                echo $list['username'];
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $list['email_id']; ?></td>
                                                                        <td>
                                                                            <?php
                                                                            if (isset($list['contact_number']) && !empty($list['contact_number']))
                                                                                echo $list['contact_number'];
                                                                            elseif (isset($list['phone']) && !empty($list['phone']))
                                                                                echo $list['phone'];
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php
                                                                            if (isset($list['user_role'])) {
                                                                                if ($list['user_role'] == 'admin')
                                                                                    echo 'Admin';
                                                                                elseif ($list['user_role'] == 'admin')
                                                                                    echo 'Super Admin';
                                                                                elseif ($list['user_role'] == 'generalUser')
                                                                                    echo 'Classified User';
                                                                                elseif ($list['user_role'] == 'storeUser')
                                                                                    echo 'Store User';
                                                                                elseif ($list['user_role'] == 'offerUser')
                                                                                    echo 'Offer User';
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <a class='btn btn-success btn-xs has-tooltip transaction transaction<?php echo $list['id']; ?>' data-placement='top'  title="Open Details" href='javascript:void(0);' aria-controls="<?php echo $list['id']; ?>" ><i class='icon-eye-open'></i></a>
                                                                            &nbsp;
                                                                            <a class='btn btn-success btn-xs has-tooltip transaction-close transaction-close<?php echo $list['id']; ?>' data-placement='top'  title="Close Details" href='javascript:void(0);' aria-controls="<?php echo $list['id']; ?>"><i class='icon-eye-close'></i></a>
                                                                            &nbsp;
                                                                            <?php
                                                                            $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                                            ?>
                                                                            <a class='btn btn-danger btn-xs has-tooltip' data-placement='top' title="Delete Transaction" data-path='<?php echo base_url() . "admin/orders/delete_transaction/" . $list['id'] . $page_redirect; ?>' id="delete_trans"><i class='icon-trash'></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="<?php echo $list['id']; ?>display" style="display:none;">
                                                                        <td colspan="9">
                                                                            <div class="loader_display loader_display<?php echo $list['id']; ?>" >
                                                                                <img src="<?php echo static_image_path; ?>ajax-loader.gif" alt="Loading data..." >  

                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php } 
                                                                else: ?>
                                                               <tr>
                                                                   <td colspan="7">No Results Found</td>
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
                                                <form method="post" action="" id="userForm1" class="form form-horizontal col-md-12">
                                                            <div class='form-group'>
                                                                <div class='col-md-4'>
                                                                    <select style="margin-left: 5px;" class='form-control' id="status_val" name="status" >
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
                            <p id="alert_message_action">Are you sure want delete Transaction(s)?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
    </body>
    <script>
        $(document).find('#per_page1').on('change', function() {
            var per_page  = $(this).val();
            console.log(per_page);
            $('#per_page').val(per_page);
             $(document).find('#submit').click(); 
        });
        $(document).on("click", "#delete_trans", function (e) {
            var data_path = $(document).find(this).attr('data-path');
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if(val=='yes') {
                     jQuery('#userForm').attr('action',data_path).submit();
                }
            });            
        });
            
        $('.loader_display').hide();
        $('.transaction-close').hide();

        $('.transaction').on('click', function (e) {

            var transaction_id = $(this).attr("aria-controls");
            var url = "<?php echo base_url(); ?>admin/orders/order_list";

            $('#' + transaction_id).show();
            $('#' + transaction_id + 'display').show();
            $('.loader_display' + transaction_id).show();
            $.post(url, {transaction_id: transaction_id}, function (response) {

                $('#' + transaction_id + 'display').html('');
                $('#' + transaction_id + 'display').append(response.html);
                $('.transaction-close' + transaction_id).show();
                $('.transaction' + transaction_id).hide();
                $('.loader_display' + transaction_id).hide();
                $('.transaction-tr' + transaction_id).css('background-color', 'rgb(204, 204, 204)');
            }, "json");
            return false;
        });

        $('.transaction-close').on('click', function (e) {

            var transaction_id = $(this).attr("aria-controls");
            $('.loader_display' + transaction_id).show();
            $('#' + transaction_id).hide();
            $('#' + transaction_id + 'display').hide();

            $('.transaction' + transaction_id).show();
            $('.transaction-close' + transaction_id).hide();
            $('.loader_display' + transaction_id).hide();
            $('.transaction-tr' + transaction_id).css('background-color', '');

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
                    action = 'delete';          
                    $("#deleteConfirm").modal('show');
                    $(document).on("click", ".yes_i_want_delete", function (e) {
                        var val = $(this).val();
                        if(val=='yes') {
                             jQuery('#userForm1').attr('action', "<?php echo base_url(); ?>admin/Orders/delete_transaction").submit();
                        }
                    });
                }
                else {
                    $("#alert").modal('show');
                    $("#error_msg").html("Select action");
                }
            }
            else {
                $("#alert").modal('show');
                $("#error_msg").html("Select any record to perform action");
            }
        }
    </script>
</body>
</html>
