<?php
include("../prm/fct.php");
include("../prm/aut.php");
insert("grp_tsk",array("respon","usr","dt_grp"),array($id_usr,$id_usr,date("Y-m-d")));
?>
