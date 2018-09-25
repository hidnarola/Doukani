<!DOCTYPE html>
<html lang="en">
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
                                    <h1><?php echo $page->sub_title; ?></h1>                                    
                                    <div class="lipsum postadBG">
                                        <div class="box-content ">
                                            <?php if($page->page_content!='') 
                                                    echo $page->page_content;
                                                else
                                                    echo '<p><big>Page content coming soon</big></p>';
                                            ?>
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