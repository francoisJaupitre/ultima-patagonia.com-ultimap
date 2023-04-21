<?php
if(isset($_POST['html']) and isset($_POST['id'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $html = rawurldecode($_POST['html']);
  $id = $_POST['id'];
  $fp  = fopen("../tmp/".$dir."/rsm_rbk_prs".$id.".html","w+");
  fwrite($fp, $html);
  fclose($fp);
}
?>
