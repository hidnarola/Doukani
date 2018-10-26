<div class="modal fade center" id="popup" tabindex="-1" role="dialog" aria-hidden="true">
    <a class='close' data-dismiss='alert' href='#'> &times; </a>
    <form id="login-form" name="login-form" method="post">
        <div id="loading4" style="text-align:center">
            <img id="loading-image" src="<?php echo HTTPS . website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
        </div>
        <div class="modal-dialog modal-md">
            <div class="col-sm-9 ContentRight loginpg">

                <h3>Login</h3>
                <div class="col-sm-12 login-div">
                    <div class="social_main">
                        <h4>Login with Social</h4>                        
                        <a href="<?php echo $fb_login_url; ?>" class="btn btn-block btn-fb" id="faebook_login"><i class="fa fa-facebook"></i>Sign In With Facebook</a>
                        <a href="<?php echo $twitter_login_url; ?>" class="btn btn-block btn-twit" id="twitter_login"><i class="fa fa-twitter"></i>Sign In With Twitter</a>
                        <a href="<?php echo $googlePlusLoginUrl; ?>" class="btn btn-block btn-g-plus" id="gplus_login"><i class="fa fa-google-plus"></i>Sign In With Google+</a>                        
                        <div class="text-right signup-link">Not Yet Registered? <a href="<?php echo HTTPS . website_url; ?>registration"><span>Sign up</span></a></div>
                    </div>
                    <div class="user-login">
                        <div class='' id="alert_box" style="display:none;">
                            <span id="alert_msg"></span>
                        </div>
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
<script>
    function load_page() {
        $("#popup").modal('show');
    }
</script>

<script type="text/javascript">

    var window_width = parseInt($(window).width());
    if (window_width <= 1024) {
        $('.cat_link_red').attr('href', 'javascript:void(0)');
    }

    $('#loading4').hide();

<?php
$emirate = $this->uri->segment(1);
if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
    ?>
        var state_id_selection = '<?php echo $emirate; ?>';
<?php } else { ?>
        var state_id_selection = '';
<?php } ?>

    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    if (window.location.hash && window.location.hash == '#_=_') {
        window.location.hash = ''; // for older browsers, leaves a # behind
        history.pushState('', document.title, window.location.pathname); // nice and clean
        e.preventDefault(); // no page reload
    }

    function validateEmail()
    {
        var emailaddress = $("#email").val();
        if (emailaddress != "") {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if (!emailReg.test(emailaddress)) {
                $("#email").css("border", "1px solid #ed1b33");
                $("#email").focus();
            }
        } else {
            $("#email").css("border", "1px solid #ed1b33");
            $("#email").focus();
        }
    }

    jQuery(document).ready(function (e) {

        $('.menu-wrapper').css('max-height', '322px');
        $('#btn-show').click(function (e) {

            var text = $(this).find('#label').text();
            if (text == 'Show More') {
                $('.menu-wrapper').css('max-height', 'none');
                $(this).find('#icon').addClass('fa-caret-square-o-up');
                $(this).find('#icon').removeClass('fa-caret-square-o-down');
                $(this).find('#label').text('Show Less');
            } else {
                $('.menu-wrapper').css('max-height', '322px');
                $(this).find('#icon').removeClass('fa-caret-square-o-up');
                $(this).find('#icon').addClass('fa-caret-square-o-down');
                $(this).find('#label').text('Show More');
            }
        });

        var resizeId;
        $(window).resize(function () {
            clearTimeout(resizeId);
            resizeId = setTimeout(doneResizing, 200);

            var h = $('#most-viewed .col-lg-3 .item-sell .item-img img').height();
            $('#most-viewed .col-lg-3 .item-sell .item-img').height(h);

            var btnw = $('.postaddButton').width();
            $('.btn.btn-app').css('width', btnw);
        });

        function doneResizing() {
            var nw = $('.owl-wrapper .owl-item .item-img').width();
            var nh = $('.owl-wrapper .owl-item .item-img').height();

            $('.owl-wrapper .owl-item .item-img a').css('width', nw);
            $('.owl-wrapper .owl-item .item-img a').css('height', nh);
        }

        var btnw = $('.postaddButton').width();
        $('.btn.btn-app').css('width', btnw);

        $("#form_subscribe").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                email: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address"
                }
            },
            submitHandler: function (form) {

                $(document).find("#subscribe").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading...');
<?php
if (isset($store_url) && $store_url != '') {
    $__store_page = 1;
    $mypath_ = $store_url . '/';
} else
    $mypath_ = base_url();
?>

                var url = "<?php echo $mypath_; ?>home/subscription/";
                var email = $('#email').val();
                $.post(url, {email: email}
                , function (response)
                {
                    $(document).find('.subscription_msg').show();

                    if (response.val == 'success') {
                        $(document).find('.subscription_msg').html('<p class="alert-success" style="background:#cbcbcb;color: #05a846;"><b>Thank You For Subscribe!</b></p>');
                    } else {
                        $(document).find('#email').val('');
                        $(document).find('.subscription_msg').html('<p class="alert-danger" style="background:#cbcbcb;color:red;"><b>Email already subscribed</b></p>');
                    }

                    $(document).find("#subscribe").html('Subscribe');

//                    console.log(response.val);
                }, "json");
                return false;
//                form.submit();
            }
        });

<?php if (isset($request_state) && !empty($request_state)) { ?>
            $('.AllCity .dropdown-toggle').html('<?php echo $request_state; ?> <span class="caret"></span>');
<?php } ?>

        $("ul#select_emirate li a").click(function () {
            var text = $(this).closest("li").text();
            var state = $(this).closest("li a").data('state');
            var state_id = $(this).closest("li a").data('state-id');
            state_wise(text, state, state_id);
        });

        $("ul#emirate_sel li a").click(function () {

            var text = $(this).closest("li").text();
            var state = $(this).closest("li a").data('state');
            var state_id = $(this).closest("li a").data('state-id');
            state_wise(text, state, state_id);

        });

        function state_wise(text, state, state_id) {

<?php
if (isset($store_url) && $store_url != '')
    $mypath_ = $store_url;
else
    $mypath_ = base_url();
?>

            $.ajax({
                async: false,
                url: "<?php echo $mypath_; ?>home/valid_state",
                data: "state_id=" + state_id,
                type: "GET",
                success: function (resp) {

                    $("input[name='selection']").val(state);
                    $(this).parents('.dropdown').find('.dropdown-toggle').html(text + ' <span class="caret"></span>');
                    var request_emirate = '<?php echo $_SERVER["REQUEST_URI"]; ?>';

<?php if (isset($product_page) && $product_page == 'yes') { ?>

                        if (state_id == 'abudhabi' || state_id == 'ajman' || state_id == 'dubai' || state_id == 'fujairah' || state_id == 'ras-al-khaimah' || state_id == 'sharjah' || state_id == 'umm-al-quwain') {

                            var test = request_emirate.split('/');
                            if (test[1] == 'abudhabi' || test[1] == 'ajman' || test[1] == 'dubai' || test[1] == 'fujairah' || test[1] == 'ras-al-khaimah' || test[1] == 'sharjah' || test[1] == 'umm-al-quwain')
                                var old_state = test[1];
                            else
                                var old_state = '';

                            if (state_id == 'abudhabi' || state_id == 'ajman' || state_id == 'dubai' || state_id == 'fujairah' || state_id == 'ras-al-khaimah' || state_id == 'sharjah' || state_id == 'umm-al-quwain') {

                                var replace_emirate = request_emirate.replace(old_state, '/' + resp);
                                replace_emirate = replace_emirate.replace('//', '/');
                            } else {
                                var replace_emirate = request_emirate;
                            }
                            var href = '<?php echo HTTP . $_SERVER["HTTP_HOST"]; ?>' + replace_emirate;

                        } else {

                            if (resp == 'failure' && state_id == undefined) {
                                var test = request_emirate.split('/');
                                var old_state = test[1];
                                var replace_emirate = request_emirate.replace('/' + old_state, '');
                                var href = '<?php echo HTTP . $_SERVER["HTTP_HOST"]; ?>' + replace_emirate;
                            }
                        }
    <?php
} elseif (isset($product_details_page) && $product_details_page = 'yes') {
    if (isset($category_slug_details)) {
        ?>
                            var href = '<?php echo HTTP . $_SERVER["HTTP_HOST"]; ?>' + '/' + resp + '/' + '<?php echo $category_slug_details; ?>';
    <?php } else { ?>
                            var href = '<?php echo HTTP . $_SERVER["HTTP_HOST"]; ?>' + '/' + resp;
    <?php } ?>
<?php } else {
    ?>
                        var href = '<?php echo HTTP . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>';
<?php } ?>
                    window.location.href = href;
                    result = true;
                },
                error: function (e) {

                }
            });
        }

        var w = $(document).find('.horizontalList .img-holder').width();
        $(document).find('.horizontalList .img-holder .img-holderInner').css('width', w);
        var h = $(document).find('.horizontalList .img-holder').height();
        $(document).find('.horizontalList .img-holder .img-holderInner').css('height', h);

        $(window).resize(function () {
            var w = $(document).find('.horizontalList .img-holder').width();
            $(document).find('.horizontalList .img-holder .img-holderInner').css('width', w);
            var h = $(document).find('.horizontalList .img-holder').height();
            $(document).find('.horizontalList .img-holder .img-holderInner').css('height', h);
        });

    });
    $(".validate-form").validate();

    $('#load_less').hide();

<?php if (isset($category_id)) { ?>
        function load_more_subcategories() {

            $("#load_more_subcategories").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading...');
            $('#load_more_subcategories').prop('disabled', true);
            //                                                    
            var url = "<?php echo base_url(); ?>home/load_more_subcategories/";
    <?php
    $emirate = $this->uri->segment(1);
    if (in_array(strtolower($emirate), array('abudhabi', 'ajman', 'dubai', 'fujairah', 'ras-al-khaimah', 'sharjah', 'umm-al-quwain'))) {
        ?>
                var state_id_selection = '<?php echo $emirate; ?>';
    <?php } else { ?>
                var state_id_selection = '';
    <?php } ?>

            $.post(url, {category_id: '<?php echo (isset($category_id)) ? $category_id : ''; ?>',
                category_view: '<?php echo (isset($category_view)) ? $category_view : ''; ?>',
                order_option: '<?php echo (isset($order_option)) ? $order_option : ''; ?>',
                state_id_selection: state_id_selection
            }
            , function (response)
            {
                $("#load_more1").before(response.html);
                $(document).find('#load_more_subcategories').hide();
                $(document).find('#show_more_sub_cat').show();
                $(document).find('#load_less').show();
                $(document).find('#load_less_subcategories').show();
            }, "json");
        }


        function load_less_subcategories() {
            $(document).find('#load_less').hide();
            $(document).find('.show_more_sub_cat').hide();
            $(document).find('#load_less_subcategories').hide();
            $(document).find('#load_more_subcategories').show();
            $(document).find("#load_more_subcategories").html('Show More');
            $(document).find("#load_more_subcategories").prop('disabled', false);
        }
<?php } ?>

    //Display ToolTip
    $('[data-toggle="tooltip"]').tooltip({'placement': 'bottom'});

<?php if (isset($home_page) && $home_page == 'yes') { ?>
        function bindScroll() {
            if ($(window).scrollTop() % 4 == 0) {
                $(window).unbind('scroll');
                load_more_homedata();
            }
        }
        //load data when scroll down
        if (bindScroll !== 'undefined')
            $(window).scroll(bindScroll);

<?php } ?>

    function update_count(a)
    {
        var url = "<?php echo HTTPS . website_url; ?>home/update_click_count";
        $.post(url, {ban_id: a}, function (response)
        {
        }, "json");
    }

    $(document).on("click", "div.newthumb a i", function (e) {
<?php
if (isset($is_logged) && $is_logged != 0) {
    if (isset($store_url) && $store_url != '')
        $mypath_ = $store_url . '/';
    else
        $mypath_ = base_url();
    ?>
            e.preventDefault();
            var url = "<?php echo $mypath_; ?>user/add_to_like";
            var thu = 0;
            var id = $(this).attr('id');

            if ($(this).hasClass('fa-thumbs-o-up')) {
                $(this).removeClass("fa-thumbs-o-up");
                $(this).addClass("fa-thumbs-up");
                thu = 1;
            } else if ($(this).hasClass('fa-thumbs-up')) {

    <?php if (isset($like_ads) && $like_ads == 'yes') { ?>
                    $('.prod_' + id).hide();
    <?php } ?>

                $(this).addClass("fa-thumbs-o-up");
                $(this).removeClass("fa-thumbs-up");
                thu = -1;
            }

            $.post(url, {value: thu, product_id: id}, function (response) {
                if (response.trim() == 'Success' || response.trim() == 'failure')
                    $('#err_div').hide();
                else
                {
                    $('#' + id).addClass("fa-thumbs-o-up");
                    $('#' + id).removeClass("fa-thumbs-up");
                }
            });
<?php } else { ?>
            window.location = "<?php echo site_url(); ?>";
<?php } ?>
    });
<?php
$session_id = session_id();
?>
    //add/update to click on Star
    $(document).on("click", "div.star a i", function (e) {
<?php
if (isset($is_logged) && $is_logged != 0) {

    if (isset($store_url) && $store_url != '')
        $mypath_ = $store_url;
    else
        $mypath_ = base_url();
    ?>
            e.preventDefault();
            var url = "<?php echo $mypath_; ?>user/add_to_favorites";
            var fav = 0;
            var id = $(this).attr('id');

            if ($(this).hasClass('fa-star-o')) {

                $(this).closest('div').addClass('fav');
                $(this).removeClass("fa-star-o");
                $(this).addClass("fa-star");
                fav = 1;
            } else if ($(this).hasClass('fa-star')) {

    <?php if (isset($favorite_ads) && $favorite_ads == 'yes') { ?>
                    $('.prod_' + id).hide();
    <?php } ?>
                $(this).closest('div').removeClass('fav');
                $(this).addClass("fa-star-o");
                $(this).removeClass("fa-star");
                fav = -1;
            }
            var getthis = this;
            $.post(url, {value: fav, product_id: id}, function (response) {
                if (response.trim() == 'Success' || response.trim() == 'failure')
                    $('#err_div').hide();
                else
                {
                    $('i').find('#' + id).closest('div').removeClass('fav');
                    $('i').find('#' + id).addClass("fa-star-o");
                    $('i').find('#' + id).removeClass("fa-star");
                }
            });
<?php } else { ?>
            window.location = "<?php echo site_url(); ?>";
<?php } ?>
    });

    //Tawk to Chatting Tool

    var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
    (function () {
        var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
        s1.async = true;
        s1.src = 'https://embed.tawk.to/56cfe12c1b785aae04c37470/default';
        s1.charset = 'UTF-8';
        s1.setAttribute('crossorigin', '*');
        s0.parentNode.insertBefore(s1, s0);
    })();

<?php if (isset($_REQUEST['cat'])) { ?>
        //show_sub_cat("<?php //echo $_REQUEST['cat'];        ?>");
<?php } ?>
    function show_sub_cat__(val) {

        $("input[name='cat']").val(val);
        var url = "<?php echo base_url(); ?>home/show_sub_cat";
        $.post(url, {value: val}, function (data)
        {
            $("#sub_cat_").html(data);
            //$("#sub_cat").select2();
        });
    }

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }

    $("#search").click(function () {

        min = $("#min_amount").val();
        max = $("#max_amount").val();

//        if (max != "" && min != "" && ($.isNumeric(min) > $.isNumeric(max)))
        if (max != "" && min != "" && min > max)
        {
            $(document).find('.response_message').html('Max amount should be greater than min amount.');
            $(document).find("#search_alert").modal('show');
            $("#max_amount").val("");
            $("#max_amount").focus();
            return false;
        } else {
            return true;
        }
    });

    var val = $("#location").val();
    show_emirates(4);
    function show_emirates(val) {
        var sel_city = $("#sel_city").val();
        var url = "<?php echo HTTPS . website_url; ?>home/show_emirates";
        $.post(url, {value: val, sel_city: sel_city}, function (data)
        {
            $("#city1").html(data);
            $("#city1 option").remove();
            $("#city1").append(data);
        });
    }
    $(document).find('#search_bar_frm').submit(function () {
        var search_txt = $(document).find('#s').val();
        search_txt = search_txt.trim();
        if (search_txt == "") {
        }
    });

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
            $("#login_submit").html('<img src="<?php echo HTTPS . website_url; ?>assets/front/images/btn-ajax-loader.gif"  alt="Image" /> &nbsp; Signing In ...');
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
//                    console.log(response);

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
                            window.location.href = href;
                        }, 1000);
                    } else {
                        if (response == "not_agree") {
                            href = '<?php echo HTTPS . website_url . 'login/agree'; ?>';
                            setTimeout(function () {
                                window.location.href = href;
                            }, 1000);
                        } else if (response == "user_role") {
                            href = '<?php echo HTTPS . website_url . 'login/user_role'; ?>';
                            setTimeout(function () {
                                window.location.href = href;
                            }, 1000);
                        } else if (response == "create_store") {
                            href = '<?php echo HTTPS . website_url . 'user/store'; ?>';
                            setTimeout(function () {
                                window.location.href = href;
                            }, 1000);
                        } else {
                            $('#alert_box').show();
                            $('#alert_msg').show();
//                            console.log(response);
                            $("#alert_msg").html('<br><div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + ' ! <a class="close" data-dismiss="alert" href="javascript:void(0);">&times; </a></div>');
                            $("#login_submit").html('&nbsp; Log In');
                        }
                    }
                }
            });
            return false;
        }
    });

<?php
$show_user_popup = $this->session->userdata('show_user_popup');
$current_user = $this->session->userdata('gen_user');
if (isset($current_user) && isset($show_user_popup)) {
    ?>
        $('.Welcomeuser').addClass('open');
    <?php
    $this->session->unset_userdata('show_user_popup');
}
?>

    $('.Welcomeuser').hover(function () {
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

    $('.menuToggle').click(function () {
        $('.menu ul').slideToggle();
    });

    $('.menuCategories').click(function () {
        $('.LeftCategory').slideToggle();
        $('.offer_page_cat').slideToggle();
        $('.store-category-left').slideToggle();
        $('.all_stores_cat_list').slideToggle();
    });

    function call_app() {
        //window.location.href = '<?php //echo doukani_app;                ?>';	
        window.open('<?php echo doukani_app; ?>', '_blank');
    }

    var but_height = $(document).find('.postaddButton').height();
    $(document).find('#headerbanner').css('height', but_height);

    $(function () {
        $.smartbanner({
            appStoreLanguage: 'us',
            title: 'Doukani',
            author: 'Doukani',
            button: 'VIEW',
            store: {
                ios: 'On the App Store',
                android: 'In Google Play'
            },
            price: {
                ios: 'FREE',
                android: 'FREE'
            }
        });
    });

    $(document).on('click', '#create_store_btn', function () {
        $('#store_name_status').html('');
        var store_name = $('#store_name').val();
        if (store_name == '') {
            $('#store_name_status').html('<font color="#b94a48">Please enter store name!</font>');
            return false;
        }
        $.ajax({
            url: '<?php echo base_url(); ?>/registration/create_session_store',
            type: 'POST',
            context: this,
            data: {'store_name_create': store_name},
            success: function (res) {
                if (res == 'success') {
                    window.location.href = '<?php echo base_url(); ?>registration';
                } else {
                    $('#store_name_status').html('<font color="#b94a48">Something went wrong. Please try again!</font>');
                }
            }
        });
        return false;
    });

    $(document).on('change', '#registration #user_role', function () {
        if ($(this).val() == 'storeUser') {
            $('.store_hide_show_div').show();
        } else {
            $('.store_hide_show_div').hide();
        }
    });


    $(document).on("change", "#store_name", function (e) {
        var store_name = $(this).val();
        if (store_name) {
            $.ajax({
                type: 'post',
                url: '<?php echo site_url() . 'home/check_store_name' ?>',
                data: {
                    store_name: store_name
                },
                success: function (response) {
                    if (response == "OK") {
                        $('.store_name_status').html('');
                        flag1 = 0;
                        return true;
                    } else {
                        flag1 = 1;
                        $('.store_name_status').html('<font color="#b94a48">' + response + '</font>');
                        return false;
                    }
                }
            });
        } else {
            $('.store_name_status').html("");
            return false;
        }
    });

    $(document).on("keyup", "#store_domain", function (e) {
        var code_k = e.keyCode;
        if (code_k != 13 && code_k != 27) {
            if ($('#store_domain').val() == '') {
                $('#full_domain').html('store_name.doukani.com');
            } else {
                $('#full_domain').html($('#store_domain').val() + '.doukani.com');
            }
        }
    });

    $(document).on("change", "#store_domain", function (e) {
        var store_domain = $(this).val();
        if (store_domain) {
            $.ajax({
                type: 'post',
                url: '<?php echo site_url() . 'home/check_store_domain' ?>',
                data: {
                    store_domain: store_domain
                },
                success: function (response) {
                    if (response == "OK") {
                        $('.store_domain_status').html('');
                        flag2 = 0;
                        return true;
                    } else {
                        flag2 = 1;
                        $('.store_domain_status').html('<font color="#b94a48">' + response + '</font>');
                        return false;
                    }
                }
            });
        } else {
            $('.store_domain_status').html("");
            return false;
        }
    });
</script>