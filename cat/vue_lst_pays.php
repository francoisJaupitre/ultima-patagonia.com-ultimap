<ul onclick="document.getElementById('sel_pays').style.display='none';">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if((($cbl=='vll' and $dt_vll['id_pays']>0) or ($cbl=='bnq' and $dt_bnq['id_pays']>0)) and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_pays" style="background-color: Chocolate;" onClick="updateData('cat_<?php echo $cbl ?>','id_pays','0',<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php	
	$flg_enter = false;
}
foreach($pays[$id_lng] as $pays_id => $nom) {
	if((($cbl=='vll' and $pays_id!=$dt_vll['id_pays']) or ($cbl=='bnq' and $pays_id!=$dt_bnq['id_pays'])) and substr(upnoac($nom),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_pays" style="background-color: Chocolate;"';} ?>  onClick="updateData('cat_<?php echo $cbl ?>','id_pays',<?php echo $pays_id.','.$id ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>