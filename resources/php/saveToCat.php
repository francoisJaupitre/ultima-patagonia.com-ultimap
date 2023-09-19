<?php //KEEP AN ELEMENT AND ITS SUB ELEMENTS FROM QUOTATION INTO CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(
	isset($data['elem']) and !empty($data['elem'])
	and isset($data['lgg']) and $data['lgg'] > 0
	and isset($data['nom']) and !empty($data['nom'])
	and isset($data['id']) and $data['id'] > 0
)
{
	$txt = simplexml_load_file('../../dev/txt.xml');
	include("functions.php");
	include("../../prm/aut.php");
	$id_lgg = $data['lgg'];
	switch($data['elem'])
	{
		case 'crc':
			$id_dev_crc = $data['id'];
			$nom_crc = $data['nom'];
			$dt_sel_crc = ftc_ass(sel_quo("titre, dsc", "dev_crc", "id", $id_dev_crc));
			include("saveToCatCrc.php");
			echo json_encode(array($id_cat_crc, (string)$txt->grdok->$id_lng));
			break;
		case 'mdl':
			$id_dev_mdl = $data['id'];
			$nom_mdl = $data['nom'];
			$dt_sel_mdl = ftc_ass(sel_quo("titre, dsc","dev_mdl", "id", $id_dev_mdl));
			include("saveToCatMdl.php");
			echo json_encode(array($id_cat_mdl, (string)$txt->grdok->$id_lng));
			break;
		case 'jrn':
			$id_dev_jrn = $data['id'];
			$nom_jrn = $data['nom'];
			$dt_sel_jrn = ftc_ass(sel_quo("titre, dsc", "dev_jrn", "id", $id_dev_jrn));
			include("saveToCatJrn.php");
			echo json_encode(array($id_cat_jrn, (string)$txt->grdok->$id_lng));
			break;
		case 'prs':
			$id_dev_prs = $data['id'];
			$nom_prs = $data['nom'];
			$dt_sel_prs = ftc_ass(sel_quo("ctg, titre, dsc", "dev_prs", "id", $id_dev_prs));
			include("saveToCatPrs.php");
			echo json_encode(array($id_cat_prs, (string)$txt->grdok->$id_lng));
			break;
		case 'srv':
			$id_dev_srv = $data['id'];
			$nom_srv = $data['nom'];
			if($id_dev_srv > 0)
			{
				$dt_srv = ftc_ass(sel_quo("id_vll, ctg, lgg", "dev_srv", "id", $id_dev_srv));
				$id_vll = $dt_srv['id_vll'];
				$ctg = $dt_srv['ctg'];
				$lgg_ctg = $dt_srv['lgg'];
			}else{
				$id_vll = $data['id_vll'];
				$ctg = $data['ctg'];
				$lgg_ctg = 0;
			}
			include("saveToCatSrv.php");
			echo json_encode(array($id_cat_srv, (string)$txt->grdok->$id_lng));
			break;
		case 'hbr':
			$id_dev_hbr = $data['id'];
			$nom_hbr = $data['nom'];
			$nom_chm = $data['nom_chm'];
			if(empty($nom_chm))
			{
				$nom_chm = 'Standard';
			}
			$dt_sel_hbr = ftc_ass(sel_quo("id_vll, rgm", "dev_hbr", "id", $id_dev_hbr));
			$id_rgm = $dt_sel_hbr['rgm'];
			include("saveToCatHbr.php");
			echo json_encode(array($id_cat_hbr, (string)$txt->grdok->$id_lng));
			break;
		case 'chm':
			$id_dev_hbr = $data['id'];
			$nom_chm = $data['nom'];
			$id_cat_hbr = $data['id_cat_hbr'];
			$dt_sel_hbr = ftc_ass(sel_quo("rgm", "dev_hbr", "id", $id_dev_hbr));
			$id_rgm = $dt_sel_hbr['rgm'];
			include("saveToCatChm.php");
			echo json_encode(array((string)$txt->grderr->$id_lng));
			break;
	}
}
?>
