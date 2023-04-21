<?php
include("../prm/fct.php");
$id_dev_crc = $_POST['id'];
$rq_dev_mdl = sel_quo("id","dev_mdl",array("id_cat","id_crc"),array("0",$id_dev_crc));
while($dt_dev_mdl = ftc_ass($rq_dev_mdl)) {
  $id_dev_mdl = $dt_dev_mdl['id'];
/*
ci-dessus à supprimer quand ajt_cat_mdl déplacé depuis onload a fct supprimer/ajouter des journees : $id_dev_crc->$id_dev_mdl = $_POST['id'].
*/
  $rq_dev_jrn = sel_quo("id","dev_jrn",array("id_cat","id_mdl"),array("0",$id_dev_mdl));
  if(num_rows($rq_dev_jrn)==0) {
    $rq_dev_jrn = sel_quo("id_cat,ord","dev_jrn",array("opt","id_mdl"),array("1",$id_dev_mdl));
    while($dt_dev_jrn = ftc_ass($rq_dev_jrn)) {$ids_dev_cat_jrn[$dt_dev_jrn['ord']] = $dt_dev_jrn['id_cat'];}
    $n_dev_cat_jrn = count($ids_dev_cat_jrn);
    $rq_cat_mdl_jrn = sel_whe("id_jrn,id_mdl","cat_mdl_jrn","","ord");
    while($dt_cat_mdl_jrn = ftc_ass($rq_cat_mdl_jrn)) {$ids_cat_mdl_jrn[$dt_cat_mdl_jrn['id_mdl']][] = $dt_cat_mdl_jrn['id_jrn'];}
    foreach ($ids_cat_mdl_jrn as $id_cat_mdl => $ids_cat_jrn) {
      if(count(array_intersect($ids_dev_cat_jrn,$ids_cat_jrn)) != $n_dev_cat_jrn) {unset($ids_cat_mdl_jrn[$id_cat_mdl]);}
    }
    foreach (array_keys($ids_cat_mdl_jrn) as $id_cat_mdl) {
      $flg_jrn = false;
      $ord_ant = 0;
      $dt_cat_mdl = ftc_ass(sel_quo("sel_mdl_jrn","cat_mdl","id",$id_cat_mdl));
      if(!empty($dt_cat_mdl['sel_mdl_jrn'])) {$sel_mdl_jrn = explode(",",$dt_cat_mdl['sel_mdl_jrn']);}
      else{unset($dt_cat_mdl);}
      $rq_cat_mdl_jrn = sel_quo("id_jrn,opt,ord","cat_mdl_jrn","id_mdl",$id_cat_mdl,"ord, opt DESC");
      while($dt_cat_mdl_jrn = ftc_ass($rq_cat_mdl_jrn)) {
        $opt_jrn = $dt_cat_mdl_jrn['opt'];
        $ord_jrn = $dt_cat_mdl_jrn['ord'];
        $id_jrn = $dt_cat_mdl_jrn['id_jrn'];
        if($opt_jrn or isset($sel_mdl_jrn) and in_array($id_jrn,$sel_mdl_jrn)) {$flg_jrn = true;}
        elseif($ord_jrn != $ord_ant) {$flg_jrn = false;}
        if($flg_jrn) {
          if(in_array($id_jrn,$ids_dev_cat_jrn)) {$ords_dev_jrn[] = array_search($id_jrn,$ids_dev_cat_jrn);}
          else{
            $flg_opt = false;
            $rq_cat_mdl_jrn_opt = sel_quo("id_jrn","cat_mdl_jrn",array("opt","ord","id_mdl"),array("0",$ord_jrn,$id_cat_mdl));
            while($dt_cat_mdl_jrn_opt = ftc_ass($rq_cat_mdl_jrn_opt)) {
              if(in_array($dt_cat_mdl_jrn_opt['id_jrn'],$ids_dev_cat_jrn)) {
                $ords_dev_jrn[] = array_search($dt_cat_mdl_jrn_opt['id_jrn'],$ids_dev_cat_jrn);
                $flg_opt = true;
              }
            }
            if(!$flg_opt) {
              if(isset($ids_cat_mdl_jrn[$id_cat_mdl])) {unset($ids_cat_mdl_jrn[$id_cat_mdl]);}
              unset($ords_dev_jrn);
              $rq_cat_mdl_jrn = null;
            }
          }
        }
        $ord_ant = $ord_jrn;
      }
      if(isset($ords_dev_jrn)) {
        $sorted = array_values($ords_dev_jrn);
        sort($sorted);
        if($ords_dev_jrn === $sorted) {
          $dt_cat_mdl = ftc_ass(select("nom","cat_mdl","id",$id_cat_mdl));
          upd_quo('dev_mdl',array('id_cat','nom'),array($id_cat_mdl,$dt_cat_mdl['nom']),$id_dev_mdl);
          echo $id_cat_mdl;
          unset($ids_cat_mdl_jrn);
        }
      }
    }



  }
/*
ci-dessous à supprimer quand ajt_cat_mdl déplacé depuis onload a fct supprimer/ajouter des journees : $id_dev_crc->$id_dev_mdl = $_POST['id'].
*/
  unset($ids_dev_cat_jrn,$ids_cat_mdl_jrn,$ords_dev_jrn);
}
?>
