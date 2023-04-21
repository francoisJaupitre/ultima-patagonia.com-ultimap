<?php
if($dvs==0 or $sld==0 or !$id_crr>0){echo '-';}
elseif($cfg_crr_sp[$id_crr]==$cfg_crr_sp[$id_crr_cmp]){
	if($sld/$dvs>1){echo number_format($sld/$dvs,$cfg_crr_dcm[$id_crr_cmp],',','');}
	else{echo number_format($dvs/$sld,$cfg_crr_dcm[$id_crr_cmp],',','');}
}
elseif($cfg_crr_sp[$id_crr]){echo number_format($sld/$dvs,$cfg_crr_dcm[$id_crr],',','');}
else{echo number_format($dvs/$sld,$cfg_crr_dcm[$id_crr],',','');}
?>
