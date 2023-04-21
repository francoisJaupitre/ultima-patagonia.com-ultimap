<?php
if(isset($_POST['id'])) {
	$id_cat = $id = $_POST['id'];
	$cbl_cat = $cbl = $_POST['cbl'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
}
switch($cbl) {
	case 'crc':
		include("../prm/ctg_prs.php");
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/clt.php");
		include("../cfg/rgn.php");
		include("../cfg/vll.php");
		break;
	case 'mdl':
		include("../prm/ctg_prs.php");
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/rgn.php");
		include("../cfg/vll.php");
		break;
	case 'jrn':
		include("../prm/ctg_prs.php");
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/vll.php");
		include("../cfg/lieu.php");
		break;
	case 'prs':
		include("../prm/ctg_prs.php");
		include("../prm/ctg_srv.php");
		include("../prm/rgm.php");
		include("../cfg/lieu.php");
		include("../cfg/vll.php");
		break;
	case 'srv':
		include("../prm/ctg_srv.php");
		include("../cfg/crr.php");
		include("../cfg/frn.php");
		include("../cfg/vll.php");
		break;
	case 'hbr':
		include("../cfg/ctg_hbr.php");
		include("../prm/ctg_res.php");
		include("../prm/pays.php");
		include("../prm/rgm.php");
		include("../prm/ty_delai.php");
		include("../cfg/bnq.php");
		include("../cfg/crr.php");
		include("../cfg/frn.php");
		include("../cfg/vll.php");
		break;
	case 'clt':
		include("../cfg/crr.php");
		include("../cfg/ctg_clt.php");
		break;
	case 'frn':
		include("../prm/ctg_srv.php");
		include("../prm/ctg_res.php");
		include("../prm/pays.php");
		include("../prm/ty_delai.php");
		include("../prm/pays.php");
		include("../cfg/bnq.php");
		include("../cfg/crr.php");
		include("../cfg/vll.php");
		break;
	case 'pic':
		include("../cfg/rgn.php");
		include("../cfg/vll.php");
		break;
	case 'vll':
		include("../cfg/hbr_def.php");
		include("../prm/pays.php");
		include("../prm/rgm.php");
		include("../cfg/rgn.php");
		break;
	case 'lieu':
		include("../prm/ctg_prs.php");
		include("../prm/pays.php");
		include("../cfg/vll.php");
		break;
	case 'bnq':
		include("../prm/pays.php");
		break;
}
include("vue_".$cbl.".php");
?>
