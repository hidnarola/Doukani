<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class='page-header page-header-with-buttons'>
                                <h1 class='pull-left'>
                                    <i class='icon-key'></i>
                                    <span>Accounts</span>
                                </h1>				
                            </div> 
                            <hr class="hr-normal">
                            <?php
                            $permission_array = explode(",", $permission[0]->permission);
                            ?>

                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            View Admin Account
                                        </div>
                                        <div class='actions'>
                                            <a class="btn box-collapse btn-xs btn-link" href="#"><i></i>
                                            </a>
                                        </div>
                                    </div>                                    
                                    <div class='box-content'>
                                        <form action='' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Username</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Username' disabled class="form-control" name="username" type='text'  value="<?php echo $user[0]->username; ?>"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Nickname</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Nickname' disabled class="form-control" name="nick_name" type='text' value="<?php echo $user[0]->nick_name; ?>"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Email Address</label>
                                                <div class='col-md-5 controls'>
                                                    <input placeholder='Email Address' disabled class="form-control" name="email_id" type='text'  value="<?php echo $user[0]->email_id; ?>"/>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Address</label>
                                                <div class='col-md-5 controls'>
                                                    <textarea placeholder="Address" disabled class="form-control" name="address" rows="4" cols="80"><?php echo $user[0]->address; ?></textarea>              				
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Phone</label>
                                                <div class='col-md-5 controls'>
                                                    <input class='form-control' disabled id='phone' placeholder='Phone' type='text' name="phone" value="<?php echo $user[0]->phone; ?>"  > 
                                                </div>
                                            </div>
                                            <div class="form-group" >
                                                <label class='col-md-2 control-label' for='inputText1'>Emirate</label>
                                                <div class='col-md-5 controls'>
                                                    <select id="sub_state_list" name="state" class="select2 form-control" disabled>
                                                        <option value="0">Select Emirate</option>
                                                        <?php foreach ($state as $o) { ?>
                                                            <option value="<?php echo $o['state_id']; ?>" <?php echo ($user[0]->state == $o['state_id']) ? 'selected' : ''; ?> ><?php echo $o['state_name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>    
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label' for='inputText1'>Chat Notification</label>
                                                <div class='col-md-5 controls'>
                                                    <input class='' id='chat_notification' type='checkbox' name="chat_notification" value="1"  <?php if ($user[0]->chat_notification == 1) echo 'checked'; ?> disabled>
                                                </div>
                                            </div>
                                            <div class='form-group'>
                                                <label class='col-md-2 control-label'>Permissions</label>
                                                <div class='col-md-10'>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('dashboard', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='dashboard' name="chk_0">
                                                            Dashboard
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('classified', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='classified' name="chk_1">
                                                            Classifieds
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('offer_mgt', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='offer_mgt' name="chk_2">
                                                            Offers Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('user_mgt', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='user_mgt' name="chk_3">
                                                            Users Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox'<?php
                                                            if (in_array('system_mgt', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='system_mgt' name="chk_4">
                                                            System Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('page_mgt', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='page_mgt' name="chk_5">
                                                            Pages Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('store_mgt', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='store_mgt' name="chk_6" >
                                                            Store Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('push notification', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='push_notification' name="chk_7">
                                                            Push Notification
                                                        </label>
                                                    </div>

                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('message_mgt', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='message_mgt' name="chk_8">
                                                            Buyer Seller Conversation
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('order_mgt', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='order_mgt' name="chk_10">
                                                            Order Management
                                                        </label>
                                                    </div>
                                                    <div class='checkbox'>
                                                        <label>
                                                            <input disabled type='checkbox' <?php
                                                            if (in_array('only_listing', $permission_array)) {
                                                                echo 'checked';
                                                            }
                                                            ?> value='only_listing' name="chk_7">
                                                            Only Listing
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions form-actions-padding-sm">
                                                <div class="row">
                                                    <?php 
                                                    $redirect = $_SERVER['QUERY_STRING'];
                                                    if(!empty($_SERVER['QUERY_STRING']))
                                                        $redirect = '/?'.$redirect;
                                                    ?>
                                                    <div class="col-md-10 col-md-offset-2">
                                                        <a href="<?php echo base_url().'admin/systems/accounts'.$redirect ?>" title="Cancel" class="btn btn-primary">
                                                            Back
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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