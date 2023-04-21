<?php
if(isset($_POST['id']) and isset($_POST['obj']) and isset($_POST['col'])) {
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$id = $_POST['id'];
	$obj = $_POST['obj'];
	$col = $_POST['col'];
	if(substr($obj,0,11)=='ecr_trs_bdg') {
		include("../cfg/crr.php");
		include("../cfg/css.php");
		include("../cfg/fin.php");
		include("../cfg/pst.php");
		$id_ecr = substr($obj,11);
		$dt_ecr = ftc_ass(sel_quo("*","fin_ecr","id",$id_ecr));
		include("vue_ecr_trs_bdg.php");
	}
	elseif(substr($obj,0,6)=='trs_tx') {
		include("../cfg/crr.php");
		include("../cfg/css.php");
		$dt_trs = ftc_ass(sel_quo("*","fin_trs","id",$id));
		include("vue_ecr_trs_tx.php");
	}
	elseif(substr($obj,0,7)=='ecr_err') {
		$dt_trs = ftc_ass(sel_quo("SUM(sld) AS sld_tot","fin_trs","id_ecr",$id));
		$flux_trs = $dt_trs['sld_tot'];
		$dt_bdg = ftc_ass(sel_quo("SUM(prd) AS prd_tot,SUM(chg) AS chg_tot,SUM(dtt) AS dtt_tot,SUM(crn) AS crn_tot","fin_bdg","id_ecr",$id));
		$som_bdg = $dt_bdg['prd_tot'] - $dt_bdg['chg_tot'] + $dt_bdg['dtt_tot'] - $dt_bdg['crn_tot'];
		$flg_err = false;
		$dt_err = ftc_ass(sel_whe("id","fin_trs","sld!=0 AND id_css=0 AND id_ecr=".$id));
		if(isset($dt_err['id'])) {$flg_err = true;}
		else{
			$dt_err = ftc_ass(sel_quo("id","fin_bdg","(prd!=0 OR chg!=0 OR dtt!=0 OR crn!=0) AND (id_pst=0 or mois='0000-00-00') AND id_ecr",$id));
			if(isset($dt_err['id'])) {$flg_err = true;}
		}
		include("vue_ecr_err.php");
	}
	else{
		$dt = ftc_ass(sel_quo($col,"fin_".$obj,"id",$id));
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dt[$col])) {echo date("d/m/Y", strtotime($dt[$col]));}
		elseif(is_numeric($dt[$col])) {
			if(($col=='dvs' or $col=='sld') and $dt[$col]>0) {echo '+';}
			include("../cfg/crr.php");
			$id_crr=1;
			if($col=='dvs') {
				include("../cfg/css.php");
				$dt_css = ftc_ass(sel_quo("id_css","fin_trs","id",$id));
				if($dt_css['id_css']>0) {$id_crr = $cfg_crr_css[$dt_css['id_css']];}
			}
			echo number_format($dt[$col],$prm_crr_dcm[$id_crr],',','');
		}
		elseif($dt[$col]!='0000-00-00') {echo stripslashes($dt[$col]);}
	}
}
?>
