


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
            <div class='scrollable-area'>
                <table class='data-table table table-striped' style='margin-bottom:0;'>
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
                                        <a class='btn btn-warning btn-xs' href='<?php echo base_url() . "admin/offers/edit/" . $o['offer_id']; ?>'>
                                            <i class='icon-edit'></i>
                                        </a>
                                        <a class='btn btn-danger btn-xs' onclick="return confirm('Are you sure you want to delete this offer?');" title="Delete Offer" href='<?php echo base_url() . "admin/offers/delete/" . $o['offer_id']; ?>'>
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
            </div>
        </div>
    </div>
</div>

    
