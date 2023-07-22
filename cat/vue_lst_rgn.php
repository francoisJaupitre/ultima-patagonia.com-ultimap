<ul onclick="document.getElementById('sel_rgn').style.display='none';">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if(!isset($id_rgn)) {$id_rgn=0;}
if($cbl!='mdl' and $cbl!='pic' and $cbl!='vll' and $id_rgn!=0 and empty($src)) {
?>
	<li onClick="vue_elem('<?php echo $cbl ?>_rgn','0')"><?php echo $txt->region->$id_lng; ?></li>
<?php
}
elseif((($cbl=='pic' and $dt_pic['id_rgn']>0) or ($cbl=='vll' and $dt_vll['id_rgn']>0)) and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_rgn" style="background-color: Chocolate;" onClick="updateData('cat_<?php echo $cbl ?>','id_rgn','0',<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
foreach($rgn as $rgn_id => $nom) {
	$flg_rgn = true;
	if(isset($lst_rgn) and in_array($rgn_id,$lst_rgn)) {$flg_rgn = false;}
	if($flg_rgn and substr(upnoac($nom),0,strlen($src))==$src) {
		if($cbl!='pic' and $cbl!='vll' and $rgn_id!=$id_rgn) {
			if($cbl=='mdl') {$event = "ajt('mdl_rgn',".$rgn_id.",'mdl',".$id.")";}
			else{$event = "vue_elem('".$cbl."_rgn',".$rgn_id.")";}
			if(isset($id_chm) and $id_chm>0) {$uid = 'id="enter_rgn'.$id_chm.'" style="background-color: Chocolate;"';}
			else{$uid = 'id="enter_rgn" style="background-color: Chocolate;"';}
?>
	<li <?php if($flg_enter) {echo $uid;} ?> onClick="<?php echo $event ?>"><?php echo $nom; ?></li>
<?php
			$flg_enter = false;
		}
		elseif(($cbl=='pic' and $rgn_id != $dt_pic['id_rgn']) or ($cbl=='vll' and $rgn_id != $dt_vll['id_rgn'])) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_rgn" style="background-color: Chocolate;"';} ?> onClick="updateData('cat_<?php echo $cbl ?>','id_rgn',<?php echo $rgn_id.','.$id ?>);"><?php echo $nom; ?></li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
