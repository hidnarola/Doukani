<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <?php $this->load->view('include/head'); ?>
        <style>
            .catlist {margin-top: 45px;}
            .list-icons01 a {margin-top:10px;}            
        </style>
    </head>
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
                        <div class="col-sm-12 main category-grid">
                            <?php $this->load->view('include/left-nav'); ?>
                            <div class="col-sm-9 ContentRight">
                                <?php $this->load->view('home/seller_profile'); ?>
                                <br>
                                <?php $this->load->view('home/seller_common'); ?>
                                <br>	
                                <br>	
                                <div class="row <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') echo'horizontalList'; else echo 'most-viewed'; ?>">
                                    <div id="most-viewed">
                                        <?php 
                                            if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                                                $this->load->view('home/product_listing_view');
                                            else                                        
                                                $this->load->view('home/product_grid_view'); 
                                        ?>
                                        <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                        <?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br><br>
                                            </div>
                                        <?php } ?>		
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--//main-->
        </div>
        <!--footer-->
        <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    <script type="text/javascript">
        $('.ShowNumber').click(function () {
<?php if ($user->phone != '') { ?>
                $(this).find('.show_number').text('<?php echo $user->phone; ?>');
<?php } else { ?>
                $(this).find('.show_number').text('<?php echo $user->contact_number; ?>');
<?php } ?>
        });

        $("#formReportAds").validate({
            rules: {
                message: "required"
            },
            messages: {
                message: "Please enter a message"
            },
            submitHandler: function (form) {
                form.submit();
                $('#send-message-popup').modal('hide');
            }
        });

        function load_more_data() {

            $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
            $('#load_product').prop('disabled', true);
            var load_more_status = $('#load_more_status').val();
            
<?php if (isset($_REQUEST['order'])) { ?>
                var order = '<?php echo $_REQUEST['order']; ?>';
<?php } else { ?>
                var order = '';
<?php } ?>

            var url = "<?php echo base_url(); ?>seller/more_seller_products";
            var start = $("#load_product").val();
            start++;
            
            var view='';
            <?php if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                view = 'list';
            <?php } ?>
                        
            $("#load_product").val(start);
            var user_id = $("#user_id").val();
            var val = start;
            if(load_more_status=='false') {
                $.post(url, {value: val, user_id: user_id, order: order,state_id_selection:state_id_selection,view:view}, function (response) {
                    
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
    <!--container-->
</body>
</html>