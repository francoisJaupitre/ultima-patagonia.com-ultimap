<?php //GET PRESTATION RATES FROM CATALOG
if(isset($bss))
{
	$rq_dev_srv = sel_quo('id, id_cat, nom, crr', 'dev_srv', 'id_prs', $id_dev_prs);
	while($dt_dev_srv = ftc_ass($rq_dev_srv))
	{
		$id_dev_srv = $dt_dev_srv['id'];
		$id_cat_srv = $dt_dev_srv['id_cat'];
		$id_crr_srv = $dt_dev_srv['crr'];
		if($id_cat_srv > 0)
		{
			if($date != '0000-00-00')
			{
				$dt_trf1 = ftc_all(sel_quo(
					"*",
					"cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf",
					"id_srv",
					$id_cat_srv
				));
			}
			$dt_trf2 = ftc_all(sel_quo(
				"*",
				"cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf",
				array("def" ,"id_srv"),
				array(1, $id_cat_srv),
				"dt_max DESC"
			));
			$err_bss = '';
			$dt_min = $dt_max = '0000-00-00';
			$flg_crr = false;
			foreach($bss as $id_bss => $base)
			{
				$dt_dev_trf = ftc_ass(sel_quo("id", "dev_srv_trf", array("id_srv", "base"), array($id_dev_srv, $base)));
				if(!empty($dt_dev_trf['id']))
				{
					$id_dev_trf = $dt_dev_trf['id'];
				}else{
					$id_dev_trf = insert("dev_srv_trf", array("id_srv", "base"), array($id_dev_srv, $base));
				}
				include("updateSrvRates.php");
			}
			if($flg_crr)
			{
				$id_crr = $id_crr_crc;
				include("calculateCrrRates.php");
				upd_quo("dev_srv", array("crr", "taux", "sup", 'dt_min', 'dt_max'), array($cur, $taux, $sup, $dt_min, $dt_max), $id_dev_srv);
			}else{
				upd_quo('dev_srv', array('dt_min', 'dt_max'), array($dt_min, $dt_max), $id_dev_srv);
			}
			if($err_bss != '')
			{
				$err_srv .= '-> '.$txt->jour->$id_lng.' '.$ord_jrn;
				if($date != '0000-00-00')
				{
					$err_srv .= ' | '.date("d/m/Y", strtotime($date));
				}
				if($obj != 'frn_all')
				{
					$dt_srv = ftc_ass(sel_quo("nom", "dev_srv", "id", $id_dev_srv));
					$err_srv .= ' : '.$dt_srv['nom'];
				}
				$err_srv .= ', '.$txt->bss->$id_lng.' : '.$err_bss."\n";
			}
		}else{
			$cur = $dt_dev_srv['crr'];
			$id_crr = $id_crr_crc;
			include("calculateCrrRates.php");
			upd_quo("dev_srv", array("taux", "sup"), array($taux, $sup), $id_dev_srv);
			if($date != '0000-00-00')
			{
				$err_srv .= '-> '.date("d/m/Y",strtotime($date)).' : '.$dt_dev_srv['nom']."\n";
			}else{
				$err_srv .= '-> '.$txt->jour->$id_lng.' '.$ord_jrn.' : '.$dt_dev_srv['nom']."\n";
			}
		}
	}
}
$rq_dev_hbr = sel_quo('id, id_cat, id_cat_chm, rgm, crr_chm, crr_rgm', 'dev_hbr', 'id_prs', $id_dev_prs);
while($dt_dev_hbr = ftc_ass($rq_dev_hbr))
{
	$id_dev_hbr	= $dt_dev_hbr['id'];
	$id_cat_hbr = $dt_dev_hbr['id_cat'];
	$id_cat_chm = $dt_dev_hbr['id_cat_chm'];
	$id_hbr_rgm = $dt_dev_hbr['rgm'];
	$id_crr_chm = $dt_dev_hbr['crr_chm'];
	$id_crr_rgm = $dt_dev_hbr['crr_rgm'];
	if($id_cat_hbr > 0 and $id_cat_chm > 0)
	{
		$dt_cat_hbr = ftc_ass(sel_quo("id_frn, frs", "cat_hbr", "id", $id_cat_hbr));
		include("updateHbrRates.php");
	}else{
		$cur = $id_crr_chm;
		$id_crr = $id_crr_crc;
		include("calculateCrrRates.php");
		if($dt_dev_hbr['crr_rgm'] > 0)
		{
			$taux_chm = $taux;
			$sup_chm = $sup;
			$cur = $id_crr_rgm;
			$id_crr = $id_crr_crc;
			include("calculateCrrRates.php");
			upd_quo("dev_hbr", array("taux_chm", "sup_chm", "taux_rgm", "sup_rgm"), array($taux_chm, $sup_chm, $taux, $sup), $id_dev_hbr);
		}else{
			upd_quo("dev_hbr", array("taux_chm", "sup_chm"), array($taux, $sup), $id_dev_hbr);
		}
	}
	if($id_cat_hbr > 0)
	{
		$dt_cat_hbr = ftc_ass(sel_quo("nvtrf, nom", "cat_hbr", "id", $id_cat_hbr));
		if($dt_cat_hbr['nvtrf'] and (!isset($lst_nvtrf) or !in_array($dt_cat_hbr['nom'], $lst_nvtrf)))
		{
			$lst_nvtrf[] = $dt_cat_hbr['nom'];
		}
	}
}
?>
