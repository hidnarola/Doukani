    
<table class='table  table-striped more_cat' style='margin-bottom:0;'>				

    <?php
    if (!empty($category)):
        foreach ($category as $cat) {
            ?>
            <tr id="<?php echo $cat['category_id'] ?>">
                <td style="display: none;"><?php echo $cat['cat_order']; ?></td>
                <td style="color: <?php echo $cat['color']; ?>;"><span><i class="fa <?php echo $cat['icon'] ?>"></i></span> <?php echo preg_replace('/\v+|\\\[rn]/', '', $cat['catagory_name']); ?></td>
                <td>
                    <?php if (!empty($cat['category_image'])): ?>
                        <a data-lightbox='flatty' href='<?php echo base_url() . category . "original/" . $cat['category_image']; ?>'>
                            <img alt="Category Image" style="height: 40px; width: 64px;" src="<?php echo base_url() . category . "small/" . $cat['category_image']; ?>" onerror="this.src='<?php echo site_url(); ?>assets/upload/No_Image.png'"/>
                        </a>
                    <?php endif; ?>
                </td>
                <td><a href='<?php echo base_url(); ?>admin/classifieds/subCategories/<?php echo $cat['category_id']; ?>' title="Add Store" class="btn">
                        Manage Sub Category
                    </a>
                </td>
                <td>
                    <a class='btn btn-warning btn-xs has-tooltip' data-placement='top' title='Edit' href='<?php echo base_url() . "admin/classifieds/categories_edit/" . $cat['category_id']; ?>'>
                        <i class='icon-edit'></i>
                    </a>
                    <a class='btn btn-danger btn-xs has-tooltip' data-placement='top' title='Delete' onclick="return confirm('Are you sure you want to delete this category?');" title="Delete User" href='<?php echo base_url() . "admin/classifieds/categories_delete/" . $cat['category_id']; ?>'>
                        <i class='icon-trash'></i>
                    </a>
                </td>
            </tr>
            <?php
        }
    endif;
    ?>				
</table>      
<script>
    $("tbody").sortable({
        cursor: "move",
        start: function (event, ui) {
            // 0 based array, add one
            start = ui.item.prevAll().length + 1;
        },
        update: function (event, ui) {
            // 0 based array, add one                            
            end = ui.item.prevAll().length + 1;
            var state = '';
            if (start > end) {
                state = 'up';
            } else {
                state = 'down';
            }
            var newOrder = $(this).sortable('toArray').toString();
            //        alert(newOrder);
            var newOrder = $(this).sortable('toArray');
            //        alert(newOrder);
            $.post("<?php echo base_url() ?>admin/classifieds/order_category", {order: newOrder});
            var id = ui.item.context.children[0].innerHTML;
        }
        // end of drag
    });
</script>			