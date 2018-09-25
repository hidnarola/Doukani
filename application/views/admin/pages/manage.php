<!DOCTYPE html>
<html>
    <head>
        <?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb store'>
        <?php $this->load->view('admin/include/header'); ?>
        <div id='wrapper'>
            <?php $this->load->view('admin/include/left-nav'); ?>
            <section id='content'>
                <div class='container'>
                    <div class='row' id='content-wrapper'>
                        <div class='col-xs-12'>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-header">
                                        <h1 class='pull-left'>
                                            <i class='icon-book'></i>
                                            <span>Manage Pages</span>
                                        </h1>
                                        
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-normal">
                            <?php if (isset($msg)): ?>
                                <div class='alert  alert-info alert-dismissable'>
                                    <a class='close' data-dismiss='alert' href='#'>&times;</a>
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>

                            <div class='col-md-12'>
                                <div class="col-md-6">
                                    <div class="title col-md-12">Header Menu</div>
                                    <ul id="show_in_header" class="sortable col-md-12">
                                        <?php foreach ($header_menu as $menu) { ?>
                                            <li id="<?php echo $menu['page_id']; ?>" class="ui-state-default"><?php echo $menu['page_title']; ?></li>
                                       <?php } ?>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <div class="title col-md-12">Footer Menu</div>

                                    <ul id="show_in_footer" class="accordion sortable col-md-12">
                                        <?php foreach ($footer_menu as $menu) { ?>
                                            <li id="<?php echo $menu['page_id']; ?>" class="ui-state-default <?php echo (!empty($menu['sub_menu'])) ? 'hasItems' : ''; ?>"><span class="toggle"><?php echo $menu['page_title']; ?></span>
                                            <?php 
                                            if(!empty($menu['sub_menu'])){ ?>
                                                <ul class="sublist">
                                                 <?php foreach ($menu['sub_menu'] as $sub_menu) { ?>
                                                 <li id="<?php echo $sub_menu['page_id']; ?>" class="ui-state-default"><?php echo $sub_menu['page_title']; ?></li>
                                                 <?php } ?>   
                                                </ul>
                                           <?php } ?>
                                           </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php $this->load->view('admin/include/footer-script'); ?> 
        <script>
       $("ul.accordion").accordion({
    collapsible: true,
    active: false,
    heightStyle: "content"
  });
        $(function() {
   
            $("ul.sortable").sortable({
                //cursor: "move",
                connectWith: 'ul.sortable',
                 beforeStop: function(ev, ui) {
                if ($(ui.item).hasClass('hasItems') && $(ui.placeholder).parent()[0] != this) {
                    $(this).sortable('cancel');
                }
            },
        
            start: function(event, ui) {
                // 0 based array, add one
                start = ui.item.prevAll().length + 1;
                console.log(ui.item.prevAll());
                console.log(start);
            },
            update: function(event, ui) {
                // 0 based array, add one                            
                end = ui.item.prevAll().length + 1;
                console.log(ui.item.prevAll());
                console.log(end);
                var state = '';
                if (start > end) {
                    state = 'up';
                } else {
                    state = 'down';
                }
                var newOrder = $(this).sortable('toArray').toString();
                //        alert(newOrder);
                var newOrder = $(this).sortable('toArray');
                var menu = $(this).attr('id');
                //        alert(newOrder);
                console.log(newOrder);
                $.post("<?php echo base_url() ?>admin/pages/order_pages", {order: newOrder});
                var id = ui.item.context.innerHTML;
            }
            // end of drag
        });
    $('ul.sublist').sortable({
        connectWith: 'ul.sublist',
        start: function(event, ui) {
                // 0 based array, add one
                start = ui.item.prevAll().length + 1;
                console.log(ui.item.prevAll());
                console.log(start);
            },
            update: function(event, ui) {
                // 0 based array, add one                            
                end = ui.item.prevAll().length + 1;
                console.log(ui.item.prevAll());
                console.log(end);
                var state = '';
                if (start > end) {
                    state = 'up';
                } else {
                    state = 'down';
                }
                var newOrder = $(this).sortable('toArray').toString();
                //        alert(newOrder);
                var newOrder = $(this).sortable('toArray');
                var menu = $(this).attr('id');
                //        alert(newOrder);
                console.log(newOrder);
                $.post("<?php echo base_url() ?>admin/pages/order_pages", {order: newOrder});
                var id = ui.item.context.innerHTML;
            }
    });
    
    $( "ul, li" ).disableSelection();
  });
  </script>
    </body>
</html>
