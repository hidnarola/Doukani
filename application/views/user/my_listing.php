<html>
    <head>
        <?php $this->load->view('include/head'); ?>   
          <?php $this->load->view('include/google_tab_manager_head'); ?>
        <style>
            button.close {background: transparent none repeat scroll 0 0;cursor: pointer;padding: 3px !important;}
            .modal-header{background-color:#ed1b33;color:white;}
            <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                .edit_option{position:inherit;}
                .most-viewed h3{margin:0 0 20px 0 !important;}
            <?php } ?>
        </style>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
        <div class="container-fluid">
            <!--ad1 header-->
            <?php $this->load->view('include/header'); ?>
            <!--//ad1 header-->
            <!--menu-->
            <?php $this->load->view('include/menu'); ?>
            <!--//menu-->
            <!--body-->
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main dashboard">
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <!--content-->
                            <div class="col-sm-10 ContentRight">                    	                      
                                <?php $this->load->view('user/user_menu'); ?>
                                <?php if (isset($msg)): ?>
                                    <div class='alert  alert-info'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <center><?php echo $msg; ?></center>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('flash_message') != ''): ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $this->session->flashdata('flash_message'); ?>
                                    </div>
                                <?php endif; ?>
                                <!--Most Viewed product items-->
                                <div class="row <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') echo'horizontalList';
                                else echo 'most-viewed'; ?>">
                                    <?php 
                                        $titl = '';
                                        if(isset($_REQUEST['val']) && $_REQUEST['val']=='Approve')
                                            $titl = 'Active';
                                        elseif(isset($_REQUEST['val']) && $_REQUEST['val']=='NeedReview') 
                                            $titl = 'Waiting for Approval';
                                        elseif(isset($_REQUEST['val']) && $_REQUEST['val']=='Unapprove')
                                            $titl = 'Unapprove';
                                        else
                                            $titl = 'Active';
                                    ?>
                                    <h4><?php echo $titl; ?> Ads</h4>
                                    <?php $this->load->view('user/listings_common'); ?>
                                    
                                    <div  id="most-viewed">
                                        <?php
                                        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                                            $this->load->view('home/product_listing_view');
                                        else
                                            $this->load->view('home/product_grid_view');
                                        ?>                                        
                                        <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
<?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button>
                                            </div>
<?php } ?>
                                    </div>
                                </div>
                                <!--End Most Viewed product items-->
                            </div>
                            <!--//content-->
                        </div>
                    </div>
                    <!--//main-->
                </div>
            </div>
        </div>
        <div class="modal fade sure" id="boostConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h4 class="modal-title"><i class="fa fa-shopping-cart"></i>Promote your ad
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </h4>                   
                    </div>
                    <div class="modal-body">
                        <!--<h4 class="modal-title">Doukani</h4>-->
                        <p>Are you sure want Boost this product !!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default yes_i_want" value="yes">Yes, I want</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade boost" id="boostModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="icn"><img src="<?php echo site_url() . 'assets/front/images/ads_left.png'; ?>" alt="" /></div>
                        <h4 class="left-ad"><?php echo $userAdsLeft; ?> Ads Left</h4>
                        <a class="boost-btn" id="buy_more_ads"><span class="ic"><i class="fa fa-bullhorn" aria-hidden="true"></i></span><span>Boost your ad</span></a>
                    </div>
                </div>
            </div>
        </div> 
        <div class="modal fade boost1" id="purchase_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm modal-purchase" role="document" >
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <!--              <button type="button" class="back"><i class="fa fa-caret-left"></i></button>              -->
                        <div class="icn"><i class="fa fa-bullhorn"></i></div>
                        <h4 class="boost-title">Promote Your Ad</h4>
                        <p class="boost-text">Your ad will remain on top of the list of it's category for:</p>
                        <input type="hidden" id="featured_ad_id" name="featured_ad_id">
                        <div class="ad-list">
                            <table class="table table-striped">
                                    <?php if (isset($featuredad_price) && sizeof($featuredad_price) > 0) { ?>
                                    <tbody>
    <?php foreach ($featuredad_price as $price) { ?>
                                            <tr>
                                                <td><h3 class="hour"><?php echo $price['hour_value']; ?> <span>Hours</span></h3></td>
                                                <td><div class="action">AED <span><?php echo $price['amount']; ?></span><br /><a href="javascript:void(0);" class="pur-btn purchase_ad_" id="<?php echo $price['hour_value']; ?>">Purchase</a></div></td>
                                            </tr>
                                        <?php }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade center" id="replyModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <form id="img_upload" name="img_upload" action="" method="post">			
                <div class="modal-dialog appup modal-md">
                    <div class="modal-content rounded">						
                        <div class="modal-header" style="">
                            <h4 class="modal-title"><i class="fa fa-info-circle"></i>Information
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>
                        </div>
                        <div class="modal-body text-center">
                            <a href="<?php echo doukani_app; ?>" name="app_url" id="app_url" target="_blank">
                                <img src="<?php echo site_url() . 'assets/front/images/iphone_icon.png'; ?>" alt="Image" >
                            </a>	
                            <h4>Use App to promote your item</h4>
                        </div>	
                    </div>
                </div>
            </form>
        </div>
        <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h4 class="modal-title"><i class="fa fa-check-square-o"></i>Confirmation
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </h4>                   
                    </div>
                    <div class="modal-body">                  
                        <p>Are you sure want delete this Ad?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade sure" id="ActiveConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h4 class="modal-title"><i class="fa fa-check-square-o"></i>Confirmation
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </h4>                   
                    </div>
                    <div class="modal-body">                  
                        <p>Are you sure want active this Ad?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default yes_active" value="yes">Yes, I want</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal fade sure" id="HoldConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h4 class="modal-title"><i class="fa fa-check-square-o"></i>Confirmation
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </h4>                   
                    </div>
                    <div class="modal-body">                  
                        <p>Are you sure want hold this Ad?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default yes_hold" value="yes">Yes, I want</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="loading" style="text-align:center" class="loader_display">
            <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
        </div>
        <!--//body-->        
        <!--footer-->
<?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    </div>
    <script type="text/javascript" >
        $(document).on("click", "#boost", function (e) {
            var product_id = $(document).find(this).attr('class');
            $(document).find('#featured_ad_id').val(product_id);
            $("#boostConfirm").modal('show');

            $(document).on("click", ".yes_i_want", function (e) {
                $(document).find('#boostConfirm').modal('hide');
                var val = $(this).val();
                if (val == 'yes') {
                    $(document).find("#boostModel").modal('show');
                    $(document).on("click", "#buy_more_ads", function (e) {
                        $(document).find('#boostModel').modal('hide');
                        $(document).find("#purchase_popup").modal('show');

                        $(document).on("click", ".purchase_ad_", function (e) {
                            $(document).find(".ad-list").html('<div style="text-align:center;"><img id="loading-image" src="<?php echo base_url(); ?>assets/front/images/ajax-loader.gif" alt="Loading..." /></div>');

                            var purchase_hour = $(this).attr('id');
                            var url = "<?php echo base_url(); ?>payment/boost_payment_request/";

                            $.post(url, {success: "success", purchase_hour: purchase_hour, product_id: product_id}, function (response) {
//                            return false;
                                window.location = response;
                            });

                        });
                    });
                }
            });
        });

        function load_more_data() {

            $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
            $('#load_product').prop('disabled', true);

            var load_more_status = $('#load_more_status').val();
            var url = "<?php echo base_url(); ?>user/load_more_mylisting/";
            var start = $("#load_product").val();
            start++;
            $("#load_product").val(start);
            var user_id = $("#user_id").val();
            var val = $("#val").val();
            var val1 = start;

<?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                var view = 'list';
<?php } else { ?>
                var view = 'grid';
<?php } ?>
            if (load_more_status == 'false') {
                $.post(url, {value: val1, user_id: user_id, val: val, view: view}, function (response)
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

        $(document).on("click", "#delet_user_ad", function (e) {
            var product_id = $(document).find(this).attr('class');
            $("#deleteConfirm").modal('show');
            $(document).on("click", ".yes_i_want_delete", function (e) {
                var val = $(this).val();
                if (val == 'yes') {
                    var url = "<?php echo base_url(); ?>user/removeproduct";
                    $.post(url, {prod_id: product_id}, function (data) {
                        window.location = "<?php echo site_url().$_SERVER['REQUEST_URI']; ?>";
                    });

                }
            });
        });
        $(document).on("click", "#active_pr", function (e) {
            var product_id = $(document).find(this).attr('class');
            $("#ActiveConfirm").modal('show');
            $(document).on("click", ".yes_active", function (e) {
                var val = $(this).val();
                if (val == 'yes') {
                    var url = "<?php echo base_url(); ?>user/updateproduct";
                    $.post(url, {prod_id: product_id}, function (data) {
                        window.location = "<?php echo site_url().$_SERVER['REQUEST_URI']; ?>";
                    });

                }
            });
        });
        $(document).on("click", "#hold_pr", function (e) {
            var product_id = $(document).find(this).attr('class');
            $("#HoldConfirm").modal('show');
            $(document).on("click", ".yes_hold", function (e) {
                var val = $(this).val();
                if (val == 'yes') {
                    var url = "<?php echo base_url(); ?>user/update_hold_product";
                    $.post(url, {prod_id: product_id}, function (data) {
                        window.location = "<?php echo site_url().$_SERVER['REQUEST_URI']; ?>";
                    });

                }
            });
        });
        
    </script>
    <!--container-->
</body>
</html>
