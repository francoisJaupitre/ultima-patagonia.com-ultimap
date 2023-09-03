<?php
if(isset($_POST['id_dev_jrn'])){
	$id_dev_jrn = $_POST['id_dev_jrn'];
	$vue_jrn = $_POST['vue'];
	$id_dev_crc = $_POST['id_dev_crc'];
	$cnf = $_POST['cnf'];
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	include("../prm/col.php");
	$dt_jrn = ftc_ass(select("id_cat,opt,date,ord,nom,titre,id_mdl","dev_jrn","id",$id_dev_jrn));
	$id_cat_jrn = $dt_jrn['id_cat'];
	$opt_jrn = $dt_jrn['opt'];
	$date_jrn = $dt_jrn['date'];
	$ord_jrn = $dt_jrn['ord'];
	$nom_jrn = $dt_jrn['nom'];
	$ttr_jrn = $dt_jrn['titre'];
	$id_dev_mdl = $dt_jrn['id_mdl'];
	$rq_dev_jrn = sel_quo("*","dev_jrn",array("ord","id_mdl"),array($ord_jrn,$id_dev_mdl),"opt DESC");
	while($dt_dev_jrn = ftc_ass($rq_dev_jrn)){
		$jrn_opt_id_cat[] = $dt_dev_jrn['id_cat'];
		$jrn_rpl_id_cat[] = $dt_dev_jrn['id_cat'];
	}
	if(!$opt_jrn){
		$dt_sel_jrn = ftc_ass(select("id","dev_jrn","id_mdl=".$id_dev_mdl." AND opt=1 AND ord",$ord_jrn));
		$id_sel_jrn = $dt_sel_jrn['id'];
	}
	$nb_jrn_opt = ftc_ass(select("COUNT(*) as total","dev_jrn","ord=".$ord_jrn." and id_mdl",$id_dev_mdl));
	if($nb_jrn_opt['total'] > 1){$flg_jrn_opt = true;}
	else{$flg_jrn_opt = false;}
	$dt_mdl = ftc_ass(select("id_cat,col,ord,trf,fus","dev_mdl","id",$id_dev_mdl));
	$id_cat_mdl = $dt_mdl['id_cat'];
	$id_col_mdl = $dt_mdl['col'];
	$trf_mdl = $dt_mdl['trf'];
	$fus_mdl = $dt_mdl['fus'];
	$ord_mdl = $dt_mdl['ord'];
	$min_jrn = ftc_num(select("MIN(ord)","dev_jrn","id_mdl",$id_dev_mdl));
	$max_jrn = ftc_num(select("MAX(ord)","dev_jrn","id_mdl",$id_dev_mdl));
	$nb_mdl = ftc_ass(select("COUNT(*) as total","dev_mdl","id_crc",$id_dev_crc));
}
if($id_cat_mdl>0 and $id_cat_jrn>0){
	$rq_cat_mdl_jrn = select("opt","cat_mdl_jrn","id_mdl=".$id_cat_mdl." AND id_jrn",$id_cat_jrn);
	if(num_rows($rq_cat_mdl_jrn)==1){
		$dt_cat_mdl_jrn = ftc_ass($rq_cat_mdl_jrn);
		$opt_cat_mdl = $dt_cat_mdl_jrn['opt'];
	}
	else{$opt_cat_mdl = 1;}
}
else{$opt_cat_mdl = 0;}
if($date_jrn!='0000-00-00'){$jour= date("D",strtotime($date_jrn));}
else{$jour = 'x';}
$nb_prs = ftc_ass(select("COUNT(*) as total","dev_prs","id_jrn",$id_dev_jrn));
?>
<tr>
<?php
if($id_cat_jrn>-1){
?>
	<td onclick="scrollup();"><img src="../prm/img/up.png"></td>
<?php
}
?>
	<td <?php if($id_cat_jrn>-1){echo 'width="56%"';} ?> class="<?php if($id_cat_jrn==-1){echo 'dsg2';}elseif($opt_jrn){echo 'lcrl';}else{echo 'tht';} ?>" style="color: #<?php echo $col[$id_col_mdl]; ?>">
		<div style="float: left;">
			<input <?php if(!$aut['dev'] or $cnf>0){echo ' disabled';} ?> type="text" autocomplete="off" placeholder="<?php echo $txt->phdate->$id_lng; ?>" class="w74" style=" float: right; color: #<?php echo $col[$id_col_mdl] ?>;" value="<?php if($date_jrn!='0000-00-00'){echo date("d/m/Y", strtotime($date_jrn));} ?>" onchange="sortJrnByDate(this.value,<?php echo ($id_dev_jrn.','.$id_dev_mdl); ?>)" />
<?php
if($id_cat_jrn>-1){
?>
			<input id="chk_jrn<?php echo $id_dev_jrn ?>" class="dev_img chk_img vue_jrn" type="checkbox" autocomplete="off" <?php if($vue_jrn==1){echo 'checked';} ?> onclick="closeRichText('dsc_jrn,dt_jrn',<?php echo $id_dev_jrn ?>,function(){chk_jrn(<?php echo $id_dev_jrn ?>)},function(){document.getElementById('chk_jrn<?php echo $id_dev_jrn ?>').checked = true});" />
			<label for="chk_jrn<?php echo $id_dev_jrn ?>"><img src="../prm/img/maxi.png" /></label>
<?php
}
?>
			<strong><?php if($opt_jrn){echo $txt->jour->$id_lng;} else{echo $txt->opt->$id_lng;} ?></strong>
			<input <?php if(!$aut['dev'] or !$opt_jrn or $cnf>0){echo ' disabled';} ?> type="number" style="width: 30px; color: #<?php echo $col[$id_col_mdl] ?>;" value="<?php echo $ord_jrn; ?>" onchange="prevSortElem('jrn',this.value,<?php echo $id_dev_jrn.','.$id_dev_mdl.','.$id_cat_mdl ?>)" />
			<span style="display: inline-block; width: 95px; text-align: center;"><?php echo $txt->jours->$jour->$id_lng; ?></span>
		</div>
<?php
if($id_cat_jrn>-1){
?>
		<div style="margin-left: 300px; margin-right: 5px;">
			<input type="text" <?php if((!$aut['dev'] and $cnf<1) or (!$aut['res'] and $cnf>0)){echo ' disabled';} ?> id="jrn_titre<?php echo $id_dev_jrn ?>" style="color: #<?php echo $col[$id_col_mdl] ?>; width: 100%;" value="<?php echo stripslashes(htmlspecialchars($ttr_jrn)); ?>" onchange="maj('dev_jrn','titre',this.value,<?php echo $id_dev_jrn ?>)" />
		</div>
	</td>
	<td width="44%" class="<?php if($opt_jrn) {echo 'dsg';} else{echo 'dsg2';} ?>">
		<div style="float: right; height: 22px; position:relative;" onclick="vue_cmd('vue_cmd_jrn<?php echo $id_dev_jrn; ?>');">
<!--COMMANDES-->
			<img src="../prm/img/cmd.gif" />
			<div id="vue_cmd_jrn<?php echo $id_dev_jrn; ?>" class="cmd wsn">
				<strong><?php echo $txt->jrn->$id_lng; ?></strong>
				<ul>
<?php
	if($aut['dev'] and $cnf<1){
?>
					<li onclick="prevUpdateRates('jrn',<?php echo $id_dev_jrn.','.$id_dev_mdl ?>);document.getElementById('vue_cmd_jrn<?php echo $id_dev_jrn; ?>').style.display='none';"><?php echo $txt->acttrf->$id_lng; ?></li>
<?php
		if($id_cat_jrn == 0){
?>
					<li onclick="prevUpdateText('jrn',<?php echo $id_dev_jrn ?>);document.getElementById('vue_cmd_jrn<?php echo $id_dev_jrn; ?>').style.display='none';"><?php echo $txt->acttxt->$id_lng; ?></li>
<?php
		}
		if(!$trf_mdl and $ord_mdl > 1 and $ord_jrn == $min_jrn[0] and !$flg_jrn_opt){
?>
					<li onclick="closeRichText('dt_crc','',function(){prevChangeParent('jrnavt',<?php echo $id_dev_jrn.','.$id_dev_mdl ?>);})"><?php echo $txt->trsfjrnavt->$id_lng; ?></li>
<?php
		}
		if(!$trf_mdl and !$fus_mdl and $ord_mdl < $nb_mdl['total'] and $ord_jrn == $max_jrn[0] and !$flg_jrn_opt){
?>
					<li onclick="closeRichText('dt_crc','',function(){prevChangeParent('jrnapr',<?php echo $id_dev_jrn.','.$id_dev_mdl ?>);})"><?php echo $txt->trsfjrnapr->$id_lng; ?></li>
<?php
		}
	}
	if($aut['cat'] and $id_cat_jrn == 0){
?>
					<li onclick="grd('jrn',<?php echo $id_dev_jrn.','.$id_dev_mdl ?>);document.getElementById('vue_cmd_jrn<?php echo $id_dev_jrn; ?>').style.display='none';"><?php echo $txt->grd->$id_lng; ?></li>
<?php
	}
	if(($aut['dev'] and $cnf<1) or (!$opt_jrn and $aut['res'] and $cnf>0)){
?>
					<li onclick="sup('jrn',<?php echo $id_dev_jrn.','.$id_dev_mdl.',0,'.$id_cat_jrn.','.$id_cat_mdl.','.$id_dev_crc.','.$opt_jrn.','.$id_sel_jrn ?>);document.getElementById('vue_cmd_jrn<?php echo $id_dev_jrn; ?>').style.display='none';"><?php echo $txt->sup->$id_lng; ?></li>
<?php
	}
?>
				</ul>
<?php
	if($id_cat_jrn > 0 and $aut['dev']){
?>
				<br/>
				<strong><?php echo $txt->cat->$id_lng; ?></strong>
				<ul>
					<li onclick="prevUpdateText('jrn',<?php echo $id_dev_jrn ?>);document.getElementById('vue_cmd_jrn<?php echo $id_dev_jrn; ?>').style.display='none';"><?php echo $txt->acttxt->$id_lng; ?></li>
					<li onclick="prevUpdateElem('jrn',<?php echo $id_dev_jrn ?>);document.getElementById('vue_cmd_jrn<?php echo $id_dev_jrn; ?>').style.display='none';"><?php echo $txt->actprs->$id_lng; ?></li>
					<li onclick="sup_cat('jrn',<?php echo $id_dev_jrn.','.$id_dev_mdl ?> );document.getElementById('vue_cmd_jrn<?php echo $id_dev_jrn; ?>').style.display='none';"><?php echo $txt->supcat->$id_lng; ?></li>
				</ul>
<?php
	}
?>
			</div>
		</div>
		<div style="margin-right: 40px; text-align: center; font-weight: bold;">
			<div style="float: right; padding-left: 5px;">
				<span class="vatdib">
					<strong><?php echo $txt->trfopt->$id_lng; ?></strong>
					<input id="trfopt_jrn<?php echo $id_dev_jrn ?>" <?php if($opt_jrn or !$aut['dev']){echo ' disabled';} ?> type="checkbox" autocomplete="off" <?php if ($opt_jrn){echo('checked="checked"');} ?>
						onclick="
<?php
	if($flg_jrn_opt and !in_array($id_cat_jrn,$jrn_opt_id_cat)){
?>
							ask_sup_cat('jrn',<?php echo $id_dev_jrn.','.$id_cat_jrn.','.$id_dev_mdl.','.$id_dev_crc ?>);
<?php
	}
	else{
?>
							maj('dev_jrn','opt','1',<?php echo $id_dev_jrn.','.$id_dev_mdl ?>);
<?php
	}
?>
						" />
				</span>
			</div>
			<div style="display: block; overflow: hidden; text-align: center; font-weight: bold;">
<?php
	if($id_cat_jrn>0){
	?>
				<div style="padding: 2px; border: 1px solid grey"><span class="lnk inf<?php echo $id_cat_jrn ?>jrn" onmouseover="vue_elem('inf',<?php echo $id_cat_jrn ?>,'jrn')" onclick="window.parent.opn_frm('cat/ctr.php?cbl=jrn&id=<?php echo $id_cat_jrn ?>');"><?php echo stripslashes($nom_jrn) ?></span></div>
<?php
	}
	else{
?>
				<input type="text" id="nom_jrn<?php echo $id_dev_jrn ?>" <?php if(!$aut['dev']){echo ' disabled';} ?> placeholder="<?php echo $txt->jrnnom->$id_lng ?>" style="background-color: lightgrey; width: 100%;" value="<?php echo stripslashes($nom_jrn) ?>" onchange="maj('dev_jrn','nom',this.value,<?php echo $id_dev_jrn ?>)" />
<?php
	}
?>
			</div>
		</div>
<?php
}
else{
?>
		<div class="wsn" style="margin-left: 300px; margin-right: 5px; padding-top: 3px;">
			<span class="vdfp" style="margin-right: 10px;"><?php echo $txt->nosrv->$id_lng; ?></span>
<?php
	if(!$opt_jrn){
 ?>
 			<span class="vatdib">
				<input id="trfopt_jrn<?php echo $id_dev_jrn ?>" <?php if(!$aut['dev']){echo ' disabled';} ?> type="checkbox" autocomplete="off" onclick="maj('dev_jrn','opt','1',<?php echo $id_dev_jrn.','.$id_dev_mdl ?>);" />
			</span>
<?php
	}
	if(($aut['dev'] and $cnf<1) or (!$opt_jrn and $aut['res'] and $cnf>0)){
?>
			<span class="dib" onClick="sup('jrn',<?php echo $id_dev_jrn.','.$id_dev_mdl.',0,'.$id_cat_jrn.',-1,'.$id_dev_crc.','.$opt_jrn ?>);"><img src="../prm/img/sup.png" /></span>
<?php
	}
?>
		</div>
<?php
	if($nb_jrn_opt['total'] == count($jrn_opt_id_cat)){
?>
	</td>
	<td id="rpl_opt_jrn<?php echo $id_sel_jrn ?>">
		<span id="rpl_jrn<?php echo $id_sel_jrn ?>" class="ajt_jrn_rpl"><?php include("vue_rpl_jrn.php"); ?></span>
<?php
	}
}
?>
	</td>
</tr>
