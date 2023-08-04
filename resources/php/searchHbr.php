<?php
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_cat_hbr']))
{
	include("../../prm/fct.php");
	include("../../prm/aut.php");
	$id_cat_hbr = $data['id_cat_hbr'];
	$id_cat_chm = $data['id_cat_chm'];
	$id_hbr_vll = $data['id_hbr_vll'];
	$id_hbr_rgm = $data['id_hbr_rgm'];
	$id_dev_hbr = $data['id_dev_hbr'];
	$id_dev_prs = $data['id_dev_prs'];
	$res = $data['res'];
	$cnf = $data['cnf'];
	$txt = simplexml_load_file('../xml/searchTxt.xml');
	if($id_cat_hbr == 0)
	{
		$dt_hbr = ftc_ass(sel_quo("id_cat,id_cat_chm,rgm","dev_hbr","id",$id_dev_hbr));
		$id_cat_hbr = $dt_hbr['id_cat'];
		$id_cat_chm = $dt_hbr['id_cat_chm'];
		$id_hbr_rgm = $dt_hbr['rgm'];
	}
	if($id_dev_prs != 0 and $id_dev_hbr != 0)
	{
		$xmlTxt1 = 'src_hbr0';
		if($res == 'ajt')
		{
			$xmlTxt0 = 'src_hbr1';
		}elseif($res == 'opt' or $res == 'sel')
		{
			$xmlTxt0 = 'src_hbr2';

		}elseif($res == 'sup')
		{
			$xmlTxt0 = 'src_hbr3';
		}
	}elseif($id_dev_prs != 0 and $id_dev_hbr == 0)
	{
		$xmlTxt0 = 'src_hbr5';
		$xmlTxt1 = 'src_hbr4';
		if($cnf < 1)
		{
			$dt = ftc_ass(sel_whe("id_cat,id_cat_chm,rgm,id_vll","dev_hbr","opt=1 AND id_vll > 0 AND id_prs=".$id_dev_prs));
		}else{
			$dt = ftc_ass(sel_whe("id_cat,id_cat_chm,rgm,id_vll","dev_hbr","sel=1 AND id_vll > 0 AND id_prs=".$id_dev_prs));
		}
		$id_ref_vll = $dt['id_vll'];
		$id_ref_hbr = $dt['id_cat'];
		$id_ref_chm = $dt['id_cat_chm'];
		$id_ref_rgm = $dt['rgm'];
	}elseif($id_dev_prs == 0 and $id_dev_hbr != 0)
	{
		$xmlTxt0 = 'src_hbr6';
		$xmlTxt1 = 'src_hbr7';
	}else if($id_dev_prs == 0 and $id_dev_hbr == 0)
	{
		if($res == 'updateRates')
		{
			$xmlTxt0 = 'src_hbr8';
			$xmlTxt1 = 'src_hbr9';
		}else if($res == 'sup')
		{
			$xmlTxt0 = 'src_hbr10';
			$xmlTxt1 = 'src_hbr11';
		}
	}
	$rq_mdl = sel_quo("id","dev_mdl","id_crc",$data['id_dev_crc']);
	while($dt_mdl = ftc_ass($rq_mdl))
	{
		$rq_jrn = sel_quo("id","dev_jrn",array("opt","id_mdl"),array("1",$dt_mdl['id']));
		while($dt_jrn = ftc_ass($rq_jrn))
		{
			$rq_prs = sel_quo("id,res,opt","dev_prs","id_jrn",$dt_jrn['id'],"","DISTINCT");
			while($dt_prs = ftc_ass($rq_prs))
			{
				$flg = false;
				$rq_hbr = sel_quo("id,id_cat,id_cat_chm,id_vll,rgm,opt,sel,rgm,res","dev_hbr","id_prs",$dt_prs['id'],"opt DESC");
				while($dt_hbr = ftc_ass($rq_hbr))
				{
					if($id_dev_prs!= 0 and $id_dev_hbr!= 0 and $dt_hbr['id_vll'] == $id_hbr_vll and $dt_hbr['rgm'] == $id_hbr_rgm and $dt_hbr['id_cat'] == '-1' and $dt_hbr['id'] != $id_dev_hbr)
					{ //HBR NON DEFINIS
						$arr[] = $dt_hbr['id'];
					}elseif($id_dev_prs!= 0 and $id_dev_hbr!= 0 and $dt_hbr['id_vll'] == $id_hbr_vll and $dt_hbr['rgm'] == $id_hbr_rgm and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == '-1' and $dt_hbr['id'] != $id_dev_hbr){
						$arr[] = $dt_hbr['id']; //HBR DEFINI / CHM NON DEFINIE
					}elseif($id_dev_prs!= 0 and $id_dev_hbr!= 0 and $id_hbr_vll == 0 and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == $id_cat_chm and $dt_hbr['id'] != $id_dev_hbr and $id_dev_prs != $dt_prs['id'] and $dt_hbr[$res] == 0){
						$arr[] = array($dt_hbr['id'], $dt_prs['id']); //SUP/SEL/OPT
					}elseif($id_dev_prs!= 0 and $id_dev_hbr == 0 and $dt_prs['id'] != $id_dev_prs){ //AJT_OPT
						if((($cnf < 1 and $dt_hbr['opt'] == 1) or ($cnf > 0 and $dt_hbr['sel'] == 1)) and $dt_hbr['id_cat'] == $id_ref_hbr and $dt_hbr['id_cat_chm'] == $id_ref_chm and $dt_hbr['rgm'] == $id_ref_rgm and $dt_hbr['id_vll'] == $id_ref_vll)
						{ //AJOUTER MEME OPTION HBR
							$flg = true;
						}
						if((($cnf < 1 and $dt_hbr['opt'] == 0) or ($cnf > 0 and $dt_hbr['sel'] == 0)) and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == $id_cat_chm)
						{ //SAUF SI EXISTE DEJA
							$flg = false;
						}
					}elseif($id_dev_prs == 0 and $id_dev_hbr != 0 and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == $id_cat_chm and (($dt_hbr['res']!= $res and $dt_hbr['res'] != -1 and $dt_hbr['res'] != 6 and $dt_hbr['id'] != $id_dev_hbr) or ($res == 0 and $id_dev_hbr == 0))){
						$arr[] = $dt_hbr['id']; //MAJ_RES
					}
					elseif($id_dev_prs == 0 and $id_dev_hbr == 0 and $dt_hbr['id_cat'] == $id_cat_hbr and $dt_hbr['id_cat_chm'] == $id_cat_chm){
						if($res == 'updateRates')
						{//update all rates
							$arr[] = $dt_hbr['id'];
						}elseif($res == 'sup'){ //SUP_ALL
							$arr[] = array($dt_hbr['id'],$dt_prs['id']);
						}
					}
				}
				if($flg) {
					$arr[] = $dt_prs['id'];
				}
			}
		}
	}
	if(isset($arr))
	{
		$msg[] = $txt->$xmlTxt0->$id_lng." ".count($arr)." ".$txt->$xmlTxt1->$id_lng;
		if($id_dev_prs == 0 and $id_dev_hbr == 0 and $cnf > 0)
		{
			$msg[] = (string)$txt->cnf->$id_lng;
		}
		$qa = array_merge($msg,$arr);
		echo json_encode($qa);
	}else{
		echo 0;
	}
}
?>
