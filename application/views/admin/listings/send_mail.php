<script type="text/javascript" src="<?php echo site_url(); ?>assets/admin/javascripts/jquery.tokeninput.js"></script>
<div class="modal fade center" id="send_mail" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header text-center orange-background">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                <h4 id="myLargeModalLabel" class="modal-title">Send Message</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissable mail_msg_response" style="display:none;">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <span class="msg_resp"></span>
                    </div>
                    <form action='' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' id="form_mail" name="form_mail">
                        <div class='box-content control'>
                            <div class='form-group subject-div'>
                                <label class="control-label">Subject :</label><span style="color:red;">*</span>
                                <input name="subject" id="subject" type="text" class="span5 form-control" data-rule-required="true"/>
                                <hr>
                            </div>
                            <div class='form-group msg-div'>
                                <label class="control-label"> Message :</label><span style="color:red;">*</span>
                                <textarea class='input-block-level wysihtml5 form-control' name="message"  id="message"  rows='10' data-rule-required="true"></textarea>
                            </div>
                            <input type="hidden" name="user_id" id="user_id"/>
                            <div class="margin-bottom-10"></div>
                            <button class='btn btn-primary' type='button' id="submit_mail" name="submit_mail"> 
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

<div class="modal fade center" id="notification" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">            
            <?php $this->load->view('admin/push_notification/form_block'); 
                  $this->load->view('admin/push_notification/script'); ?>    
        </div>
    </div>
</div>

<script type="text/javascript">
    var timer = '';
    $('.send_message').click(function () {
        $(document).find('.mail_msg_response').hide();
        $(document).find('#subject').val('');                    
        $(document).find('#message').data("wysihtml5").editor.clear();
        var id = jQuery(this).attr('data-id');
        if (id !== null) {
            $(document).find("#send_mail").modal('show');
            $(document).find("#user_id").val(id);
        }
    });
    $('.send_notification').click(function () {
        $(document).find('#message11').val('');
        $(document).find('#url').val('');
        var id = jQuery(this).attr('data-id');        
        var for_ = jQuery(this).attr('data-for');        
        var data_length = jQuery(this).attr('data-length');
//        console.log(id+ "==" + for_ + "==" + data_length);
        if (id !== null) {
            $(document).find('.device_div').hide();
            $(document).find('.send_to_all').remove();      
            $(document).find('#send_for').val(for_);            
            $(document).find('.counter').text(data_length);
            $(document).find('#max_length').val(data_length);
            $(document).find('#cancel_link').hide();            
            $(document).find('#notificationResponse').text('');
            $(document).find('#successCount').text('0');
            $(document).find('#failureCount').text('0');
            $(document).find('#message11').removeAttr('readonly');
            $(document).find('#submit_notification').attr('disabled', false);
            
            $(document).find("#notification").modal('show');
            $(document).find("#demo-input-local-exclude").val(id);
        }
    });
    
    $(document).find("#submit_mail").on("click", function (e) {
        
        $(document).find('.mail_msg_response').hide();
                    
        var subject = $(document).find('#subject').val();
        var message = $(document).find('#message').val();
        var user_id = $(document).find('#user_id').val();

        if(subject=='')
           $(document).find('.subject-div').addClass('has-error');
        else
           $(document).find('.subject-div').removeClass('has-error');
        
        if(message=='')
           $(document).find('.msg-div').addClass('has-error');        
        else
           $(document).find('.msg-div').removeClass('has-error');
       
       var url = '<?php echo base_url(); ?>admin/users/send_message_to_seller';
       
       if(subject!='' && message!='') {
            $(document).find("#submit_mail").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Sending...');
            $(document).find('#submit_mail').prop('disabled', true);
            $.post(url, {user_id:user_id,subject:subject,message:message,jquery_request:'yes'}, function (response) {                
                if(response=='Mail sent successfully') {
                    
                    $(document).find('#subject').val('');                    
                    $(document).find('#message').data("wysihtml5").editor.clear();
                    $(document).find('.mail_msg_response').show();
                    $(document).find('.mail_msg_response').addClass('alert-success');
                    $(document).find('.mail_msg_response').removeClass('alert-info');
                    $(document).find('.msg_resp').html(response);
                    
                    window.clearTimeout(timer);  
                    timer = window.setTimeout(function(){$("#send_mail").modal('hide');},2000); 
                }
                else {
                    
                    $(document).find('.mail_msg_response').show();
                    $(document).find('.mail_msg_response').removeClass('alert-success');
                    $(document).find('.mail_msg_response').addClass('alert-info');
                    $(document).find('.msg_resp').html(response);
                }

                $(document).find('#submit_mail').prop('disabled', false);
                $(document).find("#submit_mail").html("<i class='icon-bolt'></i>Send Message");
            }, "json");
       }
    });
</script>