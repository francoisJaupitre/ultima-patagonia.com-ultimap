<?php //DETERMINE RATE TO USE BETWEEN 2 CURRENCIES
if($id_crr > 0  and $cur > 0 and isset($cfg_crr_sp[$cur]) and isset($cfg_crr_tx[$cur]))
{
	if($cfg_crr_sp[$id_crr] xor $cfg_crr_sp[$cur])
	{
		$taux = $cfg_crr_tx[$cur] * $cfg_crr_tx[$id_crr];
		if($cfg_crr_sp[$cur])
		{
			$sup = 0;
		}else{
			$sup = 1;
		}
	}elseif($cfg_crr_tx[$cur] > $cfg_crr_tx[$id_crr])
	{
		$taux = $cfg_crr_tx[$cur] / $cfg_crr_tx[$id_crr];
		if($cfg_crr_sp[$cur])
		{
			$sup = 0;
		}else{
			$sup = 1;
		}
	}else{
		$taux = $cfg_crr_tx[$id_crr] / $cfg_crr_tx[$cur];
		if($cfg_crr_sp[$cur])
		{
			$sup = 1;
		}else{
			$sup = 0;
		}
	}
}else{
	$taux = 1;
	$sup = 0;
}
?>
