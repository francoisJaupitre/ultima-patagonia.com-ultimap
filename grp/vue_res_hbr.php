<?php
$rq = sel_whe(
	"dev_hbr.id AS id_dev_hbr,dev_hbr.id_cat AS id_cat_hbr,id_cat_chm,dev_hbr.nom,nom_chm,dev_hbr.res,dev_hbr.dt_res,dev_prs.id AS id_dev_prs,dev_jrn.opt AS opt_jrn,groupe,version,cnf,id_crc,grp_res.id AS id_grp_res",
	"(dev_hbr INNER JOIN (dev_prs INNER JOIN (dev_jrn INNER JOIN (dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc=dev_crc.id) ON dev_jrn.id_mdl=dev_mdl.id) ON dev_prs.id_jrn=dev_jrn.id) ON dev_hbr.id_prs=dev_prs.id)
	LEFT JOIN grp_res ON grp_res.id_hbr=dev_hbr.id_cat AND grp_res.id_grp=dev_crc.id_grp",
	"(
		(
			dev_prs.res!=1 AND dev_hbr.res<4  AND dev_hbr.res!=0 AND dev_hbr.res!=-1
		) OR (
			dev_hbr.id_cat>0 AND dev_hbr.id_cat_chm!=-2 AND dev_hbr.res!=6 AND (
				dev_prs.res=1 AND (
					(
						cnf<1 AND dev_hbr.res!=0 AND (
							dev_hbr.opt=1 OR (
								dev_hbr.opt!=1 AND dev_hbr.res!=-1
							)
						)
					) OR (
						cnf>0 AND (
							dev_hbr.sel=1 OR (
								dev_hbr.res!=0 AND dev_hbr.res!=-1
							)
						)
					)
				)
			)
		)
	) AND dev_crc.id_grp=".$id_grp,
	"cnf DESC,nom,dt_res DESC",
	"DISTINCT"
);
if(num_rows($rq)>0){
?>
<div class="tbl_prs">
	<div class="lsb fwb "><?php echo $txt->res->$id_lng.' '. $txt->hbr->$id_lng ?></div>
	<table class="dsg w-100">
<?php
	$flg_nb_hbr = $flg_nb_chm = $flg_nb_res = $flg_nb_dt_res = $flg_nb_crc = $flg_nb_grp_res = false;
	$nb_hbr = $nb_chm = $nb_res = $nb_dt_res = $nb_crc = $nb_grp_res = 0;
	$dt_all = ftc_all($rq);
	foreach($dt_all as $i => $dt){
?>
		<tr>
<?php
		if(!$flg_nb_hbr and !$nb_hbr){
			$nb_hbr = 1;
			while(array_key_exists($i+$nb_hbr,$dt_all) and $dt_all[$i+$nb_hbr]['id_cat_hbr'] == $dt['id_cat_hbr']){$nb_hbr++;}
			$flg_nb_hbr = true;
		}
		if($flg_nb_hbr){
?>
			<td class="td_acc lnk" rowspan="<?php echo $nb_hbr ?>" onclick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt['id_cat_hbr'] ?>');"><?php echo $dt['nom'] ?></td>
<?php
			$flg_nb_hbr = false;
		}
		$nb_hbr--;
		if(!$flg_nb_chm and !$nb_chm){
			$nb_chm = 1;
			while(array_key_exists($i+$nb_chm,$dt_all) and $dt_all[$i+$nb_chm]['id_cat_chm'] == $dt['id_cat_chm']){$nb_chm++;}
			$flg_nb_chm = true;
		}
		if($flg_nb_chm){
?>
			<td class="td_acc" rowspan="<?php echo $nb_chm ?>"><?php echo $dt['nom_chm'] ?></td>
<?php
			$flg_nb_chm = false;
		}
		$nb_chm--;
		if(!$flg_nb_res and !$nb_res){
			$nb_res = 1;
			while(array_key_exists($i+$nb_res,$dt_all) and $dt_all[$i+$nb_res]['res'] == $dt['res']){$nb_res++;}
			$flg_nb_res = true;
		}
		if($flg_nb_res){
?>
			<td class="td_acc" rowspan="<?php echo $nb_res ?>" style="background-color: <?php echo $col_res_srv[$dt['res']] ?>;"><?php echo $res_srv[$id_lng][$dt['res']] ?></td>
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
			while(array_key_exists($i+$nb_grp_res,$dt_all) and $dt_all[$i+$nb_grp_res]['id_crc'] == $dt['id_crc'] and $dt_all[$i+$nb_grp_res]['id_cat_hbr'] == $dt['id_cat_hbr']){$nb_grp_res++;}
			$flg_nb_grp_res = true;
		}
		if($flg_nb_grp_res){
			if($dt['id_grp_res']>0){//utile?
				if($flg_sup[$dt['id_grp_res']] and !$dt['cnf']){
?>
			<td rowspan="<?php echo $nb_grp_res ?>" onclick="sup_res(<?php echo $dt['id_crc'].','.$dt['id_cat_hbr']; ?>,'hbr');"><img src="../prm/img/sup.png" /></td>
<?php
				}
				else{$flg_sup[$dt['id_grp_res']]=true;}
			}//utile?
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
