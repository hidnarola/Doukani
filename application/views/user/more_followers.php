

                          <?php if(!empty($myfollowers1)){ ?>
                          <table class="followers_tbl table table-striped table-bordered">                           
                          <tbody>
                            <?php
                              foreach ($myfollowers1 as $follower) {
                              ?>
                            <tr style="border-bottom: 1px solid #">
                              <td>
                                <?php $profile_picture = '';
									if($follower['profile_picture'] != ''){
										$profile_picture = base_url() . profile . "original/" .$follower['profile_picture'];	
									}
                                    elseif($follower['facebook_id'] != ''){
                                        $profile_picture = 'https://graph.facebook.com/'.$follower['facebook_id'].'/picture?type=large';
                                    }else if($follower['twitter_id'] != ''){
                                        $profile_picture = 'https://twitter.com/'.$follower['username'].'/profile_image?size=original';     
                                    }
									elseif($follower['google_id'] != ''){
										$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$follower['google_id'].'?alt=json');
										$d = json_decode($data);
										$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
									}
                                 ?>
                            <img class="img-responsive img-square" height="100" width="100" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'">

                          </td>
                              <td><p><?php if($follower['nick_name']!=''): echo $follower['nick_name']; else: echo $follower['username']; endif; ?></p></td>
                            </tr>
                            <?php } ?>
                          
                            <?php }else{ ?>
                            <p> There are no followers to list.</p>
                            <?php } ?>							
							</tbody>
                          </table>
                       
<script type="text/javascript">
     $('div.star a i').click(function() { 
          
             var url = "<?php echo base_url() ?>home/add_to_favorites";
            var fav = 0;
            var id = $(this).attr('id');
            console.log(id);
            if($(this).hasClass('fa-star-o')){
                 $(this).closest('div').addClass('fav');
                 $(this).removeClass("fa-star-o");
                 $(this).addClass("fa-star");
                 fav = 1;
            }else if($(this).hasClass('fa-star')){
                 $(this).closest('div').removeClass('fav');
                 $(this).addClass("fa-star-o");
                 $(this).removeClass("fa-star");
                 fav = -1;
            }
            
             $.post(url, {value: fav,product_id:id}, function(response){   
                console.log(response);
				if(response!='Success' && response!='failure')
				{
					$('#err_div').show();
					$("#error_msg").text(response);					
				}
				else				
					$('#err_div').hide();
            });
        });
</script>
<!--container-->
</body>
</html>