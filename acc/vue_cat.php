<?php
if(isset($_POST['cbl'])) {
	$cbl = $_POST['cbl'];
	unset($_POST['cbl']);
	$txt = simplexml_load_file('txt.xml');
	include("../prm/fct.php");
	include("../prm/aut.php");
	$id_clt = $id_rgn = $id_vll = $id_ctg = $web = 0;
}
$rang = 1;
$whr = $flt = '';
?>
<table id="tab_cat" class="tbl_acc">
	<tr class="fwb">
<?php
switch($cbl) {
	case 'crc':
		include("../cfg/clt.php");
		if(isset($_POST['id_clt'])) {$id_clt = $_POST['id_clt'];}
		if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
		if(isset($_POST['web'])) {$web = $_POST['web'];}
?>
		<td class='tbl'><input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('crc','crc',this.value);" /></td>
		<td class='tbl'>
<?php
		if($flt) {$whr = "(nom LIKE '%".$flt."%' OR titre LIKE '%".$flt."%' OR dsc LIKE '%".$flt."%' OR web_uid LIKE '%".$flt."%') AND ";}
		if($web) {$whr .= "web_uid != '' AND ";}
		if(!$id_clt) {
			if(!$web and !$flt) {$nb_crc = ftc_ass(sel_whe("COUNT(*) as total","cat_crc",$whr."1","1"));}
			else{$nb_crc = ftc_ass(sel_whe("COUNT(*) as total","cat_crc LEFT JOIN cat_crc_txt  ON cat_crc.id = cat_crc_txt.id_crc AND lgg=".$id_lgg,$whr."1","1"));}
		}
		else{
			if(!$web and !$flt) {$nb_crc = ftc_ass(sel_quo("COUNT(DISTINCT cat_crc.id) as total","cat_crc INNER JOIN cat_crc_clt ON cat_crc_clt.id_crc = cat_crc.id",$whr."id_clt",$id_clt));}
			else{$nb_crc = ftc_ass(sel_quo("COUNT(DISTINCT cat_crc.id) as total","cat_crc_clt LEFT JOIN (cat_crc LEFT JOIN cat_crc_txt ON cat_crc.id = cat_crc_txt.id_crc AND lgg=".$id_lgg.") ON cat_crc_clt.id_clt = cat_crc.id",$whr."id_clt",$id_clt));}
		}
		echo $nb_crc['total'].' '.$txt->crc->$id_lng;
?>
			| WEB SOLO
			<input name="chk_web" type="hidden" value="0" />
			<input id="web" name="chk_web" type="checkbox" <?php if($web) {echo ' checked="true"';} ?> onclick="vue_cat('<?php echo $cbl ?>');" value="1">
		</td>
		<td class='tbl'>
			<div class="sel" onclick="vue_cmd('sel_clt')">
				<img src="../prm/img/sel.png" />
				<div>
					<input type="hidden" id="clt" value="<?php echo $id_clt ?>" />
<?php
		if(!$id_clt) {echo $txt->clt->$id_lng;}
		else{echo $clt[$id_clt];}
?>
				</div>
			</div>
			<div id="sel_clt" class="cmd mw200">
				<input type="text" id="ipt_sel_clt" onkeyup="auto_lst('<?php echo $cbl ?>','clt',this.value,event);" />
				<div id="lst_clt"><?php include("vue_lst_clt.php") ?></div>
			</div>
		</td>
		<td class="text-center" id="addElem"><img src="../prm/img/ajt.png"/></td>
<?php
		break;
case 'mdl':
  include("../cfg/rgn.php");
  if(isset($_POST['id_rgn'])) {$id_rgn = $_POST['id_rgn'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
	if(isset($_POST['web'])) {$web = $_POST['web'];}
?>
	<td class='tbl'><input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('mdl','mdl',this.value);" /></td>
  <td class='tbl'>
<?php
	$whr = '';
	if($flt) {$whr = "(nom LIKE '%".$flt."%' OR titre LIKE '%".$flt."%' OR dsc LIKE '%".$flt."%' OR web_uid LIKE '%".$flt."%') AND ";}
	if($web) {$whr .= "web_uid != '' AND ";}
  if(!$id_rgn) {
		if(!$web and !$flt) {$nb_mdl = ftc_ass(sel_whe("COUNT(*) as total","cat_mdl",$whr."1","1"));}
		else{$nb_mdl = ftc_ass(sel_whe("COUNT(*) as total","cat_mdl LEFT JOIN cat_mdl_txt  ON cat_mdl.id = cat_mdl_txt.id_mdl AND lgg=".$id_lgg,$whr."1","1"));}
	}
  else{
		if(!$web and !$flt) {$nb_mdl = ftc_ass(sel_quo("COUNT(DISTINCT cat_mdl.id) as total","cat_mdl_rgn INNER JOIN cat_mdl ON cat_mdl_rgn.id_mdl = cat_mdl.id",$whr."id_rgn",$id_rgn));}
		else{$nb_mdl = ftc_ass(sel_quo("COUNT(DISTINCT cat_mdl.id) as total","cat_mdl_rgn LEFT JOIN (cat_mdl LEFT JOIN cat_mdl_txt ON cat_mdl.id = cat_mdl_txt.id_mdl AND lgg=".$id_lgg.") ON cat_mdl_rgn.id_mdl = cat_mdl.id",$whr."id_rgn",$id_rgn));}
	}
  echo $nb_mdl['total'].' '.$txt->mdl->$id_lng;
?>
		| WEB SOLO
		<input name="chk_web" type="hidden" value="0" />
		<input id="web" name="chk_web" type="checkbox" <?php if($web) {echo ' checked="true"';} ?> onclick="vue_cat('<?php echo $cbl ?>');" value="1">
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_rgn')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="rgn" value="<?php echo $id_rgn ?>" />
<?php
  if(!$id_rgn) {echo $txt->rgn->$id_lng;}
  else{echo $rgn[$id_rgn];}
?>
      </div>
    </div>
    <div id="sel_rgn" class="cmd mw200">
      <input type="text" id="ipt_sel_rgn" onkeyup="auto_lst('<?php echo $cbl ?>','rgn',this.value,event);" />
      <div id="lst_rgn"><?php include("vue_lst_rgn.php") ?></div>
    </div>
  </td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png" /></td>
<?php
  break;
case 'jrn':
  include("../cfg/vll.php");
  if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
	<td class='tbl'><input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('jrn','jrn',this.value);" /></td>
  <td class='tbl'>
<?php
	if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
  if(!$id_vll) {$nb_jrn = ftc_ass(sel_whe("COUNT(*) as total","cat_jrn",$whr."1","1"));}
  else{$nb_jrn =  ftc_ass(sel_quo("COUNT(DISTINCT cat_jrn.id) as total","cat_jrn_vll INNER JOIN cat_jrn ON cat_jrn_vll.id_jrn = cat_jrn.id",$whr."id_vll",$id_vll));}
  echo $nb_jrn['total'].' '.$txt->jrn->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_vll')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="vll" value="<?php echo $id_vll ?>" />
<?php
  if(!$id_vll) {echo $txt->vll->$id_lng;}
  else{echo $vll[$id_vll];}
?>
      </div>
    </div>
    <div id="sel_vll" class="cmd mw200">
      <input type="text" id="ipt_sel_vll" onkeyup="auto_lst('<?php echo $cbl ?>','vll',this.value,event);" />
      <div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
    </div>
  </td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png"/></td>
<?php
  break;
case 'prs':
  include("../prm/lgg.php");
  include("../prm/ctg_prs.php");
  include("../cfg/vll.php");
  if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
  if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
	<td class='tbl'><input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('prs','prs',this.value);" /></td>
  <td class='tbl'>
<?php
	if($flt) {$whr = "cat_prs.nom LIKE '%".$flt."%' AND ";}
  if(!$id_vll) {
    if($id_ctg!=0) {$nb_prs = ftc_ass(sel_quo("COUNT(*) as total","cat_prs",$whr."ctg",$id_ctg));}
    else{$nb_prs = ftc_ass(sel_whe("COUNT(*) as total","cat_prs",$whr."1","1"));}
  }
  else{
    if($id_ctg!=0) {$nb_prs =  ftc_ass(sel_quo("COUNT(DISTINCT cat_prs.id) as total","cat_prs_lieu INNER JOIN cat_prs ON cat_prs_lieu.id_prs = cat_prs.id AND ctg =".$id_ctg." INNER JOIN cat_lieu ON cat_prs_lieu.id_lieu = cat_lieu.id",$whr."id_vll",$id_vll));}
    else{$nb_prs =  ftc_ass(sel_quo("COUNT(DISTINCT cat_prs.id) as total","cat_prs_lieu INNER JOIN cat_prs ON cat_prs_lieu.id_prs = cat_prs.id INNER JOIN cat_lieu ON cat_prs_lieu.id_lieu = cat_lieu.id",$whr."id_vll",$id_vll));}
  }
  echo $nb_prs['total'].' '.$txt->prs->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_vll')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="vll" value="<?php echo $id_vll ?>" />
<?php
  if(!$id_vll) {echo $txt->vll->$id_lng;}
  else{echo $vll[$id_vll];}
?>
      </div>
    </div>
    <div id="sel_vll" class="cmd mw200">
      <input type="text" id="ipt_sel_vll" onkeyup="auto_lst('<?php echo $cbl ?>','vll',this.value,event);" />
      <div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
    </div>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_ctg')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="ctg" value="<?php echo $id_ctg ?>" />
        <input type="hidden" id="ctg_prs" value="<?php echo $id_ctg ?>" />
<?php
  if(!$id_ctg) {echo $txt->lst->cat->ctg->$id_lng;}
  else{echo $ctg_prs[$id_lng][$id_ctg];}
?>
      </div>
    </div>
    <div id="sel_ctg" class="cmd mw200">
      <input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('<?php echo $cbl ?>','ctg_prs',this.value,event);" />
      <div id="lst_ctg_prs"><?php include("vue_lst_ctg_prs.php") ?></div>
    </div>
  </td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png"/></td>
<?php
  break;
case 'srv':
  include("../prm/lgg.php");
  include("../prm/ctg_srv.php");
  include("../cfg/vll.php");
  if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
  if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
	<td class='tbl'><input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('srv','srv',this.value);" /></td>
  <td class='tbl'>
<?php
	if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
  if(!$id_vll and !$id_ctg) {$nb_srv = ftc_ass(sel_whe("COUNT(*) as total","cat_srv",$whr."1","1"));}
  elseif($id_vll!=0 and $id_ctg!=0) {$nb_srv = ftc_ass(sel_quo("COUNT(*) as total","cat_srv",$whr."ctg=".$id_ctg." AND id_vll",$id_vll));}
  elseif($id_vll!=0) {$nb_srv = ftc_ass(sel_quo("COUNT(*) as total","cat_srv",$whr."id_vll",$id_vll));}
  else{$nb_srv = ftc_ass(sel_quo("COUNT(*) as total","cat_srv",$whr."ctg",$id_ctg));}
  echo $nb_srv['total'].' '.$txt->srv->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_vll')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="vll" value="<?php echo $id_vll ?>" />
<?php
  if(!$id_vll) {echo $txt->vll->$id_lng;}
  else{echo $vll[$id_vll];}
?>
      </div>
    </div>
    <div id="sel_vll" class="cmd mw200">
      <input type="text" id="ipt_sel_vll" onkeyup="auto_lst('<?php echo $cbl ?>','vll',this.value,event);" />
      <div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
    </div>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_ctg')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="ctg" value="<?php echo $id_ctg ?>" />
        <input type="hidden" id="ctg_srv" value="<?php echo $id_ctg ?>" />
<?php
  if(!$id_ctg) {echo $txt->lst->cat->ctg->$id_lng;}
  else{echo $ctg_srv[$id_lng][$id_ctg];}
?>
      </div>
    </div>
    <div id="sel_ctg" class="cmd mw200">
      <input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('<?php echo $cbl ?>','ctg_srv',this.value,event);" />
      <div id="lst_ctg_srv"><?php include("vue_lst_ctg_srv.php") ?></div>
    </div>
  </td>
  <td class='tbl'><?php echo $txt->lst->cat->datemaxi->$id_lng; ?></td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png"/></td>
<?php
  break;
case 'hbr':
  include("../prm/lgg.php");
  include("../cfg/ctg_hbr.php");
  include("../cfg/vll.php");
  if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
  if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
	<td class='tbl'><input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('hbr','hbr',this.value);" /></td>
  <td class='tbl'>
<?php
	if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
  if($id_vll!=0) {
    if($id_ctg!=0) {$nb_hbr = ftc_ass(sel_quo("COUNT(*) as total","cat_hbr",$whr."ctg=".$id_ctg." AND id_vll",$id_vll));}
    else{$nb_hbr = ftc_ass(sel_quo("COUNT(*) as total","cat_hbr",$whr."id_vll",$id_vll));}
  }
  else{
    if($id_ctg!=0) {$nb_hbr = ftc_ass(sel_quo("COUNT(*) as total","cat_hbr",$whr."ctg",$id_ctg));}
    else{$nb_hbr = ftc_ass(sel_whe("COUNT(*) as total","cat_hbr",$whr." 1","1"));}
  }
  echo $nb_hbr['total'].' '.$txt->hbr->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_vll');">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="vll" value="<?php echo $id_vll ?>" />
<?php
  if(!$id_vll) {echo $txt->vll->$id_lng;}
  else{echo $vll[$id_vll];}
?>
      </div>
    </div>
    <div id="sel_vll" class="cmd mw200">
      <input type="text" id="ipt_sel_vll" onkeyup="auto_lst('<?php echo $cbl ?>','vll',this.value,event);" />
      <div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
    </div>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_ctg')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="ctg" value="<?php echo $id_ctg ?>" />
        <input type="hidden" id="ctg_hbr" value="<?php echo $id_ctg ?>" />
<?php
  if(!$id_ctg) {echo $txt->lst->cat->ctg->$id_lng;}
  else{echo $ctg_hbr[$id_lng][$id_ctg];}
?>
      </div>
    </div>
    <div id="sel_ctg" class="cmd mw200">
      <input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('<?php echo $cbl ?>','ctg_hbr',this.value,event);" />
      <div id="lst_ctg_hbr"><?php include("vue_lst_ctg_hbr.php") ?></div>
    </div>
  </td>
  <td class='tbl'><?php echo $txt->lst->cat->datemaxi->$id_lng; ?></td>
	<td class='tbl'><?php echo $txt->lst->cat->nvtrf->$id_lng; ?></td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png" /></td>
<?php
  break;
case 'clt':
  include("../cfg/ctg_clt.php");
  if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
  <td class='tbl'>
		<input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('clt','clt',this.value);" /><br />
<?php
if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
  if(!$id_ctg) {$nb_clt = ftc_ass(sel_whe("COUNT(*) as total","cat_clt",$whr."1","1"));}
  else{$nb_clt = ftc_ass(sel_quo("COUNT(*) as total","cat_clt",$whr."id_ctg",$id_ctg));}
  echo $nb_clt['total'].' '.$txt->clt->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_ctg')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="ctg_clt" value="<?php echo $id_ctg ?>" />
<?php
  if(!$id_ctg) {echo $txt->lst->cat->ctg->$id_lng;}
  else{echo $nom_ctg_clt[$id_ctg];}
?>
      </div>
    </div>
    <div id="sel_ctg" class="cmd mw200">
      <input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('<?php echo $cbl ?>','ctg_clt',this.value,event);" />
      <div id="lst_ctg_clt"><?php include("vue_lst_ctg_clt.php") ?></div>
    </div>
  </td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png" /></td>
<?php
  break;
case 'frn':
  include("../prm/lgg.php");
  include("../prm/ctg_srv.php");
  include("../cfg/vll.php");
  if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
  if(isset($_POST['id_ctg'])) {$id_ctg = $_POST['id_ctg'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
  <td class='tbl'>
		<input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('frn','frn',this.value);" /><br />
<?php
	if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
  if(!$id_vll) {
    if($id_ctg!=0) {$nb_frn = ftc_ass(sel_quo("COUNT(DISTINCT cat_frn.id) as total","cat_frn_ctg_srv INNER JOIN cat_frn ON cat_frn_ctg_srv.id_frn = cat_frn.id",$whr."ctg_srv",$id_ctg));}
    else{$nb_frn = ftc_ass(sel_whe("COUNT(*) as total","cat_frn",$whr." 1","1"));}
  }
  else{
    if($id_ctg!=0) {$nb_frn = ftc_ass(sel_quo("COUNT(DISTINCT cat_frn.id) as total","cat_frn_vll INNER JOIN (cat_frn INNER JOIN cat_frn_ctg_srv ON cat_frn_ctg_srv.id_frn = cat_frn.id) ON cat_frn_vll.id_frn = cat_frn.id",$whr."ctg_srv=".$id_ctg." AND id_vll",$id_vll));}
    else{$nb_frn =  ftc_ass(sel_quo("COUNT(DISTINCT cat_frn.id) as total","cat_frn_vll INNER JOIN cat_frn ON cat_frn_vll.id_frn = cat_frn.id",$whr."id_vll",$id_vll));}
  }
  echo $nb_frn['total'].' '.$txt->frn->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_vll');">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="vll" value="<?php echo $id_vll ?>" />
<?php
  if(!$id_vll) {echo $txt->vll->$id_lng;}
  else{echo $vll[$id_vll];}
?>
      </div>
    </div>
    <div id="sel_vll" class="cmd mw200">
      <input type="text" id="ipt_sel_vll" onkeyup="auto_lst('<?php echo $cbl ?>','vll',this.value,event);" />
      <div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
    </div>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_ctg')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="ctg" value="<?php echo $id_ctg ?>" />
        <input type="hidden" id="ctg_srv" value="<?php echo $id_ctg ?>" />
<?php
  if(!$id_ctg) {echo $txt->lst->cat->ctg->$id_lng;}
  else{echo $ctg_srv[$id_lng][$id_ctg];}
?>
      </div>
    </div>
    <div id="sel_ctg" class="cmd mw200">
      <input type="text" id="ipt_sel_ctg" onkeyup="auto_lst('<?php echo $cbl ?>','ctg_srv',this.value,event);" />
      <div id="lst_ctg_srv"><?php include("vue_lst_ctg_srv.php") ?></div>
    </div>
  </td>
	<td class='tbl'><?php echo $txt->lst->cat->nvtrf->$id_lng; ?></td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png" /></td>
<?php
  break;
case 'pic':
  include("../cfg/rgn.php");
  if(isset($_POST['id_rgn'])) {$id_rgn = $_POST['id_rgn'];}
?>
  <td class='tbl'>
<?php
  if(!$id_rgn) {$nb_pic = ftc_ass(sel_whe("COUNT(*) as total","cat_pic"));}
  else{$nb_pic = ftc_ass(sel_quo("COUNT(*) as total","cat_pic","id_rgn",$id_rgn));}
  echo $nb_pic['total'].' '.$txt->pic->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_rgn')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="rgn" value="<?php echo $id_rgn ?>" />
<?php
  if(!$id_rgn) {echo $txt->rgn->$id_lng;}
  else{echo $rgn[$id_rgn];}
?>
      </div>
    </div>
    <div id="sel_rgn" class="cmd mw200">
      <input type="text" id="ipt_sel_rgn" onkeyup="auto_lst('<?php echo $cbl ?>','rgn',this.value,event);" />
      <div id="lst_rgn"><?php include("vue_lst_rgn.php") ?></div>
    </div>
  </td>
  <td class="text-center" style="background: url(../prm/img/ajt.png) no-repeat center;"><input id="file" type="file" accept="image/*" onchange="up_img()" style="filter: alpha(opacity=0);opacity: 0; width: 33px;" /></td>
<?php
  break;
case 'rgn':
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
  <td class='tbl'>
		<input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('rgn','rgn',this.value);" /><br />
<?php
	if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
  $nb_rgn = ftc_ass(sel_whe("COUNT(*) as total","cat_rgn",$whr."1","1"));
  echo $nb_rgn['total'].' '.$txt->rgn->$id_lng;
?>
  </td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png" /></td>
<?php
  break;
case 'vll':
  include("../cfg/rgn.php");
  if(isset($_POST['id_rgn'])) {$id_rgn = $_POST['id_rgn'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
  <td class='tbl'>
		<input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('vll','vll',this.value);" /><br />
<?php
	if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
  if(!$id_rgn) {$nb_vll = ftc_ass(sel_whe("COUNT(*) as total","cat_vll",$whr."1","1"));}
  else{$nb_vll = ftc_ass(sel_quo("COUNT(*) as total","cat_vll",$whr."id_rgn",$id_rgn));}
  echo $nb_vll['total'].' '.$txt->vll->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_rgn')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="rgn" value="<?php echo $id_rgn ?>" />
<?php
  if(!$id_rgn) {echo $txt->rgn->$id_lng;}
  else{echo $rgn[$id_rgn];}
?>
      </div>
    </div>
    <div id="sel_rgn" class="cmd mw200">
      <input type="text" id="ipt_sel_rgn" onkeyup="auto_lst('<?php echo $cbl ?>','rgn',this.value,event);" />
      <div id="lst_rgn"><?php include("vue_lst_rgn.php") ?></div>
    </div>
  </td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png" /></td>
<?php
  break;
case 'lieu':
  include("../cfg/vll.php");
  if(isset($_POST['id_vll'])) {$id_vll = $_POST['id_vll'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
	<td class='tbl'><input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('lieu','lieu',this.value);" /></td>
  <td class='tbl'>
<?php
	if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
  if(!$id_vll) {$nb_lieu = ftc_ass(sel_whe("COUNT(*) as total","cat_lieu",$whr."1","1"));}
  else{$nb_lieu = ftc_ass(sel_quo("COUNT(*) as total","cat_lieu",$whr."id_vll",$id_vll));}
  echo $nb_lieu['total'].' '.$txt->lieu->$id_lng;
?>
  </td>
  <td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_vll')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="vll" value="<?php echo $id_vll ?>" />
<?php
  if(!$id_vll) {echo $txt->vll->$id_lng;}
  else{echo $vll[$id_vll];}
?>
      </div>
    </div>
    <div id="sel_vll" class="cmd mw200">
      <input type="text" id="ipt_sel_vll" onkeyup="auto_lst('<?php echo $cbl ?>','vll',this.value,event);" />
      <div id="lst_vll"><?php include("vue_lst_vll.php") ?></div>
    </div>
  </td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png" /></td>
<?php
  break;
case 'bnq':
	include("../prm/lgg.php");
	include("../prm/pays.php");
  if(isset($_POST['id_pays'])) {$id_pays = $_POST['id_pays'];}
	if(isset($_POST['flt'])) {$flt = $_POST['flt'];}
?>
	<td class='tbl'>
		<input type="text" id="flt" value="<?php echo $flt ?>" class="flt" onkeyup="if(this.value=='<?php echo $flt ?>') {this.style.backgroundColor = 'rgb(255,255,255)';} else{this.style.backgroundColor = 'rgb(255,255,102)';}" onchange="this.style.backgroundColor = 'rgb(255,255,255)';vue_cat('bnq','bnq',this.value);" /><br />
<?php
	if($flt) {$whr = "nom LIKE '%".$flt."%' AND ";}
	if(!$id_pays) {$nb_bnq = ftc_ass(sel_whe("COUNT(*) as total","cat_bnq",$whr."1","1"));}
	else{$nb_bnq = ftc_ass(sel_quo("COUNT(*) as total","cat_bnq",$whr."id_pays",$id_pays));}
  echo $nb_bnq['total'].' '.$txt->bnq->$id_lng;
?>
  </td>
	<td class='tbl'>
    <div class="sel" onclick="vue_cmd('sel_pays')">
      <img src="../prm/img/sel.png" />
      <div>
        <input type="hidden" id="pays" value="<?php echo $id_pays ?>" />
<?php
  if(!$id_pays) {echo $txt->pays->$id_lng;}
  else{echo $pays[$id_lng][$id_pays];}
?>
      </div>
    </div>
    <div id="sel_pays" class="cmd mw200">
      <input type="text" id="ipt_sel_pays" onkeyup="auto_lst('<?php echo $cbl ?>','pays',this.value,event);" />
      <div id="lst_pays"><?php include("vue_lst_pays.php") ?></div>
    </div>
  </td>
  <td class="text-center" id="addElem"><img src="../prm/img/ajt.png" /></td>
<?php
  break;
}
?>
	</tr>
<?php
include("vue_dt_cat.php");
?>
</table>
