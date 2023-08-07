<?php
if(isset($_POST['id_dev_crc'])){
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$dt_crc = ftc_ass(select("id_cat,groupe,version,periode,nom,lgg","dev_crc INNER JOIN grp_dev ON dev_crc.id_grp = grp_dev.id","dev_crc.id",$id_dev_crc));
	$id_cat_crc = $dt_crc['id_cat'];
	$grp = $dt_crc['groupe'];
	$vrs = $dt_crc['version'];
	$prd = $dt_crc['periode'];
	$nom_crc = $dt_crc['nom'];
	$lgg_crc = $dt_crc['lgg'];
	$rq_bss_crc = select("id,base,vue", "dev_crc_bss","id_crc",$id_dev_crc,"vue DESC,base");
//	$nb_rmn_crc = ftc_ass(select("COUNT(*) as total","dev_crc_rmn","id_crc",$id_dev_crc));
}
?>
<td width="50%" class="lsb">
	<div style="float: left; padding-right: 5px;">
		<strong><?php echo $txt->dev->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="text" style="width: 150px; margin-right: 10px;" value="<?php echo stripslashes($grp) ?>" onChange="maj('dev_crc','groupe',this.value,<?php echo $id_dev_crc ?>)" />
		<strong><?php echo $txt->version->$id_lng; ?></strong>
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> id="crc_version<?php echo $id_dev_crc ?>" type="number" style="width: 25px; margin-right: 10px;" value="<?php echo $vrs ?>" onChange="maj('dev_crc','version',this.value,<?php echo $id_dev_crc ?>)" />
		<strong><?php echo $txt->periode->$id_lng; ?></strong>
	</div>
	<div style="display: block; overflow: hidden;">
		<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="text" class="w-100" value="<?php echo stripslashes(htmlspecialchars($prd)) ?>" onChange="maj('dev_crc','periode',this.value,<?php echo $id_dev_crc ?>)" />
	</div>
</td>
<td width="50%" class="dsg">
	<div style="float: right; padding-left: 5px; height: 22px; position: relative;" onclick="vue_cmd('vue_cmd_crc');">
<!--COMMANDES-->
		<img src="../prm/img/cmd.gif" />
		<div id="vue_cmd_crc" class="cmd wsn">
			<strong><?php echo $txt->dev->$id_lng; ?></strong>
			<ul>
				<li onclick="window.parent.opn_frm('fct/vue_trf.php?id=<?php echo $id_dev_crc; ?>');"><?php echo $txt->vuetrf->$id_lng; ?></li>
				<li onclick="window.parent.opn_frm('fct/vue_prg.php?cbl=dev&id=<?php echo $id_dev_crc; ?>&id_lgg=<?php echo $lgg_crc; ?>');"><?php echo $txt->vueprg->$id_lng; ?></li>
				<li onclick="window.parent.opn_frm('fct/vue_rbk.php?id=<?php echo $id_dev_crc; ?>&id_lgg=<?php echo $lgg_crc; ?>');"><?php echo $txt->vuerbk->$id_lng; ?></li>
<?php
if($aut['dev'] and $cnf<1){
?>
				<li onclick="prevUpdateRates('crc',<?php echo $id_dev_crc ?>);"><?php echo $txt->acttrf->$id_lng; ?></li>
<?php
	if($id_cat_crc == 0){
?>
				<li onclick="prevUpdateText('crc',<?php echo $id_dev_crc ?>);"><?php echo $txt->acttxt->$id_lng; ?></li>
<?php
	}
?>
				<li onclick="ajt_bss('crc',<?php echo $id_dev_crc ?>);"><?php echo $txt->ajtbss->$id_lng; ?></li>
<?php
	if(num_rows($rq_bss_crc)>0){
?>
				<li onclick="sup_bss('crc',<?php echo $id_dev_crc ?>);"><?php echo $txt->supbss->$id_lng; ?></li>
<?php
	}
}
?>
				<li id="newVersion"><?php echo $txt->vrs->$id_lng; ?></li>
<?php
if($aut['dev'] and $cnf < 1)
{
?>
				<li id="confirmation"><?php echo $txt->conf->$id_lng; ?></li>
<?php
}
if($aut['cat'] and $id_cat_crc == 0){
?>
				<li onclick="grd('crc',<?php echo $id_dev_crc ?>);"><?php echo $txt->grd->$id_lng; ?></li>
<?php
}
?>
			</ul>
			<br/>
			<strong><?php echo $txt->ress->$id_lng; ?></strong>
			<ul>
<?php
if($aut['res']){
?>
				<li onclick="mailHbr(0);"><?php echo $txt->mailshbr->$id_lng; ?></li>
				<li onclick="mailFrn(0);"><?php echo $txt->mailsfrn->$id_lng; ?></li>
<?php
}
?>
				<li onclick="window.open('../fct/docx_hbr.php?id=<?php echo $id_dev_crc;?>&hbr=0');"><?php echo $txt->lst_hbr->$id_lng; ?></li>
				<li onclick="window.open('../fct/docx_frn.php?id=<?php echo $id_dev_crc;?>&frn=0');"><?php echo $txt->lst_frn->$id_lng; ?></li>

			</ul>
			<br/>
			<strong><?php echo $txt->doc->$id_lng; ?></strong>
			<ul>
				<li onclick="window.open('../fct/docx_pax.php?id=<?php echo $id_dev_crc;?>&cbl=crc');"><?php echo $txt->lst_pax->$id_lng; ?></li>
				<li onclick="window.open('../fct/docx_srv.php?id=<?php echo $id_dev_crc;?>');"><?php echo $txt->lst_srv->$id_lng; ?></li>
<?php
if($cnf>0){
?>
				<li onclick="window.open('../fct/vch_hbr.php?id=<?php echo $id_dev_crc;?>&hbr=0');"><?php echo $txt->vchhbr->$id_lng; ?></li>
				<li onclick="window.open('../fct/vch_frn.php?id=<?php echo $id_dev_crc;?>&frn=0');"><?php echo $txt->vchfrn->$id_lng; ?></li>
<?php
}
?>
			</ul>
<?php
if($id_cat_crc != 0 and $aut['dev']){
?>
			<br/>
			<strong><?php echo $txt->cat->$id_lng; ?></strong>
			<ul>
				<li onclick="prevUpdateText('crc',<?php echo $id_dev_crc ?>);"><?php echo $txt->acttxt->$id_lng; ?></li>
				<li onclick="prevUpdateElem('crc',<?php echo $id_dev_crc ?>);"><?php echo $txt->actmdl->$id_lng; ?></li>
			</ul>
<?php
}
?>
			<br/>
			<strong><?php echo $txt->aff->$id_lng; ?></strong>
			<ul>
				<li onclick="mdf_vue('crc','mdl','true',0);"><?php echo $txt->maxmdl->$id_lng; ?></li>
				<li onclick="if(cls_rch('dt_crc')){mdf_vue('crc','mdl','false',0);}"><?php echo $txt->minmdl->$id_lng; ?></li>
				<li onclick="mdf_vue('crc','jrn','true',0);"><?php echo $txt->maxjrn->$id_lng; ?></li>
				<li onclick="if(cls_rch('dt_crc')){mdf_vue('crc','jrn','false',0);}"><?php echo $txt->minjrn->$id_lng; ?></li>
			</ul>
		</div>
	</div>
	<div style="display: block; overflow: hidden; text-align: center; font-weight: bold;">
<?php
if($id_cat_crc>0){
?>
			<div style="padding: 2px; border: 1px solid grey"><span class="lnk inf<?php echo $id_cat_crc ?>crc" onmouseover="vue_elem('inf',<?php echo $id_cat_crc ?>,'crc')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=crc&id=<?php echo $id_cat_crc ?>');"><?php echo stripslashes($nom_crc) ?></span></div>
<?php
}
else{
?>
			<input type="text" id="nom_crc<?php echo $id_dev_crc ?>" <?php if(!$aut['dev']){echo ' disabled';} ?> placeholder="<?php echo $txt->crcnom->$id_lng ?>" style="background-color: lightgrey; width: 100%;" value="<?php echo stripslashes($nom_crc) ?>" onchange="maj('dev_crc','nom',this.value,<?php echo $id_dev_crc ?>)" />
<?php
}
?>
	</div>
</td>
