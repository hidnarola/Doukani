<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  | -------------------------------------------------------------------------
  | Hooks
  | -------------------------------------------------------------------------
  | This file lets you define "hooks" to extend CI without hacking the core
  | files.  Please see the user guide for info:
  |
  |	http://codeigniter.com/user_guide/general/hooks.html
  |
 */



/* End of file hooks.php */
/* Location: ./application/config/hooks.php */


$hook['post_controller_constructor'] = array(
    'class'    => 'Logincheck',
    'function' => 'isLogin',
    'filename' => 'logincheck.php',
    'filepath' => 'hooks'
);

$hook['post_controller_constructor'] = array(
    'class'    => 'Check_user_block',
    'function' => 'index',
    'filename' => 'check_user_block.php',
    'filepath' => 'hooks'
);

$hook['post_controller_constructor'] = array(
    'class' => 'Accesscheck',
    'function' => 'index',
    'filename' => 'accesscheck.php',
    'filepath' => 'hooks'
);  

// $hook['post_controller_constructor'] = array(
//     'class' => 'Check_subdomain',
//     'function' => 'index',
//     'filename' => 'check_subdomain.php',
//     'filepath' => 'hooks'
// );