<?php
$frs = $frs_crc + $frs_hbr;
$cur = $id_crr_chm;
$net = $db_net_chm;
$rck = $db_rck_chm;
include("clc_trf.php");
$cst_db_sel_hbr = $cst;
$trf_db_sel_hbr = $trf;
$cur = $id_crr_rgm;
$net = $db_net_rgm;
$rck = $db_rck_rgm;
include("clc_trf.php");
$cst_db_sel_hbr += $cst;
$trf_db_sel_hbr += $trf;
if($cfg_crr_sp[$id_crr_trf]==1){
	$trf_db_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
	$cst_db_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
}
else{
	$trf_db_sel_hbr *= $cfg_crr_tx[$id_crr_trf];
	$cst_db_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
}
if($ty_mrq==2){
?>
<td class="stl5" style="<?php if($est_chm==1 or $est_rgm==1){echo 'background-color: gold;';} if($est_chm==-1 or $est_rgm==-1){echo 'background-color: tomato;';} ?>"><?php echo number_format($trf_db_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.',''); ?></td>
<?php
}
?>
<td class="stl5" style="<?php if($est_chm==1 or $est_rgm==1){echo 'background-color: gold;';} if($est_chm==-1 or $est_rgm==-1){echo 'background-color: tomato;';} ?>"><?php echo number_format($cst_db_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.',''); ?></td>
<?php
if($ty_mrq==2){
?>
<td class="stl3"><?php if($trf_db_sel_hbr!=0){echo(number_format((1-$cst_db_sel_hbr/$trf_db_sel_hbr)*100,0)."%");} ?></td>
<?php
}
if($vue_sgl==1){
	$cur = $id_crr_chm;
	$net = $sg_net_chm;
	$rck = $sg_rck_chm;
	include("clc_trf.php");
	$cst_sg_sel_hbr = $cst;
	$trf_sg_sel_hbr = $trf;
	$cur = $id_crr_rgm;
	$net = $sg_net_rgm;
	$rck = $sg_rck_rgm;
	include("clc_trf.php");
	$cst_sg_sel_hbr += $cst;
	$trf_sg_sel_hbr += $trf;
	if($cfg_crr_sp[$id_crr_trf]==1){
		$trf_sg_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
		$cst_sg_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
	}
	else{
		$trf_sg_sel_hbr *= $cfg_crr_tx[$id_crr_trf];
		$cst_sg_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
	}
	if($ty_mrq==2){
?>
<td class="stl5" style="<?php if($est_chm==1 or $est_rgm==1){echo 'background-color: gold;';} if($est_chm==-1 or $est_rgm==-1){echo 'background-color: tomato;';} ?>"><?php echo number_format($trf_sg_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.',''); ?></td>
<?php
	}
?>
<td class="stl5" style="<?php if($est_chm==1 or $est_rgm==1){echo 'background-color: gold;';} if($est_chm==-1 or $est_rgm==-1){echo 'background-color: tomato;';} ?>"><?php echo number_format($cst_sg_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.',''); ?></td>
<?php
	if($ty_mrq==2){
?>
<td class="stl3"><?php if($trf_sg_sel_hbr!=0){echo(number_format((1-$cst_sg_sel_hbr/$trf_sg_sel_hbr)*100,0)."%");} ?></td>
<?php
	}
}
if($vue_tpl==1){
	$cur = $id_crr_chm;
	$net = $tp_net_chm;
	$rck = $tp_rck_chm;
	include("clc_trf.php");
	$cst_tp_sel_hbr = $cst;
	$trf_tp_sel_hbr = $trf;
	$cur = $id_crr_rgm;
	$net = $tp_net_rgm;
	$rck = $tp_rck_rgm;
	include("clc_trf.php");
	$cst_tp_sel_hbr += $cst;
	$trf_tp_sel_hbr += $trf;
	if($cfg_crr_sp[$id_crr_trf]==1){
		$trf_tp_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
		$cst_tp_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
	}
	else{
		$trf_tp_sel_hbr *= $cfg_crr_tx[$id_crr_trf];
		$cst_tp_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
	}
	if($ty_mrq==2){
?>
<td class="stl5" style="<?php if($est_chm==1 or $est_rgm==1){echo 'background-color: gold;';} if($est_chm==-1 or $est_rgm==-1){echo 'background-color: tomato;';} ?>"><?php echo number_format($trf_tp_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.',''); ?></td>
<?php
	}
?>
<td class="stl5" style="<?php if($est_chm==1 or $est_rgm==1){echo 'background-color: gold;';} if($est_chm==-1 or $est_rgm==-1){echo 'background-color: tomato;';} ?>"><?php echo number_format($cst_tp_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.',''); ?></td>
<?php
	if($ty_mrq==2){
?>
<td class="stl3"><?php if($trf_tp_sel_hbr!=0){echo(number_format((1-$cst_tp_sel_hbr/$trf_tp_sel_hbr)*100,0)."%");} ?></td>
<?php
	}
}
if($vue_qdp==1){
	$cur = $id_crr_chm;
	$net = $qd_net_chm;
	$rck = $qd_rck_chm;
	include("clc_trf.php");
	$cst_qd_sel_hbr = $cst;
	$trf_qd_sel_hbr = $trf;
	$cur = $id_crr_rgm;
	$net = $qd_net_rgm;
	$rck = $qd_rck_rgm;
	include("clc_trf.php");
	$cst_qd_sel_hbr += $cst;
	$trf_qd_sel_hbr += $trf;
	if($cfg_crr_sp[$id_crr_trf]==1){
		$trf_qd_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
		$cst_qd_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
	}
	else{
		$trf_qd_sel_hbr *= $cfg_crr_tx[$id_crr_trf];
		$cst_qd_sel_hbr /= $cfg_crr_tx[$id_crr_trf];
	}
	if($ty_mrq==2){
?>
<td class="stl5" style="<?php if($est_chm==1 or $est_rgm==1){echo 'background-color: gold;';} if($est_chm==-1 or $est_rgm==-1){echo 'background-color: tomato;';} ?>"><?php echo number_format($trf_qd_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.',''); ?></td>
<?php
	}
?>
<td class="stl5" style="<?php if($est_chm==1 or $est_rgm==1){echo 'background-color: gold;';} if($est_chm==-1 or $est_rgm==-1){echo 'background-color: tomato;';} ?>"><?php echo number_format($cst_qd_sel_hbr,$prm_crr_dcm[$id_crr_trf],'.',''); ?></td>
<?php
	if($ty_mrq==2){
?>
<td class="stl3"><?php if($trf_qd_sel_hbr!=0){echo(number_format((1-$cst_qd_sel_hbr/$trf_qd_sel_hbr)*100,0)."%");} ?></td>
<?php
	}
}
?>
<td class="stl5" style="<?php if(strtotime($dt_min_chm) > strtotime($date) or strtotime($dt_min_rgm) > strtotime($date)){echo 'background-color: tomato;';} ?>">
<?php
if($dt_min_chm!='0000-00-00'){echo date("d/m/Y", strtotime($dt_min_chm));}
if($dt_min_rgm!='0000-00-00'){echo '<br />'.date("d/m/Y", strtotime($dt_min_rgm));}
?>
</td>
<td class="stl5" style="<?php if(strtotime($dt_max_chm) < strtotime($date) or $dt_max_chm < date("Y-m-d") or ($flg_rgm_trf and strtotime($dt_max_rgm) < strtotime($date))){echo 'background-color: tomato;';} ?>">
<?php
if($dt_max_chm!='0000-00-00'){echo date("d/m/Y", strtotime($dt_max_chm));}
if($dt_max_rgm!='0000-00-00'){echo '<br />'.date("d/m/Y", strtotime($dt_max_rgm));}
?>
</td>
