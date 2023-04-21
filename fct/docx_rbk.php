<?php
include("../prm/fct.php");
include("../prm/aut.php");

function addrichText($sec,$str,$fs,$ps,$underline,$fgcolor){
	$textrun = $sec->createTextRun($ps);
	$fs2 = $fs;
	$tag1 = array(1=>'<strong>',2=>'</strong>',3=>'<em>',4=>'</em>',5=>'<u>',6=>'</u>',7=>'</span>',8=>'<span');
	$tag10 = array(1=>'text-decoration:',2=>'background-color:#',3=>'color:');
	$tag2 = array(1=>'bold',2=>'italic',3=>'underline');
	$tag20 = array(1=>'underline',2=>'fgColor',3=>'color');
	$tag3 = array(1=>'true',2=>'false',3=>'true',4=>'false',5=>'true',6=>'false',7=>'false');
	$col_rsm = array('blue'=>'0000FF','green'=>'008000','purple'=>'800080','gray'=>'808080','orange'=>'FFA500','red'=>'FF0000','white'=>'FFFFFF','black'=>'000000','brown'=>'A52A2A','yellow'=>'FFFF00');
	$j=0;
	$flg = true;
	while(strpos($str,'<')!==false and $flg){
		$pos = strpos($str,'<');
		$flg = false;
		foreach($tag1 as $i => $t){

			/*$txttt = $str."\r\n"; //DETECTER MAUVAISE BALISE EX:	if gte mso 9
			$fp = fopen("../tmp/".$dir."/fct.txt","a");
				if($fp){
					fwrite($fp, $txttt);
					fclose($fp);
				}*/

			if(substr($str,$pos,strlen($t))==$t){
				$flg = true;
				if(strlen(strstr($str,$t,true))>0){
					$txt[] = strstr($str,$t,true);
					$fstr[] = $fs2;
				}//echo $pos.$str.'<br/><br/><br/>';
				$pos = strpos($str,$t);
				$str = substr($str,$pos+strlen($t));
				$flg = true;
				if($i==7){
					$j--;
					if(isset($span[$j])){
						foreach($span[$j] as $spa){
							unset($fs2[$spa]);
						}
						unset($span[$j]);
					}
				}
				elseif($i==8){
					$pos = strpos($str,'style="');
					if($pos < strpos($str,'>')){
						$str = substr($str,$pos+7);
						$style = explode(";",strstr($str,'">',true));
					//	var_dump($style);
						if(empty($style[count($style)-1])){unset($style[count($style)-1]);}
						foreach($style as $stl){
							foreach($tag10 as $i10 => $t10){
								if(substr(str_replace(" ","",$stl),0,strlen($t10))==$t10){//echo $str.'<br/><br/>';
									if($i10==1){$tag = $underline;}
									elseif($i10==2){$tag = $fgcolor[upnoac(substr(str_replace(" ","",$stl),strlen($t10)))];}
									else{$tag = $col_rsm[substr(str_replace(" ","",$stl),strlen($t10))];}
									$fs2[$tag20[$i10]] = $tag;
									$span[$j][] = $tag20[$i10];
								}
							}
						}
					}
					$pos = strpos($str,'">');
					$str = substr($str,$pos+2);
					$j++;
				}
				else{
					if($tag3[$i]=='true'){$fs2[$tag2[round($i/2)]] = $tag3[$i];}
					else{unset($fs2[$tag2[round($i/2)]]);}
				}
			}
		}
	}
	if(strlen($str)>0){
		$txt[] = $str;
		$fstr[] = $fs2;
	}
	if(isset($txt)){
		foreach($txt as $i => $str){$textrun->addText($str,$fstr[$i]);}
	}
}

if(isset($_GET['id']) and $_GET['id']>0 and isset($_GET['id_lgg']) and $_GET['id_lgg']>0){
	$id = $_GET['id'];
	$lgg_id = $_GET['id_lgg'];
	$txt = simplexml_load_file('txt.xml');
	$txt_prg = simplexml_load_file('txt_prg.xml');
	$cbl = 'dev';
	$googlekey = "AIzaSyBuXaGEpXzsBNlbuHyX-WCm7QkXtPj1LKs";
	$wdt_img = 2.3;
	include("prg.php");
	include("ttr.php");
	include("../prm/ctg_prs.php");
	include("../prm/ctg_srv.php");
//DOC SETTINGS
	require_once '../prm/PHPWord.php';
	$PHPWord = new PHPWord();
	$fgcolor = array(
		'FFFF00'=>PHPWord_Style_Font::FGCOLOR_YELLOW,
		'7FFF00'=>PHPWord_Style_Font::FGCOLOR_LIGHTGREEN,
		'00FFFF'=>PHPWord_Style_Font::FGCOLOR_CYAN,
		'FF00FF'=>PHPWord_Style_Font::FGCOLOR_MAGENTA,
		'0000FF'=>PHPWord_Style_Font::FGCOLOR_BLUE,
		'FF0000'=>PHPWord_Style_Font::FGCOLOR_RED,
		'00008B'=>PHPWord_Style_Font::FGCOLOR_DARKBLUE,
		'008B8B'=>PHPWord_Style_Font::FGCOLOR_DARKCYAN,
		'008000'=>PHPWord_Style_Font::FGCOLOR_DARKGREEN,
		'8B008B'=>PHPWord_Style_Font::FGCOLOR_DARKMAGENTA,
		'A52100'=>PHPWord_Style_Font::FGCOLOR_DARKRED,
		'808000'=>PHPWord_Style_Font::FGCOLOR_DARKYELLOW,
		'808080'=>PHPWord_Style_Font::FGCOLOR_DARKGRAY,
		'BFBFBF'=>PHPWord_Style_Font::FGCOLOR_LIGHTGRAY,
		'000000'=>PHPWord_Style_Font::FGCOLOR_BLACK,
	);
	$sectionStyle = array('orientation' => null,'marginLeft' => 1000,'marginRight' => 800,'marginTop' => 700,'marginBottom' => 600);
	$section = $PHPWord->createSection($sectionStyle);
	$fontStyle1 = '';
	$fontStyle1 = array('name' => 'Verdana', 'color'=>'808080', 'size'=>7);
	$fontStyle2 = array('name' => 'Verdana', 'color'=>'2D4CA4', 'size'=>12, 'bold'=>true);
	$fontStyle3 = array('name' => 'Verdana', 'color'=>'2D4CA4', 'size'=>12);
	$fontStyle4 = array('name' => 'Verdana', 'color'=>'606060', 'size'=>10);
	$fontStyle6 = array('name' => 'Verdana', 'color'=>'000000', 'size'=>10);
	$fontStyle8 = array('name' => 'Verdana', 'color'=>'333399', 'size'=>16);
	$fontStyle10 = array('name' => 'Verdana', 'color'=>'#2D4CA4', 'size'=>16);
	$fontStyle13 = array('name' => 'Verdana', 'color'=>'2D4CA4', 'size'=>10, 'bold'=>true);
	$paragraphStyle1 = array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$paragraphStyle2 = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$paragraphStyle3 = array('align'=>'right','borderBottomSize'=>15, 'borderBottomColor' => '006699');
	$tableStyle = '';
	$tableStyle2 = array('cellMarginTop'=>80, 'cellMarginLeft'=>80, 'cellMarginRight'=>160,'cellMarginBottom'=>160);
	$height = '';
	$cellStyle1 = array('valign'=>'center', 'borderTopSize' => 10);
	$cellStyle2 = '';
	$cellStyle3 = array('valign'=>'center', 'borderTopSize' => 10, 'borderTopColor' => '006699', 'borderBottomSize'=>10, 'borderBottomColor' => '006699');
	$cellStyle4 = array('valign'=>'center', 'borderTopSize' => 10, 'borderTopColor' => '006699');
	$imageStyle1 = array('width'=>2, 'height'=>0.4, 'align'=>'left');
	$imageStyle2 = array('width'=>1.5, 'height'=>0.75, 'align'=>'left');
	$imageStyle3 = array('width'=>6.5, 'height'=>4.8, 'align'=>'left');
	$imageStyle4 = array('width'=>0.1, 'height'=>0.1, 'align'=>'left');
	$linkStyle = array('color'=>'0000FF','underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE);
	if(!$clt_tmpl[$id_clt]){
	//FOOTER
		$footer = $section->createFooter();
		$table = $footer->addTable($tableStyle);
		$table->addRow($height);
		$cell = $table->addCell(3000, $cellStyle1);
		$cell->addImage('../prm/img/'.$dir.'/logo2.jpg', $imageStyle1);
		$cell = $table->addCell(7500, $cellStyle1);
		$cell->addText(stripslashes(replace($txt_prg->footer1)), $fontStyle1, $paragraphStyle1);
		$cell->addText(stripslashes(replace($txt_prg->footer2)), $fontStyle1, $paragraphStyle1);
	}
//LOGO
	$table = $section->addTable($tableStyle);
	$table->addRow($height);
	$cell = $table->addCell(3000, $cellStyle2);
	if($clt_tmpl[$id_clt]==1){
		$nom_clt = str_replace(" ","_",$clt[$id_clt]);
		$cell->addImage('../prm/img/'.$dir.'/'.$nom_clt.'_logo.jpg', $imageStyle1);
	}
	else{$cell->addImage('../prm/img/'.$dir.'/logo1.jpg', $imageStyle1);}
	$cell = $table->addCell(7000, $cellStyle3);
	$cell->addText(stripslashes(replace($txt_prg->rbk->$id_lgg)), $fontStyle3, $paragraphStyle1);
	if($id_clt>1){$cell->addText(stripslashes(replace($clt[$id_clt])), $fontStyle2, $paragraphStyle1);}
	else{$cell->addText(stripslashes(replace($dt_crc['titre'])), $fontStyle2, $paragraphStyle1);}
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText(stripslashes(replace($dt_crc['groupe'])), $fontStyle8, $paragraphStyle2);
	$table = $section->addTable($tableStyle);
	$table->addRow($height);
	$cell = $table->addCell(10500, $cellStyle4);
	$cell->addText(stripslashes(replace($dt_crc['duree'].' '.$txt_prg->jours->$id_lgg)), $fontStyle10, $paragraphStyle3);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$section->addText('', $fontStyle, $paragraphStyle2);
	$img = array();
	foreach($pic as $pi){
		foreach($pi as $p){$img[] = $p;}
	}
	if(count($img)>9){$nb = 9;}
	else{$nb = count($img);}
	$ran = array_rand($img,$nb);
	$table = $section->addTable($tableStyle);
	$table->addRow($height);
	$i=1;
	foreach($ran as $k){
		$cell = $table->addCell(3400, $cellStyle2);
		$dim = getimagesize('../pic/'.$dir.'/'.$img[$k]);
		$hgt_img = $wdt_img *  $dim[1] / $dim[0];
		$fotoStyle = array('width'=>$wdt_img, 'height'=>$hgt_img,'align'=>'right');
	  $cell->addImage('../pic/'.$dir.'/'.$img[$k], $fotoStyle);
		if($i==3 or $i==6){$table->addRow($height);}
		$i++;
	}
	$section = $PHPWord->createSection($sectionStyle);
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
							$prs_id[$ii]=$id_dev_prs;
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
		$fs_mdl = array('name' => 'Verdana', 'color'=>$col[$lst_mdl['col'][$mdl[$j]]], 'size'=>16);
		$fs_jrn = array('name' => 'Verdana', 'color'=>$col[$lst_mdl['col'][$mdl[$j]]], 'size'=>10, 'bold'=>true);
		if(isset($srv_in[$j])){
			$dat = date("d/m/Y", strtotime($srv_in[$j]));
			if($srv_out[$j]!=$srv_in[$j] and $srv_out[$j]!=''){$dat .= ' - '.date("d/m/Y", strtotime($srv_out[$j])).$prs_ctg[$j];}
		}
		foreach($prs_vll[$prs_id[$j]] as $id_vll){
			unset($prs_vll[$prs_id[$j]]);
			if($id_vll != $old_vll){
				$old_vll = $id_vll;
				if(isset($old_dat)){
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
				}
				if(!in_array($id_vll,$dev_vll)){
					$dt_vll_txt = ftc_ass(sel_quo("dsc","cat_vll_txt",array("id_vll","lgg"),array($id_vll,$lgg_crc)));
					$dev_vll[] = $id_vll;
					$section->addText(stripslashes(replace($vll[$id_vll])), $fs_mdl, $paragraphStyle2);
					if(isset($dt_vll_txt['dsc'])){
						$dsc = explode('<br />',stripslashes(replace(nl2br(trim($dt_vll_txt['dsc'])))));
						foreach($dsc as $lgn){addrichText($section,trim($lgn), $fontStyle4, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
					}
					$flg_br = true;
				}
				$section->addText('', $fontStyle, $paragraphStyle2);
			}
		}
		if(isset($prs_ctg[$j])){
			if($dat!=$old_dat){
				$section->addText($dat, $fs_jrn, $paragraphStyle2);
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
				$dt_dev_jrn = ftc_ass(sel_quo("nom,titre","dev_jrn","id",$jrn_id[$j]));
				if(empty($dt_dev_jrn['titre'])){$msg = $dt_dev_jrn['nom'];}
				else{$msg = $dt_dev_jrn['titre'];}
				$section->addText(replace(mb_strtoupper(stripslashes($msg))), $fs_jrn, $paragraphStyle2);
				unset($msg);
			}
			if($pr!=$old_prs or $dat!=$old_dat_prs){
				$old_prs = $pr;
				$old_dat_prs = $dat;
				if($flg_mlt_pax and isset($nbp[$j])){
					if(!isset($ult_pax) or $nbp[$j]!=$ult_pax){
						$section->addText('__________', $fontStyle3, $paragraphStyle3);
						if($ptl){$section->addText('x'.$nbp[$j].'&#43;1', $fontStyle10, $paragraphStyle3);}
						else{$section->addText('x'.$nbp[$j], $fontStyle10, $paragraphStyle3);}
						$ult_pax = $nbp[$j];
						$flg_br = false;
					}
				}
				if($flg_br){
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$flg_br = false;
				}
				if($jrn[$j]>0){$rq_jrn_lieu = sel_quo("id_lieu","cat_jrn_lieu","id_jrn",$jrn[$j],"ord");}
				if(num_rows($rq_jrn_lieu)>0){
					unset($lieu_prs[$pr]);
					while($dt_jrn_lieu = ftc_ass($rq_jrn_lieu)){$lieu_prs[$pr][] = $dt_jrn_lieu['id_lieu'];}
					$flg_map[$prs_id[$j]] = true;
				}
				if($pr>0){//$section->addText('A', $fontStyle, $paragraphStyle2);
					if(!isset($lieu_prs[$pr])){
						if($prs_ctg[$j]!=10){ //remplacer par !$doc_srv_ctg_prs ?? exclus permis transfrontalier
							$rq_prs_lieu = sel_quo("id_lieu","cat_prs_lieu","id_prs",$pr,"ord");
							while($dt_prs_lieu = ftc_ass($rq_prs_lieu)){$lieu_prs[$pr][] = $dt_prs_lieu['id_lieu'];}
						}
						if($prs_ctg[$j]==10 or ($flg_map[$prs_id[$j]] and $prs_ctg[$j]==20)){
							$lieu_avt = $lieu_vll = $lst_vll = $lieu_apr = array();
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
							if($cnf>0 and ($dt_dev_hbr['sel']==1 or ($dt_dev_hbr['opt']==1 and $dt_dev_prs['res']==-1)) and $dt_dev_hbr['id_cat']!=0){
								$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre,lat,lon","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$dt_dev_hbr['id_cat']));
								if($dt_cat_hbr['titre']==''){$new_hbr_nom = $dt_cat_hbr['nom'];}
								else{$new_hbr_nom = $dt_cat_hbr['titre'];}
								$new_vll = $dt_cat_hbr['id_vll'];
								$new_hbr_lat = $dt_cat_hbr['lat'];
								$new_hbr_lon = $dt_cat_hbr['lon'];
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
								if($cnf>0 and ($dt_dev_hbr['sel']==1 or ($dt_dev_hbr['opt']==1 and $dt_dev_prs['res']==-1)) and $dt_dev_hbr['id_cat']!=0){
									$dt_cat_hbr = ftc_ass(sel_quo("nom,id_vll,titre,lat,lon","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$dt_dev_hbr['id_cat']));
									if($dt_cat_hbr['titre']==''){$old_hbr_nom = $dt_cat_hbr['nom'].' HTL';}
									else{$old_hbr_nom = $dt_cat_hbr['titre'];}
									$old_hbr_vll = $dt_cat_hbr['id_vll'];
									$old_hbr_lat = $dt_cat_hbr['lat'];
									$old_hbr_lon = $dt_cat_hbr['lon'];
								}
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
						$section->addImage("../tmp/".$dir."/map_rbk_prs".$prs_id[$j].".jpeg", $imageStyle3);
						$table = $section->addTable($tableStyle2);
						$table->addRow($height);
						$cell = $table->addCell(5000, $cellStyle2);
						$k = 0;
						$alphas = range('A', 'Z');
						$color = array("BE9628","7DABFD","8AAF00","DC8600");
						foreach($mrk_map[$prs_id[$j]] as $i => $nom){
							if($k>3){$k=0;}
							$textrun = $cell->createTextRun($paragraphStyle2);
							if($itm_map[$prs_id[$j]][$i]==$nom){$textrun->addText($alphas[$i].' ', array('color'=>$color[$k]), $paragraphStyle2);}
							else{$textrun->addImage('../prm/img/road.png', $imageStyle4);}
							$textrun->addText(' '.stripslashes(replace($nom)), $fontStyle, $paragraphStyle2);
							$k++;
						}
						$rsm = file_get_contents("../tmp/".$dir."/rsm_rbk_prs".$prs_id[$j].".html");
						if(isset($rsm)){
							$cell = $table->addCell(3000, $cellStyle2);
							$dsc = explode('<br />',stripslashes(replace(nl2br(trim($rsm)))));
							foreach($dsc as $lgn){addrichText($cell,trim($lgn), $fontStyle, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
						}
						unset($rsm);
					}
				}
				elseif($pr>0){
					if(empty($dt_cat_prs['titre'])){$msg .= $dt_cat_prs['nom'];}
					else{$msg .= $dt_cat_prs['titre'];}
				}
				if($dt_cat_prs['is_out'] and $pr>0){$msg .= " OUT: ".$info[$j];}
				if(!is_null($dt_cat_prs['duree']) and $pr>0){
					$msg .= '<br />-> '.$txt_prg->duree->$id_lgg.': ';
					if(date("i", strtotime($dt_cat_prs['duree']))=='00'){$msg .= date("H", strtotime($dt_cat_prs['duree'])).$txt_prg->hs->$id_lgg." ";}
					else{$msg .= date("H:i", strtotime($dt_cat_prs['duree'])).$txt_prg->hs->$id_lgg." ";}
				}
				unset($old_ctg,$old_nom);
				if($prs_id[$j]>0 and $prs_ctg[$j]!=10){
					$rq_srv = sel_whe("id_cat,ctg,dev_srv.lgg,nom,titre","dev_srv LEFT JOIN cat_srv_txt ON dev_srv.id_cat = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"res!=6 AND opt=1 AND id_prs=".$prs_id[$j],"ctg,nom");
					while($dt_srv = ftc_ass($rq_srv)){
						if($dt_srv['ctg']!=$old_ctg or ($dt_srv['nom']!=$old_nom and $mrk_nom_ctg_srv[$dt_srv['ctg']])){
							$old_ctg = $dt_srv['ctg'];
							$old_nom = $dt_srv['nom'];
							$msg .= '<br />->';
							if($mrk_ctg_ctg_srv[$dt_srv['ctg']]){
								$msg .= ' '.$ctg_srv[$id_lgg][$dt_srv['ctg']].' ';
								if($lgg_ctg_srv[$dt_srv['ctg']] and $dt_srv['lgg']>0){$msg .= '('.$nom_lgg_lgg[$id_lgg][$dt_srv['lgg']].') ';}
							}
							if($mrk_nom_ctg_srv[$dt_srv['ctg']] and $mrk_srv_ctg_prs[$prs_ctg[$j]]){
								if($dt_srv['titre']==''){$msg .= ' '.$dt_srv['nom'];}
								else{$msg .= ' '.$dt_srv['titre'];}
							}
						}
					}
				}
			}
			if(!empty($msg)){
				$dsc = explode('<br />',stripslashes(replace(nl2br(trim($msg)))));
				foreach($dsc as $lgn){$section->addText(trim($lgn), $fontStyle6, $paragraphStyle2);}
				unset($msg);
			}
		}
	}
	$section->addText('', $fontStyle1, $paragraphStyle2);
	$section->addText('', $fontStyle1, $paragraphStyle2);
//EN CAS D'URGENCE
	$section ->addText('', $fontStyle6, $paragraphStyle2);
	$section->addText(stripslashes(replace($txt_prg->urg->$id_lgg)), $fontStyle13, $paragraphStyle2);
	$section ->addText('', $fontStyle6, $paragraphStyle2);
	$section ->addText(stripslashes(replace($txt_prg->dt_urg->$id_lgg)), $fontStyle6, $paragraphStyle2);
	$section ->addText('', $fontStyle6, $paragraphStyle2);
//EXPORT
	$ttr = "Roadbook_".$ttr.".docx";
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save("../tmp/".$dir."/".$ttr);
	if (file_exists("../tmp/".$dir."/".$ttr)){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename("../tmp/".$dir."/".$ttr));
		header('Content-Transfer-Encoding: binary');
		header("Expires: 0");
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize("../tmp/".$dir."/".$ttr));
		ob_clean();
		flush();
		readfile("../tmp/".$dir."/".$ttr);
		exit;
	}
}
?>
