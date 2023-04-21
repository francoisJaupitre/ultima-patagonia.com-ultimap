<?php
if($dt_sel_hbr['id_vll']>0){$dt_sel_vll = ftc_ass(select("lat,lon","cat_vll","id",$dt_sel_hbr['id_vll']));}
$id_cat_hbr = insert("cat_hbr",array("id_vll","nom","ctg_res","lat","lon",'dt_cat','usr'),array($dt_sel_hbr['id_vll'],$nom_hbr,1,$dt_sel_vll['lat'],$dt_sel_vll['lon'],date("Y-m-d"),$id_usr));
upd_quo("dev_hbr",array("id_cat","nom"),array($id_cat_hbr,$nom_hbr),$id_dev_hbr);
include("grd_chm.php");
?>
