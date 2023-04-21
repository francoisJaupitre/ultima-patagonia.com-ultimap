<ul>
<?php
if(!isset($src)){$src='';}
if($id_clt!=0 and empty($src)){
	if($cbl=='crc'){$event = "vue_cat('".$cbl."','clt','0');";}
	elseif($cbl=='grp'){$event = "vue_grp('".$cbl."','0');";}
	else{$event = "vue_dev('".$cbl."','clt','0');";}
?>
	<li onClick="<?php echo $event ?>"><?php echo $txt->clt->$id_lng; ?></li>
<?php
}
$flg_enter = true;
foreach($clt as $clt_id => $nom){
	if($clt_id!=$id_clt and substr(upnoac($nom),0,strlen($src))==$src){
		if($cbl=='crc'){$event = "vue_cat('".$cbl."','clt','".$clt_id."');";}
		elseif($cbl=='gr0' || $cbl=='gr1'){$event = "vue_grp('".$cbl."','".$clt_id."');";}
		else{$event = "vue_dev('".$cbl."','clt','".$clt_id."');";}
?>		
	<li <?php if($flg_enter){echo 'id="enter_clt" style="background-color: Chocolate;"';} ?> onClick="<?php echo $event ?>"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>