<?php
include("../prm/fct.php");
$id_srv_trf = $_POST['id_srv_trf'];
$max = ftc_ass(select("MAX(bs_max) AS bs_max","cat_srv_trf_bss","id_trf",$id_srv_trf));
if(!empty($max['bs_max'])) {
	$dt_srv_bss = ftc_ass(select("id_frn,clc,est","cat_srv_trf_bss","bs_max=".$max['bs_max']." AND id_trf",$id_srv_trf));
	$bs = $max['bs_max']+1;
	insert('cat_srv_trf_bss',array("id_trf","bs_min","bs_max","id_frn","clc","est"),array($id_srv_trf,$bs,$bs,$dt_srv_bss['id_frn'],$dt_srv_bss['clc'],$dt_srv_bss['est']));
}
else{echo insert('cat_srv_trf_bss',array("id_trf","bs_min","bs_max"),array($id_srv_trf,1,1));}
?>
