<html>
    <head>
		<title><?php echo ($page_title) ? $page_title : 'Doukani';?></title>				
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>		
		<link href='<?php echo base_url(); ?>assets/admin/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
        <?php //$this->load->view('include/head'); ?>
		<link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.carousel.css' rel='stylesheet' type='text/css'>		
		<link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>		
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;" />
    <link href="<?php echo base_url(); ?>assets/front/dist/css/bootstrap.css" rel="stylesheet">    
    <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />        
    
    
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url(); ?>assets/front/dist/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap.min.js"></script>
    
    <!-- Validate Plugin -->
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/plugins/validate/jquery.validate.min.js"></script>
    
	<script src="<?php echo base_url(); ?>assets/front/javascripts/theme.js" type="text/javascript"></script>
    <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />    
	<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
	
	<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
	

	<link href="<?php echo base_url(); ?>assets/front/style.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/front/responsive.css" rel="stylesheet">
	
	<title>Home Page</title>
   </head>

    <body>
		
        <div class="container-fluid">

            <?php $this->load->view('include/home_header'); ?>

            <?php $this->load->view('include/menu'); ?>

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
                        <div class="col-sm-10 bgcolhome">						
                            <div class="row latest">
                                <div class="col-sm-8 latest-ad">
								<!-- <div class="wrapper-with-margin">
									<div id="owl-demo" class="owl-carousel">
										 <div>One</div><div>Two</div><div>Three</div><div>Four</div>
										 <div>Five</div><div>Six</div><div>Seven</div><div>Eight</div>
										 <div>Nine</div><div>Ten</div>
									</div>
								</div> 
<div class="owl-controls clickable"><div class="owl-pagination"><div class="owl-page active">trial<span class=""></span></div><div class="owl-page">eample<span class=""></span></div></div></div>-->
		<?php 
			$active1	=	'';
			$active2	=	'';
			/*if(sizeof($f_products)>0)
				$active1	=	'active';
				
			if(sizeof($latest_product)>0 && sizeof($f_products)==0) */
				$active2	=	'active';			
		?>
		<!-- <ul id="myTabs" class="nav nav-tabs" role="tablist">
			<!--<li role="presentation" class="<?php echo $active1; ?>">
				<a href="<?php if($active1=='active') echo '#featured_tab'; else echo '#'; ?>" aria-controls="<?php if($active1=='active') echo 'featured_tab'; else echo '#'; ?>" role="tab" data-toggle="tab" style="<?php if($active1=='') echo 'color:gray;pointer-events:none;'; ?>"><label class="tab_label">Featured Ads</label></a>
			</li> 
			<li role="presentation" class="<?php echo $active2; ?>"><a href="#latest_tab" aria-controls="proflatest_tabile" role="tab" data-toggle="tab"><label class="tab_label">Latest Ads</label></a></li>
		</ul> -->
		<ul id="myTabs" class="nav nav-tabs" role="tablist" >
			<li style="padding-top:12px;">
				<label class="tab_label">Latest Ads</label>
			</li>
		</ul>
		<div class="tab-content">
			<!-- <div role="tabpanel" class="tab-pane <?php echo $active1; ?>" id="featured_tab">
			<div id="owl-demo1" class="owl-carousel">
					<?php foreach ($f_products as $pro) {  ?>
                <div class="item ">
					<div class="col-sm-12">
						<div class="item-sell featured-sell">
                            <div class="ribbon_main">
                                <div class="red_ribbon"></div>
                                    <div class="item-img">
										<?php if($pro['product_is_sold']==1) { ?>
										<div class="sold"><span>SOLD</span></div>
										<?php } ?>
											<a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>"  class="img-responsive center-block" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'" /></a>
                                    </div>
                            </div>
							<div class="item-disc">
								 <a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>">
									<?php  $len	=	strlen($pro['product_name']); ?>	
									<h4 <?php if($len>17){ echo 'title="'.$pro['product_name'].'"'; } ?> >
									<?php  echo $pro['product_name'];	?></h4>
									</a>
									<?php 
										$str	=	str_replace('\n', " ", $pro['catagory_name']);
										$len	=	strlen($str);
									?>
									<small <?php if($len>25){ echo 'title="'.$str.'"'; } ?>>
									<?php 	echo $str; ?>
									</small>
							</div>
							  <div class="cat_grid">
								<div class="by-user">
									<?php $profile_picture = '';
									if($pro['profile_picture'] != ''){
										$profile_picture = base_url() . profile . "original/" .$pro['profile_picture'];	
									} elseif($pro['facebook_id'] != ''){
										$profile_picture = 'https://graph.facebook.com/'.$pro['facebook_id'].'/picture?type=large';
									} elseif($pro['twitter_id'] != ''){
										$profile_picture = 'https://twitter.com/'.$pro['username'].'/profile_image?size=original';     
									} elseif($pro['google_id'] != ''){
										$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$pro['google_id'].'?alt=json');
										$d = json_decode($data);
										$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
									}
								?>
									<img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
										 <a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a>                                            					 
								</div>
								<div class="price">
									<span>AED <?php echo number_format($pro['product_price']); ?></span>
								</div>
								</div>
								<div class="count-img">
									<i class="fa fa-image"></i><span><?php echo $pro['cntimg']+$pro['main']; ?></span>
								</div>
								<?php if($pro['product_is_sold']!=1) { ?>
									<?php if($is_logged!=0){ ?>
									<?php if(@$pro['product_total_favorite'] != 0){ ?>
									<div class="star fav" ><a href="#">
											<i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"  id="<?php echo $pro['product_id']; ?>"></i>
										</a></div>
									<?php } else { ?>
									<div class="star" ><a href="#" id="<?php echo $pro['product_id']; ?>">
											<i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>" ></i>
										</a></div>
									<?php }
									} else { ?>

									<div class="star" ><a href="<?php echo base_url() .'login/index'; ?>" id="<?php echo $pro['product_id']; ?>">
											<i class="fa fa-star-o"  id="<?php echo $pro['product_id']; ?>"></i>
										</a></div>
									<?php } ?>
									<?php } ?>
						</div>
					</div>
                </div>
				<?php  } ?>
              </div>
			  <div class="customNavigation">
				<a class="prev" id="demo1_prev"><span class="fa fa-chevron-circle-left"></span></a>
				<a class="next" id="demo1_next"><span class="fa fa-chevron-circle-right"></span></a>
			  </div>
              </div> -->
			 <div role="tabpanel" class="tab-pane <?php echo $active2; ?>" id="latest_tab">								
				<div id="owl-demo2" class="owl-carousel">
					<?php foreach ($latest_product as $pro) {  ?>
                <div class="item ">
					<div class="col-sm-12">
						<div class="item-sell">
                                    <div class="item-img">
										<?php if ($pro['mytag']=="SOLD"){ ?>
										<div class="sold"><span>SOLD</span></div>
										<?php } ?>

										<a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>"  class="img-responsive center-block" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'" /></a>
                                    </div>
                            
							<div class="item-disc">
								 <a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>">
								<?php  $len	=	strlen($pro['product_name']); ?>	
								<h4 <?php if($len>17){ echo 'title="'.$pro['product_name'].'"'; } ?> >
								<?php  echo $pro['product_name']; 	?></h4>
								</a>
								<?php 
									$str	=	str_replace('\n', " ", $pro['catagory_name']);
									$len	=	strlen($str);
								?>
								<small <?php if($len>25){ echo 'title="'.$str.'"'; } ?>>
								<?php echo $str; ?>
								</small>
							</div>
							  <div class="cat_grid">
								<?php $profile_picture = '';
									if($pro['profile_picture'] != ''){
										$profile_picture = base_url() . profile . "original/" .$pro['profile_picture'];	
									}
									elseif($pro['facebook_id'] != ''){
										$profile_picture = 'https://graph.facebook.com/'.$pro['facebook_id'].'/picture?type=large';
									}elseif($pro['twitter_id'] != ''){
										$profile_picture = 'https://twitter.com/'.$pro['username'].'/profile_image?size=original';     
									}
									elseif($pro['google_id'] != ''){
										$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$pro['google_id'].'?alt=json');
										$d = json_decode($data);
										$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
									}
								?>
									<div class="by-user">
										<img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
											 <a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a>                                            
									</div>
									<div class="price">
										<span>AED <?php echo number_format($pro['product_price']); ?></span>
									</div>
								</div>
								<div class="count-img">
									<i class="fa fa-image"></i><span><?php echo $pro['cntimg']+$pro['main']; ?></span>
								</div>
								<?php if($pro['product_is_sold']!=1) { ?>
								<?php if($is_logged!=0){ ?>
								<?php if(@$pro['product_total_favorite'] != 0){ ?>
								<div class="star fav" ><a href="#">
										<i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
									</a></div>
								<?php } else { ?>
								<div class="star" ><a href="#">
										<i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
									</a></div>
								<?php }
								} else { ?>

								<div class="star" ><a href="<?php echo base_url() .'login/index'; ?>">
										<i class="fa fa-star-o"></i>
									</a></div>
								<?php } ?>
								<?php } ?>
						</div>
					</div>
                </div>
				<?php  } ?>
              </div>
			  <div class="customNavigation">
				<a class="prev" id="demo2_prev"><span class="fa fa-chevron-circle-left"></span></a>
				<a class="next" id="demo2_next"><span class="fa fa-chevron-circle-right"></span></a>
			  </div>
				</div>
                    </div>
                        </div>
                                <div class="col-sm-4">
                                    <div class="ad-banner-square home_sidebar_banner">
                                        <?php									
                                        if(!empty($feature_banners)){ ?>

                                        <a href="<?php echo $feature_banners[0]['site_url']; ?>" target="_blank" onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name'] ?>" width="100%" class="img-responsive center-block"/ ></a>
                                        <?php   }else{
                                        ?>
                                        <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/ad1.jpg" class="img-responsive center-block" /></a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="ad-banner">
                                        <?php
                                        if(!empty($between_banners)){ 

                                        ?>

                                        <a href="<?php echo $between_banners[0]['site_url']; ?>" target="_blank" onclick="javascript:update_count('<?php echo $between_banners[0]['ban_id']; ?>')"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $between_banners[0]['big_img_file_name'] ?>" width="100%" class="img-responsive center-block" /></a>
                                        <?php   }else{

                                        ?>
                                        <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/ad2.jpg" class="img-responsive center-block" /></a>
                                        <?php } ?>


                                    </div>
                                </div>
                            </div>

                            <!--//ad block-->

                            <!--//row-->


                            <!--Most Viewed product items-->
                            <div class="row most-viewed">
                                <div class="col-sm-12" id="most-viewed">
                                    <h3>Most Viewed Ads</h3>
                                    <!--item1-->
                                    <?php if (!empty($most_viewed_product)){
                                    // echo "<pre>"; print_r($most_viewed_product); die;
                                    foreach ($most_viewed_product as $pro) {

                                    ?>
                                    <div class="col-md-3 col-sm-4">
                                        <div class="item-sell">
                                            <div class="item-img">
											   <?php if($pro['product_is_sold']==1) { ?>
											   <div class="sold"><span>SOLD</span></div>
											   <?php } ?>
                                                <?php if (!empty($pro['product_image'])): ?>
                                                <a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive center-block" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'" /></a>
                                                <?php endif; ?>

                                            </div>
                                            <div class="item-disc">
                                                <a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>">												
												<?php  $len	=	strlen($pro['product_name']); ?>	
												<h4 <?php if($len>21){ echo 'title="'.$pro['product_name'].'"'; } ?> >
												<?php
														 echo $pro['product_name']; 							
												?>
												</h4></a>
												<?php 
													$str	=	str_replace('\n', " ", $pro['catagory_name']);
													$len	=	strlen($str);
												?>
												<small <?php if($len>28){ echo 'title="'.$str.'"'; } ?>>
												<?php
														echo $str; ?>
												</small>												
                                            </div>
                                            <div class="cat_grid">
												<?php $profile_picture = '';
													if($pro['profile_picture'] != ''){
														$profile_picture = base_url() . profile . "original/" .$pro['profile_picture'];	
													}
													elseif($pro['facebook_id'] != ''){
														$profile_picture = 'https://graph.facebook.com/'.$pro['facebook_id'].'/picture?type=large';
													}elseif($pro['twitter_id'] != ''){
														$profile_picture = 'https://twitter.com/'.$pro['username'].'/profile_image?size=original';     
													}
													elseif($pro['google_id'] != ''){
														$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$pro['google_id'].'?alt=json');
														$d = json_decode($data);
														$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
													}
												?>
                                                <div class="by-user">
                                                    <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
                                                         <a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a>                                            
                                                </div>
                                                <div class=" price">
                                                    <span>AED <?php echo number_format($pro['product_price']); ?></span>
                                                </div>
                                            </div>
                                            <div class="count-img">
                                                <i class="fa fa-image"></i><span><?php echo $pro['cntimg']+$pro['main']; ?></span>
                                            </div>

											<?php if($pro['product_is_sold']!=1) { ?>	
												<?php if($is_logged!=0){ ?>
												<?php if(@$pro['product_total_favorite'] != 0){ ?>
												<div class="star fav" ><a href="#" id="<?php echo $pro['product_id']; ?>">
														<i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
													</a></div>
												<?php } else { ?>
												<div class="star" ><a href="#">
														<i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
													</a></div>
												<?php }
												} else { ?>

												<div class="star" ><a href="<?php echo base_url() .'login/index'; ?>">
														<i class="fa fa-star-o"></i>
													</a></div>
												<?php } ?>
                                            <?php } ?>

                                        </div>
                                    </div>

                                    <?php } }   ?>

                                </div>
                                <?php if(@$hide == "false"){?>
                                <div class="col-sm-12 text-center" id="load_more">
                                    <button class="btn btn-blue" onclick="load_more_product();" id="load_product" value="0">Load More</button>
									<br><br><br><br>
                                </div>
                                <?php } ?>
                            </div>
                            <!--End Most Viewed product items-->

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
			<div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-md">
					<div class="modal-content rounded">
						<div class="modal-header text-center orange-background">
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">
								<i class="fa fa-close"></i>
							</button>
							<h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
						</div>
						<div class="modal-body">
							
						</div>
						<div class='alert alert-info alert-dismissable'>						
								<center><span id="error_msg" ></span></center>                        					
						</div>
					</div>
				</div>
			</div>		
			 
            <!--footer-->
            <?php $this->load->view('include/footer'); ?>
            <!--//footer-->
        </div>	
		
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/owl.carousel.js"></script>
		
<script type="text/javascript">
    $(document).ready(function() {		
	
	
	
	     var carousel = $("#owl-demo");
		  carousel.owlCarousel({
			navigation:true,
			navigationText: [
			  "<i class='icon-chevron-left icon-white'><</i>",
			  "<i class='icon-chevron-right icon-white'>></i>"
			  ],
		  });

			//featured ads
			var owl = $("#owl-demo1");	
			owl.owlCarousel({
			  autoPlay: 2000,
			  items : 3,
			  navigation:true,
			  itemsDesktop : [1000,3],
			  itemsDesktopSmall : [900,2],
			  itemsTablet: [600,1],
			  itemsMobile : false ,
			  navigation:true,
					
			});
				
			  $("#demo1_next").click(function(){
				owl.trigger('owl.next');
			  })
			  $("#demo1_prev").click(function(){
				owl.trigger('owl.prev');
			  })
			
			//latest ads
			var owl1 = $("#owl-demo2");
			owl1.owlCarousel({
			  autoPlay: 2000,
			  items : 3,
			  itemsDesktop : [1000,3],
			  itemsDesktopSmall : [900,2],
			  itemsTablet: [600,1],
			  itemsMobile : false 
			});	
			
			  $("#demo2_next").click(function(){
				owl1.trigger('owl.next');
			  })
			  $("#demo2_prev").click(function(){
				owl1.trigger('owl.prev');
			  })	
			 
			});

					 

					$('#myTabs a').click(function(e) {

						e.preventDefault()
						$(this).tab('show')
					})

					function update_count(a)
					{
						var url = "<?php echo base_url() ?>home/update_click_count";
						$.post(url, {ban_id: a}, function(response)
						{
						}, "json");
					}


					function load_more_product() {
						$body = $("body");
						$body.addClass("loading");
						var url = "<?php echo base_url() ?>home/show_more_product";
						var start = $("#load_product").val();
						start++;
						$("#load_product").val(start);
						var val = start;
						$('#loading').show();
						$.post(url, {value: val}, function(response)
						{
							$("#most-viewed").append(response.html);
							if (response.val == "true") {
								$("#load_product").hide();
							}
							$('#loading').hide();
						}, "json");
					}

			$('div.star a i').click(function(e) {	
			
			<?php if($is_logged!=0){ ?>	
				e.preventDefault();
				var url = "<?php echo base_url() ?>home/add_to_favorites";
				var fav = 0;
				var id = $(this).attr('id');
				//alert(id);
				console.log(id);
				if ($(this).hasClass('fa-star-o')) {
					$(this).closest('div').addClass('fav');
					$(this).removeClass("fa-star-o");
					$(this).addClass("fa-star");
					fav = 1;
				} else if ($(this).hasClass('fa-star')) {
					$(this).closest('div').removeClass('fav');
					$(this).addClass("fa-star-o");
					$(this).removeClass("fa-star");
					fav = -1;
				}

				$.post(url, {value: fav, product_id: id}, function(response)
				{    
					
					if(response.trim()=='Success' ||  response.trim()=='failure')
						$('#err_div').hide();
					else
					{
						$("#send-message-popup").modal('show');
						$('#err_div').show();
						$("#error_msg").text(response);					
					}
				});				
				<?php } else { ?>										
				window.location="<?php echo base_url(); ?>";
				<?php } ?>
		});        
        </script>
        <!--container-->
    </body>
</html>
