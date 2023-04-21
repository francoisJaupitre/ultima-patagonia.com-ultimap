<?php
if(isset($_POST['cbl']) and isset($_POST['src']) and isset($_POST['obj']) and isset($_POST['id'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$cbl = $_POST['cbl'];
	$src = upnoac(rawurldecode($_POST['src']));
	$obj = $_POST['obj'];
	$id = $_POST['id'];
	if($obj=='grp'){
		$id_grp = $id;
		include("vue_lst_grp.php");
	}
	elseif($obj=='clt'){
		$id_clt = $id;
		include("../cfg/clt.php");
		include("vue_lst_clt.php");
	}
	elseif($obj=='rgn'){
		$id_rgn = $id;
		include("../cfg/rgn.php");
		include("vue_lst_rgn.php");
	}
	elseif($obj=='vll'){
		$id_vll = $id;
		include("../cfg/vll.php");
		include("vue_lst_vll.php");
			}
	elseif($obj=='ctg_prs'){
		$id_ctg = $id;
		include("../prm/lgg.php");
		include("../prm/ctg_prs.php");
		include("vue_lst_ctg_prs.php");
	}
	elseif($obj=='ctg_srv'){
		$id_ctg = $id;
		include("../prm/lgg.php");
		include("../prm/ctg_srv.php");
		include("vue_lst_ctg_srv.php");
	}
	elseif($obj=='ctg_hbr'){
		$id_ctg = $id;
		include("../prm/lgg.php");
		include("../cfg/ctg_hbr.php");
		include("vue_lst_ctg_hbr.php");
	}
	elseif($obj=='ctg_clt'){
		$id_ctg = $id;
		include("../cfg/ctg_clt.php");
		include("vue_lst_ctg_clt.php");
	}
	elseif($obj=='crr'){
		include("../prm/lgg.php");
		include("../prm/crr.php");
		include("../cfg/crr.php");
		include("vue_lst_crr.php");
	}
	elseif($obj=='lng'){
		$id_lng = $id;
		include("../prm/lgg.php");
		include("vue_lst_lng.php");
	}
	elseif($obj=='lgg'){
		$id_lgg = $id;
		include("../prm/lgg.php");
		include("vue_lst_lgg.php");
	}
	elseif(substr($obj,0,7)=='css_crr'){
		include("../cfg/crr.php");
		$css_id = $id;
		include("vue_lst_css_crr.php");
	}
	elseif(substr($obj,0,7)=='crr_cmp'){
		include("../cfg/crr.php");
		$id_crr_cmp = $id;
		include("vue_lst_crr_cmp.php");
	}
}
?>
