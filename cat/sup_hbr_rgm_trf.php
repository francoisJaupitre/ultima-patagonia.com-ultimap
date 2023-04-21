<?php
include("../prm/fct.php");
$id_hbr_rgm_trf = $_POST['id_hbr_rgm_trf'];
delete('cat_hbr_rgm_trf',"id",$id_hbr_rgm_trf);
delete('cat_hbr_rgm_trf_ssn',"id_trf",$id_hbr_rgm_trf);
?>