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
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-building'></i>
                                    <span>Store Request</span>
                                </h1>                                
                            </div>
                            <br>
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>
                            <?php
                            $redirect = $_SERVER['QUERY_STRING'];
                            if (!empty($_SERVER['QUERY_STRING']))
                                $redirect = '/?' . $redirect;
                            ?>
                            <br>                            
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Store Request List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <form id="storeForm" action="" method="POST"><!-- data-table-->
                                                        <table class=' table  table-striped superCategoryList' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>                                                                    
                                                                    <th>Email ID</th>
                                                                    <th>Contact Number</th>
                                                                    <th>Store Name</th>
                                                                    <th>Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (!empty($store_request_list)):
                                                                    foreach ($store_request_list as $list):
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $list['email_id']; ?></td>
                                                                            <td><?php echo $list['phone']; ?></td>
                                                                            <td><?php echo $list['store_name']; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if ($list['status'] == 0) {
                                                                                    echo 'Pending';
                                                                                } elseif ($list['status'] == 2) {
                                                                                    echo 'Approved';
                                                                                } elseif ($list['status'] == 3) {
                                                                                    echo 'Rejetced';
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td>
                                                                                <?php
                                                                                $redirect_after_edit = base_url() . "admin/users/edit_store_request/" . $list['id'];
                                                                                if ((isset($search)) && !empty($search))
                                                                                    $redirect_after_edit .= $search;
                                                                                $redirect_after_delete = base_url() . "admin/users/delete_store_request/" . $list['id'];
                                                                                if ((isset($search)) && !empty($search))
                                                                                    $redirect_after_delete .= $search;
                                                                                ?>

                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <li>
                                                                                            <a href="<?php echo $redirect_after_edit; ?>" class="e_wallet_orders"><i class="icon-edit"></i> Edit Store Request Details</a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a onclick="return confirm('Are you sure you want to delete this store request?');" href='<?php echo $redirect_after_delete; ?>'>
                                                                                                <i class='icon-trash'></i> Delete Request
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>                                                                                
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    endforeach;
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>            
    </body>
</html>
<?php $this->load->view('admin/include/footer-script'); ?>
<script type="text/javascript">
    function all_select() {
        var checked = jQuery('#all').attr('checked');
        if (checked)
            jQuery(":input[type=checkbox]", ".superCategoryList").attr('checked', true);
        else
            jQuery(":input[type=checkbox]", ".superCategoryList").attr('checked', false);
    }
</script>