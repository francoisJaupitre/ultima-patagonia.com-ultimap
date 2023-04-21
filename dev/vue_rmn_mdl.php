<?php
if(isset($_POST['id_dev_mdl'])){
	$id_dev_mdl = $_POST['id_dev_mdl'];
	$vue_pax = $_POST['pax_vue'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ncn.php");
	include("../prm/room.php");
	unset($_POST['id_dev_mdl']);
	$dt_mdl = ftc_ass(sel_quo("id_grp,dev_mdl.ptl","dev_mdl INNER JOIN dev_crc ON dev_mdl.id_crc = dev_crc.id","dev_mdl.id",$id_dev_mdl));
	$grp_crc = $dt_mdl['id_grp'];
	$num_grp_pax = num_rows(sel_quo("id","grp_pax",array("id_grp","prt"),array($grp_crc,1)));
	$ptl = $dt_mdl['ptl'];
}
?>
<table class="tbl_mdl w-100">
	<tr>
		<td class="lsb">
			<input id="chk_pax_mdl_<?php echo $id_dev_mdl; ?>" class="dev_img chk_img" type="checkbox" autocomplete="off" <?php if($vue_pax==1){echo 'checked';} ?> onclick="chk_pax(<?php echo $id_dev_mdl; ?>);" />
			<label for="chk_pax_mdl_<?php echo $id_dev_mdl; ?>"><img src="../prm/img/maxi.png" /></label>
			<strong><?php echo $txt->paxs->$id_lng; ?></strong>
		</td>
	</tr>
	<tr><td><div id="vue_pax_mdl_<?php echo $id_dev_mdl; ?>" class="pax"><?php include("vue_pax_mdl.php"); ?></div></td></tr>
</table>
