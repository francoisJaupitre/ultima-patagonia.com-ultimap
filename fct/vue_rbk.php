<?php
if(isset($_GET['id']) and $_GET['id']>0 and isset($_GET['id_lgg']) and $_GET['id_lgg']>=0){
	$id = $_GET['id'];
	$lgg_id = $_GET['id_lgg'];
	$txt = simplexml_load_file('txt.xml');
	$txt_prg = simplexml_load_file('txt_prg.xml');
	$cbl = 'dev';
	$googlekey = "AIzaSyBuXaGEpXzsBNlbuHyX-WCm7QkXtPj1LKs";
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("prg.php");
	include("../prm/ctg_prs.php");
	include("../prm/ctg_srv.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('forme.css'))  ?>" />
		<link rel="stylesheet" type="text/css" href="../prm/forme.css?version=<?php echo date('Y-m-d-H-i-s', filemtime('../prm/forme.css'))  ?>" />
		<link rel="stylesheet" type="text/css" href="../prm/css/<?php echo $dir.'/tmpl'.$clt_tmpl[$id_clt].'.css?version='.date('Y-m-d-H-i-s', filemtime('../prm/css/'.$dir.'/tmpl'.$clt_tmpl[$id_clt].'.css')) ?>" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXaGEpXzsBNlbuHyX-WCm7QkXtPj1LKs"></script>
		<script><?php include("script.js"); ?></script>
	</head>
	<body onload="act_tab('rbk',<?php echo $id ?>,'dev',<?php echo $lgg_id ?>);vue_map('<?php echo $dir ?>')">
		<div id="wrapper">
			<input type="button" value="<?php echo $txt->prg->act->$id_lng; ?>" onclick="document.location.replace('vue_rbk.php?id=<?php echo $id ?>&id_lgg=<?php echo $lgg_id ?>');" />
			<input type="button" value="<?php echo $txt->prg->docx->$id_lng; ?>" onclick="window.open('docx_rbk.php?id=<?php echo $id ?>&id_lgg=<?php echo $lgg_id ?>');" />
		</div>
		<br />
		<br />
		<div class="bck">
			<div class="pge">
<?php
if($clt_tmpl[$id_clt]==1){

}
elseif(!$clt_tmpl[$id_clt]){
?>
				<div class="div0 bg-blue">
					<img src="<?php echo '../prm/img/'.$dir.'/bandeau1.jpg' ?>" width="800"/>
					<table class="w-100">
						<tr>
							<td><div class="div1 wsn">Votre carnet de bord :</div></td>
							<td>
								<div class="div1"><?php echo stripslashes(trim($txt_crc[1])) ?></div>
								<div class="div2"><?php echo stripslashes(trim($txt_crc[2])) ?></div>
							</td>
						</tr>
					</table>
					</div>
					<br />
					<div class="div3">
<?php
}
	$img = array();
	foreach($pic as $pi){
		foreach($pi as $p){$img[] = $p;}
	}
	if(count($img)>9){$nb = 9;}
	else{$nb = count($img);}
	$ran = array_rand($img,$nb);
	if($nb>2){$wdt = 230;}
	else{$wdt = 345;}
	foreach($ran as $k){
?>
						<img src="<?php echo '../pic/'.$dir.'/'.$img[$k]; ?>" width="<?php echo $wdt; ?>" />
<?php
	}
?>
					</div>
				</div>
				<div class="pge">
					<div style="page-break-before: always;">
						<div class="div3">
<?php
	$k=0;
	$rq_pax = sel_quo("base","dev_crc_bss",array("vue","id_crc"),array("1",$id));
	while($dt_pax = ftc_ass($rq_pax)){
		$nb_pax_crc = $dt_pax['base'];
		$k++;
	}
	if($k!=1){$flg_err_crc = true;}
	$ii = 0;
	if(isset($lst_mdl['id'])){
		foreach($lst_mdl['id'] as $id_mdl){
			$rsp_crc = '';
			$rsp_mdl = '';
			if($lst_mdl['trf'][$id_mdl]){
				$k=0;
				$rq_pax = sel_quo("base","dev_mdl_bss",array("vue","id_mdl"),array("1",$id_mdl));
				while($dt_pax = ftc_ass($rq_pax)){
					$nb_pax = $dt_pax['base'];
					$k++;
				}
				if($k!=1){$rsp_mdl = $txt->res_frn->msg2->$id_lng.$lst_mdl['ord'][$id_mdl].".\n";}
			}
			else{
				if($flg_err_crc){$rsp_crc = $txt->res_frn->msg1->$id_lng.".\n";}
				$nb_pax = $nb_pax_crc;
			}
			$rq_jrn = sel_quo("id,date,ord,id_cat","dev_jrn",array("opt","id_mdl"),array("1",$id_mdl),"ord");
			while($dt_jrn = ftc_ass($rq_jrn)){
				$id_dev_jrn = $dt_jrn['id'];
				$id_cat_jrn = $dt_jrn['id_cat'];
				$date_jrn = $dt_jrn['date'];
				if(empty($date_jrn) or $date_jrn=="0000-00-00"){
					$rsp_crc .= $txt->res_frn->msg3->$id_lng.$dt_jrn['ord'].".\n";
					$rsp_mdl .= $txt->res_frn->msg3->$id_lng.$dt_jrn['ord'].".\n";
				}
				if($id_cat_jrn>0){
					$rq_jrn_vll = sel_quo("id_vll","cat_jrn_vll","id_jrn",$id_cat_jrn,"ord");
					while($dt_jrn_vll = ftc_ass($rq_jrn_vll)){
						if(!in_array($dt_jrn_vll['id_vll'],$jrn_vll)){$jrn_vll[] = $dt_jrn_vll['id_vll'];}
					}
				}
				$rq_prs = sel_quo("id,id_cat,ctg,res,opt,heure,info","dev_prs","id_jrn",$id_dev_jrn,"ord");//ajouter res = 2 (prestations confirméés).
				while($dt_prs = ftc_ass($rq_prs)){
					$id_ctg_prs = $dt_prs['ctg'];
					if($mrk_srv_ctg_prs[$id_ctg_prs] or $id_ctg_prs==1 or $id_ctg_prs==19 or $id_ctg_prs==20){
						$id_dev_prs = $dt_prs['id'];
						$id_cat_prs = $dt_prs['id_cat'];
						if(!$id_cat_jrn and $id_ctg_prs!=10){
							$rq_prs_vll = sel_quo("id_vll","cat_lieu INNER JOIN cat_prs_lieu ON cat_lieu.id = cat_prs_lieu.id_lieu","id_prs",$id_cat_prs,"ord");
							while($dt_prs_vll = ftc_ass($rq_prs_vll)){
								if(!in_array($dt_prs_vll['id_vll'],$jrn_vll)){$jrn_vll[] = $dt_prs_vll['id_vll'];}
							}
						}
						$prs_vll[$id_dev_prs] = $jrn_vll;
						unset($jrn_vll);
						$flg_prs = false;
						$rq_srv = sel_quo("id,opt,rva","dev_srv","id_prs",$id_dev_prs);
						while($dt_srv = ftc_ass($rq_srv)){
							if((($cnf>0 and $dt_prs['res']==1) or ($cnf<1 and $dt_prs['opt']==1)) and $dt_srv['opt']==1){
								$id_dev_srv = $dt_srv['id'];
								if($prs[$ii-1] != $id_cat_prs or $nb_pax != $nbp[$ii-1] or date ('Y-m-d', strtotime ("-".$j." days $date_jrn")) != $srv_in[$ii-1] or ($dt_srv['rva']!='' and $dt_srv['rva']!=$rva[$ii-1]) or (!is_null($dt_prs['heure']) and $dt_prs['heure']!=$hre[$ii-1]) or ($dt_prs['info']!='' and $dt_prs['info']!=$info[$ii-1]) or $id_ctg_prs==10){
									$rva[$ii] = $dt_srv['rva'];
									$prs[$ii] = $id_cat_prs;
									$nbp[$ii] = $nb_pax;
									$srv_in[$ii] = $date_jrn;
									$hre[$ii] = $dt_prs['heure'];
									$info[$ii] = $dt_prs['info'];
									$prs_ctg[$ii] = $id_ctg_prs;
									$prs_id[$ii] = $id_dev_prs;
									$jrn[$ii] = $id_cat_jrn;
									$jrn_id[$ii] = $id_dev_jrn;
									$mdl[$ii] = $id_mdl;
									$old_dat[$ii] = $date_jrn;
									$flg_out = $flg_prs = true;
									$ii++;
									$j = 1;
								}
								else{
									$j++;
									foreach($old_dat as $k => $old){$old_dat[$k]=$date_jrn;}
								}
							}
							$lst_srv[] = $id_dev_srv;
						}
						if(!$flg_prs){
							$srv_in[$ii] = $date_jrn;
							$prs[$ii] = $id_cat_prs;
							$prs_id[$ii] = $id_dev_prs;
							$jrn_id[$ii] = $id_dev_jrn;
							$mdl[$ii] = $id_mdl;
							$ii++;
						}
					}
					else{$flg_out = true;}
				}
				if($flg_out){
					$flg_srv = false;
					for($k=0; $k<$ii;$k++){
						if(isset($old_dat[$k])){
							if($old_dat[$k]!=$date_jrn){
								$srv_out[$k] = $old_dat[$k];
								unset($old_dat[$k]);
							}
							else{$flg_srv=true;}
						}
					}
					$flg_out = $flg_srv;
				}
			}
			if($lst_mdl['trf'][$id_mdl]){$rsp .= $rsp_mdl;}
			else{$rsp .= $rsp_crc;}
		}
	}
	$date_jrn = date('Y-m-d', strtotime ("+1 days $date_jrn"));
	if($flg_out){
		for($k=0; $k<$ii;$k++){;
			if(isset($old_dat[$k]) and $old_dat[$k]!=$date_jrn){$srv_out[$k] = $old_dat[$k];}
		}
	}
	unset($old_dat,$nbpx);
	if(count(array_unique($nbp)) > 1){
		foreach(array_unique($nbp) as $pax){$nbpx .= $pax.' / ';}
		$nbpax = substr($nbpx, 0, -3);
		$flg_mlt_pax = true;
	}
	else{
		$nbpax = $nbp[0];
		$flg_mlt_pax = false;
	}
	foreach($prs as $j => $pr){
		if(isset($srv_in[$j])){
			$dat = date("d/m/Y", strtotime($srv_in[$j]));
			if($srv_out[$j]!=$srv_in[$j] and $srv_out[$j]!=''){$dat .= ' - '.date("d/m/Y", strtotime($srv_out[$j]));}
		}
		foreach($prs_vll[$prs_id[$j]] as $id_vll){
			unset($prs_vll[$prs_id[$j]]);
			if($id_vll != $old_vll){
				$old_vll = $id_vll;
				if(isset($old_dat)){echo '<br /><br />';}
				if(!in_array($id_vll,$dev_vll)){
					$dt_vll_txt = ftc_ass(sel_quo("dsc","cat_vll_txt",array("id_vll","lgg"),array($id_vll,$lgg_crc)));
					$dev_vll[] = $id_vll;

?>
							<div style="page-break-inside: avoid">
								<div class="fs_mdl" style="color:#<?php echo $col[$lst_mdl['col'][$mdl[$j]]] ?>;"><?php echo stripslashes($vll[$id_vll]); ?></div>
<?php
					if(isset($dt_vll_txt['dsc'])){
?>
								<div class="fs4"><?php echo stripslashes(trim($dt_vll_txt['dsc'])) ?></div>
<?php
					}
?>
								<br />
							</div>
<?php
					$flg_br = true;
				}
			}
		}
		if(isset($prs_ctg[$j])){
			if($dat!=$old_dat){
				$flg_div = true;
?>
							<div style="page-break-inside: avoid">
								<div class="fs_jrn" style="color:#<?php echo $col[$lst_mdl['col'][$mdl[$j]]] ?>;"><?php echo $dat ?></div>
<?php
				$old_dat = $dat;
			}
			if($jrn_id[$j] != $old_jrn){
				$old_jrn = $jrn_id[$j];
				$dt_mdl = ftc_ass(sel_quo("trf,id_crc,ptl","dev_mdl","id",$mdl[$j]));
				if(!$dt_mdl['trf']){
					$dt_crc = ftc_ass(sel_quo("ptl","dev_crc","id",$dt_mdl['id_crc']));
					$ptl=$dt_crc['ptl'];
				}
				else{$ptl=$dt_mdl['ptl'];}
?>
								<div class="fs_jrn" style="color:#<?php echo $col[$lst_mdl['col'][$mdl[$j]]] ?>;">
<?php
				$dt_dev_jrn = ftc_ass(sel_quo("nom,titre","dev_jrn","id",$jrn_id[$j]));
				if(empty($dt_dev_jrn['titre'])){echo stripslashes($dt_dev_jrn['nom']);}
				else{echo stripslashes($dt_dev_jrn['titre']);}
?>
								</div>
<?php
			}
			if($pr!=$old_prs or $dat!=$old_dat_prs){
				$old_prs = $pr;
				$old_dat_prs = $dat;
				if($flg_mlt_pax and isset($nbp[$j])){
					if(!isset($ult_pax) or $nbp[$j]!=$ult_pax){
?>
								<div class="fs10">__________<br />x<?php echo $nbp[$j]; if($ptl){echo '&#43;1';} ?></div>
<?php
						$ult_pax = $nbp[$j];
						$flg_br = false;
					}
				}
				if($flg_br){
					echo '<br />';
					$flg_br = false;
				}
				if($jrn[$j]>0){$rq_jrn_lieu = sel_quo("id_lieu","cat_jrn_lieu","id_jrn",$jrn[$j],"ord");}
				if(num_rows($rq_jrn_lieu)>0){
					unset($lieu_prs[$pr]);
					while($dt_jrn_lieu = ftc_ass($rq_jrn_lieu)){$lieu_prs[$pr][] = $dt_jrn_lieu['id_lieu'];}
					$flg_map[$prs_id[$j]] = true;
				}
				if($pr>0){//echo 'A';
					if(!isset($lieu_prs[$pr])){
						if($prs_ctg[$j]!=10){ //remplacer par !$doc_srv_ctg_prs ?? exclus permis transfrontalier
							$rq_prs_lieu = sel_quo("id_lieu","cat_prs_lieu","id_prs",$pr,"ord");
							while($dt_prs_lieu = ftc_ass($rq_prs_lieu)){$lieu_prs[$pr][] = $dt_prs_lieu['id_lieu'];}
						}
						if($prs_ctg[$j]==10 or ($flg_map[$prs_id[$j]] and $prs_ctg[$j]==20)){
							$lieu_prs[$pr] = $lieu_avt = $lieu_vll = $lst_vll = $lieu_apr = array();
							for($k=1;$k>0;$k++){
								$rq_prs_lieu = sel_quo("id_lieu,id_vll","cat_prs_lieu INNER JOIN cat_lieu ON cat_lieu.id = cat_prs_lieu.id_lieu",array("rbk","id_prs"),array("1",$prs[$j-$k]),"ord DESC");
								while($dt_prs_lieu = ftc_ass($rq_prs_lieu)){
									if($prs_ctg[$j-$k]!=10){
										$lieu_avt[] = $dt_prs_lieu['id_lieu'];
										$lst_vll[] = $dt_prs_lieu['id_vll'];
										if($prs_ctg[$j-$k]==10 or $prs_ctg[$j-$k]==19 or $srv_in[$j]!=$srv_in[$j-$k]){
											unset($rq_prs_lieu);
											$k=-1;
										}
									}
									else{
										unset($rq_prs_lieu);
										$k=-1;
									}
								}
							}
							if($prs_ctg[$j]==10 or !$flg_map[$prs_id[$j]]){
								for($k=1;$k>0;$k++){
									$rq_prs_lieu = sel_quo("id_lieu,id_vll","cat_prs_lieu INNER JOIN cat_lieu ON cat_lieu.id = cat_prs_lieu.id_lieu",array("rbk","id_prs"),array("1",$prs[$j+$k]),"ord");
									while($dt_prs_lieu = ftc_ass($rq_prs_lieu)){
										if($prs_ctg[$j+$k]!=10 and $srv_in[$j]==$srv_in[$j+$k] and ($prs[$j+$k]!=$prs[$j+$k-1] or $k==1)){
											$lieu_apr[] = $dt_prs_lieu['id_lieu'];
											$lst_vll[] = $dt_prs_lieu['id_vll'];
											if($prs_ctg[$j+$k]==20){
												unset($rq_prs_lieu);
												$k=-1;
											}
										}
										elseif($srv_in[$j]!=$srv_in[$j+$k]){
											$flg_map[$prs_id[$j+$k]] = true;
											unset($rq_prs_lieu);
											$k=-1;
										}
									}
								}
							}
							else{
								$rq_prs_lieu = sel_quo("id_lieu,id_vll","cat_prs_lieu INNER JOIN cat_lieu ON cat_lieu.id = cat_prs_lieu.id_lieu",array("rbk","id_prs"),array("1",$prs[$j]),"ord");
								while($dt_prs_lieu = ftc_ass($rq_prs_lieu)){
									if($prs_ctg[$j+$k]!=10 and $srv_in[$j]==$srv_in[$j+$k]){
										$lieu_apr[] = $dt_prs_lieu['id_lieu'];
										$lst_vll[] = $dt_prs_lieu['id_vll'];
									}
								}
							}
							$rq_jrn_vll = sel_quo("id_vll","cat_jrn_vll","id_jrn",$jrn[$j],"ord");
							while($dt_jrn_vll = ftc_ass($rq_jrn_vll)){
								if(!in_array($dt_jrn_vll['id_vll'],$lst_vll)){$lieu_vll[]=-$dt_jrn_vll['id_vll'];}
							}
							$lieu_prs[$pr] = array_merge($lieu_avt,$lieu_vll,$lieu_apr);
						}
					}
				}
?>
								<div class="fs6">
<?php
				unset($msg);
				if(!is_null($hre[$j])){$msg = date("H:i", strtotime($hre[$j])).$txt_prg->hs->$id_lgg.": ";}
				if($doc_srv_ctg_prs[$prs_ctg[$j]] and isset($lieu_prs[$pr]) and $pr>0){$msg .= $ctg_prs[$id_lgg][$prs_ctg[$j]]." ";}
				if($pr>0){
					$dt_cat_prs = ftc_ass(sel_quo("nom,duree,is_out,titre","cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_crc,"cat_prs.id",$pr));
					if(!$dt_cat_prs['is_out']){$msg .= $info[$j]." ";}
				}
				$dt_prs = ftc_ass(sel_quo("id_jrn","dev_prs","id",$prs_id[$j]));
				$id_jrn = $dt_prs['id_jrn'];
				if(!isset($ord[$id_jrn])){$ord[$id_jrn]=1;}
				if($id_jrn!=$new_jrn){
					$new_jrn = $id_jrn;
					$flg_new = true;
					$rq_dev_prs = sel_quo("id,id_cat,res","dev_prs","id_jrn",$id_jrn);
					while($dt_dev_prs = ftc_ass($rq_dev_prs)){
						$rq_dev_hbr = sel_quo("id_cat,sel,opt","dev_hbr","id_prs",$dt_dev_prs['id']);
						while($dt_dev_hbr = ftc_ass($rq_dev_hbr)){
							if($dt_dev_hbr['id_cat']!=0){
								if($cnf>0 and ($dt_dev_hbr['sel'] or ($dt_dev_hbr['opt'] and $dt_dev_prs['res']==-1))){
									$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre,lat,lon","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$dt_dev_hbr['id_cat']));
									if($dt_cat_hbr['titre']==''){$new_hbr_nom = $dt_cat_hbr['nom'];}
									else{$new_hbr_nom = $dt_cat_hbr['titre'];}
									$new_vll = $dt_cat_hbr['id_vll'];
									$new_hbr_lat = $dt_cat_hbr['lat'];
									$new_hbr_lon = $dt_cat_hbr['lon'];
								}
								elseif($cnf<1 and $dt_dev_hbr['opt']){
									$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre,lat,lon","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$dt_dev_hbr['id_cat']));
									if($dt_cat_hbr['titre']==''){$new_hbr_nom = $dt_cat_hbr['nom'];}
									else{$new_hbr_nom = $dt_cat_hbr['titre'];}
									$new_vll = $dt_cat_hbr['id_vll'];
									$new_hbr_lat = $dt_cat_hbr['lat'];
									$new_hbr_lon = $dt_cat_hbr['lon'];
								}
							}
							else{$new_hbr_nom = "CAS NON ENVISAGE";}
						}
					}
				}
				if($flg_new or !isset($old_hbr_nom)){
					$flg_new = false;
					$dt_jrn = ftc_ass(sel_quo("date","dev_jrn","id",$id_jrn));
					$dat = $dt_jrn['date'];
					$dat = date("Y-m-d",strtotime("-1 days $dat"));
					$dt_mdl = ftc_ass(sel_quo("dev_mdl.id,dev_mdl.ord","dev_jrn LEFT JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id",$id_jrn));
					$dt_jrn = ftc_ass(sel_quo("id","dev_jrn",array("opt","date","id_mdl"),array("1",$dat,$dt_mdl['id'])));
					if($dt_jrn['id']==''){
						$ord_mdl = 	$dt_mdl['ord']-1;
						if($ord_mdl>0){
							$dt_mdl = ftc_ass(sel_quo("id","dev_mdl",array("id_crc","ord"),array($id,$ord_mdl)));
							$dt_jrn = ftc_ass(sel_quo("id","dev_jrn",array("opt","date","id_mdl"),array("1",$dat,$dt_mdl['id'])));
						}
					}
					if($dt_jrn['id']!=$old_jrn[$pr]){
						$old_jrn[$pr] = $dt_jrn['id_jrn'];
						$rq_dev_prs = sel_quo("id,id_cat,res","dev_prs","id_jrn",$dt_jrn['id']);
						while($dt_dev_prs = ftc_ass($rq_dev_prs)){
							$rq_dev_hbr = sel_quo("id_cat,sel,opt","dev_hbr","id_prs",$dt_dev_prs['id']);
							while($dt_dev_hbr = ftc_ass($rq_dev_hbr)){
								if($dt_dev_hbr['id_cat']!=0){
									if($cnf>0 and ($dt_dev_hbr['sel']==1 or ($dt_dev_hbr['opt']==1 and $dt_dev_prs['res']==-1))){
										$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre,lat,lon","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$dt_dev_hbr['id_cat']));
										if($dt_cat_hbr['titre']==''){$old_hbr_nom = $dt_cat_hbr['nom'].' HTL';}
										else{$old_hbr_nom = $dt_cat_hbr['titre'];}
										$old_hbr_vll = $dt_cat_hbr['id_vll'];
										$old_hbr_lat = $dt_cat_hbr['lat'];
										$old_hbr_lon = $dt_cat_hbr['lon'];
									}
									elseif($cnf<1 and $dt_dev_hbr['opt']==1){
										$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre,lat,lon","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$dt_dev_hbr['id_cat']));
										if($dt_cat_hbr['titre']==''){$old_hbr_nom = $dt_cat_hbr['nom'].' HTL';}
										else{$old_hbr_nom = $dt_cat_hbr['titre'];}
										$old_hbr_vll = $dt_cat_hbr['id_vll'];
										$old_hbr_lat = $dt_cat_hbr['lat'];
										$old_hbr_lon = $dt_cat_hbr['lon'];
									}
								}
								else{$old_hbr_nom = "CAS NON ENVISAGE";}
							}
						}
					}
				}
				$flg_un = false;
				if(isset($lieu_prs[$pr])){
					foreach($lieu_prs[$pr] as $id_lieu){
						if($flg_un){$msg .= " - ";}
						elseif($prs_ctg[$j]!=10){$flg_un = true;}
						if($id_lieu>0){
							$dt_lieu = ftc_ass(sel_quo("nom,hbr,titre,id_vll,lat,lon","cat_lieu LEFT JOIN cat_lieu_txt ON cat_lieu.id = cat_lieu_txt.id_lieu AND lgg=".$lgg_crc,"cat_lieu.id",$id_lieu));
							if($dt_lieu['hbr'] and $ord[$id_jrn]==1 and $old_hbr_nom!='' and $old_hbr_vll==$dt_lieu['id_vll']){
								$txt_map = $old_hbr_nom.' ('.$vll[$old_hbr_vll].')';
								if($prs_ctg[$j]==10 or ($flg_map[$prs_id[$j]] and $prs_ctg[$j]==20)){
									$lat[$prs_id[$j]][] = $old_hbr_lat;
									$lon[$prs_id[$j]][] = $old_hbr_lon;
									if($old_hbr_lat.','.$old_hbr_lon != $old_latlon){
										$mrk_map[$prs_id[$j]][] = $txt_map;
										$latlon[$prs_id[$j]][] = $old_hbr_lat.','.$old_hbr_lon;
										$old_latlon = $old_hbr_lat.','.$old_hbr_lon;
									}
								}
								elseif($prs_ctg[$j]!=10){$msg .= $txt_map;}
							}
							elseif($dt_lieu['hbr'] and $new_hbr_nom!='' and $new_vll==$dt_lieu['id_vll']){
								$txt_map = $new_hbr_nom.' ('.$vll[$new_vll].')';
								if($prs_ctg[$j]==10 or ($flg_map[$prs_id[$j]] and $prs_ctg[$j]==20)){
									$lat[$prs_id[$j]][] = $new_hbr_lat;
									$lon[$prs_id[$j]][] = $new_hbr_lon;
									if($new_hbr_lat.','.$new_hbr_lon != $old_latlon){
										$mrk_map[$prs_id[$j]][] = $txt_map;
										$latlon[$prs_id[$j]][] = $new_hbr_lat.','.$new_hbr_lon;
										$old_latlon = $new_hbr_lat.','.$new_hbr_lon;
									}
								}
								if($prs_ctg[$j]!=10){$msg .= $txt_map;}
							}
							else{
								if(empty($dt_lieu['titre'])){$txt_map = $dt_lieu['nom'];}
								else{$txt_map = $dt_lieu['titre'];}
								if($prs_ctg[$j]==10 or ($flg_map[$prs_id[$j]] and $prs_ctg[$j]==20)){
									$lat[$prs_id[$j]][] = $dt_lieu['lat'];
									$lon[$prs_id[$j]][] = $dt_lieu['lon'];
									if($dt_lieu['lat'].','.$dt_lieu['lon'] != $old_latlon){
										$mrk_map[$prs_id[$j]][] = $txt_map;
										$latlon[$prs_id[$j]][] = $dt_lieu['lat'].','.$dt_lieu['lon'];
										$old_latlon = $dt_lieu['lat'].','.$dt_lieu['lon'];
									}
								}
								if($prs_ctg[$j]!=10){$msg .= $txt_map;}
							}
						}
						else{
							$id_vll = -$id_lieu;
							$dt_vll = ftc_ass(sel_quo("nom,lat,lon","cat_vll","id",$id_vll));
							$txt_map = $dt_vll['nom'];
							$lat[$prs_id[$j]][] = $dt_vll['lat'];
							$lon[$prs_id[$j]][] = $dt_vll['lon'];
							if($dt_vll['lat'].','.$dt_vll['lon'] != $old_latlon){
								$mrk_map[$prs_id[$j]][] = $txt_map;
								$latlon[$prs_id[$j]][] = $dt_vll['lat'].','.$dt_vll['lon'];
								$old_latlon = $dt_vll['lat'].','.$dt_vll['lon'];
							}
						}
						$ord[$id_jrn]++;
						$lat[$prs_id[$j]]=array_unique($lat[$prs_id[$j]]);
						$lon[$prs_id[$j]]=array_unique($lon[$prs_id[$j]]);
						$itm_map[$prs_id[$j]] = array_values(array_unique($mrk_map[$prs_id[$j]]));
					}
					unset($old_latlon);
					if(isset($mrk_map[$prs_id[$j]]) and count($latlon[$prs_id[$j]])>1){
?>
									<input id="latlon<?php echo $prs_id[$j] ?>" type="hidden" value="<?php echo implode("|",$latlon[$prs_id[$j]]); ?>" />
									<input id="lat<?php echo $prs_id[$j] ?>" type="hidden" value="<?php echo implode("|",$lat[$prs_id[$j]]); ?>" />
									<input id="lon<?php echo $prs_id[$j] ?>" type="hidden" value="<?php echo implode("|",$lon[$prs_id[$j]]); ?>" />
									<div id="map<?php echo $prs_id[$j] ?>" style="visibility: hidden"></div>
									<image id="img<?php echo $prs_id[$j] ?>" />
									<br />
									<table>
										<tr>
											<td style="padding: 20px 50px;">
												<table>
<?php
						$k = 0;
						$alphas = range('A', 'Z');
						$color = array("BE9628","7DABFD","8AAF00","DC8600");
						foreach($mrk_map[$prs_id[$j]] as $i => $nom){
							if($k>7){$k=0;}
?>
													<tr style="font-weight: normal;">
														<td style="color: <?php echo '#'.$color[$k]; ?>">
<?php
								if($itm_map[$prs_id[$j]][$i]==$nom){echo $alphas[$i];}
								else{
?>
															<img src="../prm/img/road.png" />
<?php
								}
?>
														</td>
														<td><?php echo stripslashes($nom); ?></td>
													</tr>
<?php
							$k++;
						}
?>
												</table>
											</td>
											<td id="rsm<?php echo $prs_id[$j] ?>" style="padding: 20px 50px; vertical-align:top;"></td>
										</tr>
									</table>
<?php
						$lst_map[]=$prs_id[$j];
					}
				}
				elseif($pr>0){
					if(empty($dt_cat_prs['titre'])){$msg .= $dt_cat_prs['nom'];}
					else{$msg .= $dt_cat_prs['titre'];}
				}
				if($dt_cat_prs['is_out'] and $pr>0){$msg .= " OUT: ".$info[$j];}
				if(!empty($msg)){echo stripslashes($msg);}
				if(!is_null($dt_cat_prs['duree']) and $pr>0){
					echo '<br />-> '.$txt_prg->duree->$id_lgg.': ';
					if(date("i", strtotime($dt_cat_prs['duree']))=='00'){echo date("H", strtotime($dt_cat_prs['duree'])).$txt_prg->hs->$id_lgg." ";}
					else{echo date("H:i", strtotime($dt_cat_prs['duree'])).$txt_prg->hs->$id_lgg." ";}
				}
				unset($old_ctg,$old_nom);
				if($prs_id[$j]>0 and $prs_ctg[$j]!=10){
					$rq_srv = sel_whe("id_cat,ctg,dev_srv.lgg,nom,titre","dev_srv LEFT JOIN cat_srv_txt ON dev_srv.id_cat = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"res!=6 AND opt=1 AND id_prs=".$prs_id[$j],"ctg,nom");
					while($dt_srv = ftc_ass($rq_srv)){
						if($dt_srv['ctg']!=$old_ctg or ($dt_srv['nom']!=$old_nom and $mrk_nom_ctg_srv[$dt_srv['ctg']])){
							$old_ctg = $dt_srv['ctg'];
							$old_nom = $dt_srv['nom'];
							echo '<br />->';
							if($mrk_ctg_ctg_srv[$dt_srv['ctg']]){
								echo ' '.$ctg_srv[$id_lgg][$dt_srv['ctg']].' ';
								if($lgg_ctg_srv[$dt_srv['ctg']] and $dt_srv['lgg']>0){echo '('.$nom_lgg_lgg[$id_lgg][$dt_srv['lgg']].') ';}
							}
							if($mrk_nom_ctg_srv[$dt_srv['ctg']] and $mrk_srv_ctg_prs[$prs_ctg[$j]]){
								if($dt_srv['titre']==''){echo ' '.$dt_srv['nom'];}
								else{echo ' '.$dt_srv['titre'];}
							}
						}
					}
				}
?>
									<br />
									<br />
								</div>
<?php
			}
		}
		if($flg_div){
			$flg_div = false;
?>
							</div>
<?php
		}
		if(isset($rsp)){echo $rsp;}
	}
	if(isset($lst_map)){
?>
							<input id="lst_map" type="hidden" value="<?php echo implode("|",$lst_map); ?>" />
<?php
	}
//EN CAS D'URGENCE
?>
							<br /><br /><br /><br />
							<span class="fs13"><?php echo $txt_prg->urg->$id_lgg ?></span>
							<br /><br />
							<span class="fs6"><?php echo $txt_prg->dt_urg->$id_lgg ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php
}
?>
