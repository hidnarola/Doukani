<td></td>
<td colspan="8">
    <?php if (isset($transaction_list) && sizeof($transaction_list) > 0) { ?>
    <div>
        <div class='box-content box-no-padding'>
            <div class="table_add_display responsive-table">
                <div class="table-responsive foo scrollable-area">                    
                        <table class="display responsive no-wrap my-trading-account-table table automation-table marketing-materials-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th colspan="9" class="box-header blue-background">Orders</th>
                                </tr>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Seller Username / Nick Name</th>
                                    <th>Store Name</th>
                                    <th>Store Domain</th>
                                    <th>Contact Number</th>
                                    <th>Email Id</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaction_list as $list) { ?>
                                    <tr href="#<?php echo $list['id']; ?>">                                                                
                                        <td><i class="fa fa-caret-down" aria-hidden="true"></i>&nbsp;<?php echo $list['order_number']; ?></td>
                                        <td><?php echo $list['delivery_type']; ?></td>
                                        <td>
                                            <?php
                                            $order_status = $list['status'];

                                            if ($order_status == 'new')
                                                echo '<span class="label label-success">New</span>';
                                            elseif ($order_status == 'in_progress')
                                                echo '<span class="label label-success">In-progress</span>';
                                            elseif ($order_status == 'completed')
                                                echo '<span class="label label-primary"> Completed</span>';
                                            elseif ($order_status == 'canceled')
                                                echo '<span class="label label-danger">Canceled</span>';
                                            else
                                                echo '';
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
                                        <td><?php echo $list['store_name']; ?></td>
                                        <td><?php echo $list['store_domain']; ?></td>
                                        <td>
                                            <?php
                                            if (isset($list['contact_number']) && !empty($list['contact_number']))
                                                echo $list['contact_number'];
                                            elseif (isset($list['phone']) && !empty($list['phone']))
                                                echo $list['phone'];
                                            ?>
                                        </td>
                                        <td><?php echo $list['email_id']; ?></td>
                                        <td>
                                            <a href="<?php echo site_url() . 'admin/orders/order_details/' . $list['order_id']; ?>" class="btn btn-warning view_details" id="<?php echo $list['order_id']; ?>"><i class="icon-eye-open"></i></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
    <?php } 
          else { 
                echo '<p style="color:red;">No record found...</p>';
          } 
    ?>
</td>