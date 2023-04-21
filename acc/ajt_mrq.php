<?php
include("../prm/fct.php");
$id_ctg_clt = $_POST['id_ctg_clt'];
$max = ftc_ass(sel_quo("MAX(bs_max) AS bs_max","cfg_mrq","id_ctg_clt",$id_ctg_clt));
if(!empty($max['bs_max'])){
	$dt_mrq = ftc_ass(sel_quo("mrq","cfg_mrq",array("bs_max","id_ctg_clt"),array($max['bs_max'],$id_ctg_clt)));
	$bs = $max['bs_max']+1;
	insert('cfg_mrq',array("id_ctg_clt","bs_min","bs_max","mrq"),array($id_ctg_clt,$bs,$bs,$dt_mrq['mrq']));
}
else{insert('cfg_mrq',array("id_ctg_clt","bs_min","bs_max","mrq"),array($id_srv_trf,1,1,"0"));}
?>
