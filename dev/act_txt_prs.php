<?php
if($id_cat_prs!=0){
	$dt_cat_prs = ftc_ass(select('nom,titre,dsc,ctg','cat_prs INNER JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs','lgg='.$id_lgg.' AND cat_prs.id',$id_cat_prs));
	if(empty($dt_cat_prs['nom'])){unset($dt_cat_prs['nom']);}
	if(empty($dt_cat_prs['titre'])){
		unset($dt_cat_prs['titre']);
		$err_prs = $dt_cat_prs['nom'].",\n";
	}
	if(empty($dt_cat_prs['dsc'])){unset($dt_cat_prs['dsc']);}
	if(empty($dt_cat_prs['ctg'])){unset($dt_cat_prs['ctg']);}
	if(!empty($dt_cat_prs)){upd_quo('dev_prs',array_keys($dt_cat_prs),array_values($dt_cat_prs),$id_dev_prs);}
}

$rq_dev_srv = select('id,id_cat','dev_srv','id_prs',$id_dev_prs);
while($dt_dev_srv = ftc_ass($rq_dev_srv)){
	$id_dev_srv = $dt_dev_srv['id'];
	$id_cat_srv = $dt_dev_srv['id_cat'];
	include("act_txt_srv.php");
}
$rq_dev_hbr = select('id,id_cat,id_cat_chm','dev_hbr','id_prs',$id_dev_prs);
while($dt_dev_hbr = ftc_ass($rq_dev_hbr)){
	$id_dev_hbr	= $dt_dev_hbr['id'];
	$id_cat_hbr = $dt_dev_hbr['id_cat'];
	$id_cat_chm = $dt_dev_hbr['id_cat_chm'];
	include("act_txt_hbr.php");
}
?>
