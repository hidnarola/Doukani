<div class="cart-table">
    <div class="cart-table-bg">
        <div class="checkout-page" id="place_order" style="display:none;">
            <div class="row">            
                <div class="col-sm-12 col-md-8 checkout-address">
                    <?php
                    $this->load->view('cart/address_form');
                    ?>
                </div>
                <div class="col-sm-12 col-md-4 your-orders">
                    <div class="side-block">
                        <h2>Place Order</h2>
                        <div class="panel-body totle-count">
                            <h3>Cart Totals</h3>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td id="sub_total_value"></td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Cost</td>
                                        <td id="shipping_cost_value"><?php echo 'AED ' . number_format($shipping_total, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total</td>
                                        <td id="final_total"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="side-block">
                        <div class="panel-body sell-opt payment_method_div">
                            <h2>Payment Method</h2>
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div id="add_error"></div>
                                <form id="place_order_form">
                                    <input type="hidden" name="address_id" id="address_id" value="<?php echo $last_address_id; ?>">
                                    <button class="btn blue-btn" name="place_my_order" id="place_my_order" type="button">Cash On Delivery</button>
                                </form>
                                <div class="payment_method_or">OR</div>
                                <div class="pay_now_btn">
                                    <a id="paytabs" href="javascript:void(0);" class="btn blue-btn">Pay Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body sell-opt">
                            <?php if (sizeof($other_page_links) > 0) { ?>
                                <ul class="cart-pages-link">
                                    <?php
                                    foreach ($other_page_links as $link) {
                                        $url = HTTPS . website_url . $link['slug_url'];
                                        if ($link['direct_url'] != '')
                                            $url = $link['direct_url'];

                                        if ($link['page_id'] == 29) {
                                            ?>
                                            <li style="margin:0 0 11px;"><a href="<?php echo $url; ?>"><i class="fa fa-edit" style="background-color:<?php echo $link['color']; ?>" ></i><br><span><?php echo $link['page_title']; ?></span></a></li>
                                        <?php } if ($link['page_id'] == 10) { ?>
                                            <li style="margin:0 0 11px;"><a href="<?php echo $url; ?>"><i class="fa fa-list-alt" style="background-color:<?php echo $link['color']; ?>;"></i><br><span><?php echo $link['page_title']; ?></span></a></li>
                                        <?php } if ($link['page_id'] == 11) { ?>
                                            <li style="margin:0 0 11px;"><a href="<?php echo $url; ?>"><i class="fa fa-user-secret" style="background-color:<?php echo $link['color']; ?>;"></i><br><span><?php echo $link['page_title']; ?></span></a></li>
                                                    <?php } ?>
                                                <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>                
                    </div>
                </div>
            </div>
        </div>   
    </div>
</body>
<script>
    $(document).on("click", ".address-radio", function () {
        var add_id = $(this).val();
        $('#address_id').val(add_id);
    });

    $(document).on("keypress", "#customer_name", function (evt) {
        var keyCode = (evt.which) ? evt.which : evt.keyCode;
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32 && keyCode != 8 && keyCode != 37 && keyCode != 38 && keyCode != 39 && keyCode != 40 && keyCode != 9)
            return false;
        return true;
    });

    $(document).on("keypress", "#contact_number", function (evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 8 && charCode != 37 && charCode != 38 && charCode != 39 && charCode != 40 && charCode != 9)
            return false;
        return true;
    });

    $(document).on("click", "#place_my_order", function (e) {
        $('.loader_display').show();
        var address_id = $('#address_id').val();
        if (address_id != '') {
            var url = "<?php echo site_url() . 'cart/place_order'; ?>";
            $.post(url, {address_id: address_id, success: 'success'}, function (response) {
//                console.log(response); return false;
                if (response == 'success')
                    window.location = "<?php echo site_url() . 'cart/success'; ?>";
                else
                    window.location = "<?php echo site_url() . 'cart'; ?>";
            });
        } else {
            $('.loader_display').hide();
            $('#add_error').show();
            $('#add_error').html('Please enter Address');
            return false;
        }
    });

//    $(document).on("click", "#paypal", function (e) {
//        $('.loader_display').show();
//        var address_id = $('#address_id').val();
//        if (address_id != '') {
//            var url = "<?php echo site_url() . 'payment/checkout_request'; ?>";
//            $.post(url, {address_id: address_id, success: 'success'}, function (response) {
//                window.location = response;
//            });
//        }
//        else {
//            $('.loader_display').hide();
//            $('#add_error').show();
//            $('#add_error').html('Please enter Address');
//            return false;
//        }
//        
//    });

    $(document).on("click", "#paytabs", function (e) {
        $('.loader_display').show();
        var address_id = $('#address_id').val();
        if (address_id != '') {
            var url = "<?php echo site_url() . 'paytabs_payment/get_url'; ?>";
            $.post(url, {address_id: address_id, success: 'success'}, function (response) {
//                console.log(response);
//                return false;
                window.location = response;
            });
        } else {
            $('.loader_display').hide();
            $('#add_error').show();
            $('#add_error').html('Please enter Address');
            return false;
        }

    });

    $(document).on("click", "#create_new", function (e) {
        $('.form-control').val('');
        $('#shipping_form').show();
    });

    $(document).on("click", "#cancel_new", function (e) {
        $('.form-control').val('');
        $('#shipping_form').hide();
    });

    $(document).on("click", ".deleteadd", function (e) {

        $('.loader_display').show();
        var control_id = $(this).attr('id');
        var address_id = control_id.split("_").pop();

        var url = "<?php echo base_url(); ?>cart/delete_address";
        $.post(url, {address_id: address_id}, function (response) {
            var existing_add = $('#address_id').val();

            if (response == 'success') {
                if (address_id == existing_add)
                    $('#address_id').val('');
                $('#span_' + address_id).hide();
            }

            $('.loader_display').hide();

        });
    });

    $(document).on("click", ".editadd", function (e) {

        $('.loader_display').show();

        var control_id = $(this).attr('id');
        var address_id = control_id.split("_").pop();

        var url = "<?php echo base_url(); ?>cart/edit_shipping_address";
        $.post(url, {address_id: address_id}, function (response) {
            var obj = jQuery.parseJSON(response);

            $('#shipping_form').show();
            $('#customer_name').val(obj.customer_name);
            $('#request_address_id').val(address_id);
            $('#address_1').val(obj.address_1);
            $('#address_2').val(obj.address_2);
            $('#state_id').val(obj.state_id);
            $('#po_box').val(obj.po_box);
            $('#contact_number').val(obj.contact_number);
            $('#email_id').val(obj.email_id);
            $('.loader_display').hide();
        });
    });

    function add_list(addr) {

        var url = "<?php echo base_url(); ?>cart/shipping_addr_list";
        $.post(url, {}, function (response)
        {

            $("#shipping_addresses_list").html('');
            $("#shipping_addresses_list").before(response.html);
            $(document).find('#address_select_' + addr).prop("checked", "checked");
        }, "json");
    }

    jQuery(document).ready(function ($) {

        $("#shipping_form").validate({
            rules: {
                customer_name: "required",
                contact_number: "required",
                email_id: {
                    required: true,
                    email: true
                },
                address_1: "required",
                state_id: "required",
//                po_box: "required",
            },
            messages: {
                customer_name: "Please enter Name",
                contact_number: "Please enter Contact Number",
                email_id: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address"
                },
                address_1: "Please enter Address 1",
                state_id: "Please select state"
            },
            submitHandler: function (form) {

                $('.loader_display').show();

                var customer_name = $('#customer_name').val();
                var address_1 = $('#address_1').val();
                var address_2 = $('#address_2').val();
                var state_id = $('#state_id').val();
                var po_box = $('#po_box').val();
                var contact_number = $('#contact_number').val();
                var address_id = $('#request_address_id').val();
                var email_id = $('#email_id').val();

                var url = "<?php echo base_url(); ?>cart/add_edit_shipping_address";

                $.post(url, {customer_name: customer_name, address_1: address_1, address_2: address_2, state_id: state_id, po_box: po_box, contact_number: contact_number, address_id: address_id, email_id: email_id}, function (response) {

                    var addr = response;
                    $('.loader_display').hide();
                    $('#shipping_addresses_list').show();
                    add_list(addr);
                    $('#address_id').val(addr);
                    $('.form-control').val('');
                    $('#shipping_form').hide();
                });
            }
        });
    });
</script>
</html>