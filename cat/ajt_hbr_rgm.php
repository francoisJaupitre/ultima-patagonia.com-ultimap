<?php
include("../prm/fct.php");
$id_rgm = $_POST['id_rgm'];
$id_hbr = $_POST['id_hbr'];
insert('cat_hbr_rgm',array("id_hbr","rgm"),array($id_hbr,$id_rgm));
$rq_chm = select("id","cat_hbr_chm","id_hbr",$id_hbr);
while($dt_chm = ftc_ass($rq_chm)) {echo $dt_chm['id'].'|';}
?>