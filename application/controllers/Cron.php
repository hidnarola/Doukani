<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('dbcommon', '', TRUE);
    }

    public function deactivate_ads() {

        $msg = "deactivate_ads";
        mail("kek@narola.email", "deactivate_ads cron", $msg);

        $data = array('function_name' => 'deactivate_ads - start', 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('cron_status', $data);

        $this->dbcommon->deactivate_ads();

        $data = array('function_name' => 'deactivate_ads - end', 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('cron_status', $data);
    }

    public function update_deactivate_ads() {
        
        $msg = "update_deactivate_ads";
        mail("kek@narola.email", "update_deactivate_ads cron", $msg);
        
        $data = array('function_name' => 'update_deactivate_ads - start', 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('cron_status', $data);

        $this->dbcommon->update_deactivate_ads();

        $data = array('function_name' => 'update_deactivate_ads - end', 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('cron_status', $data);
    }

    public function deactivate_offer_ads() {
        $msg = "deactivate_offer_ads";
        mail("kek@narola.email", "deactivate_offer_ads cron", $msg);
        
        $data = array('function_name' => 'deactivate_offer_ads - start', 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('cron_status', $data);

        $this->dbcommon->deactivate_offer_ads();

        $data = array('function_name' => 'deactivate_offer_ads - end', 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('cron_status', $data);
    }

    public function update_deactivate_offer_ads() {
        
        $msg = "update_deactivate_offer_ads";
        mail("kek@narola.email", "update_deactivate_offer_ads cron", $msg);
        
        $data = array('function_name' => 'update_deactivate_offer_ads - start', 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('cron_status', $data);

        $this->dbcommon->update_deactivate_offer_ads();

        $data = array('function_name' => 'update_deactivate_offer_ads - end', 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('cron_status', $data);
    }

//	public function deactivate_products()
//	{	
//            //run daily 1 time	
//            //for Calssified , Store Ads
//            
//            $this->dbcommon->update_deactivate_ads();
//        
//            //For Offer Ads
//            $this->dbcommon->deactivate_offer_ads();
//            $this->dbcommon->update_deactivate_offer_ads();
//        
//		$data	=	array('id'=>NULL,'created_date'=>date('y-m-d H:i:s', time()));
//		$this->dbcommon->insert('trial', $data);
////		//to remove images 
////		$d	=	explode('/',APPPATH);				
////		$source_folder	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/'.product.'original';
////		$this->dbcommon->glob_files($source_folder);	
////		
////		//delete video 
////		$source_folder	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/'.product.'video';
////		$this->dbcommon->deletevideo_files($source_folder);	
////		
////		//delete thumbnail of uploaded video		
////		$source_folder	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/assets/upload/profile/thumb';
////		$this->dbcommon->deleteuserimg_files($source_folder);	
//	}


    public function unlink_images() {

        $data = array('id' => NULL, 'created_date' => date('y-m-d H:i:s', time()));
        $this->dbcommon->insert('trial', $data);
        //to remove images 
        $d = explode('/', APPPATH);
        $source_folder = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'original';
        $this->dbcommon->glob_files($source_folder);

        //delete video 
        $source_folder = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'video';
        $this->dbcommon->deletevideo_files($source_folder);

        //delete thumbnail of uploaded video		
        $source_folder = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/assets/upload/profile/thumb';
        $this->dbcommon->deleteuserimg_files($source_folder);
    }

    public function users_ads_update() {
        //run on 1sy day of every month
        $this->dbcommon->users_ds_update();
    }

    /*
      it will run once a week at midnight on Sunday morning
     */

    public function delete_convesation() {
        
        $msg = "delete_convesation";
        mail("kek@narola.email", "delete_convesation cron", $msg);
        $this->dbcommon->delete_buyer_seller_conversation();
        $this->dbcommon->user_cart_delete();
    }

    public function remove_imgs() {
        $d = explode('/', APPPATH);
        $source_folder = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'original';
        $orig_images = scandir($source_folder);
        echo '<pre>';
        print_r($orig_images);
        exit;
    }

    public function remove_videos() {
        $d = explode('/', APPPATH);
        $source_folder = $d[0] . '/' . $d[1] . '/' . $d[2] . '/' . $d[3] . '/classified_application/' . product . 'video';
        $videos = scandir($source_folder);
        unset($videos[0]);
        unset($videos[1]);
        $videos = array_values($videos);

        $vids = $this->dbcommon->find_all_videos();
        $vids_del = array();
        foreach ($videos as $k => $v):
            if (in_array($v, $vids)) {
                
            } else {
                array_push($vids_del, $v);
                echo '/var/www/html/classified_application/assets/upload/product/video/' . $v;
                exit;
            }
        endforeach;
        echo '<pre>';
        print_r($vids_del);
        exit;
    }

}

// http://doukani.com/cron/deactivate_products run daily
// http://doukani.com/cron/users_ads_update //run on 1st day of month