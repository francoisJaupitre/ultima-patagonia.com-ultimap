<?php
include("../prm/fct.php");
$obj = $_POST["obj"];
$val = $_POST["val"];
if($obj=="mdl"){
	$id_dev_crc = $_POST["id_sup"];
	$id_dev_mdl = $_POST["id"];
	$min_mdl[0]=1; //$min_mdl = ftc_num(select("MIN(ord)","dev_mdl","id_crc",$id_dev_crc));
	$max_mdl = ftc_num(select("MAX(ord)","dev_mdl","id_crc",$id_dev_crc));
	if($val >= $min_mdl[0] and $val <= $max_mdl[0]){
		$dt = ftc_ass(select("ord, fus","dev_mdl","id",$id_dev_mdl));
		$ord_mdl = $dt['ord'];
		$fus = $dt['fus'];
		$nb_jrn = ftc_ass(select("COUNT(*) as total","dev_jrn","opt=1 AND id_mdl",$id_dev_mdl));
		$nb_j = $nb_jrn['total'];
		if($fus){$nb_j--;}
		$nb_i = 0;
		$rq_mdl = select("id,ord,fus","dev_mdl","id_crc",$id_dev_crc);
		while($dt_mdl = ftc_ass($rq_mdl)){
			if($dt_mdl['ord'] > $ord_mdl and $dt_mdl['ord'] <= $val){
				if($dt_mdl['fus']){$nb_i--;}
				$nb_k = -$nb_j;
				$rq_jrn = select("id,ord,opt,date","dev_jrn","id_mdl",$dt_mdl['id']);
				while($dt_jrn = ftc_ass($rq_jrn)){
					$date = $dt_jrn['date'];
					if($date!='0000-00-00'){
						$date = date ('Y-m-d', strtotime ("+$nb_k days $date"));
						$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
						echo $result."->res_srv_chg";
						$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
						echo $result."->res_hbr_chg";
					}
					upd_noq("dev_jrn",array("ord","date"),array($dt_jrn['ord']+$nb_k,"'".$date."'"),$dt_jrn['id']);
					if($dt_jrn['opt']){$nb_i++;}
				}
				upd_noq("dev_mdl","ord","ord-1",$dt_mdl['id']);
			}
			if($dt_mdl['ord'] < $ord_mdl and $dt_mdl['ord'] >= $val){
				if($dt_mdl['fus']){
					$nb_i--;
					if($dt_mdl['ord']+1==$max_mdl[0]){ //l'avant dernier devient dernier.
						upd_noq("dev_crc","duree","duree+1",$id_dev_crc);
						upd_quo("dev_mdl","fus","NULL",$dt_mdl['id']);
					}
				}
				$rq_jrn = select("id,ord,date,opt","dev_jrn","id_mdl",$dt_mdl['id']);
				while($dt_jrn = ftc_ass($rq_jrn)){
					$date = $dt_jrn['date'];
					if($date!='0000-00-00'){
						$date = date ('Y-m-d', strtotime ("+$nb_j days $date"));
						$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
						echo $result."->res_srv_chg";
						$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
						echo $result."->res_hbr_chg";
						}
					upd_noq("dev_jrn",array("ord","date"),array($dt_jrn['ord']+$nb_j,"'".$date."'"),$dt_jrn['id']);
					if($dt_jrn['opt']){$nb_i++;}
				}
				upd_noq("dev_mdl","ord","ord+1",$dt_mdl['id']);
			}
		}
		$rq_jrn = select("id,ord,date","dev_jrn","id_mdl",$id_dev_mdl);
		while($dt_jrn = ftc_ass($rq_jrn)){
			$date = $dt_jrn['date'];
			if($ord_mdl > $val){
				if($date!='0000-00-00'){
					$date = date ('Y-m-d', strtotime ("-$nb_i days $date"));
					$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
					echo $result."->res_srv_chg";
					$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
					echo $result."->res_hbr_chg";
					}
				upd_noq("dev_jrn",array("ord","date"),array($dt_jrn['ord']-$nb_i,"'".$date."'"),$dt_jrn['id']);
			}
			else{
				if($date!='0000-00-00'){
					$date = date ('Y-m-d', strtotime ("+$nb_i days $date"));
					$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
					echo $result."->res_srv_chg";
					$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
					echo $result."->res_hbr_chg";
				}
				upd_noq("dev_jrn",array("ord","date"),array($dt_jrn['ord']+$nb_i,"'".$date."'"),$dt_jrn['id']);
			}
		}
		upd_quo("dev_mdl","ord",$val,$id_dev_mdl);
		if($val == $max_mdl[0] and $fus){
			upd_noq("dev_crc","duree","duree+1",$id_dev_crc);
			upd_quo("dev_mdl","fus","NULL",$id_dev_mdl);
		}
		echo 1;
	}
	else{echo 0;}
}
elseif($obj=="jrn"){
	$id_dev_mdl = $_POST["id_sup"];
	$id_dev_jrn = $_POST["id"];
	$min_jrn = ftc_num(select("MIN(ord)","dev_jrn","id_mdl",$id_dev_mdl));
	$max_jrn = ftc_num(select("MAX(ord)","dev_jrn","id_mdl",$id_dev_mdl));
	if($val >= $min_jrn[0] and $val <= $max_jrn[0]){
		$dt = ftc_ass(select("ord, date","dev_jrn","id",$id_dev_jrn));
		$ord_jrn = $dt['ord'];
		$date_jrn = $dt['date'];
		if($date_jrn!='0000-00-00'){
			$date = date ('Y-m-d', strtotime ("+".$val-$ord_jrn." days $date_jrn"));
			$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$id_dev_jrn);
			echo $result."->res_srv_chg";
			$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$id_dev_jrn);
			echo $result."->res_hbr_chg";
			}
		else{$date='0000-00-00';}
		upd_quo("dev_jrn","date",$date,$id_dev_jrn);
		$rq_jrn = select("id,ord,date","dev_jrn","id_mdl",$id_dev_mdl);
		while($dt_jrn = ftc_ass($rq_jrn)){
			if($dt_jrn['ord'] > $ord_jrn and $dt_jrn['ord'] <= $val){
				$date = $dt_jrn['date'];
				if($date!='0000-00-00'){
					$date = date ('Y-m-d', strtotime ("-1 days $date"));
					$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
					echo $result."->res_srv_chg";
					$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
					echo $result."->res_hbr_chg";
				}
				upd_noq("dev_jrn",array("ord","date"),array("ord-1","'".$date."'"),$dt_jrn['id']);
			}
			if($dt_jrn['ord'] < $ord_jrn and $dt_jrn['ord'] >= $val){
				$date = $dt_jrn['date'];
				if($date!='0000-00-00'){
					$date = date ('Y-m-d', strtotime ("+1 days $date"));
					$result = upd_var_noq("dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id","dev_srv.res","3","(dev_srv.res=-2 OR dev_srv.res=1 OR dev_srv.res=2) AND id_jrn",$dt_jrn['id']);
					echo $result."->res_srv_chg";
					$result = upd_var_noq("dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","dev_hbr.res","3","(dev_hbr.res=-2 OR dev_hbr.res=1 OR dev_hbr.res=2) AND id_jrn",$dt_jrn['id']);
					echo $result."->res_hbr_chg";
				}
				upd_noq("dev_jrn",array("ord","date"),array("ord+1","'".$date."'"),$dt_jrn['id']);
			}
			if($dt_jrn['ord'] == $ord_jrn and $dt_jrn['id']!= $id_dev_jrn){upd_quo("dev_jrn","ord",$val,$dt_jrn['id']);}
		}
		upd_quo("dev_jrn","ord",$val,$id_dev_jrn);
		echo 1;
	}
	else{echo 0;}
}
elseif($obj=="prs"){
	$id_dev_jrn = $_POST["id_sup"];
	$id_dev_prs = $_POST["id"];
	$min_prs = ftc_num(select("MIN(ord)","dev_prs","id_jrn",$id_dev_jrn));
	$max_prs = ftc_num(select("MAX(ord)","dev_prs","id_jrn",$id_dev_jrn));
	if($val >= $min_prs[0] and $val <= $max_prs[0]){
		$dt = ftc_ass(select("ord","dev_prs","id",$id_dev_prs));
		$ord_prs = $dt['ord'];
		$rq_prs = select("id,ord","dev_prs","id_jrn",$id_dev_jrn);
		while($dt_prs = ftc_ass($rq_prs)){
			if($dt_prs['ord'] > $ord_prs and $dt_prs['ord'] <= $val){upd_noq("dev_prs","ord","ord-1",$dt_prs['id']);}
			if($dt_prs['ord'] < $ord_prs and $dt_prs['ord'] >= $val){upd_noq("dev_prs","ord","ord+1",$dt_prs['id']);}
			if($dt_prs['ord'] == $ord_prs and $dt_prs['id']!= $id_dev_prs){upd_quo("dev_prs","ord",$val,$dt_prs['id']);}
		}
		upd_quo("dev_prs","ord",$val,$id_dev_prs);
		echo 1;
	}
	else{echo 0;}
}
?>
