<link rel="stylesheet" href="<?php echo site_url(); ?>/assets/front/stylesheets/file_upload_css/style.css">
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/tmpl.min.js"></script>
<link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/nanoscroller.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/emoji.css" rel="stylesheet">  		
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/nanoscroller.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/util.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/config.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/jquery.emojiarea.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/emoji-picker.js"></script>
<link href="<?php echo base_url(); ?>assets/front/stylesheets/inbox.css" rel="stylesheet">
<style>
    #content-wrapper .box .box-content {background:transparent !important; padding:0;}
    .alert-success { background-color:#f1f5fa; border: 1px solid #ddd; color: #3c763d; display: inline-block; padding: 15px; width: 100%; vertical-align:top; }
    #send-message-popup .alert-info{  background-color: #fff; border: 1px solid #ddd; color: #3c763d; display: inline-block; padding: 15px; width: 100%; vertical-align:top; }
    .user-img-t img {-webkit-border-radius: 60px; -moz-border-radius: 60px; -o-border-radius: 60px; border-radius: 60px; display: inline-block; height: 50px; vertical-align: top; width: 50px; background: #fff; border: 1px solid #ddd; float: right; margin: 0 0 0 20px;}

    .alert h5 { color: #034694; font-size: 16px; margin: 0; padding:4px 0 0;}
    .alert  p{ color:#000;}
    .time.recive-time {text-align: left; color:#666;}

    .alert-info .user-img-t{ float:left;}
    .alert-info .user-img-t img{ margin:0 20px 0 0;}
    .alert-info .time.recive-time { text-align: right;}
    .alert-success h5 { color: #034694;}
    .alert-info h5 { color:#ed1b33;}
</style>
<div class="popup-bg-002">
    <div id='content-wrapper'>
        <div class='col-xs-12'>                                                        
            <div class=''>
                <div class='box' style='margin-bottom:0'>					
                    <div class='box-content box-double-padding scrollable' data-scrollable-height='680' data-scrollable-start='bottom' style="background: #ECECEC;">
                        <div class='row'>                           
                            
                            <input type="hidden" id="con_user_id" value="<?php echo $con_user_id; ?>" >
                            <input type="hidden" id="con_oth_user" value="<?php echo $con_oth_user; ?>" >
                            <input type="hidden" id="con_product_id" value="<?php echo $con_product_id; ?>" >
                            <br>
                            <?php
                            foreach ($chat_list as $chat) {
                                if ($chat['sender_id'] != $current_user['user_id']) {
                                    $profile_picture = '';

                                    $profile_picture = $this->dbcommon->load_picture($chat['upick'], $chat['ufb'], $chat['utwi'], $chat['uname'], $chat['ugoo']);
                                    ?>
                                    <div class='col-sm-12 text-left pro_msg1 chat_msg2'>
                                        <div class='alert alert-info alert-dismissable'>
                                            <span class="user-img-t">
                                                <img src="<?php echo $profile_picture; ?>" alt="Profile Image">
                                                <h5><?php echo $chat['uname']; ?></h5>
                                            </span>
                                            <span class="arrow-left"/>
                                            <textarea data-emojiable="true" class="dis_txt"><?php echo json_decode(trim($chat['message'])); ?></textarea>
                                            <div class='time recive-time'>
                                                <small class='date recive-time'>
                                                    <span class='timeago has-tooltip' data-placement='top' title='<?php echo $chat['created_at']; ?>'>
                                                        <?php echo date('d-m-Y H:i', strtotime($chat['created_at'])); ?> 
                                                    </span><i class='icon-time'/>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    $profile_picture = '';
                                    $profile_picture = $this->dbcommon->load_picture($chat['upick'], $chat['ufb'], $chat['utwi'], $chat['uname'], $chat['ugoo']);
                                    ?>

                                    <div class='col-sm-12  text-right pro_msg2 chat_msg2'>
                                        <div class='alert alert-success alert-dismissable text-right'>
                                            <span class="user-img-t">
                                                <img src="<?php echo $profile_picture; ?>" alt="Profile Image"><br>
                                                <h5><?php echo $chat['uname']; ?></h5>
                                            </span>
                                            <span class="arrow-right"/>																	
                                            <textarea data-emojiable="true" class="dis_txt"><?php echo json_decode(trim($chat['message'])); ?></textarea>
                                            <div class='time recive-time'>
                                                <small class='date recive-time '>
                                                    <span class='timeago  has-tooltip' data-placement='top' title=''  >
                                                        <?php echo date('d-m-Y H:i', strtotime($chat['created_at'])); ?>
                                                    </span> 
                                                    <i class='icon-time'/>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <?php if ($hide == "false") { ?>
                                <div class="col-sm-12 text-center" id="load_more">
                                    <button class="btn btn-blue" onclick="more_conversation();" id="load_con" value="0">Load More</button><br><br><br>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="loading1" style="text-align:center;display:none;">
            <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
        </div>
    </div>
</div>
<script>
    var i = 0;
    <?php 
    
        $loggein_profile_pic = $this->dbcommon->load_picture($current_user['profile_picture'],$current_user['facebook_id'], $current_user['twitter_id'], $current_user['username'], $current_user['google_id']);
    ?>
    function more_conversation() {

        $body = $("body");
        $body.addClass("loading");
        var user_id = $("#con_user_id").val();
        var oth_user = $("#con_oth_user").val();
        var product_id = $("#con_product_id").val();
        var url = "<?php echo base_url() ?>user/more_conversation/";
        var start = $("#load_con").val();

        start++;
        $("#load_con").val(start);
        var val1 = start;
        $('#loading1').show();

        $.post(url, {user_id: user_id, oth_user: oth_user, product_id: product_id, value: val1}, function (response) {
            $("#load_more").before(response.html);
            if (response.val == "true") {
                $("#load_con").hide();
            }
            $('#loading1').hide();
        }, "json");
    }
</script>
<script>
    $(function () {
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '<?php echo base_url(); ?>assets/front/stylesheets/emojis/img/',
            popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
    });
</script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>

