<?php
$rq_hbr_cnf = sel_quo("dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_crc.id_grp,nomgrp","((((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("cnf","dev_hbr.res"),array("1","1"),"dt_res,nomgrp","DISTINCT");
$nb_hbr_cnf = num_rows($rq_hbr_cnf);
$rq_hbr_dev = sel_quo("dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_crc.id_grp,nomgrp","((((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("cnf","dev_hbr.res"),array("0","1"),"dt_res,nomgrp","DISTINCT");
$nb_hbr_dev = num_rows($rq_hbr_dev);
$rq_hbr_fin = sel_quo("dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_crc.id_grp,nomgrp","((((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("cnf","dev_hbr.res"),array("2","1"),"dt_res,nomgrp","DISTINCT");
$nb_hbr_fin = num_rows($rq_hbr_fin);
$rq_hbr_arc = sel_quo("dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_crc.id_grp,nomgrp","((((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("cnf","dev_hbr.res"),array("-1","1"),"dt_res,nomgrp","DISTINCT");
$nb_hbr_arc = num_rows($rq_hbr_arc);
$rq_hbr_cnf2 = sel_whe("dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_hbr.res,dev_crc.id_grp,nomgrp,dt_pay","(((((dev_hbr LEFT JOIN (SELECT id_hbr,MIN(dev_hbr_pay.date) AS dt_pay FROM dev_hbr_pay GROUP BY id_hbr) t ON t.id_hbr = dev_hbr.id) INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_hbr.id_cat > 0 AND (dev_hbr.res<-1 OR dev_hbr.res>1) AND dev_hbr.res<4 AND (dev_hbr.sel=0 or dev_prs.res!=1) AND cnf=1","dt_res,nomgrp","DISTINCT");
$nb_hbr_cnf2 = num_rows($rq_hbr_cnf2);
$rq_hbr_dev2 = sel_whe("dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_hbr.res,dev_crc.id_grp,nomgrp,dt_pay","(((((dev_hbr LEFT JOIN (SELECT id_hbr,MIN(dev_hbr_pay.date) AS dt_pay FROM dev_hbr_pay GROUP BY id_hbr) t ON t.id_hbr = dev_hbr.id) INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_hbr.id_cat > 0 AND (dev_hbr.res<-1 OR dev_hbr.res>1) AND dev_hbr.res<4 AND cnf='0'","dt_res,nomgrp","DISTINCT");
$nb_hbr_dev2 = num_rows($rq_hbr_dev2);
$rq_hbr_fin2 = sel_whe("dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_hbr.res,dev_crc.id_grp,nomgrp,dt_pay","(((((dev_hbr LEFT JOIN (SELECT id_hbr,MIN(dev_hbr_pay.date) AS dt_pay FROM dev_hbr_pay GROUP BY id_hbr) t ON t.id_hbr = dev_hbr.id) INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_hbr.id_cat > 0 AND (dev_hbr.res<-1 OR dev_hbr.res>1) AND dev_hbr.res<4 AND (dev_hbr.sel=0 or dev_prs.res!=1) AND cnf=2","dt_res,nomgrp","DISTINCT");
$nb_hbr_fin2 = num_rows($rq_hbr_fin2);
$rq_hbr_arc2 = sel_whe("dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_hbr.res,dev_crc.id_grp,nomgrp,dt_pay","(((((dev_hbr LEFT JOIN (SELECT id_hbr,MIN(dev_hbr_pay.date) AS dt_pay FROM dev_hbr_pay GROUP BY id_hbr) t ON t.id_hbr = dev_hbr.id) INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_hbr.id_cat > 0 AND (dev_hbr.res<-1 OR dev_hbr.res>1) AND dev_hbr.res<4 AND cnf=-1","dt_res,nomgrp","DISTINCT");
$nb_hbr_arc2 = num_rows($rq_hbr_arc2);

$rq_frn_cnf = sel_quo("dev_srv.id_frn,dev_srv.dt_res,dev_crc.id_grp,nomgrp","((((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("cnf","dev_srv.res"),array("1","1"),"dt_res,nomgrp","DISTINCT");
$nb_frn_cnf = num_rows($rq_frn_cnf);
$rq_frn_dev = sel_quo("dev_srv.id_frn,dev_srv.dt_res,dev_crc.id_grp,nomgrp","((((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("cnf","dev_srv.res"),array("0","1"),"dt_res,nomgrp","DISTINCT");
$nb_frn_dev = num_rows($rq_frn_dev);
$rq_frn_fin = sel_quo("dev_srv.id_frn,dev_srv.dt_res,dev_crc.id_grp,nomgrp","((((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("cnf","dev_srv.res"),array("2","1"),"dt_res,nomgrp","DISTINCT");
$nb_frn_fin = num_rows($rq_frn_fin);
$rq_frn_arc = sel_quo("dev_srv.id_frn,dev_srv.dt_res,dev_crc.id_grp,nomgrp","((((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",array("cnf","dev_srv.res"),array("-1","1"),"dt_res,nomgrp","DISTINCT");
$nb_frn_arc = num_rows($rq_frn_arc);
$rq_frn_cnf2 = sel_whe("dev_srv.id_frn,dev_srv.dt_res,dev_srv.res,dev_crc.id_grp,nomgrp,dt_pay","(((((dev_srv LEFT JOIN (SELECT id_srv,MIN(dev_srv_pay.date) AS dt_pay FROM dev_srv_pay GROUP BY id_srv) t ON t.id_srv = dev_srv.id) INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","(dev_srv.res<0 OR dev_srv.res>1) AND dev_srv.res<4 AND (dev_srv.opt=0 or dev_prs.res!=1) AND cnf=1","dt_res,nomgrp","DISTINCT");
$nb_frn_cnf2 = num_rows($rq_frn_cnf2);
$rq_frn_dev2 = sel_whe("dev_srv.id_frn,dev_srv.dt_res,dev_srv.res,dev_crc.id_grp,nomgrp,dt_pay","(((((dev_srv LEFT JOIN (SELECT id_srv,MIN(dev_srv_pay.date) AS dt_pay FROM dev_srv_pay GROUP BY id_srv) t ON t.id_srv = dev_srv.id) INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","(dev_srv.res<0 OR dev_srv.res>1) AND dev_srv.res<4 AND cnf='0'","dt_res,nomgrp","DISTINCT");
$nb_frn_dev2 = num_rows($rq_frn_dev2);
$rq_frn_fin2 = sel_whe("dev_srv.id_frn,dev_srv.dt_res,dev_srv.res,dev_crc.id_grp,nomgrp,dt_pay","(((((dev_srv LEFT JOIN (SELECT id_srv,MIN(dev_srv_pay.date) AS dt_pay FROM dev_srv_pay GROUP BY id_srv) t ON t.id_srv = dev_srv.id) INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","(dev_srv.res<0 OR dev_srv.res>1) AND dev_srv.res<4 AND (dev_srv.opt=0 or dev_prs.res!=1) AND cnf=2","dt_res,nomgrp","DISTINCT");
$nb_frn_fin2 = num_rows($rq_frn_fin2);
$rq_frn_arc2 = sel_whe("dev_srv.id_frn,dev_srv.dt_res,dev_srv.res,dev_crc.id_grp,nomgrp,dt_pay","(((((dev_srv LEFT JOIN (SELECT id_srv,MIN(dev_srv_pay.date) AS dt_pay FROM dev_srv_pay GROUP BY id_srv) t ON t.id_srv = dev_srv.id) INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","(dev_srv.res<0 OR dev_srv.res>1) AND dev_srv.res<4 AND cnf=-1","dt_res,nomgrp","DISTINCT");
$nb_frn_arc2 = num_rows($rq_frn_arc2);

$lst_dev = array("cnf","dev","fin","arc");
if($nb_hbr_cnf>0 or $nb_hbr_dev>0 or $nb_hbr_fin>0 or $nb_hbr_arc>0 or $nb_hbr_cnf2>0 or $nb_hbr_dev2>0 or $nb_hbr_fin2>0 or $nb_hbr_arc2>0){
?>
<div class="floating-box"><?php include("vue_res_hbr.php"); ?></div>
<?php
}
if($nb_frn_cnf>0 or $nb_frn_dev>0 or $nb_frn_fin>0 or $nb_frn_arc>0 or $nb_frn_cnf2>0 or $nb_frn_dev2>0 or $nb_frn_fin2>0 or $nb_frn_arc2>0){
?>
<div class="floating-box"><?php include("vue_res_frn.php"); ?></div>
<?php
}
?>
