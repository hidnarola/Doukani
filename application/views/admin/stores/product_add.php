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
                                            Add Product
                                        </div>						
                                    </div>
                                    <?php if (isset($msg)): ?>
                                        <div class='alert  <?php echo $msg_class; ?>'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <?php echo $msg; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class='box-content'>
                                        <form action='<?php echo base_url(); ?>admin/stores/product_add/<?php echo $store_id; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Product Name</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Name' class="form-control" name="st_pro_name" type='text' data-rule-required='true'>		                  
                                                </div>
                                            </div>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Product Image</label>
                                                <div class='col-md-5'>
                                                    <input title='Store Image' name='st_pro_image'type='file'>		                  
                                                </div>
                                            </div>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Product Stock</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='stock' class="form-control" name="st_pro_stock" type='text' data-rule-required='true' data-rule-number='true'>		                  
                                                </div>
                                            </div>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Product Description</label>
                                                <div class='col-md-5'>
                                                    <textarea class="form-control" id="inputTextArea1" placeholder="Description" name="st_pro_desc" rows="3"></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Product Price</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Price'  class="form-control"  name="st_pro_price" type='text' data-rule-required='true' data-rule-number='true'>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Product Category</label>
                                                <div class='col-md-5'>
                                                    <select class="select2 form-control" name="cat_id">
                                                        <?php foreach ($category as $cat):?>
                                                        <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach;?>
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
                                                        <a href='<?php echo base_url(); ?>admin/stores/product/<?php echo $store_id; ?>' title="Cancel" class="btn">Cancel</a>
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