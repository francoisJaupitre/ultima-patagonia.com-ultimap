<?php
include("../prm/fct.php");
include("../cfg/fin.php");
$tab=$_POST["tab"];
$col=$_POST["col"];
$val=$_POST["val"];
$id=$_POST["id"];
$car = substr(trim($val),0,1);
if((is_numeric($car) or $car == '(' or $car == ')' or $car == '=' or $car == '+' or $car == '-') and $col!='date' and $col!='nom' and $col!='imp' and $col!='fac' and $col!='dsc'){
	/*$val = str_replace(' ','',$val);
	$val = trim(preg_replace('/\t+/', '', $val));*/
	$val = preg_replace('/\s+/', '', $val);echo $val;
	$len = strlen($val);
	$val = str_replace('=','+',$val);
	$i = 0;
	$flg = true;
	while($i < $len and $flg){
		$car = substr($val,$i,1);
		if(is_numeric($car) or $car == '(' or $car == ')' or $car == '+' or $car == '-' or $car == '*' or $car == '/' or $car == '.' or $car == ','){$flg = true;}
		else{$flg = false;}
		$i++;
	}
	if($flg){
		$code = '$val='.str_replace(',','.',$val).';';
		if(@eval('return true;' . $code)){eval($code);}
		else{return 0;}
		$val=round($val,2);
	}
	if($tab=="cmp_clc"){
		$ids = explode('_',$id);
		$dt_cmp_clc = ftc_ass(sel_quo("id","cmp_clc",array("id_itm","id_grp"),array($ids[0],$ids[1])));
		if(empty($dt_cmp_clc['id'])){$id = insert("cmp_clc",array("id_itm","id_grp"),array($ids[0],$ids[1]));}
		else{$id = $dt_cmp_clc['id'];}
	}
}
$val = str_replace(array('"','|'),'',$val);
if($col=='date'){
	if($val!=''){
		$dt = explode('/',$val);
		if(!isset($dt[2])){$y = date("Y");}
		else{$y = $dt[2];}
		if(checkdate($dt[1],$dt[0],$y)){$val = $y.'-'.$dt[1].'-'.$dt[0];}
		else{return 0;}
		if(strtotime($val)<strtotime($dat_min)){return 0;}
	}
	else{return 0;}
}
$res = upd_quo($tab,$col,trim($val),$id);
echo $res;
?>
