
<div class='box bordered-box orange-border' style='margin-bottom:0;'>
    <div class='box-header orange-background'>
        <div class='title'>
            <?php
            if (!empty($users)) {
                if ($users[0]['user_role'] == "generalUser") {
                    echo "Classified User List";
                } elseif ($users[0]['user_role'] == "offerUser") {
                    echo 'Offer User List';
                } elseif ($users[0]['user_role'] == "storeUser") {
                    echo 'Virtual Store User List';
                }
            } else {
                echo "User List";
            }
            ?>
        </div>
        <div class='actions'>
            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
            </a>
        </div>
    </div>
    <div class='box-content box-no-padding'>
        <div class='responsive-table'>
            <div class='scrollable-area'>
                <form id="userForm" action="" method="POST"><!-- data-table-->
                    <table class=' table  table-striped' style='margin-bottom:0;'>
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Block/Unblock</th>
                                <th>Registered Date</th>
                                <!-- <th>UDID number</th> -->
                                <!-- <th>User type iOS/Android</th> -->
                                <!-- <th>Action Register</th> -->
                                <th>Remaining Ads</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                            if (!empty($users)):
                                foreach ($users as $u) {
                                    ?>
                                    <tr>
                                        <td><?php echo $u['email_id']; ?></td>
                                        <td><?php echo $u['phone']; ?></td>
                                        <td>
                                            <?php if ($u['user_block'] == 0) { ?>
                                                <a onclick="block(<?php echo $u['user_id'] ?>);" class='btn btn-warning btn-xs' href="#"><i class='icon-lock'></i> Block</a>
                                            <?php } else { ?>
                                                <a onclick="unblock(<?php echo $u['user_id'] ?>);" class='btn btn-success btn-xs' href="#"><i class='icon-unlock'> </i>UnBlock</a> 
                                            <?php } ?>
                                        </td>
                                        <td><?php echo date('Y-m-d', strtotime($u['user_register_date'])); ?></td>
                                        <!-- <td><?php //echo $u['device_identifier']; ?></td> -->
                                        <!-- <td class="text-center"> 
                                            <?php //if ($u['device_type'] == 1) { ?>
                                                <i class="icon-apple" style="font-size: 28px;color: #606060;" ></i>
                                            <?php //} else if ($u['device_type'] == 2) { ?>
                                                <i class="icon-android" style="font-size: 28px;color: #A4C639;"></i>
                                            <?php //} ?>
                                        </td> -->
                                        <!-- <td></td>  -->
                                        <td><?php echo $u['userAdsLeft']; ?></td>
                                        <td>
                                            <div class='text-right'>
												<?php if ($u['user_role'] == 'generalUser' && $u['userAdsLeft']>0) { ?>
													<a onclick="block(<?php echo $u['user_id'] ?>);" class='btn  btn-danger btn-xs' href="<?php echo site_url(). 'admin/classifieds/listings_add?userid='.$u['user_id']; ?>"><i class='icon-lock'></i> Ad Post</a>
												<?php } ?> 
                                                <a class='btn btn-xs send_message has-tooltip' data-placement='top' title='Email' data-id="<?php echo $u['user_id']; ?>" title="Send message to user">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                                <a class='btn btn-success btn-xs has-tooltip' data-placement='top' title='View' href='<?php echo base_url() . "admin/users/view/" . $u['user_id']; ?>'>
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                                <a class='btn btn-warning btn-xs has-tooltip' data-placement='top' title='Edit' title="Edit User" href='<?php echo base_url() . "admin/users/edit/" . $u['user_id']; ?>'>
                                                    <i class='icon-edit'></i>
                                                </a>
                                                <a class='btn btn-danger btn-xs has-tooltip' data-placement='top' title='Delete' onclick="return confirm('Are you sure you want to delete this user?');" title="Delete User" href='<?php echo base_url() . "admin/users/delete/" . $u['user_id']; ?>'>
                                                    <i class='icon-trash'></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            endif;
                            ?>
                        </tbody>
                    </table>
                    <?php if (!empty($users)) { ?>
                        <input type="hidden" name="redirectUrl" value="<?php echo base_url() . "admin/users/index/" . $users[0]['user_role']; ?>" />
                    <?php } ?>
                </form>
				<div class="col-sm-12 text-right pag_bottom">
					<ul class="pagination pagination-sm"><?php if(isset($links)) echo $links; ?></ul>	
				</div>
            </div>
        </div>
    </div>
</div>


