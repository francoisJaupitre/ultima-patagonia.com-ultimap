<ul onclick="document.getElementById('sel_clt').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(substr(upnoac($txt->opn->$id_lng),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_clt" style="background-color: Chocolate;"';} ?> onClick="window.parent.opn_frm('cat/ctr.php?cbl=clt&id=<?php echo $clt_crc; ?>');"><?php echo $txt->opn->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
foreach($clt as $clt_id => $nom){
	if($clt_ctg[$clt_id]>0 and $clt_id != $clt_crc and substr(upnoac($nom),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_clt" style="background-color: Chocolate;"';} ?> onClick="maj('grp_dev','id_clt',<?php echo $clt_id.','.$id_dev_crc ?>)"><?php echo stripslashes($nom); ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
