<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 MostViewsHedding">        
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

        $path = '';
        
        if(isset($like_ads))
            $path = 'user/like';
        elseif(isset($favorite_ads))
            $path = 'user/favorite';
        elseif(isset($my_deactivateads))
            $path = 'user/deactivateads';
        elseif(isset($my_listing)) {
            $path = 'user/my_listing';
        }
        
        $grid_path = base_url(). $path.'?view=grid';
        $list_path = base_url(). $path.'?view=list';
        $map_path  = base_url(). $path.'?view=map';
        
        if(isset($my_listing)) {
            
            $path = 'user/my_listing';
            if (!isset($_REQUEST['val']) || $_REQUEST['val'] == 'Approve') {
                $grid_path .= '&val=Approve';                
                $list_path .= '&val=Approve';                
                $map_path  .= '&val=Approve';
            }
            elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == 'NeedReview') {
                $grid_path .= '&val=NeedReview';                
                $list_path .= '&val=NeedReview';                
                $map_path  .= '&val=NeedReview';
            }
            elseif (isset($_REQUEST['val']) && $_REQUEST['val'] == 'Unapprove') {
                $grid_path .= '&val=Unapprove';                
                $list_path .= '&val=Unapprove';
                $map_path  .= '&val=Unapprove';
            }
        }
        
        ?>    
        <a href="<?php echo $grid_path; ?>" class="<?php echo $view_active1; ?>"><span class="fa  fa-th"></span></a>
        <a href="<?php echo $list_path; ?>" class="<?php echo $view_active2; ?>"><span class="fa fa-th-list"></span></a>
        <a href="<?php echo $map_path; ?>" class="<?php echo $view_active3; ?>"><span class="fa  fa-map-marker"></span></a>
            <br><br>
    </div>
</div>