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
                                            <span>Buyer Seller Conversation</span>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <form id="form1" name="form1" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                <input type="submit" name="submit" id="submit">
                            </form>
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
                                                                    <th class="text-center">Product Image</th>
                                                                    <th class="text-center">Product Price</th>
                                                                    <th class="text-center">Product Status</th>
                                                                    <th class="text-center">Seller Username</th>
                                                                    <th class="text-center">Seller Nickname</th>
                                                                    <th class="text-center">Seller Email ID</th>                 
                                                                    <th class="text-center">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($product_list) && sizeof($product_list)>0):
                                                                    foreach ($product_list as $pro) {
                                                                        ?>
                                                                        <tr class="text-center">                                            
                                                                            <td><?php if (!empty($pro['product_image'])) { ?>
                                                                                    <a data-lightbox='flatty' href='<?php echo base_url() . product . "snall/" . $pro['product_image']; ?>'>
                                                                                        <img alt="Product Image" style="height: 40px; width: 64px;" src="<?php echo base_url() . product . "small/" . $pro['product_image']; ?>" onerror="this.src='<?php echo site_url(); ?>/assets/upload/No_Image.png'"/>
                                                                                    </a>
                                                                                <?php } else { ?> 
                                                                                    <img alt="Product Image" style="height: 40px; width: 64px;" src="<?php echo site_url(); ?>assets/upload/No_Image.png"/>
                                                                                <?php } ?></td>
                                                                            <td><?php echo $pro['product_price']; ?></td>
                                                                            <td><?php echo $pro['product_is_inappropriate'] ?></td>         
                                                                            <td><?php echo $pro['username'] ?></td>
                                                                            <td><?php echo $pro['nick_name']; ?></td>
                                                                            <td><?php echo $pro['email_id']; ?></td>
                                                                            <td>
                                                                                <a class='btn btn-primary btn-xs has-tooltip' data-placement='top' title="View" href='<?php echo base_url() . "admin/conversation/view_conversation/" . $pro['product_id']; ?>'>
                                                                                    <i class='icon-th-large'></i>
                                                                                </a>                 
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                            else: ?>
                                                               <tr>
                                                                   <td colspan="7">No Results Found</td>
                                                               </tr>
                                                           <?php
                                                                endif;
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>	
                                                    </div>                                                  
                                                </div>
                                                <br>
                                                <br>
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <div class="col-sm-4">
                                                            <label>Per page : </label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="per_page1" id="per_page1" class="form-control" >                                              
                                                                <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '10') ? 'selected' : ''; ?>>10</option>    
                                                                <option value="25" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '25') ? 'selected' : ''; ?>>25</option>
                                                                <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '50') ? 'selected' : ''; ?>>50</option>
                                                                <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '100') ? 'selected' : ''; ?>>100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
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
                                        $(document).find('#per_page1').on('change', function () {
                                            var per_page = $(this).val();
//                                            console.log(per_page);
                                            $('#per_page').val(per_page);
                                            $(document).find('#submit').click();
                                        });
                                        $("#form_mail").validate({
                                            ignore: 'input[type=hidden]',
                                            rules: {
                                                subject: "required"
                                            },
                                            messages: {
                                                message: "Please enter Message"
                                            },
                                            submitHandler: function (form) {
                                                form.submit();
                                            }
                                        });
                                        $(document).ready(function () {
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
                                        $(document).ready(function () {

                                            $(document).on('click', '.send_message', function () {
                                                var id = jQuery(this).attr('data-id');
                                                if (id !== null) {
                                                    $("#send-message-popup").modal('show');
                                                    $("#user_id").val(id);
                                                }
                                            });
                                        });

</script>