<?php
include("../prm/fct.php");
$id_lieu = $_POST["id_lieu"];
$id_vll = $_POST["id_vll"];
$dt_vll = ftc_ass(select("lat,lon","cat_vll","id",$id_vll));
upd_quo("cat_lieu",array_keys($dt_vll),array_values($dt_vll),$id_lieu);
?>