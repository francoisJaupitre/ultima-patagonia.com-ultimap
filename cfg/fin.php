<?php
$sld_inv = $dvs_inv = $css_inv = array();
$rq_fin = sel_quo("*","cfg_fin","","","id");
while($dt_fin = ftc_ass($rq_fin)){
  if($dt_fin['id']==1){
    $dat_min = $dt_fin['date'];
    $inv_zero = $dt_fin['inv'];
    $nzero = $dt_fin['excfsc'];
    $id_crr_cmp = $dt_fin['crr_cmp'];
    $id_crr_fin = 1;
  }
  else{
    if(isset($sld_inv[$dt_fin['date']])) {$sld_inv[$dt_fin['date']] += $dt_fin['inv'];}
    else{$sld_inv[$dt_fin['date']] = $dt_fin['inv'];}
    if(isset($dvs_inv[$dt_fin['date']])) {$dvs_inv[$dt_fin['date']] += $dt_fin['dvs'];}
    else{$dvs_inv[$dt_fin['date']] = $dt_fin['dvs'];}
    if(isset($css_inv[$dt_fin['date']])) {$css_inv[$dt_fin['date']] += $dt_fin['id_css'];}
    else{$css_inv[$dt_fin['date']] = $dt_fin['id_css'];}
  }
}
?>
