<?php
$tab=$_POST["tab"];
$col=$_POST["col"];
$val=rawurldecode($_POST["val"]);
$id=$_POST["id"];
include("../prm/fct.php");
include("../prm/aut.php");
include("../prm/lgg.php");
$txt = simplexml_load_file('txt.xml');
$car = substr(trim($val),0,1);
if((is_numeric($car) or $car == '(' or $car == ')' or $car == '=' or $car == '+' or $car == '-') and $col!='date' and $col!='dt_ctc' and $col!='dt_ech' and $col!='dt_stat' and $col!='nom' and $col!='commen' and $col!='duree' and $col!='motscles'){
	/*$val = str_replace(' ','',$val);
	$val = trim(preg_replace('/\t+/', '', $val));*/
	$val = preg_replace('/\s+/', '', $val);
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
		$val=round($val,4);
	}
}
elseif($col=='date' or $col=='dt_ctc' or $col=='dt_ech' or $col=='dt_stat'){
	if($val!=''){
		$dt = explode('/',$val);
		if(!isset($dt[2]) or $dt[2]==''){$y=date("Y");}
		else{$y=$dt[2];}
		$val = $y.'-'.$dt[1].'-'.$dt[0];
	}
	else{$val='0000-00-00';}
}
if($tab=='grp_tsk'){upd_quo("grp_tsk",array("dt_grp","usr"),array(date("Y-m-d"),$id_usr),$id);}
elseif($tab=='crm_ech' and $col=='stat'){upd_quo("crm_ech","dt_stat",date("Y-m-d"),$id);}
elseif($tab=='cfg_fin'){
	$dt_cfg = ftc_ass(sel_quo("id",$tab,"id",$id));
	if(!isset($dt_cfg['id'])){insert($tab,array("id"),array("1"));}
}
elseif($tab=='cfg_mrq' and ($col=='bs_min' or $col=='bs_max')){
	$id_ctg_clt = $_POST["id_sup"];
	$dt_cfg = ftc_ass(sel_quo("bs_min,bs_max","cfg_mrq","id",$id));
	$bs_min = $dt_cfg['bs_min'];
	$bs_max = $dt_cfg['bs_max'];
	if(($col=='bs_max' and $bs_min > $val and $val !='0') or ($col=='bs_min' and $bs_max < $val and $bs_max != '0' and $val !='0')){
		echo $txt->errbss->$id_lng;
		return;
	}
	$rq_mrq = sel_whe("id,bs_min,bs_max","cfg_mrq","id!=".$id." AND id_ctg_clt".$id_ctg_clt);
	while($dt_mrq = ftc_ass($rq_mrq)){
		if($val >= $dt_mrq['bs_min'] and $val <= $dt_mrq['bs_max'] and $val != 0){
			echo $txt->errbss2->$id_lng;
			return;
		}
		if($col=='bs_max' and $bs_min!='0' and $bs_min < $dt_mrq['bs_max'] and $val > $dt_mrq['bs_min'] and $val != 0){
			echo $txt->errbss3->$id_lng;
			return;
		}
		if($col=='bs_min' and $bs_max!='0' and $bs_max > $dt_mrq['bs_min'] and $val < $dt_mrq['bs_max']){upd_quo('cfg_mrq','bs_max',$val,$id);}
	}
}
$res = upd_quo($tab,$col,trim($val),$id);
echo $res;
?>
