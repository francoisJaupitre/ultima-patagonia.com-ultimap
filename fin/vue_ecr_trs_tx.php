<?php
if($dt_trs['dvs']==0 or $dt_trs['sld']==0 or $dt_trs['id_css']==0) {echo '-';}
elseif($cfg_crr_sp[$cfg_crr_css[$dt_trs['id_css']]]==1) {echo number_format($dt_trs['sld']/$dt_trs['dvs'],$cfg_crr_dcm[$cfg_crr_css[$dt_trs['id_css']]],',','');}
else{echo number_format($dt_trs['dvs']/$dt_trs['sld'],$cfg_crr_dcm[$cfg_crr_css[$dt_trs['id_css']]],',','');}
?>
