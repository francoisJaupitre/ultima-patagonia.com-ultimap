<?php
if(isset($_POST['id_dev_crc']))
{
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../cfg/rgn.php");
	$rq_crc = select("id_cat", "dev_crc", "id", $id_dev_crc);
	$dt_crc = ftc_ass($rq_crc);
	$id_cat_crc = $dt_crc['id_cat'];
	$cbl = 'crc';
	$dt_mdl = ftc_ass(sel_quo("id, id_cat", "dev_mdl", "id_crc", $id_dev_crc, "ord DESC"));
	$last_id_cat_mdl = $dt_mdl['id_cat'];
	$last_id_dev_mdl = $dt_mdl['id'];
}
if($last_id_cat_mdl > 0)
{
	$dt_rgn = ftc_ass(sel_quo("id_rgn", "cat_mdl_rgn", "id_mdl", $last_id_cat_mdl));
	$id_rgn = $dt_rgn['id_rgn'];
}else if($last_id_dev_mdl > 0)
{
	$dt_rgn = ftc_ass(sel_quo("id_rgn", "dev_mdl_rgn", "id_mdl", $last_id_dev_mdl));
	$id_rgn = $dt_rgn['id_rgn'];
}
if($aut['dev'] and $cnf < 1)
{
?>
<table class="tbl_crc">
	<tr>
		<td class="lslm w-100">
			<span class="vdfp"><?php echo $txt->ajtmdl->$id_lng.':'; ?></span>
			<span id="crc_rgn<?php echo $id_dev_crc ?>" class="rgn"><?php include("vue_crc_rgn.php"); ?></span>
		</td>
	</tr>
</table>
<?php
}
?>
<br />
