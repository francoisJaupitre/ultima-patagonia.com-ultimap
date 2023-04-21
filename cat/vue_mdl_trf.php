<?php
//  include("trf_mdl.php"); 'sel_mdl_jrn' n'est pas pris en compte dans fct/trf.php
$txt_fct = simplexml_load_file('../fct/txt.xml');
$flg_err_trf = false;
if(isset($err_hbr_jrn[$id_trf])) {
  foreach(array_unique($err_hbr_jrn[$id_trf]) as $jrn) {
    if($err_hbr_def[$id_trf][$jrn]) {
      echo '<span style="color:red;">'.$txt_fct->err->hbr_def->$id_lng.$jrn.'</span><br/>';
      $flg_err_trf = true;
    }
    if($err_hbr_db[$id_trf][$jrn]) {
      echo '<span style="color:red;">'.$txt_fct->err->hbr_db->$id_lng.$jrn.'</span><br/>';
      $flg_err_trf = true;
    }
    if($err_hbr_sel[$id_trf][$jrn]) {
      echo '<span style="color:red;">'.$txt_fct->err->hbr_sel->$id_lng.$jrn.'</span><br/>';
      $flg_err_trf = true;
    }
    if($err_hbr_dup[$id_trf][$jrn]) {
      echo '<span style="color:red;">'.$txt_fct->err->hbr_dup->$id_lng.$jrn.'</span><br/>';
      $flg_err_trf = true;
    }
  }
}
if(isset($err_trf_srv[$id_trf][0]) and $err_trf_srv[$id_trf][0]) {
  echo '<span style="color:red;">'.$txt_fct->err->srv_jrn->$id_lng.' '.$txt_fct->jours->$id_lng.' : '.$err_srv_jrn[$id_trf][0].'</span><br/>';
  $flg_err_trf = true;
}
if(!$flg_err_trf) {echo $txt_fct->base->$id_lng.' '.$base." : ".number_format($prx,0,',',' ').' '.$prm_crr_nom[$id_crr_clt].$txt_fct->trf->parpers->$id_lng;}
?>
