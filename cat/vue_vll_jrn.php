<?php
$nb_jrn = ftc_ass(select("COUNT(*) as total","cat_jrn_vll","id_vll",$id));
if($nb_jrn['total']!=0) {
?>
<div class="lmcf fwb"><?php echo $txt->jrns->$id_lng.' :'; ?></div>
<table class="dsg w-100" style="min-width: 259px">
<?php
	$rq_jrn = select("cat_jrn.id,cat_jrn.nom,info","cat_jrn INNER JOIN cat_jrn_vll ON cat_jrn.id = cat_jrn_vll.id_jrn","id_vll",$id,"nom","DISTINCT");
	while($dt_jrn = ftc_ass($rq_jrn)) {
?>
	<tr>
		<td>
			<span class="wsn lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $dt_jrn['id'] ?>');"><?php  echo stripslashes($dt_jrn['nom']); ?></span>
<?php
 		if(!empty($dt_jrn['info'])) {echo stripslashes(' ['.$dt_jrn['info'].']');}
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
<div class="lmcf fwb"><?php echo $txt->nojrn->$id_lng; ?></div>
<?php
}
?>
