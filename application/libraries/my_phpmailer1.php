<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_PHPMailer1 {
    public function My_PHPMailer1() {
        echo 'calling';
        require_once('PHPMailer/PHPMailerAutoload.php');
    }
}

//if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//
//class Pay_tabs_verify_info {
//    public function Pay_tabs_verify_info() {
//        echo 'calling';
//    }
//}
// import paytabs class 
//require_once('PayTabs/PayTabs.php');

//class Pay_tabs_verify_info {
//
////make sure to set the right value in paytabs_config.php file
////create new paytabs object 
//    public function Pay_tabs_verify_info() {
////        $paytabs = new PayTabs();
////        print($paytabs->validate());
//    }
//
//}

?>