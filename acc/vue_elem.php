<?php
if(isset($_POST['id']) and isset($_POST['obj'])){
	$id = $_POST['id'];
	$obj = $_POST['obj'];
	$col = $_POST['col'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	if($obj=='vue_acc'){
		include("../prm/pays.php");
		include("../cfg/frn.php");
		include("../cfg/crr.php");
		include("vue_acc.php");
	}
	elseif($obj=='vue_hom'){
		include("../prm/pays.php");
		include("../cfg/frn.php");
		include("../cfg/crr.php");
		include("vue_hom.php");
	}
	elseif($obj=='vue_tsk'){
		$cbl = 'tsk';
		include("vue_tsk.php");
	}
	elseif($obj=='vue_grp'){
		include("../cfg/clt.php");
		include("vue_grp.php");
	}
	elseif($obj=='vue_pay'){
		include("../cfg/frn.php");
		include("../cfg/crr.php");
		include("vue_pay.php");
	}
	elseif($obj=='cfg_lgg'){
		include("../prm/lgg.php");
		include("vue_cfg_lgg.php");
	}
	elseif(substr($obj,0,10)=='cfg_ty_mrq'){
		include("../cfg/ctg_clt.php");
		$tymrq = $ty_mrq_ctg_clt[$id];
		include("../prm/ty_mrq.php");
		include("vue_cfg_ty_mrq.php");
	}
	/*elseif(substr($obj,0,11)=='ctg_clt_com'){
		include("../cfg/ctg_clt.php");
		if($ty_mrq_ctg_clt[$id]>1){
			$com = $com_ctg_clt[$id];
			include("vue_ctg_clt_com.php");
		}
	}*/
	elseif(substr($obj,0,11)=='fin_crr_css'){
		$css_id = $id;
		include("../cfg/crr.php");
		include("../cfg/css.php");
		include("vue_fin_crr.php");
	}
	elseif(substr($obj,0,11)=='fin_crr_cmp'){
		include("../cfg/crr.php");
		include("../cfg/fin.php");
		include("vue_crr_cmp.php");
	}
	else{
		$dt = ftc_ass(sel_quo($col,'cfg_'.$obj,'id',$id));
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dt[$col])){echo date("d/m/Y", strtotime($dt[$col]));}
		elseif($col=='duree'){echo date("H:i",strtotime($dt[$col]));}
		elseif($col=='mrq' or $col=='com' or $col=='mrq_hbr' or $col=='frs'){echo number_format($dt[$col]*100,2,'.','');}
		elseif($col=='taux' or $col=='tauxf'){
			include("../cfg/crr.php");
			echo number_format($dt[$col],$cfg_crr_dcm[$cfg_crr_id[$id]],'.','');
		}
		elseif($col=='dvs'){
			include("../cfg/crr.php");
			include("../cfg/fin.php");
			echo number_format($dt[$col],$prm_crr_dcm[$id_crr_cmp],'.','');
		}
		elseif($col=='inv'){
			include("../cfg/crr.php");
			echo number_format($dt[$col],$prm_crr_dcm[1],'.','');
		}
		elseif($dt[$col]!='0000-00-00'){echo stripslashes($dt[$col]);}
	}
}
?>
