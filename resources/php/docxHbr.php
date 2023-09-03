<?php //CREATE A DOCX FILE PRINTING ACCOMODATIONS DATAS INCLUDED IN A QUOTATION FOR ONE OR ALL SUPPLIERS
if(isset($_GET['id']) and isset($_GET['hbr']))
{
	$id_dev_crc = $_GET['id'];
	$id_res_hbr = $_GET['hbr'];
	$id_res_chm = $_GET['chm'];
	$obj = 'doc';
	include("resHbr.php");
	require "../../vendor/autoload.php";
	$fontStyle = array('name' => 'Arial', 'color'=>'000000', 'size'=>10);
	$fontStyle2 = array('name' => 'Arial', 'color'=>'FF0000', 'size'=>10);
	$paragraphStyle = array('align'=>'left', 'spaceBefore'=>0, 'spaceAfter'=>0, 'spacing'=>0);
	if(isset($lst_dev))
	{
		$pw = new \PhpOffice\PhpWord\PhpWord();
		foreach($lst_dev as $id_dev)
		{
			$section = $pw->addSection(	array('marginLeft' => 1000, 'marginRight' => 775, 'marginTop' => 700, 'marginBottom' => 850));
			if(isset($tab_hbr[$id_dev]))
			{
				foreach($tab_hbr[$id_dev] as $i => $hb)
				{
					unset($nbp, $npax);
					foreach($tab_rgm[$id_dev][$hb] as $r => $rg)
					{
						foreach($tab_chm[$id_dev][$hb][$rg] as $j => $ch)
						{
							$dt_mdl = ftc_ass(sel_quo("trf", "dev_mdl", "id", $tab_mdl[$id_dev][$hb][$rg][$j]));
							if($tab_rmn_pax[$id_dev][$hb][$rg][$j])
							{
								$id_rmn = $tab_rmn_pax[$id_dev][$hb][$rg][$j];
							}else{
								if($dt_mdl['trf'])
								{
									$dt_rmn = ftc_ass(sel_quo("id", "dev_mdl_rmn", array("nr", "id_mdl"), array("1", $tab_mdl[$id_dev][$hb][$rg][$j])));
								}else{
									$dt_rmn = ftc_ass(sel_quo("id", "dev_crc_rmn", array("nr", "id_crc"), array("1", $id_dev)));
								}
								$id_rmn = $dt_rmn['id'];
								if($id_rmn >0)
								{
									if($dt_mdl['trf'])
									{
										$rq_rmn_pax = sel_quo("*", "dev_mdl_rmn_pax", "id_rmn", $id_rmn, "room, nc");
									}else{
										$rq_rmn_pax = sel_quo("*", "dev_crc_rmn_pax", "id_rmn", $id_rmn, "room, nc");
									}
									$nbp[] = num_rows($rq_rmn_pax);
								}else{
									$nbp[] = 0;
								}
							}
						}
					}
					$nbp = array_unique($nbp);
					foreach($nbp as $np)
					{
						$npax.= $np.'/';
					}
					$npax = substr($npax, 0, -1);
					if($npax==0)
					{
						unset($nbp, $npax);
						foreach($tab_rgm[$id_dev][$hb] as $r => $rg)
						{
							foreach($tab_chm[$id_dev][$hb][$rg] as $j => $ch)
							{
								$nbp[] = $tab_nb_pax_hb[$id_dev][$hb][$rg][$j];
							}
						}
						$nbp = array_unique($nbp);
						foreach($nbp as $np)
						{
							$npax.= $np.'/';
						}
						$npax = substr($npax, 0, -1);
					}
					$section->addText('Grupo: '.replace($nom_gpe[$id_dev])." x".$npax, $fontStyle, $paragraphStyle);
					$dt_cat_hbr = ftc_ass(sel_quo("nom, ctg", "cat_hbr", "id", $hb));
					$section->addText(replace($dt_cat_hbr['nom']), $fontStyle, $paragraphStyle);
					$section->addText(replace($rsp), $fontStyle2, $paragraphStyle);
					foreach($tab_rgm[$id_dev][$hb] as $r => $rg)
					{
						foreach($tab_chm[$id_dev][$hb][$rg] as $j => $ch)
						{
							if($message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] != $ms)
							{
								$ms = $message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]];
								$dsc = explode('<br />', stripslashes(replace(nl2br(trim($ms)))));
								foreach($dsc as $lgn)
								{
									$section->addText(trim($lgn), $fontStyle, $paragraphStyle);
								}
								$dt_mdl = ftc_ass(sel_quo("trf", "dev_mdl", "id", $tab_mdl[$id_dev][$hb][$rg][$j]));
								if($tab_rmn_pax[$id_dev][$hb][$rg][$j])
								{
									$id_rmn = $tab_rmn_pax[$id_dev][$hb][$rg][$j];
								}else{
									if($dt_mdl['trf'])
									{
										$dt_rmn = ftc_ass(sel_quo("id", "dev_mdl_rmn", array("nr", "id_mdl"), array("1", $tab_mdl[$id_dev][$hb][$rg][$j])));
									}else{
										$dt_rmn = ftc_ass(sel_quo("id", "dev_crc_rmn", array("nr", "id_crc"), array("1", $id_dev)));
									}
									$id_rmn = $dt_rmn['id'];
								}
								if($id_rmn>0)
								{
									$flg_pax = true;
									if($dt_mdl['trf'])
									{
										$rq_rmn_pax = sel_quo("*", "dev_mdl_rmn_pax", "id_rmn", $id_rmn, "nc, room");
									}else{
										$rq_rmn_pax = sel_quo("*", "dev_crc_rmn_pax", "id_rmn", $id_rmn, "nc, room");
									}
									while($dt_rmn_pax = ftc_ass($rq_rmn_pax))
									{
										if($flg_pax)
										{
											$table = $section->addTable($tableStyle);
											$table->addRow($height);
											$cell = $table->addCell(2500, $cellStyle2);
											$cell->addText(replace($txt_res->nom->$id_lgg_hbr.':'), $fontStyle, $paragraphStyle);
											$cell = $table->addCell(2500, $cellStyle2);
											$cell->addText(replace($txt_res->pre->$id_lgg_hbr.':'), $fontStyle, $paragraphStyle);
											$cell = $table->addCell(1500, $cellStyle2);
											$cell->addText(replace($txt_res->psp->$id_lgg_hbr.':'), $fontStyle, $paragraphStyle);
											$cell = $table->addCell(1500, $cellStyle2);
											$cell->addText(replace($txt_res->ncn->$id_lgg_hbr.':'), $fontStyle, $paragraphStyle);
											if($rmg_hbr[$dt_cat_hbr['ctg']])
											{
												$cell = $table->addCell(1500, $cellStyle2);
												$cell->addText(replace($txt_res->rmn->$id_lgg_hbr.':'), $fontStyle, $paragraphStyle);
											}
											$flg_pax = false;;
										}
										if($dt_rmn_pax['room'] > 0)
										{
											$dt_pax = ftc_ass(sel_quo("*", "grp_pax", "id", $dt_rmn_pax['id_pax']));
											$table->addRow($height);
											$cell = $table->addCell(2500, $cellStyle2);
											$cell->addText(stripslashes(replace($dt_pax['nom'])), $fontStyle, $paragraphStyle);
											$cell = $table->addCell(2500, $cellStyle2);
											$cell->addText(stripslashes(replace($dt_pax['pre'])), $fontStyle, $paragraphStyle);
											$cell = $table->addCell(1500, $cellStyle2);
											$cell->addText(stripslashes(replace($dt_pax['psp'])), $fontStyle, $paragraphStyle);
											$cell = $table->addCell(1500, $cellStyle2);
											$cell->addText(stripslashes(replace($ncn[$id_lgg_hbr][$dt_pax['ncn']])), $fontStyle, $paragraphStyle);
											if($rmg_hbr[$dt_cat_hbr['ctg']])
											{
												$cell = $table->addCell(1500, $cellStyle2);
												$cell->addText(stripslashes(replace($room[$id_lgg_hbr][$dt_rmn_pax['room']])).' '.$dt_rmn_pax['nc'], $fontStyle, $paragraphStyle);
											}
										}
									}
									$section->addText('', $fontStyle, $paragraphStyle);
									$section->addText('', $fontStyle, $paragraphStyle);
								}
							}
						}
					}
				}
			}
		}
		$ttr = "Lista_alojamientos";
		if($id_res_hbr > 0)
		{
			$dt_cat_hbr = ftc_ass(sel_quo("nom", "cat_hbr", "id", $id_res_hbr));
			$ttr .= "_".str_replace(array(" ", "/"), "_", stripslashes($dt_cat_hbr['nom']));
		}
		$grp = str_replace(array(" ", "/"), "_", stripslashes($nom_gpe[$id_dev]));
		$file .= $ttr."_".$grp.".docx";
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, 'Word2007');
		$objWriter->save("../../tmp/".$dir."/".$file);
		if (file_exists("../../tmp/".$dir."/".$file))
		{
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename("tmp/".$dir."/".$file));
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
	}
	echo $rsp;
}
?>
