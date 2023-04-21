<?php
include("../prm/fct.php");
if(isset($_POST['id_prs']) and $_POST['id_prs']>0){
  $id_prs = $_POST['id_prs'];
  $dt_new_cnf = ftc_ass(sel_quo("id_jrn,ord","dev_prs","id",$id_prs));
  $dt_old_cnf = ftc_ass(sel_whe("id","dev_prs","res = 1 AND id != ".$id_prs." AND ord=".$dt_new_cnf['ord']." AND id_jrn=".$dt_new_cnf['id_jrn']));
  if($dt_old_cnf['id']>0){
    upd_quo("dev_prs",'res',2,$dt_old_cnf['id']);
    echo $dt_old_cnf['id'];
  }
  else{echo 0;}
}
?>
