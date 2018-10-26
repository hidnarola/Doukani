<div class="input-group-btn">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">                             
        <?php
        if (isset($category_name))
            echo $category_name . '&nbsp;';
        else
            echo 'Categories';
        ?>
        <span class="caret"></span></button>
    <ul class="dropdown-menu" role="menu">
        <?php
        if (in_array($this->uri->segment(1), array('alloffers', 'offers', 'companies')) ||
                (isset($offer_detail) && $offer_detail == 'yes') ||
                (isset($offer_company_page) && $offer_company_page == 'yes') ||
                (isset($company_followers_page) && $company_followers_page == 'yes')
        ) {
            ?>
            <li><a href="<?php echo HTTPS . website_url . 'offers'; ?>">All Categories</a></li>
            <?php foreach ($offer_category as $cat): ?>
                <li>
                    <a href="<?php echo HTTPS . website_url . 'offers/?cat_id=' . $cat['category_id']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></a>
                </li>
                <?php
            endforeach;
        } else {
            ?>
            <li><a href="<?php echo HTTPS . website_url . emirate_slug . 'search'; ?>">All Categories</a></li>
            <?php foreach ($category as $cat): ?>
                <li>
                    <a href="<?php echo HTTPS . website_url . emirate_slug . $cat['category_slug']; ?>"><?php echo str_replace('\n', " ", $cat['catagory_name']); ?></a>
                </li>
                <?php
            endforeach;
        }
        ?>
    </ul>
</div>
<?php
if (in_array($this->uri->segment(1), array('alloffers', 'offers', 'companies')) ||
        (isset($offer_detail) && $offer_detail == 'yes') ||
        (isset($offer_company_page) && $offer_company_page == 'yes') ||
        (isset($company_followers_page) && $company_followers_page == 'yes')
) {
    $search_path_ = HTTPS . website_url . 'offers';
} else {
    if (isset($category_name) && isset($category_slug))
        $search_path_ = HTTPS . website_url . emirate_slug . $category_slug;
    else
        $search_path_ = HTTPS . website_url . emirate_slug . 'search';
}
?>                    
<form  method="get" id="search_bar_frm" action="<?php echo $search_path_; ?>"> 
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "<?php echo HTTPS . website_url; ?>",
        "name" : "Doukani",
        "potentialAction": {
        "@type": "SearchAction",
        "target": "https://doukani.com/search/?s={s}",
        "query-input": "required name=s"
        }
        }
    </script>
    <input type="text" class="form-control" aria-label="..." value="<?php echo @$search_value ? strip_tags($search_value) : @strip_tags($_GET['s']); ?>" name="s" id="s">
    <input type="hidden" class="form-control" aria-label="..." value="<?php echo @$_GET['cat_id'] ? $_GET['cat_id'] : ''; ?>" name="cat_id">
    <input type="hidden" class="form-control" aria-label="..." value="<?php echo @$_GET['view'] ? $_GET['view'] : ''; ?>" name="view">
    <button type="submit" class="btn btn-link">
        <?php
        $this->load->view('svg_html/search');
        ?>  
    </button>
</form>