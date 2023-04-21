<?php
include("../prm/fct.php");
$tab=$_POST["tab"];
$col=$_POST["col"];
$val=rawurldecode($_POST["val"]);
$id=$_POST["id"];
$res = upd_quo($tab,$col,trim($val),$id);
echo $res;
?>
