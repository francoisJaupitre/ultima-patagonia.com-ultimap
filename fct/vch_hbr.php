<?php
if(isset($_GET['id']) and !empty($_GET['id'])){
	$id_dev_crc = $_GET['id'];
	$id_res_hbr = $_GET['hbr'];
	$id_res_chm = 0;
	$obj = 'vch';
	$txt_vch = simplexml_load_file('txt_vch.xml');
	include("res_hbr.php");
	include("../cfg/clt.php");
	$id_dev = $id_dev_crc;
	$id_clt = $id_clt[$id_dev];
//DOC SETTINGS
	require_once '../vendor/PHPWord.php';
	$sectionStyle = array('orientation' => null,'marginLeft' => 1200,'marginRight' => 1000,'marginTop' => 900,'marginBottom' => 800);
	$height = 110;
	$imageStyle2 = array('width'=>2, 'height'=>0.4, 'align'=>'left');
	$cellStyle3 = array('valign'=>'center', 'borderTopSize' => 10, 'borderTopColor' => '006699', 'borderBottomSize'=>10, 'borderBottomColor' => '006699');
	$fontStyle = array('name' => 'Arial', 'color'=>'000000', 'size'=>10);
	$fontStyle2 = array('name' => 'Arial', 'color'=>'000000', 'size'=>24,'bold'=>true);
	$fontStyle3 = array('name' => 'Arial', 'color'=>'000000', 'size'=>14);
	$fontStyle4 = array('name' => 'Arial', 'color'=>'000000', 'size'=>10, 'bold'=>true);
	$fontStyle5 = array('name' => 'Arial', 'color'=>'ff0000', 'size'=>10);
	$paragraphStyle = array('align'=>'left','spaceBefore'=>50,'spaceAfter'=>50,'spacing'=>50);
	$paragraphStyle2 = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$paragraphStyle3 = array('align'=>'center','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$paragraphStyle4 = array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$PHPWord = new PHPWord();
	if(isset($rsp)){
		$section = $PHPWord->createSection($sectionStyle);
		$section->addText(replace($rsp), $fontStyle5, $paragraphStyle);
	}
	if(isset($tab_hbr[$id_dev])){
		foreach($tab_hbr[$id_dev] as $i => $hb){
			$dt_cat_hbr = ftc_ass(sel_quo("cat_hbr.*,cat_hbr_txt.titre,cat_hbr_txt.web","cat_hbr LEFT JOIN cat_hbr_txt ON cat_hbr_txt.id_hbr = cat_hbr.id AND lgg=".$lgg_crc[$id_dev],"cat_hbr.id",$hb));
			foreach($tab_rgm[$id_dev][$hb] as $r => $rg){
				foreach($tab_chm[$id_dev][$hb][$rg] as $j => $ch){
					$section = $PHPWord->createSection($sectionStyle);
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(3000, $cellStyle2);
					if($clt_tmpl[$id_clt]==1){
						$nom_clt = str_replace(" ","_",$clt[$id_clt]);
						$cell->addImage('../prm/img/'.$dir.'/'.$nom_clt.'_logo.jpg', $imageStyle2);
					}
					else{$cell->addImage('../prm/img/'.$dir.'/logo2.jpg', $imageStyle2);}
					$cell = $table->addCell(7000, $cellStyle3);
					$cell->addText(stripslashes(replace($txt_vch->msg2->$id_lgg)), $fontStyle, $paragraphStyle3);
					$cell->addText(stripslashes(replace($txt_vch->msg3->$id_lgg)), $fontStyle, $paragraphStyle3);
					$cell->addText(stripslashes(replace($txt_vch->msg4->$id_lgg)), $fontStyle, $paragraphStyle3);
					$section->addText('', $fontStyle3, $paragraphStyle2);
					$section->addText(stripslashes(replace($txt_vch->vch->$id_lgg)), $fontStyle2, $paragraphStyle);
					$section->addText('', $fontStyle3, $paragraphStyle2);
					$section->addText('', $fontStyle3, $paragraphStyle2);
					if(!empty($dt_cat_hbr['titre'])){$section->addText(stripslashes(replace($dt_cat_hbr['titre'])), $fontStyle3, $paragraphStyle2);}
					else{$section->addText(stripslashes(replace($dt_cat_hbr['nom'])), $fontStyle3 , $paragraphStyle2);}
					$section->addText('', $fontStyle, $paragraphStyle2);
					if(!empty($dt_cat_hbr['adresse'])){$section->addText(stripslashes(replace($dt_cat_hbr['adresse'])), $fontStyle, $paragraphStyle2);}
					$section->addText(stripslashes(replace($vll[$dt_cat_hbr['id_vll']])), $fontStyle, $paragraphStyle2);
					if(!empty($dt_cat_hbr['tel_hbr'])){$section->addText(stripslashes(replace($dt_cat_hbr['tel_hbr'])), $fontStyle, $paragraphStyle2);}
					/*if($lgg_hbr!=$lgg_crc[$id_dev]){
						$dt_cat_hbr_trad = ftc_ass(sel_quo("web","cat_hbr_txt",array("lgg","id_hbr"),array($lgg_crc[$id_dev],$hb)));
						if(!empty($dt_cat_hbr_trad['web'])){$section->addLink((replace($dt_cat_hbr_trad['web'])),'WEB', $linkStyle, $paragraphStyle2);}
						elseif(!empty($dt_cat_hbr['web'])){$section->addLink((replace($dt_cat_hbr['web'])),'WEB', $linkStyle, $paragraphStyle2);}
					}
					else{$section->addLink((replace($dt_cat_hbr['web'])),'WEB',$linkStyle, $paragraphStyle2);}*/
					if(!is_null($dt_cat_hbr['chk_in']) and !is_null($dt_cat_hbr['chk_out'])){
						$section->addText('', $fontStyle, $paragraphStyle2);
						$section->addText(stripslashes(replace($txt_vch->checkin->$id_lgg.': '.date("H:i", strtotime($dt_cat_hbr['chk_in'])).$txt_vch->hs->$id_lgg.' / '.$txt_vch->checkout->$id_lgg.': '.date("H:i", strtotime($dt_cat_hbr['chk_out'])).$txt_vch->hs->$id_lgg)), $fontStyle, $paragraphStyle2);
					}
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$table = $section->addTable($tableStyle);
					$table->addRow($height2);
					$cell = $table->addCell(2000, $cellStyle);
					if($tab_rva[$id_dev][$hb][$rg][$j]!=''){
						$cell->addText(stripslashes(replace($txt_vch->rva->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
						if($id_lgg_hbr!=$id_lgg){$cell->addText('['.stripslashes(replace($txt_vch->rva->$id_lgg_hbr.']')), $fontStyle, $paragraphStyle2);}
					}
					$cell = $table->addCell(2000, $cellStyle);
					$cell->addText(stripslashes(replace($tab_rva[$id_dev][$hb][$rg][$j])), $fontStyle, $paragraphStyle2);
					$cell = $table->addCell(1500, $cellStyle);
					$cell->addText(stripslashes(replace($txt_vch->sir->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
					if($id_lgg_hbr!=$id_lgg){$cell->addText('['.stripslashes(replace($txt_vch->sir->$id_lgg_hbr.']')), $fontStyle, $paragraphStyle2);}
					$cell = $table->addCell(3500, $cellStyle);

					$dt_mdl = ftc_ass(sel_quo("trf","dev_mdl","id",$tab_mdl[$id_dev][$hb][$rg][$j]));
					if($tab_rmn_pax[$id_dev][$hb][$rg][$j]){$id_rmn = $tab_rmn_pax[$id_dev][$hb][$rg][$j];}
					else{
						if($dt_mdl['trf']){$dt_rmn = ftc_ass(sel_quo("id","dev_mdl_rmn",array("nr","id_mdl"),array("1",$tab_mdl[$id_dev][$hb][$rg][$j])));}
						else{$dt_rmn = ftc_ass(sel_quo("id","dev_crc_rmn",array("nr","id_crc"),array("1",$id_dev)));}
						$id_rmn = $dt_rmn['id'];
					}
					if($dt_mdl['trf']){$rq_rmn_pax = sel_quo("*","dev_mdl_rmn_pax","id_rmn",$id_rmn,"room,nc");}
					else{$rq_rmn_pax = sel_quo("*","dev_crc_rmn_pax","id_rmn",$id_rmn,"room,nc");}
					$nb_pax = num_rows($rq_rmn_pax);
					$cell->addText(stripslashes(replace($nom_gpe[$id_dev].' x'.$nb_pax)), $fontStyle3, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$dt_cat_chm = ftc_ass(sel_quo("cat_hbr_chm.*,cat_hbr_chm_txt.titre","cat_hbr_chm LEFT JOIN cat_hbr_chm_txt ON cat_hbr_chm_txt.id_hbr_chm = cat_hbr_chm.id AND lgg=".$lgg_crc[$id_dev],"cat_hbr_chm.id",$tab_chm[$id_dev][$hb][$rg][$j]));
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(2000, $cellStyle2);
					$cell->addText(stripslashes(replace($txt_vch->ctg->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
					if($id_lgg_hbr!=$id_lgg){$cell->addText('['.stripslashes(replace($txt_vch->ctg->$id_lgg_hbr.']')), $fontStyle, $paragraphStyle2);}
					$cell = $table->addCell(7000, $cellStyle2);
					if(!empty($dt_cat_chm['titre'])){$cell->addText(stripslashes(replace($dt_cat_chm['titre'])), $fontStyle, $paragraphStyle2);}
					else{
						$cell->addText(stripslashes(replace($dt_cat_chm['nom'])), $fontStyle, $paragraphStyle2);
						if($lgg_hbr!=$lgg_crc[$id_dev]){
							$dt_cat_chm_trad = ftc_ass(sel_quo("titre","cat_hbr_chm_txt",array("lgg","id_hbr_chm"),array($lgg_hbr,$ch)));
							if(!empty($dt_cat_chm_trad['titre'])){$cell->addText('['.stripslashes(replace($dt_cat_chm_trad['titre'])).']', $fontStyle, $paragraphStyle2);}
						}
					}
					$section->addText('', $fontStyle, $paragraphStyle2);
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(2000, $cellStyle2);
					$cell->addText(stripslashes(replace($txt_vch->rgm->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
					if($id_lgg_hbr!=$id_lgg){$cell->addText('['.stripslashes(replace($txt_vch->rgm->$id_lgg_hbr)).']', $fontStyle, $paragraphStyle2);}
					$cell = $table->addCell(3000, $cellStyle2);
					$cell->addText(stripslashes(replace($rgm[$id_lgg][$rg])), $fontStyle, $paragraphStyle2);
					if($id_lgg_hbr!=$id_lgg){$cell->addText('['.stripslashes(replace($rgm[$id_lgg_hbr][$rg])).']', $fontStyle, $paragraphStyle2);}
					$section->addText('', $fontStyle, $paragraphStyle2);
					if($rmg_hbr[$dt_cat_hbr['ctg']]){
						$table = $section->addTable($tableStyle);
						$table->addRow($height);
						$cell = $table->addCell(2000, $cellStyle2);
						$cell->addText(stripslashes(replace($txt_res->rmn->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
						$cell = $table->addCell(5000, $cellStyle2);
						$cell->addText(stripslashes(replace($tab_rmn[$id_dev][$hb][$rg][$j])), $fontStyle, $paragraphStyle2);
						$section->addText('', $fontStyle, $paragraphStyle2);
					}
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(2000, $cellStyle2);
					$cell->addText(stripslashes(replace($txt_vch->checkin->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
					$cell = $table->addCell(4000, $cellStyle2);
					$msg = date("d/m/Y", strtotime($tab_in[$id_dev][$hb][$rg][$j]));
					if(isset($tab_early[$id_dev][$hb])){
						if(in_array($tab_in[$id_dev][$hb][$rg][$j],$tab_early[$id_dev][$hb])){$msg .= ' ('.$txt_vch->early->$id_lgg.')';}
					}
					$cell->addText(stripslashes(replace($msg)), $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(2000, $cellStyle2);
					$cell->addText(stripslashes(replace($txt_vch->checkout->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
					$cell = $table->addCell(4000, $cellStyle2);
					$msg = date("d/m/Y", strtotime($tab_out[$id_dev][$hb][$rg][$j]));
					if(isset($tab_late[$id_dev][$hb])){
						if(in_array($tab_out[$id_dev][$hb][$rg][$j],$tab_late[$id_dev][$hb])){$msg .= ' ('.$txt_vch->late->$id_lgg.')';}
					}
					$cell->addText(stripslashes(replace($msg)), $fontStyle, $paragraphStyle2);
					if($id_rmn>0){
						$section->addText('', $fontStyle, $paragraphStyle2);
						$section->addText('', $fontStyle, $paragraphStyle2);
						$flg_pax = true;
						while($dt_rmn_pax = ftc_ass($rq_rmn_pax)){
							if($flg_pax){
								$table = $section->addTable($tableStyle);
								$table->addRow($height);
								$cell = $table->addCell(2500, $cellStyle2);
								$cell->addText(replace($txt_res->nom->$id_lgg_hbr.':'), $fontStyle4, $paragraphStyle4);
								$cell = $table->addCell(2500, $cellStyle2);
								$cell->addText(replace($txt_res->pre->$id_lgg_hbr.':'), $fontStyle4, $paragraphStyle4);
								$cell = $table->addCell(1500, $cellStyle2);
								$cell->addText(replace($txt_res->psp->$id_lgg_hbr.':'), $fontStyle4, $paragraphStyle4);
								$cell = $table->addCell(1600, $cellStyle2);
								$cell->addText(replace($txt_res->ncn->$id_lgg_hbr.':'), $fontStyle4, $paragraphStyle4);
								if($rmg_hbr[$dt_cat_hbr['ctg']]){
									$cell = $table->addCell(1500, $cellStyle2);
									$cell->addText(replace($txt_res->rmn->$id_lgg_hbr.':'), $fontStyle4, $paragraphStyle4);
								}
								$flg_pax = false;
								$section->addText('', $fontStyle, $paragraphStyle2);
								$table = $section->addTable($tableStyle);
							}
							$dt_pax = ftc_ass(sel_quo("*","grp_pax","id",$dt_rmn_pax['id_pax']));
							$table->addRow($height);
							$cell = $table->addCell(2500, $cellStyle2);
							$cell->addText(stripslashes(replace($dt_pax['nom'])), $fontStyle, $paragraphStyle4);
							$cell = $table->addCell(2500, $cellStyle2);
							$cell->addText(stripslashes(replace($dt_pax['pre'])), $fontStyle, $paragraphStyle4);
							$cell = $table->addCell(1500, $cellStyle2);
							$cell->addText(stripslashes(replace($dt_pax['psp'])), $fontStyle, $paragraphStyle4);
							$cell = $table->addCell(1600, $cellStyle2);
							$cell->addText(stripslashes(replace($ncn[$id_lgg_hbr][$dt_pax['ncn']])), $fontStyle, $paragraphStyle4);
							if($rmg_hbr[$dt_cat_hbr['ctg']]){
								$cell = $table->addCell(1500, $cellStyle2);
								$cell->addText(stripslashes(replace($room[$id_lgg_hbr][$dt_rmn_pax['room']])).' '.$dt_rmn_pax['nc'], $fontStyle, $paragraphStyle4);
							}
						}
					}
				}
			}
		}
		$ttr = stripslashes(replace($txt_vch->ttr_hbr->$id_lgg));
		if($id_res_hbr!=0){
			$dt_cat_hbr = ftc_ass(sel_quo("nom","cat_hbr","id",$id_res_hbr));
			$ttr .= "_".str_replace(array(" ","/"),"_",stripslashes($dt_cat_hbr['nom']));
		}
		if($id_clt[$id_dev]!=1){$ttr .= "_".str_replace(array(" ","/"),"_",stripslashes(replace($clt[$id_clt[$id_dev]])));}
		$grp = str_replace(array(" ","/"),"_",stripslashes(replace($nom_gpe[$id_dev])));
		$file .= $ttr."_".$grp.".docx";
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
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
	}
	else{echo $txt->vch->$id_lng;}
}
?>
