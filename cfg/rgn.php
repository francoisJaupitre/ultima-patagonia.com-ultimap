<?php
$rgn = array();
$rq_rgn = sel_quo("*","cat_rgn","","","nom");
while($dt_rgn = ftc_ass($rq_rgn)){$rgn[$dt_rgn['id']] = $dt_rgn['nom'];}
?>