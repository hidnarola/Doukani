<head>
    <?php $this->load->view('include/head'); ?>
    <?php $this->load->view('include/google_tab_manager_head'); ?>
</head>
<?php
if (isset($product_list) && sizeof($product_list) > 0) {
    echo '<table border=1>';
    echo '<tr>';
    echo '<td>Image</td>';
    echo '<td>Title</td>';
    echo '<td>Price</td>';
    echo '<td>Qunatity</td>';
    echo '<td>Total</td>';
    echo '</tr>';
    $sub_total = 0;
    foreach ($product_list as $prod) {

        echo '<tr id="data_row_' . $prod['product_id'] . '">';
        echo '<td>';
        if (!empty($prod['product_image']))
            $cover_image = product.'medium/' . $prod['product_image'];
        else
            $cover_image = base_url() . 'assets/upload/No_Image.png';
        echo '<img src="' . $cover_image . '"  alt="'.$prod['product_name'].'">';
        echo '</td>';
        echo '<td>';
        echo '<a href="' . HTTP . $prod['store_domain'] . '.' . website_url . $prod['product_slug'] . '">' . $prod['product_name'] . '</a>';
        echo '</td>';
        echo '<td id="price_' . $prod["product_id"] . '">';
        echo $prod['product_price'];
        echo '</td>';
        echo '<td>';
        $qunatity = $this->dbcart->get_quantity_incart($prod['product_id']);
        ?>
        <select class="form-control qunatity_dropdown" id="quantity_<?php echo $prod['product_id']; ?>" name="quantity_<?php echo $prod['product_id']; ?>">
            <?php $i = 1;
            while ($i <= $prod['stock_availability']) {
                ?>
                <option value="<?php echo $i; ?>" <?php if ($i == $qunatity) echo 'selected=selected'; ?>  ><?php echo $i; ?> </option>
                <?php
                $i++;
            }
            ?>
        </select>
        <?php
        echo '</td>';
        echo '<td id="total_' . $prod['product_id'] . '">';
        echo $total = $prod['product_price'] * $qunatity;
        $sub_total += $total;
        echo '</td>';
        echo '<td>';
        echo '<a href="javascript:void(0);" class="delete_product" id="delete_product_' . $prod['product_id'] . '">Delete</a>';
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';

        echo '</td>';
        echo '</tr>';
    }
    echo '<tr><td></td></tr>';
    echo '<tr><td colspan="4">Sub-total</td><td><label id="sub_total" class="sub_total">' . $sub_total . '</label></td></tr>';
    echo '</table>';

    echo '<br>';
    echo '<br>';
}
?>
<script>
    $(document).on("change", ".qunatity_dropdown", function (e) {

        var product_id_name = $(this).attr('id');
        var product_id = product_id_name.split("_").pop();
        var quantity = $('#quantity_' + product_id).val();

        var price = $('#price_' + product_id).text();
        var answer = parseFloat(price) * parseInt(quantity);

        $('#total_' + product_id).text(answer);
        get_subtotal();
    });

    $(document).on("click", ".delete_product", function (e) {

        var product_id_name = $(this).attr('id');
        var product_id = product_id_name.split("_").pop();
        var quantity = $('#quantity_' + product_id).val();

        //pass product_id and qunatity
        var url = "<?php echo base_url(); ?>cart/delete_product";

        $.post(url, {quantity: quantity, product_id: product_id}, function (response)
        {
            get_subtotal();
            if (response == 'success')
                $('#data_row_' + product_id).hide();
            else
                window.location = "<?php echo HTTPS . doukani_website; ?>";
        });

    });

    function get_subtotal() {
        var sub_total = 0;

        $('.qunatity_dropdown').each(function (i, obj) {
            var dropdown = $(this).attr('id');
            var get_product_id = dropdown.split("_").pop();
            var get_quantity = $('#quantity_' + get_product_id).val();

            var get_price = $('#price_' + get_product_id).text();
            var get_answer = parseFloat(get_price) * parseInt(get_quantity);

            sub_total = sub_total + get_answer;
            $('#sub_total').text(sub_total);

        });
    }
</script>