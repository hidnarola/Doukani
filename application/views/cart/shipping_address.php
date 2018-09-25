<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <?php $this->load->view('include/head'); ?>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!-- list to display user added addresses-->
        <?php
        $this->load->view('cart/address_list');
        ?>

        <a id="create_new" href="javascript:void(0);">create new address</a>

        <?php
        $this->load->view('cart/address_form');
        ?>
        <div id="loading" style="text-align:center" class="loader_display">
            <img id="loading-image" src="<?php echo static_image_path; ?>ajax-loader.gif" alt="Loading..." />
        </div>
    </body>
    <script>

        $(document).on("click", "#create_new", function (e) {
            $('.form-control').val('');
            $('#shipping_form').show();
        });

        $(document).on("click", ".deleteadd", function (e) {

            $('.loader_display').show();
            var control_id = $(this).attr('id');
            var address_id = control_id.split("_").pop();

            var url = "<?php echo base_url(); ?>cart/delete_address";
            $.post(url, {address_id: address_id}, function (response) {

                if (response == 'success')
                    $('#span_' + address_id).hide();

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
                $('#address_id').val(obj.id);
                $('#customer_name').val(obj.customer_name);
                $('#address_1').val(obj.address_1);
                $('#address_2').val(obj.address_2);
                $('#state_id').val(obj.state_id);
                $('#po_box').val(obj.po_box);
                $('#contact_number').val(obj.contact_number);
                $('#email_id').val(obj.email_id);
                $('.loader_display').hide();

            });
        });

        function add_list() {

            var url = "<?php echo base_url(); ?>cart/shipping_addr_list";
            $.post(url, {}, function (response)
            {
                $("#shipping_addresses_list").html('');
                $("#shipping_addresses_list").before(response.html);
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
                    po_box: "required",
                },
                messages: {
                    customer_name: "Please enter Name",
                    contact_number: "Please enter Contact Number",
                    email_id: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address"
                    },
                    address_1: "Please enter Address 1",
                    state_id: "Please select state",
                    po_box: "Please enter proper PO Box Number"
                },
                submitHandler: function (form) {

                    $('.loader_display').show();

                    var customer_name = $('#customer_name').val();
                    var address_1 = $('#address_1').val();
                    var address_2 = $('#address_2').val();
                    var state_id = $('#state_id').val();
                    var po_box = $('#po_box').val();
                    var contact_number = $('#contact_number').val();
                    var address_id = $('#address_id').val();
                    var email_id = $('#email_id').val();

                    var url = "<?php echo base_url(); ?>cart/add_edit_shipping_address";

                    $.post(url, {customer_name: customer_name, address_1: address_1, address_2: address_2, state_id: state_id, po_box: po_box, contact_number: contact_number, address_id: address_id, email_id: email_id}, function (response) {

                        $('.loader_display').hide();

                        add_list();

                        $('.form-control').val('');
                        $('#shipping_form').hide();

                        if (response == 'success')
                            console.log('success');
                        else
                            console.log('failed to add/update');
                    });
                }
            });
        });
    </script>
</html>