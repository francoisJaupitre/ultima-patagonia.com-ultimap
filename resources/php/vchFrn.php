<?php //CREATE A DOCX FILE PRINTING CONFIRMED SERVICE VOUCHERS FOR ONE OR ALL SUPPLIERS
if(isset($_GET['id']) and $_GET['id'] > 0 and isset($_GET['frn']) and $_GET['frn'] >= 0)
{
	$id_dev_crc = $_GET['id'];
	$id_res_frn = $_GET['frn'];
	$obj = 'vch';
	$txt_vch = simplexml_load_file('txt_vch.xml');
	include("resFrn.php");
	include("../../cfg/clt.php");
	$id_dev = $id_dev_crc;
	$id_clt = $id_clt[$id_dev];
	require_once '../vendor/PHPWord.php';
	$sectionStyle = array('orientation' => null, 'marginLeft' => 1200, 'marginRight' => 1000, 'marginTop' => 900, 'marginBottom' => 800);
	$height = 100;
	$imageStyle2 = array('width'=>2, 'height'=>0.4, 'align'=>'left');
	$cellStyle3 = array('valign'=>'center', 'borderTopSize' => 10, 'borderTopColor' => '006699', 'borderBottomSize'=>10, 'borderBottomColor' => '006699');
	$fontStyle = array('name' => 'Arial', 'color'=>'000000', 'size'=>10);
	$fontStyle2 = array('name' => 'Arial', 'color'=>'000000', 'size'=>24, 'bold'=>true);
	$fontStyle3 = array('name' => 'Arial', 'color'=>'000000', 'size'=>14);
	$fontStyle4 = array('name' => 'Arial', 'color'=>'000000', 'size'=>10, 'bold'=>true);
	$fontStyle5 = array('name' => 'Arial', 'color'=>'FF0000', 'size'=>10);
	$paragraphStyle = array('align'=>'left', 'spaceBefore'=>50, 'spaceAfter'=>50, 'spacing'=>50);
	$paragraphStyle2 = array('align'=>'both', 'spaceBefore'=>0, 'spaceAfter'=>0, 'spacing'=>0);
	$paragraphStyle3 = array('align'=>'center', 'spaceBefore'=>0, 'spaceAfter'=>0, 'spacing'=>0);
	$paragraphStyle4 = array('align'=>'left', 'spaceBefore'=>0, 'spaceAfter'=>0, 'spacing'=>0);
	$PHPWord = new PHPWord();
	if(isset($rsp))
	{
		$section = $PHPWord->createSection($sectionStyle);
		$section->addText(replace($rsp), $fontStyle5, $paragraphStyle);
	}
	if(isset($tab_frn[$id_dev]))
	{
		foreach($tab_frn[$id_dev] as $i => $fr)
		{
			foreach(array_unique($tab_prs[$id_dev][$fr]) as $j => $pr)
			{
				if($tab_ctg_prs[$id_dev][$fr][$j] != 19 and $tab_ctg_prs[$id_dev][$fr][$j] != 20 and $tab_ctg_prs[$id_dev][$fr][$j] != 24)
				{
					$section = $PHPWord->createSection($sectionStyle);
					$table = $section->addTable($tableStyle);
					$table->addRow($height);
					$cell = $table->addCell(3000, $cellStyle2);
					if($clt_tmpl[$id_clt] == 1)
					{
						$nom_clt = str_replace(" ", "_", $clt[$id_clt]);
						$cell->addImage('../prm/img/'.$dir.'/'.$nom_clt.'_logo.jpg', $imageStyle2);
					}else{
						$cell->addImage('../prm/img/'.$dir.'/logo2.jpg', $imageStyle2);
					}
					$cell = $table->addCell(7000, $cellStyle3);
					$cell->addText(stripslashes(replace($txt_vch->msg2->$id_lgg)), $fontStyle, $paragraphStyle3);
					$cell->addText(stripslashes(replace($txt_vch->msg3->$id_lgg)), $fontStyle, $paragraphStyle3);
					$cell->addText(stripslashes(replace($txt_vch->msg4->$id_lgg)), $fontStyle, $paragraphStyle3);
					$section->addText('', $fontStyle3, $paragraphStyle2);
					$section->addText(stripslashes(replace($txt_vch->vch->$id_lgg)), $fontStyle2, $paragraphStyle);
					$section->addText('', $fontStyle3, $paragraphStyle2);
					$section->addText('', $fontStyle3, $paragraphStyle2);
					$dt_cat_frn = ftc_ass(sel_quo("*", "cat_frn", "id", $fr));
					if(!empty($dt_cat_frn['titre']))
					{
						$section->addText(stripslashes(replace($dt_cat_frn['titre'])), $fontStyle3, $paragraphStyle2);
					}else{
						$section->addText(stripslashes(replace($dt_cat_frn['nom'])), $fontStyle3 , $paragraphStyle2);
					}
					if(!empty($dt_cat_frn['adresse']))
					{
						$section->addText(stripslashes(replace($dt_cat_frn['adresse'])), $fontStyle, $paragraphStyle2);
					}
					if(!empty($dt_cat_frn['tel']))
					{
						$section->addText(stripslashes(replace($dt_cat_frn['tel'])), $fontStyle, $paragraphStyle2);
					}
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$table = $section->addTable($tableStyle);
					$table->addRow($height2);
					$cell = $table->addCell(2000, $cellStyle);
					if($tab_rva[$id_dev][$fr][$j] != '')
					{
						$cell->addText(stripslashes(replace($txt_vch->rva->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
						if($id_lgg_frn != $id_lgg)
						{
							$cell->addText('['.stripslashes(replace($txt_vch->rva->$id_lgg_frn.']')), $fontStyle, $paragraphStyle2);
						}
					}
					$cell = $table->addCell(2000, $cellStyle);
					$cell->addText(stripslashes(replace($tab_rva[$id_dev][$fr][$j])), $fontStyle, $paragraphStyle2);
					$cell = $table->addCell(1500, $cellStyle);
					$cell->addText(stripslashes(replace($txt_vch->sir->$id_lgg.':')), $fontStyle4, $paragraphStyle2);
					if($id_lgg_frn != $id_lgg)
					{
						$cell->addText('['.stripslashes(replace($txt_vch->sir->$id_lgg_frn.']')), $fontStyle, $paragraphStyle2);
					}
					$cell = $table->addCell(3500, $cellStyle);
					$msg = $nom_gpe[$id_dev].' x'.$tab_nb_pax_fr[$id_dev][$fr][$j];
					if($prs_guia[$tab_prs_id[$id_dev][$fr][$j]])
					{
						$msg .= ' +'.$txt_vch->guia->$id_lgg_frn;
					}
					$cell->addText(stripslashes(replace($msg)), $fontStyle3, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$dt_cat_prs = ftc_ass(sel_quo(
						"cat_prs.*, cat_prs_txt.titre",
						"cat_prs LEFT JOIN cat_prs_txt ON cat_prs_txt.id_prs = cat_prs.id AND lgg = ".$lgg_crc[$id_dev],
						"cat_prs.id",
						$pr
					));
					if(!empty($dt_cat_prs['titre']))
					{
						$section->addText(stripslashes(replace($dt_cat_prs['titre'])), $fontStyle3, $paragraphStyle2);
					}else{
						$section->addText(stripslashes(replace($dt_cat_prs['nom'])), $fontStyle3, $paragraphStyle2);
					}
					if($lgg_frn != $lgg_crc[$id_dev])
					{
						$dt_cat_prs_trad = ftc_ass(sel_quo("titre", "cat_prs_txt", array("lgg", "id_prs"), array($lgg_frn, $pr)));
						if(!empty($dt_cat_prs_trad['titre']))
						{
							$section->addText('['.stripslashes(replace($dt_cat_prs_trad['titre'])).']', $fontStyle, $paragraphStyle2);
						}
					}
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					if($tab_ctg_prs[$id_dev][$fr][$j] != 10)
					{
						$msg = date("d/m/Y", strtotime($tab_in[$id_dev][$fr][$j]));
						$msg = date("d/m/Y", strtotime($tab_in[$id_dev][$fr][$j]));
						if($tab_out[$id_dev][$fr][$j] != $tab_in[$id_dev][$fr][$j])
						{
							$msg .= ' - '.date("d/m/Y", strtotime($tab_out[$id_dev][$fr][$j]));
						}
						$section->addText(stripslashes(replace($msg)), $fontStyle4, $paragraphStyle2);
						$section->addText('', $fontStyle, $paragraphStyle2);
						$section->addText('', $fontStyle, $paragraphStyle2);
						if(!is_null($tab_hre[$id_dev][$fr][$j]))
						{
							$section->addText(date("H:i", strtotime($tab_hre[$id_dev][$fr][$j])).$txt_vch->hs->$id_lgg, $fontStyle, $paragraphStyle2);
						}
						$rq_srv = sel_quo(
							"id_cat, id_frn, ctg, nom, titre",
							"dev_srv LEFT JOIN cat_srv_txt ON dev_srv.id_cat = cat_srv_txt.id_srv AND cat_srv_txt.lgg=".$lgg_frn,
							array("id_frn", "id_prs"),
							array($fr, $tab_prs_id[$id_dev][$fr][$j]),
							"id_frn, ctg, nom"
						);
						while($dt_srv = ftc_ass($rq_srv))
						{
							$msg = '';
							if($mrk_ctg_ctg_srv[$dt_srv['ctg']])
							{
								$msg .= ' '.$ctg_srv[$id_lgg_frn][$dt_srv['ctg']];
							}
							if($mrk_nom_ctg_srv[$dt_srv['ctg']])
							{
								if($dt_srv['titre'] == '')
								{
									$msg .= ' '.$dt_srv['nom'];
								}else{
									$msg .= ' '.$dt_srv['titre'];
								}
							}
							if($msg != '')
							{
								$section->addText(stripslashes(replace($msg)), $fontStyle, $paragraphStyle2);
							}
						}
					}else{
						$flg_pck = true;
						for($k = $j - 1; $k>=0 ; $k--)
						{
							if($tab_ctg_prs[$id_dev][$fr][$k] == 19 and $flg_pck)
							{
								$flg_pck = false;
								$msg = date("d/m/Y", strtotime($tab_in[$id_dev][$fr][$k]));
								if(!is_null($tab_hre[$id_dev][$fr][$k]))
								{
									$msg .= ' - '.date("H:i", strtotime($tab_hre[$id_dev][$fr][$k])).$txt_vch->hs->$id_lgg;
								}
								$section->addText(stripslashes(replace($msg)), $fontStyle4, $paragraphStyle2);
								$dt_cat_prs = ftc_ass(sel_quo(
									"cat_prs.*, cat_prs_txt.titre",
									"cat_prs LEFT JOIN cat_prs_txt ON cat_prs_txt.id_prs = cat_prs.id AND lgg=".$lgg_crc[$id_dev],
									"cat_prs.id", $tab_prs[$id_dev][$fr][$k]
								));
								if(!empty($dt_cat_prs['titre']))
								{
									$section->addText(stripslashes(replace($dt_cat_prs['titre'])), $fontStyle, $paragraphStyle);
								}else{
									$section->addText(stripslashes(replace($dt_cat_prs['nom'])), $fontStyle, $paragraphStyle);
								}
								if($lgg_frn != $lgg_crc[$id_dev])
								{
									$dt_cat_prs_trad = ftc_ass(sel_quo("titre", "cat_prs_txt", array("lgg", "id_prs"), array($lgg_frn, $tab_prs[$id_dev][$fr][$k])));
									if(!empty($dt_cat_prs_trad['titre']))
									{
										$section->addText('['.stripslashes(replace($dt_cat_prs_trad['titre'])).']', $fontStyle, $paragraphStyle);
									}
								}
								$section->addText('', $fontStyle, $paragraphStyle2);
								$section->addText('', $fontStyle, $paragraphStyle2);
								$section->addText('', $fontStyle, $paragraphStyle2);
							}
						}
						$flg_drp = true;
						for($k = $j + 1; $k < count($tab_prs[$id_dev][$fr]); $k++)
						{
							if($tab_ctg_prs[$id_dev][$fr][$k] == 20 and $flg_drp)
							{
								$flg_drp = false;
								$msg = date("d/m/Y", strtotime($tab_in[$id_dev][$fr][$k]));
								if(!is_null($tab_hre[$id_dev][$fr][$k]))
								{
									$msg .= ' - '.date("H:i", strtotime($tab_hre[$id_dev][$fr][$k])).$txt_vch->hs->$id_lgg;
								}
								$section->addText(stripslashes(replace($msg)), $fontStyle4, $paragraphStyle2);
								$dt_cat_prs = ftc_ass(sel_quo(
									"cat_prs.*, cat_prs_txt.titre",
									"cat_prs LEFT JOIN cat_prs_txt ON cat_prs_txt.id_prs = cat_prs.id AND lgg = ".$lgg_crc[$id_dev],
									"cat_prs.id",
									$tab_prs[$id_dev][$fr][$k]
								));
								if(!empty($dt_cat_prs['titre']))
								{
									$section->addText(stripslashes(replace($dt_cat_prs['titre'])), $fontStyle, $paragraphStyle);
								}else{
									$section->addText(stripslashes(replace($dt_cat_prs['nom'])), $fontStyle, $paragraphStyle);
								}
								if($lgg_frn != $lgg_crc[$id_dev])
								{
									$dt_cat_prs_trad = ftc_ass(sel_quo("titre", "cat_prs_txt", array("lgg", "id_prs"), array($lgg_frn, $tab_prs[$id_dev][$fr][$k])));
									if(!empty($dt_cat_prs_trad['titre']))
									{
										$section->addText('['.stripslashes(replace($dt_cat_prs_trad['titre'])).']', $fontStyle, $paragraphStyle);
									}
								}
								$section->addText('', $fontStyle, $paragraphStyle2);
								$section->addText('', $fontStyle, $paragraphStyle2);
								$section->addText('', $fontStyle, $paragraphStyle2);
							}
						}
					}
					$dt_mdl = ftc_ass(sel_quo("trf", "dev_mdl", "id", $tab_mdl[$id_dev][$fr][$j]));
					if($dt_mdl['trf'])
					{
						$rq_lst_pax = sel_quo(
							"*",
							"dev_mdl_pax INNER JOIN grp_pax ON dev_mdl_pax.id_pax = grp_pax.id",
							"id_mdl",
							$tab_mdl[$id_dev][$fr][$j],
							"ord"
						);
					}else{
						$rq_lst_pax = sel_quo(
							"*",
							"dev_crc_pax INNER JOIN grp_pax ON dev_crc_pax.id_pax = grp_pax.id",
							"id_crc",
							$id_dev,
							"ord"
						);
					}
					$section->addText('', $fontStyle, $paragraphStyle2);
					$section->addText('', $fontStyle, $paragraphStyle2);
					$flg_pax = true;
					while($dt_lst_pax = ftc_ass($rq_lst_pax))
					{
						if($flg_pax)
						{
							$table = $section->addTable($tableStyle);
							$table->addRow($height);
							$cell = $table->addCell(3500, $cellStyle2);
							$cell->addText(replace($txt_res->nom->$id_lgg_frn.':'), $fontStyle4, $paragraphStyle4);
							$cell = $table->addCell(3500, $cellStyle2);
							$cell->addText(replace($txt_res->pre->$id_lgg_frn.':'), $fontStyle4, $paragraphStyle4);
							$cell = $table->addCell(1700, $cellStyle2);
							$cell->addText(replace($txt_res->psp->$id_lgg_frn.':'), $fontStyle4, $paragraphStyle4);
							$cell = $table->addCell(1700, $cellStyle2);
							$cell->addText(replace($txt_res->ncn->$id_lgg_frn.':'), $fontStyle4, $paragraphStyle4);
							$flg_pax = false;
							$section->addText('', $fontStyle, $paragraphStyle2);
							$table = $section->addTable($tableStyle);
						}
						$table->addRow($height);
						$cell = $table->addCell(3500, $cellStyle2);
						$cell->addText(stripslashes(replace($dt_lst_pax['nom'])), $fontStyle, $paragraphStyle4);
						$cell = $table->addCell(3500, $cellStyle2);
						$cell->addText(stripslashes(replace($dt_lst_pax['pre'])), $fontStyle, $paragraphStyle4);
						$cell = $table->addCell(1700, $cellStyle2);
						$cell->addText(stripslashes(replace($dt_lst_pax['psp'])), $fontStyle, $paragraphStyle4);
						$cell = $table->addCell(1700, $cellStyle2);
						$cell->addText(stripslashes(replace($ncn[$id_lgg_frn][$dt_lst_pax['ncn']])), $fontStyle, $paragraphStyle4);
					}
				}
			}
		}
		$ttr = stripslashes(replace($txt_vch->ttr_frn->$id_lgg));
		if($id_res_frn > 0)
		{
			$dt_cat_frn = ftc_ass(sel_quo("nom", "cat_frn", "id", $id_res_frn));
			$ttr .= "_".str_replace(array(" ", "/"), "_", stripslashes($dt_cat_frn['nom']));
		}
		if($id_clt[$id_dev] != 1)
		{
			$ttr .= '_'.str_replace(array(" ", "/"), "_", stripslashes(replace($clt[$id_clt[$id_dev]])));
		}
		$grp = str_replace(array(" ", "/"), "_", stripslashes(replace($nom_gpe[$id_dev])));
		$file .= $ttr.'_'.$grp.".docx";
		$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
		$objWriter->save("../../tmp/".$dir."/".$file);
		if(file_exists("../../tmp/".$dir."/".$file))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attaprsent; filename='.basename("tmp/".$dir."/".$file));
			header('Content-Transfer-Encoding: binary');
			header("Expires: 0");
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: '.filesize("../../tmp/".$dir."/".$file));
			ob_clean();
			flush();
			readfile("../../tmp/".$dir."/".$file);
			exit;
		}
	}else{
		echo $txt->vch->$id_lng;
	}
}
?>
