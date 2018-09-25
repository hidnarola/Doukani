<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <style>
            .mynew a {color: #333;font-size: 20px;position: absolute;right: 10px;top: 40px;}
            .mynew1 a {color: #333;font-size: 20px;position: absolute;right: 15px;top: 60px;}
            button.close {background: transparent none repeat scroll 0 0;cursor: pointer;padding: 3px !important;}
            .modal-header{background-color:#ed1b33;color:white;}
            <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                .edit_option{position:inherit;}            
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
                                <h4>Deactivated Ads</h4>
                                <?php $this->load->view('user/listings_common'); ?>
                                <!--Most Viewed product items-->
                                <div class="row <?php if(isset($_REQUEST['view']) && $_REQUEST['view']=='list') echo 'horizontalList'; else echo 'most-viewed'; ?>"><br>
                                    <?php 
                                    if(isset($_REQUEST['view']) && $_REQUEST['view']=='list')
                                        $this->load->view('home/product_listing_view'); 
                                    else
                                        $this->load->view('home/product_grid_view'); 
                                    ?>
                                    <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                    <?php if (@$hide == "false") { ?>
                                        <div class="col-sm-12 text-center" id="load_more">
                                            <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br>
                                            <br/>                                
                                        </div>
                                    <?php } ?>	                            
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
        <!--//body-->
        <!--footer-->
        <?php $this->load->view('include/footer'); ?>
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
        <!--//footer-->
    </div>
    <script type="text/javascript" >

        function load_more_data() {

            $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
            $('#load_product').prop('disabled', true);
            
            var load_more_status = $('#load_more_status').val();
            var url = "<?php echo base_url(); ?>user/more_deactivateads";
            var start = $("#load_product").val();
            start++;
            $("#load_product").val(start);
            var val = start;
            var view = '';
            <?php if(isset($_REQUEST['view']) && $_REQUEST['view']=='list') { ?>
                view = 'list';    
            <?php } ?>
            if(load_more_status=='false') {
                $.post(url, {value: val,view:view}, function (response)
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
                if(val=='yes') {
                    
                    var url = "<?php echo base_url(); ?>user/removeproduct";
                    $.post(url, {prod_id: product_id}, function (data){                        
                        window.location = "<?php echo site_url().$_SERVER['REQUEST_URI']; ?>";
                    });
                }
            });            
        });

        function show(a)
        {
            $(".item-sell" + a).addClass("hover");
            $(".item-sell" + a).hover(function () {
                //console.log('here');
                $("#edit" + a).css("visibility", "visible");
                $("#edit1" + a).css("visibility", "visible");
                $("#mynew1" + a).css("visibility", "visible");
            },
                    function () {
                        //console.log('there');
                        $("#edit" + a).css("visibility", "hidden");
                        $("#edit1" + a).css("visibility", "hidden");
                        $("#mynew1" + a).css("visibility", "hidden");
                    });

        }

        $(".mynew1").css("visibility", "hidden");
        $(".mynew").css("visibility", "hidden");

    </script>
    <script>
        $(".item-sell").on({
            click: function () {
                $(this).toggleClass("active");
            }, mouseenter: function () {
                $(this).addClass("inside");
            }, mouseleave: function () {
                $(this).removeClass("inside");
            }
        });
    </script>
    <!--container-->
</body>
</html>