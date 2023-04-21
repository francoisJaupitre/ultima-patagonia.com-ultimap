<?php
$limit = 30;
$j=0;
if(isset($_POST['rang'])){
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ctg_srv.php");
	include("../prm/ctg_prs.php");
	include("../prm/res_prs.php");
	include("../prm/res_srv.php");
	include("../cfg/crr.php");
	include("../cfg/frn.php");
	include("../cfg/vll.php");
	$rang = $_POST['rang'];
	$cnf = $_POST['cnf'];
	$id_grp = $_POST['id_grp'];
	$dt_jrn = $_POST['dt_jrn'];
	$id_prs = $_POST['id_prs'];
	$id_vll = $_POST['id_vll'];
	$id_ctg = $_POST['id_ctg'];
	$id_srv = $_POST['id_srv'];
	$id_hbr = $_POST['id_hbr'];
	$id_frn = $_POST['id_frn'];
	$id_res = $_POST['id_res'];
	$_POST = array();
	$dt = explode('/',$dt_jrn);
	if(isset($dt[2])){$dt_jrn = $dt[2].'-'.$dt[1].'-'.$dt[0];}
}
$var = "nomgrp, dev_crc.id AS id_crc, groupe, date, dev_prs.id AS id_dev_prs, dev_prs.id_cat AS id_cat_prs, dev_prs.nom AS nom_prs, dev_prs.ctg AS id_prs_ctg, dev_prs.heure AS hre_prs, dev_prs.info AS inf_prs";
$tab = "grp_dev INNER JOIN (dev_crc INNER JOIN (dev_mdl INNER JOIN (dev_jrn INNER JOIN ";
if($id_vll>0 or $id_ctg>0 or $id_srv>0 or $id_hbr>0 or $id_frn>-1 or $id_res>-3){
	if(($id_frn==-1 and $id_srv==0 and $id_ctg<2) and ($id_ctg==1 or $id_hbr>0)){
		$tab .= "(dev_prs INNER JOIN (SELECT DISTINCT id_prs FROM dev_hbr WHERE sel=1";
		if($id_vll>0){$tab .= " AND id_vll=".$id_vll;}
		if($id_ctg==1){$tab .= " AND id>0";}
		if($id_hbr>0){$tab .= " AND id_cat=".$id_hbr;}
		if($id_res>-3){$tab .= " AND res=".$id_res." AND id_cat>-2 AND id_cat_chm>-2";}
	}
	else{
		$tab .= "(dev_prs INNER JOIN (SELECT DISTINCT id_prs FROM dev_srv WHERE opt=1";
		if($id_vll>0){$tab .= " AND id_vll=".$id_vll;}
		if($id_ctg>1){$tab .= " AND ctg=".$id_ctg;}
		if($id_srv>0){$tab .= " AND id_cat=".$id_srv;}
		if($id_frn>-1){$tab .= " AND id_frn=".$id_frn;}
		if($id_res>-3){$tab .= " AND res=".$id_res;}
		if($id_frn==-1 and $id_srv==0 and $id_ctg<2){
			$tab .= " UNION ALL SELECT id_prs FROM dev_hbr WHERE sel=1";
			if($id_vll>0){$tab .= " AND id_vll=".$id_vll;}
			if($id_ctg==1){$tab .= " AND id>0";}
			if($id_hbr>0){$tab .= " AND id_cat=".$id_hbr;}
			if($id_res>-3){$tab .= " AND res=".$id_res." AND id_cat>-2 AND id_cat_chm>-2";}
		}
	}
	$tab .= ") t2 ON t2.id_prs = dev_prs.id)";
}
else{$tab .= "dev_prs";}
$tab .= " ON dev_prs.id_jrn = dev_jrn.id) ON dev_jrn.id_mdl = dev_mdl.id) ON dev_mdl.id_crc=dev_crc.id) ON dev_crc.id_grp=grp_dev.id";
$ord = "date";
if($cnf>1){$ord .= " DESC";}
$ord .= ",nomgrp,groupe,dev_mdl.ord";
if($cnf>1){$ord .= " DESC";}
$ord .= ",dev_prs.ord";
if($cnf>1){$ord .= " DESC";}
$ord .= " LIMIT ";
if($rang==1){$ord .= $limit;}
else{$ord .= (($limit*($rang-1))).",".$limit;}
$col = "dev_prs.res=1 AND ";
if($id_grp>0){$col .= "grp_dev.id=".$id_grp." AND ";}
if($id_prs>0){$col .= "dev_prs.id_cat=".$id_prs." AND ";}
if($cnf==1){$col .= "date >= '".$dt_jrn."'";}
else{$col .= "date <= '".$dt_jrn."'";}
$col .= " AND cnf";
$val = $cnf;

$nb_row = 0;
//echo 'SELECT '.$var.' FROM '.$tab.' WHERE '.$col.' = '.$val.' ORDER BY '.$ord;
$rq_res = sel_quo($var,$tab,$col,$val,$ord);
$dt_all = ftc_all($rq_res);
foreach($dt_all as $i => $dt_res){
	$tab = "(
		SELECT t2.*,dev_srv.id AS id_dev_srv, dev_srv.id_cat AS id_cat_srv, dev_srv.nom AS nom_srv, dev_srv.ctg as id_srv_ctg, dev_srv.id_frn, dev_srv.res AS id_srv_res, dev_srv.rva AS id_srv_rva, dev_hbr.id AS id_dev_hbr, dev_hbr.id_cat AS id_cat_hbr, dev_hbr.id_cat_chm, dev_hbr.nom AS nom_hbr, dev_hbr.nom_chm, dev_hbr.res AS id_hbr_res, dev_hbr.rva AS id_hbr_rva, dev_hbr.rgm AS id_rgm
		FROM (
			(SELECT DISTINCT id_vll,id_prs FROM dev_srv WHERE opt=1 UNION ALL SELECT id_vll,id_prs FROM dev_hbr WHERE sel=1) t2
			LEFT JOIN dev_srv ON dev_srv.id_prs = t2.id_prs AND dev_srv.id_vll = t2.id_vll AND dev_srv.opt=1 AND dev_srv.res != 6
			LEFT JOIN dev_hbr ON dev_hbr.id_prs = t2.id_prs AND dev_hbr.id_vll = t2.id_vll AND dev_hbr.sel=1 AND dev_hbr.res != 6
		)
	) t ";
	$col = "t.id_prs";
	$rq_res2 = sel_quo("*",$tab,$col,$dt_res['id_dev_prs'],"id_dev_srv,id_dev_hbr");
	$nb_row = num_rows($rq_res2);
	$flg_nb_row = true;
	$flg_nb_vll = $flg_nb_srv_ctg = $flg_nb_hbr_ctg = $flg_nb_srv = $flg_nb_hbr = $flg_nb_frn = $flg_nb_chm = $flg_nb_srv_cmd = false;
	$nb_vll = $nb_srv_ctg = $nb_hbr_ctg = $nb_srv = $nb_hbr = $nb_frn = $nb_chm = $nb_srv_cmd = 0;
	$dt_all2 = ftc_all($rq_res2);
	foreach($dt_all2 as $i2 => $dt_res2){
		$j++;
		if($rang==1){
?>
<tr id="res<?php echo $dt_res['id_dev_prs'] ?>">
<?php
		}
		else{echo "res".$dt_res['id_dev_prs'].'$$';}
//empezaria include;
		$flg_err = $flg_old = false;
		if($dt_res['date']<date("Y-m-d")){$flg_old=true;}
		if($flg_nb_row){
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" <?php if($nb_row>1){echo "rowspan='".$nb_row."'";} ?>><?php echo date("d/m/Y", strtotime($dt_res['date'])); ?></td>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" <?php if($nb_row>1){echo "rowspan='".$nb_row."'";} ?>><span class="dib lnk" onClick="window.parent.opn_frm('dev/ctr.php?id=<?php echo $dt_res['id_crc'] ?>&scrl=<?php echo $dt_res['id_dev_prs'] ?>')"><?php echo stripslashes($dt_res['groupe'].'<br/>('.$dt_res['nomgrp'].')') ?></span></td>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" <?php if($nb_row>1){echo "rowspan='".$nb_row."'";} ?>>
<?php
			echo $ctg_prs[$id_lng][$dt_res['id_prs_ctg']];
			if($dt_res['id_cat_prs']>0){
?>
		<span class="dib" onClick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $dt_res['id_cat_prs'] ?>')" style="color: #0000C3"><?php echo stripslashes($dt_res['nom_prs']) ?></span>
<?php
			}
			else{echo ' '.stripslashes($dt_res['nom_prs']);}
?>
		<div style="float: left; padding-right: 5px;"><input id="prs_heure<?php echo $dt_res['id_dev_prs'] ?>" type="time" <?php if(!$aut['res']){echo ' disabled';} ?> value="<?php if(!is_null($dt_res['hre_prs'])){echo date("H:i", strtotime($dt_res['hre_prs']));} ?>" onblur="maj('dev_prs','heure',this.value,<?php echo $dt_res['id_dev_prs'] ?>);" /></div>
<?php
			if($dt_res['id_prs_ctg'] !=1 and $dt_res['id_prs_ctg'] !=9  and $dt_res['id_prs_ctg'] !=11 and $dt_res['id_prs_ctg'] !=12 and $dt_res['id_prs_ctg'] !=17){
?>
			<div style="display: block; overflow: hidden;"><input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> placeholder="<?php echo $txt->infrva->$id_lng; ?>" style="width: 100%; text-align-last: auto;" value="<?php echo $dt_res['inf_prs'] ?>" onchange="maj('dev_prs','info',this.value,<?php echo $dt_res['id_dev_prs'] ?>)" /></div>
<?php
			}
?>
	</td>
<?php
			$flg_nb_row = false;
		}
		if($nb_row>0){
			$nb_row--;
			if(!$flg_nb_vll and $nb_vll==0){
				$nb_vll = 1;
				while(array_key_exists($i2+$nb_vll,$dt_all2) and $dt_all2[$i2+$nb_vll]['id_vll'] == $dt_res2['id_vll']){$nb_vll++;}
				$flg_nb_vll = true;
			}
			if($flg_nb_vll){
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" rowspan="<?php echo $nb_vll ?>"><?php echo $vll[$dt_res2['id_vll']]; ?></td>
<?php
				$flg_nb_vll = false;
			}
			$nb_vll--;
			if(isset($dt_res2['id_dev_srv']) and $dt_res2['id_dev_srv']!=$old_srv){
				if(!$flg_nb_srv_ctg and $nb_srv_ctg==0){
					$nb_srv_ctg = 1;
					while(array_key_exists($i2+$nb_srv_ctg,$dt_all2) and $dt_all2[$i2+$nb_srv_ctg]['id_srv_ctg'] == $dt_res2['id_srv_ctg'] and !isset($dt_all2[$i2+$nb_srv_ctg-1]['id_dev_hbr'])){$nb_srv_ctg++;}
					$flg_nb_srv_ctg = true;
				}
				if($flg_nb_srv_ctg){
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" rowspan="<?php echo $nb_srv_ctg ?>"><?php echo $ctg_srv[$id_lng][$dt_res2['id_srv_ctg']]; ?></td>
<?php
					$flg_nb_srv_ctg = false;
				}
				$nb_srv_ctg--;
			}
			elseif(isset($dt_res2['id_dev_hbr'])){
				if(!$flg_nb_hbr_ctg and $nb_hbr_ctg==0){
					$nb_hbr_ctg = 1;
					while(array_key_exists($i2+$nb_hbr_ctg,$dt_all2) and isset($dt_all2[$i2+$nb_hbr_ctg]['id_dev_hbr'])){$nb_hbr_ctg++;}
					$flg_nb_hbr_ctg = true;
				}
				if($flg_nb_hbr_ctg){
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" rowspan="<?php echo $nb_hbr_ctg ?>"><?php echo $ctg_srv[$id_lng][1]; ?></td>
<?php

					$flg_nb_hbr_ctg = false;
				}
				$nb_hbr_ctg--;
			}
			if(isset($dt_res2['id_cat_srv']) and $dt_res2['id_dev_srv']!=$old_srv){
				if($dt_res2['id_cat_srv']!=0){
					if(!$flg_nb_srv and $nb_srv==0){
						$nb_srv = 1;
						while(array_key_exists($i2+$nb_srv,$dt_all2) and $dt_all2[$i2+$nb_srv]['id_cat_srv'] == $dt_res2['id_cat_srv'] and !isset($dt_all2[$i2+$nb_srv-1]['id_dev_hbr'])){$nb_srv++;}
						$flg_nb_srv = true;
					}
					if($flg_nb_srv){
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" rowspan="<?php echo $nb_srv ?>">
		<span class="dib lnk" onClick="window.parent.opn_frm('cat/ctr.php?cbl=srv&id=<?php echo $dt_res2['id_cat_srv'] ?>')"><?php echo stripslashes($dt_res2['nom_srv']) ?></span>
	</td>
<?php
						$flg_nb_srv = false;
					}
					$nb_srv--;
				}
				else{
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>"><?php echo stripslashes($dt_res2['nom_srv']); ?></td>
<?php
				}
			}
			elseif(isset($dt_res2['id_cat_hbr']) and $dt_res2['id_cat_hbr']!=0){
				if($dt_res2['id_cat_hbr']!=0){
					if(!$flg_nb_hbr and $nb_hbr==0){
						$nb_hbr = 1;
						while(array_key_exists($i2+$nb_hbr,$dt_all2) and $dt_all2[$i2+$nb_hbr]['id_cat_hbr'] == $dt_res2['id_cat_hbr']){$nb_hbr++;}
						$flg_nb_hbr = true;
					}
					if($flg_nb_hbr){
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" rowspan="<?php echo $nb_hbr ?>">
<?php
						if($dt_res2['id_cat_hbr']>0){
?>
		<span class="dib" onClick="window.parent.opn_frm('cat/ctr.php?cbl=hbr&id=<?php echo $dt_res2['id_cat_hbr'] ?>')" style="color: #0000C3"><?php echo stripslashes($dt_res2['nom_hbr']) ?></span>
<?php
						}
						elseif($dt_res2['id_cat_hbr']==-2){echo $txt->libre->$id_lng;}
						elseif($dt_res2['id_cat_hbr']==-1){echo $txt->nodef->$id_lng;}
?>
	</td>
<?php
						$flg_nb_hbr = false;
					}
					$nb_hbr--;
				}
				else{
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>"><?php echo stripslashes($dt_res2['nom_hbr']); ?></td>
<?php
				}
			}
			if(isset($dt_res2['id_dev_srv']) and $dt_res2['id_dev_srv']!=$old_srv){
				if(!$flg_nb_frn and $nb_frn==0){
					$nb_frn = 1;
					while(array_key_exists($i2+$nb_frn,$dt_all2) and $dt_all2[$i2+$nb_frn]['id_dev_srv'] == $dt_res2['id_dev_srv'] and !isset($dt_all2[$i2+$nb_frn-1]['id_dev_hbr'])){$nb_frn++;}
					$flg_nb_frn = true;
				}
				if($flg_nb_frn){
					$id_frn = $dt_res2['id_frn'];
					$id_dev_srv = $dt_res2['id_dev_srv'];
?>
	<td id="frn_srv<?php echo $dt_res2['id_dev_srv'] ?>" class="tbl frn_ope_frn<?php echo $dt_res2['id_frn'] ?> srv_res_frn<?php echo $dt_res2['id_dev_srv'] ?> crc_res_frn<?php echo $dt_res['id_dev_crc'] ?> dsp_frn" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" rowspan="<?php echo $nb_frn ?>"><?php include("vue_srv_frn.php"); ?></td>
<?php
					$flg_nb_frn = false;
				}
				$nb_frn--;
			}
			elseif(isset($dt_res2['id_dev_hbr'])){
				if(!$flg_nb_chm and $nb_chm==0){
					$nb_chm = 1;
					while(array_key_exists($i2+$nb_chm,$dt_all2) and $dt_all2[$i2+$nb_chm]['id_cat_chm'] == $dt_res2['id_cat_chm'] and isset($dt_all2[$i2+$nb_chm]['id_dev_hbr'])){$nb_chm++;}
					$flg_nb_chm = true;
				}
				if($flg_nb_chm){
?>
	<td class="tbl" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" rowspan="<?php echo $nb_chm ?>"><?php if($dt_res2['id_cat_chm']==-2){echo $txt->libre->$id_lng;;} elseif($dt_res2['id_cat_chm']>0 and $dt_res2['id_cat_hbr']!=-2){echo $dt_res2['nom_chm'];} ?></td>
<?php
					$flg_nb_chm = false;
				}
				$nb_chm--;
			}
			if(isset($dt_res2['id_dev_srv']) and $dt_res2['id_dev_srv']!=$old_srv){
				$old_srv = $dt_res2['id_dev_srv'];
				if(!$flg_nb_srv_cmd and $nb_srv_cmd==0){
					$nb_srv_cmd = 1;
					while(array_key_exists($i2+$nb_srv_cmd,$dt_all2) and $dt_all2[$i2+$nb_srv_cmd]['id_dev_srv'] == $dt_res2['id_dev_srv'] and !isset($dt_all2[$i2+$nb_srv_cmd-1]['id_dev_hbr'])){$nb_srv_cmd++;}
					$flg_nb_srv_cmd = true;
				}
				if($flg_nb_srv_cmd){
?>
	<td id="res_srv<?php echo $dt_res2['id_dev_srv'] ?>" class="tbl frn_ope_srv<?php echo $dt_res2['id_frn'] ?> srv_res_srv<?php echo $dt_res2['id_dev_srv'] ?> prs_res_srv<?php echo $dt_res['id_dev_prs'] ?> mdl_res_srv<?php echo $dt_res['id_dev_mdl'] ?> crc_res_srv<?php echo $dt_res['id_dev_crc'] ?>" style="<?php if($flg_old){echo 'background: lightgrey';} ?>" rowspan="<?php echo $nb_srv_cmd ?>"><?php include("vue_res_srv.php"); ?></td>
	<td id="cmd_srv<?php echo $dt_res2['id_dev_srv'] ?>" rowspan="<?php echo $nb_srv_cmd ?>"><?php include("vue_cmd_srv.php"); ?></td>
<?php
					$flg_nb_srv_cmd = false;
				}
				$nb_srv_cmd--;
			}
			elseif(isset($dt_res2['id_dev_hbr'])){
?>
	<td id="res_hbr<?php echo $dt_res2['id_dev_hbr'] ?>" class="tbl cat_res_hbr<?php echo $dt_res2['id_cat_hbr'] ?> dev_res_hbr<?php echo $dt_res2['id_dev_hbr'] ?> prs_res_hbr<?php echo $dt_res['id_dev_prs'] ?> mdl_res_hbr<?php echo $dt_res['id_dev_mdl'] ?> crc_res_hbr<?php echo $dt_res['id_dev_crc'] ?>" style="<?php if($flg_old){echo 'background: lightgrey';} ?>"><?php if($dt_res2['id_cat_hbr']>-1 and $dt_res2['id_cat_chm']>-2){include("vue_res_hbr.php");} ?></td>
	<td id="cmd_hbr<?php echo $dt_res2['id_dev_hbr'] ?>"><?php if($dt_res2['id_cat_hbr']>-1 and $dt_res2['id_cat_chm']>-2){include("vue_cmd_hbr.php");} ?></td>
<?php
			}
		}
		//fin include
		if($rang==1){
?>
</tr>
<?php
		}
		else{echo '|';}
	}
}
if($j==0 and $rang>1){echo '0';}
?>
