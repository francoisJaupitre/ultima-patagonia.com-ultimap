<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['ids']))
{
  include("../../prm/fct.php");
  include("../../prm/aut.php");
  $txt = simplexml_load_file('../../acc/txt.xml');
  $msg = '';
  foreach($data['ids'] as $id)
  {
    include("archiveElem.php");
    if(isset($err))
    {
      $msg .= $err;
      unset($err);
    }  
  }
  if(!empty($msg))
  {
    echo json_encode($txt->arch_pls_dev->$id_lng.$msg);
  }
}
?>
