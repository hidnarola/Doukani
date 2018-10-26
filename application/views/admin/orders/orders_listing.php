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
                                            <i class='icon-list-alt'></i>
                                            <span>Orders Listing</span>
                                        </h1>
                                        <div class='pull-right'>                                            
                                            <a class="btn" href="<?php echo base_url() . "admin/orders/order_listing"; ?>">
                                                <i class="fa fa-refresh"></i> Reset Filters
                                            </a>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                            <form id="form2" name="form2" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                <input type="submit" name="submit1" id="submit1">
                            </form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>
                            </div>
                            <form accept-charset="UTF-8" method="post" action="<?php echo site_url() . 'admin/orders/order_listing'; ?>" name="form1" id="form1">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div style="margin-bottom:0;" class="box bordered-box orange-border">
                                            <div class="box-header orange-background">
                                                <div class="title">Search Order Number</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content">
                                                <div class="form-group col-sm-8">
                                                    <input type="text" name="search_order" value="<?php if (isset($_POST['search_order']) && !empty($_POST['search_order'])) echo $_POST['search_order']; ?>" placeholder="Order Number" class="form-control" id="search_order">
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn btn-primary" id="" name="submit_filter" type="submit">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>
                            <br>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Orders</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <form method="post" action="" id="userForm" class="form form-horizontal">
                                                        <table class="display responsive no-wrap my-trading-account-table table automation-table marketing-materials-table superCategoryList" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                    <th>Order Number</th>
                                                                    <th>Type</th>
                                                                    <th>Date</th>
                                                                    <th>Customer Details</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($orders) && sizeof($orders) > 0) {
                                                                    foreach ($orders as $ord) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $ord['order_id']; ?>" /></td>
                                                                            <td><?php echo $ord['order_number']; ?></td>
                                                                            <td><?php echo $ord['delivery_type']; ?></td>
                                                                            <td><?php
                                                                                $created_date = date_create($ord['created_date']);
                                                                                echo date_format($created_date, 'd-m-Y H:i');
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                echo '<label>Customer Name: </label>' . $ord['customer_name'];
                                                                                echo '<br>';
                                                                                echo '<label>Contact Number: </label>' . $ord['contact_number'];
                                                                                echo '<br>';
                                                                                echo '<label>Email id: </label>' . $ord['email_id'];
                                                                                echo '<br>';

                                                                                $user_address = '';
                                                                                $state_name = $this->dbcart->state_name($ord['state_id']);

                                                                                if (!empty($ord['address_1']))
                                                                                    $user_address .= $ord['address_1'];
                                                                                if (!empty($ord['address_2']))
                                                                                    $user_address .= ', ' . $ord['address_2'];
                                                                                if (!empty($ord['state_id']))
                                                                                    $user_address .= ', ' . $state_name[0]->state_name;
                                                                                if (!empty($ord['po_box']))
                                                                                    $user_address .= ', PO Box:' . $ord['po_box'];
                                                                                echo '<label>Address:</label>' . $user_address;
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $order_status = $ord['order_status'];

                                                                                if ($order_status == 'new')
                                                                                    echo '<span class="label label-success">New</span>';
                                                                                elseif ($order_status == 'in_progress')
                                                                                    echo '<span class="label label-success">In-progress</span>';
                                                                                elseif ($order_status == 'completed')
                                                                                    echo '<span class="label label-success">Completed</span>';
                                                                                elseif ($order_status == 'canceled')
                                                                                    echo '<span class="label label-danger">Canceled</span>';
                                                                                else
                                                                                    echo '';
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
                                                                                            <a href="<?php echo site_url() . 'admin/orders/order_details/' . $ord['order_id']; ?>">
                                                                                                <i class="fa fa-eye" aria-hidden="true"></i> Order Details 
                                                                                            </a> 
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <?php
                                                                                            $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                                                            ?>
                                                                                            <a class="delete-order" data-path='<?php echo base_url() . "admin/orders/delete_order/" . $ord['order_id'] . $page_redirect; ?>' id="delete_order">
                                                                                                <i class="fa fa-remove" aria-hidden="true"></i> Delete Order
                                                                                            </a>
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
                                                                        <td colspan="8">No Results Found</td>
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
            <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">  
                            <h4 class="modal-title">Confirmation
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>                   
                        </div>
                        <div class="modal-body">                  
                            <p id="alert_message_action">Are you sure want delete Order(s)?</p>
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
    </body>
    <script>
        $(document).find('#per_page1').on('change', function () {
            var per_page = $(this).val();
//            console.log(per_page);
            $('#per_page').val(per_page);
            $(document).find('#submit1').click();
        });
        $(document).on("click", "#delete_order", function (e) {
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
                    action = 'delete';
                    $("#deleteConfirm").modal('show');
                    $(document).on("click", ".yes_i_want_delete", function (e) {
                        var val = $(this).val();
                        if (val == 'yes') {
                            jQuery('#userForm1').attr('action', "<?php echo base_url(); ?>admin/Orders/delete_order").submit();
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
</html>
