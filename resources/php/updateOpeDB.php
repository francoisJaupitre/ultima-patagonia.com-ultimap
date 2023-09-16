<?php //UPDATE DATABASE IN OPERATIONS
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data["tab"]) and isset($data["col"]) and isset($data["val"]) and isset($data["id"]))
{
	$tab = $data["tab"];
	$col = $data["col"];
	$val = $data["val"];
	$id = $data["id"];
	include("functions.php");
	$txt = simplexml_load_file('../xml/updateTxt.xml');
	$car = substr(trim($val), 0, 1);
	$not_col = array('date', 'mois', 'rva', 'info');
	if(!in_array($col, $not_col))
	{
		$val = preg_replace('/\s+/', '', $val);
		$len = strlen($val);
		$val = str_replace('=', '+', $val);
		$flg = true;
		for($i = 0; $i < $len; $i++)
		{
			$car = substr($val, $i, 1);
			if(!(is_numeric($car) or $car == '(' or $car == ')' or $car == '+' or $car == '-' or $car == '*' or $car == '/' or $car == '.' or $car == ','))
			{
				$flg = false;
				break;
			}
		}
		if($flg)
		{
			$code = '$val = '.str_replace(',', '.', $val).';';
			try
			{
				@eval($code);
			}catch(ParseError $e)
			{
				echo json_encode($txt->errval->$id_lng);
			 	return;
			}
			$val = round($val, 2);
		}
	}
	if($col == 'date' or $col == 'dt_min_chm' or $col == 'dt_max_chm' or $col == 'dt_min_rgm' or $col == 'dt_max_rgm' or $col == 'dob' or $col == 'exp')
	{
		if($val != '')
		{
			$dt = explode('/', $val);
			if(!isset($dt[2]))
			{
				if(strtotime(date("Y").'-'.$dt[1].'-'.$dt[0]) > strtotime(date("Y-m-d")))
				{
					$y = date("Y");
				}else{
					$y = date("Y")+1;
				}
			}else{
				$y = $dt[2];
			}
			$val = $y.'-'.$dt[1].'-'.$dt[0];
		}else{
			$val = '0000-00-00';
		}
		$res = upd_quo($tab, $col, "'".$val."'", $id);
	}
	if($tab == 'dev_prs' and ($col == 'heure' or $col == 'info'))
	{
		$dt_prs = ftc_ass(sel_quo("heure, info", "dev_prs", "id", $id));
		if(!is_null($dt_prs[$col]) and !empty($dt_prs[$col]))
		{
			$result = upd_var_noq("dev_srv", "res", "3", "(res = -2 OR res = 1 OR res = 2) AND id_prs", $id);
			$result = upd_var_noq("dev_hbr", "res", "3", "(res = -2 OR res = 1 OR res = 2) AND id_prs", $id);
		}
	}elseif($tab == 'dev_srv' and $col == 'res')
	{
		upd_quo("dev_srv", "dt_res", date("Y-m-d"), $id);
		$dt_res = ftc_ass(sel_quo(
			"id_grp, id_frn",
			"dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id",
			"dev_srv.id",
			$id
		));
		$rq_res = sel_quo("id", "grp_res", array("id_grp", "id_frn"), array($dt_res['id_grp'], $dt_res['id_frn']));
		if(num_rows($rq_res) == 0)
		{
			insert("grp_res", array("id_grp", "id_frn"), array($dt_res['id_grp'], $dt_res['id_frn']));
		}
	}elseif($tab == 'dev_hbr' and $col == 'res')
	{
		upd_quo("dev_hbr", "dt_res", date("Y-m-d"), $id);
		$dt_res = ftc_ass(sel_quo(
			"id_grp, dev_hbr.id_cat",
			"dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id",
			"dev_hbr.id",
			$id
		));
		$rq = sel_quo("id", "grp_res", array("id_grp", "id_hbr"), array($dt_res['id_grp'], $dt_res['id_cat']));
		if(num_rows($rq) == 0)
		{
			insert("grp_res", array("id_grp", "id_hbr"), array($dt_res['id_grp'], $dt_res['id_cat']));
		}
	}
	if($col == 'heure' and $val == ''){
		$res = upd_nul('dev_prs', 'heure', $id);
	}else{
		$res = upd_quo($tab, $col, trim($val), $id);
	}
	echo json_encode(array($res));
	return;
}
echo 0;
?>
