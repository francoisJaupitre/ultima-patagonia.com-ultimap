<?php
include("../prm/fct.php");
$id = $_POST['id'];
$cbl = $_POST['cbl'];
$dt_pax = ftc_ass(sel_whe("id_pax,id_".$cbl,"dev_".$cbl."_pax","id=".$id));
$rq_rmn = sel_whe("id","dev_".$cbl."_rmn","id_".$cbl."=".$dt_pax["id_".$cbl]);
while($dt_rmn = ftc_ass($rq_rmn)){
  $dt = ftc_ass(sel_quo("id","dev_".$cbl."_rmn_pax","id_rmn=".$dt_rmn['id']." AND id_pax",$dt_pax['id_pax']));
  delete("dev_".$cbl."_rmn_pax","id",$dt['id']);
}
delete("dev_".$cbl."_pax","id",$id);

?>
