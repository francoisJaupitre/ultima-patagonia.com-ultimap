<?php
$pst = array();
$rsl_pst = array();
$prd_pst = array();
$chg_pst = array();
$crn_pst = array();
$dtt_pst = array();
$rq_pst = sel_quo("*","fin_pst","","","pst");
while($dt_pst = ftc_ass($rq_pst)){
	$pst[$dt_pst['id']] = $dt_pst['pst'];
	$rsl_pst[$dt_pst['id']] = $dt_pst['rsl'];
	$prd_pst[$dt_pst['id']] = $dt_pst['sld_prd'];
	$chg_pst[$dt_pst['id']] = $dt_pst['sld_chg'];
	$crn_pst[$dt_pst['id']] = $dt_pst['sld_crn'];
	$dtt_pst[$dt_pst['id']] = $dt_pst['sld_dtt'];	
}
?>