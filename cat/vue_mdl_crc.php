<?php
$nb_crc = ftc_ass(select("COUNT(*) as total","cat_crc_mdl","id_mdl",$id));
if($nb_crc['total']!=0) {
?>
<div class="lsb fwb"><?php echo $txt->crcs->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	$rq_crc = select("cat_crc.id,nom,info","cat_crc INNER JOIN cat_crc_mdl ON cat_crc.id = cat_crc_mdl.id_crc","id_mdl",$id,"nom","DISTINCT");
	while($dt_crc = ftc_ass($rq_crc)) {
?>
	<tr>
		<td class="lnk_cat" onclick="window.parent.opn_frm('cat/ctr.php?cbl=crc&id=<?php echo $dt_crc['id'] ?>');"><?php  echo stripslashes($dt_crc['nom']); if(!empty($dt_crc['info'])) {echo stripslashes(' ['.$dt_crc['info'].']');} ?></td>
	</tr>
<?php
	}
?>
</table>
<?php
}
else{
?>
<div class="lslm fwb"><?php echo $txt->nocrc->$id_lng; ?></div>
<?php
}
?>
