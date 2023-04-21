<?php
$nb_jrn = ftc_ass(select("COUNT(*) as total","cat_jrn_prs","id_prs",$id));
if($nb_jrn['total']!=0) {
?>
<div class="lcrl fwb"><?php echo $txt->jrns->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	$rq_jrn = select("cat_jrn.id,nom,opt,info","cat_jrn INNER JOIN cat_jrn_prs ON cat_jrn.id = cat_jrn_prs.id_jrn","id_prs",$id,"opt DESC,nom","DISTINCT");
	while($dt_jrn = ftc_ass($rq_jrn)) {
?>
	<tr>
		<td class="lnk_cat" style="<?php if(!$dt_jrn['opt']) {echo 'font-style: italic;';} ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $dt_jrn['id'] ?>');"><?php  echo stripslashes($dt_jrn['nom']); if(!empty($dt_jrn['info'])) {echo stripslashes(' ['.$dt_jrn['info'].']');} ?></td>
	</tr>
<?php
	}
?>
</table>
<?php
}
else{
?>
<div class="lcrl fwb"><?php echo $txt->nojrn->$id_lng; ?></div>
<?php
}
?>
