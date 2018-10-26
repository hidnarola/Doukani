<html>
<head>
     <?php $this->load->view('include/head'); ?>
</head>
<?php
 if(@$subcat_id == "")
   $subcat_id = 0;
                                         
?>
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
            <div class="col-sm-12 main category-grid">
		    <div class="row">
                    <!--cat-->
                   <?php $this->load->view('include/left-nav'); ?>
                    <!--//cat-->
                    <!--content-->
                    <div class="col-sm-10">
                      <!--row-->
                      <div class="row subcat-div">
                          <div class="col-sm-8">
                            <?php $this->load->view('include/breadcrumb'); ?>
                            <span class="result"><?php echo @$subcat_name?@$subcat_total:$total; ?> Results</span>
                            </div>
                            <div class="col-sm-4 text-right views">
                            	<a href="<?php echo  base_url();?>home/category/<?php echo $category_id; ?><?php echo ($sub_category_id != '' || $sub_category_id != null) ? '/'.$sub_category_id : ''; ?>" class="view-active"><span class="fa  fa-th"></span></a>
                                <a href="<?php echo  base_url();?>home/category_listing/<?php echo $category_id; ?><?php echo ($sub_category_id != '' || $sub_category_id != null) ? '/'.$sub_category_id : ''; ?>"><span class="fa  fa-th-list"></span></a>
                                <a href="<?php echo  base_url();?>home/category_map/<?php echo $category_id; ?><?php echo ($sub_category_id != '' || $sub_category_id != null) ? '/'.$sub_category_id : ''; ?>"><span class="fa  fa-map-marker"></span></a>
                            </div>
                            <div class="col-sm-12">
                            	<div class="col-sm-12 no-padding-xs">
                                    <div class="col-sm-12 subcats">
                                     
                                       <?php foreach ($subcat as $sub){ ?>
                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                            <!--<a href="<?php echo  current_url();?>?subcat=<?php echo $sub['id']; ?>"><?php echo $sub['name'];?><span class="count">(<?php echo $sub['total'];?>)</span></a>-->
                                            <a href="<?php echo  base_url();?>home/category/<?php echo $category_id."/".$sub['id']; ?>"><?php echo $sub['name'];?> <span class="count">(<?php echo $sub['total'];?>)</span></a>
                                        </div>
                                       <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!--Product-->
                           <!--//-->
                        <div class="row">
                            <div class="col-sm-12 catlist">
                                
                                <?php $flag = 1;
								
                                    if (!empty($product)){
                                      foreach ($product as $pro) {
                                         if($flag == 5){ ?>
                                            
                                          <div class="col-sm-12">
                                            <div class="ad-banner1">
                                              <?php											 
                                                if(!empty($between_banners)){ ?>
													
                                                <a href="<?php echo $between_banners[0]['site_url']; ?>" target="_blank" onclick="javascript:update_count('<?php echo $between_banners[0]['ban_id']; ?>')"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $between_banners[0]['big_img_file_name'] ?>" width="100%" class="img-responsive center-block" /></a>
                                             <?php   }else{
											
                                             ?>
                                          <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/ad2.jpg" class="img-responsive center-block" /></a>
                                            <?php } ?>
                                             
                                              
                                            </div>
                                          </div>
                                        <?php } 
                                        $flag++;
                                 ?>
                              
                                <!--item1-->
                                <div class="col-md-3 col-sm-4">
                                	<div class="item-sell">
                                    	<div class="item-img">
										<?php if($pro['product_is_sold']==1) { ?>
											<div class="sold"><span>SOLD</span></div>
										<?php } ?>
                                            <a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'" /></a>
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
												<small <?php if($len>28){ echo 'title="'.$str.'"'; } ?>>
												<?php 																	
													 if($len>28) 	
														echo substr($str,0,28).'...';
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
                                                  <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
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
                                <!--//item1-->
                                <?php }   } else{
                                      echo "<h5>No product found in this category</h5>";
                                      
                                 }  ?>
                                 <!--item1-->
                                								
                            <?php if(@$hide == "false"){?>
                                 <div class="col-sm-12 text-center" id="load_more">
                                    <button class="btn btn-blue" onclick="load_more_category();" id="load_product" value="0">Load More</button><br><br><br>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                        <!--//-->
                      <!-- end product --> 
                    </div>
                    <!--//content-->
                </div>
            </div>
            <!--//main-->
            
        </div>
        <!--//body-->
         <div id="loading" style="text-align:center">
                 <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." "/>
          </div>
        <!--footer-->
            <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>
    
<!--container-->

<script type="text/javascript">

		function update_count(a)
		{
			var url = "<?php echo base_url() ?>home/update_click_count";   
            $.post(url, {ban_id: a}, function(response)
            { }, "json");
		}

       function load_more_category(){
			$body = $("body");
            $body.addClass("loading");
            var url = "<?php echo base_url() ?>home/load_more_category/<?php echo $category_id."/".@$subcat_id; ?>";
            var start = $("#load_product").val();
            start++;
            $("#load_product").val(start);
            var val = start;
			 $('#loading').show();
            $.post(url, {value: val}, function(response)
            {   
                $("#load_more").before(response.html);
                if(response.val == "true"){
                    $("#load_product").hide();
                }
				$('#loading').hide();
            }, "json");
        }
        
      
    
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
            
            $.post(url, {value: fav,product_id:id}, function(response)
            {   
                //console.log(response);
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
</body>
</html>
