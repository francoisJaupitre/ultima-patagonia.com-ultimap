<?php
$pays = array();
foreach($lgg as $i => $nom){
	if($lngg[$i]){
		$rq_pays = sel_prm("*","prm_pays");
		while($dt_pays = ftc_ass($rq_pays)){$pays[$nom][$dt_pays['id']] = $dt_pays['nom_'.$nom];}
		asort($pays[$nom]);
	}
}
?>