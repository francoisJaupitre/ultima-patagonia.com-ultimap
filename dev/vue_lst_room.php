<ul onclick="document.getElementById('sel_<?php echo $cbl?>_pax_room<?php echo $dt_rmn_pax['id']; ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if($dt_rmn_pax['room']>0 and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src){
?>
	<li onClick="maj('dev_<?php echo $cbl; ?>_rmn_pax','room','0',<?php echo $dt_rmn_pax['id'] ?>);"><?php echo $txt->nodef->$id_lng ?></li>
<?php
}
foreach($room[$id_lng] as $id_room => $nom){
	if($id_room != $dt_rmn_pax['room'] and substr(upnoac($nom),0,strlen($src))==$src){
?>		
	<li <?php if($flg_enter){echo 'id="enter_'.$cbl.'_pax_room'.$dt_rmn_pax['id'].'" style="background-color: Chocolate;"';} ?> onClick="maj('dev_<?php echo $cbl; ?>_rmn_pax','room',<?php echo $id_room.','.$dt_rmn_pax['id'] ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>