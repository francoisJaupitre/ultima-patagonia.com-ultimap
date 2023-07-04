<?php
if(isset($_GET['id']) and $_GET['id']>0){
	$id_dev_crc = $_GET['id'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/col.php");
	include("../prm/ctg_prs.php");
	include("../prm/ctg_srv.php");
	include("../prm/ncn.php");
	include("../prm/res_srv.php");
	include("../prm/rgm.php");
	include("../prm/room.php");
	include("../prm/ty_mrq.php");
	include("../cfg/clt.php");
	include("../cfg/crr.php");
	include("../cfg/frn.php");
	include("../cfg/hbr_def.php");
	include("../cfg/rgn.php");
	include("../cfg/vll.php");
	include("../vendor/googleAPIKey/googleAPIKey.php");
	$rq_pic = sel_quo("pic","cat_pic");
	while($dt_pic = ftc_ass($rq_pic)){$bg[] = $dt_pic['pic'];}
	if(isset($bg)){
		$i = rand(0, count($bg)-1);
		$pic = "$bg[$i]";
	}
	$dt_crc = ftc_ass(sel_quo("*","dev_crc LEFT JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
	$cnf = $dt_crc['cnf'];
	include("../prm/aut.php");
	$grp_crc = $dt_crc['id_grp'];
	$rq_grp = sel_quo("id","dev_crc","id_grp",$grp_crc);
	if(num_rows($rq_grp)>1){$flg_clt=false;}
	else{$flg_clt=true;}
	$flg_grp=true;
	$rq_grp_crc = sel_quo("dev_crc_pax.id","dev_crc_pax","id_crc",$id_dev_crc);
	if(num_rows($rq_grp_crc)>0){$flg_grp=false;}
	elseif($flg_grp){
		$rq_grp_mdl = sel_quo("dev_mdl_pax.id","dev_mdl_pax INNER JOIN dev_mdl ON dev_mdl_pax.id_mdl=dev_mdl.id","id_crc",$id_dev_crc);
		if(num_rows($rq_grp_mdl)>0){$flg_grp=false;}
		elseif($flg_grp){
			$rq_grp_srv = sel_whe("dev_srv.id","dev_crc INNER JOIN (dev_mdl INNER JOIN (dev_jrn INNER JOIN (dev_prs INNER JOIN dev_srv ON dev_prs.id=dev_srv.id_prs) ON dev_jrn.id=dev_prs.id_jrn) ON dev_mdl.id=dev_jrn.id_mdl) ON dev_crc.id=dev_mdl.id_crc","dev_srv.res!=0 AND dev_srv.res!=5 AND dev_srv.res!=6 AND id_crc=".$id_dev_crc);
			if(num_rows($rq_grp_srv)>0){$flg_grp=false;}
			elseif($flg_grp){
				$rq_grp_hbr = sel_whe("dev_hbr.id","dev_crc INNER JOIN (dev_mdl INNER JOIN (dev_jrn INNER JOIN (dev_prs INNER JOIN dev_hbr ON dev_prs.id=dev_hbr.id_prs) ON dev_jrn.id=dev_prs.id_jrn) ON dev_mdl.id=dev_jrn.id_mdl) ON dev_crc.id=dev_mdl.id_crc","dev_hbr.res!=0 AND dev_hbr.res!=5 AND dev_hbr.res!=6 AND id_crc=".$id_dev_crc);
				if(num_rows($rq_grp_hbr)>0){$flg_grp=false;}
			}
		}
	}
	$num_grp_pax = num_rows(sel_quo("id","grp_pax",array("id_grp","prt"),array($grp_crc,1)));
	$id_cat_crc = $dt_crc['id_cat'];
	$vue_sgl_crc = $dt_crc['vue_sgl'];
	$vue_dbl_crc = $dt_crc['vue_dbl'];
	$vue_tpl_crc = $dt_crc['vue_tpl'];
	$vue_qdp_crc = $dt_crc['vue_qdp'];
	$sgl_crc = $dt_crc['sgl'];
	$dbl_mat_crc = $dt_crc['dbl_mat'];
	$dbl_twn_crc = $dt_crc['dbl_twn'];
	$tpl_mat_crc = $dt_crc['tpl_mat'];
	$tpl_twn_crc = $dt_crc['tpl_twn'];
	$qdp_crc = $dt_crc['qdp'];
	$ptl = $dt_crc['ptl'];
	$psg = $dt_crc['psg'];
	$grp = $dt_crc['groupe'];
	$vrs = $dt_crc['version'];
	$prd = $dt_crc['periode'];
	$nom_crc = $dt_crc['nom'];
	$duree = $dt_crc['duree'];
	$ttr_crc = $dt_crc['titre'];
	$clt_crc = $dt_crc['id_clt'];
	$com_crc = $dt_crc['com'];
	$mrq_hbr_crc = $dt_crc['mrq_hbr'];
	$frs_crc = $dt_crc['frs'];
	$ty_mrq = $dt_crc['ty_mrq'];
	$id_crr_crc = $dt_crc['crr'];
	$lgg_crc = $dt_crc['lgg'];
	$dsc_crc = $dt_crc['dsc'];
	$inf_crc = $dt_crc['info'];
	$rq_bss_crc = sel_quo("*","dev_crc_bss","id_crc",$id_dev_crc,"base");
	if(num_rows($rq_bss_crc)>0){
		while($dt_bss_crc = ftc_ass($rq_bss_crc)){
			$bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['base'];
			$vue_bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
			$mrq_crc[$dt_bss_crc['id']] = $dt_bss_crc['mrq'];
		}
	}
	if($cnf<1){$vue_res = 0;}
	else{$vue_res = 1;}
	$onload = "init('".$id_lng."',".$cnf.",".$id_dev_crc.",".$aut['dev'].");$('body').focus();";
	if(isset($_GET['scrl']) and $_GET['scrl']>0){
		$dt_prs = ftc_ass(sel_quo("id_mdl,id_jrn","dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id","dev_prs.id",$_GET['scrl']));
		$onload .= "scroll2(".$dt_prs['id_jrn'].",".$dt_prs['id_mdl'].");";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css'))  ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $googleAPIKey ?>"></script>
		<script><?php include("script_vue.js");?></script>
		<script><?php include("script_act.js");?></script>
		<script><?php include("script_ajt.js");?></script>
		<script><?php include("script_sup.js");?></script>
		<script><?php include("script_src.js");?></script>
		<script><?php include("../prm/script.js");?></script>
	</head>
	<body class="usn" onload="<?php echo $onload; ?>" onblur="fos = document.activeElement.id;this.onfocus='document.activeElement.id.focus();this.onfocus=null;'" >
		<div id="shadowing"></div>
		<div id="alert"></div>
		<div id="txtHint"><br/></div>
		<div id="bck" style="background-image: url('../pic/<?php echo $dir.'/'.$pic; ?>');"></div>
		<div id="div_crc">
			<table class="tbl_crc w-100">
				<tr id="vue_ttr_crc" <?php if($id_cat_crc>0){echo 'class="up_crc'.$id_cat_crc.'"';} ?>><?php include("vue_ttr_crc.php"); ?></tr>
				<tr id="vue_ttf_crc"><?php include("vue_ttf_crc.php"); ?></tr>
				<tr id="vue_trf_crc"><?php include("vue_trf_crc.php"); ?></tr>
				<tr id="vue_dsc_crc"><?php include("vue_dsc_crc.php"); ?></tr>
			</table>
			<br />
			<table class="tbl_crc w-100">
				<tr>
					<td class="lsb">
						<input id="chk_res" class="dev_img chk_img" type="checkbox" autocomplete="off" <?php if($vue_res==1){echo 'checked';} ?> onclick="chk_res();" />
						<label for="chk_res"><img src="../prm/img/maxi.png" /></label>
						<strong><?php echo $txt->ress->$id_lng; ?></strong>
					</td>
				</tr>
				<tr><td><div id="vue_res_crc" class="crc_dev_res crc_dev_hbr<?php echo $id_dev_crc ?> crc_dev_srv<?php echo $id_dev_crc ?>"><?php include("vue_res_crc.php"); ?></div></td></tr>
			</table>
			<span id="vue_rmn_crc"><?php include("vue_rmn_crc.php"); ?></span>
			<br />
			<span id="vue_dt_crc"><?php include("vue_dt_crc.php"); ?></span>
			<div id="vue_end_crc" class="text-center"><?php include("vue_end_crc.php"); ?></div>
		</div>
		<script src='../vendor/tinymce/tinymce.min.js'></script>
		<script src='../resources/js/script.js'></script>
		<script src='../resources/js/devMail.js'></script>
		<script src='../resources/js/richTxt.js'></script>
	</body>
</html>
<?php
}
?>
