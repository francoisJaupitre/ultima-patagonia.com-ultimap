<?php
if($ord_jrn != 1) {
	$dt_jrn_lieu_min = ftc_ass(select("id_lieu","cat_prs_lieu t INNER JOIN (
		SELECT id_prs FROM cat_jrn_prs WHERE opt = 1 AND id_jrn=".$id_jrn_sel." ORDER BY ord ASC LIMIT 1
	) t0 ON t.id_prs = t0.id_prs","1","1","t.ord ASC LIMIT 1"));
}
if($ord_jrn != 0) {
	$dt_jrn_lieu_max = ftc_ass(select("id_lieu","cat_prs_lieu t INNER JOIN (
		SELECT id_prs FROM cat_jrn_prs WHERE opt = 1 AND id_jrn=".$id_jrn_sel." ORDER BY ord DESC LIMIT 1
	) t0 ON t.id_prs = t0.id_prs","1","1","t.ord DESC LIMIT 1"));
}
if(!empty($dt_jrn_lieu_min['id_lieu'])) {
	$rq_prs_lieu_min = sel_whe("id_prs","cat_prs_lieu t0","ord = (SELECT ord FROM cat_prs_lieu t1 WHERE t1.id_prs = t0.id_prs ORDER BY ord ASC LIMIT 1) AND id_lieu=".$dt_jrn_lieu_min['id_lieu']);
	while($dt_prs_lieu_min = ftc_ass($rq_prs_lieu_min)) {
		$rq_jrn_opt_min = sel_quo("t0.id_jrn","cat_jrn_prs t0 INNER JOIN (
				SELECT MIN(ord) as min_ord,id_jrn FROM cat_jrn_prs WHERE opt=1 GROUP BY id_jrn
			) t1 ON t0.id_jrn = t1.id_jrn AND t0.ord = t1.min_ord","opt=1 AND t0.id_prs",$dt_prs_lieu_min['id_prs'],"","DISTINCT");
		while($dt_jrn_opt_min = ftc_ass($rq_jrn_opt_min)) {$lst_jrn_opt_min[] = $dt_jrn_opt_min['id_jrn'];}
	}
}
if(!empty($dt_jrn_lieu_max['id_lieu'])) {
	$rq_prs_lieu_max = sel_whe("id_prs","cat_prs_lieu t0","ord = (SELECT ord FROM cat_prs_lieu t1 WHERE t1.id_prs = t0.id_prs ORDER BY ord DESC LIMIT 1) AND id_lieu=".$dt_jrn_lieu_max['id_lieu']);
	while($dt_prs_lieu_max = ftc_ass($rq_prs_lieu_max)) {
		$rq_jrn_opt_max = sel_quo("t0.id_jrn","cat_jrn_prs t0 INNER JOIN (
				SELECT MAX(ord) as max_ord,id_jrn FROM cat_jrn_prs WHERE opt=1 GROUP BY id_jrn
			) t1 ON t0.id_jrn = t1.id_jrn AND t0.ord = t1.max_ord","opt=1 AND t0.id_prs",$dt_prs_lieu_max['id_prs'],"","DISTINCT");
		while($dt_jrn_opt_max = ftc_ass($rq_jrn_opt_max)) {$lst_jrn_opt_max[] = $dt_jrn_opt_max['id_jrn'];}
	}
}
if(!empty($dt_jrn_lieu_min['id_lieu']) and !empty($dt_jrn_lieu_max['id_lieu'])) {$lst_jrn_opt = array_intersect($lst_jrn_opt_min,$lst_jrn_opt_max);}
elseif(!empty($dt_jrn_lieu_min['id_lieu'])) {$lst_jrn_opt = $lst_jrn_opt_min;}
else{$lst_jrn_opt = $lst_jrn_opt_max;}
$rq_jrn_opt = sel_whe("cat_jrn.id,cat_jrn.nom,cat_jrn.info","cat_jrn","id IN (".implode(",",$lst_jrn_opt).")","nom");
?>
