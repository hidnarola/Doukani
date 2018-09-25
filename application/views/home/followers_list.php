<?php foreach ($myfollowers as $follower) { ?>
    <li <?php  if(isset($following_page) && $following_page == 'yes') { ?> id="<?php echo $follower['seller_id']; ?>"  class="follower_block follower_block_<?php echo $follower['seller_id']; ?>" <?php } else { ?>class="follower_block" <?php } ?> >
        <?php
        $profile_picture = $this->dbcommon->load_picture($follower['profile_picture'], $follower['facebook_id'], $follower['twitter_id'], $follower['username'], $follower['google_id'], 'medium', 'user-follower');
        ?>
        <img class="img-responsive img-square" height="100" width="100" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo HTTP . website_url; ?>assets/upload/avtar.png'" alt="Profile Image">
        <p><?php
            if ($follower['nick_name'] != ''):
                echo $follower['nick_name'];
            else:
                echo $follower['username'];
            endif;
            ?>
        </p>
        <?php if(isset($following_page) && $following_page == 'yes') { ?>
            <a href="javascript:void(0)" class="btn btn-block mybtn following_" id="<?php echo $follower['seller_id']; ?>_following" data-id="<?php echo $follower['seller_id']; ?>">Following</a>
        <?php } ?>
    </li>
<?php } ?>
<script>
    $(document).find('.follower_block').mouseover(function () {            
        var seller_id = $(document).find(this).attr('id');
        $(document).find('#'+seller_id+'_following').text('Un-follow');
    });

    $(document).find('.follower_block').mouseout(function () {            
        var seller_id = $(document).find(this).attr('id');        
        $(document).find('#'+seller_id+'_following').text('Following');
    });
    $(document).find('.following_').click(function () {        
        var user_id = $(document).find(this).attr('data-id');
        $(document).find('#'+user_id+'_following').prop('disabled', true);
        var url = "<?php echo site_url(); ?>seller/unfollow/"+ user_id;            
        $.post(url, {}, function (response) {
            $(document).find('.follower_block_'+user_id).hide();
            
        });
    });        
</script>