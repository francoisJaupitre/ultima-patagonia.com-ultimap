<h4><?php echo date("d/m/Y"); ?></h4>
<h3><?php echo $txt->ope->$id_lng; ?></h3>
<table class="w-100">
<?php
$flg_nb_hbr = $flg_nb_crc = false;
$nb_hbr = $nb_crc = 0;
$dt_all = ftc_all($rq_hoy);
foreach($dt_all as $i => $dt_hoy){
?>
	<tr>
<?php
	if(!$flg_nb_crc and $nb_crc==0){
		$nb_crc = 1;
		while(array_key_exists($i+$nb_crc,$dt_all) and $dt_all[$i+$nb_crc]['id_crc'] == $dt_hoy['id_crc']){$nb_crc++;}
		$flg_nb_crc = true;
	}
	if($flg_nb_crc){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_crc ?>" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_hoy['id_crc'] ?>&scrl=<?php echo $dt_hoy['id_dev_prs'] ?>');"><?php echo $dt_hoy['groupe'] ?></td>
<?php
		$flg_nb_crc = false;
	}
	$nb_crc--;
	if(!$flg_nb_hbr and $nb_hbr==0){
		$nb_hbr = 1;
		while(array_key_exists($i+$nb_hbr,$dt_all) and $dt_all[$i+$nb_hbr]['id_cat'] == $dt_hoy['id_cat']){$nb_hbr++;}
		$flg_nb_hbr = true;
	}
	if($flg_nb_hbr){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_hbr ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt_hoy['id_cat'] ?>');"><?php echo $dt_hoy['nom'] ?></td>
<?php
		$flg_nb_hbr = false;
	}
	$nb_hbr--;
?>
	</tr>
<?php
}
?>
</table>
