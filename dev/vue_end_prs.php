<?php
if(isset($_POST['id_dev_prs'])){
	$id_dev_prs = $_POST['id_dev_prs'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ctg_srv.php");
	$dt_prs = ftc_ass(select("id_cat,ctg,info,heure,id_jrn,id_rmn","dev_prs","id",$id_dev_prs));
	$id_cat_prs = $dt_prs['id_cat'];
	$id_ctg_prs = $dt_prs['ctg'];
	$inf_prs = $dt_prs['info'];
	$hre_prs = $dt_prs['heure'];
	$id_dev_jrn = $dt_prs['id_jrn'];
	$dt_jrn = ftc_ass(select("id_mdl","dev_jrn","id",$id_dev_jrn));
	$id_dev_mdl = $dt_jrn['id_mdl'];
	$dt_mdl = ftc_ass(select("trf","dev_mdl","id",$id_dev_mdl));
	$trf_mdl = $dt_mdl['trf'];
	$rq_rgn = sel_quo("id_rgn","dev_mdl_rgn","id_mdl",$id_dev_mdl);
	while($dt_rgn = ftc_ass($rq_rgn)){$ids_rgn[] = $dt_rgn['id_rgn'];}
	include("../cfg/vll.php");
	unset($ids_rgn);
	if($trf_mdl){$nb_rmn_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl_rmn","id_mdl",$id_dev_mdl));}
	else{$nb_rmn_crc = ftc_ass(select("COUNT(*) as total","dev_crc_rmn","id_crc",$id_dev_crc));}
	if($id_ctg_prs ==1 or $id_ctg_prs ==9 or $id_ctg_prs ==11 or $id_ctg_prs ==12 or $id_ctg_prs ==17){
		$rq_hbr = select("id_vll,rgm","dev_hbr","id_cat!=0 AND id_prs",$id_dev_prs,"sel DESC, opt DESC");
		if(num_rows($rq_hbr)>0){
			$dt_hbr = ftc_ass($rq_hbr);
			$id_vll = $vll_srv = $dt_hbr['id_vll'];
			$id_rgm = $dt_hbr['rgm'];
		}
	}
	else{$vll_srv = 0;}
}
?>
<table>
	<tr>
		<td class="dsg" width="58%">
			<div style="float: left; padding-right: 5px;"><input id="prs_heure<?php echo $id_dev_prs ?>" type="time" <?php if(!$aut['res']){echo ' disabled';} ?> value="<?php if(!is_null($hre_prs)){echo date("H:i", strtotime($hre_prs));} ?>" onblur="maj('dev_prs','heure',this.value,<?php echo $id_dev_prs ?>);" onclick="this.focus();"/></div>
<?php
	if($id_ctg_prs !=1 and $id_ctg_prs !=9  and $id_ctg_prs !=11 and $id_ctg_prs !=12 and $id_ctg_prs !=17){
?>
			<div style="display: block; overflow: hidden;"><input type="text" <?php if(!$aut['res']){echo ' disabled';} ?> placeholder="<?php echo $txt->infrva->$id_lng; ?>" style="width: 100%;" value="<?php echo stripslashes(htmlspecialchars($inf_prs)) ?>" onchange="maj('dev_prs','info',this.value,<?php echo $id_dev_prs ?>)" /></div>
<?php
	}
	elseif(($trf_mdl and $nb_rmn_mdl['total']>1) or (!$trf_mdl and $nb_rmn_crc['total']>1)){
?>
			<span class="vdfp"><?php echo $txt->pax->rooming->$id_lng ?></span>
			<span id="prs_rmn<?php echo $id_dev_prs ?>" style="dib"><?php include("vue_prs_rmn.php"); ?></span>
<?php
	}
?>
		</td>
		<td class="dsg">
<?php
	if(($aut['dev'] and $cnf<1) or $aut['res']){
		if($id_cat_prs == 0){
			$id_vll = 0;
			$id_rgm = 0;
?>
			<span class="vdfp"><?php echo $txt->ajt->$id_lng.':'; ?></span>
			<span id="prs_vll_ctg<?php echo $id_dev_prs ?>" class="vll"><?php include("vue_prs_vll_ctg.php"); ?></span>
<?php
		}
		elseif($vll_srv != 0){
			$cbl = 'hbr_opt';
			$id_dev_hbr = 0;
			$id_hbr = 0;
?>
				<span class="vdfp"><?php echo $txt->ajtopthbr->$id_lng.':'; ?></span>
				<input type="hidden" id="vll_hbr_opt<?php echo $id_dev_prs ?>" value="<?php echo $id_vll ?>" />
				<input type="hidden" id="rgm_hbr_opt<?php echo $id_dev_prs ?>" value="<?php echo $id_rgm ?>" />
				<span id="prs_hbr<?php echo $id_dev_prs ?>"><?php include("vue_prs_hbr.php"); ?></span>
<?php
		}
		else{echo $txt->supcatprs->$id_lng;}
	}
?>
		</td>
	</tr>
</table>
