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
                                    <i class='icon-money'></i>
                                    <span>Featured Ad Price</span>
                                </h1>               
                            </div>
                            <hr class="normal" />
                            <?php if ($this->session->flashdata('msg')): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>

                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='icon-edit'></div>
                                            Featured Ad Price
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class='box-content'>
                                        <form action='<?php echo base_url() . 'admin/Systems/featuredad_price' ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post'>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>24 Hours</label>
                                                <div class='col-md-5 controls'>
                                                    <input class=" form-control number_field" name="24_Hours" type='text' data-rule-required='true' value="<?php echo $featured_price['24_Hours'] ?>"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-4 control-label' for='inputText1'>48 Hours</label>
                                                <div class='col-md-5 controls'>
                                                    <input class=" form-control number_field" name="48_Hours" type='text' data-rule-required='true' value="<?php echo $featured_price['48_Hours'] ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-3">
                                                        <button class='btn btn-primary' type='submit' name="submit">
                                                            <i class="fa fa-floppy-o"></i>
                                                            Update
                                                        </button>
                                                        <a href='<?php echo base_url(); ?>admin/Systems/featuredad_price' title="Cancel" class="btn">Cancel</a>
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
                <section>
                    </div>
<?php $this->load->view('admin/include/footer-script'); ?>
                    <script>
                        $(function () {
                            $('#ms').change(function () {
                                //console.log($(this).val());
                            }).multipleSelect({
                                width: '100%'
                            });
                            $(".ms-drop ul li").each(function () {
                                $(this).css("background", $(this).find("input").val());
                            });
                        });
                        
                        
                        $(".number_field").keydown(function (e) {
                            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||    
                                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||     
                                (e.keyCode >= 35 && e.keyCode <= 40)) {                 
                                     return;
                            }

                            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                e.preventDefault();
                            }    
                        });
    
                    </script>