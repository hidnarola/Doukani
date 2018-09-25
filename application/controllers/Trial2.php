<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trial2 extends CI_Controller {

	public function __construct() {
        parent::__construct();    
        $this->load->model('dbcommon', '', TRUE);    
    }
	
    public function index() {
        
        $user_id = 122;
        $email_id = 'doukani0adonis@gmail.com';
        $sender_name = 'kesha';
        $mobile_no =  '123456';
                
        $button_label = 'Click here to login';
        $button_link = base_url() . "login/index";
        $question_title =  'how are you???';
        $sub_title =  'This is sub-title';
        $description = 'Now, When Store User hold his store 1st February and Active on 20 February. But Our system will deactivate on 15th February to this ad because duration is over.';
        $ad_link = 'http://doukani.com/privacy';
        $attachment_name = 'attachement name';
        $title   = $question_title;
        $file_name = '456322.jpg';
      /*  $content = '
       <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>
        <h6 style="font-family: Roboto, sans-serif; color:#ed1b33; font-size:20px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:800; text-transform:uppercase; display:block;">Request For</h6>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-size:17px; color:#333;">Title:'.$question_title.'</div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-size:15px; color:#666;">Subtitle:'.$sub_title.'<br></div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:10px; padding-right:0; padding-bottom:15px; padding-left:0; font-size:14px; color:#999;">Description:'.$description.'</div>
        
        <div style="margin-top:0; margin-right:0; margin-bottom:10px; margin-left:0; padding-top:10px; padding-right:20px; padding-bottom:10px; padding-left:20px; background:rgba(0, 0, 0, 0.04);">
        <h6 style="font-family: Roboto, sans-serif; color:#ed1b33; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:5px; padding-right:0; padding-bottom:10px; padding-left:0; font-weight:400;">Sender Details:</h6>
        
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Name:</span> '.$sender_name.' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333"> E-mail: </span> '.$email_id.' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:25px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333"> Mobile Number: </span> '.$mobile_no.'</div>
                  <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#333;">  Ad Link: '.$ad_link.' </div>
         <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#333;"> Attachment '.base64_encode($file_name).' </div>
</div>    
        </div>
';
      */
        
        $user_id = 122;
        $email_id = 'doukani0adonis@gmail.com';
        
        $button_label = 'Click here to login';
        $button_link = base_url() . "login/index";
        $sender_name = 'keshakapadia';
        $sender_email_id = 'keshakapadia';
        $message = 'Now, When Store User hold his store 1st February and Active on 20 February. But Our system will deactivate on 15th February to this ad because duration is over.';
        $activate_key = $this->my_encryption->safe_b64encode("123456789");
       
        $message = '';
        
        /*$title = 'Report For A Doukani Product';
        $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> <br>        
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Report from:</span> '.$sender_name.' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Email ID:</span> '.$sender_name.' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Report for Product:</span> '.$sender_name.' </div>        
            <br>
            <h6 style="font-family: Roboto, sans-serif; color:#7f7f7f; font-size:14px; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:6px; padding-left:0; font-weight:400;"><strong>Comment</strong></h6>
        <hr>
        <p>'.$message.'</p>
        </div>'; 
        
        echo $new_data = $this->dbcommon->mail_format($title,$content); */
        
        $title = 'Reply for your Ad';
                $content = '
        <div style="margin-top:-21; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:0; padding-left:0; width:416px; float: right; font-family: Roboto, sans-serif;"> 
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Ad Title:</span> '.$productName.' </div>
        <div style="margin-top:0; margin-right:0; margin-bottom:0; margin-left:0; padding-top:0; padding-right:0; padding-bottom:5px; padding-left:0; font-size:14px; color:#999;"> <span style="color:#333">Sender is :</span> '.$sender.' </div><br>
        <a style="background: #ed1b33 none repeat scroll 0 0;border-radius: 4px;color: #fff;display: inline-table;font-family: Roboto,sans-serif;font-size: 14px;font-weight: 400;height: 36px;line-height: 34px; padding-top:3px; padding-right:12px; padding-bottom:3px; padding-left:12px; text-align: center;text-decoration:none; width:156px; " href="' . $button_link . '">'.$button_label.'</a></div>';
                
        echo $new_data = $this->dbcommon->mail_format($title,$content); 
      }
}
?>