<div class="col-sm-12" id="most-viewed">
	  <?php 
	  //print_r($_REQUEST);
	  if (!empty($listing)){
			   foreach ($listing as $pro) {				  
				?>
	<div class="col-md-3 col-sm-4">
	  <div class="item-sell item-sell<?php echo $pro['product_id'];?>" >
		<input type="hidden" id="myprod" value="<?php echo $pro['product_id'];?>">
		  <div class="item-img">
			<?php if($pro['product_is_sold']==1) { ?>
				<div class="sold"><span>SOLD</span></div>
			<?php } ?>
				<?php //if (!empty($pro['product_image'])): ?>
								<a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" alt="Image" /></a>
				 <?php //endif; ?>
			  
			</div>
			<div class="item-disc">
			  <a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><h4><?php echo $pro['product_name']; ?></h4></a>
			  <small><?php echo str_replace('\n', " ", $pro['catagory_name']); ?></small>
			</div>
			<div class="row" style="min-height: 60px;">
				<div class="by-user col-xs-12">
				<?php $profile_picture = base_url() . profile . "original/" .$current_user->profile_picture;
						if($current_user->facebook_id != ''){
						  $profile_picture = 'https://graph.facebook.com/'.$current_user->facebook_id.'/picture';
						}
				?>
<img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" alt="Profile Image" />                                                
					<a href="#"><?php echo $pro['username1']; ?></a>                                            
				</div>
				<div class="col-xs-12 price">
					<span>AED <?php echo number_format($pro['product_price']); ?></span>
				</div>
			</div>
			<div class="count-img">
			  <i class="fa fa-image"></i><span><?php echo $pro['cntimg']+$pro['main']; ?></span>
			</div>
			<?php if($pro['product_is_sold']!=1) { ?>
			<div class="edit_option"><i class="fa fa-pencil-square-o"></i>
			  <div class="tip" style="">
				  <ul class="options_list">  
					<?php if($_REQUEST['val']=='Approve' || $_REQUEST['val']=='NeedReview'): ?>
					<li id="edit<?php echo $pro['product_id'];?>"><a href="<?php echo site_url().'user/listings_edit/'.$pro['product_id']; ?>"><i><img src="<?php echo site_url(); ?>assets/front/images/edit.png" alt="Image"></i>Edit</a></li>
					<?php endif; ?>
					<?php //if($_REQUEST['val']=='NeedReview'): ?>
					<!--<li class="star"><a href="#"><i><img src="<?php //echo site_url(); ?>assets/front/images/repost.png"></i>Repost</a></li>-->
					<?php //endif; ?>
					<?php if($_REQUEST['val']=='Approve') { ?>
					<li id="mynew1<?php echo $pro['product_id'];?>" class="mark_sold"><a href="<?php echo site_url(); ?>user/mark_sold/<?php echo  $pro['product_id']; ?>"><i><img src="<?php echo site_url(); ?>assets/front/images/sold.png" alt="Image"></i>Mark Sold</a></li>
					<?php  } ?>
					
					<li id="mynew1<?php echo $pro['product_id'];?>"><a href="#" onclick="javascript:deleteproduct('<?php echo $pro['product_id']; ?>');"><i><img src="<?php echo site_url(); ?>assets/front/images/delete.png" alt="Image" ></i>Delete</a></li>
					
					<?php if($_REQUEST['val']=='Approve') { ?>
					<li id="mynew1<?php echo $pro['product_id'];?>"><a href="#"><i><img src="<?php echo site_url(); ?>assets/front/images/boost.png" alt="Image"></i>Boost</a><font color="white">(Coming Soon)</font></li>
					<?php } ?>
				  </ul>
				</div>
			</div>       
		<?php } ?>			
		</div>
	</div>                                 
	  <?php } } else{
		  echo "<h5>&nbsp;No product found.</h5>";
	  }   ?>

</div>               