<?php
if($id_cat_mdl !=0){
	$dt_mdl_jrn = ftc_ass(sel_quo("ord","cat_mdl_jrn",array("id_mdl","id_jrn"),array($id_cat_mdl,$id_cat_jrn_sel)));
	if(!empty($dt_mdl_jrn)){
		$ord_mdl_jrn = $dt_mdl_jrn['ord'];
		$rq_jrn_opt = sel_quo("cat_jrn.id,nom,info","cat_mdl_jrn INNER JOIN cat_jrn ON cat_mdl_jrn.id_jrn = cat_jrn.id",array("ord","id_mdl"),array($ord_mdl_jrn,$id_cat_mdl),"nom");
	}
}
elseif($id_cat_jrn_sel>0){
	$dt_jrn_lieu_min = ftc_ass(sel_quo("id_lieu","cat_prs_lieu t INNER JOIN (
		SELECT id_prs FROM cat_jrn_prs WHERE opt = 1 AND id_jrn =".$id_cat_jrn_sel." ORDER BY ord ASC LIMIT 1
	) t0 ON t.id_prs = t0.id_prs","","","t.ord ASC LIMIT 1"));
	$dt_jrn_lieu_max = ftc_ass(sel_quo("id_lieu","cat_prs_lieu t INNER JOIN (
		SELECT id_prs FROM cat_jrn_prs WHERE opt = 1 AND id_jrn =".$id_cat_jrn_sel." ORDER BY ord DESC LIMIT 1
	) t0 ON t.id_prs = t0.id_prs","","","t.ord DESC LIMIT 1"));
	if(!empty($dt_jrn_lieu_min['id_lieu']) and !empty($dt_jrn_lieu_max['id_lieu'])){
		$rq_jrn_opt_min = sel_whe("id_jrn","cat_jrn_prs t0 INNER JOIN (
				SELECT id_prs FROM cat_prs_lieu t1 WHERE t1.ord = (SELECT ord FROM cat_prs_lieu t2 WHERE t2.id_prs = t1.id_prs ORDER BY ord LIMIT 1) AND id_lieu=".$dt_jrn_lieu_min['id_lieu']."
			) t3 ON t3.id_prs = t0.id_prs","t0.ord = (SELECT ord FROM cat_jrn_prs t4 WHERE t4.id_prs = t0.id_prs AND t4.opt = 1 ORDER BY ord LIMIT 1)","","DISTINCT");
		while($dt_jrn_opt_min = ftc_ass($rq_jrn_opt_min)){$lst_jrn_opt_min[] = $dt_jrn_opt_min['id_jrn'];}
		$rq_jrn_opt_max = sel_whe("id_jrn","cat_jrn_prs t0 INNER JOIN (
				SELECT id_prs FROM cat_prs_lieu t1 WHERE t1.ord = (SELECT ord FROM cat_prs_lieu t2 WHERE t2.id_prs = t1.id_prs ORDER BY ord DESC LIMIT 1) AND id_lieu=".$dt_jrn_lieu_max['id_lieu']."
			) t3 ON t3.id_prs = t0.id_prs INNER JOIN (
				SELECT id_prs FROM cat_jrn_prs t4 WHERE t4.ord = (SELECT ord FROM cat_jrn_prs t5 WHERE t5.id_prs = t4.id_prs ORDER BY ord DESC LIMIT 1) AND opt = 1
			) t6 ON t6.id_prs = t0.id_prs","","","DISTINCT");
		while($dt_jrn_opt_max = ftc_ass($rq_jrn_opt_max)){$lst_jrn_opt_max[] = $dt_jrn_opt_max['id_jrn'];}
		$lst_jrn_opt = array_intersect($lst_jrn_opt_min,$lst_jrn_opt_max);
		$rq_jrn_opt = sel_whe("cat_jrn.id,cat_jrn.nom,cat_jrn.info","cat_jrn","id IN (".implode(",",$lst_jrn_opt).")","nom");
	}
}
?>
