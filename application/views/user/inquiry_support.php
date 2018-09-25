<html>
    <head>
        <?php $this->load->view('include/head'); ?>   
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script> 	   
        <script>
            $(function () {
                window.emojiPicker = new EmojiPicker({
                    emojiable_selector: '[data-emojiable=true]',
                    assetsPath: 'lib/img/',
                    popupButtonClasses: 'fa fa-smile-o'
                });
                window.emojiPicker.discover();
            });
        </script>
    </head>

    <style>	
        .alert-info .user-img-t {
            left: 0px !important;
            position:auto !important;
            top:0px !important;		
        }

        *{margin:0; padding:0;}
        body{ margin:0; padding:0; font-family: 'Roboto', sans-serif; font-weight:400;}
        .custome-chat {  margin: 0;}
        .custome-chat ul{ list-style:none;}

        .custome-chat ul li{ display:block; width:100%; margin:0 0 20px; position:relative; z-index:10; padding: 15px;   background: #eee; max-width: 1000px;}
        .first-chat{ display:inline-block; width:100%; margin:0 0 20px; z-index:12; position:relative;}
        .first-chat h4{color:#333; font-size:16px; line-height:100%; margin:10px 0 10px; padding:0; font-weight:700; display:inline-block;}
        .first-chat p{ color:#999; font-size:13px; line-height:100%; margin:0 0 10px; padding:0; font-weight:400;}
        .first-chat-img{ float:left; width:80px; height:80px; border:1px solid #ccc; background:#ddd; margin:0 15px 0 0; -webkit-border-radius:80px; -moz-border-radius:80px; -o-border-radius:80px; border-radius:80px;}
        .first-chat-img img{ width:80px; height:80px; -webkit-border-radius:80px; -moz-border-radius:80px; -o-border-radius:80px; border-radius:80px;}

        .grounp-comments:after{ content:""; width:1px; height:100%; background:#ccc; position:absolute; left:-43px; bottom:50%; z-index:-1;}
        .grounp-comments + .grounp-comments:after{ height:120%;}
        .grounp-comments:before{ content:""; width:0px; height:1px; background:#ccc; position:absolute; left:-43px; top:50%; z-index:-1;}
        .grounp-comments{ border:1px solid #ccc; border-left:4px solid #bbb; min-width:800px; margin:15px 24px 15px 20px; padding:10px; display:inline-block; vertical-aling:top; position:relative; z-index:10; -webkit-border-radius:8px; -moz-border-radius:8px; -o-border-radius:8px; border-radius:8px; background:#fff;}
        .grounp-comments-icons{ float:left; position:relative;  margin: 0 15px 15px 0;}
        .grounp-comments-img{ width:60px; height:60px; background:#fff; border:1px solid #ddd; -webkit-border-radius:60px; -moz-border-radius:40px; -o-border-radius:40px; border-radius:40px;}
        .grounp-comments-img img{-webkit-border-radius:40px; -moz-border-radius:40px; -o-border-radius:40px; border-radius:40px; width:100%; height:100%;}
        .grounp-comments-icons span{ position:absolute; top:0; right:-2px; width:12px; height:12px; display:block; -webkit-border-radius:50px; -moz-border-radius:50px; -o-border-radius:50px; border-radius:50px;}
        .grounp-comments-icons span.online{  background:green;}
        .grounp-comments-icons span.offline{ background:grey;}

        .grounp-comments p{ font-size:13px; color:#333; line-height:normal; margin: 0 0 15px;}

        .grounp-comments-right{ float:left; width:83%;}
        .user-name{ margin:0 0 0px; display:inline-block; vertical-align:top; width:100%;}
        .user-name h5{ float:left; color:#333; font-size:14px; font-weight:700; margin:0; padding:0;}
        .user-name h6{ float:right; color:#999; font-size:13px; font-weight:400; margin:0; padding:0;}

        .comment-function p{ display:inline-block; vertical-align:top; margin:0 10px 0 0;}
        .comment-function p a{ color:#999; font-size:13px; text-decoration:none; line-height: 18px; }
        .comment-function p a:hover{ color:red;}

        .comment-replay{ position:relative; width:100%; display:inline-block;} 
        .comment-replay input[type="text"]{ background:#fff; border:1px solid #ddd; padding:3px 5px 7px 12px; 
                                            line-height:20px; float:left; width:68%; height:32px; color:#333; text-transform:capitalize;}
        .comment-replay button{ width:20%; float:left; background:#034694; border:0; color:#fff; height:32px; text-transform:uppercase; line-height:28px; cursor:pointer;}
        /*.comment-replay button:hover{ background:} */
        .data-icon{ float:right; margin:0 0 0 10px;}
        .data-icon a{ color:#034694; font-size:14px;}
        .data-icon a:hover{ color:#034694;}
        .data-icon i{ padding:0;}

        .show-commentbox { position: absolute; right:10px; top:12px; z-index:100;}
        .show-commentbox a{ color:#333; font-size:18px;} 
        .show-commentbox a:hover{ color:#034694; }

        .comment-box-01{}
        .sent-comment{ position: absolute; right:0; bottom:0; margin: 0;}		
        .comment-box-01 + .comment-box-01 .grounp-comments:after{ height:150%;}
        #send-message-popup .alert-info { background-color: #eaeaea;}

        @media (min-width:768px) and (max-width:991px){
            .grounp-comments {  min-width: 460px;}
            .grounp-comments-right { width: 81%;}
            .comment-replay input[type="text"] { width: 64%;}
        }
        @media(max-width:767px){
            .first-chat { text-align: center;}
            .custome-chat { margin: 80px auto; padding: 0 15px; width: auto;}
            .first-chat-img { float: none; margin: 0 auto 15px; width: 80px;}
            .grounp-comments::after,
            .grounp-comments::before{ display:none;}
            .grounp-comments { min-width: auto; width: 100%; margin:0 0 15px;}
            .grounp-comments-right { float: none; width: 100%;}
            .comment-replay input[type="text"]{ width:60%;}
            .comment-replay button{ width:auto; padding:0 10px;}
            .show-commentbox { position: absolute; right: 10px; top: 29px; z-index: 100;}

            .grounp-comments-icons { float: none; margin: 0 auto 20px; position: relative; text-align: center;}
            .grounp-comments-img {margin: 0 auto; }
            .grounp-comments-right { text-align: center;}
            .user-name { display: inline-block; text-align: center; }
            .user-name h5 { float: none; margin: 0 0 10px;}
            .user-name h6 {float: left;}
            .sent-comment { color: #999; display:inline-block; margin:0; padding:10px 0 5px; position:relative; right:0; top:0;}
            .custome-chat { margin: 0 auto; padding: 0; width: auto;}	
            .custome-chat ul + br,
            .custome-chat ul + br + br,
            .custome-chat ul + br + br + br{ display:none;}
        }		
    </style>
    <script>

    </script> 
</head> 
<body>
    <?php $this->load->view('include/google_tab_manager_body'); ?>
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
                                    <li><a href="<?php echo site_url() . 'home'; ?>">Home</a></li>
                                    <li><a href="<?php echo site_url() . 'user/index'; ?>">Dashboard</a></li>
                                    <li class="active">Inbox</li>
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
                                <a class="active" href="<?php echo site_url() . '/user/inbox_products'; ?>"><span class="fa fa-envelope"></span>Inbox <span id="inbox_count"><?php echo '(' . $inbox_count . ')'; ?></span></a>
                                <input type="hidden" id="inbox_count_txt" value="<?php echo $inbox_count; ?>">
                            </div>
                        </div>		
                        <div id="loading" class="loader"></div>
                        <?php
                        foreach ($listing as $list) {
                            $this->load->model('dbcommon', '', TRUE);
                            $last_up = $this->dbcommon->last_up_inquiry($list['inquiry_id']);
                            //print_r($last_up);
                            ?>	
                            <div class="custome-chat">						
                                <ul>
                                    <li>	
                                        <div class="comment-box-01 comment-box-<?php echo $list['product_id']; ?>" style="">
                                            <div class="grounp-comments">									
                                                <div class="user-name">										
                                                    <h6><?php echo date('d-m-Y H:i', strtotime($last_up['message_post_time'])); ?></h6>
                                                </div>
                                                <div>										
                                                    <h4><?php echo $list['inquiry_subject']; ?></h4>	
                                                    <p><?php echo $last_up['message']; ?></p>										
                                                    <div class="comment-replay">											
                                                        <form class='form form-horizontaldefault_form' method="post" id="">												
                                                            <input type="text" placeholder="Reply here..." name="reply" maxlength="50" required="required">
                                                            <button type="submit" id="submit" class="submit">Reply</button>
                                                        </form>
                                                        <br><br>											
                                                        <div class="data-icon">
                                                            <a href="#" title="Convesation"><i class="fa fa-database"></i>&nbsp;Conversation</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                            <h6 align="right"  class="sent-comment">dfasdfasfd</h6>	
                                                        </div>
                                                    </div>										
                                                </div> 
                                            </div>
                                        </div>								
                                    </li>
                                </ul>
<?php } ?>	
                            <br>
                            <br>
                            <br>
                            <br>
                        </div>	
                    </div>
                    <nav class="col-sm-8 text-left">
<?php echo $links; ?>
                    </nav>			
                </div>
            </div>
        </div>                           
    </div>                      
</div>                    
</div>
</div>            
</div>  
<?php $this->load->view('include/footer'); ?>        
<div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">			
    <div class="modal-dialog modal-md" style="width:70%">
        <div class="modal-content rounded">
            <div class="modal-header text-center orange-background" style="background:#034694 none repeat scroll 0 0;  border-radius: 6px 6px 0 0;color: #fff;font-size: 18px;margin: -1px 0 0;padding: 10px; " >
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">
                    <i class="fa fa-close"></i>
                </button>
                <h4 id="myLargeModalLabel" class="modal-title"><i class="fa fa-envelope-o"></i> Conversation</h4>							
            </div>
            <div id="chat_mod"></div>
        </div>
    </div>
</div>	
<div id="loading" style="text-align:center">
    <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
</div>
</body>
</html>