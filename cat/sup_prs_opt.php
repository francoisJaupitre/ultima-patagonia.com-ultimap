<?php
include("../prm/fct.php");
$id_jrn_prs = $_POST['id_jrn_prs'];
$ord = $_POST['ord'];
$id_jrn = $_POST['id_jrn'];
$nb_opt = ftc_ass(select("COUNT(*) as total","cat_jrn_prs","id_jrn = ".$id_jrn." and ord",$ord));
if($nb_opt['total']==1) {
	$rq_prs = select("id, ord","cat_jrn_prs","id_jrn",$id_jrn);
	while($dt_prs = ftc_ass($rq_prs)) {
		if($dt_prs['ord'] > $ord) {upd_noq("cat_jrn_prs","ord","ord-1",$dt_prs['id']);}
	}
}
delete('cat_jrn_prs',"id",$id_jrn_prs);
?>