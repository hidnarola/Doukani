<!DOCTYPE html>
<html>
    <head>
	<?php $this->load->view('admin/include/head'); ?>
    </head>
    <body class='contrast-fb'>
	<?php $this->load->view('admin/include/header'); ?>
	<div id='wrapper'>
	    <?php $this->load->view('admin/include/left-nav'); ?>
	    <section id='content'>
		<div class='container-fluid'>
		    <div class='row-fluid' id='content-wrapper'>
			<div class='span12'>
			    <div class='page-header page-header-with-buttons'>
				<h1 class='pull-left'>
				    <i class='icon-building'></i>
				    <span>Mange Stores</span>
				</h1>				
			    </div>
			    <?php if (isset($msg)): ?>
    			    <div class='alert  <?php echo $msg_class; ?>'>
    				<a class='close' data-dismiss='alert' href='#'>&times;</a>
				    <?php echo $msg; ?>
    			    </div>
			    <?php endif; ?>
			    <div class='row-fluid'>
				<div class='row-fluid'>
				    <div class='span12 box'>
					<div class='box-header orange-background'>
					    <div class='title'>Send message to store owners</div>					   
					</div>
					<form action='<?php echo base_url(); ?>admin/stores/manage_stores' class='form form-horizontal validate-form' accept-charset="UTF-8" method='post'>
					    <div class='box-content control'>
						 <div class='control-group'>
						<textarea class='input-block-level wysihtml5' id='wysiwyg2' rows='10' data-rule-minlength="10" data-rule-required="true"></textarea>					    
						 </div>
						<div class="margin-bottom-10"></div>
						<button class='btn btn-primary' type='submit'>
						    <i class='icon-bolt'></i>
						    Send Message
						</button>
					</form>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
		</div>
	</div>
    </section>
</div>
<?php $this->load->view('admin/include/footer-script'); ?>
<script type="text/javascript">
    $(document).ready(function() {
	function bindClicks() {
	    $("ul.tsc_pagination a").click(paginationClick);
	}

	function paginationClick() {
	    var href = $(this).attr('href');
	    $("#rounded-corner").css("opacity", "0.4");
	    $.ajax({
		type: "GET",
		url: href,
		data: {},
		success: function(response)
		{
		    //alert(response);
		    $("#rounded-corner").css("opacity", "1");
		    $("#divID").html(response);
		    bindClicks();
		}
	    });
	    return false;
	}
	bindClicks();
    });
</script>
</body>
</html>