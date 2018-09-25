<?php
if ($this->uri->segment(5) != '')
    $banner_for = $this->uri->segment(5);
else
    $banner_for = '';
?>  
<div class='box-content '>
    <select name="ban_name_0" id="ban_type" class='select2 form-control' onchange="show_banner('<?php echo $this->uri->segment(4) ?>', this.value);" >
        <option value="all" <?php
        if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'all') {
            echo 'selected=selected';
        }
        ?>>All</option>
                <?php if ($banner_for == 'web') { ?>            
            <option value="header" <?php
            if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'header') {
                echo 'selected=selected';
            }
            ?>>Header Banner</option>
            <option value="sidebar" <?php
            if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'sidebar') {
                echo 'selected=selected';
            }
            ?>>Sidebar Banner</option>
            <option value="between" <?php
            if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'between') {
                echo 'selected=selected';
            }
            ?>>Between Banner</option>
                <?php } elseif ($banner_for == 'mobile') { ?>
            <option value="intro" <?php
            if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'intro') {
                echo 'selected=selected';
            }
            ?>>Intro Banner </option>	
            <option value="feature" <?php
            if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'feature') {
                echo 'selected=selected';
            }
            ?>>Feature Banner</option>	
            <option value="footer" <?php
            if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'footer') {
                echo 'selected=selected';
            }
            ?>>Footer Banner </option>	
            <option value="between_app" <?php
            if (isset($_GET['ban_name_0']) && $_GET['ban_name_0'] == 'between_app') {
                echo 'selected=selected';
            }
            ?>>Between Banner</option>
                <?php } ?>                                                    
    </select>
    <br>
</div> 