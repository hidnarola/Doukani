<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb store'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>
                                            <i class=' icon-question-sign '></i>
                                            <span>FAQ</span>
                                        </h1>
                                        <div class='pull-right'>
                                            <a href='<?php echo base_url(); ?>admin/faq/add' title="Add FAQ" class="btn">
                                                <i class='icon-plus'></i>
                                                Add FAQ
                                            </a>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'></div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>

                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>FAQ List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <form method="post" action="" id="userForm" class="form form-horizontal">  
                                                        <table class='table  table-striped' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                    <th style="display: none;">Order</th>
                                                                    <th>FAQ Title</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($faq) && sizeof($faq) > 0):
                                                                    foreach ($faq as $f) {
                                                                        ;
                                                                        ?>
                                                                        <tr id="<?php echo $f['faq_id']; ?>">
                                                                            <td><input type="checkbox" value="<?php echo $f['faq_id']; ?>" class="input-sm" style="height:14px;"/></td>
                                                                            <td><?php echo $f['question']; ?></td>
                                                                            <td>
                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/faq/edit/" . $f['faq_id']; ?>'>
                                                                                                <i class='icon-edit'></i> Edit FAQ
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a data-path='<?php echo base_url() . "admin/faq/delete/" . $f['faq_id']; ?>' id="delete_faq">
                                                                                                <i class='icon-trash'></i> Delete FAQ
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                else:
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="8">No Results Found</td>
                                                                    </tr>
                                                                <?php
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                    <form method="post" action="" id="userForm1" class="form form-horizontal col-md-12">
                                                        <div class='form-group'>
                                                            <div class='col-md-3'>
                                                                <select style="margin-left: 5px;" class='form-control' id="status_val" name="status">
                                                                    <option value="0">Select Action</option>
                                                                    <option value="delete">Delete</option>
                                                                </select>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <input type="hidden" id="checked_val" name="checked_val"/>
                                                                <input type="button" class="btn" value="Apply to selected" onclick="update_status();">
                                                            </div>
                                                        </div>
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
            </section>
            <div class="modal fade center" id="alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content rounded">
                        <div class="modal-header text-center orange-background">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                            <h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
                        </div>
                        <div class="modal-body">
                            <div class="FeaturedAds-popup">
                                <form action='' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form">
                                    <div class='box-content control'>
                                        <div class='form-group '>
                                            <font color="red" ><span id="error_msg" ></span></font>
                                        </div>
                                        <div class="margin-bottom-10"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">  
                            <h4 class="modal-title">Confirmation
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>                   
                        </div>
                        <div class="modal-body">                  
                            <p id="alert_message_action">Are you sure want to delete FAQ(s)?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>  
        <script>
            $(document).on("click", "#delete_faq", function (e) {
                var data_path = $(document).find(this).attr('data-path');
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        jQuery('#userForm').attr('action', data_path).submit();
                    }
                });
            });

            $("tbody").sortable({
                cursor: "move",
                start: function (event, ui) {
                    // 0 based array, add one
                    start = ui.item.prevAll().length + 1;
                },
                update: function (event, ui) {
                    // 0 based array, add one                            
                    end = ui.item.prevAll().length + 1;
                    var state = '';
                    if (start > end) {
                        state = 'up';
                    } else {
                        state = 'down';
                    }
                    var newOrder = $(this).sortable('toArray').toString();
                    //        alert(newOrder);
                    var newOrder = $(this).sortable('toArray');
                    //        alert(newOrder);
                    $.post("<?php echo base_url() ?>admin/faq/order_pages", {sort_order: newOrder});
                    var id = ui.item.context.children[0].innerHTML;
                }
                // end of drag
            });

            $("input.location").click(function () {
                var location_val;
                if ($(this).is(':checked')) {
                    location_val = 1
                } else {
                    location_val = 0
                }

                var id = $(this).attr('id');
                var page = $(this).data('page');
                $.post("<?php echo base_url() ?>admin/faq/set_location", {location: id, faq_id: page, value: location_val}, function (response)
                {
                    console.log(response);
                });
            });

            function all_select() {
                var checked = jQuery('#all').attr('checked');
                if (checked)
                    jQuery(".input-sm").attr('checked', true);
                else
                    jQuery(".input-sm").attr('checked', false);
            }

            function update_status() {

                var historySelectList = $('select#status_val');
                var selectedValue = $('option:selected', historySelectList).val();
                var checkedValues = $('.input-sm:checked').map(function () {
                    return this.value;
                }).get();

                $('#checked_val').val(checkedValues);

                if ($('#checked_val').val() != '') {
                    if (selectedValue == 'delete') {
                        $("#deleteConfirm").modal('show');
                        $(document).on("click", ".yes_i_want_delete", function (e) {
                            var val = $(this).val();
                            if (val == 'yes') {
                                jQuery('#userForm1').attr('action', "<?php echo base_url(); ?>admin/faq/delete").submit();
                            }
                        });
                    } else {
                        $("#alert").modal('show');
                        $("#error_msg").html("Select action");
                    }
                } else {
                    $("#alert").modal('show');
                    $("#error_msg").html("Select any record to perform action");
                }
            }
        </script>
    </body>
</html>