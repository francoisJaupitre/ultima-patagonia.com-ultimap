<?php
include("../prm/fct.php");
$cbl = $_POST['cbl'];
$nr = $_POST['nr'];
if($cbl=='crc'){
	$id_dev_crc = $_POST['id'];
	$dt = ftc_ass(select("id","dev_crc_rmn","nr=".$nr." AND id_crc",$id_dev_crc));
	$id_rmn = $dt['id'];
	delete("dev_crc_rmn","id",$id_rmn);
	delete("dev_crc_rmn_pax","id_rmn",$id_rmn);
	$rq_rmn = select("id,nr","dev_crc_rmn","id_crc",$id_dev_crc);
	while($dt_rmn = ftc_ass($rq_rmn)){
		if($dt_rmn['nr']>$nr){upd_noq("dev_crc_rmn","nr","nr-1",$dt_rmn['id']);}
	}
	$dt = ftc_ass(select("id","dev_crc_rmn","nr=1 AND id_crc",$id_dev_crc));
	if(!empty($dt['id'])){$id_rmn_new = $dt['id'];}
	else{$id_rmn_new = 0;}
	upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_prs.id = dev_hbr.id_prs","dev_hbr.res","3","(dev_hbr.res=1 OR dev_hbr.res=2) AND dev_prs.id_rmn",$id_rmn);
	upd_var_quo("dev_prs","id_rmn",$id_rmn_new,"id_rmn",$id_rmn);
}
elseif($cbl=='mdl'){
	$id_dev_mdl = $_POST['id'];
	$dt = ftc_ass(select("id","dev_mdl_rmn","nr=".$nr." AND id_mdl",$id_dev_mdl));
	$id_rmn = $dt['id'];
	delete("dev_mdl_rmn","id",$id_rmn);
	delete("dev_mdl_rmn_pax","id_rmn",$id_rmn);
	$rq_rmn = select("id,nr","dev_mdl_rmn","id_mdl",$id_dev_mdl);
	while($dt_rmn = ftc_ass($rq_rmn)){
		if($dt_rmn['nr']>$nr){upd_noq("dev_mdl_rmn","nr","nr-1",$dt_rmn['id']);}
	}
	$dt = ftc_ass(select("id","dev_mdl_rmn","nr=1 AND id_mdl",$id_dev_mdl));
	if(!empty($dt['id'])){$id_rmn_new = $dt['id'];}
	else{$id_rmn_new = 0;}
	upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_prs.id = dev_hbr.id_prs","dev_hbr.res","3","(dev_hbr.res=1 OR dev_hbr.res=2) AND dev_prs.id_rmn",$id_rmn);
	upd_var_quo("dev_prs","id_rmn",$id_rmn_new,"id_rmn",$id_rmn);
}
