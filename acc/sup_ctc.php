<?php
include("../prm/fct.php");
delete("crm_ech","id_ctc",$_POST['id']);
delete("crm_ctc","id",$_POST['id']);
?>
