<?php
if(isset($_POST['url']) and isset($_POST['id'])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  $url = rawurldecode($_POST['url']);
  $id = $_POST['id'];
  $image = file_get_contents($url);
  $fp  = fopen("../tmp/".$dir."/map_rbk_prs".$id.".jpeg", "w");
  fputs($fp, $image);
  fclose($fp);
  unset($image);
}
?>
