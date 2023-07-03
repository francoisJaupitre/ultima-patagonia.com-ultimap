<?php
if(isset($_POST['id_dev_jrn'])) {
  $id_dev_jrn = $_POST['id_dev_jrn'];
  $vue_jrn = $_POST['vue'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
  unset($_POST['id_dev_jrn']);
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/col.php");
  include("../prm/lgg.php");
	include("../prm/ctg_prs.php");
	include("../prm/ctg_srv.php");
	include("../prm/res_prs.php");
	include("../prm/res_srv.php");
	include("../prm/rgm.php");
	include("../cfg/vll.php");
	include("../cfg/crr.php");
  include("../cfg/rgn.php");
	$dt_jrn = ftc_ass(select("opt,dsc,id_mdl,id_pic,id_cat,date,ord","dev_jrn","id",$id_dev_jrn));
	$opt_jrn = $dt_jrn['opt'];
	$dsc_jrn = $dt_jrn['dsc'];
	$id_pic = $dt_jrn['id_pic'];
	$id_dev_mdl = $dt_jrn['id_mdl'];
  $id_cat_jrn = $dt_jrn['id_cat'];
  $date_jrn = $dt_jrn['date'];
  $ord_jrn = $dt_jrn['ord'];
	$dt_mdl = ftc_ass(select("col,vue_sgl,vue_tpl,vue_qdp,trf,ptl,psg,com,mrq_hbr","dev_mdl","id",$id_dev_mdl));
	$id_col_mdl = $dt_mdl['col'];
	$trf_mdl = $dt_mdl['trf'];
	$dt_crc = ftc_ass(select("com,mrq_hbr,frs,ty_mrq,crr,vue_sgl,vue_tpl,vue_qdp,ptl,psg","dev_crc","id",$id_dev_crc));
	$com_crc = $dt_crc['com'];
	$mrq_hbr_crc = $dt_crc['mrq_hbr'];
	$frs_crc = $dt_crc['frs'];
	$ty_mrq = $dt_crc['ty_mrq'];
	$id_crr_crc = $dt_crc['crr'];
	if($trf_mdl) {
		$vue_sgl_mdl = $dt_mdl['vue_sgl'];
		$vue_tpl_mdl = $dt_mdl['vue_tpl'];
		$vue_qdp_mdl = $dt_mdl['vue_qdp'];
		$com = $dt_mdl['com'];
		$mrq_hbr = $dt_mdl['mrq_hbr'];
		$ptl = $dt_mdl['ptl'];
		$psg = $dt_mdl['psg'];
		$bss_mdl = $vue_bss_mdl = $mrq_mdl = array();
		$rq_bss_mdl = select("*","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
		if(num_rows($rq_bss_mdl)>0) {
			while($dt_bss_mdl = ftc_ass($rq_bss_mdl)) {
				$bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['base'];
				$vue_bss_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['vue'];
				$mrq_mdl[$dt_bss_mdl['id']] = $dt_bss_mdl['mrq'];
			}
		}
		$nb_rmn_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl_rmn","id_mdl",$id_dev_mdl));
	}
	else{
		$vue_sgl_crc= $dt_crc['vue_sgl'];
		$vue_tpl_crc= $dt_crc['vue_tpl'];
		$vue_qdp_crc= $dt_crc['vue_qdp'];
		$com = $com_crc;
		$mrq_hbr = $mrq_hbr_crc;
		$ptl = $dt_crc['ptl'];
		$psg = $dt_crc['psg'];
		$bss_crc = $vue_bss_crc = array();
		$rq_bss_crc = select("*","dev_crc_bss","id_crc",$id_dev_crc,"base");
		if(num_rows($rq_bss_crc)>0) {
			while($dt_bss_crc = ftc_ass($rq_bss_crc)) {
				$bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['base'];
				$vue_bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
				$mrq_crc[$dt_bss_crc['id']] = $dt_bss_crc['mrq'];
			}
		}
		$nb_rmn_crc = ftc_ass(select("COUNT(*) as total","dev_crc_rmn","id_crc",$id_dev_crc));
	}
	$dt_jrn = ftc_ass(select("dev_jrn.id_cat","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id",$id_dev_jrn));
	$id_cat_jrn = $dt_jrn['id_cat'];
	if($id_cat_jrn > 0) {
		$ids_rgn = array();
		$rq_vll = sel_quo("id_rgn","cat_jrn_vll INNER JOIN cat_vll ON id_vll = cat_vll.id","id_jrn",$id_cat_jrn);
		while($dt_vll = ftc_ass($rq_vll)) {$ids_rgn[] = $dt_vll['id_rgn'];}
	}
	unset($ids_rgn,$prs_datas);
  $id_rgn = 0;
  $rq_prs = select("id,nom,opt,ord,id_cat","dev_prs","id_jrn",$id_dev_jrn,"ord,opt DESC,nom,id");
  while($dt_prs = ftc_ass($rq_prs)){
    $prs_datas[$id_dev_jrn][$dt_prs['id']]['nom'] = $dt_prs['nom'];
    $prs_datas[$id_dev_jrn][$dt_prs['id']]['opt'] = $dt_prs['opt'];
    $prs_datas[$id_dev_jrn][$dt_prs['id']]['ord'] = $dt_prs['ord'];
    $prs_datas[$id_dev_jrn][$dt_prs['id']]['id_cat'] = $dt_prs['id_cat'];
  }
}
?>
<table id="vue_dsc_jrn_<?php echo $id_dev_jrn ?>" class="w-100"><?php if($vue_jrn) {include("vue_dsc_jrn.php");} ?></table>
<div id="vue_dt_jrn_<?php echo $id_dev_jrn ?>" <?php if(!$vue_jrn) {echo 'class="up_prs"';} ?> style="overflow-x: auto;"><?php include("vue_dt_jrn.php"); ?></div>
<div id="vue_end_jrn_<?php echo $id_dev_jrn ?>" class="text-center"><?php include("vue_end_jrn.php"); ?></div>
