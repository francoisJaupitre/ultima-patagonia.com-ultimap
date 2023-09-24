<?php
if(isset($_POST['id_dev_mdl'])){
	$id_dev_mdl = $_POST['id_dev_mdl'];
  unset($_POST['id_dev_mdl']);
  $vue_mdl = $_POST['vue'];
  $jrn_vue = explode('|',$_POST['jrn_vue']);
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
  include("../prm/lgg.php");
	include("../prm/col.php");
  include("../prm/ncn.php");
  include("../prm/room.php");
  include("../prm/ctg_prs.php");
  include("../prm/ctg_srv.php");
  include("../prm/res_prs.php");
  include("../prm/res_srv.php");
  include("../prm/rgm.php");
  include("../cfg/rgn.php");
  include("../cfg/crr.php");
	$dt_mdl = ftc_ass(select("dev_mdl.col,dev_mdl.dsc,dev_mdl.info,id_grp,dev_mdl.id_cat,dev_mdl.trf,dev_mdl.fus,dev_mdl.ord,dev_mdl.vue_sgl,dev_mdl.vue_tpl,dev_mdl.vue_qdp,dev_mdl.com,dev_mdl.mrq_hbr,dev_mdl.ptl,dev_mdl.psg","dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id","dev_mdl.id",$id_dev_mdl));
	$id_cat_mdl = $dt_mdl['id_cat'];
  $id_col_mdl = $dt_mdl['col'];
	$dsc_mdl = $dt_mdl['dsc'];
	$inf_mdl = $dt_mdl['info'];
  $trf_mdl = $dt_mdl['trf'];
  $fus_mdl = $dt_mdl['fus'];
  $ord_mdl = $dt_mdl['ord'];
  $grp_crc = $dt_mdl['id_grp'];
  $num_grp_pax = num_rows(sel_quo("id","grp_pax",array("id_grp","prt"),array($grp_crc,1)));
  $ptl = $dt_mdl['ptl'];
	$rq_rgn = sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$id_dev_mdl);
	while($dt_rgn = ftc_ass($rq_rgn))
	{
		$ids_rgn[] = $dt_rgn['id_rgn'];
	}
	include("../cfg/vll.php");
	unset($ids_rgn);
  $dt_crc = ftc_ass(select("com,mrq_hbr,frs,ty_mrq,crr,vue_sgl,vue_tpl,vue_qdp,ptl,psg","dev_crc","id",$id_dev_crc));
  $com_crc = $dt_crc['com'];
  $mrq_hbr_crc = $dt_crc['mrq_hbr'];
  $frs_crc = $dt_crc['frs'];
  $ty_mrq = $dt_crc['ty_mrq'];
  $id_crr_crc = $dt_crc['crr'];
  $nb_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl","id_crc",$id_dev_crc));
  if($trf_mdl)
	{
    $vue_sgl_mdl = $dt_mdl['vue_sgl'];
    $vue_tpl_mdl = $dt_mdl['vue_tpl'];
    $vue_qdp_mdl = $dt_mdl['vue_qdp'];
    $com = $dt_mdl['com'];
    $mrq_hbr = $dt_mdl['mrq_hbr'];
    $ptl = $dt_mdl['ptl'];
    $psg = $dt_mdl['psg'];
    $bss_mdl = $vue_bss_mdl = $mrq_mdl = array();
    $rq_bss_mdl = select("*","dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
    if(num_rows($rq_bss_mdl)>0){
      while($dt_bss_mdl = ftc_ass($rq_bss_mdl)){
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
    if(num_rows($rq_bss_crc)>0){
      while($dt_bss_crc = ftc_ass($rq_bss_crc)){
        $bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['base'];
        $vue_bss_crc[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
        $mrq_crc[$dt_bss_crc['id']] = $dt_bss_crc['mrq'];
      }
    }
    $nb_rmn_crc = ftc_ass(select("COUNT(*) as total","dev_crc_rmn","id_crc",$id_dev_crc));
  }
}
unset($jrn_datas,$prs_datas);
$rq_prs = select("dev_prs.id,dev_prs.nom,dev_prs.opt,dev_prs.ord,dev_prs.id_cat,id_jrn","dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id","id_mdl",$id_dev_mdl,"ord,opt DESC,nom,id");
while($dt_prs = ftc_ass($rq_prs)){
  $prs_datas[$dt_prs['id_jrn']][$dt_prs['id']]['nom'] = $dt_prs['nom'];
  $prs_datas[$dt_prs['id_jrn']][$dt_prs['id']]['opt'] = $dt_prs['opt'];
  $prs_datas[$dt_prs['id_jrn']][$dt_prs['id']]['ord'] = $dt_prs['ord'];
  $prs_datas[$dt_prs['id_jrn']][$dt_prs['id']]['id_cat'] = $dt_prs['id_cat'];
}
$rq_jrn = select("*","dev_jrn","id_mdl",$id_dev_mdl,"ord,opt DESC");
while($dt_jrn = ftc_ass($rq_jrn)){
  $jrn_datas[$dt_jrn['id']]['id_cat'] = $last_id_cat_jrn = $dt_jrn['id_cat'];
  $jrn_datas[$dt_jrn['id']]['date'] = $dt_jrn['date'];
  $jrn_datas[$dt_jrn['id']]['opt'] = $dt_jrn['opt'];
  $jrn_datas[$dt_jrn['id']]['ord'] = $dt_jrn['ord'];
  $jrn_datas[$dt_jrn['id']]['nom'] = $dt_jrn['nom'];
  $jrn_datas[$dt_jrn['id']]['titre'] = $dt_jrn['titre'];
  //$jrn_datas[$dt_jrn['id']]['dsc'] = $dt_jrn['dsc'];
	//$jrn_datas[$dt_jrn['id']]['id_pic'] = $dt_jrn['id_pic'];
}
?>
<span id="vue_dsc_mdl_<?php echo $id_dev_mdl ?>"><?php if($vue_mdl) {include("vue_dsc_mdl.php");} ?></span>
<?php
if($trf_mdl) {
?>
<span id="vue_rmn_mdl_<?php echo $id_dev_mdl ?>"><?php include("vue_rmn_mdl.php"); ?></span>
<br />
<?php
}
?>
<span id="vue_dt_mdl_<?php echo $id_dev_mdl ?>" class="dboa<?php if(!$vue_mdl){echo ' up_jrn';} ?>"><?php include("vue_dt_mdl.php"); ?></span>
<div id="vue_end_mdl_<?php echo $id_dev_mdl ?>" class="text-center"><?php include("vue_end_mdl.php"); ?></div>
