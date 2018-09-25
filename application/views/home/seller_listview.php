<!DOCTYPE html>
<html lang="en">
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
                        <div class="col-sm-12 main category-grid">
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <!--content-->
                            <div class="col-sm-9 ContentRight">
                                <?php $this->load->view('home/seller_profile'); ?>
                                <?php if ($this->session->flashdata('msg1')): ?>
                                    <div class='alert  alert-info'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $this->session->flashdata('msg1'); ?>
                                    </div>
                                <?php endif; ?>
                                <br>
                                <?php $this->load->view('home/seller_common'); ?>
                                <br>
                                <div class="row horizontalList">
                                    <div class="catlist">
                                        <?php $this->load->view('home/product_listing_view'); ?>
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
                        <!--//content-->
                    </div>
                </div>
            </div>
        </div>
        <!--//main-->
    <!--footer-->
    <?php $this->load->view('include/footer'); ?>
    <!--//footer-->

<script type="text/javascript">

    $('div.navigation').css({'float': 'left'});
    $('button.mybtn').click(function () {
        $(this).find('.show_number').text('');
    });
    $('div.content').css('display', 'block');
    
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

        $("#load_product").val(start);
        var user_id = $("#user_id").val();
        var val = start;
        if(load_more_status=='false') {
            $.post(url, {value: val, user_id: user_id, view: "list", order: order,state_id_selection:state_id_selection}, function (response)
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