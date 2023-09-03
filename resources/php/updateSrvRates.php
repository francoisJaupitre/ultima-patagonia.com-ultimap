<?php //GET SERVICE RATES FROM CATALOG
$flg_trf = false;
if($date != '0000-00-00')
{
	foreach($dt_trf1 as $dt_trf)
	{
		if(
			strtotime($dt_trf['dt_min']) <= strtotime($date)
			and strtotime($date) <= strtotime($dt_trf['dt_max'])
			and $dt_trf['bs_min'] <= $base + $ptl
			and $dt_trf['bs_max'] >= $base + $ptl
			and $dt_trf['bs_min'] != 0
			and $dt_trf['bs_max'] != 0
		)
		{
			$flg_trf = $flg_crr = true;
			if($dt_trf['id_frn'] > 0)
			{
				$dt_frn = ftc_ass(sel_quo("nvtrf, nom, frs", "cat_frn", "id", $dt_trf['id_frn']));
				if($dt_frn['nvtrf'] and (!isset($lst_nvtrf) or !in_array($dt_frn['nom'], $lst_nvtrf)))
				{
					$lst_nvtrf[] = $dt_frn['nom'];
				}
				upd_quo("dev_srv", "frs", $dt_frn['frs'], $id_dev_srv);
			}
			$trf_net = $dt_trf['trf_net'];
			$trf_rck = $dt_trf['trf_rck'];
			$cur = $dt_trf['crr'];
			if($dt_trf['clc'])
			{
				$trf_net /= $base;
				$trf_rck /= $base;
			}else{
				$trf_net *= ($base + $ptl) / $base;
			}
			upd_quo('dev_srv_trf', array('est', 'trf_net', 'trf_rck'), array($dt_trf['est'], $trf_net, $trf_rck), $id_dev_trf);
			if($dt_min == '0000-00-00' and $dt_max == '0000-00-00')
			{
				$dt_min = $dt_trf['dt_min'];
				$dt_max = $dt_trf['dt_max'];
			}else{
				if(strtotime($dt_min) < strtotime($dt_trf['dt_min']))
				{
					$dt_min = $dt_trf['dt_min'];
				}
				if(strtotime($dt_max) > strtotime($dt_trf['dt_max']))
				{
					$dt_max = $dt_trf['dt_max'];
				}
			}
		}
	}
}
if(!$flg_trf)
{
	foreach($dt_trf2 as $dt_trf)
	{
		if(
			!$flg_trf
			and $dt_trf['bs_min'] <= $base + $ptl
			and $dt_trf['bs_max'] >= $base + $ptl
			and $dt_trf['bs_min'] != 0
			and $dt_trf['bs_max'] != 0
		)
		{
			$flg_trf = $flg_crr = true;
			if($dt_trf['id_frn'] > 0)
			{
				$dt_frn = ftc_ass(sel_quo("nvtrf, nom, frs", "cat_frn", "id", $dt_trf['id_frn']));
				if($dt_frn['nvtrf'] and !in_array($dt_frn['nom'], $lst_nvtrf))
				{
					$lst_nvtrf[] = $dt_frn['nom'];
				}
				upd_quo("dev_srv", "frs", $dt_frn['frs'], $id_dev_srv);
			}
			$trf_net = $dt_trf['trf_net'];
			$trf_rck = $dt_trf['trf_rck'];
			$cur = $dt_trf['crr'];
			if($dt_trf['clc'])
			{
				$trf_net /= $base;
				$trf_rck /= $base;
			}else{
				$trf_net *= ($base + $ptl) / $base;
			}
			upd_quo('dev_srv_trf', array('est', 'trf_net', 'trf_rck'), array(1, $trf_net, $trf_rck), $id_dev_trf);
			if($dt_min == '0000-00-00' and $dt_max == '0000-00-00')
			{
				$dt_min = $dt_trf['dt_min'];
				$dt_max = $dt_trf['dt_max'];
			}else{
				if(strtotime($dt_min) < strtotime($dt_trf['dt_min']))
				{
					$dt_min = $dt_trf['dt_min'];
				}
				if(strtotime($dt_max) > strtotime($dt_trf['dt_max']))
				{
					$dt_max = $dt_trf['dt_max'];
				}
			}
		}
	}
}
if(!$flg_trf)
{
	upd_quo('dev_srv_trf', 'est', '-1', $id_dev_trf);
	if($ptl){
		$err_bss .= $base.'+1,';
	}else{
		$err_bss .= $base.',';
	}
}
?>
