<?php
$id_pax = $_POST['id'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
include("../cfg/lng.php");
$rq_crc_pax = sel_quo("id","dev_crc_pax","id_pax",$id_pax);
$rq_mdl_pax = sel_quo("id","dev_mdl_pax","id_pax",$id_pax);
if(num_rows($rq_crc_pax)==0 and num_rows($rq_mdl_pax)==0){delete("grp_pax","id",$id_pax);}
else{echo $txt->sup_pax->$id_lng;}
?>
