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
                                    <span>Offers</span>
                                </h1>				
                            </div>
                            <hr class="hr-normal">
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <?php if (validation_errors() != false) { ?>
                                <div class='alert alert-info text-center'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo validation_errors(); ?>                              
                                </div>                          
                            <?php } ?>
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-plus'></div>
                                            Add Offer
                                            <?php
                                            $admin_permission = $this->session->userdata('admin_modules_permission');
                                            ?>
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <form class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form" name="form">

                                            <div class='form-group'>                                               
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Company<span>*</span></label>
                                                <div class='col-md-5 controls form-group'>

                                                    <select id="offer_user_company_id" class="select2 form-control" name="offer_user_company_id" data-rule-required='true'>
                                                        <option value="">Select Offer Company</option>
                                                        <?php foreach ($company as $o) { ?>
                                                            <option value="<?php echo $o['user_id']; ?>"><?php echo $o['company_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Title<span>*</span></label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input placeholder='Offer Title' class="form-control" name="offer_title" type='text' data-rule-required='true' value="<?php echo set_value('offer_title'); ?>">
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Description<span>*</span></label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <textarea class='input-block-level wysihtml5 form-control' id="offer_description" placeholder="Offer Description" name="offer_description" rows="10" data-rule-required='true' ><?php echo set_value('offer_description'); ?></textarea>
                                                </div>
                                            </div>

                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Phone Number<span>*</span></label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input placeholder='Phone Number' class="form-control" name="phone_no" type='text' id="phone_no" data-rule-required='true'>
                                                </div>
                                            </div>

                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'>Start Date</label>
                                                <div class='col-md-10  form-group'>
                                                    <label class='radio radio-inline'>
                                                        <input type="radio" name="st_dt_0" id="st_now" value="st_now"  checked/>
                                                        Start Immediately 
                                                    </label>
                                                    <label class='radio radio-inline'>
                                                        <input type="radio" name="st_dt_0" id="st_cust" value="st_cust"  />
                                                        Custom Start Date
                                                    </label>
                                                </div>
                                            </div>
                                            <div class='form-group' id="start_dt">
                                                <label class='col-md-2 control-label' for='inputText'></label>
                                                <div class='col-md-5  form-group'>
                                                    <div class='datetimepicker input-group' id='datepicker'>
                                                        <input class='form-control' data-format='yyyy-MM-dd' name="start_date" id="start_date" placeholder='Select Start Date' type='text' value="<?php echo isset($_POST['date']) ? $_POST['date'] : date("Y-m-d"); ?>">
                                                        <span class='input-group-addon'>
                                                            <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'>End Date</label>
                                                <div class='col-md-10  form-group'>
                                                    <label class='radio radio-inline'>
                                                        <input type="radio" name="end_dt_0" id="end_never" value="end_never"  checked/>
                                                        No End Date 
                                                    </label>
                                                    <label class='radio radio-inline'>
                                                        <input type="radio" name="end_dt_0" id="end_cust" value="end_cust"  />
                                                        Custom End Date 
                                                    </label>
                                                </div>
                                            </div>
                                            <div class='form-group' id='end_dt'>
                                                <label class='col-md-2 control-label' for='inputText'></label>
                                                <div class='col-md-5  form-group'>
                                                    <div class='datetimepicker input-group' id='datepicker'>
                                                        <input class='form-control' data-format='yyyy-MM-dd' name="end_date" id="end_date"  placeholder='Select End Date' type='text'>
                                                        <span class='input-group-addon'>
                                                            <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                        </span>
                                                    </div>
                                                    <font color="#b94a48" style="font-size: 14px; font-weight:lighter !important; "><span id="lbl_dbo"></span></font>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer URL</label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input  placeholder="Url to redirect" class="form-control" name='offer_url' type="url" >                         
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Image</label>
                                                <div class='col-md-12'>
                                                    <?php
//                                                    if($_SERVER['REMOTE_ADDR'] == '203.109.68.198') {
                                                    ?>
                                                    <input title="Search for file" name='offer_image_0[]' type='file' id="offer_image" onchange="javascript:checkimage(this);" multiple="">
                                                    <?php
//                                                    }else{
                                                    ?>
                                                    <!--<input title="Search for file" name='offer_image_0' type='file' id="offer_image" onchange="javascript:loadimage(this);">-->
                                                    <?php
//                                                    }
                                                    ?>
                                                    <label class='control-label' for='inputText1'>Minimum Size: 300px*300px</label>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'></label>
                                                <div class='col-md-9'>
                                                    <img alt="Offer Image" src="" id="blah1">
                                                </div>
                                            </div>
                                            <?php if ($admin_permission == 'only_listing') { ?>    
                                                <input id="offer_is_approve" name="offer_is_approve" class="form-control" type="hidden" value="unapprove">                 
                                            <?php } else { ?>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Offer Is</label>
                                                    <div class='col-md-5  form-group'>
                                                        <select class="select2 form-control" name="offer_is_approve">
                                                            <option value="WaitingForApproval">Waiting For Approval</option>
                                                            <option value="approve" selected=selected>Approve</option>
                                                            <option value="unapprove">Unapprove</option>
                                                        </select>
                                                    </div>
                                                </div>   
                                            <?php } ?>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' id="submit" name="submit">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Save
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>admin/offers/index' title="Cancel" class="btn">Cancel</a>
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
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/wysihtml5-0.3.0.js"></script> 
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/front/javascripts/bootstrap-wysihtml5.js"></script>
    </body>
    <script>

                                                        $('#blah1').hide();

                                                        $('#start_dt').hide();
                                                        $('#end_dt').hide();

                                                        $('#st_cust').click(function () {
                                                            $('#start_dt').show();
                                                        });
                                                        $('#end_cust').click(function () {
                                                            $('#end_dt').show();
                                                        });
                                                        $('#st_now').click(function () {
                                                            $('#start_dt').hide();
                                                        });
                                                        $('#end_never').click(function () {
                                                            $('#end_dt').hide();
                                                        });

                                                        $(document).on("keypress", "#phone_no", function (e) {
                                                            var charCode = (e.which) ? e.which : e.keyCode;
                                                            if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
                                                                return false;
                                                            }
                                                            return true;
                                                        });

                                                        $(function () {
                                                            $('#submit').click(function () {
                                                                var end_select = document.getElementById("end_cust");
                                                                if (end_select.checked) {

                                                                    var st_now = document.getElementById("st_now");
                                                                    var st_cust = document.getElementById("st_cust");
                                                                    if (st_now.checked) {
                                                                        var start = '<?php echo date('Y-m-d'); ?>';
//                                                                        console.log("start immediately");
                                                                    }
                                                                    else {
                                                                        if (st_cust.checked) {
                                                                            var start = $("#start_date").val();
//                                                                            console.log("custom_date");
                                                                        }
                                                                    }

                                                                    var end = $("#end_date").val();
                                                                    if (end < start) {
//                                                                        console.log("if part");
                                                                        $("#lbl_dbo").show();
                                                                        $("#lbl_dbo").text("Last Date Must be greater than Start Date");
                                                                        return false;
                                                                    }
                                                                    else {
                                                                        $("#lbl_dbo").hide();
                                                                    }
                                                                }
                                                            });
                                                        });

                                                        function loadimage(input) {

                                                            var offer_image = $("#offer_image").val();
                                                            if (offer_image != '') {
                                                                var file_data = $("#offer_image").prop("files")[0];
                                                                var type = file_data.type;
                                                                if (file_data) {
                                                                    if (type != "image/jpg" && type != "image/png" && type != "image/jpeg" && type != "image/gif") {
                                                                        $('#offer_image').val('');
                                                                        $(document).find('.file-input-name').html('');
                                                                        $(".file-input-name").html("");
                                                                        var imgcon = $("#blah1")[0];
                                                                        $(imgcon).attr("src", "");
                                                                        $(imgcon).hide();

                                                                        $(document).find('.response_message').html('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');
                                                                        $(document).find("#search_alert").modal('show');
                                                                        return false;
                                                                    }
                                                                }
                                                            }

                                                            if (input.files && input.files[0]) {
                                                                var reader = new FileReader();
                                                                reader.onload = function (e) {
                                                                    $('#blah1').attr('src', e.target.result);
                                                                    var imgcon = $("#blah1")[0];
                                                                    var img = imgcon;

                                                                    var pic_real_width, pic_real_height;
                                                                    $("<img/>")
                                                                            .attr("src", $(img).attr("src"))
                                                                            .load(function () {
                                                                                pic_real_width = this.width;
                                                                                pic_real_height = this.height;

                                                                                if (pic_real_width < 300 || pic_real_height < 300) {
                                                                                    $(document).find('.response_message').html('Offer Image size should be minimum of 300px*300px');
                                                                                    $(document).find("#search_alert").modal('show');

                                                                                    $('#offer_image').val('');
                                                                                    $(document).find('.file-input-name').html('');
                                                                                    $(".file-input-name").html("");
                                                                                    $(imgcon).attr("src", "");
                                                                                    $(imgcon).hide();
                                                                                }
                                                                                else
                                                                                {
                                                                                    $(imgcon).attr("src", $(img).attr("src"));
                                                                                    $(imgcon).show();
                                                                                }
                                                                            });
                                                                };
                                                                reader.readAsDataURL(input.files[0]);
                                                            }
                                                        }
                                                        
                                                        function checkimage(input){
                                                            var img_error_cnt = 0;
                                                            var _URL = window.URL || window.webkitURL;
                                                            var total_files_selected = input.files.length;
                                                            if(total_files_selected > 15){
                                                                alert('You can not upload more than 15 images');
                                                                $(input).val('');
                                                                return false;
                                                            }

                                                            var file, img;
                                                            for (var i = 0; i < total_files_selected; i++){
                                                                if((file = input.files[i])){
                                                                    img = new Image();
                                                                    img.src = _URL.createObjectURL(file);
                                                                    img.onload = function () {
                                                                        if(this.complete){
                                                                            if(this.width < 300 || this.height < 300){
                                                                                img_error_cnt = img_error_cnt + 1;
                                                                            }
                                                                        }
                                                                    };

                                                                }

                                                            }
                                                            console.log('Outside ', img_error_cnt);


                                                            if(img_error_cnt > 0){
                                                                alert('Offer Image size should be minimum of 300px*300px');
                                                                return false;
                                                            }
                                                        }
    </script>
</html>