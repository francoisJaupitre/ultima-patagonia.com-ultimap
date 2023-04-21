<?php
$lieu = array();
$lieu_uid = array();
$lieu_nom = array();
$lieu_vll = array();
$rq_lieu = sel_quo("cat_lieu.id,cat_lieu.nom AS lieu,cat_vll.nom AS vll","cat_lieu INNER JOIN cat_vll ON cat_lieu.id_vll = cat_vll.id");
while($dt_lieu = ftc_ass($rq_lieu)){
	$lieu[$dt_lieu['id']] = $dt_lieu['lieu'];
	$lieu_uid[] = $dt_lieu['id'];
	$lieu_nom[] = $dt_lieu['lieu'];
	$lieu_vll[] = $dt_lieu['vll'];
}
array_multisort ($lieu_vll,$lieu_nom,$lieu_uid);
?>
