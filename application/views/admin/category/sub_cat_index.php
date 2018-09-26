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
                                            <i class='icon-list'></i>
                                            <span>Sub Category</span>
                                        </h1>
                                        <div class='pull-right'>
                                            <a href='<?php echo base_url(); ?>admin/classifieds/subCategories_add/<?php echo $cat_id; ?>' title="Add Store" class="btn">
                                                <i class='icon-plus'></i>
                                                Add Sub Category
                                            </a>				   
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'></div>
                                </div>
                                <div class='title text-right total-disp'>
                                    <h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4>
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
                                            <div class='title'>Sub Category List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area'><!-- data-table -->
                                                    <table class='table superCategoryList data-table-column-filter table-striped' style='margin-bottom:0;'>
                                                        <?php $admin_permission = $this->session->userdata('admin_modules_permission'); ?>
                                                        <thead>
                                                            <tr>
                                                                <?php if ($admin_permission != 'only_listing') { ?>
                                                                    <th></th>
                                                                <?php } ?>
                                                                <th style="display: none;">Order</th>
                                                                <th>Name</th>
                                                                <th>Image</th>
                                                                <?php if ($admin_permission != 'only_listing') { ?>
                                                                    <th>Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($category) && sizeof($category) > 0):
                                                                foreach ($category as $cat) {
                                                                    ?>
                                                                    <tr id="<?php echo $cat['sub_category_id'] ?>">
                                                                        <?php if ($admin_permission != 'only_listing') { ?>
                                                                            <td><input type="checkbox" value="<?php echo $cat['sub_category_id']; ?>" class="input-sm" style="height:14px;" /></td>
                                                                        <?php } ?>
                                                                        <td style="display: none;"><?php echo $cat['sub_cat_order']; ?></td>
                                                                        <td style="color: <?php echo $parent_category->color; ?>"><span><i class="fa <?php echo $cat['icon'] ?>"></i></span>&nbsp;<?php echo $cat['sub_category_name']; ?></td>
                                                                        <td> 
                                                                            <?php
                                                                            if (isset($cat['sub_category_image']) && !empty($cat['sub_category_image']))
                                                                                $load_image = site_url() . category . "original/" . $cat['sub_category_image'];
                                                                            else
                                                                                $load_image = site_url() . 'assets/upload/No_Image.png';
                                                                            ?>
                                                                            <a data-lightbox='flatty' href='<?php echo $load_image; ?>'>
                                                                                <img style="height: 40px; width: 64px;" alt="Category Image" src="<?php echo $load_image; ?>" onerror="this.src='<?php echo site_url(); ?>assets/upload/No_Image.png'"/>
                                                                            </a>
                                                                        </td>
                                                                        <?php
                                                                        $admin_permission = $this->session->userdata('admin_modules_permission');
                                                                        if ($admin_permission != 'only_listing') {
                                                                            ?>
                                                                            <td>
                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/classifieds/subCategories_edit/" . $cat['sub_category_id']; ?>'>
                                                                                                <i class='icon-edit'></i> Edit Sub-category
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a data-id="<?php echo $cat['sub_category_id']; ?>" id="delete_cat">
                                                                                                <i class='icon-trash'></i> Delete Sub-category
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        <?php } ?>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            endif;
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <?php if ($admin_permission != 'only_listing') { ?>
                                                                    <th></th>
                                                                <?php } ?>
                                                                <th style="display: none;"></th>
                                                                <th>Name</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <?php
                                                    $admin_permission = $this->session->userdata('admin_modules_permission');
                                                    if ($admin_permission != 'only_listing') {
                                                        ?>
                                                        <form method="post" action="" id="userForm" class="form form-horizontal col-md-12">
                                                            <div class='form-group'>
                                                                <div class='col-md-3'>
                                                                    <select style="margin-left: 5px;" class='form-control' id="status_val" name="status">
                                                                        <option value="0">Select Action</option>
                                                                        <option value="delete">Delete</option>
                                                                    </select>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <input type="hidden" id="checked_val" name="checked_val"/>
                                                                    <input type="hidden" id="category_id" name="category_id"  value="<?php echo $cat_id; ?>" />
                                                                    <input type="button" class="btn" value="Apply to selected" onclick="update_status();">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    <?php } ?>
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
                            <p>Are you sure want to delete Sub-category(s)?</p>
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
    </body>
</html>
<script>
    $(document).on("click", "#delete_cat", function (e) {
        var category_id = $(document).find(this).attr('data-id');
        $("#deleteConfirm").modal('show');
        $(document).on("click", ".yes_i_want_delete", function (e) {
            var val = $(this).val();
            if (val == 'yes') {
                jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/classifieds/subCategories_delete/" + category_id).submit();
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
            $.post("<?php echo base_url() ?>admin/classifieds/order_sub_category", {order: newOrder});
            var id = ui.item.context.children[0].innerHTML;
        }
        // end of drag
    });

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
                        jQuery('#userForm').attr('action', "<?php echo base_url(); ?>admin/classifieds/subCategories_delete/<?php echo $this->uri->segment(3); ?>/<?php echo $this->uri->segment(4); ?>").submit();
                                            }
                                        });
                                    } else {
                                        $("#alert").modal('show');
                                        $("#error_msg").html("Select action");
                                        return false;
                                    }
                                } else {
                                    $("#alert").modal('show');
                                    $("#error_msg").html("Select any record to perform action");
                                    return false;
                                }
                            }
</script>