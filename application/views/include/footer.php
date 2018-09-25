<?php
if (isset($store_url) && $store_url != '') {
    $__store_page = 1;
    $mypath_ = $store_url . '/';
} else
    $mypath_ = base_url();
?>
<?php if (!isset($store_home_page)) { ?>
    <!--<div class="whiteBGSpace"></div>-->
    <footer class="subscribe">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12 col-lg-12">
                    <form  name="form_subscribe" id="form_subscribe" method='post'>
                        <label class="col-lg-3">Subscription</label>
                        <div>
                            <input type="text" class="form-control  col-sm-4" placeholder="Email" name="email" id="email">
                            <button class="btn btn-default btn_subscribe" type="submit" name="subscribe" id="subscribe">Subscribe</button>
                            <h5 class="subscription_msg" style="display:none;">-</h5>
                        </div>
                        <p>Subscribe now to get updates on<br/> promotions and coupons.</p>
                    </form>
                </div>
            </div>  
        </div>
    </footer>
    <footer class="links">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-lg-12" itemscope itemtype="https://schema.org/SiteNavigationElement">
                    <?php foreach ($footer_menu as $menu) { ?>
                        <div class="five-div">
                            <h4><?php echo $menu['page_title']; ?></h4>
                            <br>
                            <?php if (!empty($menu['sub_menu'])) { ?>
                                <ul>
                                    <?php
                                    foreach ($menu['sub_menu'] as $sub_menu) {
                                        $url = HTTPS . website_url . $sub_menu['slug_url'];
                                        if ($sub_menu['direct_url'] != '')
                                            $url = $sub_menu['direct_url'];
                                        ?>
                                        <li><a href="<?php echo $url; ?>" itemprop="url"><?php if ($sub_menu['icon'] != '' || $sub_menu['icon'] != null) { ?><i class="fa <?php echo $sub_menu['icon']; ?>" style="background-color:<?php echo $sub_menu['color']; ?>;"></i><?php } echo '<span itemprop="name">' . $sub_menu['page_title'] . '</span>'; ?></a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <div class="five-div">
                        <form id="search_by_city_frm" name="search_by_city_frm">
                            <h4>Emirates</h4><br>
                            <ul  id="emirate_sel">
                                <?php foreach ($state as $st): ?>
                                    <li><a href="javascript:void(0);" data-state="<?php echo $st['state_name']; ?>" data-state-id="<?php echo $st['state_slug']; ?>" ><?php echo $st['state_name']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>  
        </div>  
    </footer> 
<?php } ?>
<div id="bottom" itemscope itemtype="https://schema.org/WPFooter">
    <footer class=" copyright">
        <div class="container">
            <div class="row">
                <?php $this->load->view('include/footer-bar'); ?>
            </div>
        </div>
    </footer>
    <div class="modal fade sure" id="search_alert" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">  
                    <h4 class="modal-title">Alert
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </h4>                   
                </div>
                <div class="modal-body">
                    <p class="response_message"></p>
                    <button type="button" class="btn btn-blue red-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:void(0);" class="scrollup"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
</div>
<?php $this->load->view('include/footer-common-js'); ?>