<div class="row subcat-div">
    <div class="col-sm-12 user-menu-bread">
        <ol class="breadcrumb no-margin">
            <li><a href="<?php echo site_url() . 'home'; ?>">Home</a></li>
            <li><a href="<?php echo site_url() . 'user/index'; ?>">Dashboard</a></li>
            <li class="active">
                <?php
                if ($this->uri->segment(2) == 'index')
                    echo "My Profile";
                elseif ($this->uri->segment(2) == 'store')
                    echo "My Store";
                elseif ($this->uri->segment(2) == 'my_listing')
                    echo "My Ads";
                elseif ($this->uri->segment(2) == 'favorite')
                    echo "My Favorites";
                elseif ($this->uri->segment(2) == 'like')
                    echo "My Likes";
                elseif ($this->uri->segment(2) == 'deactivateads')
                    echo "Deactivated Ads";
                elseif ($this->uri->segment(2) == 'orders')
                    echo "My Orders";
                elseif ($this->uri->segment(2) == 'inbox_products')
                    echo "My Inbox";
                elseif ($this->uri->segment(2) == 'followers')
                    echo "My Followers";
                elseif ($this->uri->segment(2) == 'following')
                    echo "Following";
                ?>
            </li>
        </ol>
        <?php if (!empty(session_storedomain)) { ?>
            <div class="visit_my_store">
                <a href="<?php echo HTTP . session_storedomain . after_subdomain . remove_home; ?>">Visit My Store</a>
            </div>
        <?php } ?>
    </div>                              
</div>
<!--//row-->
<div class="row">
    <div class="col-sm-12 profile-tabs">		
        <ul class="nav nav-tabs">
            <li role="presentation" <?php if ($this->uri->segment(2) == 'index') echo "class='active'"; ?>><a <?php
                if ($this->uri->segment(2) == 'index')
                    echo "href='#'";
                else
                    echo "href='" . site_url() . "user/index'";
                ?> 
                    >My Profile</a></li>
                <?php
                $current_user = $this->session->userdata('gen_user');
                if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') {
                    ?>
                <li role="presentation" <?php if ($this->uri->segment(2) == 'store') echo "class='active'"; ?>><a <?php
                    if ($this->uri->segment(2) == 'store')
                        echo "href='#'";
                    else
                        echo "href='" . site_url() . "user/store'";
                    ?> 
                        >My Store</a></li>			  								 
                <?php } ?>
            <li role="presentation"  <?php if (in_array($this->uri->segment(2), array('my_listing', 'deactivateads'))) echo "class='active'"; ?>>
                <a id="mylink"  onmouseover="javascript:show_listmenu();">My Ads</a>				                 <ul aria-labelledby="dropdownMenu1" class="dropdown-menu" role="menu" id="product_is_inappropriate" name="product_is_inappropriate" style="display:none;z-index: 1111111;">
                    <?php
                    $path = site_url() . 'user/my_listing';
                    $app_req = '';
                    $need_req = '';
                    $un_req = '';

                    $app_req = '?val=Approve';
                    $need_req = '?val=NeedReview';
                    $un_req = '?val=Unapprove';

                    if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                        $app_req = '?val=Approve&view=list';
                    if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                        $app_req = '?val=Approve&view=map';
                    if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                        $need_req = '?val=NeedReview&view=list';
                    if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                        $need_req = '?val=NeedReview&view=map';
                    if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                        $un_req = '?val=Unapprove&view=list';
                    if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                        $un_req = '?val=Unapprove&view=map';


                    $deact_path = site_url() . 'user/deactivateads';
                    $deact_un_req = '';
                    if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')
                        $deact_un_req = '?view=list';
                    if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'map')
                        $deact_un_req = '?view=map';
                    ?>
                    <li role="presentation" style="background-color:#ed1b33;"><a href="<?php echo $path . $app_req; ?>" role="menuitem"  id="approve">Active</a></li>
                    <li role="presentation" style="background-color:#ed1b33;"><a href="<?php echo $path . $need_req; ?>" role="menuitem"  id="needreview">Waiting for Approval</a></li>
                    <li role="presentation" style="background-color:#ed1b33;"><a href="<?php echo $path . $un_req; ?>" role="menuitem"  id="unapprove">Unapprove</a></li>
                    <li role="presentation" style="background-color:#ed1b33;"><a href="<?php echo $deact_path . $deact_un_req; ?>">Deactivated</a></li>
                </ul>
            </li>

            <li role="presentation">
                <a <?php echo "href='" . site_url() . "user/post_ads'"; ?>><i class="fa fa-plus"></i>Post Free Ad</a></li>
            <?php
            $u_i = 0;
            if (isset($current_user['user_role']) && $current_user['user_role'] == 'storeUser') {
                if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
                    $u_i = 1;
            }

            if ($u_i == 1) {
                ?>
                <li role="presentation"  <?php if (in_array($this->uri->segment(2), array('orders', 'order_list'))) echo "class='active'"; ?>>
                    <a id="mylink"  onmouseover="javascript:show_order();">My Orders</a>
                    <ul aria-labelledby="dropdownMenu1" class="dropdown-menu" role="menu" id="order_list" name="order_list" style="display:none;">
                        <?php if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') { ?>
                            <li role="presentation" style="background-color:#ed1b33;"><a href="<?php echo HTTPS . website_url . 'user/orders/sold'; ?>" role="menuitem" id="approve">Sold Products</a></li>
                        <?php } ?>
                        <li role="presentation" style="background-color:#ed1b33;"><a href="<?php echo HTTPS . website_url . 'user/orders/bought'; ?>" role="menuitem" id="needreview">Bought Products</a></li>
                    </ul>											
                </li>                
            <?php } else { ?>

                <li role="presentation" <?php if (in_array($this->uri->segment(2), array('orders', 'order_list'))) echo "class='active'"; ?>><a <?php echo "href='" . site_url() . "user/orders/bought'"; ?> >My Orders</a></li>

            <?php } ?>
            <li role="presentation" <?php if (in_array($this->uri->segment(2), array('favorite', 'like', 'followers', 'following'))) echo "class='active'"; ?>>
                <a id="morelink"  onmouseover="javascript:show_more_links();">More&nbsp;&nbsp;<i class="fa fa-caret-down"></i></a>
                <ul aria-labelledby="dropdownMenu1" class="dropdown-menu" role="menu" id="more_list" name="more_list" style="display:none;">                
                    <li role="presentation" style="background-color:#ed1b33;">
                        <a href='<?php echo site_url() . "user/like"; ?><?php echo (isset($_REQUEST['view'])) ? '?view=' . $_REQUEST['view'] : ''; ?>' role="menuitem">My Likes</a>
                    </li>
                    <li role="presentation" style="background-color:#ed1b33;">
                        <a href='<?php echo site_url() . "user/favorite"; ?><?php echo (isset($_REQUEST['view'])) ? '?view=' . $_REQUEST['view'] : ''; ?>' role="menuitem">My Favorites</a> 
                    </li>
                    <li role="presentation" style="background-color:#ed1b33;">
                        <a href='<?php echo site_url() . "user/followers"; ?>' role="menuitem">My Followers</a>
                    </li>
                    <li role="presentation" style="background-color:#ed1b33;">
                        <a href='<?php echo site_url() . "user/following"; ?>' role="menuitem">Following</a>
                    </li>
                </ul>
            </li>
        </ul>
        <br>
        <a href="<?php echo site_url() . 'user/inbox_products'; ?>" class="indox-link"><span class="fa fa-envelope"></span>
            Inbox <?php echo '<span id="inbox_count">(' . inbox_count . ')</span>'; ?>			
        </a>
    </div>
</div>
<script>
    $("#product_is_inappropriate").hide();
    $("#order_list").hide();
    $("#more_list").hide();

    function show_order() {
        $("#order_list").show();
    }

    function show_more_links() {
        $("#more_list").show();
    }

    function show_listmenu() {
        $("#product_is_inappropriate").show();
    }

    $("#order_list").mouseleave(function () {
        $("#order_list").hide();        
    });    
    $("#more_list").mouseleave(function () {
        $("#more_list").hide();        
    });
    
    $("#mylink").mouseover(function () {
        $("#order_list").show();        
    });
    $("#morelink").mouseover(function () {
        $("#more_list").show();        
    });

    $("#product_is_inappropriate").mouseleave(function () {
        $("#product_is_inappropriate").hide();
    });

    $("div.profile-tabs").mouseleave(function () {
        $("#product_is_inappropriate").hide();
        $("#order_list").hide();
        $("#more_list").hide();
    });

    function show_me()
    {
        $("#product_is_inappropriate").addClass("hover");
        $("#product_is_inappropriate").hover(function () {
            $("#product_is_inappropriate").show();
        },
        function () {
            $("#product_is_inappropriate").hide();
        });
    }

</script>