<?php
$id = $_POST['id'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../prm/aut.php");
include("../cfg/lng.php");
switch($_POST['obj']){
  case 'crr':
    delete("cfg_crr","id",$id);
    break;
  case 'tsk':
    delete("cfg_tsk","id",$id);
    break;
  case 'css':
    $rq_trs = sel_quo("id","fin_trs","id_css",$id);
    if(num_rows($rq_trs)>0){echo $txt->sup->css->$id_lng;}
    else{
      $rq_fin = sel_quo("id","cfg_fin","id_css",$id);
      if(num_rows($rq_fin)>0){echo $txt->sup->css->$id_lng;}
      else{delete("fin_css","id",$id);}
    }
    break;
  case 'pst':
    $rq_bdg = sel_quo("id","fin_bdg","id_pst",$id);
    if(num_rows($rq_bdg)>0){echo $txt->sup->pst->$id_lng;}
    else{delete("fin_pst","id",$id);}
    break;
  case 'ctg_clt':
    $rq_clt = sel_quo("id","cat_clt","id_ctg",$id);
    if(num_rows($rq_clt)>0){echo $txt->sup->ctg_clt1->$id_lng;}
    else{
      $rq_tsk1 = sel_quo("id","cfg_tsk","ctg_clt",$id);
      $rq_tsk2 = sel_quo("id","cfg_tsk","ctg_clt","-".$id);
      if(num_rows($rq_tsk1) or num_rows($rq_tsk2)>0){echo $txt->sup->ctg_clt2->$id_lng;}
      else{
        delete("cfg_ctg_clt","id",$id);
        delete("cfg_mrq","id_ctg_clt",$id);
      }
    }
    break;
}
?>
