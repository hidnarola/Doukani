<?php if(isset($myfollowers) && sizeof($myfollowers)>0) { ?>
        <?php foreach ($myfollowers as $follower) { ?>
        <li>
            <?php
                $profile_picture = $this->dbcommon->load_picture($follower['profile_picture'], $follower['facebook_id'], $follower['twitter_id'], $follower['username'], $follower['google_id'], 'medium', 'user-follower');
            ?>
            <img class="img-responsive img-square" height="100" width="100" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'" alt="Profile Image">
            <p><?php 
                if ($follower['nick_name'] != ''): 
                    echo $follower['nick_name'];
                else: 
                    echo $follower['username'];
                endif; 
                ?>
            </p>
        </li>
        <?php } 
} ?>