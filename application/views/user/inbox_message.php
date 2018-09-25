<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <?php $this->load->view('include/head'); ?>   
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script> 	
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
        <!-- <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/jquery.emojiareaP.js"></script> -->
        <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/emoji-picker.js"></script>
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/inbox.css" rel="stylesheet">
        <!-- <link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/bootstrap.min.css" rel="stylesheet">  
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/cover.css" rel="stylesheet">  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/nanoscroller.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/emoji.css" rel="stylesheet">  		  
    </head>
    <body>
        <div class="container-fluid">     
            <?php $this->load->view('include/header'); ?>      
            <?php $this->load->view('include/menu'); ?>        
            <div class="page">            
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>            
                        <div class="col-sm-12 main dashboard">
                            <?php $this->load->view('include/left-nav'); ?>
                            <div class="col-sm-9 ContentRight">                    	

                                <?php $this->load->view('user/user_menu'); ?>	
                                <div id="loading1" class="loader"></div>
                                <?php
                                if (sizeof($listing) > 0) {
                                    foreach ($listing as $list) { ?>
                                        <div class="custome-chat">						
                                            <ul>
                                                <li>
                                                    <div class="first-chat" onclick="toggle('<?php echo $list['product_id']; ?>');">
                                                        <div class="first-chat-img">
                                                            <?php if ($list['product_image'] != '') { ?>
                                                                <img width="80px" height="60px" src="<?php echo base_url() . product . "small/" . $list['product_image']; ?>" alt="Image #1" onerror="this.src='<?php echo base_url() . 'assets/upload/No_Image.png'; ?>'" alt="Product Image"></img>
                                                            <?php } else { ?>
                                                                <img width="80px" height="60px" src="<?php echo base_url() . 'assets/upload/No_Image.png'; ?>" alt="Image #1" onerror="this.src='<?php echo base_url() . 'assets/upload/No_Image.png'; ?>'" alt="Product Image"></img>
                                                            <?php } ?>
                                                        </div>
                                                        <h4>
                                                            <?php
                                                            if ($list['product_for'] == 'classified')
                                                                $redirect_product_pg = site_url() . $list['product_slug'];
                                                            else
                                                                $redirect_product_pg = HTTP . $list['store_domain'] . after_subdomain . '/' . $list['product_slug'];
                                                            ?>
                                                            <a href="<?php echo $redirect_product_pg; ?>" style="text-size:10px"><?php echo $list['product_name']; ?></a></h4>
                                                        <p><?php echo $list['product_price'] . ' AED'; ?></p>
                                                    </div>									
                                                    <div class="show-commentbox" onclick="toggle('<?php echo $list['product_id']; ?>');">
                                                        <?php if ($list['counter'] > 0) { ?>
                                                            <span class="btn btn-danger" style="height:20px;padding:0px;" id="new_lable_<?php echo $list['product_id']; ?>"	>&nbsp;New&nbsp;</span> 
                                                        <?php } ?>										
                                                        <a href="javascript:void(0);" id="commentbox<?php echo $list['product_id']; ?>"><i class="fa fa-chevron-down" class="mylink" ></i></a>
                                                    </div>
                                                    <?php
                                                    $this->load->model('dbcommon', '', TRUE);
                                                    $con = $this->dbcommon->get_senders($list['product_id'], $current_user['user_id']);
                                                    //echo $this->db->last_query().'<br><br>';									
                                                    foreach ($con as $c) {
                                                        if ($c['product_id'] == $list['product_id']) {
                                                            if ($c['uid'] == $user_id) {

                                                                $user_arr[$c['u1id']]['username'] = $c['u1name'];
                                                                $user_arr[$c['u1id']]['user_id'] = $c['u1id'];
                                                                $user_arr[$c['u1id']]['product_id'] = $c['product_id'];
                                                                $user_arr[$c['u1id']]['sent'] = 'yes';

                                                                $user_arr[$c['u1id']]['profile_picture'] = $this->dbcommon->load_picture($c['u1pick'], $c['u1fb'], $c['u1twei'], $c['u1twei'], $c['u1goo']);
                                                            } else {
                                                                $user_arr[$c['uid']]['username'] = $c['uname'];
                                                                $user_arr[$c['uid']]['user_id'] = $c['uid'];
                                                                $user_arr[$c['uid']]['product_id'] = $c['product_id'];
                                                                $user_arr[$c['uid']]['sent'] = '';

                                                                $user_arr[$c['uid']]['profile_picture'] = $this->dbcommon->load_picture($c['upick'], $c['ufb'], $c['utwi'], $c['utwi'], $c['ugoo']);
                                                            }
                                                        }
                                                    }


                                                    foreach ($user_arr as $k => $u) {
                                                        if ($u['product_id'] == $list['product_id']) {
                                                            $msg = $this->dbcommon->last_up_conv($list['product_id'], $u['user_id']);
                                                            ?>	
                                                            <!-- display:none;-->
                                                            <div class="comment-box-01 comment-box-<?php echo $list['product_id']; ?>" style="">
                                                                <div class="grounp-comments">
                                                                    <div class="grounp-comments-icons">
                                                                        <div class="grounp-comments-img">
                                                                            <img src="<?php echo $u['profile_picture']; ?>" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" alt="Profile Image">
                                                                        </div>										
                                                                    </div>
                                                                    <div class="grounp-comments-right">
                                                                        <div class="user-name">
                                                                            <h5><?php echo $u['username']; ?></h5>
                                                                            <h6 id="time_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>"><?php echo date('d-m-Y H:i', strtotime($msg['created_at'])); ?></h6>
                                                                        </div>
                                                                        <span id="db_data<?php echo $list['product_id']; ?>_<?php echo $u['user_id']; ?>" class="msgtxt">
                                                                            
                                                                            <textarea data-emojiable="true" class="dis_txt chat_msg2" id="results_<?php echo $list['product_id']; ?>_<?php echo $u['user_id']; ?>"><?php echo json_decode($msg['message']); ?></textarea>
                                                                        </span>
                                                                        <p class="print_p" id="print_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>"></p>
                                                                        <br>
                                                                        <form class='form form-horizontal default_form validate-form callmulti_form' method="post" id="<?php echo $list['product_id'] . '_' . $u['user_id']; ?>">	
                                                                            <div class="comment-replay">											
                                                                                        <!--action="<?php //echo site_url();     ?>user/send_reply" -->											
                                                                                <input type="hidden" name="mproduct_id" id="mproduct_id_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>" value="<?php echo $list['product_id']; ?>">
                                                                                <input type="hidden" name="receiver_id"  id="receiver_id_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>" value="<?php echo $u['user_id']; ?>">
                                                                                <input type="hidden" name="sender_id"  id="sender_id_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>" value="<?php echo $user_id; ?>">
                                                                                <p class="lead emoji-picker-container" id="myp_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>">
                                                                                    <input type="text" class="form-control reply_box" placeholder="Reply here..." data-emojiable="true" name="reply"   id="reply_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>"  maxlength="100"/>
                                                                                </p>
                                                                                <br><br>
                                                                                <button type="submit" id="submit" class="submit">Reply</button>
                                                                                <div class="data-icon"><a href="javascript:void(0);" onclick="detail_data('<?php echo $list['product_id']; ?>', '<?php echo $user_id; ?>', '<?php echo $u['user_id']; ?>')" title="Convesation"><i class="fa fa-database"></i>&nbsp;Conversation</a>
                                                                                    <h6 align="right"  class="sent-comment" id="sent_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>"><?php echo $msg['mysent']; ?></h6>	</div>

                                                                        </form>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    ?>												
                                                </li>
                                            </ul>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="catlist col-sm-10">
                                            <div class="TagsList">
                                                <div class="subcats">
                                                    <div class="col-sm-12 no-padding-xs">
                                                        <div class="col-sm-12">
                                                            &nbsp;No Message found
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                </div>	
                            </div>
                            <nav class="col-sm-8 text-left">
                                <?php echo $links; ?>
                            </nav>			
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
<?php $this->load->view('include/footer'); ?>        
<div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog"  aria-hidden="true">			
    <div class="modal-dialog modal-md" style="width:70%">
        <div class="modal-content rounded">
            <div class="modal-header text-center orange-background" style="background:#034694 none repeat scroll 0 0;  border-radius: 6px 6px 0 0;color: #fff;font-size: 18px;margin: -1px 0 0;padding: 10px; " >
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    <i class="fa fa-close"></i>
                </button>
                <h4 id="myLargeModalLabel" class="modal-title"><i class="fa fa-envelope-o"></i> Conversation</h4>							
            </div>
            <div id="chat_mod">
                <div id="loading3" style="text-align:center;">
                    <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
                </div>						
            </div>
        </div>
    </div>
</div>	
<div id="loading" style="text-align:center;display:none;" class="loader_display">
    <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
</div>

<div id="div_js"></div>

<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/nanoscroller.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/util.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/config.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/jquery.emojiarea.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/emoji-picker.js"></script>
<script>
                                                                    function detail_data(product_id, user_id, oth_user) {
                                                                        $('#loading3').show();
                                                                        var url = "<?php echo base_url(); ?>user/conversation";
                                                                        //$("#chat_mod").append("");		
                                                                        $("#send-message-popup").modal('show');
                                                                        $.post(url, {product_id: product_id, user_id: user_id, oth_user: oth_user}, function (response)
                                                                        {
                                                                            $("#chat_mod").html(response.html);
                                                                            $('#loading3').hide();
                                                                        }, "json");
                                                                    }

                                                                    function toggle(a) {
                                                                        var url = "<?php echo base_url(); ?>user/update_seen";
                                                                        $('.comment-box-' + a).toggle();
                                                                        $('#new_lable_' + a).hide();
                                                                        var count = $('#inbox_count_txt').val();

                                                                        $.post(url, {product_id: a}, function (response)
                                                                        {
                                                                            response = parseInt(response);
                                                                            $('#inbox_count').text("(" + response + ")");
                                                                            return false;
                                                                        }, "json");
                                                                    }

                                                                    $(document).ready(function () {

                                                                        $('textarea').attr('readonly', 'readonly');
                                                                        $(".callmulti_form").submit(function () {

                                                                            var formID = $(this).attr('id');
                                                                            var formDetails = $('#' + formID);
                                                                            var reply = $.trim($('#reply_' + formID).val());

                                                                            if (reply != '' && reply != undefined) {

                                                                                var r = $('#reply_' + formID).val();
                                                                                var url = "<?php echo base_url(); ?>user/send_reply";

                                                                                $('.loader_display').show();
                                                                                $.ajax({
                                                                                    type: "POST",
                                                                                    url: url,
                                                                                    data: formDetails.serialize(),
                                                                                    success: function (data) {
                                                                                        var copy = $("#myp_" + formID).html();
                                                                                        $("#db_data").hide();
                                                                                        $('.loader_display').hide();

                                                                                        $(function () {
                                                                                            window.emojiPicker = new EmojiPicker({
                                                                                                emojiable_selector: '[data-emojiable=true]',
                                                                                                assetsPath: '<?php echo base_url(); ?>assets/front/stylesheets/emojis/img',
                                                                                                popupButtonClasses: 'fa fa-smile-o'
                                                                                            });
                                                                                            window.emojiPicker.discover();
                                                                                        });
                                                                                        $('#results_' + formID).attr("data-emojiable", "true");

                                                                                        var obj = jQuery.parseJSON(data);

                                                                                        $('#db_data' + formID).hide();
                                                                                        $('#results_' + formID).hide();
                                                                                        $('#results_' + formID).html("");
                                                                                        $('#results_' + formID).text("");
                                                                                        $('#sent_' + formID).text("");
                                                                                        $('#time_' + formID).text("");

                                                                                        $('#sent_' + formID).text("Sent");
                                                                                        $('#time_' + formID).text(obj.sent_at);

                                                                                        $('#reply_' + formID).val('');

                                                                                        $('#loading').hide();

                                                                                        $("#print_" + formID).html(copy);
                                                                                        $(document).find("#print_" + formID + ' .reply_box').val(r);

                                                                                        $(".grounp-comments-right .print_p").find('i.emoji-picker-icon').css('display', 'none');
                                                                                        $(".grounp-comments-right .print_p").find('.form-control').removeClass("form-control");
                                                                                        $("#print_" + formID).find('input').removeAttr("id");
                                                                                        $("#myp_" + formID).find('div').html('');

                                                                                    },
                                                                                    error: function (jqXHR, text, error) {
                                                                                        $('#result').html(error);
                                                                                    }
                                                                                }, "json");
                                                                            }
                                                                            return false;
                                                                        });
                                                                    });


                                                                    function more_products() {
                                                                        var url = "<?php echo base_url(); ?>user/load_more_inbox_listing";
                                                                        var start = $("#load_product").val();
                                                                        start++;
                                                                        $("#load_product").val(start);
                                                                        var val = start;
                                                                        $.post(url, {value: val}, function (response)
                                                                        {
                                                                            $("#most-viewed").append(response.html);
                                                                            if (response.val == "true") {
                                                                                $("#load_product").hide();
                                                                            }
                                                                        }, "json");
                                                                    }
</script>
<script>
    $(function () {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '<?php echo base_url(); ?>assets/front/stylesheets/emojis/img',
            popupButtonClasses: 'fa fa-smile-o'
        });
        window.emojiPicker.discover();
    });
</script>
</body>
</html>