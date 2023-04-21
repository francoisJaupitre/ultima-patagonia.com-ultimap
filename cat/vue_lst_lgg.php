<ul onclick="document.getElementById('sel_lgg').style.display='none';">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
foreach($nom_lgg as $lgg_id => $nom) {
	if((!isset($lgg_exist) or !in_array($lgg_id,$lgg_exist)) and substr(upnoac($nom_lgg[$lgg_id]),0,strlen($src))==$src) {
		if(!isset($id_chm)) {$id_chm = '';}
?>
	<li <?php if($flg_enter) {echo 'id="enter_lgg'.$id_chm.'" style="background-color: Chocolate;"';} ?> onClick="ajt_lgg('<?php echo $cbl; if($id_chm>0) {echo "_chm";} ?>',<?php if($id_chm>0) {echo $id_chm;}else{echo 0;} ?>,<?php echo $lgg_id ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
