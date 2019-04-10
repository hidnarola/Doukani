<div class="prod-info" >
    <div class="buy-wrap">
        <?php
        if ($product->stock_availability > 0 && !in_array($product->sub_category_id, array(12, 37, 60, 61, 13, 40, 53, 54, 55, 56, 57))) {
            ?>
            <div class="btn-wrap pro_inf_btn">
                <a href="javascript:void(0);" class="btn red-btn buy_link" id="buy_now">Buy Now</a>
                <a href="javascript:void(0);" class="btn cart-btn buy_link" id="add_to_cart">Add to cart</a>
                <?php
                if (isset($product->product_for) && $product->product_for == 'store'){
                  ?>
                 <a href="<?php echo HTTPS . website_url; ?>/allstores" class="btn red-btn continue_ship" >Continue Shipping</a>
                    <?php }?>
            </div>
        <?php } ?>

        <?php
        if ($product->stock_availability > 0 && in_array($product->sub_category_id, array(12, 37, 60, 61, 13, 40, 53, 54, 55, 56, 57))) {
            ?>

            <?php if ($product_is_sold == 0 && $product->product_is_inappropriate == 'Approve' && $product->product_deactivate == NULL) { ?>
                <button class="btn black-btn" onclick="show_number();"><span class="show_number" > Show Number</span></button>
                <?php
            } else {
                if ($product_is_sold == 1) {
                    echo "<p class='sold_message'><i class='fa fa-check-circle' aria-hidden='true'></i> Item Sold</p>";
                } else {
                    echo "<p class='expired_message'><i class='fa fa-exclamation-circle' aria-hidden='true'></i> AD Expired</p>";
                }
            }
            if (isset($user_agree) && $user_agree == 0) {
                if ($product->product_is_inappropriate == 'Approve' && $product->product_deactivate == NULL) {
                    ?>
                    <button class="btn red-btn  <?php // if ($is_logged != 0 && $user_status == 'yes') echo 'disabled';     ?>  " data-toggle="modal" id="reply_btn"> Reply to Ad</button>
                    <?php
                }
            } else {
                ?>
                <button class="btn btn-blue btn-block disabled"  style="background-color:#034694;color:white;" data-toggle="modal" id="reply_btn"> Reply to Ad</button>
                <?php
            }
            ?>
        <?php } ?>                                            
        <?php if ($product->product_price != '' && $product->product_price <> 0) { ?>
            <div class="price-wrap" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <span class="sel_price_lbl">Selling Price</span>
                <div><span itemprop="priceCurrency" content="AED">AED </span><span itemprop="price" content="<?php echo $product->product_price; ?>"><?php echo number_format($product->product_price, 2); ?></span></div>
            </div>
        <?php } ?>
    </div>
    <div class="extra-info row" itemprop="additionalProperty" itemscope itemtype="https://schema.org/PropertyValue">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr style="color:#9197a3;">
                    <th>Posted On</th>
                    <td><?php echo $posted_on; ?></td>
                </tr>
                <tr>
                    <th class="param-label" itemprop="name">Category</th>
                    <td class="param-values" itemprop="value">
                        <?php
                        echo str_replace('\n', " ", $product->catagory_name);
                        if ($product->sub_category_id != '' || $product->sub_category_id != null) {
                            echo ' - ' . str_replace('\n', " ", $product->sub_category_name);
                        }
                        ?>
                    </td>
                </tr>
                <?php if (isset($product->vehicle_features)) { ?>
                    <?php if ($product->vehicle_features->bname != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Brand</th>
                            <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->bname; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->vehicle_features->mname != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Model</th>
                            <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->mname; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->vehicle_features->mileagekm != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Mileage</th>
                            <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->mileagekm; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->vehicle_features->colorname != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Color</th>
                            <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->colorname; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->vehicle_features->type_of_car != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Type Of Car</th>
                            <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->type_of_car; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->vehicle_features->year != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Year</th>
                            <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->year; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->vehicle_features->make != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Make</th>
                            <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->make; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->vehicle_features->vehicle_condition != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Condition</th>
                            <td class="param-values" itemprop="value"><?php echo $product->vehicle_features->vehicle_condition; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
                <?php if (isset($product->realestate_features)) { ?>
                    <?php if ($product->realestate_features->Emirates != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Emirates</th>
                            <td class="param-values" itemprop="value"><?php echo $product->realestate_features->Emirates; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->realestate_features->PropertyType != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Property Type</th>
                            <td class="param-values" itemprop="value"><?php echo $product->realestate_features->PropertyType; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->realestate_features->Bedrooms != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Bedrooms</th>
                            <td class="param-values" itemprop="value"><?php
                                if ((int) $product->realestate_features->Bedrooms == '-1')
                                    echo 'More than 10';
                                else
                                    echo $product->realestate_features->Bedrooms;
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->realestate_features->Bathrooms != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Bathrooms</th>
                            <td class="param-values" itemprop="value"><?php
                                if ((int) $product->realestate_features->Bathrooms == '-1')
                                    echo 'More than 10';
                                else
                                    echo $product->realestate_features->Bathrooms;
                                ?>
                            </td>
                        </tr>
                    <?php } ?>                                       
                    <?php if ($product->realestate_features->Area != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Area</th>
                            <td class="param-values" itemprop="value"><?php echo $product->realestate_features->Area; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->realestate_features->Amenities != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Amenities</th>
                            <td class="param-values" itemprop="value"><?php echo $product->realestate_features->Amenities; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->realestate_features->furnished != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Furnished</th>
                            <td class="param-values" itemprop="value"><?php echo ($product->realestate_features->furnished != "0") ? ucfirst($product->realestate_features->furnished) : '-'; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($product->realestate_features->pets != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Pets</th>
                            <td class="param-values" itemprop="value"><?php echo ($product->realestate_features->pets != "0") ? ucfirst($product->realestate_features->pets) : '-'; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>

                <?php if (isset($product->car_number)) { ?>
                    <?php if ($product->car_number->car_number != '') { ?>
                        <tr style="color:#ed1b33">
                            <th class="param-label" itemprop="name"><b>Car Number</b></th>
                            <td class="param-values" itemprop="value"><b><?php echo $product->car_number->car_number; ?></b></td>
                        </tr>
                    <?php } ?>                                            
                    <?php if ($product->car_number->plate_source_name != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Plate Source</th>
                            <td class="param-values" itemprop="value"><?php echo $product->car_number->plate_source_name; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($product->car_number->plate_prefix != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Plate Prefix</th>
                            <td class="param-values" itemprop="value"><?php echo $product->car_number->plate_prefix; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($product->car_number->plate_digit != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Plate Digit</th>
                            <td class="param-values" itemprop="value"><?php echo $product->car_number->plate_digit; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($product->car_number->car_repeating_number != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Repeating Number</th>
                            <td class="param-values" itemprop="value"><?php echo $product->car_number->car_repeating_number; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?> 

                <?php if (isset($product->mobile_number)) { ?>
                    <?php if ($product->mobile_number->mobile_operator != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Mobile Operator</th>
                            <td class="param-values" itemprop="value"><?php echo $product->mobile_number->mobile_operator; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($product->mobile_number->car_repeating_number != '') { ?>
                        <tr>
                            <th class="param-label" itemprop="name">Repeating Number</th>
                            <td class="param-values" itemprop="value"><?php echo $product->mobile_number->car_repeating_number; ?></td>
                        </tr>
                    <?php } ?>

                    <?php if ($product->mobile_number->mobile_number != '') { ?>
                        <tr style="color:#ed1b33">
                            <th class="param-label" itemprop="name"><b>Mobile Number</b></th>
                            <td class="param-values" itemprop="value"><b><?php echo $product->mobile_number->mobile_number; ?></b></td>
                        </tr>
                    <?php } ?>                                           
                <?php } ?> 
                <?php if ($product->address != '') { ?>
                    <tr> 
                        <th class="param-label" itemprop="name">Address</th>
                        <td class="param-values" itemprop="value"><?php echo $product->address; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="detail-ad ad-banner-square prod_det pull-right mo-none">
            <?php
            if (!empty($feature_banners)) {
                if ($feature_banners[0]['ban_txt_img'] == 'image') {
                    ?>
                    <a href="<?php echo '//' . $feature_banners[0]['site_url']; ?>" target="_blank" onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" ><img src="<?php echo HTTP . website_url; ?>assets/upload/banner/original/<?php echo $feature_banners[0]['big_img_file_name']; ?>" class="img-responsive center-block" alt="Banner" /></a>
                    <?php
                } elseif ($feature_banners[0]['ban_txt_img'] == 'text') {
                    ?>
                    <a href="<?php echo '//' . $feature_banners[0]['site_url']; ?>" target="_blank"  onclick="javascript:update_count('<?php echo $feature_banners[0]['ban_id']; ?>')" class="mybanner img-responsive center-block">
                        <div class="">
                            <?php
                            echo $feature_banners[0]['text_val'];
                            ?>
                        </div>
                    </a>
                    <?php
                }
            }
            ?>
        </div>

    </div>    
</div>