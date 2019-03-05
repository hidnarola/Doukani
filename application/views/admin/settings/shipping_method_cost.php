<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <style type="text/css">
    .help-block{margin-top:0px; margin-bottom: 0px;}
    </style>
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
                                    <i class='fa fa-cogs'></i>
                                    <span>Shipping Cost</span>
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
                                            Site Shipping Cost
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <?php $current_user = $this->session->userdata('gen_user'); ?>
                                            <?php 
                                                $min_ship_weight = 0.00;
                                                $max_ship_weight = 0.00;
                                                $ship_cost = 0.00;
                                                $ship_cost_per_extra_kg = 0.00;
                                                if(isset($shipping) && !empty($shipping)){
                                                    $min_ship_weight = $shipping['min_weight'];
                                                    $max_ship_weight = $shipping['max_weight'];
                                                    $ship_cost = $shipping['cost'];
                                                    $ship_cost_per_extra_kg = $shipping['cost_per_extra_kg'];
                                                }
                                            ?>
                                            <form action='<?php echo base_url() . 'admin/systems/shipping_method_cost' ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' id="add_shipping_cost_form">
                                                
                                                <?php
                                                foreach ($delivery_options as $opt_id => $opt_data):
                                                ?>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='<?php $opt_data['id']; ?>'><?php echo $opt_data['option_text']; ?></label>
                                                    <div class='col-md-8 controls'>
                                                        <input class="form-control original_price" placeholder="<?php echo $opt_data['option_text']; ?>" name="cost[<?php echo $opt_data['id']; ?>]" type="text" value="<?php echo $find_existing_method_cost[$opt_data['id']]; ?>" />
                                                    </div>
                                                </div>
                                                <?php
                                                endforeach;
                                                ?>
                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <button class='btn btn-primary' type='submit'>
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                            <a href='<?php echo base_url(); ?>admin/systems/shipping_cost' title="Cancel" class="btn">Cancel</a>
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
                        $(".original_price").keydown(function (e) {
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