<ul>
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
foreach($cfg_crr_nom as $crr_id => $nom){
	if($crr_id != $cfg_crr_css[$css_id] and substr(upnoac($nom),0,strlen($src))==$src){
?>
		<li <?php if($flg_enter){echo 'id="enter_css_crr'.$css_id.'" style="background-color: Chocolate;"';} ?> onclick="maj('fin_css','crr','<?php echo $crr_id ?>',<?php echo $css_id ?>);"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
