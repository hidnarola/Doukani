 <?php $flag = 1;
                              if (!empty($product)){
                                      foreach ($product as $pro) {
                                           if($flag == 3){ ?>
                                            
                                          <div class="col-sm-12 no-padding">
                                            <a href="#"><img src="<?php echo base_url();?>assets/front/images/ad2.jpg" class="img-responsive" width="100%" style=" margin-bottom:30px;"></a>
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
                                        <?php if (!empty($pro['product_image'])): ?>
                                               <img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'" />
                                             <?php endif; ?>
                                        <div class="count-img">
                                        	<i class="fa fa-image"></i><span><?php echo $pro['cntimg']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 info-holder">
                                     <?php //if(@$pro['product_total_favorite'] != 0){ ?>
                                       <!-- <div class="star fav" ><a href="#">
                                           <i class="fa fa-star" id="<?php //echo $pro['product_id']; ?>"></i>
                                          </a></div> -->
                                        <?php //} else { ?>
                                        <!--<div class="star" ><a href="#">
                                         <i class="fa fa-star-o" id="<?php //echo $pro['product_id']; ?>"></i>
                                        </a></div>-->
                                     <?php //} ?>
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
                                                        <div class="col-sm-4 col-md-3"><span>Year :</span> <?php echo @$pro['year']; ?></div>
                                                    <?php } if(@$pro['colorname']){?>
                                                        <div class="col-sm-4 col-md-3"><span>Color : </span><?php echo @$pro['colorname']; ?></div>
                                                    <?php } if(@$pro['mileagekm']){?>
                                                        <div class="col-sm-4 col-md-3"><span>KM : </span><?php echo @$pro['mileagekm']; ?></div>
                                                    <?php }if(@$pro['model']){ ?>
                                                        <div class="col-sm-4 col-md-3"><span>Model : </span><?php echo @$pro['model']; ?></div>
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
                                      
                                        <div class="by-user col-sm-6 padding5">
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
                                        <div class="col-sm-6 padding5 text-right">
                                        	<a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>" class="btn mybtn">View</a>
                                        </div>
                                    </div>
                                </div>
                            <!--//item-->
                              <?php } } ?>
	<script>

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