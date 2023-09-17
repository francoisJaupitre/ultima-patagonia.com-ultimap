<?php //ADD A BASE (NUMBER OF PASSENGERS) IN A QUOTATION
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(
	isset($data['cbl']) and !empty($data['cbl'])
	and isset($data['base']) and !empty($data['base'])
	and isset($data['id']) and $data['id'] > 0
	and isset($data['cnf'])
)
{
	$base = $data['base'];
	$txt = simplexml_load_file('../xml/updateTxt.xml');
	include("functions.php");
	include("../../cfg/crr.php");
	include("../../cfg/lng.php");
	while(strpos($base, ';'))
	{
		$bas[] = strstr($base, ';', true);
		$base = substr($base, strpos($base, ';')+1);
	}
	$bas[] = $base;
	foreach($bas as $bs)
	{
		if(strpos($bs, '-') !== false)
		{
			$b1 = intval(strstr($bs, '-',true));
			$b2 = intval(substr($bs, strpos($bs, '-')+1));
			if($b1 > 0 and $b2 > 0)
			{
				for($i = $b1; $i <= $b2; $i++)
				{
					$bss[] = $i;
				}
			}
		}elseif(intval($bs) > 0)
		{
			$bss[] = intval($bs);
		}
	}
	if(isset($bss))
	{
		$err_srv = '';
		if($data['cbl'] == 'crc')
		{
			$id_dev_crc = $data['id'];
			$dt_dev_crc = ftc_ass(sel_quo(
				"ptl, crr, id_clt, ty_mrq, com, mrq_hbr, frs",
				"dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",
				"dev_crc.id",
				$id_dev_crc
			));
			$ptl = $dt_dev_crc['ptl'];
			$id_crr_crc = $dt_dev_crc['crr'];
			$id_clt = $dt_dev_crc['id_clt'];
			$rq_bss_crc = sel_quo("base", "dev_crc_bss", "id_crc", $id_dev_crc);
			while($dt_bss_crc = ftc_ass($rq_bss_crc))
			{
				$bss_crc[] = $dt_bss_crc['base'];
			}
			unset($dt_dev_crc['ptl'],$dt_dev_crc['crr'],$dt_dev_crc['id_clt']);
		}elseif($data['cbl'] == 'mdl')
		{
			$id_dev_mdl = $data['id'];
			$dt_dev_mdl = ftc_ass(sel_quo("ptl, id_crc, com, mrq_hbr", "dev_mdl", "id", $id_dev_mdl));
			$ptl = $dt_dev_mdl['ptl'];
			$dt_dev_crc = ftc_ass(sel_quo(
				"crr, id_clt",
				"dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id",
				"dev_crc.id",
				$dt_dev_mdl['id_crc']
			));
			$id_crr_crc = $dt_dev_crc['crr'];
			$id_clt = $dt_dev_crc['id_clt'];
			$rq_bss_mdl = sel_quo("base", "dev_mdl_bss", "id_mdl", $id_dev_mdl);
			while($dt_bss_mdl = ftc_ass($rq_bss_mdl))
			{
				$bss_mdl[] = $dt_bss_mdl['base'];
			}
			unset($dt_dev_mdl['ptl'], $dt_dev_mdl['id_crc']);
		}
		$dt_clt = ftc_ass(sel_quo("id_ctg", "cat_clt", "id", $id_clt));
		$id_ctg_clt = $dt_clt['id_ctg'];
		if($data['cnf'] == 0)
		{
			$vue = 1;
		}else{
			$vue = 0;
		}
		$err_mrq = false;
		$dt_cfg = ftc_ass(sel_quo("*", "cfg_ctg_clt", "id", $id_ctg_clt));
		unset($dt_cfg['id'], $dt_cfg['nom'], $dt_cfg['frs']);
		foreach($bss as $base)
		{
			if($data['cbl'] == 'crc' and !isset($bss_crc) or !in_array($base, $bss_crc))
			{
				if(!empty(array_diff($dt_cfg, $dt_dev_crc)))
				{
					$err_mrq = true;
				}
				$dt_cfg = ftc_ass(sel_whe(
					"mrq",
					"cfg_mrq",
					"bs_min <= ".$base." AND bs_max >= ".$base." AND id_ctg_clt = ".$id_ctg_clt
				));
				insert("dev_crc_bss", array("id_crc", "base", "vue", "mrq"), array($id_dev_crc, $base, $vue, $dt_cfg['mrq']));
				$rq_mdl = sel_quo("id, trf", "dev_mdl", "id_crc", $id_dev_crc);
				while($dt_mdl = ftc_ass($rq_mdl))
				{
					if(!$dt_mdl['trf'])
					{
						$id_dev_mdl = $dt_mdl['id'];
						include("../../dev/ajt_trf_srv.php");
					}
				}
			}
			elseif($data['cbl'] == 'mdl' and !isset($bss_mdl) or !in_array($base,$bss_mdl))
			{
				unset($dt_cfg['ty_mrq']);
				if(!empty(array_diff($dt_cfg, $dt_dev_mdl)))
				{
					$err_mrq = true;
				}
				$dt_cfg = ftc_ass(sel_whe(
					"mrq",
					"cfg_mrq",
					"bs_min <= ".$base." AND bs_max >= ".$base." AND id_ctg_clt = ".$id_ctg_clt
				));
				insert("dev_mdl_bss", array("id_mdl", "base", "vue", "mrq"), array($id_dev_mdl, $base, $vue, $dt_cfg['mrq']));
				include("../../dev/ajt_trf_srv.php");
			}
		}
		$err = '';
		if($err_mrq)
		{
			$err .= $txt->err->mrq_bss->$id_lng."\n";
		}
		if($err_srv != '')
		{
			$err .= $txt->err->srv->$id_lng.$err_srv."\n";
		}
		if(isset($err_crr))
		{
			$err .= $txt->err->crr->$id_lng."\n";
			foreach($err_crr as $nom)
			{
				$err .= "-> ".$nom."\n";
			}
			$err .= "\n";
		}
		if(isset($lst_nvtrf))
		{
			$err .= $txt->err->nvtrf->$id_lng."\n";
			foreach($lst_nvtrf as $nom)
			{
				$err .= "-> ".$nom."\n";
			}
		}
		if($err != '')
		{
			echo json_encode(array($err));
		}
	}
}
?>
