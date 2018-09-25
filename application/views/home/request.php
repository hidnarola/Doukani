<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>

        <meta name="keywords" content="<?php echo $page->page_meta_keyword; ?>" />
        <meta name="description" content="<?php echo $page->page_meta_desc; ?>" />
        <meta name="title" content="<?php echo $page->page_meta_title; ?>" />
        <style>
            label span { color:red;}			
            .title { padding-top: 16px;}
        </style>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div class="container-fluid">
            <?php $this->load->view('include/header'); ?>
            <?php $this->load->view('include/menu'); ?>
            <div class="page">
                <div class="container">
                    <div class="row">
                        <!--header-->
                        <?php $this->load->view('include/sub-header'); ?>
                        <!--//header-->
                        <!--main-->
                        <div class="col-sm-12 main category-grid">			                    
                            <!--cat-->
                            <?php $this->load->view('include/left-nav'); ?>
                            <div class="col-sm-9 ContentRight">
                                <!--//cat-->
                                <!--content-->
                                <div class="support">                          
                                    <?php if ($this->session->flashdata('msg_request')) { ?>
                                        <div class="alert alert-info alert-dismissable">
                                            <a href="javascript:void(0);" data-dismiss="alert" class="close">×</a>
                                            <?php echo $this->session->flashdata('msg_request'); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (isset($msg)): ?>
                                        <div class='alert  alert-info alert-dismissable'>
                                            <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                            <?php echo $msg; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class='title'>                                        
                                        <a href="javascript:void(0);" id="help_lbl_req">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i> How can we help you?
                                        </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <?php
                                            $name = "";
                                            $email_id = "";
                                            $mobile_number = "";
                                            if (isset($user_data) && sizeof($user_data) > 0) {
                                                $name = $user_data->first_name . ' ' . $user_data->last_name;
                                                $email_id = $user_data->email_id;
                                                $mobile_number = $user_data->phone;
                                            }
                                            ?>
                                            <div class='box postadBG'>                    
                                                <div class='box-content'>
                                                    <form class="form validate-form" style="margin-bottom: 0;" method="post" action="#" accept-charset="UTF-8" enctype="multipart/form-data">
                                                        <div class='form-group'>
                                                            <label>Name <span>*</span></label>
                                                            <input class='form-control' id='name' name="name" placeholder='Name' data-rule-required='true' maxlength="50"
                                                                   value="<?php echo $name; ?>" <?php if ($name != '') echo 'readonly'; ?>>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Email ID <span>*</span></label>
                                                            <input type="email" class='form-control' id='email_id' name="email_id" placeholder='Email ID' data-rule-required='true' maxlength="250" value="<?php echo $email_id; ?>" <?php if ($email_id != '') echo 'readonly'; ?>>
                                                        </div>						  
                                                        <div class='form-group'>
                                                            <label>Mobile Number <span>*</span></label>
                                                            <input class='form-control' id='mobile_number' name="mobile_number" placeholder='Mobile Number' data-rule-required='true' onkeypress="return isNumber1(event)" maxlength="50" value="<?php echo $mobile_number; ?>" <?php if ($mobile_number != '') echo 'readonly'; ?>>
                                                        </div>
                                                        <div class='form-group'>									    
                                                            <label>How Can We Help You? <span>*</span></label>
                                                            <select id="question" name="question" class='form-control' data-rule-required='true'>
                                                                <option value="">Select</option>
                                                                <option value="1">Suggestions/Complains</option>
                                                                <option value="2">Registration/Account</option>
                                                                <option value="3">Problem with Ads</option>											
                                                                <option value="4">Technical Issues</option>											
                                                                <option value="5">Fraud</option>
                                                            </select>
                                                        </div>
                                                        <div class='form-group' style="display:none;" id="sub_que_div">
                                                            <label><span>*</span></label>								 
                                                            <select id="sub_question" name="sub_question" class='form-control'>
                                                                
                                                            </select>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Description <span>*</span></label>
                                                            <textarea class='form-control' id='description' name='description' placeholder='Description' rows='3' data-rule-required='true' maxlength="250" ></textarea>
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Ad Link </label>
                                                            <input class='form-control' id='ad_link' name="ad_link" placeholder='Link URL' >
                                                        </div>
                                                        <div class='form-group'>
                                                            <label>Attachment</label><br>	
                                                            <input type="file" id='file_name' name="file_name" style="">
                                                        </div>	  
                                                        <div class="form-group">
                                                            <button name="submit" class="btn btn-blue red-btn" style="background-color:#ed1b33">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-sm-4 RightquickLink'>
                                            <div class='box'>
                                                <div class='lead'>
                                                    <i class='icon-github text-contrast'></i>
                                                    <?php echo $page_heading->page_title; ?>	
                                                </div>
                                                <div class='text-muted'>
                                                    <ul class="list-unstyled">	
                                                        <?php
                                                        foreach ($page_links as $link) {
                                                            $page_url1 = base_url() . $link['slug_url'];
                                                            if ($link['direct_url'] != '')
                                                                $page_url1 = $link['direct_url'];
                                                            ?>
                                                            <li class="li_hr">
                                                                <a href="<?php echo $page_url1; ?>" ><i class="fa fa-angle-right"></i><?php echo $link['page_title']; ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>	
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
        <?php $this->load->view('include/footer'); ?>

        <script>

            function isNumber1(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;

                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 45) {
                    return false;
                }
                return true;
            }

            //$("#sub_question").val('Gateway 2');
            $("#question").change(function () {
                var que_opt = $(this).val();
                if (que_opt != '') {

                    if (que_opt != 4) {
                        $("#sub_que_div").show();
                        if (que_opt == 3) {
                            var newOptions = {
                                0: '-',
                                1: "I am not able to find my ad",
                                2: "My Ad was deleted",
                                3: "How to Edit an Ad?",
                                4: "How to Delete an Ad?",
                                5: "How to Post an Ad?"
                            };
                        }
                        else if (que_opt == 2) {
                            var newOptions = {
                                0: '-',
                                6: "I have problems with my account",
                                7: "How to Register",
                                8: "Forgot my Password",
                                9: "Others"
                            };
                        }
                        else if (que_opt == 1) {
                            var newOptions = {
                                0: '-',
                                10: "Suggestions",
                                11: "Complains"
                            };
                        }
                        else if (que_opt == 5) {
                            var newOptions = {
                                0: '-',
                                12: "I want to report a fraud",
                                13: "I am a victim of a fraud",
                                14: "I want to report identity theft",
                                15: "Others"
                            };
                        }
                    } else
                        $("#sub_que_div").hide();
                }
                else
                    $("#sub_que_div").hide();
                var $el = $("#sub_question");
                $el.empty();
                $.each(newOptions, function (value, key) {
                    $el.append($("<option></option>")
                            .attr("value", value).text(key));
                });
            });
            
            $('#file_name').bind('change', function() {                
                
                var file_size = this.files[0].size;
                if(file_size > 3000000) {
                    $(document).find('.response_message').html('The attachment size exceeds the allowable limit');
                    $(document).find("#search_alert").modal('show');
                    $('#file_name').val('');
//                    alert('The attachment size exceeds the allowable limit');                    
                    return false;
                }
            });
            
        </script>
</body>
</html>