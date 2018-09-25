<?php

$doesNotRequireLogin = array();
$permissions = array();
$doesNotRequireLogin['users']['signup'] = true;
$doesNotRequireLogin['users']['login'] = true;
$doesNotRequireLogin['users']['forget_password'] = true;
$doesNotRequireLogin['users']['reset_password'] = true;
$doesNotRequireLogin['users']['verify'] = true;
$doesNotRequireLogin['users']['signout'] = true;

/*
 * Permision for Admin role
 */
$permissions['admin']['home']['index'] = true;
$permissions['admin']['users']['profile'] = true;
$permissions['admin']['stores']['index'] = true;
$permissions['admin']['stores']['add'] = true;
$permissions['admin']['stores']['edit'] = true;
$permissions['admin']['stores']['delete'] = true;

/*
 * Permision for User role
 */
$permissions['user']['home']['index'] = true;
$permissions['user']['users']['profile'] = true;
$permissions['user']['users']['change_picture'] = true;

