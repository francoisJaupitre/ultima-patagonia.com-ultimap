<h4><?php echo $txt->pay->$id_lng.'<br />'. $txt->hbr->$id_lng ?></h4>
<table class="w-100">
<?php
	foreach($dt_all as $i => $dt){
?>
	<tr>
<?php
		if(!$flg_nb_date and $nb_date==0){
			$nb_date = 1;
			while(array_key_exists($i+$nb_date,$dt_all) and $dt_all[$i+$nb_date]['date'] == $dt['date']){$nb_date++;}
			$flg_nb_date = true;
		}
		if($flg_nb_date){
?>
		<td class="td_acc" rowspan="<?php echo $nb_date ?>" style="<?php if($dt['date'] < date("Y-m-d")){echo 'color: red';} elseif($dt['date'] == date("Y-m-d")){echo 'background-color: red';} ?>"><?php if($dt['date']!="0000-00-00"){echo date("d/m/Y",strtotime($dt['date']));} ?></td>
<?php
			$flg_nb_date = false;
		}
		$nb_date--;
		if(!$flg_nb_hbr and $nb_hbr==0){
			$nb_hbr = 1;
			while(array_key_exists($i+$nb_hbr,$dt_all) and $dt_all[$i+$nb_hbr]['id_cat'] == $dt['id_cat']){$nb_hbr++;}
			$flg_nb_hbr = true;
		}
		if($flg_nb_hbr){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_hbr ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt['id_cat'] ?>');"><?php echo $dt['nom'] ?></td>
<?php
			$flg_nb_hbr = false;
		}
		$nb_hbr--;
?>
		<td class="td_acc"><?php echo $dt['liq'].' '.$prm_crr_nom[$dt['crr']] ?></td>
<?php
		if(!$flg_nb_crc and $nb_crc==0){
			$nb_crc = 1;
			while(array_key_exists($i+$nb_crc,$dt_all) and $dt_all[$i+$nb_crc]['id_crc'] == $dt['id_crc']){$nb_crc++;}
			$flg_nb_crc = true;
		}
		if($flg_nb_crc){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_crc ?>" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt['id_crc'] ?>&scrl=<?php echo $dt['id_dev_prs'] ?>');"><?php echo $dt['groupe'] ?></td>
<?php
			$flg_nb_crc = false;
		}
		$nb_crc--;
		if($aut['adm_fin'] and $dt['fin']==0){
?>
		<td id="ajt_ecr_hbr<?php echo $dt['id_hbr_pay'] ?>" onclick="ajt_ecr('hbr',<?php echo $dt['id_hbr_pay'] ?>);"><img src="../prm/img/crr.png" /></td>
<?php
		}
		elseif($aut['adm_fin'] and $dt['fin']==-1){
?>
		<td id="ajt_ecr_hbr<?php echo $dt['id_hbr_pay'] ?>" onclick="maj('dev_hbr_pay','fin','1',<?php echo $dt['id_hbr_pay'] ?>);"><img src="../prm/img/exc.png" /></td>
<?php
		}
?>
	</tr>
<?php
	}
?>
</table>
