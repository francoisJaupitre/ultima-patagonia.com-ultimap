<?php
if(isset($_POST['id']) and $_POST['id']>0 and isset($_POST['cbl']) and !empty($_POST['cbl']) and isset($_POST['id_lgg']) and $_POST['id_lgg']>=0){
	$cbl = $_POST['cbl'];
	$id = $_POST['id'];
	$lgg_id = $_POST['id_lgg'];
	$txt = simplexml_load_file('../resources/xml/mainTxt.xml');
	$txt_prg = simplexml_load_file('txt_prg.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$wdt_img = 230;
	$hl = 12.4;
	include("prg.php");
	include("trf.php");
}
include("../cfg/crr.php");
include("ttr.php");
if($cbl=='dev' and $vrs>1){$ttr .= "_V".$vrs;}

$html = '<head><link rel="stylesheet" type="text/css" href="forme.css?version='.date('Y-m-d-H-i-s', filemtime('forme.css')).'" /><link rel="stylesheet" type="text/css" href="../prm/forme.css?version='.date('Y-m-d-H-i-s', filemtime('../prm/forme.css')).'" /><link rel="stylesheet" type="text/css" href="../prm/css/'.$dir.'/tmpl'.$clt_tmpl[$id_clt].'.css?version='.date('Y-m-d-H-i-s', filemtime('../prm/css/'.$dir.'/tmpl'.$clt_tmpl[$id_clt].'.css')).'" /></head><body>';
if(!$clt_tmpl[$id_clt]){$html .= '<footer><table style="border-top: 1px solid black; width: 100%"><tr><td><img src="../prm/img/'.$dir.'/logo2.jpg" style="width: 190px;"/></td><td class="w-100"><div class="fs1">'.$txt_prg->footer1.'</div><div class="fs1">'.$txt_prg->footer2.'</div></td></tr></table></footer>';}
?>
<div class="pge">
<?php
ob_start();
if($clt_tmpl[$id_clt]==1){
	$tx_clt = $dt_crc['tx_clt'];
	$dt_pax = ftc_ass(sel_quo("nom,pre","grp_pax","id_grp",$id_grp,"ord LIMIT 1"));
	if(!empty($dt_pax['nom'])){
		$nom_pax = $dt_pax['nom'];
		$pre_pax = $dt_pax['pre'];
	}
	else{$nom_pax = $nomgrp;}
	$nom_clt = str_replace(" ","_",$clt[$id_clt]);
	$txt_clt = simplexml_load_file('../prm/txt/'.$dir.'/'.$nom_clt.'.xml');
	$ext_img = array("jpg","jpg","jpg","jpg");
	$wdts_img = array(798,143,300,589);
	$n_img = 0;
?>
	<div class="break-after">
		<div class="div0 bg-black">
			<img src="<?php echo '../prm/img/'.$dir.'/'.$nom_clt.$n_img.'.'.$ext_img[$n_img] ?>" width="<?php echo $wdts_img[$n_img];$n_img++; ?>"/>
		 	<div class="text-white h1">
				<div class="title1">
					<span class="sp0"><?php echo $txt_clt->txt0->$id_lgg; ?></span>
				</div>
			</div>
		</div>
		<div>
			<table class="m-auto tb0">
				<tr>
					<td class="td0">
						<table class="tb1">
							<tr><td class="text-center td1"><?php echo $txt_clt->txt1->$id_lgg; ?></td></tr>
							<tr>
								<td class="td2">
									<ul>
										<li><strong><?php echo $txt_clt->txt2->$id_lgg; ?></strong><?php echo $nom_pax; ?></li>
										<li><strong><?php echo $txt_clt->txt3->$id_lgg; ?></strong><?php if(isset($pre_pax)) {echo $pre_pax;} ?></li>
										<li><strong><?php echo $txt_clt->txt4->$id_lgg; ?></strong><?php if(isset($date_arri)) {echo $date_arri;} ?></li>
										<li><strong><?php echo $txt_clt->txt5->$id_lgg; ?></strong><?php if(isset($date_retour)) {echo $date_retour;} ?></li>
										<li><strong><?php echo $txt_clt->txt6->$id_lgg; ?></strong><?php if(isset($bss[0])) {echo max($bss[0]);} ?></li>
									</ul>
								</td>
							</tr>
						</table>
					</td>
					<td class="td3"><img src="<?php echo '../prm/img/'.$dir.'/'.$nom_clt.$n_img.'.'.$ext_img[$n_img] ?>" width="<?php echo $wdts_img[$n_img];$n_img++ ?>"/></td>
				</tr>
			</table>
		</div>
<?php
	$html .= ob_get_contents();
	ob_end_flush();
?>
	</div>
</div>
<div class="pge">
<?php
	$html .= '<div class="footer text-center"><p>'.$txt_clt->txt7->$id_lgg.'</p></div></div>';
	$html .= '<div class="header"><img src="../prm/img/'.$dir.'/'.$nom_clt.$n_img.'.'.$ext_img[$n_img].'" width="'.$wdts_img[$n_img].'"/><span>'.$txt_clt->txt8->$id_lgg.'</span></div>';
	$n_img++;
	ob_start();
?>
	<div class="div2 bg-black">
		<div class="text-white h2">
			<div class="div3">
				<span class="sp0"><?php echo $txt_clt->txt9->$id_lgg; ?></span>
			</div>
		</div>
	</div>
	<div class="div4">
<?php
}
elseif(!$clt_tmpl[$id_clt]){
?>
	<div class="div0 bg-blue">
		<img src="<?php echo '../prm/img/'.$dir.'/bandeau1.jpg' ?>" width="800"/>
		<table class="w-100">
			<tr>
				<td><div class="title1 wsn"><?php echo $txt_prg->bandeau->$id_lgg ?></div></td>
				<td>
					<div class="title1"><?php echo stripslashes(trim($txt_crc[1])) ?></div>
					<div class="div2"><?php echo stripslashes(trim($txt_crc[2])) ?></div>
				</td>
			</tr>
		</table>
	</div>
	<br />
	<div class="div3">
<?php
}
if(!empty($cbl!='mdl' and $txt_crc[3])){
?>
		<div class="fs4"><?php echo stripslashes(trim($txt_crc[3])) ?></div>
		<br />
<?php
}
elseif($cbl=='mdl' and !empty($txt_mdl[2][$id])){
	?>
			<div class="fs4"><?php echo stripslashes(trim($txt_mdl[2])) ?></div>
			<br />
	<?php
	}
?>
		<br />
<?php
if(isset($lst_mdl['id'])){
	foreach($lst_mdl['id'] as $id_mdl){
		$id_col = $lst_mdl['col'][$id_mdl];
?>
		<div style="page-break-inside: avoid">
<?php
		if($cbl !='mdl' and !empty($txt_mdl[1][$id_mdl])){
?>
			<div class="fs_mdl" style="color:#<?php echo $col[$id_col] ?>;"><?php echo stripslashes(trim($txt_mdl[1][$id_mdl])) ?></div>
			<br />
<?php
		}
		if(!empty($txt_mdl[2][$id_mdl])){
?>
			<div class="fs4"><?php echo stripslashes(trim($txt_mdl[2][$id_mdl])) ?></div>
			<br />
<?php
		}
?>
		</div>
<?php
		if(isset($lst_jrn[$id_mdl]['id'])){
			foreach($lst_jrn[$id_mdl]['id'] as $id_jrn){
?>
		<div style="page-break-inside: avoid">
			<div class="fs_jrn" style="color:#<?php echo $col[$id_col] ?>;"><?php echo mb_strtoupper(stripslashes(trim($txt_jrn[1][$id_jrn]))) ?></div>
			<div class="fs_jrn" style="color:#<?php echo $col[$id_col] ?>;"><?php echo mb_strtoupper(stripslashes(trim($txt_jrn[2][$id_jrn]))) ?></div>
			<br />
<?php
				$flg_cmp = true;
				if($flg_img[$id_jrn]){
?>
			<table>
				<tr>
					<td class="vat">
<?php
					if(isset($txt_jrn[3][$id_jrn])){
?>
						<div class="fs6"><?php foreach($txt_jrn[3][$id_jrn] as $dsc_jrn){echo stripslashes(nl2br(trim($dsc_jrn)));} ?></div>
						<br />
<?php
					}
					if(isset($txt_jrn[4][$id_jrn])){
?>
						<div class="fs6">
<?php
						$dsc = explode('<br />',nl2br($txt_jrn[4][$id_jrn]));
						foreach($dsc as $dsc_jrn){echo stripslashes(trim($dsc_jrn)).'<br/>';}
?>
						</div>
						<br/>
<?php
					}
					if(isset($txt_jrn[5][$id_jrn])){
?>
						<div style="page-break-inside: avoid">
<?php

						if($flg_cmp){
							$flg_cmp = false;
?>
							<div class="fs11"><?php echo $txt_prg->inc->$id_lgg.':' ?></div>
<?php
						}
						foreach($txt_jrn[5][$id_jrn] as $i => $dsc_prs){
							if(!empty($dsc_prs)){
								$prs = explode('<br />',nl2br(preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;",$dsc_prs)));
?>
							<div class="fs7"><?php foreach($prs as $lgn){echo stripslashes(trim($lgn)).'<br/>';} ?></div>
<?php
							}
						}
?>
						</div>
<?php
					}
					if(isset($txt_jrn[6][$id_jrn])){
?>
						<div style="page-break-inside: avoid">
<?php
						if($flg_cmp){
							$flg_cmp = false;
?>
							<div class="fs11"><?php echo $txt_prg->inc->$id_lgg.':' ?></div>
<?php
						}
?>
							<div class="fs7"><?php foreach($txt_jrn[6][$id_jrn] as $dsc_prs){echo stripslashes(nl2br(preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;",trim($dsc_prs)))).'<br/>';} ?></div>
						</div>
<?php
					}
?>
					</td>
					<td style="vertical-align: top; text-align: right;">
						<div style="text-align: right; padding-left: 20px;">
<?php
					if(isset($pic[$id_jrn])) {
						foreach($pic[$id_jrn] as $i => $foto){
?>
								<img src="<?php echo '../pic/'.$dir.'/'.$foto; ?>" width="<?php echo $style_pic[$id_jrn][$i]['width'] ?>" height="<?php echo $style_pic[$id_jrn][$i]['height'] ?>" />
<?php
						}
					}
?>
						</div>
					</td>
				</tr>
			</table>
<?php
				}
				else{
					if(isset($txt_jrn[3][$id_jrn])){
?>
			<div class="fs6"><?php foreach($txt_jrn[3][$id_jrn] as $dsc_jrn){echo stripslashes(trim($dsc_jrn));} ?></div>
			<br />
<?php
					}
					if(isset($txt_jrn[4][$id_jrn])){
?>
			<div class="fs6">
<?php
						$dsc = explode('<br />',nl2br($txt_jrn[4][$id_jrn]));
						foreach($dsc as $dsc_jrn){echo stripslashes(trim($dsc_jrn)).'<br/>';}
?>
			</div>
<?php
					}
				}
?>
		</div>
<?php
				if(isset($txt_jrn[7][$id_jrn])){echo '<br/>';}
				if(isset($txt_jrn[8][$id_jrn])){
?>
		<div style="page-break-inside: avoid">
<?php
					if($flg_cmp){
						$flg_cmp = false;
?>
				<div class="fs11"><?php echo $txt_prg->inc->$id_lgg.':' ?></div>
<?php
					}
					foreach($txt_jrn[8][$id_jrn] as $i => $dsc_prs){
						if(!empty($dsc_prs)){
							$prs = explode('<br />',nl2br(preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;",$dsc_prs)));
?>
				<div class="fs7"><?php foreach($prs as $lgn){echo stripslashes(trim($lgn)).'<br/>';} ?></div>
<?php
						}
					}
?>
			</div>
<?php
				}
				if(isset($txt_jrn[9][$id_jrn])){
?>
			<div style="page-break-inside: avoid">
<?php
					if($flg_cmp){
						$flg_cmp = false;
?>
				<div class="fs11"><?php echo $txt_prg->inc->$id_lgg.':' ?></div>
<?php
					}
?>
				<div class="fs7"><?php foreach($txt_jrn[9][$id_jrn] as $dsc_prs){echo stripslashes(nl2br(preg_replace("/\\\\u([0-9A-F]{2,5})/i", "&#x$1;",trim($dsc_prs)))).'<br/>';} ?></div>
			</div>
<?php
				}
				if(!$flg_cmp){echo '<br/>';}
				echo '<br/>';
			}
		}
	}
}
//if($clt_tmpl[$id_clt]==1){
?>
	</div>
<?php
//}
//TARIFS
if($cbl=='dev'){
	$html .= ob_get_contents();
	ob_end_flush();
?>
</div>
<br />
<div class="pge">
<?php
	ob_start();
?>
	<div style="page-break-before: always;">
<?php
	if($clt_tmpl[$id_clt]==1) {
?>
		<div class="div2 bg-black">
			<div class="text-white h2">
				<div class="div3">
					<span class="sp0">VOTRE BUDGET</span>
				</div>
			</div>
		</div>
		<div class="div4">
<?php
	}
	elseif(!$clt_tmpl[$id_clt]) {echo '<div class="div3"><div class="fs8">'.stripslashes($txt_prg->trf->$id_lgg.' '.$prm_crr_ttr[$id_lgg][$dt_crc['crr']].' '.$txt_prg->pers->$id_lgg).'</div><br />';}
	if($vue_trf) {
		$multiBss = array();
		foreach ($bss as $id_trf => $value)
		{
			if(count($value)>1)
			{
				$flagMultiBss = true;
				break;
			}
			$multiBss[] = $value[0];
			if(count(array_unique($multiBss))>1)
			{
				$flagMultiBss = true;
				break;
			}
		}
		$flg_trf_crc = true;
		$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id,"ord");
		while($dt_mdl = ftc_ass($rq_mdl)){
			if($dt_mdl['trf']){
			  $id_trf = $dt_mdl['id'];
			  $vue_sgl = $dt_mdl['vue_sgl'];
			  $vue_dbl = $dt_mdl['vue_dbl'];
			  $vue_tpl = $dt_mdl['vue_tpl'];
			  $vue_qdp = $dt_mdl['vue_qdp'];
			  $ptl = $dt_mdl['ptl'];
			  $psg = $dt_mdl['psg'];
			}
			else{
			  $id_trf = 0;
			  $vue_sgl = $dt_crc['vue_sgl'];
			  $vue_dbl = $dt_crc['vue_dbl'];
			  $vue_tpl = $dt_crc['vue_tpl'];
			  $vue_qdp = $dt_crc['vue_qdp'];
			  $ptl = $dt_crc['ptl'];
			  $psg = $dt_crc['psg'];
			}
			if($id_trf or $flg_trf_crc){
				$id_col = $dt_mdl['col'];
				if($id_trf) {
?>
			<span class="fs_mdl1" style="color:#<?php echo $col[$id_col]; ?>"><?php if(empty($dt_mdl['titre'])) {echo stripslashes($txt_prg->mdl->$id_lgg).' '.$dt_mdl['ord'];} else{echo mb_strtoupper(stripslashes(trim($dt_mdl['titre'])));} ?></span>
<?php
				}
				elseif($flg_trf_crc)
				{
					if(count(array_unique($lst_mdl['trf'])) >1) {
?>
			<span class="fs13"><?php if($vols_dom) {echo stripslashes($txt_prg->crc2->$id_lgg);} else {echo stripslashes($txt_prg->crc1->$id_lgg);} ?></span>
<?php
					}
					$flg_trf_crc = false;
				}

				if(isset($err_hbr_jrn[$id_trf])){
					foreach(array_unique($err_hbr_jrn[$id_trf]) as $jrn){
						if($err_hbr_def[$id_trf][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_def->$id_lng.$jrn.'</span><br/>';}
						if($err_hbr_db[$id_trf][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_db->$id_lng.$jrn.'</span><br/>';}
						if($err_hbr_sel[$id_trf][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_sel->$id_lng.$jrn.'</span><br/>';}
						if($err_hbr_dup[$id_trf][$jrn]){echo '<span class="color-red">'.$txt->err->hbr_dup->$id_lng.$jrn.'</span><br/>';}
						if($err_hbr_sg[$id_trf][$jrn] and $vue_sgl){echo '<span class="color-red">'.$txt->err->hbr_sg->$id_lng.$jrn.'</span><br/>';}
						if($err_hbr_tp[$id_trf][$jrn] and $vue_tpl){echo '<span class="color-red">'.$txt->err->hbr_tp->$id_lng.$jrn.'</span><br/>';}
						if($err_hbr_qd[$id_trf][$jrn] and $vue_qdp){echo '<span class="color-red">'.$txt->err->hbr_qd->$id_lng.$jrn.'</span><br/>';}
					}
				}
?>
			<table>
<?php
				if(isset($bss[$id_trf])){
					foreach($bss[$id_trf] as $i => $base){
						if(isset($trf_db_hbr[$id_trf])) {$prx = $trf_srv[$id_trf][$i]+$trf_db_hbr[$id_trf]/2;}
						elseif(isset($trf_srv[$id_trf][$i])){$prx = $trf_srv[$id_trf][$i];}
						else{$prx = 0;}
						if($ptl){$prx += $cst_db_hbr[$id_trf]/(2*$base);}
						if($psg){$prx += ($cst_sg_hbr[$id_trf]-$cst_db_hbr[$id_trf]/2)/$base;}
?>
				<tr>
<?php
						if(!$clt_tmpl[$id_clt] or $flagMultiBss or $vue_sgl or $vue_tpl or $vue_qdp)
						{
?>
					<td style="padding: 0px 5px;" class="fs6">
<?php
							echo $txt_prg->base->$id_lng.' '.$base;
							if($ptl){echo '&#43;1';}
							echo ' :';
?>
					</td>
<?php
						}
						if($clt_tmpl[$id_clt]==1) {
							$prx2 = $prx / $tx_clt;
?>
					<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx2,0,',',' '); ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[2].$txt_prg->pers2->$id_lgg; ?></td>
<?php
						}
?>
					<td style="padding: 0px 5px;" class="fs6"><?php if($clt_tmpl[$id_clt]==1) {echo '( eq. ';} ?><span class="fs9"><?php echo number_format($prx,0,',',' '); ?></span></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; if($clt_tmpl[$id_clt]==1) {echo ')';} ?></td>
					<td style="padding: 0px 5px;" class="fs6">
<?php
						if($err_trf_srv[$id_trf][$i]){echo '<span class="color-red">'.$txt->err->srv_jrn->$id_lng.' '.$txt->jours->$id_lng.' : '.$err_srv_jrn[$id_trf][$i].'</span>';}
?>
					</td>
				</tr>
<?php
					}
				}
				if($vue_sgl==1){
					$prx = $trf_sg_hbr[$id_trf]-$trf_db_hbr[$id_trf]/2;
?>
				<tr>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->sup_sgl->$id_lgg.' :'; ?></td>
<?php
					if($clt_tmpl[$id_clt]==1) {
						$prx2 = $prx / $tx_clt;
?>
					<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx2,0,',',' '); ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[2].$txt_prg->pers2->$id_lgg; ?></td>
<?php
					}
?>
					<td style="padding: 0px 5px;" class="fs6"><?php if($clt_tmpl[$id_clt]==1) {echo '( eq. ';} ?><span class="fs9"><?php echo number_format($prx,0,',',' '); ?></span></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; if($clt_tmpl[$id_clt]==1) {echo ')';} ?></td>
				</tr>
<?php
				}
				if($vue_tpl==1){
					$prx = $trf_db_hbr[$id_trf]/2-$trf_tp_hbr[$id_trf]/3;
?>
				<tr>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->red_tpl->$id_lgg.' :' ?></td>
<?php
					if($clt_tmpl[$id_clt]==1) {
						$prx2 = $prx / $tx_clt;
?>
					<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx2,0,',',' '); ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[2].$txt_prg->pers2->$id_lgg; ?></td>
<?php
					}
?>
					<td style="padding: 0px 5px;" class="fs6"><?php if($clt_tmpl[$id_clt]==1) {echo '( eq. ';} ?><span class="fs9"><?php echo number_format($prx,0,',',' '); ?></span></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; if($clt_tmpl[$id_clt]==1) {echo ')';} ?></td>
				</tr>
<?php
				}
				if($vue_qdp==1){
					$prx = $trf_db_hbr[$id_trf]/2-$trf_qd_hbr[$id_trf]/4;
?>
				<tr>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->red_qdp->$id_lgg.' :' ?></td>
<?php
					if($clt_tmpl[$id_clt]==1) {
						$prx2 = $prx / $tx_clt;
?>
					<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx2,0,',',' '); ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[2].$txt_prg->pers2->$id_lgg; ?></td>
<?php
					}
?>
					<td style="padding: 0px 5px;" class="fs6"><?php if($clt_tmpl[$id_clt]==1) {echo '( eq. ';} ?><span class="fs9"><?php echo number_format($prx,0,',',' '); ?></span></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; if($clt_tmpl[$id_clt]==1) {echo ')';} ?></td>
				</tr>
<?php
				}
?>
			</table>
<?php
				if($psg){
?>
			<span class="fs12"><?php echo $txt_prg->trf_psg->$id_lgg; ?></span><br/>
<?php
				}
				elseif($ptl){
?>
			<span class="fs12"><?php echo $txt_prg->trf_ptl->$id_lgg; ?></span><br/>
<?php
				}
?>
			<br/>
<?php
			}
		}
?>
			<span class="fs12">
<?php
		if(!$vols_dom){echo $txt_prg->trf_dbl->$id_lgg.' '.$txt_prg->trf_dbl1->$id_lgg;}
		else{echo $txt_prg->trf_dbl->$id_lgg.' '.$txt_prg->trf_dbl2->$id_lgg;}
?>
			</span>
			<br/>
<?php
		if($clt_tmpl[$id_clt]==1) {
?>
			<div class="fs6">Le budget peut varier selon le nombre de participants, la saison, la personnalisation des prestations et la variation du taux de change.</div>
<?php
		}
?>
			<br/><br/>
<?php
		if($clt_tmpl[$id_clt]==1 and $vue_opt and (isset($opt_srv_id) or isset($opt_prs_id))){include("vue_dt_prg_trf_opt.php");}
	//VOLS DOMESTIQUES
		if($vue_vols and isset($vol_id)){
			$t=0;
?>
			<span class="fs13"><?php echo $txt_prg->lst_vol->$id_lgg; ?></span>
			<br /><br />
			<table>
<?php
			foreach($vol_id as $id_vol){
				if(strpos($id_vol, '_')){
					$id_v1 = intval(strstr($id_vol, '_',true));
					$pos = strpos($id_vol, '_');
					$id_v2 = intval(substr($id_vol, $pos+1));
					$msg_vol = "";
					if($id_v1>0){$msg_vol = $vll[$id_v1];}
					$msg_vol .= " - ";
					if($id_v2>0){$msg_vol .= $vll[$id_v2].' :';}
					$dt_vol = ftc_ass(sel_quo("id,trf,cpp","dev_vol",array("id_crc","id_v1","id_v2"),array($id,$id_v1,$id_v2)));
?>
				<tr>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $msg_vol ?></td>
<?php
					if($dt_vol['trf']>0){
						if($clt_tmpl[$id_clt]==1) {
							$prx2 = $dt_vol['trf'] / $tx_clt;
?>
					<td style="padding: 0px 5px;" class="fs6"><?php echo number_format($prx2,0,',',' '); ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[2].$txt_prg->pers2->$id_lgg; ?></td>
<?php
						}
?>
					<td style="padding: 0px 5px;" class="fs6" id="<?php echo 'X'.$id_vol ?>"><?php if($clt_tmpl[$id_clt]==1) {echo '( eq. ';} ?><span class="fs6"><?php if($dt_vol['trf']){echo number_format($dt_vol['trf'],0,',',' ');} elseif(!$dt_vol['id']){echo 'X';}  ?></span></td>
					<td style="padding: 0px 5px;" class="fs6" id="<?php echo 'C'.$id_vol ?>"><?php if($dt_vol['id']){echo $dt_vol['cpp'];} else{echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;} if($clt_tmpl[$id_clt]==1) {echo ')';} ?></td>
<?php
					}
?>
				</tr>
<?php
					$t++;
				}
			}
			if($t>1){
				$dt_vol = ftc_ass(sel_quo("id,trf","dev_vol",array("id_crc","id_v1","id_v2"),array($id,0,0)));
?>
				<tr>
					<td style="padding: 0px 5px;" class="fs6">TOTAL :</td>
<?php
				if($clt_tmpl[$id_clt]==1) {
					$prx2 = $dt_vol['trf'] / $tx_clt;
?>
					<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx2,0,',',' '); ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[2].$txt_prg->pers2->$id_lgg; ?></td>
<?php
				}
?>
					<td style="padding: 0px 5px;" class="fs6" id="totvol"><?php if($clt_tmpl[$id_clt]==1) {echo '( eq. ';} ?><span class="fs9"><?php if($dt_vol['trf']){echo number_format($dt_vol['trf'],0,',',' ');} elseif(!$dt_vol['id']){echo 'X';}  ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></span><?php if($clt_tmpl[$id_clt]==1) {echo ')';} ?></td>
				</tr>
<?php
			}
?>
			</table>
			<br />
			<span class="fs12"><?php echo $txt_prg->trf_est->$id_lgg; ?></span>
			<br/><br/><br/><br/>
<?php
		}
	}
	if($dt_crc['total']){
?>
			<span class="fs13"><?php echo $txt_prg->total->$id_lgg; ?></span>
			<br /><br />
			<table>
				<tr>
<?php
				if($clt_tmpl[$id_clt]==1) {
					$prx2 = $dt_crc['total'] / $tx_clt;
?>
					<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx2,0,',',' '); ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[2]; ?></td>
<?php
				}
				if($clt_tmpl[$id_clt]==1) {
?>
					<td style="padding: 0px 5px;" class="fs6"><?php echo '( eq. '; ?></td>
<?php
				}
?>
					<td style="padding: 0px 5px;" class="fs9" id="total"><?php echo number_format($dt_crc['total'],0,',',' ');  ?></td>
					<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']]; ?></td>
<?php
				if($clt_tmpl[$id_clt]==1) {
?>
					<td style="padding: 0px 5px;" class="fs6"><?php echo ')'; ?></td>
<?php
				}
?>
				</tr>

			</table>
			<br/><br/><br/>
<?php
	}
	if(!$clt_tmpl[$id_clt] and isset($hbr_id)) {
?>
			<span class="fs13"><?php echo $txt_prg->lst_hbr->$id_lgg ?></span>
<?php
		include("vue_dt_prg_lst_hbr.php");
		if($saut_apr){
?>
		</div>
<?php
			$html .= ob_get_contents();
			ob_end_flush();
?>
	</div>
	<br />
	<div class="pge">
<?php
			ob_start();
?>
		<div style="page-break-before: always;">
<?php
		}
	}
	if($vue_opt){
		if(isset($opt_hbr_id)){
?>
		<span class="fs13"><?php echo $txt_prg->hbr_opt->$id_lgg; ?></span>
		<br/>
		<table class="ts2">
			<tr>
				<td class="cs6"><?php echo upnoac($txt_prg->jours->$id_lgg); ?></td>
				<td class="cs6"><?php echo $txt_prg->vll->$id_lgg; ?></td>
				<td class="cs6"><?php echo $txt_prg->ctg->$id_lgg; ?></td>
				<td class="cs6"><?php echo $txt_prg->hbr->$id_lgg; ?></td>
				<td class="cs6"><?php echo $txt_prg->chm->$id_lgg; ?></td>
				<td class="cs6"><?php echo $txt_prg->sup->$id_lgg ?></td>
			</tr>
<?php
			$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id,"ord");
			while($dt_mdl = ftc_ass($rq_mdl)){
				if($dt_mdl['trf']){
				  $id_trf = $dt_mdl['id'];
				  $vue_sgl = $dt_mdl['vue_sgl'];
				  $vue_dbl = $dt_mdl['vue_dbl'];
				  $vue_tpl = $dt_mdl['vue_tpl'];
				  $vue_qdp = $dt_mdl['vue_qdp'];
				  $ptl = $dt_mdl['ptl'];
				  $psg = $dt_mdl['psg'];
				}
				else{
				  $id_trf = 0;
				  $vue_sgl = $dt_crc['vue_sgl'];
				  $vue_dbl = $dt_crc['vue_dbl'];
				  $vue_tpl = $dt_crc['vue_tpl'];
				  $vue_qdp = $dt_crc['vue_qdp'];
				  $ptl = $dt_crc['ptl'];
				  $psg = $dt_crc['psg'];
				}
				$id_dev_mdl=$dt_mdl['id'];
				if(isset($opt_hbr_id[$id_dev_mdl])){
					foreach($opt_hbr_id[$id_dev_mdl] as $j => $id_hbr){
						$flg_tab = true;
						if(isset($tab_opt_hbr_id[$id_dev_mdl])){
							foreach($tab_opt_hbr_id[$id_dev_mdl] as $i => $id_hbr_tab){
								if($id_hbr==$id_hbr_tab and $opt_chm_id[$id_dev_mdl][$j]==$tab_opt_chm_id[$id_dev_mdl][$i]){$flg_tab=false;}
							}
						}
						if($flg_tab){
							$tab_opt_hbr_id[$id_dev_mdl][] = $id_hbr;
							$tab_opt_chm_id[$id_dev_mdl][] = $opt_chm_id[$id_dev_mdl][$j];
						}
					}
					foreach($tab_opt_hbr_id[$id_dev_mdl] as $i => $id_hbr_tab){
						foreach($opt_hbr_id[$id_dev_mdl] as $j => $id_hbr){
							if($id_hbr==$id_hbr_tab and $opt_chm_id[$id_dev_mdl][$j]==$tab_opt_chm_id[$id_dev_mdl][$i]){
								$tab_trf_opt_hbr_db[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$trf_opt_hbr_db[$id_dev_mdl][$j];
								$tab_opt_hbr_jrn[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$opt_hbr_jrn[$id_dev_mdl][$j];
								$tab_err_trf_db_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$err_trf_db_opt_hbr[$id_dev_mdl][$j];
								$tab_opt_hbr_vll[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$opt_hbr_vll[$id_dev_mdl][$j];
								$tab_trf_opt_hbr_sg[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$trf_opt_hbr_sg[$id_dev_mdl][$j];
								$tab_err_trf_sg_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$err_trf_sg_opt_hbr[$id_dev_mdl][$j];
								$tab_trf_opt_hbr_tp[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$trf_opt_hbr_tp[$id_dev_mdl][$j];
								$tab_err_trf_tp_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$err_trf_tp_opt_hbr[$id_dev_mdl][$j];
								$tab_trf_opt_hbr_qd[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$trf_opt_hbr_qd[$id_dev_mdl][$j];
								$tab_err_trf_qd_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$err_trf_qd_opt_hbr[$id_dev_mdl][$j];
							}
						}
					}
					if(isset($tab_opt_hbr_id[$id_dev_mdl])){
						foreach($tab_opt_hbr_id[$id_dev_mdl] as $i => $id_hbr_tab){
							$prx = 0;
							$jrn_opt = '';
							$err = 0;
							$flg_vrg = false;
							$prx_sg=0;
							$err_sg_opt=0;
							$prx_tp=0;
							$err_tp_opt=0;
							$prx_qd=0;
							$err_qd_opt=0;
							foreach($tab_trf_opt_hbr_db[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]] as $j => $prx_opt_hbr_db){
								$prx += $prx_opt_hbr_db/2;
								$prx_sg += $tab_trf_opt_hbr_sg[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
								$prx_tp += $tab_trf_opt_hbr_tp[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j]/3;
								$prx_qd += $tab_trf_opt_hbr_qd[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j]/4;

								if($flg_vrg){$jrn_opt .= ',';}
								if($tab_opt_hbr_jrn[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j]>0){
									$jrn_opt .= $tab_opt_hbr_jrn[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
									$flg_vrg = true; // mentionner early check in o late checkout!
								}
								$err = $tab_err_trf_db_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
								$err_sg_opt = $tab_err_trf_sg_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
								$err_tp_opt = $tab_err_trf_tp_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
								$err_qd_opt = $tab_err_trf_qd_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
								$vil = $tab_opt_hbr_vll[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
							}
							$tab_prx[$id_dev_mdl][$i] = $prx;
							$tab_jrn[$id_dev_mdl][$i] = $jrn_opt;
							$tab_err[$id_dev_mdl][$i] = $err;
							$tab_vil[$id_dev_mdl][$i] = $vil;
							$tab_sg_prx[$id_dev_mdl][$i] = $prx_sg;
							$tab_err_sg[$id_dev_mdl][$i] = $err_sg_opt;
							$tab_tp_prx[$id_dev_mdl][$i] = $prx_tp;
							$tab_err_tp[$id_dev_mdl][$i] = $err_tp_opt;
							$tab_qd_prx[$id_dev_mdl][$i] = $prx_qd;
							$tab_err_qd[$id_dev_mdl][$i] = $err_qd_opt;
						}
						foreach($tab_opt_hbr_id[$id_dev_mdl] as $i => $id_hbr_tab){
?>
				<tr>
					<td class="cs7"><?php echo $tab_jrn[$id_dev_mdl][$i]; ?></td>
<?php
							if($id_hbr_tab!=0){
								$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr_tab));
?>
					<td class="cs7"><?php echo stripslashes($vll[$dt_hbr['id_vll']]); ?></td>
					<td class="cs7"><?php echo stripslashes($ctg_hbr[$id_lng][$dt_hbr['ctg']]); ?></td>
					<td class="cs7">
<?php
								if(empty($dt_hbr['titre'])){echo stripslashes($dt_hbr['nom']);}
								elseif(!empty($dt_hbr['web'])){echo '<a href="'.$dt_hbr['web'].'" target="_blank">'.stripslashes($dt_hbr['titre']).'</a>';}
								else{echo stripslashes($dt_hbr['titre']);}
?>
					</td>
					<td class="cs7">
<?php
								if($tab_opt_chm_id[$id_dev_mdl][$i]!=0){
									$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$tab_opt_chm_id[$id_dev_mdl][$i]));
									if(!empty($dt_chm['titre'])){echo stripslashes($dt_chm['titre']);}
									else{echo stripslashes($dt_chm['nom']);}
								}
								else{echo $txt->err->chm->$id_lng;}
?>
					</td>
<?php
							}
							else{
?>
					<td class="cs7"><?php echo stripslashes($vll[$tab_vil[$id_dev_mdl][$i]]); ?></td>
					<td class="cs7"></td>
					<td class="cs7"><?php echo $txt->err->hbr->$id_lng; ?></td>
<?php
							}
?>
					<td class="cs7">
<?php
							if($vue_sgl==1){
								echo $txt_prg->sgl->$id_lgg.' : ';
								if($tab_err_sg[$id_dev_mdl][$i]==0){
									echo number_format($tab_sg_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;
								}
								else{echo $txt->err->trf->$id_lng;}
								echo '<br/>';
							}
							if($vue_dbl==1){
								echo $txt_prg->dbl->$id_lgg.' : ';
								if($tab_err[$id_dev_mdl][$i]==0){
									echo number_format($tab_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;
								}
								else{echo $txt->err->trf->$id_lng;}
								echo '<br/>';
							}
							if($vue_tpl==1){
								echo $txt_prg->tpl->$id_lgg.' : ';
								if($tab_err_tp[$id_dev_mdl][$i]==0){
									echo number_format($tab_tp_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;
								}
								else{echo $txt_prg->nd->$id_lgg;}
								echo '<br/>';
							}
							if($vue_qdp==1){
								echo $txt_prg->qdp->$id_lgg.' : ';
								if($tab_err_qd[$id_dev_mdl][$i]==0){
									echo number_format($tab_qd_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg;
								}
								else{echo $txt_prg->nd->$id_lgg;}
								echo '<br/>';
							}
?>
					</td>
				</tr>
<?php
						}
					}
				}
			}
?>
			</table>
			<br/><br/>
<?php
		}
		if(!$clt_tmpl[$id_clt] and (isset($opt_srv_id) or isset($opt_prs_id))) {include("vue_dt_prg_trf_opt.php");}
	}
	if(isset($sel_prs_id)){
?>
			<br/>
			<span class="fs5">
<?php
		if($vue_dt_trf){echo $txt_prg->dt_trf->$id_lgg;}
		elseif(!$clt_tmpl[$id_clt]) {echo $txt_prg->inc->$id_lgg;}
		elseif($clt_tmpl[$id_clt]==1) {echo 'Ce que le prix comprend';}
?>
			</span>
			<br/><br/>
<?php
		if($clt_tmpl[$id_clt]==1 and 1==0){
?>
			<div style="page-break-inside: avoid">
				<span class="fs6">Hébergements en chambre double.</span>
			</div>
			<br/>
<?php
		}
		$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id,"ord");
		while($dt_mdl = ftc_ass($rq_mdl)){
			if($dt_mdl['trf']){
			  $id_trf = $dt_mdl['id'];
			  $vue_sgl = $dt_mdl['vue_sgl'];
			  $vue_dbl = $dt_mdl['vue_dbl'];
			  $vue_tpl = $dt_mdl['vue_tpl'];
			  $vue_qdp = $dt_mdl['vue_qdp'];
			  $ptl = $dt_mdl['ptl'];
			  $psg = $dt_mdl['psg'];
			}
			else{
			  $id_trf = 0;
			  $vue_sgl = $dt_crc['vue_sgl'];
			  $vue_dbl = $dt_crc['vue_dbl'];
			  $vue_tpl = $dt_crc['vue_tpl'];
			  $vue_qdp = $dt_crc['vue_qdp'];
			  $ptl = $dt_crc['ptl'];
			  $psg = $dt_crc['psg'];
			}
			$id_dev_mdl=$dt_mdl['id'];
			$id_col = $dt_mdl['col'];
			if(isset($sel_prs_id[$id_dev_mdl])){
				foreach($sel_prs_id[$id_dev_mdl] as $i => $id_dev_prs){
					unset($id_cat_prs);
					$id_cat_prs = $sel_prs_id_cat[$id_dev_mdl][$id_dev_prs];
					if($id_cat_prs>-1){
						if($id_cat_prs>0){
							$jrn = implode(", ",$sel_prs_jrn_cat[$id_dev_mdl][$id_cat_prs]);
							$dt_ttr = ftc_ass(sel_quo("nom,titre","cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_crc,"cat_prs.id",$id_cat_prs));
							if(count($sel_prs_jrn_cat[$id_dev_mdl][$id_cat_prs])>1){$flg_s = true;}
							else{$flg_s = false;}
						}
						else{
							$jrn = $sel_prs_jrn[$id_dev_prs];
							$dt_ttr = ftc_ass(sel_quo("nom,titre","dev_prs","id",$id_dev_prs));
							$flg_s = false;
						}
?>
			<div style="page-break-inside: avoid">
				<span class="fs_mdl3" style="color:#<?php echo $col[$id_col]; ?>;">
<?php
						if($flg_s){echo $txt_prg->jours->$id_lgg.' '.$jrn.' : ';}
						else{echo $txt_prg->jour->$id_lgg.' '.$jrn.' : ';}
						if(!empty($dt_ttr['titre'])){echo stripslashes($dt_ttr['titre']);}
						else{echo stripslashes($dt_ttr['nom']);}
?>
				</span>
				<br/>
<?php
						if($vue_dt_trf){
?>
				<table>
<?php
							if(
								(
									(
										$id_cat_prs>0 and (empty($sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs]) or count(array_unique($sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs]))==1)
									)
									or
									(
										$id_cat_prs==0 and (empty($sel_prs_trf_srv[$id_dev_prs]) or count(array_unique($sel_prs_trf_srv[$id_dev_prs]))==1)
									)
								)
								and !$ptl and !isset($err_sel_prs_trf_srv[$id_dev_prs])
							){
								if($id_cat_prs>0){$prx = $sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs][0]+$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;}
								else{$prx = $sel_prs_trf_srv[$id_dev_prs][0]+$trf_db_hbr_sel_prs[$id_dev_prs]/2;}
								if(count($bss[$id_trf])==1){$base = $txt_prg->base->$id_lgg.' '.$bss[$id_trf][0];}
								else{$base = $txt_prg->bases->$id_lgg.' '.$bss[$id_trf][0].'-'.$bss[$id_trf][count($bss[$id_trf])-1];}
?>
					<tr>
<?php
								if(!$clt_tmpl[$id_clt] or $flagMultiBss or $vue_sgl or $vue_tpl or $vue_qdp)
								{
?>
						<td style="padding: 0px 5px;" class="fs6">
<?php
									if(number_format($prx,0) !=0){
										echo $base;
										if($ptl){echo '&#43;1';}
										echo ' :';
									}
?>
						</td>
<?php
								}
?>
						<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
						<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
					</tr>
<?php
							}
							elseif(isset($bss[$id_trf])){
								foreach($bss[$id_trf] as $i => $base){
									if($id_cat_prs>0){
										$prx = $sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs][$i]+$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;
										if($ptl){$prx += $cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/(2*$base);}
										if($psg){$prx += ($cst_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]-$cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2)/$base;}
									}
									else{
										$prx = $sel_prs_trf_srv[$id_dev_prs][$i]+$trf_db_hbr_sel_prs[$id_dev_prs]/2;
										if($ptl){$prx += $cst_db_hbr_sel_prs[$id_dev_prs]/(2*$base);}
										if($psg){$prx += ($cst_sg_hbr_sel_prs[$id_dev_prs]-$cst_db_hbr_sel_prs[$id_dev_prs]/2)/$base;}
									}
?>
					<tr>
<?php
									if(!$clt_tmpl[$id_clt] or $flagMultiBss or $vue_sgl or $vue_tpl or $vue_qdp)
									{
?>
						<td style="padding: 0px 5px;" class="fs6">
<?php
										echo $txt_prg->base->$id_lng.' '.$base;
										if($ptl){echo '&#43;1';}
										echo ' :';
?>
						</td>
<?php
									}
?>
						<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
						<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
						<td style="padding: 0px 5px;" class="fs6">
	<?php
							if($err_sel_prs_trf_srv[$id_dev_prs][$i]){echo '<span class="color-red">'.$txt->err->srv_jrn->$id_lng.'</span>';}
	?>
						</td>
					</tr>
<?php
							}
						}
						if($vue_sgl==1 and $trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_sg_hbr_sel_prs[$id_dev_prs]>0){
							if($id_cat_prs>0){$prx = $trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]-$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;}
							else{$prx = $trf_sg_hbr_sel_prs[$id_dev_prs]-$trf_db_hbr_sel_prs[$id_dev_prs]/2;}
?>
					<tr>
						<td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->sup_sgl->$id_lgg.' :'; ?></td>
						<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
						<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
					</tr>
<?php
							}
							if($vue_tpl==1 and $trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_tp_hbr_sel_prs[$id_dev_prs]>0){
								if($id_cat_prs>0){$prx = $trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2-$trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/3;}
								else{$prx = $trf_db_hbr_sel_prs[$id_dev_prs]/2-$trf_tp_hbr_sel_prs[$id_dev_prs]/3;}
?>
					<tr>
						<td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->red_tpl->$id_lgg.' :' ?></td>
						<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
						<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
					</tr>
<?php
							}
							if($vue_qdp==1 and $trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_qd_hbr_sel_prs[$id_dev_prs]>0){
								if($id_cat_prs>0){$prx = $trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2-$trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/4;}
								else{$prx = $trf_db_hbr_sel_prs[$id_dev_prs]/2-$trf_qd_hbr_sel_prs[$id_dev_prs]/4;}
?>
					<tr>
						<td style="padding: 0px 5px;" class="fs6"><?php echo $txt_prg->red_qdp->$id_lgg.' :' ?></td>
						<td style="padding: 0px 5px;" class="fs9"><?php echo number_format($prx,0,',',' '); ?></td>
						<td style="padding: 0px 5px;" class="fs6"><?php echo $prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg; ?></td>
					</tr>
<?php
							}
?>
				</table>
<?php
						}
?>
			</div>
			<br/>
<?php
					}
				}
			}
		}
	}
?>
			<br/>
			<span class="fs5">
<?php
	if(!$clt_tmpl[$id_clt]) {echo $txt_prg->noinc->$id_lgg;}
	elseif($clt_tmpl[$id_clt]==1) {echo 'Ce que le prix ne comprend pas';}
?>
			</span>
			<br/><br/>
			<div style="page-break-inside: avoid">
				<span class="fs6">Pourboires.</span>
			</div>
			<br/>
			<div style="page-break-inside: avoid">
				<span class="fs6">Essence, stationnement, péage, 2ième conducteur lors de la location de véhicules.</span>
			</div>
			<br/>
			<div style="page-break-inside: avoid">
				<span class="fs6">Entrées, taxes et repas non mentionnés.</span>
			</div>
			<br/>
			<div style="page-break-inside: avoid">
				<span class="fs6">Vols internationaux et domestiques.</span>
				<span class="fs_mdl2">En Argentine, les vols nationaux incluent un bagage en soute de 15kg (supplément pour 23kg à régler à l'aéroport uniquement).</span>
			</div>
			<br/>
<?php
	if($clt_tmpl[$id_clt]==1) {
		if(isset($hbr_id)) {
?>
			</div>

<?php
			if($saut_avt){
	?>
		</div>
	<?php
				$html .= ob_get_contents();
				ob_end_flush();
	?>
	</div>
	<br />
	<div class="pge">
	<?php
				ob_start();
	?>
		<div style="page-break-before: always;">
	<?php
			}
			else{echo '<br/><br/>';}
	?>
			<div style="page-break-inside: avoid">
				<div class="div2 bg-black">
					<div class="text-white h2">
						<div class="div5">
							<span class="sp0">VOS HEBERGEMENTS</span>
						</div>
					</div>
				</div>
				<div class="div4">
<?php
		include("vue_dt_prg_lst_hbr.php");
		}
?>
				</div>
			</div>
			<div class="div2 bg-black">
				<div class="text-white h2">
					<div class="div6">
						<span class="sp0">COMMENT Y ALLER ?</span>
					</div>
				</div>
			</div>
			<div class="div4">
				<div class="fs6">Le vol international n’est jamais inclus dans les prestations proposées par votre expert local. Chaque voyageur doit réserver son acheminement de manière séparée. Sur Internet, il est très facile de comparer et de réserver votre vol au meilleur prix.</div>
				<br>
				<div class="fs5">Réservez le plus tôt possible et obtenez le meilleur prix !</div>
				<div class="fs6">La plupart des compagnies pratiquent toutes la même règle commerciale : plus l’avion se remplit, plus le prix des derniers sièges attribués est élevé. Ainsi, plus tôt vous procéderez à votre réservation, meilleur sera le prix obtenu.
					<br /><br />
					Pour trouver votre vol, vous pouvez vous rendre sur des sites de comparateurs de vols tels que
					<ul class="dashed">
						<li>Kayak : <a href="https://www.kayak.fr">https://www.kayak.fr</a></li>
						<li>Liligo : <a href="https://www.liligo.fr">http://www.liligo.fr</a></li>
						<li>Opodo : <a href="https://www.opodo.fr">http://www.opodo.fr</a></li>
					</ul>
				</div>
				<br /><br />
			</div>
			<div class="div2 bg-black">
				<div class="text-white h2">
					<div class="div7">
						<span class="sp0">FORMALITÉS ADMINISTRATIVES</span>
					</div>
				</div>
			</div>
			<div class="div4">
				<div class="fs5">Les formalités administratives</div>
				<br /><br />
				<div class="fs6">
					ATTENTION : Suite à la crise du Covid les conditions d’entrée et de sortie peuvent évoluer d’ici votre départ.
					<br />
					Nous vous invitons à consulter le site du Ministère des affaires étrangères :
					<a href="https://www.diplomatie.gouv.fr/fr/conseils-aux-voyageurs/conseils-par-pays-destination/argentine/#derniere">https://www.diplomatie.gouv.fr/fr/conseils-aux-voyageurs/conseils-par-pays-destination/argentine/#derniere</a>
					<br /><br />
					Nos éclaireurs à Grenoble restent également à votre disposition pour vous accompagner dans vos démarches : 0458005393
				</div>
				<br /><br />
				<div class="fs5">Pour les ressortissants français :</div>
				<div class="fs6">
					<ul>
						<li>Votre passeport valide pour toute la durée du séjour en Argentine</li>
						<li>Pas de visa nécessaire.</li>
					</ul>
					<div class="underline">Vous voyagez avec des enfants</div>
					Les mineurs français sont soumis aux mêmes obligations que les personnes majeures. Ils doivent être titulaires d'un passeport valide pour la durée du voyage.
					<br /><br />
					Depuis le 15 janvier 2017, un enfant mineur résidant en France et qui voyage seul ou avec une autre personne que ses parents doit être muni notamment d'une autorisation de sortie du territoire (AST). Il s'agit d'un formulaire établi et signé par un parent (ou responsable légal).
				</div>
				<br /><br />
				<div class="fs5 underline">Formalités en cas de vols escale aux Etats-Unis</div>
				<br />
				<div class="fs5">Pour les ressortissants français :</div>
				<div class="fs6">
					<ul>
						<li>Un passeport valide 6 mois après la date de sortie des Etats-Unis ;</li>
						<li>une autorisation de voyage électronique : ESTA (Electronic System for Travel Authorization).</li>
					</ul>
					Vous devez obtenir votre ESTA avant votre départ et l’imprimer ; elle sera exigée à l’embarquement et à l’arrivée sur le territoire américain.
					<br />
				</div>
				<br />
				<div class="fs5">Votre passeport</div>
				<div class="fs6">
					Depuis le 1er avril 2016, la loi exige que tous les voyageurs à destination des États-Unis ou en transit sur le sol américain soient en possession d’un passeport biométrique (avec puce électronique).
					<br />
					Un passeport biométrique, symbolisé par une puce sur la couverture, répond aux normes internationales permettant de sécuriser et de stocker des informations concernant le porteur du passeport. Tous les passeports émis en France depuis le 29 juin 2009 remplissent cette obligation.
					<br />
				</div>
				<br />
				<div class="fs5">L’autorisation de voyage électronique</div>
				<div class="fs6">
					Vous devrez remplir une autorisation ESTA sur le site officiel
					<br /><br />
					https://esta.cbp.dhs.gov. Valable pour une durée de deux ans ou jusqu’à expiration du passeport, cette autorisation doit être sollicitée au plus tard 72 heures avant le départ ; nous vous recommandons de la solliciter aussitôt votre voyage confirmé. Les mineurs doivent également solliciter l’autorisation ESTA.
					<br />
					Dans la plupart des cas, les agents de sécurité intérieure donnent l’accord en ligne presque immédiatement en renvoyant la mention “autorisation approuvée”. L’ESTA est payante (14 US$ en ligne par carte bancaire, montant révisable sans préavis).
					<br /><br />
					Les voyageurs ayant effectué un séjour en <strong>Iran, Irak, Soudan Yémen, Somalie, Lybie ou Syrie</strong> depuis le 1er mars 2011, et dont le passeport porte la trace, doivent faire une demande de visa auprès de l’ambassade des Etats-Unis ou via Visa Express ; l’ESTA ne sera pas acceptée.
					<br /><br />
					<div class="underline">Vous voyagez avec des enfants</div>
					Les mineurs français sont soumis aux mêmes obligations que les personnes majeures. Ils doivent être titulaires d’un passeport valide 6 mois après la date de sortie des Etats-Unis et de l’autorisation ESTA.
					<br />
					Les mineurs, voyageant seuls ou accompagnés par un seul parent, devront fournir un document établissant leur filiation et garantissant que le voyage est autorisé par les deux parents. Veuillez consulter l’ambassade des Etats-Unis, 2, avenue Gabriel, 75008 Paris. Tél. 01 43 12 20 20.
					<br /><br />
					Depuis le 15 janvier 2017, un enfant mineur résidant en France et qui voyage seul ou avec une autre personne que ses parents doit être muni notamment d'une autorisation de sortie du territoire (AST). Il s'agit d'un formulaire établi et signé par un parent (ou responsable légal).
				</div>
				<br />
				<div class="fs5">
					Pour les autres nationalités, veuillez-vous renseigner auprès des autorités consulaires de sortie des Etats-Unis dans votre pays.
					<br /><br />
					Les passeports doivent être en parfait état (pas de taches, agrafes, trombones, marques, déchirures…).
				</div>
				<br /><br />
			</div>
			<div class="div2 bg-black">
				<div class="text-white h2">
					<div class="div8">
						<span class="sp0">SANTÉ</span>
					</div>
				</div>
			</div>
			<div class="div4">
				<div class="fs6">
					Consulter son médecin traitant ou un centre de vaccinations internationales afin de faire une évaluation de son état de santé et de bénéficier de recommandations sanitaires, notamment sur les vaccinations.
					<br /><br />
					Consulter éventuellement son dentiste avant le départ.
				</div>
				<br />
				<div class="fs5">Vaccins</div>
				<div class="fs6">
					Aucun vaccin n'est obligatoire.
					<br />
					Nous vous recommandons cependant d'être à jour pour les vaccinations classiques : Diphtérie, Tétanos, Poliomyélite, Fièvre typhoïde.
					<br />
					La vaccination contre la fièvre jaune est conseillée, en particulier pour les déplacements dans la province de Misiones (nord du pays) où se trouve notamment la zone touristique des chutes d’Iguazu. A pratiquer avant le départ dans un centre agréé.
					<br />
				</div>
				<br />
				<div class="fs5">Paludisme</div>
				<div class="fs6">
					Il existe des petits foyers de paludisme mineurs dans le Nord-Est du pays, en particulier dans la province de Misiones.
					<br /><br />
					Le paludisme (ou malaria) est une maladie parasitaire transmise par les piqûres de moustiques. Les mesures classiques de protection contre les moustiques sont fortement recommandées. Durant son séjour, et pendant les deux mois qui suivent son retour, en cas de fièvre, un avis médical doit être pris rapidement pour mettre en oeuvre dès que possible un traitement antipaludique éventuel.
					<br /><br />
					Veuillez consulter votre médecin traitant avant votre départ qui vous conseillera et vous prescrira le traitement le plus efficace si nécessaire.
				</div>
				<br />
				<div class="fs5">Dentiste et médecin</div>
				<div class="fs6">
					 Nous vous recommandons d'effectuer une visite de contrôle avant votre départ.
					 <br /><br />
					 Pour plus d’informations sur les précautions à prendre, vous pouvez consulter le site Internet de SMI (Service Médical International) : <a href="https://smi-voyage-sante.fr/">www.smi-voyage-sante.com</a> <a href="https://www.diplomatie.gouv.fr/">www.diplomatie.gouv.fr/</a> ou <a href="https://www.pasteur.fr/">www.pasteur.fr/</a>
				</div>
				<br /><br />
			</div>
			<div class="div2 bg-black">
				<div class="text-white h2">
					<div class="div9">
						<span class="sp0">INFORMATIONS PRATIQUES</span>
					</div>
				</div>
			</div>
			<div class="div4">
				<div class="fs5">Argent</div>
				<br />
				<div class="fs6">
					La devise est le peso argentin (ARS).
					<br />
					Taux de change (cours indicatif) : 1 € = <?php echo number_format($cfg_crr_txf[3]*$cfg_crr_txf[2]/10,$cfg_crr_dcm[3],'.','')*10; ?> ARS environ.
					<br />
					Nous vous conseillons d’emporter des euros, que vous pouvez changer dans les principales grandes villes. Evitez de changer dans la rue (faux billets courants). Les paiements par carte bancaire sont possibles, mais les commerces facturent souvent un supplément (recargo) ; posez la question avant de payer. Des distributeurs automatiques de billets sont également disponibles dans les villes ou leurs aéroports (Buenos Aires, Ushuaia, El Calafate, Salta...), pour cartes Visa, Mastercard, etc.
				</div>
				<br /><br />
			</div>
			<div style="page-break-inside: avoid">
				<div class="div2 bg-black">
					<div class="text-white h2">
						<div class="div10">
							<span class="sp0">VOS GARANTIES</span>
						</div>
					</div>
				</div>
				<div class="div4 text-center">
					<img src="<?php echo '../prm/img/'.$dir.'/'.$nom_clt.$n_img.'.'.$ext_img[$n_img] ?>" width="<?php echo $wdts_img[$n_img];$n_img++; ?>"/>
				</div>
			</div>
			<div class="div2 bg-black">
				<div class="text-white h2">
					<div class="div11">
						<span class="sp0">VOTRE ASSURANCE & ASSISTANCE</span>
					</div>
				</div>
			</div>
			<div class="div4">
				<div class="fs6">
					Pour continuer à vous faire voyager dans les meilleures conditions, il nous tenait à coeur de vous offrir une solution d’assurance complète pour tenir compte du risque Covid 19.
					<br /><br />
					Pour cela, nous avons négocié avec Assur-Travel, l’assurance Évasion.
				</div>
				<br />
				<div class="fs5 underline">La garantie annulation fermeture des frontières</div>
				<div class="fs12">offert pour toutes les réservations *</div>
					<ul class="fs6">
						<li><strong>Remboursement ou report sans frais en cas de fermeture des frontières,</strong> quarantaine imposée sur place ou au retour.
					</ul>
				<div class="fs12">* Pour être tout à fait honnête, nous appliquons simplement la règlementation européenne sur la vente de voyage. Mais c’est aussi cela l’avantage de partir avec nous. Pas de compromis ! Vous bénéficiez à la fois de la protection juridique / financière d’une agence française et l’expertise de nos conseillers locaux.</div>
				<br />
				<div class="fs5 underline">L’assistance rapatriement incluant les épidémies.</div>
				<br />
				<div class="fs5">Les principales garanties :</div>
				<ul class="fs6">
					<li>Rapatriement sanitaire y compris les personnes accompagnantes</li>
					<li>Frais médicaux</li>
					<li><strong>Retour impossible</strong> en cas d’épidémie</li>
					<li>Frais hôteliers <strong>suite à mise en quarantaine</strong></li>
					<li><strong>Retour anticipé</strong></li>
					<li>Soutien psychologique suite à mise en quarantaine</li>
				</ul>
				<br />
				<div class="fs5 underline">L’assurance annulation incluant les épidémies.</div>
				<br />
				<div class="fs5">
					Les principales garanties :
					<br /><br />
					<em>Le remboursement des frais d’annulation en cas de :</em>
				</div>
				<ul class="fs6">
					<li>Maladie, accident ou décès (y compris rechute ou aggravation)</li>
				</ul>
				<div class="fs6">
					<div class="underline">Annulation en cas d’imprévus</div>
					<br />
					Tout évènement aléatoire, indépendant de la volonté de l’assuré, imprévisible et justifiable
					<br /><br />
					Dont les motifs suivants :
					<ul>
						<li>Annulation pour <strong>refus d’embarquement</strong> suite à la prise de température</li>
						<li><strong>Non présentation du test PCR</strong> pour voyager dans les délais requis</li>
						<li>Assuré désigné comme étant <strong>cas contact dans les 7 jours</strong> précèdent le départ</li>
					</ul>
					<div class="underline">Pour les causes dénommées</div>
					<ul>
						<li>Vol dans les locaux privés ou professionnels Convocation en tant que témoin ou juré d’assise</li>
						<li>Convocation pour une adoption d’enfant Convocation à un examen de rattrapage</li>
						<li>Obtention d’un emploi ou d’un stage rémunéré icenciement économique</li>
						<li>Mutation professionnelle</li>
						<li>Suppression et modification des congés payés</li>
						<li>Dommages graves au véhicule 48h avant le départ</li>
						<li>Vol des papiers d’identité</li>
						<li>Contre-indication de vaccination</li>
						<li>Annulation d’un accompagnant (maximum 4)</li>
						<li>Le remboursement des <strong>prestations non consommées</strong> de voyage en cas <strong>d’interruption</strong> de séjour</li>
					</ul>
				</div>
				<br /><br />
				<div class="fs5 underline">Quelles sont les formules ? et le prix ?</div>
				<br />
				<div class="fs6">
					La garantie annulation fermeture des frontières est incluse dans toutes les formules.
					<br />
					<div class="underline">En option, nous proposons trois formules pour un maximum de souplesse :</div>
					<ol>
						<li>Assistance rapatriement incluant les épidémies : <strong>1,5% du prix du voyage</strong></li>
						<li>Assistance rapatriement incluant les épidémie + Assurance annulation incluant les épidémies, bagage : <strong>4% du prix du voyage</strong></li>
						<li>Assistance rapatriement incluant les épidémie + Assurance annulation incluant les épidémies, bagage + vol manqué, retard de transport, Interruption de séjour : <strong>4,8% du prix du voyage</strong></li>
					</ol>
					<a href="https://www.tracedirecte.com/include/viewFile.php?idtf=5886&path=3e%2F5886_142_Tableau-des-garanties.pdf">Télécharger le tableau des garanties</a>
					<br />
					<a href="https://www.tracedirecte.com/include/viewFile.php?idtf=5887&path=a3%2F5887_195_Conditions-ge-ne-rales_Assurance.pdf">Télécharger les conditions générales de vente</a>
					<br />
					<br />
				</div>
				<div class="fs5 underline">Comment souscrire à nos assurances ?</div>
				<br />
				<div class="fs6">Au moment de votre inscription, vous pourrez tout simplement cocher la formule d’assurance que vous souhaitez.</div>
				<br />
				<div class="fs5 underline">
					Quiz des assurances cartes bancaires ?
					<br />
					1,2,3 Comparez !
				</div>
				<br />
				<div class="fs6">
					Vous avez l’habitude d’utiliser les assurances de votre carte bancaire ?
					<br />
					Petite mise en garde, très peu de cartes proposent des garanties liées au Covid.
					<br />
					Nous vous laissons le soins de vérifier auprès de votre banque.
					<br /><br />
					Pour vous aider à faire votre choix, voici <strong>notre comparateur entre les assurances CB et notre assurance :</strong>
					<br /><br />
					<a href="https://tracedirecte.assur-travel-mycomparateur.fr/">Comparateur d’assurance</a>
					<br /><br /><br />
				</div>
			</div>
			<div class="div2 bg-black">
				<div class="text-white h2">
					<div class="div12">
						<span class="sp0">PRÊT À PARTIR !</span>
					</div>
				</div>
			</div>
			<div class="div4">
				<div class="fs5">Ce programme vous convient ?</div>
				<br />
				<div class="fs6">
					Pour concrétiser votre voyage, il vous suffit de m’envoyer un message de confirmation dans votre espace client.
					<br /><br />
					En retour, je vous enverrai un bulletin d’inscription numérique. Vous serez prévenu par mail dès qu’il sera disponible.
				</div>
				<div class="fs5">Pour vous inscrire :</div>
				<br />
				<div class="fs6">
					Dans votre espace client :
					<ul class="dashed">
						<li>Cliquez sur le bouton « Je m’inscris ». (<a href="http://bit.ly/2r4WGoE">http://bit.ly/2r4WGoE</a>)</li>
						<li>Indiquez le prénom et le nom des participants.</li>
						<li>Choisissez vos assurances.</li>
						<li>Saisissez vos coordonnées bancaires pour régler votre acompte de 30 %.</li>
					</ul>
				</div>
				<br /><br />
			</div>
			<div class="div2 bg-black">
				<div class="text-white h2">
					<div class="div13">
						<span class="sp0">BESOIN D’AIDE ?</span>
					</div>
				</div>
			</div>
			<div class="div4">
				<div class="fs5">Pour toutes les questions concernant l’organisation de votre voyage :</div>
				<div class="fs6">Contactez-moi directement.</div>
				<ul class="fs5">
					 <li>Par téléphone :</li>
				 </ul>
				<div class="fs6">
					Du lundi au vendredi de 14h00 à 21h00
					<br />
					Tél : 04-85-87-03-26
					<br />
					Tél local : +54-294-434-2815
				</div>
				<ul class="fs6">
					 <li><strong>Par messagerie</strong> via votre espace client</li>
				</ul>
				<br />
				<div class="fs6"><strong>Pour toutes questions administratives (inscription, formalité, assurances, facture, règlement) :</strong> Contactez le service client à Grenoble (France).</div>
				<ul class="fs5">
					 <li>Par téléphone :</li>
				 </ul>
				 <div class="fs6">
					 Du lundi au vendredi de 9h à 18h30.
					 Tél : +33 (0)4 58 00 53 93
				 </div>
			</div>
		</div>
<?php
	}
	elseif(!$clt_tmpl[$id_clt]) {
	//EN CAS D'URGENCE
?>
<!--			<br />
			<span class="fs13"><?php echo $txt_prg->urg->$id_lgg ?></span>
			<br /><br />
			<span class="fs6"><?php echo $txt_prg->dt_urg->$id_lgg ?></span>!-->
		</div>
	</div>
<?php
}
	$flg_map = false;
	foreach($map as $i => $lnk){
		if(mb_strlen($lnk)>118){
			$html .= ob_get_contents();
			ob_end_flush();
?>
</div>
<br />
<div class="pge">
<?php
			ob_start();
			if($clt_tmpl[$id_clt]==1) {echo '<div class="div4">';}
			elseif(!$clt_tmpl[$id_clt]) {echo '<div class="div3">';}
			if(!$flg_map){
?>
	<div style="page-break-before: always;">
		<span class="fs13"><?php echo $txt_prg->iti->$id_lgg; ?></span>
		<br/><br/>
	</div>
<?php
				$flg_map = true;
			}
			echo '<img src="'.$lnk.'" /><br />';
			echo stripslashes($leg[$i]).'<br />';
			echo '</div>';
		}
	}
}
$html .= ob_get_contents();
ob_end_flush();
$html .= '</body>';
$fp = @fopen("../tmp/".$dir."/".$ttr.".html", "w");
if($fp){
	fwrite($fp, $html);
	fclose($fp);
}
if($flg_map){
?>
	</div>
<?php
}
?>
</div>
