<?php //DELETE AN ACCOMODATION ROOM IN CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_hbr_chm']) and $data['id_hbr_chm'] > 0)
{
	include("functions.php");
	$dt_prs_hbr = ftc_ass(sel_quo("id", "cat_prs_hbr", "id_chm", $data['id_hbr_chm']));
	if(empty($dt_prs_hbr['id']))
	{
		$rq_sel_trf = sel_quo('id', 'cat_hbr_chm_trf', 'id_chm', $data['id_hbr_chm']);
		while($dt_sel_trf = ftc_ass($rq_sel_trf))
		{
			delete('cat_hbr_chm_trf', "id", $dt_sel_trf['id']);
			delete('cat_hbr_chm_trf_ssn', "id_trf", $dt_sel_trf['id']);
		}
		delete('cat_hbr_chm', 'id', $data['id_hbr_chm']);
		delete('cat_hbr_chm_txt', 'id_hbr_chm', $data['id_hbr_chm']);
		delete('cat_vll_hbr', 'id_chm', $data['id_hbr_chm']);
	}else{
		$rq_prs_hbr = sel_quo("nom","cat_prs_hbr INNER JOIN cat_prs ON cat_prs_hbr.id_prs = cat_prs.id", "id_chm", $data['id_hbr_chm']);
		while($dt_prs_hbr = ftc_ass($rq_prs_hbr))
		{
			$err .= $dt_prs_hbr['nom']."\n";
		}
		include("../../cfg/lng.php");
		$txt = simplexml_load_file('../../cat/txt.xml');
		echo $txt->del_chm->$id_lng.$err;
	}
}
?>
