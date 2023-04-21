<?php
$nb_srv = ftc_ass(select("COUNT(*) as total","cat_prs_srv","id_prs",$id_prs));
if($nb_srv['total']!=0) {
?>
<div class="lmcf fwb"><?php echo $txt->srvs->$id_lng.' :'; ?></div>
<table class="w-100 <?php if($opt_jrn) {echo 'dsg';} else{echo 'tht';} ?>">
<?php
	$rq_srv = select("cat_srv.id as id_srv,id_vll,ctg,nom,info,lgg,cat_prs_srv.opt as opt","cat_prs_srv INNER JOIN cat_srv ON cat_srv.id = cat_prs_srv.id_srv","id_prs",$id_prs,"nom");
	while ($dt_srv = ftc_ass($rq_srv)) {
		$id_vll = $dt_srv['id_vll'];
		$inf = ' ';
		if ($dt_srv['lgg'] >0) {$inf .= '['.$nom_lgg_lgg[$id_lng][$dt_srv['lgg']].']';}
		if (!empty($dt_srv['info'])) {$inf .= '['.$dt_srv['info'].']';}
?>
	<tr>
		<td width="30%" class="td_cat"><?php echo $vll[$id_vll]; ?></td>
		<td width="30%" class="td_cat"><?php echo $ctg_srv[$id_lng][$dt_srv['ctg']]; ?></td>
		<td width="30%" class="lnk_cat" >
			<span class="dib" onClick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $dt_srv['id_srv'] ?>');"><?php echo stripslashes($dt_srv['nom'].$inf); ?></span>
		</td>
		<td><input type="checkbox" disabled <?php if ($dt_srv['opt']) {echo('checked="checked"');} ?>/></td>
	</tr>
<?php
	}
?>
</table>
<?php
}
$nb_hbr = ftc_ass(select("COUNT(*) as total","cat_prs_hbr","id_prs",$id_prs));
if($nb_hbr['total']!=0) {
?>
<div class="lmcf fwb"><?php echo $txt->hbrs->$id_lng.' :'; ?></div>
<table class="w-100 <?php if($opt_jrn) {echo 'dsg';} else{echo 'tht';} ?>">
	<tr class="fwb">
		<td class="td_cat"><?php echo $txt->vll->$id_lng; ?></td>
		<td class="td_cat"><?php echo $txt->rgm->$id_lng; ?></td>
		<td class="td_cat"><?php echo $txt->hbr->$id_lng; ?></td>
		<td class="td_cat"><?php echo $txt->chm->$id_lng; ?></td>
	</tr>
<?php
	$rq_prs_hbr = select("*","cat_prs_hbr","id_prs",$id_prs);
	while($dt_prs_hbr = ftc_ass($rq_prs_hbr)) {
		$id_prs_hbr = $dt_prs_hbr['id'];
		$id_hbr = $dt_prs_hbr['id_hbr'];
		$id_chm = $dt_prs_hbr['id_chm'];
		$id_vll = $dt_prs_hbr['id_vll'];
		$id_rgm = $dt_prs_hbr['rgm'];
?>
	<tr>
		<td class="td_cat"><?php echo $vll[$id_vll]; ?></td>
		<td class="td_cat"><?php echo $rgm[$id_lng][$id_rgm]; ?></td>
		<td class="<?php if($id_hbr!=-1) {echo 'lnk_cat';} else{echo 'td_cat';} ?>" <?php if($id_hbr!=-1) { ?> onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $id_hbr ?>');" <?php ;} ?>>
<?php
		if($id_hbr!=-1) {
			$rq_hbr=select("nom","cat_hbr","id",$id_hbr);
			$dt_hbr=ftc_ass($rq_hbr);
			echo $dt_hbr['nom'];}
		else{echo $txt->nodef->$id_lng;}
?>
		</td>
		<td class="td_cat">
<?php
		if($id_chm>0) {
			$rq_chm=select("nom","cat_hbr_chm","id",$id_chm);
			$dt_chm=ftc_ass($rq_chm);
			echo $dt_chm['nom'];
		}
		else{echo $txt->nodef->$id_lng;}
?>
		</td>
	</tr>
<?php
	}
	unset($id_vll);
?>
</table>
<?php
}
if($nb_srv['total']==0 and $nb_hbr['total']==0) {
?>
<div class="tht fwb"><?php echo $txt->nosrv->$id_lng; ?></div>
<?php
}
?>
