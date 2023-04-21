<ul onclick="document.getElementById('sel_lgg').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
foreach($nom_lgg as $lgg_id => $nom){
	if($lgg_id != $lgg_crc and substr(upnoac($nom_lgg[$lgg_id]),0,strlen($src))==$src){
?>		
	<li <?php if($flg_enter){echo 'id="enter_lgg" style="background-color: Chocolate;"';} ?> onClick="maj('dev_crc','lgg',<?php echo $lgg_id.','.$id_dev_crc ?>)"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>