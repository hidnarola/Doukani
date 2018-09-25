<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <style>
            .follower_list li {background: #FFF;}
        </style>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>			
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="store-page">
                    <div class="container">
                        <div class="row">
                            <?php $this->load->view('include/sub-header'); ?>
                            <div class="mainContent">
                                <input type="hidden" name="search" id="search">
                                <input type="hidden" name="product_view" id="product_view" value="grid">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $store_user[0]->user_id; ?>">                         
                                <?php $this->load->view('store/store_common'); ?>
                                <div class="store-products-wrapper">
                                    <div class="store-products-head">      
                                        <h2><?php echo $store[0]->store_name . '\'s Store'; ?>
                                            <span class="since_line">(Since <?php echo $store_user_regidate; ?>)</span></h2>
                                    </div>     
                                    <div class="catlist">
                                        <h3>Followers</h3>
                                        <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                        <div class="store-products-list-wrapper" style="text-align:center;">
                                            <?php if (!empty($myfollowers)) { ?>
                                            <ul class="catlist followers_tbl follower_list ">
                                                <?php foreach ($myfollowers as $follower) { ?>
                                                <li>
                                                    <?php
                                                        $profile_picture = $this->dbcommon->load_picture($follower['profile_picture'], $follower['facebook_id'], $follower['twitter_id'], $follower['username'], $follower['google_id'], 'medium', 'user-follower');
                                                    ?>
                                                    <img class="img-responsive img-square" height="100" width="100" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo HTTPS.website_url; ?>assets/upload/avtar.png'" alt="Profile Image">
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
                                                
                                                    if (@$hide == "false") { ?>
                                                    <div class="col-sm-12 text-center loding-btn" id="load_more">
                                                        <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button>
                                                    </div>
                                                <?php } ?>
                                            </ul>
                                            <?php }  else { ?>
                                            <p>There are no followers to list.</p>
                                            <?php } ?>
                                        </div>
                                        <br>
                                        <br>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>        
            <?php $this->load->view('store/store_common_div'); ?>
            <?php $this->load->view('include/footer'); ?>
        </div>        
<?php
$mypath_ = $store_url;
?>
        <script type="text/javascript">           
            function load_more_data() {

                $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_product').prop('disabled', true);
                var load_more_status = $('#load_more_status').val();
                
                var url = "<?php echo $mypath_; ?>seller/more_followers";
                var start = $("#load_product").val();
                start++;
                $("#load_product").val(start);
                var user_id = $("#user_id").val();
                var val = start;
                //$('#loading').show();
                if(load_more_status=='false') {
                    $.post(url, {value: val, user_id: user_id,request_from:'store_followers_page'}, function (response)
                    { 
                        $('#load_more_status').val(response.val);

                        $("#load_more").before(response.html);
                        if (response.val == "true")
                            $("#load_product").hide();
                        
                        $('#load_product').prop('disabled', false);
                        $("#load_product").html('Load More');
                        
                    }, "json");
                }
            }
        </script>
    </body>
</html>
