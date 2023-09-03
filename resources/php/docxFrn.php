<?php //CREATE A DOCX FILE PRINTING SERVICE DATAS INCLUDED IN A QUOTATION FOR ONE OR ALL SUPPLIERS
if(isset($_GET['id']) and $_GET['id'] > 0 and isset($_GET['frn']) and $_GET['frn'] >= 0)
{
	$id_dev_crc = $_GET['id'];
	$id_res_frn = $_GET['frn'];
	$obj = 'doc';
	$rsp = '';
	include("resFrn.php");
	require "../../vendor/autoload.php";
	$fontStyle = array('name' => 'Arial', 'color'=>'000000', 'size'=>10);
	$fontStyle2 = array('name' => 'Arial', 'color'=>'FF0000', 'size'=>10);
	$paragraphStyle = array('align'=>'left', 'spaceBefore'=>0, 'spaceAfter'=>0, 'spacing'=>0);
	if(isset($lst_dev))
	{
		$pw = new \PhpOffice\PhpWord\PhpWord();
		foreach($lst_dev as $id_dev)
		{
			$section = $pw->addSection(array('marginLeft' => 1000, 'marginRight' => 775, 'marginTop' => 700, 'marginBottom' => 850));
			if(isset($tab_frn[$id_dev]))
			{
				foreach($tab_frn[$id_dev] as $i => $fr)
				{
					$section->addText('Grupo: '.replace($nom_gpe[$id_dev])." x".$nbpax[$id_dev][$fr], $fontStyle, $paragraphStyle);
					$dt_cat_frn = ftc_ass(sel_quo("nom", "cat_frn", "id", $fr));
					$section->addText(replace($dt_cat_frn['nom']), $fontStyle, $paragraphStyle);
					if(!$flg_send[$id_dev][$fr])
					{
						$dsc = explode('<br />', stripslashes(replace(nl2br(trim($rsp)))));
						foreach($dsc as $lgn)
						{
							$section->addText(trim($lgn), $fontStyle2, $paragraphStyle);
						}
					}
					$dsc = explode('<br />', stripslashes(replace(nl2br(trim($message[$id_dev][$fr])))));
					foreach($dsc as $lgn)
					{
						$section->addText(trim($lgn), $fontStyle, $paragraphStyle);
					}
				}
			}elseif(!empty($rsp))
			{
				echo $rsp;
			}
		}
		$ttr = "Lista_proveedores";
		if($id_res_frn > 0)
		{
			$dt_cat_frn = ftc_ass(sel_quo("nom", "cat_frn", "id", $id_res_frn));
			$ttr .= "_".str_replace(array(" ", "/"), "_", stripslashes($dt_cat_frn['nom']));
		}
		$grp = str_replace(array(" ", "/"), "_", stripslashes($nom_gpe[$id_dev]));
		$file .= $ttr."_".$grp.".docx";
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, 'Word2007');
		$objWriter->save("../../tmp/".$dir."/".$file);
		if(file_exists("../../tmp/".$dir."/".$file))
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
