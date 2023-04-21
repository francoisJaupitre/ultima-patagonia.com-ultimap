<ul>
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
foreach($cfg_crr_nom as $crr_id => $nom){
	if($crr_id != $id_crr_cmp and substr(upnoac($nom),0,strlen($src))==$src){
?>
		<li <?php if($flg_enter){echo 'id="enter_crr_cmp1" style="background-color: Chocolate;"';} ?> onclick="maj('cfg_fin','crr_cmp','<?php echo $crr_id ?>','1');"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
