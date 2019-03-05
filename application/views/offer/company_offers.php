<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <?php
        $protocol = 'http';
        $company_image = HTTPS . website_url . offer_company . 'original/' . $company_details['company_logo'];
        if (empty($company_image))
            $company_image = HTTPS . website_url . 'assets/upload/doukani_log.png';
        ?>
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="Doukani" />
        <meta property="og:title" content="<?php echo $company_details['company_name']; ?>'s Offers" />
        <meta property="og:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:image" content="<?php echo $company_image; ?>" />
        <meta property="og:description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $company_details['company_description']); ?>" />
        <!--        <meta name="keyword" content="<?php //echo $keyword_;  ?>" />-->

        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="Doukani">
        <meta name="twitter:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta name="twitter:title" content="<?php echo $company_details['company_name']; ?>'s Offers">
        <meta name="twitter:description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $company_details['company_description']); ?>">
        <meta name="twitter:image:src" content="<?php echo $company_image; ?>">        
        <script type="text/javascript">
            document.write('<style>.noscript { display: none; }</style>');            
        </script>
        <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <!--container-->
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class=" page">
                <div class="container">
                    <div class="row">
                    <?php $this->load->view('include/sub-header'); ?>
                    <?php if ($this->session->flashdata('msg1')): ?>
                        <div class='alert alert-success'>
                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                            <?php echo $this->session->flashdata('msg1'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="offer-wrap">
                        <div class="row">
                             <div class="col-md-9 col-sm-8 right-side">
                                <input type="hidden" name="offer_cat_id" id="offer_cat_id">
                                <input type="hidden" name="search" id="search">
                                <input type="hidden" name="offer_view" id="offer_view" value="grid">
                                <input type="hidden" name="off_user_id" id="off_user_id" value="<?php echo $company_details['user_id']; ?>">
                                <input type="hidden" name="user_company_id" id="user_company_id" value="<?php echo $company_details['id']; ?>">
                                <div class="gray-box">
                                    <?php if ($is_following > 0 && isset($login_username) && $login_username != $company_details['username']) { ?>
                                    <div class="badge_top badge_off_top" data-toggle="tooltip" data-placement="top" data-original-title="You are following"><img src="<?php echo site_url(); ?>assets/front/images/check.png" alt="Check Mark" ></div>
                                    <?php } ?>
                                    
                                    <div class="company-info">
                                        <?php
                                        $company_image = company_details_image_start . HTTPS . website_url . offer_company . 'medium/' . $company_details['company_logo'] . company_details_image_end;
                                        if (empty($company_image))
                                            $company_image = company_details_image_start . HTTPS . website_url . 'assets/upload/doukani_log.png' . company_details_image_end;
                                        ?>
                                        <div class="comp-image"><img src="<?php echo $company_image; ?>" alt="<?php echo $company_details['company_name']; ?>" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'"></div>
                                        <div class="comp-detail">
                                            <h3 class="comp-name"><a href="<?php echo site_url() . $company_details['user_slug']; ?>" class="company_name_link"><?php echo $company_details['company_name']; ?></a>
                                                <ul class="social-icn">
                                                    <?php if (isset($company_details['website_url']) && !empty($company_details['website_url'])) { ?>
                                                        <li><a href="<?php echo $company_details['website_url']; ?>"><i class="fa fa-globe" aria-hidden="true"></i></a></li>
                                                    <?php } ?>
                                                    <?php if (isset($company_details['facebook_social_link']) && !empty($company_details['facebook_social_link'])) { ?>
                                                        <li><a href="<?php echo $company_details['facebook_social_link']; ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                                                    <?php } ?>
                                                    <?php if (isset($company_details['twitter_social_link']) && !empty($company_details['twitter_social_link'])) { ?>
                                                        <li><a href="<?php echo $company_details['twitter_social_link']; ?>"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                                                    <?php } ?>
                                                    <?php if (isset($company_details['instagram_social_link']) && !empty($company_details['instagram_social_link'])) { ?>
                                                        <li><a href="<?php echo $company_details['instagram_social_link']; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                                    <?php } ?>
                                                    <?php if (isset($company_details['company_total_views']) && !empty($company_details['company_total_views'])) { ?>
                                                        <li><span><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $company_details['company_total_views']; ?> Views </span></li>
                                                    <?php } ?>
                                                </ul>
                                            </h3>
                                            <?php if (!isset($company_details['email_id']) || isset($total_followers)) { ?>
                                                <div class="contact">
                                                    <?php if (!isset($company_details['email_id']) && !empty($company_details['email_id'])) { ?>
                                                        <p class="c-line"><strong>Email Address: </strong><?php echo $company_details['email_id']; ?></p>
                                                    <?php } if (isset($total_followers)) { ?>

                                                        <p class="c-line last"><a href="<?php echo site_url() . $company_details['user_slug'] . '/followers'; ?>"><strong>Followers: </strong><?php echo ($total_followers != '') ? $total_followers : '0'; ?></a></p>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            <div class="extra-det">
                                                <div class="right-btn">
                                                    <?php if (isset($company_details['company_description']) && !empty($company_details['company_description'])) { ?>
                                                        <a class="btn black-btn" id="about_us_link">About Us</a>
                                                    <?php } ?>
                                                    <a class="btn red-btn" id="contact_us_link"> Contact Us</a>
                                                    <?php
                                                    $btn_name = '<i class="fa fa-plus"></i> Follow';
                                                    if ($is_following > 0)
                                                        $btn_name = 'Following';
                                                    if (isset($login_username)) {
                                                        if ($login_username != $company_details['username']) {
                                                            if ($btn_name == 'Following') {
                                                                ?>
                                                                <span class="store-follow-btn"><a href="<?php echo HTTPS . website_url; ?>seller/unfollow/<?php echo $company_details['user_id'] . '/' . $company_details['user_slug']; ?>"  id="following"><?php echo $btn_name; ?></a></span>
                                                                <?php
                                                            } else {
                                                                if (isset($current_user) && (sizeof($current_user) == 0) || (isset($current_user) && sizeof($current_user) > 0 && $current_user != '' && $current_user['user_id'] != $company_details['user_id'])) {
                                                                    ?>
                                                                    <span class="store-follow-btn"><a href="<?php echo HTTPS . website_url; ?>seller/addfollow/<?php echo $company_details['user_id'] . '/' . $company_details['user_slug']; ?>" ><?php echo $btn_name; ?></a></span>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        ?>
                                                        <span class="store-follow-btn"><a href="<?php echo HTTPS . website_url . 'login/index'; ?>" ><?php echo $btn_name; ?></a></span>
                                                    <?php } ?>
                                                </div>
                                                <ul class="sub-act">
                                                    <li class="share_frd"> <span class="social_label ">Share with friends </span> <span class='st_facebook_large '></span> <span class='st_twitter_large disabled'></span> <span class='st_googleplus_large disabled' ></span> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gray-box">
                                    <div class="offer-top">

                                        <ol class="breadcrumb no-margin"  itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo site_url() . 'alloffers'; ?>" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">Home</span></a><meta itemprop="position" content="1" /></li>
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo site_url() . 'companies'; ?>" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">Companies</span></a><meta itemprop="position" content="2" /></li>
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active"><a itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name"><?php echo $company_details['company_name']; ?></span></a><meta itemprop="position" content="3" /></li>
                                        </ol>


                                        <div class="view-block"> <a href="javascript:void(0);" class="active offer_view grid" data-id="grid"><i class="fa fa-th" aria-hidden="true"></i></a> <a href="javascript:void(0);" class="offer_view list" data-id="list"><i class="fa fa-th-list" aria-hidden="true"></i></a> </div>
                                        <br>
                                        <br>
                                    </div>
                                    <div id="loading" style="text-align:center" class="loader_display"> <img src="<?php echo HTTPS . website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." /> </div>
                                    <div class="offer-listing">
                                        <div class="offer-listing-div">
                                            <div class="row">
                                                <?php
                                                if (isset($offers_list) && sizeof($offers_list) > 0) {
                                                    $this->load->view('offer/offer_grid_view');
                                                } else {
                                                    ?>
                                                    <div class="catlist">
                                                        <div class="catlist col-sm-10">
                                                            <div class="TagsList">
                                                                <div class="subcats">
                                                                    <div class="col-sm-12 no-padding-xs">
                                                                        <div class="col-sm-12">
                                                                            &nbsp;No results found
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <br><br><br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
<?php if (@$hide == "false") { ?>
                                            <div class="text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_offers" value="0">Load More</button>
                                            </div>
                                            <br>
                                            <br>
<?php } ?>

                                    </div>
                                </div>
                            </div>
                       
                            <div class="col-md-3 col-sm-4">
                                <div class="gray-box side">
                                    <h3 class="wrap-title">Similar Companies</h3>
                                    <div class="cate-listing">
                                        <div class="cate-list">
                                            <ul class="comp-ul">
                                                <?php foreach ($similar_companies as $sim) { ?>
                                                    <li> <a href="<?php echo $sim['user_slug']; ?>">
                                                            <?php
                                                            if (isset($sim['company_logo']) && !empty($sim['company_logo']))
                                                                $img_path = company_details_image_start . site_url() . offer_company . 'medium/' . $sim['company_logo'] . company_details_image_end;
                                                            else
                                                                $img_path = company_details_image_start . site_url() . 'assets/upload/No_Image.png' . company_details_image_end;
                                                            ?>
                                                            <div class="comp-block">
                                                                <div class="comp-img"><img src="<?php echo $img_path; ?>" alt="Company Logo" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" /></div>
                                                            </div>
                                                        </a> </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
                </div>
                <!--//main--> 
            </div>
            <!--//body--> 
        </div>
        <div class="modal fade center" id="about_us" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog appup modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><i class="fa fa-info-circle"></i>About Us</h4>
                    </div>
                    <div class="modal-body text-center">
                        <?php if (isset($company_details['company_description']) && !empty($company_details['company_description'])) { ?>
                            <p> <?php echo $company_details['company_description']; ?> </p>
<?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div id="send_inquiry" class="modal fade" role="dialog">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <form accept-charset="utf-8" name="formReportAds" method="post" id="formReportAds" class="form-horizontal validate-form" action="<?php echo site_url() . 'home/send_msg_seller'; ?>">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Contact to Company</h4>
                        </div>
                        <?php
                        if (isset($current_user) && (sizeof($current_user) == 0) || (isset($current_user) && sizeof($current_user) > 0 && $current_user != '' && $current_user['user_id'] != $user->user_id)) {
                            ?>
                            <div class="modal-body">
                                <div style="display: none" id="formErrorMsgReport" class="alert alert-info"></div>
    <?php if (isset($company_details['company_number']) && !empty($company_details['company_number'])) { ?>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <a class="ShowNumber btn mybtn btn-block" id="see_number">
                                                <span class="fa fa-phone"></span><span class="show_number" id="show_number"> Show Number</span>
                                            </a>					   
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <label>&nbsp;OR</label>                     
                                        </div>
                                    </div>
    <?php } ?>
                                <div class="row">
                                    <div class="col-xs-4">
                                        <label>Send Mail</label>
                                    </div>
                                    <div class="col-xs-12">
                                        <textarea placeholder="" name ="message" id="message" class="form-control xyz"  data-rule-required='true'></textarea>
                                    </div>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <div class="col-xs-3 text-center">
                                        <label class="control-label">Name</label>
                                    </div>
                                    <div class="col-xs-9">
                                        <input type="text" value="<?php echo $seller_name; ?>" placeholder="" name="seller_name" id="seller_name" class="form-control" readonly>
                                        <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $seller_id; ?>" >
                                        <input type="hidden" name="request_from" id="request_from" value="<?php echo $request_from; ?>" >
                                        <input type="hidden" name="redirect_url" id="redirect_url" value="<?php echo current_url(); ?>" >
                                    </div>
                                </div>
                                <div class="form-group" style="display:none;">
                                    <div class="col-xs-3 text-center">
                                        <label class="control-label">Email </label>
                                    </div>
                                    <div class="col-xs-9">
    <?php echo $seller_emailid; ?>
                                        <input type="hidden" value="<?php echo $seller_emailid; ?>" placeholder="" name="seller_email" id="seller_email" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-sm-6 col-xs-12">&nbsp;</div>
                                <div class="col-sm-6 col-xs-12 popup-ftr-btn">
                                    <button type="button" class="btn btn-black" data-dismiss="modal">Close</button>               
                                    <button type="submit" name="send_mail" class="btn btn-success btn-md">Submit</button>
                                </div>
                            </div>
<?php } elseif (!isset($current_user)) { ?>
                            <div class="modal-body">
                                <h5>You need to be logged in to contact with Company.</h5>
                            </div>
                            <div class="modal-footer">
                                <a href="login/index" class="btn btn-success btn-md">Log In</a>
                            </div>
<?php } ?>
                    </form>
                </div>
            </div>
        </div>

        <div id="ifLoginModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">To Contact</h4>
                    </div>
                    <div class="modal-body">
                        <h5>You need to be logged in to contact.</h5>
                    </div>
                    <div class="modal-footer">
                        <div class="col-sm-6 col-xs-12">&nbsp;</div>
                        <div class="col-sm-6 col-xs-12 popup-ftr-btn">
                            <a href="<?php echo base_url(); ?>login" class="btn btn-success btn-md">Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--footer-->
<?php $this->load->view('include/footer'); ?>
        <script type="text/javascript">

            $('#see_number').click(function () {
<?php
if (isset($company_details['company_number']) && !empty($company_details['company_number'])) {
    ?>
                    $(this).find('.show_number').text('<?php echo $company_details['company_number']; ?>');
<?php } ?>
            });

            $(document).on("click", "#about_us_link", function (e) {
                $("#about_us").modal('show');
            });

            $(document).on("click", "#contact_us_link", function (e) {
<?php if ($is_logged == 0) { ?>
                    $("#ifLoginModal").modal('show');
<?php } else { ?>
                    $("#send_inquiry").modal('show');
<?php } ?>
            });

            $(document).on("click", ".offer_view", function (e) {
                e.preventDefault();
                $('#load_offers').val(0);
                $('.loader_display').show();

                var search = $(this).attr('data-id');
                var val1 = 1;
                $('#offer_view').val(search);
                var offer_view = $('#offer_view').val();
                var type = $('#search').val();
                var offer_cat_id = $('#offer_cat_id').val();
                var off_user_id = $('#off_user_id').val();
                var user_company_id = $('#user_company_id').val();

                if (search == 'grid') {
                    $('.' + search).addClass('active');
                    $('.list').removeClass('active');
                }
                else if (search == 'list') {
                    $('.' + search).addClass('active');
                    $('.grid').removeClass('active');
                }

                var url = "<?php echo site_url(); ?>alloffers/offer_grid_list_view";
                $.post(url, {value: 0, view: search, category_id: offer_cat_id, off_user_id: off_user_id, user_company_id: user_company_id}, function (response) {
                    $('.offer-listing-div .row').html('');
                    $('.offer-listing-div .row').html(response.html);

                    if (response.val == "true")
                        $("#load_offers").hide();
                    else
                        $("#load_offers").show();

                    $('.loader_display').hide();
                }, "json");
            });

            function load_more_data() {

                var offer_view = $('#offer_view').val();
                var offer_cat_id = $('#offer_cat_id').val();
                var off_user_id = $('#off_user_id').val();
                var user_company_id = $('#user_company_id').val();
                $("#load_offers").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_offers').prop('disabled', true);

                var url = "<?php echo base_url(); ?>alloffers/offer_grid_list_view";
                var start = $("#load_offers").val();
                start++;
                $("#load_offers").val(start);
                var val = start;
                $.post(url, {value: val, view: offer_view, category_id: offer_cat_id, off_user_id: off_user_id, user_company_id: user_company_id}, function (response) {
                    $('.offer-listing-div .row').append(response.html);
                    if (response.val == "true")
                        $("#load_offers").hide();
                    else
                        $("#load_offers").show();

                    $('#load_offers').prop('disabled', false);
                    $("#load_offers").html('Load More');
                }, "json");
            }

            $("#following").mouseenter(function () {
                $('#following').text('Un-follow');
            });

            $("#following").mouseout(function () {
                $('#following').text('Following');
            });
        </script>
    </body>
</html>
