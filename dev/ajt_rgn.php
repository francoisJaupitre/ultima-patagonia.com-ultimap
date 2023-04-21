<?php
if(isset($_POST['id_mdl']) and isset($_POST['id_rgn']) and $_POST['id_mdl'] > 0 and $_POST['id_rgn'] > 0) {
  include("../prm/fct.php");
  insert("dev_mdl_rgn",array('id_mdl','id_rgn'),array($_POST['id_mdl'],$_POST['id_rgn']));
}
?>
