<?php
include("../prm/fct.php");
if(isset($_POST['id_crc']) and isset($_POST['id']) and $_POST['id_crc']>0 and $_POST['id']>0){
	$id_crc = $_POST['id_crc'];
	if($_POST['obj']=='hbr'){
		$id_cat_hbr = $_POST['id'];
		$rq_res = sel_whe("dev_hbr.id","dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res!=-1 AND dev_hbr.res!=0 AND id_crc=".$id_crc." AND dev_hbr.id_cat=".$id_cat_hbr);
		while($dt_res = ftc_ass($rq_res)){upd_quo("dev_hbr","res","NULL",$dt_res['id']);}
	}
	elseif($_POST['obj']=='frn'){
		$id_frn = $_POST['id'];
		$rq_res = sel_whe("dev_srv.id","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.res!=-1 AND dev_srv.res!=0 AND id_crc=".$id_crc." AND dev_srv.id_frn=".$id_frn);
		while($dt_res = ftc_ass($rq_res)){upd_quo("dev_srv","res","NULL",$dt_res['id']);}
	}
}
?>
