<header>
    <nav class='navbar navbar-default'>
        <a class='navbar-brand' href='<?php echo base_url(); ?>admin/'>
            <i class='icon-heart-empty'></i>
            <span class='hidden-phone'>Classified Application</span>
        </a>
        <a class='toggle-nav btn pull-left' href='#'>
            <i class="fa fa-bars"></i>
        </a>
        <ul class='nav'>
            <li class='dropdown dark user-menu'>
                <?php
                $user = $this->session->userdata('user');                
                $name = explode('@', $user->email_id);
                ?>
                <a class='dropdown-toggle' data-toggle='dropdown' href='#'>
                    <?php if (!empty($user->profile_picture)): ?>
                        <img width="23" height="23" alt="<?php echo $user->username; ?>" src="<?php echo base_url() . profile."original/" . $user->profile_picture; ?>" onerror="this.src='<?php echo base_url() ?>assets/upload/avtar.png'"/>
                    <?php endif; ?>
                    <span class='user-name'><?php echo $user->username; ?></span>
                    <b class='caret'></b>
                </a>
                <ul class='dropdown-menu'>
                    <li>
                        <a href='<?php echo base_url() . "admin/users/profile" ?>'>
                            <i class='icon-user'></i>
                            Profile
                        </a>
                    </li>
                    <!-- <li>
                        <a href='user_profile.html'>
                            <i class='icon-cog'></i>
                            Settings
                        </a>
                    </li> -->
                    <li class='divider'></li>
                    <li>
                        <a href='<?php echo base_url() . "admin/users/signout"; ?>'>
                            <i class='icon-signout'></i>
                            Sign out
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>