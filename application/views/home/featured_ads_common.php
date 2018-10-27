<div class="col-sm-12 text-right views">
    <?php
        $view_active1 = '';
        $view_active2 = '';
        $view_active3 = '';

        if (!isset($_GET['view']) || (isset($_GET['view']) && ($_GET['view'] == 'grid' || empty($_GET['view']))))
            $view_active1	=	'view-active';
        elseif(isset($_GET['view']) && $_GET['view']=='list')
            $view_active2	=	'view-active';
        elseif(isset($_GET['view']) && $_GET['view']=='map')
            $view_active3	=	'view-active';      
        
        $grid_path = base_url().emirate_slug.$slug.'/?view=grid';
        $list_path = base_url().emirate_slug.$slug.'/?view=list';
        $map_path  = base_url().emirate_slug.$slug.'/?view=map';
    
        $emirate =  $this->uri->segment(1);   
        $seller_path = $slug;

        if (!isset($_GET['view']) || (isset($_GET['view']) && ($_GET['view'] == 'grid' || empty($_GET['view'])))) {
            if(in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain')))
                $seller_path = $emirate.'/'.$slug.'?view=grid';     
            else    
                $seller_path = $slug.'?view=grid';                    
        }
        elseif(isset($_GET['view']) && $_GET['view']=='list') {
            if(in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','rak','sharjah','uaq')))
                $seller_path = $emirate.'/'.$slug.'?view=list';     
            else
                $seller_path = $slug.'?view=list';
        }
        elseif(isset($_GET['view']) && $_GET['view']=='map') {
            if(in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain')))
                $seller_path = $emirate.'/'.$slug.'?view=map';     
            else
                $seller_path = $slug.'?view=map';                    
        }
    ?>    
    <a href="<?php echo $grid_path; ?>" class="<?php echo $view_active1; ?>"><span class="fa  fa-th"></span></a>
    <a href="<?php echo $list_path; ?>" class="<?php echo $view_active2; ?>"><span class="fa fa-th-list"></span></a>
    <a href="<?php echo $map_path; ?>" class="<?php echo $view_active3; ?>"><span class="fa  fa-map-marker"></span></a>
</div>