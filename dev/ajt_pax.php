<?php
if(isset($_POST['cbl']) and isset($_POST['id']) and isset($_POST['id_sup']) and ($_POST['cbl']=='crc' or $_POST['cbl']=='mdl') and $_POST['id'] > 0 and $_POST['id_sup'] > 0) {
  include("../prm/fct.php");
  insert("dev_".$_POST['cbl']."_pax",array('id_pax','id_'.$_POST['cbl']),array($_POST['id'],$_POST['id_sup']));
}
?>
