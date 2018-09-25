<?php foreach ($subcat as $sub) { ?>
    <div class="col-sm-6 col-md-6 col-lg-4 show_more_sub_cat">
        <a href="<?php echo base_url() . emirate_slug .$sub['sub_category_slug'] . '/' . $category_view . $order_option; ?>"><?php echo $sub['name']; ?> <span class="count">(<?php echo $sub['total']; ?>)</span></a>
    </div>
<?php } ?>