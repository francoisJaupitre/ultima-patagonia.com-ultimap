<?php
$nom_ctg_clt = $ty_mrq_ctg_clt = $com_ctg_clt = $mrq_hbr_ctg_clt = $frs_ctg_clt = array();
$rq_ctg_clt = sel_quo("*","cfg_ctg_clt","","","id");
if(num_rows($rq_ctg_clt)==0){
	insert("cfg_ctg_clt",array("nom","ty_mrq"),array("new margin type","1"));
	$nom_ctg_clt[1]= '';
	$ty_mrq_ctg_clt[1] = 1;
	$com_ctg_clt[1] = 0;
	$mrq_hbr_ctg_clt[1] = 0;
	$frs_ctg_clt[1] = 0;
	insert("cat_clt",array("id_ctg","nom","crr"),array(1,"new client type",1));
}
while($dt_ctg_clt = ftc_ass($rq_ctg_clt)){
	$nom_ctg_clt[$dt_ctg_clt['id']] = $dt_ctg_clt['nom'];
	$ty_mrq_ctg_clt[$dt_ctg_clt['id']] = $dt_ctg_clt['ty_mrq'];
	$com_ctg_clt[$dt_ctg_clt['id']] = $dt_ctg_clt['com'];
	$mrq_hbr_ctg_clt[$dt_ctg_clt['id']] = $dt_ctg_clt['mrq_hbr'];
	$frs_ctg_clt[$dt_ctg_clt['id']] = $dt_ctg_clt['frs'];
}
?>
