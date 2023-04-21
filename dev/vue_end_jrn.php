<?php
if(isset($_POST['id_dev_jrn'])){
	$id_dev_jrn = $_POST['id_dev_jrn'];
	$vue_jrn = $_POST['vue'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ctg_prs.php");
	$dt_jrn = ftc_ass(select("dev_jrn.id_cat","dev_jrn INNER JOIN dev_mdl ON dev_jrn.id_mdl = dev_mdl.id","dev_jrn.id",$id_dev_jrn));
	$id_cat_jrn = $dt_jrn['id_cat'];
	if($id_cat_jrn > 0){
		$ids_rgn = array();
		$rq_vll = sel_quo("id_rgn","cat_jrn_vll INNER JOIN cat_vll ON id_vll = cat_vll.id","id_jrn",$id_cat_jrn);
		while($dt_vll = ftc_ass($rq_vll)){$ids_rgn[] = $dt_vll['id_rgn'];}
	}
	include("../cfg/vll.php");
	unset($ids_rgn);
}
if($vue_jrn == 1 and $id_cat_jrn > -1 and (($aut['dev'] and $cnf<1) or ($aut['res'] and $cnf>0))){
?>
<table>
	<tr>
<?php
	if($id_cat_jrn>0){
?>
		<td class="lmcf">
			<span class="vdfp"><?php echo $txt->ajtoptcat->$id_lng.':'; ?></span>
			<span id="prs_jrn_opt<?php echo $id_dev_jrn ?>" class="prs_opt"><input type="button" value="<?php echo $txt->prs->$id_lng ?>" onclick="vue_elem('prs_jrn_opt<?php echo $id_dev_jrn ?>','0');" /></span>
		</td>
<?php
	}
	$id_vll=0;
	$id_ctg_prs=0;
?>

		<td class="lmcf">
			<span class="vdfp"><?php echo $txt->ajtprs->$id_lng.':'; ?></span>
			<span id="jrn_vll_ctg<?php echo $id_dev_jrn ?>" class="vll"><?php include("vue_jrn_vll_ctg.php"); ?></span>
		</td>
	</tr>
</table>
<?php
}
?>
