<?php
$nb_hbr = ftc_ass(select("COUNT(*) AS total","cat_hbr","id_frn",$id));
if($nb_hbr['total']>0) {
?>
<div class="dsg">
	<table>
		<tr>
			<td colspan="3" class=fwb><?php echo $txt->defhbr->$id_lng ?></td>
			<td><img src="../prm/img/vrl.png" /></td>
		</tr>
<?php
	$rq_hbr = select(
		"id,nom,id_vll,vrl,dt_max,id_frn",
		"cat_hbr LEFT JOIN (
			SELECT cat_hbr_chm.id_hbr AS id_hbr,MAX(dt_max) AS dt_max
			FROM cat_hbr_chm_trf_ssn
			INNER JOIN cat_hbr_chm_trf ON cat_hbr_chm_trf_ssn.id_trf = cat_hbr_chm_trf.id
			INNER JOIN cat_hbr_chm ON cat_hbr_chm_trf.id_chm = cat_hbr_chm.id
			 GROUP BY cat_hbr_chm.id_hbr
		) t ON cat_hbr.id = t.id_hbr",
		"id_frn",
		$id,
		"id_vll,nom",
		"DISTINCT"
	);
	while($dt_hbr = ftc_ass($rq_hbr)) {
?>
		<tr>
			<td><?php echo $vll[$id_vll] ?></td>
			<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt_hbr['id']?>');"><?php echo $dt_hbr['nom']; ?></td>
			<td style="<?php if($dt_hbr['dt_max'] < date ('Y-m-d', strtotime ("+1 months"))) {echo 'color: red';} ?>"><?php if($dt_hbr['dt_max']!='0000-00-00' and !empty($dt_hbr['dt_max'])) {echo date("d/m/Y", strtotime($dt_hbr['dt_max']));} ?></td>
<?php
		if($aut['adm_cat']) {
?>
			<td><input type="checkbox" autocomplete="off" <?php if($dt_hbr['vrl']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_hbr','vrl','1',<?php echo $dt_hbr['id'] ?>)}else{updateData('cat_hbr','vrl','0',<?php echo $dt_hbr['id'] ?>)};" /></td>
<?php
		}
?>
		</tr>
<?php
	}
?>
	</table>
</div>
<?php
}
else{
?>
<div class="dsg fwb"><?php echo $txt->nodefhbr->$id_lng ?></div>
<?php
}
?>
