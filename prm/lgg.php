<?php
$nom_lgg = array();
$lgg = array();
$lngg = array();
$lgg_nom = array();
$rq_lgg = sel_prm("*","prm_lgg","","","lgg");
while($dt_lgg = ftc_ass($rq_lgg)){
	$nom_lgg[$dt_lgg['id']] = $dt_lgg['nom'];
	$lgg[$dt_lgg['id']] = $dt_lgg['lgg'];
	$lngg[$dt_lgg['id']] = $dt_lgg['lng'];
	$lgg_nom[$dt_lgg['lgg']] = $dt_lgg['nom'];
}
$rq_lgg = sel_prm("*","prm_lgg","","","lgg");
while($dt_lgg = ftc_ass($rq_lgg)){
	foreach($lgg as $uid => $uid_lgg){
		if($lngg[$uid]){$nom_lgg_lgg[$uid_lgg][$dt_lgg['id']] = $dt_lgg['nom_'.$uid_lgg];}
	}
}
?>
