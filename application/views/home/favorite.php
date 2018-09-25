<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
    </head>
    <body>
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
                                <!--row-->
                                <?php $this->load->view('user/user_menu'); ?>                        
                                <!--Most Viewed product items-->
                                <div class="row most-viewed"><br>
                                    <?php $this->load->view('home/product_grid_view'); ?>
                                    <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                    <?php if (@$hide == "false") { ?>
                                        <div class="col-sm-12 text-center" id="load_more">
                                            <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br><br>
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
        <!--//footer-->
    </div>
    <script type="text/javascript" >

        function load_more_data() {

            $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
            $('#load_product').prop('disabled', true);
            var load_more_status = $('#load_more_status').val();
            
            var segment = $("#segment").val();
            if (segment == 'user')
                var url = "<?php echo base_url(); ?>user/more_favorite/";
            else
                var url = "<?php echo base_url(); ?>user/more_favorite/";
            var start = $("#load_product").val();
            start++;
            $("#load_product").val(start);
            var val1 = start;
            
            if(load_more_status=='false') {
                $.post(url, {value: val1}, function (response)
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
    <!--container-->
</body>
</html>
