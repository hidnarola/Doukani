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
 
                        <!--Most Viewed product items-->
                        <div class="row most-viewed">
                            <div class="col-sm-12" id="most-viewed">
                            	<h3><?php echo $category_name; ?></h3>
                                
                                 <!--item1-->
                                  <?php if (!empty($product)){
                                           foreach ($product as $pro) {
                                              // echo "<pre>"; print_r($most_viewed_product); die;
                                            
                                            ?>
                                <div class="col-md-3 col-sm-4">
                                	<div class="item-sell">
                                    	<div class="item-img">
                                            <?php if (!empty($pro['product_image'])): ?>
                                                            <a href="#"><img src="<?php echo base_url() . product . "original/" . $pro['product_image']; ?>" class="img-responsive" /></a>
                                             <?php endif; ?>
                                        	
                                        </div>
                                        <div class="item-disc">
	                                        <a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><h4><?php echo $pro['product_name']; ?></h4></a>
    	                                    <small><?php echo $pro['catagory_name']; ?></small>
                                        </div>
                                        <div class="row">
                                            <div class="by-user col-sm-6">
                                                <img src="<?php echo base_url() . profile . "original/" . $pro['profile_picture']; ?>" class="img-responsive img-circle" />
                                                <a href="#"><?php echo $pro['username']; ?></a>                                            
                                            </div>
                                            <div class="col-sm-6 price">
                                                <span>AED <?php echo number_format($pro['product_price']); ?></span>
                                            </div>
                                        </div>
                                        <div class="count-img">
                                        	<i class="fa fa-image"></i><span><?php echo $pro['product_total_views']; ?></span>
                                        </div>
                                        <div class="star"><a href="#"><i class="fa fa-star-o"></i></a></div>
                                    </div>
                                </div>
                                 
                                  <?php } } else{
                                      echo "<h5>No product found in this category</h5>";
                                  }  ?>

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
    
<!--container-->
</body>
</html>
