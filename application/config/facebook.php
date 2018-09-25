<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


$config['facebook']['api_id'] = '1681712568714868';
//$config['facebook']['api_id'] = '1723840564495611';
$config['facebook']['app_secret'] = '6b16e02a19d46db2494469cfd9e3484e';
//$config['facebook']['app_secret'] = '27b67955338c962b979c707f926b051b';
//$config['facebook']['redirect_url'] = 'http://localhost/classified_application/login';
$config['facebook']['redirect_url'] = 'https://doukani.com/facebook_login';
// $config['facebook']['default_graph_version'] = 'v2.3';

// $config['facebook']['redirect_url'] = 'http://clientapp.narolainfotech.com/HD/classified_application/login';
$config['facebook']['permissions'] = array(
    'email',
    'user_location',
    'user_birthday',
    'user_friends',
    'public_profile'
);
?>
