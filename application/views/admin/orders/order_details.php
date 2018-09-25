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
                    <div class="col-sm-12 row">
                        <br><br><br>
                        <div class="box-header">                                                    
                            <?php if (isset($order_details[0]->status)) { ?>                                        <form id="update_form" name="update_form" action="<?php echo site_url() . 'admin/orders/order_update'; ?>" method='post'>
                                    <div class="col-sm-2">
                                        <label>Update Status</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <select name="status" id="status" class="form-control col-md-8">
                                            <option value="new" <?php echo ($order_details[0]->status == "new") ? 'selected' : ''; ?> >New</option>
                                            <option value="in_progress" <?php echo ($order_details[0]->status == "in_progress") ? 'selected' : ''; ?> >In-progress</option>
                                            <option value="completed" <?php echo ($order_details[0]->status == "completed") ? 'selected' : ''; ?> >Completed</option>
                                            <option value="canceled" <?php echo ($order_details[0]->status == "canceled") ? 'selected' : ''; ?> >Canceled</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="hidden" name="order_id" id="order_id" value="<?php echo $order_details[0]->id; ?>" >
                                        <input type="submit" name="update_status" id="update_status" value="Update" class="btn btn-primary col-md-4">
                                    </div>    
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                    <br><br>                    
                    <div class='row' id='content-wrapper'>                        
                        <div class="col-sm-12">                            
                            <div class="col-sm-12 ContentRight">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div style="margin-bottom:0;" class="box bordered-box blue-border">
                                            <div class="box-header blue-background">
                                                <div class="title">Product List</div>
                                                <div class=""></div>                      
                                            </div>
                                            <div class='box-content box-no-padding'>
                                            <div class="responsive-table">
                                                <div class="scrollable-area">
                                                    <?php if (sizeof($products) > 0) { ?>
                                                        <table style="margin-bottom:0;" class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product </th>
                                                                    <th>Quantity</th>
                                                                    <th>Price</th>
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
                                                                                $cover_image = base_url() .product. 'small/' . $pro['product_image'];
                                                                            else
                                                                                $cover_image = base_url() . 'assets/upload/No_Image.png';
                                                                            ?>
                                                                            <img src="<?php echo thumb_start_cart . $cover_image . thumb_end_cart; ?>"  alt="Product Image" onerror="this.src='<?php echo thumb_start_grid.base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'">
                                                                            <?php echo $pro['product_name']; ?>
                                                                        </td>
                                                                        <td><?php echo $pro['quantity']; ?></td>
                                                                        <td><?php echo number_format($pro['price'],2); ?></td>                                                                          </tr>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div></div></div>
                                </div>
                                <br><br>
                                <div class="row most-viewed">
                                    <div  id="most-viewed">                                        
                                        <div class="row">
                                            <?php if (isset($order_details) && !empty($order_details)) { ?>
                                                <div class="col-sm-4">
                                                    <div class="box">
                                                        <div class="box-header box-header green-background">
                                                            <div class="title">
                                                                Buyer Details
                                                            </div>                      
                                                        </div>
                                                        <div class="box-content">
                                                            <div class="form-group">
                                                                <label>Receiver Name:</label> 
                                                                <?php echo $order_details[0]->customer_name; ?>
                                                            </div>                        
                                                            <div class="form-group">
                                                                <label>Contact Number:</label>
                                                                <?php echo $order_details[0]->contact_number; ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Email ID:</label>
                                                                <?php echo $order_details[0]->email_id; ?>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Address:</label>
                                                                <?php
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

                                                            </div>                      
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            if (isset($seller_details) && !empty($seller_details)) {
                                                ?>
                                                <div class="col-sm-4">
                                                    <div class="box seller-details-box">
                                                        <div class="box-header box-header purple-background">
                                                            <div class="title">
                                                                <i class="icon-eraser"></i>
                                                                Seller Details
                                                            </div>                      
                                                        </div>
                                                        <div class="box-content">
                                                            <div class="store-individual-user-pic">
                                                                <span>
                                                                    <a href="<?php echo HTTP . $seller_details[0]->store_domain . after_subdomain . remove_home; ?>">
                                                                        <?php
                                                                        if (isset($seller_image) && !empty($seller_image) && !empty($seller_image[0]->profile_picture))
                                                                            $seller_image = base_url() . 'assets/upload/profile/original/' . $seller_image[0]->profile_picture;
                                                                        else
                                                                            $seller_image = base_url() . 'assets/upload/No_Image.png';
                                                                        ?>
                                                                        <img alt="Seller Image" src="<?php echo $seller_image; ?>" height="100px" width="100px" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'">
                                                                    </a>
                                                                </span>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Store Name: </label>
                                                                <?php echo $seller_details[0]->store_name; ?>
                                                            </div>      
                                                            <?php if($seller_details[0]->store_is_inappropriate=='Approve' && $seller_details[0]->store_status==0) { ?>
                                                            <div class="form-group col-sm-12">
                                                                <a href="<?php echo HTTP . $seller_details[0]->store_domain . after_subdomain . remove_home; ?>" class="btn btn-primary">Visit Store</a>
                                                            </div>       
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="col-sm-4">
                                                <div class="box">
                                                    <div class="box-header box-header orange-background">
                                                        <div class="title">
                                                            Shipping Details
                                                        </div>                      
                                                    </div>
                                                    <div class="box-content">
                                                        <div class="form-group">
                                                            <label>Order No: </label>&nbsp;<?php if (isset($order_details[0]->order_number)) echo $order_details[0]->order_number; ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Payment Type: </label>&nbsp;<?php if (isset($order_details[0]->delivery_type)) echo $order_details[0]->delivery_type; ?>
                                                        </div>                        
                                                        <div class="form-group">
                                                            <label>Purchased On: </label>
                                                            <?php if (isset($order_details[0]->created_date)) echo $order_details[0]->created_date; ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Sub-total: </label>
                                                            <?php if (isset($order_details[0]->sub_total)) echo $order_details[0]->sub_total; ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Shipping Cost: </label>
                                                            <?php if (isset($order_details[0]->shipping_cost)) echo $order_details[0]->shipping_cost; ?>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Final Total: </label>
                                                            <?php if (isset($order_details[0]->final_total)) echo $order_details[0]->final_total; ?>
                                                        </div>                                                        
                                                        <div class="form-group">
                                                            <label>Status: </label>
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
        <?php $this->load->view('admin/include/footer-script'); ?>
    </body>
</html>

