<?php
include("../prm/fct.php");
$id_dev_jrn = $_POST["id"];
$id_dev_crc = $_POST["id_dev_crc"];
$val = $_POST["val"];
if($val!=''){
	$dt = explode('/',$val);
	if(!isset($dt[2])){
		if(strtotime(date("Y").'-'.$dt[1].'-'.$dt[0])>strtotime(date("Y-m-d"))){$y=date("Y");}
		else{$y=date("Y")+1;}
	}
	else{$y=$dt[2];}
	$date_jrn = $y.'-'.$dt[1].'-'.$dt[0];
}
else{$date_jrn = '0000-00-00';}
$dt_jrn = ftc_ass(select("ord","dev_jrn","id",$id_dev_jrn));
$ord_jrn = $dt_jrn['ord'];
$rq_mdl = select("id","dev_mdl","id_crc",$id_dev_crc,"ord");
while($dt_mdl = ftc_ass($rq_mdl)){
	$rq_jrn = select("id,ord","dev_jrn","id_mdl",$dt_mdl['id'],"ord");
	while($dt_jrn = ftc_ass($rq_jrn)){
		if($date_jrn!='0000-00-00'){
			$date = date ('Y-m-d', strtotime ("+".$dt_jrn['ord']-$ord_jrn." days $date_jrn"));
			upd_quo("dev_jrn","date",$date,$dt_jrn['id']);
		}
		else{upd_quo("dev_jrn","date","0000-00-00",$dt_jrn['id']);}
		$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
		echo $result."->res_srv_chg";
		$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
		echo $result."->res_hbr_chg";
	}
}
echo 1;
?>