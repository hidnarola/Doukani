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
                <div class="form-holder col-md-6">
                    <div class="row">
                        <div class="col-md-12 pl0">
                            <div class="rwraaper">
                                <div class="hu-tag">
                                    <img src="<?php echo HTTPS . website_url; ?>assets/front/images/winipad/hu-tag.png"  alt="tag">
                                </div>
                                <p class="ftitle">
                                    <strong>Enter the unique verification code now for a chance to win
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
                                    <form name="verification" id="verification" method='post'>
                                        <input type="text" placeholder="Unique Code" name="unique_code" id="unique_code" value="<?php // echo set_value('unique_code'); ?>" />
                                        <br><br>  
                                       
                                        <button type="submit" name="save" id="save" class="btn signupbtn">Submit</button>
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
        <footer>
            <?php $this->load->view('include/footer-bar'); ?>
        </footer>
    </body>
    <script>
        var flag1 = '';
        $("#verification").validate({
            rules: {
                unique_code: {
                    required: true
                },
            },
            messages: {
                unique_code: {
                    required: "Please enter verification unique code"
                }
            },
            submitHandler: function (form) {
                if (flag1 == 0) {
                    form.submit();
                }
            }
        });
    </script>
</html>