<?php
if(isset($_POST['id_prs']) and $_POST['id_prs']>0){
  include("../prm/fct.php");
  $dt_prs = ftc_ass(select("id_mdl,id_jrn","dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id","dev_prs.id",$_POST['id_prs']));
  echo $dt_prs['id_jrn']."|".$dt_prs['id_mdl'];
}
?>
