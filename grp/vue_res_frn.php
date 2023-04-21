<?php
$rq = sel_whe(
	"dev_srv.id AS id_srv, dev_srv.id_frn,dev_srv.res,dev_srv.dt_res,dev_prs.id AS id_dev_prs,dev_jrn.opt AS opt_jrn,groupe,version,cnf,id_crc,grp_res.id AS id_grp_res",
	"(dev_srv INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc=dev_crc.id) ON dev_jrn.id_mdl=dev_mdl.id) ON dev_prs.id_jrn=dev_jrn.id) ON dev_srv.id_prs=dev_prs.id)
	LEFT JOIN grp_res ON grp_res.id_frn=dev_srv.id_frn AND grp_res.id_grp=dev_crc.id_grp",
	"(
		(
			dev_prs.res!=1 AND dev_srv.res<4  AND dev_srv.res!=0 AND dev_srv.res!=-1
		) OR (
			dev_prs.res=1 AND (
				dev_srv.res!=6 AND (
					dev_srv.res!=0 OR (
						cnf>0 AND dev_srv.opt=1
					)
				)
			)
		)
	) AND dev_crc.id_grp=".$id_grp,
	"cnf DESC,id_frn,dt_res DESC",
	"DISTINCT"
);
if(num_rows($rq)>0){
?>
<div class="tbl_prs">
	<div class="lsb fwb"><?php echo $txt->res->$id_lng.' '. $txt->frn->$id_lng ?></div>
	<table class="dsg w-100">
<?php
	$flg_nb_frn = $flg_nb_res = $flg_nb_dt_res = $flg_nb_crc = $flg_nb_grp_res = false;
	$nb_frn = $nb_res = $nb_dt_res = $nb_crc = $nb_grp_res =0;
	$dt_all = ftc_all($rq);
	foreach($dt_all as $i => $dt){
?>
	<tr>
<?php
		if(!$flg_nb_frn and !$nb_frn){
			$nb_frn = 1;
			while(array_key_exists($i+$nb_frn,$dt_all) and $dt_all[$i+$nb_frn]['id_frn'] == $dt['id_frn']){$nb_frn++;}
			$flg_nb_frn = true;
		}
		if($flg_nb_frn){
			if($dt['id_frn'] >0){
?>
			<td class="td_acc lnk" rowspan="<?php echo $nb_frn ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=frn&id=<?php echo $dt['id_frn'] ?>');"><?php echo $frn[$dt['id_frn']] ?></td>
<?php
			}
			else{
?>
			<td class="td_acc" rowspan="<?php echo $nb_frn ?>"><?php echo $txt->nodef->$id_lng ?></td>
<?php
			}
			$flg_nb_frn = false;
		}
		$nb_frn--;
		if(!$flg_nb_res and !$nb_res){
			$nb_res = 1;
			while(array_key_exists($i+$nb_res,$dt_all) and $dt_all[$i+$nb_res]['res'] == $dt['res']){$nb_res++;}
			$flg_nb_res = true;
		}
		if($flg_nb_res){
?>
			<td class="td_acc" rowspan="<?php echo $nb_res ?>" style="background-color: <?php echo $col_res_srv[$dt['res']] ?>;"><?php echo $res_srv[$id_lng] [$dt['res']] ?></td>
<?php
			$flg_nb_res = false;
		}
		$nb_res--;
		if(!$flg_nb_dt_res and !$nb_dt_res){
			$nb_dt_res = 1;
			while(array_key_exists($i+$nb_dt_res,$dt_all) and $dt_all[$i+$nb_dt_res]['dt_res'] == $dt['dt_res']){$nb_dt_res++;}
			$flg_nb_dt_res = true;
		}
		if($flg_nb_dt_res){
?>
			<td class="td_acc" rowspan="<?php echo $nb_dt_res ?>" style="<?php if($dt['dt_res']<date("Y-m-d",strtotime('-8 days')) and $dt['res']==1){echo 'color: red';} ?>"><?php if($dt['dt_res']!="0000-00-00"){echo date("d/m/Y",strtotime($dt['dt_res']));} ?></td>
<?php
			$flg_nb_dt_res = false;
		}
		$nb_dt_res--;
		if(!$flg_nb_crc and !$nb_crc){
			$nb_crc = 1;
			while(array_key_exists($i+$nb_crc,$dt_all) and $dt_all[$i+$nb_crc]['id_crc'] == $dt['id_crc']){$nb_crc++;}
			$flg_nb_crc = true;
		}
		if($flg_nb_crc){
?>
			<td class="td_acc lnk" rowspan="<?php echo $nb_crc ?>" onclick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt['id_crc'] ?>&scrl=<?php echo $dt['id_dev_prs'] ?>');"><?php echo $dt['groupe'].' V'.$dt['version']; ?></td>
<?php
			$flg_nb_crc = false;
		}
		$nb_crc--;
		if(!$flg_nb_grp_res and !$nb_grp_res){
			$nb_grp_res = 1;
			while(array_key_exists($i+$nb_grp_res,$dt_all) and $dt_all[$i+$nb_grp_res]['id_crc'] == $dt['id_crc'] and $dt_all[$i+$nb_grp_res]['id_frn'] == $dt['id_frn']){$nb_grp_res++;}
			$flg_nb_grp_res = true;
		}
		if($flg_nb_grp_res){
			if($dt['id_grp_res']>0){
				if($flg_sup[$dt['id_grp_res']] and !$dt['cnf']){
?>
			<td rowspan="<?php echo $nb_grp_res ?>" onclick="sup_res(<?php echo $dt['id_crc'].','.$dt['id_frn']; ?>,'frn');"><img src="../prm/img/sup.png" /></td>
<?php
				}
				else{$flg_sup[$dt['id_grp_res']]=true;}
			}
			$flg_nb_grp_res = false;
		}
		$nb_grp_res--;
?>
			<td><?php if(!$dt['opt_jrn']){echo 'ANNULER STATUT RESA DANS OPTION JOURNEE';} ?></td>
		</tr>
<?php
	}
?>
	</table>
</div>
<?php
}
