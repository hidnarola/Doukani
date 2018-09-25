<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <meta name="keywords" content="<?php echo $page->page_meta_keyword; ?>" />
        <meta name="description" content="<?php echo $page->page_meta_desc; ?>" />
        <meta name="title" content="<?php echo $page->page_meta_title; ?>" />
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>       
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main category-grid">			
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>
                            <!--//cat-->
                            <div class="col-sm-9 ContentRight">
                                <div class="row subcat-div">
                                    <div class="col-sm-9">
                                        <?php $this->load->view('include/breadcrumb'); ?>
                                    </div>
                                </div>
                                <div class="box-contentOuter">
                                    <h1>
                                        <?php echo $page->sub_title; ?></h1>
                                    <div class="lipsum postadBG">
                                        <div class="box-content ">
                                            <?php echo $page->page_content; ?>
                                        </div>
                                        <div class='post-prod' >
                                            <form  name="default_form" class='form form-horizontal default_form validate-form' accept-charset="UTF-8" method='post'  id="form1">
                                                <div class='form-group'>
                                                    <label class="control-label col-sm-3 col-sm-3">Name <span> *</span>
                                                    </label>
                                                    <div class="col-sm-4 controls">
                                                        <input placeholder='Name' class="form-control" name="name" type='text' id="name" onkeyup="isChar();" data-rule-required='true'/>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class="control-label col-sm-3 col-sm-3">Email Id <span> *</span>
                                                    </label>
                                                    <div class="col-sm-4 controls">
                                                        <input placeholder='Email Id ' class="form-control" name="email_address" type='text' id="email_address" data-rule-required='true'/>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class="control-label col-sm-3 col-sm-3">Subject <span> *</span>
                                                    </label>
                                                    <div class="col-sm-4 controls">
                                                        <input placeholder='Subject' class="form-control" name="title" id="title" type='text' data-rule-required='true'/>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class="control-label col-sm-3 col-sm-3">Message <span> *</span>
                                                    </label>
                                                    <div class='col-sm-4 controls'>
                                                        <textarea class="form-control" id="desc" placeholder="Message" name="desc" rows="3" data-rule-required='true'></textarea>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="form-actions form-actions-padding-sm">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-10 col-md-offset-2">
                                                                                                            <button class='btn mybtn contact-us-btn' type='submit' id="submitHandler" name="submit">
                                                                                                                Send
                                                                                                            </button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>-->

                                                <div class="form-actions" style="margin-bottom:0">
                                                    <div class="row">
                                                        <div class="col-sm-9 col-sm-offset-3">
                                                            <button class='btn mybtn contact-us-btn' type='submit' id="submitHandler" name="submit">
                                                                Send
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>
                                    </div>						
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>  
            </div>  
        </div>
        <?php $this->load->view('include/footer'); ?>
    </body>
</html>