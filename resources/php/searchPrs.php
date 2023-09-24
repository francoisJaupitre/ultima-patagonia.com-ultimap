<?php //GET OTHERS SAME PRESTATIONS IN A QUOTATION WHEN USER MAKE SOME CHANGES
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(
	isset($data['id_cat']) and $data['id_cat'] > 0
	and isset($data['param'])
	and isset($data['id_dev_jrn']) and $data['id_dev_jrn'] > 0
	and isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0
)
{
	include("functions.php");
	$params = json_decode($data['param'], true);
	if(isset($params['ord']))
	{
		$xmlTxt0 = 'src_prs1';
		$xmlTxt1 = 'src_prs0';
		if($params['ord'] == 0)
		{
			//ajt_opt vue_dt_jrn
		}else{
			$dt_prs = ftc_ass(sel_quo("id_cat", "dev_prs", array("opt", "id_jrn", "ord"), array("1", $data['id_dev_jrn'], $params['ord'])));
			if($dt_prs['id_cat'] > 0)
			{
				$rq = sel_whe(
					"dev_jrn.id, dev_prs.ord",
					"dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id",
					"
						dev_jrn.opt = 1
						AND dev_jrn.id != ".$data['id_dev_jrn']."
						AND dev_mdl.id_crc = ".$data['id_dev_crc']."
						AND dev_prs.id_cat = ".$dt_prs['id_cat']
				);
				while($dt = ftc_ass($rq))
				{
					$flg = true;
					$rq_prs = sel_quo("id_cat", "dev_prs", array("ord", "id_jrn"), array($dt['ord'], $dt['id']));
					while($dt_prs = ftc_ass($rq_prs))
					{
						if($dt_prs['id_cat'] == $data['id_cat'])
						{
							$flg = false;
						}
					}
					if($flg)
					{
						if(!isset($lst) or !in_array($dt['id'], $lst))
						{
							$arr[] = $dt['id'];
							$arr[] = $dt['ord'];
							$lst[] = $dt['id'];
						}
					}
				}
			}
		}
	}elseif(isset($params['id_dev']))
	{
		if(isset($params['opt']))
		{
			$rq = sel_whe(
				"dev_prs.id AS id_prs, dev_jrn.id AS id_jrn",
				"dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id",
				"
					dev_jrn.opt = 1
					AND dev_jrn.id != ".$data['id_dev_jrn']."
					AND dev_mdl.id_crc = ".$data['id_dev_crc']."
					AND dev_prs.opt = ".$params['opt']."
					AND dev_prs.id_cat = ".$data['id_cat']
			);
			while($dt = ftc_ass($rq))
			{
				$arr[] = $dt['id_prs'];
				$arr[] = $dt['id_jrn'];
			}
			if(isset($params['id_cat_jrn']) and isset($params['id_dev_mdl']) and isset($params['id_ant']))
			{
				$xmlTxt0 = 'src_prs4';
				$xmlTxt1 = 'src_prs0';
			}elseif(isset($params['opt'] == 0))
			{
				$xmlTxt0 = 'src_prs2';
				$xmlTxt1 = 'src_prs0';
			}elseif(isset($params['opt'] == 1))
			{
				$xmlTxt0 = 'src_prs3';
				$xmlTxt1 = 'src_prs0';
			}
		}elseif(isset($params['res']))
		{
			$rq = sel_whe(
				"dev_prs.id AS id_prs",
				"dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id",
				"
					dev_jrn.opt = 1
					AND dev_jrn.id != ".$data['id_dev_jrn']."
					AND dev_mdl.id_crc = ".$data['id_dev_crc']."
					AND dev_prs.res != ".$params['res']."
					AND dev_prs.id_cat=".$data['id_cat']
			);
			while($dt = ftc_ass($rq))
			{
				$arr[] = $dt['id_prs'];
			}
			$xmlTxt0 = 'src_prs5';
			$xmlTxt1 = 'src_prs0';
		}
	}
	if(isset($arr))
	{
		include("../../prm/aut.php");
		$txt = simplexml_load_file('../xml/searchTxt.xml');
		$nb = count($arr);
		if(isset($params['ord']) or isset($params['opt']))
		{
			$nb /= 2;
		}
		$msg[] = $txt->$xmlTxt0->$id_lng." ".$nb." ".$txt->$xmlTxt1->$id_lng;
		$qa = array_merge($msg, $arr);
		echo json_encode($qa);
	}else{
		echo 0;
	}
}
?>
