<?php 
include("prm/fct.php");
include("prm/lgg.php");
$id_lng = $lgg[$_POST['id_lng']];
$dt_usr = ftc_ass(sel_prm("id","prm_usr","log",$_SERVER['REMOTE_USER']));
insert("cfg_usr",array("id_usr","lng","lgg"),array($dt_usr['id'],$id_lng,$_POST['id_lng']));
?>