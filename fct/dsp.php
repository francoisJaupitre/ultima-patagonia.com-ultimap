<?php
include("../prm/fct.php");
if($_POST['cbl']=='srv'){
	$id_dev_srv = $_POST['id'];
	$dt_srv = ftc_ass(sel_quo("id_frn,id_prs","dev_srv","id",$id_dev_srv));
	$dt_prs = ftc_ass(sel_quo("id_jrn","dev_prs","id",$dt_srv['id_prs']));
	$dt_jrn = ftc_ass(sel_quo("date","dev_jrn","id",$dt_prs['id_jrn']));
	insert("frn_dsp",array("id_frn","date"),array($dt_srv['id_frn'],$dt_jrn['date']));
	upd_quo("dev_srv",array("res","id_frn"),array("NULL","NULL"),$id_dev_srv);
	echo $dt_srv['id_frn'];
}
?>
