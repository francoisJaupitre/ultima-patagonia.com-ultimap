<?php
$cbl = $_POST['cbl'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
include("../cfg/lng.php");
echo $txt->cmp->$id_lng.': '.$txt->$cbl->$id_lng;
?>
