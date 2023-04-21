<?php
$rq_dev_prs = select('id,id_cat','dev_prs','id_jrn',$id_dev_jrn);
while($dt_dev_prs = ftc_ass($rq_dev_prs)){
	$id_dev_prs = $dt_dev_prs['id'];
	include("act_trf_prs.php");		
}
?>