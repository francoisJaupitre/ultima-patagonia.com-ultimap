<?php
include("../prm/fct.php");
$val = $_POST["val"];
$id_dev_mdl = $_POST["id_dev_mdl"];
$id_dev_crc = $_POST["id_dev_crc"];
$dt = ftc_ass(select("ord,fus","dev_mdl","id",$id_dev_mdl));
$ord_mdl = $dt['ord'];
$fus_mdl = $dt['fus'];
if($val==1 and $fus_mdl==0){
	$rq_mdl = select("id,ord","dev_mdl","id_crc",$id_dev_crc);
	while($dt_mdl = ftc_ass($rq_mdl)){
		if($dt_mdl['ord'] > $ord_mdl){	
			$rq_jrn = select("id, ord, date","dev_jrn","id_mdl",$dt_mdl['id']);
			while($dt_jrn = ftc_ass($rq_jrn)){
				$date = $dt_jrn['date'];
				if($date!='0000-00-00'){$date = date ('Y-m-d', strtotime ("-1 days $date"));}
				upd_noq("dev_jrn",array("ord","date"),array("ord-1","'".$date."'"),$dt_jrn['id']);
			}
		}
	}
	upd_noq("dev_crc","duree","duree-1",$id_dev_crc);
}
elseif($fus_mdl==1){
	$rq_mdl = select("id,ord","dev_mdl","id_crc",$id_dev_crc);
	while($dt_mdl = ftc_ass($rq_mdl)){
		if($dt_mdl['ord'] > $ord_mdl){	
			$rq_jrn = select("id, ord, date","dev_jrn","id_mdl",$dt_mdl['id']);
			while($dt_jrn = ftc_ass($rq_jrn)){
				$date = $dt_jrn['date'];
				if($date!='0000-00-00'){$date = date ('Y-m-d', strtotime ("+1 days $date"));}
				upd_noq("dev_jrn",array("ord","date"),array("ord+1","'".$date."'"),$dt_jrn['id']);
			}
		}
	}
	upd_noq("dev_crc","duree","duree+1",$id_dev_crc);
}
upd_quo("dev_mdl","fus",$val,$id_dev_mdl);
?>