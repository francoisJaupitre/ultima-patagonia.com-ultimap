<?php
include("../prm/fct.php");
$id_hbr_chm_trf = $_POST['id_hbr_chm_trf'];
delete('cat_hbr_chm_trf',"id",$id_hbr_chm_trf);
delete('cat_hbr_chm_trf_ssn',"id_trf",$id_hbr_chm_trf)
?>