<html lang="en">
    <head>
        <?php $this->load->view('admin/include/head'); ?>        
        <style>.action_drop_down  .sr-only {position: relative;}</style>
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='row'>
                                <div class="col-sm-12">
                                    <div class="orange-background">
                                        <div class="page-header">
                                            <h1 class='pull-left'>
                                                <i class='icon-th-list'></i>
                                                <span>Balance</span>
                                            </h1>
                                            <div class="pull-right">                                            
                                                <a class="btn" href="<?php echo base_url() . "admin/orders/balance_list"; ?>">
                                                    <i class="fa fa-refresh"></i> Reset Filters
                                                </a>
                                            </div>
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
                            <form id="form2" name="form2" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                <input type="submit" name="submit1" id="submit1">
                            </form>                            
                            <form accept-charset="UTF-8" method="post" action="<?php echo site_url() . 'admin/orders/balance_list'; ?>" name="form1" id="form1">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div style="margin-bottom:0;" class="box bordered-box orange-border">
                                            <div class="box-header orange-background">
                                                <div class="title">Search Order Number</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content">
                                                <div class="form-group col-sm-8">
                                                    <input type="text" name="search_order" value="<?php if (isset($_POST['search_order']) && !empty($_POST['search_order'])) echo $_POST['search_order']; ?>" placeholder="Order Number" class="form-control" id="search_order">
                                                </div>
                                                <div class="form-group">
                                                    <button class="btn btn btn-primary" id="" name="submit_filter" type="submit">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>                               

                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>

                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Balance List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class='box-content box-no-padding'>
                                            <div class="table_add_display responsive-table">
                                                <div class="table-responsive foo scrollable-area table-responsive">
                                                    <form method="post" action="" id="userForm" class="form form-horizontal">
                                                        <table class="display responsive no-wrap my-trading-account-table table automation-table marketing-materials-table" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>                                                                                                               
                                                                    <th width="10%">Order Number</th>
                                                                    <th width="10%">Store Name</th>
                                                                    <th width="10%" class="text-right">Percentage</th>
                                                                    <th width="10%" class="text-right">Doukani Commission</th>
                                                                    <th width="10%" class="text-right">Store Amount</th>
                                                                    <th width="10%" class="text-right">Order Amount</th>
                                                                    <th width="10%">Balance Status</th>
                                                                    <th width="10%">Order Status</th>
                                                                    <th width="20%">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($balance_list) && sizeof($balance_list) > 0) {
                                                                    foreach ($balance_list as $list) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $list['order_number']; ?></td>
                                                                            <td><?php echo $list['store_name']; ?></td>
                                                                            <td class="text-right"><?php echo $list['percentage'] . '%'; ?></td>
                                                                            <td class="text-right"><?php echo 'AED ' . number_format($list['doukani_amout'], 2); ?></td>
                                                                            <td class="text-right"><?php echo 'AED ' . number_format($list['store_amount'], 2); ?></td>
                                                                            <td class="text-right"><?php echo 'AED ' . number_format($list['amount'], 2); ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if ($list['balance_status'] == 1) {
                                                                                    echo 'Payment Received';
                                                                                } elseif ($list['balance_status'] == 2) {
                                                                                    echo 'Canceled';
                                                                                } elseif ($list['balance_status'] == 3) {
                                                                                    echo 'Paid to Seller';
                                                                                }
                                                                                ?>
                                                                            </td>
                                                                            <td><?php echo ucfirst($list['order_status']); ?></td>
                                                                            <td>
                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <li>
                                                                                            <a target="_blank" href="<?php echo site_url() . 'admin/users/e_wallet/?userid=' . $list['store_owner']; ?>" class="view_details" id="<?php echo $list['order_id']; ?>"><i class="icon-money"></i> Store's E-walllet</a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a target="_blank" href="<?php echo site_url() . 'admin/orders/order_details/' . $list['order_id']; ?>" class="view_details" id="<?php echo $list['order_id']; ?>"><i class="icon-eye-open"></i> Order Details</a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>                                                                    
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                }
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
                                                    <br>
                                                    <br>                                                
                                                    <br>                                                
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
        <?php $this->load->view('admin/include/footer-script'); ?>
    </body>
    <script type="text/javascript">
        $(document).find('#per_page1').on('change', function () {
            var per_page = $(this).val();
            console.log(per_page);
            $('#per_page').val(per_page);
            $(document).find('#submit1').click();
        });
    </script>
</html>
