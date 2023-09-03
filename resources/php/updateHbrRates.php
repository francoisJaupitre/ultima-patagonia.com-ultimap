<?php //GET ACCOMODATION RATES FROM CATALOG
$flg_trf = false;
if($date != '0000-00-00')
{
	$rq_trf = sel_quo('*', 'cat_hbr_chm_trf INNER JOIN cat_hbr_chm_trf_ssn ON cat_hbr_chm_trf.id = cat_hbr_chm_trf_ssn.id_trf', 'id_chm', $id_cat_chm);
	while($dt_trf = ftc_ass($rq_trf))
	{
		if(strtotime($dt_trf['dt_min']) <= strtotime($date) and strtotime($date) <= strtotime($dt_trf['dt_max']))
		{
			$flg_trf = true;
			$cur = $dt_trf['crr'];
			$id_crr = $id_crr_crc;
			include("calculateCrrRates.php");
			if($dt_cat_hbr['id_frn'] > 0)
			{
				$dt_frn = ftc_ass(sel_quo("frs", "cat_frn", "id", $dt_cat_hbr['id_frn']));
				$frs = $dt_frn['frs'];
			}else{
				$frs = $dt_cat_hbr['frs'];
			}
			upd_quo(
				'dev_hbr',
				array('crr_chm', 'frs', 'taux_chm', 'sup_chm', 'est_chm', 'dt_min_chm', 'dt_max_chm', 'db_rck_chm', 'db_net_chm', 'sg_rck_chm', 'sg_net_chm', 'tp_rck_chm', 'tp_net_chm', 'qd_rck_chm', 'qd_net_chm'),
				array($dt_trf['crr'], $frs, $taux, $sup, $dt_trf['est'], $dt_trf['dt_min'], $dt_trf['dt_max'], $dt_trf['db_rck'], $dt_trf['db_net'], $dt_trf['sg_rck'], $dt_trf['sg_net'], $dt_trf['tp_rck'], $dt_trf['tp_net'], $dt_trf['qd_rck'], $dt_trf['qd_net']),
				$id_dev_hbr
			);
		}
	}
}
if(!$flg_trf)
{
	$dt_trf = ftc_ass(sel_whe(
		'*',
		'cat_hbr_chm_trf INNER JOIN cat_hbr_chm_trf_ssn ON cat_hbr_chm_trf.id = cat_hbr_chm_trf_ssn.id_trf',
		'cat_hbr_chm_trf_ssn.dt_max = (SELECT MAX(dt_max) FROM cat_hbr_chm_trf_ssn WHERE id_trf = cat_hbr_chm_trf.id) AND def = 1 and id_chm = '.$id_cat_chm
	));
	if(!empty($dt_trf['id']))
	{
		$flg_trf = true;
		$cur = $dt_trf['crr'];
		$id_crr = $id_crr_crc;
		include("calculateCrrRates.php");
		if($dt_cat_hbr['id_frn'] > 0)
		{
			$dt_frn = ftc_ass(sel_quo("frs", "cat_frn", "id", $dt_cat_hbr['id_frn']));
			$frs = $dt_frn['frs'];
		}else{
			$frs = $dt_cat_hbr['frs'];
		}
		upd_quo(
			'dev_hbr',
			array('crr_chm', 'frs', 'taux_chm', 'sup_chm', 'est_chm', 'dt_min_chm', 'dt_max_chm', 'db_rck_chm', 'db_net_chm', 'sg_rck_chm', 'sg_net_chm', 'tp_rck_chm', 'tp_net_chm', 'qd_rck_chm', 'qd_net_chm'),
			array($dt_trf['crr'], $frs, $taux, $sup, 1, $dt_trf['dt_min'], $dt_trf['dt_max'], $dt_trf['db_rck'], $dt_trf['db_net'], $dt_trf['sg_rck'], $dt_trf['sg_net'], $dt_trf['tp_rck'], $dt_trf['tp_net'], $dt_trf['qd_rck'], $dt_trf['qd_net']),
			$id_dev_hbr
		);
	}
}
$flg_rgm = true;
$dt_chm = ftc_ass(sel_quo("rgm", "cat_hbr_chm", "id", $id_cat_chm));
if($dt_chm['rgm'] != $id_hbr_rgm)
{
	$flg_rgm = false;
	$dt_rgm = ftc_ass(sel_quo("id", "cat_hbr_rgm",array("rgm", "id_hbr"), array($id_hbr_rgm, $id_cat_hbr)));
	if($date != '0000-00-00')
	{
		$rq_trf = sel_quo('*', 'cat_hbr_rgm_trf INNER JOIN cat_hbr_rgm_trf_ssn ON cat_hbr_rgm_trf.id = cat_hbr_rgm_trf_ssn.id_trf', 'id_rgm', $dt_rgm['id']);
		while($dt_trf = ftc_ass($rq_trf))
		{
			if(strtotime($dt_trf['dt_min']) <= strtotime($date) and strtotime($date) <= strtotime($dt_trf['dt_max']))
			{
				$flg_rgm = true;
				$cur = $dt_trf['crr'];
				$id_crr = $id_crr_crc;
				include("calculateCrrRates.php");
				upd_quo(
					'dev_hbr',
					array('crr_rgm', 'taux_rgm', 'sup_rgm', 'est_rgm', 'dt_min_rgm', 'dt_max_rgm', 'db_rck_rgm', 'db_net_rgm', 'sg_rck_rgm', 'sg_net_rgm', 'tp_rck_rgm', 'tp_net_rgm', 'qd_rck_rgm', 'qd_net_rgm'),
					array($dt_trf['crr'], $taux, $sup, $dt_trf['est'], $dt_trf['dt_min'], $dt_trf['dt_max'], $dt_trf['db_rck'], $dt_trf['db_net'], $dt_trf['sg_rck'], $dt_trf['sg_net'], $dt_trf['tp_rck'], $dt_trf['tp_net'], $dt_trf['qd_rck'], $dt_trf['qd_net']),
					$id_dev_hbr
				);
			}
		}
	}
	if(!$flg_rgm)
	{
		$dt_trf = ftc_ass(sel_whe(
			'*',
			'cat_hbr_rgm_trf INNER JOIN cat_hbr_rgm_trf_ssn ON cat_hbr_rgm_trf.id = cat_hbr_rgm_trf_ssn.id_trf',
			'cat_hbr_rgm_trf_ssn.dt_max = (SELECT MAX(dt_max) FROM cat_hbr_rgm_trf_ssn WHERE id_trf = cat_hbr_rgm_trf.id) AND def = 1 and id_rgm = '.$dt_rgm['id']
		));
		if(!empty($dt_trf['id']))
		{
			$flg_rgm = true;
			$cur = $dt_trf['crr'];
			$id_crr = $id_crr_crc;
			include("calculateCrrRates.php");
			upd_quo(
				'dev_hbr',
				array('crr_rgm', 'taux_rgm', 'sup_rgm', 'est_rgm', 'dt_min_rgm', 'dt_max_rgm', 'db_rck_rgm', 'db_net_rgm', 'sg_rck_rgm', 'sg_net_rgm', 'tp_rck_rgm', 'tp_net_rgm', 'qd_rck_rgm', 'qd_net_rgm'),
				array($dt_trf['crr'], $taux, $sup, 1, $dt_trf['dt_min'], $dt_trf['dt_max'], $dt_trf['db_rck'], $dt_trf['db_net'], $dt_trf['sg_rck'], $dt_trf['sg_net'], $dt_trf['tp_rck'], $dt_trf['tp_net'], $dt_trf['qd_rck'], $dt_trf['qd_net']),
				$id_dev_hbr
			);
		}
	}
	if(!$flg_rgm)
	{
		$cur = 1;
		$id_crr = $id_crr_crc;
		include("calculateCrrRates.php");
		upd_quo("dev_hbr", array("crr_rgm", 'taux_rgm', 'sup_rgm'), array(1, $taux, $sup), $id_dev_hbr);
	}
}else{
	upd_quo(
		'dev_hbr',
		array('crr_rgm', 'taux_rgm', 'sup_rgm', 'est_rgm', 'dt_min_rgm', 'dt_max_rgm', 'db_rck_rgm', 'db_net_rgm', 'sg_rck_rgm', 'sg_net_rgm', 'tp_rck_rgm', 'tp_net_rgm', 'qd_rck_rgm', 'qd_net_rgm'),
		array(0, 0, 0, 0, "0000-00-00", "0000-00-00", 0, 0, 0, 0, 0, 0, 0, 0),
		$id_dev_hbr
	);
}
if(!$flg_trf or !$flg_rgm)
{
	if(!$flg_trf)
	{
		$cur = $id_crr_chm;
		$id_crr = $id_crr_crc;
		include("calculateCrrRates.php");
		upd_quo("dev_hbr", array("taux_chm", "sup_chm"), array($taux, $sup), $id_dev_hbr);
		upd_quo("dev_hbr", "est_chm", "-1", $id_dev_hbr);
	}
	if(!$flg_rgm)
	{
		$cur = $id_crr_rgm;
		$id_crr = $id_crr_crc;
		include("calculateCrrRates.php");
		upd_quo("dev_hbr", array("taux_rgm", "sup_rgm"), array($taux, $sup), $id_dev_hbr);
		upd_quo("dev_hbr", "est_rgm", "-1", $id_dev_hbr);
		}
	$dt_err_hbr = ftc_ass(sel_quo("nom", "dev_hbr", "id", $id_dev_hbr));
	if($date != '0000-00-00')
	{
		$err_hbr .= '-> '.date("d/m/Y", strtotime($date));
	}else{
		$err_hbr .= '-> '.$txt->jour->$id_lng.' '.$ord_jrn;
	}
	if(!isset($obj) or $obj != 'hbr_all')
	{
		$err_hbr .= ' : '.$dt_err_hbr['nom'];
	}
	$err_hbr .= "\n";
}
?>
