<div class="col-sm-12 list-item"><div class="col-sm-3 img-holder"><?php if($pro['product_is_sold']==1) { ?><div class="sold"><span>SOLD</span></div><?php } ?><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/No_Image.png'"/><div class="count-img"><i class="fa fa-image"></i><span><?php echo $pro['cntimg']+$pro['main']; ?></span></div></div><div class="col-sm-9 info-holder"><?php if($pro['product_is_sold']!=1) { ?><?php if($is_logged!=0){ ?><?php if(@$pro['product_total_favorite'] != 0){ ?><div class="star fav" ><a href="#"><i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i></a></div><?php } else { ?><div class="star" ><a href="#"> <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i></a></div><?php }} else { ?>   <div class="star" ><a href="<?php echo base_url() .'login/index'; ?>"><i class="fa fa-star-o"></i></a></div><?php } ?><?php } ?><div class="col-sm-6"><a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><h3><?php echo $pro['product_name']; ?></h3></a><small><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></small></div><div class="col-sm-6 price padding-r50"><h4>AED <?php echo number_format($pro['product_price']); ?></h4></div><div class="infobar col-sm-12">
<?php if($category_id == 7){?>     <?php if(@$pro['year'] != ""){?>
		<div class="col-sm-4 col-md-2">Year : <?php echo @$pro['year']; ?></div><?php } if(@$pro['colorname']){?><div class="col-sm-4 col-md-3">Color : <?php echo @$pro['colorname']; ?></div><?php } if(@$pro['mileagekm']){?><div class="col-sm-4 col-md-3">KM : <?php echo @$pro['mileagekm']; ?></div><?php }if(@$pro['model']){ ?><div class="col-sm-4 col-md-2">Model : <?php echo @$pro['mname']; ?></div><?php } if(@$pro['type_of_car']){ ?><div class="col-sm-4 col-md-3">Type : <?php echo @$pro['type_of_car']; ?></div><?php }if(@$pro['make']){ ?><div class="col-sm-4 col-md-3">Make : <?php echo @$pro['make']; ?></div><?php } ?><?php } 




else if($category_id == 8){?><?php if(@$pro['Country'] != ""){?><div class="col-sm-4 col-md-3">Country : <?php echo @$pro['Country']; ?></div><?php } if(@$pro['Emirates']){?><div class="col-sm-4 col-md-3">Emirates : <span><?php echo @$pro['Emirates']; ?></span></div><?php } if(@$pro['PropertyType']){?><div class="col-sm-4 col-md-3">Property Type : <span><?php echo @$pro['PropertyType']; ?></span></div><?php }if(@$pro['Bathrooms']){ ?><div class="col-sm-4 col-md-3">Bathrooms : <span><?php echo @$pro['Bathrooms']; ?></span></div><?php } if(@$pro['Bedrooms']){ ?><div class="col-sm-4 col-md-3">Bedrooms : <span><?php echo @$pro['Bedrooms']; ?></span></div><?php }if(@$pro['Area']){ ?><div class="col-sm-4 col-md-3">Area : <span><?php echo @$pro['Area']; ?></span></div><?php }if(@$pro['Amenities']){ ?><div class="col-sm-4 col-md-3">Amenities : <span><?php echo @$pro['Amenities']; ?></span></div><?php } ?><?php } ?></div><div class="by-user col-sm-6 padding5"><img src="<?php echo base_url() . profile . "original/" . $pro['profile_picture']; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" /><a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>"><?php echo $pro['username1']; ?></a></div><div class="col-sm-6 padding5 text-right"><a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>" class="btn mybtn">View</a></div></div></div>	


<img src="http://localhost:81/classified_application/assets/upload/product/medium/Thumb_VEHNI990XR.jpeg" class="img-responsive" onerror="this.src="http://localhost:81/classified_application/assets/upload/No_Image.png"/>



aazk
94ece395780660e05c073d959ad27f17
94ece395780660e05c073d959ad27f17


payal
64d8a47c30f84958c2cc2181e9382f35



