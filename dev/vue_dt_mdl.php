<?php
if(isset($_POST['id_dev_mdl'])){
	$id_dev_mdl = $_POST['id_dev_mdl'];
	$vue_mdl = $_POST['vue'];
	$jrn_vue = explode('|',$_POST['jrn_vue']);
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/col.php");
	include("../prm/ctg_prs.php");
	include("../prm/ctg_srv.php");
	include("../prm/res_prs.php");
	include("../prm/res_srv.php");
	include("../prm/rgm.php");
	include("../cfg/vll.php");
	include("../cfg/crr.php");
	$dt_mdl = ftc_ass(select("id_cat,col,trf,fus,ord,vue_sgl,vue_tpl,vue_qdp,com,mrq_hbr,ptl,psg","dev_mdl","id",$id_dev_mdl));
	$id_cat_mdl = $dt_mdl['id_cat'];
	$id_col_mdl = $dt_mdl['col'];
	$trf_mdl = $dt_mdl['trf'];
	$fus_mdl = $dt_mdl['fus'];
	$ord_mdl = $dt_mdl['ord'];
	$dt_crc = ftc_ass(select("com,mrq_hbr,frs,ty_mrq,crr,vue_sgl,vue_tpl,vue_qdp,ptl,psg","dev_crc","id",$id_dev_crc));
	$com_crc = $dt_crc['com'];
	$mrq_hbr_crc = $dt_crc['mrq_hbr'];
	$frs_crc = $dt_crc['frs'];
	$ty_mrq = $dt_crc['ty_mrq'];
	$id_crr_crc = $dt_crc['crr'];
	$nb_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl","id_crc",$id_dev_crc));
	if($trf_mdl){
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
	$rq_prs = select("dev_prs.id,dev_prs.nom,dev_prs.opt,dev_prs.ord,dev_prs.id_cat,id_jrn","dev_prs INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id","id_mdl",$id_dev_mdl,"ord,opt DESC,nom,id");
	while($dt_prs = ftc_ass($rq_prs)){
		$prs_datas[$dt_prs['id_jrn']][$dt_prs['id']]['nom'] = $dt_prs['nom'];
		$prs_datas[$dt_prs['id_jrn']][$dt_prs['id']]['opt'] = $dt_prs['opt'];
		$prs_datas[$dt_prs['id_jrn']][$dt_prs['id']]['ord'] = $dt_prs['ord'];
		$prs_datas[$dt_prs['id_jrn']][$dt_prs['id']]['id_cat'] = $dt_prs['id_cat'];
	}
	$rq_jrn = select("*","dev_jrn","id_mdl",$id_dev_mdl,"ord,opt DESC");
	while($dt_jrn = ftc_ass($rq_jrn)){
		$jrn_datas[$dt_jrn['id']]['id_cat'] = $dt_jrn['id_cat'];
		$jrn_datas[$dt_jrn['id']]['date'] = $dt_jrn['date'];
		$jrn_datas[$dt_jrn['id']]['opt'] = $dt_jrn['opt'];
		$jrn_datas[$dt_jrn['id']]['ord'] = $dt_jrn['ord'];
		$jrn_datas[$dt_jrn['id']]['nom'] = $dt_jrn['nom'];
		$jrn_datas[$dt_jrn['id']]['titre'] = $dt_jrn['titre'];
		$jrn_datas[$dt_jrn['id']]['dsc'] = $dt_jrn['dsc'];
	}
}
if($id_cat_mdl>-1){
	if($vue_mdl == 1){
		if(isset($jrn_datas)) {
			$nb_jrn = count($jrn_datas);
			if($nb_jrn > 0){
			//$nb_jrn = ftc_ass(select("COUNT(*) as total","dev_jrn","id_mdl",$id_dev_mdl));
			//if($nb_jrn['total'] > 0){
				$min_jrn = ftc_num(select("MIN(ord)","dev_jrn","id_mdl",$id_dev_mdl));
				$max_jrn = ftc_num(select("MAX(ord)","dev_jrn","id_mdl",$id_dev_mdl));
				foreach($jrn_datas as $id_dev_jrn => $dt_jrn) {
			//$rq_jrn = select("*","dev_jrn","id_mdl",$id_dev_mdl,"ord,opt DESC");
			//while($dt_jrn = ftc_ass($rq_jrn)){
					$id_cat_jrn = $dt_jrn['id_cat'];
					$date_jrn = $dt_jrn['date'];
					$opt_jrn = $dt_jrn['opt'];
					$ord_jrn = $dt_jrn['ord'];
					$nom_jrn = $dt_jrn['nom'];
					$ttr_jrn = $dt_jrn['titre'];
					$dsc_jrn = $dt_jrn['dsc'];
					$nb_jrn_opt = ftc_ass(select("COUNT(*) as total","dev_jrn","ord=".$ord_jrn." AND id_mdl",$id_dev_mdl));
					if($nb_jrn_opt['total'] > 1){$flg_jrn_opt = true;}
					else{$flg_jrn_opt = false;}
					unset($trf_net,$trf_rck);
					if(!isset($jrn_opt_id_cat)){
						$id_sel_jrn = $id_dev_jrn;
						echo  '<br />';
					}
					$jrn_opt_id_cat[] = $id_cat_jrn;
					$jrn_rpl_id_cat[] = $id_cat_jrn;
					if(isset($jrn_vue) and in_array("vue_jrn".$id_dev_jrn,$jrn_vue)) {$vue_jrn=1;}
					else{$vue_jrn = 0;}
?>
<div id="div_jrn<?php echo $id_dev_jrn ?>" class="jrn_jrn<?php echo $id_dev_mdl.'_'.$ord_jrn; if($opt_jrn){echo ' sel_opt';} ?>">
	<div <?php if($id_cat_jrn>-1) {echo 'class="tbl_jrn"';} ?>>
		<table id="vue_ttr_jrn_<?php echo $id_dev_jrn ?>" <?php if($id_cat_jrn>0){echo 'class="up_jrn'.$id_cat_jrn.'"';} if($id_cat_jrn > -1){echo 'width="100%"';} ?>><?php include("vue_ttr_jrn.php"); ?></table>
<?php
					if($id_cat_jrn>-1){
?>
		<div id="vue_dsc_dt_end_jrn_<?php echo $id_dev_jrn ?>"><?php include("vue_dsc_dt_end_jrn.php"); ?></div>
<?php
					}
					if($nb_jrn_opt['total'] == count($jrn_opt_id_cat)){
?>
	</div>
<?php
						if($id_cat_jrn!=-1 and (($aut['dev'] and $cnf<1) or ($aut['res'] and $cnf>0))){
?>
		<div id="rpl_opt_jrn<?php echo $id_sel_jrn ?>" class="text-center">
			<table>
				<tr>
					<td id="rpl_jrn<?php echo $id_sel_jrn ?>" class="ajt_jrn_rpl"><?php include("vue_rpl_jrn.php"); ?></td>
					<td id="opt_jrn<?php echo $id_sel_jrn ?>" class="ajt_jrn_opt"><?php include("vue_opt_jrn.php"); ?></td>
				</tr>
			</table>
		</div>
<?php
						}
						unset($jrn_opt_id_cat);
					}
?>
	</div>
</div>
<?php
				}
			}
		}
	}
	else{
?>
<table class="dsg w-100">
	<tr>
		<td class="stl1"><?php echo $txt->jrns->$id_lng.':'; ?></td>
<?php
		$ord_jrn_ant = 0;
		$rq_jrn = select("nom,opt,ord,id_cat","dev_jrn","id_mdl",$id_dev_mdl,"ord,opt DESC");
		while($dt_jrn = ftc_ass($rq_jrn)){
			if($ord_jrn_ant != $dt_jrn['ord']){
				if($ord_jrn_ant!=0){
?>
		</td>
<?php
				}
?>
		<td class="stl1">
<?php
			}
			else{echo '<br />';}
?>
			<span <?php if($dt_jrn['opt']==0){echo 'style="font-weight: normal"';} ?>>
<?php
			if(!empty($dt_jrn['nom'])){
				if($dt_jrn['id_cat']>0){
?>
				<span class="lnk inf<?php echo $dt_jrn['id_cat'] ?>jrn" onmouseover="vue_elem('inf',<?php echo $dt_jrn['id_cat'] ?>,'jrn')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $dt_jrn['id_cat'] ?>')">
<?php
				}
				echo stripslashes($dt_jrn['nom']);
				if($dt_jrn['id_cat']>0){echo '</span>';}
			}
			elseif($dt_jrn['id_cat']==-1){echo $txt->nosrv->$id_lng;}
			else{echo $txt->nonom->$id_lng;}
?>
			</span>
<?php
			$ord_jrn_ant = $dt_jrn['ord'];
		}
?>
		</td>
	</tr>
</table>
<?php
	}
}
?>
