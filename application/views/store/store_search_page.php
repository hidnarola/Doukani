<!DOCTYPE html>
<html lang="en">
    <head>    
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <style>
            .modal-header{
                background-color:#ed1b33;
                color:white;
            }
        </style> 
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="store-pages search-list-page">
                <div class="container">
                    <div class="row">
                        <?php $this->load->view('include/sub-header'); ?>
                        <div class="mainContent">               
                            
                                    <div class="store-list">
                                        <div class="gray-box">
                                            <div class="store-category-head">
                                                <h1 class="wrap-title">Search Stores</h1>
                                            </div>
                                    <input type="hidden" name="filters" id="filters" value="<?php if (isset($_POST['search_value'])) echo $_POST['search_value']; ?>">
                                    <div class="store_search_page store-listing" id="reset_data">
                                        <ul class="store-list">
                                            <?php $this->load->view('store/store_grid_view'); ?>
                                            <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                        <?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_store" value="0">Load More</button><br><br><br>
                                            </div>
                                        <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                                </div>
                        </div>   
                    </div>
                </div>
            </div>
            <?php $this->load->view('include/footer'); ?>
            <div id="loading" style="text-align:center" class="loader_display">
                <img id="loading-image1" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." />
            </div>
        </div>   
        <script>
            jQuery(document).on('mouseenter', ".following1", function (event) {
                $(this).text('Un-follow');
            });

            jQuery(document).on('mouseout', ".following1", function (event) {
                $(this).text('Following');
            });

            jQuery(document).on('mouseenter', ".following", function (event) {
                $(this).text('Un-follow');
            });

            jQuery(document).on('mouseout', ".following", function (event) {
                $(this).text('Following');
            });
            $(document).ready(function () {

                $('.store-individual-user-social-toggle').click(function () {
                    $('.store-individual-user-social ul').slideToggle();
                });
                $('.store-individual-user-right-toggle').click(function () {
                    $('.store-individual-user-right > ul').slideToggle();
                });

                $('.menu-wrapper').css('max-height', '322px');
            });

            function load_more_data() {

                $("#load_store").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
                $('#load_store').prop('disabled', true);
                
                var load_more_status = $('#load_more_status').val();
                var search = $('#filters').val();
                var url = "<?php echo base_url(); ?>allstores/load_more_stores/";
                var start = $("#load_store").val();
                var search_store = 'search_store';

                start++;

                $("#load_store").val(start);
                var val1 = start;

                if(load_more_status=='false') {
                    $.post(url, {value: val1, search_word: search, search_store: search_store,state_id_selection:state_id_selection}, function (response)
                    {
                        $('#load_more_status').val(response.val);
                        
                        $("#load_more").before(response.html);
                        if (response.val == "true") {
                            $("#load_store").hide();
                        }
                        
                        $('#load_store').prop('disabled', false);
                        $("#load_store").html('Load More');
                        
                    }, "json");
                }
            }
        </script>
    </body>
</html>