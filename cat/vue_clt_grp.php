<?php
$rq_grp = select("grp_dev.*,min_crc.dt_dev","grp_dev LEFT JOIN (SELECT MIN(dt_dev) AS dt_dev,id_grp FROM dev_crc GROUP BY id_grp) min_crc ON grp_dev.id=min_crc.id_grp","id_clt",$id,"dt_dev DESC");
$nb_grp = num_rows($rq_grp);
if($nb_grp>0) {
?>
<div class="lmcf fwb"><?php echo $txt->grp->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_grp = ftc_ass($rq_grp)) {
		$nb_pax = ftc_ass(sel_quo("COUNT(*) as total","grp_pax",array("id_grp","prt"),array($dt_grp['id'],1)));
?>
	<tr>
		<td class="lnk" onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $dt_grp['id'] ?>');"><?php echo stripslashes($dt_grp['nomgrp']); if($nb_pax['total']>0){echo ' x'.$nb_pax['total'];} ?></td>
	</tr>
<?php
	}
?>
</table>
<?php
}
