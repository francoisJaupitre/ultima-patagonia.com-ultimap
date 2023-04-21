<?php
include("../prm/fct.php");
if(isset($_POST['id_pax']) and $_POST['id_pax'] >0){
	$id_pax = $_POST['id_pax'];
	$rq_crc = sel_quo("id_crc","dev_crc_pax","id_pax",$id_pax);
	while($dt_crc = ftc_ass($rq_crc)){$arr_pax[] = $dt_crc['id_crc'];}
	$rq_mdl = sel_quo("id_crc","dev_mdl_pax INNER JOIN dev_mdl ON dev_mdl_pax.id_mdl = dev_mdl.id",array("trf","id_pax"),array(1,$id_pax));
	while($dt_mdl = ftc_ass($rq_mdl)){$arr_pax[] = $dt_mdl['id_crc'];}
	$arr_pax = array_unique($arr_pax);
	if(isset($arr_pax) and !empty($arr_pax)){echo implode("|",$arr_pax);}
	else{echo 0;}
}
?>
