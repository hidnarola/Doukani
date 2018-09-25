<?php $display_description = '';
                                    if(isset($category_description) && !empty($category_description))
                                        $display_description = $category_description;
                                    elseif(isset($sub_category_description) && !empty($sub_category_description))
                                        $display_description = $sub_category_description;
                                    elseif(empty($display_description) && isset($category_description) && !empty($category_description))
                                        $display_description = $category_description;
                                    
                                    if(!empty($display_description)) {
                                        ?>                                    
                                    <div class="subcats">
                                        <div class="col-sm-12 no-padding-xs">
                                            <div class="col-sm-12">
                                                <h1 style="color: #05a846;margin: 10px 0;" class="cat_title_pg"><i class="fa <?php echo $category_icon; ?>"></i><?php echo $category_name; ?></h1>
                                                <h2 class="cat_desc_pg"><?php echo $display_description; ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>