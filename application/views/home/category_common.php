<div class="col-sm-6">
    <?php $this->load->view('include/breadcrumb'); ?>     
    <span class="result"><?php echo @$subcat_name?@$subcat_total:@$total; ?> Results</span>
</div>
<?php ?>
<div class="col-sm-6 text-right views">
	<?php
                $emirate =  $this->uri->segment(1);   
                $cate_path = $slug;
                        
		if(!isset($_GET['view']) || (isset($_GET['view']) && $_GET['view']=='grid')) {
                    if(in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain')))
                        $cate_path = $emirate.'/'.$slug.'?view=grid';     
                    else    
                        $cate_path = $slug.'?view=grid';
                    
                    if(isset($_GET['s']))
                        $cate_path .= '&s='.$_GET['s'];
                }
		elseif(isset($_GET['view']) && $_GET['view']=='list') {
                    if(in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','rak','sharjah','uaq')))
                        $cate_path = $emirate.'/'.$slug.'?view=list';     
                    else
                        $cate_path = $slug.'?view=list';
                    if(isset($_GET['s']))
                        $cate_path .= '&s='.$_GET['s'];
                }
		elseif(isset($_GET['view']) && $_GET['view']=='map') {
                    if(in_array(strtolower($emirate),array('abudhabi','ajman','dubai','fujairah','ras-al-khaimah','sharjah','umm-al-quwain')))
                        $cate_path = $emirate.'/'.$slug.'?view=map';     
                    else
                        $cate_path = $slug.'?view=map';
                    if(isset($_GET['s']))
                        $cate_path .= '&s='.$_GET['s'];
                }
	?>
	 <form name="sort-form" id="sort-form" class="SortBy-option" action="<?php echo base_url().$cate_path; ?>" method="post">
		<span>Sort By:</span>
		  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu6" data-toggle="dropdown" aria-expanded="true">
			<?php if(isset($_REQUEST['order'])){
					  if($_REQUEST['order'] != '' && $_REQUEST['order']=='lh')
						echo 'Price Low To High';									   
					  elseif($_REQUEST['order'] != '' && $_REQUEST['order']=='hl') 
						echo 'Price High To Low';
					  else
						echo 'Default'; 									  
					}
					else {
						echo 'Default';
					} ?>
			<span class="caret"></span>
		  </button>
		<ul id="price_sort" role="menu" class="dropdown-menu" aria-labelledby="dropdownMenu6">
			<li role="presentation"><a role="menuitem" data-state="" tabindex="-1" 
				href="<?php echo site_url().$cate_path; ?>"  rel="nofollow" >Default</a></li>
			<li role="presentation"><a role="menuitem" data-state="L_H" tabindex="-1" href="<?php echo site_url().$cate_path.'&order=lh'; ?>"  rel="nofollow" >Price Low To High</a></li>
			<li role="presentation"><a role="menuitem" data-state="H_L" tabindex="-1" href="<?php echo site_url().$cate_path.'&order=hl'; ?>"  rel="nofollow" >Price High To Low</a></li>
		</ul>
	  </form>
	  <?php 			
			$view_active1	=	'';	
			$view_active2	=	'';	
			$view_active3	=	'';	
			if(!isset($_GET['view']) || (isset($_GET['view']) && $_GET['view']=='grid'))
				$view_active1	=	'view-active';
			elseif(isset($_GET['view']) && $_GET['view']=='list')
				$view_active2	=	'view-active';
			elseif(isset($_GET['view']) && $_GET['view']=='map')
				$view_active3	=	'view-active';
                        
                        $grid_path = base_url().emirate_slug.$slug.'/?view=grid';
                        $list_path = base_url().emirate_slug.$slug.'/?view=list';
                        $map_path  = base_url().emirate_slug.$slug.'/?view=map';
                        
                        if(isset($_GET['s'])) {
                            $grid_path .= "&s=".$_GET['s'];
                            $list_path .= "&s=".$_GET['s'];
                            $map_path  .= "&s=".$_GET['s'];
                        }
	  ?>
	  
	  <a href="<?php echo $grid_path; ?><?php echo $order_option; ?>" class="<?php echo $view_active1; ?>"><span class="fa  fa-th"></span></a>

	  <a href="<?php echo  $list_path; ?><?php echo $order_option; ?>" class="<?php echo $view_active2; ?>"><span class="fa  fa-th-list"></span></a>

	  <a href="<?php echo  $map_path; ?><?php echo $order_option; ?>" class="<?php echo $view_active3; ?>"><span class="fa  fa-map-marker"></span></a>
</div>