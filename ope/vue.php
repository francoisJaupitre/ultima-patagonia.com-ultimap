<?
if(isset($_POST['cnf'])){
	$txt = simplexml_load_file('txt.xml');
	$cnf = $_POST['cnf'];
	$id_grp = $_POST['id_grp'];
	$dt_jrn = $_POST['dt_jrn'];
	$id_prs = $_POST['id_prs'];
	$id_vll = $_POST['id_vll'];
	$id_ctg = $_POST['id_ctg'];
	$id_srv = $_POST['id_srv'];
	$id_hbr = $_POST['id_hbr'];
	$id_frn = $_POST['id_frn'];
	$id_res = $_POST['id_res'];
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ctg_srv.php");
	include("../prm/ctg_prs.php");
	include("../prm/res_prs.php");
	include("../prm/res_srv.php");
	include("../cfg/crr.php");
	include("../cfg/frn.php");
	include("../cfg/vll.php");
	$dt = explode('/',$dt_jrn);
	if(!isset($dt[2])){$y = date("Y");}
	else{$y=$dt[2];}
	if(checkdate($dt[1],$dt[0],$y)){$dt_jrn = date("Y-m-d",strtotime($y.'-'.$dt[1].'-'.$dt[0]));}
	//else{$dt_jrn = date("Y-m-d");}
	elseif($cnf==1){
		$min = ftc_num(sel_quo("MIN(date)","dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id","cnf","1"));
		$dt_jrn = $min[0];
	}
	elseif($cnf==2){
		$max = ftc_num(sel_quo("MAX(date)","dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id","cnf","2"));
		$dt_jrn = $max[0];
	}
}
else{
	//$dt_jrn = date("Y-m-d");
	if($cnf==1){
		$min = ftc_num(sel_quo("MIN(date)","dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id","cnf","1"));
		$dt_jrn = $min[0];
	}
	elseif($cnf==2){
		$max = ftc_num(sel_quo("MAX(date)","dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id","cnf","2"));
		$dt_jrn = $max[0];
	}
	$id_grp = 0;
	$id_prs = 0;
	$id_vll = 0;
	$id_srv = 0;
	$id_hbr = 0;
	$id_frn = -1;
	$id_res = -3;
}
//empezaria vue_res.php
$rang = 1;
?>
<input id="cnf" type="hidden" value="<?php echo $cnf ?>" />
<input id="dt_jrn" type="text" autocomplete="off" placeholder="<?php echo $txt->phdate->$id_lng; ?>" class="w74" value="<?php if(!empty($dt_jrn)){echo date("d/m/Y", strtotime($dt_jrn));} ?>" onchange="vue()">
<input type="button" value="HOY" onclick="document.getElementById('dt_jrn').value='<?php echo date("d/m/Y"); ?>';vue();" />
<select id="sel_grp" style="width: 100px;" onchange="vue()">
	<option value="0"><?php echo $txt->grp->$id_lng; ?></option>
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp","cnf",$cnf,"nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
?>
	<option <?php if($dt_grp['id']==$id_grp){echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo stripslashes($dt_grp['nomgrp']) ?></option>

<?php
}
?>
</select>
<select id="sel_prs" style="width: 120px;" onchange="vue();">
	<option value="0"><?php echo $txt->prs->$id_lng; ?></option>
<?php
$rq_prs = sel_quo("dev_prs.id_cat,cat_prs.nom","cat_prs INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON cat_prs.id = dev_prs.id_cat","cnf",$cnf,"nom","DISTINCT");
while($dt_prs = ftc_ass($rq_prs)){
?>
	<option <?php if($dt_prs['id_cat']==$id_prs){echo ' selected';} ?> value="<?php echo $dt_prs['id_cat'] ?>"><?php echo stripslashes($dt_prs['nom']) ?></option>
<?php
}
?>
</select>
<select id="sel_vll" style="width: 95px;" onchange="vue();">
	<option value="0"><?php echo $txt->vll->$id_lng; ?></option>
<?php
foreach($vll as $vll_id => $nom){
?>
	<option <?php if($vll_id==$id_vll){echo ' selected';} ?> value="<?php echo $vll_id ?>"><?php echo $nom ?></option>
<?php
}
?>
</select>
<select id="sel_ctg" style="width: 100px;" onchange="vue();">
	<option value="0"><?php echo $txt->ctg->$id_lng; ?></option>
<?php
foreach($ctg_srv[$id_lng] as $ctg_id => $nom){
?>
	<option <?php if($ctg_id==$id_ctg){echo ' selected';} ?> value="<?php echo $ctg_id ?>"><?php echo $nom ?></option>
<?php
}
?>
</select>
<select id="sel_srv" style="width: 120px;" onchange="vue();">
	<option value="0"><?php echo $txt->srv->$id_lng; ?></option>
<?php
$rq_srv = sel_quo("dev_srv.id_cat,cat_srv.nom","cat_srv INNER JOIN (dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id) ON cat_srv.id = dev_srv.id_cat","cnf",$cnf,"nom","DISTINCT");
while($dt_srv = ftc_ass($rq_srv)){
?>
	<option <?php if($dt_srv['id_cat']==$id_srv){echo ' selected';} ?> value="<?php echo $dt_srv['id_cat'] ?>"><?php echo stripslashes($dt_srv['nom']) ?></option>
<?php
}
?>
</select>
<select id="sel_hbr" style="width: 120px;" onchange="vue();">
	<option value="0"><?php echo $txt->hbr->$id_lng; ?></option>
<?php
$rq_hbr = sel_quo("dev_hbr.id_cat,cat_hbr.nom","cat_hbr INNER JOIN (dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_hbr.id_prs = dev_prs.id) ON cat_hbr.id = dev_hbr.id_cat","cnf",$cnf,"nom","DISTINCT");
while($dt_hbr = ftc_ass($rq_hbr)){
?>
	<option <?php if($dt_hbr['id_cat']==$id_hbr){echo ' selected';} ?> value="<?php echo $dt_hbr['id_cat'] ?>"><?php echo stripslashes($dt_hbr['nom']) ?></option>
<?php
}
?>
</select>
<select id="sel_frn" style="width: 120px;" onchange="vue();">
	<option value="-1"><?php echo $txt->frn->$id_lng; ?></option>
	<option <?php if($id_frn=='0'){echo ' selected';} ?> value="0"><?php echo $txt->nodef->$id_lng; ?></option>
<?php
$rq_frn = sel_quo("dev_srv.id_frn,cat_frn.nom","cat_frn INNER JOIN (dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id) ON dev_srv.id_prs = dev_prs.id) ON cat_frn.id = dev_srv.id_frn","cnf",$cnf,"nom","DISTINCT");
while($dt_frn = ftc_ass($rq_frn)){
?>
	<option <?php if($dt_frn['id_frn']==$id_frn){echo ' selected';} ?> value="<?php echo $dt_frn['id_frn'] ?>"><?php echo stripslashes($dt_frn['nom']) ?></option>
<?php
}
?>
</select>
<select id="sel_res" style="width: 115px;" onchange="vue();">
	<option value="-3"><?php echo $txt->res->$id_lng; ?></option>
<?php
foreach($res_srv[$id_lng] as $res_id => $nom){
?>
	<option <?php if($res_id==$id_res){echo ' selected';} ?> value="<?php echo $res_id ?>"><?php echo $nom ?></option>
<?php
}
?>
</select>
<hr/>
<table id="tab_res" class="w-100">
	<tr style="font-weight: bold">
		<td class="tbl">DATE</td>
		<td class="tbl"><?php echo $txt->grp->$id_lng; ?></td>
		<td class="tbl"><?php echo $txt->prs->$id_lng; ?></td>
		<td class="tbl"><?php echo $txt->vll->$id_lng; ?></td>
		<td class="tbl"><?php echo $txt->ctg->$id_lng; ?></td>
		<td class="tbl"><?php echo $txt->srv->$id_lng.' / '.$txt->hbr->$id_lng; ?></td>
		<td class="tbl"><?php echo $txt->frn->$id_lng.' / '.$txt->chm->$id_lng; ; ?></td>
		<td class="tbl"><?php echo $txt->res->$id_lng; ?></td>
	</tr>
<?php
include("vue_dt_res.php");
?>
</table>
