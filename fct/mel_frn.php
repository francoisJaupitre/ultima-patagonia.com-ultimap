<?php
if(isset($_POST['id_dev_crc']) and isset($_POST['id_res_frn'])) {
	$id_res_frn=$_POST['id_res_frn'];
	$id_dev_crc=$_POST['id_dev_crc'];
	$obj='mail';
	include("res_frn.php");
	include("../prm/ctg_res.php");
	include("../prm/usr.php");
	$nb = 0;
	$rsp = '';
	if(isset($lst_dev)) {
		$rsp_srv = '';
		foreach($lst_dev as $id_dev) {
			if(isset($tab_frn[$id_dev])) {
				foreach($tab_frn[$id_dev] as $i => $fr) {
					$dt_cat_frn = ftc_ass(sel_quo("*","cat_frn","id",$fr));
					$nom_frn = $dt_cat_frn['nom'];
					$mel_frn = $dt_cat_frn['mail'];
					$ctc_frn = $dt_cat_frn['contact'];
					$tel_frn = $dt_cat_frn['tel_res'];
					$ctg_res_frn = $dt_cat_frn['ctg_res'];
					if(empty($mel_frn)) {$rsp .= $txt->mel_frn->msg1->$id_lng.$nom_frn.$txt->mel_frn->msg2->$id_lng.".\n";}
					//elseif(!$flg_send[$id_dev][$fr]) {$rsp .= $txt->mel_frn->msg8->$id_lng.$nom_frn.".\n";} A METTRE PONCTUEL DANS RES_FRN//DEPLACER DANS TXT.XML OU EFFACER
					if($flg_send[$id_dev][$fr]) {
						$msg = '<span style="font: 13px, arial, sans-serif;">';
						if($ctg_res_frn != 1) {
							$msg .= $txt->mail->$id_lng.' '.$ctg_res[$id_lng][$ctg_res_frn].': ';
							if($ctg_res_frn == 2) {$msg .= $tel_frn;}
							$msg .= '<br/>';
						}
						if(!empty($ctc_frn)) {$msg .= 'At. '.replace($ctc_frn).'<br/><br/>';}
						if($cnf[$id_dev]==1) {$msg .= 'Estimados,<br/>A continuaci&#243;n, les enviamos nuestro pedido de reserva:<br/><br/>';}
						elseif($cnf[$id_dev]==0) {$msg .= 'Estimados,<br/>A continuaci&#243;n, les enviamos nuestro pedido de bloqueo:<br/><br/>';}
						$msg .= 'Grupo: '.replace($nom_gpe[$id_dev]).' x'.$nbpax[$id_dev][$fr].'<br/>'.replace($nom_frn).'<br/>';
						$msg .= replace($message[$id_dev][$fr]);
						$mespx = array_unique($mes_pxlst[$id_dev][$fr]);
						if(count($mespx)==1) {$msg .= replace($mespx[0]);}
						else{
							foreach($mespx as $mesp) {$msg .= replace($mesp).'<br/>';}
						}
						$msg .= '<br/>Saludos y gracias de antemano.</span>';
						if($cnf[$id_dev]==1) {$subj = utf8_encode('Nueva reserva: '.replace($nom_gpe[$id_dev])." x".$nbpax[$id_dev][$fr].' / '.replace($nom_frn));}
						elseif($cnf[$id_dev]==0) {$subj = utf8_encode('Nuevo bloqueo: '.replace($nom_gpe[$id_dev]).' x'.$nbpax[$id_dev][$fr].' / '.replace($nom_frn));}
						$from = $mel_usr;
						$act = 'nv';
						$melto = $mel_frn;
						$ccrt = 'reservas@ultima-patagonia.com';
						include("eml.php");
						$rsp_srv .= '||'.$file.'|'.$subj.'.eml';
						$rsp .= $txt->mel_frn->msg3->$id_lng.$nom_frn.$txt->mel_frn->msg4->$id_lng;
						$nb++;
						foreach($lst_srv[$id_dev][$fr] as $id_srv) {
							upd_quo("dev_srv",array("res","dt_res"),array("1",date("Y-m-d")),$id_srv);
							$rsp_srv .= '|'.$id_srv;
						}
						$rq_res = sel_quo("id","grp_res",array("id_grp","id_frn"),array($id_grp[$id_dev],$fr));
						if(num_rows($rq_res)==0) {insert("grp_res",array("id_grp","id_frn"),array($id_grp[$id_dev],$fr));}
					}
				}
				$rsp .= $txt->mel_frn->msg5->$id_lng.$nb.$txt->mel_frn->msg6->$id_lng;
			//	echo $rsp.$rsp_srv;
			}
			elseif(empty($rsp)) {$rsp = $txt->mel_frn->msg7->$id_lng;}
			//else{echo $rsp;}
		}
		echo $rsp.$rsp_srv;
	}
}
?>
