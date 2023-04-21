<?php
if(isset($_POST['id']) and $_POST['id']>0 and isset($_POST['cbl']) and !empty($_POST['cbl']) and isset($_POST['id_lgg']) and $_POST['id_lgg']>0){
	$cbl = $_POST['cbl'];
	$id = $_POST['id'];
	$lgg_id = $_POST['id_lgg'];
  include("../prm/fct.php");
  include("../prm/aut.php");
  include("../cfg/clt.php");
  if($cbl=='dev'){
  	$dt_ttr = ftc_ass(sel_quo("*","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id));
  	$vrs = $dt_ttr['version'];
    $groupe = $dt_ttr['groupe'];
    $id_clt = $dt_ttr['id_clt'];
    $nomgrp = $dt_ttr['nomgrp'];
  }
  elseif($cbl=='crc'){
    $dt_ttr = ftc_ass(sel_quo("titre,nom","cat_crc LEFT JOIN cat_crc_txt on cat_crc.id = cat_crc_txt.id_crc AND lgg=".$lgg_id,"cat_crc.id",$id));
    $nom = $dt_ttr['nom'];
    $dt_mdl = ftc_ass(sel_quo("MAX(ord) AS max","cat_crc_mdl","id_crc",$id));
  	$dt_fus = ftc_ass(sel_whe("COUNT(id) AS total","cat_crc_mdl","fus=1 AND ord<".$dt_mdl['max']." AND id_crc=".$id));
  	$dt_jrn = ftc_ass(sel_quo("COUNT(cat_mdl_jrn.id) AS total","cat_mdl_jrn INNER JOIN cat_crc_mdl ON cat_mdl_jrn.id_mdl = cat_crc_mdl.id_mdl","id_crc",$id));
  	$duree = $dt_jrn['total']-$dt_fus['total'];
  }
  elseif($cbl=='mdl'){
    $dt_ttr = ftc_ass(sel_quo("titre","cat_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl AND lgg=".$lgg_id,"cat_mdl.id",$id));
    $nom = $dt_ttr['nom'];
    $dt_jrn = ftc_ass(sel_quo("COUNT(cat_mdl_jrn.id) AS total","cat_mdl_jrn","id_mdl",$id));
  	$duree = $dt_jrn['total'];
  }
	$ttr = $dt_ttr['titre'];
  include("ttr.php");
  if($cbl=='dev' and $vrs>1){$ttr .= "_V".$vrs;}
	echo rawurlencode($ttr);
}
?>
