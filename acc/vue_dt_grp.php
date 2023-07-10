<?php
$limit = 50;
$i = 0;
if(isset($_POST['rang'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/clt.php");
	$cbl = $_POST['cbl'];
	unset($_POST['cbl']);
	$id_clt = $_POST['id_clt'];
	$rang = $_POST['rang'];
}
$var = "grp_dev.*,min_crc.dt_dev,cnt_crc.nb_crc";
$tab = "grp_dev LEFT JOIN (SELECT MIN(dt_dev) AS dt_dev,id_grp FROM dev_crc GROUP BY id_grp) min_crc ON grp_dev.id=min_crc.id_grp
LEFT JOIN (SELECT COUNT(id) AS nb_crc,id_grp FROM dev_crc GROUP BY id_grp) cnt_crc ON grp_dev.id=cnt_crc.id_grp
LEFT JOIN (SELECT DISTINCT(id_grp) FROM dev_crc WHERE cnf>0) t ON grp_dev.id=t.id_grp LEFT JOIN (SELECT DISTINCT(id_grp) FROM fin_bdg) t2 ON grp_dev.id=t2.id_grp";
if($cbl == 'gr0'){$col = "(t.id_grp IS NULL AND t2.id_grp IS NULL)";}
elseif($cbl == 'gr1'){$col = "(t.id_grp IS NOT NULL OR t2.id_grp IS NOT NULL)";}
if($id_clt==0){
	$col .= " AND 1";
	$val = "1";
}
else{
	$col .= " AND id_clt";
	$val = $id_clt;
}
$ord = "dt_dev DESC LIMIT ";
if($rang==1){$ord .= $limit;}
else{$ord .= (($limit*($rang-1))).",".$limit;}
$rq_grp = sel_quo($var,$tab,$col,$val,$ord,"DISTINCT");
if(num_rows($rq_grp)==0 and isset($_POST['rang'])){echo '0';}
while($dt_grp = ftc_ass($rq_grp)){
	$i++;
	$id_grp = $dt_grp['id'];
	$nb_pax = ftc_ass(sel_quo("COUNT(*) as total","grp_pax",array("id_grp","prt"),array($id_grp,1)));
	if(!isset($_POST['rang'])){
?>
<tr id="grp<?php echo $id_grp ?>" class="tr">
<?php
	}
	else{echo "grp".$id_grp.'$$';}
?>
	<td class='tbl lnk' onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $id_grp ?>');"><?php echo $dt_grp['nomgrp']; if($nb_pax['total']>0){echo ' x'.$nb_pax['total'];} ?></td>
	<td class='tbl'><?php if($dt_grp['nb_crc']){echo $dt_grp['nb_crc'];} else{echo '-';} ?></td>
	<td class='tbl lnk' onclick="window.parent.opn_frm('cat/ctr.php?cbl=clt&id=<?php echo $dt_grp['id_clt'] ?>');"><?php echo stripslashes($clt[$dt_grp['id_clt']]) ?></td>
<?php
	if(!$dt_grp['nb_crc'] and $cbl == 'gr0'){
?>
	<td class="delete-elem2" id="<?php echo $id_grp ?>">
		<img src="../prm/img/sup.png" />
	</td>
	<td><input type="checkbox" class="chk" id="<?php echo $id_grp ?>" /></td>
<?php
	}
	if(!isset($_POST['rang'])){
?>
</tr>
<?php
	}
	elseif($i<$limit){echo '|';}
}
?>
