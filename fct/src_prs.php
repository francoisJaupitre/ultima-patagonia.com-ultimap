<?php
include("../prm/fct.php");
$id_cat_prs = $_POST['id_cat_prs'];
$ord_prs = $_POST['ord_prs'];
$id_dev_jrn = $_POST['id_dev_jrn'];
$id_dev_crc = $_POST['id_dev_crc'];
$res_act = $_POST['res_act'];
$chk = $_POST['chk'];
if($chk==-1){
	if($ord_prs>0){
		$dt_prs = ftc_ass(sel_quo("id_cat","dev_prs",array("opt","id_jrn","ord"),array("1",$id_dev_jrn,$ord_prs)));
		$id_ref_prs = $dt_prs['id_cat'];
		if($id_ref_prs>0){
			$rq = sel_whe("dev_jrn.id,dev_prs.ord","dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id","dev_jrn.opt=1 AND dev_jrn.id!=".$id_dev_jrn." AND dev_mdl.id_crc=".$id_dev_crc." AND dev_prs.id_cat=".$id_ref_prs);
			while($dt = ftc_ass($rq)){
				$flg = true;
				$rq_prs = sel_quo("id_cat","dev_prs",array("ord","id_jrn"),array($dt['ord'],$dt['id']));
				while($dt_prs = ftc_ass($rq_prs)){
					if($dt_prs['id_cat']==$id_cat_prs){$flg = false;}
				}
				if($flg){
					$flg2 = true;
					if(isset($lst)){
						foreach($lst as $id){
							if($id==$dt['id']){$flg2 = false;}
						}
					}
					if($flg2){
						$arr[] = $dt['id'];
						$arr[] = $dt['ord'];
						$lst[] = $dt['id'];
					}
				}
			}
		}
	}
	else{
		//ajt_opt vue_dt_jrn
	}
}
elseif($id_cat_prs>0){
	if($chk >= 0 and $chk <= 1){
		$rq = sel_whe("dev_prs.id AS id_prs, dev_jrn.id AS id_jrn","dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id","dev_jrn.opt=1 AND dev_jrn.id!=".$id_dev_jrn." AND dev_mdl.id_crc=".$id_dev_crc." AND dev_prs.opt=".$chk." AND dev_prs.id_cat=".$id_cat_prs);
		while($dt = ftc_ass($rq)){
			$arr[] = $dt['id_prs'];
			$arr[] = $dt['id_jrn'];
		}
	}
	elseif($chk==-2){
		$rq = sel_whe("dev_prs.id AS id_prs","dev_prs INNER JOIN (dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id","dev_jrn.opt=1 AND dev_jrn.id!=".$id_dev_jrn." AND dev_mdl.id_crc=".$id_dev_crc." AND dev_prs.res!=".$res_act." AND dev_prs.id_cat=".$id_cat_prs);
		while($dt = ftc_ass($rq)){$arr[] = $dt['id_prs'];}
	}
}
/*elseif($res_act!='sup' and $ord_prs>0){//anl_opt solo?
	$dt_prs = ftc_ass(sel_quo("id_jrn,ord","dev_prs","id",$ord_prs));echo $ord_prs.' '.$dt_prs['ord'].' '.$dt_prs['id_jrn'];
	$dt_cnf_prs = ftc_ass(sel_whe("id","dev_prs","res = 1 AND id != ".$ord_prs." AND ord=".$dt_prs['ord']." AND id_jrn=".$dt_prs['id_jrn']));
	$arr[] = $dt_cnf_prs['id'];
}*/
if(isset($arr)){
	$imp = implode("|",$arr);
	echo $imp;
}
else{echo 0;}
?>
