<!DOCTYPE html>
<html>
    <head> 
        <title><?php echo $page_title; ?></title>
        <link href="<?php echo HTTPS . website_url; ?>assets/front/winipad/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo HTTPS . website_url; ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet">        
        <link rel="stylesheet" type="text/css" href="<?php echo HTTPS . website_url; ?>assets/front/winipad/style.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo HTTPS . website_url; ?>assets/front/winipad/responsive.css"/>        
        <script src="<?php echo HTTPS . website_url; ?>assets/front/dist/js/jquery.min.js"></script>
        <script src="<?php echo HTTPS . website_url; ?>assets/front/dist/js/bootstrap.min.js"></script>     
        <script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/plugins/validate/jquery.validate.min.js"></script>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body class="bgclr">
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <?php
        $iphone_app = doukani_iphone_app;
        $android_app = doukani_android_app;
        $logo_link = HTTPS . website_url;
        $doukani_loge_img = $this->db->query('select image_name from doukani_logo where id=1')->row_array();
        $doukani_logo = $doukani_loge_img['image_name'];

        if (empty($doukani_logo))
            $doukani_logo = 'assets/front/images/DoukaniLogo.png';
        else
            $doukani_logo = doukani_logo . 'original/' . $doukani_logo;
        ?>
        <div>
            <div class="container">
                <div class="form-holder">
                    <div class="row">
                        <div class="col-md-6 pr0">
                            <div class="lpart text-center">
                                <p>BUY & SELL ANYTHING FOR FREE</p>
                                <div class="wlogo">
                                    <a href="<?php echo HTTPS . website_url; ?>">
                                        <img src="<?php echo HTTPS . website_url; ?>assets/front/images/winipad/whitelogo.png" class="img-responsive"  alt="logo">
                                    </a>
                                </div>
                                <div class="tablet">
                                    <img src="<?php echo HTTPS . website_url; ?>assets/front/images/winipad/tablet.png" class="img-responsive"  alt="tablet">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pl0">
                            <div class="rwraaper">
                                <div class="hu-tag">
                                    <img src="<?php echo HTTPS . website_url; ?>assets/front/images/winipad/hu-tag.png"  alt="tag">
                                </div>
                                <p class="ftitle">
                                    <strong>Register</strong> on <i>DOUKANI.COM</i> now for a chance to win
                                    a <strong>iPad</strong> in our <strong>Lucky Draw</strong>
                                </p>
                                <?php if (validation_errors() != false) { ?>
                                    <div class='alert alert-info text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo validation_errors(); ?>
                                    </div>
                                <?php } ?>	
                                <?php if (isset($msg) && !empty($msg)): ?>
                                    <div class='alert <?php echo $msg_class; ?> text-center'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <?php echo $msg; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($this->session->flashdata('msg5') != ''): ?>
                                    <div class='alert  alert-success'>
                                        <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                        <center><?php echo $this->session->flashdata('msg5'); ?></center>
                                    </div>
                                <?php endif; ?>	
                                <div class="rform">
                                    <form name="registration" id="registration" method='post'>
                                        <input type="text" placeholder="Your Name" name="name" id="name" value="<?php echo set_value('name'); ?>" />
                                        <br><br>
                                        <input type="email" placeholder="Email Address" name="email_id" id="email_id" value="<?php echo set_value('email_id'); ?>" />
                                        <span id="email_status"></span>
                                        <br><br>   
                                        <br>
                                        <div class="form-group" style="float: left;">    
                                            <input type="checkbox" name="term_condition" id="term_condition" checked value="1">  Yes, I agree with <a href="javaacript:void(0)" data-toggle="modal" data-target="#modalRegister"><span><?php echo $term_link->page_title; ?></span></a>
                                            <div></div>
                                        </div>
                                        <button type="submit" name="register" id="register" class="btn signupbtn">Register</button>
                                    </form>
                                </div> 
                                <p class="btitle">Download <span>DOUKANI</span> App on your <i>IOS</i> or <i>Android</i> phone now!</p>
                                <div class="storebtnwrraper">
                                    <a href="<?php echo $iphone_app; ?>"><img src="<?php echo HTTPS . website_url; ?>assets/front/images/winipad/app-store.png"   alt="appstorebtn"></a>
                                    <a href="<?php echo $android_app; ?>"><img src="<?php echo HTTPS . website_url; ?>assets/front/images/winipad/google-play.png"  alt="appstorebtn"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalRegister" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title" style="text-align-last: center">Terms and Conditions</h2>
                    </div>
                    <div class="modal-body">
                        <p> 1. There is no entry fee and no purchase necessary to enter this competition. </p>
                        <p> 2. Route to entry for the competition and details of how to enter are via&nbsp;https://doukani.com/winipad. </p>
                        <p>3. Closing date for entry will be 23:59 on Sunday, 8th October 2017. After this date, no further entries to the competition will be permitted.</p>
                        <p>4. No responsibility can be accepted for entries not received for whatever reason.</p>
                        <p>5. The prize draw will take place on Sunday, 8th October 2017.</p>
                        <p>6. The promoter reserves the right to cancel or amend the competition and these terms and conditions without notice in the event of a catastrophe, war, civil or military disturbance, act of God or any actual or anticipated breach of any applicable law or regulation or any other event outside of the promoter's control. Any changes to the competition will be notified to entrants as soon as possible by the promoter.</p>
                        <p>7. The promoter is not responsible for inaccurate prize details supplied to any entrant by any third party connected with this competition.</p>
                        <p>8. No cash alternative to the prize will be offered. The prize is not transferable. Prizes are subject to availability and we reserve the right to substitute any prize with another of equivalent value without giving notice.</p>
                        <p>9. The winner will be chosen at random using random winner generating software from all entries received and verified by the promoter and or its agents.</p>
                        <p>10. The winner will be notified by email within 1 day of the prize draw date. If the winner cannot be contacted or does not claim the prize during the event, we reserve the right to withdraw the prize from the winner and pick a replacement winner.</p>
                        <p>11. The promoter's decision in respect of all matters to do with the competition will be final and no correspondence will be entered into.</p>
                        <p>12. By entering this competition, an entrant is indicating his/her agreement to be bound by these terms and conditions.</p>
                        <p>13. The competition and these terms and conditions will be governed by UAE law and any disputes will be subject to the exclusive jurisdiction of the courts of UAE.</p>
                        <p>14. The winner agrees to the use of his/her name and image in any publicity material. Any personal data relating to the winner or any other entrants will be used solely in accordance with current UAE data protection legislation and will not be disclosed to a third party.</p>
                        <p>15. Entry into the competition will be deemed as acceptance of these terms and conditions.</p>
                        <p>16. This promotion is in no way sponsored, endorsed or administered by, or associated with, Facebook, Twitter or any other social network. You are providing your information to Doukani.com and not to any other party. The information provided will be used in conjunction with the following Privacy Policy found at&nbsp;https://doukani.com/terms-and-conditions. </p>
                        <p>17. We are not connected or affiliated with Apple in any way. We are simply huge fans of their products, use them ourselves and wanted to give our community an awesome prize.</p>

                        <?php // echo $term_link->page_content; ?>
                    </div>
                    <div class="rform" style="margin: 0;">
                        <div class="modal-footer">
                            <button type="button" class="btn signupbtn" data-dismiss="modal" style="width: 20%;">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <?php $this->load->view('include/footer-bar'); ?>
        </footer>

    </body>
    <script>
        var flag1 = '';
        $(document).on("change", "#email_id", function (e) {
            var email_id = $(this).val();
            if (email_id) {
                $.ajax({
                    type: 'post',
                    url: '<?php echo site_url() . 'home/check_email_id' ?>',
                    data: {
                        email_id: email_id
                    },
                    success: function (response) {
                        if (response == "OK") {
                            $('#email_status').html('');
                            flag1 = 0;
                            return true;
                        } else {
                            flag1 = 1;
                            $('#email_status').html('<font color="#b94a48">' + response + '</font>');
                            return false;
                        }
                    }
                });
            } else {
                $('#email_status').html("");
                return false;
            }
        });

        $("#registration").validate({
            errorPlacement: function (error, element) {
                if (element[0]['id'] == "term_condition") {
                    error.insertAfter(element.siblings('div')); // select2
                } else {
                    error.insertAfter(element);

                }

            },
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 30
                },
                email_id: {
                    required: true,
                    email: true
                },
                term_condition: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Please enter Name",
                    minlength: "Name should be of minimum 3 characters",
                    maxlength: "Name should be of maximum 30 characters"
                },
                email_id: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address"
                },
                term_condition: {
                    required: "Please check the Terms and Conditions"
                },
            },
            submitHandler: function (form) {
                if (flag1 == 0) {
                    form.submit();
                }
            }
        });
    </script>
</html>