<?php
$tab=$_POST["tab"];
$col=$_POST["col"];
$val=rawurldecode($_POST["val"]);
$id=$_POST["id"];
include("../prm/fct.php");
include("../prm/aut.php");
include("../prm/lgg.php");
$txt = simplexml_load_file('txt.xml');
$not_col = array(
	'date',
	'dt_ctc',
	'dt_ech',
	'dt_stat',
	'nom',
	'commen',
	'duree',
	'motscles',
	'tel',
	'canal'
);
if(!in_array($col, $not_col))
{
	$val = preg_replace('/\s+/', '', $val);
	$len = strlen($val);
	$val = str_replace('=', '+', $val);
	$flg = true;
	$in_car = array('(', ')', '+', '-', '*', '/', '.', ',');
	for($i = 0; $i < $len; $i++)
	{
		$car = substr($val, $i, 1);
		if(!is_numeric($car) and !in_array($car, $in_car))
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
		if($col == 'frs' || $col == 'taux')
		{
			$val /= 100;
		}else{
			$val = round($val, 2);
		}
	}
}elseif($col == 'date' or $col == 'dt_ctc' or $col == 'dt_ech' or $col == 'dt_stat')
{
	if($val != '')
	{
		$dt = explode('/', $val);
		if(!isset($dt[2]) or $dt[2] == '')
		{
			$y = date("Y");
		}else{
			$y = $dt[2];
		}
		$val = $y.'-'.$dt[1].'-'.$dt[0];
	}else{
		$val = '0000-00-00';
	}
}
if($tab == 'grp_tsk')
{
	upd_quo("grp_tsk", array("dt_grp", "usr"), array(date("Y-m-d"), $id_usr), $id);
}elseif($tab == 'crm_ech' and $col == 'stat')
{
	upd_quo("crm_ech", "dt_stat", date("Y-m-d"), $id);
}elseif($tab == 'cfg_fin')
{
	$dt_cfg = ftc_ass(sel_quo("id", $tab, "id", $id));
	if(!isset($dt_cfg['id']))
	{
		insert($tab, array("id"), array("1"));
	}
}elseif($tab == 'cfg_mrq' and ($col == 'bs_min' or $col == 'bs_max'))
{
	$id_ctg_clt = $_POST["id_sup"];
	$dt_cfg = ftc_ass(sel_quo("bs_min, bs_max", "cfg_mrq", "id", $id));
	$bs_min = $dt_cfg['bs_min'];
	$bs_max = $dt_cfg['bs_max'];
	if(
		($col == 'bs_max' and $bs_min > $val and $val != '0')
		or ($col == 'bs_min' and $bs_max < $val and $bs_max != '0' and $val !='0')
	)
	{
		echo $txt->errbss->$id_lng;
		return;
	}
	$rq_mrq = sel_whe("id, bs_min, bs_max", "cfg_mrq", "id != ".$id." AND id_ctg_clt = ".$id_ctg_clt);
	while($dt_mrq = ftc_ass($rq_mrq))
	{
		if($val >= $dt_mrq['bs_min'] and $val <= $dt_mrq['bs_max'] and $val != 0)
		{
			echo $txt->errbss2->$id_lng;
			return;
		}
		if($col == 'bs_max' and $bs_min != '0' and $bs_min < $dt_mrq['bs_max'] and $val > $dt_mrq['bs_min'] and $val != 0)
		{
			echo $txt->errbss3->$id_lng;
			return;
		}
		if($col == 'bs_min' and $bs_max!='0' and $bs_max > $dt_mrq['bs_min'] and $val < $dt_mrq['bs_max'])
		{
			upd_quo('cfg_mrq', 'bs_max', $val, $id);
		}
	}
}
$res = upd_quo($tab, $col, trim($val), $id);
echo $res;
?>
