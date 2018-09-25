<div class='row'>
    <div class='col-sm-12'>
        <div class='box bordered-box orange-border' style='margin-bottom:0;'>
            <div class='box-header orange-background'>
                <div class='title'>Banner List</div>
                <div class='actions'>
                    <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                    </a>
                </div>
            </div>
            <div class='box-content box-no-padding'>
                <div class='responsive-table'>
                    <div class='scrollable-area'>

                        <table class='data-table table table-bordered table-striped' style='margin-bottom:0;'>
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
                                    foreach ($superCategories as $superCategory) {
                                        ?>
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
                                            </td>
                                            <td align="center">
                                                <?php echo ucfirst($superCategory['ban_show_status']); ?>
                                            </td>
                                            <td  align="center">
                                                <?php echo $superCategory['pause_banner']; ?>
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
                                                <?php if ($type == 10) { ?>
                                                    <a class="btn btn-warning btn-xs" href="<?php echo base_url(); ?>admin/custom_banner/editvip/<?php echo $type; ?>/<?php echo $superCategory['ban_id']; ?>"><i class="icon-edit"></i></a>
                                                    <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>admin/custom_banner/deletevip/<?php echo $type; ?>/<?php echo $superCategory['ban_id']; ?>" onclick="return confirm('Are you sure you want to delete this record ?');"><i class="icon-trash"></i></a>
                                                <?php } else { ?>
                                                    <a class="btn btn-warning btn-xs" href="<?php echo base_url(); ?>admin/custom_banner/editcustom/<?php echo $type; ?>/<?php echo $superCategory['ban_id']; ?>"><i class="icon-edit"></i></a>
                                                    <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>admin/custom_banner/deletecustom/<?php echo $type; ?>/<?php echo $superCategory['ban_id']; ?>" onclick="return confirm('Are you sure you want to delete this record ?');"><i class="icon-trash"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
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