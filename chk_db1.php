ERREURS BASE1<BR/>
<?php
ini_set('max_execution_time', 120);
include('prm/fct.php');
$rq_grp = sel_whe("id","grp_dev");
while($dt_grp = ftc_ass($rq_grp)){$lst_grp[]=$dt_grp['id'];}
//grp_pax
$rq_grp_pax = sel_whe("id,id_grp","grp_pax");
while($dt_grp_pax = ftc_ass($rq_grp_pax)){
	if(in_array($dt_grp_pax['id_grp'],$lst_grp)){$flg=false;}
	else{$lst_dep_grp_pax[]=$dt_grp_pax['id'];}
}
echo '<BR/>grp_pax: ';
var_dump($lst_dep_grp_pax);
//foreach($lst_dep_grp_pax as $id){delete("grp_pax","id",$id);}		//DEPURATION
//FIN_BDG
$rq_bdg = sel_whe("id,id_grp","fin_bdg","id_grp>0");
while($dt_bdg = ftc_ass($rq_bdg)){
	if(in_array($dt_bdg['id_grp'],$lst_grp)){$flg=false;}
	else{$lst_dep_bdg[]=$dt_bdg['id'];}
}
echo '<BR/>fin_bdg: ';
var_dump($lst_dep_bdg);
//DEV_CRC
$rq_crc = sel_whe("id,id_grp","dev_crc");
while($dt_crc = ftc_ass($rq_crc)){
	$lst_crc[]=$dt_crc['id'];
	if(!in_array($dt_crc['id_grp'],$lst_grp)){
		echo 'no group '.$dt_crc['id_grp'].' / ';
		//upd_quo("dev_crc","id_grp","1",$dt_crc['id_grp']);
	}
}
echo '<BR/>dev_crc.duree != nb.dev_jrn: ';
$flg = true;
foreach($lst_crc as $id_crc){
	$rq_duree = sel_quo("COUNT(dev_jrn.id) AS total, dev_crc.duree as duree","dev_crc INNER JOIN (dev_mdl INNER JOIN dev_jrn ON dev_mdl.id = dev_jrn.id_mdl)ON dev_crc.id = dev_mdl.id_crc","dev_jrn.opt=1 AND dev_crc.id",$id_crc,"dev_crc.id");
	while($dt_duree = ftc_ass($rq_duree)){
		$dt_mdl = ftc_ass(sel_quo("MAX(dev_mdl.ord) AS max","dev_crc INNER JOIN dev_mdl ON dev_crc.id = dev_mdl.id_crc","dev_crc.id",$id_crc));
		if($dt_mdl['max']>0){
			$dt_fus = ftc_ass(sel_whe("COUNT(dev_mdl.id) AS total","dev_crc INNER JOIN dev_mdl ON dev_crc.id = dev_mdl.id_crc","dev_mdl.ord<".$dt_mdl['max']." AND fus=1 AND dev_crc.id=".$id_crc));
			$nb = $dt_duree['total']-$dt_fus['total'];
			if($nb != $dt_duree['duree']){
				$flg = false;
				echo $id_crc.' ('.$nb.' != '.$dt_duree['duree'].') ';
			}
		}
	}
}
if($flg){echo 'NULL ';}
//DEV_CRC_BSS
$rq_crc_bss = sel_whe("id,id_crc","dev_crc_bss");
while($dt_crc_bss = ftc_ass($rq_crc_bss)){
	$flg = true;
	foreach($lst_crc as $id_crc){
		if($id_crc == $dt_crc_bss['id_crc']){$flg=false;}
	}
	if($flg){$lst_dep_crc_bss[]=$dt_crc_bss['id'];}
}
echo '<BR/>dev_crc_bss: ';
var_dump($lst_dep_crc_bss);
//DEV_CRC_RMN
$rq_rmn = sel_whe("id,id_crc","dev_crc_rmn");
while($dt_rmn = ftc_ass($rq_rmn)){
	$flg = true;
	foreach($lst_crc as $id_crc){
		if($id_crc == $dt_rmn['id_crc']){$flg=false;}
	}
	if($flg){$lst_dep_rmn[]=$dt_rmn['id'];}
	else{$lst_rmn[]=$dt_rmn['id'];}
}
echo '<BR/>dev_crc_rmn: ';
var_dump($lst_dep_rmn);
//DEV_CRC_RMN_PAX
$rq_pax = sel_whe("id,id_rmn","dev_crc_rmn_pax");
while($dt_pax = ftc_ass($rq_pax)){
	$flg = true;
	foreach($lst_rmn as $id_rmn){
		if($id_rmn == $dt_pax['id_rmn']){$flg=false;}
	}
	if($flg){$lst_dep_pax[]=$dt_pax['id'];}
}
echo '<BR/>dev_crc_rmn_pax: ';
var_dump($lst_dep_pax);
//DEV_MDL
$rq_mdl = sel_whe("id,id_crc","dev_mdl");
while($dt_mdl = ftc_ass($rq_mdl)){
	$flg = true;
	foreach($lst_crc as $id_crc){
		if($id_crc == $dt_mdl['id_crc']){$flg=false;}
	}
	if($flg){$lst_dep_mdl[]=$dt_mdl['id'];}
	else{$lst_mdl[]=$dt_mdl['id'];}
}
echo '<BR/>dev_mdl: ';
var_dump($lst_dep_mdl);
//DEV_MDL_BSS
$rq_mdl_bss = sel_whe("id,id_mdl","dev_mdl_bss");
while($dt_mdl_bss = ftc_ass($rq_mdl_bss)){
	$flg = true;
	foreach($lst_mdl as $id_mdl){
		if($id_mdl == $dt_mdl_bss['id_mdl']){$flg=false;}
	}
	if($flg){$lst_dep_mdl_bss[]=$dt_mdl_bss['id'];}
}
echo '<BR/>dev_mdl_bss: ';
var_dump($lst_dep_mdl_bss);
//DEV_MDL_RMN
$rq_rmn = sel_whe("id,id_mdl","dev_mdl_rmn");
while($dt_rmn = ftc_ass($rq_rmn)){
	$flg = true;
	foreach($lst_mdl as $id_mdl){
		if($id_mdl == $dt_rmn['id_mdl']){$flg=false;}
	}
	if($flg){$lst_dep_rmn[]=$dt_rmn['id'];}
	else{$lst_rmn[]=$dt_rmn['id'];}
}
echo '<BR/>dev_mdl_rmn: ';
var_dump($lst_dep_rmn);
//DEV_MDL_RMN_PAX
$rq_pax = sel_whe("id,id_rmn","dev_mdl_rmn_pax");
while($dt_pax = ftc_ass($rq_pax)){
	$flg = true;
	foreach($lst_rmn as $id_rmn){
		if($id_rmn == $dt_pax['id_rmn']){$flg=false;}
	}
	if($flg){$lst_dep_pax[]=$dt_pax['id'];}
}
echo '<BR/>dev_mdl_rmn_pax: ';
var_dump($lst_dep_pax);
//DEV_JRN
$rq_jrn = sel_whe("id,id_mdl","dev_jrn");
while($dt_jrn = ftc_ass($rq_jrn)){
	$flg = true;
	foreach($lst_mdl as $id_mdl){
		if($id_mdl == $dt_jrn['id_mdl']){$flg=false;}
	}
	if($flg){$lst_dep_jrn[]=$dt_jrn['id'];}
	else{$lst_jrn[]=$dt_jrn['id'];}
}
echo '<BR/>dev_jrn: ';
var_dump($lst_dep_jrn);
//DEV_PRS
$rq_prs = sel_whe("id,id_jrn","dev_prs");
while($dt_prs = ftc_ass($rq_prs)){
	$flg = true;
	foreach($lst_jrn as $id_jrn){
		if($id_jrn == $dt_prs['id_jrn']){$flg=false;}
	}
	if($flg){$lst_dep_prs[]=$dt_prs['id'];}
	else{$lst_prs[]=$dt_prs['id'];}
}
echo '<BR/>dev_prs: ';
var_dump($lst_dep_prs);
//DEV_HBR
$rq_hbr = sel_whe("id,id_prs","dev_hbr");
while($dt_hbr = ftc_ass($rq_hbr)){
	$flg = true;
	foreach($lst_prs as $id_prs){
		if($id_prs == $dt_hbr['id_prs']){$flg=false;}
	}
	if($flg){$lst_dep_hbr[]=$dt_hbr['id'];}
	else{$lst_hbr[]=$dt_hbr['id'];}
}
echo '<BR/>dev_hbr: ';
var_dump($lst_dep_hbr);
//foreach($lst_dep_hbr as $id){delete("dev_hbr_pay","id",$id);}		//DEPURATION
//DEV_HBR_PAY
$rq_hbr_pay = sel_whe("id,id_hbr","dev_hbr_pay");
while($dt_hbr_pay = ftc_ass($rq_hbr_pay)){
	$flg = true;
	foreach($lst_hbr as $id_hbr){
		if($id_hbr == $dt_hbr_pay['id_hbr']){$flg=false;}
	}
	if($flg){$lst_dep_hbr_pay[]=$dt_hbr_pay['id'];}
}
echo '<BR/>dev_hbr_pay: ';
var_dump($lst_dep_hbr_pay);
//DEV_SRV
$rq_srv = sel_whe("id,id_prs","dev_srv");
while($dt_srv = ftc_ass($rq_srv)){
	$flg = true;
	foreach($lst_prs as $id_prs){
		if($id_prs == $dt_srv['id_prs']){$flg=false;}
	}
	if($flg){$lst_dep_srv[]=$dt_srv['id'];}
	else{$lst_srv[]=$dt_srv['id'];}
}
echo '<BR/>dev_srv: ';
var_dump($lst_dep_srv);
?>
