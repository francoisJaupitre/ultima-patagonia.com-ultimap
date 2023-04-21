<?php
include("../prm/fct.php");
if($_POST['obj']=='crr') {echo insert("cfg_crr","id_crr",$_POST['id']);}
else if($_POST['obj']=='tsk') {
  $max = ftc_ass(sel_quo("MAX(ord) AS ord","cfg_tsk"));
  if(!empty($max['ord'])) {
    insert("cfg_tsk",array("nom","ord"),array("_new action",$max['ord']+1));
  }
  else{insert("cfg_tsk",array("nom"),array("_new action"));}
}
else if($_POST['obj']=='css') {insert("fin_css",array("crr","css"),array("1","_new account"));}
else if($_POST['obj']=='pst') {insert("fin_pst",array("pst"),array("_new post"));}
else if($_POST['obj']=='ctg_clt') {
  $id_ctg_clt = insert("cfg_ctg_clt",array("nom","ty_mrq"),array("_new client type","1"));
	insert("cfg_mrq",array("id_ctg_clt","bs_min","bs_max"),array($id_ctg_clt,"1","1"));
}
else if($_POST['obj']=='inv') {
  insert("cfg_fin","date",date("Y-m-d"));
}
?>
