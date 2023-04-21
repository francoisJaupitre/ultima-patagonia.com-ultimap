<ul>
<?php
if(!isset($src)){$src='';}
if($id_rgn!=0 and empty($src)){
?>
	<li onClick="vue_cat('<?php echo $cbl ?>','rgn','0');"><?php echo $txt->rgn->$id_lng; ?></li>
<?php
}
$flg_enter = true;
foreach($rgn as $rgn_id => $nom){
	if($rgn_id!=$id_rgn and substr(upnoac($nom),0,strlen($src))==$src){
?>		
	<li <?php if($flg_enter){echo 'id="enter_rgn" style="background-color: Chocolate;"';} ?> onClick="vue_cat('<?php echo $cbl ?>','rgn',<?php echo $rgn_id ?>);"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>