<?php
include("../prm/fct.php");
include("../prm/aut.php");
$ids = $_POST['ids'];
foreach($ids as $id){include("arch.php");}
?>
