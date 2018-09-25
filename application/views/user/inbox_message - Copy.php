<html>
<head>
     <?php $this->load->view('include/head'); ?>   
<link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/datatables/bootstrap-datatable.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/stylesheets/bootstrap/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/stylesheets/dark-theme.css" media="all" rel="stylesheet" type="text/css" />

<body  class="js no-touch localstorage svg">

<div class="container-fluid">     
        <?php $this->load->view('include/header'); ?>      
		<?php $this->load->view('include/menu'); ?>        
        <div class="row page">            
           <?php $this->load->view('include/sub-header'); ?>            
            <div class="col-sm-12 main dashboard">
    <div class="row">
         <?php $this->load->view('include/left-nav'); ?>
         <div class="col-sm-10">		
                      <!--row-->
                      <div class="row subcat-div no-padding">
                            <div class="col-sm-12">
                                <ol class="breadcrumb no-margin">
                                  <li><a href="#">Home</a></li>
                                  <li class="">My Listing</li>
                                </ol>
                            </div>                              
                        </div>                   
                        <div class="row">
                            <div class="col-sm-12 profile-tabs">		
                                <ul class="nav nav-tabs">
                                  <li role="presentation"><a href="index">My Profile</a></li>								 
                                  <li role="presentation" class=""><a id="mylink" onclick="javascript:mylisting('Approve');" onmouseover="javascript:show_listmenu();">My Listing</a>								  
											<ul aria-labelledby="dropdownMenu1" class="dropdown-menu" role="menu" id="product_is_inappropriate" name="product_is_inappropriate" style="display:none;"> <!-- onmouseover="show_me();"-->
												<li role="presentation" style="background-color:red;"><a href="#" role="menuitem" onclick="javascript:mylisting('Approve');" id="approve">Approve</a></li>
												<li role="presentation" style="background-color:red;"><a href="#" role="menuitem"  onclick="javascript:mylisting('Unapprove');" id="unapprove">Unapprove</a></li>
												<li role="presentation" style="background-color:red;"><a href="#" role="menuitem"  onclick="javascript:mylisting('NeedReview');" id="needreview">NeedReview</a></li>
											</ul>											
								  </li>
                                  <li role="presentation"><a href="favorite">My Favorites</a></li>
								  <li role="presentation"><a href="deactivateads" >Deactivate Ads</a></li>
                                </ul>
                                <a class="active" href="<?php echo site_url().'/user/inbox_products'; ?>"><span class="fa fa-envelope"></span>Inbox</a>
                            </div>
                        </div>
                        <ol class="breadcrumb no-margin">
							<?php $numItems = count($sub_bread);
							$i = 0;
								foreach ($sub_bread as $key => $value) { 
									if($key !=''){ ?>
									<li class="<?php echo (++$i === $numItems) ? 'active' : ''; ?>"><a href="<?php echo $value; ?>"><?php echo str_replace('\n', " ", $key); ?></a></li>
								<?php }else{ $i++;}
							} ?>
						</ol>
						
						<div class=" most-viewed col-sm-12">
			<?php 
				foreach($listing as $list){				
					//echo '<pre>';
					//print_r($list);
			?>				
			<div class='' data-scrollable-height='680' data-scrollable-start='bottom' style="background: #ECECEC;">
				<div class='row'>
					<div class='col-sm-12  pro_msg1'>						
					<br>						 
						<div class="box bordered-box blue-border" style="margin-bottom:0;">						
						<div class="box-header blue-background">
							<div class="title">
								<img width="25px" height="25px" src="<?php echo base_url() . product . "small/" . $list['product_image']; ?>" alt="Image #1" onerror="this.src='<?php echo base_url() . 'assets/upload/No_Image.png'; ?>'"></img>
							<a herf="#" style="text-size:10px"><?php echo $list['product_name'].'=>'.$list['product_id']; ?></a></div>
							<div class="actions text-right">	
								<a class="btn box-remove btn-xs btn-link" href="#"><i class="icon-remove"></i></a>
								<a class="btn box-collapse btn-xs btn-link" href="#"><i></i></a>
							</div>								
						</div>	
						<?php 	$profile_picture='';
										if($list['profile_picture'] != ''){
											$profile_picture = base_url() . profile . "original/" .$list['profile_picture'];	
										}
                                        elseif($list['facebook_id'] != ''){
                                            $profile_picture = 'https://graph.facebook.com/'.$list['facebook_id'].'/picture?type=large';
                                        }elseif($list['twitter_id'] != ''){
                                            $profile_picture = 'https://twitter.com/'.$list['twitter_id'].'/profile_image?size=original';     
                                        }
										elseif($list['google_id'] != ''){
											$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$list['google_id'].'?alt=json');
											$d = json_decode($data);
											$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
										}
                         ?>
						<?php 
							$this->load->model('dbcommon', '', TRUE);
							$con	=	$this->dbcommon->get_conversation($list['product_id'],$current_user['user_id']);
						
						foreach($con as $c) {
							if($c['product_id']==$list['product_id']) {
							//if($user_id!=$list['receiver_id'] && $c['receiver_id']!=$list['receiver_id']) {  	
							if($c['sender_id']==$user_id) {  ?>	
							<div class="chat-outer reply"><!-- receiver loggin user-->logged in user
								<div class="chat-time"><i class="fa fa-clock-o"></i><?php echo $c['created_at']; ?> </div>
									<div class="chat-div">
										<div class="chat-img"><img src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"></div>
										<div class="chat-message alert-info">
											<span class="chatright-arrow"></span>
											<h4 class="chat-username"><?php echo $list['username']; ?></h4>		
											<p><?php echo $c['message'].'=>'.$c['con_id']; ?></p>
										</div>
									</div>	
							</div>								  
							<?php } else { ?>	
								<div class="chat-outer"><!-- sender-->
								<div class="chat-time"><i class="fa fa-clock-o"></i> <?php echo $c['created_at']; ?> </div>
									<div class="chat-div">
										<div class="chat-img"><img src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"></div>
										<div class="chat-message">
											<span class="chatleft-arrow"></span>
											<h4 class="chat-username"><?php echo $list['username']; ?></h4>		
											<p><?php echo $c['message'].'=>'.$c['con_id']; ?></p>
										</div>
									</div>	
								</div>
							<?php }  }  }  ?>		
							
					</div>	
				</div>	
			</div>
		</div>
		<br>			
		<br><?php } ?>						
				<br>
				<br>
				<br>
				<br>
			</div>													
		</div>
	</div>                           
</div>                      
</div>                    
</div>
</div>            
</div>        
            
			
			<?php $this->load->view('include/footer'); ?>        
    </div>

</body>
</html>
