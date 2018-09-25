<?php
$queryString = '';
$suffixUrl = '';
if ($this->input->get('search'))
    $queryString = "?search=" . $this->input->get('search');
$suffixUrl = $queryString;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
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
                                            <i class='icon-gamepad'></i>
                                            <span>WinIpad Users</span>
                                        </h1>                                    
                                    </div>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <!--                                <div class="col-sm-3">
                                                                    <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                                                        <div class="box-header orange-background">
                                                                            <div class="title">Show By Status</div>
                                                                            <div class="actions">
                                                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>                                        
                                                                        <div class="box-content ">
                                                                            <form id="form1" name="form1" action="<?php echo $url ?>" method="get" accept-charset="UTF-8">
                                
                                                                                <div class='' id="date_range">
                                                                                    <input  id="date_range_val" class='form-control daterange input-group' data-format='yyyy-MM-dd' placeholder='Product Posted Date' type='text' value="<?php if (isset($_REQUEST['dt'])) echo $_REQUEST['dt']; ?>" name="dt">
                                
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                <form action="<?php echo $url ?>" method="get" style="margin-top: 10px;">
                                    <div class="col-sm-3">
                                        <div class="box bordered-box orange-border" style="margin-bottom:0;">
                                            <div class="box-header orange-background">
                                                <div class="title">Filter User By</div>
                                                <div class="actions">
                                                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="box-content ">
                                                <div class="form-group">
                                                    <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                                    <select id="filter_list" name="filter" class="select2 form-control" onchange="show_user();">
                                                        <option value="all" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'all') echo 'selected=selected'; ?>>All</option>
                                                        <option value="dt" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'dt') echo 'selected=selected'; ?>>By Date</option>
                                                        <option value="active_users" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'active_users') echo 'selected=selected'; ?>>By Active Users</option>
                                                        <option value="inactive_users" <?php if (isset($_GET['filter']) && $_GET['filter'] != '' && $_GET['filter'] == 'inactive_users') echo 'selected=selected'; ?>>By Inactive Users</option>
                                                    </select>
                                                </div>                                            

                                                <div class=''  id="date_range" <?php
                                                if (isset($_GET['filter']) && $_GET['filter'] == 'dt')
                                                    echo '';
                                                else
                                                    echo "style='display: none;'";
                                                ?>>
                                                         <?php
                                                         if (isset($_GET['dt']))
                                                             $date = str_replace("+", "to", $_GET['dt']);
                                                         else
                                                             $date = '';
                                                         ?>
                                                    <input  id="date_range_val" class='form-control daterange input-group' data-format='yyyy-MM-dd' placeholder='Select daterange' type='text' onblur="show_user();" value="<?php echo $date; ?>" name="dt" >                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class='title'>
                                            <!--<form action="<?php echo $url ?>" method="get" style="margin-top: 10px;">-->
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6 col-sm-offset-1 text-right" style="margin-bottom: 10px;">
                                                        <input type="text" placeholder="Search By firstname/Email" name="search" class="form-control" value="<?php if (isset($_GET['search'])) echo $_GET['search']; ?>">
                                                    </div>
                                                    <div class="col-sm-2 text-right">
                                                        <button type="submit" id="" class="btn btn-primary">
                                                            <i class="fa fa-search"></i> Search
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($this->input->get('per_page')) { ?>
                                                <input type="hidden" name="per_page" value="<?php echo $this->input->get('per_page') ?>"/>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-sm-4">
                                    <div class='title text-right total-disp'><h4><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h4></div>
                                </div>                                
                            </div>
                            <br>
                            <br>

                            <?php if ($this->session->flashdata('msg')): ?>
                                <div class='alert <?php echo $this->session->flashdata('class') ?> alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php
                                    echo $this->session->flashdata('msg');
                                    ;
                                    ?>
                                </div>
                            <?php endif; ?>                            
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
                                        <form id="form1" name="form1" action="<?php echo $url; ?>" method="get" accept-charset="UTF-8" style="display:none;">
                                            <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                            <input type="submit" name="submit" id="submit">
                                        </form>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <table class='table table-striped superCategoryList' style='margin-bottom:0;'>
                                                        <thead>
                                                            <tr>
                                                                <!--<th><input type="checkbox" id="all" value="0" onclick="all_select();" style="height: 16px;"/></th>-->
                                                                <th>Email ID</th>
                                                                <th>First Name</th>
                                                                <th>Username</th>
                                                                <th>Status</th>
                                                                <th>Registered Date</th>    
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (isset($winipad_users) && sizeof($winipad_users) > 0):
                                                                foreach ($winipad_users as $pro) {
                                                                    ?>
                                                                    <tr>
                                                                        <!--<td><input class="input-sm" type="checkbox"  style="height: 16px;" value="<?php echo $pro['user_id']; ?>" /></td>--> 
                                                                        <td><?php echo $pro['email_id']; ?></td>
                                                                        <td><?php echo $pro['first_name']; ?></td>
                                                                        <td><?php echo $pro['username']; ?></td>
                                                                        <td><?php if ($pro['status'] == 'active') { ?>
                                                                                <span class="badge badge-success">Active</span>
                                                                            <?php } else { ?>
                                                                                <span class="badge badge-warning">Inactive</span>
                                                                            <?php }
                                                                            ?>
                                                                        </td>
                                                                        <td><?php echo date('Y-m-d', strtotime($pro['user_register_date'])); ?></td>  
                                                                        <td>                                                                            
                                                                            <div class="btn-group action_drop_down">
                                                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                    <span class="caret"></span>
                                                                                    <span class="sr-only">Toggle Dropdown</span>
                                                                                </button>
                                                                                <ul class="dropdown-menu" role="menu">
                                                                                    <?php
                                                                                    $page_redirect = (isset($_GET['page'])) ? '?page=' . $_GET['page'] : '';
                                                                                    if ($pro['status'] == 'inactive') {
                                                                                        ?>
                                                                                        <li>
                                                                                            <a data-path='<?php echo base_url() . "admin/users/update_winipad_users/" . $pro['user_id'] . '/' . $page_redirect; ?>' id="update_status" data-id="<?php echo $pro['user_id']; ?>">
                                                                                                <i class='icon-check'></i> Make Active User
                                                                                            </a>
                                                                                        </li>
                                                                                    <?php } else { ?>
                                                                                        <?php
                                                                                        $push_notification = $this->permission->has_permission('push_notification');
                                                                                        if ($push_notification == 1) {
                                                                                            if ($pro['device_type'] == NULL)
                                                                                                echo '';
                                                                                            elseif ($pro['device_type'] == 1) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a class='send_notification' data-id="<?php echo $pro['user_id']; ?>" data-for="ios" data-length = '<?php echo $iphone_notification_max_length->val; ?>'>
                                                                                                        <i class="fa fa-apple"></i> Send Notification
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            } elseif ($pro['device_type'] == 0) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a class='send_notification' data-id="<?php echo $pro['user_id']; ?>" data-for="android" data-length = '<?php echo $android_notification_max_length->val; ?>'>
                                                                                                        <i class="fa fa-android"></i> Send Notification
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        if ($pro['email_id'] != '') {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a class='send_message' data-id="<?php echo $pro['user_id']; ?>">
                                                                                                    <i class="fa fa-envelope"></i> Send Email
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }
                                                                                        if ($pro['is_delete'] == 4) {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a href="<?php echo site_url() . 'admin/users/block_list/' . $pro['user_id']; ?>" target="_blank">
                                                                                                    <i class="fa fa-list"></i> Block Product List
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        } else {
                                                                                            $classified = $this->permission->has_permission('classified');
                                                                                            if ($classified == 1) {

                                                                                                if ($pro['userAdsLeft'] > 0 && in_array($pro['is_delete'], array(0, 3)) && in_array($pro['user_role'], array('generalUser', 'storeUser'))) {
                                                                                                    ?>
                                                                                                    <li>
                                                                                                        <a href="<?php echo site_url() . 'admin/classifieds/listings_add/listings/classified/?userid=' . $pro['user_id']; ?>" title="Add Classified Product"><i class='icon-plus'></i> Ad Post</a>
                                                                                                    </li>
                                                                                                    <li class="divider"></li>
                                                                                                    <?php
                                                                                                }
                                                                                                if (in_array($pro['user_role'], array('generalUser', 'storeUser'))) {
                                                                                                    ?>
                                                                                                    <li>
                                                                                                        <a href='<?php echo base_url() . "admin/classifieds/listings/classified/?userid=" . $pro['user_id']; ?>' target="_blank">
                                                                                                            <i class='fa fa-list'></i> New Classified Product List
                                                                                                        </a>  
                                                                                                    </li>
                                                                                                    <li class="divider"></li>
                                                                                                    <li>
                                                                                                        <a href='<?php echo base_url() . "admin/classifieds/repost_ads/classified/?userid=" . $pro['user_id']; ?>' target="_blank">
                                                                                                            <i class='fa fa-list-ol'></i> Repost Classified Product List
                                                                                                        </a>
                                                                                                    </li>
                                                                                                    <li class="divider"></li>
                                                                                                    <?php
                                                                                                }
                                                                                            }
                                                                                            $store_mgt = $this->permission->has_permission('store_mgt');

                                                                                            if ($pro['user_role'] == 'storeUser' && $store_mgt == 1) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a href='<?php echo base_url() . "admin/classifieds/listings/store/?userid=" . $pro['user_id']; ?>' target="_blank">
                                                                                                        <i class='fa fa-bars'></i> New Store Product List
                                                                                                    </a> 
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <li>
                                                                                                    <a href='<?php echo base_url() . "admin/classifieds/repost_ads/store/?userid=" . $pro['user_id']; ?>' target="_blank">
                                                                                                        <i class='fa fa-list-alt'></i> Repost Store Product List
                                                                                                    </a>  
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                            $offer_mgt = $this->permission->has_permission('offer_mgt');
                                                                                            if ($pro['user_role'] == 'offerUser' && $offer_mgt == 1) {
                                                                                                ?>
                                                                                                <li>
                                                                                                    <a href="<?php echo site_url() . 'admin/offers/index/?userid=' . $pro['user_id']; ?>" target="_blank">
                                                                                                        <i class="fa fa-list"></i> Offers List
                                                                                                    </a>
                                                                                                </li>
                                                                                                <li class="divider"></li>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>                    

                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/users/view/" . $pro['user_id']; ?>'>
                                                                                                <i class="fa fa-info-circle"></i> View User Details
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/users/edit/" . $pro['user_id']; ?>'>
                                                                                                <i class='icon-edit'></i> Edit User
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <?php
                                                                                        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "storeUser" && $pro['store_id'] != '') {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/view_store/" . $pro['store_id'] . '/' . $search; ?>'>
                                                                                                    <i class="fa fa-building-o"></i> View Store Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/edit_store/" . $pro['store_id'] . $search; ?>'>
                                                                                                    <i class='icon-edit'></i> Edit Store Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }

                                                                                        if ($this->uri->segment(4) != '' && $this->uri->segment(4) == "offerUser") {
                                                                                            ?>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/view_offers_company/" . $pro['company_user_id'] . $search; ?>'>
                                                                                                    <i class='fa fa-building'></i> View Offer Company Details
                                                                                                </a>         
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <li>
                                                                                                <a href='<?php echo base_url() . "admin/users/edit_offers_company/" . $pro['company_user_id'] . $search; ?>'>
                                                                                                    <i class='icon-edit'></i> Edit Offer Company Details
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="divider"></li>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </ul>
                                                                            </div>  
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            else:
                                                                ?>
                                                                <tr>
                                                                    <td colspan="8">No Results Found</td>
                                                                </tr>
                                                            <?php
                                                            endif;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="col-sm-4">
                                                        <label>Per page : </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select name="per_page1" id="per_page1" class="form-control" >                                                        
                                                            <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '10') ? 'selected' : ''; ?>>10</option>    
                                                            <option value="25" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '25') ? 'selected' : ''; ?>>25</option>
                                                            <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '50') ? 'selected' : ''; ?>>50</option>
                                                            <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '100') ? 'selected' : ''; ?>>100</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">

                                                </div>
                                                <br>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="modal fade center" id="alert" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content rounded">
                        <div class="modal-header text-center orange-background">
                            <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="icon icon-remove"></i></button>
                            <h4 id="myLargeModalLabel" class="modal-title">Alert</h4>
                        </div>
                        <div class="modal-body">
                            <div class="FeaturedAds-popup">
                                <form action='' class='form form-horizontal' accept-charset="UTF-8" method='post' id="featured_form">
                                    <div class='box-content control'>
                                        <div class='form-group '>
                                            <font color="red" ><span id="error_msg" ></span></font>
                                        </div>
                                        <div class="margin-bottom-10"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">  
                            <h4 class="modal-title">Confirmation
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </h4>                   
                        </div>
                        <div class="modal-body">                  
                            <p>Are you sure you want to make User as Active?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
<?php $this->load->view('admin/include/footer-script'); ?>

        <script>
            $('input[name="dt"]').daterangepicker({
                format: "YYYY-MM-DD"
            });
            $(document).find('#per_page1').on('change', function () {
                var per_page = $(this).val();
                console.log(per_page);
                $('#per_page').val(per_page);
                $(document).find('#submit').click();
            });
            $(document).on("click", "#update_status", function (e) {
                var data_path = $(document).find(this).attr('data-path');
                var data_id = $(document).find(this).attr('data-id');
                console.log(data_id);
                $(".sure .modal-sm .modal-header").css({"background": "#337ab7"});
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        $.ajax({
                            url: "<?php echo site_url() . 'admin/users/update_winipad_users' ?>",
                            type: 'POST',
                            dataType: 'JSON',
                            data: {id: data_id},
                            success: function (data) {
                                if (data == 'success') {
                                    window.location.reload();
                                }
                            }
                        });
//                        jQuery('#userForm').attr('action', data_path).submit();
                    }
                });
            });
            function show_user() {

                var filter_val = $('#filter_list').val();
                var state_val = "";
                if (filter_val == "dt") {
                    var val = $('#date_range_val').val();
                    $('#date_range').show();

                } else {
                    $('#date_range').hide();
                    $('#date_range_val').val('');
                }
            }
        </script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/moment-with-locales.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/javascripts/bootstrap-datetimepicker.js"></script>
<?php $this->load->view('admin/listings/send_mail'); ?>
    </body>
</html>