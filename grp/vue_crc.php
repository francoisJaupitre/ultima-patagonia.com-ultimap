<?php
$rq_cnf = sel_quo("id,groupe,version,dt_cnf","dev_crc",array("cnf","id_grp"),array("1",$id_grp),"groupe,version","DISTINCT");
$nb_cnf = num_rows($rq_cnf);
if($nb_cnf>0){
?>
<div class="lmcf fwb wsn"><?php echo $txt->cnf->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_cnf = ftc_ass($rq_cnf)){
?>
	<tr id="shd_crc<?php echo $dt_cnf['id']; ?>" class="shd_crc">
		<td class="lnk" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_cnf['id'] ?>');"><?php echo stripslashes($dt_cnf['groupe'].' V'.$dt_cnf['version'].' ('.date("d/m/Y",strtotime($dt_cnf['dt_cnf'])).')');?></td>
	</tr>
<?php
	}
?>
</table>
<hr />
<?php
}
$rq_dev = sel_quo("id,groupe,version,dt_dev","dev_crc",array("cnf","id_grp"),array("0",$id_grp),"groupe,version","DISTINCT");
$nb_dev = num_rows($rq_dev);
if($nb_dev>0){
?>
<div class="lmcf fwb wsn"><?php echo $txt->dev->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_dev = ftc_ass($rq_dev)){
?>
	<tr id="shd_crc<?php echo $dt_dev['id']; ?>" class="shd_crc">
		<td class="lnk" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_dev['id'] ?>');"><?php echo stripslashes($dt_dev['groupe'].' V'.$dt_dev['version'].' ('.date("d/m/Y",strtotime($dt_dev['dt_dev'])).')');?></td>
	</tr>
<?php
	}
?>
</table>
<hr />
<?php
}
$rq_fin = sel_quo("id,groupe,version,dt_cnf","dev_crc",array("cnf","id_grp"),array("2",$id_grp),"groupe,version","DISTINCT");
$nb_fin = num_rows($rq_fin);
if($nb_fin>0){
?>
<div class="lmcf fwb wsn"><?php echo $txt->fin->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_fin = ftc_ass($rq_fin)){
?>
	<tr id="shd_crc<?php echo $dt_fin['id']; ?>" class="shd_crc">
		<td class="lnk" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_fin['id'] ?>');"><?php echo stripslashes($dt_fin['groupe'].' V'.$dt_fin['version'].' ('.date("d/m/Y",strtotime($dt_fin['dt_cnf'])).')');?></td>
	</tr>
<?php
	}
?>
</table>
<hr />
<?php
}
$rq_arc = sel_quo("id,groupe,version,dt_dev","dev_crc",array("cnf","id_grp"),array("-1",$id_grp),"groupe,version","DISTINCT");
$nb_arc = num_rows($rq_arc);
if($nb_arc>0){
?>
<div class="lmcf fwb wsn"><?php echo $txt->arc->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_arc = ftc_ass($rq_arc)){
?>
	<tr id="shd_crc<?php echo $dt_arc['id']; ?>" class="shd_crc">
		<td class="lnk" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_arc['id'] ?>');"><?php echo stripslashes($dt_arc['groupe'].' V'.$dt_arc['version'].' ('.date("d/m/Y",strtotime($dt_arc['dt_dev'])).')');?></td>
	</tr>
<?php
	}
?>
</table>
<hr />
<?php
}
if($nb_cnf==0 and $nb_dev==0 and $nb_fin==0 and $nb_arc==0){
?>
<div class="lmcf fwb wsn"><?php echo $txt->nodev->$id_lng; ?></div>
<?php
}
?>
