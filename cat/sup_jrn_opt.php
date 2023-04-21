<?php
include("../prm/fct.php");
$id_mdl_jrn = $_POST['id_mdl_jrn'];
$ord = $_POST['ord'];
$id_mdl = $_POST['id_mdl'];
$nb_opt = ftc_ass(select("COUNT(*) as total","cat_mdl_jrn","id_mdl = ".$id_mdl." and ord",$ord));
if($nb_opt['total']==1) {
	$rq_jrn = select("id,ord","cat_mdl_jrn","id_mdl",$id_mdl);
	while($dt_jrn = ftc_ass($rq_jrn)) {
		if($dt_jrn['ord'] > $ord) {upd_noq("cat_mdl_jrn","ord","ord-1",$dt_jrn['id']);}
	}
}
delete('cat_mdl_jrn',"id",$id_mdl_jrn);
?>