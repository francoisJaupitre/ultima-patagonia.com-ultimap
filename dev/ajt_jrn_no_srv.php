<?php
$id_dev_mdl = $_POST['id_dev_mdl'];
$ord_jrn = $_POST['ord_jrn'];
$id_dev_crc = $_POST['id_dev_crc'];
$nbj = $_POST['nbj'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/lng.php");
$max_date = "0000-00-00";
$max_ord = 0;
$err = $err_ord = '';
$dt_mdl = ftc_ass(sel_quo("ord","dev_mdl","id",$id_dev_mdl));
$ord_mdl = $dt_mdl['ord'];
$flg_plus = true;
if($ord_jrn == 0){
	$dt_jrn = ftc_ass(sel_quo("MAX(ord) AS ord,MAX(date) as date","dev_jrn","id_mdl",$id_dev_mdl));
	if(!is_null($dt_jrn['ord'])){
		$max_date = $dt_jrn['date'];
		$max_ord = $dt_jrn['ord'];
	}
	elseif($ord_mdl!=1){
		$i = $ord_mdl;
		$flg_mdl = false;
		while(!$flg_mdl and $i>1){
			$i--;
			$dt_jrn = ftc_ass(sel_quo("MAX(dev_jrn.ord) AS ord,MAX(date) as date,fus","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id",array("dev_mdl.ord","id_crc"),array($i,$id_dev_crc)));
			if(!is_null($dt_jrn['ord'])){$flg_mdl = true;}
		}
		if($flg_mdl){
			$max_date = $dt_jrn['date'];
			$max_ord = $dt_jrn['ord'];
			if($i==$ord_mdl-1 and $dt_jrn['fus']==1){$flg_plus = false;}
		}
	}
	else{
		$dt_jrn = ftc_ass(sel_quo("MIN(dev_jrn.ord) AS ord,MIN(date) as date","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","id_crc",$id_dev_crc));
		if(!is_null($dt_jrn['ord'])){
			$min_date = $max_date = $dt_jrn['date'];
			if($max_date!='0000-00-00'){$max_date = date ('Y-m-d', strtotime ("-1 days $max_date"));}
		}
	}
	$rq_mdl = sel_whe("id,ord,fus","dev_mdl","ord >".$ord_mdl." AND id_crc=".$id_dev_crc,"ord");
	while($dt_mdl = ftc_ass($rq_mdl)){
		$rq_jrn = sel_quo("id,ord,date","dev_jrn","id_mdl",$dt_mdl['id']);
		while($dt_jrn = ftc_ass($rq_jrn)){
			$date = $dt_jrn['date'];
			if($date!='0000-00-00'){
				$date = date ('Y-m-d', strtotime ("+$nbj days $date"));
				$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
				$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
			}
			upd_noq("dev_jrn",array("ord","date"),array("ord+$nbj","'".$date."'"),$dt_jrn['id']);
		}
		$err_ord .= $dt_mdl['ord'].', ';
	}
	if($flg_plus){
		$ord_jrn = $max_ord + 1;
		if($max_date!="0000-00-00"){$date = date ('Y-m-d', strtotime ("+1 days $max_date"));}
		else{$date = '0000-00-00';}
	}
	else{
		$ord_jrn = $max_ord;
		$date = $max_date;
	}
	for($j=0;$j<intval($nbj);$j++){
		insert("dev_jrn",array("id_mdl","id_cat","ord","date","opt"),array($id_dev_mdl,'-1',$ord_jrn,$date,'1'));
		if($date!='0000-00-00'){$date = date ('Y-m-d', strtotime ("+1 days $date"));}
		$ord_jrn++;
	}
	if($err_ord != ''){$err = $txt->err->alrt->$id_lng.$err_ord.$txt->err->alrt2->$id_lng;}
	upd_noq('dev_crc','duree','duree+'.$nbj,$id_dev_crc);
}
else{
	$dt_jrn = ftc_ass(sel_quo("date","dev_jrn",array("id_mdl","ord"),array($id_dev_mdl,$ord_jrn)));
	insert("dev_jrn",array("id_mdl","id_cat","ord","date","opt"),array($id_dev_mdl,'-1',$ord_jrn,$dt_jrn['date'],'0'));
}
if($err != ''){echo $err;}
else{echo 1;}
?>
