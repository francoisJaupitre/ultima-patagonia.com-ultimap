<?php
include("../prm/fct.php");
$id_ecr = $_POST['id'];
$dt_fin = ftc_ass(sel_quo("nature,date","fin_ecr","id",$id_ecr));
$rq_ecr = sel_quo("id","fin_ecr",array("nature","date"),array($dt_fin['nature'],$dt_fin['date']));
while($dt_ecr = ftc_ass($rq_ecr)) {
	if($id_ecr != $dt_ecr['id']) {
		upd_var_quo("fin_trs","id_ecr",$id_ecr,"id_ecr",$dt_ecr['id']);
		upd_var_quo("fin_bdg","id_ecr",$id_ecr,"id_ecr",$dt_ecr['id']);
		delete("fin_ecr","id",$dt_ecr['id']);
	}
}
?>
