<ul onclick="document.getElementById('sel_ctg_lgg').style.display='none';">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if(substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
<li <?php if($flg_enter) {echo 'id="enter_ctg_lgg" style="background-color: Chocolate;"';} ?>  onClick="updateData('cat_srv','lgg',0,<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
foreach($nom_lgg_lgg[$id_lng] as $lgg_id => $nom) {
	if(substr(upnoac($nom_lgg[$lgg_id]),0,strlen($src))==$src) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_ctg_lgg" style="background-color: Chocolate;"';} ?>  onClick="updateData('cat_srv','lgg',<?php echo $lgg_id.','.$id ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
