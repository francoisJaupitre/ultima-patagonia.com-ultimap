<?php //CREATE A NEW PASSENGER IN A GROUP
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_grp']) and $data['id_grp'] > 0)
{
  include("functions.php");
  $dt_pax = ftc_ass(sel_quo("MAX(ord) AS ord", "grp_pax", "id_grp", $data['id_grp']));
  insert("grp_pax", array("id_grp", "ord"), array($data['id_grp'], $dt_pax['ord'] + 1));
}
?>
