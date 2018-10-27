<div class="col-sm-6 text-right views latest_pg_views border-title ">
    <?php
    $view_active1 = '';
    $view_active2 = '';
    $view_active3 = '';
    
    if (!isset($_GET['view']) || (isset($_GET['view']) && ($_GET['view'] == 'grid' || empty($_GET['view']))))
        $view_active1 = 'view-active';
    elseif (isset($_GET['view']) && $_GET['view'] == 'list')
        $view_active2 = 'view-active';
    elseif (isset($_GET['view']) && $_GET['view'] == 'map')
        $view_active3 = 'view-active';
    ?>

    <a href="<?php echo base_url() . emirate_slug . 'latest/?view=grid'; ?>" class="<?php echo $view_active1; ?>"><span class="fa fa-th"></span></a>
    <a href="<?php echo base_url() . emirate_slug . 'latest/?view=list'; ?>" class="<?php echo $view_active2; ?>"><span class="fa fa-th-list"></span></a>
    <a href="<?php echo base_url() . emirate_slug . 'latest/?view=map'; ?>" class="<?php echo $view_active3; ?>"><span class="fa fa-map-marker"></span></a>
</div>