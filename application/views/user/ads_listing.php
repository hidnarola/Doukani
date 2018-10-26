<html>
<head>
     <?php $this->load->view('include/head'); ?>
    <?php $this->load->view('include/google_tab_manager_head'); ?>
</head>
<body>
    <?php $this->load->view('include/google_tab_manager_body'); ?>
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
                            	<h3>Favorites List </h3>
                                
                                 <!--item1-->
                                  <?php if (!empty($ads)){
                                           foreach ($ads as $pro) {
                                              // echo "<pre>"; print_r($most_viewed_product); die;
                                            
                                            ?>
                                <div class="col-md-3 col-sm-4">
                                	<div class="item-sell">
                                    	<div class="item-img">
                                            <?php if (!empty($pro['product_image'])): ?>
                                                            <a href="#"><img src="<?php echo base_url() . product . "original/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/not-found.JPG'"/></a>
                                             <?php endif; ?>
                                        	
                                        </div>
                                        <div class="item-disc">
	                                        <h4><?php echo $pro['product_name']; ?></h4>
    	                                    <small><?php echo $pro['catagory_name']; ?></small>
                                        </div>
                                        <div class="row">
                                            <div class="by-user col-sm-8">
                                                <img src="<?php echo base_url() . profile . "original/" . $pro['profile_picture']; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" />
                                                <a href="#"><?php echo $pro['username1']; ?></a>                                            
                                            </div>
                                            <div class="col-sm-4 price">
                                                <span>$<?php echo $pro['product_price']; ?></span>
                                            </div>
                                        </div>
                                        <div class="count-img">
                                        	<i class="fa fa-image"></i><span><?php echo $pro['product_total_views']; ?></span>
                                        </div>
                                           <?php if(@$pro['product_total_favorite'] != 0){ ?>
                                                <div class="star fav" ><a href="#">
                                                   <i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
                                                  </a></div>
                                       <?php } else { ?>
                                            <div class="star" ><a href="#">
                                             <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
                                            </a></div>
                                       <?php } ?>
                                    </div>
                                </div>
                                 
                                  <?php } } else{
                                      echo "<h5>No product found in this category</h5>";
                                  }   ?>

                            </div>
                            <!--<div class="col-sm-12 text-center">
                                <button class="btn btn-blue" onclick="load_more_product();" id="load_product" value="0">Load More</button>
                            </div>-->
                        </div>
                      <!--End Most Viewed product items-->
                        
                    </div>
                    <!--//content-->
                </div>
            </div>
            <!--//main-->
            
            
            
            
        </div>
        <!--//body-->
        
        <!--footer-->
            <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>
<script type="text/javascript" >
     $('div.star a i').click(function() { 
          
             var url = "<?php echo base_url() ?>user/add_to_favorites";
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
//                console.log(response);

            });
            
            
        });
</script>
<!--container-->
</body>
</html>
