<ul>
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if($dt_clt['id_ctg']>0 and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_ctg_clt" style="background-color: Chocolate;" onClick="maj('cat_clt','id_ctg',0,<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
foreach($nom_ctg_clt as $ctg_id => $nom) {
	if($ctg_id != $dt_clt['id_ctg'] and substr(upnoac($nom),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_ctg_clt" style="background-color: Chocolate;"';} ?>  onClick="maj('cat_clt','id_ctg',<?php echo $ctg_id.','.$id ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
