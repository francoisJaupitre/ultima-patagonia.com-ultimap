<ul onclick="document.getElementById('sel_lieu').style.display='none';">
<?php
if(!isset($src)) {$src='';}
if(!isset($id_lieu)) {$id_lieu=0;}
$flg_enter = true;
foreach($lieu_uid as $uid => $lieu_id) {
	if($lieu_id!=$id_lieu and (substr(upnoac($lieu_nom[$uid]),0,strlen($src))==$src or substr(upnoac($lieu_vll[$uid]),0,strlen($src))==$src)) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_lieu" style="background-color: Chocolate;"';} ?> onClick="ajt('<?php echo $cbl ?>_lieu',<?php echo $lieu_id ?>,'<?php echo $cbl ?>',<?php echo $id ?>);"><?php echo $lieu_nom[$uid].' ('.$lieu_vll[$uid].')' ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
