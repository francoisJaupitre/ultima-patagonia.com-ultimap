<ul>
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
foreach($prm_crr_nom as $id_crr => $nom){
	if(array_key_exists($id_crr,$cfg_crr_nom)){$flg = false;}
	else{$flg = true;}
	if($flg and $id_crr>1 and (substr(upnoac($nom.' ('.$prm_crr_ttr[$id_lng][$id_crr].')'),0,strlen($src))==$src or substr(upnoac($prm_crr_ttr[$id_lng][$id_crr]),0,strlen($src))==$src)){
?>
	<li <?php if($flg_enter){echo 'id="enter_crr" style="background-color: Chocolate;"';} ?> onClick="ajt_cfg('crr',<?php echo $id_crr ?>);"><?php echo $nom.' ('.$prm_crr_ttr[$id_lng][$id_crr].')'; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
