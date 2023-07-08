<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_crc'])) {
	include("../../prm/fct.php");
	include("../../prm/aut.php");
	$id_crc = $data['id_crc'];
	$dt_crc = ftc_ass(sel_quo("*","dev_crc","id",$id_crc));
	unset($dt_crc['id']);
	$dt_vrs = ftc_ass(sel_quo("MAX(version) as vrs","dev_crc","id_grp",$dt_crc['id_grp']));
	$dt_vrs['vrs']++;
	$dt_crc['version'] = $dt_vrs['vrs'];
	$dt_crc['dt_dev'] = date("Y-m-d");
	$dt_crc['usr'] = $id_usr;
	$dt_crc['cnf'] = 0;
	$id_crc_new = insert("dev_crc",array_keys($dt_crc),array_values($dt_crc));
	$rq_bss = sel_quo("*","dev_crc_bss","id_crc",$id_crc);
	while($dt_bss = ftc_ass($rq_bss)){
		unset($dt_bss['id']);
		$dt_bss['id_crc'] = $id_crc_new;
		insert("dev_crc_bss",array_keys($dt_bss),array_values($dt_bss));
	}
	$rq_vol = sel_quo("*","dev_vol","id_crc",$id_crc);
	while($dt_vol = ftc_ass($rq_vol)){
		unset($dt_vol['id']);
		$dt_vol['id_crc'] = $id_crc_new;
		insert("dev_vol",array_keys($dt_vol),array_values($dt_vol));
	}
	$rq_pax = sel_quo("*","dev_crc_pax","id_crc",$id_crc);
	while($dt_pax = ftc_ass($rq_pax)){
		unset($dt_pax['id']);
		$dt_pax['id_crc'] = $id_crc_new;
		insert("dev_crc_pax",array_keys($dt_pax),array_values($dt_pax));
	}
	$rq_rmn = sel_quo("*","dev_crc_rmn","id_crc",$id_crc);
	while($dt_rmn = ftc_ass($rq_rmn)){
		$id_rmn = $dt_rmn['id'];
		unset($dt_rmn['id']);
		$dt_rmn['id_crc'] = $id_crc_new;
		$id_rmn_new = insert("dev_crc_rmn",array_keys($dt_rmn),array_values($dt_rmn));
		$lst_rmn_crc[$id_rmn] = $id_rmn_new;
		$rq_rmn_pax = sel_quo("*","dev_crc_rmn_pax","id_rmn",$id_rmn);
		while($dt_rmn_pax = ftc_ass($rq_rmn_pax)){
			unset($dt_rmn_pax['id']);
			$dt_rmn_pax['id_rmn'] = $id_rmn_new;
			insert("dev_crc_rmn_pax",array_keys($dt_rmn_pax),array_values($dt_rmn_pax));
		}
	}
	$rq_mdl = sel_quo("*","dev_mdl","id_crc",$id_crc);
	while($dt_mdl = ftc_ass($rq_mdl)){
		$id_mdl = $dt_mdl['id'];
		unset($dt_mdl['id']);
		$dt_mdl['id_crc'] = $id_crc_new;
		$id_mdl_new = insert("dev_mdl",array_keys($dt_mdl),array_values($dt_mdl));
		$rq_bss = sel_quo("*","dev_mdl_bss","id_mdl",$id_mdl);
		while($dt_bss = ftc_ass($rq_bss)){
			unset($dt_bss['id']);
			$dt_bss['id_mdl'] = $id_mdl_new;
			insert("dev_mdl_bss",array_keys($dt_bss),array_values($dt_bss));
		}
		$rq_pax = sel_quo("*","dev_mdl_pax","id_mdl",$id_mdl);
		while($dt_pax = ftc_ass($rq_pax)){
			unset($dt_pax['id']);
			$dt_pax['id_mdl'] = $id_mdl_new;
			insert("dev_mdl_pax",array_keys($dt_pax),array_values($dt_pax));
		}
		$rq_rmn = sel_quo("*","dev_mdl_rmn","id_mdl",$id_mdl);
		while($dt_rmn = ftc_ass($rq_rmn)){
			$id_rmn = $dt_rmn['id'];
			unset($dt_rmn['id']);
			$dt_rmn['id_mdl'] = $id_mdl_new;
			$id_rmn_new = insert("dev_mdl_rmn",array_keys($dt_rmn),array_values($dt_rmn));
			$lst_rmn_mdl[$id_rmn] = $id_rmn_new;
			$rq_rmn_pax = sel_quo("*","dev_mdl_rmn_pax","id_rmn",$id_rmn);
			while($dt_rmn_pax = ftc_ass($rq_rmn_pax)){
				unset($dt_rmn_pax['id']);
				$dt_rmn_pax['id_rmn'] = $id_rmn_new;
				insert("dev_mdl_rmn_pax",array_keys($dt_rmn_pax),array_values($dt_rmn_pax));
			}
		}
		$rq_jrn = sel_quo("*","dev_jrn","id_mdl",$id_mdl);
		while($dt_jrn = ftc_ass($rq_jrn)){
			$id_jrn = $dt_jrn['id'];
			unset($dt_jrn['id']);
			$dt_jrn['id_mdl'] = $id_mdl_new;
			$id_jrn_new = insert("dev_jrn",array_keys($dt_jrn),array_values($dt_jrn));
			$rq_prs = sel_quo("*","dev_prs","id_jrn",$id_jrn);
			while($dt_prs = ftc_ass($rq_prs)){
				$id_prs = $dt_prs['id'];
				unset($dt_prs['id']);
				if(is_null($dt_prs['heure'])){unset($dt_prs['heure']);}
				$dt_prs['id_jrn'] = $id_jrn_new;
				if($dt_mdl['trf']==1 and $dt_prs['id_rmn']!=0){$id_rmn_new = $lst_rmn_mdl[$dt_prs['id_rmn']];}
				elseif($dt_mdl['trf']==0 and $dt_prs['id_rmn']!=0){$id_rmn_new = $lst_rmn_crc[$dt_prs['id_rmn']];}
				else{$id_rmn_new = 0;}
				$dt_prs['id_rmn'] = $id_rmn_new;
				$id_prs_new = insert("dev_prs",array_keys($dt_prs),array_values($dt_prs));
				$rq_hbr = sel_quo("*","dev_hbr","id_prs",$id_prs);
				while($dt_hbr = ftc_ass($rq_hbr)){
					$id_hbr = $dt_hbr['id'];
					unset($dt_hbr['id']);
					$dt_hbr['id_prs'] = $id_prs_new;
					$id_hbr_new = insert("dev_hbr",array_keys($dt_hbr),array_values($dt_hbr));
					$rq_hbr_pay = sel_quo("*","dev_hbr_pay","id_hbr",$id_hbr);
					while($dt_hbr_pay = ftc_ass($rq_hbr_pay)){
						unset($dt_hbr_pay['id']);
						$dt_hbr_pay['id_hbr'] = $id_hbr_new;
						insert("dev_hbr_pay",array_keys($dt_hbr_pay),array_values($dt_hbr_pay));
					}
				}
				$rq_srv = sel_quo("*","dev_srv","id_prs",$id_prs);
				while($dt_srv = ftc_ass($rq_srv)){
					$id_srv = $dt_srv['id'];
					unset($dt_srv['id']);
					$dt_srv['id_prs'] = $id_prs_new;
					$id_srv_new = insert("dev_srv",array_keys($dt_srv),array_values($dt_srv));
					$rq_srv_pay = sel_quo("*","dev_srv_pay","id_srv",$id_srv);
					while($dt_srv_pay = ftc_ass($rq_srv_pay)){
						unset($dt_srv_pay['id']);
						$dt_srv_pay['id_srv'] = $id_srv_new;
						insert("dev_srv_pay",array_keys($dt_srv_pay),array_values($dt_srv_pay));
					}
					$rq_srv_trf = sel_quo("*","dev_srv_trf","id_srv",$id_srv);
					while($dt_srv_trf = ftc_ass($rq_srv_trf)){
						unset($dt_srv_trf['id']);
						$dt_srv_trf['id_srv'] = $id_srv_new;
						insert("dev_srv_trf",array_keys($dt_srv_trf),array_values($dt_srv_trf));
					}
				}
			}
		}
	}
	//echo $id_crc_new;
	echo json_encode($id_crc_new);
}
?>
