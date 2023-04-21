<?php
if(isset($_POST['cbl'])){
	$cbl = $_POST['cbl'];
	unset($_POST['cbl']);
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/pays.php");
}
else{$cbl = 'hom';}
include("../cfg/crr.php");
include("../cfg/frn.php");
//stats header
$nb_dev = ftc_ass(sel_quo("COUNT(*) as total","dev_crc","cnf","NULL"));
$nb_arc = ftc_ass(sel_quo("COUNT(*) as total","dev_crc","cnf","-1"));
$nb_cnf = ftc_ass(sel_quo("COUNT(*) as total","dev_crc","cnf","1"));
$nb_fin = ftc_ass(sel_quo("COUNT(*) as total","dev_crc","cnf","2"));
$nb_crc = ftc_ass(sel_whe("COUNT(*) as total","cat_crc"));
$nb_mdl = ftc_ass(sel_whe("COUNT(*) as total","cat_mdl"));
$nb_jrn = ftc_ass(sel_whe("COUNT(*) as total","cat_jrn"));
$nb_prs = ftc_ass(sel_whe("COUNT(*) as total","cat_prs"));
$nb_srv = ftc_ass(sel_whe("COUNT(*) as total","cat_srv"));
$nb_hbr = ftc_ass(sel_whe("COUNT(*) as total","cat_hbr"));
$nb_clt = ftc_ass(sel_whe("COUNT(*) as total","cat_clt"));
$nb_frn = ftc_ass(sel_whe("COUNT(*) as total","cat_frn"));
$nb_pic = ftc_ass(sel_whe("COUNT(*) as total","cat_pic"));
$nb_rgn = ftc_ass(sel_whe("COUNT(*) as total","cat_rgn"));
$nb_vll = ftc_ass(sel_whe("COUNT(*) as total","cat_vll"));
$nb_lieu = ftc_ass(sel_whe("COUNT(*) as total","cat_lieu"));

//COMPARE DATE MAJ TXT CAT VS DATE web
$id_lgg = 1; //Français
$rq_mdl_web = sel_whe("cat_mdl.id,cat_mdl.nom,cat_mdl_txt.dt_web,cat_mdl_txt.dt_txt","cat_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl","web_uid != '' AND lgg=".$id_lgg);
while($dt_mdl_web = ftc_ass($rq_mdl_web)){
	$web_mdl_date[$dt_mdl_web['id']] = $dt_mdl_web['dt_web'];
	$txt_mdl_date[$dt_mdl_web['id']] = $dt_mdl_web['dt_txt'];
	$nom_mdl[$dt_mdl_web['id']] = $dt_mdl_web['nom'];
}
$rq_crc_web = sel_whe("cat_crc.id,cat_crc.nom,cat_crc_txt.dt_web,cat_crc_txt.dt_txt","cat_crc LEFT JOIN cat_crc_txt ON cat_crc.id = cat_crc_txt.id_crc","web_uid != '' AND lgg=".$id_lgg);
while($dt_crc_web = ftc_ass($rq_crc_web)){
	$rq_crc_mdl = sel_quo("id_mdl","cat_crc_mdl","id_crc",$dt_crc_web['id']);
	while($dt_crc_mdl = ftc_ass($rq_crc_mdl)) {
		if(strtotime($web_mdl_date[$dt_crc_mdl['id_mdl']]) > strtotime($dt_crc_web['dt_web']) or strtotime($dt_crc_web['dt_txt']) > strtotime($dt_crc_web['dt_web'])) {$crc_web[$dt_crc_web['id']] = $dt_crc_web['nom'];}
	}
}
foreach($web_mdl_date as $id_mdl => $dt_web) {
	if(strtotime($txt_mdl_date[$id_mdl]) > strtotime($dt_web)) {$mdl_web[$id_mdl] = $nom_mdl[$id_mdl];}
	else{
		$rq_jrn_web = sel_quo("cat_mdl_jrn.id_jrn,dt_txt","cat_mdl_jrn INNER JOIN cat_jrn_txt ON cat_mdl_jrn.id_jrn = cat_jrn_txt.id_jrn",array("lgg","id_mdl"),array($id_lgg,$id_mdl));
		while($dt_jrn_web = ftc_ass($rq_jrn_web)) {
			if(strtotime($dt_jrn_web['dt_txt']) > strtotime($dt_web)) {
				$mdl_web[$id_mdl] = $nom_mdl[$id_mdl];
				break;
			}
			else{
				$id_jrn = $dt_jrn_web['id_jrn'];
				$rq_prs_web = sel_quo("cat_jrn_prs.id_prs,dt_txt","cat_jrn_prs INNER JOIN cat_prs_txt ON cat_jrn_prs.id_prs = cat_prs_txt.id_prs",array("lgg","id_jrn"),array($id_lgg,$id_jrn));
				while($dt_prs_web = ftc_ass($rq_prs_web)) {
					if(strtotime($dt_prs_web['dt_txt']) > strtotime($dt_web)) {
						$mdl_web[$id_mdl] = $nom_mdl[$id_mdl];
						break 2;
					}
				}
			}
		}
	}
}


//src_err_cat #1
$rq_mdl = sel_whe("cat_mdl_rgn.id,cat_mdl.id AS id_mdl,nom","cat_mdl_rgn RIGHT JOIN cat_mdl ON cat_mdl_rgn.id_mdl = cat_mdl.id","cat_mdl_rgn.id is null");
while($dt_mdl = ftc_ass($rq_mdl)){
	if(!empty($dt_mdl['id_mdl'])){$mdl[$dt_mdl['id_mdl']] = $dt_mdl['nom'];}
}
$rq_jrn = sel_whe("cat_jrn_vll.id,cat_jrn.id AS id_jrn,nom","cat_jrn_vll RIGHT JOIN cat_jrn ON cat_jrn_vll.id_jrn = cat_jrn.id","cat_jrn_vll.id is null");
while($dt_jrn = ftc_ass($rq_jrn)){
	if(!empty($dt_jrn['id_jrn'])){$jrn[$dt_jrn['id_jrn']] = $dt_jrn['nom'];}
}
$rq_prs = sel_whe("cat_prs_lieu.id,cat_prs.id AS id_prs,nom","cat_prs_lieu RIGHT JOIN cat_prs ON cat_prs_lieu.id_prs = cat_prs.id","cat_prs_lieu.id is null");
while($dt_prs = ftc_ass($rq_prs)){
	if(!empty($dt_prs['id_prs'])){$prs_lieu[$dt_prs['id_prs']] = $dt_prs['nom'];}
}
$rq_prs = sel_quo("id,nom","cat_prs","ctg","NULL");
while($dt_prs = ftc_ass($rq_prs)){
	if(!empty($dt_prs['id'])){$prs_ctg[$dt_prs['id']] = $dt_prs['nom'];}
}
$rq_srv = sel_quo("id,nom","cat_srv","id_vll","NULL");
while($dt_srv = ftc_ass($rq_srv)){
	if(!empty($dt_srv['id'])){$srv_vll[$dt_srv['id']] = $dt_srv['nom'];}
}
$rq_srv = sel_quo("id,nom","cat_srv","ctg","NULL");
while($dt_srv = ftc_ass($rq_srv)){
	if(!empty($dt_srv['id'])){$srv_ctg[$dt_srv['id']] = $dt_srv['nom'];}
}
$rq_hbr = sel_quo("id,nom","cat_hbr","id_vll","NULL");
while($dt_hbr = ftc_ass($rq_hbr)){
	if(!empty($dt_hbr['id'])){$hbr[$dt_hbr['id']] = $dt_hbr['nom'];}
}
$rq_clt = sel_quo("id,nom","cat_clt","id_ctg","NULL");
while($dt_clt = ftc_ass($rq_clt)){
	if(!empty($dt_clt['id'])){$clt[$dt_clt['id']] = $dt_clt['nom'];}
}
$rq_frn = sel_whe("cat_frn_vll.id,cat_frn.id AS id_frn,nom","cat_frn_vll RIGHT JOIN cat_frn ON cat_frn_vll.id_frn = cat_frn.id","cat_frn_vll.id is null");
while($dt_frn = ftc_ass($rq_frn)){
	if(!empty($dt_frn['id_frn'])){$frn_vll[$dt_frn['id_frn']] = $dt_frn['nom'];}
}
$rq_frn = sel_whe("cat_frn_ctg_srv.id,cat_frn.id AS id_frn,nom","cat_frn_ctg_srv RIGHT JOIN cat_frn ON cat_frn_ctg_srv.id_frn = cat_frn.id","cat_frn_ctg_srv.id is null");
while($dt_frn = ftc_ass($rq_frn)){
	if(!empty($dt_frn['id_frn'])){$frn_ctg[$dt_frn['id_frn']] = $dt_frn['nom'];}
}
$rq_pic = sel_quo("id,pic","cat_pic","id_rgn","NULL");
while($dt_pic = ftc_ass($rq_pic)){
	if(!empty($dt_pic['id'])){$pic[$dt_pic['id']] = $dt_pic['pic'];}
}
$rq_vll = sel_quo("id,nom","cat_vll","id_rgn","NULL");
while($dt_vll = ftc_ass($rq_vll)){
	if(!empty($dt_vll['id'])){$vll_rgn[$dt_vll['id']] = $dt_vll['nom'];}
}
$rq_vll = sel_quo("id,nom","cat_vll","id_pays","NULL");
while($dt_vll = ftc_ass($rq_vll)){
	if(!empty($dt_vll['id'])){$vll_pays[$dt_vll['id']] = $dt_vll['nom'];}
}
$rq_lieu = sel_quo("id,nom","cat_lieu","id_vll","NULL");
while($dt_lieu = ftc_ass($rq_lieu)){
	if(!empty($dt_lieu['id'])){$lieu[$dt_lieu['id']] = $dt_lieu['nom'];}
}
$rq_bnq = sel_quo("id,nom","cat_bnq","id_pays","NULL");
while($dt_bnq = ftc_ass($rq_bnq)){
	if(!empty($dt_bnq['id'])){$bnq[$dt_bnq['id']] = $dt_bnq['nom'];}
}
if(isset($mdl) or isset($jrn)or isset($prs_lieu) or isset($prs_ctg) or isset($srv_vll) or isset($srv_ctg) or isset($hbr) or isset($clt) or isset($frn_vll) or isset($frn_ctg) or isset($pic) or isset($vll_rgn) or isset($vll_pays) or isset($lieu) or isset($bnq)){$flg_err_cat = true;}
else{$flg_err_cat = false;}
$rq_hoy = sel_whe("dev_crc.id AS id_crc,dev_prs.id AS id_dev_prs,dev_hbr.nom,dev_hbr.id_cat,dev_hbr.dt_res,dev_crc.groupe","(((dev_hbr INNER JOIN dev_prs ON dev_hbr.id_prs = dev_prs.id) INNER JOIN dev_jrn ON dev_prs.id_jrn = dev_jrn.id) INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id) INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id","date>=CURDATE()-1 AND date<=CURDATE() AND cnf=1 AND dev_prs.res=1 AND (dev_hbr.res=2 OR dev_hbr.id_cat_chm=-2)","groupe,date,dev_mdl.ord,dev_jrn.ord,dev_prs.ord","DISTINCT");
$nb_hoy = num_rows($rq_hoy);

?>
<header>
	<ul>
		<li><a class="fwb" style="<?php if($cbl=='hom'){echo 'background-color: #7d6cc0';}?>" onclick="vue_acc('hom');"><?php echo $txt->hom->$id_lng; ?></a></li>
		<li><a class="fwb" style="<?php if($cbl=='tsk'){echo 'background-color: #7d6cc0';}?>" onclick="vue_acc('tsk');"><?php echo $txt->tsk->$id_lng; ?></a></li>
		<li><a class="fwb" style="<?php if($cbl=='res'){echo 'background-color: #7d6cc0';}?>" onclick="vue_acc('res');"><?php echo $txt->res->$id_lng; ?></a></li>
<?php
if($aut['fin']){
?>
		<li><a class="fwb" style="<?php if($cbl=='pay'){echo 'background-color: #7d6cc0';}?>" onclick="vue_acc('pay');"><?php echo $txt->pay->$id_lng; ?></a></li>
<?php
}
?>
		<li><a class="fwb" style="<?php if($cbl=='crm'){echo 'background-color: #7d6cc0';}?>" onclick="vue_acc('crm');"><?php echo $txt->crm->$id_lng; ?></a></li>
<!--
		<li><a class="fwb" style="<?php if($cbl=='cal'){echo 'background-color: #7d6cc0';}?>" onclick="vue_acc('cal');"><?php echo $txt->cal->$id_lng; ?></a></li>
		<li><a class="fwb" style="<?php if($cbl=='web'){echo 'background-color: #7d6cc0';}?>" onclick="vue_acc('web');"><?php echo $txt->web->$id_lng; ?></a></li>
-->
		<li><a class="fwb" style="<?php if($cbl=='cfg'){echo 'background-color: #7d6cc0';}?>" onclick="vue_acc('cfg');"><?php echo $txt->cfg->$id_lng; ?></a></li>
	</ul>
</header>
<div id="vue_<?php echo $cbl ?>" class="<?php echo $cbl; if($cbl=='hom'){echo ' tsk';} ?>"><?php include("vue_".$cbl.".php"); ?></div>
<input type="hidden" id="cbl" value="<?php echo $cbl ?>" />
