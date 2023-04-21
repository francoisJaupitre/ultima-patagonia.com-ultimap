<?php
include("../prm/fct.php");
$id_dev_mdl = $_POST['id_dev_mdl'];
$cbl = $_POST['cbl'];
if($cbl=='ttr_jrn_apr' or $cbl=='opt_jrn_apr'){
	$id_ref_jrn = $_POST['id_ref_jrn'];
	$dt_jrn = ftc_ass(select("ord","dev_jrn","id",$id_ref_jrn));
	$ord_jrn = $dt_jrn['ord'];
	$rq_jrn = select("id,ord","dev_jrn","id_mdl",$id_dev_mdl);
	while($dt_jrn = ftc_ass($rq_jrn)){
		if($dt_jrn['ord'] >= $ord_jrn){$arr_jrn[] = $dt_jrn['id'];}
		//$id_ref_jrn est jrn suivant qd sup donc eviter $dt_jrn['id']!=id_ref_jrn pour ttr_jrn_apr ! a verifier pour les autres cas.
	}
}
elseif($cbl=='ttr_jrn_avt1' or $cbl=='dt_jrn_avt1' or $cbl=='end_jrn_avt1'){
	$id_ref_jrn = $_POST['id_ref_jrn'];
	$dt_jrn = ftc_ass(sel_quo("ord","dev_jrn","id",$id_ref_jrn));
	$ord_jrn = $dt_jrn['ord']-1;
	$rq_jrn = sel_quo("id","dev_jrn",array("ord","id_mdl"),array($ord_jrn,$id_dev_mdl));
	if(num_rows($rq_jrn)>0){
		$dt_jrn = ftc_ass($rq_jrn);
		$arr_jrn[] = $dt_jrn['id'];
	}
}
elseif($cbl=='ttr_jrn_avt2'){
	$rq_jrn = sel_quo("id,ord","dev_jrn","id_mdl",$id_dev_mdl,"ord DESC LIMIT 1");
	if(num_rows($rq_jrn)>0){
		$dt_jrn = ftc_ass($rq_jrn);
		$arr_jrn[] = $dt_jrn['id'];
	}
}
elseif($cbl=='ttr_jrn_apr1' or $cbl=='dt_jrn_apr1' or $cbl=='end_jrn_apr1'){
	$id_ref_jrn = $_POST['id_ref_jrn'];
	$dt_jrn = ftc_ass(select("ord","dev_jrn","id",$id_ref_jrn));
	$ord_jrn = $dt_jrn['ord']+1;
	$rq_jrn = select("id,ord","dev_jrn","ord=".$ord_jrn." AND id_mdl",$id_dev_mdl);
	if(num_rows($rq_jrn)>0){
		$dt_jrn = ftc_ass($rq_jrn);
		$arr_jrn[] = $dt_jrn['id'];
	}
}
elseif($cbl=='ttr_jrn_lst'){
	$rq_jrn = select("MAX(ord) as ord,id","dev_jrn","opt=1 AND id_mdl",$id_dev_mdl);
	if(num_rows($rq_jrn)>0){
		$dt_jrn = ftc_ass($rq_jrn);
		$arr_jrn[] = $dt_jrn['id'];
	}
}
else{
	$rq_jrn = select("id","dev_jrn","id_mdl",$id_dev_mdl,"ord");
	while($dt_jrn = ftc_ass($rq_jrn)){$arr_jrn[] = $dt_jrn['id'];}
}
if(isset($arr_jrn)){echo implode("|",$arr_jrn);}
else{echo 0;}
?>
