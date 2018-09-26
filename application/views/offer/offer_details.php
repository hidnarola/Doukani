<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/lightbox/lightbox.css" media="screen" rel="stylesheet" type="text/css" />
        <?php
        $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https';
        $offer_image = base_url() . offers . "original/" . $check_offer_slug['offer_image'];
        if (empty($offer_image))
            $offer_image = HTTPS . website_url . 'assets/upload/doukani_log.png';
        ?>
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="Doukani" />
        <meta property="og:title" content="<?php echo $check_offer_slug['offer_title']; ?>" />
        <meta property="og:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:image" content="<?php echo $offer_image; ?>" />

        <meta property="og:description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $check_offer_slug['offer_description']); ?>" />
        <meta name="description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $check_offer_slug['offer_description']); ?>" />

        <meta content="article" property="og:type" />
        <meta content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" property="og:url">

        <meta content="summary" name="twitter:card" />
        <meta content="doukaniapp" name="twitter:site" />
        <meta content="<?php echo $check_offer_slug['offer_title']; ?>" name="twitter:title" />
        <meta name="twitter:text:description" content="<?php echo preg_replace('#<[^>]+>#', ' ', $check_offer_slug['offer_description']); ?>" />
        <meta content="<?php echo $offer_image; ?>" name="twitter:image" />
        <script type="text/javascript">
            document.write('<style>.noscript { display: none; }</style>');
        </script>    
        <script type="text/javascript" src="<?php echo site_url(); ?>assets/front/javascripts/buttons.js"></script>
        <!--<script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>-->
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/lightbox/lightbox.min.js" type="text/javascript"></script>
        <style>
            .badge_top {top:initial;}
        </style>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
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
                                    <div class="prod-breadcrumb">
                                        <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                                <a href="<?php echo site_url() . 'alloffers'; ?>" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">Offers</span></a>
                                                <meta itemprop="position" content="1" />
                                            </li>
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo site_url() . 'companies'; ?>" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name">Companies</span></a>
                                                <meta itemprop="position" content="2" />
                                            </li>
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a href="<?php echo site_url() . $check_offer_slug['user_slug']; ?>" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name"><?php echo $check_offer_slug['company_name']; ?></span></a>
                                                <meta itemprop="position" content="3" />
                                            </li>
                                            <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="active"><a href="javascript:void(0);" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name"><?php echo $check_offer_slug['offer_title']; ?></span></a>
                                                <meta itemprop="position" content="4" />
                                            </li>
                                        </ol>
                                    </div>
                                    <div class="offer-disp">
                                        <div class="offer-top">
                                            <h3 class="offer-name" itemprop="name"><?php echo $check_offer_slug['offer_title']; ?></h3>
                                        </div>
                                    </div>                                
                                    <div class="offer-view" itemscope itemtype="https://schema.org/Product">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-8">
                                                <div class="offer-disp">
                                                    <div class="offer-img">
                                                        <?php if (isset($check_offer_slug['offer_image']) && !empty($check_offer_slug['offer_image'])) { ?>
                                                            <a class="data-lightbox-custom" data-lightbox='flatty' href='<?php echo base_url() . offers . "offer_detail/" . $check_offer_slug["offer_image"]; ?>' >
                                                                <img src="<?php echo base_url() . offers . "offer_detail/" . $check_offer_slug['offer_image']; ?>" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" alt="<?php echo $check_offer_slug['offer_title']; ?>">
                                                            </a>
                                                        <?php } else { ?>
                                                            <img src="<?php echo base_url(); ?>assets/upload/No_Image.png" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'" alt="<?php echo $check_offer_slug['offer_title']; ?>">
                                                        <?php } ?>
                                                    </div>
                                                    <?php if (isset($updated_views_count) && !empty($updated_views_count)) { ?>
                                                        <p class="views-offer"><span><i class="fa fa-eye" aria-hidden="true"></i> <?php echo $updated_views_count; ?> Views </span></p>
                                                    <?php } ?>
                                                    <div class="desc-wrap">
                                                        <h4 class="sub-title">Description</h4>
                                                        <p itemprop="description"><br><?php echo $check_offer_slug['offer_description']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-12" itemprop="additionalProperty" class="row" itemscope itemtype="https://schema.org/PropertyValue">
                                                <div class="offer-act">
                                                    <div class="offer-valid">
                                                        <div class="v-left">
                                                            <p class="added"><span class="param-label" itemprop="name">Added</span> <span class="param-values" itemprop="value"><?php
                                                                    $date = date_create($check_offer_slug['offer_start_date']);
                                                                    echo date_format($date, 'd-m-Y');
                                                                    ?></span></p>
                                                            <?php if ($check_offer_slug['is_enddate'] == 0) { ?>
                                                                <p class="exp"><strong class="param-label" itemprop="name">Expire on</strong> <span class="param-values" itemprop="value"><?php
                                                                        $date = date_create($check_offer_slug['offer_end_date']);
                                                                        echo date_format($date, 'd-m-Y');
                                                                        ?></span></p>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="share_frd"> 
                                                            <span class="social_label ">Share with friends </span>
                                                            <span class='st_facebook_large' id="facebook_btn" ></span>
                                                            <span class='st_twitter_large disabled'></span>
                                                            <span class='st_googleplus_large disabled'></span>
                                                        </div>
                                                    </div>
                                                    <div class="action-wrap">
                                                        <?php if ($check_offer_slug['company_is_inappropriate'] == 'Approve' && $check_offer_slug['offer_is_approve'] == 'approve' && $check_offer_slug['company_status'] == 0) { ?>
                                                            <a class="btn black-btn " id="show_number_link"><span class="show_number"> Show Number</span></a>
                                                            <?php
                                                        } else {
                                                            echo "<p class='expired_message'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> AD Expired</p>";
                                                        }
                                                        ?>
                                                        <?php if (isset($check_offer_slug['offer_url']) && !empty($check_offer_slug['offer_url'])) { ?>
                                                            <a class="btn red-btn" id="reply_to_ad_link" href="<?php echo $check_offer_slug['offer_url']; ?>">Go To Website</a>

                                                            <?php
                                                        }
                                                        $btn_name = '<i class="fa fa-plus"></i> Follow Company';
                                                        if ($is_following > 0)
                                                            $btn_name = 'Following Company';
                                                        if (isset($login_username)) {
                                                            if ($login_username != $check_offer_slug['username']) {
                                                                if ($btn_name == 'Following Company') {
                                                                    ?>
                                                                    <span class="store-follow-btn"><a href="<?php echo HTTPS . website_url; ?>seller/unfollow/<?php echo $check_offer_slug['user_id'] . '/' . $check_offer_slug['user_slug'] . '/' . $check_offer_slug['offer_slug']; ?>"  id="following"><?php echo $btn_name; ?></a></span>
                                                                    <?php
                                                                } else {
                                                                    if (isset($current_user) && (sizeof($current_user) == 0) || (isset($current_user) && sizeof($current_user) > 0 && $current_user != '' && $current_user['user_id'] != $check_offer_slug['user_id'])) {
                                                                        ?>
                                                                        <span class="store-follow-btn"><a href="<?php echo HTTPS . website_url; ?>seller/addfollow/<?php echo $check_offer_slug['user_id'] . '/' . $check_offer_slug['user_slug'] . '/' . $check_offer_slug['offer_slug']; ?>" ><?php echo $btn_name; ?></a></span>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            ?>
                                                            <span class="store-follow-btn"><a href="<?php echo HTTPS . website_url . 'login/index'; ?>" ><?php echo $btn_name; ?></a></span>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="ads-banner">
                                                        <?php
                                                        if (!empty($featured_banners)) {
                                                            if ($featured_banners[0]['ban_txt_img'] == 'image') {
                                                                ?>
                                                                <a href="<?php echo '//' . $featured_banners[0]['site_url']; ?>" target="_blank" onclick="javascript:update_count('<?php echo $featured_banners[0]['ban_id']; ?>')" ><img src="<?php echo base_url(); ?>assets/upload/banner/original/<?php echo $featured_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" /></a>
                                                                <?php
                                                            } elseif ($featured_banners[0]['ban_txt_img'] == 'text') {
                                                                ?>
                                                                <a href="<?php echo '//' . $featured_banners[0]['site_url']; ?>" target="_blank"  onclick="javascript:update_count('<?php echo $featured_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block">
                                                                    <div class="">
                                                                        <?php
                                                                        echo $featured_banners[0]['text_val'];
                                                                        ?>
                                                                    </div>
                                                                </a>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gray-box">
                                        <?php if ($is_following > 0 && isset($login_username) && $login_username != $company_details['username']) { ?>
                                            <div class="badge_top badge_off_top" data-toggle="tooltip" data-placement="top" data-original-title="You are following"><img src="<?php echo site_url(); ?>assets/front/images/check.png" alt="Check Mark"></div>
                                        <?php } ?>
                                        <div class="company-info">
                                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $company_details['user_id']; ?>">
                                            <?php
                                            $company_image = HTTPS . website_url . offer_company . 'medium/' . $company_details['company_logo'];
                                            if (empty($company_image))
                                                $company_image = HTTPS . website_url . 'assets/upload/doukani_log.png';
                                            ?>
                                            <a href="<?php echo site_url() . $company_details['user_slug']; ?>">
                                                <div class="comp-image"><img src="<?php echo $company_image; ?>" alt="Company Logo" onerror="this.src='<?php echo base_url(); ?>assets/upload/No_Image.png'"></div>
                                            </a>
                                            <div class="comp-detail">
                                                <h3 class="comp-name"><?php echo $company_details['company_name']; ?> 
                                                    <ul class="social-icn">
                                                        <?php
                                                        if (isset($company_details['website_url']) && !empty($company_details['website_url'])) {
                                                            if (strpos($company_details['website_url'], 'http://') !== false || strpos($company_details['website_url'], 'https://') !== false) {
                                                                $company_details_url = 'href="' . $company_details['website_url'] . '"';
                                                            } else {
                                                                $company_details_url = 'href="http://' . $company_details['website_url'] . '"';
                                                            }
                                                            ?>
                                                            <li><a <?php echo $company_details_url; ?>><i class="fa fa-globe" aria-hidden="true"></i></a></li>
                                                        <?php } ?>
                                                        <?php
                                                        if (isset($company_details['facebook_social_link']) && !empty($company_details['facebook_social_link'])) {
                                                            if (strpos($company_details['facebook_social_link'], 'http://') !== false || strpos($company_details['facebook_social_link'], 'https://') !== false) {
                                                                $facebook_social_link = 'href="' . $company_details['facebook_social_link'] . '"';
                                                            } else {
                                                                $facebook_social_link = 'href="http://' . $company_details['facebook_social_link'] . '"';
                                                            }
                                                            ?>
                                                            <li><a <?php echo $facebook_social_link; ?>><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                                                        <?php } ?>
                                                        <?php
                                                        if (isset($company_details['twitter_social_link']) && !empty($company_details['twitter_social_link'])) {
                                                            if (strpos($company_details['twitter_social_link'], 'http://') !== false || strpos($company_details['twitter_social_link'], 'https://') !== false) {
                                                                $twitter_social_link = 'href="' . $company_details['twitter_social_link'] . '"';
                                                            } else {
                                                                $twitter_social_link = 'href="http://' . $company_details['twitter_social_link'] . '"';
                                                            }
                                                            ?>
                                                            <li><a <?php echo $twitter_social_link; ?>><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
                                                        <?php } ?>
                                                        <?php
                                                        if (isset($company_details['instagram_social_link']) && !empty($company_details['instagram_social_link'])) {
                                                            if (strpos($company_details['instagram_social_link'], 'http://') !== false || strpos($company_details['instagram_social_link'], 'https://') !== false) {
                                                                $instagram_social_link = 'href="' . $company_details['instagram_social_link'] . '"';
                                                            } else {
                                                                $instagram_social_link = 'href="http://' . $company_details['instagram_social_link'] . '"';
                                                            }
                                                            ?>
                                                            <li><a <?php echo $instagram_social_link; ?>><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                                        <?php } ?>                        
                                                    </ul>
                                                </h3>
                                                <?php                                                 
//                                                print_r($company_details);
                                                if (!isset($company_details['email_id']) || isset($company_details['followers_count'])) { ?>
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
                                                        <?php if ($check_offer_slug['company_is_inappropriate'] == 'Approve' && $check_offer_slug['offer_is_approve'] == 'approve' && $check_offer_slug['company_status'] == 0) { ?>
                                                            <a class="btn red-btn" id="contact_us_link"> Contact Us</a>
                                                        <?php } ?>
                                                    </div>                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-4">
                                    <div class="gray-box side">
                                        <h3 class="wrap-title">Related Offers</h3>
                                        <?php $this->load->view('offer/offer_grid_view'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="ifLoginModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">To Report</h4>
                    </div>
                    <div class="modal-body">
                        <h5>You need to be logged in to reply for this item.</h5>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url(); ?>login" class="btn btn-success btn-md"  rel="nofollow" >Log In</a>
                    </div>
                </div>
            </div>
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
        <div id="ifLoginModal1" class="modal fade" role="dialog">
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

        <?php $this->load->view('include/footer'); ?>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/lightbox/lightbox.min.js" type="text/javascript"></script> 
    </body>
    <script type="text/javascript">
                                                            $(function () {
                                                                $(".data-lightbox-custom").each(function () {
                                                                    console.log($(this).find("img").attr("alt"));
                                                                    $(this).attr("title", $(this).find("img").attr("alt"));
                                                                    $('.lb-image').attr("alt", $(this).find("img").attr("alt"));
                                                                });
                                                            });


                                                            $(document).on("click", "#about_us_link", function (e) {
                                                                $("#about_us").modal('show');
                                                            });

                                                            $(document).on("click", "#contact_us_link", function (e) {
<?php if ($is_logged == 0) { ?>
                                                                    $("#ifLoginModal1").modal('show');
<?php } else { ?>
                                                                    $("#send_inquiry").modal('show');
<?php } ?>
                                                            });

                                                            $('#show_number_link').click(function () {
<?php
if (isset($check_offer_slug['company_number']) && !empty($check_offer_slug['company_number'])) {
    ?>
                                                                    $(this).find('.show_number').text('<?php echo $check_offer_slug['company_number']; ?>');
<?php } ?>
                                                            });

                                                            $(document).on("click", "#reply_to_ad_link", function (e) {
                                                                console.log("herere");
<?php if ($is_logged == 0) { ?>
                                                                    $("#ifLoginModal").modal('show');
<?php } else { ?>
                                                                    $("#replyModal").modal('show');
<?php } ?>
                                                            });
                                                            $("#following").mouseenter(function () {
                                                                $('#following').text('Un-follow Company');
                                                            });

                                                            $("#following").mouseout(function () {
                                                                $('#following').text('Following Company');
                                                            });
    </script>
</html>

