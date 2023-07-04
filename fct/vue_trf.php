<?php
if(isset($_GET['id']) and !empty($_GET['id'])){
	$id = $_GET['id'];
	$cbl = 'dev';
	$txt = simplexml_load_file('../resources/xml/mainTxt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/rpl.php");
	include("../prm/lgg.php");
	include("../prm/crr.php");
	include("../cfg/ctg_hbr.php");
	include("../cfg/clt.php");
	include("../cfg/lieu.php");
	include("../cfg/lng.php");
	include("../cfg/ttr_lieu.php");
	include("../cfg/vll.php");
	$rq_pic = sel_quo("pic","cat_pic");
	while($dt_pic = ftc_ass($rq_pic)){$bg[] = $dt_pic['pic'];}
	$i = rand(0, count($bg)-1);
	$pic = "$bg[$i]";
	$dt_crc = ftc_ass(sel_quo("*","dev_crc","id",$id));
	$cnf = $dt_crc['cnf'];
	$lgg_crc = $dt_crc['lgg'];
	$vue_dt_trf = $vue_map = true;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('forme.css'))  ?>" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css'))  ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script><?php include("script.js");?></script>
	</head>
	<body onload="act_tab('trf',<?php echo $id ?>,'dev');">
		<div id="bck" style="background-image: url('../pic/<?php echo $dir.'/'.$pic; ?>');"></div>
		<div id="wrapper"><input type="button" value="<?php echo $txt->trf->act->$id_lng; ?>" onclick="document.location.replace('vue_trf.php?id=<?php echo $id;?>');" /></div>
		<br />
		<br />
		<table>
			<tr class="vat">
				<td class="tbl_trf">
<?php
	include("trf.php");
	if($dt_max_crc >= $dt_min_crc and $dt_max_crc!='' and $dt_min_crc!=''){echo $txt->trf->msg1->$id_lng.date("d/m/Y", strtotime($dt_min_crc)).$txt->trf->msg2->$id_lng.date("d/m/Y", strtotime($dt_max_crc)).".<br/>";}
	$flg_trf_mdl = true;
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
		if($id_trf or ($flg_trf_mdl and $flg_trf_crc)){
			if($id_trf){
?>
					<strong><?php echo $txt->mdl->$id_lng.' '.$dt_mdl['ord'].' : '.stripslashes($dt_mdl['titre']); ?> </strong>
<?php
			}
			else{
				$flg_trf_mdl=false;
?>
					<strong><?php echo $txt->crc->$id_lng; ?></strong>
<?php
			}
?>
					</br>
					<table>
<?php
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
			if(isset($bss[$id_trf])){
				foreach($bss[$id_trf] as $i => $base){
					$prx = $trf_srv[$id_trf][$i]+$trf_db_hbr[$id_trf]/2;
					$cst = $cst_srv[$id_trf][$i]+$cst_db_hbr[$id_trf]/2;
					if($ptl){
						$prx += $cst_db_hbr[$id_trf]/(2*$base);
						$cst += $cst_db_hbr[$id_trf]/(2*$base);
					}
					if($psg){
						$prx += ($cst_sg_hbr[$id_trf]-$cst_db_hbr[$id_trf]/2)/$base;
						$cst += ($cst_sg_hbr[$id_trf]-$cst_db_hbr[$id_trf]/2)/$base;
					}
?>
						<tr>
							<td style="padding: 0px 5px;">
<?php
					echo $txt->base->$id_lng.' '.$base;
					if($ptl){echo '+1';}
					echo ' :';
?>
							</td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
					echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
					if($prx!=0){echo ' ('.number_format((1-$cst/$prx)*100,0).'%)';}
					if(isset($err_trf_srv[$id_trf][$i]) and $err_trf_srv[$id_trf][$i]){echo '<span class="color-red">'.$txt->err->srv_jrn->$id_lng.' '.$txt->jours->$id_lng.' : '.$err_srv_jrn[$id_trf][$i].'</span>';}
?>
							</td>
						</tr>
<?php
				}
			}
			if($vue_sgl==1){
				$prx = $trf_sg_hbr[$id_trf]-$trf_db_hbr[$id_trf]/2;
				$cst = $cst_sg_hbr[$id_trf]-$cst_db_hbr[$id_trf]/2;
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->supsgl->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
				echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
				if($prx!=0){echo ' ('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
			}
			if($vue_tpl==1){
				$prx = $trf_db_hbr[$id_trf]/2-$trf_tp_hbr[$id_trf]/3;
				$cst = $cst_db_hbr[$id_trf]/2-$cst_tp_hbr[$id_trf]/3;
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->redtpl->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
				echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
				if($prx!=0){echo ' ('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
			}
			if($vue_qdp==1){
				$prx = $trf_db_hbr[$id_trf]/2-$trf_qd_hbr[$id_trf]/4;
				$cst = $cst_db_hbr[$id_trf]/2-$cst_qd_hbr[$id_trf]/4;
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->redqdp->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
				echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
				if($prx!=0){echo ' ('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
			}
?>
					</table>
<?php
			if($psg){
?>
					<span class="em"><?php echo $txt->trf_psg->$id_lng; ?></span><br/>
<?php
			}
			elseif($ptl){
?>
					<span class="em"><?php echo $txt->trf_ptl->$id_lng; ?></span><br/>
<?php
			}
?>
					<br/>
<?php
		}
	}
?>
					<span class="em"><?php echo $txt->trf_dbl->$id_lng; ?></span><br/>
<?php
	if(isset($hbr_id)){
?>
					<hr/>
					<strong><?php echo $txt->lst_hbr->$id_lng ?></strong>
					<br/>
					<table>
						<tr>
							<td class="stl4"><?php echo $txt->jours->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->villes->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->categories->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->hebergements->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->chambres->$id_lng; ?></td>
						</tr>
<?php
		foreach($hbr_id as $i => $id_hbr){
?>
						<tr>
<?php
			if($id_hbr>0){
				$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
?>
							<td class="stl4"><?php echo $hbr_jrn[$id_hbr][$chm_id[$i]]; ?></td>
							<td class="stl4"><?php echo stripslashes($vll[$dt_hbr['id_vll']]); ?></td>
							<td class="stl4"><?php echo stripslashes($ctg_hbr[$id_lng][$dt_hbr['ctg']]); ?></td>
							<td class="stl4">
<?php
				if(empty($dt_hbr['titre'])){echo stripslashes($dt_hbr['nom']);}
				elseif(!empty($dt_hbr['web'])){echo '<a href="'.$dt_hbr['web'].'" target="_blank">'.stripslashes($dt_hbr['titre']).'</a>';}
				else{echo stripslashes($dt_hbr['titre']);}
?>
							</td>
							<td class="stl4">
<?php
				if($chm_id[$i]!=0){
					$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$chm_id[$i]));
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
							<td class="stl4"><?php echo $hbr_jrn[$id_hbr][$vll_hbr[$i]]; ?></td>
							<td class="stl4"><?php echo stripslashes($vll[$vll_hbr[$i]]); ?></td>
							<td class="stl4"></td>
<?php
				if($id_hbr==-2){
?>
							<td class="stl4"><?php echo $txt->libre->$id_lng; ?></td>
<?php
				}
				else{
?>
							<td class="stl4"><?php echo $txt->err->hbr->$id_lng; ?></td>
<?php
				}
			}
?>
						</tr>
<?php
		}
?>
					</table>
					<br/>
<?php
		if(isset($opt_hbr_id)){
?>
		<hr/>
		<strong><?php echo $txt->hbr_opt->$id_lng; ?></strong>
		<br/>
		<table>
			<tr>
				<td class="stl4"><?php echo $txt->jours->$id_lng; ?></td>
				<td class="stl4"><?php echo $txt->villes->$id_lng; ?></td>
				<td class="stl4"><?php echo $txt->categories->$id_lng; ?></td>
				<td class="stl4"><?php echo $txt->hebergements->$id_lng; ?></td>
				<td class="stl4"><?php echo $txt->chambres->$id_lng; ?></td>
				<td class="stl4"><?php echo $txt->trf->supplements->$id_lng; ?></td>
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
								$tab_cst_opt_hbr_db[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$cst_opt_hbr_db[$id_dev_mdl][$j];
								$tab_opt_hbr_jrn[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$opt_hbr_jrn[$id_dev_mdl][$j];
								$tab_err_trf_db_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$err_trf_db_opt_hbr[$id_dev_mdl][$j];
								$tab_opt_hbr_vll[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$opt_hbr_vll[$id_dev_mdl][$j];
								$tab_trf_opt_hbr_sg[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$trf_opt_hbr_sg[$id_dev_mdl][$j];
								$tab_cst_opt_hbr_sg[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$cst_opt_hbr_sg[$id_dev_mdl][$j];
								$tab_err_trf_sg_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$err_trf_sg_opt_hbr[$id_dev_mdl][$j];
								$tab_trf_opt_hbr_tp[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$trf_opt_hbr_tp[$id_dev_mdl][$j];
								$tab_cst_opt_hbr_tp[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$cst_opt_hbr_tp[$id_dev_mdl][$j];
								$tab_err_trf_tp_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$err_trf_tp_opt_hbr[$id_dev_mdl][$j];
								$tab_trf_opt_hbr_qd[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$trf_opt_hbr_qd[$id_dev_mdl][$j];
								$tab_cst_opt_hbr_qd[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$cst_opt_hbr_qd[$id_dev_mdl][$j];
								$tab_err_trf_qd_opt_hbr[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][]=$err_trf_qd_opt_hbr[$id_dev_mdl][$j];
							}
						}
					}
					if(isset($tab_opt_hbr_id[$id_dev_mdl])){
						foreach($tab_opt_hbr_id[$id_dev_mdl] as $i => $id_hbr_tab){
							$prx = 0;
							$cst = 0;
							$jrn_opt = '';
							$err = 0;
							$flg_vrg = false;
							$prx_sg=0;
							$cst_sg=0;
							$err_sg_opt=0;
							$prx_tp=0;
							$cst_tp=0;
							$err_tp_opt=0;
							$prx_qd=0;
							$cst_qd=0;
							$err_qd_opt=0;
							foreach($tab_trf_opt_hbr_db[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]] as $j => $prx_opt_hbr_db){
								$prx += $prx_opt_hbr_db/2;
								$prx_sg += $tab_trf_opt_hbr_sg[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
								$prx_tp += $tab_trf_opt_hbr_tp[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j]/3;
								$prx_qd += $tab_trf_opt_hbr_qd[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j]/4;
								$cst += $tab_cst_opt_hbr_db[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j]/2;
								$cst_sg += $tab_cst_opt_hbr_sg[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j];
								$cst_tp += $tab_cst_opt_hbr_tp[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j]/3;
								$cst_qd += $tab_cst_opt_hbr_qd[$id_dev_mdl][$id_hbr_tab][$tab_opt_chm_id[$id_dev_mdl][$i]][$j]/4;
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
							$tab_cst[$id_dev_mdl][$i] = $cst;
							$tab_jrn[$id_dev_mdl][$i] = $jrn_opt;
							$tab_err[$id_dev_mdl][$i] = $err;
							$tab_vil[$id_dev_mdl][$i] = $vil;
							$tab_sg_prx[$id_dev_mdl][$i] = $prx_sg;
							$tab_sg_cst[$id_dev_mdl][$i] = $cst_sg;
							$tab_err_sg[$id_dev_mdl][$i] = $err_sg_opt;
							$tab_tp_prx[$id_dev_mdl][$i] = $prx_tp;
							$tab_tp_cst[$id_dev_mdl][$i] = $cst_tp;
							$tab_err_tp[$id_dev_mdl][$i] = $err_tp_opt;
							$tab_qd_prx[$id_dev_mdl][$i] = $prx_qd;
							$tab_qd_cst[$id_dev_mdl][$i] = $cst_qd;
							$tab_err_qd[$id_dev_mdl][$i] = $err_qd_opt;
						}
						foreach($tab_opt_hbr_id[$id_dev_mdl] as $i => $id_hbr_tab){
?>
						<tr>
							<td class="stl4"><?php echo $tab_jrn[$id_dev_mdl][$i]; ?></td>
<?php
							if($id_hbr_tab!=0){
								$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr_tab));
?>
							<td class="stl4"><?php echo stripslashes($vll[$dt_hbr['id_vll']]); ?></td>
							<td class="stl4"><?php echo stripslashes($ctg_hbr[$id_lng][$dt_hbr['ctg']]); ?></td>
							<td class="stl4">
<?php
								if(empty($dt_hbr['titre'])){echo stripslashes($dt_hbr['nom']);}
								elseif(!empty($dt_hbr['web'])){echo '<a href="'.$dt_hbr['web'].'" target="_blank">'.stripslashes($dt_hbr['titre']).'</a>';}
								else{echo stripslashes($dt_hbr['titre']);}
?>
							</td>
							<td class="stl4">
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
							<td class="stl4"><?php echo stripslashes($vll[$tab_vil[$id_dev_mdl][$i]]); ?></td>
							<td class="stl4"></td>
							<td class="stl4"><?php echo $txt->err->hbr->$id_lng; ?></td>
<?php
							}
?>
							<td class="stl4">
<?php
							if($vue_sgl==1){
								echo $txt->sgl->$id_lng.' : ';
								if($tab_err_sg[$id_dev_mdl][$i]==0){
									echo number_format($tab_sg_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng;
?>
								<span class="usn">
<?php
									echo ' ('.number_format($tab_sg_cst[$id_dev_mdl][$i],0,',',' ').') ('.number_format($tab_sg_prx[$id_dev_mdl][$i]-$tab_sg_cst[$id_dev_mdl][$i],0,',',' ').')';
									if($tab_sg_prx[$id_dev_mdl][$i]!=0){' ('.number_format((1-$tab_sg_cst[$id_dev_mdl][$i]/$tab_sg_prx[$id_dev_mdl][$i])*100,0).'%)';}
?>
								</span>
<?php
								}
								else{echo $txt->err->trf->$id_lng;}
								echo '<br/>';
							}
							if($vue_dbl==1){
								echo $txt->dbl->$id_lng.' : ';
								if($tab_err[$id_dev_mdl][$i]==0){
									echo number_format($tab_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng;
?>
								<span class="usn">
<?php
									echo ' ('.number_format($tab_cst[$id_dev_mdl][$i],0,',',' ').') ('.number_format($tab_prx[$id_dev_mdl][$i]-$tab_cst[$id_dev_mdl][$i],0,',',' ').')';
									if($tab_prx[$id_dev_mdl][$i]!=0){' ('.number_format((1-$tab_cst[$id_dev_mdl][$i]/$tab_prx[$id_dev_mdl][$i])*100,0).'%)';}
?>
								</span>
<?php
								}
								else{echo $txt->err->trf->$id_lng;}
								echo '<br/>';
							}
							if($vue_tpl==1){
								echo $txt->tpl->$id_lng.' : ';
								if($tab_err_tp[$id_dev_mdl][$i]==0){
									echo number_format($tab_tp_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng;
?>
								<span class="usn">
<?php
									echo ' ('.number_format($tab_tp_cst[$id_dev_mdl][$i],0,',',' ').') ('.number_format($tab_tp_prx[$id_dev_mdl][$i]-$tab_tp_cst[$id_dev_mdl][$i],0,',',' ').')';
									if($tab_tp_prx[$id_dev_mdl][$i]!=0){' ('.number_format((1-$tab_tp_cst[$id_dev_mdl][$i]/$tab_tp_prx[$id_dev_mdl][$i])*100,0).'%)';}
?>
								</span>
<?php
								}
								else{echo $txt->nd->$id_lng;}
								echo '<br/>';
							}
							if($vue_qdp==1){
								echo $txt->qdp->$id_lng.' : ';
								if($tab_err_qd[$id_dev_mdl][$i]==0){
									echo number_format($tab_qd_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng;
?>
								<span class="usn">
<?php
									echo ' ('.number_format($tab_qd_cst[$id_dev_mdl][$i],0,',',' ').') ('.number_format($tab_qd_prx[$id_dev_mdl][$i]-$tab_qd_cst[$id_dev_mdl][$i],0,',',' ').')';
									if($tab_qd_prx[$id_dev_mdl][$i]!=0){' ('.number_format((1-$tab_qd_cst[$id_dev_mdl][$i]/$tab_qd_prx[$id_dev_mdl][$i])*100,0).'%)';}
?>
								</span>
<?php
								}
								else{echo $txt->nd->$id_lng;}
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
			<br/>
<?php
		}
	}
	//OPTIONS
	if(isset($opt_srv_id) or isset($opt_prs_id)){
?>
					<hr/>
					<strong><?php echo $txt->en_opt->$id_lng; ?></strong>
					<br/><br/>
<?php
		$flg_trf_mdl = true;
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
			if($id_trf !=0 or $flg_trf_mdl){
				//SERVICES
				if(isset($opt_srv_id[$id_trf])){
					array_multisort($opt_srv_jrn[$id_trf],$opt_srv_id[$id_trf]);
					foreach($opt_srv_id[$id_trf] as $j => $id_srv){
						if($id_srv>0){$rq_nom_srv = sel_quo("nom,titre","cat_srv LEFT JOIN cat_srv_txt ON cat_srv.id = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"cat_srv.id",$id_srv);}
						else{$rq_nom_srv = sel_quo("nom","dev_srv","id",-$id_srv);}
						$dt_nom_srv = ftc_ass($rq_nom_srv);
?>
					<span class="em" style="text-transform: uppercase;">
<?php
						echo $txt->jour->$id_lng.' '.$opt_srv_jrn[$id_trf][$j].' : ';
						if(!empty($dt_nom_srv['titre'])){echo $dt_nom_srv['titre'];}
						else{echo $dt_nom_srv['nom'];}
?>
					</span>
					<br/>
					<table>
<?php
//regrouper les bases de memes tarifs comme pour les tarifs detaillés avec count(array_unique
						if(isset($bss[$id_trf])){
							foreach($bss[$id_trf] as $i => $base){
								$prx = $trf_opt_srv[$id_trf][$j][$i];
								$cst = $cst_opt_srv[$id_trf][$j][$i];
?>
						<tr>
							<td style="padding: 0px 5px;">
<?php
								echo $txt->base->$id_lng.' '.$base;
								if($ptl){echo '+1';}
								echo ' :';
								if($err_trf_opt_srv[$id_trf][$j][$i]){echo '<span class="color-red">'.$txt->err->opt_srv->$id_lng.'</span>';}
?>
							</td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn"><?php echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').') ('.number_format((1-$cst/$prx)*100,0).'%)'; ?></td>
						</tr>
<?php
							}
						}
?>
					</table>
					<br/>
<?php
					}
				}
				//PRESTATIONS
				if(isset($opt_prs_id[$id_trf])){
					foreach($opt_prs_id[$id_trf] as $i => $id_dev_prs){
						unset($id_cat_prs);
				    $id_cat_prs = $opt_prs_id_cat[$id_trf][$id_dev_prs];
						if($id_cat_prs>-1){
							if($id_cat_prs>0){
								$jrn = implode(", ",$opt_prs_jrn_cat[$id_trf][$id_cat_prs]);
								$dt_ttr = ftc_ass(sel_quo("nom,titre","cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_crc,"cat_prs.id",$id_cat_prs));
								if(count($opt_prs_jrn_cat[$id_trf][$id_cat_prs])>1){$flg_s = true;}
								else{$flg_s = false;}
							}
							else{
								$jrn = $opt_prs_jrn[$id_dev_prs];
								$dt_ttr = ftc_ass(sel_quo("titre","dev_prs","id",$id_dev_prs));
								$flg_s = false;
							}
?>
					<span class="em">
<?php
					    if($flg_s){echo $txt->jours->$id_lng.' '.$jrn.' : ';}
					    else{echo $txt->jour->$id_lng.' '.$jrn.' : ';}
					    if(!empty($dt_ttr['titre'])){echo stripslashes($dt_ttr['titre']);}
					    else{echo stripslashes($dt_ttr['nom']);}
?>
					</span>
					<br/>
<?php
							if($err_hbr_def_opt_prs[$id_dev_prs][$jrn]==1){echo '<span class="color-red">'.$txt->err->hbr_def->$id_lng.$jrn.'</span><br/>';}
							if($err_hbr_db_opt_prs[$id_dev_prs][$jrn]==1){echo '<span class="color-red">'.$txt->err->hbr_db->$id_lng.$jrn.'</span><br/>';}
							if($vue_sgl==1 and $err_hbr_sg_opt_prs[$id_dev_prs][$jrn]==1){echo '<span class="color-red">'.$txt->err->hbr_sg->$id_lng.$jrn.'</span><br/>';}
							if($vue_tpl==1 and $err_hbr_tp_opt_prs[$id_dev_prs][$jrn]==1){echo '<span class="color-red">'.$txt->err->hbr_tp->$id_lng.$jrn.'</span><br/>';}
							if($vue_qdp==1 and $err_hbr_qd_opt_prs[$id_dev_prs][$jrn]==1){echo '<span class="color-red">'.$txt->err->hbr_qd->$id_lng.$jrn.'</span><br/>';}
?>
					<table>
<?php
							if(
								(
									(
										$id_cat_prs>0 and (empty($opt_prs_trf_srv_cat[$id_trf][$id_cat_prs]) and empty($opt_prs_cst_srv_cat[$id_trf][$id_cat_prs]))
										or (count(array_unique($opt_prs_trf_srv_cat[$id_trf][$id_cat_prs]))==1 and count(array_unique($opt_prs_cst_srv_cat[$id_trf][$id_cat_prs]))==1)
									)
									or
									(
										$id_cat_prs==0 and (empty($opt_prs_trf_srv[$id_dev_prs]) and empty($opt_prs_cst_srv[$id_dev_prs]))
										or (count(array_unique($opt_prs_trf_srv[$id_dev_prs]))==1 and count(array_unique($opt_prs_cst_srv[$id_dev_prs]))==1)
									)
								)
								and !$ptl and !isset($err_trf_srv_opt_prs[$id_dev_prs])
							){
								if($id_cat_prs>0){
									$prx = $opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][0]+$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;
									$cst = $opt_prs_cst_srv_cat[$id_trf][$id_cat_prs][0]+$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;
								}
								else{
									$prx = $opt_prs_trf_srv[$id_dev_prs][0]+$trf_db_hbr_opt_prs[$id_dev_prs]/2;
									$cst = $opt_prs_trf_srv[$id_dev_prs][0]+$cst_db_hbr_opt_prs[$id_dev_prs]/2;
								}
								if(count($bss[$id_trf])==1){$base = $txt->base->$id_lng.' '.$bss[$id_trf][0];}
								else{$base = $txt->bases->$id_lng.' '.$bss[$id_trf][0].'-'.$bss[$id_trf][count($bss[$id_trf])-1];}
	?>
						<tr>
							<td style="padding: 0px 5px;"><?php if(number_format($prx,0)!=0){echo $base.' :';} ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
	<?php
								echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
								if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
	?>
							</td>
						</tr>
	<?php
							}
							elseif(isset($bss[$id_trf])){
								foreach($bss[$id_trf] as $i => $base){
									if($id_cat_prs>0){
										$prx = $opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][$i]+$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;
										$cst = $opt_prs_cst_srv_cat[$id_trf][$id_cat_prs][$i]+$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;
										if($ptl){
											$prx += $cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/(2*$base);
											$cst += $cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/(2*$base);
										}
										if($psg){
											$prx += ($cst_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs]-$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2)/$base;
											$cst += ($cst_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs]-$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2)/$base;
										}
									}
									else{
										$prx = $opt_prs_trf_srv[$id_dev_prs][$i]+$trf_db_hbr_opt_prs[$id_dev_prs]/2;
										$cst = $opt_prs_cst_srv[$id_dev_prs][$i]+$cst_db_hbr_opt_prs[$id_dev_prs]/2;
										if($ptl){
											$prx += $cst_db_hbr_opt_prs[$id_dev_prs]/(2*$base);
											$cst += $cst_db_hbr_opt_prs[$id_dev_prs]/(2*$base);
										}
										if($psg){
											$prx += ($cst_sg_hbr_opt_prs[$id_dev_prs]-$cst_db_hbr_opt_prs[$id_dev_prs]/2)/$base;
											$cst += ($cst_sg_hbr_opt_prs[$id_dev_prs]-$cst_db_hbr_opt_prs[$id_dev_prs]/2)/$base;
										}
									}
?>
						<tr <?php if(isset($err_trf_srv_opt_prs[$id_dev_prs][$i])){echo ' style="color:red"';} ?>>
							<td style="padding: 0px 5px;">
<?php
									echo $txt->base->$id_lng.' '.$base;
									if($ptl){echo '+1';}
									echo ' :';
?>
							</td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;">
								<span class="usn">
<?php
									echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
									if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
								</span>
<?php
									if(isset($err_trf_srv_opt_prs[$id_dev_prs][$i])){echo ' - '.$txt->err->srv_jrn->$id_lng;}
?>
							</td>
						</tr>
<?php
								}
							}
							if($vue_sgl==1 and isset($hbr_id_opt_prs[$id_dev_prs])){
								if($id_cat_prs>0){
									$prx = $trf_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs]-$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;
									$cst = $cst_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs]-$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;
								}
								else{
									$prx = $trf_sg_hbr_opt_prs[$id_dev_prs]-$trf_db_hbr_opt_prs[$id_dev_prs]/2;
									$cst = $cst_sg_hbr_opt_prs[$id_dev_prs]-$cst_db_hbr_opt_prs[$id_dev_prs]/2;
								}
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->supsgl->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
								echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
								if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
							}
							if($vue_tpl==1 and isset($hbr_id_opt_prs[$id_dev_prs])){
								if($id_cat_prs>0){
									$prx = $trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2-$trf_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/3;
									$cst = $cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2-$cst_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/3;
								}
								else{
									$prx = $trf_db_hbr_opt_prs[$id_dev_prs]/2-$trf_tp_hbr_opt_prs[$id_dev_prs]/3;
									$cst = $cst_db_hbr_opt_prs[$id_dev_prs]/2-$cst_tp_hbr_opt_prs[$id_dev_prs]/3;
								}
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->redtpl->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
								echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
								if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
							}
							if($vue_qdp==1 and isset($hbr_id_opt_prs[$id_dev_prs])){
								if($id_cat_prs>0){
									$prx = $trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2-$trf_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/4;
									$cst = $cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2-$cst_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/4;
								}
								else{
									$prx = $trf_db_hbr_opt_prs[$id_dev_prs]/2-$trf_qd_hbr_opt_prs[$id_dev_prs]/4;
									$cst = $cst_db_hbr_opt_prs[$id_dev_prs]/2-$cst_qd_hbr_opt_prs[$id_dev_prs]/4;
								}
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->redqdp->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
								echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
								if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
							}
?>
					</table>
<?php
							if(isset($opt_srv_id_opt_prs[$id_dev_prs])){
								foreach($opt_srv_id_opt_prs[$id_dev_prs] as $j => $id_srv){
									if($id_srv>0){$rq_nom_srv = sel_quo("nom","cat_srv LEFT JOIN cat_srv_txt ON cat_srv.id = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"cat_srv.id",$id_srv);}
									else{$rq_nom_srv = sel_quo("nom","dev_srv","id",-$id_srv);}
									$dt_nom_srv = ftc_ass($rq_nom_srv);
?>
					<span class="em">
<?php
									if(!empty($dt_nom_srv['titre'])){echo $dt_nom_srv['titre'];}
									else{echo $dt_nom_srv['nom'];}
?>
					</span>
					<table>
<?php
									if(isset($bss[$id_trf])){
										foreach($bss[$id_trf] as $i => $base){
											if($id_cat_prs>0){
												$prx = $trf_opt_srv_opt_prs_cat[$id_cat_prs][$j][$i];
												$cst = $cst_opt_srv_opt_prs_cat[$id_cat_prs][$j][$i];
												$err = $err_trf_opt_srv_opt_cat[$id_cat_prs][$j][$i];
											}
											else{
												$prx = $trf_opt_srv_opt_prs[$id_dev_prs][$j][$i];
												$cst = $cst_opt_srv_opt_prs[$id_dev_prs][$j][$i];
												$err = $err_trf_opt_srv_opt_prs[$id_dev_prs][$j][$i];
											}
?>
						<tr>
							<td style="padding: 0px 5px;">
<?php
											echo $txt->base->$id_lng.' '.$base;
											if($ptl){echo '+1';}
											echo ' :';
											if($err){echo '<span class="color-red">'.$txt->err->opt_srv->$id_lng.'</span>';}
?>
							</td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn"><?php echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').') ('.number_format((1-$cst/$prx)*100,0).'%)';	?></td>
						</tr>
<?php
										}
									}
?>
					</table>
<?php
								}
							}
							if(isset($hbr_id_opt_prs[$id_dev_prs])){
?>
					<br/>
					<span class="em"><?php echo $txt->hbr_sel->$id_lng; ?></span>
					<table>
						<tr>
							<td class="stl4"><?php echo $txt->villes->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->categories->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->hebergements->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->chambres->$id_lng; ?></td>
						</tr>
<?php
								foreach($hbr_id_opt_prs[$id_dev_prs] as $i => $id_hbr){
?>
						<tr>
<?php
									if($id_hbr>0){
										$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
?>
							<td class="stl4"><?php echo stripslashes($vll[$dt_hbr['id_vll']]); ?></td>
							<td class="stl4"><?php echo $ctg_hbr[$id_lng][$dt_hbr['ctg']]; ?></td>
							<td class="stl4">
<?php
										if(empty($dt_hbr['titre'])){echo stripslashes($dt_hbr['nom']);}
										elseif(!empty($dt_hbr['web'])){echo '<a href="'.$dt_hbr['web'].'" target="_blank">'.stripslashes($dt_hbr['titre']).'</a>';}
										else{echo stripslashes($dt_hbr['titre']);}
?>
							</td>
							<td class="stl4">
<?php
										if($chm_id_opt_prs[$id_dev_prs][$i]!=0){
											$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$chm_id_opt_prs[$id_dev_prs][$i]));
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
							<td class="stl4"><?php echo stripslashes($vll[$vll_hbr_opt_prs[$id_dev_prs][$i]]); ?></td>
							<td class="stl4"><?php echo $txt->err->hbr->$id_lng; ?></td>
<?php
									}
?>
						</tr>
<?php
								}
?>
					</table>
<?php
								if(isset($opt_hbr_id_opt_prs[$id_dev_prs])){
?>
					<br/>
					<span class="em"><?php echo $txt->hbr_opt->$id_lng; ?></span>
					<table>
						<tr>
							<td class="stl4"><?php echo $txt->villes->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->categories->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->hebergements->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->chambres->$id_lng; ?></td>
							<td class="stl4"><?php echo $txt->trf->supplements->$id_lng; ?></td>
						</tr>
<?php
									foreach($opt_hbr_id_opt_prs[$id_dev_prs] as $i => $id_hbr){
										if($id_cat_prs>0){
											$prx = $trf_opt_hbr_db_opt_prs_cat[$id_cat_prs][$i]/2;
											$prx_sg = $trf_opt_hbr_sg_opt_prs_cat[$id_cat_prs][$i];
											$prx_tp = $trf_opt_hbr_tp_opt_prs_cat[$id_cat_prs][$i]/3;
											$prx_qd = $trf_opt_hbr_qd_opt_prs_cat[$id_cat_prs][$i]/4;
											$cst = $cst_opt_hbr_db_opt_prs_cat[$id_cat_prs][$i]/2;
											$cst_sg = $cst_opt_hbr_sg_opt_prs_cat[$id_cat_prs][$i];
											$cst_tp = $cst_opt_hbr_tp_opt_prs_cat[$id_cat_prs][$i]/3;
											$cst_qd = $cst_opt_hbr_qd_opt_prs_cat[$id_cat_prs][$i]/4;
											$err_sg = $err_trf_sg_opt_hbr_opt_prs_cat[$id_cat_prs][$i];
											$err_db = $err_trf_db_opt_hbr_opt_prs_cat[$id_cat_prs][$i];
											$err_tp = $err_trf_tp_opt_hbr_opt_prs_cat[$id_cat_prs][$i];
											$err_qd = $err_trf_qd_opt_hbr_opt_prs_cat[$id_cat_prs][$i];
										}
										else{
											$prx = $trf_opt_hbr_db_opt_prs[$id_dev_prs][$i]/2;
											$prx_sg = $trf_opt_hbr_sg_opt_prs[$id_dev_prs][$i];
											$prx_tp = $trf_opt_hbr_tp_opt_prs[$id_dev_prs][$i]/3;
											$prx_qd = $trf_opt_hbr_qd_opt_prs[$id_dev_prs][$i]/4;
											$cst = $cst_opt_hbr_db_opt_prs[$id_dev_prs][$i]/2;
											$cst_sg = $cst_opt_hbr_sg_opt_prs[$id_dev_prs][$i];
											$cst_tp = $cst_opt_hbr_tp_opt_prs[$id_dev_prs][$i]/3;
											$cst_qd = $cst_opt_hbr_qd_opt_prs[$id_dev_prs][$i]/4;
											$err_sg = $err_trf_sg_opt_hbr_opt_prs[$id_dev_prs][$i];
											$err_db = $err_trf_db_opt_hbr_opt_prs[$id_dev_prs][$i];
											$err_tp = $err_trf_tp_opt_hbr_opt_prs[$id_dev_prs][$i];
											$err_qd = $err_trf_qd_opt_hbr_opt_prs[$id_dev_prs][$i];
										}
?>
						<tr>
<?php
										if($id_hbr>0){
											$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
?>
							<td class="stl4"><?php echo stripslashes($vll[$dt_hbr['id_vll']]); ?></td>
							<td class="stl4"><?php echo stripslashes($ctg_hbr[$id_lng][$dt_hbr['ctg']]); ?></td>
							<td class="stl4">
<?php
											if(empty($dt_hbr['titre'])){echo stripslashes($dt_hbr['nom']);}
											elseif(!empty($dt_hbr['web'])){echo '<a href="'.$dt_hbr['web'].'" target="_blank">'.stripslashes($dt_hbr['titre']).'</a>';}
											else{echo stripslashes($dt_hbr['titre']);}
?>
							</td>
							<td class="stl4">
<?php
											if($opt_chm_id_opt_prs[$id_dev_prs][$i]!=0){
												$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$opt_chm_id_opt_prs[$id_dev_prs][$i]));
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
							<td class="stl4"><?php echo stripslashes($vll[$opt_hbr_vll_opt_prs[$id_dev_prs][$i]]); ?></td>
							<td class="stl4"><?php echo $txt->err->hbr->$id_lng; ?></td>
							<td class="stl4"></td>
							<td class="stl4"></td>
<?php
										}
?>
							<td class="stl4">
<?php
										if($vue_sgl==1){
											echo $txt->sgl->$id_lng.' : ';
											if(!$err_sg){echo number_format($prx_sg,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng.' <span class="usn">('.number_format($cst_sg,0,',',' ').') ('.number_format($prx_sg-$cst_sg,0,',',' ').') ('.number_format((1-$cst_sg/$prx_sg)*100,0).'%)</span>';}
											else{echo $txt->err->trf->$id_lng;}
											echo '<br/>';
										}
										if($vue_dbl==1){
											echo $txt->dbl->$id_lng.' : ';
											if(!$err_db){echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng.' <span class="usn">('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').') ('.number_format((1-$cst/$prx)*100,0).'%)</span>';}
											else{echo $txt->err->trf->$id_lng;}
											echo '<br/>';
										}
										if($vue_tpl==1){
											echo $txt->tpl->$id_lng.' : ';
											if(!$err_tp){echo number_format($prx_tp,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng.' <span class="usn">('.number_format($cst_tp,0,',',' ').') ('.number_format($prx_tp-$cst_tp,0,',',' ').') ('.number_format((1-$cst_tp/$prx_tp)*100,0).'%)</span>';}
											else{echo $txt->err->trf->$id_lng;}
											echo '<br/>';
										}
										if($vue_qdp==1){
											echo $txt->qdp->$id_lng.' : ';
											if(!$err_qd){echo number_format($prx_qd,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng.' <span class="usn">('.number_format($cst_qd,0,',',' ').') ('.number_format($prx_qd-$cst_qd,0,',',' ').') ('.number_format((1-$cst_qd/$prx_qd)*100,0).'%)</span>';}
											else{echo $txt->err->trf->$id_lng;}
											echo '<br/>';
										}
?>
							</td>
						</tr>
<?php
									}
?>
					</table>
<?php
								}
?>
					<br/>
<?php
							}
?>
					<br/>
<?php
						}
					}
				}
			if($id_trf==0){$flg_trf_mdl=false;}
			}
		}
	}
	if(isset($sel_prs_id)){
?>
					<hr/>
					<strong><?php echo $txt->trf->dt_trf->$id_lng; ?></strong>
					<br/>
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
					<span class="em">
<?php
						if($flg_s){echo $txt->jours->$id_lng.' '.$jrn.' : ';}
						else{echo $txt->jour->$id_lng.' '.$jrn.' : ';}
						if(!empty($dt_ttr['titre'])){echo stripslashes($dt_ttr['titre']);}
						else{echo stripslashes($dt_ttr['nom']);}
?>
					</span>
					<br/>
					<table>
<?php
						if(
							(
								(
									$id_cat_prs>0 and (empty($sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs]) and empty($sel_prs_cst_srv_cat[$id_dev_mdl][$id_cat_prs]))
									or (count(array_unique($sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs]))==1 and count(array_unique($sel_prs_cst_srv_cat[$id_dev_mdl][$id_cat_prs]))==1)
								)
								or
								(
									$id_cat_prs==0 and (empty($sel_prs_trf_srv[$id_dev_prs]) and empty($sel_prs_cst_srv[$id_dev_prs]))
									or (count(array_unique($sel_prs_trf_srv[$id_dev_prs]))==1 and count(array_unique($sel_prs_cst_srv[$id_dev_prs]))==1)
								)
							)
							and !$ptl and !isset($err_sel_prs_trf_srv[$id_dev_prs])
						){
							if($id_cat_prs>0){
								$prx = $sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs][0]+$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;
								$cst = $sel_prs_cst_srv_cat[$id_dev_mdl][$id_cat_prs][0]+$cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;
							}
							else{
								$prx = $sel_prs_trf_srv[$id_dev_prs][0]+$trf_db_hbr_sel_prs[$id_dev_prs]/2;
								$cst = $sel_prs_cst_srv[$id_dev_prs][0]+$cst_db_hbr_sel_prs[$id_dev_prs]/2;
							}
							if(count($bss[$id_trf])==1){$base = $txt->base->$id_lng.' '.$bss[$id_trf][0];}
							else{$base = $txt->bases->$id_lng.' '.$bss[$id_trf][0].'-'.$bss[$id_trf][count($bss[$id_trf])-1];}
?>
						<tr>
							<td style="padding: 0px 5px;"><?php if(number_format($prx,0)!=0){echo $base.' :';} ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
							echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
							if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
						}
						elseif(isset($bss[$id_trf])){
							foreach($bss[$id_trf] as $i => $base){
								if($id_cat_prs>0){
									$prx = $sel_prs_trf_srv_cat[$id_dev_mdl][$id_cat_prs][$i]+$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;
									$cst = $sel_prs_cst_srv_cat[$id_dev_mdl][$id_cat_prs][$i]+$cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;
									if($ptl){
										$prx += $cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/(2*$base);
										$cst += $cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/(2*$base);
									}
									if($psg){
										$prx += ($cst_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]-$cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2)/$base;
										$cst += ($cst_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]-$cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2)/$base;
									}
								}
								else{
									$prx = $sel_prs_trf_srv[$id_dev_prs][$i]+$trf_db_hbr_sel_prs[$id_dev_prs]/2;
									$cst = $sel_prs_cst_srv[$id_dev_prs][$i]+$cst_db_hbr_sel_prs[$id_dev_prs]/2;
									if($ptl){
										$prx += $cst_db_hbr_sel_prs[$id_dev_prs]/(2*$base);
										$cst += $cst_db_hbr_sel_prs[$id_dev_prs]/(2*$base);
									}
									if($psg){
										$prx += ($cst_sg_hbr_sel_prs[$id_dev_prs]-$cst_db_hbr_sel_prs[$id_dev_prs]/2)/$base;
										$cst += ($cst_sg_hbr_sel_prs[$id_dev_prs]-$cst_db_hbr_sel_prs[$id_dev_prs]/2)/$base;
									}
								}
?>
						<tr>
							<td style="padding: 0px 5px;">
<?php
							echo $txt->base->$id_lng.' '.$base;
							if($ptl){echo '+1';}
							echo ' :';
?>
							</td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
						echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
						if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
						if($err_sel_prs_trf_srv[$id_dev_prs][$i]){echo '<span class="color-red">'.$txt->err->srv_jrn->$id_lng.'</span>';}
?>
							</td>
						</tr>
<?php
							}
						}
						if($vue_sgl==1 and $trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_sg_hbr_sel_prs[$id_dev_prs]>0){
							if($id_cat_prs>0){
								$prx = $trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]-$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;
								$cst = $cst_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]-$cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;
							}
							else{
								$prx = $trf_sg_hbr_sel_prs[$id_dev_prs]-$trf_db_hbr_sel_prs[$id_dev_prs]/2;
								$cst = $cst_sg_hbr_sel_prs[$id_dev_prs]-$cst_db_hbr_sel_prs[$id_dev_prs]/2;
							}
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->supsgl->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
								echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
								if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
						}
						if($vue_tpl==1 and $trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_tp_hbr_sel_prs[$id_dev_prs]>0){
							if($id_cat_prs>0){
								$prx = $trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2-$trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/3;
								$cst = $cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2-$cst_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/3;
							}
							else{
								$prx = $trf_db_hbr_sel_prs[$id_dev_prs]/2-$trf_tp_hbr_sel_prs[$id_dev_prs]/3;
								$cst = $cst_db_hbr_sel_prs[$id_dev_prs]/2-$cst_tp_hbr_sel_prs[$id_dev_prs]/3;
							}
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->redtpl->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
								echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
								if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
						}
						if($vue_qdp==1 and $trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_qd_hbr_sel_prs[$id_dev_prs]>0){
							if($id_cat_prs>0){
								$prx = $trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2-$trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/4;
								$cst = $cst_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2-$cst_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/4;
							}
							else{
								$prx = $trf_db_hbr_sel_prs[$id_dev_prs]/2-$trf_qd_hbr_sel_prs[$id_dev_prs]/4;
								$cst = $cst_db_hbr_sel_prs[$id_dev_prs]/2-$cst_qd_hbr_sel_prs[$id_dev_prs]/4;
							}
?>
						<tr>
							<td style="padding: 0px 5px;"><?php echo $txt->trf->redqdp->$id_lng; ?></td>
							<td style="padding: 0px 5px;"><?php echo number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt->trf->parpers->$id_lng; ?></td>
							<td style="padding: 0px 5px;" class="usn">
<?php
							echo '('.number_format($cst,0,',',' ').') ('.number_format($prx-$cst,0,',',' ').')';
							if($prx!=0){echo '('.number_format((1-$cst/$prx)*100,0).'%)';}
?>
							</td>
						</tr>
<?php
						}
?>
					</table>
					<br/>
<?php
					}
				}
			}
		}
	}
?>
				</td>
				<td>
<?php
	foreach($map as $i => $lnk){
		if(mb_strlen($lnk)>118){
			if($i==0){echo '<strong class="usn">'.$txt->trf->map1->$id_lng.'</strong><br/>';}
			else{echo '<strong class="usn">'.$txt->trf->map2->$id_lng.'</strong><br/>';}
			//echo $lnk.'<br />';
			echo '<image src="'.$lnk.'"  class="usa" /><br/>';
			echo stripslashes($leg[$i]).'<br />';
		}
	}
?>
				</td>
			</tr>
		</table>
	</body>
</html>
<?php
}
?>
