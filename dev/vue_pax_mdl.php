<?php
if(isset($_POST['id']) or isset($_POST['id_dev_mdl'])){
	if(isset($_POST['id'])){$id_dev_mdl = $_POST['id'];}
	else{$id_dev_mdl = $_POST['id_dev_mdl'];}
	$vue_pax = $_POST['pax_vue'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ncn.php");
	include("../prm/room.php");
	$dt_mdl = ftc_ass(sel_quo("id_grp,dev_mdl.ptl,trf","dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id","dev_mdl.id",$id_dev_mdl));
	$trf_mdl = $dt_mdl['trf'];
	$grp_crc = $dt_mdl['id_grp'];
	$num_grp_pax = num_rows(sel_quo("id","grp_pax",array("id_grp","prt"),array($grp_crc,1)));
	$ptl = $dt_mdl['ptl'];
}
if($vue_pax){
	$cbl='mdl';
	$rq_pax = sel_quo("grp_pax.*,dev_mdl_pax.id AS id_mdl_pax,dev_mdl_pax.id_pax AS id_pax","dev_mdl_pax INNER JOIN grp_pax ON dev_mdl_pax.id_pax = grp_pax.id","id_mdl",$id_dev_mdl,"ord,nom");
	$num_mdl_pax = num_rows($rq_pax);
	$rq_rmn = sel_quo("*","dev_mdl_rmn","id_mdl",$id_dev_mdl,"nr");
	$num_mdl_rmn = num_rows($rq_rmn);
	if($num_mdl_pax>0){
?>
<table class="dsg w-100">
	<tr>
		<td class="stl1"><?php echo $txt->pax->nom->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->pre->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->dob->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->psp->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->exp->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->ncn->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->info->$id_lng; ?></td>
<?php
		if($num_mdl_rmn>0){
			while($dt_rmn = ftc_ass($rq_rmn)){
				$lst_rmn[] = $dt_rmn['id'];
?>
		<td class="stl1">
<?php
				echo $txt->pax->rooming->$id_lng.' '.$dt_rmn['nr'];
				if(($aut['dev'] or $aut['res']) and $num_mdl_rmn>1){
?>
			<span class="dib" onClick="sup_rmn('mdl',<?php echo $id_dev_mdl.','.$dt_rmn['nr'] ?>);"><img src="../prm/img/sup.png" /></span>
<?php
				}
?>
			<br />
			<input type="text" style="text-align: center;" <?php if(!$aut['dev'] and !$aut['res']){echo' disabled';} ?> value="<?php echo stripslashes($dt_rmn['info']); ?>" onchange="maj('dev_mdl_rmn','info',this.value,<?php echo $dt_rmn['id'] ?>);" />
		</td>
<?php
			}
		}
		if($aut['dev'] or $aut['res']){
?>
		<td onclick="addRmn('mdl',<?php echo $id_dev_mdl ?>);"><img src="../prm/img/ajt.png" /></td>
<?php
		}
?>
	</tr>
<?php
		while($dt_pax = ftc_ass($rq_pax)){
			$lst_pax[] = $dt_pax['id_pax'];
			$id_pax = $dt_pax['id'];
?>
	<tr>
		<td class="stl2 usa"><?php echo stripslashes($dt_pax['nom']); ?></td>
		<td class="stl2 usa"><?php echo stripslashes($dt_pax['pre']); ?></td>
		<td class="stl2 usa"><?php if($dt_pax['dob']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_pax['dob']));} ?></td>
		<td class="stl2 usa"><?php echo stripslashes($dt_pax['psp']); ?></td>
		<td class="stl2 usa"><?php if($dt_pax['exp']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_pax['exp']));} ?></td>
		<td class="stl2 usa"><?php if($dt_pax['ncn']>0){echo $ncn[$id_lng][$dt_pax['ncn']];} ?></td>
		<td class="stl2 usa"><?php echo stripslashes($dt_pax['info']); ?></td>
<?php
			if($num_mdl_rmn>0){
				foreach($lst_rmn as $id_rmn){
?>
		<td id="mdl_rmn_pax<?php echo $id_rmn.'_'.$id_pax ?>" class="stl2"><?php include("vue_rmn_pax.php"); ?></td>
<?php
				}
			}
			if($aut['dev'] or $aut['res']){
?>
		<td onclick="sup_pax('mdl',<?php echo $dt_pax['id_mdl_pax'].','.$id_dev_mdl; ?>);"><img src="../prm/img/sup.png" /></td>
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
	if(($aut['dev'] or $aut['res'])){
		$num_pax = num_rows(sel_quo("grp_pax.id","dev_mdl_pax INNER JOIN grp_pax ON dev_mdl_pax.id_pax = grp_pax.id AND grp_pax.prt = 1","id_mdl",$id_dev_mdl));
		if($num_grp_pax > $num_pax){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_mdl_pax<?php echo $id_dev_mdl; ?>')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->ajtpax->$id_lng; ?></div>
	</div>
	<div id="sel_mdl_pax<?php echo $id_dev_mdl; ?>" class="cmd mw200">
		<div><input type="text" id="ipt_sel_mdl_pax<?php echo $id_dev_mdl; ?>" class="pax_fll" onkeyup="auto_lst('mdl','mdl_pax<?php echo $id_dev_mdl; ?>',this.value,event);" /></div>
		<div id="lst_mdl_pax<?php echo $id_dev_mdl; ?>"><?php include("vue_lst_pax.php") ?></div>
	</div>
</span>
<?php
		}
		else{
?>
<span class="dib">
	<div class="noselcol"><?php echo $txt->nopax->$id_lng; ?></div>
</span>
<?php
		}
	}
}
?>
