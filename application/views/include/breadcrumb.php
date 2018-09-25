<?php if (isset($breadcrumbs) && sizeof($breadcrumbs) > 0) { ?>
    <ol class="breadcrumb no-margin" itemscope itemtype="https://schema.org/BreadcrumbList">
        <?php
        $numItems = count($breadcrumbs);
        $dd = 0;
        $link_pos = 1;
        foreach ($breadcrumbs as $key => $value) {
            if ($key != '') {
                ?>
                <li class="<?php echo ( ++$dd === $numItems) ? 'active' : ''; ?>" itemprop="itemListElement" itemscope itemtype="httpd://schema.org/ListItem">
                    <a href="<?php echo $value; ?>" itemscope itemtype="https://schema.org/Thing" itemprop="item"><span itemprop="name"><?php echo str_replace('\n', " ", $key); ?></span></a>
                    <meta itemprop="position" content="<?php echo $link_pos; ?>" />
                </li>
        <?php
            $link_pos++;
            } else {
            $dd++;
        }
    }
    ?>
    </ol>
<?php } ?>