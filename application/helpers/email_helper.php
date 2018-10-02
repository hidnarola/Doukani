<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('send_mail')) {

    function send_mail($to, $subject, $body, $send_from = NULL) {
        $CI = & get_instance();
        $CI->load->library('My_PHPMailer');
        $mail = new PHPMailer();
        $mail->IsSMTP(); // we are going to use SMTP
        $mail->SMTPAuth = true; // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
        $mail->Host = "smtp.zoho.com";      // setting GMail as our SMTP server
        $mail->Port = 465;     // SMTP port to connect to GMail
        $mail->Transport = 'Smtp';
//	$mail->SMTPDebug = true;
        $tit = 'Doukani Support Team';

        $mail->Password = "doukani$11";
        if ($send_from == NULL) {
//            $mail->Username = "info@doukani.com";  // user email address		
//            $mail->SetFrom('info@doukani.com', $tit);  //Who is sending the email
            $mail->Username = "support@doukani.com";  // user email address		
            $mail->SetFrom('support@doukani.com', $tit);  //Who is sending the email
            //$mail->AddReplyTo('support@doukani.com',$tit);  //email address that receives the response
            $mail->Password = "doukani$115@9H";
        } elseif ($send_from == 'hello@doukani.com') {

            $mail->Username = $send_from;
            $mail->SetFrom($send_from, $tit);
        } elseif ($send_from == 'stores@doukani.com') {

            $mail->Username = $send_from;
            $mail->SetFrom($send_from, $tit);
        } elseif ($send_from == 'info@doukani.com') {

            $mail->Username = $send_from;
            $mail->SetFrom($send_from, $tit);
        }


        $mail->IsHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        if (is_array($to)) {
            foreach ($to as $ad) {
                $mail->AddAddress(trim($ad));
            }
        } else
            $mail->AddAddress(trim($to));

        if (!$mail->send()) {
            return 0;
        } else {
            return 1;
        }

        /* $CI = & get_instance();
          $CI->load->library('My_PHPMailer');
          $mail = new PHPMailer();
          $mail->IsSMTP(); // we are going to use SMTP
          $mail->SMTPAuth = true; // enabled SMTP authentication
          $mail->SMTPSecure = "ssl";  // prefix for secure protocol to connect to the server
          $mail->Host = "smtp.gmail.com";      // setting GMail as our SMTP server
          $mail->Port = 465;     // SMTP port to connect to GMail
          $mail->Username = "demo.narola@gmail.com";  // user email address
          $mail->Password = "Ke6g7sE70Orq3Rqaqa";	    // password in GMail
          //	$mail->Username = 'photos@iphotographs.com';
          //	$mail->Password = 'success123';
          $mail->Transport = 'Smtp';
          $mail->SetFrom('info@classifiedapp.com', 'Doukani Support Team');  //Who is sending the email
          $mail->AddReplyTo("info@classifiedapp.com", "Doukani Support Team");  //email address that receives the response
          $mail->IsHTML(true);
          $mail->Subject = $subject;
          $mail->Body = $body;
          $mail->AddAddress($to);
          if (!$mail->send()) {
          return 0;
          } else {
          return 1;
          } */
    }

}

function mail_config() {
    $configs = array(
        'protocol' => 'ssl',
        'smtp_host' => 'smtp.zoho.com',
        'smtp_user' => 'support@doukani.com',
        'smtp_pass' => 'doukani$11',
        'smtp_port' => '465',
        'mailtype' => 'html',
        'wordwrap' => TRUE,
    );
    return $configs;
}
