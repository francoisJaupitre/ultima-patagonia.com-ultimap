<?php
if(isset($_POST['cbl']) and isset($_POST['id_rmn']) and isset($_POST['id_pax']) and ($_POST['cbl']=='crc' or $_POST['cbl']=='mdl') and $_POST['id_rmn'] > 0 and $_POST['id_pax'] > 0) {
  include("../prm/fct.php");
  delete("dev_".$_POST['cbl']."_rmn_pax","id_rmn=".$_POST['id_rmn']." AND id_pax",$_POST['id_pax']);
}
?>
