<?php
$id_dev_prs = $_POST['id_dev_prs'];
$id_hbr = $_POST['id_hbr'];
$id_vll = $_POST['id_vll'];
$id_rgm = $_POST['id_rgm'];
include("../prm/fct.php");
include("../prm/aut.php");
include("../prm/lgg.php");
include("../cfg/ctg_hbr.php");
include("../cfg/crr.php");
$txt = simplexml_load_file('txt.xml');
$dt_prs = ftc_ass(sel_quo("id_jrn","dev_prs","id",$id_dev_prs));
$id_dev_jrn = $dt_prs['id_jrn'];
$dt_jrn = ftc_ass(sel_quo("id_mdl, date","dev_jrn","id",$id_dev_jrn));
$id_dev_mdl = $dt_jrn['id_mdl'];
$date = $dt_jrn['date'];
$dt_mdl = ftc_ass(sel_quo("id_crc,vue_sgl,vue_tpl,vue_qdp,trf,com,mrq_hbr","dev_mdl","id",$id_dev_mdl));
$id_dev_crc = $dt_mdl['id_crc'];
$dt_crc = ftc_ass(sel_quo("crr,vue_sgl,vue_tpl,vue_qdp,com,mrq_hbr,frs,ty_mrq","dev_crc","id",$id_dev_crc));
$com_crc = $dt_crc['com'];
$mrq_hbr_crc = $dt_crc['mrq_hbr'];
$frs_crc = $dt_crc['frs'];
$ty_mrq = $dt_crc['ty_mrq'];
$id_crr_crc = $dt_crc['crr'];
$lat = $lon = $nom = '';
if($dt_mdl['trf']) {
	$vue_sgl = $dt_mdl['vue_sgl'];
	$vue_tpl = $dt_mdl['vue_tpl'];
	$vue_qdp = $dt_mdl['vue_qdp'];
	$com = $dt_mdl['com'];
	$tx_mrq = $dt_mdl['mrq_hbr'];
}
else{
	$vue_sgl = $dt_crc['vue_sgl'];
	$vue_tpl = $dt_crc['vue_tpl'];
	$vue_qdp = $dt_crc['vue_qdp'];
	$com = $com_crc;
	$tx_mrq = $mrq_hbr_crc;
}
$id_crr_trf = $id_crr_crc;
if($id_hbr>0) {
	$nb_chm = ftc_ass(sel_quo("COUNT(*) as total","cat_hbr_chm","id_hbr",$id_hbr));
	if($nb_chm['total']!=0) {
		$dt_hbr = ftc_ass(sel_quo("lat,lon,nom,id_frn,frs,nvtrf","cat_hbr","id",$id_hbr));
		$nvtrf = $dt_hbr['nvtrf'];
		$frs_hbr = 1;
		if($dt_hbr['id_frn']>0) {
			$dt_frn = ftc_ass(sel_quo("frs","cat_frn","id",$dt_hbr['id_frn']));
			$frs_hbr += $dt_frn['frs'];
		}
		else{$frs_hbr += $dt_hbr['frs'];}
?>
<div class="div_vll">
	<table class="w-100">
		<tr style="height: 100%">
			<td>
				<table class="vatdib">
					<tr style="font-weight: bold;">
						<td>
							<span class="dib" onClick="document.getElementById('vue_trf_hbr_<?php echo $id_dev_prs ?>').innerHTML='';$('vue_trf_hbr_<?php echo id_dev_prs ?>').removeClass('hbr');"><img src="../prm/img/cls.png" /></span>
							<span class="dib" onClick="vue_trf_hbr(<?php echo $id_dev_prs.',0,0' ?>);"><img src="../prm/img/bck.png" /></span>
<?php
echo '<br/>'.$prm_crr_nom[$id_crr_trf];
?>

						</td>
						<td class="stl3"><?php echo $txt->opt->$id_lng.'<br/>'.$txt->chms->$id_lng; ?></td>
<?php
		if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->dbl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
		}
?>
						<td class="stl3"><?php echo $txt->dbl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
		if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->com->$id_lng.'<br/>'.$txt->dbl->$id_lng; ?></td>
<?php
		}
		if($vue_sgl) {
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->sgl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
			}
?>
						<td class="stl3"><?php echo $txt->sgl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->com->$id_lng.'<br/>'.$txt->sgl->$id_lng; ?></td>
<?php
			}
		}
		if($vue_tpl) {
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->tpl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
			}
?>
						<td class="stl3"><?php echo $txt->tpl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->com->$id_lng.'<br/>'.$txt->tpl->$id_lng; ?></td>
<?php
			}
		}
		if($vue_qdp) {
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->qdp->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
			}
?>
						<td class="stl3"><?php echo $txt->qdp->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->com->$id_lng.'<br/>'.$txt->qdp->$id_lng; ?></td>
<?php
			}
		}
?>
						<td class="stl3"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->min->$id_lng; ?></td>
						<td class="stl3"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->max->$id_lng; ?></td>
					</tr>
<?php
		$flg_lnk = true;
		$rq_rgm = sel_quo("id","cat_hbr_rgm",array("id_hbr","rgm"),array($id_hbr,$id_rgm));
		if(num_rows($rq_rgm)>0) {
			$rq_chm = sel_quo("id,nom","cat_hbr_chm","id_hbr",$id_hbr,"nom");
			$flg_rgm_trf = true;
		}
		else{
			$rq_chm = sel_quo("id,nom","cat_hbr_chm",array("id_hbr","rgm"),array($id_hbr,$id_rgm),"nom");
			$flg_rgm_trf = false;
		}
		$nb_chm = num_rows($rq_chm);
		while($dt_chm = ftc_ass($rq_chm)) {
			$flg_rgm = $flg_rgm_trf;
?>
					<tr style="font-weight: normal;<?php if($nvtrf) {echo 'background-color: orange;';} ?>">
<?php
			if($flg_lnk) {
?>
						<td rowspan="<?php echo $nb_chm ?>" class="stl5" style="height: 26px;">
							<span class="lnk inf<?php echo $id_hbr ?>hbr" onmouseover="vue_elem('inf',<?php echo $id_hbr ?>,'hbr')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $id_hbr ?>');"><?php echo stripslashes($dt_hbr['nom']); ?></span>
						</td>
<?php
				$flg_lnk = false;
			}
?>
						<td class="stl5"><?php echo stripslashes($dt_chm['nom']); ?></td>
<?php
			$flg_trf = false;
			if($date!='0000-00-00') {
				$rq_trf = sel_quo('*','cat_hbr_chm_trf INNER JOIN cat_hbr_chm_trf_ssn ON cat_hbr_chm_trf.id = cat_hbr_chm_trf_ssn.id_trf','id_chm',$dt_chm['id']);
				while($dt_trf = ftc_ass($rq_trf)) {
					if(strtotime($dt_trf['dt_min']) <= strtotime($date) and strtotime($date) <= strtotime($dt_trf['dt_max'])) {
						$flg_trf = true;
						$id_crr_chm = $dt_trf['crr'];
						$est_chm = $dt_trf['est'];
						$dt_min_chm = $dt_trf['dt_min'];
						$dt_max_chm = $dt_trf['dt_max'];
						$db_rck_chm = $dt_trf['db_rck'];
						$db_net_chm = $dt_trf['db_net']*$frs_hbr;
						$sg_rck_chm = $dt_trf['sg_rck'];
						$sg_net_chm = $dt_trf['sg_net']*$frs_hbr;
						$tp_rck_chm = $dt_trf['tp_rck'];
						$tp_net_chm = $dt_trf['tp_net']*$frs_hbr;
						$qd_rck_chm = $dt_trf['qd_rck'];
						$qd_net_chm = $dt_trf['qd_net']*$frs_hbr;
					}
				}
			}
			if(!$flg_trf) {
				$dt_trf = ftc_ass(sel_quo("*","cat_hbr_chm_trf INNER JOIN cat_hbr_chm_trf_ssn ON cat_hbr_chm_trf.id = cat_hbr_chm_trf_ssn.id_trf",array("def","id_chm"),array("1",$dt_chm['id']),"dt_max DESC"));
				if(!empty($dt_trf['id'])) {
					$flg_trf = true;
					$id_crr_chm = $dt_trf['crr'];
					$est_chm = 1;
					$dt_min_chm = $dt_trf['dt_min'];
					$dt_max_chm = $dt_trf['dt_max'];
					$db_rck_chm = $dt_trf['db_rck'];
					$db_net_chm = $dt_trf['db_net']*$frs_hbr;
					$sg_rck_chm = $dt_trf['sg_rck'];
					$sg_net_chm = $dt_trf['sg_net']*$frs_hbr;
					$tp_rck_chm = $dt_trf['tp_rck'];
					$tp_net_chm = $dt_trf['tp_net']*$frs_hbr;
					$qd_rck_chm = $dt_trf['qd_rck'];
					$qd_net_chm = $dt_trf['qd_net']*$frs_hbr;
				}
			}
			if($flg_rgm) {
				$flg_rgm = false;
				$dt_rgm = ftc_ass(sel_quo("id","cat_hbr_rgm",array("id_hbr","rgm"),array($id_hbr,$id_rgm)));
				if($date!='0000-00-00') {
					$rq_trf = sel_quo("*","cat_hbr_rgm_trf INNER JOIN cat_hbr_rgm_trf_ssn ON cat_hbr_rgm_trf.id = cat_hbr_rgm_trf_ssn.id_trf","id_rgm",$dt_rgm['id']);
					while($dt_trf = ftc_ass($rq_trf)) {
						if(strtotime($dt_trf['dt_min']) <= strtotime($date) and strtotime($date) <= strtotime($dt_trf['dt_max'])) {
							$flg_rgm = true;
							$id_crr_rgm = $dt_trf['crr'];
							$est_rgm = $dt_trf['est'];
							$dt_min_rgm = $dt_trf['dt_min'];
							$dt_max_rgm = $dt_trf['dt_max'];
							$db_rck_rgm = $dt_trf['db_rck'];
							$db_net_rgm = $dt_trf['db_net']*$frs_hbr;
							$sg_rck_rgm = $dt_trf['sg_rck'];
							$sg_net_rgm = $dt_trf['sg_net']*$frs_hbr;
							$tp_rck_rgm = $dt_trf['tp_rck'];
							$tp_net_rgm = $dt_trf['tp_net']*$frs_hbr;
							$qd_rck_rgm = $dt_trf['qd_rck'];
							$qd_net_rgm = $dt_trf['qd_net']*$frs_hbr;
						}
					}
				}
				if(!$flg_rgm) {
					$dt_trf = ftc_ass(sel_quo("*","cat_hbr_rgm_trf INNER JOIN cat_hbr_rgm_trf_ssn ON cat_hbr_rgm_trf.id = cat_hbr_rgm_trf_ssn.id_trf",array("def","id_rgm"),array("1",$dt_rgm['id']),"dt_max DESC"));
					if(!empty($dt_trf['id'])) {
						$flg_rgm = true;
						$id_crr_rgm = $dt_trf['crr'];
						$est_rgm = 1;
						$dt_min_rgm = $dt_trf['dt_min'];
						$dt_max_rgm = $dt_trf['dt_max'];
						$db_rck_rgm = $dt_trf['db_rck'];
						$db_net_rgm = $dt_trf['db_net']*$frs_hbr;
						$sg_rck_rgm = $dt_trf['sg_rck'];
						$sg_net_rgm = $dt_trf['sg_net']*$frs_hbr;
						$tp_rck_rgm = $dt_trf['tp_rck'];
						$tp_net_rgm = $dt_trf['tp_net']*$frs_hbr;
						$qd_rck_rgm = $dt_trf['qd_rck'];
						$qd_net_rgm = $dt_trf['qd_net']*$frs_hbr;
					}
				}
			}
			else{
				$id_crr_rgm = 0;
				$est_rgm = 0;
				$dt_min_rgm = '0000-00-00';
				$dt_max_rgm = '0000-00-00';
				$db_rck_rgm = 0;
				$db_net_rgm = 0;
				$sg_rck_rgm = 0;
				$sg_net_rgm = 0;
				$tp_rck_rgm = 0;
				$tp_net_rgm = 0;
				$qd_rck_rgm = 0;
				$qd_net_rgm = 0;
				$flg_rgm = true;
			}
			if(!$flg_trf or !$flg_rgm) {
				if(!$flg_trf) {$est_chm = -1;}
				if(!$flg_rgm) {$est_rgm = -1;}
			}
			if($flg_trf) {include("vue_trf_chm.php");}
			else{
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
				if($vue_sgl) {
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
				}
				if($vue_tpl) {
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
				}
				if($vue_qdp) {
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
				}
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
			}
?>
					</tr>
<?php
		}
?>
					<input id="lat<?php echo $id_dev_prs ?>" type="hidden" value="<?php echo $dt_hbr['lat']; ?>">
					<input id="lon<?php echo $id_dev_prs ?>" type="hidden" value="<?php echo $dt_hbr['lon']; ?>">
					<input id="nom<?php echo $id_dev_prs ?>" type="hidden" value="<?php echo $dt_hbr['nom'] ?>" />
				</table>
			</td>
			<td style="height: 100%; width: 100%">
				<div id="map<?php echo $id_dev_prs ?>" style="height: 100%" class="stl4"></div>
			</td>
		</tr>
	</table>
</div>
<?php
	}
}
else{
	$rq_hbr = sel_quo("cat_hbr.id,nom,lat,lon,ctg,id_frn,frs,nvtrf","cat_hbr INNER JOIN cfg_ctg_hbr ON cat_hbr.ctg = cfg_ctg_hbr.id",array("id_vll","lstrg","ferme"),array($id_vll,"0","0"),"ord,nom");
	if(num_rows($rq_hbr)!=0) {
?>
<div class="div_vll">
	<table class="w-100">
		<tr style="height: 100%">
			<td>
				<table class="vatdib">
					<tr style="font-weight: bold;">
						<td>
							<span class="dib" onClick="document.getElementById('vue_trf_hbr_<?php echo $id_dev_prs ?>').innerHTML='';"><img src="../prm/img/cls.png" /></span>
<?php
		echo '<br/>'.$prm_crr_nom[$id_crr_trf];
?>
						</td>
						<td class="stl3"><?php echo $txt->opt->$id_lng.'<br/>'.$txt->hbrs->$id_lng; ?></td>
						<td class="stl3"><?php echo $txt->ctg->$id_lng; ?></td>
						<td class="stl3"><?php echo $txt->chms->$id_lng; ?></td>
<?php
		if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->dbl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
		}
?>
						<td class="stl3"><?php echo $txt->dbl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
		if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->com->$id_lng.'<br/>'.$txt->dbl->$id_lng; ?></td>
<?php
		}
		if($vue_sgl) {
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->sgl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
			}
?>
						<td class="stl3"><?php echo $txt->sgl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->com->$id_lng.'<br/>'.$txt->sgl->$id_lng; ?></td>
<?php
			}
		}
		if($vue_tpl) {
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->tpl->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
			}
?>
						<td class="stl3"><?php echo $txt->tpl->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->com->$id_lng.'<br/>'.$txt->tpl->$id_lng; ?></td>
<?php
			}
		}
		if($vue_qdp) {
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->qdp->$id_lng.'<br/>'.$txt->trf->$id_lng; ?></td>
<?php
			}
?>
						<td class="stl3"><?php echo $txt->qdp->$id_lng.'<br/>'.$txt->cst->$id_lng; ?></td>
<?php
			if($ty_mrq == 2) {
?>
						<td class="stl3"><?php echo $txt->com->$id_lng.'<br/>'.$txt->qdp->$id_lng; ?></td>
<?php
			}
		}
?>
						<td class="stl3"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->min->$id_lng; ?></td>
						<td class="stl3"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->max->$id_lng; ?></td>
					</tr>
<?php
		$j = 0;
		while($dt_hbr = ftc_ass($rq_hbr)) {
			$nvtrf = $dt_hbr['nvtrf'];
			$frs_hbr = 1;
			if($dt_hbr['id_frn']>0) {
				$dt_frn = ftc_ass(sel_quo("frs","cat_frn","id",$dt_hbr['id_frn']));
				$frs_hbr += $dt_frn['frs'];
			}
			else{$frs_hbr += $dt_hbr['frs'];}
			if($j>7) {$j=0;}
			$flg_lnk = true;
			$dt_rgm = ftc_ass(sel_quo("id","cat_hbr_rgm",array("id_hbr","rgm"),array($dt_hbr['id'],$id_rgm)));
			if(!empty($dt_rgm['id'])) {
				$rq_chm = sel_quo("id,nom","cat_hbr_chm","id_hbr",$dt_hbr['id'],"nom");
				$flg_rgm_trf = true;
			}
			else{
				$rq_chm = sel_quo("id,nom","cat_hbr_chm",array("id_hbr","rgm"),array($dt_hbr['id'],$id_rgm),"nom");
				$flg_rgm_trf = false;
			}
			$flg_map = false;
			$nb_chm = num_rows($rq_chm);
			while($dt_chm = ftc_ass($rq_chm)) {
				$flg_map = true;
				$flg_rgm = $flg_rgm_trf;

?>
					<tr style="font-weight: normal;<?php if($nvtrf) {echo 'background-color: orange;';} ?>">

<?php
				if($flg_lnk) {
?>
						<td rowspan="<?php echo $nb_chm ?>" class="stl4">
							<image src="../prm/img/<?php echo $j ?>-minidot.png" />
						</td>
						<td rowspan="<?php echo $nb_chm ?>" class="stl5" style="height: 26px;">
							<span class="lnk inf<?php echo $dt_hbr['id'] ?>hbr" onmouseover="vue_elem('inf',<?php echo $dt_hbr['id'] ?>,'hbr')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt_hbr['id'] ?>');"><?php echo stripslashes($dt_hbr['nom']); ?></span>
						</td>
						<td rowspan="<?php echo $nb_chm ?>" class="stl5"><?php echo $ctg_hbr[$id_lng][$dt_hbr['ctg']]; ?></td>
<?php
					$flg_lnk = false;
				}
?>
						<td class="stl5"><?php echo stripslashes($dt_chm['nom']); ?></td>
<?php
				$flg_trf = false;
				if($date!='0000-00-00') {
					$rq_trf = sel_quo("*","cat_hbr_chm_trf INNER JOIN cat_hbr_chm_trf_ssn ON cat_hbr_chm_trf.id = cat_hbr_chm_trf_ssn.id_trf","id_chm",$dt_chm['id']);
					while($dt_trf = ftc_ass($rq_trf)) {
						if(strtotime($dt_trf['dt_min']) <= strtotime($date) and strtotime($date) <= strtotime($dt_trf['dt_max'])) {
							$flg_trf = true;
							$id_crr_chm = $dt_trf['crr'];
							$est_chm = $dt_trf['est'];
							$dt_min_chm = $dt_trf['dt_min'];
							$dt_max_chm = $dt_trf['dt_max'];
							$db_rck_chm = $dt_trf['db_rck'];
							$db_net_chm = $dt_trf['db_net']*$frs_hbr;
							$sg_rck_chm = $dt_trf['sg_rck'];
							$sg_net_chm = $dt_trf['sg_net']*$frs_hbr;
							$tp_rck_chm = $dt_trf['tp_rck'];
							$tp_net_chm = $dt_trf['tp_net']*$frs_hbr;
							$qd_rck_chm = $dt_trf['qd_rck'];
							$qd_net_chm = $dt_trf['qd_net']*$frs_hbr;
						}
					}
				}
				if(!$flg_trf) {
					$dt_trf = ftc_ass(sel_quo("*","cat_hbr_chm_trf INNER JOIN cat_hbr_chm_trf_ssn ON cat_hbr_chm_trf.id = cat_hbr_chm_trf_ssn.id_trf",array("def","id_chm"),array("1",$dt_chm['id']),"dt_max DESC"));
					if(!empty($dt_trf['id'])) {
						$flg_trf = true;
						$id_crr_chm = $dt_trf['crr'];
						$est_chm = 1;
						$dt_min_chm = $dt_trf['dt_min'];
						$dt_max_chm = $dt_trf['dt_max'];
						$db_rck_chm = $dt_trf['db_rck'];
						$db_net_chm = $dt_trf['db_net']*$frs_hbr;
						$sg_rck_chm = $dt_trf['sg_rck'];
						$sg_net_chm = $dt_trf['sg_net']*$frs_hbr;
						$tp_rck_chm = $dt_trf['tp_rck'];
						$tp_net_chm = $dt_trf['tp_net']*$frs_hbr;
						$qd_rck_chm = $dt_trf['qd_rck'];
						$qd_net_chm = $dt_trf['qd_net']*$frs_hbr;
					}
				}
				if($flg_rgm) {
					$flg_rgm = false;
					$dt_rgm = ftc_ass(sel_quo("id","cat_hbr_rgm",array("id_hbr","rgm"),array($dt_hbr['id'],$id_rgm)));
					if($date!='0000-00-00') {
						$rq_trf = sel_quo("*","cat_hbr_rgm_trf INNER JOIN cat_hbr_rgm_trf_ssn ON cat_hbr_rgm_trf.id = cat_hbr_rgm_trf_ssn.id_trf","id_rgm",$dt_rgm['id']);
						while($dt_trf = ftc_ass($rq_trf)) {
							if(strtotime($dt_trf['dt_min']) <= strtotime($date) and strtotime($date) <= strtotime($dt_trf['dt_max'])) {
								$flg_rgm = true;
								$id_crr_rgm = $dt_trf['crr'];
								$est_rgm = $dt_trf['est'];
								$dt_min_rgm = $dt_trf['dt_min'];
								$dt_max_rgm = $dt_trf['dt_max'];
								$db_rck_rgm = $dt_trf['db_rck'];
								$db_net_rgm = $dt_trf['db_net']*$frs_hbr;
								$sg_rck_rgm = $dt_trf['sg_rck'];
								$sg_net_rgm = $dt_trf['sg_net']*$frs_hbr;
								$tp_rck_rgm = $dt_trf['tp_rck'];
								$tp_net_rgm = $dt_trf['tp_net']*$frs_hbr;
								$qd_rck_rgm = $dt_trf['qd_rck'];
								$qd_net_rgm = $dt_trf['qd_net']*$frs_hbr;
							}
						}
					}
					if(!$flg_rgm) {
						$dt_trf = ftc_ass(sel_quo("*","cat_hbr_rgm_trf INNER JOIN cat_hbr_rgm_trf_ssn ON cat_hbr_rgm_trf.id = cat_hbr_rgm_trf_ssn.id_trf",array("def","id_rgm"),array("1",$dt_rgm['id']),'dt_max DESC'));
						if(!empty($dt_trf['id'])) {
							$flg_rgm = true;
							$id_crr_rgm = $dt_trf['crr'];
							$est_rgm = 1;
							$dt_min_rgm = $dt_trf['dt_min'];
							$dt_max_rgm = $dt_trf['dt_max'];
							$db_rck_rgm = $dt_trf['db_rck'];
							$db_net_rgm = $dt_trf['db_net']*$frs_hbr;
							$sg_rck_rgm = $dt_trf['sg_rck'];
							$sg_net_rgm = $dt_trf['sg_net']*$frs_hbr;
							$tp_rck_rgm = $dt_trf['tp_rck'];
							$tp_net_rgm = $dt_trf['tp_net']*$frs_hbr;
							$qd_rck_rgm = $dt_trf['qd_rck'];
							$qd_net_rgm = $dt_trf['qd_net']*$frs_hbr;
						}
					}
				}
				else{
					$id_crr_rgm = 0;
					$est_rgm = 0;
					$dt_min_rgm = '0000-00-00';
					$dt_max_rgm = '0000-00-00';
					$db_rck_rgm = 0;
					$db_net_rgm = 0;
					$sg_rck_rgm = 0;
					$sg_net_rgm = 0;
					$tp_rck_rgm = 0;
					$tp_net_rgm = 0;
					$qd_rck_rgm = 0;
					$qd_net_rgm = 0;
					$flg_rgm = true;
				}
				if(!$flg_trf or !$flg_rgm) {
					if(!$flg_trf) {$est_chm = -1;}
					if(!$flg_rgm) {$est_rgm = -1;}
				}
				if($flg_trf) {include("vue_trf_chm.php");}
				else{
?>
						<td class="stl4"></td>
<?php
						if($ty_mrq == 2) {
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
					}
					if($vue_sgl) {
?>
						<td class="stl4"></td>
<?php
						if($ty_mrq == 2) {
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
						}
					}
					if($vue_tpl) {
?>
						<td class="stl4"></td>
<?php
						if($ty_mrq == 2) {
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
						}
					}
					if($vue_qdp) {
?>
						<td class="stl4"></td>
<?php
						if($ty_mrq == 2) {
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
						}
					}
?>
						<td class="stl4"></td>
						<td class="stl4"></td>
<?php
				}
?>
					</tr>
<?php
			}
			if($nb_chm == 0) {
?>
					<tr style="font-weight: normal;<?php if($nvtrf) {echo 'background-color: orange;';} ?>">
						<td class="stl4">
							<image src="../prm/img/<?php echo $j ?>-minidot.png" />
						</td>
						<td class="stl5" style="height: 26px;">
							<span class="lnk inf<?php echo $dt_hbr['id'] ?>hbr" onmouseover="vue_elem('inf',<?php echo $dt_hbr['id'] ?>,'hbr')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt_hbr['id'] ?>');"><?php echo stripslashes($dt_hbr['nom']); ?></span>
						</td>
						<td class="stl5"><?php echo $ctg_hbr[$id_lng][$dt_hbr['ctg']]; ?></td>
					</tr>
<?php
			}
			$lat .= stripslashes($dt_hbr['lat']).'|';
			$lon .= stripslashes($dt_hbr['lon']).'|';
			$nom .= stripslashes($dt_hbr['nom']).'|';
			$j++;
		}
?>
				<input id="lat<?php echo $id_dev_prs ?>" type="hidden" value="<?php echo $lat; ?>" />
				<input id="lon<?php echo $id_dev_prs ?>" type="hidden" value="<?php echo $lon; ?>" />
				<input id="nom<?php echo $id_dev_prs ?>" type="hidden" value="<?php echo $nom; ?>" />
				</table>

			</td>
			<td style="height: 100%; width: 100%">
				<div id="map<?php echo $id_dev_prs ?>" style="height: 100%" class="stl4" ></div>
			</td>
		</tr>
	</table>
</div>
<?php
	}
}
?>
