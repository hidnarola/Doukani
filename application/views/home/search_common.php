<div class="col-sm-12 text-right views">
    <?php
        $view_active1 = '';
        $view_active2 = '';
        $view_active3 = '';
        
        if(!isset($_GET['view']) || (isset($_GET['view']) && $_GET['view']=='grid'))
            $view_active1	=	'view-active';
        elseif(isset($_GET['view']) && $_GET['view']=='list')
            $view_active2	=	'view-active';
        elseif(isset($_GET['view']) && $_GET['view']=='map')
            $view_active3	=	'view-active';      
        
        $cur_url = ltrim($_SERVER['REQUEST_URI'],"/");
        $cur_url = str_replace('&view=grid','',$cur_url);
        $cur_url = str_replace('?view=grid','',$cur_url);
        $cur_url = str_replace('&view=list','',$cur_url);
        $cur_url = str_replace('?view=list','',$cur_url);
        $cur_url = str_replace('&view=map','',$cur_url);
        $cur_url = str_replace('?view=map','',$cur_url);
        if(isset($_REQUEST['page'])) {
            $cur_url = str_replace('?page='.$_REQUEST['page'],'',$cur_url);        
            $cur_url = str_replace('&page='.$_REQUEST['page'],'',$cur_url);
        }
        
        if(isset($_REQUEST['search']) && $_REQUEST['search']=='search')
            $grid_path = base_url().$cur_url.'&view=grid'; 
        else {
            if(isset($_REQUEST['s']))
                $grid_path = base_url().$cur_url.'&view=grid';
            else
                $grid_path = base_url().emirate_slug.$slug.'/?view=grid';
        }
        
        if(isset($_REQUEST['search']) && $_REQUEST['search']=='search')
            $list_path = base_url().$cur_url.'&view=list';         
        else {
            if(isset($_REQUEST['s']))
                $list_path = base_url().$cur_url.'&view=list';
            else
                $list_path = base_url().emirate_slug.$slug.'/?view=list';
        }
        
        if(isset($_REQUEST['search']) && $_REQUEST['search']=='search')
            $map_path = base_url().$cur_url.'&view=map'; 
        else {
            if(isset($_REQUEST['s']))
                $map_path = base_url().$cur_url.'&view=map';
            else
                $map_path  = base_url().emirate_slug.$slug.'/?view=map';
        }
        
        $emirate =  $this->uri->segment(1);   
        $seller_path = $slug;
        $sts_array = array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain');        
        
    ?>    
    <a href="<?php echo $grid_path; ?>" class="<?php echo $view_active1; ?>"><span class="fa  fa-th"></span></a>
    <a href="<?php echo $list_path; ?>" class="<?php echo $view_active2; ?>"><span class="fa fa-th-list"></span></a>
    <a href="<?php echo $map_path; ?>" class="<?php echo $view_active3; ?>"><span class="fa  fa-map-marker"></span></a>
</div>