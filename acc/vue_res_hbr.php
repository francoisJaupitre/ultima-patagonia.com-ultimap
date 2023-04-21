<h3><?php echo $txt->hbr->$id_lng ?></h3>
<?php
if($nb_hbr_cnf>0 or $nb_hbr_dev>0 or $nb_hbr_fin>0 or $nb_hbr_arc>0){
?>
<h4><?php echo $txt->lst->acc->resenv->$id_lng ?></h4>
<?php
	foreach($lst_dev as $lshb){
		if($lshb == 'cnf'){
			$nb_hbr = $nb_hbr_cnf;
			$rq_hbr = $rq_hbr_cnf;
		}
		elseif($lshb == 'dev'){
			$nb_hbr = $nb_hbr_dev;
			$rq_hbr = $rq_hbr_dev;
		}
		elseif($lshb == 'fin'){
			$nb_hbr = $nb_hbr_fin;
			$rq_hbr = $rq_hbr_fin;
		}
		elseif($lshb == 'arc'){
			$nb_hbr = $nb_hbr_arc;
			$rq_hbr = $rq_hbr_arc;
		}
		if($nb_hbr>0){
			$flg_nb_date = $flg_nb_hbr = $flg_nb_grp = false;
			$nb_hbr_date = $nb_hbr_hbr = $nb_hbr_grp = 0;
			$dt_all = ftc_all($rq_hbr);
?>
<h5>
<?php
			if($lshb == 'cnf'){echo $txt->cnf->$id_lng.' '. $txt->encours->$id_lng;}
			elseif($lshb == 'dev'){echo $txt->dev->$id_lng.' '. $txt->encours->$id_lng;}
			elseif($lshb == 'fin'){echo $txt->cnf->$id_lng.' '. $txt->archives->$id_lng;}
			elseif($lshb == 'arc'){echo $txt->dev->$id_lng.' '. $txt->archives->$id_lng;}
?>
</h5>
<table class="w-100">
<?php
			foreach($dt_all as $i => $dt){
?>
	<tr>
<?php
				if(!$flg_nb_date and $nb_hbr_date==0){
					$nb_hbr_date = 1;
					while(array_key_exists($i+$nb_hbr_date,$dt_all) and $dt_all[$i+$nb_hbr_date]['dt_res'] == $dt['dt_res']){$nb_hbr_date++;}
					$flg_nb_date = true;
				}
				if($flg_nb_date){
?>
		<td class="td_acc" rowspan="<?php echo $nb_hbr_date ?>" style="<?php if($dt['dt_res']<date("Y-m-d",strtotime('-8 day'))){echo 'color: red';} ?>"><?php if($dt['dt_res']!="0000-00-00"){echo date("d/m/Y",strtotime($dt['dt_res']));} ?></td>
<?php
				$flg_nb_date = false;
				}
				$nb_hbr_date--;
				if(!$flg_nb_hbr and $nb_hbr_hbr==0){
					$nb_hbr_hbr = 1;
					while(array_key_exists($i+$nb_hbr_hbr,$dt_all) and $dt_all[$i+$nb_hbr_hbr]['id_cat'] == $dt['id_cat']){$nb_hbr_hbr++;}
					$flg_nb_hbr = true;
				}
				if($flg_nb_hbr){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_hbr_hbr ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt['id_cat'] ?>');"><?php echo $dt['nom'] ?></td>
<?php
				$flg_nb_hbr = false;
				}
				$nb_hbr_hbr--;
				if(!$flg_nb_grp and $nb_hbr_grp==0){
					$nb_hbr_grp = 1;
					while(array_key_exists($i+$nb_hbr_grp,$dt_all) and $dt_all[$i+$nb_hbr_grp]['id_grp'] == $dt['id_grp']){$nb_hbr_grp++;}
					$flg_nb_grp = true;
				}
				if($flg_nb_grp){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_hbr_grp ?>" onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $dt['id_grp'] ?>');"><?php echo $dt['nomgrp'] ?></td>
<?php
					$flg_nb_grp = false;
				}
				$nb_hbr_grp--;
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
if($nb_hbr_cnf2>0 or $nb_hbr_dev2>0 or $nb_hbr_fin2>0 or $nb_hbr_arc2>0){
?>
<h4><?php echo $txt->lst->acc->resaut->$id_lng ?></h4>
<?php
	foreach($lst_dev as $lshb){
		if($lshb == 'cnf'){
			$nb_hbr = $nb_hbr_cnf2;
			$rq_hbr = $rq_hbr_cnf2;
		}
		elseif($lshb == 'dev'){
			$nb_hbr = $nb_hbr_dev2;
			$rq_hbr = $rq_hbr_dev2;
		}
		elseif($lshb == 'fin'){
			$nb_hbr = $nb_hbr_fin2;
			$rq_hbr = $rq_hbr_fin2;
		}
		elseif($lshb == 'arc'){
			$nb_hbr = $nb_hbr_arc2;
			$rq_hbr = $rq_hbr_arc2;
		}
		if($nb_hbr>0){
			$flg_nb_date = $flg_nb_hbr = $flg_nb_grp = false;
			$nb_hbr_date = $nb_hbr_hbr = $nb_hbr_grp = 0;
			$dt_all = ftc_all($rq_hbr);
?>
<h5>
<?php
			if($lshb == 'cnf'){echo $txt->cnf->$id_lng.' '. $txt->encours->$id_lng;}
			elseif($lshb == 'dev'){echo $txt->dev->$id_lng.' '. $txt->encours->$id_lng;}
			elseif($lshb == 'fin'){echo $txt->cnf->$id_lng.' '. $txt->archives->$id_lng;}
			elseif($lshb == 'arc'){echo $txt->dev->$id_lng.' '. $txt->archives->$id_lng;}
?>
</h5>
<table class="w-100">
<?php
			foreach($dt_all as $i => $dt){
?>
	<tr>
<?php
				if(!$flg_nb_date and $nb_hbr_date==0){
					$nb_hbr_date = 1;
					while(array_key_exists($i+$nb_hbr_date,$dt_all) and $dt_all[$i+$nb_hbr_date]['dt_res'] == $dt['dt_res']){$nb_hbr_date++;}
					$flg_nb_date = true;
				}
				if($flg_nb_date){
?>
		<td class="td_acc" rowspan="<?php echo $nb_hbr_date ?>" style="<?php if(($dt['res']!=2 or empty($dt['dt_pay'])) and $dt['dt_res']<date("Y-m-d",strtotime('-8 day'))){echo 'color: red';} ?>"><?php if($dt['dt_res']!="0000-00-00"){echo date("d/m/Y",strtotime($dt['dt_res']));} ?></td>
<?php
				$flg_nb_date = false;
				}
				$nb_hbr_date--;
				if(!$flg_nb_hbr and $nb_hbr_hbr==0){
					$nb_hbr_hbr = 1;
					while(array_key_exists($i+$nb_hbr_hbr,$dt_all) and $dt_all[$i+$nb_hbr_hbr]['id_cat'] == $dt['id_cat']){$nb_hbr_hbr++;}
					$flg_nb_hbr = true;
				}
				if($flg_nb_hbr){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_hbr_hbr ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt['id_cat'] ?>');"><?php echo $dt['nom'] ?></td>
<?php
				$flg_nb_hbr = false;
				}
				$nb_hbr_hbr--;
				if(!$flg_nb_grp and $nb_hbr_grp==0){
					$nb_hbr_grp = 1;
					while(array_key_exists($i+$nb_hbr_grp,$dt_all) and $dt_all[$i+$nb_hbr_grp]['id_grp'] == $dt['id_grp']){$nb_hbr_grp++;}
					$flg_nb_grp = true;
				}
				if($flg_nb_grp){
?>
		<td class="td_acc lnk" rowspan="<?php echo $nb_hbr_grp ?>" onclick="window.parent.opn_frm('grp/ctr.php?id=<?php echo $dt['id_grp'] ?>');"><?php echo $dt['nomgrp'] ?></td>
<?php
					$flg_nb_grp = false;
				}
				$nb_hbr_grp--;
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
