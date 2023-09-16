<?php
$rq_sel_prs = sel_quo("id","dev_prs","id_jrn",$id_dev_jrn);
while($dt_sel_prs = ftc_ass($rq_sel_prs)){
	$id_dev_prs = $dt_sel_prs['id'];
	include("sup_prs.php");
}
delete("dev_jrn","id",$id_dev_jrn);
?>
