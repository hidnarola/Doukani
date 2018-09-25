<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('include/head'); ?>	 
    </head>
    <body>
        <?php
        if (@$subcat_id == "")
            $subcat_id = 0;
        ?>
        <!--container-->
        <div class="container-fluid">                	
            <?php $this->load->view('include/header'); ?>        
            <?php $this->load->view('include/menu'); ?>        
            <div class=" page">
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
                            <!--content-->
                            <div class="col-sm-9 ContentRight">
                                <div class="subcat-div">
                                    <div class="content-top-option">
                                        <?php $this->load->view('home/category_common'); ?>
                                    </div>
                                    <?php $this->load->view('home/category_description'); ?>
                                    <div class="TagsList">                                    
                                        <?php if(isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {  ?>
                                        <?php } else {  ?>
                                        <div class="subcats cat_desc_div">
                                            <div class="col-sm-12 no-padding-xs">
                                                <div class="col-sm-12">
                                                    <?php 
                                                    $cat_inc = 0;
                                                    $count_cats  = count($subcat);
                                                        foreach ($subcat as $sub) {
                                                            if($cat_inc < 9) {
                                                    ?>
                                                        <div class="col-sm-6 col-md-6 col-lg-4">
                                                            <a href="<?php echo base_url() .emirate_slug .$sub['sub_category_slug'] . '/' . $category_view . $order_option; ?>" rel="nofollow"><?php echo $sub['name']; ?> <span class="count">(<?php echo $sub['total']; ?>)</span></a>
                                                        </div>
                                                    <?php } 
                                                    else { 
                                                        if($cat_inc==10) { ?>
                                                        <div class="col-sm-12 text-center" id="load_more1">
                                                            <button class="btn btn-blue cat_more_page" onclick="load_more_subcategories();" id="load_more_subcategories" value="0">Show More</button><br><br>
                                                            <br/>
                                                        </div>
                                                        <div class="col-sm-12 text-center" id="load_less">
                                                            <button class="btn btn-blue cat_more_page" onclick="load_less_subcategories();" id="load_less_subcategories" value="0">Show Less</button><br><br>
                                                            <br/>
                                                        </div>
                                                        <?php } }
                                                        $cat_inc++;
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }  ?>
                                    </div>
                                    <!--//content-->
                                </div>
                                <!--row-->
                                <div class="row <?php if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') echo'horizontalList';
                                else echo 'most-viewed'; ?>">
                                    <div class=" catlist">
                                        <?php 
                                            
                                            if(isset($_REQUEST['view']) && $_REQUEST['view']=='list')
                                                $this->load->view('home/product_listing_view');
                                            else 
                                                $this->load->view('home/product_grid_view'); 
                                            ?>
                                        <input type="hidden" name="load_more_status" id="load_more_status" value="<?php echo (isset($hide)) ? $hide : ''; ?>">
                                        <?php if (@$hide == "false") { ?>
                                            <div class="col-sm-12 text-center" id="load_more">
                                                <button class="btn btn-blue" onclick="load_more_data();" id="load_product" value="0">Load More</button><br><br><br>
                                            </div>
<?php } ?>                          
                                    </div>
                                </div>
                                <!--//-->
                                <!-- end product -->
                            </div>
                            <!--//content-->
                        </div>
                    </div>
                    <!--//main-->
                </div>
                <!--//body-->
            </div>
        <!--footer-->
        <?php $this->load->view('include/footer'); ?>
        <!--//footer-->
    
    <script type="text/javascript">

        function load_more_data() {

            $("#load_product").html('<i class="fa fa-empire fa-spin fa-fw"></i> &nbsp; Loading Data...');
            $('#load_product').prop('disabled', true);
            var load_more_status = $('#load_more_status').val();

                    <?php if (isset($_REQUEST['order'])) { ?>
                                    var order = '<?php echo $_REQUEST['order']; ?>';
                    <?php } else { ?>
                                    var order = '';
                    <?php } 
                    if (isset($_REQUEST['s'])) { ?>
                         var s = '<?php echo $_REQUEST['s']; ?>';   
                    <?php } else { ?>
                          var s = '';      
                    <?php } ?>
                        
                     var view='';
                    <?php if(isset($_REQUEST['view']) && $_REQUEST['view'] == 'list') { ?>
                        view = 'list';
                    <?php } ?>

            var url = "<?php echo base_url(); ?>home/load_more_category/<?php echo $category_id . "/" . @$subcat_id; ?>";
                    var start = $("#load_product").val();
                    start++;
                    $("#load_product").val(start);
                    var val = start;
                    if(load_more_status=='false') {
                        $.post(url, {value: val, order: order,s:s,state_id_selection:state_id_selection,view:view}, function (response)
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
    </div>
    <!--container-->
</body>
</html>