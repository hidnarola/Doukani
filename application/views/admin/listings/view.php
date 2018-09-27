<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <link href='<?php echo base_url(); ?>assets/admin/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>

        <link href='<?php echo base_url(); ?>assets/front/dist/css/Open_Sans.css' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="<?php echo site_url(); ?>/assets/front/stylesheets/file_upload_css/style.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/admin/stylesheets/blueimp/blueimp-gallery.min.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload.css">
        <link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-ui.css">
        <noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-noscript.css"></noscript>
        <noscript><link rel="stylesheet" href="<?php echo site_url(); ?>assets/front/stylesheets/file_upload_css/jquery.fileupload-ui-noscript.css"></noscript>

        <?php $this->load->view('admin/include/listing_script'); ?>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/theme.js" type="text/javascript"></script> 
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/vendor/jquery.ui.widget.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.iframe-transport.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/tmpl.min.js"></script>
        <script src="<?php echo site_url(); ?>/assets/admin/javascripts/blueimp/load-image.all.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/canvas-to-blob.min.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.iframe-transport.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-process.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-image.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-validate.js"></script>
        <script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/jquery.fileupload-ui.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style>
            canvas {display:none;}
        </style>
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-list-ol'></i>
                                    <span>Listings</span>
                                </h1>
                                <div class='pull-right'>                                  
                                    <?php
                                    $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                    $view_path = base_url() . "admin/classifieds/listings_edit/" . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6) . '/' . $page_redirect;
                                    ?>
                                    <a href='<?php echo $view_path; ?>' class="btn-primary btn-lg">
                                        <i class="fa fa-pencil"></i>&nbsp;Edit Ad
                                    </a>
                                </div>
                            </div>
                            <hr class="hr-normal">
                            <?php if (validation_errors() != false) { ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo validation_errors(); ?>                              
                                </div>                          
                            <?php } ?>
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <div class='title'>                         
                                <?php
                                if (isset($_GET['userid']) && $_GET['userid'] != '') {
                                    $res = $this->db->query('select email_id,username from user where user_id=' . $_GET['userid'])->row();
                                    if (isset($res)) {
                                        echo 'Email ID: <u>' . $res->email_id . '</u><br>';
                                        echo 'Username: ' . $res->username;
                                    } else
                                        redirect('admin/classifieds/listings/');
                                }
                                ?>
                            </div>
                            <?php
                            if (isset($_REQUEST['request_for']) && $_REQUEST['request_for'] == 'user' && isset($_REQUEST['userid']))
                                $myredirect_path = base_url() . 'admin/classifieds/listings_edit/' . $product[0]['product_id'] . '/?request_for=user&userid=' . $_REQUEST['userid'];
                            else
                                $myredirect_path = base_url() . 'admin/classifieds/listings_edit/' . $product[0]['product_id'];
                            ?> 
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='fa fa-info-circle'></div>
                                            View Listing
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>                                        
                                        <div class="col-md-12">
                                            <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Category<span> *</span></label>
                                                <div class='col-md-5' style="padding: 0px 12px 14px 6px;">
                                                    <select class="form-control" id="cat_id" name="cat_id" onchange="show_sub_cat(this.value);" <?php if (isset($user_category_id) && (int) $user_category_id > 0) echo 'disabled=disabled'; ?>>
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>" <?php
                                                            if ($cat['category_id'] == $product[0]['category_id'])
                                                                echo 'selected';
                                                            elseif (isset($user_category_id) && (int) $user_category_id > 0 && $user_category_id == $cat['category_id']) {
                                                                echo 'selected';
                                                            }
                                                            ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                                <?php endforeach; ?>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                            <div class='row'>
                                                <label class='col-md-2 control-label text-right' for='inputText1'>Sub Category<span> *</span></label>
                                                <div class='col-md-5' id="sub_cat_list" style="padding: 0px 12px 14px 6px;">
                                                    <select class="form-control" id="" name="sub_cat" <?php if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) echo 'disabled=disabled'; ?>>
                                                        <option value="">Select Sub Category</option>
                                                        <?php foreach ($sub_category as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>" <?php
                                                            if ($cat['sub_category_id'] == $product[0]['sub_category_id'])
                                                                echo 'selected';
                                                            elseif (isset($user_sub_category_id) && (int) $user_sub_category_id > 0)
                                                                echo set_select('sub_cat', $cat['sub_category_id'], TRUE);
                                                            ?>><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                                <?php endforeach; ?>
                                                    </select>                                                   
                                                    <label id="subcat_id_err" class="error" style="display:none;"><font color="#b94a48">This field is required.</font></label>
                                                </div>
                                            </div>
                                        </div>
                                        <form class='form form-horizontal' accept-charset="UTF-8" method='post'>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Product Posted Date</label>
                                                <div class='col-md-5 controls'>
                                                    <input class="form-control"  placeholder="Product Posted Date" value="<?php if (isset($product[0]['product_posted_time'])) echo $product[0]['product_posted_time']; ?>" type="text" />
                                                </div>
                                            </div>
                                            <?php if (!empty($product[0]['product_reposted_time']) && $product[0]['product_reposted_time'] != '0000-00-00 00:00:00') { ?>
                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Product Modified Date</label>
                                                    <div class='col-md-5 controls'>
                                                        <input class="form-control"  placeholder="Product Re-posted Date" value="<?php if (isset($product[0]['product_reposted_time'])) echo $product[0]['product_reposted_time']; ?>" type="text" />
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            if (!empty($product[0]['admin_modified_at']) && $product[0]['product_reposted_time'] != '0000-00-00 00:00:00') {
                                                ?>
                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Modified by Admin at</label>
                                                    <div class='col-md-5 controls'>
                                                        <input class="form-control"  placeholder="Modified by Admin at" value="<?php if (isset($product[0]['admin_modified_at'])) echo $product[0]['admin_modified_at']; ?>" type="text" />
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Total Views</label>
                                                <div class='col-md-5 controls'>                                                    
                                                    <input class="form-control"  placeholder="Total Views" value="<?php echo $product[0]['product_total_views']; ?>" type="text" />                                                                       
                                                </div>                                                
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Total Likes</label>
                                                <div class='col-md-5 controls'>
                                                    <?php $count = $this->product->get_product_like_users($product[0]['product_id'], NULL, 'yes'); ?>
                                                    <input class="form-control"  placeholder="Total Likes" value="<?php echo $count; ?>" type="text" />                                                                       
                                                </div>                                                
                                            </div>

                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Users List who liked this product</label>
                                                <div class='col-md-5 controls'>
                                                    <a href='<?php echo base_url() . 'admin/classifieds/like_user_list/' . $product[0]['product_id']; ?>' class="btn btn-primary" target="_blank">
                                                        <i class="fa fa-users"></i>&nbsp;Users List
                                                    </a>                                    
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Total Favorites</label>
                                                <div class='col-md-5 controls'>
                                                    <?php $count = $this->product->get_product_favorite_users($product[0]['product_id'], NULL, 'yes'); ?>
                                                    <input class="form-control"  placeholder="Total Favorites" value="<?php echo $count; ?>" type="text" />
                                                </div>
                                            </div>                                                                                        
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Users List who made their favorite</label>
                                                <div class='col-md-5 controls'>
                                                    <a href='<?php echo base_url() . 'admin/classifieds/favorite_user_list/' . $product[0]['product_id']; ?>' class="btn btn-primary" target="_blank">
                                                        <i class="fa fa-users"></i>&nbsp;Users List
                                                    </a>
                                                </div>
                                            </div>
                                            <?php if (isset($productowner_role) && $productowner_role == 'storeUser') { ?>
                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Stock Availability</label>
                                                    <div class='col-md-5 controls'>
                                                        <input class="form-control"  placeholder="Stock Availability" value="<?php if (isset($product[0]['stock_availability'])) echo $product[0]['stock_availability']; ?>" type="text"/>
                                                    </div>
                                                </div>
                                            <?php } ?>  
                                        </form>
                                        <!--===================== DEFAULT FORM ======================-->
                                        <?php //if($product_type=='default'){  ?>

                                        <?php
                                        $this->load->view('admin/listings/edit_forms/form1_default');
                                        ?>
                                        <?php //}else if($product_type=='vehicle'){  ?>
                                        <!--=========================== VEHICLE FORM =============================-->
                                        <?php
                                        $this->load->view('admin/listings/edit_forms/form2_vehicle');
                                        ?>

                                        <?php //}else if($product_type=='real_estate'){  ?>
                                        <!--================= REAL ESTATE HOUSES FORM ===================-->
                                        <?php
                                        $this->load->view('admin/listings/edit_forms/form3_realestate1');
                                        ?>
                                        <!--================= REAL ESTATE SHARED ROOMS FORM ===================-->
                                        <?php
                                        $this->load->view('admin/listings/edit_forms/form4_realestate2');
                                        ?>                
                                        <!--  ===========================  Car Number    ===========================  - -->
                                        <?php
                                        $this->load->view('admin/listings/edit_forms/form5_car_number');
                                        ?>  
                                        <!--  ===========================  Mobile Number    ===========================  - -->
                                        <?php
                                        $this->load->view('admin/listings/edit_forms/form6_mobile_number');
                                        ?>  


                                        <?php //}  ?>
                                        <form id="fileupload" action="<?php echo base_url() . 'uploads/index/'; ?>" method="POST" enctype="multipart/form-data">
                                            <h4><i class="fa fa-image"></i>&nbsp;&nbsp;Upload Media</h4>
                                            <hr />      
                                            <span id="error_img" style="color:red"></span>      
                                            <div class='form-group'>                        
                                                <?php if (!empty($product[0]['product_image'])): ?>
                                                    <div class='form-group img-div005' style="display: inline-block;vertical-align: top;">
                                                        <div class='gallery'>                                                   
                                                            <ul class='list-unstyled list-inline'>
                                                                <li>
                                                                    <div class='picture'>      
                                                                        <?php
                                                                        if (!empty($product[0]['product_image'])) {
                                                                            $load_img = base_url() . product . "original/" . $product[0]['product_image'];
                                                                            $img_url = base_url() . product . "medium/" . $product[0]['product_image'];
                                                                        } else {
                                                                            $load_img = site_url() . '/assets/upload/No_Image.png';
                                                                            $img_url = site_url() . '/assets/upload/No_Image.png';
                                                                        }
                                                                        ?>
                                                                        <a data-lightbox='flatty' href='<?php echo $load_img; ?>'>
                                                                            <img alt="product Image" src="<?php echo $img_url; ?>" width="150px" height="150px" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'"/>
                                                                        </a>                                                                
                                                                    </div>                          
                                                                </li >
                                                            </ul>                       
                                                        </div>                              
                                                    </div>
                                                <?php endif; ?>                                             

                                            </div>
                                            <div class="form-group img-div006" >                         
                                                <div class='gallery'>                                                 
                                                    <ul class='list-unstyled list-inline'>
                                                        <?php foreach ($images as $i): ?>  
                                                            <li>                                                  
                                                                <div class='picture'>  
                                                                    <?php
                                                                    if (!empty($i['product_image'])) {
                                                                        $load_img = base_url() . product . "original/" . $i['product_image'];
                                                                        $img_url = base_url() . product . "medium/" . $i['product_image'];
                                                                    } else {
                                                                        $load_img = site_url() . '/assets/upload/No_Image.png';
                                                                        $img_url = site_url() . '/assets/upload/No_Image.png';
                                                                    }
                                                                    ?>
                                                                    <a data-lightbox='flatty' href="<?php echo $load_img; ?>">
                                                                        <img alt="product Image" src="<?php echo $img_url; ?>" width="150px" height="150px" onerror="this.src='<?php echo thumb_start_grid . base_url(); ?>assets/upload/No_Image.png<?php echo thumb_end_grid; ?>'">
                                                                    </a>                                 
                                                                </div>                          
                                                            </li>      
                                                        <?php endforeach; ?>                        
                                                    </ul>                       
                                                </div>                        
                                            </div>

                                            <div class="form-group" style="margin-top:20px;<?php
                                            if (isset($product[0]['video_name']) && $product[0]['video_name'] != '')
                                                echo '';
                                            else
                                                echo 'display:none;';
                                            ?>" >                           
                                                     <?php if ($product[0]['video_name'] != '') { ?>    
                                                    <div class="video-uploaded-div">
                                                        <video width="400" controls>                                      
                                                            <source src="<?php echo base_url() . product . 'video/' . $product[0]['video_name']; ?>" type="video/webm">
                                                            <source src="<?php echo base_url() . product . 'video/' . $product[0]['video_name']; ?>" type="video/mp4">
                                                            <source src="<?php echo base_url() . product . 'video/' . $product[0]['video_name']; ?>" type="video/ogg">
                                                            <source src="<?php echo base_url() . product . 'video/' . $product[0]['video_name']; ?>" type="application/ogg">

                                                            Your browser does not support HTML5 video.
                                                        </video> <a style="cursor:pointer;" class="" onclick="javascript:mydeletevideo('<?php echo $product[0]['product_id']; ?>', '<?php echo $product[0]['video_name']; ?>');"><i class="fa fa-trash"></i></a>
                                                    </div>  
                                                <?php } ?>  
                                            </div>  
                                            <div class="clearfix"></div>                    
                                        </form>
                                        <div class="form-actions form-actions-padding-sm btn-btm-css">
                                            <div class="row">
                                                <div class="col-md-10 col-md-offset-2">
                                                    <?php
                                                    if (isset($_REQUEST['userid']) && $_REQUEST['userid'] != '') {
                                                        $page_redirect = (isset($_GET['page'])) ? '&page=' . $_GET['page'] : '';
                                                        $redirect_path = base_url() . "admin/classifieds/" . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . '?request_for=user&userid=' . $_REQUEST['userid'] . $page_redirect;
                                                    } else {
                                                        $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                        $redirect_path = base_url() . "admin/classifieds/" . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $page_redirect;
                                                    }
                                                    ?>
                                                    <a href='<?php echo $redirect_path; ?>' title="Back" class="btn-primary btn-lg">Back</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>

        <?php //$this->load->view('admin/include/footer-script');    ?>        
        <script>
            var emirate_url = "<?php echo base_url() ?>admin/classifieds/show_emirates_postadd";
            var plate_prefix_url = "<?php echo base_url(); ?>admin/classifieds/show_prefix";
        </script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/listing_common.js" type="text/javascript"></script>
        <script type="text/javascript">

            var val = $('#cat_id').val();
            var subval = $('#sub_cat').val();

            var base_url = "<?php echo base_url(); ?>admin/";

            $(document).ready(function () {
                setTimeout(function () {
                    $(document).find('#sub_cat').attr('disabled', true);

<?php if (isset($user_sub_category_id) && (int) $user_sub_category_id > 0) { ?>
                        show_sub_cat_fields("<?php echo $user_sub_category_id; ?>");
<?php } else { ?>
                        var subval = $(document).find('#sub_cat').val();
                        show_sub_cat_fields(subval);
<?php } ?>
                }, 1000);
            });

            function isNumber1(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
                    return false;
                }
                return true;
            }


            $("#video_form1").val("");
            $("#video_form2").val("");
            $("#video_form3").val("");
            $("#video_form4").val("");
            $("#video_form5").val("");
            $("#video_form6").val("");

            $("#form1_images_arr").val("");
            $("#form2_images_arr").val("");
            $("#form3_images_arr").val("");
            $("#form4_images_arr").val("");
            $("#form5_images_arr").val("");
            $("#form6_images_arr").val("");


            function show_hide(a)
            {
                if (a == 1) {
                    //alert("1");                       
                    del_video();
                    $("#youtube_div").show();
                    $("#video_div").hide();
                    $("#error_span").hide();
                    $("#table_image1").html("");
                } else {
                    del_video();
                    //alert("2");
                    $("#table_image1").html("");
                    $("#youtube_div").hide();
                    $("#video_div").show();
                    $("#my_youtube_link").val("");
                }
            }



            /*jslint unparam: true, regexp: true */
            total_image = 0, current_image = 0;

            show_sub_cat(val);
            var q = 0;

            function show_sub_cat(val) {

                $("input[name='cat_id']").val(val);
                $(".real_estate").hide();
                $(".vehicle_form").hide();
                $(".default_form").show();
                $("#form_type").val("default_form");

                $("#sub_cat_form1").val("");
                $("#sub_cat_form2").val("");
                $("#sub_cat_form3").val("");
                $("#sub_cat_form4").val("");
                $("#sub_cat_form5").val("");
                $("#sub_cat_form6").val("");

                if ($("#cat_id") != '')
                    $("#cat_id_err").hide();

                if ($("#show_sub_category") == '')
                    $("#subcat_id_err").show();

                var userid = '';
<?php
if (isset($_GET['userid'])) {
    ?>
                    var userid = "<?php echo $_GET['userid']; ?>";
    <?php
} elseif ($user_id != '') {
    ?>
                    var userid = "<?php echo $user_id; ?>";
    <?php
}
?>

                var url = "<?php echo base_url() ?>admin/classifieds/show_sub_cat";
                $.post(url, {value: val, sub_cat_id:<?php echo $product[0]['sub_category_id']; ?>, q: q, userid: userid}, function (data)
                {
                    $("#sub_cat_list").html(data);
                    //$("#sub_cat").select2();
                });
                q = q + 1;
            }

            var val = $('#cat_id').val();

            function show_model(val1)
            {
                var url = "<?php echo base_url() ?>admin/classifieds/show_model";
                $.post(url, {value: val1}, function (data)
                {
                    $("#pro_model option").remove();
                    $("#pro_model").append(data);

                });
            }

            $(':input').attr('readonly', 'readonly');
            $("select").attr("disabled", "disabled");
            $(":input").attr("disabled", "disabled");

//            $('.btn').hide();
        </script>        
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="<?php echo site_url(); ?>assets/googleMap.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc-XPpHskmvNVI5zH7T52Kvgja829p6Ek&libraries=places&callback=initAutocomplete"
        async defer></script>
    </body>
</html>