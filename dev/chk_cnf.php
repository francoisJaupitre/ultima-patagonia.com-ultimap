<?php
include("../prm/fct.php");
$id_dev_crc = $_POST['id_dev_crc'];
$i=0;
$flg_date = false;
$rq_mdl = select("id,ord,trf","dev_mdl","id_crc",$id_dev_crc);
while($dt_mdl = ftc_ass($rq_mdl)){
	$j=0;
	$id_dev_mdl = $dt_mdl['id'];
	if($dt_mdl['trf']){$rq_bss = select("vue","dev_mdl_bss","id_mdl",$id_dev_mdl);}
	else{
		$rq_bss = select("vue","dev_crc_bss","id_crc",$id_dev_crc);
		$flg_crc = true;
	}
	while($dt_bss = ftc_ass($rq_bss)){
		if($dt_bss['vue']==1){$j++;}
	}
	if($j!=1){
		$arr_cnf[$i]=$dt_mdl['ord'];
		$i++;
	}
	else{
		$err_hbr=0;
		$rq_jrn = select("id,date","dev_jrn","opt=1 AND id_mdl",$id_dev_mdl);
		while($dt_jrn = ftc_ass($rq_jrn)){
			$id_dev_jrn = $dt_jrn['id'];
			if($dt_jrn['date']=='0000-00-00'){$flg_date = true;}
			$rq_prs = select("id","dev_prs","id_jrn",$id_dev_jrn);
			while($dt_prs = ftc_ass($rq_prs)){
				$id_dev_prs = $dt_prs['id'];
				$rq_hbr = select("id,id_cat,opt","dev_hbr","id_prs",$id_dev_prs);
				while($dt_hbr = ftc_ass($rq_hbr)){
					if($dt_hbr['opt']==1 and $dt_hbr['id_cat']==0){$err_hbr=1;}
				}
			}
		}
		if($err_hbr==1){
			$arr_cnf[$i]=$dt_mdl['ord'];
			$i++;
		}
	}
}
if(!$flg_crc){upd_var_quo("dev_crc_bss","vue","NULL","id_crc",$id_dev_crc);}
if(isset($arr_cnf)){echo implode("|",$arr_cnf);}
elseif($flg_date){echo 'nodat';}
else{echo 0;}
?>
