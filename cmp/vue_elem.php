<?php
if(isset($_POST['id']) and isset($_POST['obj']) and isset($_POST['col'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/fin.php");
	$id = $_POST['id'];
	$obj = $_POST['obj'];
	$col = $_POST['col'];
	if($obj=="clc"){
		$ids = explode('_',$id);
		$dt_cmp_clc = ftc_ass(sel_quo("id","cmp_clc",array("id_itm","id_grp"),array($ids[0],$ids[1])));
		$id = $dt_cmp_clc['id'];
	}
	if(substr($obj,0,7)=='fac_itm'){
		include("../cfg/crr.php");
		include("../cfg/itm.php");
		$id_fac = substr($obj,7);
		$dt_fac = ftc_ass(sel_quo("*","cmp_fac","id",$id_fac));
		include("vue_fac_itm.php");
	}
	elseif(substr($obj,0,7)=='fac_vnt'){
		$dt_fac = ftc_ass(sel_quo("id,vnt","cmp_fac","id",$id));
		include("vue_fac_vnt.php");
	}
	elseif(substr($obj,0,6)=='itm_tx'){
		include("../cfg/crr.php");
		$dt_itm = ftc_ass(sel_quo("*","cmp_itm","id",$id));
		$dvs = $dt_itm['dvs'];
		$sld = $dt_itm['sld'];
		$id_crr = $dt_itm['id_crr'];
		include("vue_tx.php");
	}
	elseif(substr($obj,0,7)=='fac_sum'){
		include("../cfg/crr.php");
		$dt_itm = ftc_ass(sel_quo("sum(sld) AS sld","cmp_itm","id_fac",$id));
		$sum_sld = $dt_itm['sld'];
		include("vue_fac_sum.php");
	}
	elseif(substr($obj,0,7)=='fac_err'){
		$rq_itm = sel_quo("*","cmp_itm","id_fac",$id);
		while($dt_itm = ftc_ass($rq_itm)){
			if((($dvs!=0 or $sld!=0) and $dt_itm['id_itm']==0) or ($dt_itm['id_crr']==0 and $dvs!=0) or ($dvs!=0 and $sld==0) or $dt_itm['id_grp']==0){$flg_err = true;}
		}
		include("vue_fac_err.php");
	}
	elseif(substr($obj,0,6)=='clc_tx'){
		include("../cfg/crr.php");
		$ids = explode('_',$id);
		$dt_clc = ftc_ass(sel_quo("dvs,sld,id_crr","cmp_clc",array("id_itm","id_grp"),array(0,$ids[1])));
		$dvs = $dt_clc['dvs'];
		$sld = $dt_clc['sld'];
		$id_crr = $dt_clc['id_crr'];
		include("vue_tx.php");
	}
	else{
		$dt = ftc_ass(sel_quo($col,'cmp_'.$obj,'id',$id));
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dt[$col])){echo date("d/m/Y", strtotime($dt[$col]));}
		elseif($col == 'dvs'){
			include("../cfg/crr.php");
			if($obj == 'clc'){
				$ids = explode('_',$id);
				$dt_crr = ftc_ass(sel_quo("id_crr","cmp_clc",array("id_itm","id_grp"),array(0,$ids[1])));
			}
			else{$dt_crr = ftc_ass(sel_quo("id_crr","cmp_itm","id",$id));}
			if($dt_crr['id_crr']>0){$id_crr = $dt_crr['id_crr'];}
			else{$id_crr = $id_crr_cmp;}
			echo number_format($dt[$col],$prm_crr_dcm[$id_crr],'.','');
		}
		elseif($col=='sld' or $col=='cpt'){
			include("../cfg/crr.php");
			echo number_format($dt[$col],$prm_crr_dcm[$id_crr_cmp],'.','');
		}
		elseif($dt[$col]!='0000-00-00'){echo stripslashes($dt[$col]);}
	}
}
?>
