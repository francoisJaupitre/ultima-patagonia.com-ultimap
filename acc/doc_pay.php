<?php
class Paiements{
	public $nom;
	public $dats = [];
	private $liqs = [];
	private $crrs = [];
	public $lst_liqs = [];
	private $bnq_id;
	private $bnq;
	function __construct($nom,$dat,$liq,$crr,$bnq_id,$bnq_dt) {
		$this->nom = $nom;
		$this->dats[strtotime($dat).$crr] = $dat;
		$this->liqs[strtotime($dat).$crr] = $liq;
		$this->crrs[strtotime($dat).$crr] = $crr;
		$this->lst_liqs[] = strtotime($dat).$crr;
		$this->bnq_id = $bnq_id;
		$this->bnq_dt = $bnq_dt;
	}
	function add_liq($new_dat,$new_liq,$new_crr) {
		if(isset($this->dats[strtotime($new_dat).$new_crr])) {$this->liqs[strtotime($new_dat).$new_crr] += $new_liq;}
		else{
			$this->dats[strtotime($new_dat).$new_crr] = $new_dat;
			$this->liqs[strtotime($new_dat).$new_crr] = $new_liq;
			$this->crrs[strtotime($new_dat).$new_crr] = $new_crr;
			$this->lst_liqs[] = strtotime($new_dat).$new_crr;
			sort($this->lst_liqs);
		}
	}
	function get_nom() {return $this->nom;}
	function count_lst_liqs() {return count($this->lst_liqs);}
	function get_lst_liqs($i) {return $this->lst_liqs[$i];}
	function get_dat($i) {return $this->dats[$i];}
	function get_liq($i) {return $this->liqs[$i];}
	function get_crr($i) {return $this->crrs[$i];}
	function get_bnq_id() {return $this->bnq_id;}
	function get_bnq_dt() {return $this->bnq_dt;}
}
function cmp_nom($a, $b) {return strcasecmp($a->nom,$b->nom);}
function cmp_dat($a, $b) {return $a->dats[$a->lst_liqs[0]] > $b->dats[$b->lst_liqs[0]];}
include("../prm/fct.php");
include("../prm/rpl.php");
include("../cfg/bnq.php");
include("../cfg/crr.php");
$rq = sel_whe("dev_srv.id_frn,dev_srv_pay.date,dev_srv_pay.crr,liq,cat_frn.nom,id_bnq,bnq","(((((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN dev_srv_pay ON dev_srv.id = dev_srv_pay.id_srv) INNER JOIN cat_frn ON cat_frn.id = dev_srv.id_frn","cnf>0 AND pay='0'");
while($dt = ftc_ass($rq)) {
	if(!isset($paiements['frn'.$dt['id_frn']]) or !is_object($paiements['frn'.$dt['id_frn']])) {$paiements['frn'.$dt['id_frn']] = new Paiements($dt['nom'],$dt['date'],$dt['liq'],$dt['crr'],$dt['id_bnq'],$dt['bnq']);}
	else{$paiements['frn'.$dt['id_frn']]->add_liq($dt['date'],$dt['liq'],$dt['crr']);}
}
$rq = sel_whe("dev_hbr.id_cat AS id_hbr,dev_hbr_pay.date,dev_hbr_pay.crr,liq,cat_hbr.nom,id_bnq,bnq,id_frn","(((((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN dev_hbr_pay ON dev_hbr.id = dev_hbr_pay.id_hbr) INNER JOIN cat_hbr ON cat_hbr.id = dev_hbr.id_cat","cnf>0 AND pay='0'");
while($dt = ftc_ass($rq)) {
	if($dt['id_frn']==0) {
		if(!isset($paiements['hbr'.$dt['id_hbr']]) or !is_object($paiements['hbr'.$dt['id_hbr']])) {$paiements['hbr'.$dt['id_hbr']] = new Paiements($dt['nom'],$dt['date'],$dt['liq'],$dt['crr'],$dt['id_bnq'],$dt['bnq']);}
		else{$paiements['hbr'.$dt['id_hbr']]->add_liq($dt['date'],$dt['liq'],$dt['crr']);}
	}
	else{
		if(!isset($paiements['frn'.$dt['id_frn']]) or !is_object($paiements['frn'.$dt['id_frn']])) {
			$dt_frn = ftc_ass(sel_quo("nom,bnq,id_bnq","cat_frn","id",$dt['id_frn']));
			$paiements['frn'.$dt['id_frn']] = new Paiements($dt_frn['nom'],$dt['date'],$dt['liq'],$dt['crr'],$dt_frn['id_bnq'],$dt_frn['bnq']);
		}
		else{$paiements['frn'.$dt['id_frn']]->add_liq($dt['date'],$dt['liq'],$dt['crr']);}
	}
}
usort($paiements,'cmp_nom');
usort($paiements,'cmp_dat');




if(isset($paiements)) {
	require_once '../vendor/PHPWord.php';
	$PHPWord = new PHPWord();
	$sectionStyle = array('orientation' => null,'marginLeft' => 1000,'marginRight' => 800,'marginTop' => 700,'marginBottom' => 600);
	$tableStyle = $height = $cellStyle = $dat = $fontStyle = $paragraphStyle = "";
	$section = $PHPWord->createSection($sectionStyle);
	$table = $section->addTable($tableStyle);
	foreach($paiements as $paiement) {
		$table->addRow($height);
		$cell = $table->addCell(2000, $cellStyle);
		$cell->addText(replace($paiement->get_nom()), $fontStyle, $paragraphStyle);
		$cell = $table->addCell(1500, $cellStyle);

		for($i=0; $i<$paiement->count_lst_liqs();$i++) {
			if($paiement->get_dat($paiement->get_lst_liqs($i)) != '0000-00-00') {$cell->addText(date("d/m/Y", strtotime($paiement->get_dat($paiement->get_lst_liqs($i)))), $fontStyle, $paragraphStyle);}
		}
		$cell = $table->addCell(1000, $cellStyle);
		for($i=0; $i<$paiement->count_lst_liqs();$i++) {
			$cell->addText($paiement->get_liq($paiement->get_lst_liqs($i)), $fontStyle, $paragraphStyle);
		}
		$cell = $table->addCell(1000, $cellStyle);
		for($i=0; $i<$paiement->count_lst_liqs();$i++) {
			$cell->addText($prm_crr_nom[$paiement->get_crr($paiement->get_lst_liqs($i))], $fontStyle, $paragraphStyle);
		}
		$cell = $table->addCell(1000, $cellStyle);
		if($paiement->get_bnq_id()>0) {$cell->addText(replace($bnq[$paiement->get_bnq_id()]), $fontStyle, $paragraphStyle);}
		$cell = $table->addCell(5000, $cellStyle);
		$dsc = explode('<br />',stripslashes(replace(nl2br(trim($paiement->get_bnq_dt())))));
		foreach($dsc as $lgn){$cell->addText(trim($lgn), $fontStyle, $paragraphStyle);}
	}
/*
$rq = sel_whe("dev_hbr.id_cat,dev_hbr_pay.date,dev_hbr_pay.crr,liq,cat_hbr.nom,id_bnq,bnq,id_frn","(((((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN dev_hbr_pay ON dev_hbr.id = dev_hbr_pay.id_hbr) INNER JOIN cat_hbr ON cat_hbr.id = dev_hbr.id_cat","cnf>0 AND pay='0'","date,id_bnq DESC");
while($dt = ftc_ass($rq)) {
	$flg_hbr = true;
	if(isset($hbr)) {
		foreach($hbr as $id_hbr) {
			if($id_hbr == $dt['id_cat']) {$flg_hbr = false;}
		}
	}
	if($flg_hbr) {
		$hbr[] = $dt['id_cat'];
		$hbr_nom[] = $dt['nom'];
		if($dt['id_frn']==0) {
			$bnq_hbr = $dt['bnq'];
			$id_bnq_hbr = $dt['id_bnq'];
		}
		else{
			$dt_frn = ftc_ass(sel_quo("bnq,id_bnq","cat_frn","id",$dt['id_frn']));
			$bnq_hbr = $dt_frn['bnq'];
			$id_bnq_hbr = $dt_frn['id_bnq'];
		}
		$hbr_bnq[] = $bnq_hbr;
		$hbr_id_bnq[] = $id_bnq_hbr;
	}
	$hbr_liq_pay[$dt['id_cat']][] = $dt['liq'];
	$hbr_liq_dat[$dt['id_cat']][] = $dt['date'];
	$hbr_liq_crr[$dt['id_cat']][] = $dt['crr'];
}
foreach($hbr as $i => $id_hbr) {
	foreach($hbr_liq_pay[$id_hbr] as $j => $liq) {
		$table->addRow($height);
		$cell = $table->addCell(1500, $cellStyle);
		if($hbr_liq_dat[$id_hbr][$j]!=$dat) {$cell->addText(date("d/m/Y", strtotime($hbr_liq_dat[$id_hbr][$j])), $fontStyle, $paragraphStyle);}
		$dat = $hbr_liq_dat[$id_hbr][$j];
		$cell = $table->addCell(2000, $cellStyle);
		if($j==0) {$cell->addText(replace($hbr_nom[$i]), $fontStyle, $paragraphStyle);}
		$cell = $table->addCell(1000, $cellStyle);
		$cell->addText($liq, $fontStyle, $paragraphStyle);
		$cell = $table->addCell(1000, $cellStyle);
		$cell->addText($prm_crr_nom[$hbr_liq_crr[$id_hbr][$j]], $fontStyle, $paragraphStyle);
		$cell = $table->addCell(1000, $cellStyle);
		if($hbr_id_bnq[$i]>0 and $j==0) {$cell->addText(replace($bnq[$hbr_id_bnq[$i]]), $fontStyle, $paragraphStyle);}
		$cell = $table->addCell(5000, $cellStyle);
		if($j==0) {$cell->addText(replace($hbr_bnq[$i]), $fontStyle, $paragraphStyle);}
	}
	$table->addRow($height);
	$cell = $table->addCell(1500, $cellStyle);
}
$table->addRow($height);
$cell = $table->addCell(1500, $cellStyle);
$table = $section->addTable($tableStyle);
$rq = sel_whe("id_frn,dev_srv_pay.date,dev_srv_pay.crr,liq,cat_frn.nom,id_bnq,bnq","(((((dev_srv INNER JOIN dev_prs ON dev_srv.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) INNER JOIN dev_srv_pay ON dev_srv.id = dev_srv_pay.id_srv) INNER JOIN cat_frn ON cat_frn.id = dev_srv.id_frn","cnf>0 AND pay='0'","date,id_bnq DESC");
while($dt = ftc_ass($rq)) {
	$flg_frn = true;
	if(isset($frn)) {
		foreach($frn as $id_frn) {
			if($id_frn == $dt['id_frn']) {$flg_frn = false;}
		}
	}
	if($flg_frn) {
		$frn[] = $dt['id_frn'];
		$frn_nom[] = $dt['nom'];
		$frn_id_bnq[] = $dt['id_bnq'];
		$frn_bnq[] = $dt['bnq'];
	}
	$frn_liq_pay[$dt['id_frn']][] = $dt['liq'];
	$frn_liq_dat[$dt['id_frn']][] = $dt['date'];
	$frn_liq_crr[$dt['id_frn']][] = $dt['crr'];
}
foreach($frn as $i => $id_frn) {
	foreach($frn_liq_pay[$id_frn] as $j => $liq) {
		$table->addRow($height);
		$cell = $table->addCell(1500, $cellStyle);
		if($frn_liq_dat[$id_frn][$j]!=$dat) {$cell->addText(date("d/m/Y", strtotime($frn_liq_dat[$id_frn][$j])), $fontStyle, $paragraphStyle);}
		$dat = $frn_liq_dat[$id_frn][$j];
		$cell = $table->addCell(2000, $cellStyle);
		if($j==0) {$cell->addText(replace($frn_nom[$i]), $fontStyle, $paragraphStyle);}
		$cell = $table->addCell(1000, $cellStyle);
		$cell->addText($liq, $fontStyle, $paragraphStyle);
		$cell = $table->addCell(1000, $cellStyle);
		$cell->addText($prm_crr_nom[$frn_liq_crr[$id_frn][$j]], $fontStyle, $paragraphStyle);
		$cell = $table->addCell(1000, $cellStyle);
		if($frn_id_bnq[$i]>0 and $j==0) {$cell->addText(replace($bnq[$frn_id_bnq[$i]]), $fontStyle, $paragraphStyle);}
		$cell = $table->addCell(5000, $cellStyle);
		if($j==0) {$cell->addText(replace($frn_bnq[$i]), $fontStyle, $paragraphStyle);}
	}
	$table->addRow($height);
	$cell = $table->addCell(1500, $cellStyle);
}
*/
	$file = "pagos.docx";
	$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
	$objWriter->save("../tmp/".$file);
	if (file_exists("../tmp/".$file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename("../tmp/".$file));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize("../tmp/".$file));
		ob_clean();
		flush();
		readfile("../tmp/".$file);
		exit;
	}
}
?>
