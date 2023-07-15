<?php
$id_dev_crc = $_POST['id_dev_crc'];
$id_hbr_def = $_POST['hbr_def'];
$txt = simplexml_load_file('txt.xml');
include("../prm/fct.php");
include("../cfg/crr.php");
include("../cfg/lng.php");
$x = $y=0;
$alt = $err = $err_hbr = '';
$dt_dev_crc = ftc_ass(select("crr","dev_crc","id",$id_dev_crc));
$id_crr_crc = $dt_dev_crc['crr'];
$rq_mdl = select("id","dev_mdl","id_crc",$id_dev_crc);
while($dt_mdl = ftc_ass($rq_mdl)){
	$rq_jrn = select("id,date,ord","dev_jrn","id_mdl",$dt_mdl['id']);
	while($dt_jrn = ftc_ass($rq_jrn)){
		$date = $dt_jrn['date'];
		$ord_jrn = $dt_jrn['ord'];
		$rq_prs = select("id","dev_prs","id_jrn",$dt_jrn['id']);
		while($dt_prs = ftc_ass($rq_prs)){
			$flg_def = false;
			$hbr_vll = 0;
			$hbr_rgm = 0;
			$rq_hbr = select("id,id_cat,id_cat_chm,id_vll,rgm,opt","dev_hbr","id_prs",$dt_prs['id']);
			while($dt_hbr = ftc_ass($rq_hbr)){
				$id_dev_hbr = $dt_hbr['id'];
				$id_hbr_rgm = $dt_hbr['rgm'];
				$dt_vll_hbr = ftc_ass(select("id_hbr,id_chm","cat_vll_hbr","rgm=".$dt_hbr['rgm']." AND hbr_def=".$id_hbr_def." AND id_vll",$dt_hbr['id_vll']));
				$id_cat_hbr = $dt_vll_hbr['id_hbr'];
				$id_cat_chm = $dt_vll_hbr['id_chm'];
				if($dt_hbr['id_cat']==-1 or ($dt_hbr['id_cat']>0 and $dt_hbr['id_cat']==$id_cat_hbr and $dt_hbr['id_cat_chm']==-1)){
					if($id_cat_hbr!=0 and $id_cat_chm!=0){
						$res = $sel = 0;
						$dt_res = '0000-00-00';
						$rva = '';
						include("act_hbr.php");
						if($err_hbr != ''){
							$err .= $err_hbr;
							$err_hbr = '';
						}
						$x++;
						$flg_def = true;
					}
					else{$y++;}
				}
				elseif($dt_hbr['id_cat']==$id_cat_hbr and $dt_hbr['id_cat_chm']==$id_cat_chm){$flg_def = true;}
				if($dt_hbr['opt']){
					$hbr_vll = $dt_hbr['id_vll'];
					$hbr_rgm = $dt_hbr['rgm'];
				}
			}
			if(!$flg_def and $hbr_vll>0 and $hbr_rgm>0){
				$dt_vll_hbr = ftc_ass(select("id_hbr,id_chm","cat_vll_hbr","rgm=".$hbr_rgm." AND hbr_def=".$id_hbr_def." AND id_vll",$hbr_vll));
				$id_cat_hbr = $dt_vll_hbr['id_hbr'];
				$id_cat_chm = $dt_vll_hbr['id_chm'];
				if($id_cat_hbr!=0 and $id_cat_chm!=0){
					$cur = 1;
					$id_crr = $id_crr_crc;
					include("clc_crr.php");
					$id_dev_hbr = insert("dev_hbr",array("id_prs","id_vll","rgm","crr_chm","taux_chm","sup_chm"),array($dt_prs['id'],$hbr_vll,$hbr_rgm,1,$taux,$sup));
					include("act_hbr.php");
					if($err_hbr != ''){
						$err .= $err_hbr;
						$err_hbr = '';
					}
					$x++;
					$flg_def = true;
				}
				else{$y++;}
			}
		}
	}
}
if($err!=''){$err = $txt->hbr_def->msg3->$id_lng.$err;}
if(isset($lst_nvtrf)){
	$err .= $txt->err->nvtrf->$id_lng."\n";
	foreach($lst_nvtrf as $nom){$err .= "-> ".$nom."\n";}
}
echo $x.' '.$txt->hbr_def->msg1->$id_lng.$y.' '.$txt->hbr_def->msg2->$id_lng."|".$err."|".$alt;
?>
