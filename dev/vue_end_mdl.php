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
	while($dt_rgn = ftc_ass($rq_rgn)){$ids_rgn[] = $dt_rgn['id_rgn'];}
	include("../cfg/vll.php");
	include("../cfg/rgn.php");
}
if($vue_mdl and $aut['dev'] and $cnf<1){
?>
<table>
	<tr>
		<td class="lcrl">
<?php
	if(isset($ids_rgn)){
?>

<?php
		echo $txt->rgn->$id_lng.'(s) : ';
		foreach ($ids_rgn as $id_rgn) {echo '<strong>'.$rgn[$id_rgn].'</strong> | ';}
		if($aut['dev']) {
?>
			<span class="dib">
				<div class="sel" onclick="vue_cmd('sel_rgn<?php echo $id_dev_mdl ?>')">
					<img src="../prm/img/sel.png" />
					<div><?php echo $txt->ajt->$id_lng; ?></div>
				</div>
				<div id="sel_rgn<?php echo $id_dev_mdl ?>" class="cmd mw200">
					<div><input type="text" id="ipt_sel_rgn<?php echo $id_dev_mdl ?>" onkeyup="auto_lst('mdl','rgn<?php echo $id_dev_mdl ?>',this.value,event);" /></div>
					<div id="lst_rgn<?php echo $id_dev_mdl ?>"><?php $cbl = "mdl"; include("vue_lst_rgn.php") ?></div>
				</div>
			</span>
<?php
		}
	}
?>
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
$rq_jrn = select("ord","dev_jrn","opt=1 AND id_mdl",$id_dev_mdl,"ord");
$nb_jrn = num_rows($rq_jrn);
if($nb_jrn>0){

?>
<table class="w-100">
	<tr>
		<td width="20%" class="dsg">
<?php
	$nb_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl","id_crc",$id_dev_crc));
	if($ord_mdl<$nb_mdl['total']){
?>
			<strong><?php echo $txt->fus->$id_lng; ?></strong>
			<input <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($fus_mdl){echo('checked="checked"');} ?> onclick="if(this.checked){fus('1',<?php echo $id_dev_mdl ?>)}else{fus('0',<?php echo $id_dev_mdl ?>)};" />
<?php
	}
?>
		</td>
		<td width="80%" class="dsg">
			<strong><?php echo $nb_jrn.' '.$txt->jours->$id_lng.' : '; ?></strong>
<?php
while($dt_jrn = ftc_ass($rq_jrn)){echo $dt_jrn['ord'].',';}
?>
		</td>
	</tr>
</table>
<?php
}
?>
