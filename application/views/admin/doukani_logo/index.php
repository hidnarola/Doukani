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
                                            <i class='icon-picture'></i>
                                            <span>Doukani Logo</span>
                                        </h1>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6"> 
                                </div>
                                <div class="col-sm-6">
                                    <div class='title text-right total-disp'><h4><span class="label label-success">3</span> Total Records </h4></div>
                                </div>
                            </div>
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($this->session->flashdata('msg') != ''): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php endif; ?>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Doukani Logo List</div>
                                            <div class='actions'>                             
                                                <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class='box-content box-no-padding'>
                                            <div class='responsive-table'>
                                                <div class='scrollable-area table-responsive'>
                                                    <form id="userForm" name="userForm" action="" method="post">
                                                        <table class='table superCategoryList table table-striped' style='margin-bottom:0;'>
                                                            <thead>
                                                                <tr>
                                                                    <th>Pages</th>
                                                                    <th>Image</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                if (isset($doukani_logo_list) && sizeof($doukani_logo_list) > 0):
                                                                    foreach ($doukani_logo_list as $dou) {
                                                                        ?>
                                                                        <tr>
                                                                            <td><?php echo $dou['page_type']; ?></td>
                                                                            <td>
                                                                                <?php
                                                                                if (isset($dou['image_name']) && !empty($dou['image_name']))
                                                                                    $load_image = site_url() . doukani_logo . "original/" . $dou['image_name'];
                                                                                else
                                                                                    $load_image = site_url() . 'assets/upload/No_Image.png';
                                                                                ?>
                                                                                <a data-lightbox='flatty' href='<?php echo $load_image; ?>'>
                                                                                    <img alt="Logo" src="<?php echo $load_image; ?>" onerror="this.src='<?php echo site_url(); ?>assets/upload/No_Image.png'" style="max-height:70px;max-width:260px;"/>
                                                                                </a> 
                                                                            </td>
                                                                            <td>
                                                                                <div class="btn-group action_drop_down">
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Actions</button>
                                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                                                                        <span class="caret"></span>
                                                                                        <span class="sr-only">Toggle Dropdown</span>
                                                                                    </button>
                                                                                    <ul class="dropdown-menu" role="menu">
                                                                                        <li>
                                                                                            <a href='<?php echo base_url() . "admin/doukani_logo/edit/" . $dou['id']; ?>'>
                                                                                                <i class='icon-edit'></i> Edit Logo
                                                                                            </a>
                                                                                        </li>
                                                                                        <li class="divider"></li>
                                                                                        <li>
                                                                                            <a data-id="<?php echo $dou['id']; ?>" id="delete_logo">
                                                                                                <i class='icon-trash'></i> Delete Logo
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                else:
                                                                    ?>
                                                                    <tr>
                                                                        <td colspan="3">No Results Found</td>
                                                                    </tr>
                                                                <?php endif;
                                                                ?>
                                                            </tbody>       
                                                        </table>                                                     
                                                    </form>
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
        <div class="modal fade sure" id="deleteConfirm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">  
                        <h4 class="modal-title">Confirmation
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </h4>                   
                    </div>
                    <div class="modal-body">                  
                        <p id="alert_message_action">Are you sure you want to delete Logo?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default yes_i_want_delete" value="yes">Yes, I want</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="loading" style="text-align:center;display:none;" >
            <img id="loading-image" src="<?php echo static_image_path; ?>ajax-loader.gif" alt="Loading..." />
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script type="text/javascript">
            $(document).on("click", "#delete_logo", function (e) {
                var logo_id = $(document).find(this).attr('data-id');
                var url = '<?php echo base_url() ?>' + "admin/doukani_logo/delete/" + logo_id;
                $("#deleteConfirm").modal('show');
                $(document).on("click", ".yes_i_want_delete", function (e) {
                    var val = $(this).val();
                    if (val == 'yes') {
                        jQuery('#userForm').attr('action', url).submit();
                    }
                });
            });
        </script>
    </body>
</html>