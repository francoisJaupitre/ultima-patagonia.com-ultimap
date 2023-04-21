<?php
if(isset($_POST['cbl']) and isset($_POST['src']) and isset($_POST['obj']) and isset($_POST['id'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	$cbl = $_POST['cbl'];
	$src = upnoac(rawurldecode($_POST['src']));
	$obj = $_POST['obj'];
	$id = $_POST['id'];
	if(substr($obj,0,3)=='frn'){
		$dt_res = ftc_ass(sel_quo("id_frn,dev_srv.id AS id_dev_srv,dev_srv.ctg AS id_srv_ctg,id_vll as id_srv_vll,date,id_crc","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",substr($obj,3)));
		$id_frn = $dt_res['id_frn'];
		$id_dev_srv = $dt_res['id_dev_srv'];
		$date_jrn = $dt_res['date'];
		include("vue_lst_frn.php");
	}
	elseif(substr($obj,0,7)=='srv_res'){
		include("../prm/res_srv.php");
		$dt_res = ftc_ass(sel_quo("dev_srv.id AS id_dev_srv,id_frn,dev_srv.res AS id_srv_res,rva AS id_srv_rva,id_prs,id_crc","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",substr($obj,7)));
		include("vue_lst_res.php");
	}
	elseif(substr($obj,0,7)=='hbr_res'){
		include("../prm/res_srv.php");
		$dt_res = ftc_ass(sel_quo("dev_hbr.id AS id_dev_hbr,dev_hbr.id_cat AS id_cat_hbr,id_cat_chm,rgm AS id_rgm,dev_hbr.res AS id_hbr_res,rva AS id_hbr_rva,id_prs,id_crc","dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","dev_hbr.id",substr($obj,7)));
		include("vue_lst_res.php");
	}
}
?>
