<?php
$rq_cnf = select("id_crc,groupe,version,dev_prs.opt,dev_prs.id AS id_dev_prs","dev_prs LEFT JOIN (SELECT MIN(date),id_crc,groupe,version,cnf,dev_jrn.id AS id_dev_jrn FROM dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id WHERE dev_prs.id_cat = ".$id." GROUP BY id_crc) t ON dev_prs.id_jrn = t.id_dev_jrn","cnf = 1 AND dev_prs.id_cat",$id,"opt DESC,groupe,version","DISTINCT");


$nb_cnf = num_rows($rq_cnf);
if($nb_cnf>0) {
?>
<div class="lmcf fwb"><?php echo $txt->cnf->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_cnf = ftc_ass($rq_cnf)) {
?>
	<tr>
		<td class="lnk_cat" style="<?php if(!$dt_cnf['opt']) {echo 'font-style: italic;';} ?>" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_cnf['id_crc'] ?>&scrl=<?php echo $dt_cnf['id_dev_prs'] ?>');"><?php echo stripslashes($dt_cnf['groupe'].' V'.$dt_cnf['version']);?></td>
	</tr>
<?php
	}
?>
</table>
<hr />
<?php
}
$rq_dev = select("id_crc,groupe,version,dev_prs.opt,dev_prs.id AS id_dev_prs","dev_prs LEFT JOIN (SELECT MIN(date),id_crc,groupe,version,cnf,dev_jrn.id AS id_dev_jrn FROM dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id WHERE dev_prs.id_cat = ".$id." GROUP BY id_crc) t ON dev_prs.id_jrn = t.id_dev_jrn","cnf = 0 AND dev_prs.id_cat",$id,"opt DESC,groupe,version","DISTINCT");
$nb_dev = num_rows($rq_dev);
if($nb_dev>0) {
?>
<div class="lmcf fwb"><?php echo $txt->dev->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_dev = ftc_ass($rq_dev)) {
?>
	<tr>
		<td class="lnk_cat" style="<?php if(!$dt_dev['opt']) {echo 'font-style: italic;';} ?>" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_dev['id_crc'] ?>&scrl=<?php echo $dt_dev['id_dev_prs'] ?>');"><?php echo stripslashes($dt_dev['groupe'].' V'.$dt_dev['version']);?></td>
	</tr>
<?php
	}
?>
</table>
<hr />
<?php
}
$rq_arc = select("id_crc,groupe,version,dev_prs.opt,dev_prs.id AS id_dev_prs","dev_prs LEFT JOIN (SELECT MIN(date),id_crc,groupe,version,cnf,dev_jrn.id AS id_dev_jrn FROM dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id WHERE dev_prs.id_cat = ".$id." GROUP BY id_crc) t ON dev_prs.id_jrn = t.id_dev_jrn","cnf = -1 AND dev_prs.id_cat",$id,"opt DESC,groupe,version","DISTINCT");
$nb_arc = num_rows($rq_arc);
if($nb_arc>0) {
?>
<div class="lmcf fwb"><?php echo $txt->arc->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_arc = ftc_ass($rq_arc)) {
?>
	<tr>
		<td class="lnk_cat" style="<?php if(!$dt_arc['opt']) {echo 'font-style: italic;';} ?>" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_arc['id_crc'] ?>&scrl=<?php echo $dt_arc['id_dev_prs'] ?>');"><?php echo stripslashes($dt_arc['groupe'].' V'.$dt_arc['version']);?></td>
	</tr>
<?php
	}
?>
</table>
<hr />
<?php
}
$rq_fin = select("id_crc,groupe,version,dev_prs.opt,dev_prs.id AS id_dev_prs","dev_prs LEFT JOIN (SELECT MIN(date),id_crc,groupe,version,cnf,dev_jrn.id AS id_dev_jrn FROM dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_prs.id_jrn = dev_jrn.id WHERE dev_prs.id_cat = ".$id." GROUP BY id_crc) t ON dev_prs.id_jrn = t.id_dev_jrn","cnf = 2 AND dev_prs.id_cat",$id,"opt DESC,groupe,version","DISTINCT");
$nb_fin = num_rows($rq_fin);
if($nb_fin>0) {
?>
<div class="lmcf fwb"><?php echo $txt->fin->$id_lng.' :'; ?></div>
<table style=" width:100%;" class="dsg">
<?php
	while($dt_fin = ftc_ass($rq_fin)) {
?>
	<tr>
		<td class="lnk_cat" style="<?php if(!$dt_fin['opt']) {echo 'font-style: italic;';} ?>" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_fin['id_crc'] ?>&scrl=<?php echo $dt_fin['id_dev_prs'] ?>');"><?php echo stripslashes($dt_fin['groupe'].' V'.$dt_fin['version']);?></td>
	</tr>
<?php
	}
?>
</table>
<hr />
<?php
}
if($nb_cnf==0 and $nb_dev==0 and $nb_fin==0 and $nb_arc==0) {
?>
<div class="lmcf fwb"><?php echo $txt->nodev->$id_lng; ?></div>
<?php
}
?>
