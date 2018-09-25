<?php
if (isset($store_url) && $store_url != '') {
    $__store_page = 1;
    $mypath_ = $store_url . '/';
} else
    $mypath_ = base_url();
?>
<header id="header">
    <?php if ($this->session->flashdata('msg') != ''): ?>
        <div class='alert  alert-success'>
            <a class='close' data-dismiss='alert' href='#'> &times; </a>
            <center><?php echo $this->session->flashdata('msg'); ?></center>
        </div>
        <?php
    endif;

    $doukani_logo = '';

    if ($this->uri->segment(1) == 'home' && ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'index') && !isset($store_page)) {

        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=1')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];
    } elseif ($this->uri->segment(1) == 'allstores' || $this->uri->segment(1) == 'store_search' || (isset($store_page) && $store_page == 'store_page')) {

        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=2')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];
    } elseif ($this->uri->segment(1) == 'alloffers') {
        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=3')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];
    } else {
        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=1')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];
    }

    if (empty($doukani_logo))
        $doukani_logo = 'assets/front/images/DoukaniLogo.png';
    else
        $doukani_logo = doukani_logo . 'original/' . $doukani_logo;
    ?>
    <div class="main-head">
        <div class="logo">
            <a href="<?php echo HTTPS . website_url; ?>" style="text-decoration:none">
                <img src="<?php echo HTTPS . website_url . $doukani_logo; ?>" >         
            </a>
        </div>
        <div class="head-action">
            <?php
            if (!isset($store_page)) {
                if ($this->uri->segment(1) == 'allstores' || $this->uri->segment(1) == 'store_search') {
                    ?>
                    <div class="search-wrap">
                        <form  method="post" action="<?php echo HTTPS . website_url; ?>store_search">              
                            <div class="input-group">
                                <input type="text" class="form-control" aria-label="..." value="<?php if (isset($_POST['search_value'])) echo $_POST['search_value']; ?>" name="search_value" id="search_value" placeholder='Search Store'>
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </span>

                            </div>
                        </form>           
                    </div>
                    <?php
                } else {
                    
                }
            } else {
                ?>
                <div class="search-wrap">
                    <form  method="post" action="<?php echo $store_url; ?>search">              
                        <div class="input-group">      
                            <!-- /btn-group -->
                            <input type="text" class="form-control" aria-label="..." value="<?php if (isset($_POST['search_value'])) echo $_POST['search_value']; ?>" name="search_value" id="search_value" placeholder='Search product in store'>  
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </span>

                        </div>   
                    </form>
                </div>   
            <?php } ?>
            <ul class="sub-action">
                <?php
                $this->load->model('dbcommon', '', TRUE);
                $current_user = $this->session->userdata('gen_user');
                if (isset($current_user) && $current_user != '') {
                    $where = " where user_id='" . $current_user['user_id'] . "'";
                    $user = $this->dbcommon->getrowdetails('user', $where);
                    ?>
                    <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Ads Left"><i class="fa fa-tags" aria-hidden="true"></i><span class="total-no"><?php echo $user->userAdsLeft; ?></span></a></li>
                    <?php
                }

                $cart_session_data = '';
                $cart_count__ = 0;
                $session_qunatity = $this->session->userdata('doukani_products');

                $_page = $this->uri->segment(1);
                if ((isset($_page) && ($_page == 'allstores' || $_page == 'store_search' || $_page == 'cart')) || (isset($__store_page) && $__store_page == 1)) {
                    $cart_session_data = 'yes';
                    if (isset($session_qunatity) && !empty($session_qunatity)) {
                        $cart_count__ = 0;
                        $arry_ids = explode(",", $session_qunatity);
                        $concat_str = '';
                        foreach ($arry_ids as $id) {
                            $arr = explode('-', $id);
                            if (isset($arr[0]) && !empty($arr[0]) && isset($arr[1]) && !empty($arr[1]))
                                $cart_count__++;
                        }
                    } else
                        $cart_count__ = 0;
                }
                elseif ($this->session->userdata('doukani_products')) {
                    $cart_session_data = 'yes';
                    $session_qunatity = $this->session->userdata('doukani_products');
                    if (isset($session_qunatity) && !empty($session_qunatity)) {
                        $cart_count__ = 0;
                        $arry_ids = explode(",", $session_qunatity);
                        $concat_str = '';
                        foreach ($arry_ids as $id) {
                            $arr = explode('-', $id);
                            if (isset($arr[0]) && !empty($arr[0]) && isset($arr[1]) && !empty($arr[1]))
                                $cart_count__++;
                        }
                    }
                }

                if (isset($cart_session_data) && $cart_session_data == 'yes') {
                    ?>
                    <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span class="total-no"><?php echo $cart_count__; ?></span></a></li>
                <?php } ?>

                <?php if ($this->session->userdata('gen_user')) { ?>
                    <li>
                        <a href="<?php echo HTTPS . website_url; ?>user/favorite" data-toggle="tooltip" data-placement="bottom" title="Favorites List"><i class="fa fa-star" aria-hidden="true"></i>
                        </a>
                    </li>                
                <?php } else { ?>
                    <li><a href="<?php echo HTTPS . website_url; ?>login/index" data-toggle="tooltip" data-placement="bottom" title="Favorites List"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                <?php } ?>
            </ul>
            <?php
            if (isset($current_user) && $current_user != '') {

                $profile_picture = '';
                $profile_picture = $this->dbcommon->load_picture($user->profile_picture, $user->facebook_id, $user->twitter_id, $user->username, $user->google_id);

                if ($current_user['nick_name'] != '')
                    $m_nm = 'Welcome, ' . $current_user['nick_name'];
                elseif ($current_user['username'] != '')
                    $m_nm = 'Welcome, ' . $current_user['username'];
                else
                    $m_nm = '';
                ?>            
                <div class="user-wrap">
                    <div class="dropdown Welcomeuser_store">
                        <a class="user-btn dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <img src="<?php echo $profile_picture; ?>" class="avtar-img" alt="" onerror="this.src='<?php echo HTTPS . website_url; ?>assets/upload/avtar.png'"/>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li class="user-data">
                                <p class="user-name"><?php echo $m_nm; ?><span class="free-ads"><?php echo $user->userAdsLeft; ?> Ads left</span></p>
                            </li>
                            <li><a href="<?php echo HTTPS . website_url; ?>user/my_listing" tabindex="-1" role="menuitem">My Ads</a></li>
                            <li><a href="<?php echo HTTPS . website_url; ?>user/post_ads" tabindex="-1" role="menuitem"><i class="fa fa-plus"></i>Post Free Ad</a></li>						
                            <li role="presentation"><a href="<?php echo HTTPS . website_url; ?>user/index" tabindex="-1" role="menuitem">My Profile</a></li>
                            <?php if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser') { ?>
                                <li><a href="<?php echo HTTPS . website_url; ?>user/store" tabindex="-1" role="menuitem">My Store</a></li>
                                <?php
                            }
                            $my_order_path = '';
                            if (isset($current_user['user_role']) && $current_user['user_role'] == 'storeUser') {
                                if (isset($current_user['last_login_as']) && $current_user['last_login_as'] == 'storeUser')
                                    $my_order_path = HTTPS . website_url . 'user/orders/sold';
                                else
                                    $my_order_path = HTTPS . website_url . 'user/orders/bought';
                            } else
                                $my_order_path = HTTPS . website_url . 'user/orders/bought';
                            ?>
                            <li><a href="<?php echo $my_order_path; ?>" tabindex="-1" role="menuitem">My Orders</a></li>

                            <li><a href="<?php echo HTTPS . website_url; ?>login/signout" tabindex="-1" role="menuitem">Sign out</a></li>                        
                        </ul>
                    </div>
                </div>
            <?php } else { ?>
                <div class="btn-group log-wrap" role="group" aria-label="...">
                    <a href="javascript:void(0);" onclick="load_page();" class="btn log-btn">Login</a>
                    <a href="<?php echo HTTPS . website_url; ?>registration" class="btn sign-btn">Sign up</a>
                </div>
            <?php } ?>
        </div>
    </div>
</header>
<div class="modal fade center" id="popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <a class='close' data-dismiss='alert' href='#'> &times; </a>
    <form id="login-form" name="login-form" method="post" class="form form-horizontal" class='validate-form' >
        <div id="loading" style="text-align:center">
            <img id="loading-image" src="<?php echo HTTPS . website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
        </div>
        <div class="modal-dialog modal-md">
            <div class="col-sm-9 ContentRight loginpg">
                <div class='' id="alert_box" style="display:none;">
                    <a class='close' data-dismiss='alert' href='#'> &times; </a>
                    <center id="alert_msg"></center>
                </div>
                <h3>Login</h3>
                <div class="col-sm-12 login-div">
                    <div class="social_main">
                        <h4>Login with Social</h4>                        
                        <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-fb" name="faebook_login"><i class="fa fa-facebook"></i>Sign In With Facebook</a>
                        <a href="<?php echo $twitter_login_url; ?>" class="btn btn-block btn-twit" name="twitter_login"><i class="fa fa-twitter"></i>Sign In With Twitter</a>
                        <a href="<?php echo $googlePlusLoginUrl; ?>" class="btn btn-block btn-g-plus" name="gplus_login"><i class="fa fa-google-plus"></i>Sign In With Google+</a>                        
                        <div class="text-right signup-link">Not Yet Registered? <a href="<?php echo HTTPS . website_url; ?>registration"><span>Sign up</span></a></div>
                    </div>
                    <div class="user-login">
                        <h4>Login with Doukani</h4>
                        <div class="form-group un">
                            <input type="text" class="form-control" placeholder="Username"  name="username" id="username" data-rule-required="true" />
                        </div>
                        <div class="form-group pwd">
                            <input type="password" class="form-control" placeholder="Password"  name="password" id="password" data-rule-required="true"/>
                        </div>
                        <div id="error">
                        </div>
                        <button class="btn btn-block btn-black" name="submit" id="login_submit" value="Log in">Log in</button>
                        <div class="text-right signup-link"><a href="<?php echo HTTPS . website_url; ?>login/forget_password">Forgot Password?</a></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function load_page() {
        $("#popup").modal('show');
    }
    $('document').ready(function () {
        $("#login-form").validate({
            rules:
                    {
                        password: {required: true},
                        username: {required: true},
                    },
            messages:
                    {
                        password: {required: "Password is required"},
                        username: {required: "Username / Email ID is required"}
                    },
            submitHandler: submitForm
        });

        function submitForm()
        {
            $("#login_submit").html('<img src="<?php echo HTTPS . website_url; ?>assets/front/images/btn-ajax-loader.gif" /> &nbsp; Signing In ...');
            var data = $("#login-form").serialize();

            $.ajax({
                type: 'POST',
                url: '<?php echo $mypath_ . "login/ajax_login"; ?>',
                data: data,
                beforeSend: function ()
                {
                    $("#alert_box").fadeOut();
                    $("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
                },
                success: function (response)
                {
                    console.log(response);

                    var json = response,
                            obj = JSON.parse(json);
                    var response = obj.response;

<?php
if (strpos($mypath_, after_subdomain) !== false) {

    $data = current_url();
    $last_data = substr($data, strpos($data, "/") - 1);
    $__redirect = 'http' . $last_data;
} else
    $__redirect = $_SERVER['REQUEST_URI'];
?>

                    if (response == "agree") {
                        var href = "<?php echo $__redirect; ?>";
                        setTimeout(function () {
                            window.location.href = href + '/#1';
                        }, 1000);
                    }
                    else {
                        if (response == "not_agree") {
                            href = '<?php echo HTTPS . website_url . 'login/agree'; ?>';
                            setTimeout(function () {
                                window.location.href = href + '/#1';
                            }, 1000);
                        }
                        else if (response == "user_role") {
                            href = '<?php echo HTTPS . website_url . 'login/user_role'; ?>';
                            setTimeout(function () {
                                window.location.href = href + '/#1';
                            }, 1000);
                        }
                        else if (response == "create_store") {
                            href = '<?php echo HTTPS . website_url . 'login/create_store'; ?>';
                            setTimeout(function () {
                                window.location.href = href + '/#1';
                            }, 1000);
                        }
                        else {
                            $('#alert_box').show();
                            $('#alert_msg').show();
                            $("#alert_msg").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + ' !</div>');
                            $("#login_submit").html('&nbsp; Log In');
                        }
                    }
                }
            });
            return false;
        }
    });

    if (window.location.hash == '#1') {
        $('.Welcomeuser_store').addClass('open');
    }

    $('.Welcomeuser_store').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });

    $('#err_div').hide();
    $('#search_value').bind("enterKey", function (e) {
        var search_value = $(this).val();
        var url = "<?php echo base_url(); ?>search";
        $.post(url, {search_value: search_value}, function (data)
        {
        });

    });
    $('#search_value').keyup(function (e) {
        if (e.keyCode == 13)
        {
            $(this).trigger("enterKey");
        }
    });
</script>