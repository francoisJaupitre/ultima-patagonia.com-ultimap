<?php
if(is_numeric($_POST["id_ctc"])){
  include("../prm/fct.php");
  include("../prm/aut.php");
  insert("crm_ech",array("id_ctc","respon","dt_ech","dt_stat"),array($_POST["id_ctc"],$id_usr,date("Y-m-d"),date("Y-m-d")));
}
?>
