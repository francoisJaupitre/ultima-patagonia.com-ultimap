<?php //DELETE A PASSENGER IN A GROUP
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_pax']) and $data['id_pax'] > 0)
{
  include("functions.php");
  $rq_crc_pax = sel_quo("id", "dev_crc_pax", "id_pax", $data['id_pax']);
  if(num_rows($rq_crc_pax) == 0)
  {
    $rq_mdl_pax = sel_quo("id", "dev_mdl_pax", "id_pax", $data['id_pax']);
    if(num_rows($rq_mdl_pax) == 0)
    {
      delete("grp_pax","id",$data['id_pax']);
    }else{
      $txt = simplexml_load_file('../../grp/txt.xml');
      include("../prm/aut.php");
      echo json_encode($txt->sup_pax->$id_lng);
    }
  }else{
    $txt = simplexml_load_file('../../grp/txt.xml');
    include("../prm/aut.php");
    echo json_encode($txt->sup_pax->$id_lng);
  }
}
?>
