<?php
include("../prm/fct.php");
$obj=$_POST['obj'];
if($obj=="mdl"){
	$id_apr=0;
	$id_dev_crc = $_POST['id_sup'];
	$id_dev_mdl = $_POST['id'];
	$rq_srv = sel_whe("dev_srv.id","dev_srv INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id","dev_srv.res>0 AND dev_srv.res<4 AND id_mdl=".$id_dev_mdl);
	if(num_rows($rq_srv)>0){echo -1; return;}
	$rq_hbr = sel_whe("dev_hbr.id","dev_hbr INNER JOIN (dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id ","dev_hbr.id_cat!=-2 AND dev_hbr.res>0 AND dev_hbr.res<4 AND id_mdl=".$id_dev_mdl);
	if(num_rows($rq_hbr)>0){echo -1;	return;}
	include("sup_mdl.php");
	if($id_apr>0){echo $id_apr;}
	else{echo $id_bef;}
}
elseif($obj=="jrn"){
	$id_dev_mdl = $_POST['id_sup'];
	$id_dev_jrn = $_POST['id'];
	$rq_srv = sel_whe("dev_srv.id","dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res>0 AND dev_srv.res<4 AND id_jrn=".$id_dev_jrn);
	if(num_rows($rq_srv)>0){echo -1; return;}
	$rq_hbr = sel_whe("dev_hbr.id","dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.id_cat!=-2 AND dev_hbr.res>0 AND dev_hbr.res<4 AND id_jrn=".$id_dev_jrn);
	if(num_rows($rq_hbr)>0){echo -1;	return;}
	$id_apr=0;
	$nb_jrn = ftc_ass(select("COUNT(*) as total","dev_jrn","id_mdl",$id_dev_mdl));
	$dt_ord_mdl = ftc_ass(select("id_crc,fus,ord","dev_mdl","id",$id_dev_mdl));
	$id_dev_crc = $dt_ord_mdl['id_crc'];
	$fus_mdl = $dt_ord_mdl['fus'];
	$ord_mdl = $dt_ord_mdl['ord'];
	$dt_ord_jrn = ftc_ass(select("ord,opt","dev_jrn","id",$id_dev_jrn));
	$ord_jrn = $dt_ord_jrn['ord'];
	if($dt_ord_jrn['opt']==1){
		$rq_sel_jrn = select("id","dev_jrn","ord = ".$ord_jrn." and id_mdl",$id_dev_mdl);
		while($dt_sel_jrn = ftc_ass($rq_sel_jrn)){
			$id_dev_jrn = $dt_sel_jrn['id'];
			include("sup_jrn.php");
			upd_noq('dev_crc','duree','duree-1',$id_dev_crc);
		}
		$rq_mdl = select("id,ord","dev_mdl","id_crc",$id_dev_crc);
		while($dt_mdl = ftc_ass($rq_mdl)){
			$rq_jrn = select("id,ord,date","dev_jrn","id_mdl",$dt_mdl['id']);
			while($dt_jrn = ftc_ass($rq_jrn)){
				if(($dt_jrn['ord'] > $ord_jrn and $dt_mdl['ord']==$ord_mdl) or ($dt_jrn['ord']>=$ord_jrn and $dt_mdl['ord']>$ord_mdl and ($nb_jrn['total']>1 or $fus_mdl==0))){
					$date = $dt_jrn['date'];
					if($date!='0000-00-00'){$date = date ('Y-m-d', strtotime ("-1 days $date"));}
					upd_noq("dev_jrn",array("ord","date"),array("ord-1","'".$date."'"),$dt_jrn['id']);
				}
				if($dt_mdl['ord']==$ord_mdl and $dt_jrn['ord']==$ord_jrn+1){$id_apr=$dt_jrn['id'];}
			}
		}
		if($fus_mdl==1 and $nb_jrn['total']==1){
			upd_quo("dev_mdl","fus","NULL",$id_dev_mdl);
			upd_noq('dev_crc','duree','duree+1',$id_dev_crc);
		}
		echo $id_apr;
	}
	else{include("sup_jrn.php");}
}
elseif($obj=="prs"){
	$id_dev_jrn = $_POST['id_sup'];
	$id_dev_prs = $_POST['id'];
	$rq_srv = sel_whe("id","dev_srv","res>0 AND res<4 AND id_prs=".$id_dev_prs);
	if(num_rows($rq_srv)>0){echo -1; return;}
	$rq_hbr = sel_whe("id","dev_hbr","id_cat!=-2 AND res>0 AND res<4 AND id_prs=".$id_dev_prs);
	if(num_rows($rq_hbr)>0){echo -1;	return;}
	$id_apr=0;
	$dt_ord_prs = ftc_ass(select("ord,opt","dev_prs","id",$id_dev_prs));
	$ord_prs = $dt_ord_prs['ord'];
	$rq_sel_prs = select("id","dev_prs","ord = ".$ord_prs." AND id_jrn",$id_dev_jrn);
	if($dt_ord_prs['opt']==1){
		while($dt_sel_prs = ftc_ass($rq_sel_prs)){
			$id_dev_prs = $dt_sel_prs['id'];
			include("sup_prs.php");
		}
	}
	else{include("sup_prs.php");}
	if($dt_ord_prs['opt']==1 or num_rows($rq_sel_prs)==1){
		$rq_prs = select("id,ord","dev_prs","id_jrn",$id_dev_jrn);
		while($dt_prs = ftc_ass($rq_prs)){
			if($dt_prs['ord'] > $ord_prs){upd_noq("dev_prs","ord","ord-1",$dt_prs['id']);}
			if($dt_prs['ord']==$ord_prs+1){$id_apr=$dt_prs['id'];}
		}
		echo $id_apr;
	}
	echo '|'.$ord_prs;
}
elseif($obj=="srv"){
	delete("dev_srv","id",$_POST['id']);
	delete("dev_srv_trf","id_srv",$_POST['id']);
	delete("dev_srv_pay","id_srv",$_POST['id']);
}
elseif($obj=="hbr"){
	delete("dev_hbr","id",$_POST['id']);
	delete("dev_hbr_pay","id_hbr",$_POST['id']);
}
?>
