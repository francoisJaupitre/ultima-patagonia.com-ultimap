<?php
if(isset($_POST['cbl'])) {
	$txt = simplexml_load_file('txt.xml');
	$cbl = $_POST['cbl'];
	$dt_mn = $_POST['dat_min'];
	$dt_mx = $_POST['dat_max'];
	$nom_nat = $_POST['nom_nat'];
	$id_css = $_POST['id_css'];
	$id_att = $_POST['id_att'];
	$id_pst = $_POST['id_pst'];
	$id_grp = $_POST['id_grp'];
	$chkhor = explode("|",$_POST['chkhor']);
	$chkver = explode("|",$_POST['chkver']);
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/crr.php");
	include("../cfg/css.php");
	include("../cfg/fin.php");
	include("../cfg/pst.php");
	if($dt_mx!='') {
		$dt = explode('/',$dt_mx);
		if(!isset($dt[2])) {$y = date("Y");}
		else{$y=$dt[2];}
		if(strtotime($y.'-'.$dt[1].'-'.$dt[0]) >= strtotime($dat_min) and strtotime($y.'-'.$dt[1].'-'.$dt[0]) >= strtotime($dat_fin)) {$dat_max = date("Y-m-d",strtotime($y.'-'.$dt[1].'-'.$dt[0]));}
		else{
			$max = ftc_num(sel_quo("MAX(date)","fin_ecr"));
			$dat_max = $max[0];
		}
	}
	else{
		$max = ftc_num(sel_quo("MAX(date)","fin_ecr"));
		$dat_max = $max[0];
	}
	if($dt_mn!='') {
		$dt = explode('/',$dt_mn);
		if(!isset($dt[2])) {$y = date("Y");}
		else{$y=$dt[2];}
		if(strtotime($y.'-'.$dt[1].'-'.$dt[0])>=strtotime($dat_min) and strtotime($y.'-'.$dt[1].'-'.$dt[0]) >= strtotime($dat_fin)) {$dat_min = date("Y-m-d",strtotime($y.'-'.$dt[1].'-'.$dt[0]));}
	}
	$min_m = date("Y",strtotime($dat_min))*12+date("m",strtotime($dat_min));
	$exc = intval(((date("Y",strtotime($dat_max)) * 12 + date("m",strtotime($dat_max))) - $min_m) / 12) + 1 + $nzero;
	$chkver = array_combine(range($nzero, count($chkver)+$nzero-1), array_values($chkver));
	for($i = count($chkver)+1; $i<$exc;$i++) {
		if(!isset($chkver[$i])) {$chkver[$i] = false;}
	}
	//print_r($chkver);
	$chkver[$exc] = true;
}
else{
	$nom_nat='*';
	$id_att='-1';
	$dat = $dat_min;
	$n = $nzero*12;
	$max = ftc_num(sel_quo("MAX(date)","fin_ecr"));
	$dat_max = $max[0];
	$min_m = date("Y",strtotime($dat_min))*12+date("m",strtotime($dat_min));
	if($cbl=='bln') {
		if(isset($dat_max)) {$exc = intval(((date("Y",strtotime($dat_max)) * 12 + date("m",strtotime($dat_max))) - $min_m) / 12) + 1 + $nzero;}
		else{$exc = $nzero;}
		$chkver[$exc] = true;
		$chkver[$exc-1] = true;
	}
	else{
		$chkhor[0] = $chkhor[1] = $chkhor[2] = $chkver[0] = $chkver[$nzero] = 0;
		while($dat < $dat_max) {
			$dat = date('Y-m-d', strtotime ("+1 years $dat"));
			if($dat < date("Y-m-d")) {$chkver[$n+1] = false;}
			else{$chkver[$n+1] = true;}
			$n++;
		}
	}
}
if(strtotime($dat_min) <  strtotime($dat_fin)){$dat_min = $dat_fin;}
include("vue_".$cbl.".php");
?>
