<?php
if(!isset($id_chm)) {$id_chm=0;}
?>
<ul onclick="document.getElementById('<?php if($cbl!='hbr') {echo "sel_rgm";} elseif($id_chm>0) {echo "sel_rgm_chm".$id_chm;} else{echo "sel_rgm_hbr";} ?>').style.display='none';">
<?php
if(!isset($src)) {$src='';}
$flg_enter = true;
if($cbl!='hbr' and $id_rgm>0 and empty($src)) {
?>
	<li onClick="vue_elem('prs_vll_ctg','<?php echo $id_vll.'_1_0' ?>');"><?php echo $txt->regime->$id_lng; ?></li>
<?php
}
elseif($cbl=='hbr' and $id_chm>0 and $dt_chm['rgm']>0 and substr(upnoac($txt->regime->$id_lng),0,strlen($src))==$src) {
?>
	<li id="enter_rgm_chm<?php echo $id_chm; ?>" style="background-color: Chocolate;"onClick="updateData('cat_hbr_chm','rgm','0',<?php echo $id_chm.','.$id ?>)"><?php echo $txt->regime->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
foreach($rgm[$id_lng] as $rgm_id => $nom) {
	if(substr(upnoac($nom),0,strlen($src))==$src) {
		if($cbl!='hbr' and $id_rgm!=$rgm_id) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_rgm" style="background-color: Chocolate;"';} ?> onClick="vue_elem('prs_vll_ctg','<?php echo $id_vll.'_1_'.$rgm_id; ?>');"><?php echo $nom; ?></li>
<?php
			$flg_enter = false;
		}
		elseif($cbl!='prs' and $dt_chm['rgm']!=$rgm_id) {
			$flg_rgm = true;
			if(isset($rgm_exist['hbr'])) {
				foreach($rgm_exist['hbr'] as $hbr_exist) {
					if($rgm_id == $hbr_exist) {$flg_rgm=false;}
				}
			}
			if($flg_rgm) {
				if($id_chm>0) {
?>
	<li <?php if($flg_enter) {echo 'id="enter_rgm_chm'.$id_chm.'" style="background-color: Chocolate;"';} ?> onClick="updateData('cat_hbr_chm','rgm',<?php echo $rgm_id.','.$id_chm.','.$id ?>)"><?php echo $nom; ?></li>
<?php
					$flg_enter = false;
				}
				else{
					if(isset($rgm_exist['chm'])) {
						foreach($rgm_exist['chm'] as $chm_exist) {
							if($rgm_id == $chm_exist) {$flg_rgm=false;}
						}
					}
					if($flg_rgm) {
?>

	<li <?php if($flg_enter) {echo 'id="enter_rgm_hbr" style="background-color: Chocolate;"';} ?> onClick="ajt_hbr_rgm(<?php echo $rgm_id ?>);"><?php echo $nom; ?></li>
<?php
						$flg_enter = false;
					}
				}
			}
		}
	}
}
?>
</ul>
