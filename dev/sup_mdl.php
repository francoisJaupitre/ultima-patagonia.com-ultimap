<?php
$rq_sel_jrn = select("id,opt","dev_jrn","id_mdl",$id_dev_mdl);
$nb_j = num_rows($rq_sel_jrn);
if($nb_j>0){
	while($dt_sel_jrn = ftc_ass($rq_sel_jrn)){
		$id_dev_jrn = $dt_sel_jrn['id'];
		include("sup_jrn.php");
		if($dt_sel_jrn['opt']){upd_noq('dev_crc','duree','duree-1',$id_dev_crc);}
	}
}
$dt_mdl = ftc_ass(select("ord,fus","dev_mdl","id",$id_dev_mdl));
if($dt_mdl['fus']==1 and $nb_j>0){
	upd_noq('dev_crc','duree','duree+1',$id_dev_crc);
	$nb_j--;
}
$ord_mdl = $dt_mdl['ord'];
$rq_mdl = select("id,ord,fus","dev_mdl","id_crc",$id_dev_crc,"ord");
while($dt_mdl = ftc_ass($rq_mdl)){
	if($dt_mdl['ord'] == $ord_mdl-1){
		$id_bef = $dt_mdl['id'];
		if($dt_mdl['fus']==1 and $nb_j>0){
			upd_quo("dev_mdl","fus","NULL",$dt_mdl['id']);
			upd_noq("dev_crc","duree","duree+1",$id_dev_crc);
			$nb_j--;
		}
	}
	if($dt_mdl['ord'] > $ord_mdl){
		upd_noq("dev_mdl","ord","ord-1",$dt_mdl['id']);
		$rq_jrn = select("id,ord,date","dev_jrn","id_mdl",$dt_mdl['id']);
		while($dt_jrn = ftc_ass($rq_jrn)){
			if($nb_j!=0){
				$date = $dt_jrn['date'];
				if($date!='0000-00-00'){$date = date ('Y-m-d', strtotime ("-$nb_j days $date"));}
				$ord = $dt_jrn['ord']-$nb_j;
				upd_noq("dev_jrn",array("ord","date"),array("'".$ord."'","'".$date."'"),$dt_jrn['id']);
			}
		}
	}
	if($dt_mdl['ord']==$ord_mdl+1){$id_apr = $dt_mdl['id'];}
}
delete("dev_mdl_bss","id_mdl",$id_dev_mdl);
$rq = select("id","dev_mdl_rmn","id_mdl",$id_dev_mdl);
while($dt = ftc_ass($rq)){delete("dev_mdl_rmn_pax","id_rmn",$dt['id']);}
delete("dev_mdl_rmn","id_mdl",$id_dev_mdl);
delete("dev_mdl_rgn","id_mdl",$id_dev_mdl);
delete("dev_mdl","id",$id_dev_mdl);
?>
