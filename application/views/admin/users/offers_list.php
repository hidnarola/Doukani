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
                                            <span>Block User's Offers</span>
                                        </h1>			
                                    </div>
                                </div>
                            </div>                            
                            <div class='title'>							
                                <div class='title'>
                                    <?php 
                                        echo 'Email ID: <u>' . @$email_id . '</u><br>';
                                        echo 'Username: ' . @$username;                                    
                                    ?>
                                </div>
                            </div>                            
                            <hr class="hr-normal">                            
                            <div class='row'>
                                <div class='col-sm-12' id="filter_list">
                                    <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                                        <div class='box-header orange-background'>
                                            <div class='title'>Offers</div>
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
                                                                <th>Offer Is</th>
                                                                <th>Start Date</th>
                                                                <th>End Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($offers)):
                                                                foreach ($offers as $pro) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?php echo $pro['offer_title']; ?></td>
                                                                        <td><?php echo ucfirst($pro['offer_is_approve']); ?></td>                     
                                                                        <td><?php echo $pro['offer_start_date']; ?></td>
                                                                        <td>
                                                                            <?php
                                                                            if (isset($pro['offer_end_date']) && $pro['offer_end_date'] == '0000-00-00')
                                                                                echo 'No End Date';
                                                                            else
                                                                                echo $pro['offer_end_date'];
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                }
                                                            endif;
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <div class="col-sm-12 text-right pag_bottom">
                                                        <ul class="pagination pagination-sm"><?php if (isset($links)) echo $links; ?></ul>	
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