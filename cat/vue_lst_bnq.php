<ul>
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if((($cbl=='hbr' and $id_bnq_hbr>0) or $dt_frn['id_bnq']>0) and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_bnq" style="background-color: Chocolate;" onClick="maj('cat_<?php echo $cbl ?>','id_bnq','0',<?php echo $id ?>);"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
foreach($bnq as $bnq_id => $nom) {
	if((($cbl=='hbr' and $id_bnq_hbr!=$bnq_id) or $dt_frn['id_bnq']!=$bnq_id) and (substr(upnoac($nom),0,strlen($src))==$src or substr(upnoac($pays[$id_lng][$bnq_pays[$bnq_id]]),0,strlen($src))==$src)) {
?>		
		<li <?php if($flg_enter) {echo 'id="enter_bnq" style="background-color: Chocolate;"';} ?> onClick="maj('cat_<?php echo $cbl ?>','id_bnq',<?php echo $bnq_id.','.$id ?>);"><?php echo $nom.' ('.$pays[$id_lng][$bnq_pays[$bnq_id]].')'; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
	</ul>