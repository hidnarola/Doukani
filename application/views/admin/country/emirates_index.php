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
                                            <i class='fa fa-flag'></i>
                                            <span>Emirates</span>
                                        </h1>
                                        <div class='pull-right'>
                                            <span data-id="<?php echo $country_id; ?>" title="Add Store" class="btn add_country">
                                                <i class='icon-plus'></i>
                                                Add Emirates
                                            </span>				   
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
                                            <div class='title'>Emirates List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <form method="post" action="" id="userForm" class="form form-horizontal">
                                                        <table class='table data-table table-striped' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Emirates Name</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($country) && sizeof($country) > 0):
                                                                    foreach ($country as $cat) {
                                                                        ?>
                                                                        <tr id="<?php echo $cat['state_id'] ?>">
                                                                            <td><?php echo $cat['state_name']; ?></td>
                                                                            <td>
                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/systems/emirates_edit/" . $cat['state_id']; ?>'>
                                                                                                <i class='icon-edit'></i> Edit Emirate
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a data-path='<?php echo base_url() . "admin/systems/emirates_delete/" . $cat['state_id']; ?>' id="delete_emirate">
                                                                                                <i class='icon-trash'></i> Delete Emirate
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
                                                </div>
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
</div>
<div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content rounded">
            <div class="modal-header text-center orange-background">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                <h4 id="myLargeModalLabel" class="modal-title">Add Emirates</h4>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <form action='<?php echo base_url(); ?>admin/systems/emirates_add' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post'>
                        <div class='box-content control'>
                            <div class='form-group'>								    				     
                                <strong>Emirate Name :</strong>
                                <input name="state_name" type="text" class="span5 form-control" data-rule-required='true' />
                                <input  name="country_id" id="country_id" type="hidden" class="span5 form-control" data-rule-required='true' />
                            </div>				
                            <button class='btn btn-primary' type='submit'>
                                <i class="fa fa-floppy-o"></i>
                                Save
                            </button>
                            <button data-dismiss="modal" class="btn btn-default rounded" type="button">Cancel</button>
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
                <p id="alert_message_action">Are you sure want to delete Emirate(s)?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('admin/include/footer-script'); ?>        
</body>
</html>
<script>

    $(document).on("click", "#delete_emirate", function (e) {
        var data_path = $(document).find(this).attr('data-path');
        $("#deleteConfirm").modal('show');
        $(document).on("click", ".yes_i_want_delete", function (e) {
            var val = $(this).val();
            if (val == 'yes') {
                jQuery('#userForm').attr('action', data_path).submit();
            }
        });
    });

    $(document).ready(function () {
        $(document).on('click', '.add_country', function () {
            var id = jQuery(this).attr('data-id');
            if (id !== null) {
                $("#send-message-popup").modal('show');
                $("#country_id").val(id);
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
            $.post("<?php echo base_url() ?>admin/classifieds/order_emirate", {order: newOrder});
            var id = ui.item.context.children[0].innerHTML;
        }
        // end of drag
    });

</script>