<?php
include("../cfg/crr.php");
$rang = 1;
?>
<input id="dat_min" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" value="<?php if(!empty($dat_min)) {echo date("d/m/Y", strtotime($dat_min));} ?>" onchange="vue('ecr');" />
<input id="dat_max" type="text" autocomplete="off" placeholder="jj/mm/aaaa" class="w74" value="<?php if(!empty($dat_max)) {echo date("d/m/Y", strtotime($dat_max));} ?>" onchange="vue('ecr');" />
<input type="button" value="-1M" onclick="document.getElementById('dat_max').value='<?php echo date("t/m/Y",strtotime(date("Y-m",strtotime($dat_max)). ' -1 month')) ?>';vue('ecr');" />
<input type="button" value="HOY" onclick="document.getElementById('dat_max').value='<?php echo date("d/m/Y"); ?>';vue('ecr');" />
<input type="button" value="+1M" onclick="document.getElementById('dat_max').value='<?php echo date("t/m/Y",strtotime(date("Y-m",strtotime($dat_max)). ' +1 month')); ?>';vue('ecr');" />
<select id="sel_nat" style="width: 90px;" onchange="vue('ecr');">
	<option value="*">NATURE</option>
<?php
$rq_ecr = sel_quo("nature","fin_ecr","","","nature","DISTINCT");
while($dt_ecr = ftc_ass($rq_ecr)) {
?>
	<option <?php if($dt_ecr['nature']==$nom_nat) {echo ' selected';} ?> value="<?php echo $dt_ecr['nature'] ?>"><?php echo stripslashes($dt_ecr['nature']) ?></option>
<?php
}
?>
</select>
<select id="sel_css" style="width: 90px;" onchange="vue('ecr');">
	<option value="0">CAISSES</option>
	<option <?php if($id_css=='-2') {echo ' selected';} ?> value="-2">NON DEFINI</option>
<?php
foreach($css as $css_id => $nom) {
?>
	<option <?php if($css_id==$id_css) {echo ' selected';} ?> value="<?php echo $css_id ?>"><?php echo $nom ?></option>
<?php
}
?>
</select>
<select id="sel_att" style="width: 90px;" onchange="vue('ecr');">
	<option value="-1">FACTURES</option>
	<option <?php if($id_att=='0') {echo ' selected';} ?> value="0">EN ATTENTE</option>
	<option <?php if($id_att=='1') {echo ' selected';} ?> value="1">OK</option>
	<option <?php if($id_att=='2') {echo ' selected';} ?> value="2">NON</option>
</select>
<select id="sel_pst" style="width: 90px;" onchange="vue('ecr');">
	<option value="0">POSTES</option>
	<option <?php if($id_pst=='-1') {echo ' selected';} ?> value="-1">NON DEFINI</option>
<?php
foreach($pst as $pst_id => $nom) {
?>
	<option <?php if($pst_id==$id_pst) {echo ' selected';} ?> value="<?php echo $pst_id ?>"><?php echo $nom ?></option>
<?php
}
?>
</select>
<select id="sel_cnf" style="width: 110px;" onchange="vue('ecr');">
	<option value="0">GROUPES</option>
	<option <?php if($id_grp=='-2') {echo ' selected';} ?> value="-2">NON DEFINI</option>
	<option <?php if($id_grp=='-1') {echo ' selected';} ?> value="-1">Autre</option>
	<optgroup label="EN COURS">
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","fin_bdg INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON fin_bdg.id_grp = grp_dev.id","cnf","1","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)) {
?>
		<option <?php if($dt_grp['id']==$id_grp) {echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
	</optgroup>
	<optgroup label="ARCHIVES">
<?php
$rq_grp = sel_quo("grp_dev.id,grp_dev.nomgrp","fin_bdg INNER JOIN (grp_dev INNER JOIN dev_crc ON grp_dev.id = dev_crc.id_grp) ON fin_bdg.id_grp = grp_dev.id","cnf","2","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)) {
?>
		<option <?php if($dt_grp['id']==$id_grp) {echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
	</optgroup>
	<optgroup label="AUTRES">
<?php
$rq_grp = sel_whe("t.id,t.nomgrp","fin_bdg INNER JOIN (SELECT grp_dev.id,nomgrp,cnf FROM grp_dev LEFT JOIN dev_crc ON grp_dev.id = dev_crc.id_grp AND dev_crc.cnf>0 WHERE dev_crc.id IS NULL) t ON fin_bdg.id_grp = t.id","","nomgrp","DISTINCT");
while($dt_grp = ftc_ass($rq_grp)) {
?>
		<option <?php if($dt_grp['id']==$id_grp) {echo ' selected';} ?> value="<?php echo $dt_grp['id'] ?>"><?php echo $dt_grp['nomgrp'] ?></option>
<?php
}
?>
	</optgroup>
</select>
<hr/>
<table class="w-100">
	<tr>
		<td class="vat">
			<table id="tab_ecr">
				<tr style="font-weight: bold">
					<td class="td_fin">DATE</td>
					<td class="td_fin">NATURE</td>
					<td class="td_fin">FLUX DE TRESORERIE
						<table>
							<tr>
								<td class="tb" style="width: 100px;">CAISSE</td>
								<td class="tb" style="width: 85px;">MONTANT</td>
								<td style="width: 35px;"></td>
								<td class="tb" style="width: 85px;">SOLDE</td>
								<td class="tb" style="width: 45px;">TAUX</td>
								<td class="tb" style="width: 85px;">FACTURE</td>
								<td style="width: 20px;"></td>
							</tr>
						</table>
					</td>
					<td class="td_fin">BUDGETS
						<table>
							<tr>
								<td class="tb" style="width: 120px;">POSTES</td>
								<td class="tb" style="width: 80px;">PRODUITS</td>
								<td class="tb" style="width: 80px;">CHARGES</td>
								<td class="tb" style="width: 80px;">DETTES</td>
								<td class="tb" style="width: 80px;">CREANCES</td>
								<td class="tb" style="width: 120px;">GROUPES</td>
								<td class="tb" style="width: 60px;">MOIS</td>
								<td class="tb" style="width: 140px;">DESCRIPTION</td>
								<td style="width: 20px;"></td>
							</tr>
						</table>
					</td>
<?php
if($aut['adm_fin']) {
?>
					<td onclick="ajt('ecr',0);">
						<img src="../prm/img/ajt.png" />
					</td>
<?php
}
?>
				</tr>
<?php
include("vue_dt_ecr.php");
?>
			</table>
		</td>
		<td id="end_ecr" class="vat"></td>
	</tr>
</table>
