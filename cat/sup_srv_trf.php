<?php
include("../prm/fct.php");
$id_srv_trf = $_POST['id_srv_trf'];
delete('cat_srv_trf',"id",$id_srv_trf);
delete('cat_srv_trf_ssn',"id_trf",$id_srv_trf);
delete('cat_srv_trf_bss',"id_trf",$id_srv_trf);
?>