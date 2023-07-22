<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_prs']) and isset($data['id_jrn']))
{
  include("../../prm/fct.php");
  include("../../prm/aut.php");
  $txt = simplexml_load_file('../../cat/txt.xml');
  $id_prs = $data['id_prs'];
  $id_jrn = $data['id_jrn'];
  $rq_jrn = sel_quo("id","cat_jrn_prs","id_jrn=".$id_jrn." AND id_prs",$id_prs);
  if(num_rows($rq_jrn) > 0)
  {
    echo json_encode($txt->err_ajt_prs->$id_lng);
  }else{
    $max = ftc_num(select("MAX(ord)","cat_jrn_prs","id_jrn",$id_jrn));
    $ord_prs = $max[0] + 1;
    insert('cat_jrn_prs',array("id_jrn","id_prs","ord","opt"),array($id_jrn,$id_prs,$ord_prs,1));
    echo 1;
  }
}
?>
