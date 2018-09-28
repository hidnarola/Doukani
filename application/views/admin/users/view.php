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
                                    <?php
                                    $user_type = '';
                                    if ($user['user_role'] == 'generalUser') {
                                        $user_type = 'Classified User';
                                        echo "<i class='icon-user'></i>";
                                    } elseif ($user['user_role'] == 'storeUser') {
                                        $user_type = 'Store User';
                                        echo "<i class='icon-building'></i>";
                                    } elseif ($user['user_role'] == 'offerUser') {
                                        $user_type = 'Offer User';
                                        echo "<i class='icon-tags'></i>";
                                    }
                                    ?>
                                    <span>Users</span>
                                </h1>				
                            </div>
                            <hr class="hr-normal">
                            <?php if (isset($msg)): ?>
                                <div class='alert  <?php echo $msg_class; ?>'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>
                            <div class='row'>
                                <div class='col-sm-12 box'>
                                    <div class='box-header orange-background'>
                                        <div class='title'>
                                            <div class='fa fa-info-circle'></div>
                                            View User
                                        </div>						
                                    </div>
                                    <br>
                                    <div class='col-sm-3 col-lg-2'>
                                        <div class='box'>
                                            <div class='box-content'>
                                                <?php
                                                $profile_picture = '';

                                                $profile_picture = $this->dbcommon->load_picture($user['profile_picture'], $user['facebook_id'], $user['twitter_id'], $user['username'], $user['google_id'], 'original', 'user-profile');
                                                ?>                                                    
                                                <div id='preview' style="cursor: pointer; z-index:-100;">
                                                    <img class="img-responsive" alt="<?php echo $user['username']; ?>" id="exist" src="<?php echo $profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"/>
                                                </div>                                                        

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 col-lg-10 box">
                                        <div class='box-content box-double-padding'>
                                            <form  class='form form-horizontal validate-form' accept-charset="UTF-8" method='post' enctype="multipart/form-data">
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>User Type</label>                                        
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='USer Type' disabled class="form-control" type='text' value="<?php echo $user_type; ?>" >
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>E-mail</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='E-mail Address' disabled class="form-control" name="user_email" type='text' value="<?php echo $user['email_id']; ?>" data-rule-required='true' data-rule-email='true'>
                                                    </div>
                                                </div>
                                                <div class='form-group'>                       
                                                    <label class='col-md-2 control-label' for='inputText1'>First Name</label>
                                                    <div class='col-md-5 controls'>
                                                        <input title='First Name' class="form-control" disabled name='first_name'type='text' value="<?php echo $user['first_name']; ?>" data-rule-required='true'>                         
                                                    </div>
                                                </div>
                                                <div class='form-group'>                       
                                                    <label class='col-md-2 control-label' for='inputText1'>Last Name</label>
                                                    <div class='col-md-5 controls'>
                                                        <input title='Last Name' class="form-control" disabled name='last_name'type='text' value="<?php echo $user['last_name']; ?>" data-rule-required='true'>                         
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Username</label>
                                                    <div class='col-md-5 controls'>
                                                        <input title='Username' class="form-control" disabled name='user_username'type='text' value="<?php echo $user['username']; ?>" data-rule-required='true'>		                  
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Nickname</label>
                                                    <div class='col-md-5 controls'>
                                                        <input title='Nickname' class="form-control" disabled name='user_nick_name'type='text' value="<?php echo $user['nick_name']; ?>" data-rule-required='true'>		                  
                                                    </div>
                                                </div> 
                                                <!--                                                <div class='form-group'>
                                                                                                    <label class='col-md-2 control-label' for='inputText1'>PayPal E-mail</label>
                                                                                                    <div class='col-md-5 controls'>
                                                                                                        <input placeholder="PayPal E-mail" class="form-control" disabled name="paypal_email_id" id="paypal_email_id" type="text" value="<?php echo $user['paypal_email_id']; ?>"/>
                                                                                                    </div>
                                                                                                </div>-->
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Contact Number</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Phone' disabled class="form-control"  name="user_phone" type='text' value="<?php echo $user['phone']; ?>" data-rule-required='true' data-rule-number='true'/>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Nationality</label>
                                                    <div class='col-md-5 controls'>
                                                        <?php
                                                        foreach ($nationality as $n) :
                                                            if ($n['nation_id'] == $user['nationality']) {
                                                                ?>
                                                                <input type='text' disabled class='form-control' value= '<?php echo $n['name']; ?>' /> 
                                                            <?php } endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Country</label>
                                                    <div class='col-md-5 controls'>
                                                        <?php
                                                        foreach ($country as $o) :
                                                            if ($o['country_id'] == $user['country']) {
                                                                ?>
                                                                <input type='text' disabled class='form-control' value= '<?php echo $o['country_name']; ?>' /> 
                                                            <?php } endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'>Emirate</label>
                                                    <div class='col-md-5 controls'>
                                                        <?php
                                                        foreach ($state as $o) :
                                                            if ($o['state_id'] == $user['state']) {
                                                                ?>
                                                                <input type='text' disabled class='form-control' value= '<?php echo $o['state_name']; ?>' /> 
                                                            <?php } endforeach; ?>
                                                    </div>
                                                </div>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Address</label>
                                                    <div class='col-md-5 controls'>
                                                        <textarea class="form-control" disabled name="user_address"><?php echo $user['address']; ?> </textarea>
                                                    </div>
                                                </div>
                                                <?php if ($user['user_role'] == 'storeUser') { ?>  
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Instagram Link</label>
                                                        <div class='col-md-5 controls'>
                                                            <input type="text" class="form-control"  name="instagram_social_link" id="instagram_social_link"  value="<?php echo $user['instagram_social_link']; ?>" disabled />
                                                        </div>
                                                    </div>                                              
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Facebook Link</label>
                                                        <div class='col-md-5 controls'>
                                                            <input type="text" class="form-control"  name="facebook_social_link" id="facebook_social_link" value="<?php echo $user['facebook_social_link']; ?>" disabled  />
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Twitter Link</label>
                                                        <div class='col-md-5 controls'>
                                                            <input type="text" class="form-control"  name="twitter_social_link" id="twitter_social_link" value="<?php echo $user['twitter_social_link']; ?>" disabled />
                                                        </div>
                                                    </div>                                            
                                                <?php } ?>

                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Gender</label>
                                                    <div class='col-md-5 controls'>
                                                        <select class="form-control" name="gender" readonly>
                                                            <option value="1" <?php if ($user['gender'] == 1) echo 'selected'; ?>>Male</option>
                                                            <option value="0" <?php if ($user['gender'] == 0) echo 'selected'; ?>>Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class='form-group'>						
                                                    <label class='col-md-2 control-label' for='inputText1'>Birth Date</label>
                                                    <div class='col-md-5 controls'>
                                                        <input title='Nickname' class="form-control" disabled name='date_of_birth'type='text' value="<?php if (isset($user->date_of_birth) && $user->date_of_birth != '0000-00-00') echo $user[0]->date_of_birth; ?>" data-rule-required='true'>		                  
                                                    </div>
                                                </div>
                                                <!-- <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Emirate</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='Emirate' disabled class="form-control"  name="user_city" type='text' value="<?php echo $user['city']; ?>" />
                                                    </div>
                                                </div> -->	
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'></label>
                                                    <div class='col-md-5 controls'>
                                                        <label><input name="subscription" type="checkbox" checked />&nbsp;Newsletter Subscription</label>
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <label class='col-md-2 control-label' for='inputText1'></label>
                                                    <div class='col-md-5 controls'>
                                                        <label><input name="notification" type="checkbox" <?php if ($user['chat_notification'] == 1) echo 'checked'; ?> />&nbsp;Email Chat Notification</label>
                                                    </div>
                                                </div>
                                                <?php if (isset($user_type) && $user_type == 'offerUser') { ?>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Current Month's Ads</label>
                                                        <div class='col-md-5 controls'>
                                                            <input placeholder='' disabled class="form-control"  name="" type='text' value="<?php echo $user['currtotads']; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Current Month's Left Ads</label>
                                                        <div class='col-md-5 controls'>
                                                            <input placeholder='' disabled class="form-control"  name="" type='text' value="<?php echo $user['currleftads']; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class='form-group'>
                                                        <label class='col-md-2 control-label' for='inputText1'>Total Ads</label>
                                                        <div class='col-md-5 controls'>
                                                            <input placeholder='' disabled class="form-control"  name="" type='text' value="<?php
                                                            if ($user['totalads'] != '')
                                                                echo $user['totalads'];
                                                            else
                                                                echo $user['currtotads']
                                                                ?>" />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class='form-group'>
                                                    <label class='col-md-2 control-label' for='inputText1'>Total Posted Ads</label>
                                                    <div class='col-md-5 controls'>
                                                        <input placeholder='' disabled class="form-control"  name="" type='text' value="<?php
                                                        if ($user['totalpostedads'] != '')
                                                            echo $user['totalpostedads'];
                                                        else
                                                            echo $user['currleftads'];
                                                        ?>" />
                                                    </div>
                                                </div>
                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Followers</label>
                                                    <div class='col-md-5 controls'>
                                                        <a href='<?php echo base_url() . 'admin/users/followers/' . $user['user_id']; ?>' class="btn btn-primary" target="_blank">
                                                            <i class="fa fa-users"></i>&nbsp;Users List
                                                        </a>                                    
                                                    </div>
                                                </div>
                                                <div class='form-group'>                        
                                                    <label class='col-md-2 control-label' for='inputText1'>Following</label>
                                                    <div class='col-md-5 controls'>
                                                        <a href='<?php echo base_url() . 'admin/users/following/' . $user['user_id']; ?>' class="btn btn-primary" target="_blank">
                                                            <i class="fa fa-users"></i>&nbsp;Users List
                                                        </a>                                    
                                                    </div>
                                                </div>
                                                <div class="form-actions form-actions-padding-sm">
                                                    <div class="row">
                                                        <?php
                                                        if (!empty($_SERVER['QUERY_STRING']))
                                                            $path = '/?' . $_SERVER['QUERY_STRING'];
                                                        else
                                                            $path = '';
                                                        $redirect_path = base_url() . "admin/users/index/" . $user['user_role'] . $path;
                                                        ?>
                                                        <div class="col-md-10 col-md-offset-2">
                                                            <a href='<?php echo $redirect_path; ?>' title="Cancel" class="btn btn-primary">
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
                </div>
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?>
        <script>
            $(':input').attr('readonly', 'readonly');
            $("select").attr("disabled", "disabled");
            $(":input").attr("disabled", "disabled");
        </script> 
    </body>
</html>