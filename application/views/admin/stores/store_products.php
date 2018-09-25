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
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-building'></i>
                                    <span>Store Product</span>
                                </h1>
                                <div class='pull-right'>
                                    <a href='<?php echo base_url(); ?>admin/stores/product_add/<?php echo $store_id; ?>' title="Add Store" class="btn">
                                        <i class='icon-plus'></i>
                                        Add Product
                                    </a>				   
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'> Product List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area'><!-- data-table-->
                                                    <table class=' table  table-striped superCategoryList' style='margin-bottom:0;'>
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                <th>Name</th>
                                                                <th>Category</th>
                                                                <th>Product Price</th>
                                                                <th>Product Stock</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($store_product)):
                                                                foreach ($store_product as $s):
                                                                    ?>
                                                                    <tr>
                                                                        <td><input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $s['store_product_id']; ?>" /></td>
                                                                        <td><?php echo $s['store_product_name']; ?></td>
                                                                        <td><?php echo str_replace('\n', " ", $s['catagory_name']); ?></td>
                                                                        <td><?php echo $s['store_product_price']; ?></td>
                                                                        <td><?php echo $s['store_product_in_stock']; ?></td>
                                                                        <td><?php echo $s['store_product_status']; ?></td>
                                                                        <td>
                                                                            <div class='text-right'>
                                                                                <a class='btn btn-warning btn-xs' title="Edit User" href='<?php echo base_url() . "admin/stores/product_edit/" . $s['store_product_id']; ?>'>
                                                                                    <i class='icon-edit'></i>
                                                                                </a>
                                                                                <a class='btn btn-danger btn-xs' onclick="return confirm('Are you sure you want to delete this product?');" title="Delete User" href='<?php echo base_url() . "admin/stores/product_delete/" . $s['store_product_id']; ?>'>
                                                                                    <i class='icon-trash'></i>
                                                                                </a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                endforeach;
                                                            endif;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <form method="post" action="" id="userForm" class="form form-horizontal col-md-12">
                                                        <div class='form-group'>
                                                            <div class='col-md-3 controls'>
                                                                <select data-rule-required='true' style="margin-left: 5px;" class='form-control' id="status_val" name="status" >
                                                                    <option>Select Action</option>
                                                                    <option value="available"> Available</option>
                                                                    <option value="sold">Sold</option>
                                                                    <option value="out_of_stock">Out Of Stock </option>
                                                                    <option value="discontinued">Discontinued</option>
                                                                </select>  
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <input type="hidden" id="checked_val" name="checked_val"/>
                                                                <input type="button" class="btn" value="Apply to selected" onclick="update_status();">
                                                            </div>
															<div class="col-sm-6 text-right pag_bottom">
																<ul class="pagination pagination-sm"><?php if(isset($links)) echo $links; ?></ul>	
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
        <div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Send Message</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <form action='<?php echo base_url(); ?>admin/stores/send_message' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post'>
                                <div class='box-content control'>
                                    <div class='form-group'>								    				     
                                        <strong>Subject :</strong>
                                        <input name="subject" type="text" class="span5 form-control" data-rule-required='true' />					
                                        <hr>
                                        <strong> Message :</strong>
                                        <textarea class='input-block-level wysihtml5' name="message" id='wysiwyg2' rows='10' data-rule-minlength="10" data-rule-required="true"></textarea>					    
                                    </div>
                                    <input type="hidden" name="user_id" id="user_id"/>
                                    <div class="margin-bottom-10"></div>				
                                    <button class='btn btn-primary' type='submit'>
                                        <i class='icon-bolt'></i>
                                        Send Message
                                    </button>
                                    <button data-dismiss="modal" class="btn btn-default rounded" type="button">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.send_message', function() {
                    var id = jQuery(this).attr('data-id');
                    if (id !== null) {
                        $("#send-message-popup").modal('show');
                        $("#user_id").val(id);
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
                var checkedValues = $('input:checkbox:checked').map(function() {
                    return this.value;
                }).get();
                if(checkedValues == ""){
                    alert("please check atleast one checkbox");
                }else{
                    $('#checked_val').val(checkedValues);
                    jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/stores/update_status").submit();
                }
            }
        </script>
    </body>
</html>