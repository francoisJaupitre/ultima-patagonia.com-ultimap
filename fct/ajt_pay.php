<?php
include("../prm/fct.php");
include("../cfg/crr.php");
if($_POST['cbl']=='hbr'){
	$id_dev_hbr = $_POST['id'];
	$dt_dev_hbr = ftc_ass(sel_quo("dev_hbr.crr_chm,dev_hbr.id_cat,dev_jrn.date","dev_hbr INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) ON dev_prs.id = dev_hbr.id_prs","dev_hbr.id",$id_dev_hbr));
	if($dt_dev_hbr['id_cat']>0){
		$flg = true;
		$rq_hbr_pay = sel_quo("*","cat_hbr_pay","id_hbr",$dt_dev_hbr['id_cat']);
		while($dt_hbr_pay = ftc_ass($rq_hbr_pay)){
			$nb_j = $dt_hbr_pay['delai'];
			if($dt_hbr_pay['ty_delai']==1){
				$date = $dt_dev_hbr['date'];
				$date = date ('Y-m-d', strtotime ("-$nb_j days $date"));
			}
			else{
				$date = date('Y-m-d');
				$date = date ('Y-m-d', strtotime ("+$nb_j days $date"));
			}
			insert("dev_hbr_pay",array("id_hbr","crr","taux","sup","date"),array($id_dev_hbr,$dt_dev_hbr['crr_chm'],$cfg_crr_tx[$dt_dev_hbr['crr_chm']],$cfg_crr_sp[$dt_dev_hbr['crr_chm']],$date));
			$flg = false;
		}
	}
	if($flg){insert("dev_hbr_pay",array("id_hbr","crr","taux","sup"),array($id_dev_hbr,$dt_dev_hbr['crr_chm'],$cfg_crr_tx[$dt_dev_hbr['crr_chm']],$cfg_crr_sp[$dt_dev_hbr['crr_chm']]));}
}
elseif($_POST['cbl']=='srv'){
	$id_dev_srv = $_POST['id'];
	$dt_dev_srv = ftc_ass(sel_quo("dev_srv.crr,dev_srv.id_frn,dev_jrn.date","dev_srv INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) ON dev_prs.id = dev_srv.id_prs","dev_srv.id",$id_dev_srv));
	$flg = true;
	if($dt_dev_srv['id_frn']>0){
		$rq_frn_pay = sel_quo("*","cat_frn_pay","id_frn",$dt_dev_srv['id_frn']);
		while($dt_frn_pay = ftc_ass($rq_frn_pay)){
			$nb_j = $dt_frn_pay['delai'];
			if($dt_frn_pay['ty_delai']==1){
				$date = $dt_dev_srv['date'];
				$date = date ('Y-m-d', strtotime ("-$nb_j days $date"));
			}
			else{
				$date = date('Y-m-d');
				$date = date ('Y-m-d', strtotime ("+$nb_j days $date"));
			}
			insert("dev_srv_pay",array("id_srv","crr","taux","sup","date"),array($id_dev_srv,$dt_dev_srv['crr'],$cfg_crr_tx[$dt_dev_srv['crr']],$cfg_crr_sp[$dt_dev_srv['crr']],$date));
			$flg = false;
		}
	}
	if($flg){insert("dev_srv_pay",array("id_srv","crr","taux","sup"),array($id_dev_srv,$dt_dev_srv['crr'],$cfg_crr_tx[$dt_dev_srv['crr']],$cfg_crr_sp[$dt_dev_srv['crr']]));}
}
?>