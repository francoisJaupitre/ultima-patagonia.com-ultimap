<?php
$id_cat_jrn = $_POST['id_cat_jrn'];
$id_dev_mdl = $_POST['id_dev_mdl'];
$ord_jrn = $_POST['ord_jrn'];
$id_dev_crc = $_POST['id_dev_crc'];
$id_lgg = $_POST['lgg'];
$txt = simplexml_load_file('../resources/xml/updateTxt.xml');
include("../prm/fct.php");
include("../cfg/crr.php");
include("../cfg/lng.php");
$dt_mdl = ftc_ass(sel_quo("id_cat,ord","dev_mdl","id",$id_dev_mdl));
$ord_mdl = $dt_mdl['ord'];
$id_cat_mdl = $dt_mdl['id_cat'];
$max_date = "0000-00-00";
$max_ord = 0;
$alt = array();
$err_ord = $err = $err_jrn = $err_prs = $err_hbr = $err_srv = '';
$ant_jrn = 0;
if($ord_jrn == -1) {
	$opt_jrn = 1;
	$dt_jrn = ftc_ass(sel_quo("MAX(ord) as ord,MAX(date) as date","dev_jrn","id_mdl",$id_dev_mdl));
	$ord_jrn = $dt_jrn['ord'] + 1;
	$date = $dt_jrn['date'];
	if($date != '0000-00-00') {$date = date ('Y-m-d', strtotime ("+1 days $date"));}
	if($id_cat_mdl !=0) {
		$rq_cat = sel_quo("ord","cat_mdl_jrn",array("id_mdl","id_jrn"),array($id_cat_mdl,$id_cat_jrn));
		while($dt_cat = ftc_ass($rq_cat)) {
			$rq_mdl_jrn = sel_whe("id_jrn,ord","cat_mdl_jrn","ord >".$dt_cat['ord']." AND id_mdl=".$id_cat_mdl,"ord DESC","DISTINCT");
			while($dt_mdl_jrn = ftc_ass($rq_mdl_jrn)) {
				$rq_dev_jrn = sel_quo("id,id_cat,ord,date","dev_jrn","id_mdl",$id_dev_mdl,"ord DESC");
				while($dt_dev_jrn = ftc_ass($rq_dev_jrn)) {
				if($dt_dev_jrn['id_cat'] == $dt_mdl_jrn['id_jrn']) {
						if($date != '0000-00-00') {upd_noq("dev_jrn",array("ord","date"),array("ord+1","date + INTERVAL 1 DAY"),$dt_dev_jrn['id']);}
						else{upd_noq("dev_jrn","ord","ord+1",$dt_dev_jrn['id']);}
						$ord_jrn = $dt_dev_jrn['ord'];
						$date = $dt_dev_jrn['date'];
						$ant_jrn = $dt_dev_jrn['id'];
					}
				}
			}
			$rq_mdl = sel_whe("id,ord","dev_mdl","ord >".$ord_mdl." AND id_crc=".$id_dev_crc,"ord");
			while($dt_mdl = ftc_ass($rq_mdl)) {
				$rq_jrn = sel_quo("id,ord,date","dev_jrn","id_mdl",$dt_mdl['id']);
				while($dt_jrn = ftc_ass($rq_jrn)) {
					if($dt_jrn['date']!='0000-00-00') {
						upd_noq("dev_jrn",array("ord","date"),array("ord+1","date + INTERVAL 1 DAY"),$dt_jrn['id']);
						$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
						$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
					}
					else{upd_noq("dev_jrn","ord","ord+1",$dt_jrn['id']);}
				}
				$err_ord .= $dt_mdl['ord'].', ';
			}
			upd_noq('dev_crc','duree','duree+1',$id_dev_crc);
		}
	}
}
elseif($ord_jrn == 0) {
	$opt_jrn = 1;
	$flg_plus = true;
	$dt_jrn = ftc_ass(sel_quo("MAX(ord) AS ord,MAX(date) as date","dev_jrn","id_mdl",$id_dev_mdl));
	if(!is_null($dt_jrn['ord'])) {
		$max_date = $dt_jrn['date'];
		$max_ord = $dt_jrn['ord'];
	}
	elseif($ord_mdl!=1) {
		$i = $ord_mdl;
		$flg_mdl = false;
		while(!$flg_mdl and $i>1) {
			$i--;
			$dt_jrn = ftc_ass(sel_quo("MAX(dev_jrn.ord) AS ord,MAX(date) as date,fus","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id",array("dev_mdl.ord","id_crc"),array($i,$id_dev_crc)));
			if(!is_null($dt_jrn['ord'])) {$flg_mdl = true;}
		}
		if($flg_mdl) {
			$max_date = $dt_jrn['date'];
			$max_ord = $dt_jrn['ord'];
			if($dt_jrn['fus']) {$flg_plus = false;}
		}
	}
	else{
		$dt_jrn = ftc_ass(sel_quo("MIN(dev_jrn.ord) AS ord,MIN(date) as date","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","id_crc",$id_dev_crc));
		if(!is_null($dt_jrn['ord'])) {
			$max_date = $min_date = $dt_jrn['date'];
			if($max_date!='0000-00-00') {$max_date = date ('Y-m-d', strtotime ("-1 days $max_date"));}
		}
	}
	$rq_mdl = sel_whe("id,ord,fus","dev_mdl","ord >".$ord_mdl." AND id_crc=".$id_dev_crc,"ord");
	while($dt_mdl = ftc_ass($rq_mdl)) {
		$rq_jrn = sel_quo("id,ord,date","dev_jrn","id_mdl",$dt_mdl['id']);
		while($dt_jrn = ftc_ass($rq_jrn)) {
			$date = $dt_jrn['date'];
			if($date!='0000-00-00') {
				$date = date ('Y-m-d', strtotime ("+1 days $date"));
				$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
				$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
			}
			upd_noq("dev_jrn",array("ord","date"),array("ord+1","'".$date."'"),$dt_jrn['id']);
		}
		$err_ord .= $dt_mdl['ord'].', ';
	}
	if($flg_plus) {
		$ord_jrn = $max_ord + 1;
		if($max_date!="0000-00-00") {$date = date ('Y-m-d', strtotime ("+1 days $max_date"));}
		else{$date = '0000-00-00';}
	}
	else{
		$ord_jrn = $max_ord;
		$date = $max_date;
	}
	upd_noq('dev_crc','duree','duree+1',$id_dev_crc);
}
else{
	$opt_jrn = 0;
	$dt_jrn = ftc_ass(sel_quo("date","dev_jrn",array("id_mdl","ord"),array($id_dev_mdl,$ord_jrn)));
	$date = $dt_jrn['date'];
}
$dt_dev_mdl = ftc_ass(sel_quo("id_crc,trf","dev_mdl","id",$id_dev_mdl));
$dt_dev_crc = ftc_ass(sel_quo("crr","dev_crc","id",$dt_dev_mdl['id_crc']));
$id_crr_crc = $dt_dev_crc['crr'];
if($dt_dev_mdl['trf']) {$rq_rmn = sel_quo("id","dev_mdl_rmn",array("nr","id_mdl"),array("1",$id_dev_mdl));}
else{$rq_rmn = sel_quo("id","dev_crc_rmn",array("nr","id_crc"),array("1",$dt_dev_mdl['id_crc']));}
$dt_rmn = ftc_ass($rq_rmn);
if(!empty($dt_rmn['id'])) {$id_rmn=$dt_rmn['id'];}
else{$id_rmn=0;}
if($id_cat_jrn > 0) {
	include("../resources/php/setJrnData.php");
	if($err_jrn != '') {$err .= $txt->err->jrn->$id_lng.$err_jrn."\n";}
	if($err_prs != '') {$err .= $txt->err->prs->$id_lng.$err_prs."\n";}
	if($err_hbr != '') {$err .= $txt->err->hbr->$id_lng.$err_hbr."\n";}
	if($err_srv != '') {$err .= $txt->err->srv->$id_lng.$err_srv."\n";}
	if(isset($lst_nvtrf)) {
		$err .= $txt->err->nvtrf->$id_lng."\n";
		foreach($lst_nvtrf as $nom) {$err .= "-> ".$nom."\n";}
	}
}
else{$id_dev_jrn = insert("dev_jrn",array("id_mdl","id_cat","ord","date","opt"),array($id_dev_mdl,$id_cat_jrn,$ord_jrn,$date,$opt_jrn));}
if($err_ord != '') {$err .= $txt->err->alrt->$id_lng.$err_ord.$txt->err->alrt2->$id_lng;}
echo $id_dev_jrn."|".$ant_jrn."|".$err."|".implode(",\n", $alt);
?>
