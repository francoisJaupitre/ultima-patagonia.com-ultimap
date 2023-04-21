<?php
include("../prm/fct.php");
$id_frn = $_POST['id_frn'];
$id_dev_srv = $_POST['id_dev_srv'];
$id_dev_crc = $_POST['id_dev_crc'];
$res = $_POST['res'];
$cnf = $_POST['cnf'];
$rq_mdl = sel_quo("id","dev_mdl","id_crc",$id_dev_crc);
while($dt_mdl = ftc_ass($rq_mdl)){
	$rq_jrn = sel_quo("id","dev_jrn",array("opt","id_mdl"),array("1",$dt_mdl['id']));
	while($dt_jrn = ftc_ass($rq_jrn)){
		if($cnf>0){$rq_prs = sel_quo("id","dev_prs",array("res","id_jrn"),array("1",$dt_jrn['id']));}
		else{$rq_prs = sel_quo("id","dev_prs",array("opt","id_jrn"),array("1",$dt_jrn['id']));}
		while($dt_prs = ftc_ass($rq_prs)){
			$rq_srv = sel_quo("id,id_frn,res","dev_srv","opt=1 AND id_prs",$dt_prs['id']);
			while($dt_srv = ftc_ass($rq_srv)){
				if($dt_srv['id_frn']==$id_frn and (($dt_srv['res']!=$res and $dt_srv['res'] != -1 and $dt_srv['res'] != 6 and $dt_srv['id'] != $id_dev_srv) or ($res == 0 and $id_dev_srv == 0))){$arr[] = $dt_srv['id'];}
			}
		}
	}
}
if(isset($arr)){
	$imp = implode("|",$arr);
	echo $imp;
}
else{echo 0;}
?>
