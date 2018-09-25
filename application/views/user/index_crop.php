<script type="text/javascript" src="http://demos.9lessons.info/ajaximageupload/scripts/jquery.min.js"></script>
<script type="text/javascript" src="http://demos.9lessons.info/ajaximageupload/scripts/jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function() 
{ 
	$('#photoimg').live('change', function() 
	{ 
		$("#preview").html('');
		$("#preview").html('<img src="loader.gif" alt="Uploading...." />');
		$("#imageform").ajaxForm(
		{
			target: '#preview'
		}).submit();
	});
}); 
</script>


<form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url().'user/upload_trial'; ?>'>
Upload image <input type="file" name="photoimg" id="photoimg" />
</form>

<div id='preview'>

</div>
