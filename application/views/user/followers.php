<html>
<head>
     <?php $this->load->view('include/head'); ?>
</head>

<body>
<!--container-->
	<div class="container-fluid">
            
    	<!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
        <!--//ad1 header-->
        <!--menu-->
		<?php $this->load->view('include/menu'); ?>
        <!--//menu-->
        
        <!--body-->
        <div class="row page">
            <!--header-->
           <?php $this->load->view('include/sub-header'); ?>
            <!--//header-->
            <!--main-->
            <div class="col-sm-12 main">
		        <div class="row">
                    <!--cat-->
                   <?php $this->load->view('include/left-nav'); ?>
                    <!--//cat-->
                    <!--content-->
                    <div class="col-sm-10">
                        <?php $this->load->view('home/seller_profile'); ?>
                        <div class="col-md-12">
                          <?php if(!empty($myfollowers)){ ?>
                          <table class="followers_tbl table table-striped table-bordered">
                            <thead>
                              <tr>
                              <th>Profile Image</th>
                              <th>Name</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach ($myfollowers as $follower) {
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
						  <?php if(@$hide == "false"){?>
						  <div class="col-sm-12 text-center loding-btn" id="load_more">
									<button class="btn btn-blue" onclick="more_followers();" id="load_product" value="0">Load More</button>
						   </div>
						   	<?php } ?>	
                        </div>
                    </div>
                        </div>
                    <!--//content-->
                </div>
            </div>
            <!--//main-->
        </div>
        <!--//body-->
        <div id="loading" style="text-align:center">
            <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
        </div>
        <!--footer-->
            <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>
<script type="text/javascript">
     $('div.star a i').click(function() { 
          
             var url = "<?php echo base_url() ?>home/add_to_favorites";
            var fav = 0;
            var id = $(this).attr('id');
//            console.log(id);
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
//                console.log(response);
				if(response!='Success' && response!='failure')
				{
					$('#err_div').show();
					$("#error_msg").text(response);					
				}
				else				
					$('#err_div').hide();
            });
        });
		
		function more_followers(){
           $body 		= $("body");
           $body.addClass("loading");
            var url 	= "<?php echo base_url() ?>seller/more_followers";
            var start 	= $("#load_product").val();
            start++;
            $("#load_product").val(start);
			var user_id	 =	$("#user_id").val();
            var val		 = start;
             //$('#loading').show();
            $.post(url, {value: val,user_id:user_id}, function(response)
            {
				///alert(response);
              //console.log(response);
			  		  
                $("#load_more").before(response.html);
                if(response.val == "true"){
                    $("#load_product").hide();
                }
                $('#loading').hide();


            }, "json");
        }	
</script>
<!--container-->
</body>
</html>