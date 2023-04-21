<?php
unset($err,$cst,$trf);
if($net>0 and ($ty_mrq==1 or ($rck>=0 and $ty_mrq==2)) and $cur>0 and $taux>0){
	$cst = $net*(1+$frs);
	if($ty_mrq==2 and $rck>0){
		if($trf = $net+($rck-$net)*(1-$com) > $cst){$trf = $net+($rck-$net)*(1-$com);} // si prix rack - commission c�d�e superieur au co�t du service
		else{$trf = $cst;}													//sinon prix coutant
	}
	else{$trf = $cst /(1-$tx_mrq);}
	if(!$sup){
		$cst *= $taux;
		$trf *= $taux;
	}
	else{
		$cst /= $taux;
		$trf /= $taux;
	}
	$err = false;
}
else{$err = true;}
?>
