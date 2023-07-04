<?php
if(isset($_GET['id']) and !empty($_GET['id'])){
	$id = $_GET['id'];
	$cbl  = $_GET['cbl'];
	$txt_res = simplexml_load_file('../resources/xml/resTxt.xml');
	include("../prm/fct.php");
	include("../prm/lgg.php");
	include("../prm/rpl.php");
	include("../prm/room.php");
	include("../prm/ncn.php");
	include("../cfg/lng.php");
	$id_lgg = $lgg[$lgg_pys];
//DOC SETTINGS
	require "../vendor/autoload.php";
	//require_once '../vendor/PHPWord.php';
	$pw = new \PhpOffice\PhpWord\PhpWord();
	//$PHPWord = new PHPWord();
	$section = $pw->addSection(	array('marginLeft' => 1000, 'marginRight' => 775, 'marginTop' => 700, 'marginBottom' => 850));
	//$section = $PHPWord->createSection($sectionStyle);
	$tableStyle = '';
	$height = '';
	$cellStyle2 = '';
	$fontStyle = array('name' => 'Arial', 'color'=>'000000', 'size'=>10);
	$fontStyle2 = array('name' => 'Arial', 'color'=>'000000', 'size'=>10, 'bold'=>true);
	$paragraphStyle = array('align'=>'left','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	$paragraphStyle2 = array('align'=>'both','spaceBefore'=>0,'spaceAfter'=>0,'spacing'=>0);
	if($cbl=='crc'){
		$dt_dev = ftc_ass(sel_quo("groupe","dev_crc","id",$id));
		$rq_crc_pax = sel_quo("id_pax, grp_pax.*","dev_crc_pax INNER JOIN grp_pax ON dev_crc_pax.id_pax = grp_pax.id","id_crc",$id,"ord");
		$num_pax = num_rows($rq_crc_pax);
		if($num_pax>0){
			$table = $section->addTable($tableStyle);
			$table->addRow($height);
			$cell = $table->addCell(2500, $cellStyle2);
			$cell->addText(replace($txt_res->nom->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(2500, $cellStyle2);
			$cell->addText(replace($txt_res->pre->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->dob->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->psp->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->exp->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->ncn->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->info->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			while($dt_crc_pax = ftc_ass($rq_crc_pax)){
				$table->addRow($height);
				$cell = $table->addCell(2500, $cellStyle2);
				$cell->addText(replace($dt_crc_pax['nom']), $fontStyle, $paragraphStyle);
				$cell = $table->addCell(2500, $cellStyle2);
				$cell->addText(replace($dt_crc_pax['pre']), $fontStyle, $paragraphStyle);
				$cell = $table->addCell(1500, $cellStyle2);
				if($dt_crc_pax['dob']!='0000-00-00'){$cell->addText(date("d/m/Y", strtotime($dt_crc_pax['dob'])), $fontStyle, $paragraphStyle);}
				$cell = $table->addCell(1500, $cellStyle2);
				$cell->addText($dt_crc_pax['psp'], $fontStyle, $paragraphStyle);
				$cell = $table->addCell(1500, $cellStyle2);
				if($dt_crc_pax['exp']!='0000-00-00'){$cell->addText(date("d/m/Y", strtotime($dt_crc_pax['exp'])), $fontStyle, $paragraphStyle);}
				$cell = $table->addCell(1500, $cellStyle2);
				$cell->addText(replace($ncn[$id_lgg][$dt_crc_pax['ncn']]), $fontStyle, $paragraphStyle);
				$cell = $table->addCell(1500, $cellStyle2);
				$cell->addText($dt_crc_pax['info'], $fontStyle, $paragraphStyle);
			}
		}
	}
	if($cbl=='mdl'){
		$dt_dev = ftc_ass(sel_quo("groupe,ord","dev_crc INNER JOIN dev_mdl ON dev_crc.id = dev_mdl.id_crc","dev_mdl.id",$id));
		$rq_mdl_pax = sel_quo("id_pax, grp_pax.*","dev_mdl_pax INNER JOIN grp_pax ON dev_mdl_pax.id_pax = grp_pax.id","id_mdl",$id,"ord");
		$num_pax = num_rows($rq_mdl_pax);
		if($num_pax>0){
			$table = $section->addTable($tableStyle);
			$table->addRow($height);
			$cell = $table->addCell(2500, $cellStyle2);
			$cell->addText(replace($txt_res->nom->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(2500, $cellStyle2);
			$cell->addText(replace($txt_res->pre->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->dob->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->psp->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->exp->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			$cell->addText(replace($txt_res->ncn->$id_lgg.':'), $fontStyle2, $paragraphStyle);
			$cell = $table->addCell(1500, $cellStyle2);
			while($dt_mdl_pax = ftc_ass($rq_mdl_pax)){
				$table->addRow($height);
				$cell = $table->addCell(2500, $cellStyle2);
				$cell->addText(replace($dt_mdl_pax['nom']), $fontStyle, $paragraphStyle);
				$cell = $table->addCell(2500, $cellStyle2);
				$cell->addText(replace($dt_mdl_pax['pre']), $fontStyle, $paragraphStyle);
				$cell = $table->addCell(1500, $cellStyle2);
				if($dt_mdl_pax['dob']!='0000-00-00'){$cell->addText(date("d/m/Y", strtotime($dt_mdl_pax['dob'])), $fontStyle, $paragraphStyle);}
				$cell = $table->addCell(1500, $cellStyle2);
				$cell->addText($dt_mdl_pax['psp'], $fontStyle, $paragraphStyle);
				$cell = $table->addCell(1500, $cellStyle2);
				if($dt_mdl_pax['exp']!='0000-00-00'){$cell->addText(date("d/m/Y", strtotime($dt_mdl_pax['exp'])), $fontStyle, $paragraphStyle);}
				$cell = $table->addCell(1500, $cellStyle2);
				$cell->addText(replace($ncn[$id_lgg][$dt_mdl_pax['ncn']]), $fontStyle, $paragraphStyle);
				$cell = $table->addCell(1500, $cellStyle2);
				$cell->addText($dt_mdl_pax['info'], $fontStyle, $paragraphStyle);
			}
		}
	}
//EXPORT
	$ttr = "Lista_paxs_".$cbl;
	if($cbl=='mdl'){$ttr .= $dt_dev['ord'];}
	$grp = str_replace(array(" ","/"),"_",stripslashes($dt_dev['groupe']));
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
}
?>
