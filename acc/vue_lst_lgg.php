<ul>
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
foreach($lgg as $lgg_id => $nom){
	if($lgg_id!=$id_lgg and substr(upnoac($nom_lgg[$lgg_id]),0,strlen($src))==$src){
?>		
	<li <?php if($flg_enter){echo 'id="enter_lgg" style="background-color: Chocolate;"';} ?> onClick="maj('cfg_usr','lgg','<?php echo $lgg_id ?>',<?php echo $id_cfg_usr ?>);"><?php echo $nom_lgg[$lgg_id] ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>