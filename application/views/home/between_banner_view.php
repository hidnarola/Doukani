<?php   
   $this->load->view('home/between_banner_update');
   $between_banner_url = '';
   if(!empty($between_banners[0]['site_url'])){
       if(strpos($between_banners[0]['site_url'], 'http://') !== false || strpos($between_banners[0]['site_url'], 'https://') !== false){
           $between_banner_url = 'href="' . $between_banners[0]['site_url'] . '" target="_blank"';
       }else{
        $between_banner_url = 'href="http://' . $between_banners[0]['site_url'] . '" target="_blank"';
       }
   }
   if($between_banners[0]['ban_txt_img']=='image') { ?>
   <a <?php echo $between_banner_url; ?> onclick="javascript:update_count('<?php echo $between_banners[0]['ban_id']; ?>')" rel="nofollow"><img src="<?php echo HTTPS.website_url; ?>assets/upload/banner/original/<?php echo $between_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner" /></a>
   <?php   } 

      elseif($between_banners[0]['ban_txt_img']=='text') {  ?>
         <a <?php echo $between_banner_url; ?> onclick="javascript:update_count('<?php echo $between_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block" rel="nofollow">
            <div class="">
               <?php 
                  echo $between_banners[0]['text_val'];
               ?>
            </div>
         </a>
<?php } ?>