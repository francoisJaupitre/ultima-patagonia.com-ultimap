<?php
include("../prm/fct.php");
switch($_POST['obj']) {
	case 'crc_clt':
		$id_clt = $_POST['id'];
		$id_crc = $_POST['id_sup'];
		insert("cat_crc_clt",array("id_crc","id_clt"),array($id_crc,$id_clt));
		break;
	case 'mdl_rgn':
		$id_rgn = $_POST['id'];
		$id_mdl = $_POST['id_sup'];
		insert("cat_mdl_rgn",array("id_mdl","id_rgn"),array($id_mdl,$id_rgn));
		break;
	case 'jrn_vll':
		$id_vll = $_POST['id'];
		$id_jrn = $_POST['id_sup'];
		$rq_max_vll = select("MAX(ord)","cat_jrn_vll","id_jrn",$id_jrn);
		$max = ftc_num($rq_max_vll);
		$ord_vll = $max[0] + 1;
		insert("cat_jrn_vll",array("id_jrn","id_vll","ord"),array($id_jrn,$id_vll,$ord_vll));
		break;
	case 'jrn_pic':
		$id_jrn = $_POST['id'];
		$id_pic = $_POST['id_sup'];
		insert('cat_jrn_pic',array("id_pic","id_jrn"),array($id_pic,$id_jrn));
		break;
	case 'jrn_lieu':
		$id_lieu = $_POST['id'];
		$id_jrn = $_POST['id_sup'];
		$rq_max_lieu = select("MAX(ord)","cat_jrn_lieu","id_jrn",$id_jrn);
		$max = ftc_num($rq_max_lieu);
		$ord_lieu = $max[0] + 1;
		insert("cat_jrn_lieu",array("id_jrn","id_lieu","ord"),array($id_jrn,$id_lieu,$ord_lieu));
		break;
	case 'prs_lieu':
		$id_lieu = $_POST['id'];
		$id_prs = $_POST['id_sup'];
		$rq_max_lieu = select("MAX(ord)","cat_prs_lieu","id_prs",$id_prs);
		$max = ftc_num($rq_max_lieu);
		$ord_lieu = $max[0] + 1;
		insert("cat_prs_lieu",array("id_prs","id_lieu","ord","shw"),array($id_prs,$id_lieu,$ord_lieu,1));
		break;
	case 'frn_vll':
		$id_vll = $_POST['id'];
		$id_frn = $_POST['id_sup'];
		insert("cat_frn_vll",array("id_frn","id_vll"),array($id_frn,$id_vll));
		break;
	case 'frn_ctg_srv':
		$id_ctg = $_POST['id'];
		$id_frn = $_POST['id_sup'];
		insert("cat_frn_ctg_srv",array("id_frn","ctg_srv"),array($id_frn,$id_ctg));
		break;
}
?>
