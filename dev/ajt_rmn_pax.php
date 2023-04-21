<?php
if(isset($_POST['cbl']) and isset($_POST['id_rmn']) and isset($_POST['id_pax']) and ($_POST['cbl']=='crc' or $_POST['cbl']=='mdl') and $_POST['id_rmn'] > 0 and $_POST['id_pax'] > 0) {
  include("../prm/fct.php");
  $id_rmn_pax = insert("dev_".$_POST['cbl']."_rmn_pax",array("id_rmn","id_pax"),array($_POST['id_rmn'],$_POST['id_pax']));
  echo $id_rmn_pax;
}
?>
