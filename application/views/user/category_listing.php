<html>
<head>
     <?php $this->load->view('include/head'); ?>
</head>

<body>
  <?php
 if(@$subcat_id == "")
   $subcat_id = 0;
                                         
?>
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
                            	<a href="<?php echo  base_url();?>home/category/<?php echo $category_id; ?><?php echo ($sub_category_id != '' || $sub_category_id != null) ? '/'.$sub_category_id : ''; ?>"><span class="fa  fa-th"></span></a>
                                <a href="<?php echo  base_url();?>home/category_listing/<?php echo $category_id; ?><?php echo ($sub_category_id != '' || $sub_category_id != null) ? '/'.$sub_category_id : ''; ?>" class="view-active"><span class="fa  fa-th-list"></span></a>
                                <a href="<?php echo  base_url();?>home/category_map/<?php echo $category_id; ?><?php echo ($sub_category_id != '' || $sub_category_id != null) ? '/'.$sub_category_id : ''; ?>"><span class="fa  fa-map-marker"></span></a>
                            </div>
                            <div class="col-sm-12">
                            	<div class="col-sm-12 no-padding-xs">
                                    <div class="col-sm-12 subcats">
                                       <?php foreach ($subcat as $sub){ ?>
                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                            <a href="<?php echo  base_url();?>home/category_listing/<?php echo $category_id."/".$sub['id']; ?>"><?php echo str_replace('\n', " ", $sub['name']);?> <span class="count">(<?php echo $sub['total'];?>)</span></a>
                                        </div>
                                       <?php } ?>
                                        
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        
                        <div class="row">
                            <div class="col-sm-12 catlist">
                              <?php $flag = 1;
							  //print_r($product);
                              if (!empty($product)){
                                      foreach ($product as $pro) {
                                           if($flag == 3){ ?>
                                            
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
                                <div class="col-sm-12 list-item">
                                    <div class="col-sm-3 img-holder">
                                      <?php if($pro['product_is_sold']==1) { ?>
									  <div class="sold"><span>SOLD</span></div>
									  <?php } ?>
                                        <?php // if (!empty($pro['product_image'])): ?>
                                               <img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'"/>
                                             <?php //endif; ?>
                                        <div class="count-img">
                                        	<i class="fa fa-image"></i><span><?php echo $pro['cntimg']+$pro['main']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 info-holder">
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
                                        <div class="col-sm-6">
                                        	<a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><h3><?php echo $pro['product_name']; ?></h3></a>
                                        	<small><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></small>
                                        </div>
                                        <div class="col-sm-6 price padding-r50">
                                        	<h4>AED <?php echo number_format($pro['product_price']); ?></h4>
                                        </div>
                                       
                                        <div class="infobar col-sm-12">
                                             <?php if($category_id == 7){?>
                                                    <?php if(@$pro['year'] != ""){?>
                                                        <div class="col-sm-4 col-md-3"><span>Year : </span><?php echo @$pro['year']; ?></div>
                                                    <?php } if(@$pro['colorname']){?>
                                                        <div class="col-sm-4 col-md-3"><span>Color : </span><?php echo @$pro['colorname']; ?></div>
                                                    <?php } if(@$pro['mileagekm']){?>
                                                        <div class="col-sm-4 col-md-3"><span>KM : </span><?php echo @$pro['mileagekm']; ?></div>
                                                    <?php }if(@$pro['model']){ ?>
                                                        <div class="col-sm-4 col-md-3"><span>Model : </span><?php echo @$pro['mname']; ?></div>
                                                    <?php } if(@$pro['type_of_car']){ ?>
                                                        <div class="col-sm-4 col-md-3"><span>Type : </span><?php echo @$pro['type_of_car']; ?></div>
                                                    <?php }if(@$pro['make']){ ?>
                                                        <div class="col-sm-4 col-md-3"><span>Make : </span><?php echo @$pro['make']; ?></div>
                                                    <?php } ?>
                                            <?php } else if($category_id == 8){?>
                                                    <?php if(@$pro['Country'] != ""){?>
                                                        <div class="col-sm-4 col-md-3"><span>Country : </span><?php echo @$pro['Country']; ?></div>
                                                    <?php } if(@$pro['Emirates']){?>
                                                        <div class="col-sm-4 col-md-3"><span>Emirates : </span><?php echo @$pro['Emirates']; ?></div>
                                                    <?php } if(@$pro['PropertyType']){?>
                                                        <div class="col-sm-4 col-md-3"><span>Property Type : </span><?php echo @$pro['PropertyType']; ?></div>
                                                    <?php }if(@$pro['Bathrooms']){ ?>
                                                        <div class="col-sm-4 col-md-3"><span>Bathrooms : </span><?php echo @$pro['Bathrooms']; ?></div>
                                                    <?php } if(@$pro['Bedrooms']){ ?>
                                                        <div class="col-sm-4 col-md-3"><span>Bedrooms : </span><?php echo @$pro['Bedrooms']; ?></div>
                                                    <?php }if(@$pro['Area']){ ?>
                                                        <div class="col-sm-4 col-md-3"><span>Area : </span><?php echo @$pro['Area']; ?></div>
                                                    <?php }if(@$pro['Amenities']){ ?>
                                                        <div class="col-sm-4 col-md-3"><span>Amenities : </span><?php echo @$pro['Amenities']; ?></div>
                                                    <?php } ?>
                                            <?php } ?>
                                        </div>
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
                                        <div class="by-user col-sm-6 padding5">                                            
										<?php //echo base_url() . profile . "original/" . $pro['profile_picture']; ?>
                                             <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
                                             <a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a>                                           
                                        </div>
                                        <div class="col-sm-6 padding5 text-right">
                                        	<a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>" class="btn mybtn">View</a>
                                        </div>
                                    </div>
                                </div>
                            <!--//item-->
                            <?php }   } else{
                                      echo "<h5>No product found in this category</h5>";
                                      
                                 }  ?>
                          <?php if(@$hide == "false"){?>
                            <div class="col-sm-12 text-center" id="load_more">
                            	<button class="btn btn-blue" onclick="load_more_category_listing();" id="load_product" value="0">Load More</button><br><br><br>
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
                 <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
          </div>
            
        <!--footer-->
            <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>
 
<script type="text/javascript">

		function update_count(a)
		{
			var url = "<?php echo base_url() ?>home/update_click_count";   
            $.post(url, {ban_id: a}, function(response)
            { }, "json");
		}
		
       function load_more_category_listing(){
           $body = $("body");
           $body.addClass("loading");
            var url = "<?php echo base_url() ?>home/load_more_category_listing/<?php echo $category_id."/".@$subcat_id; ?>";
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
            var id = $("div.star a i").attr('id');
//            console.log(id);
			
             if($("#"+id).hasClass('fa-star-o')){
                  $("#"+id).closest('div').addClass('fav');
                 $("#"+id).removeClass("fa-star-o");
                 $("#"+id).addClass("fa-star");
                 fav = 1;
            }else if($("#"+id).hasClass('fa-star')){
                 $("#"+id).closest('div').removeClass('fav');
                 $("#"+id).addClass("fa-star-o");
                 $("#"+id).removeClass("fa-star");
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
<!--container-->
</body>
</html>
