<?php
$nb_mdl = ftc_ass(select("COUNT(*) as total","cat_mdl_jrn","id_jrn",$id));
if($nb_mdl['total']!=0) {
?>
<div class="lslm fwb"><?php echo $txt->mdls->$id_lng; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	$rq_mdl = select("cat_mdl.id,nom,opt,info","cat_mdl INNER JOIN cat_mdl_jrn ON cat_mdl.id = cat_mdl_jrn.id_mdl","id_jrn",$id,"opt DESC,nom","DISTINCT");
	while($dt_mdl = ftc_ass($rq_mdl)) {
?>
	<tr>
		<td class="lnk_cat" style="<?php if(!$dt_mdl['opt']) {echo 'font-style: italic;';} ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=mdl&id=<?php echo $dt_mdl['id'] ?>');"><?php  echo stripslashes($dt_mdl['nom']); if(!empty($dt_mdl['info'])) {echo stripslashes(' ['.$dt_mdl['info'].']');} ?></td>
	</tr>
<?php
	}
?>
</table>
<?php
}
else{
?>
<div class="lslm fwb"><?php echo $txt->nomdl->$id_lng; ?></div>
<?php
}
?>
