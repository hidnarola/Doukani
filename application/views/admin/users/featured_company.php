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
                                            <i class='icon-tags'></i>
                                            <span>Featured Offer Users</span>
                                        </h1>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'>
                                        <h5><span class="f_label" >F</span> - Featured User Companies Running in Front End</h5>
                                    </div>
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
                                <div class='col-sm-12' id="filter_list">
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Listings</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <form id="form1" name="form1" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                            <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                            <input type="submit" name="submit" id="submit">
                                        </form>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <table class='table table-striped superCategoryList' style='margin-bottom:0;'>
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>
                                                                <th>Company Name</th>
                                                                <th>Status</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($featured_companies) && sizeof($featured_companies) > 0):
                                                                foreach ($featured_companies as $pro) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $pro['user_id']; ?>" /></td> 
                                                                        <td>
                                                                            <?php if (!empty($pro['mystatus']) && $pro['mystatus'] == 'running') { ?>
                                                                                <span class="f_label" style="">F</span>
                                                                                <?php
                                                                            }
                                                                            echo $pro['company_name'];
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo $pro['mystatus']; ?>
                                                                        </td>
                                                                        <td><?php
                                                                            $date = date_create($pro['start_date']);
                                                                            echo date_format($date, "d-m-Y H:i:s");
                                                                            ?>
                                                                        </td>  
                                                                        <td><?php
                                                                            $date = date_create($pro['end_date']);
                                                                            echo date_format($date, "d-m-Y H:i:s");
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : ''; ?>
                                                                            <div class="btn-group action_drop_down">
                                                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                    <span class="caret"></span>
                                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                                </button>
                                                                                <ul class="dropdown-menu" role="menu">
                                                                                    <li>
                                                                                        <?php $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : ''; ?>
                                                                                        <a data-path='<?php echo base_url() . "admin/users/update_unfeatured_company/" . $pro['user_id'] . '/' . $page_redirect; ?>' id="unfeatured_offer">
                                                                                            <i class='icon-edit'></i> Un-featured
                                                                                        </a> 
                                                                                    </li>
                                                                                    <li class="divider"></li>
                                                                                    <li>
                                                                                        <a href='<?php echo base_url() . "admin/users/view_offers_company/" . $pro['id'] . $page_redirect; ?>' target="_blank">
                                                                                            <i class='fa fa-building'></i> View Offer Company Details
                                                                                        </a>  
                                                                                    </li>
                                                                                    <li class="divider"></li>
                                                                                    <li>
                                                                                        <a href='<?php echo base_url() . "admin/users/edit_offers_company/" . $pro['id'] . $page_redirect; ?>' target="_blank">
                                                                                            <i class='icon-edit'></i>&nbsp;Edit Offer Company Details
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="divider"></li>
                                                                                    <li>
                                                                                        <a href = '<?php echo base_url() . "admin/users/view/" . $pro['user_id'] . '/' . $page_redirect; ?>' target="_blank">
                                                                                            <i class = "fa fa-info-circle"></i> View User Details
                                                                                        </a>
                                                                                    </li>
                                                                                    <li class="divider"></li>
                                                                                    <li>
                                                                                        <a href = '<?php echo base_url() . "admin/users/edit/" . $pro['user_id'] . $page_redirect; ?>' target="_blank">
                                                                                            <i class = 'icon-edit'></i> Edit User Details
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
                                                    <form method="post" action="" id="userForm" class="form form-horizontal col-md-12">
                                                        <div class='form-group'>
                                                            <div class='col-md-4'>
                                                                <select style="margin-left: 5px;" class='form-control' id="status_val" name="status" >
                                                                    <option>Select Action</option>
                                                                    <option value="unfeatured">Un-featured</option>
                                                                </select>  
                                                            </div>
                                                            <div class='col-md-3'>
                                                                <input type="hidden" id="checked_val" name="checked_val"/>
                                                                <?php
                                                                $redirect_after_delete = '';

                                                                if (isset($_REQUEST['page']))
                                                                    $redirect_after_delete .= '?page=' . $_REQUEST['page'];
                                                                ?>
                                                                <input type="hidden" id="redirect_me" name="redirect_me" value="<?php echo $redirect_after_delete; ?>" /> 

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
                            <p>Are you sure you want to make Offer User(s) as Un-featured?</p>
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
            $(document).find('#per_page1').on('change', function () {
                var per_page = $(this).val();
                console.log(per_page);
                $('#per_page').val(per_page);
                $(document).find('#submit').click();
            });
            $(document).on("click", "#unfeatured_offer", function (e) {
                var data_path = $(document).find(this).attr('data-path');
                $(".sure .modal-sm .modal-header").css({"background": "#337ab7"});
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        jQuery('#userForm').attr('action', data_path).submit();
                    }
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
                    if (selectedValue == 'unfeatured') {
                        $(".sure .modal-sm .modal-header").css({"background": "#337ab7"});
                        $("#deleteConfirm").modal('show');
                        $(document).on("click", ".yes_i_want_delete", function (e) {
                            var val = $(this).val();
                            if (val == 'yes') {
                                jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/users/update_unfeatured_company").submit();
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