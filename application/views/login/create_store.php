<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
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
                            <div class="col-sm-9 loginpg ContentRight">         
                                <div class="col-sm-12" >
                                    <h3>Create Your Own Store</h3><br>
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active create_store_div" id="home">
                                            <div class="row">
                                                <div class="col-md-12 col-md-offset-3">
                                                    <div class='' id="alert_box1" style="display:none;width:50%;">
                                                        <center id="alert_msg1"></center>
                                                    </div>
                                                    <form  name="store_form" class='default_form form form-horizontal' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="store_form">

                                                        <div class="form-group">
                                                            <label for="validation_name" class="control-label col-sm-2">Category<span style="color:red;">*</span></label>
                                                            <div class="col-sm-4 controls">
                                                                <select class="form-control" id="category_id" name="category_id" onchange="show_sub_cat(this.value);" >
                                                                    <option value="">Select Category</option>
                                                                    <option value="0">Store Website</option>
                                                                    <?php foreach ($category as $cat): ?>
                                                                        <option value="<?php echo $cat['category_id']; ?>" ><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group new_webiste">
                                                            <label for="validation_name" class="control-label col-sm-2">Website URL<span style="color:red;">*</span></label>
                                                            <div class="col-sm-4">
                                                                <input type="url" class="form-control" placeholder="Website URL"  name="webiste_link" id="webiste_link" />
                                                            </div>  
                                                        </div>
                                                        <div class="form-group sub_cat_block new_store_det">                                      
                                                            <label for="validation_name" class="control-label col-sm-2">Sub Category</label>
                                                            <div class="col-sm-4">
                                                                <select class="form-control" id="sub_category_id" name="sub_category_id">
                                                                    <option value="0">ALL</option>      
                                                                </select>
                                                            </div>  
                                                        </div>
                                                        
                                                        <div class="form-group">                                      
                                                            <label for="validation_name" class="control-label col-sm-2">Store Name<span style="color:red;">*</span></label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" placeholder="Store Name"  name="store_name" id="store_name"  />
                                                                <span class="store_name_status"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group domain">
                                                            <label for="validation_name" class="control-label col-sm-2">Store Domain Name<span style="color:red;">*</span></label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" placeholder="Store Domain Name"  name="store_domain" id="store_domain" />
                                                                <span id="full_domain">store_name.doukani.com</span>
                                                                <br>
                                                                <span class="store_domain_status"></span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group new_store_det">
                                                            <label for="validation_name" class="control-label col-sm-2">Store Description<span style="color:red;">*</span></label>
                                                            <div class="col-sm-4">
                                                                <textarea cols="78" rows="5" class="form-control" name="store_description" ></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group new_store_det">
                                                            <label for="" class="control-label col-sm-2">Shipping Cost</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" placeholder="Shipping Cost"  name="shipping_cost" id="shipping_cost" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="validation_name" class="control-label col-sm-2">Meta Title</label>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" placeholder="Meta Title"  name="meta_title" id="meta_title" />
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="validation_name" class="control-label col-sm-2">Meta Description</label>
                                                            <div class="col-sm-4">                                        
                                                                <textarea cols="78" rows="5" class="form-control" name="meta_description" id="meta_description"  ></textarea>
                                                            </div>
                                                        </div>                                                        
                                                        <div class="col-sm-2"></div>                                
                                                        <div class="col-sm-2">      
                                                            <div class="form-group">
                                                                <label></label>
                                                                <button class="btn btn-block btn-black" name="store_submit" id="store_submit" value="Submit">Create Store</button>
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
            </div>        
            <?php $this->load->view('include/footer'); ?>
            <div id="loading" style="text-align:center" class="loader_display">
                <img id="loading-image" src="<?php echo base_url() ?>assets/front/images/ajax-loader.gif" alt="Loading..." alt="Image" />
            </div>
        </div>    
        <script>
            var flag1 = 0;
    var flag2 = 0;

//    $(document).on("change", "#store_name", function (e) {
//        var store_name = $(this).val();
//        if(store_name) {
//            $.ajax({
//            type: 'post',
//            url: '<?php echo site_url().'home/check_store_name' ?>',
//            data: {
//                store_name:store_name
//            },
//            success: function (response) {                  
//                if(response=="OK") {
//                   $('.store_name_status').html('');
//                   flag1 = 0;
//                   return true;
//                }
//               else {
//                    flag1 = 1;
//                    $('.store_name_status').html('<font color="#b94a48">'+response+'</font>');
//                    return false;                               
//                }
//              }
//            });
//        }
//        else {
//           $( '.store_name_status' ).html("");
//           return false;
//        }
//    });


//    $(document).on("change", "#store_domain", function (e) {
//        var store_domain = $(this).val();
//        if(store_domain) {
//            $.ajax({
//            type: 'post',
//            url: '<?php echo site_url().'home/check_store_domain' ?>',
//            data: {
//                store_domain:store_domain
//            },
//            success: function (response) {                  
//                if(response=="OK") {
//                   $('.store_domain_status').html('');
//                   flag2 = 0;
//                   return true;
//                }
//               else {
//                    flag2 = 1;
//                    $('.store_domain_status').html('<font color="#b94a48">'+response+'</font>');
//                    return false;                               
//                }
//              }
//            });
//        }
//        else {
//           $( '.store_domain_status' ).html("");
//           return false;
//        }
//    });
            $('document').ready(function () {
                $("#store_form").validate({
                    rules:
                            {
                                category_id: {required: true},
                                store_name: {
                                    required: true,
                                    minlength: 5,
                                    maxlength: 20
                                },
                                store_domain: {
                                    required: true,
                                    minlength: 5,
                                    maxlength: 15
                                },
                                store_description: {required: true},
//                                shipping_cost: {required: true}
                            },
                    messages:
                            {
                                category_id: {required: "Category selection is required."},
                                store_name: {required: "Store name is required.",
                                    minlength: "Store name should be of minimum 5 chars",
                                    maxlength: "Store name should be of maximum 20 chars"
                                },
                                store_domain: {
                                    required: "Store URL is required.",
                                    minlength: "Store domain name should be of minimum 5 chars",
                                    maxlength: "Store domain name should be of maximum 15 chars"
                                },
                                store_description: {required: "Store Description is required."},
//                                shipping_cost: {required: "Shipping Cost is required."}
                            },
                    submitHandler: submitForm1
                });

                function submitForm1()
                {
                    if(flag1==1 || flag2==1)
                        return false;
                    
                    $('.loader_display').show();
                    $("#store_submit").html('<img src="<?php echo site_url(); ?>assets/front/images/btn-ajax-loader.gif" / alt="Image"> &nbsp; Creating Store ...');
                    var data = $("#store_form").serialize();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url() . "login/ajax_createstore"; ?>',
                        data: data,
                        beforeSend: function ()
                        {
                            $("#alert_box1").fadeOut();
                            $("#store_submit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending request...');
                        },
                        success: function (response)
                        {

                            var json = response,
                            obj = JSON.parse(json);
                            var response = obj.response;
                            if (response == 'success') {
                                href = '<?php echo site_url() . "user/store"; ?>';
                                setTimeout(function () {
                                    window.location.href = href;
                                }, 1000);
                            }
                            else {
                                
                                if (response == "store_empty_name_error") {
                                    $('.loader_display').hide();
                                    $('#alert_box1').show();
                                    $('#alert_msg1').show();
                                    $("#alert_msg1").html('<br><div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;  Store Name can not be empty  ! <a class="close" data-dismiss="alert" href="javascript:void(0);">&times; </a></div>');
                                    $("#store_submit").html('&nbsp; Create Store');
                                }
                                if (response == "store_empty_domain_error") {
                                    $('.loader_display').hide();
                                    $('#alert_box1').show();
                                    $('#alert_msg1').show();
                                    $("#alert_msg1").html('<br><div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;  Store Domain can not be empty  ! <a class="close" data-dismiss="alert" href="javascript:void(0);">&times; </a></div>');
                                    $("#store_submit").html('&nbsp; Create Store');
                                }
                                
                                if (response == "store_name_error") {
                                    $('.loader_display').hide();
                                    $('#alert_box1').show();
                                    $('#alert_msg1').show();
                                    $("#alert_msg1").html('<br><div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;  Store Name already exists ! <a class="close" data-dismiss="alert" href="#">&times; </a></div>');
                                    $("#store_submit").html('&nbsp; Create Store');
                                }
                                else if (response == "store_domain_error") {
                                    $('.loader_display').hide();
                                    $('#alert_box1').show();
                                    $('#alert_msg1').show();
                                    $("#alert_msg1").html('<br><div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;  Store URL already exists !<a class="close" data-dismiss="alert" href="#">&times; </a></div>');
                                    $("#store_submit").html('&nbsp; Create Store');
                                }
                                else if(response == 'website_name_error') {
                                    
                                    $('.loader_display').hide();
                                    $('#alert_box1').show();
                                    $('#alert_msg1').show();
                                    $("#alert_msg1").html('<br><div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;  Website URL can not be blank  ! <a class="close" data-dismiss="alert" href="#">&times; </a></div>');
                                    $("#store_submit").html('&nbsp; Create Store');
                                }
                            }
                        }
                    });
                    return false;
                }
            });

            $(document).on("keypress keyup focusin blur cut paste", "#store_domain", function (e) {
                    $('#full_domain').html('');
                    $('#full_domain').html("http://" + $('#store_domain').val() + '.doukani.com');
            });
            
            $(document).on("keypress", "#store_domain", function (e) {                
                var valid = (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122) || (e.which == 8);
                if (!valid) {
                    e.preventDefault();
                } 
            });
            
            $(document).on("keypress", "#shipping_cost", function (e) {                
                var charCode = (e.which) ? e.which : e.keyCode;                
                if ((charCode >= 48 && charCode <= 57) || (charCode >= 96 && charCode <= 105) || charCode == 46)
                    return true;
                else
                    return false;
            });
            
            $('.sub_cat_block').hide();
            $('.new_store_det').hide();
            $('.new_webiste').hide();
            $('.domain').hide();
            
            function show_sub_cat(val) {
                $('.domain').show();
                if(val > 0) {
                    $('.new_webiste').hide();
                    $('.sub_cat_block').show();
                    $('.new_store_det').show();
                    $("input[name='category_id']").val(val);
                    var url = "<?php echo base_url(); ?>login/show_sub_cat";
                    $.post(url, {value: val}, function (data)
                    {
                        $("#sub_category_id").html(data);
                    });
                }
                else {
                     $('.new_webiste').show();
                     $('.sub_cat_block').hide();  
                     $('.new_store_det').hide();
                }
            }
        </script>
    </body>
</html>