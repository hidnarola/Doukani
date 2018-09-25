<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <?php $protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === FALSE ? 'http' : 'https'; ?>
        <meta property="og:type" content="article" />
        <meta property="og:site_name" content="Doukani" />
        <meta property="og:title" content="<?php echo $store[0]->store_name; ?>" />
        <meta property="og:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta property="og:image" content="<?php echo $share_url; ?>" />
        <meta property="og:description" content="<?php echo $store[0]->store_description; ?>" />
        <meta name="twitter:card" content="summary">
        <meta name="twitter:site" content="Doukani">
        <meta name="twitter:url" content="<?php echo $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
        <meta name="twitter:title" content="<?php echo $store[0]->store_name; ?>">
        <meta name="twitter:description" content="<?php echo $store[0]->store_description; ?>">
        <meta name="twitter:image:src" content="<?php echo $share_url; ?>">

        <link rel="image_src" href="<?php echo $share_url; ?>" />
        <script type="text/javascript">
            document.write('<style>.noscript { display: none; }</style>');
        </script>
        <script type="text/javascript" src="<?php echo HTTP . website_url; ?>assets/front/javascripts/buttons.js"></script>
        <script type="text/javascript">stLight.options({publisher: "e16e028e-6148-4bb8-9d36-8ddd8927b25b", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
        <style>
            .horizontalList{margin-left: auto;margin-right: auto;width: 80%; }
            .modal-header{background-color:#ed1b33;color:white;}            
        </style>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>			
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="store-details">
                    <div class="container">
                        <div class="row">
                            <?php $this->load->view('include/sub-header'); ?>
                            <div class="mainContent">
                                <?php if (isset($_REQUEST['s'])) { ?>
                                    <input type="hidden" name="s" id="search_value1" value="<?php echo $_REQUEST['s']; ?>">
                                <?php } ?> 
                                <input type="hidden" name="search" id="search">
                                <input type="hidden" name="product_view" id="product_view" value="grid">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $store[0]->store_owner; ?>">
                                <?php $this->load->view('store/store_common'); ?>                        
                                <div class="store-products-wrapper">
                                    <div class="store-products-head">
                                        <h2><?php echo $store[0]->store_name . '\'s Store'; ?></h2>
                                        <br><br>
                                        (Since <?php echo $store_user_regidate; ?>)                              
                                    </div>

                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $store_user[0]->user_id; ?>">
                                    <div class="catlist">
                                        <h3>Search Result</h3>
                                        <div class="col-sm-12 text-right views">
                                            <?php 
                                                $path = $store_url.'search/';
                                                $grid_path = $path;
                                                $list_path = $path;
                                                   
                                                if(isset($_REQUEST['s'])) {
                                                    $path .= '?s='.$_REQUEST['s'];
                                                    $list_path = $path.'&view=list';
                                                    $grid_path = $path;
                                                }                                                
                                            ?>
                                            <a href="<?php echo $grid_path; ?>" class="product_view grid view-active" data-id="grid"><span class="fa fa-th"></span></a>                                                
                                            <a href="<?php echo $list_path; ?>" class="product_view list" data-id="list"><span class="fa  fa-th-list"></span></a>                                            
                                        </div>
                                        <div class="store-products-list-wrapper" id="reset_data">
                                            <?php 
                                            if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list')    
                                                $this->load->view('store/store_product_list_view'); 
                                            else    
                                                $this->load->view('store/product_store_grid_view'); 
                                            ?>
                                            <!--item1-->
                                            <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                            <?php if (@$hide == "false") { ?>
                                                <div class="col-sm-12 text-center" id="load_more">
                                                    <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br><br>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loading" style="text-align:center" class="loader_display">
                <img id="loading-image1" src="<?php echo HTTPS . website_url; ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
            </div>
            <?php $this->load->view('store/store_common_div'); ?>
            <?php $this->load->view('include/footer'); ?>         
        </div>
        <?php $mypath_ = $store_url; ?>
        <script type="text/javascript">
            
            function load_more_data()
            {
                $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_product').prop('disabled', true);
                var load_more_status = $('#load_more_status').val();
<?php
$mypath_ = $store_url;
?>
                var url = "<?php echo $mypath_; ?>home/more_search";
                var start = $("#load_product").val();
                start++;
                $("#load_product").val(start);
                var val = start;                
                var search_value1 = $("#search_value1").val();
                var view='';
                <?php if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                    view = 'list';
                <?php } ?>
                
                if(load_more_status=='false') {
                    $.post(url, {value: val, search_value1: search_value1,state_id_selection:state_id_selection,view:view}, function (response)
                    {
                        $('#load_more_status').val(response.val);

                        $("#load_more").before(response.html);
                        if (response.val == "true")
                            $("#load_product").hide();
                        
                        $('#load_product').prop('disabled', false);
                        $("#load_product").html('Load More');                        
                    }, "json");
                }
            }
            
        </script>
        <!--container-->
    </body>
</html>
