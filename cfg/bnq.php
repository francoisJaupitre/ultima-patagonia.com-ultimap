<?php
$bnq = array();
$bnq_pays = array();
$rq_bnq = sel_quo("*","cat_bnq","","","nom");
while($dt_bnq = ftc_ass($rq_bnq)){
	$bnq[$dt_bnq['id']] = $dt_bnq['nom'];
	$bnq_pays[$dt_bnq['id']] = $dt_bnq['id_pays'];
}
?>