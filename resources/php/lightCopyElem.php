<?php //CREATE A COPY OF AN ELEMENT FROM CATALOG OR MAIN MENU IGNORING CHILDREN
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['cbl']) and isset($data['id']) and $data['id'] > 0 and isset($data['nom']) and !empty($data['nom']))
{
	include("functions.php");
	include("../../prm/aut.php");
	switch($data['cbl'])
	{
		case 'crc':
			$dt_crc = ftc_ass(sel_quo("*", "cat_crc", "id", $data['id']));
			unset($dt_crc['id']);
			$dt_crc['nom'] = $data['nom'];
			$dt_crc['dt_cat'] = date("Y-m-d");
			$dt_crc['usr'] = $id_usr;
			$id_crc_new = insert("cat_crc", array_keys($dt_crc), array_values($dt_crc));
			$rq_txt = sel_quo("*", "cat_crc_txt", "id_crc", $data['id']);
			while($dt_txt = ftc_ass($rq_txt))
			{
				unset($dt_txt['id']);
				$dt_txt['id_crc'] = $id_crc_new;
				insert("cat_crc_txt", array_keys($dt_txt), array_values($dt_txt));
			}
			$rq_clt = sel_quo("*", "cat_crc_clt", "id_crc", $data['id']);
			while($dt_clt = ftc_ass($rq_clt)){
				unset($dt_clt['id']);
				$dt_clt['id_crc'] = $id_crc_new;
				insert("cat_crc_clt", array_keys($dt_clt), array_values($dt_clt));
			}
			echo json_encode($id_crc_new);
			break;
		case 'mdl':
			$dt_mdl = ftc_ass(sel_quo("*", "cat_mdl", "id", $data['id']));
			unset($dt_mdl['id']);
			$dt_mdl['nom'] = $data['nom'];
			$dt_mdl['dt_cat'] = date("Y-m-d");
			$dt_mdl['usr'] = $id_usr;
			$id_mdl_new = insert("cat_mdl", array_keys($dt_mdl), array_values($dt_mdl));
			$rq_txt = sel_quo("*", "cat_mdl_txt", "id_mdl", $data['id']);
			while($dt_txt = ftc_ass($rq_txt))
			{
				unset($dt_txt['id']);
				$dt_txt['id_mdl'] = $id_mdl_new;
				insert("cat_mdl_txt", array_keys($dt_txt), array_values($dt_txt));
			}
			$rq_rgn = sel_quo("*", "cat_mdl_rgn", "id_mdl", $data['id']);
			while($dt_rgn = ftc_ass($rq_rgn))
			{
				unset($dt_rgn['id']);
				$dt_rgn['id_mdl'] = $id_mdl_new;
				insert("cat_mdl_rgn", array_keys($dt_rgn), array_values($dt_rgn));
			}
			echo json_encode($id_mdl_new);
			break;
		case 'jrn':
			$dt_jrn = ftc_ass(sel_quo("*", "cat_jrn", "id", $data['id']));
			unset($dt_jrn['id']);
			$dt_jrn['nom'] = $data['nom'];
			$dt_jrn['dt_cat'] = date("Y-m-d");
			$dt_jrn['usr'] = $id_usr;
			$id_jrn_new = insert("cat_jrn", array_keys($dt_jrn), array_values($dt_jrn));
			$rq_txt = sel_quo("*", "cat_jrn_txt", "id_jrn", $data['id']);
			while($dt_txt = ftc_ass($rq_txt))
			{
				unset($dt_txt['id']);
				$dt_txt['id_jrn'] = $id_jrn_new;
				insert("cat_jrn_txt", array_keys($dt_txt), array_values($dt_txt));
			}
			$rq_vll = sel_quo("*", "cat_jrn_vll", "id_jrn", $data['id']);
			while($dt_vll = ftc_ass($rq_vll))
			{
				unset($dt_vll['id']);
				$dt_vll['id_jrn'] = $id_jrn_new;
				insert("cat_jrn_vll", array_keys($dt_vll), array_values($dt_vll));
			}
			$rq_pic = sel_quo("*", "cat_jrn_pic", "id_jrn", $data['id']);
			while($dt_pic = ftc_ass($rq_pic))
			{
				unset($dt_pic['id']);
				$dt_pic['id_jrn'] = $id_jrn_new;
				insert("cat_jrn_pic", array_keys($dt_pic), array_values($dt_pic));
			}
			$rq_lieu = sel_quo("*", "cat_jrn_lieu", "id_jrn", $data['id']);
			while($dt_lieu = ftc_ass($rq_lieu))
			{
				unset($dt_lieu['id']);
				$dt_lieu['id_jrn'] = $id_jrn_new;
				insert("cat_jrn_lieu", array_keys($dt_lieu), array_values($dt_lieu));
			}
			echo json_encode($id_jrn_new);
			break;
		case 'prs':
			$dt_prs = ftc_ass(sel_quo("*", "cat_prs", "id", $data['id']));
			unset($dt_prs['id']);
			if(is_null($dt_prs['duree']))
			{
				unset($dt_prs['duree']);
			}
			$dt_prs['nom'] = $data['nom'];
			$dt_prs['dt_cat'] = date("Y-m-d");
			$dt_prs['usr'] = $id_usr;
			$id_prs_new = insert("cat_prs", array_keys($dt_prs), array_values($dt_prs));
			$rq_txt = sel_quo("*", "cat_prs_txt", "id_prs", $data['id']);
			while($dt_txt = ftc_ass($rq_txt))
			{
				unset($dt_txt['id']);
				$dt_txt['id_prs'] = $id_prs_new;
				insert("cat_prs_txt", array_keys($dt_txt), array_values($dt_txt));
			}
			$rq_lieu = sel_quo("*", "cat_prs_lieu", "id_prs", $data['id']);
			while($dt_lieu = ftc_ass($rq_lieu))
			{
				unset($dt_lieu['id']);
				$dt_lieu['id_prs'] = $id_prs_new;
				insert("cat_prs_lieu", array_keys($dt_lieu), array_values($dt_lieu));
			}
			echo json_encode($id_prs_new);
			break;
		case 'srv':
			$dt_srv = ftc_ass(sel_quo("*", "cat_srv", "id", $data['id']));
			unset($dt_srv['id'], $dt_srv['vrl']);
			$dt_srv['nom'] = $data['nom'];
			$dt_srv['dt_cat'] = date("Y-m-d");
			$dt_srv['usr'] = $id_usr;
			$id_srv_new = insert("cat_srv", array_keys($dt_srv), array_values($dt_srv));
			$rq_txt = sel_quo("*", "cat_srv_txt", "id_srv", $data['id']);
			while($dt_txt = ftc_ass($rq_txt))
			{
				unset($dt_txt['id']);
				$dt_txt['id_srv'] = $id_srv_new;
				insert("cat_srv_txt", array_keys($dt_txt), array_values($dt_txt));
			}
			echo json_encode($id_srv_new);
			break;
	}
}
?>
