<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="store-details">
            <div class="container">
                <div class="row">
                    <?php $this->load->view('include/header'); ?>
                    <?php $this->load->view('include/menu'); ?>
                    <div class="mainContent">
                        <div class="cart-wrap">
                            <div class="inner-wrap">                                
                                <?php if ($this->session->flashdata('msg') != ''): ?>
                                    <div class='alert  alert-danger'>
                                        <a class='close' data-dismiss='alert' href='#'> &times; </a>
                                        <center><?php echo $this->session->flashdata('msg'); ?></center>
                                    </div>
                                <?php endif; ?>
                                <h3 class = "cart-title">My Cart</h3>
                                <div class = "forward">
                                    <span class = "next" id = "cart_next">Next <i class = "fa fa-arrow-right" aria-hidden = "true"></i>
                                    </span>
                                    <a href = "<?php echo HTTP . website_url . 'cart'; ?>" class = "back" id = "cart_back"><i class = "fa fa-arrow-left" aria-hidden = "true"></i> Back</a>
                                </div>
                                <div class = "clearfix"></div>
                                <div class = "cart-table-bg" id = "display_div">
                                    <div class = "cart-view">
                                        <div class = "table-responsive">
                                            <table class = "table">
                                                <thead>
                                                    <tr>
                                                        <th class = "cart-product-thumbnail cart-table-th">Product</th>
                                                        <th class = "cart-product-name cart-table-th"></th>
                                                        <th class = "cart-product-quantity cart-table-th">Quantity</th>
                                                        <th class = "cart-product-price cart-table-th">Price</th>
                                                        <th class = "cart-product-subtotal cart-table-th">Total</th>
                                                        <th class = "cart-product-remove cart-table-th">&nbsp;
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $sub_total = 0;
                                                    $__count_seller = '';
                                                    $not_valid_product = '';

                                                    foreach ($product_list as $prod) {

                                                        $qunatity = $this->dbcart->get_quantity_incart($prod['product_id']);

                                                        if ($prod['store_owner'] != $__count_seller) {
                                                            $__count_seller = $prod['store_owner'];
                                                            ?>
                                                            <tr>
                                                                <td colspan="3" class="seller-name-td">
                                                                    <span class="seller-name-cart"> Selling By: <?php echo $prod['store_name']; ?></span>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                        ?>
                                                        <tr class="cart_item" id="data_row_<?php echo $prod['product_id']; ?>">
                                                            <td class="cart-product-thumbnail">
                                                                <?php
                                                                if (!empty($prod['product_image']))
                                                                    $cover_image = base_url() . product . 'small/' . $prod['product_image'];
                                                                else
                                                                    $cover_image = base_url() . 'assets/upload/No_Image.png';
                                                                ?>
                                                                <a href="javascript:void(0);">
                                                                    <img src="<?php echo thumb_start_cart . $cover_image . thumb_end_cart; ?>"  alt="<?php echo $prod['product_name']; ?>" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'"/>
                                                                </a>
                                                            </td>
                                                            <td class="cart-product-name product_title"> 
                                                                <a href="<?php echo HTTP . $prod['store_domain'] . '.' . website_url . $prod['product_slug']; ?>" class="cart_product_link" >

                                                                    <?php echo $prod['product_name']; ?></a>
                                                                <span id="span_error_<?php echo $prod['product_id']; ?>" class="span_cart_error">
                                                                    <?php
                                                                    $product_status = 1;
                                                                    if (!empty($prod['session_product_status'])) {
                                                                        $product_status = 0;
                                                                        echo $prod['session_product_status'];
                                                                    } elseif ($qunatity > $prod['stock_availability']) {
                                                                        $product_status = 0;
                                                                        echo '* Only ' . $prod['stock_availability'] . ' Available in Stock';
                                                                    } else {
                                                                        $product_status = 1;
                                                                    }
                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td class="cart-product-quantity">
                                                                <div class="input-group quantity-wrapper">
                                                                    <?php if ($product_status == 1) { ?>
                                                                        <select class="form-control qunatity_dropdown" id="quantity_<?php echo $prod['product_id']; ?>" name="quantity_<?php echo $prod['product_id']; ?>">
                                                                            <?php
                                                                            $i = 1;
                                                                            while ($i <= $prod['stock_availability']) {
                                                                                ?>
                                                                                <option value="<?php echo $i; ?>" <?php if ($i == $qunatity) echo 'selected=selected'; ?>  ><?php echo $i; ?> </option>
                                                                                <?php
                                                                                $i++;
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <?php
                                                                    } else {
                                                                        echo 0;
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </td>
                                                            <td class="cart-product-price"  >AED <span class="amount" id="price_<?php echo $prod['product_id']; ?>"><?php echo number_format($prod['product_price'], 2); ?></span></td>
                                                            <td class="cart-product-subtotal"> 
                                                                AED <span class="amount" id="total_<?php echo $prod['product_id']; ?>">

                                                                    <?php
                                                                    if ($product_status == 1)
                                                                        $total = $prod['product_price'] * $qunatity;
                                                                    else
                                                                        $total = 0.00;

                                                                    echo number_format($total, 2);
                                                                    ?></span>
                                                                <?php
                                                                if ($product_status == 1)
                                                                    $sub_total += $total;
                                                                else
                                                                    $sub_total += 0.00;

                                                                if ($product_status != 1)
                                                                    $not_valid_product .= $prod['product_id'] . ',';
                                                                ?>
                                                            </td>
                                                            <td class="cart-product-remove"> <a class="delete_product remove" href="javascript:void(0);" id="delete_product_<?php echo $prod['product_id']; ?>">×</a></td>
                                                        </tr>								
                                                        <?php
                                                    }

                                                    //unset product id from session for cart
                                                    if (isset($not_valid_product) && !empty($not_valid_product)) {
                                                        $new_str = '';
                                                        $not_valid = explode(',', $not_valid_product);
                                                        $session_qunatity = $this->session->userdata('doukani_products');
                                                        $arr = explode(',', $session_qunatity);
                                                        foreach ($arr as $a) {

                                                            $arr = explode('-', $a);
                                                            if (isset($arr) && !empty($arr) && isset($arr[0]) && isset($arr[1])) {
                                                                if (in_array($arr[0], $not_valid)) {
                                                                    unset($arr);
                                                                } else {
                                                                    $new_str .= $arr[0] . '-' . $arr[1] . ',';
                                                                }
                                                            }
                                                        }

                                                        $this->session->set_userdata('doukani_products', $new_str);
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>  
                                        </div>
                                        <div class="panel-body totle-count">
                                            <h3>Cart Totals</h3>
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>Subtotal
                                                            <input type="hidden" value="<?php echo $sub_total; ?>" name="stotal" id="stotal" >
                                                        </td>
                                                        <td id="sub_total"><?php if (isset($sub_total)) echo 'AED ' . number_format($sub_total, 2); ?></td>
                                                    </tr>                      
                                                </tbody>
                                            </table>
                                            <form id="place_order_form">
                                                <?php if (isset($current_user) && !empty($current_user)) { ?> 
                                                    <button class="btn blue-btn cart-button" name="proceed" id="proceed" type="button">Proceed to checkout</button>
                                                <?php } else { ?>
                                                    <button class="btn blue-btn cart-button" name="login_cart" id="login_cart" type="button">Login</button>
                                                <?php } ?>                      
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>	
                </div>
            </div>
        </div>
        <?php $this->load->view('include/footer'); ?>
        <div id="loading" style="text-align:center" class="loader_display">
            <img id="loading-image" src="<?php echo static_image_path; ?>ajax-loader.gif" alt="Loading..." />
        </div>
        <script>

            $(document).on("click", "#login_cart", function (e) {
                window.location = '<?php echo HTTP . website_url . 'login/index'; ?>';
            });
            $('#cart_back').hide();

            function number_format(number, decimals, dec_point, thousands_sep) {
                // Strip all characters but numerical ones.
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                        s = '',
                        toFixedFix = function (n, prec) {
                            var k = Math.pow(10, prec);
                            return '' + Math.round(n * k) / k;
                        };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            }

            $('#place_order').hide();

            $(document).on("click", "#proceed", function (e) {
                $('#cart_back').show();
                $('#cart_next').hide();
                $('.loader_display').show();
                var url = "<?php echo base_url(); ?>cart/shipping_part";

                $.post(url, {step1: 'complete'}, function (response)
                {
                    var __sub_total = $('#stotal').val().replace(",", "");
                    $("#display_div").html('');
                    $("#display_div").before(response);

                    var shipping = $('#shipping_cost_value').text();
                    var __shipping_cost = shipping.replace("AED ", '');

                    $('#sub_total_value').html('AED ' + number_format(__sub_total, 2));
                    //$('#shipping_cost_value').html('AED ' + number_format(__shipping_cost));

                    var __final_total = parseFloat(__sub_total) + parseFloat(__shipping_cost);

                    $('#final_total').html('AED ' + number_format(__final_total, 2));

                    if (__final_total > 0) {
                    } else {
                        $(document).find('.payment_method_div').remove();
                    }

                    $('#place_order').show();
                    $('.loader_display').hide();
                });
            });
            /*
             Use while user chnage quantity 
             */
            $(document).on("change", ".qunatity_dropdown", function (e) {

                var product_id_name = $(this).attr('id');
                var product_id = product_id_name.split("_").pop();
                var quantity = $('#quantity_' + product_id).val();

                var url = "<?php echo base_url(); ?>home/check_product_and_quantity";

                $.post(url, {quantity: quantity, product_id: product_id}, function (response)
                {
                    if (response == 'success') {
                        var price = $('#price_' + product_id).text();
                        var answer = parseFloat(price.replace(",", "")) * parseInt(quantity.replace(",", ""));
                        $('#span_error_' + product_id).hide();
                        $('#total_' + product_id).text(number_format(answer, 2));
                    } else {
                        if (response == 'Out of stock' || response == 'Not Available') {
                            $('#span_error_' + product_id).show();
                            $('#span_error_' + product_id).text('* ' + response);
                        } else
                        {
                            $('#span_error_' + product_id).show();
                            $('#span_error_' + product_id).text('* Only ' + response + ' Available in Stock');
                            //reset dropdown
                            var availability = parseInt(response);
                            var i = 1;
                            var concat_str = '';
                            while (i <= availability) {
                                concat_str = concat_str + '<option value="' + i + '">' + i + '</option>';
                                i++;
                            }

                            $("#quantity_" + product_id).html(concat_str);

                            var price = $('#price_' + product_id).text().replace(",", "");
                            var answer = parseFloat(price) * 1;

                            $("#total_" + product_id).html(number_format(answer, 2));
                        }

                    }
                    get_subtotal();
                });
            });

            $(document).on("click", ".delete_product", function (e) {

                var product_id_name = $(this).attr('id');
                var product_id = product_id_name.split("_").pop();
                var quantity = $('#quantity_' + product_id).val();

                //pass product_id and qunatity
                var url = "<?php echo base_url(); ?>cart/delete_product";

                $.post(url, {quantity: quantity, product_id: product_id}, function (response)
                {
                    if (response == 'success')
                        $('#data_row_' + product_id).hide();
                    else
                        window.location = "<?php echo HTTPS . doukani_website; ?>";
                });
                get_subtotal();
            });

            function get_subtotal() {
                var sub_total = 0;

                $('.qunatity_dropdown').each(function (i, obj) {
                    var dropdown = $(this).attr('id');
                    var get_product_id = dropdown.split("_").pop();
                    var get_quantity = $('#quantity_' + get_product_id).val();

                    var get_price = $('#price_' + get_product_id).text().replace(",", "");
                    var get_answer = parseFloat(get_price) * parseInt(get_quantity);

                    sub_total = sub_total + get_answer;
                    $('#sub_total').text('AED ' + number_format(sub_total, 2));
                    $('#stotal').val(number_format(sub_total, 2));
                });
            }
        </script>
    </body>
</html>