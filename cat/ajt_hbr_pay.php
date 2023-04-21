<?php
include("../prm/fct.php");
$id_hbr = $_POST['id_hbr'];
$taux = 0;
$rq_pay = select("taux","cat_hbr_pay","id_hbr",$id_hbr);
while($dt_pay = ftc_ass($rq_pay)) {$taux += $dt_pay['taux'];}
$taux = 1-$taux;
insert('cat_hbr_pay',array("id_hbr","taux","ty_delai"),array($id_hbr,$taux,1));
?>