<title><?php echo (isset($page_title)) ? $page_title : 'Doukani'; ?></title>
<?php
//IOS Mobile    
if (!isset($_COOKIE['ios-appid-cookie'])) {
    setcookie('ios-appid-cookie', ios_app_id);
    $_COOKIE['ios-appid-cookie'] = ios_app_id;
    echo '<meta content="app-id=' . ios_app_id . '" name="apple-itunes-app">';
}
//
////Android Mobile
//if (!isset($_COOKIE['android-appid-cookie'])) {
//    setcookie('android-appid-cookie', android_app_id);
//    $_COOKIE['android-appid-cookie'] = android_app_id;
//    echo '<meta name="google-play-app" content="app-id=' . android_app_id . '">';
//}
?>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="oJpJlJv_8K4wnLKT6MW7dvtVn9TPGtYZL6sHZmHun_0" />
<link href='<?php echo HTTPS . website_url; ?>assets/admin/images/meta_icons/favicon.ico' rel='shortcut icon' type='image/x-icon'>
<link href="<?php echo HTTPS . website_url; ?>assets/front/dist/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo HTTPS . website_url; ?>assets/front/dist/font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" />

<link href='<?php echo HTTPS . website_url; ?>assets/front/dist/css/Open_Sans.css' rel='stylesheet' type='text/css'>
<link href="<?php echo HTTPS . website_url; ?>assets/front/stylesheets/bootstrap-select.css" rel="stylesheet">
<link href="<?php echo HTTPS . website_url; ?>assets/admin/stylesheets/plugins/select2/select2.css" media="all" rel="stylesheet" type="text/css" />
<link rel='stylesheet' type='text/css' href='<?php echo HTTPS . website_url; ?>assets/admin/stylesheets/icomoon/style.css' />
<link rel="stylesheet" href="<?php echo HTTPS . website_url; ?>assets/front/stylesheets/jquery.smartbanner.css" type="text/css" media="screen">
<link href="<?php echo HTTPS . website_url; ?>assets/front/style.css" rel="stylesheet">
<link href="<?php echo HTTPS . website_url; ?>assets/front/responsive.css" rel="stylesheet">
<link href='<?php echo HTTPS; ?>fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>

<script src="<?php echo HTTPS . website_url; ?>assets/front/dist/js/jquery.min.js"></script>
<script src="<?php echo HTTPS . website_url; ?>assets/front/dist/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/additional-methods.js" type="text/javascript"></script>
<script src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/theme.js" type="text/javascript"></script>

<link href="<?php echo HTTPS . website_url; ?>assets/admin/stylesheets/plugins/bootstrap_daterangepicker/bootstrap-daterangepicker.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?php echo HTTPS . website_url; ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css" media="all" rel="stylesheet" type="text/css" />
<link href="<?php echo HTTPS . website_url; ?>assets/admin/stylesheets/plugins/bootstrap_datetimepicker/datepicker.css" media="all" rel="stylesheet" type="text/css" />
<link rel='stylesheet' type='text/css' href='<?php echo HTTPS . website_url; ?>assets/admin/stylesheets/plugins/bootstrap_colorpicker/bootstrap-colorpicker.css'/>
<script src="<?php echo HTTPS . website_url; ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?php echo HTTPS . website_url; ?>assets/admin/javascripts/plugins/bootstrap_colorpicker/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<script src="<?php echo HTTPS . website_url; ?>assets/admin/javascripts/plugins/bootstrap_daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="<?php echo HTTPS . website_url; ?>assets/admin/javascripts/plugins/common/moment.min.js" type="text/javascript"></script>
<script src="<?php echo HTTPS . website_url; ?>assets/admin/javascripts/plugins/bootstrap_datetimepicker/bootstrap-datetimepicker.js" type="text/javascript"></script>

<script src="<?php echo HTTPS . website_url; ?>assets/front/javascripts/jquery.smartbanner.js"></script>
 <?php $this->load->view('include/google_tab_manager_head'); ?>
<?php
$controller = $this->router->fetch_class();
$method = $this->router->fetch_method();
?>
<meta property="og:type" content="website" />
<?php
$old = array('<br>','"');
$new = array(' ',' ');
?>
<?php if (($controller != 'pages' && $method != 'page')) { ?>
    <meta name="title" content="<?= (!empty($seo['title'])) ? $seo['title'] : (isset($page_title)) ? $page_title : ''; ?>">
    <meta name="Description" content="<?= (!empty($seo['description'])) ? str_replace($old, $new, $seo['description']) : ''; //(isset($description_) && !empty($description_)) ? $description_ : ''; ?>">
    <meta name="keyword" content="<?= (!empty($seo['keyword'])) ? $seo['keyword'] : ''; //(isset($keyword_) && !empty($keyword_)) ? $keyword_ : '' ; ?>">
<?php } ?>
<meta property="og:title" content="<?= (isset($page_title)) ? $page_title : 'Doukani'; ?>"/>
<meta property="og:url" content="<?= (isset($seo_url) && !empty($seo_url)) ? $seo_url : HTTP . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"/>
<meta property="og:site_name" content="Doukani"/>
<meta property="og:description" content="<?= (!empty($seo['description'])) ? str_replace($old, $new, $seo['description']) : '' ?>"/>

<?php if(isset($slug_for) && in_array($slug_for,array('category','sub_category'))) { ?>

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?= (isset($seo_url) && !empty($seo_url)) ? $seo_url : HTTP . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" >
<meta name="twitter:title" content="<?= (!empty($seo['title'])) ? $seo['title'] : $page_title ?>">
<meta name="twitter:description" content="<?= (!empty($seo['description'])) ? str_replace($old, $new, $seo['description']) : '' ?>">

<?php } else { ?>

<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?= (isset($seo_url) && !empty($seo_url)) ? $seo_url : HTTP . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" >
<meta name="twitter:title" content="<?= (isset($page_title)) ? $page_title : 'Doukani'; ?>">
<meta name="twitter:description" content="<?= (!empty($seo['description'])) ? str_replace($old, $new, $seo['description']) : '' ?>">

<?php } ?>

<?php $this->load->view('include/googleAnalytics'); ?>