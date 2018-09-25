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
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='fa fa-info-circle'></div>
                                            View Offers
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <form  class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Posted Date</label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input placeholder='Offer Posted Date' disabled class="form-control" type='text' value="<?php echo $offers[0]->offer_posted_on; ?>" />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Total Views</label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input placeholder='Offer Total Views' disabled class="form-control" type='text' value="<?php echo $offers[0]->offer_total_views; ?>" />
                                                </div>
                                            </div>
                                            
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Company<span>*</span></label>
                                                <div class='col-md-5 controls form-group'>
                                                    <select id="offer_user_company_id" class="select2 form-control" name="offer_user_company_id" data-rule-required='true' disabled>
                                                        <option value="">Select Offer Company</option>
                                                        <?php foreach ($company as $o) { ?>
                                                            <?php if(isset($offers[0]->offer_user_company_id) && $offers[0]->offer_user_company_id==$o['user_id']) { ?>
                                                                <option value="<?php echo $o['user_id']; ?>" selected>
                                                                    <?php echo $o['company_name']; ?>
                                                                </option>
                                                            <?php } else {?>
                                                                <option value="<?php echo $o['user_id']; ?>">
                                                                    <?php echo $o['company_name']; ?>
                                                                </option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Title</label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input placeholder='Offer Title' disabled class="form-control" name="offer_title" type='text' data-rule-required='true' value="<?php echo $offers[0]->offer_title; ?>" />
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Description<span>*</span></label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <textarea class='input-block-level wysihtml5 form-control' id="offer_description" placeholder="Offer Description" name="offer_description" rows="10" data-rule-required='true' disabled><?php echo $offers[0]->offer_description; ?></textarea>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText'>Start Date</label>
                                                <div class='col-md-5 form-group'>
                                                    <div class='datetimepicker input-group' id='datepicker'>
                                                        <input class='form-control' data-format='yyyy-MM-dd' name="start_date" id="start_date" placeholder='Select Start Date' type='text' value="<?php echo $offers[0]->offer_start_date; ?>" disabled>
                                                        <span class='input-group-addon'>
                                                            <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>                                                
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'>End Date</label>
                                                <div class='col-md-10 form-group'>
                                                    <?php if (isset($offers[0]->is_enddate) && $offers[0]->is_enddate == 1) { ?>
                                                    <label class='radio radio-inline'>
                                                        <input type="radio" name="end_dt_0" id="end_never" value="end_never"  <?php if (isset($offers[0]->is_enddate) && $offers[0]->is_enddate == 1) echo 'checked'; ?> disabled />
                                                        No End Date
                                                    </label>
                                                    <?php } 
                                                        if(isset($offers[0]->is_enddate) && $offers[0]->is_enddate == 0) {
                                                    ?>
                                                    <label class='radio radio-inline'>
                                                        <input type="radio" name="end_dt_0" id="end_cust" value="end_cust"  <?php if (isset($offers[0]->is_enddate) && $offers[0]->is_enddate == 0) echo 'checked'; ?> disabled />
                                                        Custom End Date 
                                                    </label>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class='form-group' id='end_dt'>
                                                <label class='col-md-2 control-label' for='inputText'></label>
                                                <div class='col-md-5 form-group'>
                                                    <div class='datetimepicker input-group' id='datepicker'>
                                                        <input class='form-control' data-format='yyyy-MM-dd' name="end_date" id="end_date"  placeholder='Select End Date' type='text' value="<?php echo $offers[0]->offer_end_date; ?>" disabled>
                                                        <span class='input-group-addon'>
                                                            <span data-date-icon='icon-calendar' data-time-icon='icon-time'></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='form-group'>						
                                                <label class='col-md-2 control-label' for='inputText1'>Offer URL</label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input  placeholder="Url to redirect" disabled class="form-control" name='offer_url'type='text' data-rule-required='true' value="<?php echo $offers[0]->offer_url; ?>" />		                  
                                                </div>
                                            </div>
                                             <div class='form-group'>                       
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Posted On </label>
                                                <div class='col-md-5 controls  form-group'>
                                                    <input  placeholder="Validity in days" disabled class="form-control" name='offer_valid_day' type='text' data-rule-required='true' value="<?php echo $offers[0]->offer_posted_on; ?>"/>
                                                </div>
                                            </div>
                                            <?php if (!empty($offers[0]->offer_image)): ?>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Offer Image</label>
                                                    <div class='col-md-5  form-group'>
                                                        <img alt="offers Image" src="<?php echo base_url() . offers . "medium/" . $offers[0]->offer_image; ?>" onError="this.src='<?php echo base_url() . 'assets/upload/No_Image.png' ?>'"/>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Status</label>
                                                <div class='col-md-5  form-group'>
                                                    <select class="select2 form-control" name="offer_status" disabled>
                                                        <option value="active" <?php echo $offers[0]->offer_status == "active" ? 'selected' : "" ?>> Active</option>
                                                        <option value="inactive" <?php echo $offers[0]->offer_status == "inactive" ? 'selected' : "" ?> >InActive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Offer Is</label>
                                                <div class='col-md-5  form-group'>
                                                    <select class="select2 form-control" name="offer_is_approve" disabled>
                                                        <option value="WaitingForApproval" <?php echo $offers[0]->offer_is_approve == "WaitingForApproval" ? 'selected' : "" ?> >Waiting For Approval</option>
                                                        <option value="approve" <?php echo $offers[0]->offer_is_approve == "approve" ? 'selected' : "" ?> >Approve</option>
                                                        <option value="unapprove" <?php echo $offers[0]->offer_is_approve == "unapprove" ? 'selected' : "" ?> >Unapprove</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <?php
                                                        $today = '';
                                                        if($this->uri->segment(5)!='')
                                                            $today = '/'.$this->uri->segment(5);
                                                        
                                                        $redirect = $_SERVER['QUERY_STRING'];
                                                        if(!empty($_SERVER['QUERY_STRING']))
                                                            $redirect = '/?'.$redirect;
                                                        ?>
                                                        
                                                        <a href='<?php echo site_url().'admin/offers/index'.$today.$redirect ; ?>' title="Back" class="btn-primary btn-lg">Back</a>
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
$(':input').attr('readonly','readonly');
$("select").attr("disabled","disabled");
$(":input").attr("disabled","disabled");
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
    </script>
    </body>
</html>
