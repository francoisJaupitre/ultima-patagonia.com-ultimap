<?php
$rq_jrn = select("id, ord, date", "dev_jrn", "id_mdl", $id_dev_mdl);
while($dt_jrn = ftc_ass($rq_jrn))
{
	$id_dev_jrn = $dt_jrn['id'];
	$ord_jrn = $dt_jrn['ord'];
	$date = $dt_jrn['date'];
	$rq_prs = sel_quo("id", "dev_prs", "id_jrn", $id_dev_jrn);
	while($dt_prs = ftc_ass($rq_prs))
	{
		$id_dev_prs = $dt_prs['id'];
		$rq_srv = sel_quo("id, id_cat, nom, crr", "dev_srv", "id_prs", $id_dev_prs);
		while($dt_srv = ftc_ass($rq_srv))
		{
			$id_dev_srv = $dt_srv['id'];
			$id_cat_srv = $dt_srv['id_cat'];
			$id_crr_srv = $dt_srv['crr'];
			$err_bss = '';
			$dt_min = $dt_max = '0000-00-00';
			$id_dev_trf = insert("dev_srv_trf", array("id_srv", "base"), array($id_dev_srv, $base));
			if($id_cat_srv != 0)
			{
				if($date != '0000-00-00')
				{
					$dt_trf1 = ftc_all(sel_quo("*", "cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf", "id_srv", $id_cat_srv));
				}
				$dt_trf2 = ftc_all(sel_quo("*", "cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf", array("def", "id_srv"), array(1, $id_cat_srv), "dt_max DESC"));
				include("../resources/updateSrvRates.php");
				if($flg_trf)
				{
					$id_crr = $id_crr_crc;
					include("clc_crr.php");
					if($id_crr_srv != $cur and (isset($bss_crc) or isset($bss_mdl)))
					{
						upd_var_quo('dev_srv_trf', 'est', '-1', 'id_srv', $id_dev_srv);
						$err_crr[] = $dt_srv['nom'].' '.$txt->jour->$id_lng.' '.$ord_jrn;
					}
					upd_quo("dev_srv", array("crr", "taux", "sup", 'dt_min', 'dt_max'), array($cur, $taux, $sup, $dt_min, $dt_max), $id_dev_srv);
				}else{
					upd_quo('dev_srv', array('dt_min', 'dt_max'), array($dt_min, $dt_max), $id_dev_srv);
				}
			}elseif($date != '0000-00-00')
			{
				$err_srv .= $dt_dev_srv['nom'].' '.$txt->jour->$id_lng.' '.date("d/m/Y", strtotime($date))."\n";
			}else{
				$err_srv .= $dt_dev_srv['nom'].' '.$txt->jour->$id_lng.' '.$ord_jrn."\n";
			}
			if($err_bss != '')
			{
				$err_srv .= $dt_srv['nom'].' '.$txt->jour->$id_lng.' '.$ord_jrn."\n";
			}
		}
	}
}
?>
