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
                                            <span>Offers</span>
                                        </h1>
                                        <div class='pull-right'>
                                            <a href='<?php echo base_url(); ?>admin/offers/add' title="Add Offer" class="btn">
                                                <i class='icon-plus'></i>
                                                Add Offers
                                            </a>                                            
                                           <a href='<?php echo site_url().'admin/offers/today_offers'; ?>' onclick="reset_filter();" title="Add Store" class="btn">
                                                <i class="fa fa-refresh"></i>
                                                Reset Filters
                                            </a>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>                        
			<form id="form1" name="form1" action="<?php echo site_url().'admin/offers/today_offers/'; ?>" method="get" accept-charset="UTF-8">
                             <div class="row">
                                <div class="col-sm-4">
                                    <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                        <div class="box-header orange-background">
                                            <div class="title">Show By Category</div>
                                            <div class="actions">
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="box-content ">
                                            <div class="form-group">
                                                <select id="cat" class="select2 form-control" onchange="show_offer();" name="cat">
                                                    <option value="all" <?php if(isset($_GET['cat']) && $_GET['cat']=="all") echo 'selected=selected';?>>All</option>
                                                    <?php foreach ($category as $o) { 
														if(isset($_GET['cat']) && $_GET['cat']==$o['category_id']) {
													?>
													  <option value="<?php echo $o['category_id']; ?>" selected><?php echo str_replace('\n', " ", $o['catagory_name']); ?></option>
													<?php } else  { ?>
                                                        <option value="<?php echo $o['category_id']; ?>"><?php echo str_replace('\n', " ", $o['catagory_name']); ?></option>
                                                    <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($user_role != 'generalUser') { ?>
                                    <div class="col-sm-4">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <div class="title">Show By Store</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content ">
                                                <div class="form-group">
                                                    <select id="cmp" class="select2 form-control" onchange="show_offer();" name="store">
                                                        <option value="all" <?php if(isset($_GET['store']) && $_GET['store']=='all')  echo 'selected=selected'; ?> >All</option>
                                                        <?php foreach ($store as $o) { 
														if(isset($_GET['store']) && $_GET['store']==$o['store_id']) {
														?> 
															<option value="<?php echo $o['store_id']; ?>" selected><?php echo $o['store_name']; ?></option>
														<?php } else  {?>
                                                            <option value="<?php echo $o['store_id']; ?>"><?php echo $o['store_name']; ?></option>
                                                        <?php } } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
									<div class="col-sm-2">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <button type="submit" name="" id="" class="btn">
													<i class="fa fa-search"></i> Search
												</button>
                                            </div>                                            
                                        </div>
                                    </div>
                            </div>
			</form>
                        
                            <hr class="hr-normal">
                            <div class='row'>
                                <div class='col-sm-12' id="filter_offer_list">
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Offer List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area'> <!-- data-table -->
                                                    <table class='table  table-striped' style='margin-bottom:0;'>
                                                        <thead style="text-align: center;">
                                                            <tr>
                                                                <th>Title</th>
                                                                <th>Total Views</th>
                                                                <th>URL</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($offers)):
                                                                foreach ($offers as $o) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $o['offer_title']; ?></td>
                                                                        <td><?php echo $o['offer_total_views']; ?></td>
                                                                        <td><?php echo $o['offer_url']; ?></td>
                                                                        <td>
                                                                            <a class='btn btn-success btn-xs has-tooltip' data-placement='top' title='View' href='<?php echo base_url() . "admin/offers/view/" . $o['offer_id']; ?>'>
                                                                                    <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                            <a class='btn btn-warning btn-xs has-tooltip' data-placement='top' title='Edit' href='<?php echo base_url() . "admin/offers/edit/" . $o['offer_id']; ?>'>
                                                                                <i class='icon-edit'></i>
                                                                            </a>
                                                                            <a class='btn btn-danger btn-xs has-tooltip' data-placement='top' title='Delete' onclick="return confirm('Are you sure you want to delete this offer?');" title="Delete Offer" href='<?php echo base_url() . "admin/offers/delete/" . $o['offer_id']; ?>'>
                                                                                <i class='icon-trash'></i>
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
        <?php $this->load->view('admin/include/footer-script'); ?>     
        <script>
        function show_offer() { /*
            var catid = $('#cat').val();
            var store = $('#cmp').val();
            var url = "<?php echo base_url() ?>admin/offers/filterOfferList";
            $.post(url, {cat: catid, store: store}, function(data)
            {
//                    alert(data);
                $("#filter_offer_list").html(data);

            }); */
        }
        function reset_filter(){
            location.reload();
        }
        </script>
    </body>
</html>