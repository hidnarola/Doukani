<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <link rel="stylesheet" href="<?php echo site_url(); ?>/assets/front/stylesheets/file_upload_css/style.css">
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/nanoscroller.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/emoji.css" rel="stylesheet">
    </head>
    <body class='contrast-fb store'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>
                                            <i class="fa fa-envelope-o"></i>
                                            <span>Messages Conversation</span>
                                        </h1>
                                    </div>
                                    <div class='title'>
                                        <h3><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h3>
                                    </div>
                                </div>
                            </div>
                            <div class='row'>
                                <form id="form1" name="form1" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                    <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                    <input type="submit" name="submit" id="submit">
                                </form>
                                <div class='col-sm-12 box' style='margin-bottom:0'>                        
                                    <div class='box'>
                                        <div class=''>                                            
                                            <?php
                                            echo '<b>Product: </b>' . $product_details[0]->product_name . '<br>';
                                            echo '<b>Price: </b>' . $product_details[0]->product_price . ' AED<br>';
                                            echo '<b>Status:</b> ' . $product_details[0]->product_is_inappropriate;
                                            ?>
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>                                    
                                    <div class='box-content box-double-padding ' style="background: #ECECEC;">    
                                        <div class="box-content postadBG FAQ-accordion">

                                            <div class="col-sm-12 ">

                                                <div id="accordion" class="panel-group">     
                                                    <?php
                                                    if (sizeof($sender_details) > 0) {
                                                        $i = 0;
                                                        foreach ($sender_details as $del) {
                                                            $i++;
                                                            ?>
                                                            <div class="panel panel-default panel_<?php echo $del['uid']; ?>_<?php echo $del['product_posted_by']; ?>_<?php echo $del['product_id']; ?>" id="<?php echo $i; ?>" >                                         
                                                                <div class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-parent="#accordion" href="#div<?php echo $i; ?>" style="text-decoration:none;" data-toggle="collapse" class="accordion-toggle">

                                                                            <div>
                                                                                <?php
                                                                                $profile_picture = $this->dbcommon->load_picture($del['upick'], $del['ufb'], $del['utwi'], $del['uname'], $del['ugoo'], 'small');
                                                                                ?>
                                                                                <div class="col-sm-12 text-left ">
                                                                                    <input type="hidden" name="buyer_id<?php echo $i; ?>" id="buyer_id<?php echo $i; ?>" value="<?php echo $del['uid']; ?>">
                                                                                    <input type="hidden" name="product_owner<?php echo $i; ?>" id="product_owner<?php echo $i; ?>" value="<?php echo $del['product_posted_by']; ?>">
                                                                                    <input type="hidden" name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>" value="<?php echo $del['product_id']; ?>">
                                                                                    <div class="alert alert-info alert-dismissable">
                                                                                        <span class="user-img-t">
                                                                                            <img src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url(); ?>assets/upload/avtar.png'" height="" width="">
                                                                                            <input type="hidden" name="buyer_id<?php echo $i; ?>" id="buyer_id<?php echo $i; ?>" value="<?php echo $del['uid']; ?>">
                                                                                            <input type="hidden" name="product_owner<?php echo $i; ?>" id="product_owner<?php echo $i; ?>" value="<?php echo $del['product_posted_by']; ?>">
                                                                                            <input type="hidden" name="product_id<?php echo $i; ?>" id="product_id<?php echo $i; ?>" value="<?php echo $del['product_id']; ?>">
                                                                                        </span>
                                                                                        Username:<?php echo $del['uname']; ?><br>
                                                                                        Nickname:<?php
                                                                        echo $del['unick'];
                                                                        // print_r($del);
                                                                                ?>
                                                                                    </div>
                                                                                </div>
                                                                                <i class="indicator glyphicon glyphicon-chevron-up  pull-right"></i>
                                                                            </div>
                                                                        </a>        
                                                                    </h4>                           
                                                                </div>                      
                                                                <div class="panel-collapse collapse <?php if ($i == 1) //echo 'in';     ?>" id="div<?php echo $i; ?>">
                                                                    <div class="panel-body">
                                                                        <div id="loading_<?php echo $del['uid']; ?>" style="text-align:center;display:none;">
            <img id="loading-image" src="<?php echo static_image_path; ?>ajax-loader.gif" alt="Loading..." />
        </div>
                                                                        <div id="load_data<?php echo $i; ?>" class="clear_data"></div>
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                        <?php }
                                                    }
                                                    ?>
                                                    <br>
                                                    <br>
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>   
                                                    </div>  
                                                </div>
                                            </div>
                                            <br>
                                                <br>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="col-sm-4">
                                                            <label>Per page : </label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select name="per_page1" id="per_page1" class="form-control" >                                              
                                                                <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '10') ? 'selected' : ''; ?>>10</option>    
                                                                <option value="25" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '25') ? 'selected' : ''; ?>>25</option>
                                                                <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '50') ? 'selected' : ''; ?>>50</option>
                                                                <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '100') ? 'selected' : ''; ?>>100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <br>
                                            <div class="clearfix"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="modal fade center" id="alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-md">
            <div class="modal-content rounded">
               <div class="modal-header text-center orange-background">
                  <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                  <h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
               </div>
               <div class="modal-body">
                  <div class="FeaturedAds-popup">
                     <form action='' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form">
                        <div class='box-content control'>
                           <div class='form-group '>
                              <font color="red" ><span id="error_msg" ></span></font>
                           </div>
                           <div class="margin-bottom-10"></div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
        </div>
        
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/nanoscroller.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/tether.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/util.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/config.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/jquery.emojiarea.js"></script>
        <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/emoji-picker.js"></script>
        <!--<script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script>-->
        <script>
            $(document).find('#per_page1').on('change', function () {
                var per_page = $(this).val();
                console.log(per_page);
                $('#per_page').val(per_page);
                $(document).find('#submit').click();
            });
                                        
            $('.panel-default').on('shown.bs.collapse', function (e) {
                $('.clear_data').html();
                $("#load_data" + e.currentTarget.id).text('');
                $("#load_data" + e.currentTarget.id).val('');
                $("#load_data" + e.currentTarget.id).html('');
                $("#load_data" + e.currentTarget.id).before('');

                var value = e.currentTarget.id;
                var product_id = $("#product_id" + value).val();
                var buyer_id = $("#buyer_id" + value).val();
                var product_owner = $("#product_owner" + value).val();
                
                $body = $("body");
                $body.addClass("loading");
                
                $('#loading_'+buyer_id).show();

                var url = "<?php echo base_url(); ?>admin/conversation/buyer_seller_conversation";

                $.post(url, {product_id: product_id, buyer_id: buyer_id, product_owner: product_owner}, function (response)
                {
                    $('#loading_'+buyer_id).hide();
                    $("#load_data" + e.currentTarget.id).html(response.html);

                    $('.chat_msg2').attr("data-emojiable", "true");
                    return false;
                }, "json");
            });
            $(function () {
                // Initializes and creates emoji set from sprite sheet
                window.emojiPicker = new EmojiPicker({
                    emojiable_selector: '[data-emojiable=true]',
                    assetsPath: '<?php echo base_url(); ?>assets/front/stylesheets/emojis/img',
                    popupButtonClasses: 'fa fa-smile-o'
                });

                window.emojiPicker.discover();
            });
        </script>
    </body>
</html>