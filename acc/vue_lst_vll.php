<ul>
<?php
if(!isset($src)) {$src = '';}
if($id_vll != 0 and empty($src))
{
?>
	<li onClick="vue_cat('<?php echo $cbl ?>','vll','0');"><?php echo $txt->vll->$id_lng; ?></li>
<?php
}
$flg_enter = true;
foreach($vll as $vll_id => $nom)
{
	if($vll_id != $id_vll and empty($src) or strpos(upnoac($nom),$src) !== false)
	{
?>
	<li <?php if($flg_enter){echo 'id="enter_vll" style="background-color: Chocolate;"';} ?> onClick="vue_cat('<?php echo $cbl ?>','vll',<?php echo $vll_id ?>);"><?php echo $nom ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
