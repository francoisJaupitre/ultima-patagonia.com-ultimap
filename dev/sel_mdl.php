<?php
include("../prm/fct.php");
$id_dev_crc = $_POST['id_dev_crc'];
$cbl = $_POST['cbl'];
if($cbl=='ttr_mdl_apr' or $cbl=='dt_mdl_apr' or $cbl=='end_mdl_apr' or $cbl=='ttr_jrn_apr'  or $cbl=='opt_jrn_apr' or $cbl=='ttr_mdl_avt' or $cbl=='dt_mdl_avt' or $cbl=='end_mdl_avt'){
	$dt_mdl = ftc_ass(select("ord","dev_mdl","id",$_POST['id_ref_mdl']));
	$ord_mdl = $dt_mdl['ord'];
	$rq_mdl = select("id,ord","dev_mdl","id_crc",$id_dev_crc);
	while($dt_mdl = ftc_ass($rq_mdl)){
		if($cbl=='ttr_mdl_avt' or $cbl=='dt_mdl_avt' or $cbl=='end_mdl_avt'){
			if($dt_mdl['ord']==$ord_mdl-1){$arr_mdl[] = $dt_mdl['id'];}
		}
		elseif($dt_mdl['ord']>$ord_mdl){$arr_mdl[] = $dt_mdl['id'];}
	}
}
else{
	$rq_mdl = select("id","dev_mdl","id_crc",$id_dev_crc);
	while($dt_mdl = ftc_ass($rq_mdl)){$arr_mdl[] = $dt_mdl['id'];}
}
if(isset($arr_mdl)){
	$imp_mdl = implode("|",$arr_mdl);
	echo $imp_mdl;
}
else{echo 0;}
?>
