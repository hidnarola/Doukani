<?php 
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
?>
<html>
<head>
	<meta property="og:type" content="article" />
    <meta property="og:site_name" content="Doukani" />
    <meta property="og:title" content="<?php echo $product->product_name; ?>" />
    <meta property="og:url" content="<?php echo $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
    <meta property="og:image" content="<?php echo $share_url; ?>" />
    <meta property="og:description" content="<?php echo $product->product_description; ?>" /> 
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="Doukani">
    <meta name="twitter:url" content="<?php echo $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>" />
    <meta name="twitter:title" content="<?php echo $product->product_name; ?>">
    <meta name="twitter:description" content="<?php echo $product->product_description; ?>">
    <meta name="twitter:image:src" content="<?php echo $share_url; ?>"> 
    <?php $this->load->view('include/head'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/gallery_assets/css/basic.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front/gallery_assets/css/galleriffic-2.css" type="text/css" />
    <link rel="image_src" href="<?php echo $share_url; ?>" />
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/gallery_assets/js/jquery.galleriffic.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/gallery_assets/js/jquery.opacityrollover.js"></script>
    <!-- We only want the thumbnails to display when javascript is disabled -->
	<script src="<?php echo base_url(); ?>assets/front/javascripts/googlemap.js"></script>
    <script type="text/javascript">
      document.write('<style>.noscript { display: none; }</style>');
    </script>
    <?php 
    $url = base_url() .'assets/upload/No_Image.png';
    $filename = document_root . product .'original/'. $product->product_image;

        if (file_exists($filename)) {
            $url = base_url() . 'assets/upload/product/original/' . $product->product_image;
        }
        $state_name = $product->state_name;
        if($product->state_name == '' )
            $state_name = 'Dubai';
     ?>
    <script>
    var lat='',lng='';
    var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': '<?php echo $state_name; ?>'}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                lat = results[0].geometry.location.lat();
                lng = results[0].geometry.location.lng();
            }
        });
	function initialize() {
           var myLatlng = new google.maps.LatLng(lat,lng);
           var mapOptions = {
             zoom: 7,
             center: myLatlng
           };

           var map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

           var marker = new google.maps.Marker({
               position: myLatlng,
               map: map
           });
           google.maps.event.addListener(marker);

         }

         google.maps.event.addDomListener(window, 'load', initialize);
	</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false}); 
</script>
<style>
.image-wrapper.current a img[alt="undefined"]{ display:none !important;}
#video_div > iframe,
#video_div > video { height: 340px; left: auto; margin: -170px 0 0; position: absolute; top: 50%; width: 100% !important;}
ul.thumbs video{height: 150px;}
</style>  
</head>
<!-- <body itemscope itemtype="http://schema.org/WebPage"> -->
<body>
<script src="https://www.youtube.com/iframe_api"></script>
<?php 
$name='';
if(isset($youtube_link) && $youtube_link!='') {
	function getYouTubeId($url){
		parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
		if(isset($my_array_of_vars['v'])) {			
			return $my_array_of_vars['v'];	
		}		
	}
	
	$youtube_url	=	(string)getYouTubeId($youtube_link); 
	if(isset($youtube_url) && $youtube_url!='') {
		$name			=	$youtube_url;	
		$youtube_url	=	'https://www.youtube.com/embed/'.$youtube_url; 
	}
	else {
		$youtube_url	=	$youtube_link; 		
		$name = substr($youtube_url, strrpos($youtube_url, '/') + 1);
	}
	//echo $youtube_url;
	$you	= strchr($youtube_url,"https://www.youtube.com");
}
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
        <div class="page">
			<div class="container">
				<div class="row">
            <!--header-->
           <?php $this->load->view('include/sub-header'); ?>
            <!--//header-->
            <!--main-->
            <div class="col-sm-12 main category-grid">
                    <!--cat-->
                   <?php $this->load->view('include/left-nav'); ?>
                    <!--//cat--><!--content-->
                    <div class="col-sm-9 ContentRight ProducstdetailsOuter">
						
                    	<!--row-->
                    	<div class="row subcat-div">
                        	<div class="col-sm-12">
                            	<?php $this->load->view('include/breadcrumb'); ?>
                                <span class="result"><?php echo $product->product_name; ?> details</span>
								<!--<a data-target="#<?php //echo ($is_logged==1) ? 'inq_sup' : 'ifLoginModal'?>" href="#" data-toggle="modal"> <span class="fa fa-envelope"></span>Inquiry - Support</a>	 -->
                            </div>
                        </div>
						<div class="whiteBG-DIV">
                        <?php if (isset($msg) && !empty($msg)): ?>
                        <div class="col-sm-12"  style="margin-top: 10px;">
                            <div class='alert <?php echo $msg_class; ?> text-center'>
                                <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                <?php echo $msg; ?>
                            </div>
                        </div>
                        <?php endif; ?>
						<?php if ($this->session->flashdata('msg33')):  ?>
							<div class="col-sm-12"  style="margin-top: 10px;">
								<div class='alert  alert-info alert-dismissable text-center' >
									<a class='close' data-dismiss='alert' href='#'>&times;</a>
									<?php echo $this->session->flashdata('msg33'); ?>
								</div>
							</div>
                        <?php endif; ?>
                        <!--///row-->
                        <!--row detail-->
                        
                        	<div class="col-sm-8 item-detail">
                            	<div class="details-pageHeading">
                                	<h3 itemprop="name"><?php echo $product->product_name; ?></h3>
                                  <img itemprop="image" src="<?php echo base_url() . 'assets/upload/product/original/' . $product->product_image; ?>" style="display:none;" />
                                </div>
                                <div class="By-Name">
                                	<p class="item-by">
                                        <a href="<?php echo base_url().'seller/listings/'.$product->product_posted_by; ?>" style="text-decoration: none;">
										<?php 
												$profile_picture = '';
												if($product->profile_picture != ''){													
													$profile_picture = base_url() . profile . "original/" .$product->profile_picture;	
												}
												elseif($product->facebook_id != ''){												
													$profile_picture = 'https://graph.facebook.com/'.$product->facebook_id.'/picture?type=large';
												}elseif($product->twitter_id != ''){											
													$profile_picture = 'https://twitter.com/'.$product->username.'/profile_image?size=original';     
												}
												elseif($product->google_id != ''){											
													$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$product->google_id.'?alt=json');
													$d = json_decode($data);
													$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
												}		
												else 
													$profile_picture =	base_url().'assets/upload/avtar.png'; 												
										?>
                                            By <img width="30" height="30" class="img-circle" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'"> <?php echo $product->username1; ?>
                                        </a>
                                    </p>                                    
                                </div>
                            </div>
                        
                        <!--//row detail-->
                        <!--row-->
                        <div class="Detailspage-content">
                            <div class="col-sm-8 images">
                            <div class="image-gallery">
                            <div id="gallery" class="">
                                <div id="controls" class="controls"></div>
                                <div class="slideshow-container">
                                <div id="loading" class="loader"></div>
                                <div id="slideshow" class="slideshow">	
									<div id="cover_div" style="display:none;">
										<?php if(!empty($cover_img)){ ?>
											 <img  src="<?php echo base_url(); ?>assets/upload/product/medium/<?php echo $cover_img; ?>" alt="Cover Image"/>
										<?php } ?>
									</div>
									<div id="video_div" style="display:none;"> <!-- style="display:none;"-->
									<?php if($product_video!='') {  ?>
									 <video width="400" controls>
									  <source src="<?php echo base_url() . product.'original/'.$product_video; ?>" type="video/mp4" />
									  <source src="<?php echo base_url() . product.'original/'.$product_video; ?>" type="video/webm" />
									  <source src="<?php echo base_url() . product.'original/'.$product_video; ?>" type="video/ogg" />
									  <source src="<?php echo base_url() . product.'original/'.$product_video; ?>" type="application/ogg" />	
									  Your browser does not support HTML5 video.
									</video> 
									<?php } 
										elseif($youtube_link!='' && isset($you) && $you!='') {	 ?>						 
											<iframe width="600" height="400" src="<?php echo $youtube_url; ?>" frameborder="0" allowfullscreen id="youtube" ></iframe>											       
										<?php } ?>
									</div>
								</div>
                                </div>
                                <!-- <div id="caption" class="caption-container"></div> -->
                            </div>
                            <div id="thumbs" class="navigation row">
                                <ul class="thumbs noscript">
								<li>
									<?php if (!empty($cover_img)){                                    
                                        $url = base_url() .'assets/upload/No_Image.png';
                                        $filename = document_root . product .'original/'. $cover_img;
                                            if (file_exists($filename)) {
                                                $url = base_url() . 'assets/upload/product/video_image/' . $cover_img;
                                            }
                                         ?>
                                    
                                        <a class="thumb" href="<?php echo $url; ?>" title="Cover Image">
                                            <img  src="<?php echo base_url(); ?>assets/upload/product/medium/<?php echo $cover_img; ?>" alt="Cover Image" onError="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" height="120px" width="120px" id="cover_image"/>
                                        </a>
                                <?php }  ?>		
								</li>
								<?php if($product_video!='' || ($youtube_link!='' && isset($you) && $you!='')) { ?>	
								<li>	
								<!-- <?php //echo base_url(); ?>assets/front/images/video.jpg-->
								<?php if($product_video!='') { ?>								
									<a class="thumb" href=""  id="video_here"> 
										<img width="120" height="120" src="<?php echo base_url(); ?>assets/upload/product/video_image/<?php echo $product_videoimg; ?>" alt='Video' id="video123" />
										<!-- <video width="150" height="120" id="video" >
											  <source src="<?php //echo base_url().'assets/upload/product/original/'.$product_video; ?>" type="video/mp4">
											  Your browser does not support HTML5 video.
										</video>  -->
									</a>
								<?php }  ?>
								<?php if($youtube_link!='' && $you!='') { ?>															
									<a class="thumb" href=""  id="youtube_link">
										<!-- <img width="120" height="120" src="<?php //echo base_url(); ?>assets/front/images/video.jpg" alt='Video' id="video123" /> -->
										<img width="120" height="120" src="" alt='Video' id="video123" />								
									</a>
								<?php } ?>	
								</li>
								<?php } 
                                if (!empty($product_images)){
                                    $i=1;
                                foreach ($product_images as $pro) { 
                                        $url = base_url() .'assets/upload/No_Image.png';
                                        $filename = document_root . product .'original/'. $pro;
                                            if (file_exists($filename)) {
                                                $url = base_url() . 'assets/upload/product/original/' . $pro;
                                            }
                                         ?>
                                    <li>
                                        <a class="thumb" href="<?php echo $url; ?>" title="Image #<?php echo $i; ?>">
                                            <img  src="<?php echo base_url(); ?>assets/upload/product/medium/<?php echo $pro; ?>" alt="Image #<?php echo $i; ?>" onError="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" height="120px" width="120px"/>
                                        </a>
                                        <div class="caption">                                            
                                            <div class="image-title">Image #<?php echo $i; ?></div>                                            
                                        </div>
                                    </li>
                                <?php $i++; } ?>
                                <?php }  ?>								
                                </ul>
                            </div>
                        </div>
                        <div class="detail-btns">
                          <?php if($product_is_sold==0) { ?>
                                    <div class="ShowNumber">
                                        <button class="btn mybtn btn-block"><span class="fa fa-phone"></span><span class="show_number"> Show Number</span></button>
                                    </div>
                                    <?php } ?>
                                    <div class="ReplytoAdd">
										<?php if(isset($user_agree) && $user_agree==0) { ?>
                                        <button class="btn btn-blue btn-block  <?php if($is_logged!=0 && $user_status=='yes') echo 'disabled'; ?>  "  style="background-color:#034694;color:white;" data-toggle="modal" data-target="#replyModal"><span class="fa fa-envelope"></span> Reply to Add</button>
										<?php } else { ?>
										<button class="btn btn-blue btn-block disabled"  style="background-color:#034694;color:white;" data-toggle="modal" data-target="#replyModal"><span class="fa fa-envelope"></span> Reply to Add</button>
										<?php }?>
                                    </div>
								
                                </div>
                                	<div class="description">
                                        <h4>Description</h4>
                                        <p><?php echo $product->product_description; ?></p>
									</div>									
									<div class=" warning_part warning_part">									
										<h3><i class="glyphicon glyphicon-ban-circle"></i> Scam Warning:</h3>
										<p>
											Never wire money or financial info to a seller on the internet. For your security, all transactions should be done in person. 
										</p>
										<?php if(isset($user_agree) && $user_agree==0) { ?>
										<p>
											Please 
											<?php if(isset($user_agree) && $user_agree==0) { ?>
												<a data-toggle="modal" data-target="#<?php echo ($is_logged==1) ? 'reportModal' : 'ifLoginModal'?>" href="#">Report this Item.</a>
											<?php } else { ?>
												<a  href="#" class="disabled">Report this Item.</a>
											<?php } ?>
										</p>
										<?php } ?>
									</div>                                
							</div>
                            <div class="col-sm-4 details">
                                <h4 class="no-margin">Selling Price :</h4>
                                <h3>AED <?php echo number_format($product->product_price); ?></h3>
                                <div class="table-responsive">
                                    <table class="table tbl-details">
                                        <tr style="color:#9197a3;">
                                          <td>Posted On</td>
                                          <td><?php echo $posted_on;?></td>
                                        </tr>
                                        <!--<tr>
                                            <td>Product Code</td>
                                            <td><?php //echo $product->product_code; ?></td>
                                        </tr> -->
                                        <!--<tr>
                                            <td>Status</td>
                                            <td><?php //echo ucfirst($product->product_status); ?></td>
                                        </tr> -->
                                        <tr>
                                            <td>Category</td>
                                            <td><?php echo str_replace('\n', " ", $product->catagory_name); ?></td>
                                        </tr>
                                        <?php if($product->sub_category_id != '' || $product->sub_category_id != null){ ?>
                                            <tr>
                                                <td>Sub-Category</td>
                                                <td><?php echo str_replace('\n', " ", $product->sub_category_name); ?></td>
                                            </tr>
                                        <?php } ?>
                                        <?php if(isset($product->vehicle_features)){ ?>
											 <?php if($product->vehicle_features->bname != ''){ ?>
												<tr>
													<td>Brand</td>
													<td><?php echo $product->vehicle_features->bname; ?></td>
												</tr>
											<?php } ?>
                                            
                                            <?php if($product->vehicle_features->mname != ''){ ?>
                                                <tr>
                                                    <td>Model</td>
                                                    <td><?php echo $product->vehicle_features->mname; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if($product->vehicle_features->mileagekm != ''){ ?>
                                                <tr>
                                                    <td>Mileage</td>
                                                    <td><?php echo $product->vehicle_features->mileagekm; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if($product->vehicle_features->colorname != ''){ ?>
                                                <tr>
                                                    <td>Color</td>
                                                    <td><?php echo $product->vehicle_features->colorname; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if($product->vehicle_features->type_of_car != ''){ ?>
                                                <tr>
                                                    <td>Type Of Car</td>
                                                    <td><?php echo $product->vehicle_features->type_of_car; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if($product->vehicle_features->year != ''){ ?>
                                                <tr>
                                                    <td>Year</td>
                                                    <td><?php echo $product->vehicle_features->year; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if($product->vehicle_features->make != ''){ ?>
                                                <tr>
                                                    <td>Make</td>
                                                    <td><?php echo $product->vehicle_features->make; ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if($product->vehicle_features->vehicle_condition != ''){ ?>
                                                <tr>
                                                    <td>Condition</td>
                                                    <td><?php echo $product->vehicle_features->vehicle_condition; ?></td>
                                                </tr>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php if(isset($product->realestate_features)){ ?>
                                            <?php if($product->realestate_features->Emirates != ''){ ?>
                                                <tr>
                                                    <td>Emirates</td>
                                                    <td><?php echo $product->realestate_features->Emirates; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if($product->realestate_features->PropertyType != ''){ ?>
                                                <tr>
                                                    <td>Property Type</td>
                                                    <td><?php echo $product->realestate_features->PropertyType; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if($product->realestate_features->Bathrooms != ''){ ?>
                                                <tr>
                                                    <td>Bathrooms</td>
                                                    <td><?php echo $product->realestate_features->Bathrooms; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if($product->realestate_features->Bedrooms != ''){ ?>
                                                <tr>
                                                    <td>Bedrooms</td>
                                                    <td><?php echo $product->realestate_features->Bedrooms; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if($product->realestate_features->Area != ''){ ?>
                                                <tr>
                                                    <td>Area</td>
                                                    <td><?php echo $product->realestate_features->Area; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if($product->realestate_features->Amenities != ''){ ?>
                                                <tr>
                                                    <td>Amenities</td>
                                                    <td><?php echo $product->realestate_features->Amenities; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if($product->realestate_features->furnished != ''){ ?>
                                                <tr>
                                                    <td>Furnished</td>
                                                    <td><?php echo $product->realestate_features->furnished; ?></td>
                                                </tr>
                                            <?php } ?>

                                            <?php if($product->realestate_features->pets != ''){ ?>
                                                <tr>
                                                    <td>Pets</td>
                                                    <td><?php echo $product->realestate_features->pets; ?></td>
                                                </tr>
                                            <?php } ?>

                                        <?php } ?>
                                        
                                    </table>
                                </div>
								<div class="detail-ad ad-banner-square prod_det pull-right desktop-view">
                                  <?php
										if(!empty($feature_banners)){ ?>

										<a href="<?php echo $feature_banners[0]['site_url']; ?>"  target="_blank"  onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" width="100%" class="img-responsive center-block" /></a>
									 <?php   }else{
									 ?>
								  <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/ad1.jpg" class="img-responsive center-block" /></a>
									<?php } ?>                                	
                                </div>							 
								
						   </div>                                
                               	<div class="col-sm-12 Products-Location">
                                	<div id="googleMap" style="width:100%;height:250px; margin:20px 0;"></div>
                                </div>
								
                                <div class="col-sm-6 share_frd">
								<?php if(isset($user_agree) && $user_agree==0) { ?>
                                  <span class="social_label ">Share with friends </span>
								  <span class='st_facebook_large ' id="facebook_btn" displayText='Facebook' ></span>
                                  <span class='st_twitter_large disabled' displayText='Tweet'></span>
                                  <span class='st_googleplus_large disabled' displayText='Google +'></span>
								  <?php } ?>
									<!-- <p class="links no-padding">Share on <i class="fa fa-facebook"></i><i class="fa fa-twitter"></i><i class="fa fa-google-plus"></i></p>	 -->
                                </div>
								
                                <div class="col-sm-6 text-right view-report">
                                	<span class="fa fa-eye blue"></span><?php echo $product->product_total_views; ?> Views
									<?php if(isset($user_agree) && $user_agree==0) { ?>
										<span class="fa fa-flag pink"></span><a data-toggle="modal" data-target="#<?php echo ($is_logged==1) ? 'reportModal' : 'ifLoginModal'?>" href="#">Report this Item</a>
									<?php } ?>
                                </div>
								
                             <div id="ifLoginModal" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">To Report</h4>
                                  </div>                                
                                  <div class="modal-body">
                                    <h5>You need to be logged in to report this item.</h5>
                                  </div>
                                  <div class="modal-footer">
                                    <a href="<?php echo base_url(); ?>login?id=<?php echo $product->product_id; ?>" class="btn btn-blue">Log In</a>
                                  </div>                              
                                </div>
                              </div>
                            </div>
                            </div>
                        </div>
						<div class="row most-viewed">
							<div class="catlist">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 MostViewsHedding">
								<h3>Related Items</h3>
							</div>
                                <?php $flag = 1;
                                    if (!empty($related_product)){
                                      foreach ($related_product as $pro) {
                                         ?>
                                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12"  id="product_div">
                                	<div class="item-sell">
                                    	<div class="item-img">
										<?php if($pro['product_is_sold']==1) { ?>
											<div class="sold"><span>SOLD</span></div>
										<?php } 
										if(isset($pro['product_image']) && $pro['product_image']!='') {
										?>											
                                            <a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" /></a>
										<?php  } else  { ?>
											<a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url(); ?>assets/upload/No_Image.png" class="img-responsive" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" /></a>
										<?php } ?>
                                        </div>
                                        <div class="item-disc">
	                                        <a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>">
											<?php  $len	=	strlen($pro['product_name']); ?>	
											<h4 <?php if($len>21){ echo 'title="'.$pro['product_name'].'"'; } ?>>
												<?php  echo $pro['product_name']; ?>
											</h4>
											</a>
												<?php 
													$str	=	str_replace('\n', " ", $pro['catagory_name']);
													$len	=	strlen($str);
												?>
												<small <?php if($len>28){ echo 'title="'.$str.'"'; } ?>>
												<?php  echo $str; ?>
												</small>	
                                        </div>
                                        <div class="cat_grid">
                                            <div class="by-user">
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
												else 
													$profile_picture =	base_url().'assets/upload/avtar.png'; 
											?>
											 <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
											 <a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>" title="<?php echo $pro['username1']; ?>"><?php echo $pro['username1']; ?></a>                                            
                                            </div>
                                            <div class=" price">
                                                <span title="AED <?php echo number_format($pro['product_price']); ?>">AED <?php echo number_format($pro['product_price']); ?></span>
                                            </div>
                                        </div>
                                        <div class="count-img">
                                        	<i class="fa fa-image"></i><span><?php echo $pro['cntimg']+$pro['main']; ?></span>
                                        </div>
										<?php if($pro['product_is_sold']!=1) { ?>
                                             <?php if($is_logged!=0){ 
												$favi	=	$this->dbcommon->myfavorite($pro['product_id'],session_userid);					
												
												if(@$pro['product_total_favorite'] != 0  && $favi==1){ ?>
                                                         <div class="star fav" id="star_div<?php echo $pro['product_id']; ?>"><a href="#">
                                                            <i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
                                                           </a></div>
                                                <?php } else { ?>
                                                     <div class="star" id="star_div<?php echo $pro['product_id']; ?>"><a href="#">
                                                      <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
                                                     </a></div>
                                                <?php }
                                                 } else { ?>

                                                <div class="star" id="star_div<?php echo $pro['product_id']; ?>"><a href="<?php echo base_url() .'login/index'; ?>">
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
                       
						 <div class="col-sm-4 detail-ad ad-banner-square pull-right responsive-view">
                                  <?php
										if(!empty($feature_banners)){ ?>

										<a href="<?php echo $feature_banners[0]['site_url']; ?>"  target="_blank"  onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')"><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" width="100%" class="img-responsive center-block" /></a>
									 <?php   }else{
									 ?>
								  <a href="#"><img src="<?php echo base_url(); ?>assets/front/images/ad1.jpg" class="img-responsive center-block" /></a>
									<?php } ?>                                	
                         </div>	
					</div>
					</div>
					</div>
                    <!--//content-->
                </div>
            </div>
            <!--//main-->
        </div>
        <!--//body-->
<div id="reportModal" class="modal fade" role="dialog">
   <div class="modal-dialog ">
      <div class="modal-content">
         <form accept-charset="utf-8" name="formReportAds" method="post" id="formReportAds" class="form-horizontal validate-form" role="form">
            <div class="modal-header">
               <h4 class="modal-title">What's wrong with this ad?
               </h4>
            </div>
            <div class="modal-body">
               <div style="display: none" id="formErrorMsgReport" class="alert alert-info"></div>
               <input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">
               <input type="hidden" value="<?php echo $product->product_code; ?>" name="productCode" id="productCode">
            <input type="hidden" value="<?php echo $product->product_name; ?>" name="productName" id="productName">
               <div class="row">
                  <div class="col-xs-12">
                     <label>
                        <input type="radio" name="report" value="spam" checked="">
                     &nbsp;Spam</label>
                     (This is a Spam Ad.)
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12">
                     <label><input type="radio" name="report" value="fraud">&nbsp; Fraud</label>
                     (You suspect this to be a scam, illegal or fradulent. )
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12">
                     <label><input type="radio" name="report" value="violation">&nbsp;
                     Policy Violation</label>
                     (Ad violates our terms &amp; conditions or other policies.)
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12">
                     <label><input type="radio" name="report" value="duplicate">&nbsp;
                     Duplicate</label> (It's identical to another Ad.)
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12">
                     <label><input type="radio" name="report" value="inappropriate">&nbsp;
                     Wrong Category</label> (It doesn't belong in this category.)
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12">
                     <label><input type="radio" name="report" value="other">&nbsp; Other</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="col-xs-12">
                     <label class="control-label">&nbsp;Comments</label>
                     <textarea placeholder="" class="form-control" name="comments" id="comments" data-rule-required='true'></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <div class="col-sm-6 col-xs-12">&nbsp;</div>
               <div class="col-sm-6 col-xs-12 popup-ftr-btn">
                  <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>               
                  <button type="submit" name="report_submit" class="btn btn-success btn-md">Submit</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>

<div id="inq_sup" class="modal fade" role="dialog">
   <div class="modal-dialog ">
      <div class="modal-content">
         <form accept-charset="utf-8" name="inq_sup_form" method="post" id="inq_sup_form" class="form-horizontal validate-form" role="form">
            <div class="modal-header">
               <h4 class="modal-title">Inquiry - Support
               </h4>
            </div>
            <div class="modal-body">
               <div style="display: none" id="formErrorMsgReport" class="alert alert-info"></div>
               <input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">               
               <div class="row">
                  <div class="col-xs-12">
                     <label>Title</label>
                     <input type="text" name="inquiry_subject" class="form-control" data-rule-required='true' maxlength="50">
                  </div>
               </div>
			   <div class="row">
                  <div class="col-xs-12">
                     <label>Type</label>
						<select name="inquiry_type" id="inquiry_type" class="form-control" data-rule-required='true'>
							<option value="">Select</option>
							<option value="INQUIRY">Inquiry</option>
							<option value="SUPPORT">Support</option>
						</select>
                  </div>
               </div>
               <div class="row">
                  <div class="col-xs-12">
                     <label>Support</label>
						<textarea name="inquiry_content" class="form-control" data-rule-required='true' maxlength="250"></textarea>
                  </div>
               </div>
			   <div class="modal-footer">
				   <div class="col-xs-8">&nbsp;</div>
				   <div class="col-xs-2">
					  <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
				   </div>
				   <div class="col-xs-2">
					  <button type="submit" name="inq_sup_submit" class="btn btn-success btn-md">Submit</button>
				   </div>
				</div>               
            </div>
            
         </form>
      </div>
   </div>
</div>
    
<div id="replyModal" class="modal fade" role="dialog">
   <div class="modal-dialog ">
	  <div class="modal-content">
		 <form name="formReplyAds" method="post" id="formReplyAds" class="form-horizontal" role="form">			
			<input type="hidden" value="<?php echo $product->product_id; ?>" name="productId" id="productId">
			<input type="hidden" value="<?php echo $product->product_code; ?>" name="productCode" id="productCode">
			<input type="hidden" value="<?php echo $product->product_name; ?>" name="productName" id="productName">
			<div class="modal-header">
			   <h4 class="modal-title">Reply to Ad
			   </h4>
			</div>
			<?php if($is_logged!=0){ ?>
			<div class="modal-body">
			   <!--<div id="formErrorMsg" class="alert alert-info">Fields marked with
				  * are required.
			   </div>
			   -->
				<div class="form-group">
					<div class="col-xs-3 text-center">
						<label class="control-label">Name *</label>
					</div>
					<div class="col-xs-9">
						<input type="text" value="<?php echo $nick_name;	 ?>" placeholder="" name="sender_name" id="sender_name" class="form-control" readonly> <input type="hidden" value="<?php echo $user_id; ?>" name="sender_id" id="sender_id">
					</div>
			   </div>
			   <div class="form-group" style="display:none;">
					<div class="col-xs-3 text-center">
						<label class="control-label">Email *</label>
					</div>
					<div class="col-xs-9">
						<input type="text" value="<?php echo $owner_email;	 ?>" placeholder="" name="sender_email" id="sender_email" class="form-control" readonly>
					</div>
			   </div>
			   <!--<div class="form-group">
				  <div class="col-xs-3 text-center">
					 <label class="control-label">Subject *</label>
				  </div>
				  <div class="col-xs-9">
					 <input type="text" value="" placeholder="" name="subject" id="subject" class="form-control">
				  </div>
			   </div>  -->
			   <div class="form-group">
				  <div class="col-xs-3 text-center">
					 <label class="control-label">Message *</label>
				  </div>
				  <div class="col-xs-9">
					 <textarea placeholder="" name ="message" id="message" class="form-control xyz" maxlength="50"></textarea>
				  </div>
			   </div>
			</div>
			 <div class="modal-footer">
			   <div class="col-sm-4 col-sm-offset-8">
			   <div class="col-sm-6">
				  <button type="button" class="btn btn-default btn-md" data-dismiss="modal">Close</button>
			   </div>
			   <div class="col-sm-6">
				  <button type="submit" name="reply_submit" class="btn btn-success btn-md">Submit</button>
			   </div>
			   </div>
			</div>
			<?php } else { ?>
			<div class="modal-body">
				<h5>You need to be logged in to reply for this item.</h5>
			</div>
			<div class="modal-footer">
				 <a href="<?php echo base_url(); ?>login?id=<?php echo $product->product_id; ?>" class="btn btn-blue">Log In</a>
		   </div>	
			<?php } ?>
		   
		 </form>
	  </div>
   </div>
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
	</div>
	</div>
        <!--//footer-->
<!--container-->
<script type="text/javascript">	
		function update_count(a)
		{
			var url = "<?php echo base_url(); ?>home/update_click_count";   
            $.post(url, {ban_id: a}, function(response)
            { }, "json");
		}
            jQuery(document).ready(function($) {
			
				var w = $('.catlist .col-lg-3 .item-sell .item-img').width();		
				$('.catlist .col-lg-3 .item-sell .item-img a').css('width', w);
				var h = $('.catlist .col-lg-3 .item-sell .item-img').height();
				$('.catlist .col-lg-3 .item-sell .item-img a').css('height', h);
				
				$(window).resize(function() {			
					var w = $('.catlist .col-lg-3 .item-sell .item-img').width();
					$('.catlist .col-lg-3 .item-sell .item-img a').css('width', w);
					var h = $('.catlist .col-lg-3 .item-sell .item-img').height();
					$('.catlist .col-lg-3 .item-sell .item-img a').css('height', h);
				 });	
		 
				//$('#video').trigger('click');
				//jQuery('#video_div').click();
				$(".image-wrapper").hide();
				$("#video_div").show();
                // We only want these styles applied when javascript is enabled
                $('div.navigation').css({'float' : 'left'});
                $('button.mybtn').click(function(){
                    $(this).find('.show_number').text('<?php echo $product->phone; ?>');
                });
                $('div.content').css('display', 'block');

				
				
				
                // Initially set opacity on thumbs and add
                // additional styling for hover effect on thumbs
                var onMouseOutOpacity = 0.67;
                $('#thumbs ul.thumbs li').opacityrollover({
                    mouseOutOpacity:   onMouseOutOpacity,
                    mouseOverOpacity:  1.0,
                    fadeSpeed:         'fast',
                    exemptionSelector: '.selected'
                });
				
               var gallery = $('#thumbs').galleriffic({
                    delay:                     4000,
                    numThumbs:                 3,
                    preloadAhead:              3,
                    enableTopPager:            false,
                    enableBottomPager:         true,
                    maxPagesToShow:            3,
                    imageContainerSel:         '#slideshow',
                    controlsContainerSel:      '#controls',
                    captionContainerSel:       '#caption',
                   // loadingContainerSel:       '#loading',
                    renderSSControls:          true,
                    renderNavControls:         true,
                    //playLinkText:              'Play Slideshow',
                    //pauseLinkText:             'Pause Slideshow',
                    prevLinkText:              '&lsaquo; Previous Photo',
                    nextLinkText:              'Next Photo &rsaquo;',
                    nextPageLinkText:          'Next &rsaquo;',
                    prevPageLinkText:          '&lsaquo; Prev',
                    enableHistory:             true,
                    autoStart:                 false,
                    syncTransitions:           true,
                    defaultTransitionDuration: 900,
                    enableKeyboardNavigation:  false,						
                    onSlideChange:             function(prevIndex, nextIndex) {
						$("#video_div").hide();												
						$(".image-wrapper").show();
						
						$('#cover_image').on('load',function() { 	
							alert("here456");
							$(".image-wrapper").hide();
							$("#cover_div").show();
							return false; 
						});  
							
						$('#video').on('click',function() { 	
							alert("here");
							$(".image-wrapper").hide();
							$("#video_div").show();
							return false; 
						});  
						
						$('#youtube').click( function(e) { 	
							alert("youuu");
							//alert("call");			
							//e.preventDefault();		
							$(".image-wrapper").hide();
							$("#video_div").show();
							return false; 
						});  
                        // 'this' refers to the gallery, which is an extension of $('#thumbs')
							this.find('ul.thumbs').children()
                            .eq(prevIndex).fadeTo('fast', onMouseOutOpacity);
							if(nextIndex==0) {
								jQuery('#video').click();								
								jQuery('#youtube').click();																
							}		
                    },
                    onSlideChangeIn: function(nextIndex) {					
                    this.find('ul.thumbs').children()
                        .eq(nextIndex).fadeTo('fast', 1.0);
                },
                    onPageTransitionOut:function(callback) {
						
                        this.fadeTo('fast', 0.0, callback);
                    },
                    onPageTransitionIn: function() {
						
                        this.fadeTo('fast', 1.0);
                    }
                });
				
            $("#formReportAds").validate({
                    rules: {
                        report: "required",
                        comments: "required"
                    },
                    messages: {
                        report: "Please select one of the options",
                        comments: "Please enter comments",
                    },
                    
                    submitHandler: function(form) {
                        form.submit();
                    }
                });

            $("#formReplyAds").validate({
                    rules: {
                        sender_name: "required",
                        //subject: "required",
                        message: "required",
                        sender_email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        sender_name: "Please Enter Name",
                        //subject: "Please provide a subject",
                        message: "Please enter a message",
                        sender_email: {
                            required: "Please enter an email address",
                            email: "Please enter a valid email address"
                        }
                    },
                    
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
		<script type="text/javascript">
     $('div.star a i').click(function(e) {				
			<?php if($is_logged!=0){ ?>	
				e.preventDefault();
				var url = "<?php echo base_url(); ?>user/add_to_favorites";
				var fav = 0;
				var id = $(this).attr('id');
				
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
						$('div.star a i').closest('div').removeClass('fav');
						$('div.star a i').addClass("fa-star-o");
						$('div.star a i').removeClass("fa-star");
						$("#send-message-popup").modal('show');
						$('#err_div').show();
						$("#error_msg").text(response);					
					}
				});				
				<?php } else { ?>										
					window.location="<?php echo base_url(); ?>";
				<?php } ?>
		});    
	
	var Youtube = (function () {
	'use strict';
		var video, results;

		var getThumb = function (url, size) {
			if (url === null) {
				return '';
			}
			size    = (size === null) ? 'big' : size;
			results = url.match('[\\?&]v=([^&#]*)');
			video   = (results === null) ? url : results[1];

			if (size === 'small') {
				return 'http://img.youtube.com/vi/' + video + '/2.jpg';
			}
			return 'http://img.youtube.com/vi/' + video + '/0.jpg';
		};
			return {
				thumb: getThumb
			};
	}());
	var link	=	"<?php echo (string)getYouTubeId($youtube_link); ?>";	
	var thumb = Youtube.thumb("http://www.youtube.com/watch?v="+link, 'small');
		$('#video123').attr("src",thumb);
	var thumb = Youtube.thumb("http://www.youtube.com/watch?v="+link, 'big');
		$("#youtube_link").attr("href", thumb);
</script>
</body>
</html>
