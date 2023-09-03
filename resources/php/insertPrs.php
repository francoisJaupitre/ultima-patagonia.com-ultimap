<?php //ADD PRESTATION IN THE DAY CATALOG
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_prs']) and $data['id_prs'] > 0 and isset($data['id_jrn']) and $data['id_jrn'] > 0)
{
  include("functions.php");
  $rq_jrn = sel_quo("id", "cat_jrn_prs", array("id_jrn", "id_prs"), array($data['id_jrn'], $data['id_prs']));
  if(num_rows($rq_jrn) > 0)
  {
    include("../../prm/aut.php");
    $txt = simplexml_load_file('../../cat/txt.xml');
    echo json_encode($txt->err_ajt_prs->$id_lng);
  }else{
    $max = ftc_num(sel_quo("MAX(ord)", "cat_jrn_prs", "id_jrn", $data['id_jrn']));
    $ord_prs = $max[0] + 1;
    insert('cat_jrn_prs', array("id_jrn", "id_prs", "ord", "opt"), array($data['id_jrn'], $data['id_prs'], $ord_prs, 1));
    echo 1;
  }
}
?>
