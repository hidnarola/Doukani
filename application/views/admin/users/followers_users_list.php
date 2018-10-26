<!DOCTYPE html>
<html>
    <head>
        <?php //$this->load->view('admin/include/head'); ?>
        <?php
        if (isset($page_title)) {
            echo '<title>' . $page_title . '</title>';
        } else {
            ?>
            <title>Classified Application</title>
        <?php } ?>

        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/light-theme.css" media="all" id="color-settings-body-color" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/lightbox/lightbox.css" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/common/bootstrap-wysihtml5.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/datatables/bootstrap-datatable.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/bootstrap/bootstrap.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/dark-theme.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/style.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/theme-colors.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_switch/bootstrap-switch.css" media="all" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/admin/stylesheets/custom-chat.css" media="all" rel="stylesheet" type="text/css" />
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css' />
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/plugins/bootstrap_colorpicker/bootstrap-colorpicker.css'/>
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/icomoon/style.css' />
        <link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/admin/stylesheets/multiple-select.css' />

        <link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
        <style>            
            /*            ul.dropdown-menu {position: relative;}
                        ul.dropdown-menu li {border-bottom: 1px #ccc solid;}*/
        </style>
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
                                            <span>Followers List</span>
                                            <?php
                                            $redirect = $_SERVER['QUERY_STRING'];
                                            if (!empty($_SERVER['QUERY_STRING']))
                                                $redirect = '/?' . $redirect;
                                            ?>
                                        </h1>                                        
                                    </div>
                                </div>
                            </div>
                            <form id="form1" name="form1" action="<?php echo site_url() . 'admin/users/followers/' . $this->uri->segment(4); ?>" method="get" accept-charset="UTF-8">
                                <input type="hidden" name="per_page" id="per_page" value="<?php echo (isset($_REQUEST['per_page'])) ? $_REQUEST['per_page'] : 10; ?>">
                                <button type="submit" name="submit" id="submit" class="btn  btn-primary display-none"><i class="fa fa-search"></i></button>
                            </form>
                            <div class="row">                                
                                <div class="col-sm-6">                                    
                                    <div class='title'>                         
                                        <?php
                                        $res = $this->db->query('select email_id from user where user_id=' . $this->uri->segment(4))->row();
                                        if (isset($res)) {
                                            echo 'Email ID: <u>' . $res->email_id . '</u>';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'>
                                        <h3><span class="label label-success"><?php echo $total_records; ?></span> Total Records </h3>
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-normal">
                            <div class='row'>
                                <div class='col-sm-12' id="filter_user_list">                                    
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Users List</div>
                                            <div class='actions'>
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>                                        
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <form name="block_status" id="block_status" method="post">
                                                        <!-- data-table -->
                                                        <table  class='table  table-striped superCategoryList' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>                                                                    
                                                                    <th  width="25%" >Email</th>                                                                                                                                        
                                                                    <th width="25%">Status</th>                                                                    
                                                                    <th width="25%">Phone</th>                                                                    
                                                                    <th width="25%">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($users_list) && sizeof($users_list) > 0):
                                                                    $ii = 1;
                                                                    foreach ($users_list as $u) {
                                                                        ?>
                                                                        <tr>                                                                            
                                                                            <td>
                                                                                <?php echo $u['email_id']; ?>
                                                                            </td>
                                                                            <td><?php
                                                                                if ($u['is_delete'] == 0)
                                                                                    echo 'Active';
                                                                                elseif ($u['is_delete'] == 1)
                                                                                    echo 'Deleted';
                                                                                elseif ($u['is_delete'] == 2)
                                                                                    echo 'Not Agree with T&C';
                                                                                elseif ($u['is_delete'] == 3) {
                                                                                    if ($u['user_role'] == 'storeUser')
                                                                                        echo 'Store Hold';
                                                                                    elseif ($u['user_role'] == 'offerUser')
                                                                                        echo 'Company Hold';
                                                                                }
                                                                                elseif ($u['is_delete'] == 4)
                                                                                    echo 'User Blocked';
                                                                                elseif ($u['is_delete'] == 5)
                                                                                    echo 'Need to fill Store Form';
                                                                                ?>
                                                                            </td>
                                                                            <td style="width:70px;"><?php echo $u['phone']; ?></td>
                                                                            <td>  
                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">                                                                                        
                                                                                        <li>
                                                                                            <a href = '<?php echo base_url() . "admin/users/view/" . $u['user_id']; ?>' target="_blank">
                                                                                                <i class = "fa fa-info-circle"></i> View User Details
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a href = '<?php echo base_url() . "admin/users/edit/" . $u['user_id']; ?>' target="_blank">
                                                                                                <i class = 'icon-edit'></i>
                                                                                                Edit User Details
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>                                                                               
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                        $ii++;
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
                                                    </form>
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="col-sm-4">
                                                        <label>Per page : </label>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <select name="per_page1" id="per_page1" class="form-control" >
                                                            <option value="2" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '2') ? 'selected' : ''; ?>>2</option>    
                                                            <option value="10" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '10') ? 'selected' : ''; ?>>10</option>    
                                                            <option value="25" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '25') ? 'selected' : ''; ?>>25</option>
                                                            <option value="50" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '50') ? 'selected' : ''; ?>>50</option>
                                                            <option value="100" <?php echo (isset($_GET['per_page']) && $_GET['per_page'] == '100') ? 'selected' : ''; ?>>100</option>
                                                        </select>
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
                    </div>
                </div>
            </section>
        </div>        
        <?php $this->load->view('admin/include/footer-script'); ?>          
    </body>
</html>
<script type="text/javascript">
    $(document).find('#per_page1').on('change', function () {
        var per_page = $(this).val();
//        console.log(per_page);
        $('#per_page').val(per_page);
        $(document).find('#submit').click();
    });
</script>