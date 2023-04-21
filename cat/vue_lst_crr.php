<ul>
<?php
if(!isset($src)) {$src='';}
if(!isset($id_chm)) {$id_chm=0;}
$flg_enter = true;
foreach($cfg_crr_nom as $crr_id => $nom) {
	if((($cbl=='clt' and $crr_id != $dt_clt['crr']) or ($cbl!='clt' and $crr_id != $dt_trf['crr'])) and substr(upnoac($nom),0,strlen($src))==$src) {
		$uid = "id='enter_crr";
		if($cbl=='clt') {$tab = 'cat_clt';}
		elseif($cbl=='srv') {$tab = 'cat_srv_trf';}
		elseif($id_chm>0) {
			$uid .= "_chm";
			$tab = 'cat_hbr_chm_trf';
		}
		else{
			$uid .= "_rgm";
			$tab = 'cat_hbr_rgm_trf';
		}
		if($cbl!='clt') {$uid .= $id_trf;}
		$uid.= "' style='background-color: Chocolate;'";
		if($cbl!='clt') {$id_sup = $id_trf;}
		else{$id_sup = $id;}
?>
	<li <?php if($flg_enter) {echo $uid;} ?> onClick="maj('<?php echo $tab ?>','crr',<?php echo $crr_id.','.$id_sup ?>);"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
