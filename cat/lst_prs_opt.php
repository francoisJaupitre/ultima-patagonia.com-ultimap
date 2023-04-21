<?php
$dt_prs_lieu_min = ftc_ass(select("id_lieu","cat_prs_lieu","id_prs",$id_prs_sel,"ord ASC LIMIT 1"));
$dt_prs_lieu_max = ftc_ass(select("id_lieu","cat_prs_lieu","id_prs",$id_prs_sel,"ord DESC LIMIT 1"));
if(!empty($dt_prs_lieu_min['id_lieu']) and !empty($dt_prs_lieu_max['id_lieu'])) {
	$rq_prs_opt = select(
	"cat_prs.id,nom,info","cat_prs INNER JOIN (SELECT id_prs FROM cat_prs_lieu t1 WHERE t1.ord = 1 AND id_lieu=".$dt_prs_lieu_min['id_lieu'].") t2 ON t2.id_prs = cat_prs.id INNER JOIN (
		SELECT id_prs FROM cat_prs_lieu t4 WHERE t4.ord = (SELECT MAX(ord) FROM cat_prs_lieu t5 WHERE t5.id_prs  = t4.id_prs)AND id_lieu = ".$dt_prs_lieu_max['id_lieu']."
	) t6 ON t6.id_prs = cat_prs.id","ctg",$ctg_opt,"nom"
	);
}
?>
