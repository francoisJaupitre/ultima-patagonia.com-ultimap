ERREURS BASE2<BR/>
<?php
ini_set('max_execution_time', 120);
include('prm/fct.php');
$rq_srv = sel_whe("id","dev_srv");
while($dt_srv = ftc_ass($rq_srv)){$lst_srv[]=$dt_srv['id'];}
//DEV_SRV_PAY
$rq_srv_pay = sel_whe("id,id_srv","dev_srv_pay");
while($dt_srv_pay = ftc_ass($rq_srv_pay)){
	$flg = true;
	foreach($lst_srv as $id_srv){
		if($id_srv == $dt_srv_pay['id_srv']){$flg=false;}
	}
	if($flg){$lst_dep_srv_pay[]=$dt_srv_pay['id'];}
}
echo '<BR/>dev_srv_pay: ';
var_dump($lst_dep_srv_pay);
//DEV_SRV_TRF
$rq_srv_trf = sel_whe("id,id_srv","dev_srv_trf");
while($dt_srv_trf = ftc_ass($rq_srv_trf)){
	$flg = true;
	foreach($lst_srv as $id_srv){
		if($id_srv == $dt_srv_trf['id_srv']){$flg=false;}
	}
	if($flg){$lst_dep_srv_trf[]=$dt_srv_trf['id'];}
}
echo '<BR/>dev_srv_trf: ';
var_dump($lst_dep_srv_trf);
//foreach($lst_dep_srv_trf as $id){$rq = delete("dev_srv_trf","id",$id);}		//DEPURATION

//CATALOGUE
$rq_srv = sel_whe("id","cat_srv");
while($dt_srv = ftc_ass($rq_srv)){
	$lst_srv[]=$dt_srv['id'];
}
$rq_trf = sel_whe("id,id_srv","cat_srv_trf");
while($dt_trf = ftc_ass($rq_trf)){
	$flg = true;
	foreach($lst_srv as $id_srv){
		if($id_srv == $dt_trf['id_srv']){$flg=false;}
	}
	if($flg){$lst_dep_trf[]=$dt_trf['id'];}
	else{$lst_srv_trf[]=$dt_trf['id'];}
}
echo '<BR/>cat_srv_trf: ';
var_dump($lst_dep_trf);

$rq_bss = sel_whe("id,id_trf","cat_srv_trf_bss");
while($dt_bss = ftc_ass($rq_bss)){
	$flg = true;
	foreach($lst_srv_trf as $id_trf){
		if($id_trf == $dt_bss['id_trf']){$flg=false;}
	}
	if($flg){$lst_dep_trf_bss[]=$dt_bss['id'];}
	else{$lst_trf_bss[]=$dt_bss['id'];}
}
echo '<BR/>cat_srv_trf_bss: ';
var_dump($lst_dep_trf_bss);


$rq_hbr = sel_whe("id","cat_hbr");
while($dt_hbr = ftc_ass($rq_hbr)){
	$lst_hbr[]=$dt_hbr['id'];
}

$rq_pay = sel_whe("id,id_hbr","cat_hbr_pay");
while($dt_pay = ftc_ass($rq_pay)){
	$flg = true;
	foreach($lst_hbr as $id_hbr){
		if($id_hbr == $dt_pay['id_hbr']){$flg=false;}
	}
	if($flg){$lst_dep_pay[]=$dt_pay['id'];}
	else{$lst_hbr_pay[]=$dt_pay['id'];}
}
echo '<BR/>cat_hbr_pay: ';
var_dump($lst_dep_pay);

$rq_chm = sel_whe("id,id_hbr","cat_hbr_chm");
while($dt_chm = ftc_ass($rq_chm)){
	$flg = true;
	foreach($lst_hbr as $id_hbr){
		if($id_hbr == $dt_chm['id_hbr']){$flg=false;}
	}
	if($flg){$lst_dep_chm[]=$dt_chm['id'];}
	else{$lst_hbr_chm[]=$dt_chm['id'];}
}
echo '<BR/>cat_hbr_chm: ';
var_dump($lst_dep_chm);

$rq_trf = sel_whe("id,id_chm","cat_hbr_chm_trf");
while($dt_trf = ftc_ass($rq_trf)){
	$flg = true;
	foreach($lst_hbr_chm as $id_chm){
		if($id_chm == $dt_trf['id_chm']){$flg=false;}
	}
	if($flg){$lst_dep_chm_trf[]=$dt_trf['id'];}
	else{$lst_chm_trf[]=$dt_trf['id'];}
}
echo '<BR/>cat_hbr_chm_trf: ';
var_dump($lst_dep_chm_trf);

foreach($lst_chm_trf as $id_trf){
	$nb_ssn = ftc_ass(sel_quo("COUNT(*) as total","cat_hbr_chm_trf_ssn","id_trf",$id_trf));
	if($nb_ssn['total']==0){$lst_dep_chm_trf2[]=$id_trf;}
	}
echo '<BR/>cat_hbr_chm_trf(no ssn): ';
var_dump($lst_dep_chm_trf2);
//foreach($lst_dep_chm_trf2 as $id){delete("cat_hbr_chm_trf","id",$id);}		//DEPURATION

$rq_ssn = sel_whe("id,id_trf","cat_hbr_chm_trf_ssn");
while($dt_ssn = ftc_ass($rq_ssn)){
	$flg = true;
	foreach($lst_chm_trf as $id_trf){
		if($id_trf == $dt_ssn['id_trf']){$flg=false;}
	}
	if($flg){$lst_dep_chm_trf_ssn[]=$dt_ssn['id'];}
}
echo '<BR/>cat_hbr_chm_trf_ssn: ';
var_dump($lst_dep_chm_trf_ssn);
//foreach($lst_dep_chm_trf_ssn as $id){$rq = delete("cat_hbr_chm_trf_ssn","id",$id);}		//DEPURATION

$rq_rgm = sel_whe("id,id_hbr","cat_hbr_rgm");
while($dt_rgm = ftc_ass($rq_rgm)){
	$flg = true;
	foreach($lst_hbr as $id_hbr){
		if($id_hbr == $dt_rgm['id_hbr']){$flg=false;}
	}
	if($flg){$lst_dep_rgm[]=$dt_rgm['id'];}
	else{$lst_hbr_rgm[]=$dt_rgm['id'];}
}
echo '<BR/>cat_hbr_rgm: ';
var_dump($lst_dep_rgm);

$rq_trf = sel_whe("id,id_rgm","cat_hbr_rgm_trf");
while($dt_trf = ftc_ass($rq_trf)){
	$flg = true;
	foreach($lst_hbr_rgm as $id_rgm){
		if($id_rgm == $dt_trf['id_rgm']){$flg=false;}
	}
	if($flg){$lst_dep_rgm_trf[]=$dt_trf['id'];}
	else{$lst_rgm_trf[]=$dt_trf['id'];}
}
echo '<BR/>cat_hbr_rgm_trf: ';
var_dump($lst_dep_rgm_trf);
//foreach($lst_dep_rgm_trf as $id){$rq = delete("cat_hbr_rgm_trf","id",$id);}		//DEPURATION

foreach($lst_rgm_trf as $id_trf){
	$nb_ssn = ftc_ass(sel_quo("COUNT(*) as total","cat_hbr_rgm_trf_ssn","id_trf",$id_trf));
	if($nb_ssn['total']==0){$lst_dep_rgm_trf2[]=$id_trf;}
	}
echo '<BR/>cat_hbr_rgm_trf(no ssn): ';
var_dump($lst_dep_rgm_trf2);
//foreach($lst_dep_rgm_trf2 as $id){delete("cat_hbr_rgm_trf","id",$id);}		//DEPURATION

$rq_ssn = sel_whe("id,id_trf","cat_hbr_rgm_trf_ssn");
while($dt_ssn = ftc_ass($rq_ssn)){
	$flg = true;
	foreach($lst_rgm_trf as $id_trf){
		if($id_trf == $dt_ssn['id_trf']){$flg=false;}
	}
	if($flg){$lst_dep_rgm_trf_ssn[]=$dt_ssn['id'];}
}
echo '<BR/>cat_hbr_rgm_trf_ssn: ';
var_dump($lst_dep_rgm_trf_ssn);
//foreach($lst_dep_rgm_trf_ssn as $id){$rq = delete("cat_hbr_rgm_trf_ssn","id",$id);}		//DEPURATION

$rq_frn = sel_whe("id","cat_frn");
while($dt_frn = ftc_ass($rq_frn)){
	$lst_frn[]=$dt_frn['id'];
}
$rq_frn_ctg_srv = sel_whe("id,id_frn","cat_frn_ctg_srv");
while($dt_frn_ctg_srv = ftc_ass($rq_frn_ctg_srv)){
	$flg = true;
	foreach($lst_frn as $id_frn){
		if($id_frn == $dt_frn_ctg_srv['id_frn']){$flg=false;}
	}
	if($flg){$lst_dep_frn_ctg_srv[]=$dt_frn_ctg_srv['id'];}
}
echo '<BR/>cat_frn_ctg_srv: ';
var_dump($lst_dep_frn_ctg_srv);
//foreach($lst_dep_frn_ctg_srv as $id){$rq = delete("cat_frn_ctg_srv","id",$id);}		//DEPURATION
$rq_frn_pay = sel_whe("id,id_frn","cat_frn_pay");
while($dt_frn_pay = ftc_ass($rq_frn_pay)){
	$flg = true;
	foreach($lst_frn as $id_frn){
		if($id_frn == $dt_frn_pay['id_frn']){$flg=false;}
	}
	if($flg){$lst_dep_frn_pay[]=$dt_frn_pay['id'];}
}
echo '<BR/>cat_frn_pay: ';
var_dump($lst_dep_frn_pay);
//foreach($lst_dep_frn_pay as $id){$rq = delete("cat_frn_pay","id",$id);}		//DEPURATION
$rq_frn_vll = sel_whe("id,id_frn","cat_frn_vll");
while($dt_frn_vll = ftc_ass($rq_frn_vll)){
	$flg = true;
	foreach($lst_frn as $id_frn){
		if($id_frn == $dt_frn_vll['id_frn']){$flg=false;}
	}
	if($flg){$lst_dep_frn_vll[]=$dt_frn_vll['id'];}
}
echo '<BR/>cat_frn_vll: ';
var_dump($lst_dep_frn_vll);
//foreach($lst_dep_frn_vll as $id){$rq = delete("cat_frn_vll","id",$id);}		//DEPURATION



$rq_vll = sel_whe("id","cat_vll");
while($dt_vll = ftc_ass($rq_vll)){
	$lst_vll[]=$dt_vll['id'];
}

$rq_lieu = sel_whe("id,id_vll","cat_lieu");
while($dt_lieu = ftc_ass($rq_lieu)){
	$flg = true;
	foreach($lst_vll as $id_vll){
		if($id_vll == $dt_lieu['id_vll']){$flg=false;}
	}
	if($flg){$lst_dep_lieu[]=$dt_lieu['id'];}
}
echo '<BR/>cat_lieu: ';
var_dump($lst_dep_lieu);
//foreach($lst_dep_lieu as $id){$rq = upd_quo("cat_lieu","id_vll","NULL",$id);}		//DEPURATION
$rq_jrn_pic = sel_whe("id,id_jrn,id_pic","cat_jrn_pic","","id");
while($dt_jrn_pic = ftc_ass($rq_jrn_pic)){
	$flg = true;
	$rq_jrn = sel_whe("id","cat_jrn");
	while($dt_jrn = ftc_ass($rq_jrn)){
		if($dt_jrn['id'] == $dt_jrn_pic['id_jrn']){
			$rq_pic = sel_whe("id","cat_pic");
			while($dt_pic = ftc_ass($rq_pic)){
				if($dt_pic['id'] == $dt_jrn_pic['id_pic']){
					$flg=false;
				}
			}
		}
	}

	if($flg){$lst_dep_jrn_pic[]=$dt_jrn_pic['id'];}
}
echo '<BR/>cat_jrn_pic: ';
var_dump($lst_dep_jrn_pic);
//
$rq_crc_rmn_pax = sel_whe("*","dev_crc_rmn_pax","","id");
while($dt_crc_rmn_pax = ftc_ass($rq_crc_rmn_pax)){
	$flg = true;
	$rq_crc_rmn = sel_quo("id_crc","dev_crc_rmn","id",$dt_crc_rmn_pax['id_rmn']);
	while($dt_crc_rmn = ftc_ass($rq_crc_rmn)){
		$dt_crc_pax = ftc_ass(sel_quo("id","dev_crc_pax",array("id_pax","id_crc"),array($dt_crc_rmn_pax['id_pax'],$dt_crc_rmn['id_crc']),"id"));
		if($dt_crc_pax['id']>0){$flg = false;}
	}
	if($flg){$lst_dep_crc_rmn_pax[]=$dt_crc_rmn_pax['id'];}
}
echo '<BR/>dev_crc_rmn_pax: ';
var_dump($lst_dep_crc_rmn_pax);
//foreach($lst_dep_crc_rmn_pax as $id){delete("dev_crc_rmn_pax","id",$id);}		//DEPURATION
$rq_mdl_rmn_pax = sel_whe("*","dev_mdl_rmn_pax","","id");
while($dt_mdl_rmn_pax = ftc_ass($rq_mdl_rmn_pax)){
	$flg = true;
	$rq_mdl_rmn = sel_quo("id_mdl","dev_mdl_rmn","id",$dt_mdl_rmn_pax['id_rmn']);
	while($dt_mdl_rmn = ftc_ass($rq_mdl_rmn)){
		$dt_mdl_pax = ftc_ass(sel_quo("id","dev_mdl_pax",array("id_pax","id_mdl"),array($dt_mdl_rmn_pax['id_pax'],$dt_mdl_rmn['id_mdl']),"id"));
		if($dt_mdl_pax['id']>0){$flg = false;}
	}
	if($flg){$lst_dep_mdl_rmn_pax[]=$dt_mdl_rmn_pax['id'];}
}
echo '<BR/>dev_mdl_rmn_pax: ';
var_dump($lst_dep_mdl_rmn_pax);
//foreach($lst_dep_mdl_rmn_pax as $id){delete("dev_mdl_rmn_pax","id",$id);}		//DEPURATION
