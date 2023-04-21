<?php
$nb_prs = ftc_ass(select("COUNT(*) as total","cat_prs_lieu","id_lieu",$id));
if($nb_prs['total']!=0) {
?>
<div class="lmcf fwb"><?php echo $txt->prss->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	$rq_prs = select("cat_prs.id,cat_prs.nom,ctg,info","cat_prs INNER JOIN cat_prs_lieu ON cat_prs.id = cat_prs_lieu.id_prs","id_lieu",$id,"ctg,nom","DISTINCT");
	while($dt_prs = ftc_ass($rq_prs)) {
?>
	<tr>
		<td class="wsn">
<?php
		echo $ctg_prs[$id_lng][$dt_prs['ctg']];
?>
			<span class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_prs['id'] ?>');"><?php  echo stripslashes($dt_prs['nom']); ?></span>
<?php
 		if(!empty($dt_prs['info'])) {echo stripslashes(' ['.$dt_prs['info'].']');}
?>
		</td>
	</tr>
<?php
	}
?>
</table>
<?php
}
else{
?>
<div class="lmcf fwb"><?php echo $txt->noprs->$id_lng; ?></div>
<?php
}
?>
