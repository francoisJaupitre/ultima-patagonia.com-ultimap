<?php
if(isset($_POST['id_dev_prs'])){
	$id_dev_prs = $_POST['id_dev_prs'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/lgg.php");
	include("../prm/ctg_prs.php");
	include("../prm/res_prs.php");
	$dt_prs = ftc_ass(select("id_cat,opt,ord,nom,titre,ctg,id_jrn,res,dt_res,taux","dev_prs","id",$id_dev_prs));
	$id_cat_prs = $dt_prs['id_cat'];
	$opt_prs = $dt_prs['opt'];
	$ord_prs = $dt_prs['ord'];
	$nom_prs = $dt_prs['nom'];
	$ttr_prs = $dt_prs['titre'];
	$id_ctg_prs = $dt_prs['ctg'];
	$id_res_prs = $dt_prs['res'];
	$dt_res_prs = $dt_prs['dt_res'];
	$tx_prs = $dt_prs['taux'];
	$id_dev_jrn = $dt_prs['id_jrn'];
	if(!$opt_prs){
		$dt_ant_prs = ftc_ass(select("id","dev_prs","id_jrn=".$id_dev_jrn." AND ord",$ord_prs,"opt DESC,nom,id"));
		$id_ant_prs = $dt_ant_prs['id'];
	}
	$nb_prs_opt = ftc_ass(select("COUNT(*) as total","dev_prs","ord=".$ord_prs." and id_jrn",$id_dev_jrn));
	if($nb_prs_opt['total'] > 1){$flg_prs_opt = true;}
	else{$flg_prs_opt = false;}
	$dt_jrn = ftc_ass(select("id_cat,id_mdl,ord","dev_jrn","id",$id_dev_jrn));
	$id_cat_jrn = $dt_jrn['id_cat'];
	$id_dev_mdl = $dt_jrn['id_mdl'];
	$ord_jrn = $dt_jrn['ord'];
	$min_jrn = ftc_num(select("MIN(ord)","dev_jrn","id_mdl",$id_dev_mdl));
	$max_jrn = ftc_num(select("MAX(ord)","dev_jrn","id_mdl",$id_dev_mdl));
	$dt_mdl = ftc_ass(select("vue_sgl,vue_tpl,vue_qdp,trf,ptl","dev_mdl","id",$id_dev_mdl));
}
if($id_cat_jrn>0 and $id_cat_prs>0){
	$rq_cat_jrn_prs = select("opt","cat_jrn_prs","id_jrn=".$id_cat_jrn." AND id_prs",$id_cat_prs);
	if(num_rows($rq_cat_jrn_prs)==1){
		$dt_cat_jrn_prs = ftc_ass($rq_cat_jrn_prs);
		$opt_cat_jrn = $dt_cat_jrn_prs['opt'];
	}
	else{$opt_cat_jrn = 1;/*2X MEME PRESTATION EN 1 DIA*/}
}
else{$opt_cat_jrn = 0;}
$rq_srv = sel_quo("id","dev_srv","id_prs",$id_dev_prs);
$nb_srv = num_rows($rq_srv);
$rq_hbr = sel_quo("id","dev_hbr","id_prs",$id_dev_prs);
$nb_hbr = num_rows($rq_hbr);
?>
	<td width="58%" class="<?php if($opt_prs){echo 'lmcf';} else{echo 'tht';} ?>">
		<div style="float: left; padding-right: 5px;">
			<strong><?php if($opt_prs){echo $txt->prs->$id_lng;} else{echo $txt->opt->$id_lng;} ?></strong>
			<input type="number" <?php if((!$aut['dev'] and $cnf<1) or (!$aut['res'] and $cnf>0)){echo ' disabled';} ?> style="width: 25px;" value="<?php echo $ord_prs; ?>" onchange="prevSortElem('prs',this.value,<?php echo $id_dev_prs.','.$id_dev_jrn.','.$id_cat_jrn.','.$id_dev_mdl ?>)" />
		</div>
		<div style="display: block; overflow: hidden;">
			<input type="text" <?php if((!$aut['dev'] and $cnf<1) or (!$aut['res'] and $cnf>0)){echo ' disabled';} ?> id="prs_titre<?php echo $id_dev_prs ?>" class="w-100" value="<?php echo stripslashes(htmlspecialchars($ttr_prs)) ?>" onchange="maj('dev_prs','titre',this.value,<?php echo $id_dev_prs ?>)" />
		</div>
	</td>
	<td width="42%" class="<?php if(($opt_cat_jrn and $opt_prs) or ($opt_prs and $flg_prs_opt)){echo 'dsg';} else{echo 'dsg2';} ?>">
		<div style="float: right; padding-left: 5px; height: 22px;" onclick="vue_cmd('vue_cmd_prs<?php echo $id_dev_prs; ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif">
			<div id="vue_cmd_prs<?php echo $id_dev_prs; ?>" class="cmd wsn">
				<strong><?php echo $txt->prs->$id_lng; ?></strong>
				<ul>
<?php
if($aut['dev'] and $cnf<1){
?>
					<li onclick="prevUpdateRates('prs',<?php echo $id_dev_prs.','.$id_dev_jrn ?>);document.getElementById('vue_cmd_prs<?php echo $id_dev_prs; ?>').style.display='none';"><?php echo $txt->acttrf->$id_lng; ?></li>
<?php
	if($id_cat_prs == 0){
?>
					<li onclick="prevUpdateText('prs',<?php echo $id_dev_prs ?>);document.getElementById('vue_cmd_prs<?php echo $id_dev_prs; ?>').style.display='none';"><?php echo $txt->acttxt->$id_lng; ?></li>
<?php
	}
	if($ord_jrn > $min_jrn[0] and !$flg_prs_opt){
?>
					<li onclick="closeRichText('dt_mdl','',function(){prevChangeParent('prsavt',<?php echo $id_dev_prs.','.$id_dev_jrn.','.$id_dev_mdl ?>);})"><?php echo $txt->trsfprsavt->$id_lng; ?></li>
<?php
	}
	if($ord_jrn < $max_jrn[0] and !$flg_prs_opt){
?>
					<li onclick="closeRichText('dt_mdl','',function(){prevChangeParent('prsapr',<?php echo $id_dev_prs.','.$id_dev_jrn.','.$id_dev_mdl ?>);})"><?php echo $txt->trsfprsapr->$id_lng; ?></li>
<?php
	}
}
if($aut['cat'] and $id_cat_prs == 0){
?>
					<li onclick="saveToCat('prs',<?php echo $id_dev_prs.','.$id_dev_jrn ?>);document.getElementById('vue_cmd_prs<?php echo $id_dev_prs; ?>').style.display='none';"><?php echo $txt->grd->$id_lng; ?></li>
<?php
}
if(($aut['dev'] and $cnf<1) or (!$opt_prs and $aut['res'] and $cnf>0)){
?>
					<li onclick="sup('prs',<?php echo $id_dev_prs.','.$id_dev_jrn.',0,'.$id_cat_prs.','.$id_cat_jrn.','.$id_dev_mdl.','.$opt_prs.','.$id_ant_prs ?>);src_prs(<?php echo $id_cat_prs.',0,'.$id_dev_jrn ?>,'sup',0);document.getElementById('vue_cmd_prs<?php echo $id_dev_prs; ?>').style.display='none';"><?php echo $txt->sup->$id_lng; ?></li>
<?php
}
?>
				</ul>
<?php
if($id_cat_prs > 0 and $aut['dev']){
?>
				<br/>
				<strong><?php echo $txt->cat->$id_lng; ?></strong>
				<ul>

					<li onclick="prevUpdateText('prs',<?php echo $id_dev_prs ?>);document.getElementById('vue_cmd_prs<?php echo $id_dev_prs; ?>').style.display='none';"><?php echo $txt->acttxt->$id_lng; ?></li>
					<li onclick="prevUpdateElem('prs',<?php echo $id_dev_prs ?>);document.getElementById('vue_cmd_prs<?php echo $id_dev_prs; ?>').style.display='none';"><?php echo $txt->actelem->$id_lng; ?></li>
					<li onclick="sup_cat('prs',<?php echo $id_dev_prs.','.$id_dev_jrn.','.$id_dev_mdl ?> );document.getElementById('vue_cmd_prs<?php echo $id_dev_prs; ?>').style.display='none';"><?php echo $txt->supcat->$id_lng; ?></li>
				</ul>
<?php
}
?>
			</div>
		</div>
		<div style="float: left; padding-right: 5px;">
			<span id="prs_ctg_prs<?php echo $id_dev_prs ?>" style="display: inline-block"><?php include("vue_prs_ctg_prs.php"); ?></span>
		</div>
		<div style="display: block; overflow: hidden;">
			<div style="float: right; padding-left: 5px;">
<?php
if($cnf>0 or $id_res_prs!=0){
?>
				<span id="prs_res<?php echo $id_dev_prs ?>" style="display: inline-block"><?php include("vue_prs_res.php"); ?></span>
<?php
}
?>
				<span class="vatdib">
					<strong><?php echo $txt->trfopt->$id_lng; ?></strong>
					<input id="trfopt_prs<?php echo $id_dev_prs ?>" <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($opt_prs){echo('checked="checked"');} ?>
						onclick="
							if(this.checked){maj('dev_prs','opt','1',<?php echo $id_dev_prs.','.$id_dev_jrn ?>);src_prs(<?php echo $id_cat_prs.',0,'.$id_dev_jrn ?>,'sel_opt',0);}
							else{
<?php
if(($opt_cat_jrn and $opt_prs) or ($opt_prs and $flg_prs_opt)){
?>
								ask_sup_cat('prs',<?php echo $id_dev_prs.','.$id_cat_prs.','.$id_dev_jrn.','.$id_dev_mdl.','.$id_dev_crc ?>);
<?php
}
else{
?>
								maj('dev_prs','opt','0',<?php echo $id_dev_prs.','.$id_dev_jrn ?>);
<?php
}
?>
							}
						" />
				</span>
			</div>
			<div style="display: block; overflow: hidden; text-align: center; font-weight: bold;">
<?php
if($id_cat_prs>0){
?>
				<div style="padding: 2px; border: 1px solid grey"><span class="lnk inf<?php echo $id_cat_prs ?>prs" onmouseover="vue_elem('inf',<?php echo $id_cat_prs ?>,'prs')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=prs&id=<?php echo $id_cat_prs ?>');"><?php echo stripslashes($nom_prs) ?></span></div>
<?php
}
else{
?>
				<input type="text" id="nom_prs<?php echo $id_dev_prs ?>" <?php if(!$aut['dev']){echo ' disabled';} ?> placeholder="<?php echo $txt->prsnom->$id_lng ?>" style="background-color: lightgrey; width: 100%;" value="<?php echo stripslashes($nom_prs) ?>" onchange="maj('dev_prs','nom',this.value,<?php echo $id_dev_prs ?>)" />
<?php
}
?>
			</div>
		</div>
	</td>
