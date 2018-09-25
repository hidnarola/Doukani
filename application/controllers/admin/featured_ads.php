<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb store'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>
                                            <i class='icon-building'></i>
                                            <span>Featured Ads</span>
                                        </h1>                                        
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>                            
                            <hr class="hr-normal">                          
                                <div class='row'>
                                    <div class='col-sm-12' id="filter_list">
                                        <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                            <div class='box-header orange-background'>
                                                <div class='title'>Listings</div>
                                                <div class='actions'>
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class='box-content box-no-padding'>
                                                <div class='responsive-table'>
                                                    <div class='scrollable-area'>
                                                        <table class='table table-striped superCategoryList' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <th>Image</th>
                                                                    <th>Status</th>
                                                                    <th>Start Date</th>                                                                    
                                                                    <th>End Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (!empty($featured_ads)):
                                                                    foreach ($featured_ads as $pro) { ?>
                                                                        <tr>
                                                                            <td><?php echo $pro['product_name']; ?></td>
                                                                            <td>
                                                                                <?php 																				
																					if (!empty($pro['product_image'])) { ?>
                                                                                    <a data-lightbox='flatty' href='<?php echo base_url() . product . "original/" . $pro['product_image']; ?>'>
                                                                                        <img alt="Category Image" style="height: 40px; width: 64px;" src="<?php echo base_url() . product . "small/" . $pro['product_image']; ?>" onerror="this.src='<?php echo site_url(); ?>/assets/upload/No_Image.png'"/>
                                                                                    </a>
                                                                                <?php } else { ?> 
																				<img alt="Category Image" style="height: 40px; width: 64px;" src="<?php echo site_url(); ?>assets/upload/No_Image.png"/>
																				<?php } ?>																				
                                                                            </td>
																			<td>
                                                                                <?php 
																					$date1	=	date_create($pro['dateFeatured']);
																					$date2	=	date_create($pro['dateExpire']);
																					if(date_format($date1,"d-m-Y")>=date('d-m-Y') && date_format($date2,"d-m-Y")<=date('d-m-Y')) 
																						echo 'Running';		
																					else 	
																						echo '---';
																				?>
																			</td>
                                                                            <td><?php 
																					$date=date_create($pro['dateFeatured']);
																					echo date_format($date,"d-m-Y"); ?>
																			</td>                                                                            
																			<td><?php 
																					$date=date_create($pro['dateExpire']);
																					echo date_format($date,"d-m-Y"); ?>
																			</td>                                                                            
                                                                            <td>
                                                                                <a class='btn btn-warning btn-xs has-tooltip' data-placement='top' title='Un-featured' onclick="return confirm('Are you sure you want to update as Un-featured ?');" title="Un-featured" href='<?php echo base_url() . "admin/classifieds/update_unfeatured/" . $pro['product_id']; ?>'>
                                                                                    <i class='icon-edit'></i>
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                endif;
                                                                ?>
                                                            </tbody>
                                                        </table>
														<div class="col-sm-12 text-right pag_bottom">
															<ul class="pagination pagination-sm"><?php if(isset($links)) echo $links; ?></ul>	
														</div>																
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
		<div class="modal fade center" id="send-message-popup" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content rounded">
                    <div class="modal-header text-center orange-background">
                        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                        <h4 id="myLargeModalLabel" class="modal-title">Set Featured Ads</h4>
                    </div>
                    <div class="modal-body">
                        <div class="FeaturedAds-popup">
                            <form action='<?php echo base_url(); ?>admin/classifieds/insert_featured' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form">
                                <div class='box-content control'>									
                                    <div class='form-group '>
										<label class='col-md-4 control-label' for='inputText1'>From Date - To Date</label>
										<div class='col-md-6  controls'>
											<input  id="date_range_val" class='form-control daterange' data-format='yyyy-MM-dd' placeholder='Select daterange' type='text' value="<?php echo date('Y-m-d')  . " to " . date("Y-m-d", strtotime("+1 month")); ?>" name="from_to">                      		    
										
											<span class='input-group-addon' id='daterange7'>
												<i class='icon-calendar'></i>
											</span>                                        
										</div>	
									</div>
                                    <div class="margin-bottom-10"></div>				
                                    <a class='btn btn-primary' href="#" onclick="javascript:insert_featured();">
                                        <i class="fa fa-paper-plane"></i>Apply                                      
                                    </a> <input type="hidden" id="checked_values" name="checked_values"/>
                                    <button data-dismiss="modal" class="btn btn-default rounded" type="button" id="cancel">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>                
    </body>
</html>