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
                                            <span>Messages</span>
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
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Message List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area'>
                                                    <form id="userForm" action="" method="POST">
                                                        <table class='table table-striped' id="msg_table" style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th style="display: none;">Id</th>
                                                                    <th class="text-center">Date</th>
                                                                    <th class="text-center">Subject</th>
                                                                    <th class="text-center">Tag</th>
                                                                    <!--<th class="text-center">Read</th>-->
                                                                    <th class="text-center">Status</th>
                                                                    <th class="text-center">Sender</th>
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (!empty($message)):
                                                                    foreach ($message as $msg) {
                                                                        ?>
                                                                        <tr class="text-center">
                                                                            <td style="display: none;"><?php echo $msg['inquiry_id']; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if (date('Y-m-d', strtotime($msg['inquiry_posted_on'])) == date('Y-m-d')) {
                                                                                    echo date('h:i a', strtotime($msg['inquiry_posted_on']));
                                                                                } else {
                                                                                    echo date('d M', strtotime($msg['inquiry_posted_on']));
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td><?php echo $msg['inquiry_subject']; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if ($msg['inquiry_type'] == "INQUIRY") {
                                                                                    echo 'Inquiry';
                                                                                } else if ($msg['inquiry_type'] == "SUPPORT") {
                                                                                    echo 'Support';
                                                                                } else if ($msg['inquiry_type'] == "OFFER") {
                                                                                    echo 'Offer Inquiry';
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <!--<td><span class="badge <?php echo ($msg['inquiry_is_read'] == 'read') ? 'badge-success' : 'badge-important'; ?> "><?php echo $msg['inquiry_is_read']; ?></span></td>-->
                                                                            <td>
                                                                                <?php if ($msg['inquiry_status'] == 'open') { ?>
                                                                                    <a onclick="msg_close(<?php echo $msg['inquiry_id'] ?>);" class='btn btn-warning btn-xs' href="#">Open</a>
                                                                                <?php } else { ?>
                                                                                    <span class='btn btn-success btn-xs'>Close</sapn> 
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td><?php echo $msg['username']; ?></td>
                                                                            <td>
                                                                                <a class='btn btn-xs send_message has-tooltip' data-placement='top' title="Send Mail" data-id="<?php echo $msg['inquiry_id']; ?>" data-value="mail" >
                                                                                   <i class="fa fa-envelope"></i>
                                                                                </a>
                                                                                <a class='btn btn-success btn-xs has-tooltip' data-placement='top' title="Reply" href='<?php echo base_url() . "admin/message/reply/" . $msg['inquiry_id']; ?>'>
                                                                                    <i class='icon-reply'></i>
                                                                                </a>
                                                                                <a class='btn btn-primary btn-xs has-tooltip' data-placement='top' title="View" href='<?php echo base_url() . "admin/message/view_conversation/" . $msg['inquiry_id']; ?>'>
                                                                                    <i class='icon-th-large'></i>
                                                                                </a>
                                                                                <a class='btn btn-danger btn-xs has-tooltip' data-placement='top' title="Delete" onclick="return confirm('Are You Sure You Want To Delete This Thread');" href='<?php echo base_url() . "admin/message/delete/" . $msg['inquiry_id']; ?>'>
                                                                                    <i class='icon-trash'></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
													<div class="col-sm-12 text-right pag_bottom">
														<ul class="pagination pagination-sm"><?php if(isset($links)) echo $links; ?></ul>	
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
        <div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Send Message</h4>
                    </div>
                   <div class="modal-body">
                        <div class="col-md-12">
                            <form class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' id="form_mail" name="form_mail">					
                                <div class='box-content control'>                                   
										<div class='form-group'>										
                                        <label class="control-label"> Message :</label>
                                        <textarea class='input-block-level wysihtml5 form-control required' name="message"  id="message"  rows='10'></textarea>					    
                                    </div>
                                    <input type="hidden" name="user_id" id="user_id"/>
                                    <div class="margin-bottom-10"></div>				
                                    <button class='btn btn-primary' type='submit' id="submit_mail" name="submit_mail" onclick="javascript:mail();"> 
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
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
<!-- / jquery migrate (for compatibility with new jquery) [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
<!-- / jquery ui -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<!-- / jQuery UI Touch Punch -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/jquery_ui_touch_punch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<!-- / bootstrap [required] -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap/bootstrap.js" type="text/javascript"></script>
<!-- / modernizr -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/modernizr/modernizr.min.js" type="text/javascript"></script>
<!-- / retina -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/retina/retina.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>
<!-- / validation --> 
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script>		
    </body>
</html>
<script>
	$("#form_mail").validate({
			ignore: 'input[type=hidden]',
			rules: {
				subject: "required"				
			},
			messages: {				        
				message: "Please enter Message"                        
			},                    
			submitHandler: function(form) {
				form.submit();
			}
		});
$(document).ready(function() {
	/*$("#form_mail").validate({
			ignore: 'input[type=hidden]',
			rules: {				
				message: "required"                        
			},
			messages: {				
				message: "Please enter Message"                        
			},                    
			submitHandler: function(form) {
				form.submit();
			}
		}); */
		
  //$('#validate-me-plz').validate();
	//$('#form_mail').validate();
  
    /*$('#msg_table').dataTable({
        aaSorting: [[0, 'desc']],
        "bDestroy": true
    }); */
});
/*function msg_open(Id) {
    jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/message/msg_open/" + Id).submit();
}
function msg_close(Id) {    
    jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/message/msg_close/" + Id).submit();
}*/
$(document).ready(function() {
  
$(document).on('click', '.send_message', function() {
	var id = jQuery(this).attr('data-id');
	if (id !== null) {
		$("#send-message-popup").modal('show');
		$("#user_id").val(id);
	}
});
});

</script>