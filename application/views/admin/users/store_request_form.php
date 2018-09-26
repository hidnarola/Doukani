<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
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
                                    <i class='icon-tags'></i>
                                    <span>Edit Store Request</span>
                                </h1>				
                            </div>
                            <hr class="hr-normal">
                            <div class="title">                         
                                Email ID: <u><?php echo $user_details['email_id']; ?></u>
                                <br>
                                Username: <?php echo $user_details['username']; ?>
                                <br>
                                Contact Number: <?php echo $user_details['phone']; ?>
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
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Edit Details
                                        </div>						
                                    </div>
                                    <div class='box-content'>
                                        <?php
                                        $redirect = $_SERVER['QUERY_STRING'];
                                        if (!empty($_SERVER['QUERY_STRING']))
                                            $redirect = '/?' . $redirect;
                                        ?>
                                        <form action='<?php echo base_url() . 'admin/users/edit_store_request/' . $store_request_details['id']; ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="store_edit">

                                            <div class='form-group'>                                                
                                                <label class='col-md-2 control-label' for='inputText1'>Store Name<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Store Name' class="form-control" name="store_name" id="store_name" type='text' value="<?php echo $store_request_details['store_name']; ?>" data-rule-required='true'>
                                                    <span class="store_name_status"></span>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Store Sub-domain<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Store Domain' class="form-control" name="store_domain" id="store_domain" type='text' value="<?php echo $store_request_details['store_domain']; ?>" data-rule-required='true' onkeypress="return isNumber1(event);" maxlength="20">
                                                    <span id="full_domain"><?php echo $store_request_details['store_domain']; ?>.doukani.com</span>
                                                    <br>
                                                    <span class="store_domain_status"></span>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Category<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select class="form-control" id="category_id" name="category_id" onchange="show_sub_cat(this.value);" data-rule-required="true">
                                                        <option value="">Select Category</option>
                                                        <option value="0" <?php echo ($store_request_details['category_id'] == 0) ? 'selected' : ''; ?>>Store Website</option>
                                                        <?php foreach ($category as $cat): ?>
                                                            <option value="<?php echo $cat['category_id']; ?>" <?php echo ($cat['category_id'] == $store_request_details['category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>                                                    
                                                </div>
                                            </div>
                                            <div class='form-group sub_cat_block' style="<?php echo ($store_request_details['category_id'] == 0) ? 'display:none;' : ''; ?>" >
                                                <label class='col-md-2 control-label' for='inputText1'>Sub Category<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <select class="form-control" id="sub_category_id" name="sub_category_id">
                                                        <option value="">ALL</option>
                                                        <?php foreach ($sub_category as $cat): ?>
                                                            <option value="<?php echo $cat['sub_category_id']; ?>" <?php echo ($cat['sub_category_id'] == $store_request_details['sub_category_id']) ? 'selected' : ''; ?>><?php echo str_replace('\n', " ", $cat['sub_category_name']); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group website_url' style="<?php echo ($store_request_details['category_id'] > 0) ? 'display:none;' : ''; ?>">
                                                <label class='col-md-2 control-label' for='inputText1'>Website URL<span>*</span></label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Website URL' class="form-control" name="website_url" type='text' value="<?php echo $store_request_details['website_url']; ?>" data-rule-required='true' maxlength="50" >
                                                </div>                                                
                                            </div>
                                            <div class='form-group store_desc' style="<?php echo ($store_request_details['category_id'] == 0) ? 'display:none;' : ''; ?>">
                                                <label class='col-md-2 control-label' for='inputText1'>Store Description</label>                                                
                                                <div class='col-md-5 controls'>
                                                    <textarea cols="78" rows="5" class="form-control" name="store_description" ><?php echo $store_request_details['store_description']; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Status</label>                                                
                                                <div class='col-md-5 controls'>
                                                    <select name="status" id="status" class="form-control">
                                                        <option value="0" <?php echo ($store_request_details['status'] == 0) ? 'selected=selected': ''; ?>>Pending</option>
                                                        <option value="2" <?php echo ($store_request_details['status'] == 2) ? 'selected=selected': ''; ?>>Approve</option>
                                                        <option value="3" <?php echo ($store_request_details['status'] == 3) ? 'selected=selected': ''; ?>>Reject</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'></label>
                                                <div class='col-md-10 controls'>
                                                    <p style="color:red;">
                                                        <i class="icon-long-arrow-right"></i> If you update with Approve or Reject status then You will not allow to update any details from above. Please make sure before update status.<br>
                                                        <i class="icon-long-arrow-right"></i> When you update with Approve status, New store will be created and Classified user will be converted into Store user.
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <?php if ($store_request_details['status'] == 0) { ?>
                                                            <button class='btn btn-primary' type='submit'>
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                        <?php } ?>
                                                        <a href='<?php echo base_url() . "admin/users/store_request_list"; ?>' title="Cancel" class="btn">Cancel</a>
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
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script>
            var flag1 = 0;
            var flag2 = 0;

            $(document).on("change", "#store_name", function (e) {
                var store_name = $(this).val();
                if (store_name) {
                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url() . 'home/check_store_name' ?>',
                        data: {
                            store_name: store_name
                        },
                        success: function (response) {
                            if (response == "OK") {
                                $('.store_name_status').html('');
                                flag1 = 0;
                                return true;
                            } else {
                                flag1 = 1;
                                $('.store_name_status').html('<font color="#b94a48">' + response + '</font>');
                                return false;
                            }
                        }
                    });
                } else {
                    $('.store_name_status').html("");
                    return false;
                }
            });


            $(document).on("change", "#store_domain", function (e) {
                var store_domain = $(this).val();
                if (store_domain) {
                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url() . 'home/check_store_domain' ?>',
                        data: {
                            store_domain: store_domain
                        },
                        success: function (response) {
                            if (response == "OK") {
                                $('.store_domain_status').html('');
                                flag2 = 0;
                                return true;
                            } else {
                                flag2 = 1;
                                $('.store_domain_status').html('<font color="#b94a48">' + response + '</font>');
                                return false;
                            }
                        }
                    });
                } else {
                    $('.store_domain_status').html("");
                    return false;
                }
            });

            $("#store_edit").submit(function (event) {
                if (flag1 == 1 || flag2 == 1)
                    return false;
            });

            function isNumber1(evt) {
                e = (evt) ? evt : window.event;
                var valid = (e.which >= 48 && e.which <= 57) || (e.which >= 65 && e.which <= 90) || (e.which >= 97 && e.which <= 122) || (e.which == 8);
                if (!valid) {
                    e.preventDefault();
                }
            }

            $(document).on("keypress keyup focusin blur cut paste", "#store_domain", function (e) {
                $('#full_domain').html('');
                $('#full_domain').html($('#store_domain').val() + '.doukani.com');
            });

            function show_sub_cat(val) {

                if (val > 0) {
                    $('.website_url').hide();
                    $('.sub_cat_block').show();
                    $('.store_desc').show();

                    $("input[name='category_id1']").val(val);

                    var sub_cat = '<?php echo $store_request_details['sub_category_id']; ?>';

                    var url = "<?php echo base_url(); ?>admin/stores/show_sub_cat";
                    $.post(url, {value: val, sub_cat_id: sub_cat}, function (data)
                    {
                        $("#sub_category_id").html(data);
                    });
                } else {
                    $('.sub_cat_block').hide();
                    $('.store_desc').hide();
                    $('.website_url').show();
                }
            }

<?php if ($store_request_details['status'] != 0) { ?>
                $(document).find('input').prop('disabled', true);
                $(document).find('select').prop('disabled', true);
                $(document).find('textarea').prop('disabled', true);
<?php } ?>
        </script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/jquery/jquery-ui.min.js" type="text/javascript"></script>
    </body>
</html>