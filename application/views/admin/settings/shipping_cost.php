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
                                    <i class='fa fa-ambulance'></i>
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
                                            Shipping Cost
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class='box-content'>
                                        <?php $current_user = $this->session->userdata('gen_user'); ?>
                                            <?php 
//                                            if($_SERVER['REMOTE_ADDR'] == '203.109.68.198') {
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
                                            <form action='<?php echo base_url() . 'admin/systems/shipping_cost' ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' id="add_shipping_cost_form">
<!--                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='min_weight'>Minimum Weight</label>
                                                    <div class='col-md-8 controls'>
                                                        <input class="form-control original_price" placeholder="Minimum Weight" name="min_weight" type="text" value="<?php echo $min_ship_weight; ?>" required="" />
                                                    </div>
                                                </div>-->
                                                
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='max_weight'>Maximum Weight</label>
                                                    <div class='col-md-8 controls'>
                                                        <input class="form-control original_price" placeholder="Maximum Weight" name="max_weight" type="text" value="<?php echo $max_ship_weight; ?>" required="" />
                                                    </div>
                                                </div>
                                                
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='cost'>Cost</label>
                                                    <div class='col-md-8 controls'>
                                                        <input class="form-control original_price" placeholder="Price" name="cost" type="text" value="<?php echo $ship_cost; ?>" required="" />
                                                    </div>
                                                </div>
                                                
                                                
                                                
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='cost_per_extra_kg'>Additional Cost Per KG</label>
                                                    <div class='col-md-8 controls'>
                                                        <input class="form-control original_price" placeholder="Cost per extra KG" name="cost_per_extra_kg" type="text" value="<?php echo $ship_cost_per_extra_kg; ?>" required="" />
                                                    </div>
                                                </div>
                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-1">
                                                            <button class='btn btn-primary' type='submit' name="submit">
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                            <a href='<?php echo base_url(); ?>admin/systems/shipping_cost' title="Cancel" class="btn">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <?php
//                                            }else{
                                            ?>
<!--                                            <form action='<?php echo base_url() . 'admin/systems/shipping_cost/' ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' id="add_shipping_cost_form">
                                                <?php 
                                                $count=1;
                                                foreach($shipping as $ship_data){
                                                ?>
                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'><?php echo $ship_data['weight_label']; ?></label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_<?php echo $count; ?>" type="text" value="<?php echo $ship_data['price'];  ?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php 
                                                $count++;
                                                }
                                            ?>

                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-3">
                                                            <button class='btn btn-primary' type='submit' name="submit">
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                            <a href='<?php echo base_url(); ?>admin/systems/shipping_cost' title="Cancel" class="btn">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>-->
                                        <?php
//                                        }
                                        ?>
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