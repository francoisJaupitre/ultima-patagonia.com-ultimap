<?php
if(isset($_POST['id_dev_crc'])){
	$id_dev_crc = $_POST['id_dev_crc'];
	$mdl_vue = explode('|',$_POST['mdl_vue']);
	$jrn_vue = explode('|',$_POST['jrn_vue']);
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/col.php");
	include("../prm/ctg_prs.php");
	include("../prm/ctg_srv.php");
	include("../prm/res_srv.php");
	include("../prm/rgm.php");
	include("../cfg/crr.php");
	include("../cfg/rgn.php");
	include("../cfg/vll.php");
	$dt_crc = ftc_ass(sel_quo("id_grp,id_cat,com,mrq_hbr,frs,ty_mrq,crr,vue_sgl,vue_tpl,vue_qdp","dev_crc","id",$id_dev_crc));
	$grp_crc = $dt_crc['id_grp'];
	$num_grp_pax = num_rows(sel_quo("id","grp_pax",array("id_grp","prt"),array($grp_crc,1)));
	$id_cat_crc = $dt_crc['id_cat'];
	$com_crc = $dt_crc['com'];
	$mrq_hbr_crc = $dt_crc['mrq_hbr'];
	$frs_crc = $dt_crc['frs'];
	$ty_mrq = $dt_crc['ty_mrq'];
	$id_crr_crc = $dt_crc['crr'];
	$vue_sgl_crc= $dt_crc['vue_sgl'];
	$vue_tpl_crc= $dt_crc['vue_tpl'];
	$vue_qdp_crc= $dt_crc['vue_qdp'];
	$rq_bss_crc = sel_quo("*","dev_crc_bss","id_crc",$id_dev_crc,"base");
	if(num_rows($rq_bss_crc)>0){
		while($dt_bss_crc = ftc_ass($rq_bss_crc)){
			$bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['base'];
			$vue_bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
			$mrq_crc[$dt_bss_crc['id']] = $dt_bss_crc['mrq'];
		}
	}
}
$nb_mdl = ftc_ass(sel_quo("COUNT(*) as total","dev_mdl","id_crc",$id_dev_crc));
$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id_dev_crc,"ord");
while($dt_mdl = ftc_ass($rq_mdl)){
	$id_dev_mdl = $dt_mdl['id'];
	$id_cat_mdl = $dt_mdl['id_cat'];
	$id_col_mdl = $dt_mdl['col'];
	$ord_mdl = $dt_mdl['ord'];
	$nom_mdl = $dt_mdl['nom'];
	$ttr_mdl = $dt_mdl['titre'];
	$dsc_mdl = $dt_mdl['dsc'];
	$fus_mdl = $dt_mdl['fus'];
	$trf_mdl = $dt_mdl['trf'];
	if($trf_mdl){
		$vue_sgl_mdl = $dt_mdl['vue_sgl'];
		$vue_dbl_mdl = $dt_mdl['vue_dbl'];
		$vue_tpl_mdl = $dt_mdl['vue_tpl'];
		$vue_qdp_mdl = $dt_mdl['vue_qdp'];
		$com_mdl = $dt_mdl['com'];
		$mrq_hbr_mdl = $dt_mdl['mrq_hbr'];
		$ptl = $dt_mdl['ptl'];
		$psg = $dt_mdl['psg'];
		$sgl_mdl = $dt_mdl['sgl'];
		$dbl_mat_mdl = $dt_mdl['dbl_mat'];
		$dbl_twn_mdl = $dt_mdl['dbl_twn'];
		$tpl_mat_mdl = $dt_mdl['tpl_mat'];
		$tpl_twn_mdl = $dt_mdl['tpl_twn'];
		$qdp_mdl = $dt_mdl['qdp'];
		$bss_mdl = $vue_bss_mdl = $mrq_mdl = array();
		$rq_bss_mdl = sel_quo("*","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
		if(num_rows($rq_bss_mdl)>0){
			while($dt_bss_mdl = ftc_ass($rq_bss_mdl)){
				$bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['base'];
				$vue_bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['vue'];
				$mrq_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['mrq'];
			}
			$bss = $bss_mdl;
			$vue_bss = $vue_bss_mdl;
			$mrq_bss = $mrq_mdl;
		}
		$vue_sgl = $vue_sgl_mdl;
		$vue_tpl = $vue_tpl_mdl;
		$vue_qdp = $vue_qdp_mdl;
		$com = $com_mdl;
		$mrq_hbr = $mrq_hbr_mdl;
		$nb_rmn_mdl = ftc_ass(sel_quo("COUNT(*) as total","dev_mdl_rmn","id_mdl",$id_dev_mdl));
	}
	else{
		$vue_sgl = $vue_sgl_crc;
		$vue_tpl = $vue_tpl_crc;
		$vue_qdp = $vue_qdp_crc;
		$com = $com_crc;
		$mrq_hbr = $mrq_hbr_crc;
		if(num_rows($rq_bss_crc)>0){
			$bss = $bss_crc;
			$vue_bss = $vue_bss_crc;
		}
	}
	$vue_mdl = 0;
	if(isset($mdl_vue)){
		foreach($mdl_vue as $id){
			if($id=="vue_mdl".$id_dev_mdl){$vue_mdl=1;}
		}
	}
?>
<div id="div_mdl<?php echo $id_dev_mdl ?>">
	<div class="tbl_crc">
		<table class="w-100">
			<tr id="vue_ttr_mdl_<?php echo $id_dev_mdl ?>"<?php if($id_cat_mdl>0){echo 'class="up_mdl'.$id_cat_mdl.'"';} ?>><?php include("vue_ttr_mdl.php") ?></tr>
			<tr id="vue_trf_mdl_<?php echo $id_dev_mdl ?>"><?php include("vue_trf_mdl.php") ?></tr>
		</table>
		<div id="vue_dsc_rmn_dt_end_mdl_<?php echo $id_dev_mdl ?>">
			<span id="vue_dsc_mdl_<?php echo $id_dev_mdl ?>"><?php if($vue_mdl){include("vue_dsc_mdl.php");} ?></span>
<?php
	if($trf_mdl){
?>
			<span id="vue_rmn_mdl_<?php echo $id_dev_mdl ?>"><?php include("vue_rmn_mdl.php"); ?></span>
			<br />
<?php
	}
?>
			<span id="vue_dt_mdl_<?php echo $id_dev_mdl ?>" <?php if(!$vue_mdl){echo 'class="up_jrn"';} ?>><?php include("vue_dt_mdl.php"); ?></span>
			<div id="vue_end_mdl_<?php echo $id_dev_mdl ?>" class="text-center"><?php include("vue_end_mdl.php"); ?></div>
		</div>
	</div>
	<br />
</div>
<?php
	unset($bss_mdl);
}
?>
