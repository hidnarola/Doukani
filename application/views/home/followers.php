<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <?php
    if (@$subcat_id == "")
        $subcat_id = 0;
    ?>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main category-grid">
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <!--content-->
                            <div class="col-sm-10 ContentRight">
                                <?php if((isset($my_followers) && $my_followers=='yes') || (isset($following) && $following=='yes')) {  
                                        $this->load->view('user/user_menu'); 
                                        
                                if(isset($my_followers) && $my_followers=='yes'){ ?>
                                    <h4> My Followers</h4>
                                <?php } else { ?>
                                    <h4>Following</h4>
                                <?php } }?>                                    
                                <div class="subcat-div">						
                                    <div class="row most-viewed">
                                        <div class="">                                
                                            <?php 
                                                if((isset($my_followers) && $my_followers=='yes') || (isset($following) && $following=='yes')) {   
                                                    echo '<input type="hidden" name="user_id" id="user_id" value="'.$user_id.'">';
                                                }
                                                else
                                                    $this->load->view('home/seller_profile'); 
                                            ?>
                                            <div class="catlist  col-sm-12 follower_list" style="margin:15px !important;">
                                                <div class="store-products-list-wrapper classified" style="text-align:center;">
                                            <?php if (!empty($myfollowers)) { ?>
                                            <ul class="catlist followers_tbl follower_list">
                                                <?php $this->load->view('home/followers_list'); ?>
                                                <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                                <?php if (@$hide == "false") { ?>
                                                    <div class="col-sm-12 text-center loding-btn" id="load_more">
                                                        <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button>
                                                    </div>
                                                <?php } ?>
                                            </ul>
                                            <?php }  else { ?>
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
                                        </div>     
                                                	
                                                <br><br>
                                            </div>
                                        </div>
                                    </div>
                                    <!--//-->
                                    <!-- end product --> 
                                </div>
                                <!--//content-->
                            </div>
                        </div>
                        <!--//main-->            
                    </div>
                    <!--//body-->               
                </div>
            </div>
            <!--footer-->
            <?php $this->load->view('include/footer'); ?>
            <!--//footer-->
        </div>
        <!--container-->
        <script type="text/javascript">            
            function load_more_data() {

                $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_product').prop('disabled', true);
                
                var load_more_status = $('#load_more_status').val();
                
                var url = "<?php echo base_url(); ?>seller/more_followers";
                var start = $("#load_product").val();
                start++;
                $("#load_product").val(start);
                var user_id = $("#user_id").val();
                var val = start;
                var following = '';
                <?php if($this->uri->segment(2)=='following') { ?>
                    following = 'yes'
                <?php } ?>
                                                    
                if(load_more_status=='false') {
                    $.post(url, {value: val, user_id: user_id,following:following}, function (response)
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