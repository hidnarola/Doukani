<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('include/head'); ?>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
        <style>
            .modal-dialog {
                width:350px !important;
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
                                <div class="modal fade center agree_popup" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <form id="agree_form" name="agree_form" action="<?php echo site_url(); ?>login/user_role" method="post" class="form form-horizontal">	
                                        <div class="modal-dialog modal-md">
                                            <div class="col-sm-12">														
                                                <div class="modal-content rounded">		
                                                    <div class="text-center">														
                                                        <h4 id="myLargeModalLabel" class="modal-title"><br></h4>
                                                        <label>Please Select User Type for further process</label>
                                                    </div>
                                                    <div class="col-md-3 text-center">
                                                    </div>
                                                    <div class="col-sm-6 text-center">
                                                        <br>
                                                        <div class="form-group">
                                                            <select id="user_role" name="user_role" class="select2 form-control" required>
                                                                <?php //<option value="">User Type</option> ?>
                                                                <option value="generalUser">Classified User</option>
                                                                <option value="storeUser">Store User</option>
                                                                <?php //<option value="offerUser">Offer User</option> ?>
                                                            </select>
                                                        </div>
                                                    </div><br>

                                                    <div class="col-md-7 text-center"></div>
                                                    <input type="submit" id="upload_img" name="submit" value="Submit" class="btn red-btn btn-block ">
                                                    <div class="col-sm-12 text-right">		
                                                        Refer this link <a href="<?php echo site_url() . $term_link->slug_url; ?>" target="_blank" style="text-decoration:visible;"><span><?php echo $term_link->page_title; ?></span></a>
                                                    </div><br>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!--//content-->   
                        </div>
                        <!--//content-->
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('include/footer'); ?>
    </body>
    <script>
        jQuery(document).ready(function ($) {
//            $("#send-message-popup").modal('show');
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