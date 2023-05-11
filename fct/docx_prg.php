<?php
include("../prm/fct.php");
include("../prm/aut.php");
include("emoji_regex.php");
function addrichText($sec,$str,$fs,$ps,$underline,$fgcolor){
	$textrun = $sec->createTextRun($ps);
	$fs2 = $fs;
	$tag1 = array(1=>'<strong>',2=>'</strong>',3=>'<em>',4=>'</em>',5=>'<u>',6=>'</u>',7=>'</span>',8=>'<span');
	$tag10 = array(1=>'text-decoration:',2=>'background-color:#');
	$tag2 = array(1=>'bold',2=>'italic',3=>'underline');
	$tag20 = array(1=>'underline',2=>'fgColor');
	$tag3 = array(1=>'true',2=>'false',3=>'true',4=>'false',5=>'true',6=>'false',7=>'false');
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
				}
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
				elseif($i==8){ //<span
					$pos = strpos($str,'style="');
					if($pos == false) {$pos = strpos($str,"style='");}
					if($pos < strpos($str,'>')){
						$str = substr($str,$pos+7);
						$style = explode(";",strstr($str,'">',true));
						if($style == false) {$style = explode(";",strstr($str,"'>",true));}
						unset($style[count($style)-1]);
						foreach($style as $stl){
							foreach($tag10 as $i10 => $t10){
								if(substr(str_replace(" ","",$stl),0,strlen($t10))==$t10){
									if($i10==1){$tag = $underline;}
									else{$tag = $fgcolor[upnoac(substr(str_replace(" ","",$stl),strlen($t10)))];}
									$fs2[$tag20[$i10]] = $tag;
									$span[$j][] = $tag20[$i10];
								}
							}
						}
					}
					$pos = strpos($str,'">');
					if($pos == false) {$pos = strpos($str,"'>");}
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
if(isset($_GET['id']) and $_GET['id']>0 and isset($_GET['cbl']) and !empty($_GET['cbl']) and isset($_GET['id_lgg']) and $_GET['id_lgg']>0){
	$cbl = $_GET['cbl'];
	$id = $_GET['id'];
	$lgg_id = $_GET['id_lgg'];
	$txt = simplexml_load_file('txt.xml');
	$txt_prg = simplexml_load_file('txt_prg.xml');
	$wdt_img = 2.3;
	$hl = 0.19;
	include("prg.php");
	include("ttr.php");
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
	$fontStyle = array('name' => 'Verdana', 'color'=>'808080', 'size'=>7);
	$fontStyle2 = array('name' => 'Verdana', 'color'=>'2D4CA4', 'size'=>12, 'bold'=>true);
	$fontStyle3 = array('name' => 'Verdana', 'color'=>'2D4CA4', 'size'=>12);
	$fontStyle4 = array('name' => 'Verdana', 'color'=>'606060', 'size'=>10);
	$fontStyle5 = array('name' => 'Verdana', 'color'=>'333399', 'size'=>10, 'bold'=>true);
	$fontStyle6 = array('name' => 'Verdana', 'color'=>'000000', 'size'=>10);
	$fontStyle7 = array('name' => 'Verdana', 'color'=>'808080', 'size'=>10);
	$fontStyle8 = array('name' => 'Verdana', 'color'=>'333399', 'size'=>16);
	$fontStyle9 = array('name' => 'Verdana', 'color'=>'000000', 'size'=>10, 'bold'=>true);
	$fontStyle10 = array('name' => 'Verdana', 'color'=>'#FF0000', 'size'=>10, 'bold'=>true);
	$fontStyle11 = array('name' => 'Verdana', 'color'=>'808080', 'size'=>10, 'bold'=>true);
	$fontStyle12 = array('name' => 'Verdana', 'color'=>'2D4CA4', 'size'=>10, 'italic'=>true);
	$fontStyle13 = array('name' => 'Verdana', 'color'=>'2D4CA4', 'size'=>10, 'bold'=>true);
	$paragraphStyle = array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$paragraphStyle2 = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$tableStyle = '';
	$tableStyle2 = array('cellMarginTop'=>80, 'cellMarginLeft'=>80, 'cellMarginRight'=>80,'cellMarginBottom'=>80);
	$height = '';
	$height2 = 450;
	$cellStyle = array('valign'=>'center', 'borderTopSize' => 10);
	$cellStyle2 = '';
	$cellStyle3 = array('valign'=>'center', 'borderTopSize' => 10, 'borderTopColor' => '006699', 'borderBottomSize'=>10, 'borderBottomColor' => '006699');
	$cellStyle4 = array('valign'=>'center', 'borderBottomSize'=>15, 'borderBottomColor' => '333399');
	$cellStyle5 = array('valign'=>'left');
	$cellStyle6 = array('valign'=>'right');
	$cellStyle7 = array('valign'=>'top', 'borderTopSize' => 10, 'borderTopColor' => '006699', 'borderBottomSize'=>10, 'borderBottomColor' => '006699', 'borderLeftSize' => 10, 'borderLeftColor' => '006699', 'borderRightSize'=>10, 'borderRightColor' => '006699');
	$imageStyle = array('width'=>2, 'height'=>0.4, 'align'=>'left');
	$imageStyle2 = array('width'=>1.5, 'height'=>0.75, 'align'=>'left');
	$imageStyle3 = array('width'=>6.5, 'height'=>6.5, 'align'=>'left');
	$linkStyle = array('color'=>'0000FF','underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE);
	$linkStyle2 = array('color'=>'0000FF','underline'=>PHPWord_Style_Font::UNDERLINE_SINGLE, 'size'=>12);
//FOOTER
	$footer = $section->createFooter();
	$table = $footer->addTable($tableStyle);
	$table->addRow($height);
	$cell = $table->addCell(3000, $cellStyle);
	$cell->addImage('../prm/img/'.$dir.'/logo2.jpg', $imageStyle);
	$cell = $table->addCell(7500, $cellStyle);
	$cell->addText(stripslashes(replace($txt_prg->footer1)), $fontStyle, $paragraphStyle);
	$cell->addText(stripslashes(replace($txt_prg->footer2)), $fontStyle, $paragraphStyle);
//LOGO
	$table = $section->addTable($tableStyle);
	$table->addRow($height);
	$cell = $table->addCell(2500, $cellStyle2);
	$cell->addImage('../prm/img/'.$dir.'/logo1.jpg', $imageStyle2);
	$cell = $table->addCell(8000, $cellStyle3);
	$dsc = explode('<br />',stripslashes(replace(nl2br(trim($txt_crc[1]))))); // strpslashes bug si apostrophe
	foreach($dsc as $lgn){$cell->addText(trim($lgn), $fontStyle2, $paragraphStyle);}
	$dsc = explode('<br />',stripslashes(replace(nl2br(trim($txt_crc[2])))));
	foreach($dsc as $lgn){$cell->addText(trim($lgn), $fontStyle3, $paragraphStyle);}
	$section->addText('', $fontStyle3, $paragraphStyle);
	if($cbl!='mdl' and !empty($txt_crc[3])){
		$dsc = explode('<br />',stripslashes(replace(nl2br(trim($txt_crc[3])))));
		foreach($dsc as $lgn){addrichText($section,trim($lgn), $fontStyle4, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
		$section->addText('', $fontStyle3, $paragraphStyle);
	}
	elseif($cbl=='mdl' and !empty($txt_mdl[2][$id])){
		$dsc = explode('<br />',stripslashes(replace(nl2br(trim($txt_mdl[2][$id])))));
		foreach($dsc as $lgn){addrichText($section,trim($lgn), $fontStyle4, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
		$section->addText('', $fontStyle3, $paragraphStyle);
	}
	$section->addText('', $fontStyle3, $paragraphStyle);
// LISTE REGIONS A FAIRE
	if(isset($lst_mdl['id'])){
		foreach($lst_mdl['id'] as $id_dev_mdl){
			$id_col = $lst_mdl['col'][$id_dev_mdl];
			$id_trf = $lst_mdl['trf'][$id_dev_mdl];
			$fs_mdl[$id_trf] = array('name' => 'Verdana', 'color'=>$col[$id_col], 'size'=>16);
			$fs_mdl1[$id_trf] = array('name' => 'Verdana', 'color'=>$col[$id_col], 'size'=>10, 'bold'=>true);
			$fs_mdl2[$id_trf] = array('name' => 'Verdana', 'color'=>$col[$id_col], 'size'=>10, 'italic'=>true);
			$fs_mdl3[$id_trf] = array('name' => 'Verdana', 'color'=>$col[$id_col], 'size'=>10);
			$fs_jrn = array('name' => 'Verdana', 'color'=>$col[$id_col], 'size'=>10, 'bold'=>true);
			$cs_mdl = array('valign'=>'center', 'borderBottomSize'=>15, 'borderBottomColor' => $col[$id_col]);
			if($cbl !='mdl' and !empty($txt_mdl[1][$id_dev_mdl])){
				$section->addText(stripslashes(replace(nl2br(trim($txt_mdl[1][$id_dev_mdl])))), $fs_mdl[$id_trf], $paragraphStyle2);
				$section->addText('', $fontStyle3, $paragraphStyle);
			}
			if(!empty($txt_mdl[2][$id_dev_mdl])){
				$dsc = explode('<br />',stripslashes(replace(nl2br(trim($txt_mdl[2][$id_dev_mdl])))));
				foreach($dsc as $lgn){addrichText($section,trim($lgn), $fontStyle4, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
				$section->addText('', $fs_mdl[$id_trf], $paragraphStyle2);
			}
			if(isset($lst_jrn[$id_dev_mdl]['id'])){
				foreach($lst_jrn[$id_dev_mdl]['id'] as $id_jrn){
					$section->addText(replace(mb_strtoupper(stripslashes(nl2br(trim($txt_jrn[1][$id_jrn]))))), $fs_jrn, $paragraphStyle2);
					$section->addText(replace(mb_strtoupper(stripslashes(nl2br(trim($txt_jrn[2][$id_jrn]))))), $fs_jrn, $paragraphStyle2);
					$section->addText('', $fs_jrn, $paragraphStyle2);
					if($flg_img[$id_jrn]){
						$table = $section->addTable($tableStyle);
						$table->addRow($height);
						$cell = $table->addCell(6500, $cellStyle2);
					}
					if(isset($txt_jrn[3][$id_jrn])){
						foreach($txt_jrn[3][$id_jrn] as $dsc_jrn){
							$dsc = explode('<br />',stripslashes(replace(nl2br(trim($dsc_jrn)))));
							foreach($dsc as $lgn){
								if($flg_img[$id_jrn]){addrichText($cell,trim($lgn), $fontStyle6, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
								else{addrichText($section,trim($lgn), $fontStyle6, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
							}
						}
						$section->addText('', $fontStyle6, $paragraphStyle2);
					}
					$dsc = explode('<br />',stripslashes(replace(nl2br(trim($txt_jrn[4][$id_jrn])))));
					foreach($dsc as $lgn){
						if($flg_img[$id_jrn]){addrichText($cell,trim($lgn), $fontStyle6, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
						else{addrichText($section,trim($lgn), $fontStyle6, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
					}
					$flg_cmp = true;
					if(isset($txt_jrn[5][$id_jrn])){
						foreach($txt_jrn[5][$id_jrn] as $i => $dsc_prs){
							if(!empty($dsc_prs)){
								if($flg_cmp){
									$cell->addText('', $fontStyle11, $paragraphStyle2);
									$cell->addText(stripslashes(replace($txt_prg->inc->$id_lgg)).':', $fontStyle11, $paragraphStyle2);
									$flg_cmp = false;
								}
								$prs = explode('<br />',preg_replace("/-#\S+/",'',stripslashes(replace(nl2br(preg_replace($emoji_regex, '- ',trim($dsc_prs)))))));
								foreach($prs as $lgn){addrichText($cell,trim(preg_replace('/\s+/', ' ',$lgn)), $fontStyle7, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
							}
						}
					}
					if(isset($txt_jrn[6][$id_jrn])){
						foreach($txt_jrn[6][$id_jrn] as $i => $dsc_prs){
							if(!empty($dsc_prs)){
								if($flg_cmp){
									$cell->addText('', $fontStyle11, $paragraphStyle2);
									$cell->addText(stripslashes(replace($txt_prg->inc->$id_lgg)).':', $fontStyle11, $paragraphStyle2);
									$flg_cmp = false;
								}
								$prs = explode('<br />',preg_replace("/-#\S+/",'',stripslashes(replace(nl2br(preg_replace($emoji_regex, '- ',trim($dsc_prs)))))));
								foreach($prs as $lgn){addrichText($cell,trim(preg_replace('/\s+/', ' ',$lgn)), $fontStyle7, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
							}
						}
					}
					if($flg_img[$id_jrn]){
						$cell = $table->addCell(4000, $cellStyle2);
						foreach($pic[$id_jrn] as $i => $foto){$cell->addImage('../pic/'.$dir.'/'.$foto, $style_pic[$id_jrn][$i]);}
					}
					if(isset($txt_jrn[7][$id_jrn])){$section->addText('', $fontStyle11, $paragraphStyle2);}
					if(isset($txt_jrn[8][$id_jrn])){
						foreach($txt_jrn[8][$id_jrn] as $i => $dsc_prs){
							if(!empty($dsc_prs)){
								if($flg_cmp){
									$section->addText(stripslashes(replace($txt_prg->inc->$id_lgg)).':', $fontStyle11, $paragraphStyle2);
									$flg_cmp = false;
								}
								$prs = explode('<br />',preg_replace("/-#\S+/",'',stripslashes(replace(nl2br(preg_replace($emoji_regex, '- ',trim($dsc_prs)))))));
								foreach($prs as $lgn){addrichText($section,trim(preg_replace('/\s+/', ' ',$lgn)), $fontStyle7, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
							}
						}
					}
					if(isset($txt_jrn[9][$id_jrn])){
						foreach($txt_jrn[9][$id_jrn] as $i => $dsc_prs){
							if(!empty($dsc_prs)){
								if($flg_cmp){
									$section->addText(stripslashes(replace($txt_prg->inc->$id_lgg)).':', $fontStyle11, $paragraphStyle2);
									$flg_cmp = false;
								}
								$prs = explode('<br />',preg_replace("/-#\S+/",'',stripslashes(replace(nl2br(preg_replace($emoji_regex, '- ',trim($dsc_prs)))))));
								foreach($prs as $lgn){addrichText($section,trim(preg_replace('/\s+/', ' ',$lgn)), $fontStyle7, $paragraphStyle2,PHPWord_Style_Font::UNDERLINE_SINGLE,$fgcolor);}
							}
						}
					}
					if(!$flg_cmp){$section->addText('', $fontStyle6, $paragraphStyle2);}
					$section->addText('', $fontStyle6, $paragraphStyle2);
				}
			}
		}
	}
//TARIFS
	if($cbl=='dev'){
		$cnf = $dt_crc['cnf'];
		$lgg_crc = $dt_crc['lgg'];
		$vrs = $dt_crc['version'];
		include("trf.php");
		$section = $PHPWord->createSection($sectionStyle);
		$table = $section->addTable($tableStyle);
		$table->addRow($height);
		$cell = $table->addCell(10000, $cellStyle4);
		$cell->addText(stripslashes(replace($txt_prg->trf->$id_lgg.' '.$prm_crr_ttr[$id_lgg][$dt_crc['crr']].' '.$txt_prg->pers->$id_lgg)), $fontStyle8, $paragraphStyle2);
		$section ->addText('', $fontStyle6, $paragraphStyle2);
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
				if($id_trf){
					if(empty($dt_mdl['titre'])){$section->addText(stripslashes(replace($txt_prg->mdl->$id_lgg)).' '.$dt_mdl['ord'], $fs_mdl1[$id_trf], $paragraphStyle2);}
					else{$section->addText(replace(mb_strtoupper(stripslashes($dt_mdl['titre']))), $fs_mdl1[$id_trf], $paragraphStyle2);}
				}
				elseif($flg_trf_crc) {
					if($vols_dom) {$section->addText(stripslashes(replace($txt_prg->crc2->$id_lgg)), $fontStyle13, $paragraphStyle2);}
					else {$section->addText(stripslashes(replace($txt_prg->crc1->$id_lgg)), $fontStyle13, $paragraphStyle2);}
					$flg_trf_crc = false;
				}
				foreach(array_unique($err_hbr_jrn[$id_trf]) as $jrn){
					if($err_hbr_def[$id_trf][$jrn]){$section->addText(stripslashes(replace($txt->err->hbr_def->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
					if($err_hbr_db[$id_trf][$jrn]){$section->addText(stripslashes(replace($txt->err->hbr_db->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
					if($err_hbr_sel[$id_trf][$jrn]){$section->addText(stripslashes(replace($txt->err->hbr_sel->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
					if($err_hbr_dup[$id_trf][$jrn]){$section->addText(stripslashes(replace($txt->err->hbr_dup->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
					if($err_hbr_sg[$id_trf][$jrn] and $vue_sgl){$section->addText(stripslashes(replace($txt->err->hbr_sg->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
					if($err_hbr_tp[$id_trf][$jrn] and $vue_tpl){$section->addText(stripslashes(replace($txt->err->hbr_tp->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
					if($err_hbr_qd[$id_trf][$jrn] and $vue_qdp){$section->addText(stripslashes(replace($txt->err->hbr_qd->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
				}
				if(isset($bss[$id_trf])){
					$table = $section->addTable($tableStyle);
					foreach($bss[$id_trf] as $i => $base){
						$prx = $trf_srv[$id_trf][$i]+$trf_db_hbr[$id_trf]/2;
						if($ptl){$prx += $cst_db_hbr[$id_trf]/(2*$base);}
						if($psg){$prx += ($cst_sg_hbr[$id_trf]-$cst_db_hbr[$id_trf]/2)/$base;}
						$table->addRow($height);
						if($ptl){
							$cell = $table->addCell(3900, $cellStyle5);
							$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.'+1 :', $fontStyle6, $paragraphStyle2);
						}
						else{
							$cell = $table->addCell(3900, $cellStyle5);
							$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.' :', $fontStyle6, $paragraphStyle2);
						}
						$cell = $table->addCell(1000, $cellStyle5);
						$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
						$cell = $table->addCell(1500, $cellStyle5);
						$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
						if($err_trf_srv[$id_trf][$i]==1){
							$cell = $table->addCell(5000, $cellStyle6);
							$cell->addText(stripslashes(replace($txt->err->srv_jrn->$id_lng.' '.$txt->jours->$id_lng.' : '.$err_srv_jrn[$id_trf][$i])), $fontStyle10, $paragraphStyle2);
						}
					}
				}
				if($vue_sgl==1){
					$prx = $trf_sg_hbr[$id_trf]-$trf_db_hbr[$id_trf]/2;
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(3900, $cellStyle5);
					$cell->addText(stripslashes(replace($txt_prg->sup_sgl->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
					$cell = $table->addCell(1000, $cellStyle6);
					$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
					$cell = $table->addCell(1500, $cellStyle5);
					$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
				}
				if($vue_tpl==1){
					$prx = $trf_db_hbr[$id_trf]/2-$trf_tp_hbr[$id_trf]/3;
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(3900, $cellStyle5);
					$cell->addText(stripslashes(replace($txt_prg->red_tpl->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
					$cell = $table->addCell(1000, $cellStyle6);
					$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
					$cell = $table->addCell(1500, $cellStyle5);
					$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
				}
				if($vue_qdp==1){
					$prx = $trf_db_hbr[$id_trf]/2-$trf_qd_hbr[$id_trf]/4;
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(3900, $cellStyle5);
					$cell->addText(stripslashes(replace($txt_prg->red_qdp->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
					$cell = $table->addCell(1000, $cellStyle6);
					$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
					$cell = $table->addCell(1500, $cellStyle5);
					$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
				}
				if($psg){$section->addText(stripslashes(replace($txt_prg->trf_psg->$id_lgg)), $fontStyle12, $paragraphStyle2);}
				elseif($ptl){$section->addText(stripslashes(replace($txt_prg->trf_ptl->$id_lgg)), $fontStyle12, $paragraphStyle2);}
				$section->addText('', $fontStyle6, $paragraphStyle2);
			}
		}
		if(!$vols_dom){$section->addText(stripslashes(replace($txt_prg->trf_dbl->$id_lgg.' '.$txt_prg->trf_dbl1->$id_lgg)), $fontStyle12, $paragraphStyle2);}
		else{$section->addText(stripslashes(replace($txt_prg->trf_dbl->$id_lgg.' '.$txt_prg->trf_dbl2->$id_lgg)), $fontStyle12, $paragraphStyle2);}
		$section->addText('', $fontStyle6, $paragraphStyle2);
		$section->addText('', $fontStyle6, $paragraphStyle2);
		if($vue_vols and isset($vol_id)){
	//VOLS DOMESTIQUES
			$t=0;
			$section->addText(stripslashes(replace($txt_prg->lst_vol->$id_lgg)), $fontStyle13, $paragraphStyle2);
			$section ->addText('', $fontStyle9, $paragraphStyle2);
			$table = $section->addTable($tableStyle);
			foreach($vol_id as $id_vol){
				if(strpos($id_vol, '_')){
					$id_v1 = intval(strstr($id_vol, '_',true));
					$pos=strpos($id_vol, '_');
					$id_v2 = intval(substr($id_vol, $pos+1));
					$msg_vol = "";
					if($id_v1>0){$msg_vol = $vll[$id_v1];}
					$msg_vol .= " - ";
					if($id_v2>0){$msg_vol .= $vll[$id_v2].' :';}
					$dt_vol = ftc_ass(sel_quo("id,trf,cpp","dev_vol",array("id_crc","id_v1","id_v2"),array($id,$id_v1,$id_v2)));
					$table->addRow($height);
					$cell = $table->addCell(3900, $cellStyle5);
					$cell->addText(stripslashes(replace($msg_vol)), $fontStyle6, $paragraphStyle2);
					$cell = $table->addCell(1000, $cellStyle5);
					if($dt_vol['trf']){$cell->addText($dt_vol['trf'], $fontStyle6, $paragraphStyle2);}
					elseif(!$dt_vol['id']){$cell->addText("X", $fontStyle6, $paragraphStyle2);}
					$cell = $table->addCell(1500, $cellStyle5);
					if($dt_vol['id']){$cell->addText(stripslashes(replace($dt_vol['cpp'])), $fontStyle6, $paragraphStyle2);}
					else{$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);}
					$t++;
				}
			}
			if($t>1){
				$dt_vol = ftc_ass(sel_quo("id,trf","dev_vol",array("id_crc","id_v1","id_v2"),array($id,0,0)));
				$table->addRow($height);
				$cell = $table->addCell(3900, $cellStyle5);
				$cell->addText("TOTAL :", $fontStyle6, $paragraphStyle2);
				$cell = $table->addCell(1000, $cellStyle5);
				if($dt_vol['trf']){$cell->addText($dt_vol['trf'], $fontStyle9, $paragraphStyle2);}
				elseif(!$dt_vol['id']){$cell->addText("X", $fontStyle9, $paragraphStyle2);}
				$cell = $table->addCell(1500, $cellStyle5);
				$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
			}
			$section ->addText('', $fontStyle9, $paragraphStyle2);
			$section->addText(stripslashes(replace($txt_prg->trf_est->$id_lgg)), $fontStyle12, $paragraphStyle2);
			$section ->addText('', $fontStyle6, $paragraphStyle2);
			$section ->addText('', $fontStyle6, $paragraphStyle2);
		}
	//TABLEAU HEBERGEMENTS
	if(isset($hbr_id)){
			$section->addText(stripslashes(replace($txt_prg->lst_hbr->$id_lgg)), $fontStyle13, $paragraphStyle2);
			$section ->addText('', $fontStyle9, $paragraphStyle2);
			$table = $section->addTable($tableStyle2);
			$table->addRow($height2);
			$cell = $table->addCell(1100, $cellStyle7);
			$cell->addText(stripslashes(replace(upnoac($txt_prg->jours->$id_lgg))), $fontStyle9, $paragraphStyle);
			$cell = $table->addCell(2000, $cellStyle7);
			$cell->addText(stripslashes(replace($txt_prg->vll->$id_lgg)), $fontStyle9, $paragraphStyle);
			$cell = $table->addCell(2000, $cellStyle7);
			$cell->addText(stripslashes(replace($txt_prg->ctg->$id_lgg)), $fontStyle9, $paragraphStyle);
			$cell = $table->addCell(2500, $cellStyle7);
			$cell->addText(stripslashes(replace($txt_prg->hbr->$id_lgg)), $fontStyle9, $paragraphStyle);
			$cell = $table->addCell(2500, $cellStyle7);
			$cell->addText(stripslashes(replace($txt_prg->chm->$id_lgg)), $fontStyle9, $paragraphStyle);
			foreach($hbr_id as $i => $id_hbr){
				$table->addRow($height2);
				if($id_hbr>0){
					$cell = $table->addCell(1100, $cellStyle7);
					$cell->addText(stripslashes(replace($hbr_jrn[$id_hbr][$chm_id[$i]])), $fontStyle6, $paragraphStyle);
					$cell = $table->addCell(2000, $cellStyle7);
					$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
					$cell->addText(stripslashes(replace($vll[$dt_hbr['id_vll']])), $fontStyle6, $paragraphStyle);
					$cell = $table->addCell(2000, $cellStyle7);
					$cell->addText(stripslashes(replace($ctg_hbr[$id_lgg][$dt_hbr['ctg']])), $fontStyle6, $paragraphStyle);
					$cell = $table->addCell(2500, $cellStyle7);
					if(empty($dt_hbr['titre'])){$cell->addText(stripslashes(replace($dt_hbr['nom'])), $fontStyle6, $paragraphStyle);}
					elseif(!empty($dt_hbr['web'])){$cell->addLink($dt_hbr['web'],stripslashes(replace_lnk($dt_hbr['titre'])), $linkStyle, $paragraphStyle);}
					else{$cell->addText(stripslashes(replace($dt_hbr['titre'])), $fontStyle6, $paragraphStyle);}
					$cell = $table->addCell(2500, $cellStyle7);
					if($chm_id[$i]!=0){
						$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$chm_id[$i]));
						if(!empty($dt_chm['titre'])){$cell->addText(stripslashes(replace($dt_chm['titre'])), $fontStyle6, $paragraphStyle);}
						else{$cell->addText(stripslashes(replace($dt_chm['nom'])), $fontStyle6, $paragraphStyle);}
					}
					else{$cell->addText(stripslashes(replace($txt->err->chm->$id_lng)), $fontStyle10, $paragraphStyle);}
				}
				else{
					$cell = $table->addCell(1100, $cellStyle7);
					$cell->addText(stripslashes(replace($hbr_jrn[$id_hbr][$vll_hbr[$i]])), $fontStyle6, $paragraphStyle);
					$cell = $table->addCell(2000, $cellStyle7);
					$cell->addText(stripslashes(replace($vll[$vll_hbr[$i]])), $fontStyle6, $paragraphStyle);
					$cell = $table->addCell(2000, $cellStyle7);
					$cell = $table->addCell(2500, $cellStyle7);
					if($id_hbr==-2){$cell->addText(stripslashes(replace($txt_prg->libre->$id_lgg)), $fontStyle10, $paragraphStyle);}
					else{$cell->addText(stripslashes(replace($txt->err->hbr->$id_lng)), $fontStyle10, $paragraphStyle);}
					$cell = $table->addCell(2000, $cellStyle7);
				}
			}
			$section->addText('', $fontStyle6, $paragraphStyle2);
		}
		if($vue_opt){ //all options
	//OPTIONS HEBERGEMENTS
			if(isset($opt_hbr_id)){
				$section->addText(stripslashes(replace($txt_prg->hbr_opt->$id_lgg)), $fontStyle13, $paragraphStyle2);
				$section ->addText('', $fontStyle9, $paragraphStyle2);
				$table = $section->addTable($tableStyle2);
				$table->addRow($height2);
				$cell = $table->addCell(950, $cellStyle7);
				$cell->addText(stripslashes(replace(upnoac($txt_prg->jours->$id_lgg))), $fontStyle9, $paragraphStyle);
				$cell = $table->addCell(1700, $cellStyle7);
				$cell->addText(stripslashes(replace($txt_prg->vll->$id_lgg)), $fontStyle9, $paragraphStyle);
				$cell = $table->addCell(1700, $cellStyle7);
				$cell->addText(stripslashes(replace($txt_prg->ctg->$id_lgg)), $fontStyle9, $paragraphStyle);
				$cell = $table->addCell(2100, $cellStyle7);
				$cell->addText(stripslashes(replace($txt_prg->hbr->$id_lgg)), $fontStyle9, $paragraphStyle);
				$cell = $table->addCell(2100, $cellStyle7);
				$cell->addText(stripslashes(replace($txt_prg->chm->$id_lgg)), $fontStyle9, $paragraphStyle);
				$cell = $table->addCell(2100, $cellStyle7);
				$cell->addText(stripslashes(replace($txt_prg->sup->$id_lgg)), $fontStyle9, $paragraphStyle);
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
								if($id_hbr == $id_hbr_tab and $opt_chm_id[$id_dev_mdl][$j] == $tab_opt_chm_id[$id_dev_mdl][$i]){
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
								$table->addRow($height);
								$cell = $table->addCell(950, $cellStyle7);
								$cell->addText(stripslashes(replace($tab_jrn[$id_dev_mdl][$i])), $fontStyle6, $paragraphStyle);
								if($id_hbr_tab!=0){
									$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr_tab));
									$cell = $table->addCell(1700, $cellStyle7);
									$cell->addText(stripslashes(replace($vll[$dt_hbr['id_vll']])), $fontStyle6, $paragraphStyle);
									$cell = $table->addCell(1700, $cellStyle7);
									$cell->addText(stripslashes(replace($ctg_hbr[$id_lgg][$dt_hbr['ctg']])), $fontStyle6, $paragraphStyle);
									$cell = $table->addCell(2100, $cellStyle7);
									if(empty($dt_hbr['titre'])){$cell->addText(stripslashes(replace($dt_hbr['nom'])), $fontStyle6, $paragraphStyle);}
									elseif(!empty($dt_hbr['web'])){$cell->addLink($dt_hbr['web'],stripslashes(replace_lnk($dt_hbr['titre'])), $linkStyle, $paragraphStyle);}
									else{$cell->addText(stripslashes(replace($dt_hbr['titre'])), $fontStyle6, $paragraphStyle);}
									$cell = $table->addCell(2100, $cellStyle7);
									if($tab_opt_chm_id[$id_dev_mdl][$i]!=0){
										$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$tab_opt_chm_id[$id_dev_mdl][$i]));
										if(!empty($dt_chm['titre'])){$cell->addText(stripslashes(replace($dt_chm['titre'])), $fontStyle6, $paragraphStyle);}
										else{$cell->addText(stripslashes(replace($dt_chm['nom'])), $fontStyle6, $paragraphStyle);}
									}
									else{$cell->addText(stripslashes(replace($txt->err->chm->$id_lng)), $fontStyle10, $paragraphStyle);}
								}
								else{
									$cell = $table->addCell(1700, $cellStyle7);
									$cell->addText(stripslashes(replace($vll[$tab_vil[$id_dev_mdl][$i]])), $fontStyle6, $paragraphStyle);
									$cell = $table->addCell(1700, $cellStyle7);
									$cell = $table->addCell(2100, $cellStyle7);
									$cell->addText(stripslashes(replace($txt->err->hbr->$id_lng)), $fontStyle10, $paragraphStyle);
									$cell = $table->addCell(2100, $cellStyle7);
								}
								$cell = $table->addCell(2100, $cellStyle7);
								/*if($vue_sgl==1 or $vue_tpl==1 or $vue_qdp==1){$cell->addText(stripslashes(replace($txt_prg->dbl->$id_lgg.' :')), $fontStyle6, $paragraphStyle);}
								if($tab_err[$id_dev_mdl][$i]==0){$cell->addText(stripslashes(replace(number_format($tab_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
								else{$cell->addText(stripslashes(replace($txt->err->trf->$id_lng)), $fontStyle10, $paragraphStyle);}*/
								if($vue_sgl==1){
									$cell->addText(stripslashes(replace($txt_prg->sgl->$id_lgg.' :')), $fontStyle6, $paragraphStyle);
									if($tab_err_sg[$id_dev_mdl][$i]==0){$cell->addText(stripslashes(replace(number_format($tab_sg_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
									else{$cell->addText(stripslashes(replace($txt->err->trf->$id_lng)), $fontStyle10, $paragraphStyle);}
								}
								if($vue_dbl==1){
									$cell->addText(stripslashes(replace($txt_prg->dbl->$id_lgg.' :')), $fontStyle6, $paragraphStyle);
									if($tab_err[$id_dev_mdl][$i]==0){$cell->addText(stripslashes(replace(number_format($tab_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
									else{$cell->addText(stripslashes(replace($txt->err->trf->$id_lng)), $fontStyle10, $paragraphStyle);}
								}
								if($vue_tpl==1){
									$cell->addText(stripslashes(replace($txt_prg->tpl->$id_lgg.' :')), $fontStyle6, $paragraphStyle);
									if($tab_err_tp[$id_dev_mdl][$i]==0){$cell->addText(stripslashes(replace(number_format($tab_tp_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
									else{$cell->addText(stripslashes(replace($txt_prg->nd->$id_lgg)), $fontStyle6, $paragraphStyle);}
								}
								if($vue_qdp==1){
									$cell->addText(stripslashes(replace($txt_prg->qdp->$id_lgg.' :')), $fontStyle6, $paragraphStyle);
									if($tab_err_qd[$id_dev_mdl][$i]==0){$cell->addText(stripslashes(replace(number_format($tab_qd_prx[$id_dev_mdl][$i],0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
									else{$cell->addText(stripslashes(replace($txt_prg->nd->$id_lgg)), $fontStyle6, $paragraphStyle);}
								}
							}
						}
					}
				}
			}
			$section->addText('', $fontStyle6, $paragraphStyle2);
			//OPTIONS
			if(isset($opt_srv_id) or isset($opt_prs_id)){
				$section->addText(stripslashes(replace($txt_prg->en_opt->$id_lgg)), $fontStyle5, $paragraphStyle2);
				$section->addText('', $fontStyle9, $paragraphStyle2);
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
						$id_col = $dt_mdl['col'];
						//SERVICES
						if(isset($opt_srv_id[$id_trf])){
							array_multisort($opt_srv_jrn[$id_trf],$opt_srv_id[$id_trf]);
							foreach($opt_srv_id[$id_trf] as $j => $id_srv){
								if($id_srv>0){$rq_nom_srv = sel_quo("nom,titre","cat_srv LEFT JOIN cat_srv_txt ON cat_srv.id = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"cat_srv.id",$id_srv);}
								else{$rq_nom_srv = sel_quo("nom","dev_srv","id",-$id_srv);}
								$dt_nom_srv = ftc_ass($rq_nom_srv);
								if(!empty($dt_nom_srv['titre'])){$section->addText(stripslashes(replace($txt_prg->jour->$id_lgg.' '.$opt_srv_jrn[$id_trf][$j].' : '.$dt_nom_srv['titre'])), $fs_mdl2[$id_trf], $paragraphStyle2);}
								else{$section->addText(stripslashes(replace($txt_prg->jour->$id_lgg.' '.$opt_srv_jrn[$id_trf][$j].' : '.$dt_nom_srv['nom'])), $fs_mdl2[$id_trf], $paragraphStyle2);}
								if(isset($bss[$id_trf])){
									$table = $section->addTable($tableStyle);
									foreach($bss[$id_trf] as $i => $base){
										$prx = $trf_opt_srv[$id_trf][$j][$i];
										$table->addRow($height);
										if($ptl){
											$cell = $table->addCell(3900, $cellStyle5);
											$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.'+1 :', $fontStyle6, $paragraphStyle2);
										}
										else{
											$cell = $table->addCell(3900, $cellStyle5);
											$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.' :', $fontStyle6, $paragraphStyle2);
										}
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
										if($err_trf_opt_srv[$id_trf][$j][$i]==1){
											$cell = $table->addCell(5000, $cellStyle6);
											$cell->addText(stripslashes(replace($txt->err->opt_srv->$id_lng)), $fontStyle10, $paragraphStyle2);
										}
									}
								}
								$section->addText('', $fontStyle6, $paragraphStyle2);
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
									if($flg_s){$msg = upnoac($txt_prg->jours->$id_lgg).' '.$jrn.' : ';}
									else{$msg = upnoac($txt_prg->jour->$id_lgg).' '.$jrn.' : ';}
									if(!empty($dt_ttr['titre'])){$msg .= stripslashes($dt_ttr['titre']);}
									else{$msg .= stripslashes($dt_ttr['nom']);}
									$section->addText(replace($msg), $fs_mdl2[$id_trf], $paragraphStyle2);
									$table = $section->addTable($tableStyle);
									if($err_hbr_def_opt_prs[$id_dev_prs][$jrn]==1){$section->addText(stripslashes(replace($txt->err->hbr_def->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
									if($err_hbr_db_opt_prs[$id_dev_prs][$jrn]==1){$section->addText(stripslashes(replace($txt->err->hbr_db->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
									if($vue_sgl==1 and $err_hbr_sg_opt_prs[$id_dev_prs][$jrn]==1){$section->addText(stripslashes(replace($txt->err->hbr_sg->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
									if($vue_tpl==1 and $err_hbr_tp_opt_prs[$id_dev_prs][$jrn]==1){$section->addText(stripslashes(replace($txt->err->hbr_tp->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
									if($vue_qdp==1 and $err_hbr_qd_opt_prs[$id_dev_prs][$jrn]==1){$section->addText(stripslashes(replace($txt->err->hbr_qd->$id_lng)).$jrn, $fontStyle10, $paragraphStyle2);}
									if(
										(
											(
												$id_cat_prs>0 and (empty($opt_prs_trf_srv_cat[$id_trf][$id_cat_prs]) or count(array_unique($opt_prs_trf_srv_cat[$id_trf][$id_cat_prs]))==1)
											)
											or
											(
												$id_cat_prs==0 and (empty($opt_prs_trf_srv[$id_dev_prs]) or count(array_unique($opt_prs_trf_srv[$id_dev_prs]))==1)
											)
										)
										and !$ptl and !isset($err_trf_srv_opt_prs[$id_dev_prs])
									){
										if($id_cat_prs>0){$prx = $opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][0]+$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;}
										else{$prx = $opt_prs_trf_srv[$id_dev_prs][0]+$trf_db_hbr_opt_prs[$id_dev_prs]/2;}
										if(count($bss[$id_trf])==1){$base = $txt_prg->base->$id_lgg.' '.$bss[$id_trf][0];}
										else{$base = $txt_prg->bases->$id_lgg.' '.$bss[$id_trf][0].'-'.$bss[$id_trf][count($bss[$id_trf])-1];}
										$table->addRow($height);
										$cell = $table->addCell(3900, $cellStyle5);
										if(number_format($prx,0)!=0){$cell->addText(stripslashes(replace($base)).' :', $fontStyle6, $paragraphStyle2);}
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
									}
									elseif(isset($bss[$id_trf])){
										foreach($bss[$id_trf] as $i => $base){
											if(!isset($err_trf_srv_opt_prs[$id_dev_prs][$i])){
												if($id_cat_prs>0){
													$prx = $opt_prs_trf_srv_cat[$id_trf][$id_cat_prs][$i]+$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;
													if($ptl){$prx += $cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/(2*$base);}
													if($psg){$prx += ($cst_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs]-$cst_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2)/$base;}
												}
												else{
													$prx = $opt_prs_trf_srv[$id_dev_prs][$i]+$trf_db_hbr_opt_prs[$id_dev_prs]/2;
													if($ptl){$prx += $cst_db_hbr_opt_prs[$id_dev_prs]/(2*$base);}
													if($psg){$prx += ($cst_sg_hbr_opt_prs[$id_dev_prs]-$cst_db_hbr_opt_prs[$id_dev_prs]/2)/$base;}
												}
												$table->addRow($height);
												if($ptl){
													$cell = $table->addCell(3900, $cellStyle5);
													$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.'+1 :', $fontStyle6, $paragraphStyle2);
												}
												else{
													$cell = $table->addCell(3900, $cellStyle5);
													$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.' :', $fontStyle6, $paragraphStyle2);
												}
												$cell = $table->addCell(1000, $cellStyle6);
												$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
												$cell = $table->addCell(1500, $cellStyle5);
												$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
											}
										}
									}
									if($vue_sgl==1 and isset($hbr_id_opt_prs[$id_dev_prs])){
										if($id_cat_prs>0){$prx = $trf_sg_hbr_opt_prs_cat[$id_trf][$id_cat_prs]-$trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2;}
										else{$prx = $trf_sg_hbr_opt_prs[$id_dev_prs]-$trf_db_hbr_opt_prs[$id_dev_prs]/2;}
										$table = $section->addTable($tableStyle);
										$table->addRow($height);
										$cell = $table->addCell(3900, $cellStyle5);
										$cell->addText(stripslashes(replace($txt_prg->sup_sgl->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
									}
									if($vue_tpl==1 and isset($hbr_id_opt_prs[$id_dev_prs])){
										if($id_cat_prs>0){$prx = $trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2-$trf_tp_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/3;}
										else{$prx = $trf_db_hbr_opt_prs[$id_dev_prs]/2-$trf_tp_hbr_opt_prs[$id_dev_prs]/3;}
										$table = $section->addTable($tableStyle);
										$table->addRow($height);
										$cell = $table->addCell(3900, $cellStyle5);
										$cell->addText(stripslashes(replace($txt_prg->red_tpl->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
									}
									if($vue_qdp==1 and isset($hbr_id_opt_prs[$id_dev_prs])){
										if($id_cat_prs>0){$prx = $trf_db_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/2-$trf_qd_hbr_opt_prs_cat[$id_trf][$id_cat_prs]/4;}
										else{$prx = $trf_db_hbr_opt_prs[$id_dev_prs]/2-$trf_qd_hbr_opt_prs[$id_dev_prs]/4;}
										$table = $section->addTable($tableStyle);
										$table->addRow($height);
										$cell = $table->addCell(3900, $cellStyle5);
										$cell->addText(stripslashes(replace($txt_prg->red_qdp->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
									}
									$section->addText('', $fontStyle6, $paragraphStyle2);
									if(isset($opt_srv_id_opt_prs[$id_dev_prs])){
										foreach($opt_srv_id_opt_prs[$id_dev_prs] as $j => $id_srv){
											if($id_srv>0){$rq_nom_srv = sel_quo("nom,titre","cat_srv LEFT JOIN cat_srv_txt ON cat_srv.id = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_crc,"cat_srv.id",$id_srv);}
											else{$rq_nom_srv = sel_quo("nom","dev_srv","id",-$id_srv);}
											$dt_nom_srv = ftc_ass($rq_nom_srv);
											if(!empty($dt_nom_srv['titre'])){$section->addText(stripslashes(replace($dt_nom_srv['titre'])), $fs_mdl2[$id_trf], $paragraphStyle2);}
											else{$section->addText(stripslashes(replace($dt_nom_srv['nom'])), $fs_mdl2[$id_trf], $paragraphStyle2);}
											if(isset($bss[$id_trf])){
												$table = $section->addTable($tableStyle);
												foreach($bss[$id_trf] as $i => $base){
													if($id_cat_prs>0){
														$prx = $trf_opt_srv_opt_prs_cat[$id_cat_prs][$j][$i];
														$err = $err_trf_opt_srv_opt_cat[$id_cat_prs][$j][$i];
													}
													else{
														$prx = $trf_opt_srv_opt_prs[$id_dev_prs][$j][$i];
														$err = $err_trf_opt_srv_opt_prs[$id_dev_prs][$j][$i];
													}
													$table->addRow($height);
													if($ptl){
														$cell = $table->addCell(1400, $cellStyle5);
														$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.'+1 :', $fontStyle6, $paragraphStyle2);
													}
													else{
														$cell = $table->addCell(1100, $cellStyle5);
														$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.' :', $fontStyle6, $paragraphStyle2);
													}
													$cell = $table->addCell(1000, $cellStyle6);
													$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
													$cell = $table->addCell(1500, $cellStyle5);
													$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
													if($err){
														$cell = $table->addCell(5000, $cellStyle6);
														$cell->addText(stripslashes(replace($txt->err->opt_srv->$id_lng)), $fontStyle10, $paragraphStyle2);
													}
												}
											}
										}
										$section->addText('', $fontStyle6, $paragraphStyle2);
									}
									if(isset($hbr_id_opt_prs[$id_dev_prs])){
										$section->addText(stripslashes(replace($txt_prg->hbr_sel->$id_lgg)), $fs_mdl2[$id_trf], $paragraphStyle2);
										$table = $section->addTable($tableStyle2);
										$table->addRow($height2);
										$cell = $table->addCell(2000, $cellStyle7);
										$cell->addText(stripslashes(replace($txt_prg->vll->$id_lgg)), $fontStyle9, $paragraphStyle);
										$cell = $table->addCell(2000, $cellStyle7);
										$cell->addText(stripslashes(replace($txt_prg->ctg->$id_lgg)), $fontStyle9, $paragraphStyle);
										$cell = $table->addCell(2500, $cellStyle7);
										$cell->addText(stripslashes(replace($txt_prg->hbr->$id_lgg)), $fontStyle9, $paragraphStyle);
										$cell = $table->addCell(2500, $cellStyle7);
										$cell->addText(stripslashes(replace($txt_prg->chm->$id_lgg)), $fontStyle9, $paragraphStyle);
										foreach($hbr_id_opt_prs[$id_dev_prs] as $i => $id_hbr){
											$table->addRow($height2);
											$cell = $table->addCell(2000, $cellStyle7);
											if($id_hbr>0){
												$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
												$cell->addText(stripslashes(replace($vll[$dt_hbr['id_vll']])), $fontStyle6, $paragraphStyle);
												$cell = $table->addCell(2000, $cellStyle7);
												$cell->addText(stripslashes(replace($ctg_hbr[$id_lgg][$dt_hbr['ctg']])), $fontStyle6, $paragraphStyle);
												$cell = $table->addCell(2500, $cellStyle7);
												if(empty($dt_hbr['titre'])){$cell->addText(stripslashes(replace($dt_hbr['nom'])), $fontStyle6, $paragraphStyle);}
												elseif(!empty($dt_hbr['web'])){$cell->addLink($dt_hbr['web'],stripslashes(replace_lnk($dt_hbr['titre'])), $linkStyle, $paragraphStyle);}
												else{$cell->addText(stripslashes(replace($dt_hbr['titre'])), $fontStyle6, $paragraphStyle);}
												$cell = $table->addCell(2500, $cellStyle7);
												if($chm_id_opt_prs[$id_dev_prs][$i]!=0){
													$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$chm_id_opt_prs[$id_dev_prs][$i]));
													if(!empty($dt_chm['titre'])){$cell->addText(stripslashes(replace($dt_chm['titre'])), $fontStyle6, $paragraphStyle);}
													else{$cell->addText(stripslashes(replace($dt_chm['nom'])), $fontStyle6, $paragraphStyle);}
												}
												else{$cell->addText(stripslashes(replace($txt->err->chm->$id_lng)), $fontStyle10, $paragraphStyle);}
											}
											else{
												$cell->addText(stripslashes(replace($vll[$vll_hbr_opt_prs[$id_dev_prs][$i]])), $fontStyle6, $paragraphStyle);
												$cell = $table->addCell(2000, $cellStyle7);
												$cell = $table->addCell(2500, $cellStyle7);
												$cell->addText(stripslashes(replace($txt->err->hbr->$id_lng)), $fontStyle10, $paragraphStyle);
												$cell = $table->addCell(2000, $cellStyle7);
											}
										}
										$section->addText('', $fontStyle6, $paragraphStyle2);
										if(isset($opt_hbr_id_opt_prs[$id_dev_prs])){
											$section->addText(stripslashes(replace($txt_prg->hbr_opt->$id_lgg)), $fs_mdl2[$id_trf], $paragraphStyle2);
											$table = $section->addTable($tableStyle2);
											$table->addRow($height2);
											$cell = $table->addCell(2000, $cellStyle7);
											$cell->addText(stripslashes(replace($txt_prg->vll->$id_lgg)), $fontStyle9, $paragraphStyle);
											$cell = $table->addCell(2000, $cellStyle7);
											$cell->addText(stripslashes(replace($txt_prg->ctg->$id_lgg)), $fontStyle9, $paragraphStyle);
											$cell = $table->addCell(2500, $cellStyle7);
											$cell->addText(stripslashes(replace($txt_prg->hbr->$id_lgg)), $fontStyle9, $paragraphStyle);
											$cell = $table->addCell(2500, $cellStyle7);
											$cell->addText(stripslashes(replace($txt_prg->chm->$id_lgg)), $fontStyle9, $paragraphStyle);
											$cell = $table->addCell(2500, $cellStyle7);
											$cell->addText(stripslashes(replace($txt_prg->sup->$id_lgg)), $fontStyle9, $paragraphStyle);
											foreach($opt_hbr_id_opt_prs[$id_dev_prs] as $i => $id_hbr){
												if($id_cat_prs>0){
													$prx = $trf_opt_hbr_db_opt_prs_cat[$id_cat_prs][$i]/2;
													$prx_sg = $trf_opt_hbr_sg_opt_prs_cat[$id_cat_prs][$i];
													$prx_tp = $trf_opt_hbr_tp_opt_prs_cat[$id_cat_prs][$i]/3;
													$prx_qd = $trf_opt_hbr_qd_opt_prs_cat[$id_cat_prs][$i]/4;
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
													$err_sg = $err_trf_sg_opt_hbr_opt_prs[$id_dev_prs][$i];
													$err_db = $err_trf_db_opt_hbr_opt_prs[$id_dev_prs][$i];
													$err_tp = $err_trf_tp_opt_hbr_opt_prs[$id_dev_prs][$i];
													$err_qd = $err_trf_qd_opt_hbr_opt_prs[$id_dev_prs][$i];
												}


												$table->addRow($height);
												if($id_hbr>0){
													$dt_hbr = ftc_ass(sel_quo("*","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr.id = cat_hbr_txt.id_hbr AND lgg=".$lgg_crc,"cat_hbr.id",$id_hbr));
													$cell = $table->addCell(2000, $cellStyle7);
													$cell->addText(stripslashes(replace($vll[$dt_hbr['id_vll']])), $fontStyle6, $paragraphStyle);
													$cell = $table->addCell(2000, $cellStyle7);
													$cell->addText(stripslashes(replace($ctg_hbr[$id_lgg][$dt_hbr['ctg']])), $fontStyle6, $paragraphStyle);
													$cell = $table->addCell(2500, $cellStyle7);
													if(empty($dt_hbr['titre'])){$cell->addText(stripslashes(replace($dt_hbr['nom'])), $fontStyle6, $paragraphStyle);}
													elseif(!empty($dt_hbr['web'])){$cell->addLink($dt_hbr['web'],stripslashes(replace_lnk($dt_hbr['titre'])), $linkStyle, $paragraphStyle);}
													else{$cell->addText(stripslashes(replace($dt_hbr['titre'])), $fontStyle6, $paragraphStyle);}
													$cell = $table->addCell(2500, $cellStyle7);
													if($opt_chm_id_opt_prs[$id_dev_prs][$i]!=0){
														$dt_chm = ftc_ass(sel_quo("nom,titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm.id = cat_hbr_chm_txt.id_hbr_chm AND lgg=".$lgg_crc,"cat_hbr_chm.id",$opt_chm_id_opt_prs[$id_dev_prs][$i]));
														if(!empty($dt_chm['titre'])){$cell->addText(stripslashes(replace($dt_chm['titre'])), $fontStyle6, $paragraphStyle);}
														else{$cell->addText(stripslashes(replace($dt_chm['nom'])), $fontStyle6, $paragraphStyle);}
													}
													else{$cell->addText(stripslashes(replace($txt->err->chm->$id_lng)), $fontStyle10, $paragraphStyle);}
												}
												else{
													$cell = $table->addCell(2000, $cellStyle7);
													$cell->addText(stripslashes(replace($vll[$opt_hbr_vll_opt_prs[$id_dev_prs][$i]])), $fontStyle6, $paragraphStyle);
													$cell = $table->addCell(2000, $cellStyle7);
													$cell = $table->addCell(2500, $cellStyle7);
													$cell->addText(stripslashes(replace($txt->err->hbr->$id_lng)), $fontStyle10, $paragraphStyle);
													$cell = $table->addCell(2000, $cellStyle7);
												}
												$cell = $table->addCell(2500, $cellStyle7);
												if($vue_sgl==1){
													if(!$err_sg){$cell->addText(stripslashes(replace($txt_prg->sgl->$id_lgg.' : '.number_format($prx_sg,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
													else{$cell->addText(stripslashes(replace($txt->sgl->$id_lng.' : '.$txt->err->trf->$id_lng)), $fontStyle10, $paragraphStyle);}
												}
												if($vue_dbl==1){
													if(!$err_db){$cell->addText(stripslashes(replace($txt_prg->dbl->$id_lgg.' : '.number_format($prx,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
													else{$cell->addText(stripslashes(replace($txt->dbl->$id_lng.' : '.$txt->err->trf->$id_lng)), $fontStyle10, $paragraphStyle);}
												}
												if($vue_tpl==1){
													if(!$err_tp){$cell->addText(stripslashes(replace($txt_prg->tpl->$id_lgg.' : '.number_format($prx_tp,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
													else{$cell->addText(stripslashes(replace($txt_prg->tpl->$id_lgg." : ".$txt_prg->nd->$id_lgg)), $fontStyle6, $paragraphStyle);}
												}
												if($vue_qdp==1){
													if(!$err_qd){$cell->addText(stripslashes(replace($txt_prg->qdp->$id_lgg.' : '.number_format($prx_qd,0,',',' ').' '.$prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle);}
													else{$cell->addText(stripslashes(replace($txt_prg->qdp->$id_lgg." : ".$txt_prg->nd->$id_lgg)), $fontStyle6, $paragraphStyle);}
												}
											}
											$section->addText('', $fontStyle6, $paragraphStyle2);
										}
									}
								}
							}
						}
						if($id_trf==0){$flg_trf_mdl=false;}
					}
				}
			}
		}
		if(isset($sel_prs_id)){
			$section->addText('', $fontStyle8, $paragraphStyle2);
			if($vue_dt_trf){$section->addText(stripslashes(replace($txt_prg->dt_trf->$id_lgg)), $fontStyle5, $paragraphStyle2);}
			else{$section->addText(stripslashes(replace($txt_prg->inc->$id_lgg)), $fontStyle5, $paragraphStyle2);}
			$section->addText('', $fontStyle9, $paragraphStyle2);
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
								$dt_ttr = ftc_ass(sel_quo("titre","dev_prs","id",$id_dev_prs));
								$flg_s = false;
							}
							if(!empty($dt_ttr['titre'])){
								if($flg_s){$section->addText(stripslashes(replace($txt_prg->jours->$id_lgg.' '.$jrn.' : '.$dt_ttr['titre'])), $fs_mdl3[$id_trf], $paragraphStyle2);}
								else{$section->addText(stripslashes(replace($txt_prg->jour->$id_lgg.' '.$jrn.' : '.$dt_ttr['titre'])), $fs_mdl3[$id_trf], $paragraphStyle2);}
								if($vue_dt_trf){
									$table = $section->addTable($tableStyle);
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
										$table->addRow($height);
										$cell = $table->addCell(3900, $cellStyle5);
										if(number_format($prx,0)!=0){$cell->addText(stripslashes(replace($base)).' :', $fontStyle6, $paragraphStyle2);}
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
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
											$table->addRow($height);
											if($ptl){
												$cell = $table->addCell(3900, $cellStyle5);
												$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.'+1 :', $fontStyle6, $paragraphStyle2);
											}
											else{
												$cell = $table->addCell(3900, $cellStyle5);
												$cell->addText(stripslashes(replace($txt_prg->base->$id_lgg)).' '.$base.' :', $fontStyle6, $paragraphStyle2);
											}
											$cell = $table->addCell(1000, $cellStyle6);
											$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
											$cell = $table->addCell(1500, $cellStyle5);
											$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
										}
									}
									if($vue_sgl==1 and $trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_sg_hbr_sel_prs[$id_dev_prs]>0){
										if($id_cat_prs>0){$prx = $trf_sg_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]-$trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2;}
										else{$prx = $trf_sg_hbr_sel_prs[$id_dev_prs]-$trf_db_hbr_sel_prs[$id_dev_prs]/2;}
										$table = $section->addTable($tableStyle);
										$table->addRow($height);
										$cell = $table->addCell(3900, $cellStyle5);
										$cell->addText(stripslashes(replace($txt_prg->sup_sgl->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
									}
									if($vue_tpl==1 and $trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_tp_hbr_sel_prs[$id_dev_prs]>0){
										if($id_cat_prs>0){$prx = $trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2-$trf_tp_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/3;}
										else{$prx = $trf_db_hbr_sel_prs[$id_dev_prs]/2-$trf_tp_hbr_sel_prs[$id_dev_prs]/3;}
										$table = $section->addTable($tableStyle);
										$table->addRow($height);
										$cell = $table->addCell(3900, $cellStyle5);
										$cell->addText(stripslashes(replace($txt_prg->red_tpl->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
									}
									if($vue_qdp==1 and $trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]>0 or $trf_db_hbr_sel_prs[$id_dev_prs]>0){
										if($id_cat_prs>0){$prx = $trf_db_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/2-$trf_qd_hbr_sel_prs_cat[$id_dev_mdl][$id_cat_prs]/4;}
										else{$prx = $trf_db_hbr_sel_prs[$id_dev_prs]/2-$trf_qd_hbr_sel_prs[$id_dev_prs]/4;}
										$table = $section->addTable($tableStyle);
										$table->addRow($height);
										$cell = $table->addCell(3900, $cellStyle5);
										$cell->addText(stripslashes(replace($txt_prg->red_qdp->$id_lgg)).' :', $fontStyle6, $paragraphStyle2);
										$cell = $table->addCell(1000, $cellStyle6);
										$cell->addText(number_format($prx,0,',',' '), $fontStyle9, $paragraphStyle2);
										$cell = $table->addCell(1500, $cellStyle5);
										$cell->addText(stripslashes(replace($prm_crr_nom[$dt_crc['crr']].$txt_prg->pers2->$id_lgg)), $fontStyle6, $paragraphStyle2);
									}
								}
								$section->addText('', $fontStyle6, $paragraphStyle2);
							}
						}
					}
				}
			}
		}
	//EN CAS D'URGENCE
		$section ->addText('', $fontStyle6, $paragraphStyle2);
		$section->addText(stripslashes(replace($txt_prg->urg->$id_lgg)), $fontStyle13, $paragraphStyle2);
		$section ->addText('', $fontStyle6, $paragraphStyle2);
		$section ->addText(stripslashes(replace($txt_prg->dt_urg->$id_lgg)), $fontStyle6, $paragraphStyle2);
		$section ->addText('', $fontStyle6, $paragraphStyle2);
	//ITINERAIRE
		$flg_map = true;
		foreach($map as $i => $lnk){
			if($lnk!=''){
				if($flg_map){
					$section = $PHPWord->createSection($sectionStyle);
					$section->addText(stripslashes(replace($txt_prg->iti->$id_lgg)), $fontStyle13, $paragraphStyle2);
					$section ->addText('', $fontStyle9, $paragraphStyle2);
				}
				$flg_map = false;
				if(strlen($lnk)<2049){
					copy($lnk, "../tmp/".$dir."/file".$i.".jpeg");
					$section->addMemoryImage("../tmp/".$dir."/file".$i.".jpeg", $imageStyle3);
					$dsc = explode('<br />',stripslashes(replace(nl2br(trim($leg[$i])))));
					foreach($dsc as $lgn){$section->addText(trim($lgn), $fontStyle6, $paragraphStyle2);}
					$section->addText('', $fontStyle6, $paragraphStyle2);
				}
			}
		}
	}
//EXPORT
	if($cbl=='dev' and $vrs>1){$ttr .= "_V".$vrs;}
	if($cnf>0){$ttr .= "_".stripslashes(replace($txt_prg->cnf->$id_lgg));}
	$ttr .= ".docx";
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
