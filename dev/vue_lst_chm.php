<ul onclick="document.getElementById('sel_chm<?php if($cbl=='hbr'){echo '_'.$cbl.$id_dev_hbr;} elseif($cbl=='prs' or $cbl=='hbr_opt'){echo '_'.$cbl.$id_dev_prs;} ?>').style.display='none';">
<?php
$flg_enter = true;
$uid = "id='enter_".$cbl."_chm";
if($cbl=='prs' or $cbl=='hbr_opt'){$uid .= $id_dev_prs;}
elseif($cbl=='hbr'){$uid .= $id_dev_hbr;}
$uid .= "'";
if(!isset($src)){$src='';}
if(substr(upnoac($txt->creer->$id_lng),0,strlen($src))==$src){
	$event = "ajt_hbr(".$id_hbr.",0,".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",1);searchHbr(".$id_hbr.",0,".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",'ajt');";
?>
	<li <?php echo $uid ." style='background-color: Chocolate;'"?> onClick="<?php echo $event; ?>"><?php echo $txt->creer->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(($cbl=='prs' or $cbl=='hbr_opt') and substr(upnoac($txt->nodef->$id_lng),0,strlen($src))==$src){
	$event = "ajt_hbr(".$id_hbr.",-1,".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",1);searchHbr(".$id_hbr.",-1,".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",'ajt');"
?>
	<li <?php if($flg_enter){echo $uid." style='background-color: Chocolate;'";} ?> onClick="<?php echo $event; ?>"><?php echo $txt->nodef->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
if(substr(upnoac($txt->libre->$id_lng),0,strlen($src))==$src){
	$event = "ajt_hbr(".$id_hbr.",-2,".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",1);searchHbr(".$id_hbr.",-2,".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",'ajt');";
?>
	<li <?php if($flg_enter){echo $uid." style='background-color: Chocolate;'";} ?> onClick="<?php echo $event; ?>"><?php echo $txt->libre->$id_lng; ?></li>
<?php
	$flg_enter = false;
}
$dt_rgm = ftc_ass(select("id","cat_hbr_rgm","id_hbr=".$id_hbr." AND rgm",$id_rgm));
if(!empty($dt_rgm['id'])){$rq_lst_chm = select("id,nom,info,nbr,cpc","cat_hbr_chm","id_hbr",$id_hbr,"nom");}
else{$rq_lst_chm = select("id,nom,info,nbr,cpc","cat_hbr_chm","id_hbr=".$id_hbr." AND rgm",$id_rgm, "nom");}
while($dt_lst_chm = ftc_ass($rq_lst_chm)){
	if(substr(upnoac($dt_lst_chm['nom']),0,strlen($src))==$src){
		$event = "ajt_hbr(".$id_hbr.",".$dt_lst_chm['id'].",".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",1); searchHbr(".$id_hbr.",".$dt_lst_chm['id'].",".$id_vll.",".$id_rgm.",".$id_dev_hbr.",".$id_dev_prs.",'ajt');";
?>
	<li <?php if($flg_enter){echo $uid." style='background-color: Chocolate;'";} ?> onClick="<?php echo $event; ?>"><?php echo stripslashes($dt_lst_chm['nom'].' ['.$dt_lst_chm['info'].' N:'.$dt_lst_chm['nbr'].' C:'.$dt_lst_chm['cpc'].']'); ?></li>
<?php
		$flg_enter = false;
	}
}
?>
</ul>
