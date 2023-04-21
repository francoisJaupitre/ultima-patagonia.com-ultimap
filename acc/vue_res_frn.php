<h3><?php echo $txt->frn->$id_lng ?></h3>
<?php
if($nb_frn_cnf>0 or $nb_frn_dev>0 or $nb_frn_fin>0 or $nb_frn_arc>0){
?>
<h4><?php echo $txt->lst->acc->resenv->$id_lng ?></h4>
<?php
	foreach($lst_dev as $lsfr){
		if($lsfr == 'cnf'){
			$nb_frn = $nb_frn_cnf;
			$rq_frn = $rq_frn_cnf;
		}
		elseif($lsfr == 'dev'){
			$nb_frn = $nb_frn_dev;
			$rq_frn = $rq_frn_dev;
		}
		elseif($lsfr == 'fin'){
			$nb_frn = $nb_frn_fin;
			$rq_frn = $rq_frn_fin;
		}
		elseif($lsfr == 'arc'){
			$nb_frn = $nb_frn_arc;
			$rq_frn = $rq_frn_arc;
		}
		if($nb_frn>0){
			$flg_nb_date = $flg_nb_frn = $flg_nb_grp = false;
			$nb_frn_date = $nb_frn_frn = $nb_frn_grp = 0;
			$dt_all = ftc_all($rq_frn);
?>
<h5>
<?php
			if($lsfr == 'cnf'){echo $txt->cnf->$id_lng.' '. $txt->encours->$id_lng;}
			elseif($lsfr == 'dev'){echo $txt->dev->$id_lng.' '. $txt->encours->$id_lng;}
			elseif($lsfr == 'fin'){echo $txt->cnf->$id_lng.' '. $txt->archives->$id_lng;}
			elseif($lsfr == 'arc'){echo $txt->dev->$id_lng.' '. $txt->archives->$id_lng;}
?>
</h5>
<table class="w-100">
<?php
			foreach($dt_all as $i => $dt){
?>
	<tr>
<?php
				if(!$flg_nb_date and $nb_frn_date==0){
					$nb_frn_date = 1;
					while(array_key_exists($i+$nb_frn_date,$dt_all) and $dt_all[$i+$nb_frn_date]['dt_res'] == $dt['dt_res']){$nb_frn_date++;}
					$flg_nb_date = true;
				}
				if($flg_nb_date){
?>
		<td class="td_acc" rowspan="<?php echo $nb_frn_date ?>" style="<?php if($dt['dt_res']<date("Y-m-d",strtotime('-8 day'))){echo 'color: red';} ?>"><?php if($dt['dt_res']!="0000-00-00"){echo date("d/m/Y",strtotime($dt['dt_res']));} ?></td>
<?php
				$flg_nb_date = false;
				}
				$nb_frn_date--;
				if(!$flg_nb_frn and $nb_frn_frn==0){
					$nb_frn_frn = 1;
					while(array_key_exists($i+$nb_frn_frn,$dt_all) and $dt_all[$i+$nb_frn_frn]['id_frn'] == $dt['id_frn']){$nb_frn_frn++;}
					$flg_nb_frn = true;
				}
				if($flg_nb_frn){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_frn_frn ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $dt['id_frn'] ?>');"><?php echo $frn[$dt['id_frn']] ?></td>
<?php
				$flg_nb_frn = false;
				}
				$nb_frn_frn--;
				if(!$flg_nb_grp and $nb_frn_grp==0){
					$nb_frn_grp = 1;
					while(array_key_exists($i+$nb_frn_grp,$dt_all) and $dt_all[$i+$nb_frn_grp]['id_grp'] == $dt['id_grp']){$nb_frn_grp++;}
					$flg_nb_grp = true;
				}
				if($flg_nb_grp){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_frn_grp ?>" onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $dt['id_grp'] ?>');"><?php echo $dt['nomgrp'] ?></td>
<?php
					$flg_nb_grp = false;
				}
				$nb_frn_grp--;
?>
	</tr>
<?php
			}
?>
</table>
<?php
		}
	}
}
if($nb_frn_cnf2>0 or $nb_frn_dev2>0 or $nb_frn_fin2>0 or $nb_frn_arc2>0){
?>
<h4><?php echo $txt->lst->acc->resaut->$id_lng ?></h4>
<?php
	foreach($lst_dev as $lsfr){
		if($lsfr == 'cnf'){
			$nb_frn = $nb_frn_cnf2;
			$rq_frn = $rq_frn_cnf2;
		}
		elseif($lsfr == 'dev'){
			$nb_frn = $nb_frn_dev2;
			$rq_frn = $rq_frn_dev2;
		}
		elseif($lsfr == 'fin'){
			$nb_frn = $nb_frn_fin2;
			$rq_frn = $rq_frn_fin2;
		}
		elseif($lsfr == 'arc'){
			$nb_frn = $nb_frn_arc2;
			$rq_frn = $rq_frn_arc2;
		}
		if($nb_frn>0){
			$flg_nb_date = $flg_nb_frn = $flg_nb_grp = false;
			$nb_frn_date = $nb_frn_frn = $nb_frn_grp = 0;
			$dt_all = ftc_all($rq_frn);
?>
<h5>
<?php
			if($lsfr == 'cnf'){echo $txt->cnf->$id_lng.' '. $txt->encours->$id_lng;}
			elseif($lsfr == 'dev'){echo $txt->dev->$id_lng.' '. $txt->encours->$id_lng;}
			elseif($lsfr == 'fin'){echo $txt->cnf->$id_lng.' '. $txt->archives->$id_lng;}
			elseif($lsfr == 'arc'){echo $txt->dev->$id_lng.' '. $txt->archives->$id_lng;}
?>
</h5>
<table class="w-100">
<?php
			foreach($dt_all as $i => $dt){
?>
	<tr>
<?php
				if(!$flg_nb_date and $nb_frn_date==0){
					$nb_frn_date = 1;
					while(array_key_exists($i+$nb_frn_date,$dt_all) and $dt_all[$i+$nb_frn_date]['dt_res'] == $dt['dt_res']){$nb_frn_date++;}
					$flg_nb_date = true;
				}
				if($flg_nb_date){
?>
		<td class="td_acc" rowspan="<?php echo $nb_frn_date ?>" style="<?php if(($dt['res']!=2 or empty($dt['dt_pay'])) and $dt['dt_res']<date("Y-m-d",strtotime('-8 day'))){echo 'color: red';} ?>"><?php if($dt['dt_res']!="0000-00-00"){echo date("d/m/Y",strtotime($dt['dt_res']));} ?></td>
<?php
				$flg_nb_date = false;
				}
				$nb_frn_date--;
				if(!$flg_nb_frn and $nb_frn_frn==0){
					$nb_frn_frn = 1;
					while(array_key_exists($i+$nb_frn_frn,$dt_all) and $dt_all[$i+$nb_frn_frn]['id_frn'] == $dt['id_frn']){$nb_frn_frn++;}
					$flg_nb_frn = true;
				}
				if($flg_nb_frn){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_frn_frn ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $dt['id_frn'] ?>');"><?php echo $frn[$dt['id_frn']] ?></td>
<?php
				$flg_nb_frn = false;
				}
				$nb_frn_frn--;
				if(!$flg_nb_grp and $nb_frn_grp==0){
					$nb_frn_grp = 1;
					while(array_key_exists($i+$nb_frn_grp,$dt_all) and $dt_all[$i+$nb_frn_grp]['id_grp'] == $dt['id_grp']){$nb_frn_grp++;}
					$flg_nb_grp = true;
				}
				if($flg_nb_grp){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_frn_grp ?>" onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $dt['id_grp'] ?>');"><?php echo $dt['nomgrp'] ?></td>
<?php
					$flg_nb_grp = false;
				}
				$nb_frn_grp--;
				if(!empty($dt['dt_pay']) and $dt['dt_pay']!="0000-00-00"){
?>
		<td class="td_acc" style="<?php if($dt['dt_pay']<date("Y-m-d")){echo 'color: red';} ?>"><?php echo date("d/m/Y",strtotime($dt['dt_pay'])); ?></td>
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
	}
}
?>
