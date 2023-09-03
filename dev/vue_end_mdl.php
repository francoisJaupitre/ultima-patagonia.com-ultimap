<?php
if(isset($_POST['id_dev_mdl'])){
	$id_dev_mdl = $_POST['id_dev_mdl'];
	$vue_mdl = $_POST['vue'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$dt_mdl = ftc_ass(select("id_cat,ord,fus","dev_mdl","id",$id_dev_mdl));
	$id_cat_mdl = $dt_mdl['id_cat'];
	$ord_mdl = $dt_mdl['ord'];
	$fus_mdl = $dt_mdl['fus'];
	$rq_rgn = sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$id_dev_mdl);
	while($dt_rgn = ftc_ass($rq_rgn)) {$ids_rgn[] = $dt_rgn['id_rgn'];}
	include("../cfg/vll.php");
	include("../cfg/rgn.php");
	$rq_jrn = select("*","dev_jrn","id_mdl",$id_dev_mdl,"ord,opt DESC");
	while($dt_jrn = ftc_ass($rq_jrn)){
		$jrn_datas[$dt_jrn['id']]['id_cat'] = $dt_jrn['id_cat'];
		$jrn_datas[$dt_jrn['id']]['date'] = $dt_jrn['date'];
		$jrn_datas[$dt_jrn['id']]['opt'] = $dt_jrn['opt'];
		$jrn_datas[$dt_jrn['id']]['ord'] = $dt_jrn['ord'];
		$jrn_datas[$dt_jrn['id']]['nom'] = $dt_jrn['nom'];
		$jrn_datas[$dt_jrn['id']]['titre'] = $dt_jrn['titre'];
		$jrn_datas[$dt_jrn['id']]['dsc'] = $dt_jrn['dsc'];
	}
}
if($vue_mdl and $aut['dev'] and $cnf < 1){
	$cbl = "mdl";
?>
<table>
	<tr>
		<td class="lcrl">
			<span id="mdl_rgn<?php echo $id_dev_crc ?>" class="rgn"><?php include("vue_mdl_rgn.php"); ?></span>
		</td>
	</tr>
	<tr>
<?php
	if($id_cat_mdl>0){
?>
		<td class="lcrl">
			<span class="vdfp"><?php echo $txt->ajtoptcat->$id_lng.':'; ?></span>
			<span id="jrn_mdl_opt<?php echo $id_dev_mdl ?>" class="jrn_opt"><input type="button" value="<?php echo $txt->jrn->$id_lng ?>" onclick="vue_elem('jrn_mdl_opt<?php echo $id_dev_mdl ?>','0');" /></span>
		</td>
<?php
	}
?>
		<td class="lcrl">
			<span class="vdfp"><?php echo $txt->ajtjrn->$id_lng.':'; ?></span>
			<span id="mdl_vll<?php echo $id_dev_mdl ?>" class="rgn"><?php include("vue_mdl_vll.php"); ?></span>
		</td>
	</tr>
</table>
<?php
}
unset($ids_rgn);
//$rq_jrn = select("ord","dev_jrn","opt=1 AND id_mdl",$id_dev_mdl,"ord");
$nb_jrn = ftc_ass(select("COUNT(*) as total","dev_jrn","opt=1 AND id_mdl",$id_dev_mdl));
if($nb_jrn['total'] >0){
?>
<table class="w-100">
	<tr>
		<td width="20%" class="dsg">
<?php
	if(isset($jrn_datas)) {
		$nb_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl","id_crc",$id_dev_crc));
		if($ord_mdl < $nb_mdl['total']){
?>
			<strong><?php echo $txt->fus->$id_lng; ?></strong>
			<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($fus_mdl){echo('checked="checked"');} ?> onclick="if(this.checked){prevFusion('1',<?php echo $id_dev_mdl ?>)}else{prevFusion('0',<?php echo $id_dev_mdl ?>)};" />
<?php
		}
?>
		</td>
		<td width="80%" class="dsg">
			<strong><?php echo $nb_jrn['total'].' '.$txt->jours->$id_lng.' : '; ?></strong>
<?php
		foreach($jrn_datas as $id_dev_jrn => $dt_jrn) {
			if($dt_jrn['opt']) {echo $dt_jrn['ord'].',';}
		}
		//while($dt_jrn = ftc_ass($rq_jrn)){echo $dt_jrn['ord'].',';}
?>
		</td>
<?php
	}
?>
	</tr>
</table>
<?php
}
?>
