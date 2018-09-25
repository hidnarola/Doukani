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
                                            <span>Messages Conversation</span>
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
                                    <div class='box-header blue-background'>
                                        <div class='title'>Messages</div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content box-double-padding scrollable' data-scrollable-height='680' data-scrollable-start='bottom' style="background: #ECECEC;">
                                        <div class='row'>
                                            <?php
                                            foreach ($inquiry_msg as $msg) {
                                                if ($msg['message_posted_by'] != $user_id) {
                                                    ?>
                                                    <div class='col-sm-12 text-left pro_msg1'>
                                                        <div class='alert alert-info alert-dismissable'>
                                                            <span class="user-img-t">
                                                                <img src="<?php echo base_url().profile.'small/'.$profile_pic_sender;?>">
                                                            </span>
                                                            <span class="arrow-left"></span>
                                                            <?php
                                                            echo $msg['message'];
                                                            ?>
                                                            <div class='time recive-time'>
                                                                <small class='date recive-time'>
                                                                    <span class='timeago fade has-tooltip' data-placement='top' title='<?php echo $msg['message_post_time']; ?>'><?php echo date('F d, Y - H:i',strtotime($msg['message_post_time'])); ?></span>
                                                                    <i class='icon-time'></i>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <div class='col-sm-12  text-right pro_msg2'>
                                                        <div class='alert alert-success alert-dismissable text-right'>
                                                            <span class="user-img-t">
                                                                <img src="<?php echo base_url().profile.'small/'.$profile_pic;?>">
                                                            </span>
                                                            <span class="arrow-right"></span>

                                                            <?php
                                                            echo $msg['message'];
                                                            ?>
                                                            <div class='time recive-time'>
                                                                <small class='date recive-time '>
                                                                    <span class='timeago fade has-tooltip' data-placement='top' title='<?php echo $msg['message_post_time']; ?>'><?php echo date('F d, Y - H:i',strtotime($msg['message_post_time'])); ?></span>
                                                                    <i class='icon-time'></i>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
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
		<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>
    </body>
</html>
