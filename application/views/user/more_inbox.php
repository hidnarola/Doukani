<?php foreach ($listing as $list) { ?>	
    <div class="custome-chat">						
        <ul>
            <li><!-- style="background-color:#eeeeee;"-->
                <div class="first-chat" onclick="toggle('<?php echo $list['product_id']; ?>');">
                    <div class="first-chat-img">
                        <?php if (isset($list['product_image']) && !empty($list['product_image'])) { ?>
                            <img width="80px" height="60px" src="<?php echo base_url() . product . "small/" . $list['product_image']; ?>" alt="Image #1" onerror="this.src='<?php echo base_url() . 'assets/upload/No_Image.png'; ?>'" ></img>
                        <?php } else { ?>
                            <img width="80px" height="60px" src="<?php echo base_url() . 'assets/upload/No_Image.png'; ?>" alt="Image #1" onerror="this.src='<?php echo base_url() . 'assets/upload/No_Image.png'; ?>'"></img>
                        <?php } ?>
                    </div>
                    <h4><a href="<?php echo site_url() . 'home/item_details/' . $list['product_id']; ?>" style="text-size:10px"><?php echo $list['product_name']; ?></a></h4>
                    <p><?php echo $list['product_price'] . ' AED'; ?></p>
                </div>									
                <div class="show-commentbox" onclick="toggle('<?php echo $list['product_id']; ?>');">
                    <a href="javascript:void(0);"  id="commentbox<?php echo $list['product_id']; ?>"  ><i class="fa fa-chevron-down" class="mylink" ></i></a>
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

                            $user_arr[$c['uid']]['profile_picture'] = $this->dbcommon->load_picture($c['upick'], $c['ufb'], $c['utwi'], $c['username'], $c['ugoo']);
                        }
                    }
                }

                foreach ($user_arr as $k => $u) {
                    if ($u['product_id'] == $list['product_id']) {
                        $msg = $this->dbcommon->last_up_conv($list['product_id'], $u['user_id']);
                        //$profile_picture='';							
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
                                        <h5><?php echo $u['username']; ?>
                                        </h5>
                                        <div class="data-icon"><a href="javascript:void(0);" onclick="detail_data('<?php echo $list['product_id']; ?>', '<?php echo $user_id; ?>', '<?php echo $u['user_id']; ?>')"><i class="fa fa-database"></i></a></div>
                                        <h6 id="time_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>"><?php echo date('d-m-Y H:i', strtotime($msg['created_at'])); ?></h6>

                                    </div>	
                                    <p id="results_<?php echo $list['product_id']; ?>_<?php echo $u['user_id']; ?>"><?php echo $msg['message']; ?></p>

                                    <div class="comment-replay">
                                        <form class='form form-horizontaldefault_form' method="post" id="<?php echo $list['product_id'] . '_' . $u['user_id']; ?>">
                                            <input type="hidden" name="mproduct_id" id="mproduct_id_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>" value="<?php echo $list['product_id']; ?>">
                                            <input type="hidden" name="receiver_id"  id="receiver_id_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>" value="<?php echo $u['user_id']; ?>">
                                            <input type="hidden" name="sender_id"  id="sender_id_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>" value="<?php echo $user_id; ?>">
                                            <input type="text" placeholder="Reply here..." name="reply"   id="reply_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>" maxlength="50" required="required">
                                            <button type="submit" id="submit" class="submit">Reply</button>
                                        </form>

                                        <h6 align="right"  class="sent-comment" id="sent_<?php echo $list['product_id'] . '_' . $u['user_id']; ?>"><?php echo $msg['mysent'] ?></h6>
                                    </div>
                                </div> 
                            </div>
                        </div>
        <?php }
    } ?>												
            </li>
        </ul>
<?php } ?>	