<ul>
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
foreach($clt as $clt_id => $nom) {
	$flg_clt = true;
	if(isset($lst_clt) and in_array($clt_id,$lst_clt)) {$flg_clt = false;}
	if($flg_clt and substr(upnoac($nom),0,strlen($src))==$src) {
		if(!isset($id_chm)) {$id_chm='';}
?>
	<li <?php if($flg_enter) {echo 'id="enter_clt'.$id_chm.'" style="background-color: Chocolate;"';} ?> onClick="ajt('crc_clt',<?php echo $clt_id ?>,'crc',<?php echo $id ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
