<?php
$cbl = $_POST['cbl'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
include("../cfg/lng.php");
echo $txt->fin->$id_lng.': '.$txt->$cbl->$id_lng;
?>
