<!doctype html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />        
        <title>Doukani</title>
        <link href="<?php echo site_url(); ?>assets/landing/bootstrap.css" rel="stylesheet" />
        <link href="<?php echo site_url(); ?>assets/landing/coming-sssoon.css" rel="stylesheet" />
        <link href="<?php echo site_url(); ?>assets/landing/font-awesome.css" rel="stylesheet">
        <link href='<?php echo site_url(); ?>assets/landing/theme.css' rel='stylesheet' type='text/css'>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <nav class="navbar navbar-transparent navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand doukani_logo" href="../">Doukani</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">                     
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>					
        <div class="main" style="background-image: url('<?php echo site_url(); ?>assets/landing/video_bg.jpg')">
            <video id="video_background" preload="auto" autoplay="true" loop="loop" muted="muted" volume="0">
                <source src="https://coming-sssoon.paperplane.io/video/time.webm" type="video/webm">							
                <source src="https://coming-sssoon.paperplane.io/video/time.mp4" type="video/mp4">
                Video not supported
            </video>
            <div class="cover black" data-color="black"></div>                        
            <div class="container">
                <h1 class="logo cursive">
                    Stay tuned...
                </h1>
                <!--  H1 can have 2 designs: "logo" and "logo cursive"           -->

                <div class="content">
                    <h4 class="motto">We are coming soon...</h4>
                    <div class="subscribe">
                        <h5 class="info-text">
                            Send your Email Address, We will notify you when doukani.com will start
                        </h5>
                        <div class="userMessageDiv"></div>
                        <div class="row">

                            <div class="col-md-4 col-md-offset-4 col-sm6-6 col-sm-offset-3 ">
                                <form class="form-inline" role="form" name="default_form"  accept-charset="UTF-8" id="default_form" name="form"  method='post' >
                                    <label for="email_id" class="error info-text"></label>
                                    <div class="form-group">

                                        <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                        <input type="email" class="form-control transparent" placeholder="Your email here..." id="email_id" name="email_id">
                                    </div>
                                    <button type="submit" class="btn btn-warning btn-fill" name="submit" id="submit">Notify Me</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div class="container">
                    © 2010-2015 doukani.com. All rights reserved.
                </div>
            </div>
        </div>
    </body>					
    <script src="<?php echo site_url(); ?>assets/landing/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="<?php echo site_url(); ?>assets/landing/bootstrap.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/plugins/validate/jquery.validate.min.js"></script>
    <script>
        jQuery(document).on('submit', "#default_form", function (event) {
            send_email('default_form');
            event.preventDefault();
        });
        function send_email(formid) {
            jQuery.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>send_landing_email',
                data: new FormData($("#" + formid)[0]),
                async: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    var result = data.split("^");

                    if (result[0] == "0") {
                        jQuery('#' + formid + ' #loading').hide();
                        $(".userMessageDiv").html("");
                        var msg = '<div class="alert alert-danger"><button class="close" data-dismiss="alert"></button> Message was not sent</div>';
                        $(".userMessageDiv").html(result[1]);
                        $(".userMessageDiv").show();
                    } else {
                        var msg = '<div class="alert alert-success"><button class="close" data-dismiss="alert"></button> Sent successfully.</div>';
                        $(".userMessageDiv").html(msg);
                        $(".userMessageDiv").show();
                        jQuery('#' + formid + ' #loading').hide();
                        setTimeout(function () {
                            $(".userMessageDiv").hide();
                        }, 2000);
                    }
                }
            });
        }
        jQuery(document).ready(function ($) {
            $("#form").validate({
                rules: {
                    email_id: {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    email_id: {
                        required: "Please enter an email address",
                        email: "Please enter a valid email address"
                    }
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>				
</html>
