<?php
include("../prm/fct.php");
include("../prm/aut.php");
insert("grp_tsk",array("id_grp","respon","usr","dt_grp"),array($_POST['id_grp'],$id_usr,$id_usr,date("Y-m-d")));
?>
