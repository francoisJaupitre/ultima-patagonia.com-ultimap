<ul>
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if($dt_hbr['ctg']>0 and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_ctg_hbr" style="background-color: Chocolate;" onClick="maj('cat_hbr','ctg','0',<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php	
	$flg_enter = false;
}
foreach($ctg_hbr[$id_lng] as $ctg_id => $nom) {
	if($ctg_id != $dt_hbr['ctg'] and substr(upnoac($nom),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_ctg_hbr" style="background-color: Chocolate;"';} ?>  onClick="maj('cat_hbr','ctg',<?php echo $ctg_id.','.$id ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>