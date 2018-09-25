<div class='row'>
    <div class='col-md-12 box'>
        <div class='box-header green-background col-md-11'>
            <div class='title'>
                <i class='icon-list'></i>
                Listings
            </div>
            <div class='actions'>
                <a class="btn box-collapse btn-mini btn-link" href="javascript:void(0);"><i></i>
                </a>
            </div>
        </div>                            
        <div class="col-md-11 box-content admin-dashboard-box">
            <div class="row">
                <div class="col-sm-4">
                    <?php
                    $store_not_approve_ads = 0;
                    $classified_listing_total = 0;
                    $classified_listing_today_added = 0;

                    $classified_approved_ads = 0;
                    $classified_unapproved_ads = 0;
                    $classified_needreview_ads = 0;
                    $classified_inappropriate_ads = 0;

                    $new_classified_approve_ads = 0;
                    $new_classified_needreview_ads = 0;
                    $new_classified_inappropriate_ads = 0;
                    $new_classified_unapprove_ads = 0;

                    $repost_classified_approve_ads = 0;
                    $repost_classified_needreview_ads = 0;
                    $repost_classified_inappropriate_ads = 0;
                    $repost_classified_unapprove_ads = 0;

                    $classified_sold_ads = 0;
                    $classified_deactivated_ads = 0;
                    $classified_deleted_ads = 0;
                    $classified_block_ads = 0;
                    $classified_hold_ads = 0;

                    $store_listing_total = 0;
                    $store_listing_today_added = 0;
                    $store_approved_ads = 0;
                    $store_unapproved_ads = 0;
                    $store_needreview_ads = 0;
                    $store_inappropriate_ads = 0;
                    $store_deactivated_ads = 0;
                    $store_deleted_ads = 0;
                    $store_block_ads = 0;
                    $store_hold_ads = 0;

                    $offer_listing_total = 0;
                    $offer_listing_today_added = 0;
                    $offer_approved_ads = 0;
                    $offer_unapproved_ads = 0;
                    $offer_needreview_ads = 0;
                    $offer_inappropriate_ads = 0;
                    $offer_deactivated_ads = 0;
                    $offer_deleted_ads = 0;
                    $offer_block_ads = 0;
                    $offer_hold_ads = 0;

                    $new_store_approve_ads = 0;
                    $new_store_needreview_ads = 0;
                    $new_store_inappropriate_ads = 0;
                    $new_store_unapprove_ads = 0;

                    $repost_store_approve_ads = 0;
                    $repost_store_needreview_ads = 0;
                    $repost_store_inappropriate_ads = 0;
                    $repost_store_unapprove_ads = 0;

                    foreach ($products as $prod) {

                        $store_not_approve_ads = $prod['store_not_approve_ads'];
                        $classified_listing_total = $prod['classified_totals'];
                        $classified_listing_today_added = $prod['classified_today_added'];
                        $classified_approved_ads = $prod['classified_approved_ads'];
                        $classified_unapproved_ads = $prod['classified_unapproved_ads'];
                        $classified_needreview_ads = $prod['classified_needreview_ads'];
                        $classified_inappropriate_ads = $prod['classified_inappropriate_ads'];

                        $repost_classified_approve_ads = $repost_counts['repost_classified_approve_ads'];
                        $repost_classified_needreview_ads = $repost_counts['repost_classified_needreview_ads'];
                        $repost_classified_inappropriate_ads = $repost_counts['repost_classified_inappropriate_ads'];
                        $repost_classified_unapprove_ads = $repost_counts['repost_classified_unapprove_ads'];

                        $new_classified_approve_ads = (int) $classified_approved_ads - (int) $repost_classified_approve_ads;
                        $new_classified_needreview_ads = (int) $classified_needreview_ads - (int) $repost_classified_needreview_ads;
                        $new_classified_inappropriate_ads = (int) $classified_inappropriate_ads - (int) $repost_classified_inappropriate_ads;
                        $new_classified_unapprove_ads = (int) $classified_unapproved_ads - (int) $repost_classified_unapprove_ads;

                        $classified_deactivated_ads = $prod['classified_deactivated_Ads'];
                        $repost_classified_deactivated_Ads = $repost_counts['repost_classified_deactivated_Ads'];

                        $new_classified_deactivated_Ads = (int) $classified_deactivated_ads - (int) $repost_classified_deactivated_Ads;

                        $classified_deleted_ads = $prod['classified_deleted'];

                        $classified_block_ads = $prod['classified_block_ads'];
                        $repost_classified_block_ads = $repost_counts['repost_classified_block_ads'];
                        $new_classified_block_ads = (int) $classified_block_ads - (int) $repost_classified_block_ads;

                        $store_listing_total = $prod['store_totals'];
                        $store_listing_today_added = $prod['store_today_added'];

                        $store_deactivated_ads = $prod['store_deactivated_Ads'];
                        $repost_store_deactivated_Ads = $repost_counts['repost_store_deactivated_Ads'];

                        $new_store_deactivated_Ads = (int) $store_deactivated_ads - (int) $repost_store_deactivated_Ads;

                        $store_deleted_ads = $prod['store_deleted'];
                        $store_block_ads = $prod['store_block_ads'];
                        $repost_store_block_ads = $repost_counts['repost_store_block_ads'];

                        $new_store_block_ads = (int) $store_block_ads - (int) $repost_store_block_ads;

                        $store_hold_ads = $prod['store_hold_ads'];
                        $repost_store_hold_ads = $repost_counts['repost_store_hold_ads'];

                        $new_store_hold_ads = (int) $store_hold_ads - (int) $repost_store_hold_ads;

                        $store_approved_ads = $prod['store_approved_ads'];
                        $store_unapproved_ads = $prod['store_unapproved_ads'];
                        $store_needreview_ads = $prod['store_needreview_ads'];
                        $store_inappropriate_ads = $prod['store_inappropriate_ads'];

                        $repost_store_approve_ads = $repost_counts['repost_store_approve_ads'];
                        $repost_store_needreview_ads = $repost_counts['repost_store_needreview_ads'];
                        $repost_store_inappropriate_ads = $repost_counts['repost_store_inappropriate_ads'];
                        $repost_store_unapprove_ads = $repost_counts['repost_store_unapprove_ads'];


                        $new_store_approve_ads = (int) $store_approved_ads - (int) $repost_store_approve_ads;
                        $new_store_needreview_ads = (int) $store_needreview_ads - (int) $repost_store_needreview_ads;
                        $new_store_inappropriate_ads = (int) $store_inappropriate_ads - (int) $repost_store_inappropriate_ads;
                        $new_store_unapprove_ads = (int) $store_unapproved_ads - (int) $repost_store_unapprove_ads;
                    }
                    ?>
                    <div class="box bordered-box blue-border box-nomargin">
                        <div class="box-header muted-background">
                            <div class="title">
                                Classified Ads
                            </div>
                            <div class="actions">
                                <a class="btn box-remove btn-xs btn-link" href="javascript:void(0);"><i class="icon-remove"></i></a>
                                <a class="btn box-collapse btn-xs btn-link" href="javascript:void(0);"><i></i>
                                </a>
                            </div>
                        </div>
                        <div class="box-content admin-dashboard-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php
                                    $clasiified_total_text = 'Approve : ' . $classified_approved_ads .
                                            '<hr class="hr_listing">Un-approve : ' . $classified_unapproved_ads . '<hr class="hr_listing">'
                                            . 'NeedReview : ' . $classified_needreview_ads . '<hr class="hr_listing">'
                                            . 'Inappropriate : ' . $classified_inappropriate_ads . '<hr class="hr_listing">'
                                            . 'Deleted : ' . $classified_deleted_ads . '<hr class="hr_listing">'
                                            . 'Blocked : ' . $classified_block_ads;
                                    ?>
                                    <a href="javascript:void(0);" title='Total Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $clasiified_total_text; ?>' >
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-success'>
                                                <?php echo $classified_listing_total; ?>
                                            </h3>
                                            <small>Total</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="<?php echo site_url() . 'admin/classifieds/listings/classified?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=' . date('Y-m-d') . '+to+' . date('Y-m-d') . '&status=0&other_status=0&submit_filter='; ?>" >
                                        <div class='box-content box-statistic admin-dashboard-box <?php echo ((int) $classified_listing_today_added > 0) ? 'red-background' : ''; ?> has-tooltip' title='Today Added'>
                                            <h3 class='title text-info'><?php echo $classified_listing_today_added; ?></h3>
                                            <small>Today Added</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="<?php echo site_url() . 'admin/classifieds/featured_ads/featured'; ?>">
                                        <div class='box-content box-statistic admin-dashboard-box'>
                                            <h3 class='title text-info'><?php echo $classified_featured_ads; ?></h3>
                                            <small>Featured Ads</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $clasiified_approved_text = '<a href="' . site_url() . 'admin/classifieds/listings/classified?filter=0&con=4&st=&cat=0&sub_cat=0&dt=&status=Approve&other_status=0&submit_filter=">New : ' . $new_classified_approve_ads . '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/classifieds/repost_ads/classified?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=&status=Approve&other_status=0&submit_filter=" >Repost : ' . $repost_classified_approve_ads . '</a>';
                                    ?>
                                    <a href="javascript:void(0);" title='Approve Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $clasiified_approved_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip' >
                                            <h3 class='title text-info'>
                                                <?php echo $classified_approved_ads; ?>
                                            </h3>
                                            <small>Approve</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    $clasiified_unapproved_text = '<a href="' . site_url() . 'admin/classifieds/listings/classified?filter=0&con=4&st=&cat=0&sub_cat=0&dt=&status=Unapprove&other_status=0&submit_filter=" >New : ' . $new_classified_unapprove_ads . '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/classifieds/repost_ads/classified?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=&status=Unapprove&other_status=0&submit_filter=">Repost : ' . $repost_classified_unapprove_ads . '</a>';
                                    ?>
                                    <a href="javascript:void(0);" title='Un-Approve Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $clasiified_unapproved_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $classified_unapproved_ads; ?>
                                            </h3>
                                            <small>Un-approve</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $clasiified_needreview_text = '<a href="' . site_url() . 'admin/classifieds/listings/classified?filter=0&con=4&st=&cat=0&sub_cat=0&dt=&status=NeedReview&other_status=0&submit_filter=">New : ' . $new_classified_needreview_ads . '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/classifieds/repost_ads/classified?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=&status=NeedReview&other_status=0&submit_filter=">Repost : ' . $repost_classified_needreview_ads . '</a>';
                                    ?>
                                    <a href="javascript:void(0);" title='NeedReview Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $clasiified_needreview_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $classified_needreview_ads; ?>
                                            </h3>
                                            <small>NeedReview</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    $clasiified_inappropriate_text = '<a href="' . site_url() . 'admin/classifieds/listings/classified?filter=0&con=4&st=&cat=0&sub_cat=0&dt=&status=Inappropriate&other_status=0&submit_filter=">New : ' . $new_classified_inappropriate_ads . '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/classifieds/repost_ads/classified?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=&status=Inappropriate&other_status=0&submit_filter=">Repost : ' . $repost_classified_inappropriate_ads . '</a>';
                                    ?>
                                    <a href="javascript:void(0);" title='In-appropriate Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $clasiified_inappropriate_text; ?>' >
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $classified_inappropriate_ads; ?>
                                            </h3>
                                            <small>In-appropriate</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $clasiified_deactivated_text = 'New : ' . $new_classified_deactivated_Ads .
                                            '<hr class="hr_listing">Repost : ' . $repost_classified_deactivated_Ads;
                                    ?>
                                    <a href="javascript:void(0);" title='Deactivated Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $clasiified_deactivated_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $classified_deactivated_ads; ?>
                                            </h3>
                                            <small>Deactivated</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Deleted Ads'>
                                        <h3 class='title text-info'><?php echo $classified_deleted_ads; ?></h3>
                                        <small>Deleted</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $clasiified_block_text = 'New : ' . $new_classified_block_ads . '<hr class="hr_listing">Repost : ' . $repost_classified_block_ads;
                                    ?>        
                                    <a href="javascript:void(0);" title='Blocked Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $clasiified_block_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $classified_block_ads; ?>
                                            </h3>
                                            <small>Blocked</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box bordered-box blue-border box-nomargin">
                        <div class="box-header orange-background">
                            <div class="title">
                                Store Ads
                            </div>
                            <div class="actions">
                                <a class="btn box-remove btn-xs btn-link" href="javascript:void(0);"><i class="icon-remove"></i></a>
                                <a class="btn box-collapse btn-xs btn-link" href="javascript:void(0);"><i></i>
                                </a>
                            </div>
                        </div>
                        <div class="box-content admin-dashboard-box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    $store_total_text = 'Approve : ' . $store_approved_ads .
                                            '<hr class="hr_listing">Unapprove : ' . $store_unapproved_ads . '<hr class="hr_listing">'
                                            . 'NeedReview : ' . $store_needreview_ads . '<hr class="hr_listing">'
                                            . 'Inappropriate : ' . $store_inappropriate_ads . '<hr class="hr_listing">'
                                            . 'Deleted : ' . $store_deleted_ads . '<hr class="hr_listing">'
                                            . 'Blocked : ' . $store_block_ads . '<hr class="hr_listing">'
                                            . 'Still store not approved : ' . $store_not_approve_ads;
                                    ?>
                                    <a href="javascript:void(0);" title='Total Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_total_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-success'>
                                                <?php echo $store_listing_total; ?>
                                            </h3>
                                            <small>Total</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="<?php echo site_url() . 'admin/classifieds/listings/store?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=' . date('Y-m-d') . '+to+' . date('Y-m-d') . '&status=0&other_status=0&submit_filter='; ?>">
                                        <div class='box-content box-statistic admin-dashboard-box <?php echo ((int) $store_listing_today_added > 0) ? 'red-background' : ''; ?> has-tooltip' title='Today Added'>
                                            <h3 class='title text-info'><?php echo $store_listing_today_added; ?></h3>
                                            <small>Today Added</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    $store_approve_text = '<a href="' . site_url() . 'admin/classifieds/listings/store?filter=0&con=4&st=&cat=0&sub_cat=0&dt=&status=Approve&other_status=0&submit_filter=">New : ' . $new_store_approve_ads .
                                            '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/classifieds/repost_ads/store?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=&status=Approve&other_status=0&submit_filter=" >Repost : ' . $repost_store_approve_ads . '</a>';
                                    ?>
                                    <a href="javascript:void(0);" title='Approve Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_approve_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $store_approved_ads; ?>
                                            </h3>
                                            <small>Approve</small>
                                        </div>
                                    </a>    
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $store_unapprove_text = '<a href="' . site_url() . 'admin/classifieds/listings/store?filter=0&con=4&st=&cat=0&sub_cat=0&dt=&status=Unapprove&other_status=0&submit_filter=">New : ' . $new_store_unapprove_ads .
                                            '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/classifieds/repost_ads/store?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=&status=Unapprove&other_status=0&submit_filter=">Repost : ' . $repost_store_unapprove_ads . '</a>';
                                    ?>
                                    <a href="javascript:void(0);" title='Unapprove Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_unapprove_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip' >
                                            <h3 class='title text-info'>
                                                <?php echo $store_unapproved_ads; ?>
                                            </h3>
                                            <small>Un-approve</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    $store_needreview_text = '<a href="' . site_url() . 'admin/classifieds/listings/store?filter=0&con=4&st=&cat=0&sub_cat=0&dt=&status=NeedReview&other_status=0&submit_filter=">New : ' . $new_store_needreview_ads .
                                            '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/classifieds/repost_ads/store?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=&status=NeedReview&other_status=0&submit_filter=">Repost : ' . $repost_store_needreview_ads . '</a>';
                                    ?>
                                    <a href="javascript:void(0);" title='NeedReview Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_needreview_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $store_needreview_ads; ?>
                                            </h3>
                                            <small>NeedReview</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $store_inappropriate_text = '<a href="' . site_url() . 'admin/classifieds/listings/store?filter=0&con=4&st=&cat=0&sub_cat=0&dt=&status=Inappropriate&other_status=0&submit_filter=">New : ' . $new_store_inappropriate_ads . '</a><hr class="hr_listing"><a href="' . site_url() . 'admin/classifieds/repost_ads/store?filter=0&con=0&st=0&cat=0&sub_cat=0&dt=&status=Inappropriate&other_status=0&submit_filter=">Repost : ' . $repost_store_inappropriate_ads . '</a>';
                                    ?>
                                    <a href="javascript:void(0);" title='In-appropriate Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_inappropriate_text; ?>' >
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip' >
                                            <h3 class='title text-info'>
                                                <?php echo $store_inappropriate_ads; ?>
                                            </h3>
                                            <small>In-appropriate</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    $store_deactivated_text = 'New : ' . $new_store_deactivated_Ads .
                                            '<hr class="hr_listing">Repost : ' . $repost_store_deactivated_Ads;
                                    ?>
                                    <a href="javascript:void(0);" title='Deactivated Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_deactivated_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $store_deactivated_ads; ?>
                                            </h3>
                                            <small>Deactivated</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Deleted Ads'>
                                        <h3 class='title text-info'><?php echo $store_deleted_ads; ?></h3>
                                        <small>Deleted</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    $store_block_text = 'New : ' . $new_store_block_ads . '<hr class="hr_listing">Repost : ' . $repost_store_block_ads;
                                    ?>
                                    <a href="javascript:void(0);"  title='Blocked Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_block_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $store_block_ads; ?>
                                            </h3>
                                            <small>Blocked</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <?php
                                    $store_hold_text = 'New : ' . $new_store_hold_ads .
                                            '<hr class="hr_listing">Repost : ' . $repost_store_hold_ads;
                                    ?>
                                    <a href="javascript:void(0);" title='Hold Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $store_hold_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip' >
                                            <h3 class='title text-info'>
                                                <?php echo $store_hold_ads; ?>
                                            </h3>
                                            <small>Hold</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="box bordered-box blue-border box-nomargin">
                        <div class="box-header purple-background">
                            <div class="title">
                                Offer Ads
                            </div>
                            <div class="actions">
                                <a class="btn box-remove btn-xs btn-link" href="javascript:void(0);"><i class="icon-remove"></i></a>
                                <a class="btn box-collapse btn-xs btn-link" href="javascript:void(0);"><i></i>
                                </a>
                            </div>
                        </div>
                        <div class="box-content admin-dashboard-box">
                            <div class="row">
                                <div class="col-sm-6">
                                    <?php
                                    $offer_totals = 0;
                                    $offer_deleted = 0;
                                    $offer_block_ads = 0;
                                    $offer_today_added = 0;
                                    $offer_approved_ads = 0;
                                    $offer_wait_approval_ads = 0;
                                    $offer_inappropriate_ads = 0;
                                    $offer_hold_ads = 0;
                                    $offer_companynot_approved = 0;

                                    foreach ($offer_ads as $ad) {

                                        $offer_totals = $ad['offer_totals'];
                                        $offer_deleted = $ad['offer_deleted'];
                                        $offer_block_ads = $ad['offer_block_ads'];
                                        $offer_today_added = $ad['offer_today_added'];
                                        $offer_approved_ads = $ad['offer_approved_ads'];
                                        $offer_wait_approval_ads = $ad['offer_wait_approval_ads'];
                                        $offer_unapprove_ads = $ad['offer_unapprove_ads'];
                                        $offer_hold_ads = $ad['offer_hold_ads'];
                                        $offer_companynot_approved = $ad['offer_companynot_approved'];
                                    }

                                    $offer_total_text = 'Approve : ' . $offer_approved_ads . '<hr class="hr_listing">'
                                            . 'Waiting : ' . $offer_wait_approval_ads . '<hr class="hr_listing">'
                                            . 'Unapprove : ' . $offer_unapprove_ads . '<hr class="hr_listing">'
                                            . 'Deleted : ' . $offer_deleted . '<hr class="hr_listing">'
                                            . 'Blocked : ' . $offer_block_ads . '<hr class="hr_listing">';
                                    ?>
                                    <a href="javascript:void(0);" title='Total Ads' data-toggle="popover" data-placement="top"  data-html="true" data-content='<?php echo $offer_total_text; ?>'>
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-success'>
                                                <?php echo $offer_totals; ?>
                                            </h3>
                                            <small>Total</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="<?php echo site_url() . 'admin/offers/index/?per_page=10&cat=all&dt=' . date('Y-m-d') . '+to+' . date('Y-m-d') . '&status=&submit='; ?>">
                                        <div class='box-content box-statistic admin-dashboard-box <?php echo ((int) $offer_today_added > 0) ? 'red-background' : ''; ?> has-tooltip' title='Today Added'>
                                            <h3 class='title text-info'><?php echo $offer_today_added; ?></h3>
                                            <small>Today Added</small>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">                                    
                                    <a href="<?php echo site_url() . 'admin/offers/index/?cat=0&status=approve&per_page=10'; ?>">
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $offer_approved_ads; ?>
                                            </h3>
                                            <small>Approve</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="<?php echo site_url() . 'admin/offers/index/?cat=0&status=unapprove&per_page=10'; ?>">
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip' >
                                            <h3 class='title text-info'>
                                                <?php echo $offer_unapprove_ads; ?>
                                            </h3>
                                            <small>Un-approve</small>
                                        </div>
                                    </a>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-sm-6">                                    
                                    <a href="<?php echo site_url() . 'admin/offers/index/?cat=0&status=WaitingForApproval&per_page=10'; ?>">
                                        <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                            <h3 class='title text-info'>
                                                <?php echo $offer_wait_approval_ads; ?>
                                            </h3>
                                            <small>Waiting for approval</small>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-6">
                                    <div class='box-content box-statistic admin-dashboard-box has-tooltip' title='Deleted Ads'>
                                        <h3 class='title text-info'><?php echo $offer_deleted; ?></h3>
                                        <small>Deleted</small>
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class='box-content box-statistic admin-dashboard-box has-tooltip'>
                                        <h3 class='title text-info'>
                                            <?php echo $offer_block_ads; ?>
                                        </h3>
                                        <small>Blocked</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='box-content box-statistic admin-dashboard-box has-tooltip' >
                                        <h3 class='title text-info'>
                                            <?php echo $offer_hold_ads; ?>
                                        </h3>
                                        <small>Hold</small>
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
