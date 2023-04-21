<?php
if(isset($_POST['cbl'])){
	$txt = simplexml_load_file('txt.xml');
	$cbl = $_POST['cbl'];
	$dt_mn = $_POST['dat_min'];
	$dt_mx = $_POST['dat_max'];
	$nom_rai = $_POST['nom_rai'];
	$nom_imp = $_POST['nom_imp'];
	$id_vnt = $_POST['id_vnt'];
	$id_ctr = $_POST['id_ctr'];
	$id_itm = $_POST['id_itm'];
	$id_grp = $_POST['id_grp'];
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/crr.php");
	include("../cfg/fin.php");
	include("../cfg/itm.php");
	if($dt_mx!=''){
		$dt = explode('/',$dt_mx);
		if(!isset($dt[2])){$y = date("Y");}
		else{$y=$dt[2];}
		if(strtotime($y.'-'.$dt[1].'-'.$dt[0])>=strtotime($dat_min)){$dat_max = date("Y-m-d",strtotime($y.'-'.$dt[1].'-'.$dt[0]));}
		else{
			$max = ftc_num(sel_quo("MAX(date)","cmp_fac"));
			$dat_max = $max[0];
		}
	}
	else{
		$max = ftc_num(sel_quo("MAX(date)","cmp_fac"));
		$dat_max = $max[0];
	}
	if($dt_mn!=''){
		$dt = explode('/',$dt_mn);
		if(!isset($dt[2])){$y = date("Y");}
		else{$y=$dt[2];}
		if(strtotime($y.'-'.$dt[1].'-'.$dt[0])>=strtotime($dat_min)){$dat_min = date("Y-m-d",strtotime($y.'-'.$dt[1].'-'.$dt[0]));}
	}
}
else{
	$nom_rai = '*';
	$nom_imp = '*';
	$id_vnt = -1;
	$id_ctr = -1;
	$dat = $dat_min;
	$n = 0;
	$max = ftc_num(sel_quo("MAX(date)","cmp_fac"));
	$dat_max = $max[0];
	while($dat < $dat_max){
		$dat = date('Y-m-d', strtotime ("+1 years $dat"));
		if($dat < date("Y-m-d")){$chkhor[$n] = "false";}
		else{$chkhor[$n] = "true";}
		$n++;
	}
}
include("vue_".$cbl.".php");
?>
