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
								<input type="hidden" value="<?php print_r($_REQUEST); ?>">
								<input type="hidden" name="cat_id" id="cat_id" value="<?php echo $_POST['cat_id']; ?>">
								<input type="hidden" name="sub_cat" id="sub_cat" value="<?php echo $_POST['sub_cat']; ?>">
								<input type="hidden" name="location1" id="location1" value="<?php echo $_POST['location']; ?>">
								<input type="hidden" name="city" id="city" value="<?php echo $_POST['location']; ?>">
								<input type="hidden" name="from_price" id="from_price" value="<?php echo $_POST['from_price']; ?>">
								<input type="hidden" name="to_price" id="to_price" value="<?php echo $_POST['to_price']; ?>">
								<?php 									
									if(isset($_REQUEST['default'])){}							
									elseif(isset($_REQUEST['vehicle_submit']))
									{
										?>
										<input type="hidden" name="pro_brand" id="pro_brand" value="<?php echo $_POST['pro_brand']; ?>">	
										<input type="hidden" name="vehicle_pro_model" id="vehicle_pro_model" value="<?php echo $_POST['vehicle_pro_model']; ?>">	
										<input type="hidden" name="vehicle_pro_year" id="vehicle_pro_year" value="<?php echo $_POST['vehicle_pro_year']; ?>">	
										<input type="hidden" name="vehicle_pro_mileage" id="vehicle_pro_mileage" value="<?php echo $_POST['vehicle_pro_mileage']; ?>">	
										<input type="hidden" name="vehicle_pro_color" id="vehicle_pro_color" value="<?php echo $_POST['vehicle_pro_color']; ?>">											
										<?php
									}
									elseif(isset($_REQUEST['real_estate_submit']))
									{ 
									?>
										<input type="hidden" name="furnished" id="furnished" value="<?php echo $_POST['furnished']; ?>">
										<input type="hidden" name="bedrooms" id="bedrooms" value="<?php echo $_POST['bedrooms']; ?>">
										<input type="hidden" name="bathrooms" id="bathrooms" value="<?php echo $_POST['bathrooms']; ?>">
										<input type="hidden" name="pets" id="pets" value="<?php echo $_POST['pets']; ?>">
										<input type="hidden" name="broker_fee" id="broker_fee" value="<?php echo $_POST['broker_fee']; ?>">
										<?php if(isset($_POST['houses_free'])):  ?>
										<input type="hidden" name="houses_free" id="houses_free" value="<?php echo $_POST['houses_free']; ?>">
										<?php endif; ?>
									  <?php	
									}
									elseif(isset($_REQUEST['shared_submit']))
									{
										 if(isset($_POST['shared_free'])):  ?>
										<input type="hidden" name="shared_free" id="shared_free" value="<?php echo $_POST['shared_free']; ?>">
										<?php endif; 
									}
								?>
                        </div>
                        <!--//row-->
                        <!--Most Viewed product items-->
                        <div class="row most-viewed">
                            <div class="col-sm-12" id="most-viewed">
                            	<h3>Search Result</h3>
                               
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
	                                        <a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><?php  $len	=	strlen($pro['product_name']); ?>	
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
												<small <?php if($len>28){ echo 'title="'.$str.'"'; } ?>>
												<?php 																	
													 if($len>28) 	
														echo substr($str,0,28).'...';
													 else
														echo $str; ?>
												</small>	
                                        </div>
                                        <div class="row" style="min-height: 60px;">
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
                                            <div class="by-user col-sm-12">
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
		
		 function load_more_product() {
			
			$body = $("body");
			$body.addClass("loading");	
		 
			var url = "<?php echo base_url() ?>home/load_more_advanced_search";
			var start = $("#load_product").val();
			start++;
			$("#load_product").val(start);
			$('#loading').show();		
			var val = start;
			var cat_id				=	$("#cat_id").val();
			var sub_cat				=	$("#sub_cat").val();
			var location1			=	$("#location1").val();
			var city				=	$("#city").val();
			var from_price			=	$("#from_price").val();
			var to_price			=	$("#to_price").val();
			var pro_brand			=	$("#pro_brand").val();
			var vehicle_pro_model	=	$("#vehicle_pro_model").val();
			var vehicle_pro_year	=	$("#vehicle_pro_year").val();
			var vehicle_pro_mileage	=	$("#vehicle_pro_mileage").val();
			var vehicle_pro_color	=	$("#vehicle_pro_color").val();
			var furnished			=	$("#furnished").val();
			var bedrooms			=	$("#bedrooms").val();
			var bathrooms			=	$("#bathrooms").val();
			var pets				=	$("#pets").val();
			var broker_fee			=	$("#broker_fee").val();
			var houses_free			=	$("#houses_free").val();
			var shared_free			=	$("#shared_free").val();
			
			 $.post(url, {value: val,cat_id:cat_id,sub_cat:sub_cat,location1:location1,city:city,from_price:from_price,to_price:to_price,pro_brand:pro_brand,vehicle_pro_model:vehicle_pro_model,vehicle_pro_year:vehicle_pro_year,vehicle_pro_mileage:vehicle_pro_mileage,vehicle_pro_color:vehicle_pro_color,furnished:furnished,bedrooms:bedrooms,bathrooms:bathrooms,pets:pets,broker_fee:broker_fee,houses_free:houses_free,shared_free:shared_free}, function(response)
			 {
				$("#load_more").append(response.html);
				//alert(response.val);
				 if (response.val == "true") {
					 $("#load_product").hide();
				 }
				 $('#loading').hide();
			 }, "json");
		}
</script>
<!--container-->
</body>
</html>
