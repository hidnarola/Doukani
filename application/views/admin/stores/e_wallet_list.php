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
                                    <span>E-wallet</span>
                                </h1>                                
                            </div>
                            <div class='title'>
                                <?php
                                if (isset($_REQUEST['userid']) && !empty($_REQUEST['userid'])) {
                                    $res = $this->db->query('select email_id,username from user where user_id=' . (int) $_REQUEST['userid'])->row();
                                    if (isset($res)) {
                                        echo 'Email ID: <u>' . $res->email_id . '</u><br>';
                                        echo 'Username: ' . $res->username;
                                    } else
                                        redirect('admin/classifieds/listings/classified');
                                }
                                ?>
                            </div>
                            <br>
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>
                            <br>                            
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>E-wallet Listing</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area'>
                                                    <form id="storeForm" action="" method="POST"><!-- data-table-->
                                                        <table class=' table  table-striped' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Requested Date</th>
                                                                    <th>Approved Date</th>
                                                                    <th>Amount</th>
                                                                    <th>Status</th>                                                                    
                                                                    <th>Action</th>                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (!empty($e_wallet_list)):
                                                                    foreach ($e_wallet_list as $list):
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $list['created_date']; ?></td>
                                                                            <td><?php echo (isset($list['modified_date']) && $list['modified_date'] != '0000-00-00 00:00:00') ? $list['modified_date'] : ''; ?></td>
                                                                            <td><?php echo 'AED ' . $list['amount']; ?></td>
                                                                            <td>
                                                                                <?php if ($list['status'] == 0) { ?>
                                                                                    <a onclick="return confirm('Are you sure you want to update as Approve?');" href='<?php echo base_url() . "admin/users/update_wallet_status/" . $list['e_payment_id'] . '/' . $user_id; ?>' class="payment_status btn btn-info btn-xs" data-placement="top" title="Mark as Approve">Pending</a>
                                                                                    <?php
                                                                                } elseif ($list['status'] == 1) {
                                                                                    echo 'Approved';
                                                                                }
                                                                                ?>
                                                                            </td>                                                                            
                                                                            <td>
                                                                                <a href="javascript:void(0);" data-id="<?php echo $list['e_payment_id']; ?>" class="e_wallet_orders"><i class="fa fa-eye"></i></a>
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
<?php $this->load->view('admin/stores/order_list_modal'); ?>
<?php $this->load->view('admin/include/footer-script'); ?>
<script  type="text/javascript">
    $(document).on('click', '.e_wallet_orders', function () {
        var balance_id = $(document).find(this).attr('data-id');        
        $(document).find('#order_list_wrapper').html('');
        var getAllOrderUrl = '<?php echo base_url(); ?>admin/users/display_ewallet_request_orders/' + balance_id;
        $.ajax({
            method: 'GET',
            url: getAllOrderUrl,
            success: function (response) {
                if (response !== '') {
                    var obj = JSON.parse(response);
                    $(document).find('#order_list_wrapper').empty();
                    $.each(obj, function (index, data) {
                        $(document).find('#order_list_wrapper').append($('<li>').html(data));
                    });
                    $(document).find('#order_view_model').modal();
                }
            },
        });
    });
</script>