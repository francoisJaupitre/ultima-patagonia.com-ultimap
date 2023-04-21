<?php
include("../prm/fct.php");
$id_dev_jrn = $_POST['id_dev_jrn'];
$cbl = $_POST['cbl'];
if($cbl=='ttr_prs_apr'){
	$id_ref_prs = $_POST['id_ref_prs'];
	$dt_prs = ftc_ass(select("ord","dev_prs","id",$id_ref_prs));
	$ord_prs = $dt_prs['ord'];
	$rq_prs = select("id,ord","dev_prs","id_jrn",$id_dev_jrn);
	while($dt_prs = ftc_ass($rq_prs)){
		if($dt_prs['ord']>=$ord_prs){$arr_prs[] = $dt_prs['id'];}
	}
}
else{
	$rq_prs = select("id","dev_prs","id_jrn",$id_dev_jrn);
	while($dt_prs = ftc_ass($rq_prs)){$arr_prs[] = $dt_prs['id'];}
}
if(isset($arr_prs)){
	$imp_prs = implode("|",$arr_prs);
	echo $imp_prs;
}
else{echo 0;}
?>
