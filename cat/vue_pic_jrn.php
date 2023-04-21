<?php			
$nb_jrn = ftc_ass(select("COUNT(*) as total","cat_jrn_pic","id_pic",$id));
if($nb_jrn['total']!=0) {
?>
<strong><?php echo $txt->jrns->$id_lng.' :'; ?></strong>
<table>
<?php
	$rq_jrn = select("cat_jrn_pic.id,id_jrn,nom","cat_jrn_pic INNER JOIN cat_jrn ON  cat_jrn_pic.id_jrn = cat_jrn.id","id_pic",$id,"nom"); 
	while($dt_jrn = ftc_ass($rq_jrn)) {
?>
	<tr>
		<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $dt_jrn['id_jrn'] ?>');"><?php  echo stripslashes($dt_jrn['nom']);?></td>			
<?php
		if($aut['cat']) {
?>
		<td onclick="sup('jrn_pic',<?php echo $dt_jrn['id'] ?>,'pic',<?php echo $id ?>)"><img src="../prm/img/sup.png" /></td>
<?php
		}
?>
	</tr>
<?php
	}
?>
</table>
<?php
}
else{
?>
<strong><?php echo $txt->nojrn->$id_lng.' :'; ?></strong>
<?php
}
?>