<div class='row'>
    <div class='col-sm-12 col-md-12 box'>
        <div class='box-header orange-background col-md-11'>
            <div class='title'>
                <i class=' icon-shopping-cart'></i>
                Companies
            </div>
            <div class='actions'>
                <a class="btn box-collapse btn-mini btn-link" href="javascript:void(0);"><i></i>
                </a>
            </div>
        </div>

        <?php
        $featured_companies = 0;
        $companies_totals = 0;
        $companies_deleted = 0;
        $companies_approved_ads = 0;
        $companies_needreview_ads = 0;
        $companies_inappropriate_ads = 0;
        $s_store_unapproved_ads = 0;
        $companies_block = 0;
        $companies_hold = 0;
        $companies_active = 0;
        $companies_today_added = 0;
        
        foreach ($companies as $c) {
            $companies_totals = $c['companies_totals'];
            $companies_deleted = $c['companies_deleted'];
            $companies_approved_ads = $c['companies_approved_ads'];
            $companies_needreview_ads = $c['companies_needreview_ads'];
            $companies_inappropriate_ads = $c['companies_inappropriate_ads'];
            $companies_unapproved_ads = $c['companies_unapproved_ads'];
            $companies_block = $c['companies_block'];
            $companies_hold = $c['companies_hold'];
            $companies_active = $c['companies_active'];
            $companies_today_added = $c['companies_today_added'];
            $featured_companies = $c['featured_companies'];            
        }
        ?>                                    
        <div class="box-content col-sm-11 admin-dashboard-box">
            <div class="col-sm-2">
<?php
$companies_total_text = 'Approve : ' . $companies_approved_ads .
'<hr class="hr_listing">Un-approve : ' . $companies_unapproved_ads . '<hr class="hr_listing">'
. 'NeedReview : ' . $companies_needreview_ads . '<hr class="hr_listing">'
. 'Inappropriate : ' . $companies_inappropriate_ads . '<hr class="hr_listing">'
. 'Deleted : ' . $companies_deleted . '<hr class="hr_listing">';
?>
                <a href="javascript:void(0);" title='Total Companies' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $companies_total_text; ?>'>
                <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                    <h3 class='title text-success'>
                        <?php echo $companies_totals; ?>
                    </h3>
                    <small>Total</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/offerUser/?company_is_inappropriate=&company_status=&per_page=10&filter=dt&con=0&st=&dt='.date('Y-m-d').'+to+'.date('Y-m-d').'&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box <?php echo ((int) $companies_today_added > 0) ? 'red-background' : ''; ?> has-tooltip' title='Today Added'>
                    <h3 class='title text-info'><?php echo $companies_today_added; ?></h3>
                    <small>Today Added</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url(); ?>admin/users/featured_companies/featured">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Featured Companies'>
                    <h3 class='title text-info'><?php echo $featured_companies; ?></h3>
                    <small>Featured</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/offerUser?company_is_inappropriate=Approve&company_status=&per_page=10&filter=all&con=0&st=&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Approve Companies'>
                    <h3 class='title text-info'><?php echo $companies_approved_ads; ?></h3>
                    <small>Approve</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/offerUser?company_is_inappropriate=Unapprove&company_status=&per_page=10&filter=all&con=0&st=&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Un-approve Companies'>
                    <h3 class='title text-info'><?php echo $companies_unapproved_ads; ?></h3>
                    <small>Unapprove</small>
                </div> 
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/offerUser?company_is_inappropriate=NeedReview&company_status=&per_page=10&filter=all&con=0&st=&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='NeedReview Companies'>
                    <h3 class='title text-info'><?php echo $companies_needreview_ads; ?></h3>
                    <small>NeedReview</small>
                </div>   
                </a>
            </div> 
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/storeUser?company_is_inappropriate=Inappropriate&company_status=&filter=all&con=0&st=0&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='In-appropriate Companies'>
                    <h3 class='title text-info'><?php echo $companies_inappropriate_ads; ?></h3>
                    <small>Inappropriate</small>                                           
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/offerUser?company_is_inappropriate=&company_status=0&per_page=10&filter=all&con=0&st=&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Approved Active Companies'>
                    <h3 class='title text-info'><?php echo $companies_active; ?></h3>
                    <small>Active</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/offerUser?company_is_inappropriate=&company_status=3&per_page=10&filter=all&con=0&st=&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Hold Approved Companies'>
                    <h3 class='title text-info'><?php echo $companies_hold; ?></h3>
                    <small>Hold</small>                                                
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo site_url().'admin/users/index/offerUser?company_is_inappropriate=&company_status=&per_page=10&filter=blo&con=0&st=&dt=&submit='; ?>">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Block Approved Companies'>
                    <h3 class='title text-info'><?php echo $companies_block; ?></h3>
                    <small>Block</small>
                </div>
                </a>
            </div>
            <div class="col-sm-2">
                <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Deleted Companies'>
                    <h3 class='title text-info'><?php echo $companies_deleted; ?></h3>
                    <small>Deleted</small>
                </div>
            </div>
        </div>
    </div>
</div>