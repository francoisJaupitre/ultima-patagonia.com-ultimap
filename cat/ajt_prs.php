<?php
include("../prm/fct.php");
$id_prs = $_POST['id_prs'];
$id_jrn = $_POST['id_jrn'];
$rq_jrn = sel_quo("id","cat_jrn_prs","id_jrn=".$id_jrn." AND id_prs",$id_prs);
if(num_rows($rq_jrn)>0) {echo 0;}
else{
  $max = ftc_num(select("MAX(ord)","cat_jrn_prs","id_jrn",$id_jrn));
  $ord_prs = $max[0] + 1;
  insert('cat_jrn_prs',array("id_jrn","id_prs","ord","opt"),array($id_jrn,$id_prs,$ord_prs,1));
  echo 1;
}
?>
