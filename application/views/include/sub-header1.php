<!-- <script src="<?php echo base_url(); ?>a
sets/front/javascripts/bootstrap-select.js" type="text/javascript"></script>
   <link href="<?php echo base_url(); ?>assets/front/stylesheets/bootstrap-select.css" media="all" rel="stylesheet" type="text/css" /> -->
<!--<div class='alert  alert-success' id="err_div" style="display:none">
   <a class='close' data-dismiss='alert' href='#'>&times;</a>
   <center><span id="error_msg" ></span></center>
    </div> -->
<header id="header">
   <?php 
   
    if($this->session->flashdata('msg')!=''):  ?>
   <div class='alert  alert-success'>
      <a class='close' data-dismiss='alert' href='#'>&times;</a>
      <center><?php echo $this->session->flashdata('msg'); ?></center>
   </div>
   <?php endif; ?>
   <div class="col-lg-2 col-sm-2 col-sm-3 col-xs-12 logo">
      <h1>
         <a href="<?php echo HTTPS.website_url; ?>" style="text-decoration:none">
         <img src="<?php echo HTTPS.website_url.'assets/front/images/DoukaniLogo.png'; ?>" >         
         </a>
      </h1>
   </div>
   <div class="col-lg-7 col-sm-7 col-sm-6 col-xs-12  SearchOuter">
      <!--search-->
      <?php 
      
        if(!isset($store_page)) {
                if($this->uri->segment(1)=='allstores') {
         ?>
            <div class="input-group store_search">                      
               <form  method="post" action="<?php echo HTTPS.website_url; ?>store_search">              
                  <input type="text" class="form-control" aria-label="..." value="<?php if(isset($_POST['search_value'])) echo $_POST['search_value']; ?>" name="search_value" id="search_value" placeholder='Search Store'>
                  <button type="submit" class="btn btn-link"></button>
               </form>           
          </div>
      <?php } else { ?>
          <div class="input-group">
               <div class="input-group-btn">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Categories <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">
                     <?php foreach ($category as $cat): ?>
                     <li>
                        <a href="<?php echo HTTPS.website_url . $cat['category_slug']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></a>
                     </li>
                     <?php endforeach; ?>
                  </ul>
               </div>
               <!-- /btn-group -->
                 <form  method="post" action="<?php echo HTTPS.website_url; ?>search">                    
                    <input type="text" class="form-control" aria-label="..." value="<?php echo @$category_name? str_replace('\n', " ", @$category_name) : set_value('search_value',@$_POST['search_value']); ?>" name="search_value" id="search_value">
                    <button type="submit" class="btn btn-link"></button>
                 </form>
                 <a href="<?php  echo HTTPS.website_url;?>advanced_search" class="adv-search" style="font-size:10px;"><font color="#ed1b33">+</font> <font color="#9a9a9a"><b>ADVANCED SEARCH</b></font></a>

            </div>
  <?php
      } 
    }
        else { ?>
        <div class="input-group store_search" >         
         <!-- /btn-group -->
           <form  method="post" action="<?php echo $store_url; ?>search">              
              <input type="text" class="form-control" aria-label="..." value="<?php if(isset($_POST['search_value'])) echo $_POST['search_value']; ?>" name="search_value" id="search_value" placeholder='Search product in store'>
              <button type="submit" class="btn btn-link"></button>
           </form>
      </div>   
      <?php } ?>
      <!-- /input-group -->
      <!--//search-->
   </div>
   <div class="col-lg-3 col-sm-3 col-sm-3 col-xs-12 UserOuter">
      <div class="fav_list">
         <?php  
            if($this->session->userdata('gen_user')){ ?>
         <a href="<?php  echo HTTPS.website_url; ?>user/favorite">Favorites List</a>
         <?php }else{ ?>
         <a href="<?php  echo HTTPS.website_url; ?>login/index">Favorites List</a>
         <?php  }  ?>          
      </div>
      <div class="login">
         <!-- <i class="fa fa-user"></i>-->
         <?php /* 
            if($this->session->userdata('user')){ ?>
         <?php $profile_picture = base_url() . profile . "small/" .$current_user->profile_picture;
            if($current_user->facebook_id != ''){
            	$profile_picture = 'https://graph.facebook.com/'.$current_user->facebook_id.'/picture';
            }
            ?>
         <img src="<?php echo $profile_picture; ?>" class="img-responsive" />
         <?php
            }else{ ?>
         <i class="fa fa-user"></i>
         <?php  
            }*/
            
            if($this->session->userdata('gen_user')){ ?>
         <a href="<?php echo HTTPS.website_url; ?>login/signout"><span>Sign out</span></a>
         <?php }else{ 					
            ?>	
         <a href="#" onclick="load_page();"><?php if($this->uri->segment(1)!='' && ($this->uri->segment(1)=='login' || $this->uri->segment(1)!='registration')) echo '<span>Login</span>'; else echo 'Login'; ?></a>
         <!-- <a href="<?php //echo base_url(); ?>login/index"><?php //if($this->uri->segment(1)!='' && ($this->uri->segment(1)=='login' || $this->uri->segment(1)!='registration')) echo '<span>Login</span>'; else echo 'Login'; ?></a> -->	
         |
         <a href="<?php echo HTTPS.website_url; ?>registration"><?php if($this->uri->segment(1)!='' && $this->uri->segment(1)=='registration') echo '<span>Sign up</span>'; else echo 'Sign up'; ?></a>
         <?php  }  ?>          
      </div>
   </div>
</header>
<div class="modal fade center" id="popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
   <a class='close' data-dismiss='alert' href='#'>&times;</a>
   
      <div id="loading" style="text-align:center">
         <img id="loading-image" src="<?php echo HTTPS.website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
      </div>
      <div class="modal-dialog modal-md">
         <div class="col-sm-9 ContentRight loginpg">
            <div class='' id="alert_box" style="display:none;">
               <a class='close' data-dismiss='alert' href='#'>&times;</a>
               <center id="alert_msg"></center>
            </div>
            <h3>Login</h3>
            <?php 
              if(isset($store_url) && $store_url!='')
                  $mypath_ = $store_url;
              else
                  $mypath_ = base_url();
            ?>
  <form action='<?php echo $mypath_; ?>login/index' class='validate-form' method='post'>
   <div class="col-sm-12 login-div">
      <div class="social_main">
         <h4>Login with Social</h4>
         <?php  //echo $fb_login_url; ?>
         <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-fb" name="faebook_login"><i class="fa fa-facebook"></i>Sign In With Facebook</a>
         <a href="<?php echo $twitter_login_url; ?>" class="btn btn-block btn-twit" name="twitter_login"><i class="fa fa-twitter"></i>Sign In With Twitter</a>
         <a href="<?php echo $googlePlusLoginUrl; ?>" class="btn btn-block btn-g-plus" name="gplus_login"><i class="fa fa-google-plus"></i>Sign In With Google+</a>
         <!-- <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-email" name="faebook_login"><i class="fa fa-envelope"></i>Sign In With Email</a> -->
         <div class="text-right signup-link">Not Yet Registered? <a href="<?php echo HTTPS.website_url; ?>registration"><span>Sign up</span></a></div>
      </div>
      <div class="user-login">
         <h4>Login with Doukani</h4>
         <div class="form-group un">
            <input type="text" class="form-control" placeholder="Username"  name="username" id="username" data-rule-required="true" />
         </div>
         <div class="form-group pwd">
            <input type="password" class="form-control" placeholder="Password"  name="password" id="password" data-rule-required="true"/>
         </div>
         <div id="error">
         </div>
         <button class="btn btn-block btn-black" name="submit" id="login_submit" value="Log in">Log in</button>
         <div class="text-right signup-link"><a href="<?php echo HTTPS.website_url; ?>login/forget_password">Forgot Password?</a></div>
      </div>
      <div class="clearfix"></div>
   </div>
</form>
   </div>
   </div>
   
</div>
<script type="text/javascript">
   function load_page() {
   	$("#popup").modal('show');		 
   }
   $('document').ready(function() { 	
   $("#login-form").validate({
        rules:
     {
   		password: {required: true},
   		username: {required: true},
      },
         messages:
      {
              password:{required: "Password is required"},
              username:{required: "Username / Email ID is required"}
         },
   	submitHandler: submitForm	
         });
      
      function submitForm()
      {		
   		$("#login_submit").html('<img src="<?php echo HTTPS.website_url; ?>assets/front/images/btn-ajax-loader.gif" /> &nbsp; Signing In ...');	
   		var data = $("#login-form").serialize();			
   		$.ajax({				
   			type : 'POST',
   			url  : '<?php echo HTTPS.website_url."login/ajax_login"; ?>',
   			data : data,
   			beforeSend: function()
   			{	
   				$("#alert_box").fadeOut();
   				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
   			},
   			success :  function(response)
   			{					
   				var json = response,
   				obj = JSON.parse(json);				
   				var response	=	obj.response;
   				 console.log(response);
          return false;
   					if(response=="agree"){	
              alert();
              <?php
                //  if(isset($store_url) && $store_url!='')
                //     $__redirect = $store_url;
                // else
                //     $__redirect = base_url();              

                //   if(strpos($mypath_,after_subdomain) !== false) {
                //       $__redirect = str_replace("https","http",$_SERVER['REQUEST_URI']);
                //   }
                //   else {
                //       $__redirect = current_url();
                //   }                
             ?>
             // alert('<?php //echo $__redirect; ?>');
             // return false;
   						// var href	=	"<?php echo 'http://anny.doukani.com/home'; ?>";   						
   						// setTimeout(function() { window.location.href = href+'/#1'; }, 1000 );
   					}
   					else {						
   						if(response=="not_agree")  {														
   							href	=	'<?php echo HTTPS.website_url.'login/agree'; ?>';
   							setTimeout(function() { window.location.href = href+'/#1'; }, 1000 );
   						}
              else if(response=="user_role")	 {
                href = '<?php echo HTTPS.website_url.'login/user_role'; ?>';
                setTimeout(function() { window.location.href = href+'/#1'; }, 1000 ); 
              }
              else if(response=="create_store")   {
                href = '<?php echo HTTPS.website_url.'login/create_store'; ?>';
                setTimeout(function() { window.location.href = href+'/#1'; }, 1000 ); 
              }
   						else {	
   								$('#alert_box').show();
   								$('#alert_msg').show();
   								$("#alert_msg").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
   								$("#login_submit").html('&nbsp; Log In');
   							}
   						}
   			}
   		});
   			return false;
   	}
   });
    
    
      
      if(window.location.hash=='#1') {        
        $('.Welcomeuser').addClass('open');
      }


    $('#err_div').hide();
       $('#search_value').bind("enterKey",function(e){         
           var search_value = $(this).val();
           var url = "<?php  echo base_url(); ?>search";
           $.post(url, {search_value: search_value}, function(data)
           {     
           });   
           
       });
       $('#search_value').keyup(function(e){
           if(e.keyCode == 13)
           {
               $(this).trigger("enterKey");
           }
       });
</script>