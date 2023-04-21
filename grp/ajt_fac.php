<?php
include("../prm/fct.php");
$dt_grp = ftc_ass(sel_quo("*","grp_dev","id",$_POST['id_grp']));
$dt_clt = ftc_ass(sel_quo("*","cat_clt","id",$dt_grp['id_clt']));
$max_fac = ftc_num(sel_quo("MAX(fac)","grp_fac"));
if($dt_clt['fac']){$nom = $dt_clt['nom'];}
else{$nom = $dt_grp['nomgrp'];}
$fac = ++$max_fac[0];
insert("grp_fac",array("id_grp","date","nom","fac"),array($_POST['id_grp'],date("Y-m-d"),$nom,$fac));
?>
