<?php
if(isset($_POST['cbl']) and isset($_POST['src']) and isset($_POST['obj']) and isset($_POST['id'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	$cbl = $_POST['cbl'];
	$src = upnoac(rawurldecode($_POST['src']));
	$obj = $_POST['obj'];
	$id = $_POST['id'];
	if(substr($obj,0,7)=='pax_ncn'){
		$dt_pax = ftc_ass(sel_quo("id,ncn","grp_pax","id",substr($obj,7)));
		include("../prm/ncn.php");
		include("vue_lst_ncn.php");
	}
}
?>