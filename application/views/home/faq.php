<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <meta name="keywords" content="<?php echo $page->page_meta_keyword; ?>" />
        <meta name="description" content="<?php echo $page->page_meta_desc; ?>" />
        <meta name="title" content="<?php echo $page->page_meta_title; ?>" />

        <style> 
            .accordion-toggle:hover {
                color:#ed1b33 !important;
            }
            .panel-default > .panel-heading {
                background-color:#f5f5f5 !important;
            }
            .white{
                background-color:#eeeeee !important;
                padding-top:50px;
                padding-bottom:50px;
                padding-right:50px;
                padding-left:50px;
            } 
        </style>
    </head>
    
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="page">       
                <div class="container">
                    <div class="row">

                        <?php $this->load->view('include/sub-header'); ?>						
                        <div class="col-sm-12 main category-grid">			                  				
                            <?php $this->load->view('include/left-nav'); ?>
                            <div class="col-sm-9 ContentRight ">
                                <div class="row subcat-div">
                                    <div class="col-sm-9">
                                        <?php $this->load->view('include/breadcrumb'); ?>
                                    </div>
                                </div>
                                <div class="box-contentOuter ">
                                    <h1><?php echo $page->sub_title; ?></h1>
                                    <div class="box-content postadBG FAQ-accordion">
                                        <div class="col-sm-12 ">
                                            <div class="panel-group" id="accordion">
                                                <?php
                                                if (sizeof($faq) > 0) {
                                                    $cnt = 0;
                                                    foreach ($faq as $f) {
                                                        ?>					
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <a class="accordion-toggle" data-toggle="collapse"   style="text-decoration:none;" href="#<?php echo $f['faq_id']; ?>" data-parent="#accordion">
                                                                <div class="panel-title">
                                                                <div><?php echo $f['question']; ?><i class="indicator glyphicon glyphicon-chevron-up  pull-right"></i></div>    		
                                                                </div>
                                                                    </a>
                                                            </div>						
                                                            <div id="<?php echo $f['faq_id']; ?>" class="panel-collapse collapse <?php if ($cnt == 0) echo 'in'; ?>">
                                                                <div class="panel-body">
        <?php echo $f['answer']; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        $cnt++;
                                                    }
                                                }
                                                ?>						
                                            </div>					
                                        </div>
                                        <div class="clearfix"></div>

                                    </div>						
                                </div>
                            </div>				
                        </div>				
                    </div>			
                </div>			
            </div>			
        </div>

<?php $this->load->view('include/footer'); ?> 
        <script>
            function toggleChevron(e) {
                $(e.target)
                        .prev('.panel-heading')
                        .find("i.indicator")
                        .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
            }
            $('#accordion').on('hidden.bs.collapse', toggleChevron);
            $('#accordion').on('shown.bs.collapse', toggleChevron);
        </script>
    </body>
</html>