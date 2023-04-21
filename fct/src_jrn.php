<?php
include("../prm/fct.php");
$id_dev_jrn = $_POST['id_dev_jrn'];
$opt = $_POST['opt'];
$dt_jrn = ftc_ass(sel_quo("id_mdl","dev_jrn","id",$id_dev_jrn));
$id_dev_mdl = $dt_jrn['id_mdl'];

$rq_hbr = sel_quo("dev_prs.id AS id_prs, dev_hbr.id AS id_hbr,dev_hbr.id_cat,id_vll,rgm","dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id","id_jrn",$id_dev_jrn);
while($dt_hbr = ftc_ass($rq_hbr)){
	if($dt_hbr['id_cat']=='-1'){//hebergements non definis
		$hbr_id[] = $dt_hbr['id_hbr'];
		$hbr_vll[] = $dt_hbr['id_vll'];
		$hbr_rgm[] = $dt_hbr['rgm'];
		$hbr_prs[] = $dt_hbr['id_prs'];
	}
}
if(isset($hbr_id)){
	$rq_jrn = sel_quo("id","dev_jrn","id_mdl",$id_dev_mdl,"ord"); //recherche dans le module ordre croissant des journées
	while($dt_jrn = ftc_ass($rq_jrn)){
		if($dt_jrn['id'] != $id_dev_jrn){
			$rq_prs = sel_quo("id","dev_prs","id_jrn",$dt_jrn['id']);
			while($dt_prs = ftc_ass($rq_prs)){
				$j = 0;
				$rq_hbr = sel_quo("id,id_cat,id_cat_chm,id_vll,rgm,opt,sel,res,dt_res,rva","dev_hbr","id_prs",$dt_prs['id']);
				while($dt_hbr = ftc_ass($rq_hbr)){
					if($opt){
						$sel = 0;
						if($dt_hbr['res']==-2 or $dt_hbr['res']==1 or $dt_hbr['res']==2 or $dt_hbr['res']==3){$res = 3;}
						elseif(!isset($res)){$res = 0;}
						$dt_res = '0000-00-00';
						$rva =	"";
					}
					else{
						$sel = $dt_hbr['sel'];
						$res = $dt_hbr['res'];
						$dt_res = $dt_hbr['dt_res'];
						$rva = $dt_hbr['rva'];
					}
					foreach($hbr_id as $i => $id_hbr){
						if($dt_hbr['id_cat']>0 and $dt_hbr['id_vll'] == $hbr_vll[$i] and $dt_hbr['rgm'] == $hbr_rgm[$i]){
							if($dt_hbr['opt']){$arr[$id_hbr][$j] = array($dt_hbr['id_cat'],$dt_hbr['id_cat_chm'],$hbr_vll[$i],$hbr_rgm[$i],$id_hbr,$hbr_prs[$i],$sel,$res,$dt_res,$rva);}
							else{$arr[$id_hbr][$j] = array($dt_hbr['id_cat'],$dt_hbr['id_cat_chm'],$hbr_vll[$i],$hbr_rgm[$i],0,$hbr_prs[$i],$sel,$res,$dt_res,$rva);}
							$j++;
						}
					}
					unset($res);
				}
			}
		}
	}
	foreach($hbr_id as $i => $id_hbr){
		if(isset($arr[$id_hbr])){
			foreach($arr[$id_hbr] as $arr_hbr){$arr2[] = implode("|",$arr_hbr);}
			$imp = implode("|-|",$arr2);
			echo $imp;
		}
		else{echo 0;}
	}
}
else{echo 0;}
?>
