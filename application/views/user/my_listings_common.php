<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 MostViewsHedding"><?php
    $myval = '';
    $sts = '';
    if (isset($_REQUEST['val']) && $_REQUEST['val'] == "Unapprove") {
        $sts = 'Unapproved Ads';
        $myval = 'Unapprove';
    } elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == "NeedReview") {
        $sts = 'Waiting for Approval Ads';
        $myval = 'NeedReview';
    } else {
        $sts = 'Approved Ads';
        $myval = 'Approve';
    }
    ?>
    <h3>
        <?php echo $sts; ?>
        <div class="col-sm-12 text-right views">
            <?php
            $view_active1 = '';
            $view_active2 = '';
            $view_active3 = '';

            if (!isset($_GET['view']) || (isset($_GET['view']) && $_GET['view'] == 'grid'))
                $view_active1 = 'view-active';
            elseif (isset($_GET['view']) && $_GET['view'] == 'list')
                $view_active2 = 'view-active';
            elseif (isset($_GET['view']) && $_GET['view'] == 'map')
                $view_active3 = 'view-active';

            $path = 'user/my_listing';

            $grid_path = base_url() . $path;
            $list_path = base_url() . $path;
            $map_path = base_url() . $path;
            $path = site_url() . 'user/my_listing';

            if (!isset($_REQUEST['val']) || $_REQUEST['val'] == 'Approve') {
                $grid_path .= '?val=Approve';                
                $list_path .= '?val=Approve&view=list';                
                $map_path .= '?val=Approve&view=map';
            }
            elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == 'NeedReview') {
                $grid_path .= '?val=NeedReview';                
                $list_path .= '?val=NeedReview&view=list';                
                $map_path .= '?val=NeedReview&view=map';
            }
            elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == 'Unapprove') {
                $grid_path .= '?val=Unapprove';                
                $list_path .= '?val=Unapprove&view=list';                
                $map_path .= '?val=Unapprove&view=map';
            }
            ?>    
            <a href="<?php echo $grid_path; ?>" class="<?php echo $view_active1; ?>"><span class="fa  fa-th"></span></a>
            <a href="<?php echo $list_path; ?>" class="<?php echo $view_active2; ?>"><span class="fa fa-th-list"></span></a>
            <a href="<?php echo $map_path; ?>" class="<?php echo $view_active3; ?>"><span class="fa  fa-map-marker"></span></a>
                <br><br>
        </div>
    </h3>
</div>
<input type="hidden" name="val" id="val" value="<?php echo $myval; ?>">
<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">