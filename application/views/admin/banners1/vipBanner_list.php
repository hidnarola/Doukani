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
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='page-header'>
                                        <h1 class='pull-left'>
                                            <i class='icon-list'></i>
                                            <span>Vip Banner</span>
                                        </h1>
										<div class='pull-right'>
											<a class="btn" href="<?php echo base_url() . "admin/custom_banner/vipBanner/10"; ?>">
                                                <i class="fa fa-refresh"></i> Reset Filters
                                            </a>
											&nbsp;&nbsp;&nbsp;
                                            <a class="btn" href="<?php echo base_url() . "admin/custom_banner/addvip/10"; ?>">
                                                <i class="icon-plus"></i> Add VIP Banner
                                            </a>                                        
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--        flash message -->
                            <?php if (isset($flash_message)) { ?>
                                <div class="alert alert-info alert-dismissable">
                                    <a class="close" data-dismiss="alert" href="#">×</a>
                                    <i class="icon-smile"></i>
                                    <?php
                                    echo $flash_message;
                                    ?>
                                </div>
                            <?php } ?>

                            <div class='row'>
                                <div class='col-sm-4'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Select Banner Type</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
										<form id="form1" name="form1" action="<?php echo site_url().'admin/custom_banner/vipBanner/10'; ?>" method="get" accept-charset="UTF-8">
                                        <div class='box-content '>
                                            <select name="ban_name_0" id="ban_type" class='select2 form-control' onchange="show_banner('<?php echo $this->uri->segment(4)?>',this.value);">
			 <option value="all" <?php if(isset($_GET['ban_name_0']) && $_GET['ban_name_0']=='all') {	 echo 'selected=selected'; } ?>>All</option>
			<option value="header" <?php if(isset($_GET['ban_name_0']) && $_GET['ban_name_0']=='header') {	 echo 'selected=selected'; } ?>>Header Banner</option>
			<option value="sidebar" <?php if(isset($_GET['ban_name_0']) && $_GET['ban_name_0']=='sidebar') {	 echo 'selected=selected'; } ?>>Sidebar Banner</option>
			<option value="between" <?php if(isset($_GET['ban_name_0']) && $_GET['ban_name_0']=='between') {	 echo 'selected=selected'; } ?>>Between Items</option>
                                                <!-- <option value="intro">Intro Banner</option>
                                                <option value="footer">Footer Banner</option>
                                                <option value="offer">Offer Banner</option>
                                                <option value="feature">Feature Banner</option>
                                                <option value="between items">Between Items</option>
                                                <option value="sponsor">Sponsor</option> -->
                                            </select>
											<br>
											<div class='form-group'>												
												<button type="submit" name="" id="" class="btn">
													<i class="fa fa-search"></i> Search
												</button>
											</div>	
                                        </div>
										</form>
                                    </div>
                                </div>
                            </div>   
                            <hr class="hr-normal">
                            <div id="filter_list">
                                <div class='row'>
                                    <div class='col-sm-12'>
                                        <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                            <div class='box-header orange-background'>
                                                <div class='title'>Vip Banner List</div>
                                                <div class='actions'>
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class='box-content box-no-padding'>
                                                <div class='responsive-table'>
                                                    <div class='scrollable-area'> <!-- data-table-->
                                                        <table class='table table-striped' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th align="center">
                                                                        Banner Id
                                                                    </th>

                                                                    <th align="center">
                                                                        Site Url
                                                                    </th>
                                                                    <th>
                                                                        Banner Type
                                                                    </th>
                                                                    <th>
                                                                        Banner Show For
                                                                    </th>
                                                                    <th>
                                                                        Pause Banner
                                                                    </th>
                                                                    <th>
                                                                        Impressions Count
                                                                    </th>
                                                                    <th>
                                                                        Clicks Count
                                                                    </th>
                                                                    <th>
                                                                        Action
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
															
                                                                if (!empty($superCategories)) {
                                                                    foreach ($superCategories as $superCategory) {?>
                                                                        <tr>
                                                                            <td align="center">
                                                                                <?php echo $superCategory['ban_id']; ?>
                                                                            </td>

                                                                            <td align="center">
                                                                                <?php echo $superCategory['site_url'] ?>
                                                                            </td>

                                                                            <td align="center">
                                                                                <?php echo $superCategory['ban_type_name'] ?>
                                                                            </td>
                                                                            <td align="center">
                                                                                <?php
                                                                                echo ucfirst($superCategory['ban_show_status']);
                                                                                ?>
                                                                            </td>
                                                                            <td  align="center">
                                                                                <?php
                                                                                echo $superCategory['pause_banner'];
                                                                                ?>
                                                                            </td>
                                                                            <td  align="center">
                                                                                <?php
                                                                                echo $superCategory['impression_count'];
                                                                                ?>
                                                                            </td>
                                                                            <td  align="center">
                                                                                <?php
                                                                                echo $superCategory['click_count'];
                                                                                ?>
                                                                            </td>
                                                                            <td  align="center">
                                                                                <a class="btn btn-warning btn-xs has-tooltip" title="Edit" data-placement='top' href="<?php echo base_url(); ?>admin/custom_banner/editvip/10/<?php echo $superCategory['ban_id']; ?>"><i class="icon-edit"></i></a>
                                                                                <a class="btn btn-danger btn-xs has-tooltip" title="Delete" data-placement='top' href="<?php echo base_url(); ?>admin/custom_banner/deletevip/10/<?php echo $superCategory['ban_id']; ?>" onclick="return confirm('Are you sure you want to delete this record ?');"><i class="icon-trash"></i></a>
                                                                            </td>
                                                                        </tr>
                                                                        <?php																	
                                                                    }
                                                                }
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
                </div>
        </div>
    </div>
</section>
</div>
<?php $this->load->view('admin/include/footer-script'); ?>
<script>
    function show_banner(banid,name) {        
	
	//window.location	=	'<?php echo site_url(); ?>/admin/custom_banner/vipBanner/'+banid+'&name='+name+'';
      /*  var url = "<?php echo base_url(); ?>admin/custom_banner/filterBannerList";       
        $.post(url, {type: 10, name: name}, function(data)
        {
//            alert(data);
            $("#filter_list").html(data);
        });
		*/
    }
</script>
