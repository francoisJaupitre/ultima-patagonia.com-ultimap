<?php
if(isset($_POST['id']) and isset($_POST['obj']) and isset($_POST['col'])){
	$id = $_POST['id'];
	$obj = $_POST['obj'];
	$col = $_POST['col'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	if(substr($obj,0,7)=="frn_srv"){
		include("../cfg/frn.php");
		if($id==0){$id=substr($obj,7);}
		$dt_res = $dt_res2 = ftc_ass(sel_quo("dev_srv.id AS id_dev_srv, dev_srv.res AS id_srv_res, dev_srv.id_frn,dev_srv.ctg AS id_srv_ctg,dev_srv.id_vll AS id_srv_vll,dev_jrn.date,dev_mdl.id_crc","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",$id));
		$id_frn = $dt_res2['id_frn'];
		$id_dev_srv = $dt_res2['id_dev_srv'];
		include("vue_srv_frn.php");
	}
	elseif(substr($obj,0,7)=='res_srv'){
		include("../prm/res_srv.php");
		if($id==0){$id=substr($obj,7);}
		$dt_res = $dt_res2 = ftc_ass(sel_quo("dev_srv.id AS id_dev_srv, dev_srv.res AS id_srv_res, dev_srv.rva AS id_srv_rva, dev_srv.id_frn, dev_prs.ctg AS id_prs_ctg","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",$id));
		include("vue_res_srv.php");
	}
	elseif(substr($obj,0,7)=='cmd_srv'){
		if($id==0){$id=substr($obj,7);}
		$dt_res = $dt_res2 = ftc_ass(sel_quo("dev_srv.id AS id_dev_srv, dev_srv.id_frn, dev_mdl.id_crc","dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.id",$id));
		include("vue_cmd_srv.php");
	}
	elseif(substr($obj,0,7)=="res_hbr"){
		include("../prm/res_srv.php");
		if($id==0){$id=substr($obj,7);}
		$dt_res = $dt_res2 = ftc_ass(sel_quo("dev_hbr.id AS id_dev_hbr, dev_hbr.res AS id_hbr_res, dev_hbr.rva AS id_hbr_rva, dev_hbr.id_cat AS id_cat_hbr, dev_hbr.id_cat_chm AS id_cat_chm","dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","dev_hbr.id",$id));
		if($dt_res2['id_cat_hbr']>-1 and $dt_res2['id_cat_chm']>-2){include("vue_res_hbr.php");}
	}
	elseif(substr($obj,0,7)=='cmd_hbr'){
		if($id==0){$id=substr($obj,7);}
		$dt_res = $dt_res2 = ftc_ass(sel_quo("dev_hbr.id AS id_dev_hbr, dev_hbr.id_cat AS id_cat_hbr, dev_hbr.id_cat_chm AS id_cat_chm, dev_mdl.id_crc","dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id","dev_hbr.id",$id));
		if($dt_res2['id_cat_hbr']>-1 and $dt_res2['id_cat_chm']>-2){include("vue_cmd_hbr.php");}
	}
	else{
		$rq = sel_quo($col,"dev_".$obj,"id",$id);
		$dt = ftc_ass($rq);
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dt[$col])){echo date("d/m/Y", strtotime($dt[$col]));}
		elseif($col=='heure'){echo date("H:i",strtotime($dt[$col]));}
		elseif($dt[$col]!='0000-00-00'){echo stripslashes($dt[$col]);}
	}
}
?>
