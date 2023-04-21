<?php
include("../prm/fct.php");
$id_frn = $_POST['id_frn'];
$taux = 0;
$rq_pay = select("taux","cat_frn_pay","id_frn",$id_frn);
while($dt_pay = ftc_ass($rq_pay)) {$taux += $dt_pay['taux'];}
$taux = 1-$taux;
insert('cat_frn_pay',array("id_frn","taux","ty_delai"),array($id_frn,$taux,1));
?>