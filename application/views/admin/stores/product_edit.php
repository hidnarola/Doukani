<!DOCTYPE html>
<html>
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
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-building'></i>
                                    <span>Store Product</span>
                                </h1>				
                            </div>							   
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Edit Product
                                        </div>						
                                    </div>
                                    <?php if (isset($msg)): ?>
                                    <div class='alert  <?php echo $msg_class; ?>'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg; ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class='box-content'>
                                        <form action='<?php echo base_url() . 'admin/stores/product_edit/' . $store_pro[0]->store_product_id; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Product Name</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Name' class="form-control" name="st_pro_name" type='text' data-rule-required='true' value="<?php echo $store_pro[0]->store_product_name;?>">		                  
                                                </div>
                                            </div>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Product Image</label>
                                                <div class='col-md-5'>
                                                    <input title='Store Image' name='st_pro_image'type='file'>		                  
                                                </div>
                                            </div>
                                            <?php if (!empty($store_pro[0]->store_product_image)): ?>
                                            <div class='form-group'>
                                                <div class="col-md-2"></div>
                                                <div class='col-md-5'>
                                                    <img alt="store Image" src="<?php echo base_url() . stores_product."medium/" . $store_pro[0]->store_product_image; ?>"/>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Product Stock</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='stock' class="form-control" name="st_pro_stock" type='text' data-rule-number='true' data-rule-required='true' value="<?php echo $store_pro[0]->store_product_in_stock; ?>" />		                  
                                                </div>
                                            </div>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Product Description</label>
                                                <div class='col-md-5'>
                                                    <textarea class="form-control" id="inputTextArea1" placeholder="Description" name="st_pro_desc" rows="3"><?php echo $store_pro[0]->store_product_description; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Product Price</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Price'  class="form-control"  name="st_pro_price" type='text' data-rule-number='true' value="<?php echo $store_pro[0]->store_product_price; ?>" />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Product Category</label>
                                                <div class='col-md-5'>
                                                    <select class="select2 form-control" name="cat_id">
                                                        <?php foreach ($category as $cat): ?>
                                                        <?php if($cat['category_id'] == $store_pro[0]->store_product_category_id){ ?>
                                                            <option value="<?php echo $cat['category_id']; ?>" selected><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php }else{ ?>
                                                            <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php } ?>
                                                        
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Status</label>
                                                <div class='col-md-5'>
                                                    <select class="select2 form-control" name="pro_status">
                                                        <option value="available" <?php echo $store_pro[0]->store_product_status == "available" ? 'selected':"" ?>> Available</option>
                                                        <option value="sold" <?php echo $store_pro[0]->store_product_status == "sold" ? 'selected':"" ?> >Sold</option>
                                                        <option value="out_of_stock" <?php echo $store_pro[0]->store_product_status == "out_of_stock" ? 'selected':"" ?> >Out Of Stock </option>
                                                        <option value="discontinued" <?php echo $store_pro[0]->store_product_status == "discontinued" ? 'selected':"" ?> >Discontinued</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit'>
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>admin/stores/product/<?php echo $store_pro[0]->store_id; ?>' title="Cancel" class="btn">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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