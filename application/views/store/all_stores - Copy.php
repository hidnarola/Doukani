<html>
   <head>
      <title><?php echo ($page_title) ? $page_title : 'Doukani';?></title>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <link href='<?php echo base_url(); ?>assets/admin/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
      <link href='<?php echo base_url(); ?>assets/front/stylesheets/owl.theme.css' rel='stylesheet' type='text/css'>
      <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;" />
      <link href="<?php echo base_url(); ?>assets/front/dist/css/bootstrap.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />
      <script src="<?php echo base_url(); ?>assets/front/dist/js/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap.min.js"></script>          
      <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />
      <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
      <link href="<?php echo base_url(); ?>assets/front/style.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/front/responsive.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/front/new_style.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/front/new_responsive.css" rel="stylesheet">
      <title>Home Page</title>
   </head>
   <body>
      <div class="container-fluid">          
      <?php $this->load->view('include/header'); ?>         
      <div class="page">
         <div class="container">
            <div class="row">
               <!--header-->
               <!--//header-->
               <!--main-->
               <div class=" main">
                  <div class="mainContent">
                     <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
                     <div class="col-sm-2 LeftCategory category">
                        <h4 id="cating"><a href="<?php echo site_url().'home/categories'?>" style="color:white; text-decoration:none;" class="menu1">Categories</a></h4>
                        <?php $category_link = ($this->uri->segment(2)=='category' || $this->uri->segment(2)=='category_listing' || $this->uri->segment(2)=='category_map')? $this->uri->segment(2) : 'category';
                           if(isset($order_option))
                              $order_option  =  $order_option;
                           else
                              $order_option  =  '';
                           ?>
                        <div class="menu-wrapper">
                           <ul class="main-menu">
                              <li class="menu1">
                                 <span href="#">
                                 <input type="checkbox" name="category_chk[]" id="category_chk[]" value="0" class="category_chk chk_all"  checked>&nbsp;&nbsp;
                                 ALL
                                 </span>
                              </li>
                              <?php foreach ($category as $cat): ?>
                              <li class="menu1">
                                 <span style="color: <?php echo $cat['color']; ?>" href="#">
                                 <input type="checkbox" name="category_chk[]" id="category_chk[]" value="<?php echo $cat['category_id']; ?>" class="category_chk chk_others" >&nbsp;&nbsp;
                                 <i class="fa <?php echo $cat['icon']; ?>"></i>
                                 <?php echo str_replace('\n', " ", $cat['catagory_name']); ?>
                                 </span>
                              </li>
                              <?php endforeach;  ?>
                           </ul>
                        </div>
                        <a id="btn-show" href="javascript:void(0);"><span class="fa fa-caret-square-o-down" ></span><label>Show More</label></a>
                     </div>
                     <div class="col-sm-10 ContentRight">
                        <div class="row most-viewed">
                           <div id="most-viewed">
                              <div class="space-top"></div>
                                 <select id="filter" name="filter">
                                    <option value="">Default</option>
                                    <option value="1">New</option>
                                    <option value="2">Popular</option>
                                 </select>
                              <div class="col-sm-12 text-center" id="reset_data">
                                 <?php   if (!empty($products)) {
                                    foreach ($products as $pro) {
                                    ?>
                                 <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                    <div class="item-sell">
                                       <div class="item-img-outer">
                                          <div class="item-img">
                                             <?php if($pro['product_is_sold']==1) { ?>
                                             <div class="sold"><span>SOLD</span></div>
                                             <?php } ?>
                                             <?php if (!empty($pro['product_image'])) { ?>
                                             <a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url() . product . "medium/" . $pro['product_image']; ?>" class="img-responsive" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" alt="<?php echo $pro['product_name']; ?>"/></a>
                                             <?php } else { ?>
                                             <a href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>"><img src="<?php echo base_url(); ?>assets/upload/No_Image.png" class="img-responsive" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" alt="<?php echo $pro['product_name']; ?>" /></a>
                                             <?php } ?>
                                          </div>
                                          <div class="function-icon">
                                             <?php if($loggedin_user!=$pro['product_posted_by']) {
                                                if($pro['product_is_sold']!=1) {
                                                   if($is_logged!=0){ 
                                                $favi =  $this->dbcommon->myfavorite($pro['product_id'],session_userid);
                                                if(@$pro['product_total_favorite'] != 0 && $favi==1){ ?>
                                             <div class="star fav" ><a href="#" id="<?php echo $pro['product_id']; ?>">
                                                <i class="fa fa-star" id="<?php echo $pro['product_id']; ?>"></i>
                                                </a>
                                             </div>
                                             <?php } else { ?>
                                             <div class="star" ><a href="#">
                                                <i class="fa fa-star-o" id="<?php echo $pro['product_id']; ?>"></i>
                                                </a>
                                             </div>
                                             <?php }
                                                } else { ?>
                                             <div class="star" ><a href="<?php echo base_url() .'login/index'; ?>">
                                                <i class="fa fa-star-o"></i>
                                                </a>
                                             </div>
                                             <?php } } }  ?>                              
                                          </div>
                                       </div>
                                       <div class="item-disc">
                                          <a style="text-decoration: none;" href="<?php echo base_url();?>home/item_details/<?php echo $pro['product_id']; ?>">
                                             <?php  $len =  strlen($pro['product_name']); ?> 
                                             <h4 <?php if($len>21){ echo 'title="'.$pro['product_name'].'"'; } ?> >
                                                <?php echo $pro['product_name']; ?>
                                             </h4>
                                          </a>
                                          <?php 
                                             $str  =  str_replace('\n', " ", $pro['catagory_name']);
                                             $len  =  strlen($str);
                                             ?>
                                          <small <?php if($len>28){ echo 'title="'.$str.'"'; } ?>>
                                          <?php echo $str; ?>
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
                                                   $profile_picture =   base_url().'assets/upload/avtar.png';  
                                                ?>
                                             <img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" />
                                             <a href="<?php echo base_url().'seller/listings/'.$pro['product_posted_by']; ?>" title="<?php echo $pro['username1']; ?>"><?php echo $pro['username1']; ?></a>                                            
                                          </div>
                                          <div class="price">
                                             <span title="AED <?php echo number_format($pro['product_price']); ?>">AED <?php echo number_format($pro['product_price']); ?></span>
                                          </div>
                                       </div>
                                       <div class="count-img">
                                          <i class="fa fa-image"></i><span><?php echo $tot_img  =  $this->dbcommon->get_no_of_images($pro['product_id']); ?></span>
                                       </div>
                                    </div>
                                 </div>
                                 <?php } } else{
                                    echo "<h5>No product found in this category</h5>";
                                    }   ?> 
                                 <?php if(@$hide == "false"){?>
                                  <div class="col-sm-12 text-center" id="load_more">
                                    <button class="btn btn-blue" onclick="get_more_products();" id="load_product" value="0">Load More</button><br><br><br>
                                  </div>
                                <?php } ?>
                              </div>
                              <input type="text" name="categories" id="categories">
                              <input type="text" name="filter_sel" id="filter_sel">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--//body-->
      <div id="loading" style="text-align:center">
         <img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
      </div>
      <script>
         $(document).ready(function(){
            
            $('.chk_all').prop('checked',true);
            $('.chk_others').prop('checked',false);
         
            $('.category_chk').on('change',function(e){         
                  get_data("checkbox");
            });   
            
            $('#filter').on('change',function(e){
                  get_data("filter");
            });

            function get_data(selection) {

               if(selection=='checkbox') {
                  //if select 0 so all other become deselect            
                  if(this.value=="0" && $('.chk_all').prop('checked')==true)
                     $('.chk_others').prop('checked',false);
                  else               
                     $('.chk_all').prop('checked',false);
                                
                  var CbChkBoxVal   =  
                              $('.category_chk:checked').map(function(){

                                 if(this.value!="0")
                                    return this.value;
                                 else
                                    return 0;

                              }).get().join(',');               
         
                  $body = $("body");
                  $body.addClass("loading");
                  
                  var url =   "<?php echo base_url(); ?>allstores/get_products";

                  
                     
               }     
                 $('#categories').val(CbChkBoxVal);

                 if(selection=='filter')
                     $('filter_sel').val();

                  var start   =  $("#load_product").val();
                  start++;
                  $("#load_product").val(start);            
                  var val1    =  start;

                     //$('#loading').show();
                     $.post(url, {cat_id: CbChkBoxVal,value:val1}, function(response)
                     {
                         //console.log(response);
                         //$("#load_more").before(response.html);
                         $('#reset_data').html('');
                         $('#reset_data').html(response.html);
                         if(response.val == "true"){
                             $("#load_product").hide();
                         }
                         $('#loading').hide();
                     }, "json");

            }

            $('.menu-wrapper').css('max-height','322px');
            
            $('#btn-show').click(function(e){            
               e.preventDefault();
               var text = $(this).find('label').text();
               
               if(text == 'Show More'){
                  $('.menu-wrapper').css('max-height','none');
                  $(this).find('label').text('Show Less');
                  $(this).find('span').addClass('fa-caret-square-o-up');
                  $(this).find('span').removeClass('fa-caret-square-o-down');
               }else{
                  $('.menu-wrapper').css('max-height','322px');
                  $(this).find('label').text('Show More');
                  $(this).find('span').removeClass('fa-caret-square-o-up');
                  $(this).find('span').addClass('fa-caret-square-o-down');
               }
            });
         }); 

      function get_more_products() {
   
           $body = $("body");
           $body.addClass("loading");
               
            var url  =  "<?php echo base_url(); ?>allstores/get_products/";
            var start   =  $("#load_product").val();
            start++;

            $("#load_product").val(start);            
            var val1    =  start;

             $('#loading').show();

            $.post(url, {value: val1,categories:categories}, function(response)
            {                 
                $("#load_more").before(response.html);
                if(response.val == "true"){
                    $("#load_product").hide();
                }
                $('#loading').hide();
            }, "json");
      }

      </script>
   </body>
</html>