<ul onclick="document.getElementById('sel_hbr_def').style.display='none';">
<?php
if(!isset($src)){$src='';}
$flg_enter = true;
foreach($hbr_def[$id_lng] as $hbr_def_id => $nom){
	if(substr(upnoac($nom),0,strlen($src))==$src){
?>
	<li <?php if($flg_enter){echo 'id="enter_hbr_def" style="background-color: Chocolate;"';} ?> onClick="defineHbr(<?php echo $hbr_def_id ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
