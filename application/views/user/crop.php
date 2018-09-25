<html>
<head>
     <?php $this->load->view('include/head'); ?>	 
		<!-- <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css"> -->
		<!-- <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/bootstrap.min.css">  -->
		<link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/cropper.css">  
		<!-- <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/main.css"> -->
	 	<!-- <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> -->    
		<!-- <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/plugins/validate/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/plugins/validate/additional-methods.js"></script> 
		<link href="<?php echo base_url(); ?>assets/front/dist/css/bootstrap.css" rel="stylesheet">    
		<script src="<?php echo base_url(); ?>assets/front/dist/js/jquery.min.js"></script>    
		<script src="<?php echo base_url(); ?>assets/front/dist/js/bootstrap.min.js"></script>        -->
	 <style>
		.bdate {
			background-color: #fff;
			background-image: none;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
			color: #555;
			display: block;
			font-size: 14px;
			height: 34px;
			line-height: 1.42857;
			padding: 6px 12px;
			transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
			width: 100%;
		}		
		.modal-backdrop.fade.in {
		display:none;
		}
		.modal-dialog {
			width:800px !important;
		}
	
		img {
		  max-width: 100%;
		}

		.cropper-view-box,
		.cropper-face {
		  border-radius: 50%;
		}
  
	 </style>	 	 
<!--<link rel="stylesheet" type="text/css" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/cropimage.css" />
<link type="text/css" href="<?php echo site_url(); ?>assets/front/stylesheets/crop/imgareaselect-default.css" rel="stylesheet" /> 
<link type="text/css" href="<?php echo site_url(); ?>assets/front/stylesheets/jquery.Jcrop.min.css" rel="stylesheet" /> 
<link type="text/css" href="<?php echo site_url(); ?>assets/front/stylesheets/jquery.Jcrop.css" rel="stylesheet" />  
 <link type="text/css" href="<?php echo site_url(); ?>assets/front/stylesheets/bootstrap.min.css" rel="stylesheet" /> 
<link type="text/css" href="<?php echo site_url(); ?>assets/front/stylesheets/cropper.css" rel="stylesheet" />  -->

</head>

<body>
    <div class="container-fluid">
        <?php $this->load->view('include/header'); ?>		 
        <?php $this->load->view('include/menu'); ?>       
        <div class="page">          
			<div class="container">
				<div class="row">
            <?php $this->load->view('include/sub-header'); ?>          
            <div class="col-sm-12 main dashboard">
				<div class="row">
                    <!--cat-->
                   <?php $this->load->view('include/left-nav'); ?>
                     <?php //echo '<pre>';
                    //         print_r($current_user);
                    //         echo '</pre>';
                     ?>
                   <div class="col-sm-9 ContentRight"> 
                    <?php if (isset($msg) && !empty($msg)): ?>
                            <div class='alert <?php echo $msg_class; ?> text-center'>
                                <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                <?php echo $msg; ?>
                            </div>
                        <?php endif; ?>
                        <!--breadcrumb-->
                        <div class="row subcat-div no-padding">
                            <div class="col-sm-12">
                                <ol class="breadcrumb no-margin">
                                  <li><a href="<?php echo site_url().'home'; ?>">Home</a></li>
                                  <li><a href="<?php echo site_url().'user/index'; ?>">Dashboard</a></li>
                                  <li class="active">My Profile</li>
                                </ol>
                            </div>                              
                        </div>
                        <!--//-->
                        <!--row-->
                        <div class="row">
                            <div class="col-sm-12 profile-tabs">
                                <ul class="nav nav-tabs"><!--href="my_listing" -->
                                  <li role="presentation" class="active"><a href="#">My Profile</a></li>
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
                                <a class="active" href="<?php echo site_url().'user/inbox_products'; ?>"><span class="fa fa-envelope"></span>Inbox <?php echo '('.$inbox_count.')'; ?></a>
                            </div>
                        </div>
                        <!--//row-->
                        <div class="row profile">
						
							<?php 
							// $data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/111179230316776211184?alt=json');
							// $d = json_decode($data);
							// $avatar = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
							
							//$email                  =      "hda.narola@gmail.com";
							//list($id, $domain) = split("@",$email);
							// $headers = get_headers("https://profiles.google.com/s2/photos/profile/111179230316776211184", 1);
							// $PicUrl = $headers['Location'];
							// print_r($PicUrl);
							?>
                      
						
						<?php 	$profile_picture='';
										if($current_user->profile_picture != ''){
											$profile_picture = base_url() . profile . "original/" .$current_user->profile_picture;	
										}
                                        elseif($current_user->facebook_id != ''){
                                            $profile_picture = 'https://graph.facebook.com/'.$current_user->facebook_id.'/picture?type=large';
                                        }elseif($current_user->twitter_id != ''){
                                            $profile_picture = 'https://twitter.com/'.$current_user->username.'/profile_image?size=original';     
                                        }
										elseif($current_user->google_id != ''){
											$data = file_get_contents('http://picasaweb.google.com/data/entry/api/user/'.$current_user->google_id.'?alt=json');
											$d = json_decode($data);
											$profile_picture = $d->{'entry'}->{'gphoto$thumbnail'}->{'$t'};
										}
                                 ?>
								 
						
                            <div class="col-sm-3 col-lg-3 text-center">								  
								  <!--<img src="<?php echo site_url();?>assets/upload/profile/original/1453192767.jpeg" class='preview' height='80%' width='80%' id='target'> -->
                                <!--<img src="<?php //echo site_url(); ?>/Timthumb.php?src=<?php //echo site_url(); ?>/assets/upload/profile/original/<?php //echo $current_user->profile_picture; ?>&w=200&h=200&q=100"  />	-->
								<img src="<?php echo $profile_picture; ?>" class="img-responsive img-circle" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" id="upload_image" alt="Profile Picture" />								
								
								<!-- <img src="<?php //echo $profile_picture; ?>"  /> -->
                                <!--<input type="file" name="profile_picture" id="profile_picture" />-->
								<!--<input type="file" name="profile_name" id="profile_name" /> -->
								<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url().'user/upload_trial'; ?>'>
									<input type="file" name="photoimg" id="photoimg" />
								</form>
									<div class="row">
									  <div class="col-sm-6">									
										<div>
										  <img class="img-responsive" id="image" src="<?php echo site_url(); ?>assets/upload/profile/original/1453206005.jpeg" alt="Picture">
										</div>
									  </div>
									  <div class="col-sm-6">
										<h3 class="page-header">Result</h3>
										<button type="button" class="btn btn-primary" id="button">Crop</button>
										<div id="result"></div>
									  </div>
									</div>
								
                            </div>
							  <form name="profile_form" id="profile_form" method="post" class="form form-horizontal validate-form" enctype="multipart/form-data"  action="<?php echo base_url(); ?>user/index" onsubmit="return  submit_call();">
                            <div class="col-sm-6 col-lg-5">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3><?php if($current_user->nick_name!=''): echo $current_user->nick_name; else: echo $current_user->username; endif; ?></h3>
                                    </div>
                                    <div class="col-sm-6 text-right">
                                        <p class="followers"><?php echo ($current_user->followers_count !='')? $current_user->followers_count : 0 ; ?> Followers</p>
                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>User Name</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="username"  id="username" class="form-control" value="<?php echo $current_user->username; ?>" data-rule-required='true'/>
                                                </div>                                                
                                            </div>
											<div class="form-group">
												<div class="col-sm-4">
                                                    <label>Nick Name</label>
                                                </div>
												<div class="col-sm-8">
													<input type="text" class="form-control" placeholder="Nick Name" name="nick_name" id="nick_name"  value="<?php echo $current_user->nick_name; ?>"/>
												</div>	
											</div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>Address</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <?php
                                                    $address = '';
                                                        if($current_user->address!='')
                                                            $address .= $current_user->address;
                                                        
                                                    /*    if($current_user->city!='')
                                                            $address .= ($address!='')? ', '.$current_user->city : $current_user->city;
                                                    
                                                        if($current_user->state!='')
                                                            $address .= ($address!='')? ', '.$current_user->state_name : $current_user->state_name;

                                                        if($current_user->country!='')
                                                            $address .= ($address!='')? ', '.$current_user->country_name : $current_user->country_name;
                                                     */   
                                                    ?>
                                                    <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                                                </div>                                                
                                            </div>
											 <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>Nationality</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="location" id="location" onchange="javascript:show_emirates(this);">
													<?php foreach ($location as $loc) { ?>
                                                           <option <?php if($current_user->country == $loc['country_id']) echo 'selected'; ?> value="<?php echo $loc['country_id']; ?>"><?php echo $loc['country_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>Emirate</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="city" id="sub_state_list" >    <?php foreach ($cities as $city) { ?>
                                                           <option <?php if($current_user->state == $city['state_id']) echo 'selected'; ?> value="<?php echo $city['state_id']; ?>_<?php echo $city['state_name']; ?>"><?php echo $city['state_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>Email</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="email" name="email" readonly="readonly" class="form-control" value="<?php echo $current_user->email_id; ?>"/>
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4" style="padding-right: 0;">
                                                    <label>Contact Number <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <input type="text" name="phone" data-rule-required='true' class="form-control" value="<?php echo $current_user->phone; ?>" onkeypress="return isNumber1(event)"/>
                                                </div>                                                
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <label>Gender</label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <select class="form-control" name="gender">
                                                        <option value="1" <?php if($current_user->gender==1) echo 'selected'; ?>>Male</option>
                                                        <option value="0" <?php if($current_user->gender==0) echo 'selected'; ?>>Female</option>
                                                    </select>
                                                </div>                                                
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-4">
                                                    <label>Birth Date</label>
                                                </div>  
                                                <div class="col-sm-8">
                                                    <!--<input type="text" id="start_date" placeholder='Date of Birth' name="date_of_birth" class="form-control" value="<?php //if(isset($current_user->date_of_birth)) echo $current_user->date_of_birth; ?>" /> -->
													<div class='datetimepicker input-group' id='datepicker'>					
														<input class='form-control bdate' data-format='yyyy-MM-dd' name="date_of_birth"  id="date_of_birth" placeholder='Select Birth Date' type='text' value="<?php if(isset($current_user->date_of_birth)) echo $current_user->date_of_birth; ?>" id="date_of_birth" ><span class='input-group-addon'><i class="fa fa-calendar"></i></span>			
													</div>
													<font color="#b94a48"><label id="lbl_dbo"></label></font>
                                                </div>
                                            </div>
											<?php  if($sub_set==0): ?>
                                            <div class="form-group">
												<div class="col-sm-4">                                                    
                                                </div>  
												 <div class="col-sm-8">
													<label><input name="subscription" type="checkbox" />Newletter Subscription</label>
												</div>
                                            </div>
											<?php endif; ?>
											<?php  if($chat==0): ?>
											<div class="form-group">
												<div class="col-sm-4">                                                    
                                                </div>  
												 <div class="col-sm-8">													
													<label><input name="notification" type="checkbox" value=1 />Email Chat Notification</label>
												</div>
                                            </div>
											<?php endif; ?>
                                            <div class="form-group">
                                                    <button name="submit" class="btn btn-blue" >Update</button>
                                                    <button type="submit" name="delete" class="btn btn-blue btn-del" onclick="return confirm('Are you sure you want to delete this account?');">Delete Account</button>
                                                    <!-- <a class="delete-account" href="#">Delete My Account</a> -->
                                            </div>
                                    </div>
                                </div>                                
                            </div>
							</form>

                            <div class="col-sm-3 col-lg-3 col-lg-offset-1">
                                <!-- <div class="form-group">
                                    <button class="btn btn-blue btn-block">Account Setting</button>
                                </div> -->
                                <div class="form-group">                                    
									<a href="<?php echo site_url().'privacy'; ?>" class="btn btn-blue btn-block">Privacy </a>
                                </div>
                                <div class="ads-left text-center">
                                    <img src="<?php echo base_url() ?>assets/front/images/ads_left.png" alt="Image">
                                    <h3><span><?php echo $current_user->userAdsLeft; ?></span> Ads Left</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!--//content-->
            </div>
			<div id="dummyModal" role="dialog" class="modal fade">
			<div class="modal-dialog">
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" data-dismiss="modal" class="close">&times;</button>
				  <h4 class="modal-title">Crop your Image</h4>
				</div>
				<div class="modal-body">
					<form name="thumbnail" action="<?php echo base_url() ?>user/upload_crop_image" method="post">
				<div class="crop_set_preview">
					<div class="crop_preview_left"> 
						<div class="crop_preview_box_big" id='viewimage'> 					
						</div>
							
					</div>					
					<div class="crop_preview_right">						
						<div class="crop_preview_box_small" id='thumbviewimage' style="position:relative; overflow:hidden;"> </div>
							
							<div class="docs-preview clearfix">
							  <div class="img-preview preview-lg"></div>          
							</div>
							<!-- <div class='img-container' style='height:150px; width:150px;'><img id='image1' src='<?php echo site_url(); ?>assets/upload/profile/original/picture.jpg' alt='Picture' height='200px' width='200px'></div> -->
							<!-- <img src="<?php echo site_url(); ?>assets/upload/profile/original/1453206005.jpeg" class="img-responsive" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" id="target7"/> -->
							 <div class="docs-data">
							  <div class="input-group input-group-sm">
								<label class="input-group-addon" for="dataX">X</label>
								<input type="text" class="form-control" id="dataX" placeholder="x">
								<span class="input-group-addon">px</span>
							  </div>
							  <div class="input-group input-group-sm">
								<label class="input-group-addon" for="dataY">Y</label>
								<input type="text" class="form-control" id="dataY" placeholder="y">
								<span class="input-group-addon">px</span>
							  </div>
							  <div class="input-group input-group-sm">
								<label class="input-group-addon" for="dataWidth">Width</label>
								<input type="text" class="form-control" id="dataWidth" placeholder="width">
								<span class="input-group-addon">px</span>
							  </div>
							  <div class="input-group input-group-sm">
								<label class="input-group-addon" for="dataHeight">Height</label>
								<input type="text" class="form-control" id="dataHeight" placeholder="height">
								<span class="input-group-addon">px</span>
							  </div>
							  <div class="input-group input-group-sm">
								<label class="input-group-addon" for="dataRotate">Rotate</label>
								<input type="text" class="form-control" id="dataRotate" placeholder="rotate">
								<span class="input-group-addon">deg</span>
							  </div>
							  <div class="input-group input-group-sm">
								<label class="input-group-addon" for="dataScaleX">ScaleX</label>
								<input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
							  </div>
							  <div class="input-group input-group-sm">
								<label class="input-group-addon" for="dataScaleY">ScaleY</label>
								<input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
							  </div>
							</div>
							<input type="text" name="x1" value="" id="x1" />
							<input type="text" name="y1" value="" id="y1" />
							<input type="text" name="x2" value="" id="x2" />
							<input type="text" name="y2" value="" id="y2" />
							<input type="text" name="w" value="" id="w" />
							<input type="text" name="h" value="" id="h" />
							<input type="text" name="wr" value="" id="wr" />
							<input type="text" name="myfilename" value="" id="myfilename" />							
							<input type="text" name="filename" value="" id="filename" />							
					</div>
				</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-blue" id="save_thumb" onclick="myFunction()">Upload Image</button>				  
					<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>				  
				</div>				
				</form>
			  </div>
			</div>
		  </div>
				</div>
			</div>
        </div>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="<?php echo site_url(); ?>/assets/front/javascripts/crop/bootstrap.min.js"></script>
<script src="<?php echo site_url(); ?>/assets/front/javascripts/crop/cropper.js"></script>
<script src="<?php echo site_url(); ?>/assets/front/javascripts/crop/main.js"></script>
<script src="<?php echo site_url(); ?>assets/front/dist/js/bootstrap.min.js"></script>
<!--<script src="<?php echo site_url(); ?>assets/front/dist/js/jquery.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery.mobile.custom.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-migrate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/crop/cropper.js" type="text/javascript"></script>
<script src="<?php echo site_url(); ?>assets/front/javascripts/crop/jquery.imgareaselect.js"></script>
<script src="<?php echo site_url(); ?>assets/front/javascripts/crop/jquery.Jcrop.js"></script>
<script src="<?php echo site_url(); ?>assets/front/javascripts/crop/jquery.color.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/crop/jquery.form.js"></script>
<script type="text/javascript">
function myFunction() {
    alert("call");
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		var myfilename = $('#myfilename').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("Please Make a Selection First");
			return false;
		}else{
			
			var url = "<?php echo base_url() ?>user/upload_crop_image";
			$.post(url, {x1: x1, y1: y1,x2:x2,y2:y2,w:w,h:h,myfilename:myfilename}, function(response)
			{    
				$("#dummyModal").modal('hide');
				//$(".modal-open").css('display','none');
				$(".imgareaselect-outer").css('display','none');
				console.log(response);
				if(response=='success')
				{	
					
					alert("success");
					// var loc	=	'<?php echo base_url() . profile."/original" ?>'+"/"+myfilename;
					// $('#upload_image').attr("src",loc);
				}
			  /*if(response.trim()=='Success' ||  response.trim()=='failure')
				$('#err_div').hide();
			  else
			  {
				$("#send-message-popup").modal('show');
				$('#err_div').show();
				$("#error_msg").text(response);         
			  } */
			}); 
		}
}
$(document).ready(function(){ 
	
	
 
	$('#photoimg').live('change', function() { 		
		$("#preview").html('');
		$("#preview").html('<img src="loader.gif" alt="Uploading...." />');
		$("#imageform").ajaxForm({			 			
			success:   showResponse 		
		}).submit();  
		
	});
	function showResponse(data, statusText, xhr, $form){		
		$('#dummyModal').modal('show');
		
		//var i			=	data.indexOf("<");		
		var real_name	=	data;
		//data.slice(0, i);		
		//var real_data	=	data.slice(1, i);
							
		/*var response_data	=	"<div class='img-container' style='height:150px; width:150px;'><img src=<?php echo site_url(); ?>"+"assets/upload/profile/thumb/"+real_name+" class='preview' height='250px' width='250px' id='image'></div>";	 */
		var response_data	=	"<div class='img-container' style='height:150px; width:150px;'><img id='image' src='<?php echo site_url(); ?>assets/upload/profile/original/picture.jpg' alt='Picture' height='200px' width='200px'></div>";			
	    if(data.indexOf('.')>0){			
			$("#myfilename").val(real_name);
		//	$('#thumbviewimage').html("<img src=<?php echo site_url(); ?>assets/upload/profile/thumb/" +real_name+" class='' height='250px' width='250px' id='target'>");
	    	$('#viewimage').html(real_name);
	    	$('#filename').val(real_name); 	
			$('#target').load(function(){	
				/*$('#target').Jcrop({      
				  bgOpacity: 0.5,
				  bgColor: 'white',
				  addClass: 'jcrop-light'
				},function(){
				  api = this;
				  //api.setSelect([20,20,130+350,65+285]);
				  api.setSelect([20,20,100,65]);
				  api.setOptions({ bgFade: true });
				  api.ui.selection.addClass('jcrop-selection');
				}); */
			});
			//$('#target').imgAreaSelect({  aspectRatio: '1:1', handles: true  , onSelectChange: preview});
		}else{
			$('#thumbviewimage').html(response_data);
	    	$('#viewimage').html(response_data);
		}
    }
	

	function processJson(data) {    
		alert("it worked" + data);
		console.log("respose: " + data);
	}
	function showRequest(formData, jqForm, options) {    
		var queryString = $.param(formData);
		console.log('About to submit: \n' + queryString + '\n');
		return true;
	} 
	
}); 
	function upload_image() {
		alert("call");
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		var myfilename = $('#myfilename').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("Please Make a Selection First");
			return false;
		}else{
			
			var url = "<?php echo base_url() ?>user/upload_crop_image";
			$.post(url, {x1: x1, y1: y1,x2:x2,y2:y2,w:w,h:h,myfilename:myfilename}, function(response)
			{    
			$("#send-message-popup").modal('hide');
				console.log(response);
				if(response=='success')
				{	
					
					alert("success");
					//var loc	=	'<?php echo base_url() . profile."/original" ?>'+"/"+myfilename;
					//$('#upload_image').attr("src",loc);
				}
			  /*if(response.trim()=='Success' ||  response.trim()=='failure')
				$('#err_div').hide();
			  else
			  {
				$("#send-message-popup").modal('show');
				$('#err_div').show();
				$("#error_msg").text(response);         
			  } */
			}); 
		}
	}	
<?php 
$thumb_width	=	150;
$thumb_height	=	150;
?>
/*
function preview(img, selection) { 	
	//alert(selection);
	console.log(selection);
	var scaleX = <?php echo $thumb_width;?> / selection.width; 
	var scaleY = <?php echo $thumb_height;?> / selection.height; 
	
	$('#thumbviewimage > img').css({
		width: Math.round(scaleX * img.width) + 'px', 
		height: Math.round(scaleY * img.height) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
	
	var x1 = Math.round((img.naturalWidth/img.width)*selection.x1);
	var y1 = Math.round((img.naturalHeight/img.height)*selection.y1);
	var x2 = Math.round(x1+selection.width);
	var y2 = Math.round(y1+selection.height);
	
	$('#x1').val(x1);	
	$('#y1').val(y1);
	$('#x2').val(x2);
	$('#y2').val(y2);	
	
	$('#w').val(Math.round((img.naturalWidth/img.width)*selection.width));
	$('#h').val(Math.round((img.naturalHeight/img.height)*selection.height));
} */

</script>
<!-- <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script> -->

</body>
</html>
