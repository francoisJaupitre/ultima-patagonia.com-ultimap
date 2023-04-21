<?php
include("../prm/fct.php");
$id_crc_mdl = $_POST['id_crc_mdl'];
$ord = $_POST['ord'];
$id_crc = $_POST['id_crc'];
$rq_mdl = select("id, ord, fus","cat_crc_mdl","id_crc",$id_crc);
while($dt_mdl = ftc_ass($rq_mdl)) {
	if($dt_mdl['ord'] == $ord-1 and $dt_mdl['fus']==1) {upd_quo("cat_crc_mdl","fus","NULL",$dt_mdl['id']);}
	if($dt_mdl['ord'] > $ord) {upd_noq("cat_crc_mdl","ord","ord-1",$dt_mdl['id']);}
}
delete('cat_crc_mdl',"id",$id_crc_mdl);
?>