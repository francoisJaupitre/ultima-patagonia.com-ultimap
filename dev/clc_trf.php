<?php
$err=0;
$cst=0;
$trf=0;
if($net<=0 and ($ty_mrq==1 or ($rck<=0 and $ty_mrq==2))){$err = 1;}
if($cur>0){
	$cst = $net*$frs;
	if($ty_mrq==2 and $rck>0){
		if($trf = $net+($rck-$net)*(1-$com) > $cst){$trf = $net+($rck-$net)*(1-$com);} // si prix rack - commission c�d�e superieur au co�t du service
		else{$trf = $cst;}	//sinon prix coutant
	}
	else{
		//$trf = $cst /(1-$tx_mrq);  BESOIN DE TRF PAR BASE (MULTIPLES MARQUES)
	}
	if($cfg_crr_sp[$cur]==1){
		$cst *= $cfg_crr_tx[$cur];
		$trf *= $cfg_crr_tx[$cur];
	}
	elseif($cfg_crr_tx[$cur]!=0){
		$cst /= $cfg_crr_tx[$cur];
		$trf /= $cfg_crr_tx[$cur];
	}
}
else{$err=1;}
?>
