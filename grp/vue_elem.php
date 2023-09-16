<?php
if(isset($_POST['id']) and isset($_POST['obj']) and isset($_POST['col'])){
	$id = $_POST['id'];
	$obj = $_POST['obj'];
	$col = $_POST['col'];
	$txt = simplexml_load_file('txt.xml');
	$id_grp = $id;
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	if($obj=='clt'){
		$dt_grp = ftc_ass(sel_quo("id_clt","grp_dev","id",$id_grp));
		$clt_grp = $dt_grp['id_clt'];
		include("../cfg/clt.php");
		include("vue_clt.php");
	}
	elseif($obj=='crc'){include("vue_crc.php");}
/*	elseif($obj=='pax_grp'){ calling destination file directly
		include("../prm/ncn.php");
		include("vue_pax.php");
	}*/
	elseif(substr($obj,0,7)=='pax_ncn'){
		$id = substr($obj,7);
		$dt_pax = ftc_ass(sel_quo("id,ncn,prt","grp_pax","id",$id));
		include("../prm/ncn.php");
		include("vue_ncn.php");
	}
	elseif($obj=='res_hbr'){
		include("../prm/res_srv.php");
		include("vue_res_hbr.php");
	}
	elseif($obj=='res_frn'){
		include("../prm/res_srv.php");
		include("../cfg/frn.php");
		include("vue_res_frn.php");
	}
	elseif($obj=='tsk_grp'){
		include("../prm/stat_tsk.php");
		include("vue_tsk.php");
	}
	elseif($obj=='fac_grp'){include("vue_fac.php");}
	else{
		$dt = ftc_ass(sel_quo($col,'grp_'.$obj,'id',$id));
		if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dt[$col])){echo date("d/m/Y", strtotime($dt[$col]));}
		elseif($dt[$col]!='0000-00-00'){echo stripslashes($dt[$col]);}
	}
}
?>
