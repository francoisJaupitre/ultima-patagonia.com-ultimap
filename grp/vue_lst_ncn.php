<ul onclick="document.getElementById('sel_pax_ncn<?php echo $dt_pax['id']; ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if($dt_pax['ncn']>0 and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src){
?>
	<li onClick="maj('grp_pax','ncn','0',<?php echo $dt_pax['id'] ?>);"><?php echo $txt->nodef->$id_lng ?></li>
<?php
}
foreach($ncn[$id_lng] as $id_ncn => $nom){
	if($id_ncn != $dt_pax['ncn'] and substr(upnoac($nom),0,strlen($src))==$src){
?>		
	<li <?php if($flg_enter){echo 'id="enter_pax_ncn'.$dt_pax['id'].'" style="background-color: Chocolate;"';} ?> onClick="maj('grp_pax','ncn',<?php echo $id_ncn.','.$dt_pax['id'] ?>);"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>