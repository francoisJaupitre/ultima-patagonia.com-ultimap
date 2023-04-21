<?php
include("../prm/fct.php");
$id_srv = $_POST['id_srv'];
$id_prs = $_POST['id_prs'];
insert("cat_prs_srv",array("id_prs","id_srv","opt"),array($id_prs,$id_srv,1));
?>