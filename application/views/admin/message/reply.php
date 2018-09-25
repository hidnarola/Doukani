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
                                            <i class="fa fa-envelope-o"></i>
                                            <span>Reply To Message</span>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <div class='row'>
                                <div class='col-sm-12 box' style='margin-bottom:0'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>Message</div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content box-double-padding'>
                                        <div class='row'>
                                            <form action='<?php echo base_url(); ?>admin/message/reply/<?php echo $inquiry[0]->inquiry_id; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Message</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea disabled  class="autosize form-control" ><?php echo $inquiry[0]->inquiry_content; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Reply</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea rows="5" cols="50" class="autosize form-control" name="message" data-rule-required="true"></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <button class='btn btn-primary' type='submit'>
                                                                <i class='icon-reply'></i>
                                                                Reply
                                                            </button>
                                                            <a href='<?php echo base_url(); ?>admin/message' title="Cancel" class="btn">Cancel</a>
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
                </div>
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>        
    </body>
</html>