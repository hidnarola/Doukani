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
                                        <?php $uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$lastUriSegment = array_pop($uriSegments); ?>
                                        <?php
                                        $current_user = $this->session->userdata('gen_user'); 
                                        ?>
                                        
                                        <?php
//                                        if($_SERVER['REMOTE_ADDR'] == '203.109.68.198' || $_SERVER['REMOTE_ADDR'] == '202.71.5.18') {
                                            $min_ship_weight = '0.00';
                                            $max_ship_weight = '0.00';
                                            $ship_cost = '0.00';
                                            $ship_cost_per_extra_kg = '0.00';
                                            if(isset($shipping) && !empty($shipping)){
//                                                pr($shipping);
                                                $min_ship_weight = $shipping['min_weight'];
                                                $max_ship_weight = $shipping['max_weight'];
                                                $ship_cost = $shipping['cost'];
                                                $ship_cost_per_extra_kg = $shipping['cost_per_extra_kg'];
                                            }
                                        ?>
                                            <form action='<?php echo base_url() . 'admin/users/store_shipping_cost/'.$lastUriSegment ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post'>
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
                                                    <label class='col-md-2 control-label' for='cost_per_extra_kg'>Additional Cost per KG</label>
                                                    <div class='col-md-8 controls'>
                                                        <input class="form-control original_price" placeholder="Cost per extra KG" name="cost_per_extra_kg" type="text" value="<?php echo $ship_cost_per_extra_kg; ?>" required="" />
                                                    </div>
                                                </div>
                                                
                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <button class='btn btn-primary' type='submit' name="submit">
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                            <a href='<?php echo base_url(); ?>admin/users/store_shipping_cost/<?php echo $lastUriSegment; ?>' title="Cancel" class="btn">Cancel</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </form>
                                        <?php
//                                        }else{
                                        ?>
                                        
                                            <?php
//                                            $for_id= array();
//                                            $st_id= array();
//                                            $lbl_id= array();
//                                            $price = array();
//                                            foreach($shipping as $id_val){
//                                                $for_id[] = $id_val['id'];
//                                            }
//                                            foreach($shipping as $id_val){
//                                                $st_id[] = $id_val['store_id'];
//                                            }
//                                            foreach($shipping as $id_val){
//                                                $lbl_id[] = $id_val['label_id'];
//                                            }
//                                            foreach($shipping as $id_val){
//                                                $price[] = $id_val['price'];
//                                            }
//                                            $offerArray =array();
//                                            foreach ($lbl_id as $key => $value) {
//                                                $offerArray[$value] = $price[$key];
//                                            }
                                            ?>
<!--                                            <form action='<?php echo base_url() . 'admin/users/store_shipping_cost/'.$lastUriSegment ?>' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post'>

                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'><=0.5 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_1" type="text" value="<?php if(in_array(1,$lbl_id)){ echo $offerArray[1]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>0.5 KG to 1.0 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_2" type="text" value="<?php if(in_array(2,$lbl_id)){ echo $offerArray[2]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>1.0 KG to 1.5 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_3" type="text" value="<?php if(in_array(3,$lbl_id)){ echo $offerArray[3]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>1.5 KG to 2.0 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_4" type="text" value="<?php if(in_array(4,$lbl_id)){ echo $offerArray[4]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>2.0 KG to 2.5 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_5" type="text" value="<?php if(in_array(5,$lbl_id)){ echo $offerArray[5]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>2.5 KG to 3.0 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_6" type="text" value="<?php if(in_array(6,$lbl_id)){ echo $offerArray[6]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>3.0 KG to 3.5 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_7" type="text" value="<?php if(in_array(7,$lbl_id)){ echo $offerArray[7]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                 <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>3.5 to 4.0 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_8" type="text" value="<?php if(in_array(8,$lbl_id)){ echo $offerArray[8]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>4.0 to 4.5 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_9" type="text" value="<?php if(in_array(9,$lbl_id)){ echo $offerArray[9]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-4 control-label' for='inputText1'>>4.5 to 5.0 KG</label>
                                                    <div class='col-md-3 controls'>

                                                        <input class="form-control original_price" placeholder="Price" name="price_10" type="text" value="<?php if(in_array(10,$lbl_id)){ echo $offerArray[10]; }?>" required="" />            
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="alert alert-info price_zero_lbl">
                                                            <i class="fa fa-info-circle" aria-hidden="true"></i><?php echo price_zero_label; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <div class="col-md-8 col-md-offset-3">
                                                            <button class='btn btn-primary' type='submit' name="submit">
                                                                <i class="fa fa-floppy-o"></i>
                                                                Save
                                                            </button>
                                                            <a href='<?php echo base_url(); ?>admin/users/store_shipping_cost/<?php echo $lastUriSegment; ?>' title="Cancel" class="btn">Cancel</a>
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