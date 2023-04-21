<ul onclick="document.getElementById('sel_ctg_prs<?php if($cbl=='prs'){echo $id_dev_prs;} elseif($cbl=='jrn'){echo '_jrn'.$id_dev_jrn;} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
if($id_ctg_prs>0 and substr(upnoac($txt->ctg->$id_lng),0,strlen($src))==$src){
	if($cbl=='prs'){$event = "maj('dev_prs','ctg',0,".$id_dev_prs.")";}
	elseif($cbl=='jrn'){$event = "vue_elem('jrn_vll_ctg".$id_dev_jrn."','".$id_vll."_0')";}
?>	
	<li onClick="<?php echo $event; ?>"><?php echo $txt->ctg->$id_lng; ?></li>
<?php
}
if($cbl=='prs'){$uid = "id='enter_ctg_prs".$id_dev_prs."'";}
elseif($cbl=='jrn'){$uid = "id='enter_jrn_ctg".$id_dev_jrn."'";}
$flg_enter = true;
foreach($ctg_prs[$id_lng] as $ctg_prs_id => $nom){
	if($ctg_prs_id != $id_ctg_prs and substr(upnoac($nom),0,strlen($src))==$src){
		if($cbl=='prs'){$event = "maj('dev_prs','ctg',".$ctg_prs_id.",".$id_dev_prs.")";}
		elseif($cbl=='jrn'){$event = "vue_elem('jrn_vll_ctg".$id_dev_jrn."','".$id_vll.'_'.$ctg_prs_id."')";}
?>		
	<li <?php if($flg_enter){echo $uid." style='background-color: Chocolate;'";} ?> onClick="<?php echo $event; ?>"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>