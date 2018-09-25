<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct() {
        parent::__construct();    
        $this->load->model('dbcommon', '', TRUE);    
    }
	
	public function deactivate_products()
	{	
		//run daily 1 time	
            //for Calssified , Store Ads
            $this->dbcommon->deactivate_ads();                
            $this->dbcommon->update_deactivate_ads();
        
            //For Offer Ads
            $this->dbcommon->deactivate_offer_ads();
            $this->dbcommon->update_deactivate_offer_ads();
        
		$data	=	array('id'=>NULL,'created_date'=>date('y-m-d H:i:s', time()));
		$this->dbcommon->insert('trial', $data);
		//to remove images 
		$d	=	explode('/',APPPATH);				
		$source_folder	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/'.product.'original';
		$this->dbcommon->glob_files($source_folder);	
		
		//delete video 
		$source_folder	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/'.product.'video';
		$this->dbcommon->deletevideo_files($source_folder);	
		
		//delete thumbnail of uploaded video		
		$source_folder	=	$d[0].'/'.$d[1].'/'.$d[2].'/'.$d[3].'/classified_application/assets/upload/profile/thumb';
		$this->dbcommon->deleteuserimg_files($source_folder);	
	}
	
	public function users_ads_update()
	{
            //run on 1sy day of every month
            $this->dbcommon->users_ds_update();
	}

	/*
		it will run once a week at midnight on Sunday morning
	*/
	public function delete_convesation() {

            $this->dbcommon->delete_buyer_seller_conversation();
            $this->dbcommon->user_cart_delete();                
	}
}

// http://doukani.com/cron/deactivate_products run daily
// http://doukani.com/cron/users_ads_update //run on 1st day of month