<?php
$filename = dirname(__FILE__) . '/sitemap.txt';
$myfile = fopen($filename, "w");
$full_str = '';
foreach ($display_list as $url) {
    $full_str .= $url . "\n";
}
fwrite($myfile, $full_str);
$myfile = fopen($filename, "r") or die("Unable to open file!");
echo fread($myfile, filesize($filename));
fclose($myfile);
?>