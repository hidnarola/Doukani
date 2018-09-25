<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/tmpl.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/nanoscroller.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/util.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/config.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/jquery.emojiarea.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/emoji-picker.js"></script>
<style>
    .emoji-picker-icon { display:none;}
    textarea { pointer-events:none; border: none; }
</style>
<div class='box-content box-double-padding scrollable' data-scrollable-height='680' data-scrollable-start='bottom' style="background: #ECECEC;" id="entire_div_<?php echo $buyer_id; ?>_<?php echo $product_owner; ?>_<?php echo $product_id; ?>" >
    <div class='row'>
        <div class="delete-all">
            <label for="all">Delete All
                <input type="checkbox" id="all" value="0" style="height: 16px;" data-id1="<?php echo $buyer_id; ?>" 
                   data-id2="<?php echo $product_owner; ?>"  
                   data-id3="<?php echo $product_id; ?>" />
                <a class="delete_all" data-id1="<?php echo $buyer_id; ?>" data-id2="<?php echo $product_owner; ?>"  data-id3="<?php echo $product_id; ?>">
                    <i class="fa fa-trash-o"></i>
                </a>
            </label>
        </div>
        <?php
        foreach ($conversation as $con) {
            if ($con['message'] != '') {
                if ($buyer_id == $con['uid'] && $con['message'] != '') {
                    ?>
                    <div class='col-sm-12 text-left pro_msg1 user_chat_<?php echo $con['con_id']; ?>'>
                        <div class='alert alert-info alert-dismissable'>
                            <span class="user-img-t">
                                <?php
                                $profile = $this->dbcommon->load_picture($con['upick'], $con['ufb'], $con['utwi'], $con['uname'], $con['ugoo'], 'small');
                                ?>
                                <img src="<?php echo $profile; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'">
                            </span>
                            <span class="arrow-left"></span>
                            
                            <textarea data-emojiable="true" class="dis_txt chat_msg2" readonly><?php echo json_decode($con['message']); ?></textarea>
                            <div class="single-delete">
                                <input class="input-sm individual_<?php echo $buyer_id; ?>_<?php echo $product_owner; ?>_<?php echo $product_id; ?>" type="checkbox"  style="height: 16px;" value="<?php echo $con['con_id']; ?>"  />

                                <a class="delete" id="<?php echo $con['con_id']; ?>">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                            <div class='time recive-time'>
                                <small class='date recive-time'>
                                    <?php echo date('F d, Y - H:i', strtotime($con['created_at'])); ?>
                                    <i class='icon-time'></i>
                                </small>
                            </div>
                        </div>
                    </div>
                <?php } elseif ($con['message'] != '') {
                    ?>
                    <div class='col-sm-12  text-right pro_msg2 user_chat_<?php echo $con['con_id']; ?>'>
                        <div class='alert alert-success alert-dismissable text-right'>
                            <span class="user-img-t">
                                <?php
                                $profile = $this->dbcommon->load_picture($con['upick'], $con['ufb'], $con['utwi'], $con['uname'], $con['ugoo'], 'small');
                                ?>
                                <img src="<?php echo $profile; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'">
                            </span>
                            <span class="arrow-right"></span>
                            
                            <textarea data-emojiable="true" class="dis_txt chat_msg2" readonly><?php echo json_decode($con['message']); ?></textarea>
                            <div class="single-delete">
                                <input class="input-sm individual_<?php echo $buyer_id; ?>_<?php echo $product_owner; ?>_<?php echo $product_id; ?>" type="checkbox"  style="height: 16px;" value="<?php echo $con['con_id']; ?>"  />
                                <a class="delete" id="<?php echo $con['con_id']; ?>">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </div>
                            <div class='time recive-time'>
                                <small class='date recive-time '>
            <?php echo date('F d, Y - H:i', strtotime($con['created_at'])); ?>                                
                                    <i class='icon-time'></i>
                                </small>
                            </div>
                        </div>
                    </div>

                <?php
                }
            }
        }
        ?>
    </div>
</div>

<div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">  
                <h4 class="modal-title">Confirmation
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </h4>                   
            </div>
            <div class="modal-body">                  
                <p id="alert_message_action">Are you sure want delete Conversation(s)?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<script>   
        
    $(function () {
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '<?php echo base_url(); ?>assets/front/stylesheets/emojis/img/',
            popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
    });
    
    
    $(document).on("click", ".delete", function (e) {
        var delete_con_id = $(this).attr('id');
        
        var url = "<?php echo site_url(); ?>admin/Conversation/message_delete";
        $.post(url, {con_id: delete_con_id}, function (response) {
            
            if(response=='success')
                $('.user_chat_'+delete_con_id).hide();
        });
        return false;
    
    });
    
    $(document).on("click", "#all", function (e) {

        var buyer_id      = $(this).attr('data-id1');
        var product_owner = $(this).attr('data-id2');
        var product_id    = $(this).attr('data-id3');

        var checked = $(this).attr('checked');

        if (checked)
            $(".individual_"+buyer_id+"_"+product_owner+"_"+product_id).attr('checked', true);
        else
            $(".individual_"+buyer_id+"_"+product_owner+"_"+product_id).attr('checked',false);
    });
    
    
    $(document).on("click", ".delete_all", function (e) {
        
        var buyer_id      = $(this).attr('data-id1');
        var product_owner = $(this).attr('data-id2');
        var product_id    = $(this).attr('data-id3');
        
        var checkedValues = $('.individual_'+buyer_id+"_"+product_owner+"_"+product_id +':checked').map(function () {
            return this.value;
        }).get();
        console.log(checkedValues);
        
        if(checkedValues!='') {
            
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if(val=='yes') {     
                    var url = "<?php echo site_url(); ?>admin/Conversation/message_delete";
                    $.post(url, {checked_val: checkedValues}, function (response) {
                        if(response=='success') {
                            $('#entire_div_'+ buyer_id +'_'+product_owner + '_' +product_id).hide();
                            $("#deleteConfirm").modal('hide');
                        return false;
                        }
                    });
                }
            });
        }
        else {
            $("#alert").modal('show');
            $("#error_msg").html("Select any record to perform action");
        }
    });
    
</script>