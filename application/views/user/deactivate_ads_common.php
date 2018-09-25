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

        $path = 'user/deactivateads';

        $grid_path = base_url() . $path;
        $list_path = base_url() . $path.'?view=list';
        $map_path = base_url() . $path.'?view=map';        

        ?>    
        <a href="<?php echo $grid_path; ?>" class="<?php echo $view_active1; ?>"><span class="fa  fa-th"></span></a>
        <a href="<?php echo $list_path; ?>" class="<?php echo $view_active2; ?>"><span class="fa fa-th-list"></span></a>
        <a href="<?php echo $map_path; ?>" class="<?php echo $view_active3; ?>"><span class="fa  fa-map-marker"></span></a>
            <br><br>
    </div>    
</div>