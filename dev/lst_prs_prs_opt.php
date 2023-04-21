<?php
if($id_cat_jrn !=0 and $id_cat_prs_sel!=0){
	$dt_jrn_prs = ftc_ass(sel_quo("ord","cat_jrn_prs",array("id_jrn","id_prs"),array($id_cat_jrn,$id_cat_prs_sel)));
	if(!empty($dt_jrn_prs)){
		$ord_jrn_prs = $dt_jrn_prs['ord'];
		$rq_lst_prs_prs_opt = sel_quo("cat_prs.id,nom,info","cat_jrn_prs INNER JOIN cat_prs ON cat_jrn_prs.id_prs = cat_prs.id",array("ord","id_jrn"),array($ord_jrn_prs,$id_cat_jrn),"nom");
	}
}
if(!isset($rq_lst_prs_prs_opt) and $id_cat_prs_sel!=0){
	$dt_prs_ctg = ftc_ass(sel_quo("ctg","cat_prs","id",$id_cat_prs_sel));
	$dt_prs_lieu_min = ftc_ass(sel_quo("id_lieu","cat_prs_lieu","id_prs",$id_cat_prs_sel,"ord ASC LIMIT 1"));
	$dt_prs_lieu_max = ftc_ass(sel_quo("id_lieu","cat_prs_lieu","id_prs",$id_cat_prs_sel,"ord DESC LIMIT 1"));
	if(!empty($dt_prs_lieu_min['id_lieu']) and !empty($dt_prs_lieu_max['id_lieu'])){
		$rq_lst_prs_prs_opt = sel_quo(
		"cat_prs.id,nom,info","cat_prs INNER JOIN (SELECT id_prs FROM cat_prs_lieu t1 WHERE t1.ord = 1 AND id_lieu=".$dt_prs_lieu_min['id_lieu'].") t2 ON t2.id_prs = cat_prs.id INNER JOIN (
			SELECT id_prs FROM cat_prs_lieu t4 WHERE t4.ord = (SELECT MAX(ord) FROM cat_prs_lieu t5 WHERE t5.id_prs  = t4.id_prs)AND id_lieu = ".$dt_prs_lieu_max['id_lieu']."
		) t6 ON t6.id_prs = cat_prs.id","ctg",$dt_prs_ctg['ctg'],"nom"
		);
	}
	else{$rq_lst_prs_prs_opt = sel_quo("cat_prs.id,cat_prs.nom AS nom,cat_prs.info,cat_lieu.nom as nom_lieu","cat_prs INNER JOIN (cat_prs_lieu INNER JOIN cat_lieu ON cat_prs_lieu.id_lieu=cat_lieu.id) ON cat_prs.id = cat_prs_lieu.id_prs AND ord=1","ctg",$id_ctg_prs_sel,"nom_lieu,nom");}
}
//elseif($id_ctg_prs_sel!=0){$rq_lst_prs_prs_opt = sel_quo("cat_prs.id,cat_prs.nom AS nom,cat_prs.info,cat_lieu.nom as nom_lieu","cat_prs INNER JOIN (cat_prs_lieu INNER JOIN cat_lieu ON cat_prs_lieu.id_lieu=cat_lieu.id) ON cat_prs.id = cat_prs_lieu.id_prs AND ord=1","ctg",$id_ctg_prs_sel,"nom_lieu,nom");}
?>
