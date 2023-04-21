<?php
include("../cfg/crr.php");
$rang = 1;
?>
<input id="dat_min" type="text" autocomplete="off" placeholder="jj/mm/aaaa" style="width: 70px;" value="<?php if(!empty($dat_min)){echo date("d/m/Y", strtotime($dat_min));} ?>" onchange="vue('fac');" />
<input id="dat_max" type="text" autocomplete="off" placeholder="jj/mm/aaaa" style="width: 70px;" value="<?php if(!empty($dat_max)){echo date("d/m/Y", strtotime($dat_max));} ?>" onchange="vue('fac');" />
<input type="button" value="HOY" onclick="document.getElementById('dat_max').value='<?php echo date("d/m/Y"); ?>';vue('fac');" />
<select id="sel_rai" style="width: 170px;" onchange="vue('fac');">
	<option value="*">RAISON SOCIALE</option>
<?php
$rq_fac = sel_quo("nom","cmp_fac","","","nom","DISTINCT");
while($dt_fac = ftc_ass($rq_fac)){
?>
	<option <?php if($dt_fac['nom']==$nom_rai){echo ' selected';} ?> value="<?php echo $dt_fac['nom'] ?>"><?php echo stripslashes($dt_fac['nom']) ?></option>
<?php
}
?>
</select>
<select id="sel_imp" style="width: 100px;" onchange="vue('fac');">
	<option value="*">CUIT/RUT</option>
<?php
$rq_fac = sel_quo("imp","cmp_fac","","","imp","DISTINCT");
while($dt_fac = ftc_ass($rq_fac)){
?>
	<option <?php if($dt_fac['imp']==$nom_imp){echo ' selected';} ?> value="<?php echo $dt_fac['imp'] ?>"><?php echo stripslashes($dt_fac['imp']) ?></option>
<?php
}
?>
</select>

<select id="sel_vnt" style="width: 120px;" onchange="vue('fac');">
	<option value="-1">COMPRA/VENTA</option>
	<option <?php if($id_vnt==0){echo ' selected';} ?> value="0">COMPRA</option>
	<option <?php if($id_vnt==1){echo ' selected';} ?> value="1">VENTA</option>
	<option <?php if($id_vnt==2){echo ' selected';} ?> value="2">COMISION (facturada a proveedor)</option>
</select>

<select id="sel_ctr" style="width: 100px;" onchange="vue('fac');">
	<option value="-1">CONTROL</option>
	<option <?php if($id_ctr==0){echo ' selected';} ?> value="0">ESPERA</option>
	<option <?php if($id_ctr==1){echo ' selected';} ?> value="1">AUDITORIA</option>
	<option <?php if($id_ctr==2){echo ' selected';} ?> value="2">OK</option>
</select>

<select id="sel_itm" style="width: 400px;" onchange="vue('fac');">
	<option value="0">ITEMS</option>
	<option <?php if($id_itm=='-1'){echo ' selected';} ?> value="-1">NON DEFINI</option>
<?php
foreach($itm as $itm_id => $nom){
?>
	<option <?php if($itm_id==$id_itm){echo ' selected';} ?> value="<?php echo $itm_id ?>"><?php echo $nom ?></option>
<?php
}
?>
</select>
<select id="sel_cnf" style="width: 110px;" onchange="vue('fac');">
	<option value="0">GROUPES</option>
<?php
$rq_grp = sel_whe("cmp_itm.id_grp","cmp_itm LEFT JOIN grp_dev ON cmp_itm.id_grp = grp_dev.id","grp_dev.id IS NULL AND cmp_itm.id_grp > 0","","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
?>
		<option <?php if($dt_grp['id_grp']==$id_grp){echo ' selected';} ?> value="<?php echo $dt_grp['id_grp'] ?>">ANNULATION</option>
<?php
}
?>
	<option <?php if($id_grp=='-2'){echo ' selected';} ?> value="-2">NON DEFINI</option>
	<option <?php if($id_grp=='-1'){echo ' selected';} ?> value="-1">Autre</option>
	<optgroup label="EN COURS">
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","cmp_itm INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON cmp_itm.id_grp = grp_dev.id","cnf","1","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
?>
		<option <?php if($dt_grp['id']==$id_grp){echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
	</optgroup>
	<optgroup label="ARCHIVES">
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","cmp_itm INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON cmp_itm.id_grp = grp_dev.id","cnf","2","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
?>
		<option <?php if($dt_grp['id']==$id_grp){echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
	</optgroup>
	<optgroup label="SANS DEVIS">
<?php
$rq_grp = sel_whe("grp_dev.id,grp_dev.nomgrp","fin_bdg INNER JOIN (grp_dev LEFT JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON fin_bdg.id_grp = grp_dev.id","dev_crc.id IS NULL","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)){
?>
		<option <?php if($dt_grp['id']==$id_grp){echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
	</optgroup>
</select>
<hr/>
<table id="tab_fac" class="w-100">
	<tr style="font-weight: bold">
		<td class="td_fin">
			<table>
				<tr>
					<td style="width: 80px">DATE</td>
					<td style="width: 190px">RAISON SOCIALE</td>
					<td style="width: 110px">CUIT/RUT</td>
					<td style="width: 140px">NUMERO</td>
					<td style="width: 90px">COMPRA/VENTA</td>
					<td style="width: 70px">CONTROL</td>
				</tr>
			</table>
		</td>
		<td class="td_fin">
			<table>
				<tr>
					<td class="tb" style="width: 80px;">MONTANT</td>
					<td class="tb" style="width: 60px;">DEVISE</td>
					<td class="tb" style="width: 70px;">SOLDE</td>
					<td class="tb" style="width: 45px;">TAUX</td>
					<td class="tb" style="width: 300px;">ITEMS</td>
					<td class="tb" style="width: 80px;">COMPUTABLE</td>
					<td class="tb" style="width: 120px;">GROUPES</td>
					<td style="width: 20px;"></td>
				</tr>
			</table>
		</td>
		<td class="td_fin">DESCRIPTION</td>
<?php
if($aut['cmp']){
?>
		<td onclick="ajt('fac',0);">
			<img src="../prm/img/ajt.png" />
		</td>
<?php
}
?>
	</tr>
<?php
include("vue_dt_fac.php");
?>
</table>
