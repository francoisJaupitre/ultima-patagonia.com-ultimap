<?php
$flg_txt = true;
if(empty($dt_crc['titre'])) {$flg_txt = false;}
if(!$flg_txt) {$err_crc .= $dt_crc['nom'].",\n";}
if(!empty($dt_crc['alerte'])) {$alt .= $dt_crc['nom'].' : '.$dt_crc['alerte'].",\n";}
$max_mdl = ftc_num(sel_quo("MAX(ord)","cat_crc_mdl","id_crc",$id_cat_crc));
$ord_jrn_ant = 1;
$rq_crc_mdl = sel_quo("*","cat_crc_mdl","id_crc",$id_cat_crc,"ord");
while($dt_crc_mdl = ftc_ass($rq_crc_mdl)) {
  $id_cat_mdl = $dt_crc_mdl['id_mdl'];
  $ord_mdl = $dt_crc_mdl['ord'];
  if($ord_mdl != $max_mdl[0]) {$fus = $dt_crc_mdl['fus'];}
  else{$fus = 0;}
  $id_rmn = 0;
  /*if(!empty($dt_crc_mdl['sel_mdl_jrn'])) {*/$sel_crc_jrn = explode(",",$dt_crc_mdl['sel_mdl_jrn']);/*}
  else{unset($sel_crc_jrn);}*/
  include("../../dev/ins_mdl.php");
  if($fus) {
    $ord_jrn--;
    upd_noq('dev_crc','duree','duree-1',$id_dev_crc);
  }
}
if($err_crc != '') {$err .= $txt->err->crc->$id_lng.$err_crc."\n";}
if($err_mdl != '') {$err .= $txt->err->mdl->$id_lng.$err_mdl."\n";}
if($err_jrn != '') {$err .= $txt->err->jrn->$id_lng.$err_jrn."\n";}
if($err_prs != '') {$err .= $txt->err->prs->$id_lng.$err_prs."\n";}
if($err_hbr != '') {$err .= $txt->err->hbr->$id_lng.$err_hbr."\n";}
if($err_srv != '') {$err .= $txt->err->srv->$id_lng.$err_srv."\n";}
?>
