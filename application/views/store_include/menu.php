<div class="HeaderSecound <?php if (in_array($this->uri->segment(1), array('allstores', 'store_search')) || (isset($store_page) && in_array($store_page, array('store_page', 'store_followers_page')))) {
    echo 'store_pages_header';
} ?>">
    <div class="col-lg-6 col-md-7 col-sm-6 Header_Left  <?php if (in_array($this->uri->segment(1), array('allstores', 'store_search')) || (isset($store_page) && in_array($store_page, array('store_page', 'store_followers_page')))) {
    echo 'store_header_left';
} ?>">
        <div class=" menu">
            <div class="menuToggle">Menu</div>
            <ul class="nav navbar-nav page_menuk">
                <li><a href="<?php echo HTTPS . website_url; ?>">HOME</a></li>				
                <?php
                if (!empty($header_menu)) {
                    foreach ($header_menu as $page) {
                        $page_url = HTTPS . website_url . $page['slug_url'];
                        if ($page['direct_url'] != '')
                            $page_url = $page['direct_url'];
                        ?>
                        <li><a href="<?php echo $page_url; ?>"><?php echo strtoupper($page['page_title']); ?> </a></li>
                        <?php
                    }
                }
                $pages_fields = ' page_id, page_title, slug_url, parent_page_id,direct_url ';
                $array = array('page_state' => 1, 'page_id' => 23);
                $header_menu = $this->dbcommon->get_specific_colums('pages_cms', $pages_fields, $array, 'order', 'asc');

                if ($header_menu[0]['direct_url'] != '')
                    $contact_url = $header_menu[0]['direct_url'];
                else
                    $contact_url = $header_menu[0]['slug_url'];
                ?>
                <li><a href="<?php echo HTTPS . website_url . $contact_url; ?> "><?php echo strtoupper($header_menu[0]['page_title']); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-6 col-md-5 col-sm-6 Header_Right">
        <div class="nation">            
            <div class="dropdownDIV"> 
                <div class="dropdown Country">					
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <img src="<?php echo HTTPS . website_url; ?>assets/front/images/United Arab Emirates.png" />UAE
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a href="#" tabindex="-1" role="menuitem">More Countries Coming Soon</a></li>					
                    </ul>
                </div>
                <?php
                $request_for_statewise = '';
                $request_for_statewise = $this->session->userdata('request_for_statewise');
                ?>                                
                <div class="dropdown AllCity">
                    <input type="hidden" name="selection">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="false">
                        <?php
                        if (isset($selected)) {
                            if ($selected != '' && $selected != 'all') {
                                echo $selected;
                            } else {
                                echo 'All Cities (UAE)';
                            }
                        } else {
                            echo 'All Cities (UAE)';
                        }
                        ?>
                        <span class="caret"></span>
                    </button>
                    <ul id="select_emirate" role="menu" class="dropdown-menu" aria-labelledby="dropdownMenu1"> 
                        <li role="presentation"><a role="menuitem" data-state="all" tabindex="-1" href="#">All Cities (UAE)</a></li>
                        <?php foreach ($state as $st) { ?>
                            <li role="presentation"><a href="javascript:void(0);" role="menuitem" data-state="<?php echo $st['state_name']; ?>" data-state-id="<?php echo $st['state_id']; ?>" tabindex="-1"><?php echo $st['state_name']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>			
            <button class="btn btn-app" onclick="call_app();"><img src="<?php echo HTTPS . website_url; ?>/assets/front/images/app-img.jpg"></button>
        </div>
    </div>

</div>
<script>
    $('.menuToggle').click(function () {
        $('.menu ul').slideToggle();
    });

    function call_app() {
        //window.location.href = '<?php //echo doukani_app;         ?>';	
        window.open('<?php echo doukani_app; ?>', '_blank');
    }
</script>