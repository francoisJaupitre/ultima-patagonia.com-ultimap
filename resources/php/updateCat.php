<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data["tab"]) and isset($data["col"]) and isset($data["val"]) and isset($data["id"]))
{
	$tab = $data["tab"];
	$col = $data["col"];
	$val = $data["val"];
	$id = $data["id"];
	include("../../prm/fct.php");
	include("../../prm/aut.php");
	include("../../prm/lgg.php");
	$txt = simplexml_load_file('../../cat/txt.xml');
	$car = substr(trim($val),0,1);
	$not_col = array('nom', 'titre', 'jours', 'date', 'dt_min', 'dt_max', 'tel', 'tel_hbr',' tel_res', 'info', 'notes', 'dsc', 'alerte', 'lon', 'lat', 'sel_mdl_jrn', 'adresse');
	if((is_numeric($car) or $car == '(' or $car == ')' or $car == '=' or $car == '+' or $car == '-') and !in_array($col, $not_col))
	{
		$val = preg_replace('/\s+/', '', $val);
		$len = strlen($val);
		$val = str_replace('=', '+', $val);
		$flg = true;
		for($i=0; $i < $len; $i++)
		{
			$car = substr($val, $i, 1);
			if(!(is_numeric($car) or $car == '(' or $car == ')' or $car == '+' or $car == '-' or $car == '*' or $car == '/' or $car == '.' or $car == ','))
			{
				$flg = false;
				break;
			}
		}
		if($flg)
		{
			$code = '$val='.str_replace(',','.',$val).';';
			if(@eval('return true;' . $code))
			{
				eval($code);
			}else{
				echo $txt->errval->$id_lng;
				return;
			}
			if($col == 'frs' || $col =='taux')
			{
				$val /= 100;
			}else{
				$val = round($val,2);
			}
		}
	}
	if($col == "ord")
	{
		$flg_col = true;
		if($val>0)
		{
			if($tab=="cat_crc_mdl")
			{
				$id_crc = $data["id_sup"];
				$dt = ftc_ass(select("ord","cat_crc_mdl","id",$id));
				$ord_init = $dt['ord'];
				$max = ftc_num(select("MAX(ord)","cat_crc_mdl","id_crc",$id_crc));
				if($val > $max[0])
				{
					$flg_col = false;
				}else{
					$rq_crc_mdl = select("id,ord","cat_crc_mdl","id_crc",$id_crc);
					while($dt_crc_mdl = ftc_ass($rq_crc_mdl))
					{
						if($dt_crc_mdl['ord'] > $ord_init and $dt_crc_mdl['ord'] <= $val)
						{
							upd_noq("cat_crc_mdl","ord","ord-1",$dt_crc_mdl['id']);
						}elseif($dt_crc_mdl['ord'] < $ord_init and $dt_crc_mdl['ord'] >= $val)
						{
							upd_noq("cat_crc_mdl","ord","ord+1",$dt_crc_mdl['id']);
						}
					}
				}
			}elseif($tab=="cat_mdl_jrn")
			{
				$id_mdl = $data["id_sup"];
				$dt = ftc_ass(select("ord","cat_mdl_jrn","id",$id));
				$ord_init = $dt['ord'];
				$max = ftc_num(select("MAX(ord)","cat_mdl_jrn","id_mdl",$id_mdl));
				if($val>$max[0])
				{
					$flg_col = false;
				}else{
					$rq_mdl_jrn = select("id,ord","cat_mdl_jrn","id_mdl",$id_mdl);
					while($dt_mdl_jrn = ftc_ass($rq_mdl_jrn))
					{
						if($dt_mdl_jrn['ord'] > $ord_init and $dt_mdl_jrn['ord'] <= $val)
						{
							upd_noq("cat_mdl_jrn","ord","ord-1",$dt_mdl_jrn['id']);
						}elseif($dt_mdl_jrn['ord'] < $ord_init and $dt_mdl_jrn['ord'] >= $val)
						{
							upd_noq("cat_mdl_jrn","ord","ord+1",$dt_mdl_jrn['id']);
						}
					}
				}
			}elseif($tab=="cat_jrn_prs")
			{
				$id_jrn = $data["id_sup"];
				$dt = ftc_ass(select("ord","cat_jrn_prs","id",$id));
				$ord_init = $dt['ord'];
				$max = ftc_num(select("MAX(ord)","cat_jrn_prs","id_jrn",$id_jrn));
				if($val>$max[0])
				{
					$flg_col = false;
				}else{
					$rq_jrn_prs = select("id,ord","cat_jrn_prs","id_jrn",$id_jrn);
					while($dt_jrn_prs = ftc_ass($rq_jrn_prs))
					{
						if($dt_jrn_prs['ord'] > $ord_init and $dt_jrn_prs['ord'] <= $val)
						{
							upd_noq("cat_jrn_prs","ord","ord-1",$dt_jrn_prs['id']);
						}elseif($dt_jrn_prs['ord'] < $ord_init and $dt_jrn_prs['ord'] >= $val)
						{
							upd_noq("cat_jrn_prs","ord","ord+1",$dt_jrn_prs['id']);
						}elseif($dt_jrn_prs['ord'] == $ord_init and $dt_jrn_prs['id']!= $id)
						{
							upd_quo("cat_jrn_prs","ord",$val,$dt_jrn_prs['id']);
						}
					}
				}
			}elseif($tab=="cat_jrn_vll")
			{
				$id_jrn = $data["id_sup"];
				$dt = ftc_ass(select("ord","cat_jrn_vll","id",$id));
				$ord_init = $dt['ord'];
				$max = ftc_num(select("MAX(ord)","cat_jrn_vll","id_jrn",$id_jrn));
				if($val>$max[0])
				{
					$flg_col = false;
				}else{
					$rq_jrn_vll = select("id,ord","cat_jrn_vll","id_jrn",$id_jrn);
					while($dt_jrn_vll = ftc_ass($rq_jrn_vll))
					{
						if($dt_jrn_vll['ord'] > $ord_init and $dt_jrn_vll['ord'] <= $val)
						{
							upd_noq("cat_jrn_vll","ord","ord-1",$dt_jrn_vll['id']);
						}elseif($dt_jrn_vll['ord'] < $ord_init and $dt_jrn_vll['ord'] >= $val)
						{
							upd_noq("cat_jrn_vll","ord","ord+1",$dt_jrn_vll['id']);
						}
					}
				}
			}elseif($tab=="cat_jrn_lieu")
			{
				$id_jrn = $data["id_sup"];
				$dt = ftc_ass(select("ord","cat_jrn_lieu","id",$id));
				$ord_init = $dt['ord'];
				$max = ftc_num(select("MAX(ord)","cat_jrn_lieu","id_jrn",$id_jrn));
				if($val>$max[0])
				{
					$flg_col = false;
				}else{
					$rq_jrn_lieu = select("id,ord","cat_jrn_lieu","id_jrn",$id_jrn);
					while($dt_jrn_lieu = ftc_ass($rq_jrn_lieu))
					{
						if($dt_jrn_lieu['ord'] > $ord_init and $dt_jrn_lieu['ord'] <= $val)
						{
							upd_noq("cat_jrn_lieu","ord","ord-1",$dt_jrn_lieu['id']);
						}elseif($dt_jrn_lieu['ord'] < $ord_init and $dt_jrn_lieu['ord'] >= $val)
						{
							upd_noq("cat_jrn_lieu","ord","ord+1",$dt_jrn_lieu['id']);
						}
					}
				}
			}elseif($tab=="cat_prs_lieu")
			{
				$id_prs = $data["id_sup"];
				$dt = ftc_ass(select("ord","cat_prs_lieu","id",$id));
				$ord_init = $dt['ord'];
				$max = ftc_num(select("MAX(ord)","cat_prs_lieu","id_prs",$id_prs));
				if($val>$max[0])
				{
					$flg_col = false;
				}else{
					$rq_prs_lieu = select("id,ord","cat_prs_lieu","id_prs",$id_prs);
					while($dt_prs_lieu = ftc_ass($rq_prs_lieu))
					{
						if($dt_prs_lieu['ord'] > $ord_init and $dt_prs_lieu['ord'] <= $val)
						{
							upd_noq("cat_prs_lieu","ord","ord-1",$dt_prs_lieu['id']);
						}elseif($dt_prs_lieu['ord'] < $ord_init and $dt_prs_lieu['ord'] >= $val)
						{
							upd_noq("cat_prs_lieu","ord","ord+1",$dt_prs_lieu['id']);
						}
					}
				}
			}
		}else{
			$flg_col = false;
		}
		if(!$flg_col)
		{
			echo $txt->errval->$id_lng;
			return ;
		}
	}elseif($col=="dt_min" || $col=="dt_max")
	{
		if($val!='')
		{
			$dt = explode('/',$val);
			if(!isset($dt[2]))
			{
				$flg_y = true;
				if(strtotime(date("Y").'-'.$dt[1].'-'.$dt[0])>=strtotime(date("Y-m-d")) or $col=="dt_min")
				{
					$y=date("Y");
				}else{
					$y=date("Y")+1;
				}
			}else{
				$y=$dt[2];
			}
			$val = $y.'-'.$dt[1].'-'.$dt[0];
		}else{
			$val='0000-00-00';
		}
	}elseif($col=="jours" and !$val>0)
	{
		echo $txt->errval->$id_lng;
		return ;
	}elseif($col=='pay' and $val=='1')
	{
		include("../cfg/crr.php");
		if($tab=='dev_srv_pay')
		{
			$dt_pay = ftc_ass(select("crr","dev_srv_pay","id",$id));
			upd_quo("dev_srv_pay",array("taux","sup"),array($cfg_crr_txf[$dt_pay['crr']],$cfg_crr_sp[$dt_pay['crr']]),$id);
		}elseif($tab=='dev_hbr_pay')
		{
			$dt_pay = ftc_ass(select("crr","dev_hbr_pay","id",$id));
			upd_quo("dev_hbr_pay",array("taux","sup"),array($cfg_crr_txf[$dt_pay['crr']],$cfg_crr_sp[$dt_pay['crr']]),$id);
		}
	}elseif($col=='dsc')
	{
		$val = str_replace('U+','\u',$val);//emoji premier systeme avec \u dans ultimap
		$val = str_replace('"',"'",$val);
	}elseif($col=='web_uid')
	{
		$dt_web = ftc_ass(select('id',$tab,$col,$val));
		if($dt_web['id']>0)
		{
			echo $txt->errwebuid->$id_lng;
			return;
		}
	}
	if($tab=='cat_mdl_jrn' and $col=='opt')
	{
		$dt_ord_jrn = ftc_ass(select('ord','cat_mdl_jrn','id',$id));
		$dt_jrn = ftc_ass(select('id','cat_mdl_jrn','id_mdl = '.$data["id_sup"].' and opt = 1 and ord',$dt_ord_jrn['ord']));
		upd_quo('cat_mdl_jrn','opt','0',$dt_jrn['id']);
	}elseif($tab=='cat_jrn_prs' and $col=='opt')
	{
		$dt_ord_prs = ftc_ass(select('ord','cat_jrn_prs','id',$id));
		$dt_prs = ftc_ass(select('id','cat_jrn_prs','id_jrn = '.$data["id_sup"].' and opt = 1 and ord',$dt_ord_prs['ord']));
		upd_quo('cat_jrn_prs','opt','0',$dt_prs['id']);
	}elseif($tab=='cat_prs_hbr' and $col=='opt')
	{
		$dt_hbr = ftc_ass(select('id','cat_prs_hbr','opt = 1 and id_prs',$data["id_sup"]));
		upd_quo('cat_prs_hbr','opt','0',$dt_hbr['id']);
	}elseif($tab=='cat_srv')
	{
		if($col=='id_vll')
		{
			$rq_srv_trf = select("cat_srv_trf_bss.id,id_frn","cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf","id_srv",$id);
			while($dt_srv_trf = ftc_ass($rq_srv_trf))
			{
				if($dt_srv_trf['id_frn']!=0)
				{
					$flg_frn_vll = true;
					$rq_frn_vll = select("id_vll","cat_frn_vll","id_frn",$dt_srv_trf['id_frn']);
					while($dt_frn_vll = ftc_ass($rq_frn_vll))
					{
						if($dt_frn_vll['id_vll']==$val) {
							$flg_frn_vll = false;
						}
					}
					if($flg_frn_vll) {
						upd_quo("cat_srv_trf_bss","id_frn","NULL",$dt_srv_trf['id']);
					}
				}
			}
		}
		if($col=='ctg')
		{
			$rq_srv_trf = select("cat_srv_trf_bss.id,id_frn","cat_srv_trf INNER JOIN cat_srv_trf_bss ON cat_srv_trf.id = cat_srv_trf_bss.id_trf","id_srv",$id);
			while($dt_srv_trf = ftc_ass($rq_srv_trf))
			{
				if($dt_srv_trf['id_frn']!=0)
				{
					$flg_frn_ctg_srv = true;
					$rq_frn_ctg_srv = select("ctg_srv","cat_frn_ctg_srv","id_frn",$dt_srv_trf['id_frn']);
					while($dt_frn_ctg_srv = ftc_ass($rq_frn_ctg_srv))
					{
						if($dt_frn_ctg_srv['ctg_srv']==$val)
						{
							$flg_frn_ctg_srv = false;
						}
					}
					if($flg_frn_ctg_srv)
					{
						upd_quo("cat_srv_trf_bss","id_frn","NULL",$dt_srv_trf['id']);
					}
				}
			}
		}
	}elseif($tab=='cat_srv_trf' and $col=='def')
	{
		$dt_srv = ftc_ass(select('id_srv','cat_srv_trf','id',$id));
		$rq_trf = select('id','cat_srv_trf','id_srv',$dt_srv['id_srv']);
		while($dt_trf = ftc_ass($rq_trf))
		{
			if($id != $dt_trf['id'])
			{
				upd_quo('cat_srv_trf','def','0',$dt_trf['id']);
			}
		}
	}elseif($tab=='cat_srv_trf_bss' and ($col=='bs_min' or $col=='bs_max'))
	{
		$id_trf = $data["id_sup"];
		$dt_trf = ftc_ass(select('bs_min,bs_max','cat_srv_trf_bss','id',$id));
		if(($col=='bs_max' and $dt_trf['bs_min'] > $val and $val !='0') or ($col=='bs_min' and $dt_trf['bs_max'] < $val and $dt_trf['bs_max'] != '0' and $val !='0'))
		{
			echo $txt->errbss->$id_lng;
			return;
		}
		$rq_bss = select('id,bs_min,bs_max','cat_srv_trf_bss','id!='.$id.' AND id_trf',$id_trf);
		while($dt_bss = ftc_ass($rq_bss))
		{
			if($val >= $dt_bss['bs_min'] and $dt_bss['bs_min']!=0 and $val <= $dt_bss['bs_max'] and $dt_bss['bs_max']!=0 and $val != 0)
			{
				echo $txt->errbss2->$id_lng;
				return;
			}elseif($col=='bs_max' and $dt_trf['bs_min']!='0' and $dt_trf['bs_min'] < $dt_bss['bs_max'] and $val > $dt_bss['bs_min'] and $val != 0)
			{
				echo $txt->errbss3->$id_lng;
				return;
			}/*elseif($col=='bs_min' and $dt_trf['bs_max']!='0' and $dt_trf['bs_max'] > $dt_bss['bs_min'] and $val < $dt_bss['bs_max'])
			{
				upd_quo('cat_srv_trf_bss','bs_max',$val,$id);
			}*/
		}
	}elseif($tab=='cat_srv_trf_ssn' and ($col=="dt_min" || $col=="dt_max"))
	{
		$dt_srv = ftc_ass(select('id_srv,dt_min,dt_max','cat_srv_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf','cat_srv_trf_ssn.id',$id));
		if(($col=='dt_max' and strtotime($dt_srv['dt_min']) > strtotime($val) and $val !='0000-00-00' and !$flg_y) or ($col=='dt_min' and strtotime($dt_srv['dt_max']) < strtotime($val) and $dt_srv['dt_max'] != '0000-00-00'))
		{
			echo $txt->errdat->$id_lng;
			return;
		}elseif($col=='dt_max' and strtotime($dt_srv['dt_min']) > strtotime($val) and $flg_y)
		{
			$dt = explode('-',$val);
			$y=$dt[0]+1;
			$val = $y.'-'.$dt[1].'-'.$dt[2];
		}
		$rq_trf = select('cat_srv_trf_ssn.id,cat_srv_trf_ssn.dt_min,cat_srv_trf_ssn.dt_max','cat_srv_trf INNER JOIN cat_srv_trf_ssn ON cat_srv_trf.id = cat_srv_trf_ssn.id_trf','cat_srv_trf_ssn.id!='.$id.' AND id_srv',$dt_srv['id_srv']);
		while($dt_trf = ftc_ass($rq_trf))
		{
			if(strtotime($val) >= strtotime($dt_trf['dt_min']) and strtotime($val) <= strtotime($dt_trf['dt_max']))
			{
				echo $txt->errdat2->$id_lng;
				return;
			}elseif(($col=='dt_max' and $dt_srv['dt_min']!='0000-00-00' and strtotime($dt_srv['dt_min']) < strtotime($dt_trf['dt_max']) and strtotime($val) > strtotime($dt_trf['dt_min'])) or ($col=='dt_min' and $dt_srv['dt_max']!='0000-00-00' and strtotime($dt_srv['dt_max']) > strtotime($dt_trf['dt_min']) and strtotime($val) < strtotime($dt_trf['dt_max'])))
			{
				echo $txt->errdat3->$id_lng;
				return;
			}
		}
	}elseif($tab=='cat_hbr')
	{
		if($col=='id_vll')
		{
			delete('cat_vll_hbr',"id_hbr",$id);
			if($val > 0)
			{
				$msg = $txt->act_map_vll->$id_lng;
			}
		}elseif($col=='adresse' and $val != '')
		{
			$msg = $txt->act_map->$id_lng;
		}
	}elseif($tab=='cat_hbr_chm' and $col=='rgm')
	{
		delete('cat_vll_hbr',"id_chm",$data["id_sup"]);
	}elseif($tab=='cat_hbr_chm_trf' and $col=='def')
	{
		$dt_chm = ftc_ass(select('id_chm','cat_hbr_chm_trf','id',$id));
		$rq_trf = select('id','cat_hbr_chm_trf','id_chm',$dt_chm['id_chm']);
		while($dt_trf = ftc_ass($rq_trf))
		{
			if($id != $dt_trf['id'])
			{
				upd_quo('cat_hbr_chm_trf','def','0',$dt_trf['id']);
			}
		}
	}elseif($tab=='cat_hbr_chm_trf_ssn' and ($col=="dt_min" || $col=="dt_max"))
	{
		$dt_chm = ftc_ass(select('id_chm,dt_min,dt_max','cat_hbr_chm_trf INNER JOIN cat_hbr_chm_trf_ssn ON cat_hbr_chm_trf.id = cat_hbr_chm_trf_ssn.id_trf','cat_hbr_chm_trf_ssn.id',$id));
		if(($col=='dt_max' and strtotime($dt_chm['dt_min']) > strtotime($val) and $val !='0000-00-00' and !$flg_y) or ($col=='dt_min' and strtotime($dt_chm['dt_max']) < strtotime($val) and $dt_chm['dt_max'] != '0000-00-00'))
		{
			echo $txt->errdat->$id_lng;
			return;
		}elseif($col=='dt_max' and strtotime($dt_chm['dt_min']) > strtotime($val) and $flg_y)
		{
			$dt = explode('-',$val);
			$y=$dt[0]+1;
			$val = $y.'-'.$dt[1].'-'.$dt[2];
		}
		$rq_trf = select('cat_hbr_chm_trf_ssn.id,cat_hbr_chm_trf_ssn.dt_min,cat_hbr_chm_trf_ssn.dt_max','cat_hbr_chm_trf INNER JOIN cat_hbr_chm_trf_ssn ON cat_hbr_chm_trf.id = cat_hbr_chm_trf_ssn.id_trf','cat_hbr_chm_trf_ssn.id!='.$id.' AND id_chm',$dt_chm['id_chm']);
		while($dt_trf = ftc_ass($rq_trf))
		{
			if(strtotime($val) >= strtotime($dt_trf['dt_min']) and strtotime($val) <= strtotime($dt_trf['dt_max']))
			{
				echo $txt->errdat2->$id_lng;
				return;
			}elseif(($col=='dt_max' and $dt_chm['dt_min']!='0000-00-00' and strtotime($dt_chm['dt_min']) < strtotime($dt_trf['dt_max']) and strtotime($val) > strtotime($dt_trf['dt_min'])) or ($col=='dt_min' and $dt_chm['dt_max']!='0000-00-00' and strtotime($dt_chm['dt_max']) > strtotime($dt_trf['dt_min']) and strtotime($val) < strtotime($dt_trf['dt_max'])))
			{
				echo $txt->errdat3->$id_lng;
				return;
			}
		}
	}elseif($tab=='cat_hbr_rgm_trf' and $col=='def')
	{
		$dt_rgm = ftc_ass(select('id_rgm','cat_hbr_rgm_trf','id',$id));
		$rq_trf = select('id','cat_hbr_rgm_trf','id_rgm',$dt_rgm['id_rgm']);
		while($dt_trf = ftc_ass($rq_trf))
		{
			if($id != $dt_trf['id'])
			{
				upd_quo('cat_hbr_rgm_trf','def','0',$dt_trf['id']);
			}
		}
	}elseif($tab=='cat_hbr_rgm_trf_ssn' and ($col=="dt_min" || $col=="dt_max"))
	{
		$dt_rgm = ftc_ass(select('id_rgm,dt_min,dt_max','cat_hbr_rgm_trf INNER JOIN cat_hbr_rgm_trf_ssn ON cat_hbr_rgm_trf.id = cat_hbr_rgm_trf_ssn.id_trf','cat_hbr_rgm_trf_ssn.id',$id));
		if(($col=='dt_max' and strtotime($dt_rgm['dt_min']) > strtotime($val) and $val !='0000-00-00' and !$flg_y) or ($col=='dt_min' and strtotime($dt_rgm['dt_max']) < strtotime($val) and $dt_rgm['dt_max'] != '0000-00-00'))
		{
			echo $txt->errdat->$id_lng;
			return;
		}elseif($col=='dt_max' and strtotime($dt_rgm['dt_min']) > strtotime($val) and $flg_y)
		{
			$dt = explode('-',$val);
			$y=$dt[0]+1;
			$val = $y.'-'.$dt[1].'-'.$dt[2];
		}
		$rq_trf = select('cat_hbr_rgm_trf_ssn.id,cat_hbr_rgm_trf_ssn.dt_min,cat_hbr_rgm_trf_ssn.dt_max','cat_hbr_rgm_trf INNER JOIN cat_hbr_rgm_trf_ssn ON cat_hbr_rgm_trf.id = cat_hbr_rgm_trf_ssn.id_trf','cat_hbr_rgm_trf_ssn.id!='.$id.' AND id_rgm',$dt_rgm['id_rgm']);
		while($dt_trf = ftc_ass($rq_trf))
		{
			if(strtotime($val) >= strtotime($dt_trf['dt_min']) and strtotime($val) <= strtotime($dt_trf['dt_max']) and $id != $dt_trf['id'])
			{
				echo $txt->errdat2->$id_lng;
				return;
			}elseif(($col=='dt_max' and $dt_rgm['dt_min']!='0000-00-00' and strtotime($dt_rgm['dt_min']) < strtotime($dt_trf['dt_max']) and strtotime($val) > strtotime($dt_trf['dt_min'])) or ($col=='dt_min' and $dt_rgm['dt_max']!='0000-00-00' and strtotime($dt_rgm['dt_max']) > strtotime($dt_trf['dt_min']) and strtotime($val) < strtotime($dt_trf['dt_max'])))
			{
				echo $txt->errdat3->$id_lng;
				return;
			}
		}
	}elseif($tab=='cat_lieu')
	{
		if($col=='id_vll' and $val > 0)
		{
			$msg = $txt->act_map_vll->$id_lng;
		}elseif($col=='nom' and $val != '')
		{
			$msg = $txt->act_map->$id_lng;
		}
	}elseif($col=='web' and $val != '' and (substr($val, 0, 7) != 'http://' and substr($val, 0, 8) != 'https://'))
	{
		$val = 'http://'.str_replace(" ","",trim($val)).'/';
	}/*elseif($col=='titre' and $tab != 'cat_prs_txt' and $tab != 'cat_jrn_txt' and $tab != 'cat_frn' and $tab != 'cat_srv_txt' and $tab != 'cat_hbr_txt' and $tab != 'cat_hbr_chm_txt' and $tab != 'cat_lieu_txt')
	{
		$val = mb_strtoupper($val);
	}
	utiliser upnoac() pour output word pdf (accent ok pour site web)?*/
	if($col=='titre' or $col=='dsc')
	{
		$val = str_replace(array("[","{"),"(",$val);
		$val = str_replace(array("]","}"),")",$val);
		if($tab=='cat_crc_txt' or $tab=='cat_mdl_txt' or $tab=='cat_jrn_txt' or $tab=='cat_prs_txt' or $tab=='cat_vll_txt')
		{
			upd_quo($tab,array("dt_txt","usr"),array(date("Y-m-d H:i:s"),$id_usr),$id);
		}
	}
	if(($col=='duree' or $col=='chk_in' or $col=='chk_out') and $val=='')
	{
		$res = upd_nul($tab,$col,$id);
	}else{
		$res = upd_quo($tab,$col,trim(addslashes($val)),$id);
	}
	if(isset($msg))
	{
		echo json_encode(array($res,(string)$msg));
	}else{
		echo json_encode($res);
	}
	return;
}
echo 0;
?>
