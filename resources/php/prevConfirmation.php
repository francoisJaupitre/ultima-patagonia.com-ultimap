<?php //CHECK IF QUOTATION IS OK TO CONFIRM
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_dev_crc']) and $data['id_dev_crc'] > 0)
{
	$id_dev_crc = $data['id_dev_crc'];
	include("functions.php");
	include("../../prm/aut.php");
	$txt = simplexml_load_file('../../dev/txt.xml');
	$i = 0;
	$flg_date = false;
	$rq_mdl = sel_quo("id, ord, trf", "dev_mdl", "id_crc", $id_dev_crc, "ord");
	while($dt_mdl = ftc_ass($rq_mdl))
	{
		$j = 0;
		$id_dev_mdl = $dt_mdl['id'];
		if($dt_mdl['trf'])
		{
			$rq_bss = sel_quo("vue", "dev_mdl_bss", "id_mdl", $id_dev_mdl);
		}else{
			$rq_bss = sel_quo("vue", "dev_crc_bss", "id_crc", $id_dev_crc);
			$flg_crc = true;
		}
		while($dt_bss = ftc_ass($rq_bss))
		{
			if($dt_bss['vue'])
			{
				$j++;
			}
		}
		if($j != 1)
		{
			$arr_cnf[$i] = $dt_mdl['ord'];
			$i++;
		}else{
			$err_hbr = 0;
			$rq_jrn = sel_quo("id, date", "dev_jrn", array("opt", "id_mdl"), array(1, $id_dev_mdl));
			while($dt_jrn = ftc_ass($rq_jrn))
			{
				$id_dev_jrn = $dt_jrn['id'];
				if($dt_jrn['date'] == '0000-00-00')
				{
					$flg_date = true;
				}
				$rq_prs = sel_quo("id", "dev_prs", "id_jrn", $id_dev_jrn);
				while($dt_prs = ftc_ass($rq_prs))
				{
					$id_dev_prs = $dt_prs['id'];
					$rq_hbr = sel_quo("id, id_cat, opt", "dev_hbr", "id_prs", $id_dev_prs);
					while($dt_hbr = ftc_ass($rq_hbr))
					{
						if($dt_hbr['opt'] and $dt_hbr['id_cat'] == 0)
						{
							$err_hbr = 1;
						}
					}
				}
			}
			if($err_hbr == 1)
			{
				$arr_cnf[$i] = $dt_mdl['ord'];
				$i++;
			}
		}
	}
	if(!$flg_crc)
	{
		upd_var_quo("dev_crc_bss", "vue", "NULL", "id_crc", $id_dev_crc);
	}
	if(isset($arr_cnf))
	{
		$msg[] = (string)$txt->chk_cnf2->$id_lng;
		$qa = array_merge($msg, $arr_cnf);
	}
	elseif($flg_date)
	{
		$qa[] = (string)$txt->chk_cnf1->$id_lng;
	}
	else
	{
		$qa[] = 0;
	}
	echo json_encode($qa);
}
?>
