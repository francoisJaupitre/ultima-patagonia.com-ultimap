<?php
if(isset($_POST['id']) or isset($_POST['id_dev_crc'])){
	if(isset($_POST['id'])){$id_dev_crc = $_POST['id'];}
	else{$id_dev_crc = $_POST['id_dev_crc'];}
	$vue_pax = $_POST['pax_vue'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ncn.php");
	include("../prm/room.php");
	$dt_crc = ftc_ass(sel_quo("id_grp,ptl","dev_crc","id",$id_dev_crc));
	$grp_crc = $dt_crc['id_grp'];
	$num_grp_pax = num_rows(sel_quo("id","grp_pax",array("id_grp","prt"),array($grp_crc,1)));
	$ptl = $dt_crc['ptl'];
}
if($vue_pax){
	$cbl='crc';
	$rq_pax = sel_quo("grp_pax.*,dev_crc_pax.id AS id_crc_pax,dev_crc_pax.id_pax AS id_pax","dev_crc_pax INNER JOIN grp_pax ON dev_crc_pax.id_pax = grp_pax.id","id_crc",$id_dev_crc,"ord,nom");
	$num_crc_pax = num_rows($rq_pax);
	$rq_rmn = sel_quo("*","dev_crc_rmn","id_crc",$id_dev_crc,"nr");
	$num_crc_rmn = num_rows($rq_rmn);
	if($num_crc_pax>0){
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
		if($num_crc_rmn>0){
			while($dt_rmn = ftc_ass($rq_rmn)){
				$lst_rmn[] = $dt_rmn['id'];
?>
		<td class="stl1">
<?php
				echo $txt->pax->rooming->$id_lng.' '.$dt_rmn['nr'];
				if(($aut['dev'] or $aut['res']) and $num_crc_rmn>1){
?>
			<span class="dib" onClick="sup_rmn('crc',<?php echo $id_dev_crc.','.$dt_rmn['nr'] ?>);"><img src="../prm/img/sup.png" /></span>
<?php
				}
?>
			<br />
			<input type="text" style="text-align: center;" <?php if(!$aut['dev'] and !$aut['res']){echo' disabled';} ?> value="<?php echo stripslashes($dt_rmn['info']); ?>" onchange="maj('dev_crc_rmn','info',this.value,<?php echo $dt_rmn['id'] ?>);" />
		</td>
<?php
			}
		}
		if($aut['dev'] or $aut['res']){
?>
		<td onclick="ajt_rmn('crc',<?php echo $id_dev_crc ?>);"><img src="../prm/img/ajt.png" /></td>
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
			if($num_crc_rmn>0){
				foreach($lst_rmn as $id_rmn){
?>
		<td id="crc_rmn_pax<?php echo $id_rmn.'_'.$id_pax ?>" class="stl2"><?php include("vue_rmn_pax.php"); ?></td>
<?php
				}
			}
			if($aut['dev'] or $aut['res']){
?>
		<td onclick="sup_pax('crc',<?php echo $dt_pax['id_crc_pax']; ?>);"><img src="../prm/img/sup.png" /></td>
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
		$num_pax = num_rows(sel_quo("grp_pax.id","dev_crc_pax INNER JOIN grp_pax ON dev_crc_pax.id_pax = grp_pax.id AND grp_pax.prt = 1","id_crc",$id_dev_crc));
		if($num_grp_pax > $num_pax){
?>
<span class="dib">
	<div class="sel" onclick="vue_cmd('sel_crc_pax')">
		<img src="../prm/img/sel.png" />
		<div><?php echo $txt->ajtpax->$id_lng; ?></div>
	</div>
	<div id="sel_crc_pax" class="cmd mw200">
		<div><input type="text" id="ipt_sel_crc_pax" class="pax_fll" onkeyup="auto_lst('crc','crc_pax',this.value,event);" /></div>
		<div id="lst_crc_pax"><?php include("vue_lst_pax.php") ?></div>
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
