<?php
$col = array();
$rq_col = sel_prm("*","prm_col");
while($dt_col = ftc_ass($rq_col)){$col[$dt_col['id']] = $dt_col['code'];}
?>