<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>


        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/token-input.css" type="text/css" />


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
                                    <i class='icon-apple'></i>
                                    <span>iOS</span>
                                </h1>				
                            </div>	
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert  alert-info'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <center><?php echo $this->session->flashdata('msg'); ?></center>
                                </div>
                            <?php endif; ?>	
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-reply'></div>
                                            Send Notification
                                        </div>						
                                    </div>
                                    <div class='box-content'><!-- action='<?php //echo base_url();  ?>admin/push_notification/ios' -->
                                        <div id="notificationResponse">

                                        </div>
                                        <div id="notificationStatistics">
                                            Success: <span id="successCount">0</span> Failed : <span id="failureCount">0</span>
                                        </div>									   
                                        <form  class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" name="notificationFormIphone" id="notificationFormIphone">
                                            <div class='form-group'>
                                                <label class="col-md-2 control-label"  for='inputText1'>Message</label>
                                                <div class="col-md-5 controls">
                                                    <textarea class="notification_message character_limit form-control" id="iphone_message" name="message" rows="5" cols="100"><?php echo isset($_POST['message']) ? $_POST['message'] : ""; ?></textarea>

                                                </div>
                                                <input type="hidden" id="android_title" value="" name="title" size="100" />
                                                <input type="hidden" id="title" value="" name="action" size="100" />
                                            </div>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>URL</label>
                                                <div class='col-md-5'>
                                                    <input type="text" class="character_limit form-control" id="iphone_url" value="" name="url" size="100" />
                                                    <p><strong>You have <em id="counter"><?php echo $iphone_notification_max_length->val; ?></em> characters remaining(message+url)</strong></p>
                                                </div>
                                            </div>  
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Device Id</label>
                                                <div class='col-md-5 controls'>
                                                    <!-- <input type="text" name="iphone_send_device" id="iphone_device_id" class="form-control"> -->
                                                    <input type="text" id="demo-input-local-exclude" name="blah" id="blah" />
                                                </div>
                                                <input type="hidden" name="device_type" id="notification_image" value="I" />
                                                <input type="hidden" name="notification_image" id="notification_image" value="" />
                                                <input type="hidden" value="0" name="success" size="100" />
                                                <input type="hidden" value="0" name="fail" size="100" />
                                                <input type="hidden" name="status" size="100" value="pending"/>						

                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'></label>
                                                <div class='col-md-5 controls'>
                                                    <label class="checkbox-inline">
                                                        <input type="checkbox" name="send_all" id="sendall_iphone" value="yes">Send to all Device
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='button' onclick="prepareIphoneNotification();">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Send
                                                        </button>
                                                        
                                                        <a href="<?php echo site_url().'admin/push_notification/ios'; ?>" title="Cancel" class="btn">Cancel</a>
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
    <script type="text/javascript" src="<?php echo site_url(); ?>assets/admin/javascripts/jquery.tokeninput.js"></script>
    <script>
    function getUTF8Length(s) {
        var len = 0;
        for (var i = 0; i < s.length; i++) {
            var code = s.charCodeAt(i);
            if (code <= 0x7f) {
                len += 1;
            } else if (code <= 0x7ff) {
                len += 2;
            } else if (code >= 0xd800 && code <= 0xdfff) {
                // Surrogate pair: These take 4 bytes in UTF-8 and 2 chars in UCS-2
                // (Assume next char is the other [valid] half and just skip it)
                len += 4;
                i++;
            } else if (code < 0xffff) {
                len += 3;
            } else {
                len += 4;
            }
        }
        return len;
    }
    $(document).ready(function () {

        $('#sendall').click(function () {
            if (jQuery('#sendall').is(':checked') == true)
            {
                jQuery("#device_id").attr("disabled", "disabled");
            }
            else {
                jQuery("#device_id").removeAttr("disabled");
            }
        });

        $('#sendall_iphone').click(function () {
            if (jQuery('#sendall_iphone').is(':checked') == true)
            {
                jQuery("#iphone_device_id").attr("disabled", "disabled");
            }
            else {
                jQuery("#iphone_device_id").removeAttr("disabled");
            }
        });
    });

    var iphone_notification_max_length = <?php echo $iphone_notification_max_length->val; ?>;
    var iphone_notification_current_length = 0;

    jQuery('.character_limit').keypress(function (e) {

        var messageUTFLength = getUTF8Length(jQuery('#iphone_message').val());
        var urlUTFLength = getUTF8Length(jQuery('#iphone_url').val());
        iphone_notification_current_length = (messageUTFLength + urlUTFLength);
        if (e.which == 8 || e.which == 46 || e.which == 0)
        {

            if (iphone_notification_current_length > 0 && e.which > 0)
            {
                iphone_notification_current_length--;
            }
            jQuery('#counter').html((iphone_notification_max_length - iphone_notification_current_length));
            return true;
        }

        ;
        if ((iphone_notification_current_length) >= iphone_notification_max_length)
        {

            jQuery('#counter').html(0);
            return false;
        }
        else
        {

            iphone_notification_current_length++;
            jQuery('#counter').html(iphone_notification_max_length - iphone_notification_current_length);
            return true;
        }

    });


    function prepareIphoneNotification()
    {

        var messageUTFLength = getUTF8Length(jQuery('#iphone_message').val());
        var urlUTFLength = getUTF8Length(jQuery('#iphone_url').val());
        var notification_length = (messageUTFLength + urlUTFLength);
        if (jQuery('#iphone_message').val() != '' && (notification_length <= iphone_notification_max_length))
        {
            jQuery.ajax({
                url: "<?php echo base_url() . 'admin/push_notification/prepare_iphone_notification_ajax' ?>",
                type: "POST",
                data: jQuery('#notificationFormIphone').serialize(),
                attemptCount: 0,
                attemptLimit: 20,
                beforeSend: function () {
                    jQuery('#notificationResponse').html('please wait....');
                    jQuery('.notification_element', '#notificationFormIphone').attr('disabled', true);
                    jQuery('.notification_message', '#notificationFormIphone').attr('readonly', true);

                    jQuery('#successCount').html('0');
                    jQuery('#failedCount').html('0');
                },
                success: function (response)
                {
                    jQuery('#notificationResponse').html(response);

                    if (jQuery(".notificationButton", "#notificationResponse").length > 0)
                    {
                        sendIphoneNotification(jQuery(".notificationButton:first", "#notificationResponse"));
                    }
                    else
                    {
                        jQuery('.notification_element', '#notificationFormIphone').attr('disabled', false);
                        jQuery('.notification_message', '#notificationFormIphone').attr('readonly', false);
                    }
                },
                error: function (xhr, textStatus, errorThrown) {

                    var s = this; // The config we used
                    //alert(s.attemptCount);
                    s.attemptCount++;
                    //alert(s.attemptCount);
                    if (s.attemptCount < s.attemptLimit) {
                        $.ajax(s);
                    } else {
                        alert('ajax request failed...!!! because of the request timeout from server');
                    }
                    //alert('ajax request failed...!!! because of the request timeout from server');
                }
            });
        }
        else
            alert('Message can\'t be empty!.');
    }

    function sendIphoneNotification(notificationObject) {

        var notificationStart = jQuery(notificationObject).attr('start');
        var notificationOffset = jQuery(notificationObject).attr('number_of_user');
        var notificationNo = jQuery(notificationObject).attr('pageNo');
        var nextButton = '';
        jQuery.ajax({
            url: "<?php echo base_url() . 'admin/push_notification/send_iphone_notification_ajax' ?>",
            type: "POST",
            data: jQuery('#notificationFormIphone').serialize() + "&limit_start=" + notificationStart + "&offest=" + notificationOffset,
            dataType: 'JSON',
            attemptCount: 0,
            attemptLimit: 20,
            beforeSend: function ()
            {
                jQuery(notificationObject).val(notificationNo + ") Processing..");
            },
            success: function (responseObj) {

                jQuery('.notificationReport').html(responseObj.response_text);
                jQuery(notificationObject).val(notificationNo + ")completed");
                jQuery('#successCount').html(parseInt(jQuery('#successCount').html()) + parseInt(responseObj.success_count));
                jQuery('#failureCount').html(parseInt(jQuery('#failureCount').html()) + parseInt(responseObj.failure_count));
                if (!jQuery(notificationObject).hasClass('last'))
                {
                    nextButton = jQuery(notificationObject).next();
                    setTimeout(function () {
                        sendIphoneNotification(nextButton)
                    }, 500);
                }
                else
                {
                    jQuery('#notificationResponse').html('Notification send completed');
                    jQuery('.notification_element', '#notificationFormIphone').attr('disabled', false);
                    jQuery('.notification_message', '#notificationFormIphone').attr('readonly', true);
                    jQuery('.btn-primary').attr('disabled', true);
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                var s = this; // The config we used
                //alert(s.attemptCount);
                s.attemptCount++;
                //alert(s.attemptCount);
                if (s.attemptCount < s.attemptLimit) {
                    $.ajax(s);
                } else {
                    alert('ajax request failed...!!! because of the request timeout from server');
                }
                //alert('ajax request failed...!!! because of the request timeout from server');
            }
        });
    }

    $(document).ready(function () {
        jQuery("#demo-input-local-exclude").tokenInput("<?php echo base_url(); ?>admin/push_notification/get_username", {
            excludeCurrent: true,
            preventDuplicates: true
        });
    });
    </script>
</html>