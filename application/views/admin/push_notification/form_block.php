<div class='row'>
    <div class='col-sm-12 box'>
        <div class='box-header orange-background'>
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
            <div class='title'>
                <div class='icon-reply'></div>
                Send Notification
            </div>						
        </div>
        <div class='box-content'><!-- action='<?php //echo base_url();    ?>admin/push_notification/ios' -->
            <div id="notificationResponse">

            </div>
            <div id="notificationStatistics">
                Success: <span id="successCount">0</span> Failed : <span id="failureCount">0</span>
            </div>									   
            <form  class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" name="notificationForm" id="notificationForm">
                <div class='form-group'>                    
                    <label class="col-md-2 control-label"  for='inputText1'>Message</label>
                    <div class="col-md-5 controls">
                        <textarea class="notification_message character_limit form-control" id="message11" name="message" rows="5" cols="100"><?php echo isset($_POST['message']) ? $_POST['message'] : ""; ?></textarea>

                    </div>
                    <input type="hidden" id="android_title" value="" name="title" size="100" />
                    <input type="hidden" id="title" value="" name="action" size="100" />
                </div>
                <div class='form-group'>						
                    <label class='col-md-2 control-label' for='inputText1'>URL</label>
                    <div class='col-md-5'>
                        <input type="text" class="character_limit form-control" id="url" value="" name="url" size="100" />
                            <p style="display:none;"><strong>You have <em id="counter" class="counter"><?php echo (isset($notification_max_length->val)) ? $notification_max_length->val : ''; ?></em> characters remaining(message+url)</strong></p>
                    </div>                    
                    <input type="hidden" name="max_length" id="max_length" value="<?php echo (isset($notification_max_length->val)) ? $notification_max_length->val : ''; ?>">
                </div>  
                <div class='form-group device_div'>
                    <label class='col-md-2 control-label' for='inputText1'>Device Id</label>
                    <div class='col-md-5 controls'>
                        <!-- <input type="text" name="iphone_send_device" id="iphone_device_id" class="form-control"> -->
                        <input type="text" id="demo-input-local-exclude" name="blah" id="blah" />
                    </div>
                    <input type="hidden" name="send_for" id="send_for" value="<?php echo (isset($request_page)) ? $request_page : ''; ?>" />
                    <input type="hidden" name="device_type" id="notification_image" value="I" />
                    <input type="hidden" name="notification_image" id="notification_image" value="" />
                    <input type="hidden" value="0" name="success" size="100" />
                    <input type="hidden" value="0" name="fail" size="100" />
                    <input type="hidden" name="status" size="100" value="pending"/>
                    
                </div>
                <div class='form-group send_to_all'>
                    <label class='col-md-2 control-label' for='inputText1'></label>
                    <div class='col-md-5 controls'>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="send_all" id="sendall" value="yes">Send to all Device
                        </label>
                    </div>
                </div>
                <div class="form-actions form-actions-padding-sm">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-2">
                            <button class='btn btn-primary' type='button' onclick="prepareNotification();" id="submit_notification">
                                <i class="fa fa-floppy-o"></i>
                                Send
                            </button>
                            <?php
                                $req = (isset($request_page)) ? $request_page : '';
                            ?>
                            <a href="<?php echo site_url() . 'admin/push_notification/' . $req; ?>" title="Cancel" class="btn" id="cancel_link">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>