<?php
$nb_hbr = ftc_ass(select("COUNT(*) as total","cat_prs_hbr","id_prs",$id));
if($nb_hbr['total']!=0) {
?>
<div class="tht fwb"><?php echo $txt->hbr->$id_lng.' :'; ?></div>
<table class="dsg">
	<tr class="fwb">
		<td class="td_cat"><?php echo $txt->vll->$id_lng; ?></td>
		<td class="td_cat"><?php echo $txt->rgm->$id_lng; ?></td>
		<td class="td_cat"><?php echo $txt->hbr->$id_lng; ?></td>
		<td class="td_cat"><?php echo $txt->chm->$id_lng; ?></td>
	</tr>
<?php
	$rq_hbr = select("cat_prs_hbr.id as id_prs_hbr,id_hbr,id_chm,opt,cat_prs_hbr.id_vll,rgm,nom","cat_prs_hbr LEFT JOIN cat_hbr ON cat_hbr.id = cat_prs_hbr.id_hbr","id_prs",$id,"opt DESC, nom");
	while($dt_hbr = ftc_ass($rq_hbr)) {
		$id_hbr = $dt_hbr['id_hbr'];
		$id_prs_hbr = $dt_hbr['id_prs_hbr'];
		$id_chm = $dt_hbr['id_chm'];
		$id_vll = $dt_hbr['id_vll'];
?>
	<tr>
		<td class="lnk_cat">
			<span onclick="window.parent.opn_frm('cat/ctr.php?cbl=vll&id=<?php echo $id_vll ?>');"><?php echo $vll[$id_vll]; ?></span>
		</td>
		<td class="td_cat"><?php echo $rgm[$id_lng][$dt_hbr['rgm']]; ?></td>
		<td class="<?php if($id_hbr!=-1) {echo 'lnk_cat';} else{echo 'td_cat';} ?>">
			<span <?php if($id_hbr!=-1) { ?> onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $id_hbr ?>');" <?php ;} ?>>
<?php
		if($id_hbr!=-1) {echo $dt_hbr['nom'];}
		else{echo $txt->nodef->$id_lng;}
?>
			</span>
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
		<td class="td_cat"><input <?php if(!$aut['cat'] or $dt_hbr['opt']) {echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($dt_hbr['opt']) {echo('checked="checked"');} ?> onclick="maj('cat_prs_hbr','opt','1',<?php echo $id_prs_hbr.','.$id; ?>);" /></td>
<?php
		if($aut['cat']) {
?>
		<td>
			<span class="dib" onclick="sup_hbr(<?php echo $id_prs_hbr ?>)"><img src="../prm/img/sup.png" /></span>
		</td>
<?php
		}
?>
	</tr>
<?php
	}
?>
	</table>
	<hr/>
<?php
}
?>
