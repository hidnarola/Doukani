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
            } else {
                jQuery("#device_id").removeAttr("disabled");
            }
        });
        $('#sendall').click(function () {
            if (jQuery('#sendall').is(':checked') == true)
            {
                jQuery("#device_id").attr("disabled", "disabled");
            } else {
                jQuery("#device_id").removeAttr("disabled");
            }
        });
    });
    var max_length = $(document).find('#max_length').val();
    var notification_max_length = parseInt(max_length);
    var notification_current_length = 0;
    jQuery('.character_limit').keypress(function (e) {

        var messageUTFLength = getUTF8Length(jQuery('#message11').val());
        var urlUTFLength = getUTF8Length(jQuery('#url').val());
        notification_current_length = (messageUTFLength + urlUTFLength);
        if (e.which == 8 || e.which == 46 || e.which == 0)
        {
            if (notification_current_length > 0 && e.which > 0)
            {
                notification_current_length--;
            }
            jQuery('#counter').html((notification_max_length - notification_current_length));
            return true;
        }

        if ((notification_current_length) >= notification_max_length)
        {
            jQuery('#counter').html(0);
            return false;
        } else
        {
            notification_current_length++;
            jQuery('#counter').html(notification_max_length - notification_current_length);
            return true;
        }

    });

    function prepareNotification()
    {

        var messageUTFLength = getUTF8Length(jQuery('#message11').val());
        var urlUTFLength = getUTF8Length(jQuery('#url').val());
        var notification_length = (messageUTFLength + urlUTFLength);
        //&& (notification_length <= notification_max_length)
        if (jQuery('#message11').val() != '')
        {
            var send_for = $(document).find('#send_for').val();
            if (send_for == 'ios')
                var url_ = "<?php echo base_url() . 'admin/push_notification/prepare_iphone_notification_ajax'; ?>";
            else
                var url_ = "<?php echo base_url() . 'admin/push_notification/prepare_android_notification_ajax'; ?>";
            jQuery.ajax({
                url: url_,
                type: "POST",
                data: jQuery('#notificationForm').serialize(),
                attemptCount: 0,
                attemptLimit: 20,
                beforeSend: function () {
                    jQuery('#notificationResponse').html('please wait....');
                    jQuery('.notification_element', '#notificationForm').attr('disabled', true);
                    jQuery('.notification_message', '#notificationForm').attr('readonly', true);
                    jQuery('#successCount').html('0');
                    jQuery('#failedCount').html('0');
                },
                success: function (response)
                {
                    jQuery('#notificationResponse').html(response);
                    if (jQuery(".notificationButton", "#notificationResponse").length > 0) {
                        sendNotification(jQuery(".notificationButton:first", "#notificationResponse"));
                    } else {
                        jQuery('.notification_element', '#notificationForm').attr('disabled', false);
                        jQuery('.notification_message', '#notificationForm').attr('readonly', false);
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
                        $(document).find('.response_message').html('ajax request failed...!!! because of the request timeout from server');
                        $(document).find("#search_alert").modal('show');
                    }
                    //alert('ajax request failed...!!! because of the request timeout from server');
                }
            });
        } else {
            $(document).find('.response_message').html('Message can\'t be empty! or its exceed limit');
            $(document).find("#search_alert").modal('show');
            $(document).find("#notification").modal('hide');
        }
    }

    function sendNotification(notificationObject) {

        var notificationStart = jQuery(notificationObject).attr('start');
        var notificationOffset = jQuery(notificationObject).attr('number_of_user');
        var notificationNo = jQuery(notificationObject).attr('pageNo');
        var nextButton = '';
        var send_for = $(document).find('#send_for').val();
        if (send_for == 'ios')
            var url_ = "<?php echo base_url() . 'admin/push_notification/send_iphone_notification_ajax'; ?>";
        else
            var url_ = "<?php echo base_url() . 'admin/push_notification/send_android_notification_ajax'; ?>";

        jQuery.ajax({
            url: url_,
            type: "POST",
            data: jQuery('#notificationForm').serialize() + "&limit_start=" + notificationStart + "&offest=" + notificationOffset,
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
                        sendNotification(nextButton)
                    }, 500);
                } else
                {
                    $(document).find('#notificationResponse').html('Notification send completed');
                    $(document).find('.notification_element', '#notificationForm').attr('disabled', false);
                    $(document).find('.notification_message', '#notificationForm').attr('readonly', true);
                    $(document).find('.btn-primary').attr('disabled', true);
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                var s = this; // The config we used                            
                s.attemptCount++;

                if (s.attemptCount < s.attemptLimit) {
                    $.ajax(s);
                } else {
                    $(document).find('.response_message').html('ajax request failed...!!! because of the request timeout from server');
                    $(document).find("#search_alert").modal('show');
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