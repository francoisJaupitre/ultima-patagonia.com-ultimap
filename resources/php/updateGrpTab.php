<?php //UPDATE TAB TITLE WITH NAME OF THE GROUP
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_grp']) and $data['id_grp'] > 0)
{
  include("functions.php");
  include("../../cfg/lng.php");
  $txt = simplexml_load_file('../../grp/txt.xml');
  $dt_grp = ftc_ass(sel_quo("nomgrp, id_clt", "grp_dev", "id", $data['id_grp']));
  $nom_tab = $txt->grp->$id_lng.': ';
  if(!empty($dt_grp['nomgrp']))
  {
    $nom_tab .= stripslashes($dt_grp['nomgrp']);
  }else{
    include("../../cfg/clt.php");
    $nom_tab .= stripslashes($clt[$dt_grp['id_clt']]);
  }
  $nb_pax = ftc_ass(sel_quo("COUNT(*) as total", "grp_pax", array("id_grp", "prt"), array($data['id_grp'], 1)));
  if($nb_pax['total'] > 0)
  {
    $nom_tab .= ' x'.$nb_pax['total'];
  }
  if(mb_strlen($nom_tab,'UTF-8') > 30){
    $nom_tab = mb_substr($nom_tab, 0, 30, 'UTF-8').'...';
  }
  echo json_encode($nom_tab);
  return;
}
?>
