<?php
if(isset($_POST['id_dev_crc'])){
	$id_dev_crc = $_POST['id_dev_crc'];
	$vue_pax = $_POST['pax_vue'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ncn.php");
	include("../prm/room.php");
	unset($_POST['id_dev_crc']);
	$dt_crc = ftc_ass(sel_quo("id_grp,ptl","dev_crc","id",$id_dev_crc));
	$grp_crc = $dt_crc['id_grp'];
	$num_grp_pax = num_rows(sel_quo("id","grp_pax",array("id_grp","prt"),array($grp_crc,1)));
	$ptl = $dt_crc['ptl'];
}
else{$vue_pax = false;}
?>
<table class="tbl_crc w-100">
	<tr>
		<td class="lsb">
			<input id="chk_pax_crc" class="dev_img chk_img" type="checkbox" autocomplete="off" <?php if($vue_pax){echo 'checked';} ?> onclick="chk_pax('');" />
			<label for="chk_pax_crc"><img src="../prm/img/maxi.png" /></label>
			<strong><?php echo $txt->paxs->$id_lng; ?></strong>
		</td>
	</tr>
	<tr><td><div id="vue_pax_crc" class="pax"><?php include("vue_pax_crc.php"); ?></div></td></tr>
</table>
