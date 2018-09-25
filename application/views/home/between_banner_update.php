<?php if(isset($between_banners[0]['ban_id']) && $between_banners[0]['ban_id']!='') {		
	$mycnt	=	$between_banners[0]['impression_count']+1;
	$array1	=	array('ban_id'=>$between_banners[0]['ban_id']);
	$data1	=	array('impression_count'=>$mycnt);
	$this->dbcommon->update('custom_banner', $array1, $data1);
}
?>
<?php if(isset($between_banners1[0]['ban_id']) && $between_banners1[0]['ban_id']!='') {		
	$mycnt	=	$between_banners1[0]['impression_count']+1;
	$array1	=	array('ban_id'=>$between_banners1[0]['ban_id']);
	$data1	=	array('impression_count'=>$mycnt);
	$this->dbcommon->update('custom_banner', $array1, $data1);
}
?>