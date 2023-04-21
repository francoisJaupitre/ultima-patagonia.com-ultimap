<?php
$ttr_lieu = array();
foreach($lgg as $i => $uid_lgg){
	$rq_lieu = sel_quo("*","cat_lieu_txt","lgg",$i);
	while($dt_lieu = ftc_ass($rq_lieu)){$ttr_lieu[$i][$dt_lieu['id_lieu']] = $dt_lieu['titre'];}
}
?>