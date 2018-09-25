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
                                    <span>Stores</span>
                                </h1>
                                <div class='pull-right'>
                                    <a href='<?php echo base_url(); ?>admin/stores/add' title="Add Store" class="btn">
                                        <i class='icon-plus'></i>
                                        Add Store
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
                                            <div class='title'>Store List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area'>
                                                    <form id="storeForm" action="" method="POST"><!-- data-table-->
                                                        <table class=' table  table-striped' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Store Name</th>
                                                                    <th>Store Image</th>
                                                                    <th>Contact Person</th>
                                                                    <th>Manage Store</th>
                                                                    <th>Status</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (!empty($stores)):
                                                                    foreach ($stores as $s):
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $s['store_name']; ?></td>
                                                                            <td>
                                                                                <?php if (!empty($s['store_image'])): ?>
                                                                                    <a data-lightbox='flatty' href='<?php echo base_url() . stores . "original/" . $s['store_image']; ?>'>
                                                                                        <img alt="Store Image" style="height: 40px; width: 64px;" src="<?php echo base_url() . stores . "small/" . $s['store_image']; ?>"/>
                                                                                    </a>
                                                                                <?php endif; ?>
                                                                            </td>
                                                                            <td><?php echo $s['store_contact_person']; ?></td>
                                                                            <td><a href='<?php echo base_url(); ?>admin/stores/product/<?php echo $s['store_id']; ?>' title="Add Store" class='btn'>
                                                                                    Manage
                                                                                </a>
                                                                            </td>
                                                                            <td>
                                                                                <?php if ($s['store_status'] == 0) { ?>
                                                                                    <a onclick="active(<?php echo $s['store_id'] ?>);" class='btn btn-warning btn-xs' href="#">Inactive</a>
                                                                                <?php } else { ?>
                                                                                    <a onclick="inactive(<?php echo $s['store_id'] ?>);" class='btn btn-success btn-xs' href="#">Active</a> 
                                                                                <?php } ?>
                                                                            </td>
                                                                            <td>
                                                                                <div class='text-right'>
                                                                                    <a class='btn btn-xs send_message has-tooltip' data-placement='top' title='Email' data-id="<?php echo $s['store_id']; ?>" title="Send message to store owner">
                                                                                       <i class="fa fa-envelope"></i>
                                                                                    </a>
                                                                                    <a class='btn btn-success btn-xs has-tooltip' data-placement='top' title='View' href='<?php echo base_url() . "admin/stores/view/" . $s['store_id']; ?>'>
                                                                                       <i class="fa fa-info-circle"></i>
                                                                                    </a>
                                                                                    <a class='btn btn-warning btn-xs has-tooltip' data-placement='top' title='Edit' title="Edit Store" href='<?php echo base_url() . "admin/stores/edit/" . $s['store_id']; ?>'>
                                                                                        <i class='icon-edit'></i>
                                                                                    </a>
                                                                                    <a class='btn btn-danger btn-xs has-tooltip' data-placement='top' title='Delete' title="Delete Store" onclick="return confirm('Are you sure you want to delete store?');" href='<?php echo base_url() . "admin/stores/delete/" . $s['store_id']; ?>'>
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
                            <form action='<?php echo base_url(); ?>admin/stores/send_message' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' id="form_mail" name="form_mail">
                                <div class='box-content control'>
                                    <div class='form-group'>								    				     
                                        <label class="control-label">Subject :</label>
                                        <input name="subject" id="subject" type="text" class="span5 form-control" />					
                                        <hr>
										</div>
										<div class='form-group'>
                                        <label class="control-label"> Message :</label>
                                        <textarea class='input-block-level wysihtml5 form-control' name="message"  id="message"  rows='10'></textarea>					    
                                    </div>
                                    <input type="hidden" name="user_id" id="user_id"/>
                                    <div class="margin-bottom-10"></div>				
                                    <button class='btn btn-primary' type='submit' id="submit_mail" name="submit_mail"> 
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
        <script type="text/javascript">
		
		/*$("#submit_mail").click(function(){		
			$("#form_mail").validate();
		}); */
		
		$("#form_mail").validate({
			ignore: 'input[type=hidden]',
			rules: {
				subject: "required",                       
				message: "required"                        
			},
			messages: {
				subject: "Please enter Subject",           
				message: "Please enter Message"                        
			},                    
			submitHandler: function(form) {
				form.submit();
			}
		});
			

				
        $(document).ready(function() {
            $(document).on('click', '.send_message', function() {
                var id = jQuery(this).attr('data-id');
                if (id !== null) {
                    $("#send-message-popup").modal('show');
                    $("#user_id").val(id);
                }
            });
        });
        function active(Id) {
            jQuery('#storeForm').attr('action', "<?php echo base_url(); ?>admin/stores/active/" + Id).submit();
        }
        function inactive(Id) {
            jQuery('#storeForm').attr('action', "<?php echo base_url(); ?>admin/stores/inactive/" + Id).submit();
        }
        </script>
    </body>
</html>