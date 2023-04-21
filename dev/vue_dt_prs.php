<?php
if(isset($_POST['id_dev_prs'])){
	$id_dev_prs = $_POST['id_dev_prs'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ctg_srv.php");
	include("../prm/res_srv.php");
	include("../prm/rgm.php");
	include("../cfg/crr.php");
	include("../cfg/vll.php");
	$dt_prs = ftc_ass(select("id_cat,id_jrn,res,ctg","dev_prs","id",$id_dev_prs));
	$id_cat_prs = $dt_prs['id_cat'];
	$id_dev_jrn = $dt_prs['id_jrn'];
	$id_res_prs = $dt_prs['res'];
	$id_ctg_prs = $dt_prs['ctg'];
	$dt_jrn = ftc_ass(select("id_mdl,date","dev_jrn","id",$id_dev_jrn));
	$date_jrn = $dt_jrn['date'];
	$id_dev_mdl = $dt_jrn['id_mdl'];
	$dt_mdl = ftc_ass(select("vue_sgl,vue_tpl,vue_qdp,trf,ptl","dev_mdl","id",$id_dev_mdl));
	$trf_mdl = $dt_mdl['trf'];
	$dt_crc = ftc_ass(select("ty_mrq,vue_sgl,vue_tpl,vue_qdp,ptl","dev_crc","id",$id_dev_crc));
	$ty_mrq = $dt_crc['ty_mrq'];
	if($trf_mdl){
		$vue_sgl = $dt_mdl['vue_sgl'];
		$vue_tpl = $dt_mdl['vue_tpl'];
		$vue_qdp = $dt_mdl['vue_qdp'];
		$ptl = $dt_mdl['ptl'];
		$rq_bss_mdl = select("id, base, vue", "dev_mdl_bss","id_mdl",$id_dev_mdl,"base");
		if(num_rows($rq_bss_mdl)>0){
			while($dt_bss_mdl = ftc_ass($rq_bss_mdl)){
				$bss[$dt_bss_mdl['id']] = $dt_bss_mdl['base'];
				$vue_bss[$dt_bss_mdl['id']] = $dt_bss_mdl['vue'];
			}
		}
	}
	else{
		$vue_sgl = $dt_crc['vue_sgl'];
		$vue_tpl = $dt_crc['vue_tpl'];
		$vue_qdp = $dt_crc['vue_qdp'];
		$ptl = $dt_crc['ptl'];
		$rq_bss_crc = select("id, base, vue", "dev_crc_bss","id_crc",$id_dev_crc,"base");
		if(num_rows($rq_bss_crc)>0){
			while($dt_bss_crc = ftc_ass($rq_bss_crc)){
				$bss[$dt_bss_crc['id']] = $dt_bss_crc['base'];
				$vue_bss[$dt_bss_crc['id']] = $dt_bss_crc['vue'];
			}
		}
	}
}
$nb_srv = ftc_ass(select("COUNT(*) as total","dev_srv","id_prs",$id_dev_prs));
$nb_pay_srv = ftc_ass(select("COUNT(dev_srv_pay.id) as total","dev_srv_pay INNER JOIN dev_srv ON dev_srv_pay.id_srv = dev_srv.id","id_prs",$id_dev_prs));
$nb_hbr = ftc_ass(select("COUNT(*) as total","dev_hbr","id_prs",$id_dev_prs));
$nb_pay_hbr = ftc_ass(select("COUNT(dev_hbr_pay.id) as total","dev_hbr_pay INNER JOIN dev_hbr ON dev_hbr_pay.id_hbr = dev_hbr.id","id_prs",$id_dev_prs));
?>
<div>
<?php
if($nb_srv['total']!=0 or $nb_hbr['total']!=0){
?>
	<div>
<?php
}
if($nb_srv['total']!=0){
?>
		<table id="tab_srv" class="dsg w-100">
			<tr>
				<td style="font-weight: bold;" colspan="3"><?php echo $txt->srvs->$id_lng.':'; ?></td>
				<td class="stl1"><?php echo $txt->trfopt->$id_lng; ?></td>
<?php
	$nb_frn_srv = ftc_ass(select("COUNT(id) as total","dev_srv","id_frn>0 AND id_prs",$id_dev_prs));
	if($dt_prs['res']==1 or $dt_prs['res']==-1 or $nb_frn_srv['total']>0 or $cnf<1){
?>
				<td class="stl1"><?php echo $txt->frn->$id_lng; ?></td>
<?php
	}
?>
				<td class="stl1"><?php echo $txt->res->$id_lng; ?></td>
<?php
	if($dt_prs['res']==1 or $nb_pay_srv['total']>0){
?>
				<td class="stl1"><?php echo $txt->pay->$id_lng; ?></td>
<?php
	}
?>
				<td></td>
<?php
	if($cnf<1){
?>
				<td class="stl1"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->min->$id_lng; ?></td>
				<td class="stl1"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->max->$id_lng; ?></td>
<?php
	}
?>
				<td class="stl1"><?php echo $txt->frs->$id_lng; ?></td>
				<td class="stl1"><?php echo $txt->bss->$id_lng.':'; ?></td>
<?php
				if(isset($bss)){
					foreach($bss as $id_bss => $base){
						if(($cnf>0 and $vue_bss[$id_bss]==1)or $cnf<1){
							if($ty_mrq==2){
			?>
							<td class="stl1"><?php echo $base; if($ptl){echo '+1';} echo '<br/>'.$txt->rack->$id_lng; ?></td>
			<?php
							}
			?>
							<td class="stl1"><?php echo $base; if($ptl){echo '+1';} echo '<br/>'.$txt->net->$id_lng; ?></td>
			<?php
							if($ty_mrq==2){
			?>
							<td class="stl1"><?php echo $txt->com->$id_lng.'<br/>'.$base; if($ptl){echo '+1';} ?></td>
			<?php
							}
						}
					}
				}
?>
			</tr>
<?php
	$rq_srv = select("*","dev_srv","id_prs",$id_dev_prs,"opt DESC,ctg,id_vll,nom");
	while($dt_srv = ftc_ass($rq_srv)){
		$id_dev_srv = $dt_srv['id'];
		$id_cat_srv = $dt_srv['id_cat'];
		$opt_srv = $dt_srv['opt'];
		$nom_srv = $dt_srv['nom'];
		$id_ctg_srv = $dt_srv['ctg'];
		$id_vll = $dt_srv['id_vll'];
		$id_crr_srv = $dt_srv['crr'];
		$tx_srv = $dt_srv['taux'];
		include("vue_srv.php");
		unset($id_ctg_srv,$id_vll);
	}
?>
		</table>
<?php
}
if($nb_srv['total']!=0 and $nb_hbr['total']!=0){
?>
	<hr/>
<?php
}
$vll_srv = 0;
unset($id_cat_hbr,$id_cat_chm);
if($nb_hbr['total']!=0){
?>
		<table class="dsg w-100">
			<tr>
				<td style="font-weight: bold;" colspan="3"><?php echo $txt->hbr->$id_lng.':'; ?></td>
				<td class="stl1"><?php echo $txt->room->$id_lng; ?></td>
				<td class="stl1"><?php echo $txt->frs->$id_lng; ?></td>
				<td class="stl1"><?php echo $txt->crr->$id_lng.':'; ?></td>
<?php
	if($ty_mrq==2){
?>
				<td class="stl1"><?php echo $txt->dbl->$id_lng.'<br/>'.$txt->rack->$id_lng; ?></td>
<?php
	}
?>
				<td class="stl1"><?php echo $txt->dbl->$id_lng.'<br/>'.$txt->net->$id_lng; ?></td>
<?php
	if($ty_mrq==2){
?>
				<td class="stl1"><?php echo $txt->com->$id_lng.'<br/>'.$txt->dbl->$id_lng; ?></td>
<?php
	}
	if($vue_sgl==1){
		if($ty_mrq==2){
?>
				<td class="stl1"><?php echo $txt->sgl->$id_lng.'<br/>'.$txt->rack->$id_lng; ?></td>
<?php
		}
?>
				<td class="stl1"><?php echo $txt->sgl->$id_lng.'<br/>'.$txt->net->$id_lng; ?></td>
<?php
		if($ty_mrq==2){
?>
				<td class="stl1"><?php echo $txt->com->$id_lng.'<br/>'.$txt->sgl->$id_lng; ?></td>
<?php
		}
	}
	if($vue_tpl==1){
		if($ty_mrq==2){
?>
				<td class="stl1"><?php echo $txt->tpl->$id_lng.'<br/>'.$txt->rack->$id_lng; ?></td>
<?php
		}
?>
				<td class="stl1"><?php echo $txt->tpl->$id_lng.'<br/>'.$txt->net->$id_lng; ?></td>
<?php
		if($ty_mrq==2){
?>
				<td class="stl1"><?php echo $txt->com->$id_lng.'<br/>'.$txt->tpl->$id_lng; ?></td>
<?php
		}
	}
	if($vue_qdp==1){
		if($ty_mrq==2){
?>
				<td class="stl1"><?php echo $txt->qdp->$id_lng.'<br/>'.$txt->rack->$id_lng; ?></td>
<?php
		}
?>
				<td class="stl1"><?php echo $txt->qdp->$id_lng.'<br/>'.$txt->net->$id_lng; ?></td>
<?php
		if($ty_mrq==2){
?>
				<td class="stl1"><?php echo $txt->com->$id_lng.'<br/>'.$txt->qdp->$id_lng; ?></td>
<?php
		}
	}
	if($cnf<1){
?>
				<td class="stl1"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->min->$id_lng; ?></td>
				<td class="stl1"><?php echo $txt->fecha->$id_lng.'<br/>'.$txt->max->$id_lng; ?></td>
<?php
		}
?>
				<td class="stl1"><?php echo $txt->trfopt->$id_lng; ?></td>
<?php
	if($cnf>0){
?>
				<td class="stl1"><?php echo $txt->resas->$id_lng; ?></td>
<?php
	}
?>
				<td class="stl1"><?php echo $txt->res->$id_lng; ?></td>
<?php
	if($cnf>0 or $nb_pay_hbr['total']>0){
?>
				<td class="stl1"><?php echo $txt->pay->$id_lng; ?></td>
<?php
	}
?>
			</tr>
<?php
	$rq_hbr = select("*","dev_hbr","id_prs",$id_dev_prs,"sel DESC, opt DESC,nom");
	while($dt_hbr = ftc_ass($rq_hbr)){
		$id_dev_hbr = $dt_hbr['id'];
		$id_cat_hbr = $dt_hbr['id_cat'];
		$id_cat_chm = $dt_hbr['id_cat_chm'];
		$opt_hbr = $dt_hbr['opt'];
		$sel_hbr = $dt_hbr['sel'];
		$id_vll = $dt_hbr['id_vll'];
		$id_rgm = $dt_hbr['rgm'];
		$est_chm = $dt_hbr['est_chm'];
		$est_rgm = $dt_hbr['est_rgm'];
		$id_crr_chm = $dt_hbr['crr_chm'];
		$id_crr_rgm = $dt_hbr['crr_rgm'];
		$tx_chm = $dt_hbr['taux_chm'];
		$tx_rgm = $dt_hbr['taux_rgm'];
		include("vue_hbr.php");
		if($id_cat_hbr != 0){$vll_srv = $id_vll;}
	}
?>
		</table>
<?php
}
if($nb_srv['total']!=0 or $nb_hbr['total']!=0){
?>
	</div>
<?php
}
?>
</div>
