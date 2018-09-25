<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/javascripts/plugins/validate/additional-methods.js" type="text/javascript"></script> 	
<link rel="stylesheet" href="<?php echo site_url(); ?>/assets/front/stylesheets/file_upload_css/style.css">
<script src="<?php echo site_url(); ?>assets/front/javascripts/file_upload_js/vendor/jquery.ui.widget.js"></script>
<script src="<?php echo site_url(); ?>assets/admin/javascripts/blueimp/tmpl.min.js"></script>

<link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/nanoscroller.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/emoji.css" rel="stylesheet">  		
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/nanoscroller.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/util.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/config.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/jquery.emojiarea.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/jquery.emojiareaP.js"></script> -->
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/emoji-picker.js"></script>
<link href="<?php echo base_url(); ?>assets/front/stylesheets/inbox.css" rel="stylesheet">
<!-- <link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/bootstrap.min.css" rel="stylesheet">  
<link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/cover.css" rel="stylesheet">  -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">  
<link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/nanoscroller.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/front/stylesheets/emojis/emoji.css" rel="stylesheet">  		  

<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/nanoscroller.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/tether.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/util.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/config.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/jquery.emojiarea.js"></script>
<script src="<?php echo base_url(); ?>assets/front/javascripts/emojis/emoji-picker.js"></script>

  <script>
	
    $(function() {
      // Initializes and creates emoji set from sprite sheet
      window.emojiPicker = new EmojiPicker({
        emojiable_selector: '[data-emojiable=true]',
        assetsPath: '<?php echo base_url(); ?>assets/front/stylesheets/emojis/img',
        popupButtonClasses: 'fa fa-smile-o'
      });
      // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
      // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
      // It can be called as many times as necessary; previously converted input fields will not be converted again
      window.emojiPicker.discover();
    });
  </script>
