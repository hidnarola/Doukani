<html>
    <head>
        <?php $this->load->view('include/head'); ?>
    </head>
    <body>
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
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row profile ord-product-div">
                                            <div class="col-md-10 col-sm-8 col-xs-8 ord-prod-status">                                            
                                                <?php
                                                $current_user = $this->session->userdata('gen_user');

                                                if ($order_details[0]->seller_id == $current_user['user_id']) {
//($order_details[0]->status != 'canceled' || $order_details[0]->status != 'completed'
                                                    if (isset($order_details[0]->status) && !in_array($order_details[0]->status, array('canceled', 'completed'))) {
                                                        ?>
                                                        <div class="col-md-8">
                                                            <form id="update_form" name="update_form" action="<?php echo site_url() . 'user/order_update'; ?>" method='post'>
                                                                <select name="status" id="status" class="form-control">
                                                                    <option value="new" <?php echo ($order_details[0]->status == "new") ? 'selected' : ''; ?> >New</option>
                                                                    <option value="in_progress" <?php echo ($order_details[0]->status == "in_progress") ? 'selected' : ''; ?> >In-progress</option>
                                                                    <option value="completed" <?php echo ($order_details[0]->status == "completed") ? 'selected' : ''; ?> >Completed</option>
                                                                    <option value="canceled" <?php echo ($order_details[0]->status == "canceled") ? 'selected' : ''; ?> >Canceled</option>
                                                                </select>
                                                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_details[0]->id; ?>" >
                                                                <input type="submit" name="update_status" id="update_status" value="Update" class="btn btn-primary">
                                                            </form>                                            
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                if ($order_details[0]->seller_id != $current_user['user_id']) {
                                                    if (isset($order_details[0]->status) && !in_array($order_details[0]->status, array('canceled', 'completed'))) {
                                                        ?>
                                                        <div class="col-md-8">
                                                            <form id="update_form" name="update_form" action="<?php echo site_url() . 'user/order_update'; ?>" method='post'>
                                                                <select name="status" id="status" class="form-control" required="required">
                                                                    <option value="">Select Status</option>
                                                                    <option value="canceled" <?php echo ($order_details[0]->status == "canceled") ? 'selected' : ''; ?>>Canceled</option>
                                                                </select>
                                                                <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_details[0]->id; ?>">
                                                                <input type="submit" name="update_status" id="update_status" value="Update" class="btn btn-primary">
                                                            </form>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                                ?>                                            
                                            </div>                                        
                                            <div class="col-md-2">
                                                <div class="box-header">
                                                    <?php
                                                    if (isset($order_details[0]->status)) {

                                                        $order_status = $order_details[0]->status;
                                                        if ($order_status == 'new')
                                                            echo '<span class="btn-success btn-lg">New</span>';
                                                        elseif ($order_status == 'in_progress')
                                                            echo '<span class="btn-success btn-lg">In-progress</span>';
                                                        elseif ($order_status == 'completed')
                                                            echo '<span class="btn-primary btn-lg"> Completed</span>';
                                                        elseif ($order_status == 'canceled')
                                                            echo '<span class="btn-danger btn-lg">Canceled</span>';
                                                        else
                                                            echo '';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div style="margin-bottom:0;" class="box bordered-box blue-border">
                                                <div class="col-sm-12 ord-prod-title-div">
                                                    <span class="ord-prod-title">Product List</span>
                                                </div>
                                                <div class="responsive-table">
                                                    <div class="scrollable-area">
                                                        <?php if (sizeof($products) > 0) { ?>
                                                            <table style="margin-bottom:0;" class="table order-product-list">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Product </th>
                                                                        <?php if ($order_details[0]->seller_id == $current_user['user_id']) { ?>                                                                            
                                                                            <th class="ord-prod-qty-th">Weight</th>
                                                                        <?php } else { ?>
                                                                            <th class="ord-prod-qty-th">Shipping Option</th>
                                                                        <?php } ?>
                                                                        <th class="ord-prod-qty-th">Quantity</th>
                                                                        <th class="ord-prod-price-th">Price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($products as $pro) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <?php
                                                                                if (!empty($pro['product_image']))
                                                                                    $cover_image = base_url() . product . 'small/' . $pro['product_image'];
                                                                                else
                                                                                    $cover_image = base_url() . 'assets/upload/No_Image.png';
                                                                                ?>
                                                                                <img src="<?php echo thumb_start_cart . $cover_image . thumb_end_cart; ?>"  alt="<?php echo $pro['product_name']; ?>" class="ord-img img-responsive" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'">
                                                                                <?php echo $pro['product_name']; ?>
                                                                            </td>
                                                                            <?php if ($order_details[0]->seller_id == $current_user['user_id']) { ?>                                                                                
                                                                                <td class="ord-prod-qty-td"><?php echo $pro['weight_text']; ?></td>                                                                                
                                                                            <?php } else { ?>
                                                                                <td class="ord-prod-qty-td"><?php echo $pro['option_text']; ?></td>
                                                                            <?php } ?>
                                                                            <td class="ord-prod-qty-td"><?php echo $pro['quantity']; ?></td>
                                                                            <td class="ord-prod-price-td">
                                                                                <?php echo number_format($pro['price'], 2); ?></td>                                                                              
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row ord-details">
                                                <?php if (isset($order_details) && !empty($order_details)) { ?>
                                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                                        <div class="box">
                                                            <div class="box-header">
                                                                <div class="title">
                                                                    Buyer Details
                                                                </div>                      
                                                            </div>
                                                            <div class="box-content">
                                                                <div class="form-group">
                                                                    <label>Receiver Name:</label> 
                                                                    <span><?php echo $order_details[0]->customer_name; ?></span>
                                                                </div>                        
                                                                <div class="form-group">
                                                                    <label>Contact Number:</label>
                                                                    <span><?php echo $order_details[0]->contact_number; ?></span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Email ID:</label>
                                                                    <span><?php echo $order_details[0]->email_id; ?></span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Address:</label>
                                                                    <span><?php
                                                                        $user_address = '';
                                                                        $state_name = $this->dbcart->state_name($order_details[0]->state_id);
                                                                        if (!empty($order_details[0]->address_1))
                                                                            $user_address .= $order_details[0]->address_1;
                                                                        if (!empty($order_details[0]->address_2))
                                                                            $user_address .= ', ' . $order_details[0]->address_2;
                                                                        if (!empty($order_details[0]->state_id))
                                                                            $user_address .= ', ' . $state_name[0]->state_name;
                                                                        if (!empty($order_details[0]->po_box))
                                                                            $user_address .= ', PO Box:' . $order_details[0]->po_box;
                                                                        echo $user_address;
                                                                        ?>
                                                                    </span>    
                                                                </div>                      
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                if (isset($seller_details) && !empty($seller_details)) {
                                                    ?>
                                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                                        <div class="box">
                                                            <div class="box-header">
                                                                <div class="title">
                                                                    <i class="icon-eraser"></i>
                                                                    Seller Details
                                                                </div>                      
                                                            </div>
                                                            <div class="box-content">
                                                                <div class="ord-store-user-profile">
                                                                    <span>
                                                                        <a href="<?php echo HTTP . $seller_details[0]->store_domain . after_subdomain . remove_home; ?>">
                                                                            <?php
                                                                            if (isset($seller_image) && !empty($seller_image) && !empty($seller_image[0]->profile_picture))
                                                                                $seller_image = base_url() . 'assets/upload/profile/original/' . $seller_image[0]->profile_picture;
                                                                            else
                                                                                $seller_image = base_url() . 'assets/upload/avtar.png';
                                                                            ?>
                                                                            <img alt="Seller Image" src="<?php echo thumb_start_cart . $seller_image . thumb_end_cart; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'">
                                                                        </a>
                                                                    </span>
                                                                </div>

                                                                <div class="form-group ord-store-details">
                                                                    <label>Store Name: </label>
                                                                    <?php echo $seller_details[0]->store_name; ?>
                                                                </div>
                                                                <?php if ($seller_details[0]->store_is_inappropriate == 'Approve' && $seller_details[0]->store_status == 0) { ?>
                                                                    <div class="form-group ord-store-link">
                                                                        <a href="<?php echo HTTP . $seller_details[0]->store_domain . after_subdomain . remove_home; ?>" class="btn btn-success">Visit Store</a>
                                                                    </div>                                                                                                                   <?php } ?>   
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-md-4 col-sm-12 col-xs-12">
                                                    <div class="box">
                                                        <div class="box-header">
                                                            <div class="title">
                                                                Shipping Details
                                                            </div>                      
                                                        </div>
                                                        <div class="box-content">
                                                            <div class="form-group">
                                                                <label>Payment Type:</label><span><?php if (isset($order_details[0]->delivery_type)) echo $order_details[0]->delivery_type; ?></span>
                                                            </div>                        
                                                            <div class="form-group">
                                                                <label>Purchased On:</label>
                                                                <span><?php if (isset($order_details[0]->created_date)) echo $order_details[0]->created_date; ?></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Sub-total:</label>
                                                                <span><?php if (isset($order_details[0]->sub_total)) echo number_format($order_details[0]->sub_total, 2); ?></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Shipping Cost:</label>
                                                                <span><?php if (isset($order_details[0]->shipping_cost)) echo number_format($order_details[0]->shipping_cost, 2); ?></span>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Final Total:</label>
                                                                <span><?php if (isset($order_details[0]->final_total)) echo number_format($order_details[0]->final_total, 2); ?></span>
                                                            </div>                                                        
                                                            <div class="form-group">
                                                                <label>Status:</label>
                                                                <span><?php
                                                                    if (isset($order_details[0]->status)) {

                                                                        $order_status = $order_details[0]->status;
                                                                        if ($order_status == 'new')
                                                                            echo '<span class="btn-success btn-lg">New</span>';
                                                                        elseif ($order_status == 'in_progress')
                                                                            echo '<span class="btn-success btn-lg">In-progress</span>';
                                                                        elseif ($order_status == 'completed')
                                                                            echo '<span class="btn-primary btn-lg"> Completed</span>';
                                                                        elseif ($order_status == 'canceled')
                                                                            echo '<span class="btn-danger btn-lg">Canceled</span>';
                                                                        else
                                                                            echo '';
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </div>                      
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><br><br>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--//content-->
                        </div>
                    </div>
                    <!--//main-->
                </div>
            </div>
        </div>        
        <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>
</body>
</html>
