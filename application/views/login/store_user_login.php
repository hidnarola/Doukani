<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <style>
            .modal-dialog {
                width:350px !important;
            }
            #agree {

            }
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
                            <?php $this->load->view('include/left-nav'); ?>
                            <div class="col-sm-9 loginpg ContentRight">      

                            </div>
                            <!--//content-->   
                        </div>
                        <!--//content-->
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('include/footer'); ?>

        <div class="modal fade center agree_popup login-for-wrapper" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <form id="agree_form" name="agree_form" action="<?php echo site_url(); ?>login/user_for" method="post" class="form form-horizontal">	
                <div class="modal-dialog modal-md">
                    <div class="login-for">
                        <h4 id="myLargeModalLabel" class="modal-title">Login for</h4>
                        <select id="user_for" name="user_for" class="select2 form-control" required>
                            <option value="storeUser">Store Ads</option>
                            <option value="generalUser">Classified Ads</option>
                        </select>
                        <input type="submit" id="upload_img" name="submit" value="Submit" class="btn red-btn btn-block ">												
                    </div>	

                </div>	
            </form>
        </div>

    </body>
    <script>
        jQuery(document).ready(function ($) {
            $("#send-message-popup").modal('show');
        });
        $('#send-message-popup').modal({backdrop: 'static', keyboard: false})

        $("#agree_form").validate({
            rules: {
                user_role: {
                    required: true
                }
            },
            messages: {
                user_role: "Please select User Type"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

    </script>
</html>