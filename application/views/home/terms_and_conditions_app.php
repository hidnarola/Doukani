<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <meta name="keywords" content="<?php echo $page_heading->page_meta_keyword; ?>" />
        <meta name="description" content="<?php echo $page_heading->page_meta_desc; ?>" />
        <meta name="title" content="<?php echo $page_heading->page_meta_title; ?>" />
        <style>
            label span {
                color:red;				
            }			
            .title {
                padding-top: 16px;
            }
            .ContentRight {
                width:100% !important;
            }
            .red-btn1 {
                max-width: 100px;
                padding: 8px 0 !important;
                text-align: center;
                width: 100%;
            }

            .red-btn1 {
                background-color: #ed1b33;
                color: #fff;
                padding: 8px 33px;
            }
        </style>
    </head>
    <body>	
<?php $this->load->view('include/google_tab_manager_head'); ?>        
        <div class="container-fluid">
            <div class="page">
                <div class="container">
                    <div class="row">                
                        <div class="col-sm-12 main category-grid">			                    
                            <div class="col-sm-9 ContentRight">
                                <!--//cat-->
                                <!--content-->
                                <div class="support">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a href="javascript:void(0);" id="btn-show"><label><?php echo $page_title; ?></label></a>	
                                            <div class='box postadBG'>                    
                                                <div class='box-content'>
                                                    <?php echo $page_heading->page_content; ?>
                                                </div>
                                            </div>
                                        </div>						
                                    </div>			
                                    <!--//content-->
                                </div>			
                            </div>
                        </div>
                    </div>  
                </div>  
            </div>  
            <!--//main-->
        </div>                        
    </div>		
</body>
</html>
