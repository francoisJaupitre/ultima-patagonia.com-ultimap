<?php
include("../prm/fct.php");
$nom = $_POST["nom"];
$id_dev_crc = $_POST["id_dev_crc"];
$id_clt = $_POST["id_clt"];
$id_grp = insert("grp_dev",array("id_clt","nomgrp","usr"),array($id_clt,$nom,$id_usr));
upd_quo("dev_crc","id_grp",$id_grp,$id_dev_crc);
?>
