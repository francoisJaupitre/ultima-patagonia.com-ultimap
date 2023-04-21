<?php
$nb_prs = ftc_ass(select("COUNT(*) as total","cat_prs_hbr","id_hbr",$id));
if($nb_prs['total']!=0) {
?>
<div class="lmcf fwb"><?php echo $txt->prss->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	$rq_prs = select("cat_prs.id,nom,opt,info","cat_prs INNER JOIN cat_prs_hbr ON cat_prs.id = cat_prs_hbr.id_prs","id_hbr",$id,"opt DESC,nom","DISTINCT");
	while($dt_prs = ftc_ass($rq_prs)) {
?>
	<tr>
		<td class="lnk_cat" style="<?php if(!$dt_prs['opt']) {echo 'font-style: italic;';} ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_prs['id'] ?>');"><?php  echo stripslashes($dt_prs['nom']); if(!empty($dt_prs['info'])) {echo stripslashes(' ['.$dt_prs['info'].']');} ?></td>
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
