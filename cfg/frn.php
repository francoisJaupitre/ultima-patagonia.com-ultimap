<?php
$frn = array();
$rq_frn = sel_quo("id,nom","cat_frn","","","nom");
while($dt_frn = ftc_ass($rq_frn)){
	$frn[$dt_frn['id']] = $dt_frn['nom'];
}
?>