<?php
$queryString = '';
$suffixUrl = '';
if ($this->input->get('search'))
    $queryString = "?search=" . $this->input->get('search');
$suffixUrl = $queryString;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <style>
            #reported_items_view .modal-body{text-align: left !important;}
            .content-div{padding-right: 105px;}
        </style>
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
                                            <i class='icon-flag'></i>
                                            <span>Reported Items</span>
                                        </h1>

                                        <!--                                        <div class='pull-right'>
                                                                                    <a href='<?php echo base_url(); ?>admin/reported_items/add' title="Add Reported Items" class="btn">
                                                                                        <i class='icon-plus'></i>
                                                                                        Add Reported Items
                                                                                    </a>
                                                                                </div>-->
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='title'>
                                        <form action="<?php echo site_url() . 'admin/reported_items/' ?>" method="get" style="margin-top: 10px;">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6" style="margin-bottom: 10px;">
                                                        <input type="text" placeholder="Search By ID/Seller/Title" name="search" class="form-control" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">
                                                    </div>
                                                    <div class="col-sm-2 text-right">
                                                        <!--<input type="submit" class="btn btn-primary" value="Filter">-->
                                                        <button type="submit" id="" class="btn btn-primary">
                                                            <i class="fa fa-search"></i> Search
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>                                        
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>
                            </div>
                            <hr class="hr-normal">
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>

                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Reported Items</div>
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
                                                                    <th>Image</th>
                                                                    <th>Product Name</th>
                                                                    <th>Email Id</th>
                                                                    <th>Report Title</th>                                                                    
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($reported_items) && sizeof($reported_items) > 0):
                                                                    foreach ($reported_items as $r) {
                                                                        ?>
                                                                        <tr id="<?php echo $r['id']; ?>">
                                                                            <td><input type="checkbox" value="<?php echo $r['id']; ?>" class="input-sm" style="height:14px;"/></td>
                                                                            <td>
                                                                                <?php
                                                                                if (!empty($r['product_image'])) {
                                                                                    $load_image = base_url() . product . "original/" . $r['product_image'];
                                                                                    $image_url = base_url() . product . "small/" . $r['product_image'];
                                                                                } else {
                                                                                    $load_image = site_url() . '/assets/upload/No_Image.png';
                                                                                    $image_url = site_url() . '/assets/upload/No_Image.png';
                                                                                }
                                                                                ?>
                                                                                <a data-lightbox='flatty' href='<?php echo $load_image; ?>'>
                                                                                    <img alt="Product Image" style="height: 40px; width: 64px;" src="<?php echo $image_url; ?>" onerror="this.src='<?php echo site_url(); ?>/assets/upload/No_Image.png'"/>
                                                                                </a>                                                
                                                                            </td>
                                                                            <td><?php echo $r['report_for_product']; ?></td>
                                                                            <td><?php echo $r['email_id']; ?></td>
                                                                            <td><?php echo $r['report_title']; ?></td>                                                                            
                                                                            <td>
                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <li>
                                                                                            <a data-id="<?php echo $r['id']; ?>" data-content-a="<?php $r['content']; ?>" id="view_reported_items">
                                                                                                <i class='fa fa-info-circle'></i> View Reported Item
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a href="<?php echo $r['link']; ?>" target="_blank">
                                                                                                <i class='fa fa-info-circle'></i> View Product Page
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a data-path='<?php echo base_url() . "admin/reported_items/delete/" . $r['id']; ?>' id="delete_reported_items">
                                                                                                <i class='icon-trash'></i> Delete Reported Item
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
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>
                                                    </div>
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
                            <p id="alert_message_action">Are you sure want to delete reported item?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade sure" id="reported_items_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header orange-background">  
                            <h4 class="modal-title">View Content
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>                   
                        </div>
                        <div class="modal-body">                  
                            <div class="content-div"></div>
                        </div>
                        <div class="modal-footer">                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>  

        <script>
            $(document).on("click", "#delete_reported_items", function (e) {
                var data_path = $(document).find(this).attr('data-path');
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        jQuery('#userForm').attr('action', data_path).submit();
                    }
                });
            });
            $(document).on("click", "#view_reported_items", function (e) {
                var data_id = $(document).find(this).attr('data-id');
                var data_content = $(document).find(this).attr('data-content-a');
                $.ajax({
                    url: "<?php echo site_url() . 'admin/reported_items/getreported_item' ?>",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {id: data_id},
                    success: function (html) {
                        if (html != '') {
                            $("#reported_items_view").modal('show');
                            $('.content-div').html(html.content);
                        }
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
                    $.post("<?php echo base_url() ?>admin/reported_items/order_pages", {sort_order: newOrder});
                    var id = ui.item.context.children[0].innerHTML;
                }
                // end of drag
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
                                jQuery('#userForm1').attr('action', "<?php echo base_url(); ?>admin/reported_items/delete").submit();
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