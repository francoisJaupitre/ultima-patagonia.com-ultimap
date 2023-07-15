<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_dev_crc']) and isset($data['id_res_hbr']) and isset($data['id_res_chm'])) {
	$id_dev_crc = $data['id_dev_crc'];
	$id_res_hbr = $data['id_res_hbr'];
	$id_res_chm = $data['id_res_chm'];
	$obj = 'mail';
	include("resHbr.php");
	include("../../prm/ctg_res.php");
	include("../../prm/usr.php");
	$nb = 0;
	$rsp = '';
	if(isset($lst_dev)) {
		$rsp_hbr = '';
		foreach($lst_dev as $id_dev) {
			if(isset($tab_hbr[$id_dev])) {
				foreach($tab_hbr[$id_dev] as $i => $hb) {
					$dt_cat_hbr = ftc_ass(sel_quo("*","cat_hbr","id",$hb));
					$nom_hbr = $dt_cat_hbr['nom'];
					if($dt_cat_hbr['id_frn'] == 0) {
						$mel_hbr = $dt_cat_hbr['mail'];
						$ctc_hbr = $dt_cat_hbr['contact'];
						$tel_hbr = $dt_cat_hbr['tel_res'];
						$ctg_res_hbr = $dt_cat_hbr['ctg_res'];
					}
					else{
						$dt_frn = ftc_ass(sel_quo("*","cat_frn","id",$dt_cat_hbr['id_frn']));
						$mel_hbr = $dt_frn['mail'];
						$ctc_hbr = $dt_frn['contact'];
						$tel_hbr = $dt_frn['tel'];
						$ctg_res_hbr = $dt_frn['ctg_res'];
					}
					if(empty($mel_hbr)) { $rsp .= $txt->mel_hbr->msg1->$id_lng.$nom_hbr.$txt->mel_hbr->msg2->$id_lng; }
					if($flg_send[$id_dev][$hb]) {
						$msg = '';
						if($ctg_res_hbr != 1) {
							$msg .= $txt->mail->$id_lng.' '.$ctg_res[$id_lng][$ctg_res_hbr].': ';
							if($ctg_res_hbr == 2) {$msg .= $tel_hbr;}
							$msg .= '<br/>';
						}
						if(!empty($ctc_hbr)) {$msg .= 'At. '.replace($ctc_hbr).'<br/><br/>';}
						if($cnf[$id_dev]==1) {$msg .= 'Estimados,<br/>A continuaci&#243;n, les enviamos nuestro pedido de reserva:<br/><br/>';}
						elseif($cnf[$id_dev]==0) {$msg .= 'Estimados,<br/>A continuaci&#243;n, les enviamos nuestro pedido de bloqueo:<br/><br/>';}
						unset($nbp,$npax);
						foreach($tab_rgm[$id_dev][$hb] as $r => $rg) {
							foreach($tab_chm[$id_dev][$hb][$rg] as $j => $ch) {
								$dt_mdl = ftc_ass(sel_quo("trf","dev_mdl","id",$tab_mdl[$id_dev][$hb][$rg][$j]));
								if($tab_rmn_pax[$id_dev][$hb][$rg][$j]) {$id_rmn = $tab_rmn_pax[$id_dev][$hb][$rg][$j]; }
								else {
									if($dt_mdl['trf']) {$dt_rmn = ftc_ass(sel_quo("id","dev_mdl_rmn",array("nr","id_mdl"),array("1",$tab_mdl[$id_dev][$hb][$rg][$j]))); }
									else { $dt_rmn = ftc_ass(sel_quo("id","dev_crc_rmn",array("nr","id_crc"),array("1",$id_dev))); }
									$id_rmn = $dt_rmn['id'];
								}
								if($id_rmn >0) {
									if($dt_mdl['trf']) { $rq_rmn_pax = sel_quo("*","dev_mdl_rmn_pax","id_rmn",$id_rmn,"room,nc"); }
									else { $rq_rmn_pax = sel_quo("*","dev_crc_rmn_pax","id_rmn",$id_rmn,"room,nc"); }
									if(num_rows($rq_rmn_pax) > 0) { $nbp[] = num_rows($rq_rmn_pax); }
									else { $nbp[] = -1; }
								}
								else { $nbp[] = 0; }
							}
						}
						if(in_array(-1,$nbp)) { $groupe = replace($nom_gpe[$id_dev]); }
						else {
							$nbp = array_unique($nbp);
							foreach($nbp as $np) {
								if(isset($npax)) { $npax .= $np.'/'; }
								else { $npax = $np.'/'; }
							}
							$npax = substr($npax, 0, -1);
							if($npax == 0) {
								unset($nbp,$npax);
								foreach($tab_rgm[$id_dev][$hb] as $r => $rg) {
									foreach($tab_chm[$id_dev][$hb][$rg] as $j => $ch) {$nbp[] = $tab_nb_pax_hb[$id_dev][$hb][$rg][$j];}
								}
								$nbp = array_unique($nbp);
								foreach($nbp as $np) { $npax .= $np.'/'; }
								$npax = substr($npax, 0, -1);
							}
							$groupe = replace($nom_gpe[$id_dev]).' x'.$npax;
						}
						$msg .= 'Grupo: '.$groupe.'<br/>'.replace($nom_hbr).'<br/>';
						foreach($tab_rgm[$id_dev][$hb] as $r => $rg) {
							foreach($tab_chm[$id_dev][$hb][$rg] as $j => $ch) {
								if(!isset($ms) or $message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]] != $ms) {
									$ms = $message[$id_dev][$hb][$rg][$ch][$tab_rmn_pax[$id_dev][$hb][$rg][$j]];
								 	$msg .= replace($ms);
								}
								$msg .= '<br/>'.replace($mes_rmlst[$id_dev][$hb][$rg][$j]);
							}
						}
						if($cnf[$id_dev]>0) { $subj = utf8_encode('Nueva reserva: '.$groupe.' / '.replace($nom_hbr)); }
						elseif($cnf[$id_dev]<1) { $subj = utf8_encode('Nuevo bloqueo: '.$groupe.' / '.replace($nom_hbr)); }
						if(count($tab_hbr[$id_dev]) > 1) {
							$from = $mel_usr;
							$act = 'nv';
							$melto = $mel_hbr;
							$ccrt = 'reservas@ultima-patagonia.com';
							include("eml.php");
							$rsp_hbr .= '||'.$file.'|'.$subj.'.eml';
							$rsp .= $txt->mel_hbr->msg3->$id_lng.$nom_hbr.$txt->mel_hbr->msg4->$id_lng;
							$nb++;
							foreach($lst_hbr[$id_dev][$hb] as $id_srv) {
								upd_quo("dev_hbr",array("res","dt_res"),array("1",date("Y-m-d")),$id_srv);
								$rsp_hbr .= '|'.$id_srv;
							}
							$rq_res = sel_quo("id","grp_res",array("id_grp","id_hbr"),array($id_grp[$id_dev],$hb));
							if(num_rows($rq_res) == 0) { insert("grp_res",array("id_grp","id_hbr"),array($id_grp[$id_dev],$hb)); }
						}
						else {
							$msg .= utf8_decode("
							<p>
								<div>Saludos y gracias de antemano.</div>
								<br/>
								<div>François Jaupitre</div>
								<div style='color: #808080'>
									<div>WhatsApp: <a target='_blank' href='https://api.whatsapp.com/send?phone=5492944342815'>+54 9 294 434 28 15</a></div>
									<div>Skype: <a target='_blank' href='skype:ultimapatagonia?chat'>ultimapatagonia</a></div>
									<div><a target='_blank' href='https://www.ultima-patagonia.com/'>www.ultima-patagonia.com</a></div>
									<div>Empresa de Viajes y Turismo - Legajo: 18395</div>
								</div>
							</p>
							");
							$qa = array('emailFrom' => $mel_usr, 'emailTo' => $mel_hbr, 'emailSubject' => $subj, 'emailBody' => htmlspecialchars( utf8_encode($msg)),'emailLstHBR' => implode("|",$lst_hbr[$id_dev][$hb]),'emailHBR' => $hb, 'emailGRP' => $id_grp[$id_dev]);
							echo json_encode($qa);
							return;
						}
					}
				}
				$rsp .= $txt->mel_hbr->msg5->$id_lng.$nb.$txt->mel_hbr->msg6->$id_lng;
			}
			elseif(empty($rsp)) { $rsp = $txt->mel_hbr->msg7->$id_lng; }
		}
		echo json_encode($rsp.$rsp_hbr);
	}
}
?>
