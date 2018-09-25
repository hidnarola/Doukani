<div class="menu_cat">
<div class="menuCategories"></div>
</div>
<div class="col-sm-2 LeftCategory category" itemscope itemtype="https://schema.org/WPSideBar">
    <h4 id="cating"><a href="<?php echo site_url() .emirate_slug . 'categories' ?>" style="color:white; text-decoration:none;" class="menu1" itemprop="url">Categories</a></h4>
    <?php
    $category_link = ($this->uri->segment(3) == 'list' || $this->uri->segment(3) == 'map') ? $this->uri->segment(3) : '';
    if (isset($order_option))
        $order_option = $order_option;
    else
        $order_option = '';

    if (isset($_GET['view']) && $_GET['view'] == 'list')
        $view_list = '?view=list';
    elseif (isset($_GET['view']) && $_GET['view'] == 'map')
        $view_list = '?view=map';
    elseif (isset($_GET['view']) && $_GET['view'] == 'grid')
        $view_list = '?view=grid';
    else
        $view_list = '';
   
    ?>
    <div class="menu-wrapper">
        <ul class="main-menu">
            <?php
            
            foreach ($category as $cat):
                $cat_view = '';
                if (isset($category_view) && !empty($category_view))
                    $cat_view = $category_view;
                
                $divide = 0;
                if(isset($cat['sub_categories']))
                    $count_subcat = count($cat['sub_categories']);
                ?>
                <li class="menu1">
                    <a style="color: <?php echo $cat['color']; ?>" href="<?php echo base_url() .emirate_slug. $cat['category_slug'] . '/' . $view_list . $order_option; ?>" itemprop="url" class="cat_link_red">
                        <i class="fa <?php echo $cat['icon']; ?>"></i>
                        <?php echo str_replace('\n', " ", $cat['catagory_name']); ?>
                    </a>
                    <?php if (isset($cat['sub_categories']) && sizeof($cat['sub_categories']) > 0) { ?>
                        <ul class="default-ul <?php echo ($count_subcat>20) ? 'mega-left-menu' : ''; ?>" style="z-index:1111 !important;" >
                            <?php                                
                            foreach ($cat['sub_categories'] as $subcategories) {
                            ?>                                
                            <li class="default-ul-sub-li">
                                <a class="menu1" href="<?php echo base_url() .emirate_slug. $subcategories['sub_category_slug'] . '/' . $view_list . $order_option; ?>" itemprop="url" style="color: <?php echo $cat['color']; ?>">
                                    <?php echo str_replace('\n', " ", $subcategories['sub_category_name']); ?>
                                </a>
                            </li>
                            <?php
                            } ?> 
                        </ul>
                    <?php } ?>
                </li>                
            <?php endforeach; ?>
        </ul>
    </div>    
    <a id="btn-show" href="javascript:void(0);" data-id="Show More" itemprop="url"><span class="fa fa-caret-square-o-down" id="icon" ></span><span id="label">Show More</span></a>
    <a class="featured_link" href="<?php echo base_url().emirate_slug.'featured_ads'.$view_list; ?>" itemprop="url">
        <div class="add_post">Featured Ads</div>
    </a>
    <a class="featured_link" href="<?php echo base_url().emirate_slug.'latest'.$view_list; ?>" itemprop="url">
        <div class="latest_post">Latest Ads</div>
    </a>
    <h4>Filter</h4>
    <!-- selectpicker -->
    <form class="filter" method="get" action="<?php echo base_url().emirate_slug; ?>search">      		
        <div class="form-group">
            <?php 
                $selected_state_id = $this->dbcommon->state_id(state_id_selection);
                if ($this->session->userdata('request_for_statewise') != '') { ?>
                <input type="hidden" name="sel_city" id="sel_city" value="<?php echo $selected_state_id; ?>">
                <input type="hidden" name="city" id="city1" value="<?php echo $selected_state_id; ?>">
                <?php
            } else {
                if (isset($_REQUEST['city'])) {
                    ?><input type="hidden" name="sel_city" id="sel_city" value="<?php echo $_REQUEST['city']; ?>"><?php } else { ?>
                    <input type="hidden" name="sel_city" id="sel_city" value="0">
                    <?php
                }
            }
            ?>
        <?php if ($this->session->userdata('request_for_statewise') == '') { ?>
            <label>CITIES</label> 
            <select class="form-control" name="city" id="city1"></select>
        <?php } ?>
        </div>
        <div class="form-group ">
            <label>Categories</label>
            <select class="form-control" name="cat" onchange="show_sub_cat__(this.value);">
                <option value="0">Property for Sale</option>
                <?php
                foreach ($category as $cat):
                        if ($cat['category_id'] == @$_REQUEST['cat']) {
                            ?>
                            <option value="<?php echo $cat['category_id']; ?>" <?php echo set_select('cat', @$_REQUEST['cat'], TRUE) ?> ><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                            <?php
                        }
                    
                endforeach;
                ?>
            </select>
            <?php if(isset($_REQUEST['view']) && in_array($_REQUEST['view'],array('grid','list','map'))) { ?>
                <input type="hidden" name="view" id="view" value="<?php echo $_REQUEST['view']; ?>">
            <?php } ?>
            <select class="form-control" id="sub_cat_" name="sub_cat">
                <option value="0">Sub Categories</option>
                <?php
                if (@$sub_category) {
                    foreach (@$sub_category as $sub): ?>
                        <?php if ($sub['sub_category_id'] == (int)@$_REQUEST['sub_cat']) { ?>
                            <option value="<?php echo $sub['sub_category_id']; ?>" selected="selected" ><?php echo str_replace('\n', " ", $sub['sub_category_name']); ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $sub['sub_category_id']; ?>" ><?php echo str_replace('\n', " ", $sub['sub_category_name']); ?></option>
                        <?php
                        }endforeach;
                }
                ?>
            </select>            
        </div>
        <div class="form-group">
            <label>Price</label>
            <div class="PriceRange">
                <input type="text" class="form-control range"  placeholder="Min" name="min_amount" id="min_amount" value="<?php echo set_value('min_amount', @$_REQUEST['min_amount']); ?>" onkeypress="return isNumber(event)"/> 
                <label class="LabelTo"> To </label> 
                <input type="text" placeholder="Max" class="form-control range" name="max_amount" id="max_amount" value="<?php echo set_value('max_amount', @$_REQUEST['max_amount']); ?>" onkeypress="return isNumber(event)"/>
            </div>
        </div>
        <button class="btn btn-block mybtn" value="search" id="search" name="search" type="submit">Search</button>
        <!-- <a class="btn btn-block mybtn">Search</a> -->
    </form>
</div>
