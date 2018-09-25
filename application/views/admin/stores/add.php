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
                                    <span>stores</span>
                                </h1>				
                            </div>							   
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Add Store
                                        </div>						
                                    </div>
                                    <?php if (isset($msg)): ?>
                                        <div class='alert  <?php echo $msg_class; ?>'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <?php echo $msg; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class='box-content'>
                                        <form action='<?php echo base_url(); ?>admin/stores/add' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                            <div class='form-group'>
                                                <label class="col-md-2 control-label"  for='inputText1'>Store Name</label>
                                                <div class="col-md-5 controls">
                                                    <input placeholder='Store Name' class="form-control" name="store_name" type='text' data-rule-required='true'>
                                                </div>
                                            </div>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Store Image</label>
                                                <div class='col-md-5'>
                                                    <input title='Store Image' name='store_image'type='file'>		                  
                                                </div>
                                            </div>  
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Contact Person</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Contact Person'  class="form-control" data-rule-required='true'  name="store_contact_person" type='text' >
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Store Owner</label>
                                                <div class='col-md-5 controls'>
                                                     <select class="select2 form-control" name="store_owner" data-rule-required='true'>
                                                        <?php foreach ($user as $u ):?>
                                                        <option value="<?php echo $u['user_id']; ?>"><?php echo $u['username']; ?></option>
                                                        <?php endforeach;
                                                        ?>
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
                                                        <a href='<?php echo base_url(); ?>admin/stores' title="Cancel" class="btn">Cancel</a>
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