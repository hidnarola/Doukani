<div class="col-sm-12 text-right views">
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

    $grid_path = base_url() . emirate_slug . $slug . '/?view=grid';
    $list_path = base_url() . emirate_slug . $slug . '/?view=list';
    $map_path = base_url() . emirate_slug . $slug . '/?view=map';
    ?>
    <form name="sort-opt" id="sort-opt" class="SortBy-option" action="#" method="post">
        <span>Sort By:</span>
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-expanded="true">
            <?php
            if (isset($_REQUEST['order'])) {
                if ($_REQUEST['order'] != '' && $_REQUEST['order'] == 'lh')
                    echo 'Price Low To High';
                elseif ($_REQUEST['order'] != '' && $_REQUEST['order'] == 'hl')
                    echo 'Price High To Low';
                else
                    echo 'Default';
            }
            else {
                echo 'Default';
            }
            ?>
            <span class="caret"></span>
        </button>		  
        <?php
        $emirate = $this->uri->segment(1);
        $seller_path = $slug;

        if (!isset($_GET['view']) || (isset($_GET['view']) && ($_GET['view'] == 'grid' || empty($_GET['view'])))) {
            if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                $seller_path = $emirate . '/' . $slug . '?view=grid';
            else
                $seller_path = $slug . '?view=grid';
        }
        elseif (isset($_GET['view']) && $_GET['view'] == 'list') {
            if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'rak', 'sharjah', 'uaq')))
                $seller_path = $emirate . '/' . $slug . '?view=list';
            else
                $seller_path = $slug . '?view=list';
        }
        elseif (isset($_GET['view']) && $_GET['view'] == 'map') {
            if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain')))
                $seller_path = $emirate . '/' . $slug . '?view=map';
            else
                $seller_path = $slug . '?view=map';
        }
        ?>
        <ul id="sort" role="menu" class="dropdown-menu" aria-labelledby="dropdownMenu5">
            <li role="presentation"><a role="menuitem" data-state="" tabindex="-1" href="<?php echo site_url() . $seller_path; ?>">Default</a></li>
            <li role="presentation"><a role="menuitem" data-state="L_H" tabindex="-1" href="<?php echo site_url() . $seller_path . '&order=lh'; ?>" >Price Low To High</a></li>
            <li role="presentation"><a role="menuitem" data-state="H_L" tabindex="-1" href="<?php echo site_url() . $seller_path . '&order=hl'; ?>" >Price High To Low</a></li>
        </ul>								  
    </form>
    <a href="<?php echo $grid_path; ?><?php echo $order_option; ?>" class="<?php echo $view_active1; ?>"><span class="fa  fa-th"></span></a>		
    <a href="<?php echo $list_path; ?><?php echo $order_option; ?>" class="<?php echo $view_active2; ?>"><span class="fa fa-th-list"></span></a>
    <a href="<?php echo $map_path; ?><?php echo $order_option; ?>" class="<?php echo $view_active3; ?>"><span class="fa  fa-map-marker"></span></a>
</div>