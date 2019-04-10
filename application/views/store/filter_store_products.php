<input type="hidden" name="load_more_status1" id="load_more_status1" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
<?php
if (isset($product_view) && $product_view == 'list') {
    $this->load->view('store/store_product_list_view');
} else {
    $this->load->view('store/product_store_grid_view');
}

if (@$hide == "false") {
    $total_pages = ceil($total_product/100);
    $initial_pages = 10;
    if($total_pages < $initial_pages){
        $initial_pages = $total_pages;
    }

    $display_pagination = " display: none;";
    if($total_pages > 0){
        $display_pagination = "";
    }
?>
<div id="page-selection" style="text-align: center;<?php echo $display_pagination; ?>"></div>
<?php } 
//if (@$hide == "false") {
    ?>
    <!-- <div class="col-sm-12 text-center" id="load_more">
        <button class="btn btn-blue" onclick="load_more_jquerylisting();" id="load_product1" value="0">Load More</button><br><br><br>
    </div> -->
<?php //} ?>
<div id="loading" style="text-align:center" class="loader_display">
    <img id="loading-image" src="<?php echo HTTPS . website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
</div>
<script>
    function load_more_jquerylisting() {
        $("#load_product1").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
        $('#load_product1').prop('disabled', true);
        var load_more_status1 = $('#load_more_status1').val();
        var cat_id = $('#categories').val();
        var url = "<?php echo site_url(); ?>home/load_more_storelisting_for_home/";
        var start1 = $("#load_product1").val();
        start1++;
        $("#load_product1").val(start1);
        var user_id = $("#user_id").val();
        var product_view = $('#product_view').val();
        var type = $('#search').val();
        var val1 = start1;

        if (load_more_status1 == 'false') {
            $.post(url, {cat_id: cat_id, value: val1, user_id: user_id, product_view: product_view, type: type, state_id_selection: state_id_selection}, function (response)
            {
                $('#load_more_status1').val(response.val);

                $("#load_more").before(response.html);
                if (response.val == "true")
                    $("#load_product1").hide();

                $('#load_product1').prop('disabled', false);
                $("#load_product1").html('Load More');

            }, "json");
        }
    }
</script>
<script type="text/javascript">
            //add to cart button
                                                $('.add_to_cart_cus').click(function () {
                                                   var proid= $(this).attr('proid');
                                                   var qat=  $(this).attr('quantity');
                                                   console.log(proid);
                                                   console.log(qat);
                                                    check_product_quantity(proid,qat);
                                                    $("i."+proid).removeClass('fa-shopping-cart');
                                                    $("i."+proid).addClass('fa-check');
                                                });


                                                function check_product_quantity(proid,qat) {

                                                    var product_id = $('#cart_product_id').val();
                                                    var quantity = $('#quantity').val();

                                                    var url = "<?php echo $store_url; ?>home/check_product_and_quantity";

                                                    $.post(url, {quantity: qat, product_id: proid}, function (response)
                                                    {
                                                        if (response == 'success') {
                                                            $('#span_error').hide();

                                                            var url = "<?php echo $store_url; ?>cart/add_to_cart";
                                                            var quantity = $('#quantity').val();
                                                            var cart_product_id = $('#cart_product_id').val();

                                                            $.post(url, {quantity: qat, cart_product_id: proid}, function (response)
                                                            {
                                                                //                                    $('#cart_count').text(response);
                                                                $('.total-no').text(response);
                                                                $('.cart-li').show();
                                                            });
                                                          //  $("#quantity_popup").modal('hide');
                                                        } else {
                                                            if (response == 'Out of stock' || response == 'Not Available') {
                                                             //   $('#span_error').show();
                                                               // $('#span_error').text('* ' + response);
                                                                return 0;
                                                            } else
                                                            {
                                                             //   $('#span_error').show();
                                                             //   $('#span_error').text('* ' + response + ' Available in Stock');

                                                                //reset dropdown
                                                                var availability = parseInt(response);
                                                                var i = 1;
                                                                var concat_str = '';

                                                                while (i <= availability) {
                                                                    concat_str = concat_str + '<option value="' + i + '">' + i + '</option>';
                                                                    i++;
                                                                }

                                                                $("#quantity").html(concat_str);
                                                                return 0;
                                                            }

                                                        }
                                                    });
                                                }
            </script>