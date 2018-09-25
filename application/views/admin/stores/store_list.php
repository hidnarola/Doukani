<table id="rounded-corner" class='table table-hover table-striped' data='' style='margin-bottom:0;'>
    <thead>
	<tr>
	    <th>Store Image</th>
	    <th>Store Name</th>
	    <th>Contact Person</th>
	    <th></th>
	</tr>
    </thead>
    <tbody>
	<?php
	if (!empty($stores)):
	    foreach ($stores as $s):
		?>
		<tr>
		    <td>
			<?php if (!empty($s['store_image'])): ?>
	    		<img alt="store Image" src="<?php echo base_url() . stores."small/" . $s['store_image']; ?>"/>
			<?php endif; ?>	    
		    </td>
		    <td><?php echo $s['store_name']; ?></td>
		    <td><?php echo $s['store_contact_person']; ?></td>								
		    <td>
			<div class='text-right'>
			    <a class='btn btn-warning btn-xs' href='<?php echo base_url() . "admin/stores/edit/" . $s['store_id']; ?>'>
				<i class='icon-edit'></i>
			    </a>
			    <a class='btn btn-danger btn-xs' href='<?php echo base_url() . "admin/stores/delete/" . $s['store_id']; ?>'>
				<i class='icon-trash'></i>
			    </a>
			</div>
		    <td>									
		    </td>
		    </td>
		</tr>
		<?php
	    endforeach;
	endif;
	?>
    </tbody>
</table>

