<?php
$vll = array();
if(isset($id_rgn) and $id_rgn > 0){$rq_vll = sel_quo("*","cat_vll","id_rgn",$id_rgn,"nom");}
elseif(isset($ids_rgn)){
  $whe = '';
  foreach ($ids_rgn as $id_rgn) {$whe .= 'id_rgn = '.$id_rgn.' OR ';}
  $whe .= '1 = 0';
  $rq_vll = sel_whe("*","cat_vll",$whe,"nom");
}
else{$rq_vll = sel_quo("*","cat_vll","","","nom");}
while($dt_vll = ftc_ass($rq_vll)){
  $vll[$dt_vll['id']] = $dt_vll['nom'];
	$vll_pays[$dt_vll['id']] = $dt_vll['id_pays'];
}
?>
