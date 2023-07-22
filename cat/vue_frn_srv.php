<?php
$nb_srv = ftc_ass(select("COUNT(*) AS total","cat_srv_trf_bss INNER JOIN (cat_srv_trf INNER JOIN cat_srv ON cat_srv.id = cat_srv_trf.id_srv) ON cat_srv_trf_bss.id_trf = cat_srv_trf.id","id_frn",$id,"","DISTINCT"));
if($nb_srv['total']>0) {
?>
<div class="dsg">
	<table>
		<tr>
			<td colspan="4" class=fwb><?php echo $txt->defsrv->$id_lng ?></td>
			<td><img src="../prm/img/vrl.png" /></td>
		</tr>
<?php
	$rq_srv = select(
		"id,nom,info,id_vll,ctg,vrl,dt_max",
		"cat_srv LEFT JOIN (
			SELECT cat_srv_trf.id_srv AS id_srv,id_frn,MAX(dt_max) AS dt_max
			FROM cat_srv_trf_ssn
			INNER JOIN cat_srv_trf ON cat_srv_trf_ssn.id_trf=cat_srv_trf.id
			INNER JOIN cat_srv_trf_bss ON cat_srv_trf_bss.id_trf=cat_srv_trf.id
			WHERE id_frn = '".$id."'
			GROUP BY cat_srv_trf.id_srv
		) t ON cat_srv.id = t.id_srv",
		"id_frn",
		$id,
		"id_vll,ctg,nom",
		"DISTINCT"
	);
	while($dt_srv = ftc_ass($rq_srv)) {
?>
		<tr>
			<td><?php echo $vll[$dt_srv['id_vll']] ?></td>
			<td><?php echo $ctg_srv[$id_lng][$dt_srv['ctg']] ?></td>
			<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $dt_srv['id']?>');">
<?php
		echo $dt_srv['nom'];
		if($dt_srv['lgg']>0) {echo ' ['.$nom_lgg_lgg[$id_lng][$dt_srv['lgg']].']';}
		if(!empty($dt_srv['info'])) {echo ' ['.$dt_srv['info'].']';}
?>
			</td>
			<td style="<?php if($dt_srv['dt_max'] < date ('Y-m-d', strtotime ("+1 months"))) {echo 'color: red';} ?>"><?php if($dt_srv['dt_max']!='0000-00-00' and !empty($dt_srv['dt_max'])) {echo date("d/m/Y", strtotime($dt_srv['dt_max']));} ?></td>
<?php
		if($aut['adm_cat']) {
?>
			<td><input type="checkbox" autocomplete="off" <?php if($dt_srv['vrl']) {echo('checked="checked"');} ?> onclick="if(this.checked) {updateData('cat_srv','vrl','1',<?php echo $dt_srv['id'] ?>)}else{updateData('cat_srv','vrl','0',<?php echo $dt_srv['id'] ?>)};" /></td>
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
<div class="dsg fwb"><?php echo $txt->nodefsrv->$id_lng ?></div>
<?php
}
?>
