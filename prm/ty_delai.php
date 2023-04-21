<?php
/*
$ty_delai = array();
$rq_ty_delai = sel_prm("*","prm_ty_delai");
while($dt_ty_delai = ftc_ass($rq_ty_delai)){$ty_delai[$dt_ty_delai['id']] = $dt_ty_delai['nom'];}
*/
$ty_delai = array();
$rq_ty_delai = sel_prm("*","prm_ty_delai");
while($dt_ty_delai = ftc_ass($rq_ty_delai)){
	foreach($lgg as $i => $uid_lgg){
		if($lngg[$i]){$ty_delai[$uid_lgg][$dt_ty_delai['id']] = $dt_ty_delai['nom_'.$uid_lgg];}
	}
}
foreach($lgg as $i => $uid_lgg){
	if($lngg[$i]){asort($ty_delai[$uid_lgg]);}
}
?>