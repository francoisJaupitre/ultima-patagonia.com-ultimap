<ul onclick="document.getElementById('sel_ctg_srv<?php if($cbl=='srv'){echo $id_dev_srv;} elseif($cbl=='prs'){echo '_prs'.$id_dev_prs;} ?>').style.display='none';">
<?php
if(!isset($src)){$src='';}
if($id_ctg_srv>0 and substr(upnoac($txt->ctg->$id_lng),0,strlen($src))==$src){
	if($cbl=='srv'){$event = "maj('dev_srv','ctg',0,".$id_dev_srv.")";}
	elseif($cbl=='prs'){$event = "vue_elem('prs_vll_ctg".$id_dev_prs."','".$id_vll."_0_".$id_rgm."_0')";}
?>
	<li onClick="<?php echo $event; ?>"><?php echo $txt->ctg->$id_lng; ?></li>
<?php
}
if($cbl=='srv'){$uid = "id='enter_srv_ctg".$id_dev_srv."'";}
elseif($cbl=='prs'){$uid = "id='enter_prs_ctg".$id_dev_prs."'";}
$flg_enter = true;
foreach($ctg_srv[$id_lng] as $ctg_srv_id => $nom){
	if((($cbl=='prs' and (($id_ctg_prs!=1 and $id_ctg_prs!=11 and $id_ctg_prs!=17) or ($ctg_srv_id==1 and ($id_ctg_prs==1 or $id_ctg_prs==9 or $id_ctg_prs==11 or $id_ctg_prs==12 or $id_ctg_prs==17)))) or ($cbl=='srv' and $ctg_srv_id>1)) and $ctg_srv_id != $id_ctg_srv and substr(upnoac($nom),0,strlen($src))==$src){
		if($cbl=='srv'){$event = "maj('dev_srv','ctg',".$ctg_srv_id.",".$id_dev_srv.")";}
		elseif($cbl=='prs'){$event = "vue_elem('prs_vll_ctg".$id_dev_prs."','".$id_vll.'_'.$ctg_srv_id."_".$id_rgm."_0')";}
?>
	<li <?php if($flg_enter){echo $uid." style='background-color: Chocolate;'";} ?> onClick="<?php echo $event; ?>"><?php echo $nom; ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
