<?php //DISPLAY PASSENGERS LIST IN A GROUP
$request = file_get_contents("php://input");
$data = json_decode($request, true);
if(isset($data['id_grp']) and $data['id_grp'] > 0)
{
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ncn.php");
	$txt = simplexml_load_file('txt.xml');
	$id_grp = $data['id_grp'];
}
$rq_pax = sel_quo("*", "grp_pax", "id_grp", $id_grp, "ord, nom, pre");
$nb_pax = num_rows($rq_pax);
?>
<table class="dsg w-100" style="min-width: 1085px;">
	<tr>
		<td></td>
		<td class="stl1"><?php echo $txt->pax->nom->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->pre->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->dob->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->psp->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->exp->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->ncn->$id_lng; ?></td>
		<td class="stl1"><?php echo $txt->pax->info->$id_lng; ?></td>
		<td></td>
		<td id="adPax"></td>
	</tr>
<?php
while($dt_pax = ftc_ass($rq_pax))
{
?>
	<tr id="trPax<?php echo $dt_pax['id']; ?>" class="tr-pax">
		<td onclick="src_pax(<?php echo $dt_pax['id']; ?>);"><img src="../prm/img/val.png" /></td>
		<td class="stl2"><input type="text" <?php if(!$aut['dev'] and !$aut['res'] or !$dt_pax['prt']){echo ' disabled';} ?> style="padding: 0 5px; max-width: 115px;" value="<?php echo stripslashes($dt_pax['nom']); ?>" onChange="maj('grp_pax','nom',this.value,<?php echo $dt_pax['id']; ?>)" /></td>
		<td class="stl2"><input type="text" <?php if(!$aut['dev'] and !$aut['res'] or !$dt_pax['prt']){echo ' disabled';} ?> style="padding: 0 5px; max-width: 115px;" value="<?php echo stripslashes($dt_pax['pre']); ?>" onChange="maj('grp_pax','pre',this.value,<?php echo $dt_pax['id']; ?>)" /></td>
		<td class="stl2"><input <?php if(!$aut['dev'] and !$aut['res'] or !$dt_pax['prt']){echo ' disabled';} ?> id="pax_dob<?php echo $dt_pax['id']; ?>" type="text" placeholder="jj/mm/aaaa" class="w74" style="padding: 0 5px;" value="<?php if($dt_pax['dob']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_pax['dob']));}; ?>" onChange="maj('grp_pax','dob',this.value,<?php echo $dt_pax['id']; ?>)" /></td>
		<td class="stl2"><input type="text" <?php if(!$aut['dev'] and !$aut['res'] or !$dt_pax['prt']){echo ' disabled';} ?> style="padding: 0 5px;" class="w74" value="<?php echo stripslashes($dt_pax['psp']); ?>" onChange="maj('grp_pax','psp',this.value,<?php echo $dt_pax['id']; ?>)" /></td>
		<td class="stl2"><input <?php if(!$aut['dev'] and !$aut['res'] or !$dt_pax['prt']){echo ' disabled';} ?> id="pax_exp<?php echo $dt_pax['id']; ?>" type="text" placeholder="jj/mm/aaaa" class="w74" style="padding: 0 5px;" value="<?php if($dt_pax['exp']!='0000-00-00'){echo date("d/m/Y", strtotime($dt_pax['exp']));}; ?>" onChange="maj('grp_pax','exp',this.value,<?php echo $dt_pax['id']; ?>)" /></td>
		<td id="pax_ncn<?php echo $dt_pax['id']; ?>" class="stl2"><?php include("vue_ncn.php"); ?></td>
		<td class="stl2"><input type="text" <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> style="padding: 0 5px;" value="<?php echo stripslashes($dt_pax['info']); ?>" onChange="maj('grp_pax','info',this.value,<?php echo $dt_pax['id']; ?>)" /></td>
		<td class="stl2"><input type="number" <?php if(!$aut['dev'] and !$aut['res']){echo ' disabled';} ?> style="padding: 0 5px; width:15px" value="<?php echo $dt_pax['ord']	; ?>" onChange="maj('grp_pax','ord',this.value,<?php echo $dt_pax['id']; ?>)" /></td>
		<td class="prt-pax">
			<input type="checkbox" autocomplete="off"
<?php
	if(!$aut['dev'] and !$aut['res'])
	{
		echo ' disabled';
	}
	if($dt_pax['prt'])
	{
		echo 'checked = "checked"';
	}
?>
			/>
		</td>
		<td class="remove-pax"></td>
	</tr>
<?php
}
?>
</table>
