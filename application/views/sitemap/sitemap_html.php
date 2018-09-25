<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <title>HTML Sitemap</title>
        <meta id="MetaDescription" name="description" content="Sitemap created using Xml Sitemap Generator .org - the free online Google XML sitemap generator" />
        <meta id="MetaKeywords" name="keywords" content="XML Sitemap Generator" />
        <meta content="Xml Sitemap Generator .org" name="Author" />
        <style>
            body, head, #xsg {margin:0px 0px 0px 0px; line-height:22px; color:#666666; width:100%; padding:0px 0px 0px 0px; 
                              font-family : Tahoma, Verdana,   Arial, sans-serif; font-size:13px;}
            #xsg ul li a {font-weight:bold; }
            #xsg ul ul li a {font-weight:normal; }
            #xsg a {text-decoration:none; }
            #xsg p {margin:10px 0px 10px 0px;}
            #xsg ul {list-style:square; }
            #xsg li {}
            #xsg th { text-align:left;font-size: 0.9em;padding:2px 10px 2px 2px; border-bottom:1px solid #CCCCCC; border-collapse:collapse;}
            #xsg td { text-align:left;font-size: 0.9em; padding:2px 10px 2px 2px; border-bottom:1px solid #CCCCCC; border-collapse:collapse;}
            #xsg .title {font-size: 0.9em;  color:#132687;  display:inline;}
            #xsg .url {font-size: 0.7em; color:#999999;}
            #xsgHeader { width:100%; float:left; margin:0px 0px 5px 0px; border-bottom:2px solid #132687; }
            #xsgHeader h1 {  padding:0px 0px 0px 20px ; float:left;}
            #xsgHeader h1 a {color:#132687; font-size:14px; text-decoration:none;cursor:default;}
            #xsgBody {padding:10px;float:left;}
            #xsgFooter { color:#999999; width:100%; float:left; margin:20px 0px 15px 0px; border-top:1px solid #999999;padding: 10px 0px 10px 0px; }
            #xsgFooter a {color:#999999; font-size:11px; text-decoration:none;   }    
            #xsgFooter span {color:#999999; font-size:11px; text-decoration:none; margin-left:20px; }  
        </style>
        <?php $this->load->view('include/google_tab_manager_head'); ?>
    </head>
    <body>
        <?php $this->load->view('include/google_tab_manager_body'); ?>
        <div id="xsg">
            <div id="xsgHeader">
                <h1><a href="https://XmlSitemapGenerator.org/sitemap-generator.aspx" title="Sitemap Generator">HTML Sitemap</a></h1>
            </div>
            <div id="xsgBody">
                <ul>
                    <li>
                        <a href="<?php echo HTTPS . website_url; ?>"><span class="title"><?php echo home_title; ?></span></a>
                        <ul>
                            <li><a href="<?php echo $site_url . 'registration'; ?>"><span class="title">Sign up</span></a></li>
                            <li><a href="<?php echo $site_url . 'login'; ?>"><span class="title">Login</span></a></li>
                            <li><a href="<?php echo $site_url . 'login/forget_password'; ?>"><span class="title">Forgot Password</span></a></li>
                            <li><a href="<?php echo $site_url . 'latest'; ?>"><span class="title">Latest Ads</span></a></li>
                            <li><a href="<?php echo $site_url . 'featured_ads'; ?>"><span class="title">Featured Ads</span></a></li>
                            <li><a href="<?php echo $site_url . 'advanced_search'; ?>"><span class="title">Advanced Search</span></a></li>                    
                            <li>
                                <a href="<?php echo $site_url . 'categories'; ?>"><span class="title">Category List</span></a>
                                <ul>
                                    <?php if (isset($category_list) && sizeof($category_list)) {
                                        foreach ($category_list as $list) {
                                            ?> 
                                            <li><a href="<?php echo $site_url . $list['category_slug']; ?>"><span class="title"><?php echo $list['catagory_name']; ?></span></a></li>
                                        <?php }
                                    } ?>
                                    <?php if (isset($sub_categories) && sizeof($sub_categories)) {
                                        foreach ($sub_categories as $list) {
                                            ?> 
                                            <li><a href="<?php echo $site_url . $list['sub_category_slug']; ?>"><span class="title"><?php echo $list['sub_category_name']; ?></span></a></li>
                                <?php }
                            } ?>
                                </ul>
                            </li>
                            <?php
                            if (isset($pages) && sizeof($pages) > 0) {
                                foreach ($pages as $p) {
                                    ?>
                                    <li><a href="<?php echo $site_url . $p['slug_url']; ?>"><span class="title"><?php echo $p['page_title']; ?></span></a></li>
                                        <?php }
                                    } ?>
                            <li>
                                <a href="<?php echo $site_url. 'search'; ?>"><span class="title">Classified Ads List</span></a>
                                <ul>
<?php
if (isset($classified_products) && sizeof($classified_products) > 0) {
    foreach ($classified_products as $list) {
        ?>
                                            <li><a href="<?php echo $site_url . $list['product_slug']; ?>"><span class="title"><?php echo $list['product_name']; ?></span></a></li>
                                        <?php }
                                    } ?>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo HTTPS .website_url. 'stores'; ?>"><span class="title">Store Ads List</span></a>
                                <ul>
<?php
if (isset($store_products) && sizeof($store_products) > 0) {
    foreach ($store_products as $list) {
        ?>
                                            <li><a href="<?php echo HTTP . $list['store_domain'] . after_subdomain . '/' . $list['product_slug']; ?>"><span class="title"><?php echo $list['product_name']; ?></span></a></li>
                                        <?php }
                                    } ?>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo $site_url. 'offers'; ?>"><span class="title">Offers</span></a>
                                <ul>
                                    <?php
                                    if (isset($offers) && sizeof($offers) > 0) {
                                        foreach ($offers as $list) {
                                            ?>
                                            <li><a href="<?php echo $site_url . $list['user_slug'] . '/' . $list['offer_slug']; ?>"><span class="title"><?php echo $list['offer_title']; ?></span></a></li>
    <?php }
} ?>
                                </ul>
                            </li>
                            <li>
                                <a href="#"><span class="title">Classified Sellers</span></a>
                                <ul>
                                    <?php
                                    if (isset($users) && sizeof($users) > 0) {
                                        foreach ($users as $list) {
                                            ?>
                                            <li><a href="<?php echo $site_url . $list['user_slug']; ?>"><span class="title"><?php echo ($list['nick_name'] != "") ? $list['nick_name'] : $list['username']; ?></span></a></li>
    <?php }
} ?>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo HTTPS .website_url. 'stores'; ?>"><span class="title">Stores List</span></a>
                                <ul>
                                    <?php
                                    if (isset($stores) && sizeof($stores) > 0) {
                                        foreach ($stores as $list) {
                                            ?>
                                            <li><a href="<?php echo HTTP . $list['store_domain'] . after_subdomain; ?>"><span class="title"><?php echo $list['store_name']; ?></span></a></li>
    <?php }
} ?>
                                </ul>
                            </li>
                            <li>
                                <a href="<?php echo HTTPS .website_url. 'companies'; ?>"><span class="title">Company List</span></a>
                                <ul>
<?php
if (isset($companies) && sizeof($companies) > 0) {
    foreach ($companies as $list) {
        ?>
                                            <li><a href="<?php echo $site_url . $list['user_slug']; ?>"><span class="title"><?php echo $list['company_name']; ?></span></a></li>
    <?php }
} ?>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!--<guid value="7339ae5d-f867-44d3-844d-3c85b1a26350" />--><!--Created using XmlSitemapGenerator.org - Free HTML, RSS and XML sitemap generator-->
            </div>
            <div id="xsgFooter">
                <span></span><a href="https://XmlSitemapGenerator.org/sitemap-generator.aspx" target="_blank" title="Online Sitemap Generator">Online Sitemap Generator</a>
                <span></span><a href="http://g-mapper.co.uk/sitemap-generator.aspx" target="_blank" title="Sitemap Generator Download">Sitemap Generator Download</a>
            </div>
        </div>
    </body>
</html>