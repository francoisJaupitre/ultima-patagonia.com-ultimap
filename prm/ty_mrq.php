<?php
$ty_mrq_dev = array();
$rq_ty_mrq = sel_prm("*","prm_ty_mrq");
while($dt_ty_mrq = ftc_ass($rq_ty_mrq)){$ty_mrq_dev[$dt_ty_mrq['id']] = $dt_ty_mrq['nom_'.$id_lng];}
?>