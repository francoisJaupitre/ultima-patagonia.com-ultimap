<?php
include("../prm/fct.php");
include("../prm/aut.php");
$tab = $_POST["tab"];
$col = $_POST["col"];
$val = $_POST["val"];
$id = $_POST["id"];
if($col == 'dob' or $col == 'exp' or $col == 'date')
{
	if($val!='')
	{
		$val = str_replace('.','/',$val);
		$dt = explode('/',$val);
		switch ($col) {
			case 'date':
				if(!isset($dt[2]) or $dt[2]=='')
				{
					if(strtotime(date("Y").'-'.$dt[1].'-'.$dt[0]) >= strtotime(date("Y-m-d")))
					{
						$y = date("Y");
					}else{
						$y = date("Y")+1;
					}
				}else{
					$y = $dt[2];
				}
			break;
			case 'dob':
				if(strtotime($dt[2].'-'.$dt[1].'-'.$dt[0]) >= strtotime(date("Y-m-d")))
				{
					$dat = DateTime::createFromFormat('y', $dt[2]);
					$y = $dat->format('Y')-100;
				}else{
					$y = $dt[2];
				}
			break;
			default:
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
}
$res = upd_quo($tab, $col, trim($val), $id);
echo $res;
?>
