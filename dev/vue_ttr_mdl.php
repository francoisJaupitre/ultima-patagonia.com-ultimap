<?php
if(isset($_POST['id_dev_mdl'])){
	$id_dev_mdl = $_POST['id_dev_mdl'];
	$vue_mdl = $_POST['vue'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/col.php");
	$dt_mdl = ftc_ass(select("id_cat,col,ord,nom,titre,trf","dev_mdl","id",$id_dev_mdl));
	$id_cat_mdl = $dt_mdl['id_cat'];
	$id_col_mdl = $dt_mdl['col'];
	$ord_mdl = $dt_mdl['ord'];
	$nom_mdl = $dt_mdl['nom'];
	$ttr_mdl = $dt_mdl['titre'];
	$trf_mdl = $dt_mdl['trf'];
	$nb_rmn_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl_rmn","id_mdl",$id_dev_mdl));
	if($trf_mdl){
		$rq_bss_mdl = select("id, base, vue", "dev_mdl_bss","id_mdl",$id_dev_mdl,"vue DESC,base");
	}
	$dt_crc = ftc_ass(select("id_cat","dev_crc","id",$id_dev_crc));
	$id_cat_crc = $dt_crc['id_cat'];
}
?>
<td onclick="scrollup();"><img src="../prm/img/up.png"></td>
<td class="lslm" style="color: #<?php echo $col[$id_col_mdl]; ?>">
	<div style="float: left;">
		<span class="vatdib">
			<input id="chk_mdl<?php echo $id_dev_mdl ?>" class="dev_img chk_img vue_mdl" type="checkbox" autocomplete="off" <?php if($vue_mdl==1){echo 'checked';} ?> onclick="if(cls_rch('dsc_mdl,dt_mdl',<?php echo $id_dev_mdl ?>)){chk_mdl(<?php echo $id_dev_mdl ?>);}" />
			<label for="chk_mdl<?php echo $id_dev_mdl ?>"><img src="../prm/img/maxi.png" /></label>
			<strong><?php echo $txt->mdl->$id_lng; ?></strong>
			<input <?php if(!$aut['dev'] or $cnf>0){echo ' disabled';} ?> type="number" style="color: #<?php echo $col[$id_col_mdl]; ?>; width: 30px; margin-right: 10px;" value="<?php echo $ord_mdl ?>" onchange="ord('mdl',this.value,<?php echo $id_dev_mdl.','.$id_dev_crc.','.$id_cat_crc ?>)" />

		</span>
		<span id="mdl_col<?php echo $id_dev_mdl ?>" style="display: inline-block"><?php include("vue_mdl_col.php"); ?></span>
	</div>
	<div style="margin-left: 250px; margin-right: 5px;" class="wsn">
		<input type="text" <?php if((!$aut['dev'] and $cnf<1) or (!$aut['res'] and $cnf>0)){echo ' disabled';} ?> id="mdl_titre<?php echo $id_dev_mdl ?>" style="color: #<?php echo $col[$id_col_mdl] ?>; width: 100%;" value="<?php echo stripslashes(htmlspecialchars($ttr_mdl)) ?>" onchange="maj('dev_mdl','titre',this.value,<?php echo $id_dev_mdl ?>)" />
	</div>
</td>
<td width="50%" class="dsg">
	<div style="float: right; height: 22px; position:relative;" onclick="vue_cmd('vue_cmd_mdl<?php echo $id_dev_mdl; ?>');">
<!--COMMANDES-->
		<img src="../prm/img/cmd.gif" />
		<div id="vue_cmd_mdl<?php echo $id_dev_mdl; ?>" class="cmd wsn">
			<strong><?php echo $txt->mdl->$id_lng; ?></strong>
			<ul>
<?php
if($aut['dev'] and $cnf<1){
?>
				<li onclick="act_trf('mdl',<?php echo $id_dev_mdl ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->acttrf->$id_lng; ?></li>
<?php
	if($id_cat_mdl == 0){
?>
				<li onclick="act_txt('mdl',<?php echo $id_dev_mdl ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->acttxt->$id_lng; ?></li>
<?php
	}
	if($trf_mdl){
?>
				<li onclick="ajt_bss('mdl',<?php echo $id_dev_mdl ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->ajtbss->$id_lng; ?></li>
<?php
		if(num_rows($rq_bss_mdl)>0){
?>
				<li onclick="sup_bss('mdl',<?php echo $id_dev_mdl ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->supbss->$id_lng; ?></li>
<?php
		}
	}
	elseif($ord_mdl > 1){
?>
				<li onclick="if(cls_rch('dt_crc')){trsf('mdl',<?php echo $id_dev_mdl.','.$id_dev_mdl ?>);}document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->trsfmdl->$id_lng; ?></li>
<?php
	}
}
if($aut['cat'] and $id_cat_mdl == 0){
?>
				<li onclick="grd('mdl',<?php echo $id_dev_mdl.','.$id_dev_crc ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->grd->$id_lng; ?></li>
<?php
}
if($aut['dev'] and $cnf<1){
?>
				<li onclick="sup('mdl',<?php echo $id_dev_mdl.','.$id_dev_crc.',0,'.$id_cat_mdl.','.$id_cat_crc ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->sup->$id_lng; ?></li>
<?php
}
if($nb_rmn_mdl['total'] > 0){
?>
				<li onclick="window.open('../fct/docx_pax.php?id=<?php echo $id_dev_mdl;?>&cbl=mdl');document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->lst_pax->$id_lng; ?></li>
<?php
}
?>
			</ul>
<?php
if($id_cat_mdl > 0 and $aut['dev']){
?>
			<br/>
			<strong><?php echo $txt->cat->$id_lng; ?></strong>
			<ul>
				<li onclick="act_txt('mdl',<?php echo $id_dev_mdl ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->acttxt->$id_lng; ?></li>
				<li onclick="act_elem('mdl',<?php echo $id_dev_mdl ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->actjrn->$id_lng; ?></li>
				<li onclick="sup_cat('mdl',<?php echo $id_dev_mdl ?> );document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->supcat->$id_lng; ?></li>
			</ul>
<?php
}
?>
			<br/>
			<strong><?php echo $txt->aff->$id_lng; ?></strong>
			<ul>
				<li onclick="mdf_vue('mdl','jrn','true',<?php echo $id_dev_mdl ?>);document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->maxjrn->$id_lng; ?></li>
				<li onclick="if(cls_rch('dt_mdl',<?php echo $id_dev_mdl ?>)){mdf_vue('mdl','jrn','false',<?php echo $id_dev_mdl ?>);}document.getElementById('vue_cmd_mdl<?php echo $id_dev_mdl; ?>').style.display='none';"><?php echo $txt->minjrn->$id_lng; ?></li>
			</ul>
		</div>
	</div>
	<div style="margin-right: 40px; text-align: center; font-weight: bold;">
<?php
if($id_cat_mdl>0){
	?>
		<div style="padding: 2px; border: 1px solid grey"><span class="lnk inf<?php echo $id_cat_mdl ?>mdl" onmouseover="vue_elem('inf',<?php echo $id_cat_mdl ?>,'mdl')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $id_cat_mdl ?>');"><?php echo stripslashes($nom_mdl) ?></span></div>
<?php
}
else{
?>
		<input type="text" id="nom_mdl<?php echo $id_dev_mdl ?>" <?php if(!$aut['dev']){echo ' disabled';} ?> placeholder="<?php echo $txt->mdlnom->$id_lng ?>" style="background-color: lightgrey; width: 100%; margin-right: 10px;" value="<?php echo stripslashes($nom_mdl) ?>" onchange="maj('dev_mdl','nom',this.value,<?php echo $id_dev_mdl ?>)" />
<?php
}
?>
	</div>
</td>
