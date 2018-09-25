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
                                            <div class='icon-edit'></div>
                                            Edit Offers
                                            <?php $admin_permission = $this->session->userdata('admin_modules_permission'); ?>
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <?php
                                        $today = '';
                                        if ($this->uri->segment(5) != '')
                                            $today = '/' . $this->uri->segment(5);

                                        $redirect = $_SERVER['QUERY_STRING'];
                                        if (!empty($_SERVER['QUERY_STRING']))
                                            $redirect = '/?' . $redirect;
                                        ?>
                                        <form class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data" id="form" name="form">

                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Company<span>*</span></label>
                                                <div class='col-md-5 controls form-group'>

                                                    <select id="offer_user_company_id" class="select2 form-control" name="offer_user_company_id" data-rule-required='true'>
                                                        <option value="">Select Offer Company</option>
                                                        <?php foreach ($company as $o) { ?>
                                                            <?php if (isset($offers[0]->offer_user_company_id) && $offers[0]->offer_user_company_id == $o['user_id']) { ?>
                                                                <option value="<?php echo $o['user_id']; ?>" selected>
                                                                    <?php echo $o['company_name']; ?>
                                                                </option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo $o['user_id']; ?>">
                                                                    <?php echo $o['company_name']; ?>
                                                                </option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Title<span>*</span></label>
                                                <div class='col-md-5 controls form-group'>
                                                    <input placeholder='Offer Title' class="form-control" name="offer_title" type='text' data-rule-required='true' value="<?php echo $offers[0]->offer_title; ?>" />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Description<span>*</span></label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <textarea class='input-block-level wysihtml5 form-control' id="offer_description" placeholder="Offer Description" name="offer_description" rows="10" data-rule-required='true' ><?php echo $offers[0]->offer_description; ?></textarea>
                                                </div>
                                            </div>                                            
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Phone Number<span>*</span></label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input placeholder='Phone Number' class="form-control" name="phone_no" type='text' value="<?php echo $offers[0]->phone_no; ?>" id="phone_no" data-rule-required='true'>
                                                </div>
                                            </div>

                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText'>Start Date</label>
                                                <div class='col-md-5 form-group'>
                                                    <div class='datetimepicker input-group' id='datepicker'>
                                                        <input class='form-control' data-format='yyyy-MM-dd' name="start_date" id="start_date" placeholder='Select Start Date' type='text' value="<?php echo $offers[0]->offer_start_date; ?>" >
                                                        <span class='input-group-addon'>
                                                            <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>                                                
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'>End Date</label>
                                                <div class='col-md-10 form-group'>
                                                    <label class='radio radio-inline'>
                                                        <input type="radio" name="end_dt_0" id="end_never" value="end_never"  <?php if (isset($offers[0]->is_enddate) && $offers[0]->is_enddate == 1) echo 'checked'; ?> />
                                                        No End Date
                                                    </label>
                                                    <label class='radio radio-inline'>
                                                        <input type="radio" name="end_dt_0" id="end_cust" value="end_cust"  <?php if (isset($offers[0]->is_enddate) && $offers[0]->is_enddate == 0) echo 'checked'; ?>/>
                                                        Custom End Date 
                                                    </label>
                                                </div>
                                            </div>
                                            <div class='form-group' id='end_dt'>
                                                <label class='col-md-2 control-label' for='inputText'></label>
                                                <div class='col-md-5 form-group'>
                                                    <div class='datetimepicker input-group' id='datepicker'>
                                                        <input class='form-control' data-format='yyyy-MM-dd' name="end_date" id="end_date"  placeholder='Select End Date' type='text' value="<?php echo (isset($offers[0]->offer_end_date) && $offers[0]->offer_end_date != '0000-00-00') ? $offers[0]->offer_end_date : ''; ?>">
                                                        <span class='input-group-addon'>
                                                            <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                        </span>
                                                    </div>
                                                    <font color="#b94a48" style="font-size: 14px; font-weight:lighter !important; "><span id="lbl_dbo"></span></font>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer URL</label>
                                                <div class='col-md-5 controls form-group'>
                                                    <input  placeholder="Url to redirect" class="form-control" name='offer_url'type='url' value="<?php echo $offers[0]->offer_url; ?>" />		                  
                                                </div>
                                            </div>
                                            <div class='form-group'>                        
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Image</label>
                                                <div class='col-md-12'>
                                                    <input title="Search for file" name='offer_image_0' type='file' id='offer_image' onchange="javascript:loadimage(this);">
                                                    <label class='control-label' for='inputText1'>Minimum Size: 300*300</label>
                                                </div>                                                
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'></label>
                                                <div class='col-md-9'>
                                                    <img alt="Offer Image" src="" id="blah1">
                                                </div>
                                            </div>
<?php if (!empty($offers[0]->offer_image)): ?>
                                                <div class='form-group'>
                                                    <div class="col-md-2"></div>
                                                    <div class='col-md-5 form-group'>
                                                        <img alt="offers Image" src="<?php echo base_url() . offers . "medium/" . $offers[0]->offer_image; ?>" onError="this.src='<?php echo base_url() . 'assets/upload/No_Image.png' ?>'" />
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($admin_permission == 'only_listing') { ?>    
                                                <input id="product_is_inappropriate" name="product_is_inappropriate" class="form-control" type="hidden" value="unapprove">                 
                                            <?php } else { ?>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Offer Is</label>
                                                    <div class='col-md-5 form-group'>
                                                        <select class="select2 form-control" name="offer_is_approve">
                                                            <option value="WaitingForApproval" <?php echo $offers[0]->offer_is_approve == "WaitingForApproval" ? 'selected' : "" ?> >Waiting For Approval</option>
                                                            <option value="approve" <?php echo $offers[0]->offer_is_approve == "approve" ? 'selected' : "" ?> >Approve</option>
                                                            <option value="unapprove" <?php echo $offers[0]->offer_is_approve == "unapprove" ? 'selected' : "" ?> >Unapprove</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <button class='btn btn-primary' type='submit' name="submit" id="submit">
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
        <script>
                                                        $('#blah1').hide();

                                                        var select2icon;
                                                        select2icon = function (e) {
                                                            return "<i class='" + e.text + "'></i> ." + e.text;
                                                        };
                                                        $("#select2-icon").select2({
                                                            formatResult: select2icon,
                                                            formatSelection: select2icon,
                                                            escapeMarkup: function (e) {
                                                                return e;
                                                            }
                                                        });
                                                        $("#select2-tags").select2({
                                                            tags: ["today", "tomorrow", "toyota"],
                                                            tokenSeparators: [",", " "],
                                                            placeholder: "Type your tag here... "
                                                        });

                                                        $("#daterange2").daterangepicker({
                                                            format: "MM/DD/YYYY"
                                                        }, function (start, end) {
                                                            return $("#daterange2").parent().find("input").first().val(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
                                                        });

<?php if (isset($offers[0]->is_enddate) && $offers[0]->is_enddate == 0) { ?>
                                                            $('#end_dt').show();
<?php } else { ?>
                                                            $('#end_dt').hide();
<?php } ?>

                                                        $('#end_cust').click(function () {
                                                            $('#end_dt').show();
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
                                                                    var start = $("#start_date").val();
                                                                    var end = $("#end_date").val();

                                                                    if (end < start) {
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
        </script>
    </body>
</html>