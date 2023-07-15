<?php
include("../cfg/crr.php");
$rq_srv = select("dev_srv.id,dev_srv.crr","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","id_crc",$id_dev_crc);
while($dt_srv = ftc_ass($rq_srv)){
	$cur = $dt_srv['crr'];
	$id_crr = $id_crr_crc;
	include("clc_crr.php");
	upd_quo("dev_srv",array("taux","sup"),array($taux,$sup),$dt_srv['id']);
}
$rq_hbr = select("dev_hbr.id,dev_hbr.crr_chm,dev_hbr.crr_rgm","dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","id_crc",$id_dev_crc);
while($dt_hbr = ftc_ass($rq_hbr)){
	$cur = $dt_hbr['crr_chm'];
	$id_crr = $id_crr_crc;
	include("clc_crr.php");
	upd_quo("dev_hbr",array("taux_chm","sup_chm"),array($taux,$sup),$dt_hbr['id']);
	if($dt_hbr['crr_rgm']>0){
		$cur = $dt_hbr['crr_rgm'];
		$id_crr = $id_crr_crc;
		include("clc_crr.php");
		upd_quo("dev_hbr",array("taux_rgm","sup_rgm"),array($taux,$sup),$dt_hbr['id']);
	}
}
?>
