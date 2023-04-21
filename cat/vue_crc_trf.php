<?php
$id_crc = $id;
$tarif = 0;
$flg_err_trf = false;
$n_mdl = 1;
$txt_fct = simplexml_load_file('../fct/txt.xml');
$rq_crc_mdl = sel_quo("id_mdl,sel_mdl_jrn","cat_crc_mdl","id_crc",$id,"ord");
while($dt_crc_mdl = ftc_ass($rq_crc_mdl)) {
  $id = $dt_crc_mdl['id_mdl'];
  if(!empty($dt_crc_mdl['sel_mdl_jrn'])) {$sel_mdl_jrn = explode(",",$dt_crc_mdl['sel_mdl_jrn']);}
  else{unset($sel_mdl_jrn);}
  //  include("trf_mdl.php"); 'sel_mdl_jrn' n'est pas pris en compte dans fct/trf.php
  if(isset($err_hbr_def) and in_array(1,$err_hbr_def[$id_trf]) or isset($err_hbr_db) and in_array(true,$err_hbr_db[$id_trf]) or isset($err_hbr_sel) and in_array(1,$err_hbr_sel[$id_trf]) or isset($err_hbr_dup) and in_array(1,$err_hbr_dup[$id_trf]) or isset($err_trf_srv[$id_trf])) {
    echo $txt_fct->err->trf->$id_lng;
?>
<span class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $id; ?>');"><?php echo $txt_fct->mdl->$id_lng.' '.$n_mdl; ?></span><br/>
<?php
    $flg_err_trf = true;
  }
  $tarif += $prx;
  $n_mdl++;
  unset($err_hbr_def,$err_hbr_db,$err_hbr_sel,$err_hbr_dup,$err_trf_srv);
}
if(!$flg_err_trf) {echo $txt_fct->base->$id_lng.' '.$base." : ".number_format($tarif,0,',',' ').' '.$prm_crr_nom[$id_crr_clt].$txt_fct->trf->parpers->$id_lng;}
$id = $id_crc;
?>
