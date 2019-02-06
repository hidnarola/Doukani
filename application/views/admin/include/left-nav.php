<style>
    a {text-decoration:none;}
</style>
<?php
$this->load->model('dbcommon', '', TRUE);

$controller = $this->router->fetch_class();
$action = $this->router->fetch_method();
$user = $this->session->userdata('user');

$sstore_id = '';
$user_type = '';
$ussert_ID = '';


if (isset($_REQUEST['userid']) && $_REQUEST['userid'] != '')
    $ussert_ID = $_REQUEST['userid'];
else {
    $ussert_ID = '';
}

if (isset($ussert_ID) && $ussert_ID != '') {

    $user_where = " where user_id='" . $ussert_ID . "'";
    $user_menu = $this->dbcommon->getrowdetails('user', $user_where);
    $user_type = $user_menu->user_role;
} else
    $user_type = '';


if ($user_type == 'storeUser') {

    $store_where = " where store_owner='" . $ussert_ID . "'";
    $sstore = $this->dbcommon->getrowdetails('store', $store_where);

    if (sizeof($sstore) > 0)
        $sstore_id = $sstore->store_id;
} else
    $sstore_id = 0;

if ($user_type == 'offerUser') {

    $company_where = " where user_id='" . $ussert_ID . "'";
    $company = $this->dbcommon->getrowdetails('offer_user_company', $company_where);

    if (sizeof($company) > 0)
        $company_id = $company->id;
} else
    $company_id = 0;
?>
<div id='main-nav-bg'></div>
<nav id='main-nav'>
    <div class='navigation'>

        <?php if ($user->user_role == 'admin' && $this->permission->has_permission('only_listing')) {
            ?>	
            <ul class='nav nav-stacked'>		 
                <!--Dashboard-->
                <?php if ($this->permission->has_permission('only_listing')) { ?>
                    <li class='<?php echo $controller == 'home' ? 'active' : '' ?>'>
                        <a href='<?php echo base_url(); ?>admin/home/'>
                            <i class='icon-dashboard'></i>
                            <span>Dashboard</span>
                        </a>
                    </li>                    
                    <li class='
                    <?php
                    if (in_array($action, array('categories', 'categories_add', 'categories_edit', 'subCategories', 'subCategories_add', 'subCategories_edit'))) {
                        echo 'active';
                    }
                    ?> '>
                        <a href='<?php echo base_url(); ?>admin/classifieds/categories'>
                            <i class='icon-list'></i>
                            <span>Categories</span>
                        </a>
                    </li>
                    <!--Classifieds-->                
                    <li class='<?php echo ($controller == 'classifieds' && $ussert_ID == '') ? 'active' : '' ?>'>
                        <a class="dropdown-collapse" href="#"><i class='icon-edit'></i>
                            <span>Only Listing</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>
                        <?php
                        $action_class1 = "";
                        $action_class2 = "";
                        $action_class3 = "";

                        if ($this->uri->segment(3) == 'listings')
                            $action_class1 = "active";

                        if ($this->uri->segment(3) == 'repost_ads')
                            $action_class2 = "active";

                        if ($this->uri->segment(3) == 'listings_spam')
                            $action_class3 = "active";

                        if ($this->uri->segment(3) == 'featured_ads')
                            $action_class4 = "active";
                        ?>
                        <ul class='<?php echo ($controller == 'classifieds' && $ussert_ID == '') ? 'in' : '' ?> nav nav-stacked'>
                            <li class='<?php echo ($this->uri->segment(3) != '' && $this->uri->segment(3) == 'listings_add') ? 'active' : ''; ?>'>
                                <a href='<?php echo base_url(); ?>admin/classifieds/listings_add/listings/classified'>
                                    <i class='icon-plus'></i>
                                    <span>Add Listing</span>
                                </a>
                            </li>
                            <li>                                           
                                <a href='#' class="dropdown-collapse">
                                    <i class='icon-edit'></i>
                                    <span>Classified Listing</span>
                                    <i class='icon-angle-down angle-down'></i>
                                </a>                                
                                <ul class="<?php echo (!empty($action_class1) || !empty($action_class2) || !empty($action_class3) || !empty($action_class4)) ? 'in' : '' ?> nav nav-stacked">
                                    <li class='<?php echo $action_class1; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/listings/classified'>
                                            <i class='icon-list'></i>
                                            <span>New Ads</span>
                                        </a>
                                    </li>
                                    <li class='<?php echo $action_class2; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/repost_ads/classified'>
                                            <i class='icon-list'></i>
                                            <span>Repost Ads</span>
                                        </a>
                                    </li>
                                    <li class='<?php echo $action_class3; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/listings_spam/classified'>
                                            <i class='icon-list'></i>
                                            <span>Spam Ads</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class='<?php if ($action == 'featured_ads') echo "active"; ?>'>
                                <a href='<?php echo base_url(); ?>admin/classifieds/featured_ads'>
                                    <i class="icon-th-list"></i>
                                    <span>Featured Ads</span>
                                </a>
                            </li>                            
                        </ul>
                    </li>                    
                    <li class="<?php echo $controller == 'offers' ? 'active' : '' ?>">
                        <a class='dropdown-collapse ' href='#'>
                            <i class='icon-tags'></i>
                            <span>Offer Ads Management</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>
                        <ul class="<?php echo $controller == 'offers' ? 'in' : '' ?> nav nav-stacked">
                            <li class='<?php if (in_array($action, array('add', 'edit', 'index', 'view')) && $this->uri->segment(4) != 'today') echo 'active'; ?>'>
                                <a href='<?php echo base_url(); ?>admin/offers/index' >
                                    <i class='icon-caret-right'></i>
                                    <span>Offers</span>
                                </a>
                            </li>
                            <li class='<?php echo ($this->uri->segment(4) == 'today') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/offers/index/today' >
                                    <i class='icon-caret-right'></i>
                                    <span>Today Offers</span>
                                </a>
                            </li>
                            <li class='<?php echo ($this->uri->segment(3) == 'featured_offers') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/offers/featured_offers' >
                                    <i class='icon-caret-right'></i>
                                    <span>Featured Offers</span>
                                </a>
                            </li>
                        </ul>
                    </li>                
                <?php } ?>
            </ul>
            <?php
        } else if ($user->user_role == 'admin' || $user->user_role == 'superadmin') {
            ?>
            <ul class='nav nav-stacked'>
                <!--Dashboard-->
                <?php if ($this->permission->has_permission('dashboard')) { ?>
                    <li class='<?php echo $controller == 'home' ? 'active' : '' ?>'>
                        <a href='<?php echo base_url(); ?>admin/home'>
                            <i class='icon-dashboard'></i>                           
                            <span>Dashboard</span>
                        </a>
                    </li>
                <?php } ?>

                <?php if ($this->permission->has_permission('categories')) { ?>
                    <li class='
                    <?php
                    if (in_array($action, array('categories', 'categories_add', 'categories_edit', 'subCategories', 'subCategories_add', 'subCategories_edit'))) {
                        echo 'active';
                    }
                    ?> '>
                        <a href='<?php echo base_url(); ?>admin/classifieds/categories'>
                            <i class='icon-list'></i>
                            <span>Categories</span>
                        </a>
                    </li>
                <?php } ?>
                <!--Classifieds-->
                <?php if ($this->permission->has_permission('classified')) { ?>
                    <li class='<?php echo ($controller == 'classifieds' && $ussert_ID == '' && !in_array($action, array('categories', 'categories_add', 'categories_edit', 'subCategories', 'subCategories_add', 'subCategories_edit'))) ? 'active' : '' ?>'>
                        <a class="dropdown-collapse" href="#"><i class='icon-list-ol'></i>
                            <span class="has-tooltip" data-placement="top" data-original-title="Classified Ads Management">Classified Ads Mgt</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>
                        <?php
                        $action_class1 = "";
                        $action_class2 = "";
                        $action_class3 = "";
                        $action_class4 = "";

                        if (in_array('listings', array($this->uri->segment(3), $this->uri->segment(4)))) {
                            if (in_array('classified', array($this->uri->segment(4), $this->uri->segment(5))))
                                $action_class1 = "active";
                            else
                                $action_class1 = "";
                        }

                        if (in_array('repost_ads', array($this->uri->segment(3), $this->uri->segment(4)))) {
                            if (in_array('classified', array($this->uri->segment(4), $this->uri->segment(5))))
                                $action_class2 = "active";
                            else
                                $action_class2 = "";
                        }

                        if (in_array('listings_spam', array($this->uri->segment(3), $this->uri->segment(4)))) {
                            if (in_array('classified', array($this->uri->segment(4), $this->uri->segment(5))))
                                $action_class3 = "active";
                            else
                                $action_class3 = "";
                        }
                        ?>
                        <ul class='
                            <?php echo ($controller == 'classifieds' && in_array($action, array('listings_add', 'listings', 'repost_ads', 'listings_spam', 'listings_edit', 'listings_view', 'featured_ads')) && $ussert_ID == '' && isset($redirect_admin_to) && $redirect_admin_to == 'classified') ? 'in' : '' ?>  nav nav-stacked'>
                            <li class='<?php echo ($this->uri->segment(3) != '' && $this->uri->segment(3) == 'listings_add') ? 'active' : ''; ?>'>
                                <a href='<?php echo base_url(); ?>admin/classifieds/listings_add/listings/classified'>
                                    <i class='icon-plus'></i>
                                    <span>Add Listing</span>
                                </a>
                            </li>
                            <li>                                           
                                <a href='#' class="dropdown-collapse">
                                    <i class='icon-list'></i>
                                    <span>Listing</span>
                                    <i class='icon-angle-down angle-down'></i>
                                </a>                                
                                <ul class="<?php echo (!empty($action_class1) || !empty($action_class2) || !empty($action_class3)) ? 'in' : '' ?> nav nav-stacked">

                                    <li class='<?php echo $action_class1; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/listings/classified'>
                                            <i class='icon-list-alt'></i>
                                            <span>New Ads</span>
                                        </a>
                                    </li>
                                    <li class='<?php echo $action_class2; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/repost_ads/classified'>
                                            <i class='icon-list-alt'></i>
                                            <span>Repost Ads</span>
                                        </a>
                                    </li>
                                    <li class='<?php echo $action_class3; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/listings_spam/classified'>
                                            <i class='icon-list-alt'></i>
                                            <span>Spam Ads</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>                            
                            <li class='<?php if ($action == 'featured_ads') echo "active"; ?>'>
                                <a href='<?php echo base_url(); ?>admin/classifieds/featured_ads'>
                                    <i class='icon-list'></i>
                                    <span>Featured Ads</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <!--Store-->
                <?php if ($this->permission->has_permission('store_mgt')) { ?>
                    <li class='<?php echo ($controller == 'classifieds' && $ussert_ID == '' && !in_array($action, array('categories', 'categories_add', 'categories_edit', 'subCategories', 'subCategories_add', 'subCategories_edit'))) ? 'active' : '' ?>'>
                        <a class="dropdown-collapse" href="#"><i class='icon-list-ol'></i>
                            <span class="has-tooltip" data-placement="top" data-original-title="Store Ads Management">Store Ads Mgt</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>
                        <?php
                        $action_class1 = "";
                        $action_class2 = "";
                        $action_class3 = "";

                        if (in_array('listings', array($this->uri->segment(3), $this->uri->segment(4)))) {
                            if (in_array('store', array($this->uri->segment(4), $this->uri->segment(5))))
                                $action_class1 = "active";
                            else
                                $action_class1 = "";
                        }

                        if (in_array('repost_ads', array($this->uri->segment(3), $this->uri->segment(4)))) {
                            if (in_array('store', array($this->uri->segment(4), $this->uri->segment(5))))
                                $action_class2 = "active";
                            else
                                $action_class2 = "";
                        }

                        if (in_array('listings_spam', array($this->uri->segment(3), $this->uri->segment(4)))) {
                            if (in_array('store', array($this->uri->segment(4), $this->uri->segment(5))))
                                $action_class3 = "active";
                            else
                                $action_class3 = "";
                        }
                        ?>

                        <ul class='
                        <?php echo ($controller == 'classifieds' && in_array($action, array('listings', 'repost_ads', 'listings_spam', 'listings_edit', 'listings_view')) && $ussert_ID == '' && isset($redirect_admin_to) && $redirect_admin_to == 'store') ? 'in' : '' ?> 
                            nav nav-stacked'>                                   
                            <li>
                                <a href='#' class="dropdown-collapse">
                                    <i class='icon-list'></i>
                                    <span>Listing</span>
                                    <i class='icon-angle-down angle-down'></i>
                                </a>                                
                                <ul class="<?php echo (!empty($action_class1) || !empty($action_class2) || !empty($action_class3)) ? 'in' : '' ?> nav nav-stacked">

                                    <li class='<?php echo $action_class1; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/listings/store'>
                                            <i class='icon-list-alt'></i>
                                            <span>New Ads</span>
                                        </a>
                                    </li>
                                    <li class='<?php echo $action_class2; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/repost_ads/store'>
                                            <i class='icon-list-alt'></i>
                                            <span>Repost Ads</span>
                                        </a>
                                    </li>
                                    <li class='<?php echo $action_class3; ?>'>
                                        <a href='<?php echo base_url(); ?>admin/classifieds/listings_spam/store'>
                                            <i class='icon-list-alt'></i>
                                            <span>Spam Ads</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <!--Offers--> 
                <?php if ($this->permission->has_permission('offer_mgt')) { ?>
                    <li class="<?php echo ($controller == 'offers' && $ussert_ID == '') ? 'active' : '' ?>">
                        <a class='dropdown-collapse ' href='#'>
                            <i class='icon-tags'></i>
                            <span>Offer Ads Management</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>
                        <ul class="<?php echo ($controller == 'offers' && $ussert_ID == '') ? 'in' : '' ?> nav nav-stacked">
                            <li class='<?php if (in_array($action, array('add', 'edit', 'index', 'view')) && $this->uri->segment(4) != 'today') echo 'active'; ?>'>
                                <a href='<?php echo base_url(); ?>admin/offers/index' >
                                    <i class='icon-caret-right'></i>
                                    <span>Offers</span>
                                </a>
                            </li>
                            <li class='<?php echo ($this->uri->segment(4) == 'today') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/offers/index/today' >
                                    <i class='icon-caret-right'></i>
                                    <span>Today Offers</span>
                                </a>
                            </li>
                            <li class='<?php echo ($this->uri->segment(3) == 'featured_offers') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/offers/featured_offers' >
                                    <i class='icon-caret-right'></i>
                                    <span>Featured Offers</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <li class="<?php echo $controller == 'reported_items' ? 'active' : '' ?>">
                    <a href='<?php echo base_url(); ?>admin/reported_items/index'>
                        <i class='icon-flag'></i>
                        <span>Reported Items</span>
                    </a>                        
                </li>   
                <!--Users-->
                <?php if ($this->permission->has_permission('user_mgt')) {
                    ?>
                    <li class='<?php echo ($controller == 'users' || ($controller == 'classifieds' && isset($ussert_ID) && $ussert_ID != '' && $action == 'listings_add' ) || ($controller == 'stores' && $action == 'edit')) ? 'active' : '' ?>'>
                        <a class='dropdown-collapse' href='/'>                            
                            <i class='icon-group'></i>
                            <span>Users Management</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>
                        <ul class='<?php
                        echo ($controller == 'users' ||
                        ($controller == 'classifieds' && isset($ussert_ID) && $ussert_ID != '' && (in_array($action, array('listings_add', 'listings', 'repost_ads')))) ||
                        ($controller == 'offers' && isset($ussert_ID) && $ussert_ID != '' && $action == 'index' ) ||
                        ($controller == 'stores' && $action == 'edit')) ? 'in' : ''
                        ?> nav nav-stacked'> 

                            <?php $title = $this->uri->segment(4); ?>
                            <li class='<?php
                            if ((isset($title) && $title == "generalUser") || $user_type == 'generalUser') {
                                echo "active";
                            }
                            ?>'>
                                    <?php if (isset($ussert_ID) && $ussert_ID != '' && $user_type == 'generalUser') { ?>
                                    <a href='<?php echo base_url(); ?>admin/users/index/generalUser' class='dropdown-collapse'>
                                        <i class='icon-user'></i>
                                        <span>Classified Users</span>
                                    </a>                                 
                                    <ol>  
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/classifieds/listings_add/listings/classified/?userid=<?php echo $ussert_ID; ?>'>
                                                <span>Add Listing</span>
                                            </a>
                                        </li>
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/classifieds/listings/classified/?userid=<?php echo $ussert_ID; ?>'>
                                                <span>Classified Ads</span>
                                            </a>
                                        </li>
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/classifieds/repost_ads/classified/?userid=<?php echo $ussert_ID; ?>'>
                                                <span>Classified Repost Ads</span>
                                            </a>
                                        </li>
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/users/view/<?php echo $ussert_ID; ?>' target="_blank">
                                                <span>View User Details</span>
                                            </a>
                                        </li>
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/users/edit/<?php echo $ussert_ID; ?>' target="_blank">
                                                <span>Edit User Details</span>
                                            </a>
                                        </li>
                                    </ol>
                                    <a href='<?php echo base_url(); ?>admin/users/index/generalUser'>
                                        <i class='icon-user'></i>
                                        <span>Reset Classified Users</span>
                                    </a>
                                <?php } else { ?>
                                    <a href='<?php echo base_url(); ?>admin/users/index/generalUser'>
                                        <i class='icon-user'></i>
                                        <span>Classified Users</span>
                                    </a>
                                <?php } ?>

                            </li>                            
                            <li class='<?php
                            if ((isset($title) && $title == "storeUser") || $user_type == 'storeUser' || ($controller == 'stores' && $action == 'edit')) {
                                echo "active";
                            }
                            ?>'>
                                    <?php if ($user_type == 'storeUser' && (isset($ussert_ID) && $ussert_ID != '') || $sstore_id > 0) { ?>
                                    <a href='<?php echo base_url(); ?>admin/users/index/storeUser' class='dropdown-collapse'>
                                        <i class='icon-building'></i>
                                        <span>Virtual Store Users</span>
                                        <i class='icon-angle-down angle-down'></i>
                                    </a> 
                                    <ol>
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/classifieds/listings_add/listings/store/?userid=<?php echo $ussert_ID; ?>'>
                                                <span>Add Listing</span>
                                            </a>
                                        </li>
                                        <?php
                                        $store_mgt = $this->permission->has_permission('store_mgt');
                                        if ($store_mgt == 1) {
                                            ?>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/classifieds/listings/store/?userid=<?php echo $ussert_ID; ?>'>
                                                    <span>New Store Ads</span>
                                                </a>
                                            </li>                                        
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/classifieds/repost_ads/store/?userid=<?php echo $ussert_ID; ?>'>
                                                    <span>Store Repost Ads</span>
                                                </a>
                                            </li>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/users/e_wallet/?userid=<?php echo $ussert_ID; ?>'>
                                                    <span>E-wallet</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        $classified = $this->permission->has_permission('classified');
                                        if ($classified == 1) {
                                            ?>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/classifieds/listings/classified/?userid=<?php echo $ussert_ID; ?>'>
                                                    <span>New Classified Ads</span>
                                                </a>
                                            </li>                                        
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/classifieds/repost_ads/classified/?userid=<?php echo $ussert_ID; ?>'>
                                                    <span>Classified Repost Ads</span>
                                                </a>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <?php if ($sstore_id > 0) { ?>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/users/view_store/<?php echo $sstore_id; ?>/?userid=<?php echo $ussert_ID; ?>' target="_blank">
                                                    <span>View Store</span>
                                                </a>
                                            </li>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/users/edit_store/<?php echo $sstore_id; ?>/?userid=<?php echo $ussert_ID; ?>' target="_blank">
                                                    <span>Edit Store</span>
                                                </a>
                                            </li>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/users/view/<?php echo $ussert_ID; ?>' target="_blank">
                                                    <span>View User Details</span>
                                                </a>
                                            </li>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/users/edit/<?php echo $ussert_ID; ?>' target="_blank">
                                                    <span>Edit User Details</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ol>
                                    <a href='<?php echo base_url(); ?>admin/users/index/storeUser'>                  
                                        <i class='icon-building'></i>
                                        <span>Reset Store Users</span>
                                    </a>
                                <?php } else { ?>
                                    <a href='<?php echo base_url(); ?>admin/users/index/storeUser'>
                                        <i class='icon-building'></i>
                                        <span>Virtual Store Users</span>                                        
                                    </a>
                                <?php } ?>
                            </li>
                            <li class='<?php
                            if ((isset($title) && $title == "offerUser") || $user_type == 'offerUser') {
                                echo "active";
                            }
                            ?>'>
                                    <?php if (isset($ussert_ID) && $ussert_ID != '' && $user_type == 'offerUser') { ?>
                                    <a href='<?php echo base_url(); ?>admin/users/index/offerUser' class='dropdown-collapse'>
                                        <i class='icon-tags'></i>
                                        <span>Offer Users</span>
                                    </a>                                 
                                    <ol>
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/offers/index/?userid=<?php echo $ussert_ID; ?>'>
                                                <span>Offers Ads</span>
                                            </a>
                                        </li>
                                        <?php if ($company_id > 0) { ?>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/users/view_offers_company/<?php echo $company_id; ?>' target="_blank">
                                                    <span>View Company Details</span>
                                                </a>
                                            </li>
                                            <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                                <a href='<?php echo base_url(); ?>admin/users/view_offers_company/<?php echo $company_id; ?>' target="_blank">
                                                    <span>Edit Company Details</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/users/view/<?php echo $ussert_ID; ?>' target="_blank">
                                                <span>View User Details</span>
                                            </a>
                                        </li>
                                        <li class='<?php if (isset($ussert_ID)) echo "active"; ?>'>
                                            <a href='<?php echo base_url(); ?>admin/users/edit/<?php echo $ussert_ID; ?>' target="_blank">
                                                <span>Edit User Details</span>
                                            </a>
                                        </li>
                                    </ol>
                                    <a href='<?php echo base_url(); ?>admin/users/index/offerUser'>
                                        <i class='icon-tags'></i>
                                        <span>Reset Offer Users</span>
                                    </a>
                                <?php } else { ?>
                                    <a href='<?php echo base_url(); ?>admin/users/index/offerUser'>
                                        <i class='icon-tags'></i>
                                        <span>Offer Users</span>
                                    </a>
                                <?php } ?>                                
                            </li>
                            <li <?php if ($controller == 'users' && $action == 'featured_stores') echo 'class="active"'; ?> >
                                <a href='<?php echo base_url(); ?>admin/users/featured_stores'>
                                    <i class='icon-building'></i>
                                    <span>Featured Store Users</span>                                        
                                </a>
                            </li>
                            <li <?php if ($controller == 'users' && $action == 'featured_companies') echo 'class="active"'; ?> >
                                <a href='<?php echo base_url(); ?>admin/users/featured_companies'>
                                    <i class='icon-tags'></i>
                                    <span>Featured Offer Users</span>                                        
                                </a>
                            </li>
                            <li <?php if ($controller == 'users' && $action == 'winipad_users') echo 'class="active"'; ?> >
                                <a href='<?php echo base_url(); ?>admin/users/winipad_users'>
                                    <i class='icon-gamepad'></i>
                                    <span>WinIpad Users</span>                                        
                                </a>
                            </li>
                            <li <?php if ($controller == 'users' && in_array($action, array('store_request_list', 'edit_store_request'))) echo 'class="active"'; ?> >
                                <a href='<?php echo base_url(); ?>admin/users/store_request_list'>
                                    <i class='icon-building'></i>
                                    <span>Store Request</span>                                        
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <!--System management-->
                <?php if ($this->permission->has_permission('system_mgt')) { ?>
                    <li class='<?php echo $controller == 'systems' ? 'active' : '' ?>'>
                        <a class='dropdown-collapse' href='/'>
                            <i class=' icon-wrench'></i>
                            <span>System Management</span>

                            <i class='icon-angle-down angle-down'></i>
                        </a>
                        <ul class='<?php
                        if (in_array(strtolower($controller), array("custom_banner", 'systems', 'doukani_logo', ''))) {
                            echo 'in';
                        }
                        ?> nav nav-stacked'>
                            <li class='<?php
                            if ($controller == 'doukani_logo' && in_array($action, array('index', 'edit'))) {
                                echo 'active';
                            }
                            ?>'>
                                <a href='<?php echo base_url(); ?>admin/doukani_logo/index'>
                                    <i class="icon-picture"></i>
                                    <span>Doukani Logos</span>
                                </a>
                            </li>
                            <li class='<?php
                            if (in_array($action, array('accounts', 'accounts_add', 'accounts_edit'))) {
                                echo 'active';
                            }
                            ?>'>
                                <a href='<?php echo base_url(); ?>admin/systems/accounts'>
                                    <i class='icon-key'></i>
                                    <span>Manage Admin Accounts</span>
                                </a>
                            </li>
                            <li class='<?php
                            if (in_array($action, array('location', 'location_edit', 'emirates', 'emirates_edit', 'nationality', 'nationality_edit'))) {
                                echo 'active';
                            }
                            ?>'>
                                <a href='<?php echo base_url(); ?>admin/systems/location'>
                                    <i class='icon-flag'></i>
                                    <span>Manage Locations</span>
                                </a>
                            </li>		    
                            <li class=''>
                                <a class='dropdown-collapse ' href='#'>
                                    <i class='icon-picture'></i>
                                    <span>Banners Management</span>
                                    <i class='icon-angle-down angle-down'></i>
                                </a>
                                <ul class='<?php
                                if ($controller == "custom_banner") {
                                    echo 'in';
                                }
                                ?> nav nav-stacked'> 
                                    <li class='<?php
                                    if (in_array($action, array('CustomBanner', 'addcustom', 'editcustom'))) {
                                        echo 'in';
                                    }
                                    ?>' >
                                            <?php
                                            if ($this->uri->segment(5) != '')
                                                $banner_for1 = $this->uri->segment(5);
                                            else
                                                $banner_for1 = '';
                                            ?>
                                        <a href="#" class='dropdown-collapse'>	
                                            <i class='icon-caret-right'></i>
                                            <span>Custom Banner</span>
                                        </a>
                                        <ul class='nav nav-stacked <?php if ((in_array($action, array('CustomBanner', 'addcustom', 'editcustom'))) && $banner_for1 != '' && (in_array($banner_for1, array('web', 'mobile')))) echo 'in'; ?> '>

                                            <li class="<?php if ((in_array($action, array('CustomBanner', 'addcustom', 'editcustom'))) && $banner_for1 != '' && $banner_for1 == 'web') echo 'active'; ?>">
                                                <a href='<?php echo base_url() . "admin/custom_banner/CustomBanner/11/web"; ?>'>
                                                    <i class='icon-desktop'></i>
                                                    <span>Web</span>
                                                </a>
                                            </li>
                                            <li class="<?php if ((in_array($action, array('CustomBanner', 'addcustom', 'editcustom'))) && $banner_for1 != '' && $banner_for1 == 'mobile') echo 'active'; ?>">
                                                <a href='<?php echo base_url() . "admin/custom_banner/CustomBanner/11/mobile"; ?>'>
                                                    <i class=' icon-mobile-phone'></i>
                                                    <span>Mobile</span>
                                                </a>
                                            </li>                    
                                        </ul>
                                    </li>
                                    <li class='<?php
                                    if (in_array($action, array('vipBanner', 'addvip', 'editvip'))) {
                                        echo 'in';
                                    }
                                    ?>'>
                                        <a href="#" class='dropdown-collapse'>
                                            <i class='icon-caret-right'></i>
                                            <span>VIP Banner</span>
                                        </a>
                                        <ul class='nav nav-stacked <?php if (($action == 'vipBanner' || $action == 'addvip' || $action == 'editvip') && $banner_for1 != '' && ($banner_for1 == 'web' || $banner_for1 == 'mobile' )) echo 'in'; ?> '>

                                            <li class="<?php if ((in_array($action, array('vipBanner', 'addvip', 'editvip'))) && $banner_for1 != '' && $banner_for1 == 'web') echo 'active'; ?>">
                                                <a href='<?php echo base_url() . "admin/custom_banner/vipBanner/10/web"; ?>'>
                                                    <i class='icon-desktop'></i>
                                                    <span>Web</span>
                                                </a>
                                            </li>

                                            <li class="<?php if ((in_array($action, array('vipBanner', 'addvip', 'editvip'))) && $banner_for1 != '' && $banner_for1 == 'mobile') echo 'active'; ?>">
                                                <a href='<?php echo base_url() . "admin/custom_banner/vipBanner/10/mobile"; ?>'>
                                                    <i class=' icon-mobile-phone'></i>
                                                    <span>Mobile</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class='<?php
                            if ($action == 'settings') {
                                echo 'active';
                            }
                            ?>'>
                                <a href='<?php echo base_url(); ?>admin/systems/settings'>
                                    <i class='icon-cogs'></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                            
                            <li class='<?php
                            if ($action == 'shipping_cost') {
                                echo 'active';
                            }
                            ?>'>
                                <a href='<?php echo base_url(); ?>admin/systems/shipping_cost'>
                                    <i class='fa fa-ambulance'></i>
                                    <span>Shipping Cost</span>
                                </a>
                            </li>
                           
                            <li class='<?php
                            if ($action == 'featuredad_price') {
                                echo 'active';
                            }
                            ?>'>
                                <a href='<?php echo base_url(); ?>admin/systems/featuredad_price'>
                                    <i class="icon-money"></i>
                                    <span>Featured Ad Price</span>
                                </a>
                            </li>
                            <li class='<?php
                            if ($action == 'buyad_price') {
                                echo 'active';
                            }
                            ?>'>
                                <a href='<?php echo base_url(); ?>admin/systems/buyad_price'>
                                    <i class="icon-money"></i>
                                    <span>Buy Ads Price</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <!--Pages management-->
                <?php if ($this->permission->has_permission('page_mgt')) { ?>
                    <li class='<?php
                    if ($controller == 'pages' || $controller == 'faq')
                        echo 'active';
                    else
                        echo '';
                    ?>'>		
                        <a class='dropdown-collapse' href='<?php echo base_url(); ?>admin/pages'>
                            <i class='icon-book'></i>
                            <span>Pages Management</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>		
                        <ul class='nav nav-stacked <?php
                        if ($controller == 'pages' || $controller == 'faq')
                            echo 'in';
                        else
                            echo '';
                        ?>'>
                            <li class='<?php echo ($controller == 'pages' && $action == 'index' || $action == "edit") ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/pages/index'>
                                    <i class='icon-building'></i>
                                    <span>Pages</span>
                                </a>
                            </li>		    		    
                            <li class='<?php echo ($controller == 'pages' && $action == 'add') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/pages/add'>
                                    <i class='icon-plus'></i>
                                    <span>Add Pages</span>
                                </a>
                            </li>
                            <li class='<?php echo ($controller == 'pages' && $action == 'manage') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/pages/manage'>
                                    <i class='icon-wrench'></i>
                                    <span>Manage Pages</span>
                                </a>
                            </li>		    		    
                            <li class='<?php echo ($controller == 'faq' && ($action == 'index' || $action == 'add' || $action == 'edit' || $action == 'delete' )) ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/faq/index'>
                                    <i class='icon-question-sign'></i>
                                    <span>Manage FAQ</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>
                <!--Store-->
                <?php if ($this->permission->has_permission('store_mgt')) { ?>
                                                                           <!-- <li class='<?php echo $controller == 'stores' ? 'active' : '' ?>'>		
                                                                                <a class='dropdown-collapse' href='<?php echo base_url(); ?>admin/stores'>
                                                                                    <i class='icon-building'></i>
                                                                                    <span>Store management </span>
                                                                                    <i class='icon-angle-down angle-down'></i>
                                                                                </a>
                                                                                <ul class=' <?php echo $controller == 'stores' ? 'in' : '' ?> nav nav-stacked'>
                                                                                    <li class='<?php if ($action == 'add' || $action == 'edit' || $action == 'index') echo 'active'; ?>'>
                                                                                        <a href='<?php echo base_url(); ?>admin/stores'>
                                                                                            <i class='icon-list'></i>
                                                                                            <span>Store </span>
                                                                                        </a>
                                                                                    </li>
                    <?php if ($controller == 'stores' && $action == 'product' || $action == 'product_add' || $action == 'product_edit') { ?>
                                                                                                                                                <li class='<?php
                        if ($controller == 'stores' && $action == 'product' || $action == 'product_add' || $action == 'product_edit') {
                            echo 'active';
                        }
                        ?>'>
                                                                                                                                                    <a href=''>
                                                                                                                                                        <i class='icon-list'></i>
                                                                                                                                                        <span><?php if (isset($store_name)) echo ucfirst(str_replace("store", '', $store_name)); ?> Store Products</span>
                                                                                                                                                    </a>
                                                                                                                                                </li>	
                    <?php } ?>
                                                                                </ul>
                                                                            </li> -->
                <?php } ?>
                <!--Push notifications-->
                <?php if ($this->permission->has_permission('push_notification')) { ?>
                    <li class='<?php echo $controller == 'push_notification' ? 'active' : '' ?>'>
                        <a class='dropdown-collapse' href='/'>
                            <i class='icon-bell'></i>
                            <span>Push Notifications</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>	    
                        <ul class='nav nav-stacked <?php echo $controller == 'push_notification' ? 'in' : '' ?>'>
                            <li class='<?php echo $action == 'ios' ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/push_notification/ios'>
                                    <i class='icon-apple'></i>
                                    <span>iOS</span>
                                </a>
                            </li>
                        </ul>
                        <ul class='nav nav-stacked <?php echo $controller == 'push_notification' ? 'in' : '' ?>'>
                            <li class='<?php echo $action == 'andorid' ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/push_notification/android'>
                                    <i class='icon-apple'></i>
                                    <span>Android</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>            
                <!-- Message Module -->
                <?php if ($this->permission->has_permission('message_mgt')) { ?>
                    <li class='<?php echo $controller == 'conversation' ? 'active' : '' ?>'>
                        <a href='<?php echo base_url(); ?>admin/conversation'>
                            <i class='icon-envelope-alt'></i>
                            <span>Buyer Seller Conversation</span>
                        </a>
                    </li>
                <?php } ?>
                <!--Order management-->
                <?php if ($this->permission->has_permission('order_mgt')) { ?>
                    <li class='<?php
                    if ($controller == 'orders')
                        echo 'active';
                    else
                        echo '';
                    ?>'>		
                        <a class='dropdown-collapse' href='<?php echo base_url(); ?>admin/orders'>
                            <i class='icon-book'></i>
                            <span>Order Management</span>
                            <i class='icon-angle-down angle-down'></i>
                        </a>		
                        <ul class='nav nav-stacked <?php
                        if ($controller == 'orders')
                            echo 'in';
                        else
                            echo '';
                        ?>'>
                            <li class='<?php echo ($controller == 'orders' && $action == 'index') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/orders'>
                                    <i class="icon-list-ol"></i>
                                    <span>Transactions</span>
                                </a>
                            </li>		    		    
                            <li class='<?php echo ($controller == 'orders' && $action == 'order_listing') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/orders/order_listing'>
                                    <i class="icon-list-alt"></i> 
                                    <span>Orders Listing</span>
                                </a>
                            </li>                            
                            <li class='<?php echo ($controller == 'orders' && $action == 'balance_listing') ? 'active' : '' ?>'>
                                <a href='<?php echo base_url(); ?>admin/orders/balance_list'>
                                    <i class="icon-th-list"></i>
                                    <span>Balance Listing</span>
                                </a>
                            </li>                            
                        </ul>
                    </li>
                <?php } ?>

            </ul>
            <!--Store User Menu-->
        <?php } ?>
    </div>
    <script>
        function goBack()
            {
                    window.history.back()
            }
    </script>
</nav>