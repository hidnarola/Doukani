<div class='row'>
    <div class='col-sm-12 col-md-12 box'>
        <div class='box-header red-background col-md-11'>
            <div class='title'>
                <i class=' icon-shopping-cart'></i>
                Store Payment Request
            </div>
            <div class='actions'>
                <a class="btn box-collapse btn-mini btn-link" href="javascript:void(0);"><i></i>
                </a>
            </div>
        </div>        
        <div class="box-content col-sm-11 admin-dashboard-box">            
            <?php
            if (isset($store_payment_request) && sizeof($store_payment_request) > 0) {
                foreach ($store_payment_request as $request) {
                    ?>
                    <div class="col-sm-2">                
                        <a href="<?php echo base_url() . 'admin/users/e_wallet/?userid=' . $request['store_owner']; ?>" target="_blank">
                            <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                <h3 class='title text-success'>
                                    <?php echo 'AED ' . number_format($request['amount'], 2); ?>
                                </h3>
                                <small><?php echo $request['store_name']; ?></small>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo 'No results found.';
            }
            ?>            
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-sm-12 col-md-4 box'>
        <div class='box-header purple-background col-md-11'>
            <div class='title'>
                <i class='icon-money'></i>
                My Balance (Commission)
            </div>
            <div class='actions'>
                <a class="btn box-collapse btn-mini btn-link" href="javascript:void(0);"><i></i>
                </a>
            </div>
        </div>        
        <div class="box-content col-sm-11 admin-dashboard-box">
            <div class="col-sm-6">                
                <!--<a href="javascript:void(0);">-->
                <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                    <h3 class='title text-success'>
                        <?php echo 'AED ' . number_format(@$doukani_balance['doukani_balance'], 2); ?>
                    </h3>
                    <small>Total</small>
                </div>
                <!--</a>-->
            </div>            
        </div>
    </div>
    <div class='col-sm-12 col-md-4 box'>
        <div class='box-header muted-background col-md-11'>
            <div class='title'>
                <i class='icon-certificate'></i>
                Create Store Request
            </div>
            <div class='actions'>
                <a class="btn box-collapse btn-mini btn-link" href="javascript:void(0);"><i></i>
                </a>
            </div>
        </div>        
        <div class="box-content col-sm-11 admin-dashboard-box">            
            <?php
            if (isset($create_store_request) && sizeof($create_store_request) > 0) {
                ?>
                <div class="col-sm-6">                
                    <a href="<?php echo base_url() . 'admin/users/store_request_list'; ?>" target="_blank">
                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                            <h3 class='title text-success'>
                                <?php echo $create_store_request['total_request']; ?>
                            </h3>                            
                            <small>Total</small>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>            
        </div>
    </div>
</div>