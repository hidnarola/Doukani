<script type="text/javascript">    
    $('#featured_form').validate();
    $(document).find(function () {
        $(document).find('#datetimepicker6').datetimepicker({
            format: 'DD-MM-YYYY HH:mm:ss'
        });
        $(document).find('#datetimepicker7').datetimepicker({
            format: 'DD-MM-YYYY HH:mm:ss',
            useCurrent: false
        });
        $(document).find("#datetimepicker6").on("dp.change", function (e) {
            $(document).find('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $(document).find("#datetimepicker7").on("dp.change", function (e) {
            $(document).find('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });

    $("select#status_val").val('0');

    var myEl = document.getElementById('cancel');
    myEl.addEventListener('click', function () {
        $("#status_val").each(function () {
            this.selectedIndex = 0
        });
    }, false);

    $('select#status_val').change(setfeatured);

    function setfeatured() {

        var historySelectList = $('select#status_val');
        var selectedValue = $('option:selected', historySelectList).val();

        var checkedValues = $('input:checkbox:checked').map(function () {
            return this.value;
        }).get();

        $('#checked_values').val(checkedValues);

        if (selectedValue == 'featured') {

            if ($('#checked_values').val() == '')
            {
                $("#alert").modal('show');
                $("#error_msg").html("Select any record for Featured Ad");
                //alert("Select any record for Freatured Ad");
                $("#status_val").each(function () {
                    this.selectedIndex = 0
                });
                return false;
            }
            else
                $("#send-message-popup").modal('show');
        }
    }

    function insert_featured() {
        jQuery('#featured_form').attr('action', "<?php echo base_url(); ?>admin/classifieds/insert_featured/<?php echo $this->uri->segment(3) . '/' . $this->uri->segment(4); ?>").submit();
            return false;
    }

    function show_list() {

        var filter_opt = $('#filter_opt').val();
        var spam_val = $('#spam_text').val();
        var subcat = "";
        var state_val = "";
        if (filter_opt == 'emirates') {
            //$('#date_range').hide();
            $('#s2id_location').show();
            $('#state_name').show();
            $('#s2id_category').hide();
            //$('#s2id_status').hide();
            $('#subcategory').hide();
            var val = $('#location').val();
            var state_val = $('#state_name').val();

        } else if (filter_opt == 'category') {
            //$('#date_range').hide();                      
            $('#s2id_location').hide();
            $('#state_name').hide();
            $('#s2id_category').show();
            $('#subcategory').show();
            //$('#s2id_status').hide();
            var val = $('#category').val();
            var subcat = $('#subcategory').val();

        }
        else if (filter_opt == 'featured') {
            //$('#date_range').show();                       
            $('#state_name').hide();
            $('#s2id_location').hide();
            $('#s2id_category').hide();
            $('#subcategory').hide();
            //$('#s2id_status').hide();
            var val = $('#date_range_val').val();

        }
        else if (filter_opt == 'unfeatured') {
            //$('#date_range').hide();                       
            $('#state_name').hide();
            $('#s2id_location').hide();
            $('#s2id_category').hide();
            $('#subcategory').hide();
            // $('#s2id_status').hide();

        }
        else {
            //$('#date_range').hide();                      
            $('#s2id_location').hide();
            $('#state_name').hide();
            $('#s2id_category').hide();
            $('#subcategory').hide();
            //$('#s2id_status').hide();
            var val = "";

        }

    }

<?php if (isset($user_category_id) && $user_category_id > 0) { ?>
            show_sub_cat("<?php echo $user_category_id; ?>");
<?php } 
    if (isset($_REQUEST['cat']) && $_REQUEST['cat'] != '') { ?>                
        show_sub_cat("<?php echo $_REQUEST['cat']; ?>");
<?php } ?>

        function show_sub_cat(val) {
            //alert(val);
            var sel_sub = 0;
            var sel_subcat = 0;
            var url = "<?php echo base_url(); ?>admin/classifieds/filter_sub_cat";
<?php if (isset($_REQUEST['cat']) && $_REQUEST['cat'] != '') { ?>
                var sel_cat = "<?php echo $_REQUEST['cat']; ?>";
<?php } ?>
<?php if (isset($_REQUEST['sub_cat']) && $_REQUEST['sub_cat'] != '') { ?>
                var sel_subcat = "<?php echo $_REQUEST['sub_cat']; ?>";
<?php } ?>
    
<?php if (isset($user_category_id) && $user_category_id > 0) { ?>
                sel_cat = "<?php echo $user_category_id; ?>";
<?php } ?>
<?php if (isset($user_sub_category_id) && $user_sub_category_id > 0) { ?>
                sel_subcat = "<?php echo $user_sub_category_id; ?>";
<?php } ?>

            var userid = '';
<?php if (isset($_REQUEST['userid']) && $_REQUEST['userid'] != '') { ?>
                var userid = "<?php echo $_REQUEST['userid']; ?>";
<?php } ?>

            $.post(url, {value: val, sel_sub: sel_sub, sel_subcat: sel_subcat, userid: userid}, function (data)
            {
                //alert(data);
                $("#subcategory_list").html(data);
                show_list();
            });
        }

        function all_select() {
            var checked = jQuery('#all').attr('checked');
            if (checked)
                jQuery(":input[type=checkbox]", ".superCategoryList").attr('checked', true);
            else
                jQuery(":input[type=checkbox]", ".superCategoryList").attr('checked', false);
        }

        function update_status() {

            var historySelectList = $('select#status_val');
            var selectedValue = $('option:selected', historySelectList).val();

            var checkedValues = $('input:checkbox:checked').map(function () {
                return this.value;
            }).get();

            $('#checked_val').val(checkedValues);

            if ($('#checked_val').val() != '') {
                var valu = $('#checked_values').val();
                var action = '';

                if (selectedValue == 'delete') {
                    action = 'listings_delete';
                    $('#alert_message_action').html('Are you sure want delete Ad(s)?');                    
                    $(".sure .modal-sm .modal-header").css({"background":"#ec1c32"});
                    $("#deleteConfirm").modal('show');
                    $(document).on("click", ".yes_i_want_delete", function (e) {
                        var val = $(this).val();
                        if(val=='yes') {
                            jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/classifieds/" + action + "/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>").submit();
                        }
                    });
                }
                else if(selectedValue=='available' || selectedValue=='sold' || selectedValue=='Approve' || selectedValue=='Unapprove' || selectedValue=='Inappropriate') {
                    action = 'update_status';
//                    $('#alert_message_action').html('Are you sure you want to Update Status for Ad?');
//                    $(".sure .modal-sm .modal-header").css({"background":"#337ab7"});
//                    $("#deleteConfirm").modal('show');
//                    $(document).on("click", ".yes_i_want_delete", function (e) {
//                        var val = $(this).val();
//                        if(val=='yes') {
                            jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/classifieds/" + action + "/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>").submit();
//                        }
//                    });
                }
                else {
                    $("#alert").modal('show');
                    $("#error_msg").html("Select action");
                    return false;
                }
            }
            else {
                $("#alert").modal('show');
                $("#error_msg").html("Select any record to perform action");
                return false;
            }
        }

<?php if (isset($_REQUEST['filter']) && $_REQUEST['filter']=="emirates" && isset($_REQUEST['con'])) { ?>
    show_emirates("<?php echo $_REQUEST['con']; ?>");
<?php } ?>

    function show_emirates(val) {
        var sel_city = 0;
        var url = "<?php echo base_url() ?>admin/classifieds/show_emirates";
        
<?php if (isset($_REQUEST['filter']) && $_REQUEST['filter']=="emirates" && isset($_REQUEST['st'])) { ?>
    
    sel_city = "<?php echo $_REQUEST['st']; ?>";
<?php
}
?>

        $.post(url, {value: val, sel_city: sel_city}, function (data)
        {
            $("#state_name option").remove();
            $("#state_name").append(data);
            show_list();
        });
    }

    function reset_filter() {
        location.reload();
    }
</script>