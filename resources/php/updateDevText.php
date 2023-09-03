<?php //GET QUOTATION TEXTS FROM CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['obj']) and isset($data['lgg']) and $data['lgg'] > 0 and isset($data['id']) and $data['id'] > 0)
{
	include("functions.php");
	include("../../prm/aut.php");
	include("../../cfg/lng.php");
	$txt = simplexml_load_file('../xml/updateTxt.xml');
	$obj = $data['obj'];
	$id_lgg = $data['lgg'];
	$err_crc = '';
	$err_mdl = '';
	$err_jrn = '';
	$err_prs = '';
	switch ($obj)
	{
		case 'crc':
			$id_dev_crc = $data['id'];
			$dt_dev_crc = ftc_ass(sel_quo('id_cat, nom', 'dev_crc', 'id', $id_dev_crc));
			$id_cat_crc = $dt_dev_crc['id_cat'];
			include("updateCrcText.php");
			break;
		case 'mdl':
			$id_dev_mdl = $data['id'];
			$dt_dev_mdl = ftc_ass(sel_quo('id_cat, nom, ord', 'dev_mdl', 'id', $id_dev_mdl));
			$id_cat_mdl = $dt_dev_mdl['id_cat'];
			$ord_mdl = $dt_dev_mdl['ord'];
			include("updateMdlText.php");
			break;
		case 'jrn':
			$id_dev_jrn = $data['id'];
			$dt_dev_jrn = ftc_ass(sel_quo('id_cat, nom', 'dev_jrn', 'id', $id_dev_jrn));
			$id_cat_jrn = $dt_dev_jrn['id_cat'];
			include("updateJrnText.php");
			break;
		case 'prs':
			$id_dev_prs = $data['id'];
			$dt_dev_prs = ftc_ass(sel_quo('id_cat, nom', 'dev_prs', 'id', $id_dev_prs));
			$id_cat_prs = $dt_dev_prs['id_cat'];
			include("updatePrsText.php");
			break;
		case 'srv':
			$id_dev_srv = $data['id'];
			$dt_dev_srv = ftc_ass(sel_quo('id_cat', 'dev_srv', 'id', $id_dev_srv));
			$id_cat_srv = $dt_dev_srv['id_cat'];
			include("updateSrvText.php");
			break;
		case 'hbr':
			$id_dev_hbr = $data['id'];
			$dt_dev_hbr = ftc_ass(sel_quo('id_cat, id_cat_chm', 'dev_hbr', 'id', $id_dev_hbr));
			$id_cat_hbr = $dt_dev_hbr['id_cat'];
			$id_cat_chm = $dt_dev_hbr['id_cat_chm'];
			include("updateHbrText.php");
			break;
	}
	$err = '';
	if($err_crc != '')
	{
		$err .= $txt->err->crc->$id_lng.$err_crc."\n";
	}
	if($err_mdl != '')
	{
		$err .= $txt->err->mdl->$id_lng.$err_mdl."\n";
	}
	if($err_jrn != '')
	{
		$err .= $txt->err->jrn->$id_lng.$err_jrn."\n";
	}
	if($err_prs != '')
	{
		$err .= $txt->err->prs->$id_lng.$err_prs;
	}
	if($err != '')
	{
		echo $err;
	}else{
		echo 1;
	}
}
?>
