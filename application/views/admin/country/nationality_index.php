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
                                            <span>Nationality</span>
                                        </h1>
                                        <div class='pull-right'>
                                            <span title="Add Store" class="btn add_country">
                                                <i class='icon-plus'></i>
                                                Add Nationality
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
                            <form id="form1" name="form1" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                <input type="submit" name="submit" id="submit">
                            </form>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Nationality List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <form method="post" action="" id="userForm" class="form form-horizontal">
                                                        <table class=' table  table-striped superCategoryList' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                    <th>Nationality Name</th>                                
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($nationality) && sizeof($nationality) > 0):
                                                                    foreach ($nationality as $nat) {
                                                                        ?>
                                                                        <tr>
                                                                            <td>
                                                                                <input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $nat['nation_id']; ?>" />
                                                                            </td>
                                                                            <td><?php echo $nat['name']; ?></td>                                                                                     
                                                                            <td>

                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/systems/nationality_edit/" . $nat['nation_id']; ?>'>
                                                                                                <i class='icon-edit'></i> Edit Nationality
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a data-path='<?php echo base_url() . "admin/systems/nationality_delete/" . $nat['nation_id']; ?>' id="del_nationality">
                                                                                                <i class='icon-trash'></i> Delete Nationality
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                else:
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="3">No Results Found</td>
                                                                    </tr>
                                                                <?php
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </form>
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>	
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="col-sm-4">
                                                        <label>Per page : </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select name="per_page1" id="per_page1" class="form-control" >                                              
                                                            <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '10') ? 'selected' : ''; ?>>10</option>    
                                                            <option value="25" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '25') ? 'selected' : ''; ?>>25</option>
                                                            <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '50') ? 'selected' : ''; ?>>50</option>
                                                            <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '100') ? 'selected' : ''; ?>>100</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <form method="post" action="" id="userForm1" class="form form-horizontal col-md-12">
                                                        <div class='form-group'>
                                                            <div class='col-md-4'>
                                                                <select style="margin-left: 5px;" class='form-control' id="status_val" name="status">
                                                                    <option>Select Action</option>
                                                                    <option value="delete">Delete</option>
                                                                </select>
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <input type="hidden" id="checked_val" name="checked_val"/> <input type="button" class="btn" value="Apply to selected" onclick="update_status();">
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
        </div>
        <div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Add Nationality</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <form action='<?php echo base_url(); ?>admin/systems/nationality_add' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post'>
                                <div class='box-content control'>
                                    <div class='form-group'>								    				     
                                        <strong>Nationality Name :</strong>
                                        <input name="nationality_name" type="text" class="span5 form-control" data-rule-required='true' />					
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
                        <p id="alert_message_action">Are you sure want to delete Nationality(s)?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script>
            $(document).find('#per_page1').on('change', function () {
                var per_page = $(this).val();
//                console.log(per_page);
                $('#per_page').val(per_page);
                $(document).find('#submit').click();
            });
            $(document).on("click", "#del_nationality", function (e) {
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
                    $("#send-message-popup").modal('show');
                    $("#user_id").val(id);
                });
            });

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
                    if (selectedValue == 'delete') {
                        $("#deleteConfirm").modal('show');
                        $(document).on("click", ".yes_i_want_delete", function (e) {
                            var val = $(this).val();
                            if (val == 'yes') {
                                jQuery('#userForm1').attr('action', "<?php echo base_url(); ?>admin/systems/nationality_delete").submit();
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