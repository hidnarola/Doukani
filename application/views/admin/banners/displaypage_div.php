<?php
if ($this->uri->segment(5) != '')
    $banner_for = $this->uri->segment(5);
else
    $banner_for = '';
?> 
<div class='box-content '>
    <select name="display_page" id="display_page" class='select2 form-control'>
        <option value="all" <?php
        if (isset($_GET['display_page']) && $_GET['display_page'] == 'all') {
            echo 'selected=selected';
        }
        ?>>All</option>
                <?php if ($banner_for == 'web') { ?>            
            <option value="all_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'all_page') {
                echo 'selected=selected';
            }
            ?>>All Classified Pages</option>

            <option value="home_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'home_page') {
                echo 'selected=selected';
            }
            ?>>Classified Home Page</option>

            <option value="bw_home_page_ban1" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'bw_home_page_ban1') {
                echo 'selected=selected';
            }
            ?>>Classified Home Page Banner 1</option>
            
            <option value="bw_home_page_ban2" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'bw_home_page_ban2') {
                echo 'selected=selected';
            }
            ?>>Classified Latest Ads Page</option>
            
            <option value="latest_ads_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'latest_ads_page') {
                echo 'selected=selected';
            }
            ?>>Classified Home Page Banner 2</option>
            
            <option value="content_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'content_page') {
                echo 'selected=selected';
            }
            ?>>Classified Content Page</option>

            <option value="store_all_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'store_all_page') {
                echo 'selected=selected';
            }
            ?>>Store All Pages</option>

            <option value="specific_store_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'specific_store_page') {
                echo 'selected=selected';
            }
            ?>>Specific Store Pages</option>

            <option value="store_content_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'store_content_page') {
                echo 'selected=selected';
            }
            ?>>Store Item Details Page</option>

            <option value="off_all_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'off_all_page') {
                echo 'selected=selected';
            }
            ?>>Offer All Pages</option>
            <option value="off_home_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'off_home_page') {
                echo 'selected=selected';
            }
            ?>>Offer Home Page</option>

            <option value="off_cat_cont" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'off_cat_cont') {
                echo 'selected=selected';
            }
            ?>>Category Wise Offers Page</option>

            <option value="off_comp_cont" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'off_comp_cont') {
                echo 'selected=selected';
            }
            ?>>Company Wise Offers Page</option>

            <option value="off_cat_side" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'off_cat_side') {
                echo 'selected=selected';
            }
            ?>>Categories Block on Offer's Home Page</option>

            <option value="off_comp_side" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'off_comp_side') {
                echo 'selected=selected';
            }
            ?>>Companies  Block on Offer's Home Page</option>

        <?php } elseif ($banner_for == 'mobile') { ?>

            <option value="all_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'all_page') {
                echo 'selected=selected';
            }
            ?>>All Pages</option>	
            <option value="home_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'home_page') {
                echo 'selected=selected';
            }
            ?>>Home Page</option>	
            <option value="content_page" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'content_page') {
                echo 'selected=selected';
            }
            ?>>Content Page</option>	

            <option value="after_splash_screen" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'after_splash_screen') {
                echo 'selected=selected';
            }
            ?>>After splash screen</option>	
            <option value="before_latest_ads" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'before_latest_ads') {
                echo 'selected=selected';
            }
            ?>>Before latest ads</option>
            <option value="before_featured_items" <?php
            if (isset($_GET['display_page']) && $_GET['display_page'] == 'before_featured_items') {
                echo 'selected=selected';
            }
            ?>>Before featured items</option>
                <?php } ?>
    </select>
    <br>                                                
</div>