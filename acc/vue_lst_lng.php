<ul>
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
foreach($lgg as $lgg_id => $uid_lgg){
	if($lngg[$lgg_id] and $uid_lgg!=$id_lng and substr(upnoac($nom_lgg[$lgg_id]),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_lng" style="background-color: Chocolate;"';} ?> onClick="updateLanguage('<?php echo $uid_lgg ?>',<?php echo $id_cfg_usr ?>);"><?php echo $nom_lgg[$lgg_id] ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
