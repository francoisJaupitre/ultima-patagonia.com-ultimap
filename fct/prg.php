<?php
include("../prm/rpl.php");
include("../prm/lgg.php");
include("../prm/col.php");
include("../cfg/ctg_hbr.php");
include("../prm/crr.php");
include("../cfg/clt.php");
include("../cfg/lieu.php");
include("../cfg/lng.php");
include("../cfg/ttr_lieu.php");
include("../cfg/vll.php");
$chr = 65;
$txt_crc[1] = '';
if($cbl=='dev'){
	$dt_crc = ftc_ass(sel_quo("*","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id));
	$ttr = $dt_crc['titre'];
	$nom = $dt_crc['nom'];
	$vrs = $dt_crc['version'];
	$groupe = $dt_crc['groupe'];
	$nomgrp = $dt_crc['nomgrp'];
	$id_grp = $dt_crc['id_grp'];
	if(!empty($ttr)){$txt_crc[1] = $ttr.' V'.$vrs.'<br />';}
	$lgg_crc = $dt_crc['lgg'];
	$id_lgg = $lgg[$lgg_crc];
	$cnf = $dt_crc['cnf'];
	$id_clt = $dt_crc['id_clt'];
	if($id_clt>1){
		$txt_crc[1] .= $clt[$id_clt];
		if(!empty($groupe)){$txt_crc[1] .= ' - ';}
	}
	$txt_crc[1] .= $groupe;
	if(empty($dt_crc['titre'])){$txt_crc[1] .= ' V'.$vrs;}
	$txt_crc[2] = $dt_crc['duree'].' '.$txt_prg->jours->$id_lgg.'<br />';
	$txt_crc[2] .= $dt_crc['periode'];
	$txt_crc[3] = $dt_crc['dsc'];
	$vols_dom = $dt_crc['vols_dom'];
	$vue_vols = $dt_crc['vue_vols'];
	$vue_opt = $dt_crc['vue_opt'];
	$vue_trf = $dt_crc['vue_trf'];
	$saut_avt = $dt_crc['saut_avt'];
	$saut_apr = $dt_crc['saut_apr'];
	$vue_dt_trf = $dt_crc['vue_dt_trf'];
	$vue_map = $dt_crc['vue_map'];
	$rq_max_mdl = sel_quo("MAX(ord)","dev_mdl","id_crc",$id);
	$max_mdl = ftc_num($rq_max_mdl);
	$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id,"ord");
}
elseif($cbl=='crc'){
	$dt_crc = ftc_ass(sel_quo("*","cat_crc LEFT JOIN cat_crc_txt on cat_crc.id = cat_crc_txt.id_crc AND lgg=".$lgg_id,"cat_crc.id",$id));
	$ttr = $dt_crc['titre'];
	$nom = $dt_crc['nom'];
	$vue_dt_trf = $vue_map = false;
	if(!empty($ttr)){$txt_crc[1] = $ttr.'<br />';}
	else{$txt_crc[1] = $nom.'<br />';}
	$id_lgg = $lgg[$lgg_id];
	$dt_mdl = ftc_ass(sel_quo("MAX(ord) AS max","cat_crc_mdl","id_crc",$id));
	$dt_fus = ftc_ass(sel_whe("COUNT(id) AS total","cat_crc_mdl","fus=1 AND ord<".$dt_mdl['max']." AND id_crc=".$id));
	$dt_jrn = ftc_ass(sel_quo("COUNT(cat_mdl_jrn.id) AS total","cat_mdl_jrn INNER JOIN cat_crc_mdl ON cat_mdl_jrn.id_mdl = cat_crc_mdl.id_mdl","id_crc",$id));
	$duree = $dt_jrn['total']-$dt_fus['total'];
	$txt_crc[2] = $duree.' '.$txt_prg->jours->$id_lgg.'<br />';
	$txt_crc[3] = $dt_crc['dsc'];
	$rq_max_mdl = sel_quo("MAX(ord)","cat_crc_mdl","id_crc",$id);
	$max_mdl = ftc_num($rq_max_mdl);
	$rq_mdl = sel_quo("cat_mdl.*,cat_mdl_txt.*,cat_crc_mdl.fus,cat_crc_mdl.ord","cat_mdl INNER JOIN cat_crc_mdl ON cat_mdl.id = cat_crc_mdl.id_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl AND lgg=".$lgg_id,"id_crc",$id,"ord");
}
elseif($cbl=='mdl'){
	$id_lgg = $lgg[$lgg_id];
	$dt_jrn = ftc_ass(sel_quo("COUNT(cat_mdl_jrn.id) AS total","cat_mdl_jrn","id_mdl",$id));
	$duree = $dt_jrn['total'];
	$vue_dt_trf = $vue_map = false;
	$txt_crc[2] = $duree.' '.$txt_prg->jours->$id_lgg.'<br />';
	$rq_mdl = sel_quo("*","cat_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl AND lgg=".$lgg_id,"cat_mdl.id",$id);
}
$flg_fus=false;
$ord_jrn = 0;
while($dt_mdl = ftc_ass($rq_mdl)){
	if($cbl=='dev'){
		$id_mdl = $dt_mdl['id'];
		$lst_mdl['id'][] = $id_mdl;
		$lst_mdl['col'][$id_mdl] = $dt_mdl['col'];
		$lst_mdl['ord'][$id_mdl] = $dt_mdl['ord'];
		if(!$dt_mdl['trf']){$lst_mdl['trf'][$id_mdl] = 0;}
		else{$lst_mdl['trf'][$id_mdl] = $dt_mdl['id'];}
	}
	elseif($cbl == 'crc'){
		$id_mdl = $dt_mdl['id_mdl'];
		$lst_mdl['id'][] = $id_mdl;
		$lst_mdl['col'][$id_mdl] = 1;
		$lst_mdl['ord'][$id_mdl] = $dt_mdl['ord'];
		$lst_mdl['trf'][$id_mdl] = 0;
	}
	elseif($cbl == 'mdl'){
		$id_mdl = $id;
		$lst_mdl['id'][] = $id_mdl;
		$ttr = $dt_mdl['titre'];
		$nom = $dt_mdl['nom'];
		if(!empty($ttr)){$txt_crc[1] = $ttr.'<br />';}
		else{$txt_crc[1] = $nom.'<br />';}
		$lst_mdl['col'][$id_mdl] = 1;
		$lst_mdl['trf'][$id_mdl] = 0;
	}
	$txt_mdl[1][$id_mdl] = '';
	if(($cbl=='dev' and $dt_mdl['trf']) or (!empty($dt_mdl['dsc']) and $cbl!='mdl')){
		if(empty($dt_mdl['titre'])){$txt_mdl[1][$id_mdl] = $txt_prg->mdl->$id_lgg.' '.$lst_mdl['ord'][$id_mdl];}
		else{$txt_mdl[1][$id_mdl] = $dt_mdl['titre'];}
	}
	$txt_mdl[2][$id_mdl]= $dt_mdl['dsc'];
	if($cbl=='dev'){$rq_max_jrn = sel_quo("MAX(ord)","dev_jrn","id_mdl",$id_mdl);}
	elseif($cbl=='crc'){$rq_max_jrn = sel_quo("MAX(ord)","cat_mdl_jrn","id_mdl",$id_mdl);}
	if($cbl!='mdl'){$max_jrn = ftc_num($rq_max_jrn);}
	if($cbl=='dev'){$rq_jrn = sel_quo("*","dev_jrn",array("opt","id_mdl"),array("1",$id_mdl),"ord");}
	else{$rq_jrn = sel_quo("cat_jrn.id,cat_jrn_txt.titre,cat_jrn_txt.dsc,cat_mdl_jrn.ord","cat_jrn INNER JOIN cat_mdl_jrn ON cat_jrn.id = cat_mdl_jrn.id_jrn LEFT JOIN cat_jrn_txt ON cat_jrn.id = cat_jrn_txt.id_jrn AND lgg=".$lgg_id,array("opt","id_mdl"),array("1",$id_mdl),"ord");}
	while($dt_jrn = ftc_ass($rq_jrn)){
		$id_jrn = $dt_jrn['id'];
		if($cbl!='mdl' and $dt_mdl['fus'] and $dt_jrn['ord']==$max_jrn[0] and $lst_mdl['ord'][$id_mdl]!=$max_mdl[0]){
			$flg_fus=true;
			if(isset($fus_ttr)){$fus_ttr .= $dt_jrn['titre'].' - ';}
			else{$fus_ttr = $dt_jrn['titre'].' - ';}
			$fus_dsc[]=$dt_jrn['dsc'];
			if($cbl=='dev'){$fus_cat[]=$dt_jrn['id_cat'];}
			else{$fus_cat[]=$id_jrn;}
			if($cbl=='dev'){$rq_prs = sel_quo("dsc,opt","dev_prs","id_jrn",$id_jrn,"ord");}
			else{$rq_prs = sel_quo("dsc,opt","cat_prs INNER JOIN cat_jrn_prs ON cat_prs.id = cat_jrn_prs.id_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_id,"id_jrn",$id_jrn,"ord");}
			while($dt_prs = ftc_ass($rq_prs)){
				if($dt_prs['opt'] and !empty($dt_prs['dsc'])){$fus_dsc_prs[]=$dt_prs['dsc'];}
			}
		}
		else{
			if($cbl!='dev' or ($dt_jrn['id_cat']>=0 or $flg_fus)){$lst_jrn[$id_mdl]['id'][] = $id_jrn;}
			$l=0;
			$h=0;
			if($cbl=='dev'){
				if($dt_jrn['date']!='0000-00-00'){
					if(!isset($date_arri)) {$date_arri = date("d/m/Y",strtotime($dt_jrn['date']));}
					$date_retour = date("d/m/Y",strtotime($dt_jrn['date']));
					$day= date("D",strtotime($dt_jrn['date']));
					$jour = $txt_prg->sem->$day->$id_lgg;
					$txt_jrn[1][$id_jrn] = $txt_prg->jour->$id_lgg.' '.$dt_jrn['ord'].' : '.$jour.' '.date("d/m/Y", strtotime($dt_jrn['date']));
				}
				else{$txt_jrn[1][$id_jrn] = $txt_prg->jour->$id_lgg.' '.$dt_jrn['ord'].' : ';}
			}
			else{
				$ord_jrn++;
				$txt_jrn[1][$id_jrn] = $txt_prg->jour->$id_lgg.' '.$ord_jrn.' : ';
			}
			if($flg_fus){$txt_jrn[2][$id_jrn] = stripslashes($fus_ttr.$dt_jrn['titre']);}
			else{$txt_jrn[2][$id_jrn] = stripslashes($dt_jrn['titre']);}
			$flg_img[$id_jrn] = false;
			if($flg_fus){
				if(isset($fus_cat)){
					foreach($fus_cat as $cat){
						if($cat !=0){
							$dt_jrn_pic = ftc_ass(sel_quo("id","cat_jrn_pic","id_jrn",$cat));
							if(!empty($dt_jrn_pic['id'])){$flg_img[$id_jrn] = true;}
						}
					}
				}
			}
			if($cbl=='dev'){
				$dt_jrn_pic = ftc_ass(sel_quo("id_pic","dev_jrn","id",$id_jrn));
				if($dt_jrn_pic['id_pic']>0){$flg_img[$id_jrn] = true;}
			}
			if(!$flg_img[$id_jrn] and (($cbl=='dev' and $dt_jrn['id_cat'] != 0) or $cbl!='dev')){
				if($cbl=='dev'){$rq_jrn_pic = sel_quo("id","cat_jrn_pic","id_jrn",$dt_jrn['id_cat']);}
				else{$rq_jrn_pic = sel_quo("id","cat_jrn_pic","id_jrn",$id_jrn);}
				$dt_jrn_pic = ftc_ass($rq_jrn_pic);
				if(!empty($dt_jrn_pic['id'])){$flg_img[$id_jrn] = true;}
			}
			if($flg_fus){
				$txt_jrn[3][$id_jrn]=$fus_dsc;
				foreach($txt_jrn[3][$id_jrn] as $dsc_jrn){
					$dsc = explode('<br />',stripslashes(nl2br(trim($dsc_jrn))));
					foreach($dsc as $lgn){$l = $l + intval(mb_strlen(trim($lgn),'UTF-8')/$chr) +1;}
				}
			}
			$txt_jrn[4][$id_jrn] = $dt_jrn['dsc'];
			$dsc = explode('<br />',stripslashes(nl2br(trim($txt_jrn[4][$id_jrn]))));
			foreach($dsc as $lgn){$l = $l + intval(mb_strlen(trim($lgn),'UTF-8')/$chr) +1;}
			if($flg_img[$id_jrn]){
				if($flg_fus){
					foreach($fus_cat as $cat){
						if($cat !=0){
							$rq_jrn_pic = sel_quo("id_pic","cat_jrn_pic","id_jrn",$cat);
							while($dt_jrn_pic = ftc_ass($rq_jrn_pic)){
								$dt_pic = ftc_ass(sel_quo("pic","cat_pic","id",$dt_jrn_pic['id_pic']));
								if(file_exists('../pic/'.$dir.'/'.$dt_pic['pic'])){
									$img = getimagesize('../pic/'.$dir.'/'.$dt_pic['pic']);
									$hgt_img = $wdt_img *  $img[1] / $img[0];
									$h = $h + $hgt_img;
									$fotoStyle = array('width'=>$wdt_img, 'height'=>$hgt_img,'align'=>'right');
									$style_pic[$id_jrn][] = $fotoStyle;
									$pic[$id_jrn][] = $dt_pic['pic'];
								}
							}
						}
					}
				}
				if($cbl=='dev'){
					$dt_jrn_pic = ftc_ass(sel_quo("id_pic","dev_jrn","id",$id_jrn));
					if($dt_jrn_pic['id_pic']>0){$rq_jrn_pic = sel_quo("id_pic","dev_jrn","id",$id_jrn);}
					elseif($dt_jrn['id_cat']>0){$rq_jrn_pic = sel_quo("id_pic","cat_jrn_pic","id_jrn",$dt_jrn['id_cat']);}
				}
				else{$rq_jrn_pic = sel_quo("id_pic","cat_jrn_pic","id_jrn",$id_jrn);}
				while($dt_jrn_pic = ftc_ass($rq_jrn_pic)){
					$dt_pic = ftc_ass(sel_quo("pic","cat_pic","id",$dt_jrn_pic['id_pic']));
					if(file_exists('../pic/'.$dir.'/'.$dt_pic['pic'])){
						$img = getimagesize('../pic/'.$dir.'/'.$dt_pic['pic']);
						$hgt_img = $wdt_img *  $img[1] / $img[0];
						$h = $h + $hgt_img;
						$fotoStyle = array('width'=>$wdt_img, 'height'=>$hgt_img,'align'=>'right');
						$style_pic[$id_jrn][] = $fotoStyle;
						$pic[$id_jrn][] = $dt_pic['pic'];
					}
				}
			}
			if($h/$l>=$hl and $flg_img){
				if($flg_fus){
					if(isset($fus_dsc_prs)){$txt_jrn[5][$id_jrn] = $fus_dsc_prs;}
					unset($fus_dsc_prs);
				}
				if($cbl=='dev'){$rq_prs = sel_quo("dsc,opt","dev_prs","id_jrn",$id_jrn,"ord");}
				else{$rq_prs = sel_quo("dsc,opt","cat_prs INNER JOIN cat_jrn_prs ON cat_prs.id = cat_jrn_prs.id_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_id,"id_jrn",$id_jrn,"ord");}
				while($dt_prs = ftc_ass($rq_prs)){
					if($dt_prs['opt']){
						if(!empty($dt_prs['dsc'])){$txt_jrn[6][$id_jrn][] = $dt_prs['dsc'];}
					}
				}
			}
			else{
				if($h/$l <0.1725 and $flg_img){$txt_jrn[7][$id_jrn] = '';}
				if($flg_fus){
					if(isset($fus_dsc_prs)){
						$txt_jrn[8][$id_jrn] = $fus_dsc_prs;
						unset($fus_dsc_prs);
					}
				}
				if($cbl=='dev'){$rq_prs = sel_quo("dsc,opt","dev_prs","id_jrn",$id_jrn,"ord");}
				else{$rq_prs = sel_quo("dsc,opt","cat_prs INNER JOIN cat_jrn_prs ON cat_prs.id = cat_jrn_prs.id_prs LEFT JOIN cat_prs_txt ON cat_prs.id = cat_prs_txt.id_prs AND lgg=".$lgg_id,"id_jrn",$id_jrn,"ord");}
				while($dt_prs = ftc_ass($rq_prs)){
					if($dt_prs['opt']){
						if(!empty($dt_prs['dsc'])){$txt_jrn[9][$id_jrn][] = $dt_prs['dsc'];}
					}
				}
			}
			$flg_fus=false;
			unset($fus_ttr,$fus_dsc,$fus_cat,$fus_dsc_prs);
		}
	}
}
?>
