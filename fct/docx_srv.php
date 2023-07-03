<?php
if(isset($_GET['id']) and $_GET['id']>0){
	$id_dev_crc = $_GET['id'];
	include("../prm/fct.php");
	include("../prm/lgg.php");
	include("../prm/rpl.php");
	include("../prm/ctg_prs.php");
	include("../prm/ctg_srv.php");
	include("../cfg/lng.php");
	include("../cfg/vll.php");
	$txt = simplexml_load_file('txt.xml');
	$dt_dev = ftc_ass(sel_quo("*","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
	$cnf = $dt_dev['cnf'];
	$nom_gpe = $dt_dev['groupe'];
	$id_clt = $dt_dev['id_clt'];
	$lgg_crc = $dt_dev['lgg'];
	$id_lgg = $lgg[$lgg_crc];
	$flg_send_crc = true;
	$k=0;
	$rq_pax = sel_quo("base","dev_crc_bss",array("vue","id_crc"),array("1",$id_dev_crc));
	while($dt_pax = ftc_ass($rq_pax)){
		$nb_pax_crc = $dt_pax['base'];
		$k++;
	}
	if($k!=1){$flg_err_crc = true;}
	$ii = 0;
	$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id_dev_crc,"ord");
	while($dt_mdl = ftc_ass($rq_mdl)){
		$id_dev_mdl = $dt_mdl['id'];
		$flg_send_mdl = true;
		$rsp_crc = '';
		$rsp_mdl = '';
		if($dt_mdl['trf']==1){
			$k=0;
			$rq_pax = sel_quo("base","dev_mdl_bss",array("vue","id_mdl"),array("1",$id_dev_mdl));
			while($dt_pax = ftc_ass($rq_pax)){
				$nb_pax = $dt_pax['base'];
				$k++;
			}
			if($k!=1){
				$rsp_mdl = $txt->res_frn->msg2->$id_lng.$dt_mdl['ord'].".\n";
				$flg_send_mdl = false;
			}
		}
		else{
			if($flg_err_crc){
				$rsp_crc = $txt->res_frn->msg1->$id_lng.".\n";
				$flg_send_crc = false;
			}
			$nb_pax = $nb_pax_crc;
		}
		$rq_jrn = sel_quo("id,date,ord","dev_jrn",array("opt","id_mdl"),array("1",$id_dev_mdl),"ord");
		while($dt_jrn = ftc_ass($rq_jrn)){
			$id_dev_jrn = $dt_jrn['id'];
			$date_jrn = $dt_jrn['date'];
			if(empty($date_jrn) or $date_jrn=="0000-00-00"){
				$rsp_crc .= $txt->res_frn->msg3->$id_lng.$dt_jrn['ord'].".\n";
				$rsp_mdl .= $txt->res_frn->msg3->$id_lng.$dt_jrn['ord'].".\n";
				$flg_send_crc = false;
				$flg_send_mdl = false;
			}
			$rq_prs = sel_quo("id,id_cat,ctg,res,opt,heure,info","dev_prs","id_jrn",$id_dev_jrn,"ord");
			while($dt_prs = ftc_ass($rq_prs)){
				$id_ctg_prs = $dt_prs['ctg'];
				if($mrk_srv_ctg_prs[$id_ctg_prs]){
					$id_dev_prs = $dt_prs['id'];
					$id_cat_prs = $dt_prs['id_cat'];
					$rq_srv = sel_quo("id,opt,rva","dev_srv","id_prs",$id_dev_prs);
					while($dt_srv = ftc_ass($rq_srv)){
						if((($cnf>0 and $dt_prs['res']==1) or ($cnf<1 and $dt_prs['opt']==1)) and $dt_srv['opt']==1){
							$id_dev_srv = $dt_srv['id'];
							if($prs[$ii-1] != $id_cat_prs or $nb_pax != $nbp[$ii-1] or date ('Y-m-d', strtotime ("-".$j." days $date_jrn")) != $srv_in[$ii-1] or ($dt_srv['rva']!='' and $dt_srv['rva']!=$rva[$ii-1]) or (!is_null($dt_prs['heure']) and $dt_prs['heure']!=$hre[$ii-1]) or ($dt_prs['info']!='' and $dt_prs['info']!=$info[$ii-1]) or $dt_prs['ctg']==10){
								$rva[$ii] = $dt_srv['rva'];
								$prs[$ii] = $id_cat_prs;
								$nbp[$ii] = $nb_pax;
								$srv_in[$ii] = $date_jrn;
								$hre[$ii]=$dt_prs['heure'];
								$info[$ii]=$dt_prs['info'];
								$prs_ctg[$ii]=$id_ctg_prs;
								$prs_id[$ii]=$id_dev_prs;
								$mdl[$ii] = $id_dev_mdl;
								$flg_out = true;
								$old_dat[$ii] = $date_jrn;
								$ii++;
								$j=1;
							}
							else{
								$j++;
								foreach($old_dat as $k => $old){$old_dat[$k]=$date_jrn;}
							}
						}
						$lst_srv[] = $id_dev_srv;
						if($dt_mdl['trf']){$flg_send=$flg_send_mdl;}
						else{$flg_send=$flg_send_crc;}
						$flg_send_crc=$flg_send_mdl=true;
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
		if($dt_mdl['trf']){$rsp .= $rsp_mdl;}
		else{$rsp .= $rsp_crc;}
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
		$dat = date("d/m/Y", strtotime($srv_in[$j]));
		if($srv_out[$j]!=$srv_in[$j] and $srv_out[$j]!=''){$dat .= ' - '.date("d/m/Y", strtotime($srv_out[$j]));}
		if($dat!=$old_dat or $pr!=$old_prs){$message .= '<br />';}
		if($dat!=$old_dat and $prs_ctg[$j]!=10){
			$message .= '<br />'.$dat.':<br />';
			$old_dat = $dat;
		}
		if($pr!=$old_prs){
			$old_prs = $pr;
			if($doc_srv_ctg_prs[$prs_ctg[$j]]){
				if($flg_mlt_pax){
					if(!isset($ult_pax) or $nbp[$j]!=$ult_pax){
						$message .= ' x'.$nbp[$j].'<br />';
						$ult_pax = $nbp[$j];
					}
				}
				if(!isset($lieu_prs[$pr]) and $pr>0){
					$rq_prs_lieu = sel_quo("id_lieu","cat_prs_lieu",array("shw","id_prs"),array("1",$pr),"ord");
					while($dt_prs_lieu = ftc_ass($rq_prs_lieu)){$lieu_prs[$pr][] = $dt_prs_lieu['id_lieu'];}
				}
				if(!is_null($hre[$j])){$message .= date("H:i", strtotime($hre[$j])).$txt->res_frn->hs->$id_lgg.": ";}
				if(isset($lieu_prs[$pr]) and $pr>0){$message .= $ctg_prs[$id_lgg][$prs_ctg[$j]]." ";}
				if($pr>0){
					$dt_cat_prs = ftc_ass(sel_quo("nom,duree,is_out,titre","cat_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_crc,"cat_prs.id",$pr));
					if(!$dt_cat_prs['is_out']){$message .= $info[$j]." ";}
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
							if($cnf>0 and ($dt_dev_hbr['sel']==1 or ($dt_dev_hbr['opt']==1 and $dt_dev_prs['res']==-1)) and $dt_dev_hbr['id_cat']!=0){
								$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$dt_dev_hbr['id_cat']));
								if($dt_cat_hbr['titre']==''){$new_hbr_nom = $dt_cat_hbr['nom'];}
								else{$new_hbr_nom = $dt_cat_hbr['titre'];}
								$new_vll = $dt_cat_hbr['id_vll'];
							}
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
						$ord_mdl = $dt_mdl['ord']-1;
						if($ord_mdl>0){
							$dt_mdl = ftc_ass(sel_quo("id","dev_mdl",array("id_crc","ord"),array($id_dev_crc,$ord_mdl)));
							$dt_jrn = ftc_ass(sel_quo("id","dev_jrn",array("opt","date","id_mdl"),array("1",$dat,$dt_mdl['id'])));
						}
					}
					if($dt_jrn['id']!=$old_jrn[$pr]){
						$old_jrn[$pr] = $dt_jrn['id_jrn'];
						$rq_dev_prs = sel_quo("id,id_cat,res","dev_prs","id_jrn",$dt_jrn['id']);
						while($dt_dev_prs = ftc_ass($rq_dev_prs)){
							$rq_dev_hbr = sel_quo("id_cat,sel,opt","dev_hbr","id_prs",$dt_dev_prs['id']);
							while($dt_dev_hbr = ftc_ass($rq_dev_hbr)){
								if($cnf>0 and ($dt_dev_hbr['sel']==1 or ($dt_dev_hbr['opt']==1 and $dt_dev_prs['res']==-1)) and $dt_dev_hbr['id_cat']!=0){
									$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$dt_dev_hbr['id_cat']));
									if($dt_cat_hbr['titre']==''){$old_hbr_nom = $dt_cat_hbr['nom'].' HTL';}
									else{$old_hbr_nom = $dt_cat_hbr['titre'];}
									$old_vll = $dt_cat_hbr['id_vll'];
								}
							}
						}
					}
				}
				$flg_un = false;
				if(isset($lieu_prs[$pr])){
					foreach($lieu_prs[$pr] as $id_lieu){
						if($flg_un){$message .= " - ";}
						else{$flg_un = true;}
						$dt_lieu = ftc_ass(sel_quo("nom,hbr,titre,id_vll","cat_lieu LEFT JOIN cat_lieu_txt ON cat_lieu.id = cat_lieu_txt.id_lieu AND lgg=".$lgg_crc,"cat_lieu.id",$id_lieu));
						if($dt_lieu['hbr'] and $ord[$id_jrn]==1 and $old_hbr_nom!='' and $old_vll==$dt_lieu['id_vll']){$message .= $old_hbr_nom.' ('.$vll[$old_vll].')';}
						elseif($dt_lieu['hbr'] and $new_hbr_nom!='' and $new_vll==$dt_lieu['id_vll']){$message .= $new_hbr_nom.' ('.$vll[$new_vll].')';}
						elseif($dt_lieu['titre']==''){$message .= $dt_lieu['nom'];}
						else{$message .= $dt_lieu['titre'];}
						$ord[$id_jrn]++;
					}
				}
				elseif($dt_cat_prs['titre']=='' and $pr>0){$message .= $dt_cat_prs['nom'];}
				elseif($pr>0){$message .= $dt_cat_prs['titre'];}
				if($dt_cat_prs['is_out'] and $pr>0){$message .= " OUT: ".$info[$j];}
				if(!is_null($dt_cat_prs['duree']) and $pr>0){
					$message .= '<br />- '.$txt->res_frn->duree->$id_lgg.': ';
					if(date("i", strtotime($dt_cat_prs['duree']))=='00'){$message .= date("H", strtotime($dt_cat_prs['duree'])).$txt->res_frn->hs->$id_lgg." ";}
					else{$message .= date("H:i", strtotime($dt_cat_prs['duree'])).$txt->res_frn->hs->$id_lgg." ";}
				}
				unset($old_ctg,$old_nom);
				$rq_srv = sel_whe("id_cat,ctg,dev_srv.lgg,nom,titre","dev_srv LEFT JOIN cat_srv_txt ON dev_srv.id_cat = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"res!=6 AND opt=1 AND id_prs=".$prs_id[$j],"ctg,nom");
				while($dt_srv = ftc_ass($rq_srv)){
					if($dt_srv['ctg']!=$old_ctg or ($dt_srv['nom']!=$old_nom and $mrk_nom_ctg_srv[$dt_srv['ctg']])){
						$old_ctg = $dt_srv['ctg'];
						$old_nom = $dt_srv['nom'];
						if($mrk_srv_ctg_prs[$prs_ctg[$j]]){
							$message .= '<br />-';
							if($mrk_ctg_ctg_srv[$dt_srv['ctg']]){
								$message .= ' '.$ctg_srv[$id_lgg][$dt_srv['ctg']].' ';
								if($lgg_ctg_srv[$dt_srv['ctg']] and $dt_srv['lgg']>0){$message .= '('.$nom_lgg_lgg[$id_lgg][$dt_srv['lgg']].') ';}
							}
							if($mrk_nom_ctg_srv[$dt_srv['ctg']]){
								if($dt_srv['titre']==''){$message .= ' '.$dt_srv['nom'];}
								else{$message .= ' '.$dt_srv['titre'];}
							}
						}
					}
				}
				$message .= '<br />';
			}
		}
		elseif($prs_ctg[$j]==10){$message .= "AUTOTOUR<br />";}
	}
	//DOC SETTINGS
	require "../vendor/autoload.php";
	//require_once '../vendor/PHPWord.php';
	//$sectionStyle = array('orientation' => null,'marginLeft' => 1200,'marginRight' => 1000,'marginTop' => 900,'marginBottom' => 800);
	$fontStyle2 = array('name' => 'Arial', 'color'=>'FF0000', 'size'=>10);
	$paragraphStyle = array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$pw = new \PhpOffice\PhpWord\PhpWord();
	//$PHPWord = new PHPWord();
	$section = $pw->addSection(	array('marginLeft' => 1000, 'marginRight' => 775, 'marginTop' => 700, 'marginBottom' => 850));
	//$section = $PHPWord->createSection($sectionStyle);
	$section->addText('Groupe: '.replace($nom_gpe)." x".$nbpax, $fontStyle, $paragraphStyle);
	if(!$flg_send){$section->addText(replace($rsp), $fontStyle2, $paragraphStyle);}
	$dsc = explode('<br />',stripslashes(replace(nl2br(trim($message)))));
	foreach($dsc as $lgn){$section->addText(trim($lgn), $fontStyle, $paragraphStyle);}
	$ttr = "Lista_servicios";
	$grp = str_replace(array(" ","/"),"_",stripslashes($nom_gpe));
	$file .= $ttr."_".$grp.".docx";
	//$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, 'Word2007');
	$objWriter->save("../tmp/".$dir."/".$file);
	if (file_exists("../tmp/".$dir."/".$file)){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename("tmp/".$dir."/".$file));
		header('Content-Transfer-Encoding: binary');
		header("Expires: 0");
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize("../tmp/".$dir."/".$file));
		ob_clean();
		flush();
		readfile("../tmp/".$dir."/".$file);
		exit;
	}
	echo $rsp;
}
?>
