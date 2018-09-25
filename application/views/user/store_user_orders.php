<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
        <div class="container-fluid">
            <!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
            <!--//ad1 header-->
            <!--menu-->
            <?php $this->load->view('include/menu'); ?>
            <!--//menu-->
            <!--body-->
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main dashboard">
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <!--content-->
                            <div class="col-sm-10 ContentRight">                    	                      
                                <?php $this->load->view('user/user_menu'); ?>
                                <?php if (isset($msg)): ?>
                                    <div class='alert  alert-info'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <center><?php echo $msg; ?></center>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('flash_message') != ''): ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $this->session->flashdata('flash_message'); ?>
                                    </div>
                                <?php endif; ?>
                                <!--Most Viewed product items-->
                                <br>
                                <div class="row">                                   
                                    <div class="col-md-12">
                                        <div class="row profile order-div">
                                            <div class="col-xs-4 col-sm-4">
                                                <div class="order-menu">
                                                    <?php
                                                    $create_path = site_url() . $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3);
                                                    ?>
                                                    <select name="order_status" id="order_status" class="form-control" style="width:auto;max-width:150px;">
                                                        <option value="">Find By Status</option>
                                                        <option value="new" <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'new') echo 'selected=selected'; ?>>New</option>
                                                        <option value="in_progress" <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'in_progress') echo 'selected=selected'; ?>>In-progress</option>
                                                        <option value="completed" <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'completed') echo 'selected=selected'; ?>>Completed</option>
                                                        <option value="canceled" <?php if ($this->uri->segment(4) != '' && $this->uri->segment(4) == 'canceled') echo 'selected=selected'; ?>>Canceled</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-sm-8">              
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-8">
                                                        <form name="search_order_form" id="search_order_form" action="<?php echo $create_path; ?>" method="post">
                                                            <div class="order-search" style="width:auto;">
                                                                <input type="text" name="search_order" id="search_order" class="form-control" placeholder="Order Number">
                                                                <input type="submit" value="Search" name="search_submit" id="search_submit" class="btn btn-success">
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-sm-12 col-md-4">
                                                        <a href="<?php echo $create_path; ?>" class="btn btn-primary reset-order-btn"><i class="fa fa-refresh"></i><span>Reset Filters</span></a>
                                                    </div>
                                                </div>              
                                            </div>
                                        </div>
                                        <?php if (sizeof($orders) > 0) { ?>

                                            <div  id="most-viewed profile">                                        
                                                <div style="margin-bottom:0;" class="box bordered-box blue-border">
                                                    <div class="box-header blue-background order-list">
                                                        <div class="responsive-table profile">
                                                            <div class="scrollable-area">
                                                                <table style="margin-bottom:0;" class="table table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Order Number</th>
                                                                            <th>Type</th>
                                                                            <th>Date</th>
                                                                            <th class="ord-cust_details">Customer Details</th>
                                                                            <th class="ord-action">Status</th>
                                                                            <th class="ord-action">Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        foreach ($orders as $ord) {
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo $ord['order_number']; ?></td>
                                                                                <td><?php echo $ord['delivery_type']; ?></td>
                                                                                <td><?php
                                                                                    $created_date = date_create($ord['created_date']);
                                                                                    echo date_format($created_date, 'd-m-Y H:i');
                                                                                    ?>
                                                                                </td>
                                                                                <td>
                                                                                    <?php
                                                                                    echo '<label>Customer Name:</label>' . $ord['customer_name'];
                                                                                    echo '<br>';
                                                                                    echo '<label>Contact Number:</label>' . $ord['contact_number'];
                                                                                    echo '<br>';
                                                                                    echo '<label>Email id:</label>' . $ord['email_id'];
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
                                                                                <td class="ord-list-status ord-action">
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
                                                                                    <div class="ord-action">
                                                                                        <a href="<?php echo site_url() . 'user/order_list/' . $ord['order_id']; ?>" class="btn btn-warning">
                                                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                                                        </a>                                                
                                                                                        <?php
                                                                                        $current_user = $this->session->userdata('gen_user');

                                                                                        if ($ord['delete_rights'] == 'yes' && isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser' && $ord['order_status'] == 'completed') {
                                                                                            ?>
                                                                                            <a href="javascript:void(0);" class="btn btn-danger delete-order" id="<?php echo $ord['order_id']; ?>">
                                                                                                <i class="fa fa-remove" aria-hidden="true"></i>
                                                                                            </a>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                                <nav class="col-sm-12 text-right">
                                                                    <?php echo $links; ?>
                                                                </nav>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        <?php } else { ?>
                                            <div class="catlist col-sm-10">
                                                <div class="TagsList">
                                                    <div class="subcats">
                                                        <div class="col-sm-12 no-padding-xs">
                                                            <div class="col-sm-12">
                                                                No records found
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <!--End Most Viewed product items-->
                                </div>
                                <!--//content-->
                            </div>
                        </div>
                        <!--//main-->
                    </div>
                </div>
            </div>   
            <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">  
                            <h4 class="modal-title"><i class="fa fa-check-square-o"></i>Confirmation
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>                   
                        </div>
                        <div class="modal-body">                  
                            <p>Are you sure you want to delete this Order?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('include/footer'); ?>
            <!--//footer-->
            <script>

                $(document).on("click", ".delete-order", function (e) {

                    var order_id = $(this).attr('id');
                    $("#deleteConfirm").modal('show');
                    $(document).on("click", ".yes_i_want_delete", function (e) {
                        var val = $(this).val();
                        if (val == 'yes') {
                            var url = "<?php echo base_url(); ?>user/delete_order";
                            $.post(url, {order_id: order_id}, function (data) {
                                window.location = "<?php echo current_url(); ?>";
                            });
                        }
                    });
                });

                $(document).on("change", "#order_status", function (e) {
                    var val = $(this).val();
                    window.location = "<?php echo base_url(); ?>user/orders/" + "<?php echo $this->uri->segment(3); ?>/" + val;
                    return false;
                });
            </script>
        </div>
    </body>
</html>
