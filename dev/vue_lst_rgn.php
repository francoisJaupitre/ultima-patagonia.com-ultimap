<ul onclick="document.getElementById('sel_rgn_<?php if($cbl=='crc'){echo 'crc'.$id_dev_crc;} elseif($cbl=='mdl'){echo 'mdl'.$id_dev_mdl;} elseif($cbl=='pic'){echo 'pic'.$id_dev_jrn;} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
if(!isset($id_rgn)){$id_rgn=0;}
if($cbl!='mdl' and $id_rgn!=0 and empty($src)){
	if($cbl=='crc'){$event = "vue_elem('crc_rgn".$id_dev_crc."','0')";}
	elseif($cbl=='pic'){$event = "vue_elem('pic_rgn".$id_dev_jrn."','0')";}
?>
	<li onClick="<?php echo $event; ?>"><?php echo $txt->rgn->$id_lng; ?></li>
<?php
}
$uid = "id='enter_";
if($cbl=='crc'){
	$uid .= "crc_rgn".$id_dev_crc;
	$elem = "crc_rgn".$id_dev_crc;
}
elseif($cbl=='mdl'){
	$uid .= "mdl_rgn".$id_dev_mdl;
	$elem = "mdl_rgn".$id_dev_mdl;
}
elseif($cbl=='pic'){
	$uid .= "pic_rgn".$id_dev_jrn;
	$elem = "pic_rgn".$id_dev_jrn;
}
$uid .= "'";
foreach($rgn as $rgn_id => $nom){
	$flg_rgn = true;
	if(isset($ids_rgn) and in_array($rgn_id,$ids_rgn)) {$flg_rgn = false;}
	if($flg_rgn  and substr(upnoac($nom),0,strlen($src))==$src){
		if($rgn_id!=$id_rgn){
			if($cbl=='mdl') {$event = "ajt_rgn($id_dev_mdl,$rgn_id);";}
			else{$event = "vue_elem('$elem',$rgn_id);";}
?>
	<li <?php if($flg_enter){echo $uid." style='background-color: Chocolate;'";} ?> onClick="<?php echo $event; ?>"><?php echo stripslashes($nom); ?></li>
<?php
			$flg_enter = false;
		}
	}
}
?>
</ul>
