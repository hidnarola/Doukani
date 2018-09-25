<div class='row'>
    <div class='col-sm-12 col-md-12 box'>
        <div class='box-header orange-background col-md-11'>
            <div class='title'>
                <i class=' icon-shopping-cart'></i>
                Stores
            </div>
            <div class='actions'>
                <a class="btn box-collapse btn-mini btn-link" href="javascript:void(0);"><i></i>
                </a>
            </div>
        </div>

        <?php
        $s_store_featured_stores = 0;
        $s_store_totals = 0;
        $s_store_deleted = 0;
        $s_store_approved_ads = 0;
        $s_store_needreview_ads = 0;
        $s_store_inappropriate_ads = 0;
        $s_store_unapproved_ads = 0;
        $s_store_hold = 0;
        $s_store_active = 0;
        $s_store_today_added = 0;
        foreach ($stores as $s) {
            $s_store_totals = $s['s_store_totals'];
            $s_store_deleted = $s['s_store_deleted'];
            $s_store_approved_ads = $s['s_store_approved_ads'];
            $s_store_needreview_ads = $s['s_store_needreview_ads'];
            $s_store_inappropriate_ads = $s['s_store_inappropriate_ads'];
            $s_store_unapproved_ads = $s['s_store_unapproved_ads'];
            $s_store_hold = $s['s_store_hold'];
            $s_store_active = $s['s_store_active'];
            $s_store_today_added = $s['s_store_today_added'];
            $s_store_featured_stores = $s['s_store_featured_stores'];

            $s_store_store_waiting = $s['s_store_store_waiting'];
        }
        ?>                                    
        <div class="box-content col-sm-11 admin-dashboard-box">
            <div class="col-sm-2">
<?php
$store_total_text = 'Approve : ' . $s_store_approved_ads .
'<hr class="hr_listing">Un-approve : ' . $s_store_unapproved_ads . '<hr class="hr_listing">'
. 'NeedReview : ' . $s_store_needreview_ads . '<hr class="hr_listing">'
. 'Inappropriate : ' . $s_store_inappropriate_ads . '<hr class="hr_listing">'
. 'Deleted : ' . $s_store_deleted . '<hr class="hr_listing">';
?>
                <a href="javascript:void(0);" title='Total Stores' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_total_text; ?>'>
                <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                    <h3 class='title text-success'>
                        <?php echo $s_store_totals; ?>
                    </h3>
                    <small>Total</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">                
                <div class='box-content box-statistic admin-dashboard-box <?php echo ((int) $s_store_today_added > 0) ? 'red-background' : ''; ?> has-tooltip' title='Today Added'>
                    <h3 class='title text-info'><?php echo $s_store_today_added; ?></h3>
                    <small>Today Added</small>
                </div>                
            </div>
            <div class="col-sm-4">
                <a href="<?php echo site_url().'admin/users/index/storeUser?store_is_inappropriate=&status=&filter=wt&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box <?php echo ((int) $s_store_store_waiting > 0) ? 'red-background' : ''; ?> has-tooltip' title='Waiting for Store Details Verification'>
                    <h3 class='title text-info'><?php echo $s_store_store_waiting; ?></h3>
                    <small>Waiting - Store Details Approval</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url(); ?>admin/users/featured_stores/featured">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Featured Stores'>
                    <h3 class='title text-info'><?php echo $s_store_featured_stores; ?></h3>
                    <small>Featured</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/storeUser?store_is_inappropriate=Approve&status=&filter=all&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Approve Stores'>
                    <h3 class='title text-info'><?php echo $s_store_approved_ads; ?></h3>
                    <small>Approve</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/storeUser?store_is_inappropriate=Unapprove&status=&filter=all&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Un-approve Stores'>
                    <h3 class='title text-info'><?php echo $s_store_unapproved_ads; ?></h3>
                    <small>Unapprove</small>
                </div> 
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/storeUser?store_is_inappropriate=NeedReview&status=&filter=all&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='NeedReview Stores'>
                    <h3 class='title text-info'><?php echo $s_store_needreview_ads; ?></h3>
                    <small>NeedReview</small>
                </div>   
                </a>
            </div> 
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/storeUser?store_is_inappropriate=Inappropriate&status=&filter=all&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='In-appropriate Stores'>
                    <h3 class='title text-info'><?php echo $s_store_inappropriate_ads; ?></h3>
                    <small>Inappropriate</small>                                           
                </div>
                </a>
            </div>                                        
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/storeUser?store_is_inappropriate=Approve&store_status=0&filter=all&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Approved Active Stores'>
                    <h3 class='title text-info'><?php echo $s_store_active; ?></h3>
                    <small>Active</small>                                                
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/storeUser?store_is_inappropriate=Approve&store_status=3&filter=all&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Approved Hold Stores'>
                    <h3 class='title text-info'><?php echo $s_store_hold; ?></h3>
                    <small>Hold</small>                                                
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/storeUser?store_is_inappropriate=Approve&store_status=&filter=blo&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Block Stores'>
                    <h3 class='title text-info'><?php echo $s_store_hold; ?></h3>
                    <small>Block</small>                                                
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Deleted Stores'>
                    <h3 class='title text-info'><?php echo $s_store_deleted; ?></h3>
                    <small>Deleted</small>                                                
                </div>
            </div>
        </div>
    </div>
</div>
