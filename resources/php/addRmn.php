<?php //CREATE NEW GUEST ROOMING FOR LODGING IN QUOTATION
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['cbl']) and !empty($data['cbl']) and isset($data['id']) and $data['id'] > 0)
{
	include("functions.php");
	if($data['cbl'] == 'crc')
	{
		$rq_bss_crc = sel_quo("base", "dev_crc_bss", array("vue", "id_crc"), array(1, $data['id']));
		$num_bss_crc = num_rows($rq_bss_crc);
		$dt_bss_crc = ftc_ass($rq_bss_crc);
		$bss_crc = $dt_bss_crc['base'];
		$dt_crc = ftc_ass(sel_quo("ptl", "dev_crc", "id", $data['id']));
		if($dt_crc['ptl'])
		{
			$bss_crc++;
		}
		$max_rmn = ftc_ass(sel_quo("MAX(nr), id", "dev_crc_rmn", "id_crc", $data['id']));
		$nr = $max_rmn['MAX(nr)'] + 1;
		$id_rmn = $max_rmn['id'];
		$nb_pax = ftc_ass(sel_quo("COUNT(id)", "dev_crc_rmn_pax", "id_rmn", $id_rmn));
		if($max_rmn['MAX(nr)'] > 0 and $nb_pax['COUNT(id)'] == $bss_crc)
		{
			$dt_rmn = ftc_ass(sel_quo("*", "dev_crc_rmn", "id", $id_rmn));
			unset($dt_rmn['id']);
			$dt_rmn['nr'] = $nr;
			insert("dev_crc_rmn", array_keys($dt_rmn), array_values($dt_rmn));
		}else{
			if($num_bss_crc != 1)
			{
				$txt = simplexml_load_file('../../dev/txt.xml');
				include("../../cfg/lng.php");
				$rsp = $txt->ajt_rmn->$id_lng;
			}else{
				$id_rmn = insert("dev_crc_rmn", array("id_crc", "nr"), array($data['id'], $nr));
				upd_var_quo(
					"dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id",
					"id_rmn",
					$id_rmn,
					array("id_rmn", "id_crc"),
					array(0, $data['id'])
				);
			}
		}
	}elseif($data['cbl'] == 'mdl')
	{
		$rq_bss_mdl = sel_quo("base", "dev_mdl_bss", array("vue", "id_mdl"), array(1, $data['id']));
		$num_bss_mdl = num_rows($rq_bss_mdl);
		$dt_bss_mdl = ftc_ass($rq_bss_mdl);
		$bss_mdl = $dt_bss_mdl['base'];
		$dt_mdl = ftc_ass(sel_quo("ptl", "dev_mdl", "id", $data['id']));
		if($dt_mdl['ptl'])
		{
			$bss_mdl++;
		}
		$max_rmn = ftc_ass(sel_quo("MAX(nr), id", "dev_mdl_rmn", "id_mdl", $data['id']));
		$nr = $max_rmn['MAX(nr)']+1;
		$id_rmn = $max_rmn['id'];
		$nb_pax = ftc_ass(sel_quo("COUNT(id)", "dev_mdl_rmn_pax", "id_rmn", $id_rmn));
		if($max_rmn['MAX(nr)'] > 0 and $nb_pax['COUNT(id)'] == $bss_mdl)
		{
			$dt_rmn = ftc_ass(sel_quo("*", "dev_mdl_rmn", "id", $id_rmn));
			unset($dt_rmn['id']);
			$dt_rmn['nr'] = $nr;
			insert("dev_mdl_rmn", array_keys($dt_rmn), array_values($dt_rmn));
		}else{
			if($num_bss_mdl != 1)
			{
				$txt = simplexml_load_file('../../dev/txt.xml');
				include("../../cfg/lng.php");
				$rsp = $txt->ajt_rmn->$id_lng;
			}else{
				$id_rmn = insert("dev_mdl_rmn", array("id_mdl", "nr"), array($data['id'], $nr));
				upd_var_quo("dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id",
					"id_rmn",
					$id_rmn,
					array("id_rmn", "id_mdl"),
					array(0, $data['id'])
				);
			}
		}
	}
	if(isset($rsp))
	{
		$qa = array((string)$rsp);
		echo json_encode($qa);
	}
}
?>
