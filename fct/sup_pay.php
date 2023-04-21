<?php
if(isset($_POST['cbl']) and ($_POST['cbl']=='hbr' or $_POST['cbl']=='srv') and isset($_POST['id']) and $_POST['id']>0) {
  include("../prm/fct.php");
  delete("dev_".$_POST['cbl']."_pay","id",$_POST['id']);
}
?>
