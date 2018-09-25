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
                    	<!--row-->
                    	<div class="row latest">
                        
                        </div>
                        <!--//row-->
                        <!--Most Viewed product items-->
                        <div class="row most-viewed">
                            <div class="col-sm-12" id="most-viewed">
                            	<h3>Search Result</h3>
								
								<?php 								
								if(isset($_REQUEST['search'])) { ?>
								<input type="hidden" name="getdata" id="getdata" value="<?php print_r($_REQUEST); ?>">	
								
								<input type="hidden" name="cat1" id="cat1" value="<?php echo $_REQUEST['cat']; ?>">	
								<input type="hidden" name="sub_cat1" id="sub_cat1" value="<?php echo $_REQUEST['sub_cat']; ?>">
								<input type="hidden" name="location" id="location" value="<?php echo $_REQUEST['location']; ?>">
								
								<input type="hidden" name="city1" id="city1" value="<?php echo $_REQUEST['city']; ?>">	
								<input type="hidden" name="min_amount1" id="min_amount1" value="<?php echo $_REQUEST['min_amount']; ?>">
								<input type="hidden" name="max_amount1" id="max_amount1" value="<?php echo $_REQUEST['max_amount']; ?>"> 
								
								<?php }  ?>
								
								<?php if(isset($_REQUEST['search_value'])) { ?>
                                <input type="hidden" name="search_value1" id="search_value1" value="<?php echo $_REQUEST['search_value']; ?>">
								<?php  } ?>	
                                 <!--item1-->
                                  <?php if (!empty($product)){
                                           foreach ($product as $pro) {
                                              // echo "<pre>"; print_r($most_viewed_product); die;
                                            
                                            ?>
                                <div class="col-md-3 col-sm-4">
                                	<div class="item-sell">
                                    	<div class="item-img">
											<?php if($pro['product_is_sold']==1) { ?>
													<div class="sold"><span>SOLD</span></div>
											<?php } ?>
                                            <?php if (!empty($pro['product_image'])): ?>
                                                            <a href="<?php echo  base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'"/></a>
                                             <?php endif; ?>
                                        	
                                        </div>
                                        <div class="item-disc">
	                                        <a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>">
											<?php  $len	=	strlen($pro['product_name']); ?>	
											<h4 <?php if($len>21){ echo 'title="'.$pro['product_name'].'"'; } ?> >
												<?php 																	
													$len	=	strlen($pro['product_name']);
													 if($len>21) 	
														echo substr($pro['product_name'],0,21).'...';
													 else
														 echo $pro['product_name']; 							
												?>
												</h4></a>
												<?php 
													$str	=	str_replace('\n', " ", $pro['catagory_name']);
													$len	=	strlen($str);
												?>
												<small <?php if($len>32){ echo 'title="'.$str.'"'; } ?>>
												<?php 																	
													 if($len>32) 	
														echo substr($str,0,32).'...';
													 else
														echo $str; ?>
												</small>	
                                        </div>
                                        <div class="row" style="min-height: 60px;">
                                            <div class="by-user col-sm-12">
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
                                                <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"/>
                                                <a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a>                                            
                                            </div>
                                            <div class="col-sm-12 price">
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
                                 
                                  <?php } } else{
                                      echo "<h5>No product found in this category</h5>";
                                  }   ?>

                            </div>
                            <div class="col-sm-12 text-center" id="load_more"></div>
								<?php if(@$hide == "false"){  ?>
								<div class="col-sm-12 text-center" >
									<button class="btn btn-blue" onclick="load_more_product();" id="load_product" value="0">Load More</button><br><br><br>
								</div>
								<?php } ?>	
                        </div>
                      <!--End Most Viewed product items-->
                        
                    </div>
                    <!--//content-->
                </div>
            </div>
            <!--//main-->
            <div id="loading" style="text-align:center">
                 <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
           </div>
            
            
            
        </div>
        <!--//body-->
        
        <!--footer-->
            <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>
<script type="text/javascript">
	function load_more_product() 
	{
		$body = $("body");
		$body.addClass("loading");
		var url = "<?php echo base_url() ?>home/more_search";
		var start = $("#load_product").val();
		start++;
		$("#load_product").val(start);
		var val = start;
		var cat1				=	$("#cat1").val();
		var sub_cat1			=	$("#sub_cat1").val();
		var location			=	$("#location").val();
		var city1				=	$("#city1").val();
		var min_amount1			=	$("#min_amount1").val();
		var max_amount1			=	$("#max_amount1").val();
		var search_value1		=	$("#search_value1").val();
		$('#loading').show();		
		 $.post(url, {value: val,cat1:cat1,sub_cat1:sub_cat1,city1:city1,min_amount1:min_amount1,max_amount1:max_amount1,search_value1:search_value1,location:location}, function(response)
		 {
			$("#load_more").append(response.html);
			//alert(response.val);
			 if (response.val == "true") {
				 $("#load_product").hide();
			 }
			 $('#loading').hide();
		 }, "json");
	}	

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
		
		$.post(url, {value: fav,product_id:id}, function(response)
		{   
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
