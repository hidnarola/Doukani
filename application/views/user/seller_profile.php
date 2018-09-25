<?php if($this->session->flashdata('msg1')):  ?>
          <div class='alert  alert-info'>
            <a class='close' data-dismiss='alert' href='#'>&times;</a>
            <center><?php echo $this->session->flashdata('msg1'); ?></center>
          </div>
                    <?php endif; ?>
			<div class="bg_up">
                      <div class="user_profile_main">
					  <input type="hidden" name="user_id" id="user_id" value="<?php echo $user->user_id; ?>">
                        <div class="clearfix">
                          <div class="user_pro_pic">
                            <?php $profile_picture = '';
                                    if($user->profile_picture != ''){
										$profile_picture = base_url() . profile . "original/" .$user->profile_picture;	
									}
									elseif($user->facebook_id != ''){
                                        $profile_picture = 'https://graph.facebook.com/'.$user->facebook_id.'/picture?type=large';
                                    }elseif($user->twitter_id != ''){
                                        $profile_picture = 'https://twitter.com/'.$user->username.'/profile_image?size=original';
									}
									elseif($user->google_id != ''){
										$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$user->google_id.'?alt=json');
										$d = json_decode($data);
										$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
									}
                                 ?>
                            <img src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'">
                            <?php if($get_myfollowers > 0 && $is_logged==1){ ?>
                              <div class="badge_top">
                                <img src="<?php echo base_url(); ?>assets/front/images/check.png" alt="" />
                              </div>
                            <?php } ?>
                          </div>
                          <div class="right_follow_side">
                            <h3><?php if($user->nick_name!=''): echo $user->nick_name; else: echo $user->username; endif; ?></h3>
                            <div class="bottom_bar">
                              <?php 
                                  $btn_name = 'Follow';
                                  if($is_following > 0)
                                    $btn_name = 'Following'; 
                                  if(isset($login_username))
								  {
									if($login_username!=$user->username) { ?>									
									<a href="<?php echo base_url(); ?>seller/addfollow/<?php echo $user->user_id; ?>" class="btn btn-block mybtn follow_btn"><?php echo $btn_name; ?></a>
									<?php 
									} 
								  }
								  else
								  { ?>
									<a href="<?php echo base_url(); ?>seller/addfollow/<?php echo $user->user_id; ?>" class="btn btn-block mybtn follow_btn"><?php echo $btn_name; ?></a> 
							<?php }  ?>
                                <!-- <button class="btn btn-block mybtn follow_btn"><?php echo $btn_name; ?></button> -->
                              <ul class="user_followers_main">
                                <li><a href="<?php echo base_url(); ?>seller/listings/<?php echo $user->user_id; ?>"><img src="<?php echo base_url(); ?>assets/front/images/img_1.png"> Listings</a></li>
                                <li><a href="<?php echo base_url(); ?>seller/followers/<?php echo $user->user_id; ?>"><img src="<?php echo base_url(); ?>assets/front/images/follow_icon.png"> Followers <?php echo sizeof($followers); ?></a></li>
                                <!--<li><a href="#" id="contact"><img src="<?php echo base_url(); ?>assets/front/images/message_icon.png"> Contact</a></li>-->
								<li><button class="btn mybtn"><span class="fa fa-phone"></span><span class="show_number"> Contact</span></button></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
<script>
	$('div.navigation').css({'float' : 'left'});
		$('button.mybtn').click(function(){
			$(this).find('.show_number').text('<?php echo $user->phone; ?>');			
		});
	$('div.content').css('display', 'block');
</script>