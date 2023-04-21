<ul onclick="document.getElementById('sel_rgm<?php if($cbl=='prs'){echo '_prs'.$id_dev_prs;} elseif($cbl=='hbr'){echo '_hbr'.$id_dev_hbr;} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
if($id_rgm>0 and substr(upnoac($txt->rgm->$id_lng),0,strlen($src))==$src){
	if($cbl=='prs'){$event = "vue_elem('prs_vll_ctg".$id_dev_prs."','".$id_vll."_".$id_ctg_srv."_0_".$id_hbr."')";}
	elseif($cbl=='hbr'){$event = "maj('dev_hbr','rgm',0,".$id_dev_hbr.")";}
?>	
	<li onClick="<?php echo $event; ?>"><?php echo $txt->rgm->$id_lng; ?></li>
<?php
}
if($cbl=='hbr'){$uid = "id='enter_hbr_rgm".$id_dev_hbr."'";}
elseif($cbl=='prs'){$uid = "id='enter_prs_rgm".$id_dev_prs."'";}
$flg_enter = true;
foreach($rgm[$id_lng] as $rgm_id => $nom){
	if($rgm_id != $id_rgm and substr(upnoac($nom),0,strlen($src))==$src){
		if($cbl=='prs'){$event = "vue_elem('prs_vll_ctg".$id_dev_prs."','".$id_vll."_".$id_ctg_srv.'_'.$rgm_id.'_'.$id_hbr."')";}
		elseif($cbl=='hbr'){$event = "maj('dev_hbr','rgm',".$rgm_id.",".$id_dev_hbr.")";}
?>		
	<li <?php if($flg_enter){echo $uid." style='background-color: Chocolate;'";} ?> onClick="<?php echo $event; ?>"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>