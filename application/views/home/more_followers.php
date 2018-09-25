<?php if(!empty($myfollowers1)){ ?>
<table class="followers_tbl table table-striped table-bordered">                           
<tbody>
<?php
  foreach ($myfollowers1 as $follower) {
  ?>
<tr style="border-bottom: 1px solid #">
  <td>
    <?php 
      $profile_picture = '';
          $profile_picture =  $this->dbcommon->load_picture($follower['profile_picture'],$follower['facebook_id'],$follower['twitter_id'],$follower['username'],$follower['google_id'],'medium');
    ?>	
<img class="img-responsive img-square" height="100" width="100" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" alt="Profile Image" >
</td>
  <td><p><?php if($follower['nick_name']!=''): echo $follower['nick_name']; else: echo $follower['username']; endif; ?></p></td>
</tr>
<?php } ?>
</tbody>
</table>
<?php }else{ ?>
<div class="catlist col-sm-10">
        <div class="TagsList">
            <div class="subcats">
                <div class="col-sm-12 no-padding-xs">
                    <div class="col-sm-12">
                        There are no followers to list.
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p> </p>
<?php } ?>							

<!--container-->
</body>
</html>